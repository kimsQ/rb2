<?php
if(!defined('__KIMS__')) exit;

include $g['path_core'].'function/thumb.func.php';
$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';

$savePath1	= $saveDir.substr($date['today'],0,4);
$savePath2	= $savePath1.'/'.substr($date['today'],4,2);
$savePath3	= $savePath2.'/'.substr($date['today'],6,2);
$folder		= substr($date['today'],0,4).'/'.substr($date['today'],4,2).'/'.substr($date['today'],6,2);

$upfileNum	= count($_FILES['upfiles']['name']);
$tmpcode	= $mediaset == 'Y' ? '' : $_SESSION['upsescode'];
$mbruid		= $my['uid'];
$fserver	= $d['mediaset']['use_fileserver'];
$url		= $fserver ? $d['mediaset']['ftp_urlpath'] : $g['url_root'].'/files/';
$d_regis	= $date['totime'];
$down		= 0;
$width		= 0;
$height		= 0;
$caption	= '';
$d_update	= '';

//$category	= 0;
$alt		= '';
$description= '';
$src		= trim($src);
$linkto		= 0;
$license	= 0;
$_fileonly	= 0;
$linkurl	= '';


if ($link != 'Y')
{
	if ($fserver)
	{
		$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
		$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
		if (!$FTP_CONNECT) getLink('','',_LANG('a5001','mediaset'),'');
		if (!$FTP_CRESULT) getLink('','',_LANG('a5001','mediaset'),'');
		if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);
		ftp_chdir($FTP_CONNECT,$d['mediaset']['ftp_folder']);
	}


	for($i = 0; $i < $upfileNum; $i++)
	{
		$name		= strtolower($_FILES['upfiles']['name'][$i]);
		$size		= $_FILES['upfiles']['size'][$i];
		$fileExt	= getExt($name);
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$type		= getFileType($fileExt);
		$tmpname	= md5($name).substr($date['totime'],8,14);
		$tmpname	= $type == 5 ? $tmpname.'.'.$fileExt : $tmpname;
		$hidden		= $type == 5 ? 1 : 0;

		if ($fileExt != 'mp4') continue;

		if ($fserver)
		{
			for ($j = 1; $j < 4; $j++)
			{
				ftp_mkdir($FTP_CONNECT,$d['mediaset']['ftp_folder'].str_replace('./files/','',${'savePath'.$j}));
			}
			ftp_put($FTP_CONNECT,$d['mediaset']['ftp_folder'].$folder.'/'.$tmpname,$_FILES['upfiles']['tmp_name'][$i],FTP_BINARY);
		}
		else {

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
				@chmod($saveFile,0707);
			}
		}

		$mingid = getDbCnt($table['s_upload'],'min(gid)','');
		$gid = $mingid ? $mingid - 1 : 100000000;

		$QKEY = "gid,pid,category,hidden,tmpcode,site,mbruid,fileonly,type,ext,fserver,url,folder,name,tmpname,thumbname,size,width,height,alt,caption,description,src,linkto,license,down,d_regis,d_update,sync,linkurl";
		$QVAL = "'$gid','$gid','$category','$hidden','$tmpcode','$s','$mbruid','$_fileonly','$type','$fileExt','$fserver','$url','$folder','$name','$tmpname','$thumbname','$size','$width','$height','$alt','$caption','$description','$src','$linkto','$license','$down','$d_regis','$d_update','$sync','$linkurl'";
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
	$name		= _LANG('a5002','mediaset');
	$fileExt	= 'mp4';

	$mingid = getDbCnt($table['s_upload'],'min(gid)','');
	$gid = $mingid ? $mingid - 1 : 100000000;

	$QKEY = "gid,pid,category,hidden,tmpcode,site,mbruid,fileonly,type,ext,fserver,url,folder,name,tmpname,thumbname,size,width,height,alt,caption,description,src,linkto,license,down,d_regis,d_update,sync,linkurl";
	$QVAL = "'$gid','$gid','$category','0','$tmpcode','$s','$mbruid','$_fileonly','0','$fileExt','0','','','$name','','','0','0','0','','','','$src','0','0','0','$d_regis','','',''";
	getDbInsert($table['s_upload'],$QKEY,$QVAL);

	if ($gid == 100000000) db_query("OPTIMIZE TABLE ".$table['s_upload'],$DB_CONNECT);

}
if ($fileonly != 'Y')
{
	if (!getDbRows($table['s_uploadcat'],'mbruid='.$my['uid'].' and type=2'))
	{
		getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'0','".$s."','".$my['uid']."','2','0','','none','0','".$date['totime']."',''");
		getDbInsert($table['s_uploadcat'],'gid,site,mbruid,type,hidden,users,name,r_num,d_regis,d_update',"'1','".$s."','".$my['uid']."','2','0','','trash','0','".$date['totime']."',''");
	}

	$_tname = 'uid='.(int)$category;
	if (!$category) $_tname = "name='none'";
	if ($category == -1) $_tname = "name='trash'";


	getDbUpdate($table['s_uploadcat'],'r_num=r_num+'.$upfileNum,'mbruid='.$my['uid'].' and type=2 and '.$_tname);
}
if ($link == 'Y') getLink('reload','parent.','','');
exit;
?>
