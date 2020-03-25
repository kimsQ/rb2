<?php
if(!defined('__KIMS__')) exit;

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$m.'/var/var.php';
include_once $_tmpvfile;

include $g['dir_module'].'var/noti/_'.$a.'.php';  // 알림메시지 양식

$id			= $id?$id:substr($g['time_split'][1],1,9);
$name		= trim($name);
$nic		= trim($nic);
$nic		= $nic ? $nic : $name;
$email		= trim($email);
$phone		= str_replace('-','',$phone);

if (!$id || !$name) getLink('', '', '정상적인 접속이 아닙니다.', '');

if(strstr(','.$d['member']['join_cutnic'].',',','.$nic.',')) {
	getLink('','','사용할 수 없는 이름 입니다.','');
}
if(getDbRows($table['s_mbrdata'],"nic='".$nic."'")) {
	$nic		= $nic.'_'.date('His');  //닉네임이 중복될 경우 중복되지 않는 임의값 적용
}

if ($snsuid) $pw1 = $id;
getDbInsert($table['s_mbrid'],'site,id,pw',"'$s','$id','".getCrypt($pw1,$date['totime'])."'");
$memberuid  = getDbCnt($table['s_mbrid'],'max(uid)','');
$auth		= $snsuid ? 1 : $d['member']['join_auth'];
$mygroup		= $d['member']['join_group'];
$level		= $d['member']['join_level'];
$comp		= $d['member']['form_comp'] && $comp ? 1 : 0;
$admin		= 0;
$name		= trim($name);
$photo		= '';
$cover		= '';
$home		= $home ? (strstr($home,'http://')?str_replace('http://','',$home):$home) : '';
$birth1		= $birth_1;
$birth2		= $birth_2.$birth_3;
$birthtype	= $birthtype ? $birthtype : 0;
$tel		= $tel_1 && $tel_2 && $tel_3 ? $tel_1 .'-'. $tel_2 .'-'. $tel_3 : '';
$location		= trim($location);
$job		= trim($job);
$marr1		= $marr_1 && $marr_2 && $marr_3 ? $marr_1 : 0;
$marr2		= $marr_1 && $marr_2 && $marr_3 ? $marr_2.$marr_3 : 0;
$sms		= $event && $phone ? 1 : 0;
$mailing	= $event && $email ? 1 : 0;
$smail		= 0;
$point		= $d['member']['join_point'];
$usepoint	= 0;
$money		= 0;
$cash		= 0;
$num_login	= 1;
$bio		= trim($bio);
$now_log	= $auth == 1?1:0;
$last_log	= $date['totime'];
$last_pw	= $snsuid?'':$date['totime'];
$is_paper	= 0;
$d_regis	= $date['totime'];
$sns		= $snsuid?$snsname:'';
$addfield	= '';

if ($_photo) {
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
}

$_addarray	= file($g['path_var'].'site/'.$r.'/member.add_field.txt');

foreach($_addarray as $_key)
{
	$_val = explode('|',trim($_key));
	if ($_val[2] == 'checkbox')
	{
		$addfield .= $_val[0].'^^^';
		if (is_array(${'add_'.$_val[0]}))
		{
			foreach(${'add_'.$_val[0]} as $_skey)
			{
				$addfield .= '['.$_skey.']';
			}
		}
		$addfield .= '|||';
	}
	else {
		$addfield .= $_val[0].'^^^'.trim(${'add_'.$_val[0]}).'|||';
	}
}

$_QKEY = "memberuid,site,auth,mygroup,level,comp,admin,adm_view,";
$_QKEY.= "email,email_noti,name,nic,grade,photo,cover,home,sex,birth1,birth2,birthtype,phone,tel,";
$_QKEY.= "location,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,bio,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,addfield";
$_QVAL = "'$memberuid','$s','$auth','$mygroup','$level','$comp','$admin','',";
$_QVAL.= "'$email','$email','$name','$nic','','$photo','$cover','$home','$sex','$birth1','$birth2','$birthtype','$phone','$tel',";
$_QVAL.= "'$location','$job','$marr1','$marr2','$sms','$mailing','$smail','$point','$usepoint','$money','$cash','$num_login','$bio','$now_log','$last_log','$last_pw','$is_paper','$d_regis','','$sns','$addfield'";
getDbInsert($table['s_mbrdata'],$_QKEY,$_QVAL);
getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$level);
getDbUpdate($table['s_mbrgroup'],'num=num+1','uid='.$mygroup);
getDbUpdate($table['s_numinfo'],'login=login+1,mbrjoin=mbrjoin+1',"date='".$date['today']."' and site=".$s);

if ($email){

	if ($sns_email) {
		$d_verified = $d_regis;  // 소셜로그인 후 가입시 소셜이디어에서 전달받은 이메일이 있을 경우, 본인인증된 메일로 간주하여 저장
	} else {
		$R = getDbData($table['s_guestauth'],"email='".$email."'",'auth,d_regis');
		$d_verified = $R['auth']?$R['d_regis']:'';
	}

	getDbInsert($table['s_mbremail'],'mbruid,email,base,backup,d_regis,d_code,d_verified',"'".$memberuid."','".$email."',1,0,'".$d_regis."','','".$d_verified."'");
}
if ($phone) {
	$R = getDbData($table['s_guestauth'],"phone='".$phone."'",'auth,d_regis');
	$d_verified = $R['auth']?$R['d_regis']:'';
	getDbInsert($table['s_mbrphone'],'mbruid,phone,base,backup,d_regis,d_code,d_verified',"'".$memberuid."','".$phone."',1,0,'".$d_regis."','','".$d_verified."'");
}

