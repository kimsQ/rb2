<!--
로그인 관련 컴포넌트 모음
1. 모달 : modal-login :    로그인 시작모달 (로그인 방식선택)
2. 모달 : modal-combine :  소셜미디어 사용자인증 후 연결정보 입력 (기존 회원중에 동일한 이메일이 존재하나, 본인인증되지 않은 이메일일 경우)
3. 모달 : modal-pwReset :  비밀번호 초기화
-->

<!-- 일반모달 : 로그인-->
<div id="modal-login" class="modal fast" style="z-index:21">

	<div class="page center" id="page-login-main">
		<header class="bar bar-nav bar-light bg-faded p-x-0">
			<a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
			<h1 class="title">로그인</h1>
		</header>
		<nav class="bar bar-tab bar-light bg-faded">
	    <a class="tab-item active" role="button" data-toggle="changeModal" href="#modal-join">
	      <small>처음이신가요? <span class="pl-2">회원가입</span></small>
	    </a>
	  </nav>
		<main class="content bg-faded">

			<div class="content-padded text-xs-center">

				<button type="button"class="btn btn-secondary btn-block" data-toggle="page" data-target="#page-login-form" data-start="#page-login-main" data-type="email" >
					이메일로 로그인
				</button>
				<span class="section-divider"><span>또는</span></span>
				<button type="button"class="btn btn-outline-primary btn-block" data-toggle="page" data-target="#page-login-form" data-start="#page-login-main" data-type="phone">
					휴대폰 번호로 로그인
				</button>

				<?php if ($d['member']['login_social']): ?>

				<?php if ($d['connect']['use_n']): ?>
				<button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-naver text-xs-center" data-connect="naver" role="button">
					<span></span>
					네이버로 로그인
				</button>
				<?php endif; ?>

				<?php if ($d['connect']['use_k']): ?>
				<button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-kakao text-xs-center" data-connect="kakao" role="button">
					<span></span>
					카카오톡으로 로그인
				</button>
				<?php endif; ?>

				<?php if ($d['connect']['use_g']): ?>
				<button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-google text-xs-center" data-connect="google" role="button">
					<span class="fa fa-google"></span>
					구글로 로그인
				</button>
				<?php endif; ?>

				<?php if ($d['connect']['use_f']): ?>
				<button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-facebook text-xs-center" data-connect="facebook" role="button">
					<span class="fa fa-facebook"></span>
					페이스북으로 로그인
				</button>
				<?php endif; ?>

				<?php if ($d['connect']['use_i']): ?>
				<button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-instagram text-xs-center" data-connect="instagram" role="button">
					<span class="fa fa-instagram"></span>
					인스타그램으로 로그인
				</button>
				<?php endif; ?>

				<?php endif; ?>

			</div>

		</main>
	</div><!-- /#page-main -->

	<div class="page right" id="page-login-form">
		<header class="bar bar-nav bar-light bg-white p-x-0">
			<a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
			<h1 class="title">로그인</h1>
		</header>
		<main class="content">

			<form id="modal-loginform" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="a" value="login">
				<input type="hidden" name="referer" value="<?php echo $referer ? $referer : $_SERVER['REQUEST_URI']?>">
				<input type="hidden" name="form" value="">
				<input type="hidden" name="login_cookie" value="checked">

				<div class="form-list floating mb-2 px-3">
	        <div class="input-row position-relative" data-role="input-phone">
	          <label>휴대폰 번호(숫자만)</label>
	          <input type="number" name="id" placeholder="휴대폰 번호" autocomplete="off">
						<div class="invalid-tooltip" data-role="idErrorBlock"></div>
	        </div>
	        <div class="input-row position-relative d-none" data-role="input-email">
	          <label>이메일 주소</label>
	          <input type="email" name="id" placeholder="이메일 주소" autocomplete="off">
						<div class="invalid-tooltip" data-role="idErrorBlock"></div>
	        </div>
	        <div class="input-row position-relative">
	          <label>비밀번호</label>
	          <input type="password" placeholder="비밀번호" name="pw" required autocapitalize="off" autocorrect="off">
						<div class="invalid-tooltip" data-role="passwordErrorBlock"></div>
	        </div>
	      </div>

				<div class="content-padded">
					<button type="submit" class="btn btn-outline-primary btn-block" data-role="submit">
						<span class="not-loading">확인</span>
		        <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 로그인중 ...</span>
					</button>
				</div>
			</form>
			<p class="content-padded text-xs-center mt-3">
				<a data-toggle="changeModal" href="#modal-pwReset" class="small muted-link" data-role="pwReset" data-type="email">
					비밀번호를 잊으셨나요? <strong>비밀번호 재설정</strong>
				</a>
			</p>

		</main>
	</div><!-- /#page-login -->

