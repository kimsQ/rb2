<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

$NT_DATA = explode('|',$my['noticeconf']);

if ($member_uid)
{
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.$NT_DATA[3].'|'.str_replace('['.$member_uid.']','',$NT_DATA[4]).'|'.$NT_DATA[5].'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
	setrawcookie('member_settings_result', rawurlencode('해제 되었습니다.'));
	getLink('reload','parent.','','');
}
else if ($module_id)
{
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.str_replace('['.$module_id.']','',$NT_DATA[3]).'|'.$NT_DATA[4].'|'.$NT_DATA[5].'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);

	if ($mobile) {
		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "알림이 설정되었습니다."},{type: "default"});';
		echo '</script>';
		exit();
	} else {
		setrawcookie('member_settings_result', rawurlencode('알림이 설정되었습니다.'));
		getLink('reload','parent.','','');
	}
}
else {
	$NT_STRING = $nt_web.'|'.$nt_email.'|'.$nt_fcm.'|'.$NT_DATA[3].'|'.$NT_DATA[4].'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);

	if (!$mobile) {

		if ($sendAjax) {

			$result['error']=false;
			echo json_encode($result);
			exit;

		} else {
			setrawcookie('member_settings_result', rawurlencode('설정이 저장되었습니다.'));
			getLink('reload','parent.','','');
		}


	} else {

		if (!$reload) {

			if ($sendAjax) {
				$result['error']=false;
				echo json_encode($result);
				exit;
			} else {
				if ($nt_email) {
					$nt_email_addClass = 'badge-primary badge-pill';
					$nt_email_removeClass = 'badge-default badge-outline';
				}
				else {
					$nt_email_addClass = 'badge-default badge-outline';
					$nt_email_removeClass = 'badge-primary badge-pill';
				}

				if ($nt_fcm) {
					$nt_fcm_addClass = 'badge-primary badge-pill';
					$nt_fcm_removeClass = 'badge-default badge-outline';
				}
				else {
					$nt_fcm_addClass = 'badge-default badge-outline';
					$nt_fcm_removeClass = 'badge-primary badge-pill';
				}

				echo '<script type="text/javascript">';
				echo 'parent.$.notify({message: "설정이 저장되었습니다."},{type: "default"});';
				echo 'parent.$("#page-main").find("[data-role=email]").addClass("'.$nt_email_addClass.'").removeClass("'.$nt_email_removeClass.'");';
				echo 'parent.$("#page-main").find("[data-role=fcm]").addClass("'.$nt_fcm_addClass.'").removeClass("'.$nt_fcm_removeClass.'");';
				echo '</script>';
				exit();
			}

		} else {
			setrawcookie('member_settings_result', rawurlencode('설정이 저장되었습니다.'));
			getLink('reload','parent.','','');
		}

	}
}
?>
