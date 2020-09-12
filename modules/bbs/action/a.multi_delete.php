<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/mediaset.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['path_module'].'mediaset/var/var.php';

include $g['path_core'].'function/rss.func.php';

include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

use Aws\S3\S3Client;

define('S3_KEY', $d['mediaset']['S3_KEY']); //발급받은 키.
define('S3_SEC', $d['mediaset']['S3_SEC'] ); //발급받은 비밀번호.
define('S3_REGION', $d['mediaset']['S3_REGION']);  //S3 버킷의 리전.
define('S3_BUCKET', $d['mediaset']['S3_BUCKET']); //버킷의 이름.

$s3 = new S3Client([
	'version'     => 'latest',
	'region'      => S3_REGION,
	'credentials' => [
			'key'    => S3_KEY,
			'secret' => S3_SEC,
	],
]);

foreach ($post_members as $val)
{
	$R = getUidData($table[$m.'data'],$val);
	if (!$R['uid']) continue;
	$B = getUidData($table[$m.'list'],$R['bbs']);
	if (!$B['uid']) continue;

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

						if ($U['fserver']==2)
						{
							$host_array = explode('//', $U['host']);
							$_host_array = explode('.', $host_array[1]);
							$S3_BUCKET = $_host_array[0];

							$s3->deleteObject([
								'Bucket' => $S3_BUCKET,
								'Key'    => $U['folder'].'/'.$U['tmpname']
							]);
						}
						else {
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

				if ($U['fserver']==2)
				{
					$host_array = explode('//', $U['host']);
					$_host_array = explode('.', $host_array[1]);
					$S3_BUCKET = $_host_array[0];

					$s3->deleteObject([
						'Bucket' => $S3_BUCKET,
						'Key'    => $U['folder'].'/'.$U['tmpname']
					]);
				}
				else {
					unlink($U['folder'].'/'.$U['tmpname']);
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
	getDbDelete($table[$m.'xtra'],'parent='.$R['uid']);
	getDbUpdate($table[$m.'list'],'num_r=num_r-1','uid='.$R['bbs']);
	getDbDelete($table['s_trackback'],"parent='".$R['bbsid'].$R['uid']."'");


	if ($R['point1']&&$R['mbruid'])
	{
		getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point1']."','게시물삭제(".getStrCut($R['subject'],15,'').")환원','".$date['totime']."'");
		getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point1'],'memberuid='.$R['mbruid']);
	}

}

setrawcookie('bbs_post_result', rawurlencode('게시물이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
