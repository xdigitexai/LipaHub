<?php
function admin_user():?array{return $_SESSION['admin']??null;}
function require_admin():void{if(!admin_user())redirect(url('admin/login.php'));}
function login_admin(string $email,string $pw):bool{$q=db()->prepare('SELECT id,name,email,password_hash FROM admins WHERE email=?');$q->execute([strtolower(trim($email))]);$u=$q->fetch();if(!$u||!password_verify($pw,$u['password_hash']))return false;session_regenerate_id(true);unset($u['password_hash']);$_SESSION['admin']=$u;return true;}
