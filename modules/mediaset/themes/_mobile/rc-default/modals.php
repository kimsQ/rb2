
<!-- 첨부 사진 메타정보 수정 -->
<div class="modal fade rb-modal-attach-meta" id="modal-attach-photo-meta" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id=""><i class="fa fa-camera-retro"></i> 사진 정보수정</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- data-role="img-preview" src="_s 이미지" data-origin="원본 이미지" 넣는다. -->
                    <div class="col-md-4"><p><img class="img-thumbnail" src="" alt="" data-role="img-preview" data-origin=""></p></div>
                    <div class="col-md-8">
                            <div class="form-group">
                                <label for="file-name" class="control-label">파일명:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" data-role="filename" name="filename">
                                    <span class="input-group-addon" data-role="fileext"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file-caption" class="control-label">캡션:</label>
                                <textarea class="form-control" data-role="filecaption"></textarea>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" data-attach-act="cancel" data-target="#modal-attach-photo-meta" data-role="eventHandler" data-id="">취소하기</button>
                <button type="button" class="btn btn-primary" data-attach-act="save" data-target="#modal-attach-photo-meta" data-role="eventHandler" data-id="">저장하기</button>
            </div>
        </div>
    </div>
</div>

<!-- 첨부 파일 메타정보 수정 -->
<div class="modal fade rb-modal-attach-meta" id="modal-attach-file-meta" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id=""><i class="fa fa-floppy-o"></i> 첨부파일 정보수정</h4>
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
                                    <span class="input-group-addon" data-role="fileext"></span>
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
                <button type="button" class="btn btn-default" data-dismiss="modal" data-attach-act="cancel" data-target="#modal-attach-file-meta" data-role="eventHandler" data-id="">취소하기</button>
                <button type="button" class="btn btn-primary" data-attach-act="save" data-target="#modal-attach-file-meta" data-role="eventHandler" data-id="" data-type="">저장하기</button>
            </div>
        </div>
    </div>
</div>


<!-- 링크 추가  -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-attach-link">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">링크 추가</h4>
            </div>
            <div class="modal-body">
                <p id="attach-link"><!--링크 입력 필드 동적 생성 --></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary" data-plugin="clipboard" data-clipboard-text="" data-role="btn-copy-linkContent">링크내용 복사하기</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 위치 추가  -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-attach-map">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">위치 추가</h4>
            </div>
            <div class="modal-body">
                <p>지도 검색 UI </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary">적용하기</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 비디오 추가  -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-attach-video">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">비디오 추가</h4>
            </div>
            <div class="modal-body">
                <p>유튜브와 비메오 비디오만 링크를 추가하는 형태</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                <button type="button" class="btn btn-primary">적용하기</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 업로드 리스트 -->
<div class="modal fade" id="modal-attach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-paperclip"></i> 첨부목록</h4>
            </div>
            <div class="modal-body">

                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#modal-attach-photo" arole="tab" data-toggle="tab">사진</a></li>
                    <li role="presentation"><a href="#modal-attach-file" role="tab" data-toggle="tab">파일</a></li>
                    <li role="presentation"><a href="#modal-attach-video" role="tab" data-toggle="tab">동영상</a></li>
                    <li role="presentation"><a href="#modal-attach-link" role="tab" data-toggle="tab">링크</a></li>
                    <li role="presentation"><a href="#modal-attach-map" role="tab" data-toggle="tab">위치</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content rb-attach">
                    <div role="tabpanel" class="tab-pane active" id="modal-attach-photo">
                        <ul class="list-group rb-attach-photo" data-role="modal-attach-preview-photo">
                            <?php echo getAttachFileList($parent_data,'modal','photo')?>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="modal-attach-file" >
                        <ul class="list-group rb-attach-file" data-role="modal-attach-preview-file">
                            <?php echo getAttachFileList($parent_data,'modal','file')?>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="modal-attach-video">
                        비디오 목록
                    </div>
                    <div role="tabpanel" class="tab-pane" id="modal-attach-link">
                        링크목록
                    </div>
                    <div role="tabpanel" class="tab-pane" id="modal-attach-map">
                        위치목록
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
