<div data-role="attach">

  <!--
  module : 첨부파일 사용 모듈 ,
  theme : 첨부파일 테마 ,
  attach_handler_file : 파일첨부 실행 엘리먼트 ,
  attach_handler_photo : 사진첨부 실행 엘리먼트 ,
  parent_data : 수정시 필요한 해당 포스트 데이타 배열 변수,
  attach_handler_getModalList : 업로드 리스트 모달로 호출용 엘리먼트 (class 인 경우 . 까지 넘긴다.)  -->

  <?php
  // 설정값 세팅
  // $parent_table=$wdgvar['parent_table'];
  // $parent_uid=$wdgvar['parent_uid'];
  // $parent_field=$wdgvar['parent_field'];
  // $attach_mod=$wdgvar['attach_mod']; // main, list...
  // $attach_object_type=$wdgvar['attach_object_type'];//첨부 대상에 따른 분류 : photo, file, link, video....
  // $attach_tmpcode=$wdgvar['attach_tmpcode'];//첨부 대상에 따른 분류 : photo, file, link, video....
  // $attach_featuredImg_form_name=$wdgvar['featuredImg_form_name'];//첨부 대상에 따른 분류 : photo, file, link, video....
  // $attach_wdgvar_id=$wdgvar['widget_uid'];

  $attachSkin = '_desktop/bs4-simple';  // 업로드 테마
  $parent_module=$module; // 첨부파일 사용하는 모듈
  $parent_data=$R; // 해당 포스트 데이타 (수정시 필요)
  $attach_module_theme=$attachSkin; // 첨부파일 테마
  $attach_handler_file='[data-role="attach-handler-file"]'; //파일첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
  $attach_handler_photo='[data-role="attach-handler-photo"]'; // 사진첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
  $attach_handler_getModalList='.getModalList'; // 첨부파일 리스트 호출 handler
  $editor_type=$editor_type; // 에디터 타입 : html,markdown
  $attach_object_type= 'photo';//첨부 대상에 따른 분류 : photo, file, link, video....

  include $g['path_module'].'mediaset/attach.php'; // 함수 인클루드
  ?>

</div>
