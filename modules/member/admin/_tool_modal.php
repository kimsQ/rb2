<!-- 포인트 지급 모달 -->
<div class="modal fade" id="modal-give_point" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="point_type" class="label label-danger"></span> 지급/차감</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-3 control-label">지급/차감</label>
					<div class="col-sm-8">
						<label class="radio-inline">
							 <input type="radio" name="how" value="+" /> <span class="text-primary">지급</span>
						</label>
						<label class="radio-inline">
							 <input type="radio" name="how" value="-" /> <span class="text-danger">차감</span>
						</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">금액</label>
					<div class="col-sm-8">
						<input type="text" class="form-control numOnly" name="price" placeholder="금액을 입력해주세요" />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 control-label">사유</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="comment" placeholder="사유를 입력해주세요" />
					</div>
				</div>
		   </div> <!--.modal-body-->
		   <div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" onclick="modal_act(this);" id="give_point">확인</button>
			</div>
		</div>  <!--.modal-content-->
	</div> <!--.modal-dialog-->
</div> <!--.modal-->

<!-- 그룹변경 모달 -->
<div class="modal fade" id="modal-tool_mygroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="label label-danger">그룹</span> 변경</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="sr-only">그룹 선택</label>
					<select name="mygroup" class="form-control custom-select">
						<option value="">회원그룹</option>
						<option value="" disabled>--------</option>
						<?php $_GRPARR = array()?>
						<?php $GRP = getDbArray($table['s_mbrgroup'],'','*','uid','asc',0,1)?>
						<?php while($_G=db_fetch_array($GRP)):$_GRPARR[$_G['uid']] = $_G['name']?>
						<option value="<?php echo $_G['uid']?>">ㆍ<?php echo $_G['name']?> (<?php echo number_format($_G['num'])?>)</option>
						<?php endwhile?>
					</select>
				</div>
			</div>
		   <div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" onclick="modal_act(this);" id="tool_mygroup">확인</button>
			</div>
		</div>  <!--.modal-content-->
	</div> <!--.modal-dialog-->
</div> <!--.modal-->

<!-- 등급변경 모달 -->
<div class="modal fade" id="modal-tool_level" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="label label-danger">등급</span> 변경</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="sr-only">등급 선택</label>
					<select name="level" class="form-control">
						<option value="">회원등급</option>
						<option value="" disabled>--------</option>
						<?php $_LVLARR = array()?>
						<?php $levelnum = getDbData($table['s_mbrlevel'],'gid=1','*')?>
						<?php $LVL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',$levelnum['uid'],1)?>
						<?php while($_L=db_fetch_array($LVL)):$_LVLARR[$_L['uid']] = $_L['name']?>
						<option value="<?php echo $_L['uid']?>">ㆍ<?php echo $_L['name']?> (<?php echo number_format($_L['num'])?>)</option>
						<?php endwhile?>
					</select>
				</div>
			</div>
		   <div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" onclick="modal_act(this);" id="tool_level">확인</button>
			</div>
		</div>  <!--.modal-content-->
	</div> <!--.modal-dialog-->
</div> <!--.modal-->

