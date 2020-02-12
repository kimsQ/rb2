<?php
$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
$g['path_root']='../../../../';
$g['path_var']=$g['path_root'].'_var/';

$date['today']  = substr(date('YmdHisw'),0,8);

if ($_FILES['file']['name']) {
      if (!$_FILES['file']['error']) {
      $name = md5(rand(100, 200));
      $ext = explode('.', $_FILES['file']['name']);
      $filename = $name . '.' . $ext[1];
          
       $upfolder = substr($date['today'],0,8); // 년월일을 업로드 폴더 구분기준으로 설정 
	 $saveDir	= '../upload/'; // bbs 게시판 안에 별도의 files 폴더를 둔다. 나중에 포럼모듈이 나오면 충돌을 피하기 위해 
	 $savePath1	= $saveDir.substr($upfolder,0,4);// 년도 폴더 지정 (없으면 아래 for 문으로  만든다)
	 $savePath2	= $savePath1.'/'.substr($upfolder,4,2); // 월 폴더 지정 (없으면  아래 for 문으로 만든다)  
	 $savePath3	= $savePath2.'/'.substr($upfolder,6,2); // 일 폴더 지정(없으면 아래 for 문으로 만든다)
		
       // 위 폴더가 없으면 새로 만들기  
	 for ($i = 1; $i < 4; $i++)
	 {
	    if (!is_dir(${'savePath'.$i}))
	    {
		  mkdir(${'savePath'.$i},0707);
		  @chmod(${'savePath'.$i},0707);
	     }
	 } 
       $sourcePath='./modules/bbs'.str_replace('..','',$savePath3); // 소스에 보여주는 패스트 -- 상대경로를  제거한다. 
       $destination = $savePath3.'/'.$filename; // 생성된 폴더/파일 --> 파일의 실제 위치   
       $location = $_FILES["file"]["tmp_name"]; // 서버에 올려진 임시파일 
       move_uploaded_file($location, $destination);
       @chmod($destination,0707); // 권한 신규 부여
         echo $sourcePath.'/'.$filename;// 최종적으로 에디터에 넘어가는 값 
      }
      else
      {
        echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
      }
  }// 파일이 넘어왔는지 체크  


?>

                  