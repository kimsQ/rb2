<?php
if(!defined('__KIMS__')) exit;

$d['bbs']['skin'] = $d['bbs']['skin_total'];
$d['bbs']['isperm'] = true;

if($uid)
{
	$R = $R['uid'] ? $R : getUidData($table[$m.'data'],$uid);
	if (!$R['uid']) getLink($g['s'].'/','','존재하지 않는 게시물입니다.','');
	$B = getUidData($table[$m.'list'],$R['bbs']);
	include_once $g['path_var'].'bbs/var.'.$B['id'].'.php';
	include_once $g['dir_module'].'mod/_view.php';
	if ($d['bbs']['isperm'])
	{
		if(strpos('_'.$B['puthead'],'[v]'))
		{
			$g['add_header_inc'] = $g['dir_module'].'var/code/'.$B['id'].'.header.php';
			if($B['imghead']) $g['add_header_img'] = $g['url_module'].'/var/files/'.$B['imghead'];
		}
		if(strpos('_'.$B['putfoot'],'[v]'))
		{
			$g['add_footer_inc'] = $g['dir_module'].'var/code/'.$B['id'].'.footer.php';
			if($B['imgfoot']) $g['add_footer_img'] = $g['url_module'].'/var/files/'.$B['imgfoot'];
		}
		if($R['mbruid']) $g['member'] = getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'*');
		$g['browtitle'] = strip_tags($R['subject']).' - '.$B['name'].' - '.$_HS['name'];
		$g['meta_tit'] = strip_tags($R['subject']).' - '.$B['name'].' - '.$_HS['name'];
		$g['meta_sbj'] = str_replace('"','\'',$R['subject']);
		$g['meta_key'] = $R['tag'] ? $B['name'].','.$R['tag'] : $B['name'].','.str_replace('"','\'',$R['subject']);
		$g['meta_des'] = getStrCut(getStripTags($R['content']),150,'');
		$g['meta_cla'] = $R['category'];
		$g['meta_rep'] = '';
		$g['meta_lan'] = 'kr';
		$g['meta_bui'] = getDateFormat($R['d_regis'],'Y.m.d');

		// 로그인한 사용자가 게시물에 좋아요/싫어요를 했는지 여부 체크
		$check_like_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$uid."' and opinion='like'";
		$check_dislike_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$uid."' and opinion='dislike'";
		$is_liked = getDbRows($table['s_opinion'],$check_like_qry);
		$is_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);

		// 로그인한 사용자가 게시물을 저장했는지 여부 체크
		$check_saved_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$uid."'";
		$is_saved = getDbRows($table['s_saved'],$check_saved_qry);
	}
}
else {
	if($bid)
	{
		$B = getDbData($table[$m.'list'],"id='".$bid."'",'*');
		if (!$B['uid'])
		{
			if($_stop=='Y') exit;
			getLink($g['s'].'/?r='.$r.'&_stop=Y','','존재하지 않는 게시판입니다.','');
		}
		include_once $g['path_var'].'bbs/var.'.$B['id'].'.php';

		$_SEO = getDbData($table['s_seo'],'rel=3 and parent='.$B['uid'],'*');
		if ($_SEO['uid'])
		{
			$g['meta_tit'] = $_SEO['title'];
			$g['meta_sbj'] = $_SEO['subject'];
			$g['meta_key'] = $_SEO['keywords'];
			$g['meta_des'] = $_SEO['description'];
			$g['meta_cla'] = $_SEO['classification'];
			$g['meta_rep'] = $_SEO['replyto'];
			$g['meta_lan'] = $_SEO['language'];
			$g['meta_bui'] = $_SEO['build'];
		}
		else {
			$g['meta_tit'] = $B['name'].' - '.$_HS['name'];
			$g['meta_sbj'] = $B['name'];
			$g['meta_key'] = $B['name'];
		}
		if(!$_HM['uid']) $g['browtitle'] = $g['browtitle'] = $B['name'].' - '.$_HS['name'];
	}
	else {
		if (!$d['bbs']['skin_total']) getLink('','','게시판아이디가 지정되지 않았습니다.','-1');
	}
}

