<?php
if(!defined('__KIMS__')) exit;

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
$_tmpvfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $_tmpvfile;

if (!$my['admin']) {
	if ($d['post']['perm_l_write'] > $my['level'] || strpos('_'.$d['post']['perm_g_write'],'['.$my['mygroup'].']') || !$my['uid']) {
		$error_msg = '정상적인 접근이 아닙니다.';
		if ($send_mod=='ajax') {
			$result=array();
		  $result['error'] = $error_msg;
		  echo json_encode($result);
			exit;
		} else {
			getLink('reload','parent.',$error_msg,'');
		}
	}
}

include_once $g['dir_module'].'lib/action.func.php';

$mbruid		= $author ? $author : $my['uid'];
$tag		= trim($tag);
$subject	= str_replace('"','“',$subject);
$subject	= $subject?htmlspecialchars(trim($subject)):'(제목 없음)';
$review		= trim($review);
$content	= trim($content);
$d_regis	= $date['totime']; // 최초 등록일
if($uid) $d_modify =$date['totime']; // 수정 등록일
else $d_modify=''; // 최초에는 수정일 없음
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= $_SERVER['HTTP_USER_AGENT'];

$format= $format?$format:1;
$display= $display?$display:1;
$hidden = $display==1 || $display==2?1:0;

if ($d['post']['badword_action'])
{
	$badwordarr = explode(',' , $d['post']['badword']);
	$badwordlen = count($badwordarr);
	for($i = 0; $i < $badwordlen; $i++)
	{
		if(!$badwordarr[$i]) continue;

		if(strstr($subject,$badwordarr[$i]) || strstr($content,$badwordarr[$i]))
		{
			if ($d['post']['badword_action'] == 1)
			{
				getLink('','','등록이 제한된 단어를 사용하셨습니다.','');
			}
			else {
				$badescape = strCopy($badwordarr[$i],$d['post']['badword_escape']);
				$content = str_replace($badwordarr[$i],$badescape,$content);
				$subject = str_replace($badwordarr[$i],$badescape,$subject);
			}
		}
	}
}

if (!$featured_img) $format = 1;  //대표이미자가 없을 경우 무조건 doc 포맷지정

