<?php
// 위젯 설정값 세팅
$parent_module=$d['attach']['parent_module']; // 첨부파일 사용하는 모듈
$parent_data=$d['attach']['parent_data']; // 해당 포스트 데이타 (수정시 필요)
$attach_module_theme=$d['attach']['theme']; // 첨부파일 테마
$attach_mode=$d['attach']['mod']; // list, main...
$attach_handler_file=$d['attach']['handler_file']; //파일첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_photo=$d['attach']['handler_photo']; // 사진첨부 실행 엘리먼트 button or 기타 엘리먼트 data-role="" 형태로 하는 것을 권고
$attach_handler_getModalList=$d['attach']['handler_getModalList']; // 첨부파일 리스트 호출 handler
$attach_object_type=$d['attach']['object_type']; // 첨부 대상에 따른 분류 : photo, file, link, video....
$editor_type=$d['attach']['editor_type']; // 에디터 타입 : html,markdown

require_once $g['dir_attach_theme'].'/main.func.php'; // 함수 인클루드
require_once $g['dir_attach_theme'].'/_var.php'; // 테마변수 인클루드
?>

<script src="<?php echo $g['url_attach_theme']?>/js/fileuploader.js"></script>
<script src="<?php echo $g['url_attach_theme']?>/main.js"></script>

<?php getImport('jquery-ui','jquery-ui.min','1.12.1','js')?>

<style>

[data-plugin="ui-sortable"] {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 450px;
}
[data-plugin="ui-sortable"] .item {
  position: relative;
  margin: 3px 3px 3px 0;
  float: left;
  text-align: center;
  cursor: move;
  background-color: #eee;
  min-width: 120px;
  min-height: 120px;
  text-align: center;
}
[data-plugin="ui-sortable"] .item .item-label,
[data-plugin="ui-sortable"] .item .item-btn {
  position: absolute;
}
[data-plugin="ui-sortable"] .item .item-label {
  top: 10px;
  left : 10px;
  right:auto;
  bottom: auto
}
[data-plugin="ui-sortable"] .item .item-btn {
  top: 10px;
  right : 10px;
  left:auto;
  bottom: auto
}
[data-plugin="ui-sortable"] .item .btn {
  border-radius: 0
}

.item.upload {
  float: left;
  margin: 3px 3px 3px 0;
  border: 1px dashed #ddd;
  background-color: #f5f5f5;
  min-width: 120px;
  min-height: 120px;
  text-align: center;
  color: #ccc
}
.item.upload:hover {
  background-color: #eee;
}

</style>
