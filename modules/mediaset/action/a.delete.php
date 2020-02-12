<?php
if(!defined('__KIMS__')) exit;

$uid = $_POST['uid']; // 첨부물 UID

$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['dir_module'].'var/var.php';
include_once $g['path_core'].'opensrc/aws-sdk-php/v3/aws-autoloader.php';

use Aws\S3\S3Client;

define('S3_KEY', $d['mediaset']['S3_KEY']); //발급받은 키.
define('S3_SEC', $d['mediaset']['S3_SEC'] ); //발급받은 비밀번호.
define('S3_REGION', $d['mediaset']['S3_REGION']);  //S3 버킷의 리전.
define('S3_BUCKET', $d['mediaset']['S3_BUCKET']); //버킷의 이름.

$U = getUidData($table['s_upload'],$uid);
 if ($U['uid'])
 {
     getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
     getDbDelete($table['s_upload'],'uid='.$U['uid']);

     if ($U['host']==$d['mediaset']['ftp_urlpath'])
     {
         $FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']);
         $FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']);
         if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
         if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');

         ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
         if($U['type']==2) ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
         ftp_close($FTP_CONNECT);

     } elseif ($U['fserver']==2) {

       $s3 = new S3Client([
         'version'     => 'latest',
         'region'      => S3_REGION,
         'credentials' => [
             'key'    => S3_KEY,
             'secret' => S3_SEC,
         ],
       ]);

       $s3->deleteObject([
         'Bucket' => S3_BUCKET,
         'Key'    => $U['folder'].'/'.$U['tmpname']
       ]);


     } else {
        unlink('.'.$U['host'].'/'.$U['folder'].'/'.$U['tmpname']);
        // if($U['type']==2) unlink('.'.$U['url'].$U['folder'].'/'.$U['tmpname'].'.'.$U['ext']);
     }
 }

 echo 'ok';
exit;
?>
