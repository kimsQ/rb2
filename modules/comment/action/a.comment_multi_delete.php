<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

foreach($comment_members as $val)
{
	$R = getUidData($table['s_comment'],$val);
	if (!$R['uid']) continue;

	//동기화
	$syncArr = getArrayString($R['sync']);
	$fdexp = explode(',',$syncArr['data'][2]);
	if ($fdexp[0]&&$fdexp[1]&&$syncArr['data'][3]) getDbUpdate($syncArr['data'][3],$fdexp[1].'='.$fdexp[1].'-1',$fdexp[0].'='.$syncArr['data'][1]);
	if ($fdexp[0]&&$fdexp[2]&&$syncArr['data'][3]) getDbUpdate($syncArr['data'][3],$fdexp[2].'='.$fdexp[2].'-'.$R['oneline'],$fdexp[0].'='.$syncArr['data'][1]);

	//첨부파일삭제
	if ($R['upload'])
	{
		include_once $g['path_module'].'mediaset/var/var.php';
		$UPFILES = getArrayString($R['upload']);

		foreach($UPFILES['data'] as $_val)
		{
			$U = getUidData($table['bbsupload'],$_val);
			if ($U['uid'])
			{
				getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
				getDbDelete($table['bbsupload'],'uid='.$U['uid']);

				if ($U['host']==$d['upload']['ftp_urlpath'])
				{
					$FTP_CONNECT = ftp_connect($d['upload']['ftp_host'],$d['upload']['ftp_port']);
					$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['upload']['ftp_user'],$d['upload']['ftp_pass']);
					if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
					if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');

					ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
					if($U['type']==2) ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
					ftp_close($FTP_CONNECT);
				}
				else {
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

}
setrawcookie('comment_post_result', rawurlencode('댓글이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
