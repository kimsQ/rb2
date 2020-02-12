<!-- 첨부 사진 메타정보 수정 -->
<div class="modal rb-modal-attach-meta" id="modal-attach-photo-meta" tabindex="-1" role="dialog" aria-labelledby="">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">사진 정보수정</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body p-0">

        <div class="container-fluid pl-0">
          <div class="row">
            <div class="col-8">
              <img class="img-fluid" src="" alt="" data-role="img-preview" data-origin="">
            </div><!-- /.col -->
            <div class="col-4 pl-0 pt-3">

              <div class="form-group">
                <label for="file-caption" class="control-label">캡션:</label>
                <textarea class="form-control" data-role="filecaption" rows="2"></textarea>
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

              <button type="button" class="btn btn-outline-secondary btn-block" data-attach-act="save" data-target="#modal-attach-photo-meta" data-role="eventHandler" data-id="">저장하기</button>


            </div><!-- /.col -->
          </div>
        </div>
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

<!-- 첨부 사진 상품태그 -->
<div class="modal rb-modal-attach-meta" id="modal-attach-photo-tag" tabindex="-1" role="dialog" aria-labelledby="">
  <!-- <input type="hidden" name="uid"> -->
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">상품 태그</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body p-0">


        <div class="container-fluid pl-0">
          <div class="row">
            <div class="col-8 text-center">

              <div data-role="image-marker-area" class="d-inline-block">
                <img class="img-fluid" src="" alt="" data-role="img-preview" data-origin="">
              </div>

            </div><!-- /.col -->
            <div class="col-4 pl-0 pt-3">

              <div data-role="comment" class="mb-3">

                <div class="dropdown">
                  <button class="btn btn-white btn-sm btn-block p-2 d-flex justify-content-between align-items-center text-left" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-width: 8.3rem">
                    <div class="media d-none">
                      <img src="" class="mr-3" alt="">
                      <div class="media-body">
                        <h6 class="mt-1" data-role="name">[한만두] 달콤한 갈비만두</h6>
                        <span data-role="price"></span> 원
                      </div>
                    </div>
                    <div data-role="none">
                      연결할 상품을 선택하세요.
                    </div>
                    <i class="fa fa-caret-down mr-2" aria-hidden="true"></i>
                  </button>
                  <div class="dropdown-menu shadow py-0" data-role="attach-goods" style="min-width: 370px">

                  </div>
                </div>
                <input type="text"  class="form-control mt-2" name="goods" value="">
                <textarea class="form-control mt-3"></textarea>
                <div class="d-flex justify-content-between mt-2">
                  <div class="">
                    <button type="button" id="imagetag-cancel" class="btn btn-white">취소</button>
                    <button type="button" id="imagetag-delete" class="btn btn-white">삭제</button>
                  </div>
                  <div class="">
                    <button type="button" data-attach-act="saveTag" data-target="#modal-attach-photo-tag" data-role="eventHandler" data-id="" class="btn btn-primary">
                      저장
                    </button>
                  </div>
                </div>
              </div>

              <div data-role="test" class="f12"></div>

            </div><!-- /.col -->
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
