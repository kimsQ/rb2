<?php
if(!defined('__KIMS__')) exit;
require_once $g['dir_module'].'includes/base.class.php';
require_once $g['dir_module'].'includes/module.class.php';
include $g['dir_module'].'var/var.php';
include $g['dir_module'].'var/noti/_'.$a.'.php';  // 알림메시지 양식

function _getPostLink($arr)
{
	$sync_arr=explode('|',$arr['sync']);
	$B = getUidData($sync_arr[0],$sync_arr[2]);
	return RW('m='.$sync_arr[1].'&bid='.$B['bbsid'].'&uid='.$sync_arr[2].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''.'#CMT-'.$arr['uid']));
}

$comment = new Comment();
$comment->theme_name = $_POST['theme_name'];
$comment->recnum = $_POST['recnum'];

$result = array();
$result['error'] = false;

if (!$sess_code){
	$result['error'] = true;
	$result['error_msg'] = '정상적인 접근이 아닙니다.';
  echo json_encode($result);
	exit;
}else{
	$mbruid		= $my['uid'];
	$id			= $my['id'];
	$name		= $my['uid'] ? $my['name'] : trim($name);
	$nic		= $my['uid'] ? $my['nic'] : $name;
	$pw			= $pw ? md5($pw) : '';
	$subject	= $my['admin'] ? trim($subject) : htmlspecialchars(trim($subject));
	$content	= trim($content);
	$subject	= $subject ? $subject : getStrCut(str_replace('&amp;',' ',strip_tags($content)),35,'..');
	$html		= $html ? $html : 'TEXT';
	$d_regis	= $date['totime'];
	$d_modify	= '';
	$d_oneline	= '';
	$ip			= $_SERVER['REMOTE_ADDR'];
	$agent		= $_SERVER['HTTP_USER_AGENT'];
	//$upload		= $upfiles; // upfiles 값을 배열로 받아서 풀어서 upload 에 저장한다.  아래 참조
	$adddata	= trim($adddata);
	$hit		= 0;
	$down		= 0;
	$oneline	= 0;
	$likes		= 0;
	$dislikes		= 0;
	$report		= 0;
	$point		= $d['comment']['give_point'];
	$hidden		= ($hidden=='true') ? 1 : 0;
	$notice		= $notice ? intval($notice) : 0;
	$display	= $hidepost || $hidden ? 0 : 1;

	// 포토, 장소, 링크 존재여부
	$is_photo=0;
	$is_link=0;
	$is_place=0;

	if ($d['comment']['badword_action'])
	{
		$badwordarr = explode(',' , $d['comment']['badword']);
		$badwordlen = count($badwordarr);
		for($i = 0; $i < $badwordlen; $i++)
		{
			if(!$badwordarr[$i]) continue;
			if(strstr($subject,$badwordarr[$i]) || strstr($content,$badwordarr[$i]))
			{
				if ($d['comment']['badword_action'] == 1)
				{
					$result['error'] = true;
					$result['error_msg'] = '등록이 제한된 단어를 사용하셨습니다.';
				    echo json_encode($result);
					exit;
				}
				else {
					$badescape = strCopy($badwordarr[$i],$d['comment']['badword_escape']);
					$content = str_replace($badwordarr[$i],$badescape,$content);
					$subject = str_replace($badwordarr[$i],$badescape,$subject);
				}
			}
		}
	}
  // 업로드 파일 세팅
	if($upfiles)
	{
		$upload='';
		foreach ($upfiles as $file) {
	      $upload .=$file;
		}
		$upload=trim($upload);
		$is_photo=1;
  }

	if ($uid)
	{
		$R = getUidData($comment->commentTable,$uid);

		if (!$R['uid']){
			$result['error'] = true;
			$result['error_msg'] = '존재하지 않는 댓글입니다.';
		    echo json_encode($result);
			exit;
		}

		if (!$my['uid'] || ($my['uid'] != $R['mbruid'] && !$my['admin']))
		{
			if (!$pw)
			{
				$result['error'] = true;
				$result['error_msg'] = '정상적인 접근이 아닙니다.';
			    echo json_encode($result);
				exit;
			}
			else {
				if($pw != $R['pw'])
				{
					$result['error'] = true;
					$result['error_msg'] = '정상적인 접근이 아닙니다.';
				    echo json_encode($result);
					exit;
				}
			}
		}

		$QVAL = "display='$display',hidden='$hidden',subject='$subject',content='$content',html='$html',";
		$QVAL .="d_modify='$d_regis',upload='$upload',adddata='$adddata'";
		getDbUpdate($comment->commentTable,$QVAL,'uid='.$R['uid']);
    $result['edit_content'] = $content;
    $result['edit_uid'] = $uid;
		$result['edit_hidden'] = $hidden;
    $result['edit_time'] = getDateFormat($d_regis,'c');
		echo json_encode($result);
    exit;

	}
	else
	{
		// $parent_set  가공
		$parent_arr=explode('-',$parent);
		$parent_prefix = $parent_arr[0];
		$parent_uid = $parent_arr[1];
		$parent_set=str_replace('-','', $parent);

		$R = getUidData($parent_table,$parent_uid);
		getDbUpdate($parent_table,"comment=comment+1,d_comment='".$date['totime']."'",'uid='.$R['uid']);
		$parentmbr = $R['mbruid'];
		$sync = $parent_table.'|'.$parent_prefix.'|'.$parent_uid;
		$minuid = getDbCnt($comment->commentTable,'min(uid)','');
		$uid = $minuid ? $minuid-1 : 1000000000;

		$QKEY = "uid,site,parent,parentmbr,display,hidden,notice,name,nic,mbruid,id,pw,subject,content,html,";
		$QKEY.= "hit,down,oneline,likes,dislikes,report,point,d_regis,d_modify,d_oneline,upload,ip,agent,sync,sns,adddata";
		$QVAL = "'$uid','$s','".$parent_set."','$parentmbr','$display','$hidden','$notice','$name','$nic','$mbruid','$id','$pw','$subject','$content','$html',";
		$QVAL.= "'$hit','$down','$oneline','$likes','$dislikes','$report','$point','$d_regis','$d_modify','$d_oneline','$upload','$ip','$agent','$sync','','$adddata'";
		getDbInsert($comment->commentTable,$QKEY,$QVAL);
		getDbUpdate($table['s_numinfo'],'comment=comment+1',"date='".$date['today']."' and site=".$s);

		if ($uid == 1000000000) db_query("OPTIMIZE TABLE ".$table['s_comment'],$DB_CONNECT);
		if ($point&&$my['uid'])
		{
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','".$point."','댓글(".getStrCut($subject,15,'').")포인트','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point+'.$point,'memberuid='.$my['uid']);
		}

    $LASTUID = getDbCnt($comment->commentTable,'min(uid)','');
    $row = getUidData($comment->commentTable,$LASTUID);


		//  연동모듈 댓글통계 반영
		if(!getDbRows($table['s_mbrmonth'],"date='".$date['month']."' and site=".$s.' and mbruid='.$row['parentmbr'])) {
		  getDbInsert($table['s_mbrmonth'],'date,site,mbruid',"'".$date['month']."','".$s."','".$row['parentmbr']."'");
		}

		if(!getDbRows($table['s_mbrday'],"date='".$date['today']."' and site=".$s.' and mbruid='.$row['parentmbr'])) {
		  getDbInsert($table['s_mbrday'],'date,site,mbruid',"'".$date['today']."','".$s."','".$row['parentmbr']."'");
		}

		if(!getDbRows($table[$parent_prefix.'month'],"date='".$date['month']."' and site=".$s.' and data='.$parent_uid)) {
		  getDbInsert($table[$parent_prefix.'month'],'date,site,data',"'".$date['month']."','".$s."','".$parent_uid."'");
		}

		if(!getDbRows($table[$parent_prefix.'day'],"date='".$date['today']."' and site=".$s.' and data='.$parent_uid)) {
		  getDbInsert($table[$parent_prefix.'day'],'date,site,data',"'".$date['today']."','".$s."','".$parent_uid."'");
		}

		getDbUpdate($table['s_mbrmonth'],'post_comment=post_comment+1',"date='".$date['month']."' and site=".$s.' and mbruid='.$row['parentmbr']); //부모글 등록자 월별 조회수 갱신
		getDbUpdate($table['s_mbrday'],'post_comment=post_comment+1',"date='".$date['today']."' and site=".$s.' and mbruid='.$row['parentmbr']); //부모글 등록자 일별조회수 갱신
		getDbUpdate($table[$parent_prefix.'month'],'comment=comment+1',"date='".$date['month']."' and site=".$s.' and data='.$parent_uid); //연동모듈 월별 조회수 갱신
		getDbUpdate($table[$parent_prefix.'day'],'comment=comment+1',"date='".$date['today']."' and site=".$s.' and data='.$parent_uid);  //연동모듈 일별 조회수 갱신


		// 댓글의 부모글 등록자에게 알림전송
		if ($row['parentmbr'] != $my['uid'] ) {

			$B = getDbData($table['bbslist'],'id="'.$R['bbsid'].'"','name');

			//알림내용에 양식 적용(/modules/comment/var/noti/regis_comment.php)
			$noti_title = $d['comment']['noti_title'];
			$noti_body = $d['comment']['noti_body'];
			$noti_referer = _getPostLink($row);
			$noti_button = $d['comment']['noti_button'];
			$noti_tag = '';

			// 내용 치환
			$noti_title = str_replace('{NAME}',$my['name'],$noti_title); //댓글등록자 이름
			$noti_title = str_replace('{NIC}',$my['nic'],$noti_title); //댓글등록자 닉네임
			$noti_body = str_replace('{NAME}',$my['name'],$noti_body); //댓글등록자 이름
			$noti_body = str_replace('{NIC}',$my['nic'],$noti_body); //댓글등록자 닉네임
			$noti_body = str_replace('{BBS}',$B['name'],$noti_body); //게시판명
			$noti_body = str_replace('{SUBJECT}',$subject,$noti_body); //댓글내용

			putNotice($row['parentmbr'],$m,$my['uid'],$noti_title,$noti_body,$noti_referer,$noti_button,$noti_tag,'','');
		}

    $result['last_row'] = $comment->getCommentRow($row,$p,0);
    $result['lastuid'] = $LASTUID;
    $result['parent_table'] = $parent_table;
    $result['sess_code'] = $sess_code;
    echo json_encode($result);

    exit;

	}
	// 신규등록
}
?>
