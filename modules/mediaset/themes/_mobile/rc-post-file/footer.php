<?php getImport('jquery-form','jquery.form.min','4.2.2','js'); ?>
<script>

var inputId='attach-file-input'; // 실제 작옹하는 input 엘리먼트 id 값을 옵션으로 지정을 해준다. (커스텀 버튼으로 click 이벤트 바인딩)
var sheet_post_photoadd = $('#sheet-post-photoadd');

// 파일업로드 옵션값 세팅
var <?php echo $d['attach']['parent_module'] ?>_upload_settings = {
  allowedTypes:"<?php echo $d['theme']['allowedTypes'] ?>",// 업로드 가능한 파일 확장자. 여기에 명시하지 않으면 파일 확장자 필터링하지 않음.
  fileName: "files", // <input type="file" name=""> 의 name 값 --> php 에서 파일처리할 때 사용됨.
  multiple: <?php echo $d['theme']['multiple']?'true':'false' ?>, // 멀티업로드를 할 경우 true 로 해준다.
  inputId:inputId, // 실제 작옹하는 input 엘리먼트 id 값을 옵션으로 지정을 해준다. (커스텀 버튼으로 click 이벤트 바인딩)
  formData: {"saveDir":'<?php echo $g['path_file'].$parent_module?>/',"theme":'<?php echo $attach_module_theme?>'}, // 추가 데이타 세팅
  onSubmit:function(files){
    sheet_post_photoadd.find('[data-act="attach"]').attr('disabled',true);
    $('[data-role="write"]').find('[data-role="attach-handler-photo"]').attr('disabled',true);
    $('[data-role="attach-handler-photo"]').addClass('d-none');
  },
  onSuccess:function(files,data,xhr,pd){
    sheet_post_photoadd.find('[data-role="none"]').addClass('d-none');
  },
  afterUploadAll:function(obj) {
    var attach_item_num = $('[data-role="write"].active').find('[data-role="list"] [data-role="attach-item"]').length;
    $('[data-act="attach"]').attr('disabled',false);
    $('[data-role="write"]').find('[data-role="attach-handler-photo"]').attr('disabled',false);
    $('[data-role="write"]').find('[data-role="attachNum"]').text(attach_item_num);
    $('[data-role="attach-handler-photo"]').removeClass('d-none');
    sheet_post_photoadd.find('[data-act="submit"]').addClass('active').removeClass('text-muted').attr('disabled',false);
    sheet_post_photoadd.find('[data-plugin="sortable"]').sortable({
      axis: 'y',
      cancel: 'button',
      delay: 250,
    });
  }
}

// main.js 기본값 세팅
var <?php echo $d['attach']['parent_module'] ?>_attach_settings={
  module : 'mediaset',
  theme : '<?php echo $attach_module_theme?>',
  handler_photo : '<?php echo $attach_handler_photo?>',
  handler_file : '<?php echo $attach_handler_file?>',
  handler_getModalList : '<?php echo $attach_handler_getModalList?>',
  listModal : '#modal-attach'
}

$(document).ready(function() {

  $('body').on('tap','[data-act="sheet"][data-target="#sheet-attach-moreAct"][data-mod="file"]',function(){
    var button = $(this);
    var target = button.attr('data-target');
    var type = button.attr('data-type');
    var title = button.attr('data-title');

    var uid = button.attr('data-id');
    var type = button.attr('data-type');
    var showhide = button.attr('data-showhide');
    var name = button.attr('data-name');
    var insert_text = button.attr('data-insert');
    var sheet = $('#sheet-attach-moreAct');
    $('#attach-files-backdrop').removeClass('hidden');
    sheet.find('[data-role="insert_text"]').val(insert_text);
    sheet.find('[data-attach-act="featured-img"]').attr('data-id',uid).attr('data-type',type).attr('data-mod','file');
    sheet.find('[data-attach-act="edit"]').attr('data-id',uid).attr('data-type',type).attr('data-mod','file');
    sheet.find('[data-attach-act="showhide"]').attr('data-id',uid).attr('data-content',showhide).attr('data-mod','file');
    sheet.find('[data-attach-act="delete"]').attr('data-id',uid).attr('data-type',type).attr('data-mod','file');

    if (showhide=='show') sheet.find('[data-attach-act="showhide"]').text('보이기');
    else sheet.find('[data-attach-act="showhide"]').text('숨기기');

    if (type!='photo') { // 이미지가 아닐 경우
      sheet.find('[data-attach-act="featured-img"]').closest('.table-view-cell').addClass('hidden');  // 대표이미지 항목 숨김처리함
      sheet.find('[data-attach-act="imageGoodsTag"]').closest('.table-view-cell').addClass('hidden');  // 상품태그 항목 숨김처리함
    } else {
      sheet.find('[data-attach-act="featured-img"]').closest('.table-view-cell').removeClass('hidden');  // 대표이미지 항목 노출
      sheet.find('[data-attach-act="imageGoodsTag"]').closest('.table-view-cell').removeClass('hidden');  // 상품태그 항목 노출
    }

    $(target).sheet({
      title : title
    });
  });

  $('.rb-preview').on('click', function() {
    $(this).removeClass('btn-primary').addClass('btn-default')
  });

});
</script>
