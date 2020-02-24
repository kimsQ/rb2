<!--
로그인 관련 컴포넌트 모음
1. 모달 : modal-login :    로그인 시작모달 (로그인 방식선택)
2. 모달 : modal-combine :  소셜미디어 사용자인증 후 연결정보 입력 (기존 회원중에 동일한 이메일이 존재하나, 본인인증되지 않은 이메일일 경우)
3. 모달 : modal-pwReset :  비밀번호 초기화
-->

<!-- 1. 일반모달 : 로그인 -->
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-body">
        <h3 class="text-center my-4">회원 로그인</h3>

        <?php if ($d['member']['login_emailid']): ?>
        <form class="px-4" id="modal-loginform" action="<?php echo $g['s']?>/" method="post">
          <input type="hidden" name="r" value="<?php echo $r?>">
          <input type="hidden" name="a" value="login">
          <input type="hidden" name="form" value="">

          <div class="form-group position-relative">
            <label class="sr-only">이메일 또는 휴대폰 번호</label>
            <input type="text" class="form-control form-control-lg" name="id" placeholder="이메일 또는 휴대폰 번호" tabindex="1" autocorrect="off" autocapitalize="off" required>
            <div class="invalid-tooltip" data-role="idErrorBlock"></div>
          </div>
          <div class="form-group position-relative">
            <label class="sr-only">패스워드</label>
            <input type="password" class="form-control form-control-lg" name="pw" tabindex="2" required placeholder="비밀번호를 입력하세요.">
            <div class="invalid-tooltip" data-role="passwordErrorBlock"></div>
          </div>

          <div class="d-flex justify-content-between align-items-center">

            <?php if ($d['member']['login_cookie']): ?>
            <div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#modal-collapsealert">
              <input type="checkbox" class="custom-control-input" id="modal-login-cookie" name="login_cookie" value="checked">
              <label class="custom-control-label" for="modal-login-cookie">로그인 상태 유지</label>
            </div>
            <?php endif; ?>

            <a class="small muted-link" href="#modal-pwReset" data-toggle="changeModal">비밀번호를 잊으셨나요?</a>
          </div>

          <div class="collapse" id="modal-collapsealert">
            <div class="alert alert-light border f12 mt-3">
              개인정보 보호를 위해, 개인 PC에서만 사용해 주세요.
            </div>
          </div>

          <div class="my-3">
            <button type="submit" class="btn btn-outline-primary btn-lg btn-block" data-role="submit" tabindex="3">
              <span class="not-loading">로그인</span>
              <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 로그인중 ...</span>
            </button>
          </div>
        </form>
        <?php endif; ?>

        <?php if ($d['member']['login_emailid'] && $d['member']['login_social']): ?>
        <span class="section-divider" style="z-index: 1080;"><span>또는</span></span>
        <?php endif; ?>

        <?php if ($d['member']['login_social']): ?>
        <div class="mx-auto mt-3 px-4">

          <?php if ($d['connect']['use_n']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-naver" data-connect="naver" role="button">
            <span></span>
            <span class="f14">네이버로 로그인</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_k']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-kakao" data-connect="kakao" role="button">
            <span></span>
            <span class="f14">카카오톡으로 로그인</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_g']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-google" data-connect="google" role="button">
            <span class="fa fa-google"></span>
            <span class="f14">구글로 로그인</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_f']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-facebook" data-connect="facebook" role="button">
            <span class="fa fa-facebook"></span>
            <span class="f14">페이스북으로 로그인</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_i']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-instagram" data-connect="instagram" role="button">
            <span class="fa fa-instagram"></span>
            <span class="f14">인스타그램으로 로그인</span>
          </button>
          <?php endif; ?>
        </div>
        <?php endif; ?>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-link muted-link" data-dismiss="modal">닫기</button>
        <a href="#modal-join" data-toggle="changeModal" data-start="" tabindex="6" class="btn btn-link muted-link">회원계정이 없으신가요 ?</a>
      </div>
    </div>
  </div>
</div>

<?php if ($call_modal_combine): ?>
<?php
$avatar_data=array('src'=>$_photo,'width'=>150,'height'=>150);
$user_avatar_src=getTimThumb($avatar_data);
$_SESSION['SL'] = ''; //세션 비우기
?>

<div class="modal fade" id="modal-combine" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
    <div class="modal-content">

      <div class="modal-body">

        <div class="text-center my-3">
          <span class="position-relative d-inline-block">
            <?php if ($_photo): ?>
            <img src="<?php echo $user_avatar_src ?>" alt=<?php echo $name ?>"" class="rounded-circle border">
            <?php else: ?>
            <img src="<?php echo $g['s'].'/files/avatar/0.svg' ?>" alt=<?php echo $name ?>"" class="rounded-circle border" width="100">
            <?php endif; ?>
            <span class="position-absolute" style="bottom:0;right:0">
              <img src="<?php echo $g['img_core']?>/sns/<?php echo $sns_name ?>.png" alt="<?php echo $sns_name ?>" class="rounded-circle" width="48">
            </span>
          </span>
        </div>

        <div class="text-center mb-3">
          <h2>계정통합</h2>
          <span class="f13 text-muted">
            <?php echo $name ?>님, 반갑습니다. <br>
            하나의 회원계정으로 다양한 서비스를 이용해 보세요.
          </span>
        </div>

        <form class="px-4" id="modal-combineform" action="<?php echo $g['s']?>/" method="post">
          <input type="hidden" name="r" value="<?php echo $r?>">
          <input type="hidden" name="a" value="login">
          <input type="hidden" name="sns_access_token" value="<?php echo $sns_access_token?>">
          <input type="hidden" name="sns_refresh_token" value="<?php echo $sns_refresh_token?>">
          <input type="hidden" name="sns_expires_in" value="<?php echo $sns_expires_in?>">
          <input type="hidden" name="snsname" value="<?php echo $sns_name?>">
          <input type="hidden" name="snsuid" value="<?php echo $snsuid?>">
          <input type="hidden" name="_photo" value="<?php echo $_photo ?>">
          <input type="hidden" name="form" value="">

          <?php if ($has_sns): ?> <!-- 동일한 이메일로 이미 가입된 소셜로그인 전용 계정이 있을 경우 -->

            <div class="alert alert-warning f13" role="alert">
              <strong><?php echo $email ?></strong>로 이미 연결된 <?php echo $has_sns_ko ?> 계정이 확인 되었습니다.
            </div>
            <button type="button" class="btn btn-lg btn-block btn-social btn-<?php echo $has_sns ?>" data-connect="<?php echo $has_sns ?>" role="button">
              <?php if ($has_sns=='naver' || $has_sns=='kakao'): ?>
              <span></span>
              <?php else: ?>
              <span class="fa fa-<?php echo $has_sns ?>"></span>
              <?php endif; ?>
              <span class="f14"><?php echo $has_sns_ko ?> 으로 로그인</span>
            </button>
            <div class="mt-3 text-muted small">
              <?php echo $has_sns_ko ?>로 로그인 후, 설정에서 <?php echo $sns_name_ko ?> 계정을 통합 할수 있습니다.
            </div>
          <?php else: ?>
          <div class="form-group position-relative">
            <label class="sr-only">이메일 또는 휴대폰번호</label>
            <input type="text" class="form-control form-control-lg" name="id" placeholder="아이디 또는 이메일" tabindex="1" value="<?php echo $email ?>" <?php echo $email?' readonly':'' ?>>
            <small class="form-text text-danger mt-2">
              회원님의 이메일로 이미 가입된 회원계정이 확인 되었습니다.<br>
              비밀번호를 입력 하시면 <?php echo $sns_name_ko ?> 계정이 자동으로 통합 됩니다.
            </small>
          </div>

          <div class="form-group position-relative">
            <label>패스워드</label>
            <input type="password" class="form-control form-control-lg" name="pw" tabindex="2" placeholder="비밀번호를 입력하세요.">
            <div class="invalid-tooltip" data-role="passwordErrorBlock" id="pw-feedback"></div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#modal-collapsealert">
              <input type="checkbox" class="custom-control-input" id="modal-combine-cookie" name="login_cookie" value="checked">
              <label class="custom-control-label" for="modal-combine-cookie">로그인 상태 유지</label>
            </div>
            <a class="small muted-link" href="<?php echo RW('mod=password_reset')?>">비밀번호를 잊으셨나요?</a>
          </div>

          <div class="collapse" id="modal-collapsealert">
            <div class="alert alert-light border f12 mt-3">
              개인정보 보호를 위해, 개인 PC에서만 사용해 주세요.
            </div>
          </div>

          <div class="my-3">
            <button type="submit" class="btn btn-outline-primary btn-lg btn-block" data-role="submit" tabindex="3">
              <span class="not-loading">연결하기</span>
              <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 연결중 ...</span>
            </button>
          </div>
          <?php endif; ?>

        </form>

      </div>
      <div class="modal-footer p-2">
        <button type="button" class="btn btn-link btn-block muted-link" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

<script>

var modal_combine = $('#modal-combine')
var f = document.getElementById('modal-combineform');

modal_combine.modal('show')

modal_combine.on('shown.bs.modal', function () {
  $(this).find('[name="pw"]').trigger('focus')
})

modal_combine.find('.form-control').keyup(function() {
  $(this).removeClass('is-invalid') //에러 흔적 초기화
});

//modal 계정통합 - 실행
modal_combine.find('form').submit(function(e){
 e.preventDefault();
 e.stopPropagation();

 if (f.pw.value == '') {
   f.pw.classList.add('is-invalid');
   getId('pw-feedback').innerHTML = '비밀번호를 입력해주세요.';
   f.pw.focus();
   return false;
 }

 var form = $(this)
 siteLogin(form)
});


</script>

<?php endif; ?>


<!-- 3. 모달 : modal-pwReset :  비밀번호 초기화 -->
<div class="modal" id="modal-pwReset" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header border-bottom-0 d-flex flex-column" style="background-color: rgba(0,0,0,.03);">
        <h5 class="modal-title mx-auto">비밀번호 재설정</h5>
      </div>

      <?php if ($d['member']['join_byEmail'] || $d['member']['join_byPhone']): ?>
      <div class="card border-0" style="margin-top: -15px" data-role="confirm_code">

        <div class="card-header">
          <ul class="nav nav-tabs nav-justified card-header-tabs">
            <?php if ($d['member']['join_byEmail']): ?>
            <li class="nav-item">
              <a class="nav-link<?php echo $d['member']['join_byEmail']?' active':'' ?>" id="tab-email" data-toggle="tab" href="#pane-pw-email">
                이메일로 받기
              </a>
            </li>
          <?php endif; ?>

            <?php if ($d['member']['join_byPhone']): ?>
            <li class="nav-item">
              <a class="nav-link<?php echo ($d['member']['join_byPhone'] && !$d['member']['join_byEmail'])?' active':'' ?>" id="tab-phone" data-toggle="tab" href="#pane-pw-phone">
                휴대폰으로 받기
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="card-body ">

          <div class="tab-content text-center">
            <div class="tab-pane <?php echo $d['member']['join_byEmail']?' show active':'' ?>" id="pane-pw-email" role="tabpanel" aria-labelledby="tab-email">

              <div class="input-group input-group-lg mt-3">
                <input type="email" class="form-control" name="email" placeholder="이메일 주소" tabindex="1" autocorrect="off" autocapitalize="off" required value="">
                <div class="invalid-tooltip" data-role="emailErrorBlock"></div>
                <div class="input-group-append">
                  <button class="btn btn-light" type="button" data-act="send_code" data-type="email" data-device="desktop">
                    <span class="not-loading">다음</span>
                    <span class="is-loading"><i class="fa fa-spinner fa-spin"></i></span>
                  </button>
                </div>
              </div>

              <div class="d-none mt-3" data-role="verify_email_area">
                <small class="form-text text-success my-3">
                  인증번호를 발송했습니다.(유효시간 <?php echo $d['member']['join_keyexpire'] ?>분)
                  <span data-role="countdown" data-email-countdown="">[00:00]</span><br>
                  위 메일로 발송된 6자리 인증번호를 입력해 주세요.<br>
                  인증번호가 오지 않으면 입력하신 정보가 정확한지 확인하여 주세요.
                </small>

                <div class="input-group input-group-lg">
                  <input type="number" class="form-control" name="confirm_email_code" data-role="confirm_email_code" placeholder="인증번호 입력">
                  <div class="invalid-tooltip" data-role="emailCodeBlock"></div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" data-act="confirm_code" data-type="email" data-device="desktop">
                      <span class="not-loading">확인</span>
                      <span class="is-loading"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                  </div>
                </div>
              </div><!-- /.d-none -->

            </div><!-- /.tab-pane -->
            <div class="tab-pane <?php echo ($d['member']['join_byPhone'] && !$d['member']['join_byEmail'])?' show active':'' ?>" id="pane-pw-phone" role="tabpanel" aria-labelledby="tab-phone">

              <div class="input-group input-group-lg mt-3">
                <input type="tel" class="form-control" name="phone" placeholder="휴대폰 번호" tabindex="1" autocorrect="off" autocapitalize="off" required>
                <div class="invalid-tooltip" data-role="phoneErrorBlock"></div>
                <div class="input-group-append">
                  <button class="btn btn-light" type="button" data-act="send_code" data-type="phone" data-device="desktop">
                    <span class="not-loading">다음</span>
                    <span class="is-loading"><i class="fa fa-spinner fa-spin"></i></span>
                  </button>
                </div>
              </div>

              <div class="d-none mt-3" data-role="verify_phone_area">
                <small class="form-text text-success my-3">
                  인증번호를 발송했습니다.(유효시간 <?php echo $d['member']['join_keyexpire'] ?>분)
                  <span data-role="countdown" data-phone-countdown="">[00:00]</span><br>
                  위 휴대폰으로 발송된 6자리 인증번호를 입력해 주세요.<br>
                  인증번호가 오지 않으면 입력하신 정보가 정확한지 확인하여 주세요.
                </small>

                <div class="input-group input-group-lg">
                  <input type="number" class="form-control" name="confirm_phone_code" data-role="confirm_phone_code" placeholder="인증번호 입력">
                  <div class="invalid-tooltip" data-role="phoneCodeBlock">인증번호를 입력해주세요.</div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" data-act="confirm_code" data-type="phone" data-device="desktop">
                      <span class="not-loading">확인</span>
                      <span class="is-loading"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                  </div>
                </div>
              </div><!-- /.d-none -->

            </div><!-- /.tab-pane -->

          </div><!-- /.tab-content -->

          <ul class="list-unstyled f13 text-muted mt-4 mb-1">
            <li>본인인증을 통해 비밀번호를 재설정 하실 수 있습니다.</li>
            <li>인증번호를 받을 곳을 선택해 주세요.</li>
            <li>비밀번호는 암호화 저장되어 분실 시 찾아드릴 수 없습니다.</li>
          </ul>

        </div><!-- /.card-body tab-content-->
      </div><!-- /.card -->
      <?php endif; ?>


      <div class="card d-none" data-role="change_pw">
        <div class="card-body">
          <form id="pwResetForm" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
  	        <input type="hidden" name="r" value="<?php echo $r?>">
  	        <input type="hidden" name="m" value="member">
  	        <input type="hidden" name="a" value="pw_reset">
  					<input type="hidden" name="act" value="change_pw">
  					<input type="hidden" name="device" value="desktop">
  					<input type="hidden" name="code" value="">
  					<input type="hidden" name="target" value="">
  					<input type="hidden" name="type" value="">
  					<input type="hidden" name="check_pw1" value="0">
  					<input type="hidden" name="check_pw2" value="0">

            <div class="form-group position-relative">
              <label>비밀번호(6~16자리)</label>
              <input type="password" class="form-control form-control-lg" name="pw1" placeholder="" autocorrect="off" autocapitalize="off" data-role="pw1">
              <div class="invalid-tooltip" data-role="pw1CodeBlock" id="pw1-feedback"></div>
            </div>

            <div class="form-group position-relative">
              <label>비밀번호 재입력</label>
              <input type="password" class="form-control form-control-lg" name="pw2" placeholder="" autocorrect="off" autocapitalize="off" data-role="pw2">
              <div class="invalid-tooltip" data-role="pw2CodeBlock" id="pw2-feedback"></div>
            </div>

            <div class="mt-4 mb-3">
              <button type="submit" class="btn btn-outline-primary btn-lg btn-block" data-role="submit">
                <span class="not-loading">변경하기</span>
                <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 변경중 ...</span>
              </button>
            </div>

  				</form>
        </div><!-- /.card-body -->
      </div><!-- /.card -->



      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-link muted-link" data-dismiss="modal">닫기</button>
        <a href="#modal-login" data-toggle="changeModal" tabindex="6" class="btn btn-link muted-link">로그인으로 가기</a>
      </div>
    </div>
  </div>
</div>

<script>

var modal_pwReset = $('#modal-pwReset')

function doPwCountdown(type) {
  modal_pwReset.find('[data-'+type+'-countdown]').each(function() {
    var $this = $(this), finalDate = $(this).data(type+'-countdown');
    $this.html('');
    $this.countdown(finalDate, function(event) {
      $this.html('['+event.strftime('%M:%S')+']');
    });
  });
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

  modal_pwReset.on('show.bs.modal', function (e) {
    var modal = modal_pwReset

    //화면 초기화
    modal.find('[data-role="confirm_code"]').removeClass('d-none')
    modal.find('[data-role="change_pw"]').addClass('d-none')
    modal.find('#tab-email').tab('show')
    modal.find('[data-act="send_code"]').prop("disabled",false)
    modal.find('[data-act="send_code"] .not-loading').text('다음')
    modal.find('[data-act="confirm_code"]').prop("disabled",false)
    modal.find('[type="number"]').val('').removeClass('is-invalid')
    modal.find('[name="email"]').val('').removeClass('is-invalid')
    modal.find('[name="phone"]').val('').removeClass('is-invalid')
    modal.find('[data-role="verify_email_area"]').addClass('d-none')
    modal.find('[data-role="verify_phone_area"]').addClass('d-none')
    modal.find('[data-role="pw1"]').val('').removeClass('is-invalid')
    modal.find('[data-role="pw2"]').val('').removeClass('is-invalid')
    modal.find('[name="check_pw1"]').val(0)
    modal.find('[name="check_pw2"]').val(0)
    modal.find('[data-role="submit"]').prop("disabled",false)
  })
  modal_pwReset.on('shown.bs.modal', function (e) {
    var modal = modal_pwReset
    modal.find('[name="email"]').trigger('focus')

  })
  modal_pwReset.find('input').keyup(function() {
  	$(this).removeClass('is-invalid') //에러 발생후 다시 입력 시도시에 에러 흔적 초기화
  });

  //비밀번호 유용성 체크
  modal_pwReset.find('[data-role="change_pw"] input').keyup(function(){
    var modal = modal_pwReset
    var item = $(this).data('role')
    var item_pw_check = modal.find('[name=check_pw]').val()
    if (item =='pw1') {
      element = document.querySelector('[name="pw1"]');
      pwResetCheck(element,'pw1-feedback')
    }
    if (item =='pw2') {
      element = document.querySelector('[name="pw2"]');
      pwResetCheck(element,'pw2-feedback')
    }
  });

})

