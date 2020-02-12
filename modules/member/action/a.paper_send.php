<?php
if(!defined('__KIMS__')) exit;

$subject = trim($subject);
$msg = trim($msg);
$html = $html ? $html : 'text';

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
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript">
//<![CDATA[
parent.getId('paperbox').innerHTML = '<div style="text-align:center;padding-top:100px;font-weight:bold;color:#888;"><img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" style="margin-bottom:-2px;margin-right:3px;" /><?php if($j):?>총 <?php echo $j?>명에게 <?php echo $subject?'이메일이':'메세지가'?> 전송되었습니다.<?php else:?><?php echo $subject?'이메일이':'메세지가'?> 전송되지 않았습니다.<?php endif?></div>';
setTimeout("parent.parent.getLayerBoxHide();",1000);
//]]>
</script> 
<?php
exit;
}
else {
	if (!$rcvmbr) getLink('','','받는사람이 지정되지 않았습니다.','');
	$M = getDbData($table['s_mbrdata'],'memberuid='.$rcvmbr,'*');
	if (!$M['memberuid']) getLink('','','받는사람이 지정되지 않았습니다.','');

	$QKEY = 'parent,my_mbruid,by_mbruid,inbox,content,html,upload,d_regis,d_read';
	$QVAL = "'$parent','".$M['memberuid']."','".$my['uid']."','1','".$msg."','$html','$upload','".$date['totime']."','0'";
	getDbInsert($table['s_paper'],$QKEY,$QVAL);
	getDbUpdate($table['s_mbrdata'],'is_paper=1','memberuid='.$M['memberuid']);
?>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<script type="text/javascript">
//<![CDATA[
parent.getId('paperbox').innerHTML = '<div style="text-align:center;padding-top:100px;font-weight:bold;color:#888;"><img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" style="margin-bottom:-2px;margin-right:3px;" />메세지를 보냈습니다.</div>';
setTimeout("parent.parent.getLayerBoxHide();",1000);
//]]>
</script> 
<?php
exit;
}
?>