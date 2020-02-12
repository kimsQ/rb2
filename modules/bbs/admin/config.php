<form class="p-4" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="config">

   <div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				<i class="fa fa-columns fa-fw" aria-hidden="true"></i> 게시판 대표 테마
			</label>
     <div class="col-md-10 col-xl-9">
			 <select name="skin_main" class="form-control custom-select">
				 <option value="">선택하세요</option>
				 <option value="" disabled>--------------------------------</option>

				 <optgroup label="데스크탑">
					 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['skin_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
				 <optgroup label="모바일">
					 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['skin_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>

			 </select>
			 <small class="form-text text-muted">
				 지정된 대표테마는 게시판설정시 별도의 테마지정없이 자동으로 적용됩니다.
				 가장 많이 사용하는 테마를 지정해 주세요.
			 </small>
		</div> <!-- .col-sm-10  -->
	</div> <!-- .form-group  -->
	<div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				<span class="badge badge-dark">게시판 모바일 대표테마</span>
			</label>
     <div class="col-md-10 col-xl-9">
			 <select name="skin_mobile" class="form-control custom-select">
				 <option value="">모바일 테마 사용안함</option>
				 <option value="" disabled>--------------------------------</option>
				 <optgroup label="모바일">
					 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['skin_mobile']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
				 <optgroup label="데스크탑">
					 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['skin_mobile']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
			 </select>
			 <small class="form-text text-muted">
				 선택하지 않으면 데스크탑 대표테마로 설정됩니다.
			 </small>
		</div> <!-- .col-sm-10  -->
	</div> <!-- .form-group  -->
   <div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				통합보드테마
			</label>
     <div class="col-md-10 col-xl-9">
			 <select name="skin_total" class="form-control custom-select">
				 <option value="">통합보드 사용안함</option>
				 <option value="" disabled>--------------------------------</option>
				 <optgroup label="데스크탑">
					 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['skin_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
				 <optgroup label="모바일">
					 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
					 <?php $dirs = opendir($tdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['skin_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
				 </optgroup>
			 </select>
			 <small class="form-text text-muted">
				 통합보드란 모든 게시판의 전체 게시물을 하나의 게시판으로 출력해 주는 서비스입니다.<br>
				 사용하시려면 통합보드용 테마를 지정해 주세요.<br>
				 통합보드의 호출은 <code><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" target="_blank"><?php echo $g['r']?>/?m=<?php echo $module?></a></code> 입니다.
			 </small>

		</div> <!-- .col-sm-10  -->
	 </div> <!-- .form-group  -->

	 <hr>
	 <div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				<i class="fa fa-pencil-square-o  fa-fw" aria-hidden="true"></i> 대표 에디터
			</label>
     <div class="col-md-10 col-xl-9">
			 <select name="editor_main" class="form-control custom-select">
				 <?php $dirs = opendir($g['path_plugin'])?>
				 <?php while(false !== ($tpl = readdir($dirs))):?>
				 <?php if(!is_file($g['path_plugin'].$tpl.'/import.desktop.php'))continue?>
				 <option value="<?php echo $tpl?>"<?php if($d['bbs']['editor_main']==$tpl):?> selected<?php endif?>>
					 ㆍ<?php echo getFolderName($g['path_plugin'].$tpl)?> (<?php echo $tpl?>)
				 </option>
				 <?php endwhile?>
				 <?php closedir($dirs)?>
			 </select>
		</div> <!-- .col-sm-10  -->
	</div> <!-- .form-group  -->
	<div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				<span class="badge badge-dark">모바일 대표테마</span>
			</label>
     <div class="col-md-10 col-xl-9">
			 <input type="hidden" name="editor_mobile" value="">
			 <input type="text" readonly class="form-control-plaintext" value="모바일 기본형">
		</div> <!-- .col-sm-10  -->
	</div> <!-- .form-group  -->

	 <hr>
	 <div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				<i class="fa fa-paperclip fa-fw" aria-hidden="true"></i> 파일첨부 대표 테마
			</label>
     <div class="col-md-10 col-xl-9">
			 <select name="attach_main" class="form-control custom-select">
				 <option value="">사용안함</option>
				 <option value="" disabled>--------------------------------</option>
				 <optgroup label="데스크탑">
					 <?php $mdir = $g['path_module'].'mediaset/themes/_desktop/'?>
					 <?php $dirs = opendir($mdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($mdir.$skin))continue?>
					 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['attach_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($mdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
					</optgroup>
					<optgroup label="모바일">
						<?php $mdir = $g['path_module'].'mediaset/themes/_mobile/'?>
						<?php $dirs = opendir($mdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..' || is_file($mdir.$skin))continue?>
						<option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['attach_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($mdir.$skin)?>(<?php echo $skin?>)</option>
						<?php endwhile?>
						<?php closedir($dirs)?>
					 </optgroup>
			 </select>
			 <small class="form-text text-muted">
				 지정된 대표테마는 게시판설정시 별도의 테마지정없이 자동으로 적용됩니다.
				 가장 많이 사용하는 테마를 지정해 주세요.
			 </small>
		</div> <!-- .col-sm-10  -->
	</div> <!-- .form-group  -->
	<div class="form-group row">
  	  <label class="col-md-2 col-form-label text-md-right">
				<span class="badge badge-dark">모바일 대표테마</span>
			</label>
     <div class="col-md-10 col-xl-9">
			 <select name="attach_mobile" class="form-control custom-select">
				 <option value="">사용안함</option>
				 <option value="" disabled>--------------------------------</option>
				 <optgroup label="모바일">
					 <?php $mmdir = $g['path_module'].'mediaset/themes/_mobile/'?>
					 <?php $dirs = opendir($mmdir)?>
					 <?php while(false !== ($skin = readdir($dirs))):?>
					 <?php if($skin=='.' || $skin == '..' || is_file($mmdir.$skin))continue?>
					 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['attach_mobile']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($mmdir.$skin)?>(<?php echo $skin?>)</option>
					 <?php endwhile?>
					 <?php closedir($dirs)?>
					</optgroup>
					<optgroup label="데스크탑">
						<?php $mmdir = $g['path_module'].'mediaset/themes/_desktop/'?>
						<?php $dirs = opendir($mmdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..' || is_file($mmdir.$skin))continue?>
						<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['attach_mobile']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($mmdir.$skin)?>(<?php echo $skin?>)</option>
						<?php endwhile?>
						<?php closedir($dirs)?>
					 </optgroup>
			 </select>
			 <small class="form-text text-muted">
				 선택하지 않으면 데스크탑 대표테마로 설정됩니다.
			 </small>
		</div> <!-- .col-sm-10  -->
	</div> <!-- .form-group  -->
	<hr>

	<div class="form-group row">
		 <label class="col-md-2 col-form-label text-md-right">
			 <i class="fa fa-comments-o fa-fw" aria-hidden="true"></i> 댓글 대표 테마
		 </label>
		<div class="col-md-10 col-xl-9">
			<select name="comment_main" class="form-control custom-select">
				<option value="">사용안함</option>
				<option value="" disabled>--------------------------------</option>
				<optgroup label="데스크탑">
					<?php $cdir = $g['path_module'].'comment/themes/_desktop/'?>
					<?php $dirs = opendir($cdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..' || is_file($cdir.$skin))continue?>
					<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['comment_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($cdir.$skin)?>(<?php echo $skin?>)</option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</optgroup>
				<optgroup label="모바일">
					<?php $cdir = $g['path_module'].'comment/themes/_mobile/'?>
					<?php $dirs = opendir($cdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..' || is_file($cdir.$skin))continue?>
					<option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['comment_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($cdir.$skin)?>(<?php echo $skin?>)</option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</optgroup>
			</select>
			<small class="form-text text-muted">
				지정된 대표테마는 게시판설정시 별도의 테마지정없이 자동으로 적용됩니다.
				가장 많이 사용하는 테마를 지정해 주세요.
			</small>
	 </div> <!-- .col-sm-10  -->
 </div> <!-- .form-group  -->
 <div class="form-group row">
		 <label class="col-md-2 col-form-label text-md-right">
			 <span class="badge badge-dark">모바일 대표테마</span>
		 </label>
		<div class="col-md-10 col-xl-9">
			<select name="comment_mobile" class="form-control custom-select">
				<option value="">사용안함</option>
				<option value="" disabled>--------------------------------</option>
				<optgroup label="모바일">
					<?php $cmdir = $g['path_module'].'comment/themes/_mobile/'?>
					<?php $dirs = opendir($cmdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..' || is_file($cmdir.$skin))continue?>
					<option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['comment_mobile']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($cmdir.$skin)?>(<?php echo $skin?>)</option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</optgroup>
				<optgroup label="데스크탑">
					<?php $cmdir = $g['path_module'].'comment/themes/_desktop/'?>
					<?php $dirs = opendir($cmdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..' || is_file($cmdir.$skin))continue?>
					<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['bbs']['comment_mobile']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($cmdir.$skin)?>(<?php echo $skin?>)</option>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</optgroup>
			</select>
			<small class="form-text text-muted">
				선택하지 않으면 데스크탑 대표테마로 설정됩니다.
			</small>
	 </div> <!-- .col-sm-10  -->
 </div> <!-- .form-group  -->
 <hr>

	 <div class="form-group row">
			<label class="col-md-2 col-form-label text-md-right">RSS 발행</label>
			<div class="col-md-10 col-xl-9">

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="rss" name="rss" value="1"  <?php if($d['bbs']['rss']):?> checked<?php endif?>>
				  <label class="custom-control-label" for="rss">RSS발행을 허용합니다. <small>(개별게시판별 RSS발행은 개별게시판 설정을 따름)</small></label>
				</div>

			</div>
	 </div>
	 <div class="form-group row">
			<label class="col-md-2 col-form-label text-md-right">게시물 출력</label>
			<div class="col-md-4 col-xl-3">
				<div class="input-group">
					<input type="text" name="recnum" value="<?php echo $d['bbs']['recnum']?$d['bbs']['recnum']:20?>" class="form-control">
					<div class="input-group-append">
						<span class="input-group-text">개</span>
					</div>
				</div>
				<small class="form-text text-muted">한페이지에 출력할 게시물의 수</small>
			</div>
			<label class="col-md-2 col-form-label text-md-right">제목 끊기</label>
			<div class="col-md-4 col-xl-4">
				<div class="input-group">
					<input type="text" name="sbjcut" value="<?php echo $d['bbs']['sbjcut']?$d['bbs']['sbjcut']:40?>" class="form-control">
					<div class="input-group-append">
						<span class="input-group-text">자</span>
					</div>
				</div>
				<small class="form-text text-muted">제목이 길 경우 보여줄 글자 수 </small>
			</div>
	 </div>

	 <div class="form-group row">
			<label class="col-md-2 col-form-label text-md-right">새글 유지시간</label>
			<div class="col-md-4 col-xl-3">
				<div class="input-group">
					<input type="text" name="newtime" value="<?php echo $d['bbs']['newtime']?$d['bbs']['newtime']:24?>" class="form-control">
					<div class="input-group-append">
						<span class="input-group-text">시간</span>
					</div>
				</div>
				<small class="form-text text-muted">새글로 인식되는 시간</small>
			</div>
			<label class="col-md-2 col-form-label text-md-right">답글 인식문자</label>
			<div class="col-md-4 col-xl-4">
				<input type="text" name="restr" value="<?php echo $d['bbs']['restr']?>" class="form-control">
				<small class="form-text text-muted">제목이 길 경우 보여줄 글자 수 </small>
			</div>
	 </div>

	 <div class="form-group row">
			<label class="col-md-2 col-form-label text-md-right">평가 제한</label>
			<div class="col-md-10 col-xl-9">

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="denylikemy" name="denylikemy" value="1"  <?php if($d['bbs']['denylikemy']):?> checked<?php endif?>>
				  <label class="custom-control-label" for="denylikemy">내글에 대한 좋아요와 싫어요 참여를 제한합니다.</label>
				</div>

			</div>
	 </div>

	 <div class="form-group row">
			<label class="col-md-2 col-form-label text-md-right">삭제 제한</label>
			<div class="col-md-10 col-xl-9">

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="replydel" name="replydel" value="1"  <?php if($d['bbs']['replydel']):?> checked<?php endif?>>
				  <label class="custom-control-label" for="replydel">답변글이 있는 원본글의 삭제를 제한합니다.</label>
				</div>

				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="commentdel" name="commentdel" value="1"  <?php if($d['bbs']['commentdel']):?> checked<?php endif?>>
				  <label class="custom-control-label" for="commentdel">댓글이 있는 원본글의 삭제를 제한합니다.</label>
				</div>

			</div>
	 </div>


	 <div class="form-group row">
		 <label class="col-md-2 col-form-label text-md-right">불량글 처리</label>
		  <div class="col-md-10 col-xl-9">
				<div class="form-inline">

					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="singo_del"name="singo_del" value="1" <?php if($d['bbs']['singo_del']):?> checked<?php endif?> >
						<label class="custom-control-label" for="singo_del">신고건 수가</label>
					</div>
					<div class="input-group ml-3">
						<input type="text" name="singo_del_num" value="<?php echo $d['bbs']['singo_del_num']?>" class="form-control">
						<div class="input-group-append">
							<span class="input-group-text">건 이상인 경우</span>
						</div>
					</div>
					<select name="singo_del_act" class="form-control custom-select ml-2">
						<option value="1"<?php if($d['bbs']['singo_del_act']==1):?> selected="selected"<?php endif?>>자동삭제</option>
						<option value="2"<?php if($d['bbs']['singo_del_act']==2):?> selected="selected"<?php endif?>>비밀처리</option>
					</select>

				</div> <!-- .form-inline -->
		</div> <!-- .col-sm-10 -->
	</div> <!-- .form-group -->
   <div class="form-group row">
       <label class="col-md-2 col-form-label text-md-right">제한단어</label>
	     <div class="col-md-10 col-xl-9">
				<textarea name="badword" rows="5" class="form-control"><?php echo $d['bbs']['badword']?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">제한단어 처리</label>
	  	  <div class="col-sm-10">

					<div class="custom-control custom-radio">
					  <input type="radio" id="badword_action_0" class="custom-control-input" name="badword_action" value="0" <?php if($d['bbs']['badword_action']==0):?> checked<?php endif?>>
					  <label class="custom-control-label" for="badword_action_0">제한단어 체크하지 않음</label>
					</div>
					<div class="custom-control custom-radio">
					  <input type="radio" id="badword_action_1" class="custom-control-input" name="badword_action" value="1"<?php if($d['bbs']['badword_action']==1):?> checked<?php endif?>>
					  <label class="custom-control-label" for="badword_action_1">등록을 차단함</label>
					</div>
					<div class="custom-control custom-radio">
					  <input type="radio" id="badword_action_2" class="custom-control-input" name="badword_action" value="2"<?php if($d['bbs']['badword_action']==2):?> checked<?php endif?>>
					  <label class="custom-control-label" for="badword_action_2">
							제한단어를 다음의 문자로 치환하여 등록함
							<input type="text" name="badword_escape" value="<?php echo $d['bbs']['badword_escape']?>" maxlength="1" class="d-inline form-control form-control-sm">
						</label>
					</div>

		   </div><!-- .col-sm-10 -->
		 </div>
   <div class="row">
			<div class="offset-md-2 col-md-10 col-xl-9">
				<button type="submit" class="btn btn-outline-primary btn-block my-4">저장하기</button>
			</div>
	</div>

</form>
<script type="text/javascript">

putCookieAlert('bbs_config_result') // 실행결과 알림 메시지 출력

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
	getIframeForAction(f);
	f.submit();
}

</script>
