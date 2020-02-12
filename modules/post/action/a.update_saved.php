<?php
if(!defined('__KIMS__')) exit;

$R = getUidData($table[$m.'data'],$uid);

$result=array();
$result['error']=false;

if (!$R['uid']) {
	$result['error']=true;
}

$mbruid		= $my['uid'];
$module 	= $m;
$category	='포스트';
$entry		= $R['uid'];
$subject	= addslashes($R['subject']);
$d_regis	= $date['totime'];

$check_saved_qry = "mbruid='".$mbruid."' and module='".$module."' and entry='".$entry."'";
$is_saved = getDbRows($table['s_saved'],$check_saved_qry);

if (!$is_saved){ // 이미 저장했던 경우
	$_QKEY = 'mbruid,module,category,entry,subject,url,d_regis';
	$_QVAL = "'$mbruid','$module','$category','$entry','$subject','$url','$d_regis'";
	getDbInsert($table['s_saved'],$_QKEY,$_QVAL);
}

echo json_encode($result);
exit;
?>
