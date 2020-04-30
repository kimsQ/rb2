<!--
 // makebbs.php 의 추가설정 부분
-->

<div class="form-group row">
    <label class="col-lg-2 col-form-label text-lg-right">게시판 관리자</label>
    <div class="col-lg-10 col-xl-9">
      <div class="input-group">
        <input class="form-control" placeholder="" type="text" name="admin" value="<?php echo $d['bbs']['admin']?>">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#bbs_admin-guide" data-tooltip="tooltip" title="도움말">
            <i class="fa fa-question-circle fa-lg"></i>
          </button>
        </div>
      </div>
      <p class="help-block collapse" id="bbs_admin-guide">
        <small class="form-text text-muted">
         이 게시판에 대해서 관리자권한을 별도로 부여할 회원이 있을경우
          회원아이디를 콤마(,)로 구분해서 등록해 주세요.<br />
          관리자로 지정될 경우 열람/수정/삭제등의 모든권한을 얻게 됩니다.
         </small>
        </p>
    </div>
 </div>

   <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">최근글 제외</label>
			<div class="col-lg-10 col-xl-9">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="display" name="display" value="1" <?php if($d['bbs']['display']):?> checked<?php endif?>>
            <label class="custom-control-label" for="display">최근글 추출에서 제외합니다.</label>
          </div>
				   <div class="help-text">
				   	  <small class="text-muted">
			   	  	  <a data-toggle="collapse" href="#bbs_display-guide"><i class="fa fa-question-circle fa-fw"></i>도움말</a>
			   	  	 </small>
				    </div>
				   <p class="help-block collapse" id="bbs_display-guide">
					   <small class="form-text text-muted">
						  최근글 추출제외는 게시물등록시에 이 설정값을 따르므로 설정값을 중간에 변경하면 이전 게시물에 대해서는 적용되지 않습니다.
				      최근글 제외설정은 게시판 서비스전에 확정하여 주세요.<br />
				      최근글에서 제외하면 통합검색에서도 제외됩니다.
				     </small>
		      </p>
			</div>
	</div>
	<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">쿼리 생략</label>
			<div class="col-lg-10 col-xl-9">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="hidelist" name="hidelist" value="1" <?php if($d['bbs']['hidelist']):?> checked<?php endif?>>
            <label class="custom-control-label" for="hidelist">게시물가공 기본쿼리를 생략합니다.</label>
          </div>
				   <div class="help-text">
				   	  <small class="text-muted">
				   	  	  <a data-toggle="collapse" href="#bbs_hidelist-guide"><i class="fa fa-question-circle fa-fw"></i>도움말</a>
				   	  	 </small>
				    </div>
				   <p class="help-block collapse" id="bbs_hidelist-guide">
					   <small class="form-text text-muted">
						  종종 기본쿼리가 아닌 테마자체에서 데이터를 가공해야 하는 경우가 있습니다.<br />
							1:1상담게시판,일정관리 등 특수한 테마의 경우 쿼리생략이 요구되기도 합니다.<br />
							쿼리생략이 요구되는 테마를 사용할 경우 체크해 주세요.<br />
				     </small>
		      </p>
			</div>
	</div>
   <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">RSS 발행</label>
			<div class="col-lg-10 col-xl-9">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="rss" name="rss" value="1" <?php if($d['bbs']['rss']):?> checked<?php endif?>>
          <label class="custom-control-label" for="rss">RSS발행을 허용합니다. (개별게시판별 RSS발행은 개별게시판 설정을 따름)</label>
        </div>
			</div>
	 </div>
	 <div class="form-group row">
        <label class="col-lg-2 col-form-label text-lg-right">조회수 증가</label>
	  	  <div class="col-lg-10 col-xl-9">

          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="hitcount_1" name="hitcount" value="1" <?php if($d['bbs']['hitcount']):?> checked<?php endif?> class="custom-control-input">
            <label class="custom-control-label" for="hitcount_1">무조건 증가</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="hitcount_0" name="hitcount" value="0"<?php if(!$d['bbs']['hitcount']):?> checked<?php endif?> class="custom-control-input">
            <label class="custom-control-label" for="hitcount_0">1회만 증가</label>
          </div>

         </div><!-- .col-lg-10 col-xl-9 -->
	</div>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">게시물 출력</label>
			<div class="col-lg-10 col-xl-9">
				<div class="row">
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="recnum" value="<?php echo $d['bbs']['recnum']?$d['bbs']['recnum']:20?>" class="form-control">
              <div class="input-group-append">
                <span class="input-group-text">개</span>
              </div>
						</div>
					</div>
					<div class="col-sm-5 form-control-static text-muted">
				    <small>한페이지에 출력할 게시물의 수</small>
				    </div>
				</div>
			</div>
	 </div>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">제목 끊기</label>
			<div class="col-lg-10 col-xl-9">
				<div class="row">
					<div class="col-sm-4">
						<div class="input-group">
							<input type="text" name="sbjcut" value="<?php echo $d['bbs']['sbjcut']?$d['bbs']['sbjcut']:40?>" class="form-control">
              <div class="input-group-append">
                <span class="input-group-text">자</span>
              </div>
						</div>
					</div>
					<div class="col-sm-5 form-control-static text-muted">
				       <small>제목이 길 경우 보여줄 글자 수 </small>
				   </div>
				</div>
			</div>
	 </div>
    <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">새글 유지시간</label>
			<div class="col-lg-10 col-xl-9">
				<div class="row">
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" name="newtime" value="<?php echo $d['bbs']['newtime']?$d['bbs']['newtime']:24?>" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text">시간</span>
                </div>
							</div>
						</div>
						<div class="col-sm-5 text-muted form-control-static">
					     <small> 새글로 인식되는 시간 </small>
					   </div>
				</div>
			</div>
	 </div>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">등록 포인트</label>
			<div class="col-lg-10 col-xl-9">
				<div class="row">
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" name="point1" value="<?php echo $d['bbs']['point1']?$d['bbs']['point1']:0?>" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text">포인트 지급</span>
                </div>
							</div>
						</div>
						<div class="col-sm-5 text-muted form-control-static">
					     <small> 게시물 삭제시 환원됩니다. </small>
					   </div>
				</div>
			</div>
	 </div>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">열람 포인트</label>
			<div class="col-lg-10 col-xl-9">
				<div class="row">
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" name="point2" value="<?php echo $d['bbs']['point2']?$d['bbs']['point2']:0?>" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text">포인트 차감</span>
                </div>
							</div>
						</div>
						<div class="col-sm-5 text-muted form-control-static">
					     <small> </small>
					   </div>
				</div>
			</div>
	 </div>
	<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">다운 포인트</label>
			<div class="col-lg-10 col-xl-9">
				<div class="row">
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" name="point3" value="<?php echo $d['bbs']['point3']?$d['bbs']['point3']:0?>" class="form-control">
                <div class="input-group-append">
                  <span class="input-group-text">포인트 차감</span>
                </div>
							</div>
						</div>
						<div class="col-sm-5 text-muted form-control-static">
					     <small> </small>
					   </div>
				</div>
			</div>
	 </div>
		<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">부가필드</label>
			<div class="col-lg-10 col-xl-9">
				<textarea name="addinfo" class="form-control" rows="3"><?php echo htmlspecialchars($R['addinfo'])?></textarea>
				<small class="form-text text-muted">
					이 게시판에 대해서 추가적인 정보가 필요할 경우 사용합니다.<br />
					필드명은 <code>[addinfo]</code> 입니다.
				</small>
			</div>
		</div>
