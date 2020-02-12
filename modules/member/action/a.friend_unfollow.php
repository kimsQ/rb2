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
	if ($R['uid'])
	{
		getDbDelete($table['s_friend'],'uid='.$R['uid'].' and my_mbruid='.$my['uid']);
		if ($R['rel'])
		{
			getDbUpdate($table['s_friend'],'rel=0','my_mbruid='.$R['by_mbruid'].' and by_mbruid='.$R['my_mbruid']);
		}
	}
}

if ($fuid&&$mbruid)
{
	echo '<script type="text/javascript">';
	echo 'parent.getMemberLayerLoad('.$mbruid.');';
	echo '</script>';
	getLink('','','','');
}
else {
	getLink('reload','parent.','','');
}
?>
