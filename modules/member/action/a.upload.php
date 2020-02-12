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
           $name    = strtolower($_FILES['file']['name']);
           $fileExt  = getExt($name);
           $fileExt  = $fileExt == 'jpeg' ? 'jpg' : $fileExt;
           $type   = getFileType($fileExt);
           $tmpname = md5($name).substr($date['totime'],8,14);
           $tmpname  = $type == 2 ? $tmpname.'.'.$fileExt : $tmpname;
                        
           $savePath	= '../upload'; // member 게시판 안에 별도의 files 폴더를 둔다. 나중에 포럼모듈이 나오면 충돌을 피하기 위해 

           $saveFile = $savePath.'/'.$tmpname; // 생성된 폴더/파일 --> 파일의 실제 위치   
           
            if($Overwrite=='true' || !is_file($saveFile))
            {
               move_uploaded_file($_FILES["file"]["tmp_name"], $saveFile);
               @chmod($saveFile,0707);
            } 
           $sourcePath=$g['url_host'].'/modules/member'.str_replace('..','',$savePath); // 소스에 보여주는 패스트 -- 상대경로를  제거한다.  
           $code='100';
           $src=$sourcePath.'/'.$tmpname;
           $result=array($code,$src); // 이미지 path 및 이미지 uid 값 
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

                  