<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';
include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

use Aws\S3\S3Client;

define('S3_KEY', $d['mediaset']['S3_KEY']); //발급받은 키.
define('S3_SEC', $d['mediaset']['S3_SEC'] ); //발급받은 비밀번호.
define('S3_REGION', $d['mediaset']['S3_REGION']);  //S3 버킷의 리전.
define('S3_BUCKET', $d['mediaset']['S3_BUCKET']); //버킷의 이름.

foreach($upfile_members as $val)
{

	$R = getUidData($table['s_upload'],$val);
	if ($R['uid'])
	{
		getDbDelete($table['s_upload'],'uid='.$R['uid']);
		getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site']);

		if ($R['fserver']==2)
		{
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
			unlink($R['src']);
			//if($R['type']==2) unlink($g['path_file'].$R['folder'].'/'.$R['thumbname']);
		}
	}
}

getLink('reload','parent.','','');
?>
