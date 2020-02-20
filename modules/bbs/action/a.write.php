<?php
if(!defined('__KIMS__')) exit;
require_once $g['path_core'].'function/sys.class.php';

if (!$_SESSION['wcode']||$_SESSION['wcode']!=$pcode) exit;

if (!$bid) getLink('','','게시판 아이디가 지정되지 않았습니다.','');
$B = getDbData($table[$m.'list'],"id='".$bid."'",'*');
if (!$B['uid']) getLink('','','존재하지 않는 게시판입니다.','');
if (!$subject) getLink('reload','parent.','제목이 입력되지 않았습니다.','');

$g['bbsVarForSite'] = $g['path_var'].'site/'.$r.'/bbs.var.php';
include_once file_exists($g['bbsVarForSite']) ? $g['bbsVarForSite'] : $g['dir_module'].'var/var.php';

include_once $g['path_var'].'bbs/var.'.$B['id'].'.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$bbsuid		= $B['uid'];
$bbsid		= $B['id'];
$mbruid		= $my['uid'];
$id			= $my['id'];
$name		= $my['uid'] ? $my['name'] : trim($name);
$nic		= $my['uid'] ? $my['nic'] : $name;
$category	= trim($category);
$subject	= str_replace('"','“',$subject);
$subject	= $my['admin'] ? trim($subject) : htmlspecialchars(trim($subject));
$content	= trim($content);
$html		= $html ? $html : 'HTML';
$tag		= trim($tag);
$d_regis	= $date['totime'];
$d_comment	= '';
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= $_SERVER['HTTP_USER_AGENT'];
$upload		= $upfiles;
$adddata	= trim($adddata);
$hidden		= $hidden ? intval($hidden) : 0;
$notice		= $notice ? intval($notice) : 0;
$display	= $d['bbs']['display'] || $hidepost || $hidden ? 0 : 1;
$parentmbr	= 0;
$point1		= trim($d['bbs']['point1']);
$point2		= trim($d['bbs']['point2']);
$point3		= $point3 ? filterstr(trim($point3)) : 0;
$point4		= $point4 ? filterstr(trim($point4)) : 0;

if ($d['bbs']['badword_action']) {
	$badwordarr = explode(',' , $d['bbs']['badword']);
	$badwordlen = count($badwordarr);
	for($i = 0; $i < $badwordlen; $i++)
	{
		if(!$badwordarr[$i]) continue;

		if(strstr($subject,$badwordarr[$i]) || strstr($content,$badwordarr[$i]))
		{
			if ($d['bbs']['badword_action'] == 1)
			{
				getLink('','','등록이 제한된 단어를 사용하셨습니다.','');
			}
			else {
				$badescape = strCopy($badwordarr[$i],$d['bbs']['badword_escape']);
				$content = str_replace($badwordarr[$i],$badescape,$content);
				$subject = str_replace($badwordarr[$i],$badescape,$subject);
			}
		}
	}
}

if (!$uid || $reply == 'Y') {
	if(!getDbRows($table[$m.'day'],"date='".$date['today']."' and site=".$s.' and bbs='.$bbsuid))
	getDbInsert($table[$m.'day'],'date,site,bbs,num',"'".$date['today']."','".$s."','".$bbsuid."','0'");
	if(!getDbRows($table[$m.'month'],"date='".$date['month']."' and site=".$s.' and bbs='.$bbsuid))
	getDbInsert($table[$m.'month'],'date,site,bbs,num',"'".$date['month']."','".$s."','".$bbsuid."','0'");
}

