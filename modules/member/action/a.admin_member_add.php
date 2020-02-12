<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id			= trim($_POST['id']);
$pw			= trim($_POST['pw1']);
$name		= trim($_POST['name']);
$nic		= trim($_POST['nic']);
$nic		= $nic ? $nic : $name;
$email		= trim($_POST['email']);
$phone		= trim($_POST['phone']);

if (!$id || !$name) getLink('','','정상적인 접속이 아닙니다.','');

if (!$check_id || !$check_nic || !$check_email || !$check_phone)
{
	getLink('','','입력내용에 문제가 있습니다. 재입력해 주세요.','');
}

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];

//getLink('','',$realname.' 여기까지','');

if ($avatar_delete)
{
	$photo = '';
	$saveFile	= $g['path_var'].'avatar/'.$avatar;
}
else {
	$photo = $avatar;
	if (is_uploaded_file($tmpname))
	{
		$fileExt	= strtolower(getExt($realname));
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;

		if (strstr('[jpg,png,gif]',$fileExt))
		{
			$wh = getimagesize($tmpname);
			if ($wh[0] >= 250 && $wh[1] >= 250)
			{
				$photo		= $id.'.'.$fileExt;
				$saveFile	= $g['path_var'].'avatar/'.$photo;

				if (is_file($saveFile)) unlink($saveFile);

				include $g['path_core'].'function/thumb.func.php';

				move_uploaded_file($tmpname,$saveFile);
				ResizeWidth($saveFile,$saveFile,500);
				@chmod($saveFile,0707);
			}
		}
	}
}

if ($uid)
{
	$_M=getDbData($table['s_mbrdata'],'memberuid='.$uid,'*');
	if($pw!='')
	{
		$newPw = getCrypt($pw,$_M['d_regis']);
	    getDbUpdate($table['s_mbrid'],"pw='".$newPw."'",'uid='.$uid);
			getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."'",'memberuid='.$uid);

	    if ($my['uid'] == $uid)
	    {
		   $_SESSION['mbr_pw']  = $newPw;
	    }
	}

	$home		= $home ? (strstr($home,'http://')?str_replace('http://','',$home):$home) : '';
	$birth1		= $birth_1;
	$birth2		= $birth_2.$birth_3;
	$birthtype	= $birthtype ? $birthtype : 0;
	$tel		= $tel_1 && $tel_2 && $tel_3 ? $tel_1 .'-'. $tel_2 .'-'. $tel_3 : '';
	$location		= trim($location);
	$job		= trim($job);
	$marr1		= $marr_1 && $marr_2 && $marr_3 ? $marr_1 : 0;
	$marr2		= $marr_1 && $marr_2 && $marr_3 ? $marr_2.$marr_3 : 0;
	$sms		= $phone && $sms ? 1 : 0;
	$mailing	= $email && $remail ? 1 : 0;
	$bio		= trim($bio);
	$addfield	= '';

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

	$_QVAL = "email='$email',name='$name',nic='$nic',home='$home',sex='$sex',photo='$photo',birth1='$birth1',birth2='$birth2',birthtype='$birthtype',phone='$phone',tel='$tel',";
	$_QVAL.= "location='$location',job='$job',marr1='$marr1',marr2='$marr2',sms='$sms',mailing='$mailing',bio='$bio',addfield='$addfield'";
	getDbUpdate($table['s_mbrdata'],$_QVAL,'memberuid='.$uid);
	setrawcookie('result_member_main', rawurlencode('회원정보가 수정 되었습니다.|success'));  // 처리여부 cookie 저장
}
else {
	getDbInsert($table['s_mbrid'],'site,id,pw',"'$s','$id','".getCrypt($pw,$date['totime'])."'");
	$memberuid  = getDbCnt($table['s_mbrid'],'max(uid)','');

	$auth		= 1;
	$mygroup	= 1;
	$level		= 1;
	$comp		= 0;
	$adm_view	= $admin ? '[admin]' : '';
	$home		= '';
	$birth1		= 0;
	$birth2		= 0;
	$birthtype	= 0;
	$tel		= $tel && substr($tel,0,2) == '01' ? $tel : '';
	$zip		= '';
	$addr0		= '';
	$addr1		= '';
	$addr2		= '';
	$job		= '';
	$marr1		= 0;
	$marr2		= 0;
	$sms		= 1;
	$mailing	= 1;
	$smail		= 0;
	$point		= 0;
	$usepoint	= 0;
	$money		= 0;
	$cash		= 0;
	$num_login	= 1;
	$pw_q		= '';
	$pw_a		= '';
	$now_log	= 0;
	$last_log	= '';
	$last_pw	= $date['totime'];
	$is_paper	= 0;
	$cert_phone	= '';
	$cert_email	= '';
	$d_regis	= $date['totime'];
	$sns		= '';
	$noticeconf	= '';
	$num_notice	= 0;
	$addfield	= '';

	$_QKEY = "memberuid,site,auth,mygroup,level,comp,admin,adm_view,";
	$_QKEY.= "email,name,nic,grade,photo,cover,home,sex,birth1,birth2,birthtype,phone,tel,";
	$_QKEY.= "location,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,noticeconf,num_notice,addfield";
	$_QVAL = "'$memberuid','$s','$auth','$mygroup','$level','$comp','$admin','$adm_view',";
	$_QVAL.= "'$email','$name','$nic','','$photo','$cover','$home','$sex','$birth1','$birth2','$birthtype','$phone','$tel',";
	$_QVAL.= "'$location','$job','$marr1','$marr2','$sms','$mailing','$smail','$point','$usepoint','$money','$cash','$num_login','$now_log','$last_log','$last_pw','$is_paper','$d_regis','','$sns','$noticeconf','$num_notice','$addfield'";
	getDbInsert($table['s_mbrdata'],$_QKEY,$_QVAL);
	getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$level);
	getDbUpdate($table['s_mbrgroup'],'num=num+1','uid='.$mygroup);

	if ($email){
		getDbInsert($table['s_mbremail'],'mbruid,email,base,backup,d_regis,d_code,d_verified',"'".$memberuid."','".$email."',1,0,'".$d_regis."','',''");
	}
	if ($phone) {
		getDbInsert($table['s_mbrphone'],'mbruid,phone,base,backup,d_regis,d_code,d_verified',"'".$memberuid."','".$phone."',1,0,'".$d_regis."','',''");
	}

	setrawcookie('result_member_main', rawurlencode('회원이 추가 되었습니다.|success'));  // 처리여부 cookie 저장
}

getLink('reload','parent.','','');
?>
