<?php
if(!defined('__KIMS__')) exit;
if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].','))
{
	if ($d['bbs']['perm_l_view'] > $my['level'] || strpos('_'.$d['bbs']['perm_g_view'],'['.$my['mygroup'].']'))
	{
		$g['main'] = $g['dir_module'].'mod/_permcheck.php';
		$d['bbs']['isperm'] = false;
	}
}
if ($R['hidden'])
{
	if ($my['uid'] != $R['mbruid'] && $my['uid'] != $R['pw'] && !$my['admin'])
	{
		if (!strpos('_'.$_SESSION['module_'.$m.'_pwcheck'],'['.$R['uid'].']'))
		{
			$g['main'] = $g['dir_module'].'mod/_pwcheck.php';
			$d['bbs']['isperm'] = false;
		}
	}
}
if ($d['bbs']['isperm'] && ($d['bbs']['hitcount'] || !strpos('_'.$_SESSION['module_'.$m.'_view'],'['.$R['uid'].']')))
{
	if ($R['point2'])
	{
		$g['main'] = $g['dir_module'].'mod/_pointcheck.php';
		$d['bbs']['isperm'] = false;
	}
	else {
		getDbUpdate($table[$m.'data'],'hit=hit+1','uid='.$R['uid']);
		$_SESSION['module_'.$m.'_view'] .= '['.$R['uid'].']';
	}
}
if ($d['bbs']['isperm'] && $R['upload'])
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

// 메타 이미지 세팅 = 해당 포스트의 대표 이미지를 메타 이미지로 적용한다.
if($R['featured_img']){
	$g['meta_img']=getPreviewResize(getUpImageSrc($R),'600x450');
}
$mod = $mod ? $mod : 'view';
$bid = $R['bbsid'];
?>
