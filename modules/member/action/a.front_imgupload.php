<?php
if(!defined('__KIMS__')) exit;

include_once $g['path_core'].'function/string.func.php';
include_once $g['dir_module'].'var/var.php'; // 관리자 설정 파일 인크루드

// 관리자 설정 값 
$perm_w=177; //미리보기 이미지 가로사이즈(등록폼 레이아웃 설정시 참고) 
$perm_h=140; //미리보기 이미지 세로사이즈(등록폼 레이아웃 설정시 참고)


//폼에서 넘겨받은 atrname 값 활용 서버에 저장되는 썸네일 파일명 얻기
$fname=$_POST['atrname']; // 히든값으로 name 속성벨류 얻어옴 
$fn_arr=explode('_',$fname); //_ 로 구분하고
$fn_ord=$fn_arr[1];// 이미지 순번 얻음. 아래 파일명 정할 때 함께 포장

// 폼에서 넘겨받은 이전 저장파일 - 이미지 수정시 기존 업로드 이미지 삭제하기 위함
$old_orifile=$_POST['orifile_'.$fn_ord]; // 기존 오리지널파일
//if($fn_ord==1) $limit_w=$d['shop']['simg_size'];// 이미지 순서를 대입하여 허용된 메인 이미지 가로사이즈 얻음. 
//else $limit_w=$d['shop']['simg_size'.($fn_ord-1)]; //이미지 순서를 대입하여 허용된 서브 이미지 가로사이즈 얻음.
$limit_w=177;

//업로드한 이미지 정보 값
$tmpname= $_FILES[$fname]['tmp_name']; // 임시파일 
$realname= $_FILES[$fname]['name']; // 실제 파일
$fileExt	= strtolower(getExt($realname)); // 확장자 얻기
$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt; // 확장자 중 jpeg 가 있으면...jpg 로 설정
$valid_formats = array("jpg", "jpg", "jpg");// 가능한 파일확장자 
if($_FILES[$fname]['tmp_name'])
{
	$tmp_info = getimagesize($tmpname); // 이미지 정보 얻기 
    $tmp_w = $tmp_info[0]; // 이미지 넓이
    $tmp_h= $tmp_info[1];// 이미지 높이
	$show_w=$perm_w;
	$show_h=$perm_h;

	if(($perm_w==$tmp_w)&&($perm_h==$tmp_h)) // 허용한 가로사이즈 혹은 세로 사이즈가 아닌경우
	{
		if(in_array($fileExt,$valid_formats))
		{
			if (is_uploaded_file($tmpname)) // 파일이 업로드되었다 가 참이면.... 
			{
				$saveDir = $g['path_root'].'_var/simbol'; // 파일구조상 이미 설정되어 있는 폴더 지정- 개별 이미지는 front 폴더에 별도 저장. 멀티업로드 파일과 구분
											
				$oriname ='mp_'.$fn_ord.'.'.$fileExt; // ori 로 오리지널 표시하고 $fn_ord 로 순서표시
				$oriFile =$saveDir.'/'.$oriname; // 오리지널 파일 DB 에 저장할 패스/파일명 지정
				
			    if(is_file($old_orifile)) unlink($old_orifile); // 기존 오리지널 이미지 삭제 - 이미지 바꾸고 저장안하면 기존 테이블의 이미지와 만지 않는 문제때문에 사용안함.
				move_uploaded_file($tmpname,$oriFile); // 업로드된 임시파일명(tmpname)을 DB 에 저장할 오리지널 파일(oriFile) 로 복사한다.
				@chmod($oriFile,0707); // 새로 들어왔으니 권한 신규 부여
				
				echo "<img src='".$oriFile."'  id='newimg_".$fn_ord."' name='".$oriFile."' width='".$perm_w."' height='".$perm_h."' class='preview'>";
				exit;
			
			} // 파일업로드 체크 
		 }else  
		 {
           	echo "<img src='".$old_orifile."'  id='newimg_".$fn_ord."' name='".$old_orifile."' width='".$perm_w."' height='".$perm_h."' class='preview'>"; 
		   echo "<div class='ajax_msg'>파일 확장자는 jpg 만 허용됩니다.</div> "; 
		   exit;
		 } 

	}else
	{
	  echo "<img src='".$old_orifile."'  id='newimg_".$fn_ord."' name='".$old_orifile."' width='".$perm_w."' height='".$perm_h."' class='preview'>"; 
	  echo "<div class='ajax_msg'>가로사이즈".$perm_w."px 혹은 세로 사이즈".$perm_h."px 가  아닙니다.</div>"; // 가로 사이즈 초과
	  exit;
	}
}else
{
  echo "<img src='".$old_orifile."'  id='newimg_".$fn_ord."' name='".$old_orifile."' width='".$perm_w."' height='".$perm_h."' class='preview'>";
  echo "<div class='ajax_msg'>업로드 파일이 없습니다. </div>";
  exit;
}
?>

                  