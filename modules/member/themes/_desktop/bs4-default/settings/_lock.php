<script>
var reauth_naver= '<?php echo getConnectUrl('naver',$d['connect']['key_n'],$d['connect']['secret_n'],$g['url_root'].'/'.$r.'/oauth/naver','reauthenticate')?>';
var reauth_kakao= '<?php echo getConnectUrl('kakao',$d['connect']['key_k'],$d['connect']['secret_k'],$g['url_root'].'/'.$r.'/oauth/kakao','reauthenticate')?>';
var reauth_google= '<?php echo getConnectUrl('google',$d['connect']['key_g'],$d['connect']['secret_g'],$g['url_root'].'/'.$r.'/oauth/google','reauthenticate')?>';
var reauth_facebook= '<?php echo getConnectUrl('facebook',$d['connect']['key_f'],$d['connect']['secret_f'],$g['url_root'].'/'.$r.'/oauth/facebook','reauthenticate')?>';
var reauth_instagram= '<?php echo getConnectUrl('instagram',$d['connect']['key_i'],$d['connect']['secret_i'],$g['url_root'].'/'.$r.'/oauth/instagram','reauthenticate')?>';
</script>

<!-- 소셜로그인으로 생성된 소셜전용 회원계정일때 -->
<?php if (!$my['last_pw']): ?>

	<div class="card mb-5">

	  <div class="card-header">
	    <div class="media text-muted my-3">
	      <i class="fa fa-lock fa-4x mx-4" aria-hidden="true"></i>
	      <div class="media-body">
					<h5 class="mb-1">개인정보 잠금</h5>
	        <small>개인정보를 안전하게 보호하기 위해, 로그인 후 <mark><?php echo $d['member']['settings_expire'] ?>분</mark>이 경과하면 본인인증을 다시 한번 확인합니다.<br>
	        <?php echo $my['nic']; ?>님의
	        마지막 로그인 일시는 <mark><time data-plugin="timeago" datetime="<?php echo getDateFormat($my['last_log'],'c')?>"></time></mark>
	        (<?php echo getDateFormat($my['last_log'],'Y.m.d H:i')?>) 입니다.<br>
	        회원 정보는 개인정보 취급방침에 따라 안전하게 보호되며, 회원님의 동의 없이 공개 또는 제 3자에게 제공되지 않습니다.</small>
	      </div>
	    </div>
	  </div>

		<ul class="list-group list-group-flush">

			<?php if ($d['connect']['use_n'] && $my_naver['uid']): ?>
		  <li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="">
					<a href="http://naver.com" target="_blank" class="muted-link">
						<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버" width="28">
						네이버
					</a>
				</div>
				<div class="">
					<button type="button" class="btn btn-outline-primary" data-reauth="naver" role="button">
						재인증 하기
					</button>
				</div>
			</li>
			<?php endif; ?>

			<?php if ($d['connect']['use_k'] && $my_kakao['uid']): ?>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="">
					<a href="http://kakao.com" target="_blank" class="muted-link">
						<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/kakao.png" alt="카카오" width="28">
						카카오
					</a>
				</div>
				<div class="">
					<button type="button" class="btn btn-outline-primary" data-reauth="kakao" role="button">
						재인증 하기
					</button>
				</div>
			</li>
			<?php endif; ?>

			<?php if ($d['connect']['use_g'] && $my_google['uid']): ?>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="">
					<a href="http://google.com" target="_blank" class="muted-link">
						<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/google.png" alt="구글" width="28">
						구글
					</a>
				</div>
				<div class="">
					<button type="button" class="btn btn-outline-primary" data-reauth="google" role="button">
						재인증 하기
					</button>
				</div>
			</li>
			<?php endif; ?>

			<?php if ($d['connect']['use_f'] && $my_facebook['uid']): ?>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="">
					<a href="http://facebook.com" target="_blank" class="muted-link">
						<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북" width="28">
						페이스북
					</a>
				</div>
				<div class="">
					<button type="button" class="btn btn-outline-primary" data-reauth="facebook" role="button">
						재인증 하기
					</button>
				</div>
			</li>
			<?php endif; ?>

			<?php if ($d['connect']['use_i'] && $my_instagram['uid']): ?>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="">
					<a href="http://instagram.com" target="_blank" class="muted-link">
						<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/instagram.png" alt="인스타그램" width="28">
						인스타그램
					</a>
				</div>
				<div class="">
					<button type="button" class="btn btn-outline-primary" data-reauth="instagram" role="button">
						재인증 하기
					</button>
				</div>
			</li>
			<?php endif; ?>

		</ul>
	</div><!-- /.card -->

<?php else: ?>

