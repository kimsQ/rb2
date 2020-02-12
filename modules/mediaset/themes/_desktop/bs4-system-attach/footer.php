<?php include $g['dir_attach_theme'].'/modals.php'; // 모달 페이지 인클루드 ?>
<?php getImport('jquery-form','jquery.form.min','4.2.2','js'); ?>
<script>
var inputId='attach-file-input'; // 실제 작옹하는 input 엘리먼트 id 값을 옵션으로 지정을 해준다. (커스텀 버튼으로 click 이벤트 바인딩)
var attach_file_saveDir = '<?php echo $g['path_file'].$parent_module?>/';// 파일 업로드 폴더
var attach_module_theme = '<?php echo $attach_module_theme?>';// attach 모듈 테마
var uploadElement = $('#attach-files');
var wysiwyg = '<?php echo $wdgvar['wysiwyg'] ?>'

$(document).ready(function() {

 var uploadObj = uploadElement.RbUploadFile({
   <?php if ($d['theme']['allowedTypes']): ?>
   allowedTypes:"<?php echo $d['theme']['allowedTypes'] ?>",// 업로드 가능한 파일 확장자. 여기에 명시하지 않으면 파일 확장자 필터링하지 않음.
   <?php endif; ?>
    fileName: "files", // <input type="file" name=""> 의 name 값 --> php 에서 파일처리할 때 사용됨.
    multiple: <?php echo $d['theme']['multiple']?'true':'false' ?>, // 멀티업로드를 할 경우 true 로 해준다.
    dragDrop:true,
    uploadStr:"<i class='fa fa-folder-o fa-fw'></i> 파일찾기", // 파일첨부 버튼
    maxFileCount: <?php echo $d['mediaset']['maxnum_file'] ?>, // 1회 첨부파일 갯수
    maxFileSize: <?php echo $d['mediaset']['maxsize_file'] ?>, // 1회 첨부파일 용량
    inputId:inputId, // 실제 작옹하는 input 엘리먼트 id 값을 옵션으로 지정을 해준다. (커스텀 버튼으로 click 이벤트 바인딩)
    formData: {"saveDir":attach_file_saveDir,"theme":attach_module_theme,"wysiwyg":wysiwyg}, // 추가 데이타 세팅

    onSubmit:function(files){
      console.log('모든 파일이 업로드가 시작되었습니다.')
      uploadElement.isLoading({
        text: "<i class='fa fa-spinner fa-spin'></i> 업로드중...",
        position: 'overlay'
      });
    },
    onSuccess:function(files,data,xhr,pd){
      console.log('파일이 업로드 되었습니다.')
      uploadElement.isLoading("hide")
		}
 });

  // main.js 기본값 세팅
  var attach_settings={
    module : 'mediaset',
    theme : attach_module_theme,
    handler_photo : '<?php echo $attach_handler_photo?>',
    handler_file : '<?php echo $attach_handler_file?>',
    handler_getModalList : '<?php echo $attach_handler_getModalList?>',
    listModal : '#modal-attach'
  }
  uploadElement.RbAttachTheme(attach_settings);

});


/*
  클립보드 기능 초기화 : clipboard.js 플러그인 참조
   data-clipboard-text="" 값이 복사된다.  data-feedback-msg="" 값이 메세지로 출력
*/
var clipboard = new ClipboardJS('[data-attach-act="clipboard"]');

$('[data-attach-act="insert"]').tooltip({
  trigger: 'hover',
  title : '본문삽입'
});
$('[data-attach-act="clipboard"]').tooltip({
  trigger: 'hover',
  title : '클립보드 복사'
});

$('body').on('click','[data-attach-act="insert"]',function(){
   $(this).attr('data-original-title', '삽입완료')
   $(this).tooltip('show');
   $(this).attr('data-original-title', '본문삽입')
});


$('body').on('click','[data-attach-act="clipboard"]',function(){
   $(this).attr('data-original-title', '복사완료')
   $(this).tooltip('show');
   $(this).attr('data-original-title', '클립보드 복사')
});

// 모달 활성화시에 입력필드 포커스 처리
$('#modal-attach-photo-meta').on('shown.bs.modal', function (event) {
  var modal = $(this)
  modal.find('[data-role="filecaption"]').focus()
})
$('#modal-attach-file-meta').on('shown.bs.modal', function (event) {
  var modal = $(this)
  modal.find('[data-role="filename"]').focus()
})

</script>
