<?php
if(!defined('__KIMS__')) exit;

$d['member']['join_enable'] = "1";
$d['member']['join_mobile'] = "1";
$d['member']['join_out'] = "2";
$d['member']['join_rejoin'] = "0";
$d['member']['join_auth'] = "1";
$d['member']['join_level'] = "1";
$d['member']['join_group'] = "1";
$d['member']['join_point'] = "0";

$name =$_POST['name'];
$id =$_POST['id'];
$pw =$_POST['pw'];
$nic =$_POST['nic'];
$email =$_POST['email'];
$sosok =$_POST['sosok'];
$admin =$_POST['admin'];

for($i=0;$i<count($id);$i++)
{
	getDbInsert($table['s_mbrid'],'site,id,pw',"'$s','$id[$i]','".password_hash($pw[$i], PASSWORD_DEFAULT)."'");
	$memberuid  = getDbCnt($table['s_mbrid'],'max(uid)','');
	$auth		= $d['member']['join_auth'];
	$sosok		= $sosok?$sosok:$d['member']['join_group'];
	$level		= $d['member']['join_level'];
	$comp		= '1';
	$admin		= $admin;
	$name		= $name;
	$photo		= '';
	$home		= $home ? (strstr($home,'http://')?str_replace('http://','',$home):$home) : '';
	$birth1		= $birth_1;
	$birth2		= $birth_2.$birth_3;
	$birthtype	= $birthtype ? $birthtype : 0;

	if(!$foreign)
	{
		$zip		= $comp_zip_1.$comp_zip_2;
		$addrx		= explode(' ',$comp_addr1);
		$addr0		= $comp_addr1 && $comp_addr2 ? substr($comp_addr1,0,6) : '';
		$addr1		= $comp_addr1 && $comp_addr2 ? $comp_addr1 : '';
		$addr2		= trim($comp_addr2);
	}
	else {
		$zip		= '';
		$addr0		= '해외';
		$addr1		= '';
		$addr2		= '';
	}
	$job		= trim($job);
	$smail		= 0;
	$point		= $d['member']['join_point'];
	$usepoint	= 0;
	$money		= 0;
	$cash		= 0;
	$num_login	= 1;
	$now_log	= 1;
	$last_log	= $date['totime'];
	$last_pw	= $date['totime'];
	$is_paper	= 0;
	$d_regis	= $date['totime'];
	$sns		= $sns_0.'|'.$sns_1.'|'.$sns_2.'|'.$sns_3.'|'.$sns_4.'|'.$sns_5.'|'.$sns_6.'|'.$sns_7.'|'.$sns_8.'|'.$sns_9.'|';
	$addfield	= '';



	$_QKEY = "memberuid,site,auth,sosok,level,comp,admin,adm_view,";
	$_QKEY.= "email,name,nic,grade,photo,home,sex,birth1,birth2,birthtype,phone,tel,zip,";
	$_QKEY.= "addr0,addr1,addr2,job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,pw_q,pw_a,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,addfield";
	$_QVAL = "'$memberuid','$s','$auth','$sosok[$i]','$level','$comp','$admin[$i]','',";
	$_QVAL.= "'$email[$i]','$name[$i]','$nic[$i]','','$photo','$home','$sex','$birth1','$birth2','$birthtype','$phone','$tel','$zip',";
	$_QVAL.= "'$addr0','$addr1','$addr2','$job','$marr1','$marr2','$sms','$mailing','$smail','$point','$usepoint','$money','$cash','$num_login','$pw_q','$pw_a','$now_log','$last_log','$last_pw','$is_paper','$d_regis','','$sns','$addfield'";
	getDbInsert($table['s_mbrdata'],$_QKEY,$_QVAL);
	getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$level);
	getDbUpdate($table['s_mbrgroup'],'num=num+1','uid='.$sosok);
	getDbUpdate($table['s_numinfo'],'login=login+1,mbrjoin=mbrjoin+1',"date='".$date['today']."' and site=".$s);


	if ($comp)
	{
		$comp_num	= $comp_num_1 && $comp_num_2 && $comp_num_3 ? $comp_num_1.$comp_num_2.$comp_num_3 : 0;
		//$comp_type	= $comp_type;
		$comp_name	= trim($comp_name);
		$comp_ceo	= trim($comp_ceo);
		$comp_upte	= trim($comp_upte);
		$comp_jongmok = trim($comp_jongmok);
		$comp_tel	= $comp_tel_1 && $comp_tel_2 ? $comp_tel_1 .'-'. $comp_tel_2 .($comp_tel_3 ? '-'.$comp_tel_3 : '') : '';
		$comp_fax	= $comp_fax_1 && $comp_fax_2 && $comp_fax_3 ? $comp_fax_1 .'-'. $comp_fax_2 .'-'. $comp_fax_3 : '';
		$comp_zip	= $comp_zip_1.$comp_zip_2;
		$comp_addr0	= $comp_addr1 && $comp_addr2 ? substr($comp_addr1,0,6) : '';
		$comp_addr1	= $comp_addr1 && $comp_addr2 ? $comp_addr1 : '';
		$comp_addr2	= trim($comp_addr2);
		$comp_part	= trim($comp_part);
		$comp_level	= trim($comp_level);

		$_QKEY = "memberuid,comp_num,comp_type,comp_name,comp_ceo,comp_upte,comp_jongmok,";
		$_QKEY.= "comp_tel,comp_fax,comp_zip,comp_addr0,comp_addr1,comp_addr2,comp_part,comp_level";
		$_QVAL = "'$memberuid','$comp_num','$comp_type','$comp_name','$comp_ceo','$comp_upte','$comp_jongmok',";
		$_QVAL.= "'$comp_tel','$comp_fax','$comp_zip','$comp_addr0','$comp_addr1','$comp_addr2','$comp_part','$comp_level'";
		getDbInsert($table['s_mbrcomp'],$_QKEY,$_QVAL);
	}
	if ($point)
	{
		getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'$memberuid','0','$point','".$d['member']['join_pointmsg']."','$d_regis'");
	}

}// for 문

getLink('reload','parent.','회원등록이 정상 처리되었습니다.','');


?>