if ($uid) {
	$R = getUidData($table[$m.'data'],$uid);
	if (!$R['uid']) getLink('','','존재하지 않는 게시물입니다.','');

	if ($reply == 'Y') {
		if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
			if ($d['bbs']['perm_l_write'] > $my['level'] || strstr($d['bbs']['perm_g_write'],'['.$my['mygroup'].']')) {
				getLink('','','정상적인 접근이 아닙니다.','');
			}
		}

		$RNUM = getDbRows($table[$m.'idx'],'gid >= '.$R['gid'].' and gid < '.(intval($R['gid'])+1));
		if ($RNUM > 98) getLink('','','죄송합니다. 더이상 답글을 달 수 없습니다.','');

		getDbUpdate($table[$m.'idx'],'gid=gid+0.01','gid > '.$R['gid'].' and gid < '.(intval($R['gid'])+1));
		getDbUpdate($table[$m.'data'],'gid=gid+0.01','gid > '.$R['gid'].' and gid < '.(intval($R['gid'])+1));

		if ($R['hidden'] && $hidden) {
			if ($R['mbruid']) {
				$pw = $R['mbruid'];
			} else {
				$pw = $my['uid'] ? $R['pw'] : ($pw == $R['pw'] ? $R['pw'] : md5($pw));
			}
		} else {
			$pw = $pw ? md5($pw) : '';
		}

		$gid	= $R['gid']+0.01;
		$depth	= $R['depth']+1;
		$parentmbr = $R['mbruid'];

		$QKEY = "site,gid,bbs,bbsid,depth,parentmbr,display,hidden,notice,name,nic,mbruid,id,pw,category,subject,content,html,tag,";
		$QKEY.= "hit,down,comment,oneline,trackback,likes,dislikes,report,point1,point2,point3,point4,d_regis,d_modify,d_comment,d_trackback,upload,ip,agent,sns,featured_img,location,pin,adddata";
		$QVAL = "'$s','$gid','$bbsuid','$bbsid','$depth','$parentmbr','$display','$hidden','$notice','$name','$nic','$mbruid','$id','$pw','$category','$subject','$content','$html','$tag',";
		$QVAL.= "'0','0','0','0','0','0','0','0','$point1','$point2','$point3','$point4','$d_regis','','','','$upload','$ip','$agent','','$featured_img','$location','$pin','$adddata'";
		getDbInsert($table[$m.'data'],$QKEY,$QVAL);
		getDbInsert($table[$m.'idx'],'site,notice,bbs,gid',"'$s','$notice','$bbsuid','$gid'");
		getDbUpdate($table[$m.'list'],"num_r=num_r+1,d_last='".$d_regis."'",'uid='.$bbsuid);
		getDbUpdate($table[$m.'month'],'num=num+1',"date='".$date['month']."' and site=".$s.' and bbs='.$bbsuid);
		getDbUpdate($table[$m.'day'],'num=num+1',"date='".$date['today']."' and site=".$s.' and bbs='.$bbsuid);
		$LASTUID = getDbCnt($table[$m.'data'],'max(uid)','');
		if ($cuid) getDbUpdate($table['s_menu'],"num='".getDbCnt($table[$m.'month'],'sum(num)','site='.$s.' and bbs='.$bbsuid)."',d_last='".$d_regis."'",'uid='.$cuid);

		if ($point1&&$my['uid']) {
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','".$point1."','게시물(".getStrCut($subject,15,'').")포인트','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point+'.$point1,'memberuid='.$my['uid']);
		}

	} else {

		if ($my['uid'] != $R['mbruid'] && !$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
		    if (!strstr($_SESSION['module_'.$m.'_pwcheck'],$R['uid'])) getLink('','','정상적인 접근이 아닙니다.','');
		}

		$pw = !$R['pw'] && !$R['hidden'] && $hidden && $R['mbruid'] ? $R['mbruid'] : $R['pw'];

		$QVAL = "display='$display',hidden='$hidden',notice='$notice',pw='$pw',category='$category',subject='$subject',content='$content',html='$html',tag='$tag',point3='$point3',point4='$point4',d_modify='$d_regis',upload='$upload',featured_img='$featured_img',location='$location',pin='$pin',adddata='$adddata'";
		getDbUpdate($table[$m.'data'],$QVAL,'uid='.$R['uid']);
		getDbUpdate($table[$m.'idx'],'notice='.$notice,'gid='.$R['gid']);
		if ($cuid) getDbUpdate($table['s_menu'],"num='".getDbCnt($table[$m.'month'],'sum(num)','site='.$R['site'].' and bbs='.$R['bbs'])."'",'uid='.$cuid);
	}

} else {

	if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
		if ($d['bbs']['perm_l_write'] > $my['level'] || strstr($d['bbs']['perm_g_write'],'['.$my['mygroup'].']')) {
			getLink('','','정상적인 접근이 아닙니다.','');
		}
	}

	$pw = $hidden && $my['uid'] ? $my['uid'] : ($pw ? md5($pw) : '');
	$mingid = getDbCnt($table[$m.'data'],'min(gid)','');
	$gid = $mingid ? $mingid-1 : 100000000.00;

	$QKEY = "site,gid,bbs,bbsid,depth,parentmbr,display,hidden,notice,name,nic,mbruid,id,pw,category,subject,content,html,tag,";
	$QKEY.= "hit,down,comment,oneline,trackback,likes,dislikes,report,point1,point2,point3,point4,d_regis,d_modify,d_comment,d_trackback,upload,ip,agent,sns,featured_img,location,pin,adddata";
	$QVAL = "'$s','$gid','$bbsuid','$bbsid','$depth','$parentmbr','$display','$hidden','$notice','$name','$nic','$mbruid','$id','$pw','$category','$subject','$content','$html','$tag',";
	$QVAL.= "'0','0','0','0','0','0','0','0','$point1','$point2','$point3','$point4','$d_regis','','','','$upload','$ip','$agent','','$featured_img','$location','$pin','$adddata'";
	getDbInsert($table[$m.'data'],$QKEY,$QVAL);
	getDbInsert($table[$m.'idx'],'site,notice,bbs,gid',"'$s','$notice','$bbsuid','$gid'");
	getDbUpdate($table[$m.'list'],"num_r=num_r+1,d_last='".$d_regis."'",'uid='.$bbsuid);
	getDbUpdate($table[$m.'month'],'num=num+1',"date='".$date['month']."' and site=".$s.' and bbs='.$bbsuid);
	getDbUpdate($table[$m.'day'],'num=num+1',"date='".$date['today']."' and site=".$s.' and bbs='.$bbsuid);
	$LASTUID = getDbCnt($table[$m.'data'],'max(uid)','');
	if ($cuid) getDbUpdate($table['s_menu'],"num='".getDbCnt($table[$m.'month'],'sum(num)','site='.$s.' and bbs='.$bbsuid)."',d_last='".$d_regis."'",'uid='.$cuid);

  if ($point1&&$my['uid']) {
		getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','".$point1."','게시물(".getStrCut($subject,15,'').")포인트','".$date['totime']."'");
		getDbUpdate($table['s_mbrdata'],'point=point+'.$point1,'memberuid='.$my['uid']);
	}

	if ($gid == 100000000.00) {
		db_query("OPTIMIZE TABLE ".$table[$m.'idx'],$DB_CONNECT);
		db_query("OPTIMIZE TABLE ".$table[$m.'data'],$DB_CONNECT);
		db_query("OPTIMIZE TABLE ".$table[$m.'month'],$DB_CONNECT);
		db_query("OPTIMIZE TABLE ".$table[$m.'day'],$DB_CONNECT);
	}

}

