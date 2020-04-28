<?php
if(!defined('__KIMS__')) exit;

include $g['path_core'].'function/thumb.func.php';

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';

// 업로드 디렉토리 없는 경우 추가
if(!is_dir($saveDir)){
  mkdir($saveDir,0707);
  @chmod($saveDir,0707);
}

$savePath1	= $saveDir.substr($date['today'],0,4);
$savePath2	= $savePath1.'/'.substr($date['today'],4,2);
$savePath3	= $savePath2.'/'.substr($date['today'],6,2);
$folder		= substr($date['today'],0,4).'/'.substr($date['today'],4,2).'/'.substr($date['today'],6,2);

$upfileNum	= count($_FILES['upfiles']['name']);
$tmpcode	= $mediaset == 'Y' ? '' : $_SESSION['upsescode'];
$mbruid		= $my['uid'];
$fserver	= $d['mediaset']['use_fileserver'];
$d_regis	= $date['totime'];
$down		= 0;
$width		= 0;
$height		= 0;
$caption	= '';
$d_update	= '';
$alt		= '';
$description= '';
$src		= trim($src);
$linkto		= 0;
$license	= 0;
$_fileonly	= $fileonly == 'Y' ? 1 : 0;
$linkurl	= '';

include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';
use Aws\S3\S3Client;

define('S3_KEY', $d['mediaset']['S3_KEY']); //발급받은 키.
define('S3_SEC', $d['mediaset']['S3_SEC'] ); //발급받은 비밀번호.
define('S3_REGION', $d['mediaset']['S3_REGION']);  //S3 버킷의 리전.
define('S3_BUCKET', $d['mediaset']['S3_BUCKET']); //버킷의 이름.

if ($type == 2 || $type == 4 || $type == 5 ) {
  $tmpname = $tmpname.'.'.$fileExt;
}

