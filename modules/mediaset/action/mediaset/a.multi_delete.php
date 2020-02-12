<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

function getuFileType($R)
{
	if ($R['type'] == 2 || $R['type'] == -1) return 1;
	if ($R['type'] == 5 || $R['type'] == 0) return 2;
	return 0;
}

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';

$_MEMBERS = array();
foreach($upfile_members as $val)
{
	$R = getUidData($table['s_upload'],$val);
	if ($R['uid'])
	{
		getDbDelete($table['s_upload'],'uid='.$R['uid']);

		if ($R['type']>0)
		{
			if ($R['fserver'] && $R['url'] == $d['mediaset']['ftp_urlpath'])
			{
				$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
				$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
				if (!$FTP_CONNECT) continue;
				if (!$FTP_CRESULT) continue;
				if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

				ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$R['folder'].'/'.$R['tmpname']);
				if($R['type']==2) ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$R['folder'].'/'.$R['thumbname']);
				ftp_close($FTP_CONNECT);
			}
			else {
				unlink($g['path_file'].$R['folder'].'/'.$R['tmpname']);
				if($R['type']==2) unlink($g['path_file'].$R['folder'].'/'.$R['thumbname']);
			}
		}

		$_type = getuFileType($R['type']);

		if ($R['category'] == -1)
		{
			getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$R['mbruid']." and type=".$_type." and name='trash'");
		}
		if ($R['category'] == 0)
		{
			getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
			getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$R['mbruid']." and type=".$_type." and name='none'");
		}
		if($R['category'] > 0)
		{
			getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$R['mbruid'].' and type='.$_type.' and uid='.$R['category']);
			getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
		}

		if($R['mbruid']) $_MEMBERS['m'.$R['mbruid']]++;
	}
}
//파일이 삭제된 회원들에게 알림
foreach($_MEMBERS as $_key => $_val)
{
	putNotice(str_replace('m','',$_key),$m,0,sprintf(_LANG('a4001','mediaset'),$_val),'','');
}

getLink('reload','parent.','','');
?>
