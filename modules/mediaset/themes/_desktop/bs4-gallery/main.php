<?php
include $g['dir_attach_theme'].'/header.php';
?>

<p class="text-muted">
  사진 또는 이미지만 업로드 가능합니다.
</p>

<div class="rb-attach mb-3 clearfix">
  <ul class="rb-attach-photo sortable  mb-2 bg-faded" data-role="attach-preview-photo" data-plugin="ui-sortable"><!-- 포토/이미지  리스트  -->
    <?php if($parent_data['uid']):?>
    <?php echo getAttachFileList($parent_data,'upload','photo',$editor_type)?>
    <?php endif?>
  </ul>
  <button type="button" class="item upload h1" role="button"
    data-role="attach-handler-file"
    data-type="file"
    title="사진첨부"
    data-loading-text="업로드 중...">
    <i class="fa fa-plus fa-lg"></i>
  </button>
</div>

<div id="attach-files" class="files"><!-- 파일폼 출력 --></div>

<?php include $g['dir_attach_theme'].'/footer.php';?>

<script>

  var link_settings={
    module : 'mediaset',
    theme : '<?php echo $g['dir_attach_theme']?>',
  };

  $('.rb-preview').on('click', function() {
    $(this).removeClass('btn-primary').addClass('btn-light')
  });

  $(document).ready(function(){

    // 사진 첨부사진 순서변경
    $('[data-plugin="ui-sortable"]').sortable({
      update: function(event, ui) {
        var attachfiles=$('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
        var new_upfiles='';
        if(attachfiles){
          for(var i=0;i<attachfiles.length;i++) {
            new_upfiles+=attachfiles[i];
          }
        }
        $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=modifygid',{
           attachfiles : new_upfiles
         });

      }
    });
    $('[data-plugin="ui-sortable"]').disableSelection();

    // 순서변경 내역 저장
    $('.dd').on('change', function() {
      var attachfiles=$('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
      var new_upfiles='';
      if(attachfiles){
        for(var i=0;i<attachfiles.length;i++) {
          new_upfiles+=attachfiles[i];
        }
      }
      $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=modifygid',{
         attachfiles : new_upfiles
       });
    });
});
</script>
