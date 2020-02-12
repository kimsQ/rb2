<?php
if(!defined('__KIMS__')) exit;

$g['searchVarForSite'] = $g['path_var'].'site/'.$r.'/search.var.php';
$_tmpdfile = file_exists($g['searchVarForSite']) ? $g['searchVarForSite'] : $g['dir_module'].'var/var.search.php';
include_once $_tmpdfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y'){
	include_once $g['dir_module'].'var/var.order.mobile.php';
}else{
	include_once $g['dir_module'].'var/var.order.desktop.php';
}

$swhere	= $swhere ? $swhere : 'all';
$_ResultArray = array();
$_HM['layout'] = $d['search']['layout'];

if ($g['mobile']&&$_SESSION['pcmode']!='Y')
{
	$_HM['m_layout'] = $d['search']['m_layout'] ?$d['search']['m_layout'] : $d['search']['layout'];
	$d['search']['theme'] = $d['search']['m_theme'] ? $d['search']['m_theme'] : $d['search']['theme'];
}

$g['dir_module_skin'] = $g['dir_module'].'/themes/'.$d['search']['theme'].'/';
$g['url_module_skin'] = $g['url_module'].'/themes/'.$d['search']['theme'];
$g['img_module_skin'] = $g['url_module_skin'].'/images';

$g['dir_module_mode'] = $g['dir_module_skin'].'main';
$g['url_module_mode'] = $g['url_module_skin'].'/main';

$g['url_reset']	= $_HS['rewrite']? RW('m=search'):$g['s'].'/?r='.$r.'&amp;m='.$m;
$g['url_where']	= $g['url_reset'].($q?($_HS['rewrite']?'?':'&amp;').'q='.urlencode($q):'').($sort?'&amp;sort='.$sort:'').($orderby?'&amp;sort='.$orderby:'').'&amp;swhere=';

$g['push_location'] = '<li class="active">'.$_HMD['name'].'</li>';

$g['main'] = $g['dir_module_mode'].'.php';
?>
