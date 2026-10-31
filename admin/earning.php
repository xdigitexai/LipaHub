<?php
require __DIR__.'/_init.php';
$defaults=[
 ['Watch Videos','Explore available TikTok and YouTube video activities.','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=900&q=85&fit=crop',''],
 ['Click Ads','Discover advertising and promotional engagement tasks.','https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&q=85&fit=crop',''],
 ['Write Blogs','Create written content through available blogging activities.','https://images.unsplash.com/photo-1455390582262-044c...',''],
 ['Answer Surveys','Share your opinions through available online surveys.','https://images.unsplash.com/photo-1553877522-43269d4ea984?w=900&q=85&fit=crop',''],
 ['Play Games','Take part in eligible game-based activities.','https://images.unsplash.com/photo-1511512578047-dfb367046420?w=900&q=85&fit=crop',''],
 ['Spin to Win','Explore spin activities and check their rules before joining.','https://images.unsplash.com/photo-1606167668584-78701c57f13d?w=900&q=85&fit=crop',''],
 ['Learn Forex','Access Forex learning resources and educational activities.','https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=900&q=85&fit=crop',''],
 ['Refer Friends','Invite friends using the platform’s referral programme.','https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=900&q=85&fit=crop','']
];
$q=db()->prepare("SELECT * FROM sections WHERE type='earning_grid' ORDER BY id LIMIT 1");$q->execute();$section=$q->fetch();
if(!$section){$body="Choose an activity to explore. Availability, eligibility and rewards may vary.\n";foreach($defaults as $d)$body.=implode('|',$d)."\n";db()->prepare("INSERT INTO sections(type,title,eyebrow,body,theme,item_limit,sort_order,enabled) VALUES('earning_grid','Explore ways to earn','WAYS TO EARN',?,'soft',8,35,1)")->execute([$body]);$q->execute();$section=$q->fetch();}
$intro='Choose an activity to explore. Availability, eligibility and rewards may vary.';
$cards=$defaults;
$lines=explode("\n",(string)$section['body']);
if(isset($lines[0])&&trim($lines[0])!=='')$intro=trim($lines[0]);
foreach(array_slice($lines,1) as $i=>$line){if($i>=8)break;$p=explode('|',$line,4);if(isset($cards[$i]))$cards[$i]=[trim($p[0]??''),trim($p[1]??''),trim($p[2]??''),trim($p[3]??'')];}
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();$intro=trim($_POST['intro']??$intro);$title=trim($_POST['title']??'Explore ways to earn');$eyebrow=trim($_POST['eyebrow']??'WAYS TO EARN');$body=$intro."\n";
 for($i=0;$i<8;$i++){$t=trim($_POST['card_title'][$i]??'');$d=trim($_POST['card_description'][$i]??'');$img=trim($_POST['card_image'][$i]??'');$link=trim($_POST['card_url'][$i]??'');if($t==='')continue;if($img!==''&&!preg_match('#^https?://#i',$img)&&!str_starts_with($img,'/')){$img='';}if($link!==''&&!preg_match('#^(https?://|/|#)#i',$link))$link='';$body.=str_replace(["\r","\n","|"],[' ',' ','/'],$t).'|'.str_replace(["\r","\n","|"],[' ',' ','/'],$d).'|'.$img.'|'.$link."\n";}
 db()->prepare("UPDATE sections SET title=?,eyebrow=?,body=?,theme='soft',item_limit=8,sort_order=35,enabled=? WHERE id=?")->execute([$title,$eyebrow,$body,isset($_POST['enabled'])?1:0,$section['id']]);
 flash('Ways to Earn section saved.');redirect(url('admin/earning.php'));
}
$msg=$_SESSION['_flash']??'';unset($_SESSION['_flash']);
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Ways to Earn</title><link rel="stylesheet" href="<?=e(url('assets/css/admin.css'))?>"></head><body><div class="shell"><?php require __DIR__.'/_nav.php';?><main><div class="top"><div><small>PLATFORM CONTENT</small><h1>Ways to Earn</h1></div><a href="<?=e(url('index.php#ways-to-earn'))?>" target="_blank" rel="noopener">Preview section ↗</a></div>
<?php if($msg):?><div class="notice"><?=e($msg)?></div><?php endif;?>
<p class="intro">Manage the eight illustrated earning categories shown on the public homepage. Add a card image, description and destination. Use your real activity links when they are ready; blank destinations use the existing registration link.</p>
<form method="post" class="panel editor"><?=csrf_field()?>
<div class="two"><label>Section heading<input name="title" value="<?=e($section['title'])?>" required></label><label>Small label<input name="eyebrow" value="<?=e($section['eyebrow'])?>"></label></div>
<label>Introductory text<textarea name="intro" rows="2"><?=e($intro)?></textarea></label>
<?php foreach($cards as $i=>$card):?><div class="earning-admin-row">
<label>Card title<input name="card_title[]" value="<?=e($card[0])?>" required></label>
<label>Description<input name="card_description[]" value="<?=e($card[1])?>"></label>
<label>Image URL<input class="earning-image-url" name="card_image[]" value="<?=e($card[2])?>" placeholder="https://..."></label>
<label>Destination URL<input name="card_url[]" value="<?=e($card[3])?>" placeholder="Leave blank to use registration link"></label>
<div class="image-upload"><input type="file" class="earning-file" accept="image/jpeg,image/png,image/webp,image/gif"><button type="button" class="secondary earning-upload">Upload image</button><span class="upload-status"></span></div>
</div><?php endforeach;?>
<label class="check-label"><input type="checkbox" name="enabled" value="1" <?=$section['enabled']?'checked':''?>> Show Ways to Earn section on the homepage</label>
<button class="primary">Save Ways to Earn</button>
</form></main></div>
<script>
document.querySelectorAll('.earning-admin-row').forEach(row=>{const btn=row.querySelector('.earning-upload');btn.addEventListener('click',async()=>{const file=row.querySelector('.earning-file').files[0],status=row.querySelector('.upload-status');if(!file){status.textContent='Choose an image first';return;}const data=new FormData();data.append('image',file);data.append('_csrf',<?=json_encode(csrf_token())?>);status.textContent='Uploading…';try{const response=await fetch(<?=json_encode(url('admin/upload.php'))?>,{method:'POST',body:data}),json=await response.json();if(!response.ok)throw Error(json.error||'Upload failed');row.querySelector('.earning-image-url').value=json.url;status.textContent='Uploaded';}catch(error){status.textContent=error.message;}});});
</script></body></html>