<?php
if(!defined('__KIMS__')) exit;

if ($_POST['uid']) {
	$uid = $_POST['uid'];
	$R = getUidData($table[$m.'data'],$uid);
} else {
	$R=getDbData($table[$m.'data'],"cid='".$cid."'",'*');
}


if (!$R['uid']) getLink('','','삭제되었거나 존재하지 않는 포스트 입니다.','');

if ($my['uid'] != $R['mbruid'] && !$my['admin']) {
	getLink('','','잘못된 접속입니다.','');
}

include_once $g['dir_module'].'var/var.php';

include_once $g['path_module'].'mediaset/var/var.php';


if ($d['post']['commentdel'])
{
	if($R['comment'])
	{
		getLink('','','댓글이 있는 포스트는 삭제할 수 없습니다.','');
	}
}

//댓글삭제
if ($R['comment'])
{
	$CCD = getDbArray($table['s_comment'],"parent='".$m.$R['uid']."'",'*','uid','asc',0,0);

	while($_C=db_fetch_array($CCD))
	{
		if ($_C['upload'])
		{
			$UPFILES = getArrayString($_C['upload']);

			foreach($UPFILES['data'] as $_val)
			{
				$U = getUidData($table['s_upload'],$_val);
				if ($U['uid'])
				{
					getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
					getDbDelete($table['s_upload'],'uid='.$U['uid']);
					if ($U['host']==$d['upload']['ftp_urlpath'])
					{
						$FTP_CONNECT = ftp_connect($d['upload']['ftp_host'],$d['upload']['ftp_port']);
						$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['upload']['ftp_user'],$d['upload']['ftp_pass']);
						if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
						if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
						if($d['upload']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

						ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
						if($U['type']==2) ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
						ftp_close($FTP_CONNECT);
					}
					else {
						unlink($g['path_file'].$U['folder'].'/'.$U['tmpname']);
						if($U['type']==2) unlink($g['path_file'].$U['folder'].'/'.$U['thumbname']);
					}
				}
			}
		}
		if ($_C['oneline'])
		{
			$_ONELINE = getDbSelect($table['s_oneline'],'parent='.$_C['uid'],'*');
			while($_O=db_fetch_array($_ONELINE))
			{
				getDbUpdate($table['s_numinfo'],'oneline=oneline-1',"date='".substr($_O['d_regis'],0,8)."' and site=".$_O['site']);
				if ($_O['point']&&$_O['mbruid'])
				{
					getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$_O['mbruid']."','0','-".$_O['point']."','한줄의견삭제(".getStrCut(str_replace('&amp;',' ',strip_tags($_O['content'])),15,'').")환원','".$date['totime']."'");
					getDbUpdate($table['s_mbrdata'],'point=point-'.$_O['point'],'memberuid='.$_O['mbruid']);
				}
			}
			getDbDelete($table['s_oneline'],'parent='.$_C['uid']);
		}
		getDbDelete($table['s_comment'],'uid='.$_C['uid']);
		getDbUpdate($table['s_numinfo'],'comment=comment-1',"date='".substr($_C['d_regis'],0,8)."' and site=".$_C['site']);

		if ($_C['point']&&$_C['mbruid'])
		{
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$_C['mbruid']."','0','-".$_C['point']."','댓글삭제(".getStrCut($_C['subject'],15,'').")환원','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point-'.$_C['point'],'memberuid='.$_C['mbruid']);
		}
	}
}
//첨부파일삭제
if ($R['upload'])
{
	$UPFILES = getArrayString($R['upload']);

	foreach($UPFILES['data'] as $_val)
	{
		$U = getUidData($table['s_upload'],$_val);
		if ($U['uid'])
		{
			getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
			getDbDelete($table['s_upload'],'uid='.$U['uid']);
			if ($U['host'] && $U['host']==$d['upload']['ftp_urlpath'])
			{
				$FTP_CONNECT = ftp_connect($d['upload']['ftp_host'],$d['upload']['ftp_port']);
				$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['upload']['ftp_user'],$d['upload']['ftp_pass']);
				if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
				if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
				if($d['upload']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

				ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
				if($U['type']==2) ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
				ftp_close($FTP_CONNECT);
			}
			else {
				unlink($g['path_file'].$m.'/'.$U['folder'].'/'.$U['tmpname']);
			}
		}
	}
}
//태그삭제
if ($R['tag'])
{
	$_tagarr1 = explode(',',$R['tag']);
	foreach($_tagarr1 as $_t)
	{
		if(!$_t) continue;
		$_TAG = getDbData($table['s_tag'],"site=".$R['site']." and keyword='".$_t."'",'*');
		if($_TAG['uid'])
		{
			if($_TAG['hit']>1) getDbUpdate($table['s_tag'],'hit=hit-1','uid='.$_TAG['uid']);
			else getDbDelete($table['s_tag'],'uid='.$_TAG['uid']);
		}
	}
}

