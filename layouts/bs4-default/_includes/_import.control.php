<?php
//사이트별 레이아웃 설정 변수
$layout = dirname($_HS['layout']);
$g['layoutVarForSite'] = $g['dir_var_site'].'layout.'.$layout.'.var.php';
include is_file($g['layoutVarForSite']) ? $g['layoutVarForSite'] : $g['dir_layout'].'_var/_var.php';

//사이트 부가정보 변수
$g['siteinfo'] = $g['dir_var_site'].'siteinfo.php';
if (is_file($g['siteinfo'])) include $g['siteinfo'];

//사이트별 웹앱 매니페스트
$g['manifestForSite'] = $g['dir_var_site'].'manifest.json';
$g['url_manifest'] = $g['url_var_site'].'/manifest.json';
$manifestForSite = file_exists($g['manifestForSite']) ? $g['url_manifest'] : $g['path_module'].'site/var/manifest.json';

// 레이아웃 내장 메인페이지에 home 레이아웃 적용
if (strstr($g['main'],$g['dir_layout']) && !$prelayout && !$layoutPage) {
	$d['layout']['php'] = $d['layout']['dir'].'/home.php';
}

if (isset($layoutPage)){
  $g['dir_module_mode'] = $g['dir_layout'].'/_pages/'.$layoutPage;
	$g['url_module_mode'] = $g['url_layout'].'/_pages/'.$layoutPage;
	$g['main'] = $g['dir_layout'].'/_pages/'.$layoutPage.'.php';
}

function getLayoutLogo($layout) {
	if ($layout['header_logo']) {
		return '<a class="navbar-brand p-0" href="'.RW(0).'" style="background-image:url('.$GLOBALS['g']['url_var_site'].'/'.$layout['header_logo'].$GLOBALS['g']['wcache'].');background-size:'.$layout['header_logo_size'].'%;background-position:'.$layout['header_logo_position'].'% 50%"></a>';
	} else {
		return '<a class="navbar-brand p-0" href="'.RW(0).'">'.$layout['header_title'].'</a>';
	}
}

?>