if ($uid) {

  $result=array();
  $result['error'] = false;

  $R = getUidData($table[$m.'data'],$uid);
	if (!$R['uid']) getLink('','','존재하지 않는 포스트입니다.','');

  if (!checkPostOwner($R)) getLink('','','잘못된 접근입니다.','');

  $log = $my[$_HS['nametype']].'|'.getDateFormat($date['totime'],'Y.m.d H:i').'<s>'.$R['log'];
  $QVAL1 = "subject='$subject',review='$review',content='$content',tag='$tag',display='$display',hidden='$hidden',format='$format',";
  $QVAL1 .="d_modify='$d_modify',category='$category_members',member='$member',upload='$upload',log='$log',featured_img='$featured_img',linkedmenu='$linkedmenu',dis_comment='$dis_comment',dis_like='$dis_like',dis_rating='$dis_rating',dis_listadd='$dis_listadd',goods='$goods'";
  getDbUpdate($table[$m.'data'],$QVAL1,'uid='.$R['uid']);

  //포스트 공유설정 업데이트
  getDbUpdate($table[$m.'index'],'display='.$display.',format='.$format,'gid='.$R['gid']);
  getDbUpdate($table[$m.'member'],'display='.$display.',format='.$format,'data='.$R['uid']);
  getDbUpdate($table[$m.'day'],'display='.$display,'data='.$R['uid']); // 일별현황 업데이트 (인기 포스트 추출목적)

  //카테고리 업데이트
  $_orign_category_members = getDbArray($table[$m.'category_index'],'data='.$R['uid'],'*','data','asc',0,1);

	while($_ocm=db_fetch_array($_orign_category_members)) {
  	if(!strstr($category_members,'['.$_ocm['category'].']')) {
			getDbDelete($table[$m.'category_index'],'category='.$_ocm['category'].' and data='.$uid);
			getDbUpdate($table[$m.'category'],'num=num-1','uid='.$_ocm['category']);
  	}
	}

	$_category_members = array();
	$_category_members = getArrayString($category_members);
	foreach($_category_members['data'] as $_ct1) {

    if (getDbRows($table[$m.'category_index'],'data='.$uid.' and category='.$_ct1)) {
      getDbUpdate($table[$m.'category_index'],'display='.$display.',format='.$format,'data='.$uid.' and category='.$_ct1);
    } else {
      $mingid = getDbCnt($table[$m.'data'],'min(gid)','');
      $gid = $mingid ? $mingid-1 : 100000000;
      $_ct1_info=getUidData($table[$m.'category'],$_ct1);
      $_ct1_depth=$_ct1_info['depth'];
      getDbInsert($table[$m.'category_index'],'site,data,category,display,format,depth,gid',"'".$s."','".$R['uid']."','".$_ct1."','".$display."','".$format."','".$_ct1_depth."','".$gid."'");
      getDbUpdate($table[$m.'category'],'num=num+1','uid='.$_ct1);
    }

	}

  //리스트 업데이트
  $_orign_list_members = getDbArray($table[$m.'list_index'],'data='.$R['uid'].' and mbruid='.$mbruid,'*','data','asc',0,1);

	while($_olm=db_fetch_array($_orign_list_members)) {
  	if(!strstr($list_members,'['.$_olm['list'].']')) {
  		getDbDelete($table[$m.'list_index'],'list='.$_olm['list'].' and data='.$R['uid'].' and mbruid='.$mbruid);
      getDbUpdate($table[$m.'list'],'num=num-1','uid='.$_olm['list']);
  	}
	}

  $_list_members = array();
  $_list_members = getArrayString($list_members);

  foreach($_list_members['data'] as $_lt1) {
    if (getDbRows($table[$m.'list_index'],'data='.$uid.' and list='.$_lt1)) {
      getDbUpdate($table[$m.'list_index'],'display='.$display,'data='.$uid.' and list='.$_lt1);
    } else {
      $maxgid = getDbCnt($table[$m.'list_index'],'max(gid)','');
      $gid = $maxgid ? $maxgid+1 : 1;
      getDbInsert($table[$m.'list_index'],'site,list,display,data,gid,mbruid',"'".$s."','".$_lt1."','".$display."','".$R['uid']."','".$gid."','".$mbruid."'");
      getDbUpdate($table[$m.'list'],'num=num+1,d_last='.$d_regis,'uid='.$_lt1);
    }
  }

	//상품리뷰 인덱스 업데이트
	if ($goods) {
		$_orign_goods_members = getDbArray($table['shopreview'],'post='.$R['uid'],'*','post','asc',0,1);

		while($_ogm=db_fetch_array($_orign_goods_members)) {
	  	if(!strstr($goods,'['.$_ogm['goods'].']')) {
	  		getDbDelete($table['shopreview'],'goods='.$_ogm['goods'].' and post='.$R['uid']);
	      getDbUpdate($table['shopdata'],'post=post-1','uid='.$_ogm['goods']);
	  	}
		}

	  $_goods_members = array();
	  $_goods_members = getArrayString($goods);

	  foreach($_goods_members['data'] as $_gd1) {
	    if (getDbRows($table['shopreview'],'post='.$uid.' and goods='.$_gd1)) {
	      getDbUpdate($table['shopreview'],'display='.$display,'post='.$uid.' and goods='.$_gd1);
	    } else {
	      $maxgid = getDbCnt($table['shopreview'],'max(gid)','');
	      $gid = $maxgid ? $maxgid+1 : 1;
	      getDbInsert($table['shopreview'],'site,goods,display,post,gid,auth',"'".$s."','".$_gd1."','".$display."','".$R['uid']."','".$gid."','1'");
	      getDbUpdate($table['shopdata'],'post=post+1,d_last='.$d_regis,'uid='.$_gd1);
	    }
	  }
	}

  // 피드 인덱스 추가
  if ($display>3) {

    $_FCD = getDbArray($table['s_friend'],'by_mbruid='.$my['uid'],'my_mbruid','uid','asc',0,1);
    while ($_F=db_fetch_array($_FCD)) {
      $mbruid		= $_F['my_mbruid'];
      $module 	= $m;
      $category	= '';
      $entry		= $R['uid'];
      $d_regis	= $date['totime'];

      $check_feed_qry = "mbruid='".$mbruid."' and module='".$module."' and entry='".$entry."'";
      $is_feed = getDbRows($table['s_feed'],$check_feed_qry);

      if (!$is_feed){
        $_QKEY = 'site,mbruid,module,category,entry,d_regis';
      	$_QVAL = "'$s','$mbruid','$module','$category','$entry','$d_regis'";
      	getDbInsert($table['s_feed'],$_QKEY,$_QVAL);
      }
    }

    //피드 구데이터 삭제 (인덱스 용량 5000건 제한 )
    $_REFCNT = getDbRows($table['s_feed'],'');
    if ($_REFCNT > 5000) {
      $_REFOVER = getDbArray($table['s_feed'],'','*','uid','asc',($_REFCNT - 4001),1);
      while($_REFK=db_fetch_array($_REFOVER)) {
        getDbDelete($table['s_feed'],'uid='.$_REFK['uid']); // 구 데이터삭제
      }
    }

    if ($_REFCNT == 1000) {
      db_query("OPTIMIZE TABLE ".$table['s_feed'],$DB_CONNECT);
    }

  }

  getDbUpdate($table['s_feed'],'display='.$display,'module="'.$m.'" and entry='.$R['uid']); //피드 인덱스 업데이트


} else {

  $member= $$member?$member:'['.$mbruid.']';
  $cid	= substr($g['time_srnad'],9,7);

  $mingid = getDbCnt($table[$m.'data'],'min(gid)','');
  $maxgid = getDbCnt($table[$m.'data'],'max(gid)','');
	$gid = $mingid ? $mingid-1 : 100000000.00;
  $_gid = $maxgid ? $maxgid+1 : 1;

  $log = $my[$_HS['nametype']].'|'.getDateFormat($date['totime'],'Y.m.d H:i').'<s>';

  $QKEY1 = "site,gid,mbruid,cid,subject,review,content,tag,html,";
  $QKEY1.= "hit,comment,oneline,d_regis,d_modify,d_comment,member,upload,log,display,hidden,featured_img,format,dis_comment,dis_like,dis_rating,dis_listadd,ip,agent";
  $QVAL1 = "'$s','$gid','$mbruid','$cid','$subject','$review','$content','$tag','$html',";
  $QVAL1.= "'0','0','0','$d_regis','','','$member','$upload','$log','$display','$hidden','$featured_img','$format','$dis_comment','$dis_like','$dis_rating','$dis_listadd','$ip','$agent'";
  getDbInsert($table[$m.'data'],$QKEY1,$QVAL1);
  getDbInsert($table[$m.'index'],'site,display,format,gid',"'$s','$display','$format','$gid'");

  $LASTUID = getDbCnt($table[$m.'data'],'max(uid)','');
  $QKEY2 = "mbruid,site,gid,data,display,format,auth,level,d_regis";
  $QVAL2 = "'$mbruid','$s','$gid','$LASTUID','$display','$format','1','1','$d_regis'";
  getDbInsert($table[$m.'member'],$QKEY2,$QVAL2);

  if(!getDbRows($table['s_mbrmonth'],"date='".$date['month']."' and site=".$s.' and mbruid='.$mbruid)) {
    getDbInsert($table['s_mbrmonth'],'date,site,mbruid,post_num',"'".$date['month']."','".$s."','".$mbruid."','0'");
  }

  if(!getDbRows($table['s_mbrday'],"date='".$date['today']."' and site=".$s.' and mbruid='.$mbruid)) {
    getDbInsert($table['s_mbrday'],'date,site,mbruid,post_num',"'".$date['today']."','".$s."','".$mbruid."','0'");
  }

  getDbUpdate($table['s_mbrdata'],'num_post=num_post+1','memberuid='.$my['uid']); // 회원포스트 수량 +1
  getDbUpdate($table['s_mbrmonth'],'post_num=post_num+1',"date='".$date['month']."' and site=".$s.' and mbruid='.$mbruid); //회원별 월별 수량등록
  getDbUpdate($table['s_mbrday'],'post_num=post_num+1',"date='".$date['today']."' and site=".$s.' and mbruid='.$mbruid); //회원별 일별 수량등록

  $_category_members = array();
	$_category_members = getArrayString($category_members);

	foreach($_category_members['data'] as $_ct1)
	{
    $_ct1_info=getUidData($table[$m.'category'],$_ct1);
    $_ct1_depth=$_ct1_info['depth'];
    if (!getDbRows($table[$m.'category_index'],'data='.$LASTUID.' and category='.$_ct1))
    {
      getDbInsert($table[$m.'category_index'],'site,data,category,depth,gid',"'".$s."','".$LASTUID."','".$_ct1."','".$_ct1_depth."','".$gid."'");
      getDbUpdate($table[$m.'category'],'num=num+1','uid='.$_ct1);
    }
	}

  $_list_members = array();
  $_list_members = getArrayString($list_members);

  foreach($_list_members['data'] as $_lt1) {
    if (!getDbRows($table[$m.'list_index'],'data='.$LASTUID.' and list='.$_lt1)) {
      getDbInsert($table[$m.'list_index'],'site,data,list,gid',"'".$s."','".$LASTUID."','".$_lt1."','".$_gid."'");
      getDbUpdate($table[$m.'list'],'num=num+1,d_last='.$d_regis,'uid='.$_lt1);
    }
  }

	if ($gid == 100000000)
	{
		db_query("OPTIMIZE TABLE ".$table[$m.'data'],$DB_CONNECT);
		db_query("OPTIMIZE TABLE ".$table[$m.'index'],$DB_CONNECT);
    db_query("OPTIMIZE TABLE ".$table[$m.'category_index'],$DB_CONNECT);
	}

}

