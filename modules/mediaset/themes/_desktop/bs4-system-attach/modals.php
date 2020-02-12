<!-- 첨부 사진 메타정보 수정 -->
<div class="modal rb-modal-attach-meta" id="modal-attach-photo-meta" tabindex="-1" role="dialog" aria-labelledby="">
  <div class="modal-dialog my-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id=""><i class="fa fa-camera-retro"></i> 사진 정보수정</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="height: 64.2vh;">
        <p><img class="img-fluid img-thumbnail" src="" alt="" data-role="img-preview" data-origin=""></p>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-block" data-attach-act="save" data-target="#modal-attach-photo-meta" data-role="eventHandler" data-id="">저장하기</button>
      </div>
    </div>
  </div>
</div>

<!-- 첨부 파일 메타정보 수정 -->
<div class="modal fade rb-modal-attach-meta" id="modal-attach-file-meta" tabindex="-1" role="dialog" aria-labelledby="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id=""><i class="fa fa-floppy-o"></i> 첨부파일 정보수정</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <h1 class="text-xs-center" data-role="img-preview">
            </h1>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="file-name" class="control-label">파일명:</label>
              <div class="input-group">
                <input type="text" class="form-control" name="filename" data-role="filename">
                <div class="input-group-append">
                  <span class="input-group-text" data-role="fileext">확장자</span>
                </div>

              </div>
            </div>
            <div class="form-group">
              <label for="file-caption" class="control-label">캡션:</label>
              <textarea class="form-control" data-role="filecaption" name="caption"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal" data-attach-act="cancel" data-target="#modal-attach-file-meta" data-role="eventHandler" data-id="">취소하기</button>
        <button type="button" class="btn btn-primary" data-attach-act="save" data-target="#modal-attach-file-meta" data-role="eventHandler" data-id="" data-type="">저장하기</button>
      </div>
    </div>
  </div>
</div>
