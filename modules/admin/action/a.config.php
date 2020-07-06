<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$fdset = array();
$fdset['config'] = array('themepc','pannellink','cache_flag','mailer','ses_key','ses_sec','ses_region','uninstall','dblclick','codeeidt','editor','syslang','sysmail','sysmodule','sms_tel','sms_id','sms_key','fcm_key','fcm_SenderId','fcm_VAPID','site_cutid');
$fdset['security'] = array('secu_tags','secu_domain','secu_param');

// system -> sys 필드명 변경
$_tmp1 = db_query("SHOW COLUMNS FROM ".$table['s_module']." WHERE `Field` = 'sys'",$DB_CONNECT);
if(!db_num_rows($_tmp1)) {
	$_tmp1 = ("alter table ".$table['s_module']." CHANGE system sys TINYINT(4) not null");
	db_query($_tmp1, $DB_CONNECT);
}

//제거탭 출력 주의 알림
if (!$d['admin']['uninstall'] && $uninstall)
{
	$_message = '시스템 도구에서 <strong>제거</strong>(<code>Uninstall</code>) 탭이 출력되도록 설정되었습니다. 이 설정은 매우 위험할 수 있으니 확인하세요.';
	$_referer = $g['s'].'/?r='.$r.'&m=admin&module=admin';
	putNotice($my['uid'],$m,0,$_message,$_referer,'');
}

if ($act == 'config')
{
	if ($d['admin']['syslang'] != $syslang)
	{
		$RCD = getDbArray($table['s_module'],'','*','gid','asc',0,1);
		while($_R = db_fetch_array($RCD))
		{
			$new_modulename = $g['path_module'].$_R['id'].'/language/'.$syslang.'/name.module.txt';
			getDbUpdate($table['s_module'],"name='".($syslang&&is_file($new_modulename)?implode('',file($new_modulename)):getFolderName($g['path_module'].$_R['id']))."'","id='".$_R['id']."'");
		}
		$panel_reload = true;
	}
}
foreach ($fdset[$act] as $val)
{
	$d['admin'][$val] = str_replace("\n",'',trim(${$val}));
}

$_tmpdfile = $g['path_var'].'/system.var.php';
$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
foreach ($d['admin'] as $key => $val)
{
	fwrite($fp, "\$d['admin']['".$key."'] = \"".addslashes(stripslashes($val))."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

//FCM 연결정보
$_tmpjfile = $g['path_var'].'fcm.info.js';
if ($fcm_SenderId) {
	$fp = fopen($_tmpjfile,'w');
	fwrite($fp, "var firebase_app_js_src = '".$fcm_app_js_src."'\n");
	fwrite($fp, "var firebase_messaging_js_src = '".$fcm_messaging_js_src."'\n");
	fwrite($fp, "var fcmSenderId = '".$fcm_SenderId."'\n");
	fwrite($fp, "var fcmVAPID = '".$fcm_VAPID."'\n");
	fwrite($fp, "var icon = '".$fcm_icon."'\n");
	fclose($fp);
	@chmod($_tmpjfile,0707);
} else {
	unlink($_tmpjfile);
}

if($autosave):
?>
<script>
parent.document.procForm.target = '';
parent.document.procForm.a.value = 'config';
parent.document.procForm.autosave.value = '';
</script>
<?php
exit;
endif;
if ($panel_reload) getLink($g['s'].'/?r='.$r.'&pickmodule='.$m.'&panel=Y','parent.parent.','','');
else {
	setrawcookie('admin_config_result', rawurlencode('시스템 설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}
?>
