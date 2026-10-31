<?php
require dirname(__DIR__).'/app/bootstrap.php';
require dirname(__DIR__).'/app/sections.php';

$slug=trim($_GET['page']??'','/');
$home=$slug==='';
$opportunity=$slug==='opportunity'?earning_opportunity(trim($_GET['task']??'')):null;
$isOpportunity=$slug==='opportunity'&&$opportunity!==null;
$page=null;
$isArticle=false;
if(!$home&&$slug!=='articles'&&$slug!=='opportunity'){
    $q=db()->prepare("SELECT * FROM content WHERE slug=? AND status='published' LIMIT 1");
    $q->execute([$slug]);
    $page=$q->fetch()?:null;
    $isArticle=$page&&$page['type']==='article';
    if(!$page)http_response_code(404);
}
if($slug==='opportunity'&&!$opportunity)http_response_code(404);
$articles=db()->query("SELECT * FROM content WHERE type='article' AND status='published' ORDER BY created_at DESC LIMIT 30")->fetchAll();
$countries=db()->query("SELECT * FROM content WHERE type='country' AND status='published' ORDER BY sort_order")->fetchAll();
$reviews=db()->query("SELECT * FROM content WHERE type='review' AND status='published' ORDER BY sort_order LIMIT 6")->fetchAll();
$site=setting('site_name','LipaHub');
$cta=setting('cta_label','Get started');
$articleListing=$slug==='articles';
$description=$isOpportunity?$opportunity['description']:($page?($page['excerpt']??''):setting('meta_description'));
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=e($page['title']??($articleListing?'Guides & articles — '.$site:$site.' — '.setting('tagline')))?></title>
<meta name="description" content="<?=e($description)?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="icon" type="image/svg+xml" href="<?=e(url('favicon.svg'))?>">
<link rel="apple-touch-icon" href="<?=e(url('assets/images/lipahub-mark.svg'))?>">
<link rel="stylesheet" href="<?=e(url('assets/css/site.css'))?>">
<link rel="stylesheet" href="<?=e(url('assets/css/sections.css'))?>">
</head>
<body>
<?php if(setting('announcement')):?><div class="announcement"><?=e(setting('announcement'))?></div><?php endif;?>
<header>
 <div class="container nav">
  <a class="brand" href="<?=e(url('index.php'))?>"><img src="<?=e(url('assets/images/lipahub-mark.svg'))?>" alt="" width="40" height="40"><span><?=e($site)?><small><?=e(setting('brand_descriptor','OPPORTUNITIES, CONNECTED'))?></small></span></a>
  <nav id="primary-navigation" aria-label="Main navigation">
   <a href="<?=e(url('index.php'))?>"><?=e(setting('nav_home','Home'))?></a>
   <a href="<?=e(url('index.php?page=how-it-works'))?>"><?=e(setting('nav_how','How it works'))?></a>
   <a href="<?=e(url('index.php#ways-to-earn'))?>">Ways to Earn</a>
   <a href="<?=e(url('index.php?page=about'))?>"><?=e(setting('nav_about','About'))?></a>
   <a href="<?=e(url('index.php?page=faq'))?>"><?=e(setting('nav_faq','FAQ'))?></a>
   <a href="<?=e(url('index.php?page=articles'))?>"><?=e(setting('nav_guides','Guides'))?></a>
  </nav>
  <a class="btn small" href="<?=e(registration_url())?>"><?=e($cta)?> ↗</a>
  <button class="menu-toggle" type="button" aria-label="Open navigation menu" aria-controls="primary-navigation" aria-expanded="false">☰</button>
 </div>
</header>
<?php if($home):?>
<main><?php render_home_sections();?></main>
<?php elseif($isOpportunity):?>
<main class="opportunity-detail-page">
 <section class="page-hero opportunity-hero"><div class="container"><a class="article-back" href="<?=e(url('index.php#ways-to-earn'))?>">← Back to ways to earn</a><div class="eyebrow">LIPAHUB / ONLINE OPPORTUNITY</div><h1><?=e($opportunity['title'])?></h1><p><?=e($opportunity['description'])?></p></div></section>
 <section class="section soft"><div class="container opportunity-detail-grid">
  <article class="opportunity-detail-copy"><?php if($opportunity['image']):?><img class="opportunity-detail-image" src="<?=e($opportunity['image'])?>" alt="<?=e($opportunity['title'])?>"><?php endif;?><div class="eyebrow">ABOUT THIS OPPORTUNITY</div><h2>Explore <?=e($opportunity['title'])?></h2><div class="opportunity-long-description"><?=nl2br(e($opportunity['detail']))?></div><p class="opportunity-note">Task availability, eligibility, instructions and any rewards are confirmed in the member area. Review the details before starting an activity.</p><a class="btn" href="<?=e(registration_url())?>">Explore opportunity &amp; sign up ↗</a></article>
  <aside class="opportunity-signup"><div class="eyebrow">GET STARTED</div><h2>Ready to explore?</h2><p>Create your LipaHub account to see which activities are currently available to you.</p><a class="btn" href="<?=e(registration_url())?>"><?=e($cta)?> ↗</a><small>No task or reward is guaranteed. Check the terms for each activity.</small></aside>
 </div></section>
