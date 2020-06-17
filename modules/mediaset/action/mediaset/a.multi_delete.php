<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

function getuFileType($R)
{
	if ($R['type'] == 2 || $R['type'] == -1) return 1;
	if ($R['type'] == 5 || $R['type'] == 0) return 2;
	return 0;
}

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';
include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

$_MEMBERS = array();
foreach($upfile_members as $val)
{
	$R = getUidData($table['s_upload'],$val);
	if ($R['uid'])
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

		$_type = getuFileType($R['type']);

		if ($R['category'] == -1)
		{
			getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$R['mbruid']." and type=".$_type." and name='trash'");
		}
		if ($R['category'] == 0)
		{
			getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
			getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$R['mbruid']." and type=".$_type." and name='none'");
		}
		if($R['category'] > 0)
		{
			getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$R['mbruid'].' and type='.$_type.' and uid='.$R['category']);
			getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
		}

		if($R['mbruid']) $_MEMBERS['m'.$R['mbruid']]++;
	}
}
//파일이 삭제된 회원들에게 알림
foreach($_MEMBERS as $_key => $_val)
{
	putNotice(str_replace('m','',$_key),$m,0,sprintf(_LANG('a4001','mediaset'),$_val),'','');
}

getLink('reload','parent.','','');
?>
