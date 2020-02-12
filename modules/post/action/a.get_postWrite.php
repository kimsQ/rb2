<?php
if(!defined('__KIMS__')) exit;

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

// 포스트 공개관련
$d['displaySet'] = "||비공개,lock||일부공개,how_to_reg||미등록,insert_link||회원공개,people_alt||전체공개,public";
$g['displaySet']['label'] = [];
$g['displaySet']['icon'] = [];
$displaySet=explode('||',$d['displaySet']);
foreach ($displaySet as $displayLine) {
	$dis=explode(',',$displayLine);
	array_push($g['displaySet']['label'], $dis[0]);
	array_push($g['displaySet']['icon'], $dis[1]);
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$mbruid = $my['uid'];

$_IS_POSTMBR=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$uid);
$_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$uid.' and level=1');

$_perm['post_member'] = $my['admin'] || $_IS_POSTMBR ? true : false;
$_perm['post_owner'] = $my['admin'] || $_IS_POSTOWN  ? true : false;

$check_like_qry    = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='like'";
$check_dislike_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='dislike'";
$check_saved_qry   = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."'";

$is_post_liked    = getDbRows($table['s_opinion'],$check_like_qry);
$is_post_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);
$is_post_saved    = getDbRows($table['s_saved'],$check_saved_qry);

$formats = explode(',', $d['theme']['format']);array_unshift($formats,'');

$result=array();

$uid = $_POST['uid']; // 포스트 고유번호
$R = getUidData($table[$m.'data'],$uid);
$mod = 'write';
$d['post']['isperm'] = true;
$goodsArry = getArrayString($R['goods']);

include_once $g['dir_module'].'mod/_view.php';

$result['uid'] = $R['uid'];
$result['avatar'] = getAvatarSrc($R['mbruid'],'48');
$result['featured'] = getPreviewResize(getUpImageSrc($R),'240x134');
$result['featured_img'] = $R['featured_img']?$R['featured_img']:'';

if ( ($date['totime']-$R['d_regis']) < 5 ) {
  $result['display'] = 5;
  $result['display_label']=$g['displaySet']['label'][5];
} else {
  $result['display'] = $R['display'];
  $result['display_label']=$g['displaySet']['label'][$R['display']];
}

$result['format'] = $R['format'];
$result['upload'] = $R['upload'];
$result['time'] = getUpImageTime($R)?getUpImageTime($R):'';
$result['nic'] = getProfileInfo($R['mbruid'],'nic');
$result['subject'] = stripslashes($R['subject']);
$result['review'] = stripslashes($R['review']);
$result['content'] = getContents($R['content'],'HTML');
$result['tag'] = $R['tag']?$R['tag']:'';
$result['d_regis'] = getDateFormat($R['d_regis'],'Y.m.d H:i');
$result['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');

$result['nic'] = getProfileInfo($R['mbruid'],'nic');
$result['dis_like'] = $R['dis_like']?$R['dis_like']:'';
$result['dis_rating'] = $R['dis_rating']?$R['dis_rating']:'';
$result['dis_comment'] = $R['dis_comment']?$R['dis_comment']:'';
$result['dis_listadd'] = $R['dis_listadd']?$R['dis_listadd']:'';

if($R['upload']) {
  //첨부링크 및 파일
  $theme_attach= '_mobile/rc-post-file';
  $theme_link= '_mobile/rc-post-link';
  include_once $g['path_module'].'mediaset/themes/'.$theme_attach.'/main.func.php';
  include_once $g['path_module'].'mediaset/themes/'.$theme_link.'/main.func.php';

  $result['attachNum'] = getAttachNum($R['upload'],'modify');
  $result['theme_attachFile'] = $theme_attach;
}

if ($R['goods']) {
  $result['goods'] = $R['goods'];
  $result['goodsNum'] = count($goodsArry['data']);
}

if (!checkPostPerm($R)){
  $markup_file = '_404';
  $result['isperm']  = false;
} else {
  $result['isperm']  = true;
  $result['linkurl']=getFeaturedimgMeta($R,'linkurl');
}

if ($is_post_liked) $result['is_post_liked'] = 1;
if ($is_post_disliked) $result['is_post_disliked'] = 1;
if ($is_post_saved) $result['is_post_saved'] = 1;

$result['error'] = false;
echo json_encode($result);
exit;
?>
