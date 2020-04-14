<?php
declare(strict_types = 1);

error_reporting(E_ALL);

$option = ['host'=>'localhost'];
//$host = isset($option['host']) ?: '';
$host ??= isset($option['host']);
$user ??= isset($option['user']);
var_dump($host, $user);