<!-- 쪽지 전송 모달 -->
<div class="modal fade" id="modal-send_paper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="label label-danger">쪽지</span> 전송</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">

				<div class="form-group">
					<label class="sr-only">메세지 입력</label>
					<textarea  name="memo" class="form-control" placeholder="메시지를 입력해 주세요." rows="5"></textarea>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 control-label">전송 년도</label>
					<div class="col-sm-8">
				      <select name="year1" class="form-control">
					      <?php for($i=$date['year'];$i<$date['year']+2;$i++):?><option value="<?php echo $i?>"<?php if($xyear1==$i):?> selected="selected"<?php endif?>><?php echo $i?></option><?php endfor?>
				       </select>
		      	</div>
		      </div>
		      <div class="form-group row">
					<label class="col-sm-3 control-label">전송 월</label>
		      	<div class="col-sm-8">
		      		 <select name="month1" class="form-control">
						   <?php for($i=1;$i<13;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xmonth1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
						 </select>
               </div>
             </div>
             <div class="form-group row">
					<label class="col-sm-3 control-label">전송 일</label>
               <div class="col-sm-8">
						<select name="day1" class="form-control">
								<?php for($i=1;$i<32;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xday1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
						</select>
					</div>
             </div>
             <div class="form-group row">
					<label class="col-sm-3 control-label">전송 시간</label>
					<div class="col-sm-8">
						 <select name="hour1" class="form-control">
					 	      <?php for($i=0;$i<24;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xhour1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
						 </select>
					</div>
				 </div>
             <div class="form-group row">
					<label class="col-sm-3 control-label">전송 분</label>
				 	<div class="col-sm-8">
						 <select name="min1" class="form-control">
						      <?php for($i=0;$i<60;$i++):?><option value="<?php echo sprintf('%02d',$i)?>"<?php if($xmin1==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d',$i)?></option><?php endfor?>
						  </select>
					 </div>
				 </div>
			</div>
		   <div class="modal-footer justify-content-between justify-content-between">
				<button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" onclick="modal_act(this);" id="send_paper">확인</button>
			</div>
		</div>  <!--.modal-content-->
	</div> <!--.modal-dialog-->
</div> <!--.modal-->

<!-- 알림 전송 모달 -->
<div class="modal fade" id="modal-send_notice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="label label-danger">알림</span> 전송</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="sr-only">타이틀</label>
					<input type="url" class="form-control" name="notice_title" value="" placeholder="알림 제목을 입력해 주세요.">
				</div>
				<div class="form-group">
					<label class="sr-only">메세지 입력</label>
					<textarea name="notice" class="form-control" placeholder="알림내용을 입력해 주세요." rows="5"></textarea>
				</div>
				<div class="form-group">
					<label>연결링크</label>
					<input type="url" class="form-control f12" name="notice_referer" value="" placeholder="URL을 입력해 주세요.">
				</div>
				<div class="form-group">
					<label>연결링크 버튼명</label>
					<input type="text" class="form-control f12" name="notice_button" value="" placeholder="버튼명을 입력해 주세요.">
				</div>
			</div>
		   <div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" onclick="modal_act(this);" id="send_notice">전송</button>
			</div>
		</div>  <!--.modal-content-->
	</div> <!--.modal-dialog-->
</div> <!--.modal-->

<!-- 메일 전송 모달 -->
<div class="modal fade" id="modal-send_email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="label label-danger">메일</span> 전송</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">
				<div class="form-group dropdown">
					<label class="sr-only">메일 양식</label>
					<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-download"></i> 메일양식 불러오기 <span class="caret"></span>
					</button>
					<div class="dropdown-menu" role="menu" style="left:15px;padding-right:10px;">
						<?php $tdir = $g['path_module'].$module.'/doc/'?>
						<?php $dirs = opendir($tdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..')continue?>
						<?php $_type = str_replace('.txt','',$skin)?>
						<a href="#" class="dropdown-item doc-type">
							<?php echo getMDname($_type)?>
							<input type="hidden" name="doc_type" value="<?php echo htmlspecialchars(implode('',file($g['path_module'].$module.'/doc/'.$_type.'.txt')))?>" />
						</a>
						<?php endwhile?>
						<?php closedir($dirs)?>
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only">제목</label>
					<input type="text" class="form-control" name="subject" placeholder="제목을 입력해주세요" />
				</div>
				<div class="form-group">
					<label class="sr-only">메세지 입력</label>
					<textarea name="content" id="summernote" class="form-control" placeholder="메시지를 입력해 주세요." rows="8"></textarea>
				</div>

			</div>
		   <div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-light" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" onclick="modal_act(this);" id="send_email">전송</button>
			</div>
		</div>  <!--.modal-content-->
	</div> <!--.modal-dialog-->
</div> <!--.modal-->
<script>
$('.doc-type').on('click',function(e) {
	 e.preventDefault();
    var cnt=$(this).find('input[name="doc_type"]').val();
    alert(cnt);
    $('#summernote').code(cnt);
})
</script>
