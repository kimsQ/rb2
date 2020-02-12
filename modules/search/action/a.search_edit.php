<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$namefile || strstr($namefile,'/')) exit;
$_newsites = '';
foreach($aply_sites as $sites) $_newsites.= '['.$sites.']';
$_nameinfo = str_replace('|','/',trim($name)).'|'.$_newsites;
$device = $mobile?'mobile.':'desktop.';
$_namefile = $g['dir_module'].'var/names/'.$device.$namefile.'.txt';

$fp = fopen($_namefile,'w');
fwrite($fp,$_nameinfo);
fclose($fp);
@chmod($_namefile,0707);

setrawcookie('search_config_result', rawurlencode('반영 되었습니다.|success'));  // 처리여부 cookie 저장
getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&searchfile='.$searchfile.'&autoCheck=Y&mobile='.$mobile,'parent.','','');
?>
