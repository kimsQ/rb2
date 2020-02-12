<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($type == 'ftpbtn')
{
	$FTP_CONNECT = ftp_connect($ftp_host,$ftp_port);
	$FTP_CRESULT = ftp_login($FTP_CONNECT,$ftp_user,$ftp_pass);

	if ($FTP_CONNECT && $FTP_CRESULT):

	$FTP_PASV = true;
	if($ftp_pasv)
	{
		$FTP_PASV = ftp_pasv($FTP_CONNECT, true);
	}
	$FTP_CHDIR = ftp_chdir($FTP_CONNECT,$ftp_rb);
	if (!$FTP_PASV) $_msg = 'Passive Mode 를 확인하세요.';
	if (!$FTP_CHDIR || substr($ftp_rb,-1)!='/') $_msg = '킴스큐 경로를 확인하세요.';
	if ($FTP_PASV && $FTP_CHDIR):
	?>
	<script>
	alert('정상적으로 FTP 연결이 확인되었습니다.');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i>정상';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.ftp.value = '1';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php else:?>
	<script>
	alert('FTP 연결이 되지 않았습니다. <?php echo $_msg?>');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.ftp.value = '';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php endif?>
	<?php else:?>
	<script>
	alert('FTP 연결이 되지 않았습니다. FTP정보를 확인해 주세요.');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.ftp.value = '';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php
	endif;
}
else if ($type == 'ftpbtn_uninstall')
{
	$FTP_CONNECT = ftp_connect($d['admin']['ftp_host'],$d['admin']['ftp_port']);
	$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['admin']['ftp_user'],$pass);

	if ($FTP_CONNECT && $FTP_CRESULT):
	?>
	<script>
	alert('정상적으로 FTP 연결이 확인되었습니다.');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i>정상';
	</script>
	<?php else:?>
	<script>
	alert('FTP 연결이 되지 않았습니다. FTP정보를 확인해 주세요.');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	</script>
	<?php
	endif;
}
else
{
	include $g['path_core'].'function/email.func.php';

	$content = '<h4>이메일전송 테스트입니다.</h4><br>';
	$content.= '이 화면을 정상적으로 확인하셨다면 이메일 전송이 정상적으로 동작중입니다.<br><br>';

	if ($type == 'sendmailbtn')
	{
		$result = getSendMail($chk_email,$my['email'].'|'.$my['name'],'['.$_HS['name'].'] 이메일 전송 테스트입니다.(Using Sendmail)',$content,'HTML');
	}
	if ($type == 'smtpbtn')
	{
		$d['admin']['smtp_use'] = true;
		$d['admin']['smtp'] = true;
		$d['admin']['smtp_host'] = trim($smtp_host);
		$d['admin']['smtp_port'] = trim($smtp_port);
		$d['admin']['smtp_ssl'] = trim($smtp_ssl);
		$d['admin']['smtp_auth'] = trim($smtp_auth);
		$d['admin']['smtp_user'] = trim($smtp_user);
		$d['admin']['smtp_pass'] = trim($smtp_pass);

		$result = getSendMail($chk_email,$my['email'].'|'.$my['name'],'['.$_HS['name'].'] 이메일 전송 테스트입니다.(Using SMTP)',$content,'HTML');
	}
	if ($result):
	?>
	<script>
	alert('이메일이 전송되었습니다. 확인해 보세요.');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i>정상';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.<?php echo $type=='sendmailbtn'?'email':'smtp'?>.value = '1';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php else:?>
	<script>
	alert('메일서버가 응답하지 않습니다.');
	parent.getId('<?php echo $type?>').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	parent.submitFlag = false;
	parent.document.procForm.a.value = 'config';
	parent.document.procForm.autosave.value = '1';
	parent.document.procForm.<?php echo $type=='sendmailbtn'?'email':'smtp'?>.value = '';
	parent.document.procForm.target = '_autosave_';
	parent.document.procForm.submit();
	</script>
	<?php
	endif;
}
exit;
?>
