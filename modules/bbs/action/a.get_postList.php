<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
include_once $g['dir_module'].'var/var.php';

$result=array();
$result['error']=false;

$B = getDbData($table[$m.'list'],"id='".$bid."' and site=".$s,'*');

if (!$B['uid']) {
  $result['error']='존재하지 않는 게시판 입니다.';
  echo json_encode($result);
  exit;
}

include_once $g['path_var'].'bbs/var.'.$bid.'.php';
include_once $g['dir_module'].'mod/_list.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$mbruid = $my['uid'];

$html='';

$TMPL['r']=$r;
$TMPL['bname']=$B['name'];
$TMPL['bid']=$B['id'];
$TMPL['cat']=$cat;
$TMPL['keyword']=$keyword;
$TMPL['num']=$NUM;

$result['num_notice']=$NUM_NOTICE;
$result['num']=$NUM;
$result['page']=$p;

if ($NUM_NOTICE) {
  foreach ($NCD as $R) {
    $TMPL['subject']=$R['subject'];
    $TMPL['uid']=$R['uid'];
    $TMPL['mbruid']=$R['mbruid'];
    $TMPL['name']=$R[$_HS['nametype']];
    $TMPL['hit']=$R['hit'];
    $TMPL['comment']=$R['comment'].($R['oneline']?'+'.$R['oneline']:'');
    $TMPL['likes']=$R['likes'];
    $TMPL['d_regis']=getDateFormat($R['d_regis'],'Y-m-d');
    $TMPL['d_regis_c']=getDateFormat($R['d_regis'],'c');
    $TMPL['new']=getNew($R['d_regis'],24)?'':'d-none';
    $TMPL['hidden']=$R['hidden']?'':'d-none';
    $TMPL['notice']=$R['notice']?'':'d-none';
    $TMPL['upload']=$R['upload']?'':'d-none';
    $TMPL['category']=$R['category'];
    $TMPL['timeago']=$d['theme']['timeago']?'data-plugin="timeago"':'';
    $TMPL['avatar'] = getAvatarSrc($R['mbruid'],'84');
    $TMPL['featured_img'] = getPreviewResize(getUpImageSrc($R),'480x270');
    $TMPL['has_featured_img'] = getUpImageSrc($R)=='/files/noimage.png'?'d-none':'';
    $TMPL['url'] = '/'.$r.'/b/'.$bid.'/'.$R['uid'];

    if ($collapse) $TMPL['article'] = getContents($R['content'],$R['html']);
    $skin_item=new skin('list-item-notice');
    $html.=$skin_item->make();
    $TMPL['items']=$html;
  }
  $skin=new skin('list');
  $result['list_notice']=$skin->make();
} else {
  $result['list_notice']='';
}


$html='';

if ($NUM) {
  foreach ($RCD as $R) {

    $TMPL['subject']=$R['subject'];
    $TMPL['uid']=$R['uid'];
    $TMPL['mbruid']=$R['mbruid'];
    $TMPL['name']= getStrCut($R[$_HS['nametype']],10,'..');
    $TMPL['hit']=$R['hit'];
    $TMPL['comment']=$R['comment'].($R['oneline']?'+'.$R['oneline']:'');
    $TMPL['likes']=$R['likes'];
    $TMPL['d_regis']=getDateFormat($R['d_regis'],'Y.m.d H:i');
    $TMPL['d_regis_c']=getDateFormat($R['d_regis'],'c');
    $TMPL['new']=getNew($R['d_regis'],24)?'':'d-none';
    $TMPL['hidden']=$R['hidden']?'':'d-none';
    $TMPL['notice']=$R['notice']?'':'d-none';
    $TMPL['upload']=$R['upload']?'':'d-none';
    $TMPL['category']=$R['category'];
    $TMPL['timeago']=$d['theme']['timeago']?'data-plugin="timeago"':'';
    $TMPL['avatar']=getAvatarSrc($R['mbruid'],'150');
    $TMPL['featured_img_sm'] = getPreviewResize(getUpImageSrc($R),'240x180');
    $TMPL['featured_img'] = getPreviewResize(getUpImageSrc($R),'480x270');  //16:9
    $TMPL['featured_img_lg'] = getPreviewResize(getUpImageSrc($R),'686x386');
    $TMPL['featured_img_1by1_200'] = getPreviewResize(getUpImageSrc($R),'200x200');
    $TMPL['featured_img_1by1_300'] = getPreviewResize(getUpImageSrc($R),'300x300');
    $TMPL['featured_img_1by1_600'] = getPreviewResize(getUpImageSrc($R),'600x600');
    $TMPL['has_featured_img'] = getUpImageSrc($R)=='/files/noimage.png'?'d-none':'';
    $TMPL['url'] = '/'.$r.'/b/'.$bid.'/'.$R['uid'];
    //업로드 파일갯수
    $d['upload'] = getArrayString($R['upload']);
    $TMPL['upload_count'] = $d['upload']['count'];

    if ($collapse) $TMPL['article'] = getContents($R['content'],$R['html']);
    $skin_item=new skin($markup_item);
    $html.=$skin_item->make();
  }
  $TMPL['items']=$html;

  if ($p==1) {
    $TMPL['page']=$p;
    $skin=new skin($markup_list);
    $result['list_post']=$skin->make();
  } else {
    $result['list_post']=$html;
  }

} else {
  $skin_item=new skin('none');
  $result['list_post']=$skin_item->make();
}

if($my['admin'] || $my['uid']==$R['mbruid']) {  // 수정,삭제 버튼 출력여부를 위한 참조
  $result['bbsadmin'] = 1;
}

if ($B['category']) {
  $_catexp = explode(',',$B['category']);
  $_catnum=count($_catexp);
  $category='<option value="" data-bid="'.$bid.'" data-collapse="'.$collapse.'">'.$_catexp[0].'</option>';

  for ($i = 1; $i < $_catnum; $i++) {
    if(!$_catexp[$i])continue;
    $category.= '<option value="'.$_catexp[$i].'"';
    $category.= 'data-bid="'.$bid.'"';
    $category.= ' data-collapse="'.$collapse.'"';
    $category.= 'data-markup="'.$markup_file.'"';
    if ($_catexp[$i]==$cat) $category.= ' selected';
    $category.= '>';
    $category.= $_catexp[$i];
    $category.= '</option>';
  }
  $result['category']=$category;
}

echo json_encode($result);
exit;
?>