</div><!-- /.modal -->

<!-- 팝업 : 로그인 안내-->
<div id="popup-login-guide" class="popup zoom">
  <div class="popup-content rounded-0">
    <div class="content rounded-0" style="min-height: 110px;">
      <div class="p-a-1">
        <h5 data-role="title"></h5>
				<span data-role="subtext" class="f14 text-muted"></span>
        <div class="text-xs-right mt-2">
          <button type="button" class="btn btn-link text-muted mr-2" data-history="back">취소</button>
          <button type="button" class="btn btn-link" data-toggle="login">로그인</button>
        </div>
			</div>
    </div>
  </div>
</div>


<?php
$avatar_data=array('src'=>$_photo,'width'=>150,'height'=>150);
$user_avatar_src=getTimThumb($avatar_data);
$_SESSION['SL'] = ''; //세션 비우기
?>

<!-- 1. 일반모달 : 계정통합-->
<div id="modal-combine" class="modal zoom">
	<header class="bar bar-nav bar-light bg-faded">
    <a class="icon icon-left-nav pull-left" role="button" data-history="back"></a>
		<?php if (!$has_sns): ?>
		<button class="btn btn-link btn-nav pull-right p-x-1 js-submit">
			<span class="not-loading">로그인</span>
			<span class="is-loading">처리중 ...</span>
    </button>
		<?php endif; ?>
    <h1 class="title">
      계정통합
    </h1>
  </header>

  <div class="bar bar-standard bar-header-secondary">
    <h1 class="title">
      <span>
				<?php if ($_photo): ?>
				<img src="<?php echo $user_avatar_src ?>" alt=<?php echo $name ?>"" class="rounded-circle border" style="width: 35px">
				<?php else: ?>
				<img src="<?php echo $g['s'].'/_var/avatar/0.svg' ?>" alt=<?php echo $name ?>"" class="rounded-circle border" style="width: 35px">
				<?php endif; ?>
				<?php if ($sns_name): ?>
				<img src="<?php echo $g['img_core']?>/sns/<?php echo $sns_name ?>.png" alt="<?php echo $sns_name ?>" class="rounded-circle" width="35" style="margin-left: -10px">
				<?php endif; ?>
      </span>
      <?php echo $name ?>님
    </h1>
  </div>

	<?php if ($call_modal_join_social): ?>
	<nav class="bar bar-tab bar-light bg-faded">
    <a class="tab-item active" role="button" data-toggle="changeModal" href="#modal-join-social">
      <small>신규계정으로 가입하기</small>
    </a>
  </nav>
	<?php endif; ?>

	<main class="content">

		<?php if ($has_sns): ?> <!-- 동일한 이메일로 이미 가입된 소셜로그인 전용 계정이 있을 경우 -->
		<div class="content-padded">
			<div class="alert alert-warning f14" role="alert">
				<?php echo $sns_name_ko ?>로 사용자 인증이 되었으나, <strong><?php echo $email ?></strong>로 이미 연결된 <strong><?php echo $has_sns_ko ?></strong> 계정이 확인 되었습니다.
			</div>
			<button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-<?php echo $has_sns ?> text-xs-center" data-connect="<?php echo $has_sns ?>" role="button">
				<?php if ($has_sns=='naver' || $has_sns=='kakao'): ?>
				<span></span>
				<?php else: ?>
				<span class="fa fa-<?php echo $has_sns ?>"></span>
				<?php endif; ?>
				<span><?php echo $has_sns_ko ?> 으로 로그인</span>
			</button>
			<div class="mt-3 text-muted small">
				<?php echo $has_sns_ko ?>로 로그인 후, <?php echo $sns_name_ko ?>계정을 통합 할수 있습니다.<br>하나의 회원계정으로 다양한 서비스를 이용해 보세요.
			</div>
		</div>
		<?php else: ?>
		<form id="modal-combineform" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="a" value="login">
			<input type="hidden" name="sns_access_token" value="<?php echo $sns_access_token?>">
			<input type="hidden" name="sns_refresh_token" value="<?php echo $sns_refresh_token?>">
			<input type="hidden" name="sns_expires_in" value="<?php echo $sns_expires_in?>">
			<input type="hidden" name="snsname" value="<?php echo $sns_name?>">
			<input type="hidden" name="snsuid" value="<?php echo $snsuid?>">
			<input type="hidden" name="_photo" value="<?php echo $_photo ?>">
			<input type="hidden" name="form" value="">

			<div class="form-list floating mb-2 px-3">
				<div class="input-row position-relative">
					<label>휴대폰 번호 또는 이메일</label>
					<input type="text" name="id" placeholder="휴대폰 번호 또는 이메일" autocomplete="off" value="<?php echo $email ?>"<?php echo $email?' readonly':'' ?>>
					<div class="invalid-tooltip" data-role="idErrorBlock">휴대폰 번호 또는 이메일 입력하세요.</div>
				</div>
				<div class="input-row position-relative">
					<label>비밀번호</label>
					<input type="password" placeholder="비밀번호" name="pw" required autocapitalize="off" autocorrect="off">
					<div class="invalid-tooltip" data-role="passwordErrorBlock">비밀번호를 입력하세요.</div>
				</div>
			</div>

			<div class="content-padded">
				<div class="p-y-1">
					<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="login_cookie" value="checked" checked>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">로그인 상태 유지</span>
					</label>
				</div>
			</div>
		</form>

		<div class="content-padded text-muted small">
			이미, <?php echo $_HS['name'] ?>에 회원계정을 가지고 계시면 로그인을 해주세요.<br>
			<?php echo $name ?>님의 <?php echo $sns_name_ko ?> 계정과 통합됩니다. <br>
			하나의 회원계정으로 다양한 서비스를 이용해 보세요.
		</div>

		<p class="content-padded text-xs-center mt-5">
			<a href="<?php echo $g['s']?>/?m=member&front=login&page=password_reset" class="small btn btn-outline-info btn-block">비밀번호를 잊으셨나요? <strong class="ml-2">비밀번호 재설정</strong></a>
		</p>
		<?php endif; ?>

	</main>
