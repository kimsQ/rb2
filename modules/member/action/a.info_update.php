<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if ($act == 'info')  // 프로필 정보 변경
{

	$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
	$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
	include_once $_tmpvfile;

	$memberuid	= $my['admin'] && $memberuid ? $memberuid : $my['uid'];
	$name		= trim($name);
	$nic		= trim($nic);
	$nic		= $nic ? $nic : $name;

	if (($d['member']['form_nic'] && !$check_nic) || !$check_email)
	{
		getLink('','','정상적인 접근이 아닙니다.','');
	}
	if(getDbRows($table['s_mbrdata'],"memberuid<>".$memberuid." and email='".$email."'"))
	{
		getLink('','','이미 존재하는 이메일입니다.','');
	}
	if($d['member']['form_nic'])
	{
		if(!$my['admin'])
		{
			if(strstr(','.$d['member']['join_cutnic'].',',','.$nic.',') || getDbRows($table['s_mbrdata'],"memberuid<>".$memberuid." and nic='".$nic."'"))
			{
				getLink('','','이미 존재하는 닉네임입니다.','');
			}
		}
	}

	$home		= $home ? (strstr($home,'http://')?str_replace('http://','',$home):$home) : '';
	$birth1		= $birth_1;
	$birth2		= $birth_2.$birth_3;
	$birthtype	= $birthtype ? $birthtype : 0;
	$tel1		= $tel1_1 && $tel1_2 && $tel1_3 ? $tel1_1 .'-'. $tel1_2 .'-'. $tel1_3 : '';
	$tel2		= $tel2_1 && $tel2_2 && $tel2_3 ? $tel2_1 .'-'. $tel2_2 .'-'. $tel2_3 : '';

	if(!$overseas)
	{
		$addrx		= explode(' ',$addr1);
		$addr0		= $addr1 && $addr2 ? $addrx[0] : '';
		$addr1		= $addr1 && $addr2 ? $addr1 : '';
		$addr2		= trim($addr2);
	}
	else {
		$zip		= '';
		$addr0		= '해외';
		$addr1		= '';
		$addr2		= '';
	}

	$job		= trim($job);
	$marr1		= $marr_1 && $marr_2 && $marr_3 ? $marr_1 : 0;
	$marr2		= $marr_1 && $marr_2 && $marr_3 ? $marr_2.$marr_3 : 0;
	$sms		= $tel2 && $sms ? 1 : 0;
	$mailing	= $remail;
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

	$_QVAL = "email='$email',name='$name',nic='$nic',home='$home',sex='$sex',birth1='$birth1',birth2='$birth2',birthtype='$birthtype',phone='$phone',tel='$tel',";
	$_QVAL.= "location='$location',job='$job',marr1='$marr1',marr2='$marr2',sms='$sms',mailing='$mailing',bio='$bio',addfield='$addfield'";
	getDbUpdate($table['s_mbrdata'],$_QVAL,'memberuid='.$memberuid);

	if ($send_mod == 'ajax') {

		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "변경 되었습니다."},{type: "default"});';
		echo '</script>';

		exit;

	} else {
		setrawcookie('member_settings_result', rawurlencode('개인정보가 변경 되었습니다.|success'));  // 처리여부 cookie 저장
		getLink('reload','parent.','','');
	}
}


if ($act == 'pw')  // 비밀번호 변경
{

	if (!$pw || !$pw1 || !$pw2)
	{
		getLink('','','정상적인 접근이 아닙니다.','');
	}

	if (getCrypt($pw,$my['d_regis']) != $my['pw'] && $my['tmpcode'] != getCrypt($pw,$my['d_regis']))
	{
		getLink('reload','parent.','현재 비밀번호가 일치하지 않습니다.','');
	}

	if ($pw == $pw1)
	{
		getLink('reload','parent.','현재 비밀번호와 변경할 비밀번호가 같습니다.','');
	}

	getDbUpdate($table['s_mbrid'],"pw='".getCrypt($pw1,$my['d_regis'])."'",'uid='.$my['uid']);
	getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."',tmpcode=''",'memberuid='.$my['uid']);

	$_SESSION['mbr_pw']  = getCrypt($pw1,$my['d_regis']);

	getLink('reload','parent.','비밀번호가 변경되었습니다.','');

}

?>
