<style>
.rb-attach .table-view:empty {
  display: none !important
}
</style>

  <?php
  include $g['dir_attach_theme'].'/header.php';
  ?>

  <div class="rb-attach" data-role="list"><!-- 포토/이미지  리스트  -->

    <ul class="table-view table-view-full my-0 ml-4 mr-0 border-top-0" data-role="attach-preview-photo" data-sortable="mediaset"></ul>

    <!-- 일반파일 리스트  -->
    <ul class="table-view table-view-full my-0 ml-4 mr-0 border-top-0" data-role="attach-preview-file" data-sortable="mediaset">
    </ul>

    <!-- 오디오 리스트  -->
    <ul class="table-view table-view-full my-0 ml-4 mr-0 border-top-0" data-role="attach-preview-audio" data-sortable="mediaset">
    </ul>

    <!-- 비디오 리스트  -->
    <div class="table-view table-view-full my-0 ml-4 mr-0 border-top-0" data-role="attach-preview-video" data-sortable="mediaset">
    </div>

    <div class="content-padded">
      <div data-role="attach-files" class="files"><!-- 파일폼 출력 --></div>
    </div>

    <div class="px-2">
      <button class="btn btn-link btn-block py-3" data-role="attach-handler-photo" data-type="file" role="button">
        <span class="not-loading">
          추가
        </span>
        <span class="is-loading">
          <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">업로드중...</span>
          </div>
        </span>
      </button>
    </div>

  </div>

  <script src="<?php echo $g['url_attach_theme']?>/main.js"></script>

  <?php
    include $g['dir_attach_theme'].'/footer.php';
  ?>
