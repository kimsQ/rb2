<?php
// FCM 알림전송
function getSendFCM($token,$title,$message,$avatar,$referer,$tag) {
  global $g,$d,$r;
  $url = 'https://fcm.googleapis.com/fcm/send';

  $g['notiIconForSite'] = $g['path_var'].'site/'.$r.'/homescreen.png';
  $g['url_notiIcon'] = $g['s'].'/_var/site/'.$r.'/homescreen-192x192.png';
  $site_icon = file_exists($g['notiIconForSite']) ? $g['url_notiIcon'] : $g['img_core'].'/touch/homescreen-192x192.png';
  $icon = $avatar?$avatar:$site_icon;

	$headers = array(
		'Authorization:key ='.$d['admin']['fcm_key'],
		'Content-Type: application/json'
	);

	$fields = array (
		'data' => array ("title" => $title),
		'notification' => array (
      "title" => $title,
      "body" => $message,
      "icon" => $icon,
      "click_action" => $referer,
      "tag" => $tag
    )
	);

	if(is_array($token)) {
		$fields['registration_ids'] = $token;
	} else {
		$fields['to'] = $token;
	}

	$fields['priority'] = "high";

	$fields = json_encode ($fields);

	$ch = curl_init ();
	curl_setopt ($ch, CURLOPT_URL, $url );
	curl_setopt ($ch, CURLOPT_POST, true );
	curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $fields );

	$result = curl_exec ($ch);
	if ($result === FALSE) {
	  die('FCM Send Error: ' . curl_error($ch));
	}
	curl_close ($ch);
	return $result;
}

?>