</div><!-- /.modal -->


<script>

var modal_combine = $('#modal-combine')
var modal_login = $('#modal-login')

var page_login_main = $('#page-login-main')
var page_login_form = $('#page-login-form')

var popup_login_guide = $('#popup-login-guide') // 로그인 가이드

var form_combine = $('#modal-combineform')
var f_combine = document.getElementById('modal-combineform');


<?php if ($call_modal_combine): ?>
modal_combine.modal('show')
<?php endif; ?>

modal_combine.on('show.rc.modal', function () {
	modal_combine.find('.input-row').removeClass('active');
	modal_combine.find('[name="id"]').val('')
	modal_combine.find('[name="pw"]').val('')
})

modal_combine.find(".form-list.floating .input-row input").on('keyup', function() {
	$(this).removeClass('is-invalid') // 에러이력 초기화
	if ($(this).val().length >= 1) {
		$(this).parents('.input-row').addClass('active');
	} else {
		$(this).parents('.input-row').removeClass('active');
	}
})

modal_combine.on('tap click','.js-submit',function(){
	form_combine.submit()
});

form_combine.submit( function(event){

	event.preventDefault();
	event.stopPropagation();

	if (f_combine.id.value == '')
	{
		f_combine.id.classList.add('is-invalid');
		f_combine.id.focus();
		return false;
	}
	if (f_combine.pw.value == '')
	{
		f_combine.pw.classList.add('is-invalid');
		f_combine.pw.focus();
		return false;
	}

	modal_combine.find('.js-submit').attr("disabled",true);

	setTimeout(function(){
		siteLogin(form_combine)
		modal_combine.find('.js-submit').attr("disabled",false);
	}, 300);

});

