<?php
if(!defined('__KIMS__')) exit;

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';
include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

use Aws\S3\S3Client;

define('S3_KEY', $d['mediaset']['S3_KEY']); //발급받은 키.
define('S3_SEC', $d['mediaset']['S3_SEC'] ); //발급받은 비밀번호.
define('S3_REGION', $d['mediaset']['S3_REGION']);  //S3 버킷의 리전.
define('S3_BUCKET', $d['mediaset']['S3_BUCKET']); //버킷의 이름.

foreach($photomembers as $file_uid)
{
	$val = explode('|',$file_uid);
	$R = getUidData($table['s_upload'],$val[0]);
	if (!$my['admin'] && (!$R['mbruid'] || $my['uid'] != $R['mbruid']))
	{
		continue;
	}

	if ($dtype == 'move')
	{
		if ($R['category'] != $mcat)
		{
			getDbUpdate($table['s_upload'],'category='.$mcat,'uid='.$R['uid']);

			if ($R['category'] == -1)
			{
				if ($mcat == 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='none'");
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
				if ($mcat > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid'].' and uid='.$mcat);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
			}
			if($R['category'] == 0)
			{
				if ($mcat == -1)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='none'");
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
				if ($mcat > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid'].' and uid='.$mcat);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='none'");
				}
			}
			if($R['category'] > 0)
			{
				if ($mcat == -1)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and uid='.$R['category']);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
				if ($mcat == 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and uid='.$R['category']);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='none'");
				}
				if ($mcat > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and uid='.$R['category']);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid'].' and uid='.$mcat);
				}
			}
		}
		setrawcookie('mediaset_result', rawurlencode('사진이 이동 되었습니다.|success'));  // 처리여부 cookie 저장
	}
	else {

		if ($R['uid'])
		{
			if ($mediaset != 'Y' || $dtype == 'delete')
			{
				getDbDelete($table['s_upload'],'uid='.$R['uid']);

				if ($R['type']>0)
				{

		      if ($R['fserver']==2) {

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
		          'Key'    => $R['folder'].'/'.$R['tmpname']
		        ]);

					}
					else {
						unlink('./'.$R['folder'].'/'.$R['tmpname']);
					}
				}

				if ($R['category'] > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and type=1 and uid='.$R['category']);
				}
			}

			if ($R['category'] == -1)
			{
				if($dtype == 'delete') getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='trash'");
			}
			if ($R['category'] == 0)
			{
				getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
				getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='none'");
				if ($mediaset == 'Y' && $dtype != 'delete') getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
			}
			if($R['category'] > 0)
			{
				getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
				if ($mediaset == 'Y' && $dtype != 'delete') getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
			}
		}
	}
}
getLink('reload','parent.','','');
?>
