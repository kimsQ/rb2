<?php
//SMS 전송
function getSendSMS($to,$from,$subject,$content,$type)
{
	global $g,$d;

	if ($html == 'TEXT') $content = nl2br(htmlspecialchars($content));

	require $g['path_core'].'opensrc/snoopy/Snoopy.class.php';

	$snoopy = new Snoopy;

	/*======================================================================*\
	// MMS일 경우 첨부파일 처리
	// 서버&로컬 에 저장된 이미지 파일 읽어올때.
	// 웹경로 ,로컬경로 모두 가능 합니다.
	\*======================================================================*/
	$img_source    = 'http://websvc.nesolution.com/sms/MMSAttachFiles/M050085/20180510145947.jpg';
	//$img_source    = './img/test.jpg';

	// $img = file_get_contents($img_source);
	// $Base64files = base64_encode($img);

	//"," 콤마로 구분 최대 3개.가능합니다.
	$files = $Base64files .",".$Base64files .",".$Base64files ;

	/*======================================================================*\
	// MMS일 경우 첨부파일 처리
	// 프론트에서 이미지 파일을 base64로 생성후 post로 받아 올때.
	// POST 방식
	\*======================================================================*/
	/*
	  $files = $_POST["Base64files"];//MMS 발송시 첨부파일
	*/

	/*======================================================================*\
	// utf-8 인코딩을 사용할 경우
	// POST 방식
	\*======================================================================*/

	$cmd = "SendSms";
	$tran_phone = urlencode(iconv('UTF-8', 'EUC-KR', $to)); //받는사람 핸드폰 번호
	$tran_callback = urlencode(iconv('UTF-8', 'EUC-KR', $from)); //보내는사람 핸드폰 번호
	$tran_date = urlencode(iconv('UTF-8', 'EUC-KR', $date)); //예약전송 일시(생략시 즉시전송)
	$tran_msg = urlencode(iconv('UTF-8', 'EUC-KR',$content)); //전송 메시지
	$guest_no = urlencode(iconv('UTF-8', 'EUC-KR',$d['admin']['sms_id'])); //SMS 계정 아이디
	$guest_key = urlencode(iconv('UTF-8', 'EUC-KR',$d['admin']['sms_key'])); //SMS 계정 인증키
	$type = urlencode(iconv('UTF-8', 'EUC-KR',$type)); //발송구분
	$subject = urlencode(iconv('UTF-8', 'EUC-KR',$subject)); //LMS / MMS 발송시 제목
	$files = $_POST["Base64files"];//MMS 발송시 첨부파일

	if($type != "MMS") {
	/*======================================================================*\
	 // GET 으로 호출
	  이미지 첨부시 에러 발생함니다. post 로 전송하세요.
	\*======================================================================*/
		$method = "GET";
		$url = "http://websvc.nesolution.com/SMS/SMS.aspx?cmd=$cmd&method=$method&";
		$url = $url . "guest_no=$guest_no&guest_key=$guest_key&tran_phone=$tran_phone&";
		$url = $url . "tran_callback=$tran_callback&tran_date=$tran_date&tran_msg=$tran_msg&";
		$url = $url . "type=$type&subject=$subject";	// LMS 또는 MMS 일경우 제목 필수

		$snoopy->fetchtext($url);
		// 출력 페이지가 euc-kr 일때
		//$send_result = $snoopy->results;
		// 출력 페이지가 utf-8 일때
		$send_result = iconv('EUC-KR', 'UTF-8', $snoopy->results);
	}
	else
	{
	/*======================================================================*\
	 // $snoopy 사용 POST 발송(MMS 파일첨부시)
	\*======================================================================*/

		$formvars["cmd"] =$cmd;
		$formvars["guest_no"] = $guest_no;
		$formvars["guest_key"] = $guest_key;
		$formvars["tran_phone"] = $tran_phone;
		$formvars["tran_callback"] = $tran_callback;
		$formvars["tran_date"] = $tran_date;
		$formvars["tran_msg"] = $tran_msg;
		$formvars["type"] = $type;
		$formvars["subject"] = $subject;
		$formvars["files"] = $files;

		$snoopy->httpmethod = "POST";
		$snoopy->submit("http://websvc.nesolution.com/SMS/SMS.aspx",$formvars );

		 //출력 페이지가 euc-kr 일때
		//$send_result = $snoopy->results;
		// 출력 페이지가 utf-8 일때
		$send_result = iconv('EUC-KR', 'UTF-8', $snoopy->results);
	}

	return $send_result;
}
?>
