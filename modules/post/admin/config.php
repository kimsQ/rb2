<form class="row no-gutters" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="config">

	<div class="col-sm-3 col-md-3 col-xl-3 d-none d-sm-block sidebar">
		<div class="card">
			<div class="card-header">
				메뉴
			</div>
			<div class="list-group" id="list-tab" role="tablist">
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if(!$_SESSION['post_config_nav'] || $_SESSION['post_config_nav']=='basic'):?> active<?php endif?>" data-toggle="list" href="#basic" role="tab" onclick="sessionSetting('post_config_nav','basic','','');" aria-selected="false">
					일반
				</a>

	      <a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['post_config_nav']=='theme'):?> active<?php endif?>" data-toggle="list" href="#theme" role="tab" onclick="sessionSetting('post_config_nav','theme','','');" aria-selected="true">
					레이아웃/테마
				</a>
	    </div>
		</div>
	</div><!-- /.sidebar -->

	<div class="col-sm-9 col-md-9 ml-sm-auto col-xl-9">

		<div class="tab-content">

			<div class="tab-pane <?php if(!$_SESSION['post_config_nav'] || $_SESSION['post_config_nav']=='basic'):?> show active<?php endif?>" id="basic" >

				<div class="card rounded-0 mb-0">
					<div class="card-header">
						일반 설정
					</div>
					<div class="card-body">

						<div class="form-group row">
						   <label class="col-md-2 col-form-label text-md-right">평가 제한</label>
						   <div class="col-md-10 col-xl-9">

						     <div class="custom-control custom-checkbox">
						       <input type="checkbox" class="custom-control-input" id="denylikemy" name="denylikemy" value="1"  <?php if($d['post']['denylikemy']):?> checked<?php endif?>>
						       <label class="custom-control-label" for="denylikemy">내글에 대한 좋아요와 싫어요 참여를 제한합니다.</label>
						     </div>

						   </div>
						</div>

						<div class="form-group row">
						   <label class="col-md-2 col-form-label text-md-right">조회수 증가</label>
						   <div class="col-md-10 col-xl-9">

								 <div class="custom-control custom-radio custom-control-inline">
			             <input type="radio" id="hitcount_1" name="hitcount" value="1" <?php if($d['post']['hitcount']):?> checked<?php endif?> class="custom-control-input">
			             <label class="custom-control-label" for="hitcount_1">무조건 증가</label>
			           </div>
			           <div class="custom-control custom-radio custom-control-inline">
			             <input type="radio" id="hitcount_0" name="hitcount" value="0"<?php if(!$d['post']['hitcount']):?> checked<?php endif?> class="custom-control-input">
			             <label class="custom-control-label" for="hitcount_0">1회만 증가</label>
			           </div>

						   </div>
						</div>

						<div class="form-group row">
							 <label class="col-md-2 col-form-label text-md-right">목록 출력수</label>
							 <div class="col-md-4">
								 <div class="input-group">
									 <div class="input-group-prepend">
											<span class="input-group-text">페이지당</span>
										</div>
									 <input type="text" name="recnum" value="<?php echo $d['post']['recnum']?$d['post']['recnum']:20?>" class="form-control text-center">
									 <div class="input-group-append">
										 <span class="input-group-text">개</span>
									 </div>
								 </div>
								 <small class="form-text text-muted">한페이지에 출력할 포스트의 수</small>
							 </div>
							 <div class="col-md-4">
								 <div class="input-group">
									 <div class="input-group-prepend">
											<span class="input-group-text">라인당</span>
										</div>
									 <input type="text" name="rownum" value="<?php echo $d['post']['rownum']?$d['post']['rownum']:'4'?>" class="form-control text-center">
									 <div class="input-group-append">
										 <span class="input-group-text">개</span>
									 </div>
								 </div>
								 <small class="form-text text-muted">한줄에 표시할 카드의 수, 카드형 레이아웃에 해당</small>
							 </div>
						</div>

						<div class="form-group row">
							 <label class="col-md-2 col-form-label text-md-right">새글 유지시간</label>
							 <div class="col-md-4 col-xl-3">
								 <div class="input-group">
									 <input type="text" name="newtime" value="<?php echo $d['post']['newtime']?$d['post']['newtime']:24?>" class="form-control">
									 <div class="input-group-append">
										 <span class="input-group-text">시간</span>
									 </div>
								 </div>
								 <small class="form-text text-muted">새글로 인식되는 시간</small>
							 </div>

						</div>

						<div class="form-group row">
						  <label class="col-md-2 col-form-label text-md-right">불량글 처리</label>
						   <div class="col-md-10 col-xl-9">
						     <div class="form-inline">

						       <div class="custom-control custom-checkbox">
						         <input type="checkbox" class="custom-control-input" id="singo_del"name="singo_del" value="1" <?php if($d['post']['singo_del']):?> checked<?php endif?> >
						         <label class="custom-control-label" for="singo_del">신고건 수가</label>
						       </div>
						       <div class="input-group ml-3">
						         <input type="text" name="singo_del_num" value="<?php echo $d['post']['singo_del_num']?>" class="form-control">
						         <div class="input-group-append">
						           <span class="input-group-text">건 이상인 경우</span>
						         </div>
						       </div>
						       <select name="singo_del_act" class="form-control custom-select ml-2">
						         <option value="1"<?php if($d['post']['singo_del_act']==1):?> selected="selected"<?php endif?>>자동삭제</option>
						         <option value="2"<?php if($d['post']['singo_del_act']==2):?> selected="selected"<?php endif?>>비밀처리</option>
						       </select>

						     </div> <!-- .form-inline -->
						 </div> <!-- .col-sm-10 -->
						</div> <!-- .form-group -->
						<div class="form-group row">
						    <label class="col-md-2 col-form-label text-md-right">제한단어</label>
						    <div class="col-md-10 col-xl-9">
						     <textarea name="badword" rows="5" class="form-control"><?php echo $d['post']['badword']?></textarea>
						     </div>
						 </div>
						 <div class="form-group row">
						     <label class="col-md-2 col-form-label text-md-right">제한단어 처리</label>
						     <div class="col-sm-10">

						       <div class="custom-control custom-radio">
						         <input type="radio" id="badword_action_0" class="custom-control-input" name="badword_action" value="0" <?php if($d['post']['badword_action']==0):?> checked<?php endif?>>
						         <label class="custom-control-label" for="badword_action_0">제한단어 체크하지 않음</label>
						       </div>
						       <div class="custom-control custom-radio">
						         <input type="radio" id="badword_action_1" class="custom-control-input" name="badword_action" value="1"<?php if($d['post']['badword_action']==1):?> checked<?php endif?>>
						         <label class="custom-control-label" for="badword_action_1">등록을 차단함</label>
						       </div>
						       <div class="custom-control custom-radio">
						         <input type="radio" id="badword_action_2" class="custom-control-input" name="badword_action" value="2"<?php if($d['post']['badword_action']==2):?> checked<?php endif?>>
						         <label class="custom-control-label" for="badword_action_2">
						           제한단어를 다음의 문자로 치환하여 등록함
						           <input type="text" name="badword_escape" value="<?php echo $d['post']['badword_escape']?>" maxlength="1" class="d-inline form-control form-control-sm mt-2">
						         </label>
						       </div>

						    </div><!-- .col-sm-10 -->
						  </div>
					</div><!-- /.card-body -->
				</div><!-- /.card -->

			</div><!-- /.tab-pane -->

			<div class="tab-pane <?php if($_SESSION['post_config_nav']=='theme'):?> show active<?php endif?>" id="theme">

				<div class="card rounded-0 mb-0">
					<div class="card-header">
						<i class="fa fa-columns fa-fw" aria-hidden="true"></i> 레이아웃 설정
					</div>
					<div class="card-body">

						<div class="form-group row">
						 <label class="col-lg-2 col-form-label text-lg-right">레이아웃</label>
						 <div class="col-lg-10 col-xl-9">

							 <select name="layout" class="form-control custom-select">
								 <option value="">사이트 대표 레이아웃</option>
								 <option disabled>--------------------</option>
								 <?php $dirs = opendir($g['path_layout'])?>
								 <?php while(false !== ($tpl = readdir($dirs))):?>
								 <?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
								 <?php $dirs1 = opendir($g['path_layout'].$tpl)?>
									 <optgroup label="<?php echo getFolderName($g['path_layout'].$tpl)?>">
										 <?php while(false !== ($tpl1 = readdir($dirs1))):?>
										 <?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
											<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($d['post']['layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>><?php echo $tpl?> &gt; <?php echo str_replace('.php','',$tpl1)?></option>
										 <?php endwhile?>
									</optgroup>
								 <?php closedir($dirs1)?>
								 <?php endwhile?>
								 <?php closedir($dirs)?>
							 </select>
						 </div>
						</div>

						<div class="form-group row">
							 <label class="col-lg-2 col-form-label text-lg-right">
								 <span class="badge badge-dark">모바일 접속</span>
							 </label>
							 <div class="col-lg-10 col-xl-9">

								 <select name="m_layout" class="form-control custom-select" id="" tabindex="-1">
									 <?php if ($_HS['m_layout']): ?>
									 <option value="0">사이트 레이아웃</option>
									 <?php else: ?>
									 <option value="0">&nbsp;사용안함 (기본 레이아웃 적용)</option>
									 <?php endif; ?>
									 <option disabled>--------------------</option>
									 <?php $dirs = opendir($g['path_layout'])?>
									 <?php while(false !== ($tpl = readdir($dirs))):?>
									 <?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
									 <?php $dirs1 = opendir($g['path_layout'].$tpl)?>
										 <optgroup label="<?php echo getFolderName($g['path_layout'].$tpl)?>">
											 <?php while(false !== ($tpl1 = readdir($dirs1))):?>
											 <?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
												<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($d['post']['m_layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>><?php echo $tpl?> &gt; <?php echo str_replace('.php','',$tpl1)?></option>
											 <?php endwhile?>
										</optgroup>
									 <?php closedir($dirs1)?>
									 <?php endwhile?>
									 <?php closedir($dirs)?>
								 </select>

							 </div>
						</div>

					</div><!-- /.card-body -->
				</div><!-- /.card -->


				<div class="card rounded-0 mb-0">
					<div class="card-header">
						<i class="fa fa-picture-o fa-fw" aria-hidden="true"></i> 테마 설정
					</div>
					<div class="card-body">

						<div class="form-group row">
						   <label class="col-md-2 col-form-label text-md-right">
						     대표 테마
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
						        <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['post']['skin_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
						        <?php endwhile?>
						        <?php closedir($dirs)?>
						      </optgroup>
						      <optgroup label="모바일">
						        <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
						        <?php $dirs = opendir($tdir)?>
						        <?php while(false !== ($skin = readdir($dirs))):?>
						        <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
						        <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['post']['skin_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
						        <?php endwhile?>
						        <?php closedir($dirs)?>
						      </optgroup>

						    </select>
						    <small class="form-text text-muted">
						      지정된 대표테마는 포스트설정시 별도의 테마지정없이 자동으로 적용됩니다.
						      가장 많이 사용하는 테마를 지정해 주세요.
						    </small>
						 </div> <!-- .col-sm-10  -->
						</div> <!-- .form-group  -->
						<div class="form-group row">
						   <label class="col-md-2 col-form-label text-md-right">
						     <span class="badge badge-dark">모바일 대표테마</span>
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
						        <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['post']['skin_mobile']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
						        <?php endwhile?>
						        <?php closedir($dirs)?>
						      </optgroup>
						      <optgroup label="데스크탑">
						        <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
						        <?php $dirs = opendir($tdir)?>
						        <?php while(false !== ($skin = readdir($dirs))):?>
						        <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
						        <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['post']['skin_mobile']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
						        <?php endwhile?>
						        <?php closedir($dirs)?>
						      </optgroup>
						    </select>
						    <small class="form-text text-muted">
						      선택하지 않으면 데스크탑 대표테마로 설정됩니다.
						    </small>
						 </div> <!-- .col-sm-10  -->
						</div> <!-- .form-group  -->


					</div><!-- /.card-body -->
				</div><!-- /.card -->

			</div><!-- /.tab-pane -->

			<div class="row">
			   <div class="offset-md-2 col-md-10 col-xl-9">
			     <button type="submit" class="btn btn-outline-primary btn-block my-4">저장하기</button>
			   </div>
			</div>
		</div><!-- /.tab-content -->

	</div><!-- /.col -->





</form>
<script type="text/javascript">

putCookieAlert('post_config_result') // 실행결과 알림 메시지 출력

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
