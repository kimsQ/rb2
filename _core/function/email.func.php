<?php
//이메일전송
function getSendMail($to,$from,$subject,$content,$html) 
{
	global $g,$d;

	if ($html == 'TEXT') $content = nl2br(htmlspecialchars($content));
	$to_exp   = explode('|', $to);
	$from_exp = explode('|', $from);

	if ($d['admin']['smtp_use'] && $d['admin']['smtp'])
	{
		require $g['path_core'].'opensrc/phpmailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;
		$mail->CharSet = 'utf-8';
		$mail->Encoding = 'base64';
		$mail->isSMTP();
		$mail->Host = $d['admin']['smtp_host'];
		$mail->SMTPAuth = $d['admin']['smtp_auth'] ? true : false;
		$mail->Username = $d['admin']['smtp_user'];
		$mail->Password = $d['admin']['smtp_pass'];
		if($d['admin']['smtp_ssl']) $mail->SMTPSecure = $d['admin']['smtp_ssl'];
		$mail->Port = $d['admin']['smtp_port'];

		$mail->From = $from_exp[0];
		if ($from_exp[1]) $mail->FromName = $from_exp[1];
		else $mail->FromName = $from_exp[0];
		if ($to_exp[1]) $mail->addAddress($to_exp[0],$to_exp[1]);
		else $mail->addAddress($to_exp[0]);

		$mail->addReplyTo($from_exp[0],($from_exp[1]?$from_exp[1]:$from_exp[0]));
		if($ccEmail) $mail->addCC($ccEmail);
		if($bccEmail) $mail->addBCC($bccEmail);

		$mail->WordWrap = 50;
		if($addAttach) $mail->addAttachment($addAttach);
		$mail->isHTML($html=='TEXT'?false:true);

		$mail->Subject = $subject;
		$mail->Body    = $content;
		if ($altBody) $mail->AltBody = $altBody;

		if(!$mail->send()) {
			return false;//$mail->ErrorInfo;
		} else {
			return true;
		}
	}
	else {
		$To = $to_exp[1] ? "\"".getUTFtoKR($to_exp[1])."\" <$to_exp[0]>" : $to_exp[0];
		$Frm = $from_exp[1] ? "\"".getUTFtoKR($from_exp[1])."\" <$from_exp[0]>" : $from_exp[0];
		$Header = "From:$Frm\nReply-To:$frm\nX-Mailer:PHP/".phpversion();
		$Header.= "\nContent-Type:text/html;charset=EUC-KR\r\n"; 
		return @mail($To,getUTFtoKR($subject),getUTFtoKR($content),$Header);
	}
}
?>