$NOWUID = $LASTUID ? $LASTUID : $R['uid'];

if ($tag || $R['tag']) {
	$_tagarr1 = array();
	$_tagarr2 = explode(',',$tag);
  $_tagdate = $date['today'];

	if ($R['uid'] && $reply != 'Y') {
    $_tagdate = substr($R['d_regis'],0,8);
		$_tagarr1 = explode(',',$R['tag']);
		foreach($_tagarr1 as $_t) {
			if(!$_t || in_array($_t,$_tagarr2)) continue;
      $_TAG = getDbData($table['s_tag'],"site=".$R['site']." and date='".$_tagdate."' and keyword='".$_t."'",'*');
			if($_TAG['uid']) {
				if($_TAG['hit']>1) getDbUpdate($table['s_tag'],'hit=hit-1','uid='.$_TAG['uid']);
				else getDbDelete($table['s_tag'],'uid='.$_TAG['uid']);
			}
		}
	}

	foreach($_tagarr2 as $_t) {
		if(!$_t || in_array($_t,$_tagarr1)) continue;
		$_TAG = getDbData($table['s_tag'],'site='.$s." and date='".$_tagdate."' and keyword='".$_t."'",'*');
		if($_TAG['uid']) getDbUpdate($table['s_tag'],'hit=hit+1','uid='.$_TAG['uid']);
		else getDbInsert($table['s_tag'],'site,date,keyword,hit',"'".$s."','".$_tagdate."','".$_t."','1'");
	}
}

$_SESSION['bbsback'] = $backtype;

if ($reply == 'Y') $msg = '답변';
else if ($uid) $msg = '수정';
else $msg = '등록';