//로그인폼 - 실행
page_login_form.find('form').submit( function(e){
	e.preventDefault();
	e.stopPropagation();
	var form = $(this)
	siteLogin(form)
});

// 로그인폼 모달이 열릴때,
modal_login.on('show.rc.modal', function () {
	// 액션페이지 초기화
  page_login_main.addClass('page center').removeClass('transition left')
	page_login_form.addClass('page right').removeClass('transition center')
	if ($('#drawer-left').length) {
		setTimeout(function(){ $('#drawer-left').drawer('hide'); }, 1000); // 왼쪽 드로워 닫기
	}
})

// 로그인폼 페이지가 열렸을때
page_login_form.on('shown.rc.page', function (e) {
	var button = $(e.relatedTarget)
	var type = button.data('type')
	var input = page_login_form.find('.input-row input')

	//초기화
	input.val('') // 아이디/비밀번호 입력항목 초기화
	page_login_form.find('.input-row').removeClass('active focus')
	page_login_form.find('[data-role="input-email"]').addClass('d-none')
	page_login_form.find('[data-role="input-phone"]').removeClass('d-none')
	page_login_form.find('[type="number"]').attr({'name':'id','required':'ture'})
	page_login_form.find('[type="email"]').removeAttr('name').removeAttr('required')
	page_login_form.find('[data-role="pwReset"]').attr('data-type','phone').attr('data-id','')

	if (type=="email") {
		page_login_form.find('[data-role="input-email"]').removeClass('d-none')
		page_login_form.find('[data-role="input-phone"]').addClass('d-none')
		page_login_form.find('[type="number"]').removeAttr('name').removeAttr('required')
		page_login_form.find('[type="email"]').attr({'name':'id','required':'ture'})
		page_login_form.find('[data-role="pwReset"]').attr('data-type','email')
	}

	setTimeout(function(){
		page_login_form.find('[name="id"]').focus()
	}, 300);

	input.focus(function(){
		$(this).parents('.input-row').addClass('focus');
	});
	input.focusout(function(){
		$(this).parents('.input-row').removeClass('focus');
	});
})

// modal 로그인이 닫혔을대
page_login_form.on('hidden.rc.page', function () {
	$(this).find('input').removeClass('is-invalid') // 에러흔적 초기화
})

page_login_form.find('input').keyup(function() {
	$(this).removeClass('is-invalid') //에러 발생후 다시 입력 시도시에 에러 흔적 초기화
});

page_login_form.find('[name="id"]').keyup(function() {
	var id = $(this).val()
	var btn_pwReset = page_login_form.find('[data-role="pwReset"]')
	btn_pwReset.attr('data-id',id)
});

page_login_form.find(".form-list.floating .input-row input").on('keyup', function() {
	if ($(this).val().length >= 1) {
		$(this).parents('.input-row').addClass('active');
	} else {
		$(this).parents('.input-row').removeClass('active');
	}
})
</script>


