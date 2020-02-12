<!-- 첨부 사진 메타정보 수정 -->
<div class="modal fade rb-modal-attach-meta" id="modal-attach-photo-meta" tabindex="-1" role="dialog" aria-labelledby="">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id=""><i class="fa fa-camera-retro"></i> 사진 정보수정</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- data-role="img-preview" src="_s 이미지" data-origin="원본 이미지" 넣는다. -->
          <div class="col-md-4">
            <p><img class="img-thumbnail" src="" alt="" data-role="img-preview" data-origin=""></p>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="file-caption" class="control-label">캡션:</label>
              <textarea class="form-control" data-role="filecaption" rows="5"></textarea>
            </div>

            <div class="form-group">
              <label for="file-name" class="control-label">파일명:</label>
              <div class="input-group">
                <input type="text" class="form-control" data-role="filename" name="filename">
                <div class="input-group-append">
                  <span class="input-group-text" data-role="fileext">확장자</span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal" data-attach-act="cancel" data-target="#modal-attach-photo-meta" data-role="eventHandler" data-id="">취소하기</button>
        <button type="button" class="btn btn-primary" data-attach-act="save" data-target="#modal-attach-photo-meta" data-role="eventHandler" data-id="">저장하기</button>
      </div>
    </div>
  </div>
</div>
