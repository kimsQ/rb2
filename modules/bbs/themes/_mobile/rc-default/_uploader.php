<?php
// 설정값 세팅
$attachSkin = $d['bbs']['a_mskin']?$d['bbs']['a_mskin']: ($d['theme']['upload_theme']?$d['theme']['upload_theme']:$d['bbs']['attach_main']);  // 업로드 테마
$parent_module=$m; // 첨부파일 사용하는 모듈
$parent_data=$R; // 해당 포스트 데이타 (수정시 필요)
$attach_module_theme=$attachSkin; // 첨부파일 테마
$attach_handler_file='[data-role="attach-handler-file"]'; //파일첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_photo='[data-role="attach-handler-photo"]'; // 사진첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_getModalList='.getModalList'; // 첨부파일 리스트 호출 handler
$attach_object_type= 'photo';//첨부 대상에 따른 분류 : photo, file, link, video....

// 함수 인클루드
include $g['path_module'].'mediaset/attach.php';
?>
