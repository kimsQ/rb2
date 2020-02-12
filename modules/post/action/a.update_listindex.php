<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

$R = getUidData($table[$m.'data'],$uid);
$mbruid =  $my['uid'];
$last_log	= $date['totime'];
$display = $R['display'];
$subject = $R['subject'];
$category = '포스트';

// 저장함 업데이트
$check_saved_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."'";
$is_saved = getDbRows($table['s_saved'],$check_saved_qry);

if ($is_saved){ // 이미 저장했던 경우
	getDbDelete($table['s_saved'],$check_saved_qry);
}else{ // 저장을 안한 경우 추가
	$_QKEY = 'mbruid,module,category,entry,subject,url,d_regis';
	$_QVAL = "'$mbruid','$m','$category','$uid','$subject','$url','$last_log'";
	getDbInsert($table['s_saved'],$_QKEY,$_QVAL);
}

//리스트 업데이트
$_orign_list_members = getDbArray($table[$m.'list_index'],'data='.$R['uid'].' and mbruid='.$mbruid,'*','data','asc',0,1);

while($_olm=db_fetch_array($_orign_list_members)) {
  if(!strstr($list_members,'['.$_olm['list'].']')) {
    getDbDelete($table[$m.'list_index'],'list='.$_olm['list'].' and data='.$R['uid'].' and mbruid='.$mbruid);
    getDbUpdate($table[$m.'list'],'num=num-1','uid='.$_olm['list']);
  }
}

$_list_members = array();
$_list_members = getArrayString($list_members);

foreach($_list_members['data'] as $_lt1) {
  if (getDbRows($table[$m.'list_index'],'data='.$uid.' and list='.$_lt1)) {
    getDbUpdate($table[$m.'list_index'],'display='.$display,'data='.$uid.' and list='.$_lt1);
  } else {
    $maxgid = getDbCnt($table[$m.'list_index'],'max(gid)','');
    $gid = $maxgid ? $maxgid+1 : 1;
    getDbInsert($table[$m.'list_index'],'site,list,display,data,gid,mbruid',"'".$s."','".$_lt1."','".$display."','".$R['uid']."','".$gid."','".$mbruid."'");
    getDbUpdate($table[$m.'list'],'num=num+1,d_last='.$last_log,'uid='.$_lt1);
  }

}

$result=array();
$result['error'] = false;
echo json_encode($result);
exit;

?>