<!-- 3. 모달 : modal-pwReset :  비밀번호 초기화 -->
<div class="modal zoom" id="modal-pwReset">

	<div class="page center" id="page-pw-main">
		<header class="bar bar-nav bar-light bg-white px-0">
			<a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
			<button class="btn btn-link btn-nav pull-right p-l-1 p-r-2" data-act="send_code" data-type="phone" data-device="mobile" tabindex="2">
				다음
			</button>
	    <h1 class="title">비밀번호 재설정</h1>
	  </header>
		<nav class="bar bar-tab bar-light bg-faded">
			<a class="tab-item d-none" role="button" data-type="email" data-role="change-input">
				<small>또는 이메일로 받기</small>
			</a>
			<a class="tab-item" role="button" data-type="phone" data-role="change-input">
				<small>또는 휴대폰으로 받기</small>
			</a>
		</nav>
	  <div class="content">
	    <div class="content-padded">

				<div class="form-list floating px-3 mb-3">
					<div class="input-row position-relative d-none" data-role="input-phone">
						<label>휴대폰 번호(숫자만)</label>
						<input type="number" name="phone" placeholder="휴대폰 번호" data-role="phone" autocomplete="off" tabindex="1">
						<div class="invalid-tooltip" data-role="phoneErrorBlock"></div>
					</div>
					<div class="input-row position-relative" data-role="input-email">
						<label>이메일 주소</label>
						<input type="email" name="email" placeholder="이메일 주소" data-role="email" autocomplete="off">
						<div class="invalid-tooltip" data-role="emailErrorBlock"></div>
					</div>
				</div>

				<ul class="f13 text-muted">
					<li>인증번호를 받을 정보를 입력해 주세요.</li>
					<li>본인 확인을 통해 비밀번호를 재설정 하실 수 있습니다.</li>
					<li>비밀번호는 암호화 저장되어 분실 시 찾아드릴 수 없습니다.</li>
				</ul>

	    </div><!-- /.content-padded -->

	  </div><!-- /.content -->
	</div><!-- /.page -->

	<div class="page right" id="page-pw-code">
		<header class="bar bar-nav bar-light bg-faded px-0">
      <a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
      <button class="btn btn-link btn-nav pull-right p-l-1 p-r-2" data-type="phone" data-act="confirm_code" data-device="mobile" data-role="confirm_code">
        확인
      </button>
			<button class="btn btn-link btn-nav pull-right p-l-1 p-r-2 d-none" data-type="phone" data-act="change_pw" data-device="mobile" data-role="change_pw">
				변경
			</button>
      <h1 class="title">비밀번호 재설정</h1>
    </header>
    <main class="content">

      <div class="content-padded" data-role="confirm_code">
        <div class="form-list floating px-3">
          <div class="input-row position-relative" data-role="input-phone">
            <label>인증번호 (6자리)</label>
            <input type="number" name="confirm_phone_code" data-role="confirm_phone_code" placeholder="인증번호" autocomplete="off">
            <div class="invalid-tooltip" data-role="phoneCodeBlock"></div>
          </div>
        </div>
        <small class="form-text text-success px-3">
          <span data-role="target"></span> 로 인증번호를 발송했습니다.<br>
          6자리 인증번호를 입력해 주세요.  (유효시간 <?php echo $d['member']['join_keyexpire'] ?>분) <span data-role="countdown" data-email-countdown="">[00:00]</span><br>
          인증번호가 오지 않으면 입력정보가 정확한지 확인하여 주세요.
        </small>
      </div><!-- /.content-padded -->

			<div class="content-padded d-none" data-role="change_pw">

				<form id="pwResetForm" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
	        <input type="hidden" name="r" value="<?php echo $r?>">
	        <input type="hidden" name="m" value="member">
	        <input type="hidden" name="a" value="pw_reset">
					<input type="hidden" name="act" value="change_pw">
					<input type="hidden" name="device" value="mobile">
					<input type="hidden" name="code" value="">
					<input type="hidden" name="target" value="">
					<input type="hidden" name="type" value="">
					<input type="hidden" name="check_pw1" value="0">
					<input type="hidden" name="check_pw2" value="0">

					<div class="form-list floating px-3">
						<div class="input-row position-relative" data-role="input-phone">
							<label>비밀번호(6~16자리)</label>
							<input type="password" name="pw1" placeholder="비밀번호" autocomplete="off" data-role="pw1">
							<div class="invalid-tooltip" data-role="pw1CodeBlock" id="pw1-feedback"></div>
						</div>
						<div class="input-row position-relative" data-role="input-phone">
							<label>비밀번호 재입력</label>
							<input type="password" name="pw2" placeholder="비밀번호 재입력" autocomplete="off" data-role="pw2">
							<div class="invalid-tooltip" data-role="pw2CodeBlock"  id="pw2-feedback"></div>
						</div>
					</div>

				</form>
			</div><!-- /.content-padded -->

    </main>
	</div><!-- /.page -->
