<?php
if(!defined('__KIMS__')) exit;

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';

$R=getUidData($table['s_upload'],$uid);
if (!$R['uid']) getLink('','',_LANG('a2001','mediaset'),'');
if ($R['type'] < 1) return getLink('','',_LANG('a2002','mediaset'),'');


$filename = getUTFtoKR($R['name']);
$filetmpname = getUTFtoKR($R['tmpname']);

if ($R['url']==$d['mediaset']['ftp_urlpath'])
{
	$filepath = $d['mediaset']['ftp_urlpath'].$R['folder'].'/'.$filetmpname;
	$filesize = $R['size'];
}
else {
	$filepath = $g['path_file'].$R['folder'].'/'.$filetmpname;
	$filesize = filesize($filepath);
}

header("Content-Type: application/octet-stream");
header("Content-Length: " .$filesize);
header('Content-Disposition: attachment; filename="'.$filename.'"');
header("Cache-Control: private, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if ($R['fserver'] && $R['url'] == $d['mediaset']['ftp_urlpath'])
{
	$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
	$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
	if (!$FTP_CONNECT) getLink('','',_LANG('a2003','mediaset'),'');
	if (!$FTP_CRESULT) getLink('','',_LANG('a2004','mediaset'),'');
	if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

	$filepath = $g['path_tmp'].'session/'.$filetmpname;
	ftp_get($FTP_CONNECT,$filepath,$d['mediaset']['ftp_folder'].$R['folder'].'/'.$filetmpname,FTP_BINARY);
	ftp_close($FTP_CONNECT);
	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
	unlink($filepath);
}
else {
	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
}
exit;
?>