$mod = $mod ? $mod : 'list';
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby && strpos('[asc][desc]',$orderby) ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : $d['bbs']['recnum'];

if ($mod == 'list')
{
	if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].','))
	{
		if ($d['bbs']['perm_l_list'] > $my['level'] || strpos('_'.$d['bbs']['perm_g_list'],'['.$my['mygroup'].']'))
		{
			$g['main'] = $g['dir_module'].'mod/_permcheck.php';
			$d['bbs']['isperm'] = false;
		}
	}
	if ($d['bbs']['isperm'])
	{
		if(strpos('_'.$B['puthead'],'[l]'))
		{
			$g['add_header_inc'] = $g['dir_module'].'var/code/'.$B['id'].'.header.php';
			if($B['imghead']) $g['add_header_img'] = $g['url_module'].'/var/files/'.$B['imghead'];
		}
		if(strpos('_'.$B['putfoot'],'[l]'))
		{
			$g['add_footer_inc'] = $g['dir_module'].'var/code/'.$B['id'].'.footer.php';
			if($B['imgfoot']) $g['add_footer_img'] = $g['url_module'].'/var/files/'.$B['imgfoot'];
		}
	}
	if (!$d['bbs']['hidelist']) include_once $g['dir_module'].'mod/_list.php';
}
else if ($mod == 'write')
{

	if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].','))
	{
		if ($d['bbs']['perm_l_write'] > $my['level'] || strpos('_'.$d['bbs']['perm_g_write'],'['.$my['mygroup'].']'))
		{
			$g['main'] = $g['dir_module'].'mod/_permcheck.php';
			$d['bbs']['isperm'] = false;
		}
		if ($R['uid'] && $reply != 'Y')
		{
			if ($my['uid'] != $R['mbruid'])
			{
				 if (!strpos('_'.$_SESSION['module_'.$m.'_pwcheck'],'['.$R['uid'].']')) $g['main'] = $g['dir_module'].'mod/_pwcheck.php';
			}
		}
	}
	if ($d['bbs']['isperm'])
	{
		if(strpos('_'.$B['puthead'],'[w]'))
		{
			$g['add_header_inc'] = $g['dir_module'].'var/code/'.$B['id'].'.header.php';
			if($B['imghead']) $g['add_header_img'] = $g['url_module'].'/var/files/'.$B['imghead'];
		}
		if(strpos('_'.$B['putfoot'],'[w]'))
		{
			$g['add_footer_inc'] = $g['dir_module'].'var/code/'.$B['id'].'.footer.php';
			if($B['imgfoot']) $g['add_footer_img'] = $g['url_module'].'/var/files/'.$B['imgfoot'];
		}
	}
	if ($reply == 'Y') $R['subject'] = $d['bbs']['restr'].$R['subject'];
	if (!$R['uid']) $R['content'] = $B['writecode'] ? $B['writecode'] : $R['content'];
	$_SESSION['wcode'] = $date['totime'];
}
else if ($mod == 'delete')
{
	$g['main'] = $g['dir_module'].'mod/_pwcheck.php';
}
else if ($mod == 'rss')
{
	include_once $g['dir_module'].'mod/_rss.php';
	exit;
}

$_HM['layout'] = $_HM['layout'] ? $_HM['layout'] : $d['bbs']['layout'];
$d['bbs']['skin']     = $d['bbs']['skin'] ? $d['bbs']['skin'] : $d['bbs']['skin_main'];
$d['bbs']['m_skin']   = $d['bbs']['m_skin'] ? $d['bbs']['m_skin'] : $d['bbs']['skin_mobile'];
$d['bbs']['attach']   = $d['bbs']['a_skin'] ? $d['bbs']['a_skin'] : $d['bbs']['attach_main'];
$d['bbs']['m_attach'] = $d['bbs']['a_mskin'] ? $d['bbs']['a_mskin'] : $d['bbs']['attach_mobile'];

