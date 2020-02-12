<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) exit;
$_mdfile = $g['dir_module'].'modal/'.$mdfile.'.php';
if (!is_file($_mdfile)) exit;

$g['main'] = $_mdfile;
?>
