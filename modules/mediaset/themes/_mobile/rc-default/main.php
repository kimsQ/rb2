<style>
.rb-attach .table-view:empty {
  display: none !important
}
</style>

  <?php
  include $g['dir_attach_theme'].'/header.php';
  ?>

  <div id="attach-files" class="files"><!-- 파일폼 출력 --></div>

  <div class="rb-attach" data-role="list"><!-- 포토/이미지  리스트  -->

    <ul class="table-view bg-white" data-role="attach-preview-photo">
    </ul>

    <!-- 일반파일 리스트  -->
    <ul class="table-view bg-white" data-role="attach-preview-file">
    </ul>

    <!-- 오디오 리스트  -->
    <ul class="table-view bg-white" data-role="attach-preview-audio">
    </ul>

    <!-- 비디오 리스트  -->
    <div class="table-view bg-white" data-role="attach-preview-video">
    </div>

  </div>

  <div data-role="attach_guide">
    <div class="d-flex justify-content-center align-items-center text-muted" style="height:70vh">
      <div data-role="attach-handler-photo" data-type="file" title="파일첨부" role="button" class="text-xs-center">
        <div class="material-icons mb-2" style="font-size: 120px;color:#ccc">
          add_photo_alternate
        </div>
        <p><small>사진,비디오,오디오,문서,파일을<br>첨부할 수 있습니다.</small></p>
      </div>
    </div>
  </div>

  <script src="<?php echo $g['url_attach_theme']?>/main.js"></script>

  <?php
    include $g['dir_attach_theme'].'/footer.php';
  ?>
