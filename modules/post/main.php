<?php
if(!defined('__KIMS__')) exit;

include_once $g['dir_module'].'_main.php';

$mod = $mod ? $mod : 'post';
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby && strpos('[asc][desc]',$orderby) ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : $d['post']['recnum'];

$_perm = array();

if ($cat) $mod='category';

if ($cid) {

  $R=getDbData($table[$m.'data'],"cid='".$cid."'",'*');

  $g['browtitle'] = strip_tags(stripslashes(getStrCut($R['subject'],10,''))).' - '.$_HS['name'];
  $g['meta_tit'] = strip_tags(stripslashes($R['subject'])).' - '.$_HS['name'];
  $g['meta_sbj'] = str_replace('"','\'',stripslashes($R['subject']));
  $g['meta_key'] = $R['tag'] ?$R['tag'] : str_replace('"','\'',stripslashes($R['subject']));
  $g['meta_des'] = getStrCut(getStripTags($R['review']),150,'');
  $g['meta_img'] = getPreviewResize(getUpImageSrc($R),'z');

  $_POSTMBR = getDbData($table[$m.'members'],'mbruid='.$my['uid'].' and data='.$R['uid'],'*');

  $_IS_POSTMBR=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$R['uid']);
  $_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$R['uid'].' and level=1');

  $_perm['post_member'] = $my['admin'] || $_IS_POSTMBR ? true : false;
  $_perm['post_owner'] = $my['admin'] || $_IS_POSTOWN  ? true : false;
  $_perm['post_write'] =  $_POSTMBR['auth'];

  // 로그인한 사용자가 게시물에 좋아요/싫어요를 했는지 여부 체크
  $check_like_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$R['uid']."' and opinion='like'";
  $check_dislike_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$R['uid']."' and opinion='dislike'";
  $is_liked = getDbRows($table['s_opinion'],$check_like_qry);
  $is_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);

  // 로그인한 사용자가 게시물을 저장했는지 여부 체크
  $check_saved_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$R['uid']."'";
  $is_saved = getDbRows($table['s_saved'],$check_saved_qry);

  $mod = $mod ? $mod : 'view';
	include_once $g['dir_module'].'mod/_view.php';
}

if ($c) {
  $g['post_reset']	= getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').'c='.$c,array($skin?'skin':'',$iframe?'iframe':'',$cat?'cat':''));
  if ($_HS['rewrite']) $g['post_reset']	= getLinkFilter2(($_HS['usescode']?'/'.$r:'').RW('c='.$c),array($skin?'skin':'',$iframe?'iframe':'',$cat?'cat':''));
} else {
  $g['post_reset']	= getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').'m='.$m,array($skin?'skin':'',$iframe?'iframe':'',$cat?'cat':''));
  if ($_HS['rewrite'])  $g['post_reset']= $g['r'].'/post';
}

