<?php $adminPage=basename($_SERVER['PHP_SELF']??'');$activeType=$_GET['type']??''; ?>
<button class="sidebar-toggle" type="button" aria-label="Open admin menu" aria-controls="admin-sidebar" aria-expanded="false">☰</button><div class="sidebar-backdrop" hidden></div>
<aside class="sidebar" id="admin-sidebar">
<a class="admin-brand" href="<?=e(url('admin/index.php'))?>"><img src="<?=e(url('assets/images/lipahub-mark.svg'))?>" alt="" width="38" height="38"><b>LipaHub</b></a>
<small>WORKSPACE</small>
<a class="<?=$adminPage==='index.php'?'active':''?>" href="<?=e(url('admin/index.php'))?>">▦ Dashboard</a>
<a class="<?=$adminPage==='settings.php'?'active':''?>" href="<?=e(url('admin/settings.php'))?>">◈ Site settings</a>
<a class="<?=$adminPage==='sections.php'?'active':''?>" href="<?=e(url('admin/sections.php'))?>">▤ Homepage builder</a>
<a class="<?=$adminPage==='footer.php'?'active':''?>" href="<?=e(url('admin/footer.php'))?>">▤ Footer editor</a>
<small>PLATFORM</small>
<a class="<?=($adminPage==='earning.php'?'active':'')?>" href="<?=e(url('admin/earning.php'))?>">✦ Ways to Earn</a>
<small>CONTENT</small>
<?php foreach(['page'=>'Pages','article'=>'Articles','country'=>'Country guides','review'=>'Reviews','faq'=>'FAQs'] as $k=>$v):?>
<a class="<?=$adminPage==='content.php'&&$activeType===$k?'active':''?>" href="<?=e(url('admin/content.php?type='.$k))?>">▤ <?=e($v)?></a>
<?php endforeach;?>
<div class="side-bottom"><a href="<?=e(url('index.php'))?>" target="_blank" rel="noopener">↗ View website</a><a href="<?=e(url('admin/logout.php'))?>">⇥ Sign out</a></div>
</aside>
<script>document.addEventListener("DOMContentLoaded",()=>{const side=document.getElementById("admin-sidebar"),toggle=document.querySelector(".sidebar-toggle"),backdrop=document.querySelector(".sidebar-backdrop");if(!side||!toggle||!backdrop)return;const close=()=>{side.classList.remove("open");backdrop.hidden=true;toggle.setAttribute("aria-expanded","false");toggle.setAttribute("aria-label","Open admin menu");toggle.textContent="☰";};toggle.addEventListener("click",()=>{const open=!side.classList.contains("open");side.classList.toggle("open",open);backdrop.hidden=!open;toggle.setAttribute("aria-expanded",String(open));toggle.setAttribute("aria-label",open?"Close admin menu":"Open admin menu");toggle.textContent=open?"×":"☰";});backdrop.addEventListener("click",close);document.addEventListener("keydown",e=>{if(e.key==="Escape")close();});side.addEventListener("click",e=>{if(e.target.closest("a"))close();});window.addEventListener("resize",()=>{if(window.innerWidth>760)close();});});</script>