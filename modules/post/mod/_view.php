<?php
if(!defined('__KIMS__')) exit;

// 조회기록
if ($mod=='view' && $d['post']['isperm'] && $my['uid'] && $R['uid']) {
	if(!getDbRows($table['s_history'],"date='".$date['today']."' and site=".$s.' and entry='.$R['uid'].' and mbruid='.$my['uid'])) {
		getDbInsert($table['s_history'],'site,mbruid,module,entry,date,d_regis',"'".$s."','".$my['uid']."','".$m."','".$R['uid']."','".$date['today']."','".$date['totime']."'");
		$_REFCNT = getDbRows($table['s_history'],'');
		if ($_REFCNT > 10000) {
			$_REFOVER = getDbArray($table['s_history'],'','*','uid','asc',($_REFCNT - 9000),1);
			while($_REFK=db_fetch_array($_REFOVER)) getDbDelete($table['s_history'],'uid='.$_REFK['uid']);
		}
	}
}

if ($mod=='view' && $d['post']['isperm'] && ($d['post']['hitcount'] || !strpos('_'.$_SESSION['module_'.$m.'_view'],'['.$R['uid'].']'))) {

	getDbUpdate($table[$m.'data'],'hit=hit+1','uid='.$R['uid']);
	getDbUpdate($table['s_mbrdata'],'hit_post=hit_post+1','memberuid='.$R['mbruid']);

	if(!getDbRows($table['s_mbrmonth'],"date='".$date['month']."' and site=".$s.' and mbruid='.$R['mbruid'])) {
    getDbInsert($table['s_mbrmonth'],'date,site,mbruid',"'".$date['month']."','".$s."','".$R['mbruid']."'");
  }

  if(!getDbRows($table['s_mbrday'],"date='".$date['today']."' and site=".$s.' and mbruid='.$R['mbruid'])) {
    getDbInsert($table['s_mbrday'],'date,site,mbruid',"'".$date['today']."','".$s."','".$R['mbruid']."'");
  }

	if(!getDbRows($table[$m.'month'],"date='".$date['month']."' and site=".$s.' and data='.$R['uid'])) {
		getDbInsert($table[$m.'month'],'date,site,data',"'".$date['month']."','".$s."','".$R['uid']."'");
	}

	if(!getDbRows($table[$m.'day'],"date='".$date['today']."' and site=".$s.' and data='.$R['uid'])) {
		getDbInsert($table[$m.'day'],'date,site,data',"'".$date['today']."','".$s."','".$R['uid']."'");
	}

	$device = isMobileConnect($_SERVER['HTTP_USER_AGENT'])?'mobile':'desktop';
	$side = strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])?'inside':'outside';

	getDbUpdate($table['s_mbrmonth'],'post_hit=post_hit+1',"date='".$date['month']."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 조회수 갱신
	getDbUpdate($table['s_mbrday'],'post_hit=post_hit+1',"date='".$date['today']."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별조회수 갱신

	if ($ref) $_QVAL = ','.$ref.'='.$ref.'+1';

	getDbUpdate($table[$m.'month'],'hit=hit+1,'.$device.'='.$device.'+1,'.$side.'='.$side.'+1'.$_QVAL,"date='".$date['month']."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 조회수 갱신
	getDbUpdate($table[$m.'day'],'hit=hit+1,display='.$R['display'].','.$device.'='.$device.'+1,'.$side.'='.$side.'+1'.$_QVAL,"date='".$date['today']."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 조회수 갱신

	$_SESSION['module_'.$m.'_view'] .= '['.$R['uid'].']';
}

if ($d['post']['isperm'] && $R['upload'])
{
	$d['upload'] = array();
	$d['upload']['tmp'] = $R['upload'];
	$d['_pload'] = getArrayString($R['upload']);
	$attach_file_num=0;// 첨부파일 수량 체크  ---------------------------------> 2015.1.1 추가 by kiere.
	foreach($d['_pload']['data'] as $_val)
	{
		$U = getUidData($table['s_upload'],$_val);
		if (!$U['uid'])
		{
			$R['upload'] = str_replace('['.$_val.']','',$R['upload']);
			$d['_pload']['count']--;
		}
		else {
			$d['upload']['data'][] = $U;
			if (!$U['sync'])
			{
				$_SYNC = "sync='[".$m."][".$R['uid']."][uid,down][".$table[$m.'data']."][".$R['mbruid']."][m:".$m.",bid:".$R['bbsid'].",uid:".$R['uid']."]'";
				getDbUpdate($table['s_upload'],$_SYNC,'uid='.$U['uid']);
			}
		}
		if($U['hidden']==0) $attach_file_num++; // 숨김처리 안했으면 수량 ++
	}
	if ($R['upload'] != $d['upload']['tmp'])
	{
		// getDbUpdate($table[$m.'data'],"upload='".$R['upload']."'",'uid='.$R['uid']);
	}
	$d['upload']['count'] = $d['_pload']['count'];
}

$mod = $mod ? $mod : 'view';

if ($mbrid) {
	$M = getDbData($table['s_mbrid'],"id='".$mbrid."'",'*');
	$MBR = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
}

//최초등록자
$M1 = getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'*');

//구독(팔로우)여부
$_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$M1['memberuid']);

$LIST=getDbData($table[$m.'list'],"id='".$list."'",'*');

//포스트 멤버
$_POSTMBR_RCD = getDbArray($table[$m.'member'],'data='.$R['uid'].' and auth=1','*','d_regis','asc',0,1);
while($_POSTMBR_R = db_fetch_array($_POSTMBR_RCD)) $MBR_RCD[] = getDbData($table['s_mbrdata'],'memberuid='.$_POSTMBR_R['mbruid'],'*');

?>
