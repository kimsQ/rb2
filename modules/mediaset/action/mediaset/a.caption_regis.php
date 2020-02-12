<?php
if(!defined('__KIMS__')) exit;

if (!$uid) getLink('','',_LANG('a0002','mediaset'),'');
$R = getUidData($table['s_upload'],$uid);
if (!$R['uid']) getLink('','',_LANG('a0003','mediaset'),'');
if (!$my['admin'] && $my['uid'] != $R['mbruid']) getLink('','',_LANG('a0004','mediaset'),'');

$name = trim($name);
$name = str_replace('.'.$R['ext'],'',$name).'.'.$R['ext'];
$name = strip_tags($name);
$alt = strip_tags(trim($alt));
$linkurl = trim($linkurl);
$caption = $my['admin'] ? trim($caption) : strip_tags(trim($caption));
$description = $my['admin'] ? trim($description) : strip_tags(trim($description));
if ($R['type']<0) $src = trim($src);
else $src = $R['src'];

getDbUpdate($table['s_upload'],"hidden='".$hidden."',name='".$name."',alt='".$alt."',caption='".$caption."',description='".$description."',src='".$src."',linkto='".$linkto."',license='".$license."',d_update='".$date['totime']."',linkurl='".$linkurl."'",'uid='.$R['uid']);
setrawcookie('mediaset_result', rawurlencode('저장 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
