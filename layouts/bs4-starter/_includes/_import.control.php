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

if ($layoutPage) {
  $g['main'] = $g['path_layout'].$d['site_layout'].'/_pages/'.$layoutPage.'.php';
}
?>
