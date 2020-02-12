<?php
if(!defined('__KIMS__')) exit;

$g['memberVarForSite'] = $g['path_var'].'site/'.$_HS['id'].'/member.var.php'; // 사이트 회원모듈 변수파일
$_varfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['dir_module'].'var/var.php';
include_once $_varfile; // 변수파일 인클루드

$_mod	= $_GET['mod'];
$front	= $front? $front: 'login';
$page	= $page ? $page : 'main';

// 모바일/데스크탑 분기
if ($g['mobile'] && $_SESSION['pcmode'] != 'Y') {
	$_front = '_mobile/'.$front;
} else {
	$_front = '_desktop/'.$front;
}

switch ($front) {
	case 'join' :

		$d['member']['sosokmenu'] = $d['member']['sosokmenu_join'];

		if (!$d['member']['join_enable']) {
			getLink('','','죄송합니다. 지금은 회원가입을 하실 수 없습니다.','-1');
		}

		if ($my['uid']){
			getLink(RW(0),'','','');
		}

		$page = $page=='main' ? 'main' : $page;
		if (!$d['member']['form_agree']) $page = $page == 'agree' ? 'agree' : $page;
		if ($token) $page = 'auth_email';
	break;

	case 'login' :

		if ($is_socialUserinfoSession) $page = 'combine';
		$d['member']['sosokmenu'] = $d['member']['sosokmenu_login'];

		if ($page !='password_reset' && $my['uid']){
			getLink(RW(0),'','','');
		}
	break;

	case 'profile' :

		$d['member']['sosokmenu'] = $d['member']['sosokmenu_profile'];

		$_MP = array();
		if ($mbrid){

			$_MP = getDbData($table['s_mbrid'],"id='".$mbrid."'",'*');
			if ($_MP['uid']) {
				$_IS_PROFILEOWN= $my['uid']==$_MP['uid'];
				$_MP = array_merge(getDbData($table['s_mbrdata'],"memberuid='".$_MP['uid']."'",'*'),$_MP);
			} else {
				$page = '_404';
			}
		}


	break;

	case 'settings' :
		$d['member']['sosokmenu'] = $d['member']['sosokmenu_settings'];
		if (!$my['uid']) getLink(RW(0),'','','');
	break;

	case 'dashboard' :
		if (!$my['uid']) getLink('/','','','');
	break;

	case 'saved' :
		$d['member']['sosokmenu'] = $d['member']['sosokmenu_saved'];
		if (!$my['uid']){
			getLink($g['s'].'/?r='.$r.'&mod=login&referer='.urlencode(RW('mod=saved')),'','','');
		}
	break;

	case 'noti' :
		$d['member']['sosokmenu'] = $d['member']['sosokmenu_noti'];
		if (!$my['uid']){
			getLink($g['s'].'/?r='.$r.'&mod=login&referer='.urlencode(RW('mod=noti')),'','','');
		}
	break;

}

$g['url_reset']	 = $g['s'].'/?r='.$r.'&amp;'.($_mod ? 'mod='.$_mod : 'm='.$m.'&amp;front='.$front).($iframe?'&amp;iframe='.$iframe:'');
$g['url_page']	 = $g['url_reset'].'&amp;page='.$page;
$g['url_action'] = $g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;a=';

if ($d['member']['theme_mobile'] && $g['mobile'] && $_SESSION['pcmode'] != 'Y' ) {
	$g['dir_module_skin'] = $g['dir_module'].'themes/'.$d['member']['theme_mobile'].'/'.$front.'/';
	$g['url_module_skin'] = $g['url_module'].'/themes/'.$d['member']['theme_mobile'].'/'.$front;
} else {
	$g['dir_module_skin'] = $g['dir_module'].'themes/'.$d['member']['theme_main'].'/'.$front.'/';
	$g['url_module_skin'] = $g['url_module'].'/themes/'.$d['member']['theme_main'].'/'.$front;
}

$g['img_module_skin'] = $g['url_module_skin'].'/image';

$g['dir_module_mode'] = $g['dir_module_skin'].$page;
$g['url_module_mode'] = $g['url_module_skin'].'/'.$page;

if($d['member']['sosokmenu'])
{
	$c=substr($d['member']['sosokmenu'],-1)=='/'?str_replace('/','',$d['member']['sosokmenu']):$d['member']['sosokmenu'];
	$_CA = explode('/',$c);
	$_FHM = getDbData($table['s_menu'],"id='".$_CA[0]."' and site=".$s,'*');

	$_tmp['count'] = count($_CA);
	$_tmp['split_id'] = '';
	for ($_i = 0; $_i < $_tmp['count']; $_i++)
	{
		$_tmp['location'] = getDbData($table['s_menu'],"id='".$_CA[$_i]."'",'*');
		$_tmp['split_id'].= ($_i?'/':'').$_tmp['location']['id'];
		$g['location']   .= ' &gt; <a href="'.RW('c='.$_tmp['split_id']).'">'.$_tmp['location']['name'].'</a>';
		$_HM['uid'] = $_tmp['location']['uid'];
		$_HM['name'] = $_tmp['location']['name'];
		$_HM['addinfo'] = $_tmp['location']['addinfo'];
	}
}

$g['main'] = $g['dir_module_mode'].'.php';
?>
