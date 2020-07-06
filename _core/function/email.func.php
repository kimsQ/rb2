<?php
//이메일전송
include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

function getSendMail($to,$from,$subject,$content,$html) {
	global $g,$d;

	if ($html == 'TEXT') $content = nl2br(htmlspecialchars($content));
	$to_exp   = explode('|', $to);
	$from_exp = explode('|', $from);

	if ($d['admin']['mailer']=='ses') {

		define('SES_KEY', $d['admin']['ses_key']); //발급받은 키.
		define('SES_SEC', $d['admin']['ses_sec']); //발급받은 비밀번호.
		define('SES_REGION', $d['admin']['ses_region']);  //SES 버킷의 리전.

		$SesClient = new SesClient([
			'credentials' => [
		      'key'    => SES_KEY,
		      'secret' => SES_SEC,
		  ],
				'region'  => SES_REGION,
				'version'     => 'latest'
		]);

		$To = $to_exp[1] ? "\"".utf8_encode($to_exp[1])."\" <$to_exp[0]>" : $to_exp[0];
		$Frm = $from_exp[1] ? "\"".utf8_encode($from_exp[1])."\" <$from_exp[0]>" : $from_exp[0];

		$char_set = 'UTF-8';

		try {
				$result = $SesClient->sendEmail([
						'Destination' => [
								'ToAddresses' => [$To],
						],
						'ReplyToAddresses' => [$Frm],
						'Source' => $Frm,
						'Message' => [
							'Body' => [
									'Html' => [
											'Charset' => $char_set,
											'Data' => $content,
									],
							],
							'Subject' => [
									'Charset' => $char_set,
									'Data' => $subject,
							],
						],
				]);
				return true;
		} catch (AwsException $e) {
				return false;
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
