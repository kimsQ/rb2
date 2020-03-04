<?php
if(!defined('__KIMS__')) exit;

$history = $__target ? '-1' : '';
$id	= trim($_POST['id']);
$pw	= trim($_POST['pw']);

if (!$id || !$pw) getLink('reload','parent.','이메일과 패스워드를 입력해 주세요.',$history);

if (strpos($id,'@') && strpos($id,'.')) {
	$M2 = getDbData($table['s_mbremail'],"email='".$id."'",'*');
	$M	= getUidData($table['s_mbrid'],$M2['mbruid']);
	$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
} else if (substr($id,0,3)=='010' || substr($id,0,3)=='011' || substr($id,0,3)=='016' || substr($id,0,3)=='017' || substr($id,0,3)=='018' || substr($id,0,3)=='019') {
	$M2 = getDbData($table['s_mbrphone'],"phone='".$id."'",'*');
	$M	= getUidData($table['s_mbrid'],$M2['mbruid']);
	$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
} else {
	$M = getDbData($table['s_mbrid'],"id='".$id."'",'*');
	$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
}

if (!$M['uid'] || $M1['auth'] == 4) {
	echo "<script>";
	echo "parent.$('".$form."').removeClass('was-validated');";
	echo "parent.$('".$form."').find('[type=submit]').prop('disabled', false);";
	echo "parent.$('".$form."').find('[data-role=idErrorBlock]').text('존재하지 않는 계정입니다.');";
	echo "parent.$('".$form."').find('[name=id]').focus().addClass('is-invalid');";
	echo "</script>";
	exit();
}
if ($M1['auth'] == 2) getLink('reload','parent.','회원님은 인증보류 상태입니다.',$history);
if ($M1['auth'] == 3) getLink('reload','parent.','회원님은 본인 인증대기 상태입니다.',$history);

if ($M['pw'] != getCrypt($pw,$M1['d_regis']) && $M1['tmpcode'] != getCrypt($pw,$M1['d_regis'])) {
  echo "<script>";
	echo "parent.$('".$form."').removeClass('was-validated');";
	echo "parent.$('".$form."').find('[type=submit]').prop('disabled', false);";
	echo "parent.$('".$form."').find('[data-role=passwordErrorBlock]').text('패스워드가 일치하지 않습니다.');";
	echo "parent.$('".$form."').find('[name=pw]').val('').focus().addClass('is-invalid');";
	echo "</script>";
	exit();
}



if ($usertype == 'admin')
if (!$M1['admin']) getLink('reload','parent.','회원님은 관리자가 아닙니다.',$history);

getDbUpdate($table['s_mbrdata'],"tmpcode='',num_login=num_login+1,now_log=1,last_log='".$date['totime']."'",'memberuid='.$M['uid']);
getDbUpdate($table['s_referer'],'mbruid='.$M['uid'],"d_regis like '".$date['today']."%' and site=".$s." and mbruid=0 and ip='".$_SERVER['REMOTE_ADDR']."'");

//소셜 로그인 후, 계정통합 처리
if ($snsuid && $snsname) {
	$d_regis	= $date['totime'];

	// SNS에 등록된 아바타가 있고, 회원정보에 저장된 아바타가 없을 경우
	if (!$M['photo'] && $_photo) {
		if (strpos($_photo,'facebook'))
		{
			$_facebookHeaders = get_headers($_photo, 1);
			if (array_key_exists('Location', $_facebookHeaders))
			{
				$_photo = $_facebookHeaders['Location'];
				$_photodata = getCURLData($_photo,'');
			}
		}
		else {
			$_photodata = getCURLData($_photo,'');
		}

		if ($_photodata)
		{
			$fileExt	= 'jpg';
			$fp = fopen($g['path_var'].'avatar/snstmp.jpg','w');
			fwrite($fp,$_photodata);
			fclose($fp);

			$photo		= $id.'.'.$fileExt;
			$saveFile1	= $g['path_var'].'avatar/'.$photo;

			include $g['path_core'].'function/thumb.func.php';
			ResizeWidth($g['path_var'].'avatar/snstmp.jpg',$saveFile1,360);

			@chmod($saveFile1,0707);
			unlink($g['path_var'].'avatar/snstmp.jpg');
		}
		getDbUpdate($table['s_mbrdata'],"photo='".$photo."'",'memberuid='.$M['uid']);  // 회원정보 아바타 이미지 저장
	}

	getDbUpdate($table['s_mbrdata'],"sns='".$snsname."'",'memberuid='.$M['uid']);  // 회원정보 sns 로그인 기록
	getDbUpdate($table['s_mbremail'],"d_verified='".$d_regis."'",'mbruid='.$M['uid'].' and email="'.$id.'"');  //  // 소셜미디어에서 전달받은 이메일 본인확인 처리

	getDbInsert($table['s_mbrsns'],'mbruid,sns,id,access_token,refresh_token,expires_in,d_regis',"'".$M['uid']."','".$snsname."','$snsuid','$sns_access_token','$sns_refresh_token','$sns_expires_in','$d_regis'");
	$_SESSION['SL'] = ''; // 소셜로그인 세션 초기화
}

if($login_cookie=='checked'){
 setAccessToken($M1['memberuid'],'login');
}

$_SESSION['mbr_uid'] = $M['uid'];
$_SESSION['mbr_pw']  = $M['pw'];
$referer = $referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'];
$referer = str_replace('&panel=Y','',$referer);
$referer = str_replace('&a=logout','',$referer);

$fmktile = mktime();
$ffolder = $g['path_tmp'].'session/';
$opendir = opendir($ffolder);
while(false !== ($file = readdir($opendir)))
{
	if(!is_file($ffolder.$file)) continue;
	if($fmktile -  filemtime($ffolder.$file) > 1800 ) unlink($ffolder.$file);
}
closedir($opendir);

if ($usertype == 'admin' || $M1['admin']) {
	if (!$M1['super'] && !$M1['adm_site']) getLink($g['s'].'/?r='.$r,'parent.','관리 사이트가 지정되지 않았습니다.','');
	$_siteArray = getArrayString($M1['adm_site']);
	$SD	= getUidData($table['s_site'],$_siteArray[data][0]);
	$r = $SD['id'];
}

if ($usertype == 'admin' && $M1['admin']) {
	getLink($g['s'].'/?r='.$r.'&panel=Y&pickmodule=dashboard&amp;important=panel','parent.parent.','','');
}

if ($M1['admin']) {
	setrawcookie('site_common_result', rawurlencode('관리자 로그인 되었습니다.|default'));  // 알림처리를 위한 로그인 상태 cookie 저장

	$site	= getUidData($table['s_site'],$s);
	$site_array = explode('/',$site['layout']);
	$nopanel_file = $g['path_layout'].$site_array[0].'/_var/nopanel.txt';

	if (is_file($nopanel_file) || ($g['mobile']&&$_SESSION['pcmode']!='Y')) {
		getLink($referer?$referer:$g['s'].'/?r='.$r,'parent.','','');
	} else {
		getLink($g['s'].'/?r='.$r.'&_admpnl_='.urlencode($referer).'&panel=Y','parent.','','');
	}

} else {
	setrawcookie('site_common_result', rawurlencode($M1['name'].'님 로그인 되었습니다.'));  // 알림처리를 위한 로그인 상태 cookie 저장
	getLink($referer?$referer:$g['s'].'/?r='.$r,'parent.','','');
}

?>
