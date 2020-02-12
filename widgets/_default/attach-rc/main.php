<?php
// 위젯 설정값 세팅
$parent_module=$wdgvar['parent_module']; // 첨부파일 사용하는 모듈
$parent_data=$wdgvar['parent_data']; // 해당 포스트 데이타 (수정시 필요)
$attach_module_theme=$wdgvar['theme']; // 첨부파일 테마
$attach_mod=$wdgvar['attach_mod']; // main, list...
$attach_handler_file=$wdgvar['attach_handler_file']; //파일첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_photo=$wdgvar['attach_handler_photo']; // 사진첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_getModalList=$wdgvar['attach_handler_getModalList']; // 첨부파일 리스트 호출 handler
$attach_object_type=$wdgvar['attach_object_type'];//첨부 대상에 따른 분류 : photo, file, link, video....
$attach_tmpcode=$wdgvar['attach_tmpcode'];//첨부 대상에 따른 분류 : photo, file, link, video....
$attach_featuredImg_form_name=$wdgvar['featuredImg_form_name'];//첨부 대상에 따른 분류 : photo, file, link, video....

// 함수 인클루드
include $g['path_module'].'mediaset/attach.php';
?>