if ($link != 'Y')
{
	if ($fserver==1) {
		$host = $d['mediaset']['ftp_urlpath'];

		$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
		$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
		if (!$FTP_CONNECT) getLink('','',_LANG('a5001','mediaset'),'');
		if (!$FTP_CRESULT) getLink('','',_LANG('a5001','mediaset'),'');
		if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);
		ftp_chdir($FTP_CONNECT,$d['mediaset']['ftp_folder']);
	}


	for($i = 0; $i < $upfileNum; $i++) {

		$name		= strtolower($_FILES['upfiles']['name'][$i]);
		$size		= $_FILES['upfiles']['size'][$i];
		$fileExt	= getExt($name);
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$type		= getFileType($fileExt);
		$tmpname	= md5($name).substr($date['totime'],8,14);
		$tmpname	= $type == 2 ? $tmpname.'.'.$fileExt : $tmpname;
		$hidden		= $type == 2 ? 1 : 0;

		if ($d['mediaset']['ext_cut'] && strstr($d['mediaset']['ext_cut'],$fileExt)) continue;

		if ($fserver==1) {
			for ($j = 1; $j < 4; $j++)
			{
				@ftp_mkdir($FTP_CONNECT,$d['mediaset']['ftp_folder'].str_replace('./files/','',${'savePath'.$j}));
			}

			if ($Overwrite == 'true' || !is_file($saveFile))
			{
				if ($type == 2)
				{
					$thumbname = md5($tmpname).'.'.$fileExt;
					$thumbFile = $g['path_tmp'].'backup/'.$thumbname;
					ResizeWidth($_FILES['upfiles']['tmp_name'][$i],$thumbFile,$d['mediaset']['thumbsize']);
					$IM = getimagesize($_FILES['upfiles']['tmp_name'][$i]);
					$width = $IM[0];
					$height= $IM[1];
					ftp_put($FTP_CONNECT,$d['mediaset']['ftp_folder'].$folder.'/'.$thumbname,$thumbFile,FTP_BINARY);
					unlink($thumbFile);
				}
			}
			ftp_put($FTP_CONNECT,$d['mediaset']['ftp_folder'].$folder.'/'.$tmpname,$_FILES['upfiles']['tmp_name'][$i],FTP_BINARY);
			ftp_close($FTP_CONNECT);

		} elseif ($fserver==2) {

			$name		= strtolower($_FILES['upfiles']['name'][$i]);
			$size		= $_FILES['upfiles']['size'][$i];
			$fileExt	= getExt($name);
			$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
			$type		= getFileType($fileExt);
			$tmpname	= md5($name).substr($date['totime'],8,14);
			$tmpname	= $type == 2 ? $tmpname.'.'.$fileExt : $tmpname;
			$hidden		= $type == 2 ? 1 : 0;

      // 파일 업로드
			$host= 'https://'.S3_BUCKET.'.s3.'.S3_REGION.'.amazonaws.com';
			$folder = str_replace('./files/','',$saveDir).$folder;
			$src = $host.'/'.$folder.'/'.$tmpname;

			$s3 = new S3Client([
				'version'     => 'latest',
				'region'      => S3_REGION,
				'credentials' => [
						'key'    => S3_KEY,
						'secret' => S3_SEC,
				],
			]);

			if ($type == 2) {
					 if ($fileExt == 'jpg') exifRotate($_FILES['upfiles']['tmp_name'][$i]); //가로세로 교정
					 ResizeWidth($_FILES['upfiles']['tmp_name'][$i],$_FILES['upfiles']['tmp_name'][$i],$d['mediaset']['thumbsize']);
					 @chmod($_FILES['upfiles']['tmp_name'][$i],0707);
					 $IM = getimagesize($_FILES['upfiles']['tmp_name'][$i]);
					 $width = $IM[0];
					 $height= $IM[1];
			}

			try {
				$s3->putObject(Array(
						'ACL'=>'public-read',
						'SourceFile'=>$_FILES['upfiles']['tmp_name'][$i],
						'Bucket'=>S3_BUCKET,
						'Key'=>$folder.'/'.$tmpname,
						'ContentType'=>$_FILES['upfiles']['type'][$i]
				));
				unlink($_FILES['upfiles']['tmp_name'][$i]);

        // getLink('','',$_FILES['upfiles']['tmp_name'][$i].' 여기까지','');

			} catch (Aws\S3\Exception\S3Exception $e) {
				$result['error'] = 'AwS S3에 파일을 업로드하는 중 오류가 발생했습니다.';
			}

		} else  {

			$host = '';
			$folder = str_replace('.','',$saveDir).$folder;
			$src = $folder.'/'.$tmpname;

			for ($j = 1; $j < 4; $j++)
			{
				if (!is_dir(${'savePath'.$j}))
				{
					mkdir(${'savePath'.$j},0707);
					@chmod(${'savePath'.$j},0707);
				}
			}

			$saveFile = $savePath3.'/'.$tmpname;

			if ($Overwrite == 'true' || !is_file($saveFile))
			{
				move_uploaded_file($_FILES['upfiles']['tmp_name'][$i], $saveFile);
				if ($type == 2)
				{
					if ($fileExt == 'jpg') exifRotate($_FILES['upfiles']['tmp_name']); //가로세로 교정
					ResizeWidth($_FILES['upfiles']['tmp_name'],$_FILES['upfiles']['tmp_name'],$d['mediaset']['thumbsize']);
					@chmod($_FILES['upfiles']['tmp_name'],0707);
					$IM = getimagesize($saveFile);
					$width = $IM[0];
					$height= $IM[1];
				}
				@chmod($saveFile,0707);
			}

		}

		$mingid = getDbCnt($table['s_upload'],'min(gid)','');
		$gid = $mingid ? $mingid - 1 : 100000000;

		$QKEY = "gid,pid,category,hidden,tmpcode,site,mbruid,fileonly,type,ext,fserver,host,folder,name,tmpname,size,width,height,alt,caption,description,src,linkto,license,down,d_regis,d_update,sync,linkurl";
		$QVAL = "'$gid','$gid','$category','$hidden','$tmpcode','$s','$mbruid','$_fileonly','$type','$fileExt','$fserver','$host','$folder','$name','$tmpname','$size','$width','$height','$alt','$caption','$description','$src','$linkto','$license','$down','$d_regis','$d_update','$sync','$linkurl'";
		getDbInsert($table['s_upload'],$QKEY,$QVAL);
		getDbUpdate($table['s_numinfo'],'upload=upload+1',"date='".$date['today']."' and site=".$s);

		if ($gid == 100000000) db_query("OPTIMIZE TABLE ".$table['s_upload'],$DB_CONNECT);
		$_nowPer = (int)((($i+1)/$upfileNum)*100);
	?>
	<script>
	parent.getId('progressPer').style.width = '<?php echo $_nowPer?>%';
	parent.getId('progressPer').innerHTML = '<?php echo $_nowPer?>%(<?php echo ($i+1)?>/<?php echo $upfileNum?>)';
	<?php if($_nowPer > 99):?>
	parent.gridProgress();
	<?php endif?>
	</script>
	<?php
	}
}
else {

	$upfileNum	= 1;
	$name		= basename($src);
	$fileExt	= getExt($src);
	$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;

	$mingid = getDbCnt($table['s_upload'],'min(gid)','');
	$gid = $mingid ? $mingid - 1 : 100000000;

	$QKEY = "gid,pid,category,hidden,tmpcode,site,mbruid,fileonly,type,ext,fserver,host,folder,name,tmpname,size,width,height,alt,caption,description,src,linkto,license,down,d_regis,d_update,sync,linkurl";
	$QVAL = "'$gid','$gid','$category','0','$tmpcode','$s','$mbruid','$_fileonly','-1','$fileExt','0','','','$name','','0','0','0','','','','$src','0','0','0','$d_regis','','',''";
	getDbInsert($table['s_upload'],$QKEY,$QVAL);

	if ($gid == 100000000) db_query("OPTIMIZE TABLE ".$table['s_upload'],$DB_CONNECT);

}
if ($fileonly != 'Y')
{
	if (!getDbRows($table['s_uploadcat'],'mbruid='.$my['uid'].' and type=1'))
	{
		getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'0','".$s."','".$my['uid']."','1','0','','none','0','".$date['totime']."',''");
		getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'1','".$s."','".$my['uid']."','1','0','','trash','0','".$date['totime']."',''");
	}

	$_tname = ' and uid='.(int)$category;
	if (!$category) $_tname = " and name='none'";
	if ($category == -1) $_tname = "and name='trash'";

	getDbUpdate($table['s_uploadcat'],'r_num=r_num+'.$upfileNum,'mbruid='.$my['uid'].' and type=1'.$_tname);
}
if ($link == 'Y') {
	setrawcookie('mediaset_result', rawurlencode('사진이 추가 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}
exit;
?>
