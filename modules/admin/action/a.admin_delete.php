<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

foreach ($mbrmembers as $val)
{
	if ($my['uid'] == $val) continue;
	$M=getDbData($table['s_mbrid'],'uid='.$val,'*');
	$_M=getDbData($table['s_mbrdata'],'memberuid='.$val,'*');
	if($auth)
	{
		if ($auth == 'D')
		{
			getDbDelete($table['s_mbrid'],'uid='.$M['uid']);
			getDbDelete($table['s_mbrdata'],'memberuid='.$M['uid']);
			getDbDelete($table['s_mbrcomp'],'memberuid='.$M['uid']);
			getDbDelete($table['s_paper'],'my_mbruid='.$M['uid']);
			getDbDelete($table['s_point'],'my_mbruid='.$M['uid']);
			getDbDelete($table['s_scrap'],'mbruid='.$M['uid']);
			getDbDelete($table['s_friend'],'my_mbruid='.$M['uid'].' or by_mbruid='.$M['memberuid']);
			getDbUpdate($table['s_mbrlevel'],'num=num-1','uid='.$_M['level']);
			getDbUpdate($table['s_mbrgroup'],'num=num-1','uid='.$_M['sosok']);
			getDbDelete($table['s_mbrsns'],'memberuid='.$M['uid']);

			if (is_file($g['path_var'].'avatar/'.$M['photo']))
			{
				unlink($g['path_var'].'avatar/'.$M['photo']);
			}
			$fp = fopen($g['path_tmp'].'out/'.$M['id'].'.txt','w');
			fwrite($fp,$date['totime']);
			fclose($fp);
			@chmod($g['path_tmp'].'out/'.$M['id'].'.txt',0707);
		}
		else if ($auth == 'A')
		{
			getDbUpdate($table['s_mbrdata'],"super=1,admin=1,adm_view='[admin]'",'memberuid='.$M['uid']);
		}
		else {
			getDbUpdate($table['s_mbrdata'],"auth='$auth'",'memberuid='.$M['uid']);
		}
	}
	else {
		getDbUpdate($table['s_mbrdata'],"super=0,admin=0,adm_view='',adm_site=''",'memberuid='.$M['uid']);
	}
}
setrawcookie('admin_admin_result', rawurlencode('처리 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