</main>
<?php elseif($articleListing):?>
<main>
 <section class="page-hero"><div class="container"><div class="eyebrow">LIPAHUB / RESOURCES</div><h1>Guides & articles.</h1><p>Practical information, clear explanations and helpful resources to support informed decisions as you explore LipaHub.</p></div></section>
 <section class="section soft"><div class="container">
  <?php if($articles):?><div class="article-listing">
   <?php foreach($articles as $a):?>
    <article class="article-card"><a href="<?=e(url('index.php?page='.$a['slug']))?>">
     <div class="cover"><?php if($a['image']):?><img src="<?=e($a['image'])?>" alt="<?=e($a['title'])?>" loading="lazy"><?php else:?><b>LH</b><?php endif;?></div>
     <div class="article-card-copy"><div class="article-meta"><span>LIPAHUB GUIDE</span><span><?=e(date('M j, Y',strtotime($a['created_at'])))?></span></div><h2><?=e($a['title'])?></h2><p><?=e($a['excerpt']??'Explore this practical LipaHub resource.')?></p><span class="read-more">Read article <span aria-hidden="true">→</span></span></div>
    </a></article>
   <?php endforeach;?>
  </div><?php else:?><div class="empty-state"><h2>New guides are on the way.</h2><p>We are preparing useful resources for this section. Please check back soon.</p></div><?php endif;?>
 </div></section>
</main>
<?php elseif($page):?>
<main>
 <section class="page-hero"><div class="container">
  <?php if($isArticle):?><a class="article-back" href="<?=e(url('index.php?page=articles'))?>">← Back to guides</a><?php else:?><a class="article-back" href="<?=e(url('index.php'))?>">← Back to home</a><?php endif;?>
  <div class="eyebrow">LIPAHUB / <?=e($isArticle?'ARTICLE':strtoupper($page['type']))?></div>
  <h1><?=e($page['title'])?></h1>
  <?php if($page['excerpt']):?><p><?=e($page['excerpt'])?></p><?php endif;?>
  <?php if($isArticle):?><div class="article-meta"><span>LipaHub Editorial</span><span><?=e(date('F j, Y',strtotime($page['created_at'])))?></span></div><?php endif;?>
 </div></section>
 <section class="section soft"><div class="container">
  <article class="article-body">
   <?php if($page['image']):?><img src="<?=e($page['image'])?>" alt="<?=e($page['title'])?>" loading="eager"><?php endif;?>
   <?=$page['body']?>
  </article>
  <div class="container inline-cta"><h2><?=e(setting('page_cta_title','Want to explore LipaHub?'))?></h2><a class="btn" href="<?=e(registration_url())?>"><?=e($cta)?> ↗</a></div>
 </div></section>
 <?php if($isArticle):$related=array_values(array_filter($articles,fn($a)=>(int)$a['id']!==(int)$page['id']));$related=array_slice($related,0,3);if($related):?>
 <section class="section"><div class="container"><div class="section-head"><div class="eyebrow">KEEP EXPLORING</div><h2>More guides for you.</h2></div><div class="article-listing">
 <?php foreach($related as $a):?><article class="article-card"><a href="<?=e(url('index.php?page='.$a['slug']))?>"><div class="cover"><?php if($a['image']):?><img src="<?=e($a['image'])?>" alt="<?=e($a['title'])?>" loading="lazy"><?php else:?><b>LH</b><?php endif;?></div><div class="article-card-copy"><div class="meta">LIPAHUB GUIDE</div><h2><?=e($a['title'])?></h2><p><?=e($a['excerpt']??'')?></p><span class="read-more">Read article →</span></div></a></article><?php endforeach;?>
 </div></div></section><?php endif;endif;?>
</main>
<?php else:?>
<main><section class="page-hero"><div class="container"><div class="eyebrow">LIPAHUB / PAGE NOT FOUND</div><h1>We couldn’t find that page.</h1><p>The page may have moved, or the link may be incorrect.</p><a class="btn" href="<?=e(url('index.php'))?>">Back to homepage</a></div></section></main>
<?php endif;?>
<footer><div class="container footer-grid">
 <div><a class="brand footer-brand" href="<?=e(url('index.php'))?>"><img src="<?=e(url('assets/images/lipahub-mark.svg'))?>" alt="" width="40" height="40"><span><?=e($site)?><small><?=e(setting('brand_descriptor','OPPORTUNITIES, CONNECTED'))?></small></span></a><p><?=e(setting('footer_text'))?></p></div>
 <div><b><?=e(setting('footer_explore_title','Explore'))?></b><?php foreach([1,2,3] as $i):$label=setting('footer_link'.$i.'_label',['How it works','About us','Guides & articles'][$i-1]);$href=setting('footer_link'.$i.'_url',[url('index.php?page=how-it-works'),url('index.php?page=about'),url('index.php?page=articles')][$i-1]);?><a href="<?=e($href)?>"><?=e($label)?></a><?php endforeach;?></div>
 <div><b><?=e(setting('footer_join_title','Get started'))?></b><a href="<?=e(registration_url())?>"><?=e(setting('footer_join_label','Create an account ↗'))?></a><a href="<?=e(url('index.php?page=faq'))?>"><?=e(setting('footer_faq_label','FAQs'))?></a><a href="mailto:<?=e(setting('contact_email'))?>">Contact</a></div>
 </div><div class="container copyright"><?=e(setting('copyright_text','© '.date('Y').' '.$site.'. All rights reserved.'))?><span><?=e(setting('legal_note','Results and availability are not guaranteed.'))?></span></div>
</footer>
<script src="<?=e(url('assets/js/site.js'))?>"></script>
</body></html>