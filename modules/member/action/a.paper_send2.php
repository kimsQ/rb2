<?php
if(!defined('__KIMS__')) exit;

$subject = trim($subject);
$msg = trim($msg);
$html = $html ? $html : 'TEXT';

if (!$msg) getLink('','','정상적인 접근이 아닙니다.','');
if (!$my['uid']) getLink('','','권한이 없습니다.','');

if ($subject)
{
	include_once $g['path_core'].'function/email.func.php';
}

if ($type == 'multi')
{
	$idexp = explode(',',$id);
	$idlen = count($idexp);
	$j = 0;
	for ($i = 0; $i < $idlen; $i++)
	{
		$xid = trim($idexp[$i]);
		if (!$xid) continue;

		if (strpos($xid,'@'))
		{
			$M = getDbData($table['s_mbrdata'],"email='".$xid."'",'*');
			if (!$M['memberuid']) continue;
			$M1 = getUidData($table['s_mbrid'],$M['memberuid']);
		}
		else {
			$M1 = getDbData($table['s_mbrid'],"id='".$xid."'",'*');
			if (!$M1['uid']) continue;
			$M = getDbData($table['s_mbrdata'],'memberuid='.$M1['uid'],'*');
		}

		if ($subject)
		{
			if (!$M['email']) continue;
			$result = getSendMail($M['email'].'|'.$M['name'], $my['email'].'|'.$my['name'],$subject,$msg,'TEXT');
			if ($result) $j++;
		}
		else {
			$QKEY = 'parent,my_mbruid,by_mbruid,inbox,content,html,upload,d_regis,d_read';
			$QVAL = "'$parent','".$M1['uid']."','".$my['uid']."','1','".$msg."','$html','$upload','".$date['totime']."','0'";
			getDbInsert($table['s_paper'],$QKEY,$QVAL);
			getDbUpdate($table['s_mbrdata'],'is_paper=1','memberuid='.$M1['uid']);
			$j++;
		}
	}
}
else {
	if (!$rcvmbr) getLink('','','받는사람이 지정되지 않았습니다.','');
	$M = getDbData($table['s_mbrdata'],'memberuid='.$rcvmbr,'*');
	if (!$M['memberuid']) getLink('','','받는사람이 지정되지 않았습니다.','');

	$QKEY = 'parent,my_mbruid,by_mbruid,inbox,content,html,upload,d_regis,d_read';
	$QVAL = "'$parent','".$M['memberuid']."','".$my['uid']."','1','".$msg."','$html','$upload','".$date['totime']."','0'";
	getDbInsert($table['s_paper'],$QKEY,$QVAL);
	getDbUpdate($table['s_mbrdata'],'is_paper=1','memberuid='.$M['memberuid']);
}
getLink('','parent.','쪽지가 전송되었습니다.','');
?>