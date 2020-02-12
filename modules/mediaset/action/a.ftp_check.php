<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$FTP_CONNECT = ftp_connect($ftp_host,$ftp_port);
$FTP_CRESULT = ftp_login($FTP_CONNECT,$ftp_user,$ftp_pass);

if ($FTP_CONNECT && $FTP_CRESULT):

$FTP_PASV = true;
if($ftp_pasv)
{
	$FTP_PASV = ftp_pasv($FTP_CONNECT, true);
}
$FTP_CHDIR = ftp_chdir($FTP_CONNECT,$ftp_folder);
if (!$FTP_PASV) $_msg = 'Passive Mode 를 확인하세요.';
if (!$FTP_CHDIR || substr($ftp_folder,-1)!='/' || substr($ftp_urlpath,-1)!='/') $_msg = '첨부할 폴더와 URL경로를 확인하세요.';
if ($FTP_PASV && $FTP_CHDIR):
?>
<script>
alert('정상적으로 FTP 연결이 확인되었습니다.');
parent.getId('ftpbtn').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i> 정상';
parent.submitFlag = false;
parent.document.procForm.a.value = 'config';
parent.document.procForm.ftp_connect.value = '1';
</script>
<?php else:?>
<script>
alert('FTP 연결이 되지 않았습니다. <?php echo $_msg?>');
parent.getId('ftpbtn').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i> 확인요망';
parent.submitFlag = false;
parent.document.procForm.a.value = 'config';
parent.document.procForm.ftp_connect.value = '';
</script>
<?php endif?>
<?php else:?>
<script>
alert('FTP 연결이 되지 않았습니다. FTP정보를 확인해 주세요.');
parent.getId('ftpbtn').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i> 확인요망';
parent.submitFlag = false;
parent.document.procForm.a.value = 'config';
parent.document.procForm.ftp_connect.value = '';
</script>
<?php
endif;

exit;
?>