</div><!-- /.modal -->


<script>

var modal_pwReset = $('#modal-pwReset')
var page_pw_main = $('#page-pw-main')
var page_pw_code = $('#page-pw-code')

function doPwCountdown(type) {
  page_pw_code.find('[data-'+type+'-countdown]').each(function() {
    var $this = $(this), finalDate = $(this).data(type+'-countdown');
    $this.html('');
    $this.countdown(finalDate, function(event) {
      $this.html('['+event.strftime('%M:%S')+']');
    });
  });
};

function doPwChangeInput(type,id) {
	var page = $('#page-pw-main')
  page.find('[data-act="send_code"]').attr('data-type',type)
  page.find('.input-row').removeClass('active') //상태초기화
  page.find('input').removeClass('is-invalid is-valid') //에러항목 초기화
  if (type=='email') {
    page.find('[name="phone"]').val('') // 입력항목 초기화
    page.find('[data-role="input-email"]').removeClass('d-none')
		if (id) page.find('[data-role="input-email"]').addClass('active')
    page.find('[data-role="input-phone"]').addClass('d-none')
		page.find('.bar-tab [data-type="phone"]').removeClass('d-none')
		page.find('.bar-tab [data-type="email"]').addClass('d-none')
    setTimeout(function(){ page.find('[name="email"]').focus().val(id) }, 500);
  } else {
    page.find('[name="email"]').val('') // 입력항목 초기화
    page.find('[data-role="input-phone"]').removeClass('d-none')
		if (id) page.find('[data-role="input-phone"]').addClass('active')
    page.find('[data-role="input-email"]').addClass('d-none')
		page.find('.bar-tab [data-type="email"]').removeClass('d-none')
		page.find('.bar-tab [data-type="phone"]').addClass('d-none')
    setTimeout(function(){ page.find('[name="phone"]').focus().val(id) }, 500);
  }
};

function pwResetCheck(obj,layer) {
	var f = document.getElementById('pwResetForm');
	if (!obj.value)
	{
		obj.classList.remove('is-invalid');
		getId(layer).innerHTML = '';
	}
	else
	{
		if (obj.name == 'pw1') {
			f.classList.remove('was-validated');

			if (f.pw1.value.length < 6 || f.pw1.value.length > 16) {

				f.check_pw1.value = '0';
				f.classList.remove('was-validated');
				obj.classList.add('is-invalid');
				obj.classList.remove('is-valid');

				getId(layer).innerHTML = '영문/숫자 2개 이상의 조합으로 최소 6~16자로 입력하셔야 합니다.';
				obj.focus();
				return false;
			}
			if (getTypeCheck(f.pw1.value,"abcdefghijklmnopqrstuvwxyz")) {
				getId(layer).innerHTML = '비밀번호가 영문만으로 입력되었습니다.\n영문/숫자 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
				obj.focus();
				return false;
			}
			if (getTypeCheck(f.pw1.value,"1234567890")) {
				getId(layer).innerHTML = '비밀번호가 숫자만으로 입력되었습니다.\n영문/숫자 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
				obj.focus();
				return false;
			}
			f.pw1.classList.add('is-valid');
			f.pw1.classList.remove('is-invalid');
			getId(layer).innerHTML = '';
			f.check_pw1.value = '1';
		}

		if (obj.name == 'pw2') {
			f.classList.remove('was-validated');
			obj.classList.add('is-invalid');
			obj.classList.remove('is-valid');

			if (f.pw1.value != f.pw2.value)
			{
				getId(layer).innerHTML = '비밀번호가 일치하지 않습니다.';
				f.classList.remove('was-validated');
				obj.focus();
				f.check_pw2.value = '0';
				return false;
			}

			f.pw2.classList.add('is-valid');
			f.pw2.classList.remove('is-invalid');
			getId(layer).innerHTML = '';

		 f.check_pw2.value = '1';
		}

	}
}

