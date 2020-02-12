<?php
if(!defined('__KIMS__')) exit;

$_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$data.' and level=1');
if (!$_IS_POSTOWN) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

if(!getDbRows($table[$m.'member'],'data='.$data.' and mbruid='.$mbruid)) getLink('reload','parent.','목록에 존재하지 않는 회원입니다.','');

$d_regis	= $date['totime']; // 최초 등록일

getDbUpdate($table['s_mbrdata'],'num_post=num_post-1','memberuid='.$mbruid);  //회원 리스트수 조정
getDbDelete($table[$m.'member'],'data='.$data.' and mbruid='.$mbruid);//멤버삭제

// 리스트에서 제거
$_orign_list_members = getDbArray($table[$m.'list_index'],'data='.$data.' and mbruid='.$mbruid,'*','data','asc',0,1);
while($_olm=db_fetch_array($_orign_list_members)) {
  getDbDelete($table[$m.'list_index'],'list='.$_olm['list'].' and data='.$data.' and mbruid='.$mbruid);
  getDbUpdate($table[$m.'list'],'num=num-1,d_last='.$d_regis,'uid='.$_olm['list']);
}

getDbUpdate($table['s_feed'],'hidden=1','module="'.$m.'" and entry='.$data.' and mbruid='.$mbruid); //피드 인덱스 업데이트

$result=array();
$result['error'] = false;

echo json_encode($result);
exit;
?>
