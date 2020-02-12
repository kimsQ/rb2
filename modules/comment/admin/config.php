
<form class="p-4" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="config" />
   <div class="form-group row">
	  <label class="col-md-2 col-form-label text-md-right">댓글 대표 테마</label>
     <div class="col-md-10 col-xl-9">
			 <select name="skin_main" class="form-control custom-select">
				 <option value="">&nbsp;+ 선택하세요</option>
				 <option value="" disabled>--------------------------------</option>

				 <optgroup label="데스크탑">
					 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['comment']['skin_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
				 <optgroup label="모바일">
					 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['comment']['skin_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
			 </select>
			 <small class="form-text text-muted">
				지정된 대표테마는 댓글목록 설정시 별도의 테마지정없이 자동으로 적용됩니다.
				가장 많이 사용하는 테마를 지정해 주세요.
			 </small>
		</div> <!-- .col-md-10 col-xl-9  -->
	</div> <!-- .form-group  -->
	<div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right"><span class="badge badge-dark">댓글 모바일 대표테마</span></label>
     <div class="col-md-10 col-xl-9">
			 <select name="skin_mobile" class="form-control custom-select">
				 <option value="">모바일 테마 사용안함</option>
				 <option value="" disabled>--------------------------------</option>

				 <optgroup label="모바일">
					 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['comment']['skin_mobile']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
					</optgroup>
					<optgroup label="데스크탑">
						<?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
						<?php $dirs = opendir($tdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
						<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['comment']['skin_mobile']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
						<?php endwhile?>
						<?php closedir($dirs)?>
					 </optgroup>
			 </select>
			 <small class="form-text text-muted">
				 선택하지 않으면 데스크탑 대표테마로 설정됩니다.
			 </small>
		</div> <!-- .col-md-10 col-xl-9  -->
	</div> <!-- .form-group  -->
   <div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">통합 댓글테마</label>
     <div class="col-md-10 col-xl-9">
			 <select name="skin_total" class="form-control custom-select">
				 <option value="">통합보드 사용안함</option>
				 <option value="" disabled>--------------------------------</option>

				 <optgroup label="데스크탑">
					 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['comment']['skin_total']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
					</optgroup>
					<optgroup label="모바일">
						<?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
						<?php $dirs = opendir($tdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
						<option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['comment']['skin_total']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
						<?php endwhile?>
						<?php closedir($dirs)?>
					 </optgroup>

			 </select>
			 <small class="form-text text-muted">
			  통합보드란 모든 댓글목록 전체 게시물을 하나의 댓글목록으로 출력해 주는 서비스입니다.<br>
 				사용하시려면 통합댓글목록용 테마를 지정해 주세요.
 				통합댓글목록의 호출은 <code><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" target="_blank"><?php echo $g['r']?>/?m=<?php echo $module?></a></code> 입니다.
			 </small>
		</div> <!-- .col-md-10 col-xl-9  -->
	 </div> <!-- .form-group  -->

	 <div class="form-group row">
			<label class="col-md-2 col-form-label text-md-right">게시물 출력</label>
			<div class="col-md-10 col-xl-9">
				<div class="input-group w-25">
					<input type="text" name="recnum" value="<?php echo $d['comment']['recnum']?$d['comment']['recnum']:20?>" class="form-control">
					<div class="input-group-append">
						<span class="input-group-text">개</span>
					</div>
				</div>
				<small class="form-text text-muted">한페이지에 출력할 게시물의 수</small>
			</div>
	 </div>
     <div class="form-group row">
		 <label class="col-md-2 col-form-label text-md-right">불량글 처리</label>
		  <div class="col-md-10 col-xl-9 form-inline">

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="report_del" name="report_del" value="1" <?php if($d['comment']['report_del']):?> checked<?php endif?> >
				  <label class="custom-control-label" for="report_del">신고건 수가</label>
				</div>

				<div class="input-group ml-4">
					<input type="text" name="report_del_num" value="<?php echo $d['comment']['report_del_num']?>" class="form-control">
					<div class="input-group-append">
						<span class="input-group-text">건 이상인 경우</span>
					</div>
				</div>

				<select name="report_del_act" class="form-control custom-select ml-4">
					<option value="1"<?php if($d['comment']['report_del_act']==1):?> selected="selected"<?php endif?>>자동삭제</option>
					<option value="2"<?php if($d['comment']['report_del_act']==2):?> selected="selected"<?php endif?>>비밀처리</option>
				</select>
		</div> <!-- .col-md-10 col-xl-9 -->
	</div> <!-- .form-group -->
   <div class="form-group row">
       <label class="col-md-2 col-form-label text-md-right">제한단어</label>
	     <div class="col-md-10 col-xl-9">
				 <textarea name="badword" rows="5" class="form-control"><?php echo $d['comment']['badword']?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">제한단어 처리</label>
	  	  <div class="col-md-10 col-xl-9">

					<div class="custom-control custom-radio">
					  <input type="radio" id="badword_action_0" class="custom-control-input" name="badword_action" value="0" <?php if($d['comment']['badword_action']==0):?> checked<?php endif?>>
					  <label class="custom-control-label" for="badword_action_0">제한단어 체크하지 않음</label>
					</div>
					<div class="custom-control custom-radio">
					  <input type="radio" id="badword_action_1" class="custom-control-input" name="badword_action" value="1"<?php if($d['comment']['badword_action']==1):?> checked<?php endif?>>
					  <label class="custom-control-label" for="badword_action_1">등록을 차단함</label>
					</div>
					<div class="custom-control custom-radio">
					  <input type="radio" id="badword_action_2" class="custom-control-input" name="badword_action" value="2"<?php if($d['comment']['badword_action']==2):?> checked<?php endif?>>
					  <label class="custom-control-label" for="badword_action_2">제한단어를 다음의 문자로 치환하여 등록함</label>
						<input class="form-control w-25" type="text" name="badword_escape" value="<?php echo $d['comment']['badword_escape']?>" maxlength="1">
					</div>

		   </div><!-- .col-md-10 col-xl-9 -->
		 </div>


		 <div class="form-group row">
				<label class="col-md-2 col-form-label text-md-right">삭제 제한</label>
				<div class="col-md-10 col-xl-9">
					<div class="custom-control custom-checkbox mt-1">
						<input type="checkbox" class="custom-control-input" id="commentdel" name="commentdel" value="1"  <?php if($d['comment']['commentdel']):?> checked<?php endif?>>
						<label class="custom-control-label" for="commentdel">한줄의견 있는 댓글의 삭제를 제한합니다.</label>
					</div>
				</div>
		 </div>

		 <div class="form-group row">
				<label class="col-md-2 col-form-label text-md-right">새글 유지시간</label>
				<div class="col-md-10">
					<div class="form-inline">
						<div class="input-group">
							<input type="text" name="newtime" value="<?php echo $d['comment']['newtime']?$d['comment']['newtime']:24?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">시간</span>
							</div>
						</div>
						<small class="text-muted ml-2">새글로 인식되는 시간</small>
					</div><!-- /.form-inline -->
				</div>
		 </div>


		 <div class="form-group row">
				<label class="col-md-2 col-form-label text-md-right">댓글 포인트</label>
				<div class="col-md-10">
					<div class="form-inline">
						<div class="input-group">
							<input type="text" name="give_point" value="<?php echo $d['comment']['give_point']?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">포인트 지급</span>
							</div>
						</div>
						<small class="text-muted ml-2">등록한 댓글을 삭제시 환원됩니다</small>
					</div><!-- /.form-inline -->
				</div>
		 </div>

		 <div class="form-group row">
				<label class="col-md-2 col-form-label text-md-right">한줄의견 포인트</label>
				<div class="col-md-10">
					<div class="form-inline">
						<div class="input-group">
							<input type="text" name="give_opoint" value="<?php echo $d['comment']['give_opoint']?>" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text">포인트 지급</span>
							</div>
						</div>
						<small class="text-muted ml-2">등록한 한줄의견을 삭제시 환원됩니다</small>
					</div><!-- /.form-inline -->
				</div>
		 </div>

		 <div class="row">
 			<div class="offset-md-2 col-md-10 col-xl-9">
 				<button type="submit" class="btn btn-outline-primary btn-block my-4">저장하기</button>
 			</div>
	 	</div>
</form>
<script type="text/javascript">
putCookieAlert('comment_config_result') // 실행결과 알림 메시지 출력

function saveCheck(f)
{
	if (f.skin_main.value == '')
	{
		alert('대표테마를 선택해 주세요.       ');
		f.skin_main.focus();
		return false;
	}
	// if (f.skin_mobile.value == '')
	// {
	// 	alert('모바일테마를 선택해 주세요.       ');
	// 	f.skin_mobile.focus();
	// 	return false;
	// }
	  if (confirm('정말로 실행하시겠습니까?         '))
		{
			getIframeForAction(f);
			f.submit();
		}
}
</script>
