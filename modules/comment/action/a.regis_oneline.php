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

$result = array();
$result['error'] = false;
$R = getUidData($comment->commentTable,$parent);
if (!$my['uid'] || !$R['uid']){
	$result['error'] = true;
	$result['error_msg'] = '정상적인 접근이 아닙니다.';
    echo json_encode($result);
	exit;

}else{
  $parentmbr	= $R['mbruid'];
	$mbruid		= $my['uid'];
	$id			= $my['id'];
	$name		= $my['uid'] ? $my['name'] : trim($name);
	$nic		= $my['uid'] ? $my['nic'] : $name;
	$pw			= $pw ? md5($pw) : '';
	$content	= trim($content);
	$html		= $html ? $html : 'TEXT';
	$report		= 0;
	$hidden		= ($hidden=='true') ? 1 : 0;
	$point		= $d['comment']['give_opoint'];
	$d_regis	= $date['totime'];
	$d_modify	= '';
	$d_oneline	= '';
	$ip			= $_SERVER['REMOTE_ADDR'];
	$agent		= $_SERVER['HTTP_USER_AGENT'];
	$adddata	= trim($adddata);


	if ($d['comment']['badword_action'])
	{
		$badwordarr = explode(',' , $d['comment']['badword']);
		$badwordlen = count($badwordarr);
		for($i = 0; $i < $badwordlen; $i++)
		{
			if(!$badwordarr[$i]) continue;

			if(strstr($content,$badwordarr[$i]))
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
				}
			}
		}
	}

	if ($uid)
	{
		$R = getUidData($comment->onelineTable,$uid);
		if((!$my['admin'] && $my['uid'] != $R['mbruid'])||!$R['uid']){
      $result['error'] = true;
			$result['error_msg'] = '정상적인 접근이 아닙니다.';
			$result['mbruid'] = $R['mbruid'];
			$result['uid'] = $R['uid'];
		    echo json_encode($result);
			exit;
        }

		$QVAL = "hidden='$hidden',content='$content',html='$html',d_modify='$d_regis',adddata='$adddata'";
		getDbUpdate($comment->onelineTable,$QVAL,'uid='.$R['uid']);

		$result['edit_content'] = $content;
    $result['edit_uid'] = $uid;
		$result['edit_hidden'] = $hidden;
    $result['edit_time'] = getDateFormat($d_regis,'c');
		echo json_encode($result);
    exit;
	}
	else
	{

		$maxuid = getDbCnt($comment->onelineTable,'max(uid)','');
		$uid = $maxuid ? $maxuid+1 : 1;

		$QKEY = "uid,site,parent,parentmbr,hidden,name,nic,mbruid,id,content,html,report,point,d_regis,d_modify,ip,agent,adddata";
		$QVAL = "'$uid','$s','$parent','$parentmbr','$hidden','$name','$nic','$mbruid','$id','$content','$html','$report','$point','$d_regis','$d_modify','$ip','$agent','$adddata'";
		getDbInsert($comment->onelineTable,$QKEY,$QVAL);
		getDbUpdate($comment->commentTable,"oneline=oneline+1,d_oneline='".$d_regis."'",'uid='.$parent);
		getDbUpdate($grant_table,"oneline=oneline+1",'uid='.$grant); // 댓글의 parent = grant
		getDbUpdate($table['s_numinfo'],'oneline=oneline+1',"date='".$date['today']."' and site=".$s);

		if ($uid == 1) db_query("OPTIMIZE TABLE ".$table['s_oneline'],$DB_CONNECT);

		if ($point&&$my['uid'])
		{
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','".$point."','한줄의견(".getStrCut(str_replace('&amp;',' ',strip_tags($content)),15,'').")포인트','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point+'.$point,'memberuid='.$my['uid']);
		}

		$LASTUID = getDbCnt($comment->onelineTable,'max(uid)','');
    $row = getUidData($comment->onelineTable,$LASTUID);


		// 한줄의견의 부모댓글 등록자에게 알림전송
		if ($row['parentmbr'] != $my['uid'] ) {

			$B = getDbData($table['bbslist'],'id="'.$R['bbsid'].'"','name');

			//알림내용에 양식 적용(/modules/comment/var/noti/regis_oneline.php)
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
			$noti_body = str_replace('{COMMENT}',$R['subject'],$noti_body); //댓글제목
			$noti_body = str_replace('{SUBJECT}',$content,$noti_body); //의견내용

			putNotice($row['parentmbr'],$m,$my['uid'],$noti_title,$noti_body,$noti_referer,$noti_button,$noti_tag,'','');
		}


    $result['last_row'] = $comment->getOnelineRow($row,$p);
    $result['lastuid'] = $LASTUID;
    $result['grant_table'] = $grant_table;
    $result['grant'] = $grant;

    echo json_encode($result);
    exit;
	}
}

?>
