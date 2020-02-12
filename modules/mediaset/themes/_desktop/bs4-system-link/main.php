<?php
include $g['dir_attach_theme'].'/header.php';
?>

<div id="attach_link">
  <fieldset id="check_url" class="mb-3">
    <div class="input-group" style="border: 2px dashed #d1d1d1;">
      <textarea class="form-control bg-white border-0" rows="3" placeholder="URL을 입력해주세요."></textarea>
      <div class="input-group-append">
        <button class="btn btn-light border-right-0 border-top-0 border-bottom-0" type="button">
          가져오기
        </button>
      </div>
    </div>
    <small class="form-text text-muted"></small>

  </fieldset>


  <div class="rb-attach mb-3 dd" id="nestable-link">
    <ol class="list-group rb-attach-file bg-faded dd-list" data-role="attach-preview-link"> <!-- 일반파일 리스트  -->
      <?php if($parent_data['uid']):?>
        <?php echo getAttachPlatformList($parent_data,'upload',$wdgvar['wysiwyg'])?>
      <?php endif?>
    </ol>
  </div>

</div>



<?php
  include $g['dir_attach_theme'].'/footer.php';
?>