$(function () {
	//비밀번호 유용성 체크
	page_pw_code.find('.input-row input').keyup(function(){
		var item = $(this).data('role')
		var item_pw_check = page_pw_code.find('[name=check_pw]').val()
		if (item =='pw1') {
			element = document.querySelector('[name="pw1"]');
			pwResetCheck(element,'pw1-feedback')
		}
		if (item =='pw2') {
			element = document.querySelector('[name="pw2"]');
			pwResetCheck(element,'pw2-feedback')
		}
	});

	// 비밀번호 초기화 모달이 열리기전에, 액션페이지 초기화
	modal_pwReset.on('show.rc.modal', function (event) {
		var button = $(event.relatedTarget)
		var type = button.attr('data-type')?button.attr('data-type'):'email';
		var id = button.attr('data-id')
		doPwChangeInput(type,id)
	  page_pw_main.addClass('page center').removeClass('transition left')
		page_pw_code.addClass('page right').removeClass('transition center')
	})

	// 비밀번호 초기화 모달이 열린후에..
	modal_pwReset.on('shown.rc.modal', function(event) {
		var input_phone = page_pw_main.find('[data-role="input-phone"]')
		var input_email = page_pw_main.find('[data-role="input-email"]')
		var btn_send = page_pw_main.find('[data-act="send_code"]')

		//각종 상태 초기화
	  page_pw_main.find('input').removeClass('is-invalid is-valid') //에러항목 초기화
	  input_phone.find('[name="phone"]').val('')
	  input_email.find('[name="email"]').val('')
	})

	page_pw_code.on('show.rc.page', function (event) {
		page_pw_code.find('[type="number"]').val('')
		page_pw_code.find('[name="pw1"]').val('')
		page_pw_code.find('[name="pw2"]').val('')
		page_pw_code.find('[data-role="change_pw"]').addClass('d-none')
		page_pw_code.find('[data-role="confirm_code"]').removeClass('d-none')
	})

})


//비번초기화시 입력항목 변경  (휴대폰-이메일 전환)
page_pw_main.on('tap','[data-role="change-input"]',function(){
  var type = $(this).data('type')
	doPwChangeInput(type)
});

// 본인인증 코드발송
page_pw_main.on('tap','[data-act="send_code"]',function(){
  var button = $(this)
  var act = 'send_code'
  var type = button.attr('data-type')
  var device = button.attr('data-device')

  if (type=='email') {
    var input = page_pw_main.find('[name="email"]')
    var _input = document.querySelector('#page-pw-main [name="email"]');
    var target = input.val()
    var msg = page_pw_main.find('[data-role="emailErrorBlock"]')

    // 상태초기화
    input.removeClass('is-invalid is-valid')

    // 이메일 입력폼 유효성 체크
    if (!target) {
      input.focus()
      input.addClass('is-invalid')
      msg.text('이메일을 입력해주세요.')
      return false;
    }
    if (!chkEmailAddr(_input.value)) {
      input.focus()
      input.addClass('is-invalid')
      msg.text('이메일 형식이 아닙니다.')
      return false;
    }
  }

  if (type=='phone') {
    var input = page_pw_main.find('[name="phone"]')
    var _input = document.querySelector('#page-pw-main [name="phone"]');
    var target = input.val()
    var msg = page_pw_main.find('[data-role="phoneErrorBlock"]')

    // 상태초기화
    input.removeClass('is-invalid is-valid')

    // 휴대폰번호 입력폼 유효성 체크
    if (!target) {
      input.focus()
      input.addClass('is-invalid')
      msg.text('휴대폰 번호를 입력해주세요.')
      return false;
    }
    if (!chkPhoneNumber(_input.value)) {
      input.focus()
      input.addClass('is-invalid')
      msg.text('휴대폰 번호 형식이 아닙니다.')
      return false;
    }
  }
  setTimeout(function() { //가상키보드 내려가는 시간 확보
    page_pw_main.loader({ //로더 출력
      text:       "확인중...",
      position:   "overlay"
    });
  }, 300);

  var url = rooturl+'/?r='+raccount+'&m=member&a=pw_reset&act='+act+'&type='+type+'&target='+target+'&device='+device

  getIframeForAction();

	page_pw_code.find('[data-act=confirm_code]').attr('data-type',type);
	page_pw_code.find('[type=number]').attr('data-role','confirm_'+type+'_code').attr('name','confirm_'+type+'_code');
	page_pw_code.find('.invalid-tooltip').attr('data-role',type+'CodeBlock');
	page_pw_code.find('[data-role=countdown]').text('');

  page_pw_code.find('[data-role="target"]').text(target)

  setTimeout(function() {
    frames.__iframe_for_action__.location.href = url;
  }, 700);

});

