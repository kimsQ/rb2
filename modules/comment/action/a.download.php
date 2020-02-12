<?php
if(!defined('__KIMS__')) exit;
include_once $g['dir_module'].'var/var.php';
$R=getUidData($table['s_upload'],$uid);
if (!$R['uid']) getLink('','','정상적인 요청이 아닙니다.','');
$filename = getUTFtoKR($R['name']);
$filetmpname = getUTFtoKR($R['tmpname']);
if ($R['url']==$d['upload']['ftp_urlpath'])
{
	$filepath = $d['upload']['ftp_urlpath'].$R['folder'].'/'.$filetmpname;
	$filesize = $R['size'];
}
else {
	$filepath = '.'.$R['url'].$R['folder'].'/'.$filetmpname;
	$filesize = filesize($filepath);
}
if (!strstr($_SERVER['HTTP_REFERER'],'module=upload'))
{
	//동기화
	$cyncArr = getArrayString($R['cync']);
	$fdexp = explode(',',$cyncArr['data'][2]);
	if($fdexp[0]&&$fdexp[1]&&$cyncArr['data'][3])
	{
		if ($cyncArr['data'][0] == 'bbs' && $cyncArr['data'][1])
		{
			$AT = getUidData($table[$cyncArr['data'][0].'data'],$cyncArr['data'][1]);
			include_once $g['path_module'].$cyncArr['data'][0].'/var/var.'.$AT['bbsid'].'.php';
			$B['var'] = $d['bbs'];
			if (!$my['admin'] && $my['uid'] != $AT['mbruid'])
			{
				if ($B['var']['perm_l_down'] > $my['level'] || strstr($B['var']['perm_g_down'],'['.$my['sosok'].']'))
				{
					getLink('','','다운로드 권한이 없습니다.','-1');
				}
			}
			if ($B['var']['point3'])
			{
				if (!$my['uid']) getLink('','','다운로드 권한이 없습니다.','-1');
				$UT = getDbData($table[$cyncArr['data'][0].'xtra'],'parent='.$AT['uid'],'*');
				if (!strpos('_'.$UT['down'],'['.$my['uid'].']') && !strpos('_'.$_SESSION['module_'.$cyncArr['data'][0].'_dncheck'],'['.$AT['uid'].']'))
				{
					if ($confirm == 'Y' && $my['point'] >= $B['var']['point3'])
					{
						if (!$my['admin'] && $my['uid'] != $AT['mbruid'])
						{
							getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','-".$B['var']['point3']."','다운로드(".getStrCut($AT['subject'],15,'').")','".$date['totime']."'");
							getDbUpdate($table['s_mbrdata'],'point=point-'.$B['var']['point3'].',usepoint=usepoint+'.$B['var']['point3'],'memberuid='.$my['uid']);
							if (!$UT['parent'])
							{
								getDbInsert($table[$cyncArr['data'][0].'xtra'],'parent,site,bbs,down',"'".$AT['uid']."','".$s."','".$AT['bbs']."','[".$my['uid']."]'");
							}
							else {
								getDbUpdate($table[$cyncArr['data'][0].'xtra'],"down='".$UT['down']."[".$my['uid']."]'",'parent='.$AT['uid']);
							}
						}
						$_SESSION['module_'.$cyncArr['data'][0].'_dncheck'] = $_SESSION['module_'.$cyncArr['data'][0].'_dncheck'].'['.$AT['uid'].']';
						getLink('','','결제되었습니다. 다운로드 받으세요.','close');
					}
					else {
						getWindow($g['s'].'/?iframe=Y&r='.$r.'&m='.$cyncArr['data'][0].'&bid='.$AT['bbsid'].'&mod=down&dfile='.$uid.'&uid='.$AT['uid'],'','width=550px,height=350px,status=yes,toolbar=no,scrollbars=no',$_SERVER['HTTP_REFERER'].'#attach','');
						exit;
					}
				}
			}
		}
		$cyncQue = $fdexp[1].'='.$fdexp[1].'+1';
		getDbUpdate($cyncArr['data'][3],$cyncQue,$fdexp[0].'='.$cyncArr['data'][1]);
	}
	getDbUpdate($table['s_upload'],'down=down+1','uid='.$R['uid']);
	getDbUpdate($table['s_numinfo'],'download=download+1',"date='".$date['today']."' and site=".$s);
}
header("Content-Type: application/octet-stream"); 
header("Content-Length: " .$filesize); 
header('Content-Disposition: attachment; filename="'.$filename.'"'); 
header("Cache-Control: private, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0");
if ($R['url']==$d['upload']['ftp_urlpath'])
{
	$FTP_CONNECT = ftp_connect($d['upload']['ftp_host'],$d['upload']['ftp_port']); 
	$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['upload']['ftp_user'],$d['upload']['ftp_pass']); 
	if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
	if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
	if($d['upload']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);
	
	$filepath = $g['path_tmp'].'session/'.$filetmpname;
	ftp_get($FTP_CONNECT,$filepath,$d['upload']['ftp_folder'].$R['folder'].'/'.$filetmpname,FTP_BINARY);
	ftp_close($FTP_CONNECT);
	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
	unlink($filepath);
}
else {
	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
}
exit;
?>