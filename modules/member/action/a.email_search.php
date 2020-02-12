<?php
if(!defined('__KIMS__')) exit;

$name		= trim($name);
$id		= trim($id);

if (!$name || !$id) getLink('','','정상적인 접근이 아닙니다.','');

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

$M = getDbData($table['s_mbrdata'],"name='".$name."'",'*');
if (!$M['name'])
{
	getLink('','','입력하신 정보로 일치하는 회원데이터가 없습니다.','');
}
$R = getUidData($table['s_mbrid'],$M['memberuid']);

if ($R['id'] != $id)
{
	getLink('','','입력하신 정보로 일치하는 회원데이터가 없습니다.','');
}

echo '<script type="text/javascript">';
echo 'parent.$("#findEmail").modal("hide");';
echo 'parent.$("#email_field").val("'.$M['email'].'");';
echo 'parent.alertLayer("#notice","success","회원님의 이메일은 ['.$M['email'].']입니다.","","","");';
echo '</script>';

exit();
?>