// 본인인증 코드확인
page_pw_code.on('tap','[data-act="confirm_code"]',function(){
  var button = $(this)
  var act = 'confirm_code'
  var type = button.data('type')
  var device = button.data('device')

  if (type=='email') {
    var input = page_pw_code.find('[name="confirm_email_code"]')
    var code = input.val()
    var msg = page_pw_code.find('[data-role="emailCodeBlock"]')

    // 상태초기화
    input.removeClass('is-invalid is-valid')

    // 인증번호 입력폼 유효성 체크
    if (!code) {
      input.focus()
      input.addClass('is-invalid')
      msg.text('인증번호를 입력해주세요.')
      return false;
    }
  }

  if (type=='phone') {
    var input = page_pw_code.find('[name="confirm_phone_code"]')
    var code = input.val()
    var msg = page_pw_code.find('[data-role="phoneCodeBlock"]')

    // 상태초기화
    input.removeClass('is-invalid is-valid')

    // 인증번호 입력폼 유효성 체크
    if (!code) {
      input.focus()
      input.addClass('is-invalid')
      msg.text('인증번호를 입력해주세요.')
      return false;
    }
  }
  setTimeout(function() { //가상키보드 내려가는 시간 확보
    page_pw_code.loader({ //로더 출력
      text:       "확인중...",
      position:   "overlay"
    });
  }, 300);

  var url = rooturl+'/?r='+raccount+'&m=member&a=pw_reset&act='+act+'&type='+type+'&code='+code+'&device='+device

  getIframeForAction();
  setTimeout(function() {
    frames.__iframe_for_action__.location.href = url;
  }, 700);

});

// 비밀번호 변경
page_pw_code.on('tap','[data-act="change_pw"]',function(){
	$('#pwResetForm').submit()
});

$('#pwResetForm').submit( function(e){
	e.preventDefault();
	e.stopPropagation();
	var form = $(this)
	var formID = form.attr('id')
	var f = document.getElementById(formID);

	if (f.check_pw1.value == '0' || f.check_pw2.value == '0') {
		e.preventDefault();
		e.stopPropagation();
	}

	page_pw_code.loader({ //로더 출력
		text:       "처리중...",
		position:   "overlay"
	});

	form.find('[name="form"]').val('#'+formID);
	form.find('[type="submit"]').attr("disabled",true);
	form.find('.form-control').removeClass('is-invalid')  //에러이력 초기화
	setTimeout(function(){
			getIframeForAction(f);
			f.submit();
		}, 500);
	}
);


modal_pwReset.find(".form-list.floating .input-row input").on('keyup', function() {
	$(this).removeClass('is-invalid') // 에러이력 초기화
	if ($(this).val().length >= 1) {
		$(this).parents('.input-row').addClass('active');
	} else {
		$(this).parents('.input-row').removeClass('active');
	}
})


popup_login_guide.on('click','[data-toggle="login"]',function(){
  history.back();
  setTimeout(function(){
		modal_login.modal();
  }, 200);
});


</script>
