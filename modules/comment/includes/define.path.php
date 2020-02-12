<?php
$g['dir_include']=$g['dir_module'].'includes/';

if($g['mobile']&&$_SESSION['pcmode']!='Y'){
    $d['ad']['skin']=$d['ad']['skin_mobile'];
    $d['ad']['layout']=$d['ad']['layout_mobile'];
}else{
    $d['ad']['skin']=$d['ad']['skin_main'];
    $d['ad']['layout']=$d['ad']['layout_main'];
}
// 모듈 theme 패스
$g['dir_module_skin'] = $g['dir_module'].'themes/'.$d['ad']['skin'].'/';
$g['url_module_skin'] = $g['url_module'].'/themes/'.$d['ad']['skin'];
$g['img_module_skin'] = $g['url_module_skin'].'/images';

// 레이아아웃 패스
$g['dir_layout'] = $g['path_layout'].$d['ad']['layout'].'/';
$g['url_layout'] = $g['s'].'/layouts/'.$d['ad']['layout'];
$g['img_layout'] = $g['url_layout'].'/_images';

// bsas.class.php skin class 에 필요
$CONF['theme_path']=$g['dir_module'].'themes';
$CONF['theme_name']=$d['ad']['skin'];

// class 인클루드
require_once $g['dir_include'].'base.class.php';
require_once $g['dir_include'].'module.class.php';
?>