$NOWUID = $LASTUID ? $LASTUID : $R['uid'];

// 업로드 파일에 대한 parent 값 업데이트
if ($upload) {
	$_updata = getArrayString($upload);
	foreach ($_updata['data'] as $_ups)
	{
		getDbUpdate($table['s_upload'],"parent='".$m.$NOWUID."'",'uid='.$_ups);
	}
}

// 링크 첨부에 대한 parent 값 업데이트
if($attachLink) {
	foreach ($attachLink as $val) {
		getDbUpdate($table['s_link'],"module='".$m."',entry='".$NOWUID."' ",'uid='.$val);
	}
}

// 태그등록
if ($tag || $R['tag'])
{
	$_tagarr1 = array();
	$_tagarr2 = explode(',',$tag);
  $_tagdate = $date['today'];

	if ($R['uid'])
	{
    $_tagdate = substr($R['d_regis'],0,8);
		$_tagarr1 = explode(',',$R['tag']);
		foreach($_tagarr1 as $_t)
		{
			if(!$_t || in_array($_t,$_tagarr2)) continue;
      $_TAG = getDbData($table['s_tag'],"site=".$R['site']." and date='".$_tagdate."' and keyword='".$_t."'",'*');
			if($_TAG['uid'])
			{
				if($_TAG['hit']>1) getDbUpdate($table['s_tag'],'hit=hit-1','uid='.$_TAG['uid']);
				else getDbDelete($table['s_tag'],'uid='.$_TAG['uid']);
			}
		}
	}

	foreach($_tagarr2 as $_t)
	{
		if(!$_t || in_array($_t,$_tagarr1)) continue;
		$_TAG = getDbData($table['s_tag'],'site='.$s." and date='".$_tagdate."' and keyword='".$_t."'",'*');
		if($_TAG['uid']) getDbUpdate($table['s_tag'],'hit=hit+1','uid='.$_TAG['uid']);
		else getDbInsert($table['s_tag'],'site,date,keyword,hit',"'".$s."','".$_tagdate."','".$_t."','1'");
	}
}

if ($uid) {

  $result['d_modify'] = getDateFormat($d_modify,'Y.m.d H:i');
  echo json_encode($result);
	exit;

} else {

	if ($send_mod=='ajax') {

		$result['last_uid'] = $LASTUID;
		$result['last_cid'] = $cid;
	  echo json_encode($result);
		exit;

	} else {
		$_R = getUidData($table[$m.'data'],$LASTUID);
		getLink(RW('m=post&mod=write&cid='.$_R['cid']),'parent.','','');
	}

}

?>