modal_pwReset.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var pane = $(this).attr('id')
  if (pane=='tab-email') modal_pwReset.find('[name="email"]').focus()
  if (pane=='tab-phone') modal_pwReset.find('[name="phone"]').focus()
})

// 본인인증 코드발송
modal_pwReset.on('click','[data-act="send_code"]',function(){
  var modal = modal_pwReset
  var button = $(this)
  var act = 'send_code'
  var type = button.attr('data-type')
  var device = button.attr('data-device')

  if (type=='email') {
    var input = modal.find('[name="email"]')
    var _input = document.querySelector('#modal-pwReset [name="email"]');
    var target = input.val()
    var msg = modal.find('[data-role="emailErrorBlock"]')

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
    var input = modal.find('[name="phone"]')
    var _input = document.querySelector('#modal-pwReset [name="phone"]');
    var target = input.val()
    var msg = modal.find('[data-role="phoneErrorBlock"]')

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

  button.attr('disabled',true) //버튼 로딩처리
  var url = rooturl+'/?r='+raccount+'&m=member&a=pw_reset&act='+act+'&type='+type+'&target='+target+'&device='+device

  getIframeForAction();

	//modal.find('[data-act=confirm_code]').attr('data-type',type);
	//modal.find('[type=number]').attr('data-role','confirm_'+type+'_code').attr('name','confirm_'+type+'_code');
	//modal.find('.invalid-tooltip').attr('data-role',type+'CodeBlock');
	modal.find('[data-role=countdown]').text('');

  modal.find('[data-role="target"]').text(target)

  setTimeout(function() {
    frames.__iframe_for_action__.location.href = url;
  }, 700);

});

// 본인인증 코드확인
modal_pwReset.on('click','[data-act="confirm_code"]',function(){
  var modal = modal_pwReset
  var button = $(this)
  var act = 'confirm_code'
  var type = button.data('type')
  var device = button.data('device')

  if (type=='email') {
    var input = modal.find('[name="confirm_email_code"]')
    var code = input.val()
    var msg = modal.find('[data-role="emailCodeBlock"]')

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
    var input = modal.find('[name="confirm_phone_code"]')
    var code = input.val()
    var msg = modal.find('[data-role="phoneCodeBlock"]')

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

  button.attr('disabled',true) //버튼 로딩처리
  var url = rooturl+'/?r='+raccount+'&m=member&a=pw_reset&act='+act+'&type='+type+'&code='+code+'&device='+device

  getIframeForAction();
  setTimeout(function() {
    frames.__iframe_for_action__.location.href = url;
  }, 700);

});

// 비밀번호 변경
$('#pwResetForm').submit( function(e){
	e.preventDefault();
	e.stopPropagation();
	var form = $(this)
	var formID = form.attr('id')
	var f = document.getElementById(formID);

	if (f.check_pw1.value == '0' || f.check_pw2.value == '0') {
   return false;
	}

	form.find('[name="form"]').val('#'+formID);
	form.find('[type="submit"]').attr("disabled",true); //버튼 로딩처리
	form.find('.form-control').removeClass('is-invalid')  //에러이력 초기화
	setTimeout(function(){
			getIframeForAction(f);
			f.submit();
		}, 500);
	}
);



</script>
