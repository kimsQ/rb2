<?php
if(!defined('__KIMS__')) exit;

if (!$my['admin']) $mod = 'login';
if (!$mod) $mod = 'front';

$module = $module ? $module : 'admin';
$front  = $front  ? $front  : 'main';
$SD = getDbData($table['s_site'],"id='".$r."'",'*');
$MD = getDbData($table['s_module'],"id='".$module."'",'*');

if ($my['admin'] && !$my['super']) {
	if (!$my['adm_site']) getLink($g['s'].'/?r='.$r,'parent.','관리 사이트가 지정되지 않았습니다.','');
	$_siteArray = getArrayString($my['adm_site']);
	$_SD	= getUidData($table['s_site'],$_siteArray[data][0]);
	$r = $r?$r:$_SD['id'];
}

if (!$MD['id']) getLink($g['s'].'/?r='.$r.'&m=admin&module=admin','','등록되지 않는 모듈입니다.','');
if (!$my['admin']&&strpos('_'.$my['adm_view'],'['.$MD['id'].']')) getLink($g['s'].'/?r='.$r.'&m=site','','접근권한이 없습니다.','');
if ($my['uid']&&!$my['super']&&!strpos('_'.$my['adm_site'],'['.$SD['uid'].']')) getLink('','','접근권한이 없습니다.','-1');

$d['module']['skin']	= $d['admin']['themepc'];
$g['dir_module_skin']	= $g['dir_module'].'theme/'.$d['module']['skin'].'/';
$g['url_module_skin']	= $g['url_module'].'/theme/'.$d['module']['skin'];

$g['dir_module_admin']	= $g['path_module'].$module.'/admin/'.$front;
$g['url_module_admin']	= $g['s'].'/modules/'.$module.'/admin/'.$front;
$g['img_module_admin']	= $g['s'].'/modules/'.$module.'/admin/images';
$g['adm_module_varmenu']= $g['path_module'].$module.'/admin/var/var.menu.php';

$g['adm_module']		= $g['path_module'].$module.'/admin.php';
$g['img_module_skin']	= $g['url_module_skin'].'/images';
$g['dir_module_mode']	= $g['dir_module_skin'].$mod;
$g['url_module_mode']	= $g['url_module_skin'].'/'.$mod;
$g['adm_href']			= $g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;module='.$module.'&amp;front='.$front;
$g['adminlanguage']		= $MD['lang']?$MD['lang']:$d['admin']['syslang'];

$g['dir_module_comm']	= $g['path_module'].$module.'/admin/_main';
$g['url_module_comm']	= $g['s'].'/modules/'.$module.'/admin/_main';

include getLangFile($g['path_module'].$module.'/language/',$g['adminlanguage'],'/lang.admin.php');
include getLangFile($g['path_module'].$module.'/language/',$g['adminlanguage'],'/lang.admin-menu.php');

if (is_file($g['adm_module_varmenu']))
{
	$d['amenu'] = array();
	include $g['adm_module_varmenu'];
}

$g['main'] = $my['admin'] && $iframe == 'Y' ? $g['adm_module'] : $g['dir_module_mode'].'.php';
?>
