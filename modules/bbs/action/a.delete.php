<?php
if(!defined('__KIMS__')) exit;

$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) getLink('','','삭제되었거나 존재하지 않는 게시물입니다.','');
$B = getUidData($table[$m.'list'],$R['bbs']);
if (!$B['uid']) getLink('','','존재하지 않는 게시판입니다.','');

include_once $g['dir_module'].'var/var.php';
include_once $g['path_var'].'bbs/var.'.$B['id'].'.php';
include_once $g['path_module'].'mediaset/var/var.php';
include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

use Aws\S3\S3Client;

define('S3_KEY', $d['mediaset']['S3_KEY']); //발급받은 키.
define('S3_SEC', $d['mediaset']['S3_SEC'] ); //발급받은 비밀번호.
define('S3_REGION', $d['mediaset']['S3_REGION']);  //S3 버킷의 리전.
define('S3_BUCKET', $d['mediaset']['S3_BUCKET']); //버킷의 이름.

$backUrl = getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').($c?'c='.$c:'m='.$m),array('bid','skin','iframe','cat','p','sort','orderby','recnum','type','where','keyword'));

if ($my['uid'] != $R['mbruid'] && !$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].','))
{
	if (!strstr($_SESSION['module_'.$m.'_pwcheck'],$R['uid']))
	{
		if ($pw)
		{
			if (md5($pw) != $R['pw']) getLink('reload','parent.','비밀번호가 일치하지 않습니다.','');
		}
		else {
			getLink($backUrl.'&mod=delete&uid='.$R['uid'],'parent.','','');
		}
	}
}

if ($d['bbs']['commentdel'])
{
	if($R['comment'])
	{
		getLink('','','댓글이 있는 게시물은 삭제할 수 없습니다.','');
	}
}
if ($d['bbs']['replydel'])
{
	$_ngid = (int)$R['gid'];
	if(getDbRows($table[$m.'data'],'gid > '.$_ngid.' and gid < '.($_ngid+1)) && !$R['depth'])
	{
		getLink('','','답변글이 있는 게시물은 삭제할 수 없습니다.','');
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

					if ($U['host']==$d['mediaset']['ftp_urlpath'])
					{
						$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
						$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
						if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
						if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
						if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

						ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
						if($U['type']==2) ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
						ftp_close($FTP_CONNECT);

					} elseif ($U['fserver']==2) {

		        $s3->deleteObject([
		          'Bucket' => S3_BUCKET,
		          'Key'    => $U['folder'].'/'.$U['tmpname']
		        ]);

					} else {
						unlink($U['folder'].'/'.$U['tmpname']);
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

			if ($d['mediaset']['ftp_urlpath'] && ($U['host']==$d['mediaset']['ftp_urlpath']))
			{
				$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
				$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
				if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.1','');
				if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
				if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

				ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
				if($U['type']==2) ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
				ftp_close($FTP_CONNECT);

			} elseif ($U['fserver']==2) {

        $s3 = new S3Client([
          'version'     => 'latest',
          'region'      => S3_REGION,
          'credentials' => [
              'key'    => S3_KEY,
              'secret' => S3_SEC,
          ],
        ]);

				$s3->deleteObject([
					'Bucket' => S3_BUCKET,
					'Key'    => $U['folder'].'/'.$U['tmpname']
				]);

			} else {
				unlink($U['folder'].'/'.$U['tmpname']);
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

getDbUpdate($table[$m.'month'],'num=num-1',"date='".substr($R['d_regis'],0,6)."' and site=".$R['site'].' and bbs='.$R['bbs']);
getDbUpdate($table[$m.'day'],'num=num-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site'].' and bbs='.$R['bbs']);
getDbDelete($table[$m.'idx'],'gid='.$R['gid']);
getDbDelete($table[$m.'data'],'uid='.$R['uid']);
getDbDelete($table[$m.'xtra'],'parent='.$R['uid']);
getDbUpdate($table[$m.'list'],'num_r=num_r-1','uid='.$R['bbs']);
if ($cuid) getDbUpdate($table['s_menu'],"num='".getDbCnt($table[$m.'month'],'sum(num)','site='.$s.' and bbs='.$R['bbs'])."'",'uid='.$cuid);
getDbDelete($table['s_trackback'],"parent='".$R['bbsid'].$R['uid']."'");

if ($R['point1']&&$R['mbruid'])
{
	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point1']."','게시물삭제(".getStrCut($R['subject'],15,'').")환원','".$date['totime']."'");
	getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point1'],'memberuid='.$R['mbruid']);
}

if ($send=="ajax") {

	$bbsque = 'site='.$s.' and notice=0';
	$bbsque .= ' and bbs='.$B['uid'];
	$NUM = getDbRows($table[$m.'data'],$bbsque);

	$result=array();
	$result['error']=false;
	$result['num']=$NUM;
	echo json_encode($result);
	exit;

} else {

	setrawcookie('bbs_action_result', rawurlencode('게시물이 삭제 되었습니다.|default'));  // 처리여부 cookie 저장
	getLink($backUrl ,'parent.' , $alert , $history);

}

?>
