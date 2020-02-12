<?php
include $g['dir_attach_theme'].'/header.php';
?>

<div id="attach-files" class="files position-relative"><!-- 파일폼 출력 -->
</div>

<div class="rb-attach mb-3 dd" id="nestable-photo">
  <ol class="list-group rb-attach-photo mb-2 bg-faded dd-list" data-role="attach-preview-photo"><!-- 포토/이미지  리스트  -->
    <?php if($parent_data['uid']):?>
    <?php echo getAttachFileList($parent_data,'upload','photo',$wdgvar['wysiwyg'])?>
    <?php endif?>
  </ol>
</div>

<div class="rb-attach mb-3 dd" id="nestable-file">
  <ol class="list-group rb-attach-file bg-faded dd-list" data-role="attach-preview-file"> <!-- 일반파일 리스트  -->
    <?php if($parent_data['uid']):?>
      <?php echo getAttachFileList($parent_data,'upload','file',$wdgvar['wysiwyg'])?>
      <?php echo getAttachFileList($parent_data,'upload','doc',$wdgvar['wysiwyg'])?>
      <?php echo getAttachFileList($parent_data,'upload','zip',$wdgvar['wysiwyg'])?>
    <?php endif?>
  </ol>
</div>

<div class="rb-attach mb-3 dd" id="nestable-video">
  <ol class="list-group rb-attach-file bg-faded dd-list" data-role="attach-preview-video"> <!-- 비디오 파일 리스트  -->
    <?php if($parent_data['uid']):?>
    <?php echo getAttachFileList($parent_data,'upload','video',$wdgvar['wysiwyg'])?>
    <?php endif?>
  </ol>
</div>

<div class="rb-attach mb-3 dd" id="nestable-audio">
  <ol class="list-group rb-attach-file bg-faded dd-list" data-role="attach-preview-audio"> <!-- 오디오 파일 리스트  -->
    <?php if($parent_data['uid']):?>
    <?php echo getAttachFileList($parent_data,'upload','audio',$wdgvar['wysiwyg'])?>
    <?php endif?>
  </ol>
</div>


<?php
  include $g['dir_attach_theme'].'/footer.php';
?>


<script>

  var link_settings={
    module : 'mediaset',
    theme : '<?php echo $g['dir_attach_theme']?>',
  };


  $('.rb-preview').on('click', function() {
    $(this).removeClass('btn-primary').addClass('btn-light')
  });

  $(document).ready(function(){

    // 첨부사진 순서변경
    $('#nestable-photo').nestable({
      group: 1,
      maxDepth: 1
    });

    // 첨부파일 순서변경
    $('#nestable-file').nestable({
      group: 2,
      maxDepth: 1
    });

    // 첨부 비디오 순서변경
    $('#nestable-video').nestable({
      group: 3,
      maxDepth: 1
    });

    // 첨부 오디오 순서변경
    $('#nestable-audio').nestable({
      group: 4,
      maxDepth: 1
    });

    // 첨부사진 순서변경
    $('#nestable-link').nestable({
      group: 5,
      maxDepth: 1
    });

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
