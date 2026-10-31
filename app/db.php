<?php
function db():PDO{static $p=null;if($p)return $p;$c=$GLOBALS['config']['db'];$dsn="mysql:host={$c['host']};port=".($c['port']??3306).";dbname={$c['name']};charset=".($c['charset']??'utf8mb4');return $p=new PDO($dsn,$c['user'],$c['pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}
