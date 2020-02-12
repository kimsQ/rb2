<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_HS = getDbData($table['s_site'],"id='".$r."'",'*');

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$layout = dirname($_HS['m_layout']);
	$noti_type = 'default';
} else {
  $layout = dirname($_HS['layout']);
	$noti_type = 'success';
}

//사이트별 레이아웃 메인화면 위젯
$g['layoutPageVarForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.'.$page.'.php';
@unlink($g['layoutPageVarForSite'] );

$result=array();
$result['error'] = false;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {

	include $g['path_layout'].$layout.'/_var/_var.'.$page.'.php';
	$result['list'] = getWidgetListEdit($d['layout'][$area]);

} else {

	setrawcookie('site_common_result', rawurlencode('구성이 초기화 되었습니다|'.$noti_type.''));  // 처리여부 cookie 저장

}

echo json_encode($result);
exit;

?>
