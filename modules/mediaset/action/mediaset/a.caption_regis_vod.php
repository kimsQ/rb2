<?php
if(!defined('__KIMS__')) exit;

if (!$uid) getLink('','',_LANG('a0002','mediaset'),'');
$R = getUidData($table['s_upload'],$uid);
if (!$R['uid']) getLink('','',_LANG('a0003','mediaset'),'');
if (!$my['admin'] && $my['uid'] != $R['mbruid']) getLink('','',_LANG('a0004','mediaset'),'');

$name = strip_tags(trim($name));
$alt = strip_tags(trim($alt));
$linkurl = trim($linkurl);
$caption = $my['admin'] ? trim($caption) : strip_tags(trim($caption));
$description = $my['admin'] ? trim($description) : strip_tags(trim($description));
if ($R['type']<0) $src = trim($src);
else $src = $R['src'];

getDbUpdate($table['s_upload'],"name='".$name."',alt='".$alt."',caption='".$caption."',description='".$description."',src='".$src."',license='".$license."',d_update='".$date['totime']."',linkurl='".$linkurl."'",'uid='.$R['uid']);

getLink('reload','parent.',_LANG('a0005','mediaset'),'');
?>