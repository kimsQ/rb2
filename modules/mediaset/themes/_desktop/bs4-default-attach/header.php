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
require_once $g['path_module'].'mediaset/var/var.php'; //모듈 공통변수 인클루드
?>

<script src="<?php echo $g['url_attach_theme']?>/js/fileuploader.js"></script>
<script src="<?php echo $g['url_attach_theme']?>/main.js"></script>

<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js') ?>

<style media="screen">
.ajax-upload-dragdrop {
  margin-bottom: 20px;
  padding: 30px;
  border: 2px dashed #d1d1d1;
  color: #999;
  text-align: center;
  vertical-align: middle;
}
.ajax-upload-dragdrop.state-hover {
  box-shadow: 0 0 2px rgba(0,0,0,0.3), 0 0 4px rgba(26,170,85,0.4);
  border: 1px solid #007bff;
}
.ajax-upload-dragdrop.state-hover::before {
  display: inline-block;
  font: normal normal normal 20px/1 FontAwesome;
  font-size: inherit;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  content: '\f093';
  font-size: 2.5em;
  text-align: center;
}

.ajax-upload-dragdrop.state-hover .ajax-file-upload,
.ajax-upload-dragdrop.state-hover span {
  opacity: 0;
  display: none
}
::-webkit-file-upload-button { cursor:pointer; }

/**
* Nestable
*/
[data-role="attach"] .dd {  }
[data-role="attach"] .dd-list { display: block; position: relative; list-style: none; }
[data-role="attach"] .dd-list .dd-list {  }
[data-role="attach"] .dd-collapsed .dd-list { display: none; }
[data-role="attach"] .dd-item,
[data-role="attach"] .dd-empty,
[data-role="attach"] .dd-placeholder { }
[data-role="attach"] .dd-handle {
  position: absolute;
  margin: 0;
  left: 0;
  top: 0;
  bottom:0;
  cursor: pointer;
  width: 25px;
  text-indent: 100%;
  white-space: nowrap;
  overflow: hidden;
  background-color: #eff3f6;
  background-image: linear-gradient(-180deg, #fafbfc 0%, #eff3f6 90%);
  background-repeat: repeat-x;
  background-position: -1px -1px;
  background-size: 110% 110%;
  border-right: 1px solid rgba(27,31,35,0.1);
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}
[data-role="attach"] .dd-handle:hover {
  background-color: #e6ebf1;
  background-image: linear-gradient(-180deg, #f0f3f6 0%, #e6ebf1 90%);
  background-position: -.5em;
}
[data-role="attach"] .dd-handle:before {
  display: block;
  position: absolute;
  left: 0;
  top: 50%;
  margin-top: -7px;
  width: 100%;
  text-align: center;
  text-indent: 0;
  color: #494949;
  font-size: 14px;
  font-weight: normal;
}

[data-role="attach"] .dd-placeholder,
[data-role="attach"] .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
[data-role="attach"] .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
  background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                    -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                       -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-size: 60px 60px;
  background-position: 0 0, 30px 30px;
}
[data-role="attach"] .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
[data-role="attach"] .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
[data-role="attach"] .dd-dragel .dd-handle {
  -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
          box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

</style>
