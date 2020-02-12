<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$ftp_port = $ftp_port ? trim($ftp_port) : '21';
$_tmpdfile = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['mediaset']['maxnum_file'] = \"".$maxnum_file."\";\n");
fwrite($fp, "\$d['mediaset']['maxsize_file'] = \"".$maxsize_file."\";\n");
fwrite($fp, "\$d['mediaset']['thumbsize'] = \"".$thumbsize."\";\n");
fwrite($fp, "\$d['mediaset']['use_fileserver'] = \"".$use_fileserver."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_type'] = \"".$ftp_type."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_host'] = \"".trim($ftp_host)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_port'] = \"".$ftp_port."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_user'] = \"".trim($ftp_user)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_pasv'] = \"".$ftp_pasv."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_pass'] = \"".trim($ftp_pass)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_folder'] = \"".trim($ftp_folder)."\";\n");
fwrite($fp, "\$d['mediaset']['ftp_urlpath'] = \"".trim($ftp_urlpath)."\";\n");
fwrite($fp, "\$d['mediaset']['S3_KEY'] = \"".trim($s3_key)."\";\n");
fwrite($fp, "\$d['mediaset']['S3_SEC'] = \"".trim($s3_sec)."\";\n");
fwrite($fp, "\$d['mediaset']['S3_REGION'] = \"".trim($s3_region)."\";\n");
fwrite($fp, "\$d['mediaset']['S3_BUCKET'] = \"".trim($s3_bucket)."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

setrawcookie('mediaset_config_result', rawurlencode('<i class="fa fa-check" aria-hidden="true"></i> 설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
