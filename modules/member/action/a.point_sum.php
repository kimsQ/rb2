<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$memberuid = 0;
$price = 0;

if ($my['admin'])
{
	foreach($members as $val)
	{
		$P = getUidData($table['s_'.$pointType],$val);
		$price = $price + $P['price'];
		$memberuid = $P['my_mbruid'];

		getDbDelete($table['s_'.$pointType],'uid='.$P['uid']);
	}

	getDbInsert($table['s_'.$pointType],'my_mbruid,by_mbruid,price,content,d_regis',"'".$memberuid."','0','$price','내역을 정리하였습니다.','".$date['totime']."'");

}
else {
	foreach($members as $val)
	{
		$P = getUidData($table['s_'.$pointType],$val);
		$price = $price + $P['price'];

		getDbDelete($table['s_'.$pointType],'uid='.$P['uid'].' and my_mbruid='.$my['uid']);
	}

	getDbInsert($table['s_'.$pointType],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','$price','내역을 정리하였습니다.','".$date['totime']."'");

}

setrawcookie('member_point_result', rawurlencode($pointType.'내역을 정리하였습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
