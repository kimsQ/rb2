<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if (!is_array($members)) $members = $fuid ? array($fuid) : array();

foreach($members as $val)
{
	$R = getUidData($table['s_friend'],$val);
	if ($R['uid'] && !$R['rel'])
	{
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'1','".$my['uid']."','".$R['my_mbruid']."','','".$date['totime']."'");
		getDbUpdate($table['s_friend'],'rel=1','uid='.$R['uid']);
	}
}

if ($mbruid)
{
	if (!$fuid)
	{
		$M = getUidData($table['s_mbrid'],$mbruid);
		if (!$M['uid']) getLink('','','존재하지 않는 회원입니다.','');
		getDbInsert($table['s_friend'],'rel,my_mbruid,by_mbruid,category,d_regis',"'0','".$my['uid']."','".$M['uid']."','','".$date['totime']."'");
	}
	echo '<script type="text/javascript">';
	// echo 'parent.getMemberLayerLoad('.$mbruid.');';
	echo '</script>';
	getLink('','','','');
}
else {
	getLink('reload','parent.','','');
}
?>
