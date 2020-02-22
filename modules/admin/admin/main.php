<?php include $g['path_module'].$module.'/var/var.version.php'; ?>

<div id="configbox" class="row no-gutters">

	<div class="col-sm-3 col-md-3 col-xl-3 d-none d-sm-block sidebar">
		<div class="card border-0">
			<div class="card-header">
				<small class="text-muted">항목</small>
			</div>
			<div class="list-group list-group-flush" id="list-tab" role="tablist">
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if(!$_SESSION['admin_config_nav'] || $_SESSION['post_config_nav']=='basic'):?> active<?php endif?>" data-toggle="list" href="#basic" role="tab" onclick="sessionSetting('post_config_nav','basic','','');" aria-selected="false">
					시스템 환경
				</a>
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['admin_config_nav']=='theme'):?> active<?php endif?>" data-toggle="list" href="#theme" role="tab" onclick="sessionSetting('post_config_nav','theme','','');" aria-selected="true">
					시스템 테마 및 고급기능
				</a>
				<a class="list-group-item d-flex justify-content-between align-items-center list-group-item-action<?php if($_SESSION['admin_config_nav']=='email'):?> active<?php endif?>" data-toggle="list" href="#email" role="tab" onclick="sessionSetting('post_config_nav','email','','');" aria-selected="true">
					이메일 양식
				</a>
			</div>
		</div>
	</div><!-- /.sidebar -->

	<div class="col-sm-9 col-md-9 ml-sm-auto col-xl-9">

		<div class="tab-content pb-5">

			<div class="tab-pane <?php if(!$_SESSION['admin_config_nav'] || $_SESSION['admin_config_nav']=='basic'):?> show active<?php endif?>" id="basic">

				<div class="card mb-0 border-0 rounded-0 border-bottom-0">
					<div class="card-header">
						시스템 환경
					</div>
					<div class="card-body">

						<div class="row">

							<div class="col-sm-6 mt-4">
								<span class=" kf-bi-01" style="font-size: 38px"> </span> <span class="h3 ml-2">Rb <code><?php echo $d['admin']['version']?></code></span>
							</div>

							<div class="col-sm-6">
								<dl class="form-row mt-4 mb-0">

									<dt class="col-sm-2">PHP</dt>
									<dd class="col-sm-9"><?php echo phpversion()?></dd>

									<dt class="col-sm-2">MySQL</dt>
									<dd class="col-sm-9"><?php echo db_info()?> (<?php echo $DB['type']?>)</dd>

								</dl>
							</div>
						</div>

					</div><!-- /.card-body -->
				</div><!-- /.card -->

				<form role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="config">
					<input type="hidden" name="act" value="config">
					<input type="hidden" name="autosave" value="">
					<input type="hidden" name="email" value="<?php echo $d['admin']['email']?>">
					<input type="hidden" name="smtp" value="<?php echo $d['admin']['email']?>">
					<input type="hidden" name="ftp" value="<?php echo $d['admin']['ftp']?>">
					<input type="hidden" name="type" value="">
					<input type="hidden" name="chk_email" value="">
					<input type="hidden" name="chk_sms" value="">


					<div class="card border-left-0 rounded-0 border-bottom-0">
						<div class="card-header">
							시스템 기본 메일
						</div>
						<div class="card-body">

							<div class="tab-content pt-3">
								<div id="mail-sendmail" class="tab-pane <?php if(!$d['admin']['smtp_use']):?> active<?php endif?>">

									<div class="form-group mb-0">
										<label class="sr-only">시스템 기본 메일</label>
										<div class="input-group">
											<input type="email" name="sysmail" value="<?php echo $d['admin']['sysmail']?$d['admin']['sysmail']:$my['email']?>" class="form-control">
											<span class="input-group-append">
												<button class="btn btn-light" type="button" id="sendmailbtn" onclick="sendCheck(this.id);">
													<?php if($d['admin']['email']):?>발송 테스트<?php else:?>이메일 전송확인<?php endif?>
												</button>
											</span>
										</div>
										<small class="form-text text-muted">입력한 이메일 주소로 전송이 되면 메일서버가 정상작동되는 상태입니다.</small>
									</div>

								</div>

								<div id="mail-smtp" class="tab-pane<?php if($d['admin']['smtp_use']=='1'):?> active<?php endif?>">

									<div class="form-row">
										<div class="form-group col-sm-4">
											<label>SMTP Server</label>
											<input class="form-control" type="text" name="smtp_host" value="<?php echo $d['admin']['smtp_host']?>" placeholder="예) smtp.mail.com">
										</div>
										<div class="form-group col-sm-2">
											<label>SMTP Port</label>
											<input type="text" class="form-control" name="smtp_port" value="<?php echo $d['admin']['smtp_port']?$d['admin']['smtp_port']:465?>" placeholder="">
										</div>
										<div class="form-group col-sm-6 pt-5">
											<label class="mr-3">
												<input type="checkbox" name="smtp_auth" value="1"<?php if($d['admin']['smtp_auth']):?> checked<?php endif?>><i></i> SMTP 인증 필요
											</label>
											<label><input type="radio" name="smtp_ssl" value=""<?php if(!$d['admin']['smtp_ssl']):?> checked<?php endif?>> 일반</label>
											<label><input type="radio" name="smtp_ssl" value="SSL"<?php if($d['admin']['smtp_ssl']=='SSL'):?> checked<?php endif?>> SSL</label>
											<label><input type="radio" name="smtp_ssl" value="TLS"<?php if($d['admin']['smtp_ssl']=='TLS'):?> checked<?php endif?>> TLS</label>
										</div>
									</div><!-- /.form-row -->

									<div class="form-row">
										<div class="form-group col-sm-6">
											<label>인증 아이디</label>
											<input type="text" class="form-control" name="smtp_user" value="<?php echo $d['admin']['smtp_user']?>" placeholder="인증 아이디">
										</div>
										<div class="form-group col-sm-6">
											<label>인증 암호</label>
											<input type="password" class="form-control" name="smtp_pass" value="<?php echo $d['admin']['smtp_pass']?>" placeholder="인증 암호">
										</div>
									</div>

									<button type="button" class="btn btn-light" id="smtpbtn" onclick="sendCheck(this.id);"><?php if($d['admin']['smtp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i>정상<?php else:?>SMTP 연결확인<?php endif?></button>
									<p class="form-control-static"><small class="text-muted">시스템 대표메일로 전송이 되면 메일서버가 정상 작동되는 상태입니다.</small></p>

								</div>
							</div>

						</div><!-- /.card-body -->
					</div><!-- /.card -->

					<div class="card border-left-0 rounded-0 border-bottom-0">
						<div class="card-header">
							FCM <span class="badge badge-dark ml-1">무료</span>
						</div>
						<div class="card-body">
								<input class="form-control" type="hidden" name="fcm_app_js_src" value="https://www.gstatic.com/firebasejs/5.2.0/firebase-app.js">
								<input class="form-control" type="hidden" name="fcm_messaging_js_src" value="https://www.gstatic.com/firebasejs/5.2.0/firebase-messaging.js">
								<input class="form-control" type="hidden" name="fcm_icon" value="/_core/images/touch/homescreen-192x192.png">

							<div class="form-group row">
								<label class="col-lg-2 col-form-label">콘솔</label>
								<div class="col-lg-10 col-xl-9 pt-2">
									<a href="https://console.firebase.google.com" target="_blank">https://console.firebase.google.com</a>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">서버 키</label>
								<div class="col-lg-10 col-xl-9">
									<textarea class="form-control f13	" name="fcm_key" rows="2"><?php echo $d['admin']['fcm_key'] ?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">발신자 ID</label>
								<div class="col-lg-10 col-xl-9">
									<input class="form-control" type="text" name="fcm_SenderId" value="<?php echo $d['admin']['fcm_SenderId'] ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">웹 푸시 인증서</label>
								<div class="col-lg-10 col-xl-9">
									<input class="form-control" type="text" name="fcm_VAPID" value="<?php echo $d['admin']['fcm_VAPID'] ?>">
									<small class="form-text text-muted">키 쌍을 입력하세요.</small>
								</div>
							</div>
						</div><!-- /.card-body -->
						<div class="card-footer">
							<small class="form-text text-muted">
								FCM (Firebase Cloud Messaging)은 클라우드에서 기기로 푸시하는 메시징 서비스로 Google 클라우드 메시징 서비스 입니다.<br>
								사용제한 없이 무료로 이용할 수 있습니다.
								자세한 내용은 <a href="https://firebase.google.com/docs/cloud-messaging/?hl=ko" target="_blank">여기</a>를 참조해주세요.
							</small>
						</div>
					</div><!-- /.card -->

					<div class="card border-left-0 rounded-0 border-bottom-0">
						<div class="card-header">
							SMS  <span class="badge badge-light ml-1">유료</span>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">SMS 발신번호</label>
								<div class="col-lg-10 col-xl-9">
									<input class="form-control" type="text" name="sms_tel" value="<?php echo $d['admin']['sms_tel'] ?>" placeholder="SMS 발신번호 등록 후 입력해주세요.">
									<small class="form-text text-muted">발신번호등록이 완료된 번호에서만 SMS 발신이 가능합니다. 자세한 내용은 <a href="https://kimsq.com/blog/post/25" target="_blank">여기</a>를 참고해 주세요.</small>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">SMS 계정번호</label>
								<div class="col-lg-10 col-xl-9">
									<input class="form-control" type="text" name="sms_id" value="<?php echo $d['admin']['sms_id'] ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">SMS 계정 인증키</label>
								<div class="col-lg-10 col-xl-9">
									<input class="form-control" type="text" name="sms_key" value="<?php echo $d['admin']['sms_key'] ?>">
								</div>
							</div>
							<hr>

							<div class="form-group row">
								<label class="col-lg-2 col-form-label pt-3">발송 테스트</label>
								<div class="col-lg-10 col-xl-9">

									<div class="input-group">
										<input type="tel" name="testsms" value="<?php echo $my['phone']?>" class="form-control" placeholder="휴대폰 번호">
										<span class="input-group-append">
											<button class="btn btn-light" type="button" id="sendsmsbtn" onclick="sendCheck(this.id);">
												<?php if($d['admin']['sms']):?>발송하기<?php else:?>SMS 전송확인<?php endif?>
											</button>
										</span>
									</div>
									<small class="form-text text-muted">입력한 휴대폰 번호로 테스트 메시지가 수신되는지 확인해 보세요.</small>
								</div>
							</div>

						</div><!-- /.card-body -->
						<div class="card-footer">
							<small class="form-text text-muted">
								SMS(핸드폰 문자메시지) 유료서비스 이며, 킴스큐 프로젝트 콘솔에서 충전할 수 있습니다. 자세한 내용은 <a href="#" target="_blank">여기</a>를 참조해주세요.
							</small>
						</div>
					</div><!-- /.card -->

					<div class="card border-left-0 rounded-0 border-bottom-0">
						<div class="card-header">
							사이트 코드 제한
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>사용제한 사이트 코드</label>
								<textarea class="form-control" name="site_cutid" rows="4"><?php echo $d['admin']['site_cutid']?></textarea>
								<small class="form-text text-muted">사용을 제한하려는 아이디를 콤마(,)로 구분해서 입력해 주세요.</small>
							</div>
						</div>
					</div><!-- /.card -->

					<div class="card border-left-0 rounded-0">
						<div class="card-header">
							FTP
						</div>
						<div class="card-body">

							<div class="btn-group btn-group-toggle nav" data-toggle="buttons">
								<label class="btn btn-light<?php if(!$d['admin']['ftp_use']):?> active<?php endif?>" data-toggle="pill" data-target="#ftp-nobody">
									<input type="radio" name="ftp_use" value=""<?php if(!$d['admin']['ftp_use']):?> checked<?php endif?>> Nobody
								</label>
								<label class="btn btn-light<?php if($d['admin']['ftp_use']=='1'):?> active<?php endif?>" data-toggle="pill" data-target="#ftp-user">
									<input type="radio" name="ftp_use" value="1"<?php if($d['admin']['ftp_use']=='1'):?> checked<?php endif?>> User
								</label>
							</div>

							<div class="tab-content mt-3">
								<div id="ftp-nobody" class="tab-pane clearfix<?php if(!$d['admin']['ftp_use']):?> active<?php endif?>">

									<p>일부기능에 제한이 있거나 보안에 취약할 수 있습니다.</p>

								</div>
								<div id="ftp-user" class="tab-pane clearfix<?php if($d['admin']['ftp_use']=='1'):?> active<?php endif?>">

									<div class="form-group">
										<label>FTP Type</label>
										<select name="ftp_type" class="form-control" onchange="ftp_select(this);">
											<option value=""<?php if(!$d['admin']['ftp_type']):?> selected<?php endif?>>FTP</option>
											<option value="sftp"<?php if($d['admin']['ftp_type']=='sftp'):?> selected<?php endif?>>SFTP</option>
										</select>
									</div>

									<div class="form-group">
										<label>FTP Server</label>
										<input type="text" class="form-control" name="ftp_host" value="<?php echo $d['admin']['ftp_host']?>" placeholder="예) example.kimsq.com  또는 IP adress 입력">
									</div>

									<div class="form-group">
										<label>FTP Port</label>
										<input type="text" class="form-control" name="ftp_port" value="<?php echo $d['admin']['ftp_port']?$d['admin']['ftp_port']:'21'?>" placeholder="">
									</div>

									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="ftp_pasv" value="1"<?php if($d['admin']['ftp_pasv']):?> checked<?php endif?>> <i></i>Passive Mode
											</label>
										</div>
									</div>

									<div class="form-group">
										<label>FTP ID</label>
										<input type="text" class="form-control" name="ftp_user" value="<?php echo $d['admin']['ftp_user']?>" placeholder="FTP ID">
									</div>

									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="ftp_pass" value="<?php echo $d['admin']['ftp_pass']?>" placeholder="Password">
									</div>

									<div class="form-group">
										<label>Rb 경로</label>
										<input type="text" class="form-control" name="ftp_rb" value="<?php echo $d['admin']['ftp_rb']?>" placeholder="">
										<p class="form-control-static">
											<small class="text-muted">
												FTP로 접속했을때 처음 접속된 경로부터 킴스큐Rb가 설치된 경로를 입력해 주세요.
												경로의 처음과 마지막은 반드시 슬래쉬(/)로 끝나야 합니다. <br>
												보기)<code>/rb/</code> 또는 <code>/www/rb/</code> 또는 <code>/public_html/rb/</code><br>
											</small>
										</p>
									</div>

									<button type="button" class="btn btn-light" id="ftpbtn" onclick="sendCheck(this.id);">
										<?php if($d['admin']['ftp']):?><i class="fa fa-info-circle fa-lg fa-fw"></i>정상<?php else:?>FTP 연결확인<?php endif?>
									</button>

								</div>
							</div>

						</div>
					</div><!-- /.card -->

					<div class="px-3">
						<button class="mt-3 btn btn-primary btn-block btn-lg" type="submit">설정 저장하기</button>
					</div>

				</form>

			</div><!-- /.tab-pane -->

			<div class="tab-pane <?php if($_SESSION['admin_config_nav']=='theme'):?> show active<?php endif?>" id="theme">

				<form role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="a" value="config">
					<input type="hidden" name="act" value="config">
					<input type="hidden" name="autosave" value="">
					<input type="hidden" name="email" value="<?php echo $d['admin']['email']?>">
					<input type="hidden" name="smtp" value="<?php echo $d['admin']['email']?>">
					<input type="hidden" name="ftp" value="<?php echo $d['admin']['ftp']?>">
					<input type="hidden" name="type" value="">
					<input type="hidden" name="chk_email" value="">
					<input type="hidden" name="chk_sms" value="">

					<div class="card border-left-0 rounded-0 border-bottom-0 border-top-0">
						<div class="card-header">
							시스템 테마 및 고급기능
						</div>
						<div class="card-body">

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>관리자 테마</label>
										<select name="themepc" class="form-control custom-select">
											<?php $dirs = opendir($g['dir_module'].'theme')?>
											<?php while(false !== ($tpl = readdir($dirs))):?>
											<?php if($tpl=='.' || $tpl == '..')continue?>
											<option value="<?php echo $tpl?>"<?php if($d['admin']['themepc']==$tpl):?> selected<?php endif?>><?php echo $tpl?></option>
											<?php endwhile?>
											<?php closedir($dirs)?>
										</select>
									</div>

									<div class="form-group">
										<label>관리패널 테마</label>
										<select name="pannellink" class="form-control custom-select">
											<?php $dirs = opendir($g['path_core'].'engine/adminpanel/theme')?>
											<?php while(false !== ($tpl = readdir($dirs))):?>
											<?php if($tpl=='.' || $tpl == '..')continue?>
											<option value="<?php echo $tpl?>"<?php if($d['admin']['pannellink']==$tpl):?> selected<?php endif?>><?php echo str_replace('.css','',$tpl)?></option>
											<?php endwhile?>
											<?php closedir($dirs)?>
										</select>
									</div>

									<div class="form-group">
										<label>CSS/JS 캐시</label>
										<select name="cache_flag" class="form-control custom-select">
											<option value=""<?php if($d['admin']['cache_flag']==''):?> selected<?php endif?>>브라우저 설정을 따름</option>
											<option value="totime"<?php if($d['admin']['cache_flag']=='totime'):?> selected<?php endif?>>접속시마다 갱신</option>
											<option value="nhour"<?php if($d['admin']['cache_flag']=='nhour'):?> selected<?php endif?>>한시간 단위로 갱신</option>
											<option value="today"<?php if($d['admin']['cache_flag']=='today'):?> selected<?php endif?>>하루 단위로 갱신</option>
											<option value="month"<?php if($d['admin']['cache_flag']=='month'):?> selected<?php endif?>>한달 단위로 갱신</option>
											<option value="year"<?php if($d['admin']['cache_flag']=='year'):?> selected<?php endif?>>일년 단위로 갱신</option>
										</select>
										<small class="form-text text-muted">CSS 나 자바스크립트 파일을 수정했을 경우에는 일정기간 접속시마다 갱신되도록 설정해 주세요.</small>
									</div>

									<div class="form-group">
										<label>제거(Uninstall)</label>
										<select name="uninstall" class="form-control custom-select">
											<option value=""<?php if(!$d['admin']['uninstall']):?> selected<?php endif?>>출력하지 않음</option>
											<option value="1"<?php if($d['admin']['uninstall']):?> selected<?php endif?>>출력함</option>
										</select>
										<small class="form-text text-muted">
											킴스큐는 전체 파일 및 DB 데이터를 일괄 삭제(Uninstall)할 수 있는 도구를 제공합니다. 그러나 매우 유의해야 하는 작업이므로 반드시 필요한 경우에만 출력하여 사용하세요.
										</small>
									</div>

									<div class="form-group">
										<label>더블클릭 전환</label>
										<select name="dblclick" class="form-control custom-select">
											<option value="1"<?php if($d['admin']['dblclick']):?> selected<?php endif?>>사용함</option>
											<option value=""<?php if(!$d['admin']['dblclick']):?> selected<?php endif?>>사용안함</option>
										</select>
										<small class="form-text text-muted">
											메뉴,페이지,모듈등의 페이지에서 화면 더블클릭시 관련 콘텍스트 메뉴를 이용해 화면을 전환할 수 있습니다.
										</small>
									</div>
								</div><!-- /.col -->
								<div class="col-sm-6">

									<div class="form-group">
										<label>소스코드 에디터</label>
										<select name="codeeidt" class="form-control custom-select">
											<option value="">TEXTAREA</option>
											<?php $dirs = opendir($g['path_plugin'].'codemirror/'.$d['ov']['codemirror'].'/theme')?>
											<?php while(false !== ($tpl = readdir($dirs))):?>
											<?php if(substr($tpl,-4)!='.css')continue?>
											<?php $_codeedit=str_replace('.css','',$tpl)?>
											<option value="<?php echo $_codeedit?>"<?php if($d['admin']['codeeidt']==$_codeedit):?> selected<?php endif?>><?php echo ucfirst($_codeedit)?></option>
											<?php endwhile?>
											<?php closedir($dirs)?>
										</select>
										<small class="form-text text-muted">
											소스코드 편집시 사용할 에디터 테마를 선택해 주세요. <a href="http://codemirror.net/demo/theme.html" target="_blank">테마보기</a>
										</small>
									</div>

									<div class="form-group">
										<label>시스템 에디터</label>
										<select name="editor" class="form-control custom-select">
											<?php $dirs = opendir($g['path_plugin'])?>
											<?php while(false !== ($tpl = readdir($dirs))):?>
											<?php if(!is_file($g['path_plugin'].$tpl.'/import.system.php'))continue?>
											<option value="<?php echo $tpl?>"<?php if($d['admin']['editor']==$tpl):?> selected<?php endif?>><?php echo $tpl?></option>
											<?php endwhile?>
											<?php closedir($dirs)?>
										</select>
										<small class="form-text text-muted">
											시스템 에디터는 플러그인 폴더(%s)에 추가될 수 있습니다. 에디터를 변경하시려면 플러그인에 추가 후 버젼선택 후에 변경해 주세요.
										</small>
									</div>

									<div class="form-group">
										<label>시작모듈</label>
										<select name="sysmodule" class="form-control custom-select">
											<?php $MODULESRCD=getDbArray($table['s_module'],"system=0 or id='site'",'*','gid','asc',0,1)?>
											<?php while($_MDR=db_fetch_array($MODULESRCD)):?>
											<option value="<?php echo $_MDR['id']?>"<?php if($d['admin']['sysmodule']==$_MDR['id']):?> selected<?php endif?>><?php echo $_MDR['name']?>(<?php echo $_MDR['id']?>)</option>
											<?php endwhile?>
										</select>
										<small class="form-text text-muted">
											킴스큐를 구동시키는 기본 모듈이며 모듈을 지정하지 않고 호출시 이 모듈이 기본모듈로서 구동됩니다. 이 설정은 특별한 경우가 아니면 변경하지 마십시오.
										</small>
									</div>

									<div class="form-group">
										<label>시스템 언어</label>
										<select name="syslang" class="form-control custom-select">
											<option value="DEFAULT" selected="">한국어</option>
										</select>
										<small class="form-text text-muted">
											이 설정을 이용해서 킴스큐 전체의 언어를 제어합니다. 개별 사이트나 모듈에서도 사용할 언어를 지정할 수 있습니다.
										</small>
									</div>


								</div><!-- /.col -->
							</div><!-- /.row -->

						</div><!-- /.card-body -->
					</div><!-- /.card -->

					<div class="px-3">
						<button class="mt-3 btn btn-primary btn-block btn-lg" type="submit">설정 저장하기</button>
					</div>

				</form>

			</div><!-- /.tab-pane -->

			<div class="tab-pane <?php if($_SESSION['admin_config_nav']=='email'):?> show active<?php endif?>" id="email">

				<div class="card border-left-0 rounded-0 border-bottom-0 border-top-0" id="emailTemplate">
					<div class="card-header">
						<div class="d-flex justify-content-between pt-2 pb-3 border-bottom">
							<span>
								<i class="fa fa-envelope-o fa-fw"></i> 이메일 양식
							</span>
							<span class="badge badge-pill badge-dark">시스템 공통</span>
						</div>

						<ul class="nav nav-tabs card-header-tabs" role="tablist" style="margin-left:-18px">
						 <li class="nav-item">
							 <a class="nav-link active py-3" id="email-code-tab" data-toggle="tab" href="#email-code" role="tab" aria-controls="home" aria-selected="true">
								 <i class="fa fa-code fa-fw" aria-hidden="true"></i>
								 소스코드
							 </a>
						 </li>
						 <li class="nav-item">
							 <a class="nav-link py-3" id="email-preview-tab" data-toggle="tab" href="#email-preview" role="tab" aria-controls="profile" aria-selected="false">
								 <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
								 미리보기
							 </a>
						 </li>
					 </ul>
					</div><!-- /.card-header -->

					<div class="card-body tab-content">
						<?php
						$_email_header = $g['path_module'].$module.'/var/email.header.txt';
						$_email_footer = $g['path_module'].$module.'/var/email.footer.txt';
						$email_header = implode('',file($g['path_module'].$module.'/var/email.header.txt'));  //이메일 헤더 양식
						$email_footer = implode('',file($g['path_module'].$module.'/var/email.footer.txt')); // //이메일 풋터 양식
						?>

						<div class="tab-pane fade show active" id="email-code" role="tabpanel">
							<ul class="pl-3 small text-muted">
								<li>시스템에서 발송되는 메일에 공통 적용되는 이메일 양식 입니다.</li>
								<li>양식에는 다음과 같은 치환문자를 사용할 수 있습니다.</li>
								<li>사이트명 : <code>{SITE}</code> / 대표이메일 : <code>{EMAIL_MAIN}</code> / 대표전화 : <code>{TEL_MAIN}</code></li>
							</ul>
							<form role="form" name="procForm2" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
								<input type="hidden" name="r" value="<?php echo $r?>">
								<input type="hidden" name="m" value="<?php echo $module?>">
								<input type="hidden" name="a" value="email_layout">

								<div class="form-group">
									<label class="d-flex justify-content-between">헤더  <span class="badge badge-pill badge-dark"><?php echo $_email_header ?></span></label>
									<textarea class="form-control f13" id="code_header" name="email_header" rows="18"><?php readfile($_email_header)?></textarea>
								</div>
								<hr>
								<div class="form-group">
									<label class="d-flex justify-content-between">풋터  <span class="badge badge-pill badge-dark"><?php echo $_email_footer ?></span></label>
									<textarea class="form-control f13" id="code_footer" name="email_footer" rows="18"><?php readfile($_email_footer)?></textarea>
								</div>
								<button class="mt-3 btn btn-outline-primary btn-block btn-lg" type="submit">메일양식 저장하기</button>
							</form>
						</div><!-- /.tab-pane -->

						<div class="tab-pane fade" id="email-preview" role="tabpanel">

							<?php echo $email_header ?>
							<div class="text-muted samll">
								메일본문이 추가됩니다.
							</div>
							<?php echo $email_footer ?>
						</div><!-- /.tab-pane -->

					</div><!-- /.card-body tab-content -->
				</div><!-- /.card -->

			</div><!-- /.tab-pane -->

		</div><!-- /.tab-content -->

	</div><!-- /.col -->

</div><!-- /.row -->



<div hidden><iframe name="_autosave_"></iframe></div>

<?php getImport('codemirror','lib/codemirror',false,'css')?>
<?php getImport('codemirror','lib/codemirror',false,'js')?>
<?php getImport('codemirror','theme/'.$d['admin']['codeeidt'],false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/xml/xml',false,'js')?>
<?php getImport('codemirror','mode/javascript/javascript',false,'js')?>
<?php getImport('codemirror','mode/css/css',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/clike/clike',false,'js')?>
<?php getImport('codemirror','mode/php/php',false,'js')?>


<!-- basic -->
<script>

putCookieAlert('admin_config_result') // 실행결과 알림 메시지 출력

var submitFlag = false;
function sendCheck(id)
{
	if (submitFlag == true)
	{
		alert('응답을 기다리는 중입니다. 잠시 기다려 주세요.');
		return false;
	}
	var f = document.procForm;
	if (id == 'sendmailbtn' || id == 'smtpbtn')
	{
		if (f.sysmail.value == '')
		{
			alert('시스템 이메일 주소를 입력해 주세요.       ');
			f.email.focus();
			return false;
		}
		f.chk_email.value = f.sysmail.value;
	}
	if (id == 'smtpbtn')
	{
		if (f.smtp_host.value == '')
		{
			alert('SMTP 서버주소를 입력해 주세요.   ');
			f.smtp_host.focus();
			return false;
		}
		if (f.smtp_port.value == '')
		{
			alert('SMTP 포트번호를 입력해 주세요.    ');
			f.smtp_port.focus();
			return false;
		}
		if (f.smtp_user.value == '')
		{
			alert('인증 아이디를 입력해 주세요.    ');
			f.smtp_user.focus();
			return false;
		}
		if (f.smtp_pass.value == '')
		{
			alert('인증 암호를 입력해 주세요.    ');
			f.smtp_pass.focus();
			return false;
		}
	}
	if (id == 'ftpbtn')
	{
		if (f.ftp_host.value == '')
		{
			alert('FTP 서버주소를 입력해 주세요.   ');
			f.ftp_host.focus();
			return false;
		}
		if (f.ftp_port.value == '')
		{
			alert('FTP 포트번호를 입력해 주세요.    ');
			f.ftp_port.focus();
			return false;
		}
		if (f.ftp_user.value == '')
		{
			alert('FTP 아이디를 입력해 주세요.     ');
			f.ftp_user.focus();
			return false;
		}
		if (f.ftp_pass.value == '')
		{
			alert('FTP 암호를 입력해 주세요.    ');
			f.ftp_pass.focus();
			return false;
		}
		if (f.ftp_rb.value == '')
		{
			alert('킴스큐 경로를 입력해 주세요.    ');
			f.ftp_rb.focus();
			return false;
		}
	}
	submitFlag = true;

	if (id == 'sendsmsbtn') {
		f.chk_sms.value = f.sms_tel.value;
		f.a.value = 'sms_check';

		if (f.testsms.value == '') {
			alert('휴대폰 번호를 입력해주세요.');
			f.testsms.focus();
			var submitFlag = false;
			return false;
		}

	} else {
		f.a.value = 'email_check';
	}
	f.type.value = id;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
}
function ftp_select(obj)
{
	if (obj.value == '') obj.form.ftp_port.value = '21';
	else obj.form.ftp_port.value = '22';
}
function saveCheck(f)
{
	getIframeForAction(f);
}

var editor_html = CodeMirror.fromTextArea(getId('code_header'), {
	mode: "text/html",
  indentUnit: 2,
  lineNumbers: true,
  matchBrackets: false,
  indentWithTabs: true,
});

var editor_html = CodeMirror.fromTextArea(getId('code_footer'), {
	mode: "text/html",
  indentUnit: 2,
  lineNumbers: true,
  matchBrackets: false,
  indentWithTabs: true,
});

</script>
