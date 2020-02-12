<?php
if(!defined('__KIMS__')) exit;
include $g['path_core'].'function/thumb.func.php';

$result=array();
$result['error'] = false;

// 업로드 디렉토리 없는 경우 추가 
if(!is_dir($uploadDir)){
   mkdir($uploadDir,0707);
   @chmod($uploadDir,0707);
}
$tmpcode  = $sescode;
$mbruid   = $my['uid'];
$album      = $album?$album:1;     
$fserver  = $d[$m]['up_use_fileserver'];
$url    = $fserver ? $d[$m]['ftp_urlpath'] : $g['url_root'];
$hidden   = $type == 2 ? 1 : 0;
$savePath1  = $uploadDir.substr($date['today'],0,4);
$savePath2  = $savePath1.'/'.substr($date['today'],4,2);
$savePath3  = $savePath2.'/'.substr($date['today'],6,2);
$folder   = $savePath3;//saveDir.substr($date['today'],0,4).'/'.substr($date['today'],4,2).'/'.substr($date['today'],6,2);
$width    = 0;
$height   = 0;
$caption  = trim($caption);
$down   = 0;
$d_regis  = $date['totime'];

for ($i = 1; $i < 4; $i++)
{
  if (!is_dir(${'savePath'.$i}))
  {
    mkdir(${'savePath'.$i},0707);
    @chmod(${'savePath'.$i},0707);
  }
}


// response 세팅 
$response='';

foreach($_FILES as $file){

  $name = strtolower($file['name']);
  $fileExt  = getExt($name);
  $fileExt  = $fileExt == 'jpeg' ? 'jpg' : $fileExt;
  $type     = getFileType($fileExt);
  $tmpname  = md5($name).substr($date['totime'],8,14);
  $tmpname  = $type == 2 ? $tmpname.'.'.$fileExt : $tmpname;
  if($type==2) $saveFile   = $savePath3.'/'.$tmpname;
  else if($type==5) $saveFile   = $savePath3.'/'.$name;
  $size   = $file['size'];
  $ext = $fileExt;

  if (!is_file($saveFile))
  {
    move_uploaded_file($file['tmp_name'], $saveFile);
  
    if ($type == 2)
    {
      $thumbname = md5($tmpname).'.'.$fileExt;
      $thumbFile = $savePath3.'/'.$thumbname;
      ResizeWidth($saveFile,$thumbFile,200);
      @chmod($thumbFile,0707);
      $IM = getimagesize($saveFile);
      $width = $IM[0];
      $height= $IM[1];
    }
      
    @chmod($thumbFile,0707); // 썸네일 
    @chmod($saveFile,0707); // 원본 
  }

  $mingid = getDbCnt($table[$m.'upload'],'min(gid)','');
  $gid = $mingid ? $mingid - 1 : 100000000;
  $folder=str_replace('.','',$folder);
  
  $QKEY = "gid,hidden,tmpcode,site,mbruid,type,ext,fserver,url,folder,name,tmpname,thumbname,size,width,height,caption,down,d_regis,d_update,cync";
  $QVAL = "'$gid','$hidden','$tmpcode','$s','$mbruid','$type','$fileExt','$fserver','$url','$folder','$name','$tmpname','$thumbname','$size','$width','$height','$caption','$down','$d_regis','$d_update','$cync'";
  getDbInsert($table[$m.'upload'],$QKEY,$QVAL);

  $last_uid = getDbCnt($table[$m.'upload'],'max(uid)','');

  if ($gid == 100000000) db_query("OPTIMIZE TABLE ".$table[$m.'upload'],$DB_CONNECT); 
  $response .= $saveFile.'^^'.$last_uid.'^^'.$type.',';
} 

$result['fileList'] = trim($response,',');
echo json_encode($result,true);
exit;

?>
