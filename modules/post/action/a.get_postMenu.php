<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
require_once $g['dir_module'].'lib/base.class.php';
require_once $g['dir_module'].'lib/module.class.php';

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

$d['post']['writeperm'] = true;

if (!$my['admin']) {
	if ($d['post']['perm_l_write'] > $my['level'] || strpos('_'.$d['post']['perm_g_write'],'['.$my['mygroup'].']') || !$my['uid']) {
	  $d['post']['writeperm'] = false;
	}
}

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

$_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$uid.' and level=1');
$_perm['post_owner'] = $my['admin'] || $_IS_POSTOWN  ? true : false;

$post = new Post();
$post->theme_name = $theme;

$result=array();
$result['error'] = false;

$R = getUidData($table[$m.'data'],$uid);
$TMPL['uid'] = $R['uid'];
$TMPL['cid'] = $R['cid'];

$list='';
$list = $post->getHtml('post-menu');

if ($d['post']['writeperm']) {
  $list .= $_perm['post_owner']?$post->getHtml('post-menu-owner'):'';
}

$result['subject'] = stripslashes($R['subject']);
$result['featured'] = $g['url_host'].getPreviewResize(getUpImageSrc($R),'640x360');
$result['review'] = $R['review'];
$result['link'] = $g['url_host'].getPostLink($R,0);
$result['likes'] = $R['likes']?$R['likes']:'';
$result['owner'] = $_perm['post_owner']?1:0;
$result['list'] = $list;
$result['num'] = $i;
$result['cid'] = $R['cid'];

echo json_encode($result);
exit;
?>
