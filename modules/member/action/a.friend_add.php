<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

$id = trim($friend);
$idexp = explode(',',$id);
$idlen = count($idexp);

for ($i = 0; $i < $idlen; $i++)
{
	$xid = trim($idexp[$i]);
	if (!$xid) continue;

	if($xid == $my['id']) continue;

	if ($d['member']['login_emailid'])
	{
		$M = getDbData($table['s_mbrdata'],"email='".$xid."'",'*');
		if (!$M['memberuid']) continue;
		$M1 = getUidData($table['s_mbrid'],$M['memberuid']);
		if (!$M1['uid']) continue;

	}
	else {
		$M1 = getDbData($table['s_mbrid'],"id='".$xid."'",'*');
		if (!$M1['uid']) continue;
		$M = getDbData($table['s_mbrdata'],'memberuid='.$M1['uid'],'*');
		if (!$M['memberuid']) continue;
	}

	$R = getDbData($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$M['memberuid'],'*');

	if (!$R['uid'])
	{
		$R2 = getDbData($table['s_friend'],'my_mbruid='.$M['memberuid'].' and by_mbruid='.$my['uid'],'*');
		if ($R2['uid'])
		{
			getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'1','".$my['uid']."','".$M['memberuid']."','','".$date['totime']."'");
			getDbUpdate($table['s_friend'],'rel=1','uid='.$R2['uid']);
		}
		else {
			getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'0','".$my['uid']."','".$M['memberuid']."','','".$date['totime']."'");
		}
	}
}

getLink('reload','parent.','','');
?>