//알림 전송 (게시물 등록: 신규 게시물 등록시, 게시판 관리자에게 알림발송)
if ($d['bbs']['noti_newpost'] && !$my['admin']){
	include $g['dir_module'].'var/noti/_new.post.php';  // 알림메시지 양식
	$sendAdmins_array = explode(',',trim($d['bbs']['admin']));
	if (is_array($sendAdmins_array)) {
		foreach($sendAdmins_array as $val) {
			$_M = getDbData($table['s_mbrid'],'id="'.$val.'"','uid');
			$__M = getDbData($table['s_mbrdata'],'memberuid='.$_M['uid'],'memberuid,email,name,nic');
			if (!$_M['uid']) continue;

			$noti_title = $d['bbs']['noti_title'];
			$noti_title = str_replace('{BBS}',$name,$noti_title);
			$noti_body = $d['bbs']['noti_body'];
			$noti_body = str_replace('{MEMBER}',$my[$_HS['nametype']],$noti_body);
			$noti_body = str_replace('{SUBJECT}',$R['subject'],$noti_body);
			$noti_referer = $g['url_http'].'/?r='.$r.'&mod=settings&page=noti';
			$noti_button = '게시물 확인';
			$noti_tag = '';
			$noti_skipEmail = 0;
			$noti_skipPush = 0;

			putNotice($_M['uid'],$m,$my['uid'],$my[$_HS['nametype']].'님이 ['.$B['name'].'] 에 등록한 게시물('.$subject.')이 등록되었습니다..',$g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;project='.$_PROJECT['uid'].'&amp;task='.$taskUid,'');
		}
	}
}

if ($backtype == "ajax") {

	$result=array();
	$result['error']=false;

	$R = getUidData($table['bbsdata'],$NOWUID);

  if (!$uid) {
    $TMPL['category'] = $R['category'];
    $TMPL['subject'] = $R['subject'];
    $TMPL['bname'] = $B['name'];
    $TMPL['bid'] = $B['id'];
    $TMPL['uid'] = $R['uid'];
    $TMPL['name'] = $R[$_HS['nametype']];
    $TMPL['comment']=$R['comment'].($R['oneline']?'+'.$R['oneline']:'');
    $TMPL['hit'] = $R['hit'];
    $TMPL['likes'] = $R['likes'];
    $TMPL['d_regis'] = getDateFormat($R['d_regis'],'Y.m.d');
    $TMPL['d_regis_c']=getDateFormat($R['d_regis'],'c');
    $TMPL['avatar'] = getAvatarSrc($R['mbruid'],'84');
    $TMPL['url'] = '/'.$r.'/b/'.$R['bbsid'].'/'.$R['uid'];
    $TMPL['featured_img_sm'] = getPreviewResize(getUpImageSrc($R),'240x180');
    $TMPL['featured_img'] = getPreviewResize(getUpImageSrc($R),'480x270');
    $TMPL['featured_img_lg'] = getPreviewResize(getUpImageSrc($R),'686x386');
    $TMPL['featured_img_sq_200'] = getPreviewResize(getUpImageSrc($R),'200x200');
    $TMPL['featured_img_sq_300'] = getPreviewResize(getUpImageSrc($R),'300x300');
    $TMPL['featured_img_sq_600'] = getPreviewResize(getUpImageSrc($R),'600x600');
    $TMPL['has_featured_img'] = getUpImageSrc($R)=='/files/noimage.png'?'d-none':'';

    $TMPL['new']=getNew($R['d_regis'],24)?'':'d-none';
    $TMPL['hidden']=$R['hidden']?'':'d-none';
    $TMPL['notice']=$R['notice']?'':'d-none';
    $TMPL['upload']=$R['upload']?'':'d-none';

    $TMPL['timeago']=$d['theme']['timeago']?'data-plugin="timeago"':'';

    if (!$list_wrapper) {
      $skin_item=new skin($markup.'-item');
      $TMPL['items']=$skin_item->make();
      $skin=new skin($markup.'-list');
      $result['item']=$skin->make();
    } else {
      if ($notice) $skin=new skin('list-item-notice');
      else $skin=new skin($markup.'-item');
      $result['item']=$skin->make();
    }

    $result['notice']=$R['notice'];
    $result['uid']=$NOWUID;
    $result['depth']=$R['depth'];
    $result['media_object']=$d['theme']['media_object'];

  } else {
    $result['notice']=$R['notice'];
    $result['uid']=$NOWUID;
    $result['subject'] = $R['subject'];
    $result['content'] = getContents($R['content'],$R['html']);
  }

	echo json_encode($result);
	exit;

} else {

	setrawcookie('bbs_action_result', rawurlencode('게시물이 '.$msg.' 되었습니다.'));  // 처리여부 cookie 저장

	if (!$backtype || $backtype == 'list') {
		getLink($nlist,'parent.','','');
	} else if ($backtype == 'view') {
		if ($_HS['rewrite']&&!strstr($nlist,'&')) {
			getLink($nlist.'/'.$NOWUID,'parent.','','');
		} else {
			getLink($nlist.'&mod=view&uid='.$NOWUID,'parent.','','');
		}
	} else {
		getLink('reload','parent.','','');
	}
}

?>