switch ($mod) {
  case 'category' :
    $CAT  = getDbData($table[$m.'category'],"id='".$cat."'",'*');
    include_once $g['dir_module'].'mod/_category.php';
    if ( $cat && (!$CAT['uid']||($CAT['reject']&&!$my['admin']))) $mod = '_404';
    if ($_HS['rewrite']) {
      if ($cat) $g['post_reset']= $g['r'].'/post/category/'.$cat;
      else $g['post_reset']= $g['r'].'/post';
    }
    $g['browtitle'] =  ($CAT['name']?$CAT['name']:'전체 카테고리').' - '.$_HS['name'];
  	$g['post_list']	= $g['post_reset'].getLinkFilter2('',array($sort!='gid'?'sort':'',$orderby!='asc'?'orderby':'',$keyword?'keyword':'',$code?'code':''));
    $g['pagelink']	= $g['post_list'];
    $_N	= !$_GET['sort'] && !$_GET['where'] && !$_GET['keyword'] && !$_GET['code']?$g['post_list'].'?':'';
  break;

  case 'post' :
    include_once $g['dir_module'].'mod/_post.php';
    if ($_HS['rewrite']) $g['post_reset']= $g['r'].'/post';
    $g['browtitle'] = '전체 포스트 - '.$_HS['name'];
    $g['post_list']	= $g['post_reset'].getLinkFilter2('',array('sort',$orderby!='asc'?'orderby':'',$keyword?'keyword':''));
    $g['pagelink']	= $g['post_list'];
    $_N	= !$_GET['sort'] && !$_GET['where'] && !$_GET['keyword']?$g['post_list'].'?':'';
  break;

  case 'keyword' :
    if (!$keyword) getLink('','','키워드를 입력해주세요.','-1');
    include_once $g['dir_module'].'mod/_category.php';
    if ($_HS['rewrite']) $g['post_reset']= $g['r'].'/post/search';
    $g['browtitle'] = '#'.$keyword.' - '.$_HS['name'];
    $g['post_list']	= $g['post_reset'].getLinkFilter2('',array('keyword'));
    $g['pagelink']	= $g['post_list'];
  break;

  case 'list' :
    include_once $g['dir_module'].'mod/_list.php';
    if ($_HS['rewrite']) $g['post_reset']= $g['r'].'/list';
    $g['browtitle'] = '전체 리스트 - '.$_HS['name'];
    $g['post_list']	= $g['post_reset'].getLinkFilter2('',array($sort!='gid'?'sort':'',$orderby!='asc'?'orderby':'',$keyword?'keyword':'','code'));
    $g['pagelink']	= $g['post_list'];
    $_N	= $_HS['rewrite'] && !$_GET['sort']?$g['page_list'].'?':'';
  break;

  case 'list_view' :
    $LIST=getDbData($table[$m.'list'],"id='".$listid."'",'*');
    include_once $g['dir_module'].'mod/_list.php';
    if ($_HS['rewrite']) $g['post_reset']= $g['r'].'/list/'.$listid;
    $g['meta_img'] = getPreviewResize(getListImageSrc($LIST['uid']),'z');
    $g['browtitle'] = $LIST['name'].' - '.$_HS['name'];
    $g['post_list']	= $g['post_reset'].getLinkFilter2('',array());
    $g['pagelink']	= $g['post_list'];
    $_N	= $_HS['rewrite'] && !$_GET['sort']?$g['page_list'].'?':'';
  break;

  case 'view' :
    if (!checkPostPerm($R)) {
    	$mod = '_404';
    	$d['post']['isperm'] = false;
    }
    include_once $g['dir_module'].'mod/_view.php';
  break;

  case 'write' :

    if (!$d['post']['writeperm']) getLink('','','잘못된 접근입니다.','-1');

    if ($cid &&!$_perm['post_owner']) getLink('','','접근권한이 없습니다.','-1'); // 수정권한 체크
    if (!$g['mobile']||$_SESSION['pcmode']=='Y') {
      $layoutArr = explode('/',$d['post']['layout']);
      $d['post']['layout'] = $layoutArr[0].'/blank.php';
    }
    $g['browtitle'] = '글쓰기 - '.$_HS['name'];
  break;
}

$_HM['layout'] = $_HM['layout'] ? $_HM['layout'] : $d['post']['layout'];
$d['post']['skin']     = $d['post']['skin'] ? $d['post']['skin'] : $d['post']['skin_main'];
$d['post']['m_skin']   = $d['post']['m_skin'] ? $d['post']['m_skin'] : $d['post']['skin_mobile'];

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$_HM['m_layout'] = $_HM['m_layout'] ? $_HM['m_layout'] : $d['post']['m_layout'];
	$d['post']['skin'] = $d['post']['m_skin'] ? $d['post']['m_skin'] : ($d['post']['skin_mobile']?$d['post']['skin_mobile']:$d['post']['skin_main']);
}

include_once $g['path_module'].$m.'/themes/'.$d['post']['skin'].'/_var.php';

$g['post_base']	 = $g['s'].'/?r='.$r.'&amp;'.'m=post';
$g['pagelink']	= $g['post_list'];
$g['post_orign'] = $g['post_reset'];
$g['post_view']	= $g['post_list'].'&amp;mod=view&amp;cid=';
$g['post_write'] = $g['post_list'].'&amp;mod=write';
$g['post_modify']= $g['post_write'].'&amp;cid=';
$g['post_action']= $g['post_base'].'&amp;a=';
$g['post_delete']= $g['post_action'].'delete&amp;cid=';
$g['post_print'] = $g['post_reset'].'&amp;iframe=Y&amp;print=Y&amp;cid=';


if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$_HM['m_layout'] = $_HM['m_layout'] ? $_HM['m_layout'] : $d['post']['m_layout'];
  $g['dir_module_skin'] = $g['dir_module'].'themes/'.$d['post']['skin_mobile'].'/';
  $g['url_module_skin'] = $g['url_module'].'/themes/'.$d['post']['skin_mobile'];
  $g['img_module_skin'] = $g['url_module_skin'].'/images';
} else {
  $_HM['layout'] = $_HM['layout'] ? $_HM['layout'] : $d['post']['layout'];
  $g['dir_module_skin'] = $g['dir_module'].'themes/'.$d['post']['skin_main'].'/';
  $g['url_module_skin'] = $g['url_module'].'/themes/'.$d['post']['skin_main'];
  $g['img_module_skin'] = $g['url_module_skin'].'/images';
}

$g['dir_module_mode'] = $g['dir_module_skin'].$mod;
$g['url_module_mode'] = $g['url_module_skin'].'/'.$mod;

$g['url_reset'] = $g['s'].'/?r='.$r.'&m='.$m;
$g['push_location'] = '<li class="active">'.$_HMD['name'].'';

if($R['linkedmenu'])
{
	$c=substr($R['linkedmenu'],-1)=='/'?str_replace('/','',$R['linkedmenu']):$R['linkedmenu'];
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
