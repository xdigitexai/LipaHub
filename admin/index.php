<?php
require __DIR__.'/_init.php';
$count=function(string $sql):int{return (int)db()->query($sql)->fetchColumn();};
$stats=[
 'Articles'=>$count("SELECT COUNT(*) FROM content WHERE type='article'"),
 'Published articles'=>$count("SELECT COUNT(*) FROM content WHERE type='article' AND status='published'"),
 'Draft articles'=>$count("SELECT COUNT(*) FROM content WHERE type='article' AND status='draft'"),
 'Pages'=>$count("SELECT COUNT(*) FROM content WHERE type='page'"),
 'Homepage sections'=>$count("SELECT COUNT(*) FROM sections"),
 'Testimonials'=>$count("SELECT COUNT(*) FROM content WHERE type='review'")
];
$recent=db()->query('SELECT title,type,status,updated_at FROM content ORDER BY updated_at DESC LIMIT 8')->fetchAll();
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>LipaHub dashboard</title><link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="<?=e(url('assets/css/admin.css'))?>"><link rel="icon" type="image/svg+xml" href="<?=e(url('favicon.svg'))?>"></head><body><div class="shell"><?php require __DIR__.'/_nav.php';?><main>
<div class="top"><div><small>WORKSPACE OVERVIEW</small><h1>Welcome back, <?=e(admin_user()['name'])?>.</h1></div><a href="<?=e(url('index.php'))?>" target="_blank" rel="noopener">View website ↗</a></div>
<div class="stats"><?php foreach($stats as $label=>$value):?><div><small><?=e($label)?></small><b><?=number_format($value)?></b><small>Live database count</small></div><?php endforeach;?></div>
<section class="panel"><h2>Website control centre</h2><p>Manage your public website, editorial content and homepage without editing code.</p><div class="quick">
<a href="<?=e(url('admin/earning.php'))?>"><b>Ways to Earn</b><small>Manage the eight illustrated earning categories, images and links.</small></a>
<a href="<?=e(url('admin/sections.php'))?>"><b>Homepage builder</b><small>Arrange, edit, show or hide homepage sections.</small></a>
<a href="<?=e(url('admin/content.php?type=article'))?>"><b>Articles & guides</b><small>Create, edit, publish and organize editorial content.</small></a>
<a href="<?=e(url('admin/content.php?type=country'))?>"><b>Country guides</b><small>Maintain useful country-specific information.</small></a>
<a href="<?=e(url('admin/settings.php'))?>"><b>Site settings</b><small>Update brand, navigation, SEO and registration destination.</small></a>
<a href="<?=e(url('admin/footer.php'))?>"><b>Footer editor</b><small>Manage footer copy, navigation and contact details.</small></a>
<a href="<?=e(url('admin/content.php?type=review'))?>"><b>Reviews & testimonials</b><small>Manage community feedback shown on the website.</small></a>
</div></section>
<section class="panel"><h2>Recently updated content</h2><p>The latest changes across your CMS.</p><?php if($recent):?><div class="table-wrap"><table><thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Last updated</th><th></th></tr></thead><tbody><?php foreach($recent as $r):?><tr><td><?=e($r['title'])?></td><td><?=e(ucfirst($r['type']))?></td><td><span class="status <?=e($r['status'])?>"><?=e(ucfirst($r['status']))?></span></td><td><?=e(date('M j, Y',strtotime($r['updated_at'])))?></td><td><a href="<?=e(url('admin/content.php?type='.$r['type']))?>">Manage →</a></td></tr><?php endforeach;?></tbody></table></div><?php else:?><div class="empty-state">No content has been added yet.</div><?php endif;?></section>
</main></div></body></html>