<?php
$getWidget=$_GET['getWidget']; // 위젯
$parent_module=$_GET['parent_module']; // 첨부파일 사용하는 모듈
$parent_data=$_GET['parent_data']; // 해당 포스트 데이타 (수정시 필요)
$attach_theme=$_GET['attach_theme']; // 첨부파일 테마
$attach_mod=$_GET['attach_mod']; // main, list...
$attach_handler_file=$_GET['attach_handler_file']; //파일첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_photo=$_GET['attach_handler_photo']; // 사진첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_getModalList=$_GET['attach_handler_getModalList']; // 첨부파일 리스트 호출 handler
$attach_object_type=$_GET['attach_object_type'];//첨부 대상에 따른 분류 : photo, file, link, video....


getWidget($getWidget,array('parent_module'=>$parent_module,'theme'=>$attach_theme,'attach_handler_file'=>$attach_handler_file,'attach_handler_photo'=>$attach_handler_photo,'attach_handler_getModalList'=>$attach_handler_getModalList,'parent_data'=>$R));
exit;
?>
