<?php
header("Content-type:text/html;charset=utf-8");
define('__KIMS__',true);
session_start();

if(!get_magic_quotes_gpc())
{
	if (is_array($_GET))
		foreach($_GET as $_tmp['k'] => $_tmp['v'])
			if (is_array($_GET[$_tmp['k']]))
				foreach($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1'])
					$_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_GET[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
	if (is_array($_POST))
		foreach($_POST as $_tmp['k'] => $_tmp['v'])
			if (is_array($_POST[$_tmp['k']]))
				foreach($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1'])
					$_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_POST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
}
else {
	if (!ini_get('register_globals'))
	{
		extract($_GET);
		extract($_POST);
	}
}

$d = array();
$g = array(
	'path_root'   => './',
	'path_core'   => './_core/',
	'path_var'    => './_var/',
	'path_tmp'    => './_tmp/',
	'path_layout' => './layouts/',
	'path_module' => './modules/',
	'path_widget' => './widgets/',
	'path_switch' => './switches/',
	'path_plugin' => './plugins/',
	'path_page'   => './pages/',
	'path_file'   => './files/'
);

$g['time_split'] = explode(' ',microtime());
$g['time_start'] = $g['time_split'][0]+$g['time_split'][1];
$g['time_srnad'] = $g['time_split'][1].substr($g['time_split'][0],2,6);

if (!is_file($g['path_var'].'db.info.php'))
{
	include $g['path_root'].'/_install/'.($install?$install:'main').'.php';
	exit;
}

require $g['path_var'].'db.info.php';
require $g['path_var'].'table.info.php';
require $g['path_var'].'switch.var.php';
require $g['path_var'].'plugin.var.php';
require $g['path_module'].'admin/var/var.version.php';
$g['sysvar'] = $g['path_var'].'/system.var.php';
require file_exists($g['sysvar']) ? $g['sysvar'] : $g['path_module'].'admin/var/var.system.php';

$g['url_file'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
$g['url_http'] = $g['url_host'].($d['admin']['http_port']&&$d['admin']['http_port']!=80?':'.$d['admin']['http_port']:'');
$g['url_sslp'] = 'https://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTPS']!='on'&&$d['admin']['ssl_port']?':'.$d['admin']['ssl_port']:'');
$g['url_root'] = $g['url_http'].$g['url_file'];
$g['ssl_root'] = $g['url_sslp'].$g['url_file'];

require $g['path_core'].'function/db.mysql.func.php';
require $g['path_core'].'function/sys.func.php';
foreach(getSwitchInc('start') as $_switch) include $_switch;
require $g['path_core'].'engine/main.engine.php';

if ($keyword)
{
	$keyword = trim($keyword);
	$_keyword= stripslashes(htmlspecialchars($keyword));
}
if (!$p) $p = 1;
if (!is_dir($g['path_module'].$m)) $m = $g['sys_module'];
$g['dir_module'] = $g['path_module'].$m.'/';
$g['url_module'] = $g['s'].'/modules/'.$m;

$g['url_var'] = $g['s'].'/_var';
$g['dir_var_site'] = $g['path_var'].'site/'.$r.'/';
$g['url_var_site'] = $g['s'].'/_var/site/'.$r;

if ($a) require $g['path_core'].'engine/action.engine.php';
if ($_HS['open'] > 1) require $g['path_core'].'engine/siteopen.engine.php';
if (!$s && $m != 'admin') getLink($g['s'].'/?m=admin&module='.$g['sys_module'].'&nosite=Y','','','');

$g['location']	= getLocation(0);
$g['browtitle'] = getPageTitile();

if($modal) $g['main'] = $g['path_module'].$modal.'.php';
else include $g['dir_module'].'main.php';

if ($m=='admin' || $iframe=='Y') $d['layout']['php'] = $_HM['layout'] = '_blank/default.php';
else {
	if (!$g['mobile']||$_SESSION['pcmode']=='Y') $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']);
	else $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HM['m_layout'] ? $_HM['m_layout'] : ($_HS['m_layout'] ? $_HS['m_layout'] : $_HS['layout']));
}

$d['layout']['dir'] = dirname($d['layout']['php']);
$g['dir_layout'] = $g['path_layout'].$d['layout']['dir'].'/';
$g['url_layout'] = $g['s'].'/layouts/'.$d['layout']['dir'];
$g['img_layout'] = $g['url_layout'].'/_images';

define('__KIMS_CONTENT__',$g['path_core'].'engine/content.engine.php');

if($my['admin'] && (!$_SERVER['HTTP_REFERER'] || $panel=='Y') && $panel!='N' && !$iframe && (!is_file($g['dir_layout'].'_var/nopanel.txt') || $important=='panel'))
{
	include $g['path_core'].'engine/adminpanel.engine.php';
}
else
{
	foreach($g['switch_1'] as $_switch) include $_switch;

	if ($m!='admin')
	{
		include $g['path_var'].'sitephp/'.$_HS['uid'].'.php';
		if($_HS['buffer'])
		{
			$g['buffer']=true;
			ob_start('ob_gzhandler');
		}
	}

	if (!is_dir('./layouts/'.$d['layout']['dir'])) {
		echo './layouts/'.$d['layout']['dir'].' 레이아웃이 존재하지 않습니다.';
		exit();
	}
	if (!file_exists($g['path_layout'].$d['layout']['php'])) {
		echo $g['path_layout'].$d['layout']['php'].' 파일이 존재하지 않습니다.';
		exit();
	}

	@include './layouts/'.$d['layout']['dir'].'/_includes/_import.control.php';
	@include $g['path_layout'].$d['layout']['php'];
	foreach($g['switch_4'] as $_switch) include $_switch;
	echo "\n".'<!-- KimsQ Rb v.'.$d['admin']['version'].' / Runtime : '.round(getCurrentDate()-$g['time_start'],3).' -->';
	if($g['buffer']) ob_end_flush();
}
db_close($DB_CONNECT);
?>
