<?php
if(!defined('__KIMS__')) exit;

if ($d['admin']['ssl_type'] == 1)
if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');

$DB_CONNECT = isConnectedToDB($DB);
$g['mobile']= isMobileConnect($_SERVER['HTTP_USER_AGENT']);
$g['device']= $g['mobile'] && $_SESSION['pcmode'] != 'Y';
$g['broswer'] = getBrowzer($_SERVER['HTTP_USER_AGENT']);
$g['deviceType']=getDeviceKind($_SERVER['HTTP_USER_AGENT'],$g['mobile']);
$my = array();
$my['level'] = 0;

if ($_SESSION['mbr_uid'])
{
	$my = array_merge(getUidData($table['s_mbrid'],$_SESSION['mbr_uid']),getDbData($table['s_mbrdata'],"memberuid='".$_SESSION['mbr_uid']."'",'*'));
	if (!$my['uid'] || $my['pw'] != $_SESSION['mbr_pw']) { // 로그인 상태에서 관리자 회원삭제 된 경우
		$_SESSION['mbr_uid'] = '';
		$_SESSION['mbr_pw']  = '';
		$_SESSION['mbr_logout'] = '1';
		setAccessToken($my['uid'],'logout');
		setrawcookie('site_login_result', rawurlencode('로그아웃 되었습니다.|danger'),time() + (60 * 30), '/');
		getLink('reload','','','');
	}
}

// 로그인 상태 유지 프로세스 추가
if($_COOKIE[$DB['head'].'_token'])
{
    $memberuid=getArrayCookie($_COOKIE[$DB['head'].'_token'],'|',0);
    $access_token=getArrayCookie($_COOKIE[$DB['head'].'_token'],'|',1);
    $_now=time();
    $t_que="memberuid='".$memberuid."' and access_token='".$access_token."' and expire > '".$_now."' ";
    $is_token=getDbData($DB['head'].'_s_mbrtoken',$t_que,'*');
     if($is_token['uid']){
     	  $my = array_merge(getUidData($table['s_mbrid'],$memberuid),getDbData($table['s_mbrdata'],"memberuid='".$memberuid."'",'*'));
     }
}

if ($r)
{
	$_HS = getDbData($table['s_site'],"id='".$r."'",'*');
	$s = $_HS['uid'];
}

if (!$s)
{
	if ($g['mobile'])
	{
		$_HH = getDbData($table['s_mobile'],'','*');
		if ($_HH['usemobile'] == 1) $_HS = getUidData($table['s_site'],$_HH['startsite']);
		else if($_HH['usemobile'] == 2) if($g['url_host'] != $_HH['startdomain']) getLink($_HH['startdomain'],'','','');
	}
	if (!$_HS['uid'])
	{
		$_HD = getDbData($table['s_domain'],"name='".str_replace('www.','',$_SERVER['HTTP_HOST'])."'",'*');
		if ($_HD['site']) $_HS = getUidData($table['s_site'],$_HD['site']);
		else $_HS = db_fetch_array(getDbArray($table['s_site'],'','*','gid','asc',1,1));
	}
	$s = $_HS['uid'];
	$r = $_HS['id'];
}
else $_HS = getUidData($table['s_site'],$s);
$_SEO = getDbData($table['s_seo'],'rel=0 and parent='.$_HS['uid'],'*');
include getLangFile($g['path_module'].'admin/language/',($_HS['lang']?$_HS['lang']:$d['admin']['syslang']),'/lang.function.php');
include getLangFile($g['path_module'].'admin/language/',($_HS['lang']?$_HS['lang']:$d['admin']['syslang']),'/lang.engine.php');

