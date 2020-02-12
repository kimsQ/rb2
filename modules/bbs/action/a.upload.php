<?php
$g=array();
$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
$g['path_root']='../../../';
$g['path_var']=$g['path_root'].'_var/';
$g['path_core']=$g['path_root'].'_core/';
$g['path_module']=$g['path_root'].'modules/';
require $g['path_var'].'db.info.php';
require $g['path_var'].'table.info.php';
require $g['path_core'].'function/db.mysql.func.php';
require $g['path_core'].'function/sys.func.php';
require $g['path_core'].'function/thumb.func.php';
include $g['path_module'].'mediaset/var/var.php'; // 미디어셋 설정내용
$DB_CONNECT = isConnectedToDB($DB);
$date['today']=date('Ymd');
$date['totime']=date('YmdHis');

if ($_FILES['file']['name']) {
   if (!$_FILES['file']['error']) {
       if (!$d['mediaset']['ext_cut'] && !strstr($d['mediaset']['ext_cut'],$fileExt)){
           $tmpcode = time();
           $s=$_POST['s'];
           $mbruid=$_POST['mbruid'];
           $fserver  = $d['meidaset']['use_fileserver'];
           $url    = $fserver ? $d['meidaset']['ftp_urlpath'] : $g['url_host'].'/modules/bbs/upload/';
           $name    = strtolower($_FILES['file']['name']);
           $size   = $_FILES['file']['size'];
           $width    = 0;
           $height   = 0;
           $caption  = trim($caption);
           $down   = 0;
           $d_regis  = $date['totime'];
           $d_update = '';
           $fileExt  = getExt($name);
           $fileExt  = $fileExt == 'jpeg' ? 'jpg' : $fileExt;
           $type   = getFileType($fileExt);
           $tmpname = md5($name).substr($date['totime'],8,14);
           $tmpname  = $type == 2 ? $tmpname.'.'.$fileExt : $tmpname;
           $hidden   = $type == 2 ? 1 : 0;
                
           $upfolder = substr($date['today'],0,8); // 년월일을 업로드 폴더 구분기준으로 설정 
           $saveDir	= '../upload/'; // bbs 게시판 안에 별도의 files 폴더를 둔다. 나중에 포럼모듈이 나오면 충돌을 피하기 위해 
           $savePath1	= $saveDir.substr($upfolder,0,4);// 년도 폴더 지정 (없으면 아래 for 문으로  만든다)
           $savePath2	= $savePath1.'/'.substr($upfolder,4,2); // 월 폴더 지정 (없으면  아래 for 문으로 만든다)  
           $savePath3	= $savePath2.'/'.substr($upfolder,6,2); // 일 폴더 지정(없으면 아래 for 문으로 만든다)
           $folder    = substr($date['today'],0,4).'/'.substr($date['today'],4,2).'/'.substr($date['today'],6,2);
    		
           // 위 폴더가 없으면 새로 만들기  
      	 for ($i = 1; $i < 4; $i++)
      	 {
      	    if (!is_dir(${'savePath'.$i}))
      	    {
      		  mkdir(${'savePath'.$i},0707);
      		  @chmod(${'savePath'.$i},0707);
      	     }
      	 } 
           $saveFile = $savePath3.'/'.$tmpname; // 생성된 폴더/파일 --> 파일의 실제 위치   
           
            if($Overwrite=='true' || !is_file($saveFile))
            {
               move_uploaded_file($_FILES["file"]["tmp_name"], $saveFile);
               if ($type == 2)
               {
                  $thumbname = md5($tmpname).'.'.$fileExt;
                  $thumbFile = $savePath3.'/'.$thumbname;
                  ResizeWidth($saveFile,$thumbFile,150);
                  @chmod($thumbFile,0707);
                  $IM = getimagesize($saveFile);
                  $width = $IM[0];
                  $height= $IM[1];
               }
               @chmod($saveFile,0707);
            } 
           
           $mingid = getDbCnt($table['bbsupload'],'min(gid)','');
           $gid = $mingid ? $mingid - 1 : 100000000;
      
           $QKEY = "gid,hidden,tmpcode,site,mbruid,type,ext,fserver,url,folder,name,tmpname,thumbname,size,width,height,caption,down,d_regis,d_update,cync";
           $QVAL = "'$gid','$hidden','$tmpcode','$s','$mbruid','$type','$fileExt','$fserver','$url','$folder','$name','$tmpname','$thumbname','$size','$width','$height','$caption','$down','$d_regis','$d_update','$cync'";
           getDbInsert($table['bbsupload'],$QKEY,$QVAL);
           getDbUpdate($table['s_numinfo'],'upload=upload+1',"date='".$date['today']."' and site=".$s);
           
           $lastuid= getDbCnt($table['bbsupload'],'max(uid)','');
           $sourcePath='./modules/bbs'.str_replace('..','',$savePath3); // 소스에 보여주는 패스트 -- 상대경로를  제거한다.  
           $code='100';
           $src=$sourcePath.'/'.$tmpname;
           $result=array($code,$src,$lastuid); // 이미지 path 및 이미지 uid 값 
            echo json_encode($result);// 최종적으로 에디터에 넘어가는 값 
      }else{
        $code='200';
        $msg = '업로드금지 확장자입니다.';
        $result=array($code,$msg);
        echo json_encode($result);// 최종적으로 에디터에 넘어가는 값
      }

    }else{
        $code='300';
        $msg = '파일 에러입니다.: '.$_FILES['file']['error'];
        $result=array($code,$msg);
        echo json_encode($result);// 최종적으로 에디터에 넘어가는 값
    }  

  }// 파일이 넘어왔는지 체크  
?>

                  