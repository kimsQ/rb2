<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error'] = false;

if (!$uid || !$display ) getLink('','','잘못된 접근입니다.','');

$R = getUidData($table[$m.'data'],$uid);

if (!$R['uid']) getLink('','','존재하지 않는 포스트입니다.','');
if (!checkPostOwner($R)) getLink('','','권한이 없습니다.','');

$hidden = $display==1 || $display==2?1:0;
$d_modify =$date['totime']; // 수정 등록일

//데이터 업데이트
$QVAL1 = "display='$display',hidden='$hidden',d_modify='$d_modify'";
getDbUpdate($table[$m.'data'],$QVAL1,'uid='.$R['uid']);

// 피드 인덱스 추가
if ($display>3) {

  $_FCD = getDbArray($table['s_friend'],'by_mbruid='.$my['uid'],'my_mbruid','uid','asc',0,1);
  while ($_F=db_fetch_array($_FCD)) {
    $mbruid		= $_F['my_mbruid'];
    $module 	= $m;
    $category	= '';
    $entry		= $R['uid'];
    $d_regis	= $date['totime'];

    $check_feed_qry = "mbruid='".$mbruid."' and module='".$module."' and entry='".$entry."'";
    $is_feed = getDbRows($table['s_feed'],$check_feed_qry);

    if (!$is_feed){
      $_QKEY = 'site,mbruid,module,category,entry,d_regis';
    	$_QVAL = "'$s','$mbruid','$module','$category','$entry','$d_regis'";
    	getDbInsert($table['s_feed'],$_QKEY,$_QVAL);
    }
  }

  //피드 구데이터 삭제 (인덱스 용량 5000건 제한 )
  $_REFCNT = getDbRows($table['s_feed'],'');
  if ($_REFCNT > 5000) {
    $_REFOVER = getDbArray($table['s_feed'],'','*','uid','asc',($_REFCNT - 4001),1);
    while($_REFK=db_fetch_array($_REFOVER)) {
      getDbDelete($table['s_feed'],'uid='.$_REFK['uid']); // 구 데이터삭제
    }
  }

  if ($_REFCNT == 1000) {
    db_query("OPTIMIZE TABLE ".$table['s_feed'],$DB_CONNECT);
  }

}

getDbUpdate($table[$m.'index'],'display='.$display,'gid='.$R['gid']); //데이터 인덱스 업데이트
getDbUpdate($table[$m.'member'],'display='.$display,'data='.$R['uid']); //멤버 인덱스 업데이트
getDbUpdate($table[$m.'category_index'],'display='.$display,'data='.$R['uid']); //카테고리 인덱스 업데이트
getDbUpdate($table[$m.'list_index'],'display='.$display,'data='.$R['uid']); //리스트 인덱스 업데이트
getDbUpdate($table['s_feed'],'display='.$display,'module="'.$m.'" and entry='.$R['uid']); //피드 인덱스 업데이트
getDbUpdate($table[$m.'day'],'display='.$display,'data='.$R['uid']); // 일별현황 업데이트 (인기 포스트 추출목적)

echo json_encode($result);
exit;

?>
