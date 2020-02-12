<?php
if(!defined('__KIMS__')) exit;

// 외부연결시 referer
$connect_referer = $_SESSION['connect_referer'];

include $g['path_var'].'site/'.$r.'/connect.var.php';

if ($_POST['returnofgoogle'] == 'Y')
{
	$result = array();
	$result['token'] = $_POST['token'];
	$result['uid'] = $_POST['uid'];
	$result['email'] = $_POST['email'];
	$result['name'] = $_POST['name'];
	$result['photo'] = $_POST['photo'];
	$result['link'] = $_POST['link'];
	$result['sex'] = $_POST['sex'] == 'male' ? 1 : 2;

	$_SESSION['SL']['google']['userinfo'] = $result;
	header('Location: '.$connect_referer);
}

// 콜백 URL에 code값과 state 값이 URL 문자열로 전송됩니다. code 값은 접근 토큰 발급 요청에 사용합니다.
function socialLogin($s,$id,$secret,$callBack,$type) {
// 소셜로그인시 referer
  $connect_referer = $_SESSION['connect_referer'];

	if(!$_SESSION['SL']['state'.$s]) $_SESSION['SL']['state'.$s] = md5(microtime().mt_rand());

	$g['connect']['client_id'] = $id;
	$g['connect']['client_secret'] = $secret;
	$g['connect']['redirect_uri'] = urlencode($callBack);
	$g['connect']['state'] = $_SESSION['SL']['state'.$s];
	$g['connect']['code'] = $_REQUEST['code'];

	// 네이버 ******************************************************************************************************************************************/
	if ($s == 'naver')
	{
		$g['connect']['callurl'] = 'https://nid.naver.com/oauth2.0/token?client_id='.$g['connect']['client_id'].'&client_secret='.$g['connect']['client_secret'];
		$g['connect']['callurl'].= '&grant_type=authorization_code&code='.$g['connect']['code'].'&state='.$g['connect']['state'];

		if($type == 'token') {

			// if ($g['connect']['state'] != $_REQUEST['state']) getLink(RW(0),'','인증에 실패했습니다. 다시 시도해 주세요.','');

			// 접근 토큰 발급 요청
			if ($_SESSION['SL'][$s]['userinfo']['access_token']) $dat['access_token'] = $_SESSION['SL'][$s]['userinfo']['access_token'];
			else $dat = json_decode(getCURLData($g['connect']['callurl'],''), true);

			// 접근 토큰을 이용하여 프로필 API 호출하기
			$dat1 = json_decode(getCURLData('https://openapi.naver.com/v1/nid/me',array("Authorization: Bearer ".$dat['access_token'])), true);

			// 프로필 정보 배열처리 후, 세션저장
			$result = array();
			$result['provider'] = $s;
			$result['access_token'] = $dat['access_token'];
			$result['refresh_token'] = $dat['refresh_token'];
			$result['expires_in'] = $dat['expires_in'];
			$result['uid']	= $dat1['response']['id'];
			$result['name']	= $dat1['response']['nickname'];
			$result['email']	= $dat1['response']['email'];
			$result['photo'] = $dat1['response']['profile_image'];
			$result['age'] = $dat1['response']['age'];
			$result['sex'] = $dat1['response']['gender'];
			$result['sex'] = $result['sex'] == 'M' ? 1 : 2;
			$result['birthday'] = str_replace('-','',$dat1['response']['birthday']);
			$_SESSION['SL'][$s]['userinfo'] = $result;

			// 원래페이지 이동
			header('Location: '.$connect_referer);
		}
	}

	// 카카오 ******************************************************************************************************************************************/
	if ($s == 'kakao')
	{

		$g['connect']['callurl'] = 'https://kauth.kakao.com/oauth/token?client_id='.$g['connect']['client_id'].'&grant_type=authorization_code&code='.$g['connect']['code'].'&redirect_uri='.$g['connect']['redirect_uri'];

		if ($type == 'token')
		{
			if($_GET['error'] == 'access_denied') getLink('','','인증에 실패했습니다. 다시 시도해 주세요.','close');
			if ($_SESSION['SL'][$s]['userinfo']['access_token']) $dat1['access_token'] = $_SESSION['SL'][$s]['userinfo']['access_token'];
			else $dat1 = json_decode(getCURLData($g['connect']['callurl'],''), true);

			$dat2 = json_decode(getCURLData('https://kapi.kakao.com/v2/user/me',array("Authorization: Bearer ".$dat1['access_token'])), true);
			$isksuser = json_decode(getCURLData('https://kapi.kakao.com/v1/api/story/isstoryuser',array("Authorization: Bearer ".$dat1['access_token'])), true);
			if ($isksuser['isStoryUser'])
			{
				$dat3 = json_decode(getCURLData('https://kapi.kakao.com/v1/api/story/profile',array("Authorization: Bearer ".$dat1['access_token'])), true);
				/*
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://kapi.kakao.com/v1/api/story/post/note?permission=M&content=".urlencode('REST API로 카카오 스토리에 노트를 올려봅니다. - '.date('Y/m/d H:i:s')));
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					"Authorization: Bearer ".$dat1['access_token']
				));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, true);
				$result_post_note = json_decode(curl_exec($ch),true);
				curl_close($ch);
				*/
			}

			$result = array();
			$result['access_token'] = $dat1['access_token'];
			$result['refresh_token'] = $dat1['refresh_token'];
			$result['expires_in'] = $dat1['expires_in'];
			$result['uid'] = $dat2['id'];
			$result['email'] = $dat2['kaccount_email'];
			$result['name'] = $dat2['properties']['nickname'];
			$result['photo'] = $dat2['properties']['profile_image'];
			$result['photo_thumb'] = $dat2['properties']['thumbnail_image'];
			$result['link'] = $dat3['permalink'];
			$result['birthday'] = $dat3['birthday'];
			$result['birthday_type'] = $dat3['birthdayType'] == 'SOLAR' ? 0 : 1;
			$result['ks_img_profile'] = $dat3['profileImageURL'];
			$result['ks_img_profile_thumb'] = $dat3['thumbnailURL'];
			$result['ks_img_bg'] = $dat3['bgImageURL'];

			$_SESSION['SL'][$s]['userinfo'] = $result;
			header('Location: '.$connect_referer);
		}
	}

	// 페이스북 ******************************************************************************************************************************************/
	if ($s == 'facebook')
	{
		$g['connect']['callurl'] = 'https://graph.facebook.com/v3.0/oauth/access_token?client_id='.$g['connect']['client_id'].'&client_secret='.$g['connect']['client_secret'].'&code='.$g['connect']['code'].'&redirect_uri='.$g['connect']['redirect_uri'];

		if ($type == 'token')
		{
			if($_GET['error'] == 'access_denied') getLink('','','인증에 실패했습니다. 다시 시도해 주세요.','close');

			// 접근 토큰 발급 요청
			if ($_SESSION['SL'][$s]['userinfo']['token']) $dat['access_token'] = $_SESSION['SL'][$s]['userinfo']['token'];
			else $dat = json_decode(getCURLData($g['connect']['callurl'],''), true);

			// 접근 토큰을 이용하여 프로필 API 호출하기
			$dat1 = json_decode(getCURLData('https://graph.facebook.com/v3.0/me?fields=id,email,first_name,last_name,name&access_token='.$dat['access_token'],''), true);

			// 프로필 정보 배열처리 후, 세션저장
			$result = array();
			$result['token'] = $dat['access_token'];
			$result['uid'] = $dat1['id'];
			$result['name'] = $dat1['last_name'].$dat1['first_name']; // $dat['name']
			$result['email'] = $dat1['email'];
			$result['photo'] = 'https://graph.facebook.com/'.$dat1['id'].'/picture?type=large';
			// $result['link'] = $dat1['link'];
			// $result['sex'] = $dat1['gender'] == 'male' ? 1 : 2;
			// $_birthday = explode('/',$dat1['birthday']);
			// $result['birthday'] = $_birthday[2].$_birthday[1].$_birthday[0];
			$_SESSION['SL'][$s]['userinfo'] = $result;
			header('Location: '.$connect_referer);
		}
	}

	// 구글 && 유투브 ******************************************************************************************************************************************/
	if ($s == 'google')
	{
		$g['connect']['callapi'] = 'https://accounts.google.com/o/oauth2/auth?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'].'&response_type=code&scope=email%20profile&state=%2Fprofile&approval_prompt=auto';
		$g['connect']['callapi_youtube'] = 'https://accounts.google.com/o/oauth2/auth?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'];
		$g['connect']['callapi_youtube'].= '&response_type=code&scope=https://www.googleapis.com/auth/youtube%20email%20profile&access_type=offline';

		if ($type == 'token')
		{
			if($_GET['error'] == 'access_denied') getLink('','','인증에 실패했습니다. 다시 시도해 주세요.','close');

			$_nowToken = $_REQUEST['state']=='/profile' ? 'token' : 'token_youtube';

			if ($_SESSION['SL'][$s]['userinfo'][$_nowToken])
			{
				$dat1['access_token'] = $_SESSION['SL'][$s]['userinfo'][$_nowToken];
			}
			else
			{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://accounts.google.com/o/oauth2/token");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, array(
					'code' => $g['connect']['code'],
					'client_id' => $g['connect']['client_id'],
					'client_secret' => $g['connect']['client_secret'],
					'redirect_uri' => urldecode($g['connect']['redirect_uri']),
					'grant_type' => 'authorization_code'
				));

				$dat1 = (array)json_decode(curl_exec($ch));
				curl_close($ch);
			}
			$dat2 = json_decode(getCURLData('https://www.googleapis.com/oauth2/v2/userinfo',array("Authorization: Bearer ".$dat1['access_token'])), true);

			$result = array();
			if($_nowToken == 'token')
			{
				$result['token'] = $dat1['access_token'];
				$result['token_youtube'] = $_SESSION['SL'][$s]['userinfo']['token_youtube'];
			}
			else {
				$result['token'] = $_SESSION['SL'][$s]['userinfo']['token'];
				$result['token_youtube'] = $dat1['access_token'];
			}
			$result['uid'] = $dat2['id'];
			$result['email'] = $dat2['email'];
			$result['name'] = $dat2['name'];
			$result['photo'] = $dat2['picture'];
			$result['link'] = $dat2['link'];
			$result['sex'] = $dat2['gender'] == 'male' ? 1 : 2;

			$_SESSION['SL'][$s]['userinfo'] = $result;
			header('Location: '.$connect_referer);
    //getLink($_SERVER['HTTP_REFERER'],'','','');
		}
	}

	// 인스타그램 ******************************************************************************************************************************************/
	if ($s == 'instagram')
	{
		$g['connect']['callapi'] = 'https://api.instagram.com/oauth/authorize/?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'].'&response_type=code';

		if ($type == 'token')
		{
			if($_GET['error'] == 'access_denied') getLink('','','인증에 실패했습니다. 다시 시도해 주세요.','close');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/oauth/access_token");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array(
				'code' => $g['connect']['code'],
				'client_id' => $g['connect']['client_id'],
				'client_secret' => $g['connect']['client_secret'],
				'redirect_uri' => urldecode($g['connect']['redirect_uri']),
				'grant_type' => 'authorization_code'
			));

			$dat1 = (array)json_decode(curl_exec($ch));
			curl_close($ch);
			$access_token = $dat1['access_token'];
			$dat2 = (array)$dat1['user'];

			$result = array();
			$result['access_token'] = $access_token;
			$result['uid'] = $dat2['id'];
			$result['name'] = $dat2['full_name'];
			$result['photo'] = $dat2['profile_picture'];
			$result['link'] = $dat2['website'];
			$_SESSION['SL'][$s]['userinfo'] = $result;
			header('Location: '.$connect_referer);
		}
	}

	return $g['connect'];
}

if ($_GET['connectReturn'] == 'naver') {
	socialLogin($_GET['connectReturn'],$d['connect']['key_n'],$d['connect']['secret_n'],$g['url_root'].'/'.$r.'/oauth/naver','token');
}
if ($_GET['connectReturn'] == 'kakao') {
	socialLogin($_GET['connectReturn'],$d['connect']['key_k'],$d['connect']['secret_k'],$g['url_root'].'/'.$r.'/oauth/kakao','token');
}
if ($_GET['connectReturn'] == 'google') {
	socialLogin($_GET['connectReturn'],$d['connect']['key_g'],$d['connect']['secret_g'],$g['url_root'].'/'.$r.'/oauth/google','token');
}
if ($_GET['connectReturn'] == 'facebook') {
	socialLogin($_GET['connectReturn'],$d['connect']['key_f'],$d['connect']['secret_f'],$g['url_root'].'/'.$r.'/oauth/facebook','token');
}
if ($_GET['connectReturn'] == 'instagram') {
	socialLogin($_GET['connectReturn'],$d['connect']['key_i'],$d['connect']['secret_i'],$g['url_root'].'/'.$r.'/oauth/instagram','token');
}
?>
