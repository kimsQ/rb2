<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id			= trim($_POST['id']);
$pw			= trim($_POST['pw1']);
$name		= trim($_POST['name']);
$nic		= trim($_POST['nic']);
$nic		= $nic ? $nic : $name;
$email		= trim($_POST['email']);

if (!$id || !$name) getLink('','','정말로 실행하시겠습니까?','');
if (!$check_id || !$check_nic || !$check_email)
{
	getLink('','','정말로 실행하시겠습니까?','');
}

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];

if ($avatar_delete)
{
	$photo = '';
	$saveFile1	= $g['path_var'].'avatar/'.$avatar;
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
			if ($wh[0] > 250 && $wh[1] > 250)
			{
				$photo		= $id.'.'.$fileExt;
				$saveFile1	= $g['path_var'].'avatar/'.$photo;

				if (is_file($saveFile1)) unlink($saveFile1);

				include $g['path_core'].'function/thumb.func.php';

				move_uploaded_file($tmpname,$saveFile1);
				ResizeWidth($saveFile1,$saveFile1,600);
				@chmod($saveFile1,0707);
			}
		}
	}
}

if ($uid)
{
	$_M = getDbData($table['s_mbrdata'],'memberuid='.$uid,'d_regis');
	if($pw!='')
	{
		$newPw = password_hash($pw, PASSWORD_DEFAULT);
	    getDbUpdate($table['s_mbrid'],"pw='".$newPw."'",'uid='.$uid);

	    if ($my['uid'] == $uid)
	    {
		   $_SESSION['mbr_pw']  = $newPw;
	    }
	}
	getDbUpdate($table['s_mbrdata'],"super='$super',email='$email',name='$name',nic='$nic',photo='$photo',phone='$phone'",'memberuid='.$uid);
	setrawcookie('admin_admin_result', rawurlencode('수정 되었습니다.|success'));  // 처리여부 cookie 저장
}
else {
	getDbInsert($table['s_mbrid'],'site,id,pw',"'$s','$id','".password_hash($pw, PASSWORD_DEFAULT)."'");
	$memberuid  = getDbCnt($table['s_mbrid'],'max(uid)','');

	$auth		= 1;
	$mygroup	= 1;
	$level		= 1;
	$comp		= 0;
	$adm_view	= $admin ? '[admin]' : '';
	$adm_site		= '';
	$home		= '';
	$birth1		= 0;
	$birth2		= 0;
	$birthtype	= 0;
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
	$bio	= '';
	$now_log	= 0;
	$last_log	= '';
	$last_pw	= $date['totime'];
	$is_paper	= 0;
	$d_regis	= $date['totime'];
	$sns		= '';
	$noticeconf	= '';
	$num_notice	= 0;
	$addfield	= '';

	$_QKEY = "memberuid,site,auth,mygroup,level,comp,super,admin,adm_view,adm_site,";
	$_QKEY.= "email,name,nic,grade,photo,home,sex,birth1,birth2,birthtype,phone,tel,";
	$_QKEY.= "job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,bio,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,noticeconf,num_notice,addfield";
	$_QVAL = "'$memberuid','$s','$auth','$mygroup','$level','$comp','$super','$admin','$adm_view','$adm_site',";
	$_QVAL.= "'$email','$name','$nic','','$photo','$home','$sex','$birth1','$birth2','$birthtype','$phone','$tel',";
	$_QVAL.= "'$job','$marr1','$marr2','$sms','$mailing','$smail','$point','$usepoint','$money','$cash','$num_login','$bio','$now_log','$last_log','$last_pw','$is_paper','$d_regis','','$sns','$noticeconf','$num_notice','$addfield'";
	getDbInsert($table['s_mbrdata'],$_QKEY,$_QVAL);
	getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$level);
	getDbUpdate($table['s_mbrgroup'],'num=num+1','uid='.$mygroup);

	if ($email){
		getDbInsert($table['s_mbremail'],'mbruid,email,base,backup,d_regis,d_code,d_verified',"'".$memberuid."','".$email."',1,0,'".$d_regis."','',''");
	}
	if ($phone) {
		getDbInsert($table['s_mbrphone'],'mbruid,phone,base,backup,d_regis,d_code,d_verified',"'".$memberuid."','".$phone."',1,0,'".$d_regis."','',''");
	}

	setrawcookie('admin_admin_result', rawurlencode($name.'님이 추가 되었습니다.|success'));  // 처리여부 cookie 저장
}
getLink('reload','parent.','','');
?>