//카테고리 등록 포스트 수 조정
$IDX = getDbSelect($table[$m.'category_index'],'data='.$R['uid'],'*');
while($I=db_fetch_array($IDX)) {
	getDbUpdate($table[$m.'category'],'num=num-1','uid='.$I['category']);
}

//리스트 등록 포스트 수 조정
$IDX2 = getDbSelect($table[$m.'list_index'],'data='.$R['uid'],'*');
while($I2=db_fetch_array($IDX2)) {
	getDbUpdate($table[$m.'list'],'num=num-1','uid='.$I2['list']);
}

getDbDelete($table[$m.'data'],'uid='.$R['uid']); //데이터삭제
getDbDelete($table[$m.'index'],'gid='.$R['gid']); // 데이터 인덱스삭제
getDbDelete($table[$m.'category_index'],'data='.$R['uid']);//카테고리 인덱스삭제
getDbDelete($table[$m.'member'],'data='.$R['uid']);//멤버삭제
getDbDelete($table[$m.'list_index'],'data='.$R['uid']);//리스트 인덱스삭제

//회원의 등록수량 조절
getDbUpdate($table['s_mbrdata'],'num_post=num_post-1,hit_post=hit_post-'.$R['hit'].',likes_post=likes_post-'.$R['likes'].',dislikes_post=dislikes_post-'.$R['dislikes'],'memberuid='.$R['mbruid']);
getDbUpdate($table['s_mbrmonth'],'post_num=post_num-1',"date='".substr($R['d_regis'],0,6)."' and site=".$R['site'].' and mbruid='.$R['mbruid']);  // 회원의 월별통계 수량갱신
getDbUpdate($table['s_mbrday'],'post_num=post_num-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site'].' and mbruid='.$R['mbruid']);  //회원의 일별 수량갱신

//회원의 월총수량 조절 (조회수,좋아요,싫어요,댓글수)
$_MONTH = getDbSelect($table[$m.'month'],'data='.$R['uid'],'*');
while ($_M=db_fetch_array($_MONTH)) {
	getDbUpdate($table['s_mbrmonth'],'post_hit=post_hit-'.$_M['hit'].',post_likes=post_likes-'.$_M['likes'].',post_dislikes=post_dislikes-'.$_M['dislikes'].',post_comment=post_comment-'.$_M['comment'],"date='".$_M['date']."' and site=".$R['site'].' and mbruid='.$R['mbruid']);
}

//회원의 일총수량 조절 (조회수,좋아요,싫어요,댓글수)
$_DAY = getDbSelect($table[$m.'day'],'data='.$R['uid'],'*');
while ($_D=db_fetch_array($_DAY)) {
	getDbUpdate($table['s_mbrday'],'post_hit=post_hit-'.$_D['hit'].',post_likes=post_likes-'.$_D['likes'].',post_dislikes=post_dislikes-'.$_D['dislikes'].',post_comment=post_comment-'.$_D['comment'],"date='".$_D['date']."' and site=".$R['site'].' and mbruid='.$R['mbruid']);
}

//포스트의 수량 삭제 (조회수,추천수)
getDbDelete($table[$m.'month'],'data='.$R['uid']); //월 데이터삭제
getDbDelete($table[$m.'day'],'data='.$R['uid']); //일 데이터삭제


if ($R['point1']&&$R['mbruid'])
{
	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point1']."','포스트 삭제(".getStrCut($R['subject'],15,'').")환원','".$date['totime']."'");
	getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point1'],'memberuid='.$R['mbruid']);
}

// 피드 인덱스 삭제
$_FCD = getDbArray($table['s_friend'],'by_mbruid='.$my['uid'],'my_mbruid','uid','asc',0,1);
while ($_F=db_fetch_array($_FCD)) {
  $mbruid		= $_F['my_mbruid'];
  $module 	= $m;
  $entry		= $R['uid'];
  $check_feed_qry = "mbruid='".$mbruid."' and module='".$module."' and entry='".$entry."'";
  $is_feed = getDbRows($table['s_feed'],$check_feed_qry);
  if ($is_feed) getDbDelete($table['s_feed'],$check_feed_qry);
}


if ($send_mod=='ajax') {

	$result=array();
	$result['error'] = false;
	echo json_encode($result);
	exit;

} else {

	setrawcookie('post_action_result', rawurlencode('포스트가 삭제 되었습니다.|success'));  // 처리여부 cookie 저장

	if ($usertype=='admin') getLink('reload','parent.' , $alert , $history);
	else getLink(RW('mod=dashboard&page=post') ,'parent.' , $alert , $history);
}

?>
