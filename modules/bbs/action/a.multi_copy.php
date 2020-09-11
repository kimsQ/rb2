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

$str_month = '';
$str_today = '';
$B = getUidData($table[$m.'list'],$bid);
$fserver  = $d['mediaset']['use_fileserver'];
sort($post_members);
reset($post_members);

foreach ($post_members as $val)
{

	$R = getUidData($table[$m.'data'],$val);
	if (!$R['uid']) continue;

	$mingid = getDbCnt($table[$m.'data'],'min(gid)','');
	$gid = $mingid ? $mingid-1 : 100000000.00;

	if (!$inc_comment)
	{
		$R['comment'] = 0;
		$R['oneline'] = 0;
	}
	if (!$inc_upload)
	{
		$R['upload'] = '';
	}

	$month = substr($R['d_regis'],0,6);
	$today = substr($R['d_regis'],0,8);

	//게시물복사
	$QKEY = "site,gid,bbs,bbsid,depth,parentmbr,display,hidden,notice,name,nic,mbruid,id,pw,category,subject,content,html,tag,";
	$QKEY.= "hit,down,comment,oneline,trackback,likes,dislikes,report,point1,point2,point3,point4,d_regis,d_modify,d_comment,d_trackback,upload,ip,agent,sns,location,pin,adddata";
	$QVAL = "'".$R['site']."','$gid','".$B['uid']."','".$B['id']."','".$R['depth']."','".$R['parentmbr']."','".$R['display']."','".$R['hidden']."','".$R['notice']."',";
	$QVAL.= "'".addslashes($R['name'])."','".addslashes($R['nic'])."','".$R['mbruid']."','".$R['id']."','".$R['pw']."','".addslashes($R['category'])."','".addslashes($R['subject'])."',";
	$QVAL.= "'".addslashes($R['content'])."','".$R['html']."','".addslashes($R['tag'])."',";
	$QVAL.= "'".$R['hit']."','".$R['down']."','".$R['comment']."','".$R['oneline']."','0','".$R['likes']."','".$R['dislikes']."','".$R['report']."','0','".$R['point2']."','".$R['point3']."','".$R['point4']."',";
	$QVAL.= "'".$R['d_regis']."','".$R['d_modify']."','".$R['d_comment']."','".$R['d_trackback']."','".$R['upload']."','".$R['ip']."','".$R['agent']."','".$R['sns']."','".$R['location']."','".$R['pin']."','".addslashes($R['adddata'])."'";
	getDbInsert($table[$m.'data'],$QKEY,$QVAL);
	getDbInsert($table[$m.'idx'],'site,notice,bbs,gid',"'".$R['site']."','".$R['notice']."','".$B['uid']."','$gid'");
	getDbUpdate($table[$m.'list'],"num_r=num_r+1",'uid='.$B['uid']);

	if(!strstr($str_month,'['.$month.']') && !getDbRows($table[$m.'month'],"date='".$month."' and site=".$R['site'].' and bbs='.$B['uid']))
	{
		getDbInsert($table[$m.'month'],'date,site,bbs,num',"'".$month."','".$R['site']."','".$B['uid']."','1'");
		$str_month .= '['.$month.']';
	}
	else {
		getDbUpdate($table[$m.'month'],'num=num+1',"date='".$month."' and site=".$R['site'].' and bbs='.$B['uid']);
	}

	if(!strstr($str_today,'['.$today.']') && !getDbRows($table[$m.'day'],"date='".$today."' and site=".$site.' and bbs='.$bbsuid))
	{
		getDbInsert($table[$m.'day'],'date,site,bbs,num',"'".$today."','".$R['site']."','".$B['uid']."','1'");
		$str_today .= '['.$today.']';
	}
	else {
		getDbUpdate($table[$m.'day'],'num=num+1',"date='".$today."' and site=".$R['site'].' and bbs='.$B['uid']);
	}

	$NOWUID = getDbCnt($table[$m.'data'],'max(uid)','');


	//댓글복사
	if ($inc_comment && $R['comment'])
	{

		$CCD = getDbArray($table['s_comment'],"parent='".$m.$R['uid']."'",'*','uid','desc',0,0);

		while($_C=db_fetch_array($CCD))
		{

			$comment_minuid = getDbCnt($table['s_comment'],'min(uid)','');
			$comment_uid = $comment_minuid ? $comment_minuid-1 : 100000000;
			$comment_sync = '['.$m.']['.$NOWUID.'][uid,comment,oneline,d_comment]['.$table[$m.'data'].']['.$_C['parentmbr'].'][m:'.$m.',bid:'.$B['id'].',uid:'.$NOWUID.']';

			$QKEY = "uid,site,parent,parentmbr,display,hidden,notice,name,nic,mbruid,id,pw,subject,content,html,";
			$QKEY.= "hit,down,oneline,likes,dislikes,report,d_regis,d_modify,d_oneline,upload,ip,agent,sync,sns,adddata";
			$QVAL = "'$comment_uid','".$_C['site']."','".$m.$NOWUID."','".$_C['parentmbr']."','".$_C['display']."','".$_C['hidden']."','".$_C['notice']."','".addslashes($_C['name'])."','".addslashes($_C['nic'])."',";
			$QVAL.= "'".$_C['mbruid']."','".$_C['id']."','".$_C['pw']."','".addslashes($_C['subject'])."','".addslashes($_C['content'])."','".$_C['html']."',";
			$QVAL.= "'".$_C['hit']."','".$_C['down']."','".$_C['oneline']."','".$_C['likes']."','".$_C['dislikes']."','".$_C['report']."','".$_C['d_regis']."','".$_C['d_modify']."','".$_C['d_oneline']."',";
			$QVAL.= "'".$_C['upload']."','".$_C['ip']."','".$_C['agent']."','$comment_sync','".$_C['sns']."','".addslashes($_C['adddata'])."'";
			getDbInsert($table['s_comment'],$QKEY,$QVAL);
			getDbUpdate($table['s_numinfo'],'comment=comment+1',"date='".substr($_C['d_regis'],0,8)."' and site=".$_C['site']);

			if ($_C['oneline'])
			{
				$_ONELINE = getDbSelect($table['s_oneline'],'parent='.$_C['uid'],'*');
				while($_O=db_fetch_array($_ONELINE))
				{
					$oneline_maxuid = getDbCnt($table['s_oneline'],'max(uid)','');
					$oneline_uid = $oneline_maxuid ? $oneline_maxuid+1 : 1;

					$QKEY = "uid,site,parent,parentmbr,hidden,name,nic,mbruid,id,content,html,likes,dislikes,report,d_regis,d_modify,ip,agent,adddata";
					$QVAL = "'$oneline_uid','".$_O['site']."','$comment_uid','".$_O['parentmbr']."','".$_O['hidden']."','".addslashes($_O['name'])."','".addslashes($_O['nic'])."','".$_O['mbruid']."',";
					$QVAL.= "'".$_O['id']."','".addslashes($_O['content'])."','".$_O['html']."','".$_O['likes']."','".$_O['dislikes']."','".$_O['report']."','".$_O['d_regis']."','".$_O['d_modify']."','".$_O['ip']."','".$_O['agent']."',";
					$QVAL.= "'".addslashes($_O['adddata'])."'";
					getDbInsert($table['s_oneline'],$QKEY,$QVAL);
					getDbUpdate($table['s_numinfo'],'oneline=oneline+1',"date='".substr($_O['d_regis'],0,8)."' and site=".$_O['site']);

				}
			}

			if ($inc_upload && $_C['upload'])
			{
				$UPFILES   = getArrayString($_C['upload']);
				$tmpupload = '';
				$_content  = $_C['content'];

				foreach($UPFILES['data'] as $_val)
				{
					$U = getUidData($table['s_upload'],$_val);
					if ($U['uid'])
					{
						$_tmpname = md5($U['tmpname']).'.'.getExt($U['tmpname']);

						if ($fserver==2)
						{

							$_downfile = getUrlData($U['src'],10);
							$saveFile = $g['path_tmp'].'session/'.$U['tmpname'];
							$fp = fopen($saveFile,'w');
							fwrite($fp,$_downfile);
							fclose($fp);
							@chmod($saveFile,0707);

							$upload_host= 'https://'.S3_BUCKET.'.s3.'.S3_REGION.'.amazonaws.com';
			        $upload_src = $upload_host.'/'.$U['folder'].'/'.$_tmpname;

			        try {
			          $s3->putObject(Array(
			              'ACL'=>'public-read',
			              'SourceFile'=>$saveFile,
			              'Bucket'=>S3_BUCKET,
			              'Key'=>$U['folder'].'/'.$_tmpname,
			          ));
								@unlink($saveFile);
			        } catch (Aws\S3\Exception\S3Exception $e) {
			          $result['error'] = 'AwS S3에 파일을 업로드하는 중 오류가 발생했습니다.';
			        }



						}
						else {
							copy('./'.$U['folder'].'/'.$U['tmpname'],'./'.$U['folder'].'/'.$_tmpname);
							$upload_src = '/'.$U['folder'].'/'.$_tmpname;
						}

						$upload_mingid = getDbCnt($table['s_upload'],'min(gid)','');
						$upload_gid = $upload_mingid ? $upload_mingid - 1 : 100000000;

						$QKEY = "gid,hidden,tmpcode,site,mbruid,type,ext,fserver,host,folder,name,tmpname,src,size,width,heigth,caption,down,d_regis,d_update,sync";
						$QVAL = "'".$upload_gid."','".$U['hidden']."','','".$U['site']."','".$U['mbruid']."','".$U['type']."','".$U['ext']."','".$U['fserver']."','".$U['host']."','".$U['folder']."',";
						$QVAL.= "'".addslashes($U['name'])."','".$_tmpname."','".$upload_src."','".$U['size']."','".$U['width']."','".$U['height']."','".addslashes($U['caption'])."',";
						$QVAL.= "'".$U['down']."','".$U['d_regis']."','".$U['d_update']."',''";
						getDbInsert($table['s_upload'],$QKEY,$QVAL);
						getDbUpdate($table['s_numinfo'],'upload=upload+1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);

						$tmpupload .= '['.getDbCnt($table['s_upload'],'max(uid)','').']';
						$_content = str_replace($U['tmpname'],$_tmpname,$_content);

					}
				}
				getDbUpdate($table['s_comment'],"content='".addslashes($_content)."',upload='".$tmpupload."'",'uid='.$comment_uid);
			}
		}
	}

	//첨부파일복사
	if ($inc_upload && $R['upload'])
	{

		$UPFILES   = getArrayString($R['upload']);
		$tmpupload = '';
		$_content1 = $R['content'];

		foreach($UPFILES['data'] as $_val)
		{
			$U = getUidData($table['s_upload'],$_val);
			if ($U['uid'])
			{
				$_tmpname = md5($U['tmpname']).'.'.getExt($U['tmpname']);

				if ($fserver==2)
				{

					$_downfile = getUrlData($U['src'],10);
					$saveFile = $g['path_tmp'].'session/'.$U['tmpname'];
					$fp = fopen($saveFile,'w');
					fwrite($fp,$_downfile);
					fclose($fp);
					@chmod($saveFile,0707);

	        $upload_host= 'https://'.S3_BUCKET.'.s3.'.S3_REGION.'.amazonaws.com';
	        $upload_src = $upload_host.'/'.$U['folder'].'/'.$_tmpname;

	        try {
	          $s3->putObject(Array(
	              'ACL'=>'public-read',
	              'SourceFile'=>$saveFile,
	              'Bucket'=>S3_BUCKET,
	              'Key'=>$U['folder'].'/'.$_tmpname,
	          ));
						@unlink($saveFile);
	        } catch (Aws\S3\Exception\S3Exception $e) {
	          $result['error'] = 'AwS S3에 파일을 업로드하는 중 오류가 발생했습니다.';
	        }

				}
				else {
					copy('./'.$U['folder'].'/'.$U['tmpname'],'./'.$U['folder'].'/'.$_tmpname);
					$upload_src = '/'.$U['folder'].'/'.$_tmpname;
				}

				$upload_mingid = getDbCnt($table['s_upload'],'min(gid)','');
				$upload_gid = $upload_mingid ? $upload_mingid - 1 : 100000000;

				$QKEY = "gid,hidden,tmpcode,site,mbruid,type,ext,fserver,host,folder,name,tmpname,size,width,height,caption,down,src,d_regis,d_update,sync";
				$QVAL = "'$upload_gid','".$U['hidden']."','','".$U['site']."','".$U['mbruid']."','".$U['type']."','".$U['ext']."','".$U['fserver']."','".$U['host']."',";
				$QVAL.= "'".$U['folder']."','".addslashes($U['name'])."','".$_tmpname."','".$U['size']."','".$U['width']."','".$U['height']."',";
				$QVAL.= "'".addslashes($U['caption'])."','".$U['down']."','".$upload_src."','".$U['d_regis']."','".$U['d_update']."',''";
				getDbInsert($table['s_upload'],$QKEY,$QVAL);
				getDbUpdate($table['s_numinfo'],'upload=upload+1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);

				$tmpupload .= '['.getDbCnt($table['s_upload'],'max(uid)','').']';
				$_content1 = str_replace($U['tmpname'],$_tmpname,$_content1);
			}
		}

		getDbUpdate($table[$m.'data'],"content='".addslashes($_content1)."',upload='".$tmpupload."'",'uid='.$NOWUID);
	}

	$_SESSION['BbsPost'.$type] = str_replace('['.$R['uid'].']','',$_SESSION['BbsPost'.$type]);

}


$referer = $g['s'].'/?r='.$r.'&iframe=Y&m=admin&module='.$m.'&front=movecopy&type='.$type;

getLink($referer,'parent.','실행되었습니다.','');
?>
