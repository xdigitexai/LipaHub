<?php
function e(?string $s):string{return htmlspecialchars((string)$s,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function setting(string $k,string $d=''):string{static $c=[];if(isset($c[$k]))return $c[$k];try{$q=db()->prepare('SELECT setting_value FROM settings WHERE setting_key=?');$q->execute([$k]);$v=$q->fetchColumn();}catch(Throwable $t){$v=false;}return $c[$k]=$v===false?$d:(string)$v;}
function set_setting(string $k,string $v):void{db()->prepare('INSERT INTO settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)')->execute([$k,$v]);}
function url(string $p=''):string{return rtrim($GLOBALS['config']['app']['base_url']??'','/').'/'.ltrim($p,'/');}
function registration_url():string{return setting('registration_url',$GLOBALS['config']['app']['registration_url']??'https://lipahub.com/register.php?ref=ItsVee');}
function csrf_token():string{if(empty($_SESSION['_csrf']))$_SESSION['_csrf']=bin2hex(random_bytes(32));return $_SESSION['_csrf'];}
function csrf_field():string{return '<input type="hidden" name="_csrf" value="'.e(csrf_token()).'">';}
function verify_csrf():void{if(!hash_equals($_SESSION['_csrf']??'',$_POST['_csrf']??'')){http_response_code(419);exit('Invalid security token.');}}
function redirect(string $p):never{header('Location: '.$p);exit;}
function flash(string $m):void{$_SESSION['_flash']=$m;}
