<?php
// 첨부파일 리스트 갯수 추출 함수
function getLinkNum($upload,$mod)
{
	global $table;

	$attach = getArrayString($upload);
	$link_num=0;// 링크 수량
	$hidden_link_num=0; // 숨김링크 수량
	foreach($attach['data'] as $val)
	{
		$U = getUidData($table['s_upload'],$val);
		if($U['fserver']==3) $link_num++; // 전체 링크수량 증가
		if($U['fserver']==3 && $U['hidden']==1) $hidden_link_num++; // 숨김링크 수량 증가
	}
  $active_link_num=$link_num-$hidden_link_num; // 공개 링크
  $result=array();
  $result['modify']=$link_num;
  $result['view']=$active_link_num;

  return $result[$mod];
}

function getAttachPlatformList($parent_data,$mod,$type) {
  global $table;

      $upload=$parent_data['upload'];
      $featured_img_uid=$parent_data['featured_img'];// 대표이미지 uid

      $sql='fserver=3';
      $attach = getArrayString($upload);

		  if ($mod=='view') $sql.=' and hidden=0';

      $uid_q='(';
      foreach($attach['data'] as $uid)
     {
         $uid_q.='uid='.$uid.' or ';
     }

     $uid_q=substr($uid_q,0,-4).')';
       $sql=$sql.' and '.$uid_q;
       $RCD=getDbArray($table['s_upload'],$sql,'*','gid','asc','',1);
       $html='';
       while($R=db_fetch_array($RCD)){
         $U=getUidData($table['s_upload'],$R['uid']);
         $html.=getAttachPlatform($U,$mod,$featured_img_uid);
       }
  return $html;

}

// 추출 함수 (낱개)
function getAttachPlatform($R,$mod,$featured_img_uid) {

	global $g,$r,$m,$theme,$TMPL;

	$m='mediaset';
	$theme='_mobile/rc-post-link';

	include_once $GLOBALS['g']['path_core'].'function/sys.class.php';

  $md_title=str_replace('|','-',$R['title']);
  $thumbnail_url_parse = parse_url($R['src']);
  $thumbnail_url_arr = explode('//',$R['src']);

  if ($R['provider']=='Google Maps') {
    $thumbnail = $R['src'];
  } else if (strpos($R['src'], '?') !== false) {
    $thumbnail = '/_core/opensrc/timthumb/thumb.php?src='.$R['src'].'&w=50&h=50&s=1';
  } else {
    $thumbnail = '/thumb'.($thumbnail_url_parse['scheme']=='https'?'-ssl':'').'/50x50/u/'.$thumbnail_url_arr[1];
  }

  $insert_text='<video class=mejs-player img-responsive img-fluid  style=max-width:100% preload=none><source src=https://www.youtube.com/embed/'.$R['src'].' type=video/youtube></video>';

	$TMPL['is_featured']=$R['uid']==$featured_img_uid?'':' hidden';
	$TMPL['is_hidden']=!$R['hidden']?' hidden':'';
	$TMPL['hidden_code']=$R['hidden']?'show':'hide';
	$TMPL['hidden_str']=$R['hidden']?'보이기':'숨기기';

	$TMPL['showhide']=!$R['hidden']?'hide':'show';
	// $TMPL['insert_text']=$insert_text;

	$TMPL['linkurl']=$R['linkurl'];
	$TMPL['thumbnail']=$thumbnail;
	$TMPL['name']=$R['caption']?$R['caption']:getStrCut($R['description'],100,'..');
	$TMPL['provider']=$R['provider'];
	$TMPL['time']=$R['time'];

	$TMPL['uid']=$R['uid'];

	if ($mod=='view') $markup_file = 'view_row';
	else $markup_file = 'edit_row';

	$skin=new skin($markup_file);
	$html=$skin->make();


  return $html;
}

?>
