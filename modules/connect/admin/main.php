<?php
$g['connectVarForSite'] = $g['path_var'].'site/'.$r.'/connect.var.php';
$_tmpdfile = file_exists($g['connectVarForSite']) ? $g['connectVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpdfile;
?>

<div id="configbox" class="row no-gutters">

	<div class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar">
		<div id="accordion">
			<div class="card border-0">
				<div class="card-header p-0 d-flex justify-content-between">

					<a class="muted-link d-block w-100" role="button" aria-expanded="true" aria-controls="collapseOne">
							소셜 로그인 목록
					</a>

				</div>
				<div class="card-body p-0">

					<div class="list-group list-group-flush border-bottom">

						<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if(!$_SESSION['connect_config_nav'] || $_SESSION['connect_config_nav']=='kakao'):?> active<?php endif?>" data-toggle="pill" href="#pane_kakao" onclick="sessionSetting('connect_config_nav','kakao','','');">
							<span>
								카카오
							</span>
							<span>
							<?php if ($d[$module]['use_k']): ?>
							<i class="fa fa-circle text-success ml-auto" data-toggle="tooltip" title="" data-original-title="사용중"></i>
							<?php endif; ?>
							</span>
						</a>
						<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if($_SESSION['connect_config_nav']=='google'):?> active<?php endif?>" data-toggle="pill" href="#pane_google" onclick="sessionSetting('connect_config_nav','google','','');">
							<span>
								구글
							</span>
							<span>
							<?php if ($d[$module]['use_g']): ?>
							<i class="fa fa-circle text-success ml-auto" data-toggle="tooltip" title="" data-original-title="사용중"></i>
							<?php endif; ?>
							</span>
						</a>
						<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if($_SESSION['connect_config_nav']=='naver'):?> active<?php endif?>" data-toggle="pill" href="#pane_naver" onclick="sessionSetting('connect_config_nav','naver','','');">
							<span>
								네이버
							</span>
							<span>
							<?php if ($d[$module]['use_n']): ?>
							<i class="fa fa-circle text-success ml-auto" data-toggle="tooltip" title="" data-original-title="사용중"></i>
							<?php endif; ?>
							</span>
						</a>
						<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if($_SESSION['connect_config_nav']=='facebook'):?> active<?php endif?>"  data-toggle="pill" href="#pane_facebook" onclick="sessionSetting('connect_config_nav','facebook','','');">
							<span>
								페이스북
							</span>
							<span>
							<?php if ($d[$module]['use_f']): ?>
							<i class="fa fa-circle text-success ml-auto" data-toggle="tooltip" title="" data-original-title="사용중"></i>
							<?php endif; ?>
							</span>
						</a>
						<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if($_SESSION['connect_config_nav']=='instagram'):?> active<?php endif?>"  data-toggle="pill" href="#pane_instagram" onclick="sessionSetting('connect_config_nav','instagram','','');">
							<span>
								인스타그램
							</span>
							<span>
							<?php if ($d[$module]['use_i']): ?>
							<i class="fa fa-circle text-success ml-auto" data-toggle="tooltip" title="" data-original-title="사용중"></i>
							<?php endif; ?>
							</span>
						</a>
					</div><!-- /.list-group -->

				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div><!-- /#accordion -->
	</div><!-- /.sidebar -->

	<div class="col-sm-8 col-md-8 ml-sm-auto col-xl-9">

			<form class="card rounded-0 border-0" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="a" value="config">


				<div class="card-header d-flex justify-content-between align-items-center page-body-header" style="line-height: 1.2;">
					<span>연결 등록정보</span>
				</div><!-- /.card-header -->

				<div class="card-body tab-content">

					<div id="pane_naver" class="tab-pane fade<?php if(!$_SESSION['connect_config_nav'] || $_SESSION['connect_config_nav']=='naver'):?> show active<?php endif?>">

						<div class="d-flex justify-content-between align-items-center">
							<div class="media p-2">
							  <img class="mr-3 rounded<?php echo !$d[$module]['use_n']?' grayscale':'' ?>" src="<?php echo $g['img_module_admin']?>/naver.png" alt="네이버" width="64px">
							  <div class="media-body">
							    <h5 class="mt-2 mb-1">
										네이버
									</h5>
							    <span class="text-muted">네이버 계정으로 로그인 ,네이버 블로그 및 포스트로 링크 공유</span>
							  </div>
							</div>

							<div class="custom-control custom-checkbox custom-control-inline ml-3">
								<input type="checkbox" class="custom-control-input" id="use_n" name="use_n" value="1" <?php echo $d[$module]['use_n']?' checked':'' ?><?php echo !$d[$module]['key_n']&&!$d[$module]['secret_n']?' disabled':'' ?>>
								<label class="custom-control-label" for="use_n">사용함</label>
							</div>
						</div><!-- /.d-flex -->

						<hr>

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">Client ID</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="key_n" value="<?php echo $d[$module]['key_n']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">Client Secret</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="secret_n" value="<?php echo $d[$module]['secret_n']?>">
							</div>
						</div><!-- /.form-group -->


						<div class="card mt-5">
							<div class="card-header d-flex justify-content-between">
								APP 등록
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">개발자 센타</label>
									<div class="col-lg-10 col-xl-9 pt-2">
										<a href="https://developers.naver.com/apps" target="_blank">https://developers.naver.com/apps</a>
									</div>
								</div><!-- /.form-group -->
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">Callback URL</label>
									<div class="col-lg-10 col-xl-9">

										<div class="input-group">
											<input type="text" class="form-control" value="<?php echo $g['url_root'].'/'.$r.'/oauth/naver'?>" readonly id="url_n">
											<div class="input-group-append">
												<button class="btn btn-light js-clipboard" type="button" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#url_n">
													<i class="fa fa-clipboard"></i>
												</button>
											</div>
										</div>
										<small class="form-text text-muted"><span class="badge badge-pill badge-dark">참고</span> <?php echo  $g['s'].'/?r='.$r.'&m='.$module.'&a=connect&connectReturn=naver'?></small>
									</div>
								</div><!-- /.form-group -->
								<hr>

								<ul class="f12 text-muted">
									<li>애플리케이션 등록: 네이버 오픈 API로 개발하시려면 먼저 <a href="https://developers.naver.com/apps/#/register?api=nvlogin" target="_blank">'Application-애플리케이션 등록'</a> 메뉴에서 애플리케이션을 등록하셔야 합니다. <br>
									<a href="https://developers.naver.com/docs/common/register" target="_blank">[자세한 방법 보기] &gt;</a></li>
									<li>클라이언트 ID와 secret 확인: <a href="https://developers.naver.com/appinfo" target="_blank">'내 애플리케이션'</a>에서 등록한 애플리케이션을 선택하면 Client ID와 Client Secret 값을 확인할 수 있습니다.</li>
									<li>API 권한 설정: <a href="https://developers.naver.com/appinfo" target="_blank">'내 애플리케이션'</a>의 'API 권한관리' 탭에서 사용하려는 API가 체크되어 있는지 확인합니다. 체크되어 있지 않을 경우 403 에러(API 권한 없음)가 발생하니 주의하시기 바랍니다.
									</li>
								</ul>

								<div class="f12 text-muted">
									SNS 로그인을 위해서는 각각의 SNS의 APP등록을 하셔야 합니다.<br />
									APP 등록을 하면 API키와 같은 특정 인증키를 받게되며 그 값을 등록해 주시면 됩니다.<br />
									인증키를 등록한 후에는 반드시 각 SNS APP등록페이지에서 콜백주소 및 기타 설정을 해 주세요.<br>
									(앱 설정페이지에서 인증된 도메인이 아닐 경우 대부분 사용이 제한됩니다.)<br>
									<strong>이 모듈은 서버에 PHP CURL 모듈이 설치되어 있어야 사용가능합니다.</strong><br>
									<hr>
									자세한 내용은 <a href="https://docs.google.com/document/d/1a1rGRZXgdeK-bxbFrHbnAQfO5BIS8s8xQteX1Ho0lA8/edit?usp=sharing" target="_blank">네이버 연결 도움말</a>을 참고해주세요
								</div>
							</div>
						</div>

					</div><!-- /#pane_naver -->


					<div id="pane_kakao" class="tab-pane fade<?php if($_SESSION['connect_config_nav']=='kakao'):?> show active<?php endif?>">


						<div class="d-flex justify-content-between align-items-center">
							<div class="media p-2">
							  <img class="mr-3 rounded<?php echo !$d[$module]['use_k']?' grayscale':'' ?>" src="<?php echo $g['img_module_admin']?>/kakaotalk.png" alt="카카오" width="64px">
							  <div class="media-body">
							    <h5 class="mt-2 mb-1">
										카카오톡
									</h5>
							    <span class="text-muted">카카오톡 계정으로 로그인 ,카카오톡 및 카카오 스토리 링크공유</span>
							  </div>
							</div>

							<div class="custom-control custom-checkbox custom-control-inline ml-3">
								<input type="checkbox" class="custom-control-input" id="use_k" name="use_k" value="1" <?php echo $d[$module]['use_k']?' checked':'' ?><?php echo !$d[$module]['key_k']&&!$d[$module]['secret_k']?' disabled':'' ?>>
								<label class="custom-control-label" for="use_k">사용함</label>
							</div>
						</div><!-- /.d-flex -->


						<hr>

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">REST API 키</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="key_k" value="<?php echo $d[$module]['key_k']?>">
							</div>
						</div><!-- /.form-group -->
						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">JavaScript 키</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="jskey_k" value="<?php echo $d[$module]['jskey_k']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">Admin 키</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="secret_k" value="<?php echo $d[$module]['secret_k']?>">
							</div>
						</div><!-- /.form-group -->


						<div class="card mt-5">
							<div class="card-header d-flex justify-content-between">
								APP 등록
							</div>
							<div class="card-body">

								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">개발자 센타</label>
									<div class="col-lg-10 col-xl-9 pt-2">
										<a href="https://developers.kakao.com/apps" target="_blank">https://developers.kakao.com/apps</a>
									</div>
								</div><!-- /.form-group -->
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">Redirect Path</label>
									<div class="col-lg-10 col-xl-9">

										<div class="input-group">
										  <input type="text" class="form-control" value="<?php echo $g['url_root'].'/'.$r.'/oauth/kakao'?>" readonly id="url_k">
										  <div class="input-group-append">
												<button class="btn btn-light js-clipboard" type="button" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#url_k">
													<i class="fa fa-clipboard"></i>
												</button>
										  </div>
										</div>
										<small class="form-text text-muted"><span class="badge badge-pill badge-dark">참고</span> <?php echo  $g['s'].'/?r='.$r.'&m='.$module.'&a=connect&connectReturn=kakao'?></small>
									</div>
								</div><!-- /.form-group -->

								<hr>
								<div class="f12 text-muted">
									SNS 로그인을 위해서는 각각의 SNS의 APP등록을 하셔야 합니다.<br />
									APP 등록을 하면 API키와 같은 특정 인증키를 받게되며 그 값을 등록해 주시면 됩니다.<br />
									인증키를 등록한 후에는 반드시 각 SNS APP등록페이지에서 콜백주소 및 기타 설정을 해 주세요.<br>
									(앱 설정페이지에서 인증된 도메인이 아닐 경우 대부분 사용이 제한됩니다.)<br>
									<strong>이 모듈은 서버에 PHP CURL 모듈이 설치되어 있어야 사용가능합니다.</strong><br>
									<hr>
									자세한 내용은 <a href="https://docs.google.com/document/d/1l8mcm_7r-RUyySdP0JlKXON6rZJtqqsjqsQaDB1F9_g/edit?usp=sharing" target="_blank">카카오 연결 도움말</a>을 참고해주세요
								</div>
							</div>
						</div><!-- /.card -->

					</div><!-- /#pane_kakao -->


					<div id="pane_google" class="tab-pane fade<?php if($_SESSION['connect_config_nav']=='google'):?> show active<?php endif?>">

						<div class="d-flex justify-content-between align-items-center">
							<div class="media">
								<span class="fa-stack fa-3x mr-3<?php echo $d[$module]['use_g']?' google active':'' ?>">
								  <i class="fa fa-square fa-stack-2x"></i>
								  <i class="fa fa-google fa-stack-1x fa-inverse"></i>
								</span>
							  <div class="media-body">
							    <h5 class="mt-3 mb-1">구글</h5>
							    <span class="text-muted">구글 계정으로 로그인</span>
							  </div>
							</div>
							<div class="custom-control custom-checkbox custom-control-inline ml-3">
								<input type="checkbox" class="custom-control-input" id="use_g" name="use_g" value="1" <?php echo $d[$module]['use_g']?' checked':'' ?><?php echo !$d[$module]['key_g']&&!$d[$module]['secret_g']?' disabled':'' ?>>
								<label class="custom-control-label" for="use_g">사용함</label>
							</div>
						</div><!-- /.d-flex -->

						<hr>

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">클라이언트 ID</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="key_g" value="<?php echo $d[$module]['key_g']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">보안 비밀</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="secret_g" value="<?php echo $d[$module]['secret_g']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="card mt-5">
							<div class="card-header d-flex justify-content-between">
								APP 등록
							</div>
							<div class="card-body">

								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">API 콘솔</label>
									<div class="col-lg-10 col-xl-9 pt-2">
										<a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a>
									</div>
								</div><!-- /.form-group -->
								<hr>
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">리디렉션 URI</label>
									<div class="col-lg-10 col-xl-9">

										<div class="input-group">
											<input type="text" class="form-control" value="<?php echo $g['url_root'].'/'.$r.'/oauth/google'?>" readonly id="url_g">
											<div class="input-group-append">
												<button class="btn btn-light js-clipboard" type="button" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#url_g">
													<i class="fa fa-clipboard"></i>
												</button>
											</div>
										</div>
										<small class="form-text text-muted"><span class="badge badge-pill badge-dark">참고</span> <?php echo  $g['s'].'/?r='.$r.'&m='.$module.'&a=connect&connectReturn=google'?></small>
									</div>
								</div><!-- /.form-group -->
								<div class="f12 text-muted">
									SNS 로그인을 위해서는 각각의 SNS의 APP등록을 하셔야 합니다.<br />
									APP 등록을 하면 API키와 같은 특정 인증키를 받게되며 그 값을 등록해 주시면 됩니다.<br />
									인증키를 등록한 후에는 반드시 각 SNS APP등록페이지에서 콜백주소 및 기타 설정을 해 주세요.<br>
									(앱 설정페이지에서 인증된 도메인이 아닐 경우 대부분 사용이 제한됩니다.)<br>
									<strong>이 모듈은 서버에 PHP CURL 모듈이 설치되어 있어야 사용가능합니다.</strong><br>
									<hr>
									자세한 내용은 <a href="https://docs.google.com/document/d/1MtntPlUzWJfzzq-p5QulQhYHcWL6j8Y0HiUe186JBas/edit?usp=sharing" target="_blank">구글 연결 도움말</a>을 참고해주세요
								</div>
							</div>
						</div><!-- /.card -->

					</div><!-- /#pane_google -->

					<div id="pane_facebook" class="tab-pane fade<?php if($_SESSION['connect_config_nav']=='facebook'):?> show active<?php endif?>">

						<div class="d-flex justify-content-between align-items-center">
							<div class="media">
								<span class="fa-stack fa-3x mr-3<?php echo $d[$module]['use_f']?' facebook active':'' ?>">
								  <i class="fa fa-square fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							  <div class="media-body">
							    <h5 class="mt-3 mb-1">페이스북</h5>
							    <span class="text-muted">페이스북 계정으로 로그인</span>
							  </div>
							</div>
							<div class="custom-control custom-checkbox custom-control-inline ml-3">
								<input type="checkbox" class="custom-control-input" id="use_f" name="use_f" value="1" <?php echo $d[$module]['use_f']?' checked':'' ?><?php echo !$d[$module]['key_f']&&!$d[$module]['secret_f']?' disabled':'' ?>>
								<label class="custom-control-label" for="use_f">사용함</label>
							</div>
						</div><!-- /.d-flex -->

						<hr>

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">앱 ID</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="key_f" value="<?php echo $d[$module]['key_f']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">앱 시크릿 코드</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="secret_f" value="<?php echo $d[$module]['secret_f']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="card mt-4">
							<div class="card-header d-flex justify-content-between">
								APP 등록
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">개발자 센타</label>
									<div class="col-lg-10 col-xl-9 pt-2">
										<a href="https://developers.facebook.com" target="_blank">https://developers.facebook.com</a>
									</div>
								</div><!-- /.form-group -->
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">콜백 URL</label>
									<div class="col-lg-10 col-xl-9">

										<div class="input-group">
										  <input type="text" class="form-control" value="<?php echo $g['url_root'].'/'.$r.'/oauth/facebook'?>" readonly id="url_f">
										  <div class="input-group-append">
												<button class="btn btn-light js-clipboard" type="button" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#url_f">
													<i class="fa fa-clipboard"></i>
												</button>
										  </div>
										</div>
										<small class="form-text text-muted"><span class="badge badge-pill badge-dark">참고</span> <?php echo  $g['s'].'/?r='.$r.'&m='.$module.'&a=connect&connectReturn=facebook'?></small>

									</div>
								</div><!-- /.form-group -->

								<hr>
								<div class="f12 text-muted">
									SNS 로그인을 위해서는 각각의 SNS의 APP등록을 하셔야 합니다.<br />
									APP 등록을 하면 API키와 같은 특정 인증키를 받게되며 그 값을 등록해 주시면 됩니다.<br />
									인증키를 등록한 후에는 반드시 각 SNS APP등록페이지에서 콜백주소 및 기타 설정을 해 주세요.<br>
									(앱 설정페이지에서 인증된 도메인이 아닐 경우 대부분 사용이 제한됩니다.)<br>
									<strong>이 모듈은 서버에 PHP CURL 모듈이 설치되어 있어야 사용가능합니다.</strong><br>
									<hr>
									자세한 내용은 <a href="https://docs.google.com/document/d/1WnwWFFozPsia1wWhxwZrnht1j7-gJRUs9gjzP3sWVgk/edit?usp=sharing" target="_blank">페이스북 연결 도움말</a>을 참고해주세요
								</div>
							</div>
						</div><!-- /.card -->

					</div><!-- /#pane_facebook -->

					<div id="pane_instagram" class="tab-pane fade<?php if($_SESSION['connect_config_nav']=='instagram'):?> show active<?php endif?>">

						<div class="d-flex justify-content-between align-items-center">
							<div class="media">
								<span class="fa-stack fa-3x mr-3<?php echo $d[$module]['use_i']?' instagram active':'' ?>">
									<i class="fa fa-square fa-stack-2x"></i>
									<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
								</span>
								<div class="media-body">
									<h5 class="mt-3 mb-1">인스타 그램</h5>
									<span class="text-muted">인스타 계정으로 로그인, 사진 가져오기</span>
								</div>
							</div>
							<div class="custom-control custom-checkbox custom-control-inline ml-3">
								<input type="checkbox" class="custom-control-input" id="use_i" name="use_i" value="1" <?php echo $d[$module]['use_i']?' checked':'' ?><?php echo !$d[$module]['key_i']&&!$d[$module]['secret_i']?' disabled':'' ?>>
								<label class="custom-control-label" for="use_i">사용함</label>
							</div>
						</div><!-- /.d-flex -->

						<hr>

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">Client ID</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="key_i" value="<?php echo $d[$module]['key_i']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right pt-3">Client Secret</label>
							<div class="col-lg-10 col-xl-9">
								<input class="form-control form-control-lg" type="text" name="secret_i" value="<?php echo $d[$module]['secret_i']?>">
							</div>
						</div><!-- /.form-group -->

						<div class="card mt-5">
							<div class="card-header d-flex justify-content-between">
								APP 등록
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">클라이언트 관리</label>
									<div class="col-lg-10 col-xl-9 pt-2">
										<a href="https://www.instagram.com/developer/clients/manage" target="_blank">https://www.instagram.com/developer/clients/manage</a>
									</div>
								</div><!-- /.form-group -->
								<div class="form-group row">
									<label class="col-lg-2 col-form-label text-lg-right">Redirect URIs</label>
									<div class="col-lg-10 col-xl-9">

										<div class="input-group">
										  <input type="text" class="form-control" value="<?php echo $g['url_root'].'/'.$r.'/oauth/instagram'?>" readonly id="url_i">
										  <div class="input-group-append">
												<button class="btn btn-light js-clipboard" type="button" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#url_i">
													<i class="fa fa-clipboard"></i>
												</button>
										  </div>
										</div>
										<small class="form-text text-muted"><span class="badge badge-pill badge-dark">참고</span> <?php echo  $g['s'].'/?r='.$r.'&m='.$module.'&a=connect&connectReturn=instagram'?></small>

									</div>
								</div><!-- /.form-group -->

								<hr>
								<div class="f12 text-muted">
									SNS 로그인을 위해서는 각각의 SNS의 APP등록을 하셔야 합니다.<br />
									APP 등록을 하면 API키와 같은 특정 인증키를 받게되며 그 값을 등록해 주시면 됩니다.<br />
									인증키를 등록한 후에는 반드시 각 SNS APP등록페이지에서 콜백주소 및 기타 설정을 해 주세요.<br>
									(앱 설정페이지에서 인증된 도메인이 아닐 경우 대부분 사용이 제한됩니다.)<br>
									<strong>이 모듈은 서버에 PHP CURL 모듈이 설치되어 있어야 사용가능합니다.</strong><br>
									<hr>
									자세한 내용은 <a href="https://docs.google.com/document/d/1nwAGoDiWkhyXGwuZ_hPpiY9UkkFwOPBg9app7wL3n3w/edit?usp=sharing" target="_blank">인스타그램 연결 도움말</a>을 참고해주세요
								</div>
							</div>
						</div><!-- /.card -->

					</div><!-- /#pane_instagram -->

					<hr>
					<button type="submit" class="btn btn-outline-primary btn-block btn-lg">
						저장하기
					</button>



				</div><!-- /.card-body -->

			</form>


	</div>
</div><!-- /.row -->


<script type="text/javascript">
//<![CDATA[

putCookieAlert('connect_config_result') // 실행결과 알림 메시지

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

//]]>
</script>
