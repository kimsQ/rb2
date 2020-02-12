<?php
include $g['dir_attach_theme'].'/header.php';
?>
<div id="attach-files" class="files"><!-- 파일폼 출력 --></div>
<div class="rb-attach">
     <?php if($attach_object_type=='photo'):?>
      <ul class="list-group rb-attach-photo" data-role="attach-preview-photo"><!-- 포토/이미지  리스트  -->
         <?php if($parent_data['uid']):?>
             <?php echo getAttachFileList($parent_data,'upload','photo')?>
          <?php endif?>
      </ul>
      <?php elseif($attach_object_type=='file'):?>
      <ul class="list-group rb-attach-file" data-role="attach-preview-file"> <!-- 일반파일 리스트  -->
          <?php if($parent_data['uid']):?>
             <?php echo getAttachFileList($parent_data,'upload','file')?>
           <?php endif?>
      </ul>
      <?php elseif($attach_object_type=='video'):?>
        <ul class="list-group rb-attach-video" data-role="attach-preview-video"> <!-- 비디오 리스트  -->
            <?php if($parent_data['uid']):?>
               <?php echo getAttachFileList($parent_data,'upload','video')?>
             <?php endif?>
        </ul>
        <?php endif?>
</div>

<?php
  include $g['dir_attach_theme'].'/footer.php';
?>
