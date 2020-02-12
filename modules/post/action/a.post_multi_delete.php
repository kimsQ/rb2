<?phpif(!defined('__KIMS__')) exit;
checkAdmin(0);
include_once $g['dir_module'].'var/var.php';
foreach ($post_members as $val){
  $R=getUidData($table[$m.'data'],$val);

  if (!$R['uid']) continue;

  $IDX = getDbSelect($table[$m.'index'],'data='.$R['uid'],'*');
  while($I=db_fetch_array($IDX)) {
    getDbUpdate($table[$m.'category'],'num=num-1','uid='.$I['category']);  //카테고리 등록 포스트 수 조정
  }

  getDbDelete($table[$m.'data'],'uid='.$R['uid']); //데이터삭제
  getDbDelete($table[$m.'index'],'data='.$R['uid']);//인덱스삭제
  getDbDelete($table[$m.'member'],'data='.$R['uid']);//멤버삭제

  //첨부파일삭제
  if ($R['upload'])
  {
  	$UPFILES = getArrayString($R['upload']);

  	foreach($UPFILES['data'] as $_val)
  	{
  		$U = getUidData($table['s_upload'],$_val);
  		if ($U['uid'])
  		{
  			getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
  			getDbDelete($table['s_upload'],'uid='.$U['uid']);
  			if ($U['url']==$d['upload']['ftp_urlpath'])
  			{
  				$FTP_CONNECT = ftp_connect($d['upload']['ftp_host'],$d['upload']['ftp_port']);
  				$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['upload']['ftp_user'],$d['upload']['ftp_pass']);
  				if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
  				if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
  				if($d['upload']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);

  				ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
  				if($U['type']==2) ftp_delete($FTP_CONNECT,$d['upload']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
  				ftp_close($FTP_CONNECT);
  			}
  			else {
  				unlink($g['path_file'].$m.'/'.$U['folder'].'/'.$U['tmpname']);
  			}
  		}
  	}
  }

}

setrawcookie('result_post_main', rawurlencode('삭제 되었습니다.|danger'));
getLink('reload','parent.','','');
?>
