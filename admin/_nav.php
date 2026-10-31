<?php $adminPage=basename($_SERVER['PHP_SELF']??'');$activeType=$_GET['type']??''; ?>
<aside class="sidebar">
<a class="admin-brand" href="<?=e(url('admin/index.php'))?>"><i>L</i><b>LipaHub</b></a>
<small>WORKSPACE</small>
<a class="<?=$adminPage==='index.php'?'active':''?>" href="<?=e(url('admin/index.php'))?>">▦ Dashboard</a>
<a class="<?=$adminPage==='settings.php'?'active':''?>" href="<?=e(url('admin/settings.php'))?>">◈ Site settings</a>
<a class="<?=$adminPage==='sections.php'?'active':''?>" href="<?=e(url('admin/sections.php'))?>">▤ Homepage builder</a>
<a class="<?=$adminPage==='footer.php'?'active':''?>" href="<?=e(url('admin/footer.php'))?>">▤ Footer editor</a>
<small>CONTENT</small>
<?php foreach(['page'=>'Pages','article'=>'Articles','country'=>'Country guides','review'=>'Reviews','faq'=>'FAQs'] as $k=>$v):?>
<a class="<?=$adminPage==='content.php'&&$activeType===$k?'active':''?>" href="<?=e(url('admin/content.php?type='.$k))?>">▤ <?=e($v)?></a>
<?php endforeach;?>
<div class="side-bottom"><a href="<?=e(url('index.php'))?>" target="_blank" rel="noopener">↗ View website</a><a href="<?=e(url('admin/logout.php'))?>">⇥ Sign out</a></div>
</aside>