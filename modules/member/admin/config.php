<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN   = db_num_rows($SITES);

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';

$_tmplfile =  $g['path_module'].$module.'/var/location.txt';
$_tmpjfile = $g['path_module'].$module.'/var/job.txt';

$g['memberAdd_fieldForSite'] = $g['path_var'].'site/'.$r.'/member.add_field.txt';
$_tmpafile = file_exists($g['memberAdd_fieldForSite']) ? $g['memberAdd_fieldForSite'] : $g['path_module'].$module.'/var/add_field.txt';

include_once $_tmpvfile;
?>


<form class="row no-gutters" name="procForm" role="form" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="">
	<input type="hidden" name="_join_menu" value="<?php echo $_SESSION['_join_menu']?$_SESSION['_join_menu']:1?>">

	<div class="col-sm-3 col-md-3 col-xl-3 d-none d-sm-block sidebar">

		<div class="card">
			<div class="card-header">
				메뉴
			</div>
			<div class="list-group" id="list-tab" role="tablist">
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if(!$_SESSION['member_config_nav'] || $_SESSION['member_config_nav']=='settings'):?> active<?php endif?>" data-toggle="list" href="#settings" role="tab" onclick="sessionSetting('member_config_nav','settings','','');">
					기초환경 설정
					<span class="badge badge-dark">공통</span>
				</a>

	      <a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['member_config_nav']=='signup-config'):?> active<?php endif?>" data-toggle="list" href="#signup-config" role="tab" onclick="sessionSetting('member_config_nav','signup-config','','');">
					회원가입 설정
					<span class="badge badge-dark">가입</span>
				</a>
	      <a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['member_config_nav']=='signup-form-config'):?> active<?php endif?>" data-toggle="list" href="#signup-form-config" role="tab" onclick="sessionSetting('member_config_nav','signup-form-config','','');">
					가입양식 관리
					<span class="badge badge-dark">가입</span>
				</a>
	      <a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['member_config_nav']=='signup-form-add'):?> active<?php endif?>" data-toggle="list" href="#signup-form-add" role="tab" onclick="sessionSetting('member_config_nav','signup-form-add','','');">
					가입항목 추가
					<span class="badge badge-dark">가입</span>
				</a>
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['member_config_nav']=='terms'):?> active<?php endif?>" data-toggle="list" href="#terms" role="tab" onclick="sessionSetting('member_config_nav','terms','','');">
					약관/안내메시지
					<span class="badge badge-dark">가입</span>
				</a>
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['member_config_nav']=='login-config'):?> active<?php endif?>" data-toggle="list" href="#login-config" role="tab" onclick="sessionSetting('member_config_nav','login-config','','');">
					로그인
					<span class="badge badge-dark">로그인</span>
				</a>
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['member_config_nav']=='settings-config'):?> active<?php endif?>" data-toggle="list" href="#settings-config" role="tab" onclick="sessionSetting('member_config_nav','settings-config','','');">
					개인정보관리
					<span class="badge badge-dark">개인정보관리</span>
				</a>
	    </div>
		</div>


	</div>
	<div class="col-sm-9 col-md-9 ml-sm-auto col-xl-9">


			<!-- Tab panes -->
			<div class="tab-content" id="setting-content">

				<!-- 기초환경 설정 -->
			 <div class="tab-pane fade<?php if(!$_SESSION['member_config_nav'] || $_SESSION['member_config_nav']=='settings'):?> show active<?php endif?>" id="settings">

				 <!-- 테마설정 -->
				 <div class="card rounded-0 mb-0">
					 <div class="card-header">
						 <i class="fa fa-picture-o fa-fw" aria-hidden="true"></i> 테마 설정
					 </div>
					 <div class="card-body">
						 <div class="row">
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>데스크탑 대표테마</label>
									 <select name="theme_main" class="form-control custom-select">
										 <option value="">&nbsp;+ 선택하세요</option>

										 <optgroup label="데스크탑">
											 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
											 <?php $dirs = opendir($tdir)?>
											 <?php while(false !== ($skin = readdir($dirs))):?>
											 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
											 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['member']['theme_main']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
											 <?php endwhile?>
											 <?php closedir($dirs)?>
										 </optgroup>
										 <optgroup label="모바일">
											 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
											 <?php $dirs = opendir($tdir)?>
											 <?php while(false !== ($skin = readdir($dirs))):?>
											 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
											 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['member']['theme_main']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
											 <?php endwhile?>
											 <?php closedir($dirs)?>
										 </optgroup>

									 </select>
									 <small class="form-text text-muted">
										지정된 대표테마는 별도의 테마를 지정하지 않으면 자동으로 적용됩니다.
										가장 많이 사용하는 테마를 지정해 주세요.
									 </small>
								 </div>
							 </div>
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>모바일 전용</label>
									 <select name="theme_mobile" class="form-control custom-select">
										 <option value="">&nbsp;+ 모바일 테마 사용안함</option>
										 <optgroup label="모바일">
											 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
											 <?php $dirs = opendir($tdir)?>
											 <?php while(false !== ($skin = readdir($dirs))):?>
											 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
											 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['member']['theme_mobile']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
											 <?php endwhile?>
											 <?php closedir($dirs)?>
											</optgroup>
											<optgroup label="데스크탑">
												<?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
												<?php $dirs = opendir($tdir)?>
												<?php while(false !== ($skin = readdir($dirs))):?>
												<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
												<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($d['member']['theme_mobile']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
												<?php endwhile?>
												<?php closedir($dirs)?>
											 </optgroup>
									 </select>
									 <small class="form-text text-muted">
										 선택하지 않으면 데스크탑 대표테마로 설정됩니다.
									 </small>
								 </div>
							 </div>
						 </div>

					 </div><!-- /.card-body -->
				 </div><!-- /.card -->

				 <!-- 소속메뉴 설정 -->
				 <div class="card rounded-0 mb-0">
					 <div class="card-header">
						 <i class="fa fa-sitemap fa-lg fa-fw"></i> 소속메뉴 설정
					 </div>
					 <div class="card-body">
						 <?php include_once $g['path_core'].'function/menu1.func.php'?>
						 <div class="row">
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>회원가입</label>
									 <select name="sosokmenu_join" class="form-control custom-select">
										 <option value="">사용안함</option>
										 <option disabled>--------------------</option>
										 <?php $cat=$d['member']['sosokmenu_join']?>
										 <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									 </select>
								 </div>
							 </div>
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>로그인</label>
									 <select name="sosokmenu_login" class="form-control custom-select">
										 <option value="">사용안함</option>
										 <option disabled>--------------------</option>
										 <?php $cat=$d['member']['sosokmenu_login']?>
										 <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									 </select>
								 </div>
							 </div>
						 </div>
						 <div class="row">
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>프로필</label>
									 <select name="sosokmenu_profile" class="form-control custom-select">
										 <option value="">사용안함</option>
										 <option disabled>--------------------</option>
										 <?php $cat=$d['member']['sosokmenu_profile']?>
										 <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									 </select>
								 </div>
							 </div>
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>개인정보 설정</label>
									 <select name="sosokmenu_settings" class="form-control custom-select">
										 <option value="">사용안함</option>
										 <option disabled>--------------------</option>
										 <?php $cat=$d['member']['sosokmenu_settings']?>
										 <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									 </select>
								 </div>
							 </div>
						 </div>

						 <div class="row">
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>저장함</label>
									 <select name="sosokmenu_saved" class="form-control custom-select">
										 <option value="">사용안함</option>
										 <option disabled>--------------------</option>
										 <?php $cat=$d['member']['sosokmenu_saved']?>
										 <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									 </select>
								 </div>
							 </div>
							 <div class="col-sm-6">
								 <div class="form-group">
									 <label>알림함</label>
									 <select name="sosokmenu_noti" class="form-control custom-select">
										 <option value="">사용안함</option>
										 <option disabled>--------------------</option>
										 <?php $cat=$d['member']['sosokmenu_noti']?>
										 <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
									 </select>
								 </div>
							 </div>
						 </div>

					 </div><!-- /.card-body -->
					 <div class="card-footer">
						 <button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4"><i class="fa fa-check"></i> 정보저장</button>
					 </div>
				 </div><!-- /.card -->

			 </div>
				<!-- /기초환경 설정 -->

				<div class="tab-pane fade<?php if($_SESSION['member_config_nav']=='signup-config'):?>  show active<?php endif?>" id="signup-config">


					<!-- 회원가입 설정 -->
					<div class="card rounded-0 mb-0">
						<div class="card-header">
							회원가입 설정
						</div>
						<div class="card-body">

							<div class="form-group">
								<label>회원가입 작동상태</label>
								<div class="">
									<div class="btn-group btn-group-toggle" data-toggle="buttons">
										<label class="btn btn-light <?php if($d['member']['join_enable']):?>active<?php endif?>">
											<input type="radio" name="join_enable" value="1" id="option1" <?php if($d['member']['join_enable']):?>checked<?php endif?>/> 작동
										</label>
										<label class="btn btn-light <?php if(!$d['member']['join_enable']):?>active<?php endif?>">
											<input type="radio" name="join_enable" value="0" <?php if(!$d['member']['join_enable']):?>checked<?php endif?> id="option2" /> 중단
										</label>
									</div>
								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>가입수단</label>

										<div class="mt-2">
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" name="join_byEmail" id="join_byEmail"<?php if($d['member']['join_byEmail']):?> checked<?php endif?> value="1">
												<label class="custom-control-label" for="join_byEmail">이메일로 가입</label>
											</div>

											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" name="join_byPhone" id="join_byPhone"<?php if($d['member']['join_byPhone']):?> checked<?php endif?> value="1">
												<label class="custom-control-label" for="join_byPhone">휴대폰 번호로 가입</label>
											</div>

											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" name="join_bySocial" id="join_bySocial"<?php if($d['member']['join_bySocial']):?> checked<?php endif?> value="1">
												<label class="custom-control-label" for="join_bySocial">소셜미디어 계정으로 가입</label>
											</div>

										</div>
			 						 <small class="form-text text-muted">소셜미디어 계정으로 가입 사용시 <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=connect&front=main">연결설정</a>이 필요합니다.</small>
									</div>
								</div>
							</div>

							<hr>
							<div class="row">

								<div class="col-sm-12">
									<div class="form-group">
										<label>가입시 본인확인 여부</label>

										<div class="">
											<div class="custom-control custom-radio custom-control-inline">
											  <input type="radio" id="join_verify_0" name="join_verify" class="custom-control-input"<?php if(!$d['member']['join_verify']):?> checked<?php endif?> value="0">
											  <label class="custom-control-label" for="join_verify_0">사용안함</label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="join_verify_1" name="join_verify" class="custom-control-input"<?php if($d['member']['join_verify']):?> checked<?php endif?> value="1">
												<label class="custom-control-label" for="join_verify_1">사용함</label>
											</div>

										</div>
			 						 <small class="form-text text-muted">
										 이메일 및 SMS로 이메일 인증번호 및 인증링크가 발송됩니다.
										 이메일 및 SMS <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=admin&front=main">발송설정과 점검</a>이 필요합니다.<br>
										 소셜미디어 계정으로 로그인 성공시 본인확인이 완료된 것으로 처리됩니다.
									 </small>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-6">

									<div class="form-group">
										<label>본인확인 인증번호 및 인증링크의 유효시간</label>
										<div class="input-group w-25">
			 							 <input type="text" name="join_keyexpire" value="<?php echo $d['member']['join_keyexpire']?>" size="5" class="form-control text-center">
			 								<div class="input-group-append">
			 									<span class="input-group-text">분</span>
			 								</div>
			 						 </div>
			 						 <small class="form-text text-muted">이메일과 휴대폰으로 전달된 인증코드 및 링크의 유효시간을 설정합니다. </small>
									</div><!-- /.form-group -->


								</div>
								<div class="col-sm-6">

									<div class="form-group">
										<label>본인확인 SMS 일발송 제한</label>
										<div class="input-group w-25">
										 <input type="text" name="join_daysms" value="<?php echo $d['member']['join_daysms']?>" size="5" class="form-control text-center">
											<div class="input-group-append">
												<span class="input-group-text">회</span>
											</div>
									 </div>
									 <small class="form-text text-muted">지정된 횟수 초과시 본인확인을 위한 SMS 발송이 제한됩니다.</small>
									</div><!-- /.form-group -->


								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>가입시 승인처리</label>
										<select name="join_auth" class="form-control custom-select">
											<option value="1"<?php if($d['member']['join_auth']==1):?> selected="selected"<?php endif?>>즉시승인</option>
											<option value="2"<?php if($d['member']['join_auth']==2):?> selected="selected"<?php endif?>>관리자 확인 후 승인</option>
										 </select>
									</div>
								</div>
								<div class="col-sm-6">

								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>가입시 소속그룹</label>
										<select name="join_group" class="form-control custom-select">
												<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
													<?php while($_S=db_fetch_array($_SOSOK)):?>
															<option value="<?php echo $_S['uid']?>"<?php if($_S['uid']==$d['member']['join_group']):?> selected="selected"<?php endif?>><?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
													<?php endwhile?>
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group error">
										<label>가입시 회원등급</label>
										<select name="join_level" class="form-control custom-select">
															<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
											<?php while($_L=db_fetch_array($_LEVEL)):?>
											<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['member']['join_level']):?> selected="selected"<?php endif?>><?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>)</option>
											<?php if($_L['gid'])break; endwhile?>
										</select>
									</div>
								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>대표 이메일</label>
										<input type="email" name="join_email" value="<?php echo $d['member']['join_email']?>" class="form-control">
										<small class="form-text text-muted">
											본인확인 인증번호 및 가입완료 메일 등의 발신자 이메일로 활용됩니다.
										</small>
									</div>
								</div>
								<div class="col-sm-6">

									<div class="form-group">
										<label>대표 전화</label>
										<input type="tel" name="join_tel" value="<?php echo $d['member']['join_tel']?>" class="form-control">
										<small class="form-text text-muted">
											본인확인 인증번호 및 가입완료 문자메시지 등의 발신자 전화번호로 활용됩니다.
										</small>
									</div>
								</div>
							</div>

							<hr>


							<div class="card">
								<div class="card-header">
									<i class="fa fa-paper-plane-o mr-1" aria-hidden="true"></i> 가입완료 메시지 발송
								</div>
								<div class="card-body">

									<div class="row">
										<div class="col">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="join_noti_send" name="join_noti_send" value="1"<?php if($d['member']['join_noti_send']):?> checked="checked"<?php endif?>>
												<label class="custom-control-label" for="join_noti_send">웹알림 발송</label>
											</div>
											<small class="form-text text-muted">
												웹알림 메시지 구성이 필요합니다.
											</small>
										</div><!-- /.col -->

										<div class="col">
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" id="join_email_send" name="join_email_send" value="1"<?php if($d['member']['join_email_send']):?> checked="checked"<?php endif?>>
												<label class="custom-control-label" for="join_email_send">이메일 발송</label>
											</div>
											<small class="form-text text-muted">
												이메일 <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=admin&front=main">발송점검</a>이 필요합니다.
											</small>
										</div>
									</div><!-- /.row -->

								</div><!-- /.card-body -->
							</div><!-- /.card -->

							<div class="card">
								<div class="card-header">
									<i class="fa fa-product-hunt mr-1" aria-hidden="true"></i> 가입시 포인트 지급
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="form-group mb-0">
												<label>지급 포인트</label>
												<input type="number" name="join_point" value="<?php echo $d['member']['join_point']?>" class="form-control" placeholder="">
											</div>
										</div>
										<div class="col">
											<div class="form-group mb-0">
												<label>지급 메세지</label>
												<input type="text" name="join_pointmsg" value="<?php echo $d['member']['join_pointmsg']?>" class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div><!-- /.card -->

							<div class="card">
								<div class="card-header">
									<i class="fa fa-ban mr-1" aria-hidden="true"></i> 가입시 제한
								</div>
								<div class="card-body">

									<div class="form-group">
										<label>가입제한 이메일</label>
										<textarea class="form-control" name="join_cutemail" rows="4"><?php echo $d['member']['join_cutemail']?></textarea>
										<small class="form-text text-muted">사용을 제한하려는 이메일을 콤마(,)로 구분해서 입력해 주세요.(예: test@email.com,@myhome.com)</small>
									</div>

									<div class="form-group">
										<label>가입제한 휴대폰</label>
										<textarea class="form-control" name="join_cutphone" rows="4"><?php echo $d['member']['join_cutphone']?></textarea>
										<small class="form-text text-muted">사용을 제한하려는 휴대폰을 콤마(,)로 구분해서 입력해 주세요.(예: 01012345678,0102345678)</small>
									</div>

									<div class="form-group">
										<label>사용제한 닉네임</label>
										<textarea class="form-control" name="join_cutnic" rows="3"><?php echo $d['member']['join_cutnic']?></textarea>
										<small class="form-text text-muted">사용을 제한하려는 닉네임을 콤마(,)로 구분해서 입력해 주세요.</small>
									</div>

									<div class="form-group">
										<label>사용제한 아이디</label>
										<textarea class="form-control" name="join_cutid" rows="4"><?php echo $d['member']['join_cutid']?></textarea>
										<small class="form-text text-muted">사용을 제한하려는 아이디를 콤마(,)로 구분해서 입력해 주세요.</small>
									</div>

								</div><!-- /.card-body -->
							</div><!-- /.card -->

							<hr>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>탈퇴데이터 처리</label>
										<div>


											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" id="join_out_1"  name="join_out" value="1" <?php if($d['member']['join_out']==1):?>checked<?php endif?>>
												<label class="custom-control-label" for="join_out_1">즉시삭제</label>
											</div>

											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" id="join_out_2" name="join_out" value="2" <?php if($d['member']['join_out']==2):?>checked<?php endif?>>
												<label class="custom-control-label" for="join_out_2">관리자 확인 후 삭제</label>
											</div>


										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group error">
										<label>탈퇴후 재가입</label>
										<div>

											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" id="join_rejoin_1" name="join_rejoin" value="1" <?php if($d['member']['join_rejoin']):?>checked<?php endif?>>
												<label class="custom-control-label" for="join_rejoin_1">허용함</label>
											</div>

											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" id="join_rejoin_0" name="join_rejoin" value="0" <?php if(!$d['member']['join_rejoin']):?>checked<?php endif?>>
												<label class="custom-control-label" for="join_rejoin_0">허용 안함</label>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div><!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4"><i class="fa fa-check"></i> 정보저장</button>
						</div>
					</div><!-- /.card -->


				</div>
				<!-- /회원가입 설정 -->

				 <!-- 가입양식 관리 -->
				<div class="tab-pane fade<?php if($_SESSION['member_config_nav']=='signup-form-config'):?> show active<?php endif?>" id="signup-form-config">
					<div class="card rounded-0 mb-0">
						<div class="card-header">
							가입양식 관리
						</div>
						<div class="card-body">

							<div class="card">
								<div class="card-header">
									<span class="badge badge-light">데스크탑</span> 회원가입 노출항목 및 옵션 <code>join</code>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-6">
											<?php $opset = array('id'=>'아이디','email'=>'이메일','phone'=>'휴대폰','password'=>'패스워드','name'=>'이름','nic'=>'닉네임','birth'=>'생년월일')?>
											<?php $i=0;foreach($opset as $_key => $_val):?>
										   <fieldset <?php echo $i<5?'disabled':''?>>
											 <?php if($i<5):?>
											<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="customCheck1" checked>
												<label class="custom-control-label" for="customCheck1"><?php echo $_val?></label>
											</div>
											 <i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
											 <div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
													<input type="checkbox" class="custom-control-input" id="customCheck2" checked>
													<label class="custom-control-label" for="customCheck2">필수입력</label>
												 </div>

											 <?php else:?>
												 <div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
	 												<input type="checkbox" class="custom-control-input" id="form_join_<?php echo $_key?>" name="form_join_<?php echo $_key?>" value="1"<?php if($d['member']['form_join_'.$_key]):?> checked<?php endif?>>
	 												<label class="custom-control-label" for="form_join_<?php echo $_key?>"><?php echo $_val?></label>
	 											 </div>
												 <i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
												 <div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
	 												<input type="checkbox" class="custom-control-input" id="form_join_<?php echo $_key?>_required" name="form_join_<?php echo $_key?>_required" value="1"<?php if($d['member']['form_join_'.$_key.'_required']):?> checked<?php endif?>>
	 												<label class="custom-control-label" for="form_join_<?php echo $_key?>_required">필수입력</label>
	 											 </div>

											 <?php endif?>
										 		</fieldset>
										 <?php $i++;endforeach?>
										</div>
										<div class="col-sm-6">
											<?php $opset = array('bio'=>'간단소개','sex'=>'성별','home'=>'홈페이지','tel'=>'일반전화','location'=>'거주지역','job'=>'직업','marr'=>'결혼기념일','add'=>'추가항목')?>
											<?php foreach($opset as $_key => $_val):?>
											<fieldset>

												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 100px">
		 											<input type="checkbox" class="custom-control-input" id="form_join_<?php echo $_key?>" name="form_join_<?php echo $_key?>" value="1"<?php if($d['member']['form_join_'.$_key]):?> checked<?php endif?>>
		 											<label class="custom-control-label" for="form_join_<?php echo $_key?>"><?php echo $_val?></label>
		 										 </div>

			 								 <i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>

											 <div class="custom-control custom-checkbox custom-control-inline">
	 											<input type="checkbox" class="custom-control-input" id="form_join_<?php echo $_key?>_required" name="form_join_<?php echo $_key?>_required" value="1"<?php if($d['member']['form_join_'.$_key.'_required']):?> checked<?php endif?>>
	 											<label class="custom-control-label" for="form_join_<?php echo $_key?>_required">필수입력</label>
	 										 </div>

											</fieldset>
											<?php endforeach?>
										</div>
									</div>
								</div>

								<div class="card-footer small text-muted">
									 회원 가입시에는 입력항목을 최소화 할것을 권고 드립니다.<br>추가로 필요한 개인정보는 가입 이후에 개인정보관리 페이지를 통해 필요할때 추가입력 받는 것을 추천드립니다.
								 </div>
							</div>

							<div class="card">
								<div class="card-header">
									<span class="badge badge-light">모바일</span> 회원가입 노출항목 및 옵션 <code>join</code>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-6">
											<fieldset disabled="">
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="" checked="">
												<label class="custom-control-label" for="">이메일</label>
												</div>
												<i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="" checked="">
												<label class="custom-control-label" for="">필수입력</label>
												</div>
											</fieldset>

											<fieldset disabled="">
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="" checked="">
												<label class="custom-control-label" for="">휴대폰번호</label>
												</div>
												<i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="" checked="">
												<label class="custom-control-label" for="">필수입력</label>
												</div>
											</fieldset>
										</div>
										<div class="col-sm-6">
											<fieldset disabled="">
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
												<label class="custom-control-label" for="customCheck1">비밀번호</label>
												</div>
												<i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="customCheck2" checked="">
												<label class="custom-control-label" for="customCheck2">필수입력</label>
												</div>
											</fieldset>

											<fieldset disabled="">
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
												<label class="custom-control-label" for="customCheck1">이름</label>
												</div>
												<i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
												<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 80px">
												<input type="checkbox" class="custom-control-input" id="customCheck2" checked="">
												<label class="custom-control-label" for="customCheck2">필수입력</label>
												</div>
											</fieldset>
										</div>
									</div>
								</div>
							</div>

						</div><!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-3"><i class="fa fa-check"></i> 정보저장</button>
						</div>
					</div><!-- /.card -->


				</div>
				 <!-- /가입양식 관리 -->

			 <!-- 가입항목 추가 -->
			 <div class="tab-pane fade<?php if($_SESSION['member_config_nav']=='signup-form-add'):?> show active<?php endif?>" id="signup-form-add">

					<div class="card rounded-0 mb-0">
						<div class="card-header">
							가입항목 추가
						</div>
						<div class="card-body">
							<div class="mb-4">
	 							<ul class="text-muted small pl-3">
	 								<li>회원가입 폼에 기본양식외의 필요한 입력양식이 있을 경우 추가해 주세요.</li>
	 								<li>입력양식 추가는 반드시 회원가입 서비스를 정식으로 오픈하기 전에 셋팅해 주세요.</li>
	 								<li>서비스도중 양식을 추가하면 이미 가입한 회원에 대해서는 반영되지 않습니다.</li>
	 								<li>회원검색용도로 양식을 추가하는 것은 권장하지 않습니다.</li>
	 							 </ul>
	 					 </div>
	 					 <div class="table-responsive">
	 						 <table class="table">
	 							<thead>
	 								<tr>
	 									<th colspan="2" class="text-center">명칭</th>
	 									<th class="text-center">형식</th>
	 									<th class="text-center">값/속성 <a href="#value-guide" data-toggle="collapse" class="muted-link"><i class="fa fa-question-circle"></i></a></th>
	 									<th class="text-center">필수</th>
	 									<th class="text-center">숨김</th>
	 								</tr>
	 							</thead>
	 							<tbody>

	 								<?php $_add = file($_tmpafile)?>
	 								<?php foreach($_add as $_key):?>
	 								<?php $_val = explode('|',trim($_key))?>

	 								<tr>
		 								<td><input type="button" value="삭제" class="btn btn-danger" onclick="delField(this.form,'<?php echo $_val[0]?>');"></td>
		 								<td><input type="text" name="add_name_<?php echo $_val[0]?>" size="13" value="<?php echo $_val[1]?>" class="form-control"></td>
		 								<td>
		 									<input type="checkbox" name="addFieldMembers[]" value="<?php echo $_val[0]?>" checked="checked" class="d-none">
		 									<select name="add_type_<?php echo $_val[0]?>" class="form-control custom-select">
		 										<option value="text"<?php if($_val[2]=='text'):?> selected="selected"<?php endif?>>TEXT</option>
		 										<option value="password"<?php if($_val[2]=='password'):?> selected="selected"<?php endif?>>PASSWORD</option>
		 										<option value="select"<?php if($_val[2]=='select'):?> selected="selected"<?php endif?>>SELECT</option>
		 										<option value="radio"<?php if($_val[2]=='radio'):?> selected="selected"<?php endif?>>RADIO</option>
		 										<option value="checkbox"<?php if($_val[2]=='checkbox'):?> selected="selected"<?php endif?>>CHECKBOX</option>
		 										<option value="textarea"<?php if($_val[2]=='textarea'):?> selected="selected"<?php endif?>>TEXTAREA</option>
		 									</select>
		 								</td>
		 								<td><input type="text" name="add_value_<?php echo $_val[0]?>" size="30" value="<?php echo $_val[3]?>" class="form-control"/></td>
		 							<!-- 	<td><input type="text" name="add_size_<?php echo $_val[0]?>" size="4" value="<?php echo $_val[4]?>" class="form-control" /></td>
		 							 필요할 경우 주석제거-->
									 <td class="text-center align-middle">
										 <div class="form-check">
											 <input type="checkbox" class="form-check-input position-static" name="add_pilsu_<?php echo $_val[0]?>" value="1"<?php if($_val[5]):?> checked="checked"<?php endif?>  id="add_pilsu_<?php echo $_val[0]?>">
										 </div>
									 </td>
	 								 <td class="text-center align-middle">
										 <div class="form-check">
											 <input type="checkbox" class="form-check-input position-static" name="add_hidden_<?php echo $_val[0]?>" value="1"<?php if($_val[6]):?> checked="checked"<?php endif?> id="add_hidden_<?php echo $_val[0]?>">
										 </div>
								 		</td>
	 								</tr>
	 								<?php endforeach?>
	 								<tr class="active">
	 									<td><button type="button" class="btn btn-outline-secondary"  onclick="addField(this.form);">추가</button></td>
	 									<td><input type="text" name="add_name" class="form-control" placeholder=""></td>
	 									<td>
	 										<select name="add_type" class="form-control custom-select">
	 											<option value="text">TEXT</option>
	 											<option value="password">PASSWORD</option>
	 											<option value="select">SELECT</option>
	 											<option value="radio">RADIO</option>
	 											<option value="checkbox">CHECKBOX</option>
	 											<option value="textarea">TEXTAREA</option>
	 										</select>
	 									</td>
	 									<td><input type="text" name="add_value" class="form-control" placeholder=""></td>
	 									<!-- <td><input type="text" name="add_size" class="form-control" placeholder=""></td>  필요할 경우 주석제거-->
	 									<td class="text-center align-middle">
											<div class="form-check">
 											 <input type="checkbox" class="form-check-input position-static" id="add_pilsu" name="add_pilsu">
 										 </div>
	 									</td>
	 									<td class="text-center align-middle">
											<div class="form-check">
 											 <input type="checkbox" class="form-check-input position-static" id="add_hidden" name="add_hidden">
 										 </div>
	 									</td>
	 								</tr>
	 							</tbody>
	 						 </table>
	 						 <p class="collapse bg-light p-3 text-muted border-light small" id="value-guide">
	 								<code>input</code> 의 경우 해당 값이 되므로 입력하지 않는 것이 일반적입니다. <br>
	 								<code>select</code>,<code>radio</code>,<code>checkbox</code> 의 경우 선택항목이 되며 콤마(,)로 구분하시면 됩니다.
	 						 </p>
	 					 </div>

	 					 <h4 class="mt-4">미리보기</h4>
	 					 <div id="preview">

	 							<!-- 추가필드 시작 -->
	 								 <?php foreach($_add as $_key):?>
	 								 <?php $_val = explode('|',trim($_key))?>
	 								 <?php if(!$_val[0]) continue?>
									 <div class="form-group">
										 <label  for="<?php echo $_val[0]?>" class="col-sm-3 control-label">
										 <?php echo $_val[1]?>
										 <?php if($_val[5]):?> <span class="text-danger">*</span><?php endif?>
										 </label>
												<div class="col-sm-8">
														<!-- 일반 input=text -->
														<?php if($_val[2]=='text'):?>
													<input type="text" id="<?php echo $_val[0]?>" name="add_<?php echo $_val[0]?>" value="<?php echo $_val[3]?>" class="form-control"/>
														<?php endif?>

														<!-- password input=text -->
														<?php if($_val[2]=='password'):?>
												  <input type="password" id="<?php echo $_val[0]?>" name="add_<?php echo $_val[0]?>" value="<?php echo $_val[3]?>" class="form-control" />
														<?php endif?>

												 	<!-- select box -->
														<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
														<select name="add_<?php echo $_val[0]?>" id="<?php echo $_val[0]?>" class="form-control">
															<option value="">&nbsp;+ 선택하세요</option>
															<?php foreach($_skey as $_sval):?>
															<option value="<?php echo trim($_sval)?>">ㆍ<?php echo trim($_sval)?></option>
															<?php endforeach?>
														</select>
														<?php endif?>

														<!-- input=radio -->
														<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
													<?php foreach($_skey as $_sval):?>
													<div class="custom-control custom-radio custom-control-inline">
													  <input type="radio" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>" class="custom-control-input">
													  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
													</div>
													<?php endforeach?>
														<?php endif?>

													<!-- input=checkbox -->
													<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
													<?php foreach($_skey as $_sval):?>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>">
														<label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
													</div>
													<?php endforeach?>
													<?php endif?>

														<!-- textarea -->
														<?php if($_val[2]=='textarea'):?>
														<textarea id="<?php echo $_val[0]?>" name="add_<?php echo $_val[0]?>" rows="5" class="form-control"><?php echo $_val[3]?></textarea>
														<?php endif?>

												 </div> <!-- .col-sm-8 -->
												</div> <!-- .form-group -->
												<?php endforeach?>


	 						<p class="text-muted small">
	 						* 숨김처리한 것은 실제 가입폼에서는 안보입니다.
	 						</p>
	 					 </div>  <!-- #preview -->
						</div><!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-3"><i class="fa fa-check"></i> 정보저장</button>
						</div><!-- /.card-footer -->
					</div><!-- /.card -->

				</div>
				 <!-- /가입항목 추가 -->

				 <!-- 약관/안내메시지 -->
				<div class="tab-pane fade<?php if($_SESSION['member_config_nav']=='terms'):?> show active<?php endif?>" id="terms">

					<div class="card rounded-0 mb-0">
						<div class="card-header">
							약관/안내 메시지
						</div>
						<div class="card-body">

							<div class="form-group row">
								<label class="col-lg-2 col-form-label">개인정보취급방침</label>
								<div class="col-lg-10 col-xl-9">
									<div class="input-group">
										<select name="join_joint_privacy" class="form-control custom-select" >
											<option value="">연결시킬 페이지를 선택해 주세요.</option>
											<option value="" disabled>--------------------------------</option>
											<?php getPageSelect($s,0,0,$d['member']['join_joint_privacy']) ?>
										</select>
									  <div class="input-group-append">
									    <a href="<?php echo $g['s'].'/index.php?r='.$r.'&mod='.$d['member']['join_joint_privacy'] ?>" class="btn btn-light" data-tooltip="tooltip" title="새창" target="_blank">접속</a>
									  </div>
									</div><!-- /.input-group -->
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 col-form-label">이용약관</label>
								<div class="col-lg-10 col-xl-9">
									<div class="input-group">
										<select name="join_joint_policy" class="form-control custom-select" >
											<option value="">연결시킬 페이지를 선택해 주세요.</option>
											<option value="" disabled>--------------------------------</option>
											<?php getPageSelect($s,0,0,$d['member']['join_joint_policy']) ?>
										</select>
									  <div class="input-group-append">
									    <a href="<?php echo $g['s'].'/index.php?r='.$r.'&mod='.$d['member']['join_joint_policy'] ?>" class="btn btn-light" data-tooltip="tooltip" title="새창" target="_blank">접속</a>
									  </div>
									</div><!-- /.input-group -->
								</div>
							</div>



						</div><!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-3"><i class="fa fa-check"></i> 정보저장</button>
						</div>
					</div><!-- /.card -->

				</div>
				<!-- 약관/안내메시지 -->



			<!-- 로그인 설정 -->
		 	<div class="tab-pane fade<?php if($_SESSION['member_config_nav']=='login-config'):?> show active<?php endif?>" id="login-config">

				 <div class="card rounded-0 mb-0">
					 <div class="card-header">
						 로그인 설정
					 </div>
					 <div class="card-body">

						 <div class="card">
							 <div class="card-header">
								 기본 옵션
							 </div>
							 <div class="card-body">


								 <div class="custom-control custom-checkbox custom-control-inline">
									 <input type="checkbox" class="custom-control-input" id="login_emailid" name="login_emailid" value="1"<?php if($d['member']['login_emailid']):?> checked="checked"<?php endif?>>
									 <label class="custom-control-label" for="login_emailid">이메일 또는 휴대폰 번호로 로그인 사용</label>
								 </div>

								 <div class="custom-control custom-checkbox custom-control-inline">
									 <input type="checkbox" class="custom-control-input" id="login_social" name="login_social" value="1"<?php if($d['member']['login_social']):?> checked="checked"<?php endif?>>
									 <label class="custom-control-label" for="login_social">소셜미디어 계정으로 로그인 사용</label>
								 </div>


							 </div>
							 <div class="card-footer small text-muted">
								 소셜 로그인을 사용하기 위해서는 <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=connect">연결설정</a>이 필요합니다.
							 </div>

						 </div><!-- /.card -->

						 <div class="card">
							 <div class="card-header">
								 로그인 상태 유지
							 </div>
							 <div class="card-body">

								 <div class="row align-items-center">
									 <div class="col">
										 <div class="custom-control custom-checkbox custom-control-inline mb-0">
											 <input type="checkbox" class="custom-control-input" id="login_cookie" name="login_cookie" value="1" <?php if($d['member']['login_cookie']):?> checked="checked"<?php endif?>>
											 <label class="custom-control-label" for="login_cookie">로그인 상태 유지 기능 사용</label>
										 </div>
									 </div><!-- /.col -->
									 <div class="col">
										 <div class="input-group w-50">
	 										<div class="input-group-prepend">
	 											<span class="input-group-text">유지기간</span>
	 										</div>
	 										<input type="text" name="login_expire" value="<?php echo $d['member']['login_expire']?>" size="5" class="form-control text-center">
	 										 <div class="input-group-append">
	 											 <span class="input-group-text">일</span>
	 										 </div>
	 									</div>
									 </div><!-- /.col -->
								 </div><!-- /.row -->

							 </div>
							 <div class="card-footer small text-muted">
								 매번 로그인할 필요 없이 편리하게 서비스를 이용할 수 있는 기능입니다. 해당 옵션을 선택하고 로그인하시면, 브라우저의 쿠키를 삭제하거나 직접 로그아웃을 선택하기 전까지는 지정된 유지기간 동안 로그인 상태가 유지됩니다.
							 </div>
						 </div><!-- /.card -->

					 </div><!-- /.card-body -->
					 <div class="card-footer">
						 <button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4"><i class="fa fa-check"></i> 정보저장</button>
					 </div>
				 </div><!-- /.card -->

			 </div>
			<!-- /로그인 설정 -->


			<!-- 개인정보관리 설정 -->
		 	<div class="tab-pane fade<?php if($_SESSION['member_config_nav']=='settings-config'):?> show active<?php endif?>" id="settings-config">

			 <div class="card rounded-0 mb-0">
				 <div class="card-header">
					 개인정보관리 설정
				 </div>
				 <div class="card-body">

					 <div class="card">
					 	<div class="card-header">
					 		노출항목 및 옵션 <code>settings</code>
					 	</div>
					 	<div class="card-body">
					 		<div class="row">
					 			<div class="col-sm-6">
					 				<?php $opset2 = array('name'=>'이름','nic'=>'닉네임','email_profile'=>'공개 이메일','avatar'=>'아바타','birth'=>'생년월일','sex'=>'성별')?>
					 				<?php $i=0;foreach($opset2 as $_key => $_val):?>
					 				 <fieldset <?php echo $i<1?'disabled':''?>>
					 				 <?php if($i<1):?>
					 				<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 100px">
					 					<input type="checkbox" class="custom-control-input" id="customCheck1" checked>
					 					<label class="custom-control-label" for="customCheck1"><?php echo $_val?></label>
					 				</div>
					 				 <i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
					 				 <div class="custom-control custom-checkbox custom-control-inline" style="min-width: 100px">
					 						<input type="checkbox" class="custom-control-input" id="customCheck2" checked>
					 						<label class="custom-control-label" for="customCheck2">필수입력</label>
					 					 </div>

					 				 <?php else:?>
					 					 <div class="custom-control custom-checkbox custom-control-inline" style="min-width: 100px">
					 						<input type="checkbox" class="custom-control-input" id="form_settings_<?php echo $_key?>" name="form_settings_<?php echo $_key?>" value="1"<?php if($d['member']['form_settings_'.$_key]):?> checked<?php endif?>>
					 						<label class="custom-control-label" for="form_settings_<?php echo $_key?>"><?php echo $_val?></label>
					 					 </div>
					 					 <i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>
					 					 <div class="custom-control custom-checkbox custom-control-inline" style="min-width: 100px">
					 						<input type="checkbox" class="custom-control-input" id="form_settings_<?php echo $_key?>_required" name="form_settings_<?php echo $_key?>_required" value="1"<?php if($d['member']['form_settings_'.$_key.'_required']):?> checked<?php endif?>>
					 						<label class="custom-control-label" for="form_settings_<?php echo $_key?>_required">필수입력</label>
					 					 </div>

					 				 <?php endif?>
					 					</fieldset>
					 			 <?php $i++;endforeach?>
					 			</div>
					 			<div class="col-sm-6">
					 				<?php $opset2 = array('bio'=>'간단소개','home'=>'홈페이지','tel'=>'일반전화','location'=>'거주지역','job'=>'직업','marr'=>'결혼기념일','add'=>'추가항목')?>
					 				<?php foreach($opset2 as $_key => $_val):?>
					 				<fieldset>

					 					<div class="custom-control custom-checkbox custom-control-inline" style="min-width: 100px">
					 						<input type="checkbox" class="custom-control-input" id="form_settings_<?php echo $_key?>" name="form_settings_<?php echo $_key?>" value="1"<?php if($d['member']['form_settings_'.$_key]):?> checked<?php endif?>>
					 						<label class="custom-control-label" for="form_settings_<?php echo $_key?>"><?php echo $_val?></label>
					 					 </div>

					 				 <i class="fa fa-long-arrow-right fa-lg text-muted pr-3"></i>

					 				 <div class="custom-control custom-checkbox custom-control-inline">
					 					<input type="checkbox" class="custom-control-input" id="form_settings_<?php echo $_key?>_required" name="form_settings_<?php echo $_key?>_required" value="1"<?php if($d['member']['form_settings_'.$_key.'_required']):?> checked<?php endif?>>
					 					<label class="custom-control-label" for="form_settings_<?php echo $_key?>_required">필수입력</label>
					 				 </div>

					 				</fieldset>
					 				<?php endforeach?>
					 			</div>
					 		</div>
					 	</div>
					 </div>

					 <div class="card">
						 <div class="card-header">
							 <i class="fa fa-lock fa-fw" aria-hidden="true"></i>  개인정보보호
						 </div>
						 <div class="card-body">

							 <div class="input-group w-50">
								 <div class="input-group-prepend">
									 <span class="input-group-text">개인정보 관리 잠금</span>
								 </div>
								 <input type="text" name="settings_expire" value="<?php echo $d['member']['settings_expire']?>" size="5" class="form-control text-center">
									<div class="input-group-append">
										<span class="input-group-text">분</span>
									</div>
							 </div>
							 <small class="form-text text-muted">로그인 후, <?php echo $d['member']['settings_expire']?>분이 경과하면 개인정보관리 페이지에서 본인 재인증 화면이 출력됩니다. </small>


							</div><!-- /.card-body -->
						</div><!-- /.card -->

						<div class="card">
 						 <div class="card-header">
 							 <i class="fa fa-user-circle-o fa-fw" aria-hidden="true"></i> 이메일 및 휴대폰 본인인증
 						 </div>
 						 <div class="card-body">

 							 <div class="input-group w-50">
 								 <div class="input-group-prepend">
 									 <span class="input-group-text"><i class="fa fa-hourglass-end fa-fw" aria-hidden="true"></i> 인증번호 유효시간</span>
 								 </div>
 								 <input type="text" name="settings_keyexpire" value="<?php echo $d['member']['settings_keyexpire']?>" size="5" class="form-control text-center">
 									<div class="input-group-append">
 										<span class="input-group-text">분</span>
 									</div>
 							 </div>
 							 <small class="form-text text-muted">이메일 및 휴대폰에 대한 본인인증 시, 인증코드의 유효시간을 설정합니다. </small>

 							</div><!-- /.card-body -->
 						</div><!-- /.card -->


						<div class="row mt-5">
							<div class="col">
								<div class="form-group">
									<label class="d-flex justify-content-between">
										거주지역 <span class="badge badge-pill badge-dark">사이트 공통</span>
									</label>
									<textarea name="location" class="form-control f13" rows="5"><?php readfile($_tmplfile)?></textarea>
								</div>
							</div><!-- /.col -->
							<div class="col">
								<div class="form-group">
									<label class="d-flex justify-content-between">
										직업군 <span class="badge badge-pill badge-dark">사이트 공통</span>
									</label>
									<textarea name="job" class="form-control f13" rows="5"><?php readfile($_tmpjfile)?></textarea>
								</div>
							</div><!-- /.col -->
						</div><!-- /.row -->

				 </div><!-- /.card-body -->
				 <div class="card-footer">
					 <button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4"><i class="fa fa-check"></i> 정보저장</button>
				 </div>
			 </div><!-- /.card -->

		 </div>


		</div>


	</div>

</form><!-- /.row -->


<script type="text/javascript">

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

putCookieAlert('member_config_result') // 실행결과 알림 메시지 출력

function addField(f)
{
	if (f.add_name.value == '')
	{
		alert('명칭을 입력해 주세요.  ');
		f.add_name.focus();
		return false;
	}
	saveCheck(f);
}
function delField(f,dval)
{
	if (confirm('정말로 삭제하시겠습니까?   '))
	{
		var l = document.getElementsByName('addFieldMembers[]');
		var n = l.length;
		var i;

		for (i = 0; i < n; i++)
		{
			if (dval == l[i].value)
			{
				l[i].checked = false;
			}
		}
		saveCheck(f);
	}
}

// 우측 메뉴 클릭시 이베트 _join_menu 값을 변경한다.
$('.list-group-item-action').on('click',function(){
	 var href=$(this).attr('href');
	 var _join_menu=href.replace('#','');
	 $('input[name="_join_menu"]').val(_join_menu);
	 console.log('11')
});

function saveCheck(f)
{

	if (f.theme_main.value == '')
	{
		alert('대표테마를 선택해 주세요.       ');
		f.theme_main.focus();
		return false;
	}

	f.a.value='member_config';
	getIframeForAction(f);
	f.submit();
}

</script>
