<?php
if(!defined('__KIMS__')) exit;


include_once $g['path_module'].'mediaset/var/var.php';
include_once $g['dir_module'].'var/var.php';

foreach ($post_members as $val)
{

	$R = getUidData($table[$m.'data'],$val);
	if (!$R['uid']) continue;
	$B = getUidData($table[$m.'list'],$R['bbs']);
	if (!$B['uid']) continue;

    if ($my['uid'] != $R['mbruid'])
    {

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
	//태그삭제
	if ($R['tag'])
	{
		$_tagdate = substr($R['d_regis'],0,8);
		$_tagarr1 = explode(',',$R['tag']);
		foreach($_tagarr1 as $_t)
		{
			if(!$_t) continue;
			$_TAG = getDbData($table['s_tag'],"site=".$R['site']." and date='".$_tagdate."' and keyword='".$_t."'",'*');
			if($_TAG['uid'])
			{
				if($_TAG['hit']>1) getDbUpdate($table['s_tag'],'hit=hit-1','uid='.$_TAG['uid']);
				else getDbDelete($table['s_tag'],'uid='.$_TAG['uid']);
			}
		}
	}

	getDbUpdate($table[$m.'month'],'num=num-1',"date='".substr($R['d_regis'],0,6)."' and site=".$R['site'].' and bbs='.$R['bbs']);
	getDbUpdate($table[$m.'day'],'num=num-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site'].' and bbs='.$R['bbs']);
	getDbDelete($table[$m.'idx'],'gid='.$R['gid']);
	getDbDelete($table[$m.'data'],'uid='.$R['uid']);
	getDbUpdate($table[$m.'list'],'num_r=num_r-1','uid='.$R['bbs']);
	getDbDelete($table['s_trackback'],"parent='".$R['bbsid'].$R['uid']."'");


	if ($R['point1']&&$R['mbruid'])
	{
		getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point1']."','게시물삭제(".getStrCut($R['subject'],15,'').")환원','".$date['totime']."'");
		getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point1'],'memberuid='.$R['mbruid']);
	}

}


getLink('reload','parent.','','');
?>