<!-- 패스워드를 직접 등록한 회원계정일때 -->
<div class="card mb-5">

  <div class="card-header">
    <div class="media text-muted my-3">
      <i class="fa fa-lock fa-4x mx-4" aria-hidden="true"></i>
      <div class="media-body">
				<h5 class="mb-1">개인정보 잠금</h5>
        <small>개인정보를 안전하게 보호하기 위해, 로그인 후 <mark><?php echo $d['member']['settings_expire'] ?>분</mark>이 경과하면 본인인증을 다시 한번 확인합니다.<br>
        <?php echo $my['nic']; ?>님의
        마지막 로그인 일시는 <mark><time data-plugin="timeago" datetime="<?php echo getDateFormat($my['last_log'],'c')?>"></time></mark>
        (<?php echo getDateFormat($my['last_log'],'Y.m.d H:i')?>) 입니다.<br>
        회원 정보는 개인정보 취급방침에 따라 안전하게 보호되며, 회원님의 동의 없이 공개 또는 제 3자에게 제공되지 않습니다.</small>
      </div>
    </div>
		<ul class="nav nav-tabs card-header-tabs mt-4">
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#pane-passwd" id="tab-passwd">비밀번호로 인증 </a>
      </li>
			<?php if ($my_naver['uid'] || $my_kakao['uid'] || $my_google['uid'] || $my_facebook['uid'] || $my_instagram['uid']): ?>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#pane-social" id="tab-social">소셜계정으로 인증</a>
      </li>
			<?php endif; ?>
    </ul>
  </div>

	<div class="tab-content">

		<div class="tab-pane fade" id="pane-passwd" role="tabpanel">
			<div class="card-body">
				<form id="page-confirmPW" action="<?php echo $g['s']?>/" method="post">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="a" value="pwConfirm">
					<input type="hidden" name="form" value="">
					<input type="hidden" name="id" value="<?php echo $my['id'] ?>">

					<?php if ($my['email']): ?>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center">계정 이메일</label>
			      <div class="col-sm-10 pt-2">
			        <?php echo $my['email'] ?>
			      </div>
					</div>
					<?php endif; ?>

					<?php if ($my['phone']): ?>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center">계정 휴대폰</label>
			      <div class="col-sm-10 pt-2">
							<?php echo substr($my['phone'], 0,3).'-'.substr($my['phone'], 3,4).'-'.substr($my['phone'], 7,4) ?>
			      </div>
					</div>
					<?php endif; ?>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center">패스워드</label>
			      <div class="col-sm-8">
			        <input type="password" name="pw" id="password" class="form-control form-control-lg" placeholder="" tabindex="2" required="" value="" autocomplete="new-pw">
			        <div class="invalid-feedback mt-2" data-role="passwordErrorBlock"></div>
			      </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center"></label>
						<div class="col-sm-8">
							<div class="d-flex justify-content-between align-items-center">
								<button class="btn btn-light" type="submit" data-role="submit" tabindex="3">
									<span class="not-loading">확인하기</span>
									<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 확인중 ...</span>
								</button>
								<a href="#modal-pwReset" data-toggle="modal">비밀번호를 분실했어요.</a>
							</div>
						</div>
					</div>


				</form>
			</div><!-- /.card-body -->
		</div><!-- /.tab-pane -->

		<div class="tab-pane fade" id="pane-social" role="tabpanel">

			<ul class="list-group list-group-flush">

				<?php if ($d['connect']['use_n'] && $my_naver['uid']): ?>
			  <li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://naver.com" target="_blank" class="muted-link">
							<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버" width="28">
							네이버
						</a>
					</div>
					<div class="">
						<button type="button" class="btn btn-outline-primary" data-reauth="naver" role="button">
							재인증 하기
						</button>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_k'] && $my_kakao['uid']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://kakao.com" target="_blank" class="muted-link">
							<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/kakao.png" alt="카카오" width="28">
							카카오
						</a>
					</div>
					<div class="">
						<button type="button" class="btn btn-outline-primary" data-reauth="kakao" role="button">
							재인증 하기
						</button>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_g'] && $my_google['uid']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://google.com" target="_blank" class="muted-link">
							<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/google.png" alt="구글" width="28">
							구글
						</a>
					</div>
					<div class="">
						<button type="button" class="btn btn-outline-primary" data-reauth="google" role="button">
							재인증 하기
						</button>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_f'] && $my_facebook['uid']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://facebook.com" target="_blank" class="muted-link">
							<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북" width="28">
							페이스북
						</a>
					</div>
					<div class="">
						<button type="button" class="btn btn-outline-primary" data-reauth="facebook" role="button">
							재인증 하기
						</button>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_i'] && $my_instagram['uid']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://instagram.com" target="_blank" class="muted-link">
							<img class="rounded-circle" src="<?php echo $g['img_core']?>/sns/instagram.png" alt="인스타그램" width="28">
							인스타그램
						</a>
					</div>
					<div class="">
						<button type="button" class="btn btn-outline-primary" data-reauth="instagram" role="button">
							재인증 하기
						</button>
					</div>
				</li>
				<?php endif; ?>

			</ul>

		</div><!-- /.tab-pane -->

	</div><!-- /.tab-content -->


</div><!-- /.card -->



<?php endif; ?>
