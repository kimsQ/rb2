<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) echo '[RESULT:로그인을 먼저 해주세요.:RESULT]';

$R = getUidData($table['s_comment'],$uid);
if (!$R['uid']) echo '[RESULT:존재하지 않는 댓글입니다.:RESULT]';

include $g['path_module'].'comment/var/var.php';

if ($d['comment']['singo_del'] && $d['comment']['singo_del_num'] <= $R['singo'])
{

	if ($d['comment']['singo_del_act'] == 1)
	{

		//동기화
		$cyncArr = getArrayString($R['cync']);
		$fdexp = explode(',',$cyncArr['data'][2]);
		if ($fdexp[0]&&$fdexp[1]&&$cyncArr['data'][3]) getDbUpdate($cyncArr['data'][3],$fdexp[1].'='.$fdexp[1].'-1',$fdexp[0].'='.$cyncArr['data'][1]);
		if ($fdexp[0]&&$fdexp[2]&&$cyncArr['data'][3]) getDbUpdate($cyncArr['data'][3],$fdexp[2].'='.$fdexp[2].'-'.$R['oneline'],$fdexp[0].'='.$cyncArr['data'][1]);

		//첨부파일삭제
		if ($R['upload'])
		{
			include_once $g['path_module'].'upload/var/var.php';
			$UPFILES = getArrayString($R['upload']);

			foreach($UPFILES['data'] as $_val)
			{
				$U = getUidData($table[$m.'upload'],$_val);
				if ($U['uid'])
				{
					getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
					getDbDelete($table[$m.'upload'],'uid='.$U['uid']);
					if ($U['host']==$d['upload']['ftp_urlpath'])
					{
						$FTP_CONNECT = ftp_connect($d['upload']['ftp_host'],$d['upload']['ftp_port']);
						$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['upload']['ftp_user'],$d['upload']['ftp_pass']);
						if (!$FTP_CONNECT) echo '[RESULT:FTP서버 연결에 문제가 발생했습니다.:RESULT]';//getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
						if (!$FTP_CRESULT) echo '[RESULT:FTP서버 아이디나 패스워드가 일치하지 않습니다.:RESULT]';//getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');

						ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
						if($U['type']==2) ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
						ftp_close($FTP_CONNECT);
					}
					else {

						//unlink($g['path_file'].$U['folder'].'/'.$U['tmpname']);
						//if($U['type']==2) unlink($g['path_file'].$U['folder'].'/'.$U['thumbname']);

					 	unlink('./modules/bbs/upload/'.$U['folder'].'/'.$U['tmpname']);
					   if($U['type']==2) unlink('./modules/bbs/upload/'.$U['folder'].'/'.$U['thumbname']);
					}
				}
			}
		}
		//한줄의견삭제
		if ($R['oneline'])
		{
			$_ONELINE = getDbSelect($table['s_oneline'],'parent='.$R['uid'],'*');
			while($_O=db_fetch_array($_ONELINE))
			{
				getDbUpdate($table['s_numinfo'],'oneline=oneline-1',"date='".substr($_O['d_regis'],0,8)."' and site=".$_O['site']);
				if ($_O['point']&&$_O['mbruid'])
				{
					getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$_O['mbruid']."','0','-".$_O['point']."','한줄의견삭제(".getStrCut(str_replace('&amp;',' ',strip_tags($_O['content'])),15,'').")환원','".$date['totime']."'");
					getDbUpdate($table['s_mbrdata'],'point=point-'.$_O['point'],'memberuid='.$_O['mbruid']);
				}
			}
			getDbDelete($table['s_oneline'],'parent='.$R['uid']);
		}

		getDbDelete($table['s_comment'],'uid='.$R['uid']);
		getDbUpdate($table['s_numinfo'],'comment=comment-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site']);


		if ($R['point']&&$R['mbruid'])
		{
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point']."','댓글삭제(".getStrCut($R['subject'],15,'').")환원','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point'],'memberuid='.$R['mbruid']);
		}

		$backUrl = getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').($c?'c='.$c:'m='.$m),array('skin','iframe','sort','orderby','recnum','where','keyword'));
		getLink($backUrl ,'parent.' , '신고건수 누적으로 삭제처리 되었습니다.' , $history);
	}
	else {
		getDbUpdate($table['s_comment'],'hidden=1','uid='.$R['uid']);
		$backUrl = getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').($c?'c='.$c:'m='.$m),array('skin','iframe','sort','orderby','recnum','where','keyword'));
		getLink($backUrl ,'parent.' , '신고건수 누적으로 게시제한처리 되었습니다.' , $history);
	}

}
else {

	if (!strstr($_SESSION['module_comment_singo'],'['.$R['uid'].']'))
	{
		getDbUpdate($table['s_comment'],'singo=singo+1','uid='.$R['uid']);
		$_SESSION['module_comment_singo'] .= '['.$R['uid'].']';
		echo '[RESULT:신고처리 되었습니다.:RESULT]';//getLink('','','신고처리 되었습니다.','');
	}
	else {
		echo '[RESULT:이미 신고하신 댓글입니다.:RESULT]'; // getLink('','','이미 신고하신 댓글입니다.','');
	}
}
?>
