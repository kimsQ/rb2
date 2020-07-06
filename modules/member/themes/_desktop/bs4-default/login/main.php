<section class="my-5">

	<header>
		<h2 class="text-center">
			<a class="navbar-brand" href="<?php  echo RW(0) ?>"
				style="background-image:url(<?php echo $d['layout']['header_logo']?$g['url_var_site'].'/'.$d['layout']['header_logo'].$g['wcache']:''?>);background-size:<?php echo $d['layout']['header_logo_size'] ?>%">
				<?php echo !$d['layout']['header_logo']?$d['layout']['header_title'] :'' ?>
			</a>
		</h2>
	</header>

	<div class="form-signin mt-2">
		<div class="card">
			<div class="card-body">

				<?php if ($d['member']['login_emailid']): ?>
				<form class="" id="page-loginform" action="<?php echo $g['s']?>/" method="post" novalidate>
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="a" value="login">
					<input type="hidden" name="referer" value="<?php echo $referer ? $referer : $_SERVER['HTTP_REFERER']?>">
					<input type="hidden" name="form" value="">

					<div class="form-group">
						<label for="">이메일 또는 휴대폰 번호</label>
						<input type="text" name="id" id="id" class="form-control" placeholder="" tabindex="1" autocorrect="off" autocapitalize="off" autofocus="autofocus" required>
						<div class="invalid-feedback mt-2" data-role="idErrorBlock"></div>
					</div>

					<div class="form-group">
						<label for="">
							비밀번호
							<a href="#modal-pwReset" data-toggle="modal" data-backdrop="static" class="label-link" id="password_reset">
								비밀번호를 잊으셨나요?
							</a>
						</label>
						<input type="password" name="pw" id="password" class="form-control" placeholder="" tabindex="2" required>
						<div class="invalid-feedback mt-2" data-role="passwordErrorBlock"></div>
					</div>

					<?php if ($d['member']['login_cookie']): ?>
					<div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#page-collapsealert">
						<input type="checkbox" class="custom-control-input" id="page-loginCookie" name="login_cookie" value="checked" tabindex="4">
						<label class="custom-control-label" for="page-loginCookie">로그인 상태 유지</label>
					</div>
					<div class="collapse" id="page-collapsealert">
						<div class="alert alert-danger f12 mb-3">
							개인정보 보호를 위해, 개인 PC에서만 사용해 주세요.
						</div>
					</div>
					<?php endif; ?>

					<button class="btn btn-lg btn-primary btn-block" type="submit" id="rb-submit" data-role="submit" tabindex="3">
						<span class="not-loading">로그인</span>
						<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 로그인중 ...</span>
					</button>
				</form>
				<?php endif; ?>

				<?php if ($d['member']['login_emailid'] && $d['member']['login_social']): ?>
				<span class="section-divider" style="z-index: 1;"><span>또는</span></span>
				<?php endif; ?>

				<?php if ($d['member']['login_social']): ?>
				<div class="mx-auto mt-3">
					<h6 class="mb-2">내 소셜계정으로 로그인</h6>

					<?php if ($d['connect']['use_k']): ?>
					<button type="button" class="btn btn-lg btn-block btn-social btn-kakao" data-connect="kakao" role="button">
						<span></span>
						<span class="f14">카카오톡 계정으로 로그인</span>
					</button>
					<?php endif; ?>

					<?php if ($d['connect']['use_n']): ?>
					<button type="button" class="btn btn-lg btn-block btn-social btn-naver" data-connect="naver" role="button">
            <span></span>
            <span class="f14">네이버 계정으로 로그인</span>
          </button>
					<?php endif; ?>

					<?php if ($d['connect']['use_g']): ?>
					<button type="button" class="btn btn-lg btn-block btn-social btn-google" data-connect="google" role="button">
            <span class="fa fa-google"></span>
            <span class="f14">구글 계정으로 로그인</span>
          </button>
					<?php endif; ?>

					<?php if ($d['connect']['use_f']): ?>
					<button type="button" class="btn btn-lg btn-block btn-social btn-facebook" data-connect="facebook" role="button">
            <span class="fa fa-facebook"></span>
            <span class="f14">페이스북 계정으로 로그인</span>
          </button>
					<?php endif; ?>

					<?php if ($d['connect']['use_i']): ?>
					<button type="button" class="btn btn-lg btn-block btn-social btn-instagram" data-connect="instagram" role="button">
            <span class="fa fa-instagram"></span>
            <span class="f14">인스타그램 계정으로 로그인</span>
          </button>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>
		</div>

	</form>

	<div class="card form-signin mt-3 bg-transparent">
		<div class="card-body">
			<a href="<?php echo RW('mod=join') ?>" tabindex="6">회원계정이 없으신가요 ?</a>
		</div>
	</div>

</section>

<script type="text/javascript">

$(function () {

	$('#page-loginform').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		var form = $(this)
		var formID = form.attr('id')
		var f = document.getElementById(formID);
		form.find('[name="form"]').val('#'+formID);
		form.find('[type="submit"]').attr("disabled",true);
		form.find('.form-control').removeClass('is-invalid')  //에러이력 초기화
		setTimeout(function(){
			getIframeForAction(f);
			f.submit();
		}, 500);
	});

	// 로그인 에러 흔적 초기화
	$("#page-loginform").find('.form-control').keyup(function() {
		$(this).removeClass('is-invalid')
	});


})

</script>
