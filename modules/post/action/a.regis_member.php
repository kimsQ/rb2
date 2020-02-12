<?php
if(!defined('__KIMS__')) exit;

$_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$data.' and level=1');
if (!$_IS_POSTOWN) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

if(!getDbRows($table['s_mbrdata'],'nic="'.$nic.'"')) getLink('reload','parent.','존재하지 않는 회원입니다.','');


$R	= getUidData($table[$m.'data'],$data);
$M = getDbData($table['s_mbrdata'],'nic="'.$nic.'"','*');

$mbruid =  $M['memberuid'];
$d_regis	= $date['totime'];
$gid = $R['gid'];
$display = $R['display'];

if(getDbRows($table[$m.'member'],'data='.$data.' and mbruid='.$mbruid)) getLink('reload','parent.','포스트에 이미 존재합니다.','');

$QKEY = "mbruid,site,gid,data,display,auth,level,d_regis";
$QVAL = "'$mbruid','$s','$gid','$data','$display','1','$level','$d_regis'";
getDbInsert($table[$m.'member'],$QKEY,$QVAL);
getDbUpdate($table['s_mbrdata'],'num_post=num_post+1','memberuid='.$mbruid);  //추가회원 포스트수 조정

// 피드 인덱스 추가
if ($display>1) {

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
    } else {
      getDbUpdate($table['s_feed'],'hidden=0',$check_feed_qry); //피드 인덱스 업데이트
    }
  }

}

$result=array();
$result['error'] = false;
$result['mbruid'] = $mbruid;

setrawcookie('post_action_result', rawurlencode('공유목록에 추가되었습니다.|success'));  // 처리여부 cookie 저장
echo json_encode($result);
exit;
?>