$d['bbs']['c_skin'] = $d['bbs']['c_skin']?$d['bbs']['c_skin']:$d['bbs']['comment_main'];
$d['bbs']['c_mskin'] = $d['bbs']['c_mskin']?$d['bbs']['c_mskin']:$d['bbs']['comment_mobile'];
$d['bbs']['c_skin_modal'] = $d['bbs']['c_skin_modal']?$d['bbs']['c_skin_modal']:$d['bbs']['comment_main_modal'];
$d['bbs']['skin'] = $skin ? $skin : $d['bbs']['skin'];

if ($g['mobile']&&$_SESSION['pcmode']!='Y')
{
	$_HM['m_layout'] = $_HM['m_layout'] ? $_HM['m_layout'] : $d['bbs']['m_layout'];
	$d['bbs']['skin'] = $d['bbs']['m_skin'] ? $d['bbs']['m_skin'] : ($d['bbs']['skin_mobile']?$d['bbs']['skin_mobile']:$d['bbs']['skin_main']);
}

include_once $g['path_module'].$m.'/themes/'.$d['bbs']['skin'].'/_var.php';

if ($c) $g['bbs_reset']	= getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').'c='.$c,array($skin?'skin':'',$iframe?'iframe':'',$cat?'cat':''));
else $g['bbs_reset']	= getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').'m='.$m,array($bid?'bid':'',$skin?'skin':'',$iframe?'iframe':'',$cat?'cat':''));
$g['bbs_list']	= $g['bbs_reset'].getLinkFilter('',array($p>1?'p':'',$sort!='gid'?'sort':'',$orderby!='asc'?'orderby':'',$recnum!=$d['bbs']['recnum']?'recnum':'',$type?'type':'',$where?'where':'',$keyword?'keyword':''));
$g['pagelink']	= $g['bbs_reset'];
$g['bbs_orign'] = $g['bbs_reset'];
$g['bbs_view']	= $g['bbs_list'].'&amp;uid=';
$g['bbs_write'] = $g['bbs_list'].'&amp;mod=write';
$g['bbs_modify']= $g['bbs_write'].'&amp;uid=';
$g['bbs_reply']	= $g['bbs_write'].'&amp;reply=Y&amp;uid=';
$g['bbs_action']= $g['bbs_list'].'&amp;a=';
$g['bbs_delete']= $g['bbs_action'].'delete&amp;uid=';
$g['bbs_rss']   = $g['bbs_list'].'&amp;mod=rss';

if ($_HS['rewrite'] && $sort == 'gid' && $orderby == 'asc' && $recnum == $d['bbs']['recnum'] && $p==1 && $bid && !$cat && !$skin && !$type && !$iframe)
{
	$g['bbs_reset']= $g['r'].'/b/'.$bid;
	$g['bbs_list'] = $g['bbs_reset'];
	$g['bbs_view'] = $g['bbs_list'].'/';
	$g['bbs_write']= $g['bbs_list'].'/write';
}

$g['dir_module_skin'] = $g['dir_module'].'themes/'.$d['bbs']['skin'].'/';
$g['url_module_skin'] = $g['url_module'].'/themes/'.$d['bbs']['skin'];
$g['img_module_skin'] = $g['url_module_skin'].'/image';

$g['dir_module_mode'] = $g['dir_module_skin'].$mod;
$g['url_module_mode'] = $g['url_module_skin'].'/'.$mod;

$g['url_reset'] = $g['s'].'/?r='.$r.'&m='.$m; // 기본링크
$g['push_location'] = '<li class="breadcrumb-item active">'.$_HMD['name'].'</li>'; // 현재위치 셋팅

if($_m != $g['sys_module']&&!$_HM['uid']) $g['location'] .= ' &gt; <a href="'.$g['bbs_reset'].'">'.($B['uid']?$B['name']:'전체게시물').'</a>';

if($d['bbs']['sosokmenu'])
{
	$c=substr($d['bbs']['sosokmenu'],-1)=='/'?str_replace('/','',$d['bbs']['sosokmenu']):$d['bbs']['sosokmenu'];
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

$g['main'] = $g['main'] ? $g['main'] : $g['dir_module_mode'].'.php';
?>
