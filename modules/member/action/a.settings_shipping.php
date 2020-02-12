<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

$mbruid =  $my['uid'];
$last_log	= $date['totime'];

if ($act=='get_data') {

	$R = getUidData($table['s_mbrshipping'],$uid);

	$result=array();
	$result['error']=false;

	$result['label'] = $R['label'];
	$result['name'] = $R['name'];
	$result['zip'] = $R['zip'];
	$result['addr1'] = $R['addr1'];
	$result['addr2'] = $R['addr2'];
	$result['tel1'] = $R['tel1'];
	$result['tel2'] = $R['tel2'];
	$result['base'] = $R['base'];

	echo json_encode($result);
	exit;

}


$addrx		= explode(' ',$addr1);
$addr0		= $addr1 && $addr2 ? $addrx[0] : '';
$addr1		= $addr1 && $addr2 ? $addr1 : '';
$addr2		= trim($addr2);

$tel1		= $tel1_1 && $tel1_2 && $tel1_3 ? $tel1_1 .'-'. $tel1_2 .'-'. $tel1_3 : '';
$tel2		= $tel2_1 && $tel2_2 && $tel2_3 ? $tel2_1 .'-'. $tel2_2 .'-'. $tel2_3 : '';

if ($base) { // 기본배송지가 지정된 경우
	getDbUpdate($table['s_mbrshipping'],'base=0','mbruid='.$my['uid']);  // 내배송지의 기본배송지 정보를 초기화
}

//배송지 수정
if ($act=='edit') {

	$_QVAL = "label='$label',name='$name',tel1='$tel1',tel2='$tel2',zip='$zip',addr0='$addr0',addr1='$addr1',addr2='$addr2',base='$base',last_log='$last_log'";
	getDbUpdate($table['s_mbrshipping'],$_QVAL,'mbruid='.$mbruid.' and uid='.$uid);
	setrawcookie('member_settings_result', rawurlencode('배송지가 저장 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}

//배송지 추가
if ($act=='add') {
	$_QKEY = "mbruid,label,name,tel1,tel2,zip,addr0,addr1,addr2,base,last_log";
	$_QVAL = "'$mbruid','$label','$name','$tel1','$tel2','$zip','$addr0','$addr1','$addr2','$base','$last_log'";
	getDbInsert($table['s_mbrshipping'],$_QKEY,$_QVAL);
	setrawcookie('member_settings_result', rawurlencode('배송지가 추가 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}

//배송지 삭제
if ($act=='del') {
	if (!$uid) getLink('','','정상적인 접근이 아닙니다.','');
	getDbDelete($table['s_mbrshipping'],'uid='.$uid.' and mbruid='.$my['uid']);
	setrawcookie('member_settings_result', rawurlencode('배송지가 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}

?>
