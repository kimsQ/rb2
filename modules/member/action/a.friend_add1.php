<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

$xid = trim($id);
if (!$xid) exit;

if($xid == $my['id']) getLink('','','자신은 친구맺기를 할 수 없습니다.','');

if ($d['member']['login_emailid'])
{
	$M = getDbData($table['s_mbrdata'],"email='".$xid."'",'*');
	if (!$M['memberuid']) getLink('','','없는 회원입니다.','');
	$M1 = getUidData($table['s_mbrid'],$M['memberuid']);
	if (!$M1['uid']) getLink('','','없는 회원입니다.','');
}
else {
	$M1 = getDbData($table['s_mbrid'],"id='".$xid."'",'*');
	if (!$M1['uid']) getLink('','','없는 회원입니다.','');
	$M = getDbData($table['s_mbrdata'],'memberuid='.$M1['uid'],'*');
	if (!$M['memberuid']) getLink('','','없는 회원입니다.','');
}

$R = getDbData($table['s_friend'],'by_mbruid='.$M['memberuid'],'*');

if (!$R['uid'])
{
	$R2 = getDbData($table['s_friend'],'my_mbruid='.$M['memberuid'].' and by_mbruid='.$my['uid'],'*');
	if ($R2['uid'])
	{
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'1','".$my['uid']."','".$M['memberuid']."','','".$date['totime']."'");
		getDbUpdate($table['s_friend'],'rel=1','uid='.$R2['uid']);
		getLink('','','맞팔 친구가 되셨습니다.','');
	}
	else {
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'0','".$my['uid']."','".$M['memberuid']."','','".$date['totime']."'");
		getLink('','','친구맺기 요청을 전달했습니다.','');
	}
}

getLink('','','이미 친구맺기 요청을 한 상태입니다.','');
?>