$_CA = array();
$date = getVDate($_HS['timecal']);
$g['s'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
$g['r'] = $_HS['rewrite'] ? $g['s'].($_HS['usescode']?'/'.$r:'') : '.';
$g['img_core'] = $g['s'].'/_core/images';
$g['meta_tit'] = $_SEO['title'];
$g['meta_key'] = $_SEO['keywords'];
$g['meta_des'] = $_SEO['description'];
$g['meta_bot'] = $_SEO['classification'];
$g['meta_img'] = $_SEO['image_src']?getMetaImage($_SEO['image_src']):$g['img_core'].'/noimage_kimsq.png';
$g['sys_module'] = $d['admin']['sysmodule'];
$g['sys_action'] = $a && !$c ? true : false;
$m = $m && !strstr($m,'.') ? $m : $g['sys_module'];
$_m = $m;
$_mod = $mod;

if (!$g['sys_action'] && !$system)
{
	if ($c)
	{
		$c=substr($c,-1)=='/'?str_replace('/','',$c):$c;
		$_CA = explode('/',$c);
		$_tmp['count'] = count($_CA);
		$_tmp['id'] = $_CA[$_tmp['count']-1];
		$_HM = getDbData($table['s_menu'],"id='".$_tmp['id']."' and site=".$s,'*');
		if ($_tmp['count']>1) $_FHM = getDbData($table['s_menu'],"id='".$_CA[0]."' and site=".$s,'*');
		else $_FHM = $_HM;

		if ($_HM['reject']&&!$my['admin']) getLink('','',_LANG('em001','admin'),'-1');
		if ($_HM['site']!=$_HS['uid']) getLink('','',_LANG('em002','admin'),'-1');

		if($_HM['menutype']==1)
		{
			if ($_HM['redirect']) getLink($_HM['joint'],'','','');
			$_tmpexp = explode('?',$_HM['joint']);
			if ($_tmpexp[1])
			{
				$_tmparr = explode('&',$_tmpexp[1]);
				foreach($_tmparr as $_tmpval)
				{
					if(!$_tmpval) continue;
					$_tmparr = explode('=',$_tmpval);
					${$_tmparr[0]} = $_tmparr[1];
				}
			}
		}

		if($_HM['menutype']==3)
		{
			getLink(RW('c='.$_HM['joint']),'','','');
		}

	}

	if (!$c && $m == $g['sys_module'])
	{
		if (!$mod) $_HP = getUidData($table['s_page'],$g['mobile']&&$_SESSION['pcmode']!='Y'?($_HS['m_startpage']?$_HS['m_startpage']:$_HS['startpage']):$_HS['startpage']);
		else $_HP = getDbData($table['s_page'],"id='".$mod."'",'*');
		if($_HP['uid']) $_HM['layout'] = $_HP['layout'];
		if ($_HP['pagetype']==1)
		{
			$_HM['layout'] = $_HP['layout'];
			$_tmpexp = explode('?',$_HP['joint']);
			if ($_tmpexp[1])
			{
				$_tmparr = explode('&',$_tmpexp[1]);
				foreach($_tmparr as $_tmpval)
				{
					if(!$_tmpval) continue;
					$_tmparr = explode('=',$_tmpval);
					${$_tmparr[0]} = $_tmparr[1];
				}
				if ($_m == $g['sys_module']) $_mod = '';
				if ($m  != $g['sys_module']) $mod = $_mod;
			}
		}
	}

	if ($d['admin']['ssl_type'] == 2)
	{
		if ($_HP['uid'])
		{
			if (strpos(',,'.$d['admin']['ssl_page'].',',','.$_HP['id'].','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
		else if ($_HM['uid'])
		{
			if (strpos(',,'.$d['admin']['ssl_menu'].',',','.$_HM['id'].','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
		else {
			if (strpos(',,'.$d['admin']['ssl_module'].',',','.$m.','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
	}
}

$_HMD = getDbData($table['s_module'],"id='".$m."'",'*');

$g['switch_1'] = getSwitchInc('top');
$g['switch_2'] = getSwitchInc('head');
$g['switch_3'] = getSwitchInc('foot');
$g['switch_4'] = getSwitchInc('end');

//사이트별 회원설정 변수
$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php'; // 사이트 회원모듈 변수파일
include_once file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].'member/var/var.php';

//사이트별 포스트설정 변수
$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
include_once file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['path_module'].'post/var/var.php';

$d['post']['writeperm'] = true;

if (!$my['admin']) {
	if ($d['post']['perm_l_write'] > $my['level'] || strpos('_'.$d['post']['perm_g_write'],'['.$my['mygroup'].']') || !$my['uid']) {
	  $d['post']['writeperm'] = false;
	}
}

//사이트별 게시판 공통설정 변수
$g['bbsVarForSite'] = $g['path_var'].'site/'.$r.'/bbs.var.php';
include_once file_exists($g['bbsVarForSite']) ? $g['bbsVarForSite'] : $g['path_module'].'bbs/var/var.php';

//사이트별 댓글설정 변수
$g['commentVarForSite'] = $g['path_var'].'site/'.$r.'/comment.var.php';
include_once file_exists($g['commentVarForSite']) ? $g['commentVarForSite'] : $g['path_module'].'comment/var/var.php';

// 회원가입을 위한 이메일/휴대폰 본인인증 후 관련세션 존재유무
if (isset($_SESSION['JOIN']['email']) || isset($_SESSION['JOIN']['phone'])) {
	$call_modal_join_site=1;  //  인증후,가입 모달 호출
}

//사이트별 외부연결 설정
if (file_exists($g['path_var'].'site/'.$r.'/connect.var.php')) {
	include $g['path_var'].'site/'.$r.'/connect.var.php';
}

// 푸시알림 지원여부
if ( $g['mobile']!='ipad' && $g['mobile']!='iphone') {
	if ($g['broswer']!='MSIE 11' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 9' && $g['broswer']!='Safari') {

		$g['pwa_supported']=1;

		if (file_exists($g['path_var'].'fcm.info.js')) {
			$g['push_active']=1;
		} else {
			$g['push_active']=2;
		}

	}
}

// 포스트 공개관련
$d['displaySet'] = "||비공개,lock||일부공개,how_to_reg||미등록,insert_link||회원공개,people_alt||전체공개,public";
$g['displaySet']['label'] = [];
$g['displaySet']['icon'] = [];
$displaySet=explode('||',$d['displaySet']);
foreach ($displaySet as $displayLine) {
	$dis=explode(',',$displayLine);
	array_push($g['displaySet']['label'], $dis[0]);
	array_push($g['displaySet']['icon'], $dis[1]);
}

//소셜로그인 세션 존재유무
if(isset($_SESSION['SL']['naver'])||isset($_SESSION['SL']['kakao'])||isset($_SESSION['SL']['facebook'])||isset($_SESSION['SL']['google'])||isset($_SESSION['SL']['instagram'])||isset($_SESSION['SL']['twitter'])){
	if (is_array($_SESSION['SL']['naver']) || is_array($_SESSION['SL']['kakao']) || is_array($_SESSION['SL']['facebook']) || is_array($_SESSION['SL']['google']) || is_array($_SESSION['SL']['instagram']) || is_array($_SESSION['SL']['twitter'])){
		$is_socialUserinfoSession = 1;
	}
}

//소셜로그인을 사용할때
if ($d['member']['login_social'] || $d['member']['join_bySocial']) {
	if ($is_socialUserinfoSession) {
		if (isset($_SESSION['SL']['naver'])) {
			$sns_code = 'n';
			$sns_name = 'naver';
			$sns_name_ko = '네이버';
			$sns_access_token	= $_SESSION['SL']['naver']['userinfo']['access_token']; //소셜미디어 접근토큰
			$sns_refresh_token	= $_SESSION['SL']['naver']['userinfo']['refresh_token']; //소셜미디어 갱신토큰
			$sns_expires_in	= $_SESSION['SL']['naver']['userinfo']['expires_in']; //소셜미디어 접근 토큰 유효기간(초)
			$snsuid	= $_SESSION['SL']['naver']['userinfo']['uid']; //소셜미디어 고유번호
			$name	= $_SESSION['SL']['naver']['userinfo']['name'];
			$email	= $_SESSION['SL']['naver']['userinfo']['email'];
			$_photo	= $_SESSION['SL']['naver']['userinfo']['photo'];
		}
		if (isset($_SESSION['SL']['kakao'])) {
			$sns_code = 'k';
			$sns_name = 'kakao';
			$sns_name_ko = '카카오';
			$sns_access_token	= $_SESSION['SL']['kakao']['userinfo']['access_token']; //소셜미디어 접근토큰
			$sns_refresh_token	= $_SESSION['SL']['kakao']['userinfo']['refresh_token']; //소셜미디어 갱신토큰
			$sns_expires_in	= $_SESSION['SL']['kakao']['userinfo']['expires_in']; //소셜미디어 접근 토큰 유효기간(초)
			$snsuid	= $_SESSION['SL']['kakao']['userinfo']['uid'];  //소셜미디어 고유번호
			$name	= $_SESSION['SL']['kakao']['userinfo']['name'];
			$email	= $_SESSION['SL']['kakao']['userinfo']['email'];
			$_photo	= $_SESSION['SL']['kakao']['userinfo']['photo'];
		}
		if (isset($_SESSION['SL']['facebook'])) {
			$sns_code = 'f';
			$sns_name = 'facebook';
			$sns_name_ko = '페이스북';
			$sns_access_token	= $_SESSION['SL']['facebook']['userinfo']['access_token']; //소셜미디어 접근토큰
			$sns_refresh_token	= $_SESSION['SL']['facebook']['userinfo']['refresh_token']; //소셜미디어 갱신토큰
			$sns_expires_in	= $_SESSION['SL']['facebook']['userinfo']['expires_in']; //소셜미디어 접근 토큰 유효기간(초)
			$snsuid	= $_SESSION['SL']['facebook']['userinfo']['uid'];  //소셜미디어 고유번호
			$name	= $_SESSION['SL']['facebook']['userinfo']['name'];
			$email	= $_SESSION['SL']['facebook']['userinfo']['email'];
			$_photo	= $_SESSION['SL']['facebook']['userinfo']['photo'];
		}
		if (isset($_SESSION['SL']['google'])) {
			$sns_code = 'g';
			$sns_name = 'google';
			$sns_name_ko = '구글';
			$sns_access_token	= $_SESSION['SL']['google']['userinfo']['access_token']; //소셜미디어 접근토큰
			$sns_refresh_token	= $_SESSION['SL']['google']['userinfo']['refresh_token']; //소셜미디어 갱신토큰
			$sns_expires_in	= $_SESSION['SL']['google']['userinfo']['expires_in']; //소셜미디어 접근 토큰 유효기간(초)
			$snsuid	= $_SESSION['SL']['google']['userinfo']['uid'];  //소셜미디어 고유번호
			$name	= $_SESSION['SL']['google']['userinfo']['name'];
			$email	= $_SESSION['SL']['google']['userinfo']['email'];
			$_photo	= $_SESSION['SL']['google']['userinfo']['photo'];
		}
		if (isset($_SESSION['SL']['instagram'])) {
			$sns_code = 'i';
			$sns_name = 'instagram';
			$sns_name_ko = '인스타그램';
			$sns_access_token	= $_SESSION['SL']['instagram']['userinfo']['access_token']; //소셜미디어 접근토큰
			$snsuid	= $_SESSION['SL']['instagram']['userinfo']['uid']; //소셜미디어 고유번호
			$name	= $_SESSION['SL']['instagram']['userinfo']['name'];
			$_photo	= $_SESSION['SL']['instagram']['userinfo']['photo'];
		}

		$mbr_sns = getDbData($table['s_mbrsns'],'id='.$snsuid.' and sns="'.$sns_name.'"','mbruid');
		$mbr_email = getDbData($table['s_mbremail'],"email='".$email."'",'*');
		$d_regis	= $date['totime'];

		if ($my['uid']) {

			// 개인정보관리 > 연결계정 > 추가 연결
			if ($mbr_sns['mbruid'] && ($mbr_sns['mbruid'] != $my['uid'])) {
				setrawcookie('site_login_result', rawurlencode($sns_name_ko.' 계정이 이미 다른계정에 연결되어 있습니다.|danger'),time() + (60 * 30), '/');
				$_SESSION['SL'] = '';  // 세션비우기
				getLink('reload','','','');
			}

			if ($mbr_sns['mbruid']) {
				$msg = ' 계정이 재인증 되었습니다.'; //개인정보관리 > 개인정보잠금 > 재인증
			} else {  //신규연결
				$msg = ' 계정이 연결 되었습니다.';  // 개인정보관리 > 연결계정 > 추가 연결
				getDbInsert($table['s_mbrsns'],'mbruid,sns,id,access_token,refresh_token,expires_in,d_regis',"'".$my['uid']."','".$sns_name."','$snsuid','$sns_access_token','$sns_refresh_token','$sns_expires_in','$d_regis'");
			}

			getDbUpdate($table['s_mbrdata'],"last_log='".$date['totime']."'",'memberuid='.$my['uid']);
			setrawcookie('site_login_result', rawurlencode($sns_name_ko.$msg.'|default'),time() + (60 * 30), '/');  // 알림레이어 출력를 위한 로그인 상태 cookie 저장
			$_SESSION['SL'] = '';  // 세션비우기
			getLink('reload','','','');

		} else {  // 비로그인 상태

				//결과값 못 받은 경우
				if (!$name) {
					$_SESSION['SL'] = '';
					setrawcookie('site_login_result',rawurlencode($sns_name_ko.' 에서 정보를 수신하지 못했습니다.|danger'),time() + (60 * 30), '/');
					getLink('reload','','','');
				}

				// 정상 소셜로그인 (이미 연결된 소셜미디어 고유번호가 있을 경우, 해당회원 로그인 처리)
				if ($mbr_sns['mbruid']) {
					$M	= getUidData($table['s_mbrid'],$mbr_sns['mbruid']);
					getDbUpdate($table['s_mbrdata'],"tmpcode='',now_log=1,last_log='".$date['totime']."',sns='".$sns_name."'",'memberuid='.$M['uid']);
					$_SESSION['mbr_uid'] = $M['uid'];
					$_SESSION['mbr_pw']  = $M['pw'];

					setAccessToken($mbr_sns['mbruid'],'login');  //로그인 유지 기본적용

					setrawcookie('site_login_result',rawurlencode($sns_name_ko.' 계정으로 로그인 되었습니다.|default'),time() + (60 * 30), '/');  // 알림레이어 출력를 위한 로그인 상태 cookie 저장
					$_SESSION['SL'] = ''; //세션 비우기
					getLink('reload','','','');
				}

				// 소셜미디어에서 획득한 이메일이 기존 회원의 동일한 이메일에 있을 경우,
				if ($mbr_email['mbruid']) {

					if ($mbr_email['d_verified']) {
						// 본인 인증된 메일일 경우, 자동 로그인 및 연결처리 (동일인 중복가입을 막기위해)
						$M	= getUidData($table['s_mbrid'],$mbr_email['mbruid']);
						$d_regis	= $date['totime'];
						getDbUpdate($table['s_mbrdata'],"tmpcode='',now_log=1,last_log='".$date['totime']."',sns='".$sns_name."'",'memberuid='.$M['uid']);
						getDbInsert($table['s_mbrsns'],'mbruid,sns,id,access_token,refresh_token,expires_in,d_regis',"'".$M['uid']."','".$sns_name."','$snsuid','$sns_access_token','$sns_refresh_token','$sns_expires_in','$d_regis'");

						$_SESSION['mbr_uid'] = $M['uid'];
						$_SESSION['mbr_pw']  = $M['pw'];
						setrawcookie('site_login_result', rawurlencode($sns_name_ko.' 계정으로 로그인 되었습니다.|default'),time() + (60 * 30), '/');  // 알림레이어 출력를 위한 로그인 상태 cookie 저장
						$_SESSION['SL'] = ''; //세션 비우기
						getLink('reload','','','');

					} else {
						// 계정연결 모달 호출

						$is_sns = getDbData($table['s_mbrsns'],'mbruid="'.$mbr_email['mbruid'].'"','sns');
						$has_sns = $is_sns['sns'];

						if ($is_sns['sns']=='naver') $has_sns_ko = '네이버';
						if ($is_sns['sns']=='kakao') $has_sns_ko = '카카오';
						if ($is_sns['sns']=='google') $has_sns_ko = '구글';
						if ($is_sns['sns']=='facebook') $has_sns_ko = '페이스북';
						if ($is_sns['sns']=='instagram') $has_sns_ko = '인스타그램';

						setrawcookie('site_login_result', rawurlencode($sns_name_ko.' 사용자 인증 되었습니다. 계정을 연결해 주세요.|default'),time() + (60 * 30), '/'); // 알림레이어 출력를 위한 로그인 상태 cookie 저장
						if ($m!='member' || $front!="login") {
							$call_modal_combine=1;  // 계정통합 모달 호출
						}
					}

				} else {

					if ($d['member']['join_enable']) { // 회원가입 작동 중지
						setrawcookie('site_login_result', rawurlencode($sns_name_ko.' 사용자 인증 되었습니다.|default'),time() + (60 * 30), '/'); // 알림레이어 출력를 위한 로그인 상태 cookie 저장
						if ($m!='member' || $front!="join") {
							$call_modal_join_social=1;  // 소셜로그인 인증후,가입 모달 호출
						}
					} else {
						$call_modal_join_social=0;
						$_SESSION['SL'] = ''; //세션 비우기
						setrawcookie('site_login_result', rawurlencode(' 죄송합니다. 지금은 회원가입을 하실 수 없습니다.|danger'),time() + (60 * 30), '/'); // 알림레이어 출력를 위한 로그인 상태 cookie 저장
					}

				}
		}

	} //소셜미디어에서 확득한 사용자 정보배열 세션이 있을때 끝

	// 연결계정 정보
	$my_naver = getDbData($table['s_mbrsns'],"mbruid='".$my['uid']."' and sns='naver'",'*');
	$my_kakao = getDbData($table['s_mbrsns'],"mbruid='".$my['uid']."' and sns='kakao'",'*');
	$my_google = getDbData($table['s_mbrsns'],"mbruid='".$my['uid']."' and sns='google'",'*');
	$my_facebook = getDbData($table['s_mbrsns'],"mbruid='".$my['uid']."' and sns='facebook'",'*');
	$my_instagram = getDbData($table['s_mbrsns'],"mbruid='".$my['uid']."' and sns='instagram'",'*');
}
?>