if ($snsuid) {
	getDbInsert($table['s_mbrsns'],'mbruid,sns,id,access_token,refresh_token,expires_in,d_regis',"'".$memberuid."','".$snsname."','$snsuid','$sns_access_token','$sns_refresh_token','$sns_expires_in','$d_regis'");
}

if ($point)
{
	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'$memberuid','0','$point','".$d['member']['join_pointmsg']."','$d_regis'");
}

if ($auth == 1)
{
	$email_from = $d['member']['join_email']?$d['member']['join_email']:$d['admin']['sysmail'];
	$sms_tel = $d['member']['join_tel']?$d['member']['join_tel']:$d['admin']['sms_tel'];

	if ($d['member']['join_email_send'] && $email_from) {
		include_once $g['path_core'].'function/email.func.php';
		$content = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
		$content .= implode('',file($g['dir_module'].'doc/email/_join.complete.txt'));
		$content.= '<p><a href="'.$g['url_root'].'" style="display:block;font-size:15px;color:#fff;text-decoration:none;padding: 15px;background:#007bff;width: 200px;text-align: center;margin: 38px auto;" target="_blank">접속하기</a></p>';
		$content.= implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
		$content = str_replace('{EMAIL_MAIN}',$email_from,$content); //대표 이메일
		$content = str_replace('{TEL_MAIN}',$sms_tel,$content); // 대표 전화
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{NAME}',$name,$content);
		$content = str_replace('{NICK}',$nic,$content);
		$content = str_replace('{ID}',$id,$content);
		$content = str_replace('{PHONE}',$phone,$content);
		$content = str_replace('{EMAIL}',$email,$content);
		$content = str_replace('{DATE}',getDateFormat($d_regis,'Y.m.d H:i'),$content);
		getSendMail($email.'|'.$name,$email_from.'|'.$_HS['name'], '['.$_HS['name'].']회원가입을 축하드립니다.', $content, 'HTML');
	}

	if ($d['member']['join_sms_send'] && $sms_tel) {
		include_once $g['path_core'].'function/sms.func.php';
		$content = implode('',file($g['dir_module'].'doc/sms/_join.complete.txt'));  // SMS메시지 양식
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{NAME}',$name,$content);
		$content = str_replace('{PHONE}',$phone,$content);
		getSendSMS($phone,$sms_tel,'',$content,'sms');
	}

	// 가입자에게 알림전송
	$noti_title = $d['member']['noti_title'];
	$noti_body = $d['member']['noti_body'];
	$noti_referer = $g['url_http'].'/?r='.$r.'&mod=settings&page=noti';
	$noti_button = $d['member']['noti_button'];
	$noti_tag = '';
	$noti_skipEmail = 1;
	$noti_skipPush = 1;
	putNotice($memberuid,$m,0,$noti_title,$noti_body,$noti_referer,$noti_button,$noti_tag,$noti_skipEmail,$noti_skipPush);

	$_SESSION['mbr_uid'] = $memberuid;
  $_SESSION['mbr_pw']  = getCrypt($pw1,$d_regis);
	setrawcookie('site_common_result', rawurlencode($name.'님 로그인 되셨습니다.|default'));
	getLink($modal?'reload':RW(0),'parent.','축하합니다. 회원가입 승인되었습니다.','');
}
if ($auth == 2)
{
	getLink(RW(0),'parent.','회원가입 신청서가 접수되었습니다. 관리자 승인후 이용하실 수 있습니다.','');
}
if ($auth == 3)
{
	$email_from = $d['member']['join_email']?$d['member']['join_email']:$d['admin']['sysmail'];
	$sms_tel = $d['member']['join_tel']?$d['member']['join_tel']:$d['admin']['sms_tel'];
	$verify_code = date('His');

	getDbUpdate($table['s_mbrdata'],'tmpcode='.$verify_code,'memberuid='.$memberuid);

	if ($d['member']['join_email_send'] && $email_from) {
		include_once $g['path_core'].'function/email.func.php';
		$content = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
		$content .= implode('',file($g['dir_module'].'doc/email/_join.auth.txt'));
		$content.= '<p><a href="'.$g['url_root'].'/?r='.$r.'&m=member&a=email_auth&tmpuid='.$memberuid.'&tmpcode='.$verify_code.'" style="display:block;font-size:15px;color:#fff;text-decoration:none;padding: 15px;background:#007bff;width: 200px;text-align: center;margin: 38px auto;" target="_blank">회원가입 계속하기</a></p>';
		$content.= implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
		$content = str_replace('{EMAIL_MAIN}',$email_from,$content); //대표 이메일
		$content = str_replace('{TEL_MAIN}',$sms_tel,$content); // 대표 전화
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{NAME}',$name,$content);
		$content = str_replace('{NICK}',$nic,$content);
		$content = str_replace('{CODE}',$verify_code,$content);
		$content = str_replace('{ID}',$id,$content);
		$content = str_replace('{PHONE}',$phone,$content);
		$content = str_replace('{EMAIL}',$email,$content);
		$content = str_replace('{DATE}',getDateFormat($d_regis,'Y.m.d H:i'),$content);
		getSendMail($email.'|'.$name,$email_from.'|'.$_HS['name'], '['.$_HS['name'].'] 회원가입을 위한 본인인증 요청', $content, 'HTML');
	}

	if ($d['member']['join_sms_send'] && $sms_tel) {
		include_once $g['path_core'].'function/sms.func.php';
		$content = implode('',file($g['dir_module'].'doc/sms/_join.auth.txt'));  // SMS메시지 양식
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{NAME}',$name,$content);
		$content = str_replace('{PHONE}',$phone,$content);
		getSendSMS($phone,$sms_tel,'',$content,'sms');
	}

	getLink($modal?'reload':RW(0),'parent.','회원가입 인증메일이 발송되었습니다. 이메일('.$email.')확인 후 인증해 주세요.','');
}
?>
