<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

$mbruid =  $my['uid'];
$last_log	= $date['totime'];
$id   = $id ? trim($id) : substr($g['time_srnad'],9,7);;
$name = addslashes(htmlspecialchars(trim($name)));

if ($uid) {
  $R = getUidData($table[$m.'list'],$uid);

  if ($R['mbruid']!=$mbruid) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

  if ($type=='name') {
    if (!$name) getLink('reload','parent.','리스트 이름을 입력해 주세요.','');
    if(getDbRows($table[$m.'list'],"name='".$name."' and mbruid=".$mbruid." and uid<>".$R['uid'])) getLink('reload','parent.','이미 같은 이름의 리스트가 존재합니다.','');
    getDbUpdate($table[$m.'list'],'name="'.$name.'",d_last='.$last_log,'uid='.$R['uid']);  //리스트명 조정
    setrawcookie('listview_action_result', rawurlencode('리스트명이 수정 되었습니다.|success'));  // 처리여부 cookie 저장
    getLink('reload','parent.','','');
  }

  if ($type=='review') {
    $result=array();
    $result['error'] = false;
    $review = str_replace(array("\r", "\n"), '', $content);
  	$QVAL = "review='$review',d_last='$last_log'";
  	getDbUpdate($table[$m.'list'],$QVAL,'uid='.$R['uid']);
  	$_list = getUidData($table[$m.'list'],$R['uid']);
  	$result['content'] = getContents($_list['review'],'TEXT');
  	echo json_encode($result);
  	exit;
  }

  if ($type=='display') {
    $result=array();
    $result['error'] = false;
    echo json_encode($result);
    getDbUpdate($table[$m.'list'],'display='.$display,'uid='.$R['uid']);
    getDbUpdate($table[$m.'list_member'],'display='.$display,'list='.$R['uid']);
    exit;
  }

  if ($type=='tag') {
    $result=array();
    $result['error'] = false;
    echo json_encode($result);
    getDbUpdate($table[$m.'list'],'tag="'.$tag.'"','uid='.$R['uid']);

    // 태그등록
    if ($tag || $R['tag'])
    {
    	$_tagarr1 = array();
    	$_tagarr2 = explode(',',$tag);
      $_tagdate = $date['today'];

    	if ($R['uid'])
    	{
        $_tagdate = substr($R['d_regis'],0,8);
    		$_tagarr1 = explode(',',$R['tag']);
    		foreach($_tagarr1 as $_t)
    		{
    			if(!$_t || in_array($_t,$_tagarr2)) continue;
          $_TAG = getDbData($table['s_tag'],"site=".$R['site']." and date='".$_tagdate."' and keyword='".$_t."'",'*');
    			if($_TAG['uid'])
    			{
    				if($_TAG['hit']>1) getDbUpdate($table['s_tag'],'hit=hit-1','uid='.$_TAG['uid']);
    				else getDbDelete($table['s_tag'],'uid='.$_TAG['uid']);
    			}
    		}
    	}

    	foreach($_tagarr2 as $_t)
    	{
    		if(!$_t || in_array($_t,$_tagarr1)) continue;
    		$_TAG = getDbData($table['s_tag'],'site='.$s." and date='".$_tagdate."' and keyword='".$_t."'",'*');
    		if($_TAG['uid']) getDbUpdate($table['s_tag'],'hit=hit+1','uid='.$_TAG['uid']);
    		else getDbInsert($table['s_tag'],'site,date,keyword,hit',"'".$s."','".$_tagdate."','".$_t."','1'");
    	}
    }

    setrawcookie('listview_action_result', rawurlencode($name.' 태그가 저장 되었습니다.|success'));  // 처리여부 cookie 저장
    exit;
  }

} else {

  if (!$name) getLink('reload','parent.','리스트 이름을 입력해 주세요.','');
  if (!$id) getLink('reload','parent.','아이디를 입력해 주세요.','');

  if(getDbRows($table[$m.'list'],"id='".$id."'")) getLink('reload','parent.','이미 같은 아이디의 리스트가 존재합니다.','');

  if(getDbRows($table[$m.'list'],"name='".$name."' and mbruid=".$mbruid)) {
    if ($send_mod == 'ajax') {
      $result['error'] = 'name_exists';
      echo json_encode($result);
      exit;
    } else {
      getLink('reload','parent.','이미 같은 이름의 리스트가 존재합니다.','');
    }
  }

  $display = $display?$display:1;
  $maxgid = getDbCnt($table[$m.'list'],'max(gid)','');
  $gid = $maxgid ? $maxgid+1 : 1;

  $QKEY = "gid,site,id,name,mbruid,display,num,d_last,d_regis,imghead,imgfoot,puthead,putfoot,addinfo,writecode";
  $QVAL = "'$gid','$s','$id','$name','$mbruid','$display','0','$last_log','$last_log','$imghead','$imgfoot','$puthead','$putfoot','$addinfo','$writecode'";
  getDbInsert($table[$m.'list'],$QKEY,$QVAL);
  getDbUpdate($table['s_mbrdata'],'num_list=num_list+1','memberuid='.$my['uid']);  //회원 리스트수 조정

  $LASTUID = getDbCnt($table[$m.'list'],'max(uid)','');

  $QKEY2 = "mbruid,site,gid,list,display,auth,level,d_regis";
  $QVAL2 = "'$mbruid','$s','$gid','$LASTUID','$display','1','1','$last_log'";
  getDbInsert($table[$m.'list_member'],$QKEY2,$QVAL2);

  if ($send_mod == 'ajax') {

    $_R = getUidData($table[$m.'list'],$LASTUID);
    $result=array();
    $result['error'] = false;
    $result['uid'] = $LASTUID;
    $result['id'] = $_R['id'];
    $result['icon'] = $g['displaySet']['icon'][$_R['display']];
    $result['label'] = $g['displaySet']['label'][$_R['display']];
    echo json_encode($result);
  	exit;

  } else {

    setrawcookie('list_action_result', rawurlencode($name.' 리스트가 추가 되었습니다.|success'));  // 처리여부 cookie 저장
    getLink('reload','parent.','','');
  }

}

?>
