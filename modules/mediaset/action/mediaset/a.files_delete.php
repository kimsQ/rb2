<?php
if(!defined('__KIMS__')) exit;

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';

foreach($photomembers as $file_uid)
{
	$val = explode('|',$file_uid);
	$R = getUidData($table['s_upload'],$val[0]);
	if (!$my['admin'] && (!$R['mbruid'] || $my['uid'] != $R['mbruid']))
	{
		continue;
	}

	if ($dtype == 'move')
	{
		if ($R['category'] != $mcat)
		{
			getDbUpdate($table['s_upload'],'category='.$mcat,'uid='.$R['uid']);

			if ($R['category'] == -1)
			{
				if ($mcat == 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='none'");
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
				if ($mcat > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid'].' and uid='.$mcat);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
			}
			if($R['category'] == 0)
			{
				if ($mcat == -1)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='none'");
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
				if ($mcat > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid'].' and uid='.$mcat);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='none'");
				}
			}
			if($R['category'] > 0)
			{
				if ($mcat == -1)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and uid='.$R['category']);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
				}
				if ($mcat == 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and uid='.$R['category']);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='none'");
				}
				if ($mcat > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and uid='.$R['category']);
					getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid'].' and uid='.$mcat);
				}
			}
		}
		setrawcookie('mediaset_result', rawurlencode('사진이 이동 되었습니다.|success'));  // 처리여부 cookie 저장
	}
	else {

		if ($R['uid'])
		{
			if ($mediaset != 'Y' || $dtype == 'delete')
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

				if ($R['category'] > 0)
				{
					getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid'].' and type=1 and uid='.$R['category']);
				}
			}

			if ($R['category'] == -1)
			{
				if($dtype == 'delete') getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='trash'");
			}
			if ($R['category'] == 0)
			{
				getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
				getDbUpdate($table['s_uploadcat'],'r_num=r_num-1','mbruid='.$my['uid']." and type=1 and name='none'");
				if ($mediaset == 'Y' && $dtype != 'delete') getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
			}
			if($R['category'] > 0)
			{
				getDbUpdate($table['s_upload'],'category=-1','uid='.$R['uid']);
				if ($mediaset == 'Y' && $dtype != 'delete') getDbUpdate($table['s_uploadcat'],'r_num=r_num+1','mbruid='.$my['uid']." and type=1 and name='trash'");
			}
		}
	}
}
getLink('reload','parent.','','');
?>
