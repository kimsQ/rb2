<div id="modal-join" class="modal fast">

  <div class="page center" id="page-join-main">
    <header class="bar bar-nav bar-light bg-faded px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title">
        회원가입
      </h1>
    </header>
    <nav class="bar bar-tab bar-light bg-faded">
      <a class="tab-item active" role="button" data-toggle="changeModal" href="#modal-login">
        <small>이미 가입하셨나요?  <span class="pl-2">로그인 하기</span></small>
      </a>
    </nav>
    <main class="content bg-faded">

      <div class="buttons content-padded">
        <button type="button"class="btn btn-secondary  btn-login-phone btn-block" data-toggle="page" data-target="#page-join-form" data-start="#page-join-main">
          이메일<?php echo $d['member']['join_byPhone']?' 또는 휴대폰 번호':'' ?>로  가입
        </button>

        <?php if ($d['member']['join_bySocial']): ?>
        <span class="section-divider"><span>또는</span></span>

        <?php if ($d['connect']['use_n']): ?>
        <button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-naver text-xs-center" data-connect="naver" role="button">
					<span></span>
					네이버로 가입
				</button>
        <?php endif; ?>

        <?php if ($d['connect']['use_k']): ?>
        <button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-kakao text-xs-center" data-connect="kakao" role="button">
					<span></span>
					카카오톡으로 가입
				</button>
        <?php endif; ?>

        <?php if ($d['connect']['use_g']): ?>
        <button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-google text-xs-center" data-connect="google" role="button">
					<span class="fa fa-google"></span>
					구글로 가입
				</button>
        <?php endif; ?>

        <?php if ($d['connect']['use_f']): ?>
        <button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-facebook text-xs-center" data-connect="facebook" role="button">
					<span class="fa fa-facebook"></span>
					페이스북으로 가입
				</button>
        <?php endif; ?>

        <?php if ($d['connect']['use_i']): ?>
        <button type="button" class="btn btn-lg btn-secondary btn-block btn-social btn-instagram text-xs-center" data-connect="instagram" role="button">
					<span class="fa fa-instagram"></span>
					인스타그램으로 가입
				</button>
        <?php endif; ?>

        <?php endif; ?>

      </div>

    </main>
  </div><!-- /#page-main -->

  <div class="page right" id="page-join-form">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <button class="btn btn-link btn-nav pull-right p-l-1 p-r-2" data-act="send_code" data-type="email" data-device="mobile" tabindex="2">
        <span class="not-loading">다음</span>
        <span class="is-loading">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="sr-only">처리중...</span>
          </div>
        </span>
      </button>
      <h1 class="title">회원가입</h1>
    </header>

    <?php if ($d['member']['join_byPhone']): ?>
    <nav class="bar bar-tab bar-light bg-faded">
      <a class="tab-item d-none" role="button" data-type="email" data-role="change-input">
        <small>또는 이메일 가입</small>
      </a>
      <a class="tab-item" role="button" data-type="phone" data-role="change-input">
        <small>또는 휴대폰 번호로 가입</small>
      </a>
    </nav>
    <?php endif; ?>

    <main class="content">

      <div class="content-padded" autocomplete="off">

        <div class="form-list floating px-3">
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

      </div><!-- /.content-padded -->

    </main>
  </div><!-- /#page-join -->

  <div class="page right" id="page-join-code">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <button class="btn btn-link btn-nav pull-right p-l-1 p-r-2" data-type="phone" data-act="confirm_code" data-device="mobile">
        확인
      </button>
      <h1 class="title">회원가입</h1>
    </header>
    <main class="content">

      <div class="content-padded">
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

    </main>
  </div>

</div><!-- /.modal -->


<?php if ($call_modal_join_site): ?>
<?php

  $email	= $_SESSION['JOIN']['email']; //본인확인된 이메일
  $phone	= $_SESSION['JOIN']['phone']; //본인확인된 휴대폰번호
  $_SESSION['JOIN'] = ''; //본인확인 세션 초기화
?>

<div id="modal-join-site" class="modal zoom">

  <section class="page center" id="page-site-main">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <button class="btn btn-link btn-nav pull-right p-x-1" data-role="showAgreement" disabled>
        다음
      </button>
      <h1 class="title">
        회원가입
      </h1>
    </header>

    <main class="content">

      <form class="content-padded" id="joinForm" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
        <input type="hidden" name="r" value="<?php echo $r?>">
        <input type="hidden" name="m" value="member">
        <input type="hidden" name="a" value="join">
        <input type="hidden" name="phone" value="<?php echo $phone ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
        <input type="hidden" name="check_pw" value="0">
        <input type="hidden" name="check_name" value="0">
        <input type="hidden" name="event" value="">

        <div class="form-list floating px-3">
          <div class="input-row position-relative">
            <label>비밀번호</label>
            <input type="password" name="pw1" placeholder="비밀번호" data-role="pw">
            <div class="invalid-tooltip" id="pw-feedback">비밀번호를 입력해주세요.</div>
          </div>
          <div class="input-row position-relative">
            <label>이름</label>
            <input type="text" name="name" placeholder="이름"  data-role="name">
            <div class="invalid-tooltip" id="name-feedback">이름을 입력해주세요.</div>
          </div>
        </div>
      </form>

      <div class="content-padded d-none" data-role="agreement">
        <p class="pl-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-all">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">전체동의 <small class="text-muted">(선택 항목 포함)</small></span>
          </label>
        </p>
        <p class="pl-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-policy">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">
              이용약관과 개인정보수집안내
              <button type="button"
                data-target="#page-site-doc"
                data-start="#page-site-main"
                data-toggle="page"
                class="btn btn-secondary btn-sm ml-2">보기</button>
            </span>
            </span>
          </label>
        </p>
        <p class="pl-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-event">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">이벤트,서비스 안내 수신 <small class="text-muted">(선택)</small></span>
          </label>
        </p>
        <button type="button" class="btn btn-secondary btn-block mt-4 js-submit" disabled>
          확인
        </button>
      </div>

    </main>
  </section>

  <section class="page right" id="page-site-doc">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title">서비스 약관</h1>
    </header>

    <div class="bar bar-standard bar-header-secondary bar-light bg-white p-x-0">
			<nav class="nav nav-inline">
        <a class="nav-link active" href="#page-site-policy" data-toggle="tab">이용약관</a>
			  <a class="nav-link" href="#page-site-privacy" data-toggle="tab">개인정보취급방침</a>
			</nav>
		</div>

    <div class="content">
      <div class="tab-pane content-padded" id="page-site-policy">
      </div>
      <div class="tab-pane content-padded d-none" id="page-site-privacy">
      </div>
		</div>
  </section>

</div><!-- /.modal -->

<script>

  var modal_join_site = $('#modal-join-site')
  var f = document.getElementById('joinForm');

  //회원가입 항목 유용성 체크
  function joinCheck(obj,layer) {
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

          f.check_pw.value = '0';
          f.classList.remove('was-validated');
          obj.classList.add('is-invalid');
          obj.classList.remove('is-valid');

    			getId(layer).innerHTML = '영문/숫자 2개 이상의 조합으로 최소 6~16자로 입력하셔야 합니다.';
    			return false;
    		}
    		if (getTypeCheck(f.pw1.value,"abcdefghijklmnopqrstuvwxyz")) {
    			getId(layer).innerHTML = '비밀번호가 영문만으로 입력되었습니다.\n영문/숫자 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
    			f.pw1.focus();
    			return false;
    		}
    		if (getTypeCheck(f.pw1.value,"1234567890")) {
    			getId(layer).innerHTML = '비밀번호가 숫자만으로 입력되었습니다.\n영문/숫자 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
    			f.pw1.focus();
    			return false;
    		}
    		f.pw1.classList.add('is-valid');
    		f.pw1.classList.remove('is-invalid');
    		getId(layer).innerHTML = '';
        f.check_pw.value = '1';
      }

      if (obj.name == 'name') {
        if (obj.value.length > 1) {
          f.check_name.value = '1';
        } else {
          f.check_name.value = '0';
        }
      }
  	}
  }

  modal_join_site.modal('show')  //가입모달 호출

  modal_join_site.on('shown.rc.modal', function () {
    modal_join_site.find('[name="pw1"]').focus()
  })

  //회원가입 시 입력항목 유용성 체크
  modal_join_site.find('.input-row input').keyup(function(){
    var item = $(this).data('role')
    var item_pw_check = modal_join_site.find('[name=check_pw]').val()
    var item_name_check = modal_join_site.find('[name=check_name]').val()

    if (item=='pw') {
      element = document.querySelector('[name="pw1"]');
      joinCheck(element,'pw-feedback')
    }
    if (item=='name') {
      element = document.querySelector('[name="name"]');
      joinCheck(element,'name-feedback')
    }

    if (item_pw_check==1 && item_name_check==1) {
      $('[data-role="showAgreement"]').removeAttr('disabled')
    } else {
      $('[data-role="showAgreement"]').attr('disabled',true)
    }
  });

  // 회원가입 시 '다음'버튼 터치시 동의항목 출력
  $('body').on('tap click','[data-role="showAgreement"]:enabled',function(){
    var id =  modal_join_site.find('[data-role="phone"]').val()
    var idtype =  'phone'

    $(this).addClass('d-none')
    modal_join_site.find('[data-role="agreement"]').removeClass('d-none')
    modal_join_site.find('.bar-tab').addClass('d-none')

    setTimeout(function(){
      $.notify({message: '약관동의가 필요합니다.'},{type: 'default'});
    }, 500);

  });

  // 회원가입 시 전체동의 체크박스 처리
  modal_join_site.find('#checkbox-all').change(function(e) {
    if ($(this).prop('checked')){
      $('#checkbox-policy').prop('checked',true)
      $('#checkbox-event').prop('checked',true)
      $('#joinForm').find('[name="event"]').val(1)
      modal_join_site.find('.js-submit').removeClass('btn-secondary').addClass('btn-primary').attr('disabled',false) // 확인 버튼 활성화 처리
    } else {
      $('#checkbox-policy').prop('checked',false)
      $('#checkbox-event').prop('checked',false)
      $('#joinForm').find('[name="event"]').val(0)
      modal_join_site.find('.js-submit').addClass('btn-secondary').removeClass('btn-primary').attr('disabled',true) // 확인 버튼 비활성화 처리
    }
  });

  // 회원가입 시 약관사항이 체크되어야 회원가입 확인버튼이 활성화 됨
  modal_join_site.find('#checkbox-policy').change(function(e) {
    if ($(this).prop('checked') && $('#checkbox-policy').prop('checked')){
      modal_join_site.find('.js-submit').removeClass('btn-secondary').addClass('btn-primary').attr('disabled',false) // 확인 버튼 활성화 처리
    } else {
      modal_join_site.find('.js-submit').addClass('btn-secondary').removeClass('btn-primary').attr('disabled',true) // 확인 버튼 비활성화 처리
    }
  });

  // 회원가입 시 아벤트,서비스 안내 수신
  modal_join_site.find('#checkbox-event').change(function(e) {
    if ($(this).prop('checked') && $('#checkbox-event').prop('checked')){
      $('#joinForm').find('[name="event"]').val(1)
    } else {
      $('#joinForm').find('[name="event"]').val(0)
    }
  });

  // 이용약관 / 개인정보취급방침 문서 자세히 보기
  $('#page-site-doc').on('shown.rc.page', function (event) {
    var button = $(event.relatedTarget)
    var type = button.data('type')
    var page = $(this)

    setTimeout(function(){

      page.find('#page-site-policy').loader({  //  로더 출력
        position:   "inside"
      });
      $.post(rooturl+'/?r='+raccount+'&m=site&a=get_postData',{
         id : 'policy',
         _mtype : 'page'
      },function(response){
         page.find('#page-site-policy').loader("hide");
         var result = $.parseJSON(response);
         var policy=result.article;
         page.find('#page-site-policy').html(policy);
      });
      $.post(rooturl+'/?r='+raccount+'&m=site&a=get_postData',{
         id : 'privacy',
         _mtype : 'page'
      },function(response){
         var result = $.parseJSON(response);
         var privacy=result.article;
         page.find('#page-site-privacy').html(privacy);
      });
    }, 300);
  })
  $('#page-site-doc').on('hidden.rc.page', function () {
    var page = $(this)
    page.find('#page-site-policy').html('');
    page.find('#page-site-privacy').html('');
  })

  // 회원가입 실행
  modal_join_site.on('tap click','.js-submit:enabled',function(){
    $(this).attr("disabled",true).text('진행중...');
    setTimeout(function(){
      getIframeForAction(f);
      f.submit();
    }, 300);
  });

</script>
<?php endif; ?>

<?php if ($call_modal_join_social): ?>
<?php
$avatar_data=array('src'=>$_photo,'width'=>150,'height'=>150);
$user_avatar_src=getTimThumb($avatar_data);
$_SESSION['SL'] = ''; //세션 비우기
?>

<!-- 1. 일반모달 : 소셜인증 후, 가입-->
<div id="modal-join-social" class="modal zoom">

  <section class="page center" id="page-social-main">
    <header class="bar bar-nav bar-light bg-faded">
      <a class="icon icon-left-nav pull-left" role="button" data-history="back"></a>
      <button class="btn btn-link btn-nav pull-right p-x-1<?php echo $name && $email?' d-none':'' ?>" data-role="showAgreement" disabled>
        다음
      </button>
      <h1 class="title">
        신규가입
      </h1>
    </header>

    <div class="bar bar-standard bar-header-secondary">
      <h1 class="title">
        <span>
          <?php if ($_photo): ?>
  				<img src="<?php echo $user_avatar_src ?>" alt=<?php echo $name ?>"" class="rounded-circle border" style="width: 2.1875rem">
  				<?php else: ?>
  				<img src="<?php echo $g['s'].'/files/avatar/0.svg' ?>" alt=<?php echo $name ?>"" class="rounded-circle border" style="width: 2.1875rem">
  				<?php endif; ?>
          <img src="<?php echo $g['img_core']?>/sns/<?php echo $sns_name ?>.png" alt="<?php echo $sns_name ?>" class="rounded-circle" style="width: 2.1875rem;margin-left: -0.625rem">
        </span>
        <?php echo $name ?>님
      </h1>
    </div>

    <nav class="bar bar-tab bar-light bg-faded">
      <a class="tab-item active" role="button" data-toggle="changeModal" href="#modal-combine">
        <small>기존회원 이신가요 ?  <span class="pl-2">계정연결하기</span></small>
      </a>
    </nav>

    <main class="content">

      <form class="content-padded" id="joinForm" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
        <input type="hidden" name="r" value="<?php echo $r?>">
        <input type="hidden" name="m" value="member">
        <input type="hidden" name="a" value="join">
        <input type="hidden" name="sns_access_token" value="<?php echo $sns_access_token?>">
        <input type="hidden" name="sns_refresh_token" value="<?php echo $sns_refresh_token?>">
        <input type="hidden" name="sns_expires_in" value="<?php echo $sns_expires_in?>">
        <input type="hidden" name="snsname" value="<?php echo $sns_name?>">
        <input type="hidden" name="snsuid" value="<?php echo $snsuid?>">
        <input type="hidden" name="_photo" value="<?php echo $_photo ?>">
        <input type="hidden" name="check_email" value="<?php echo $email?1:0 ?>">
        <input type="hidden" name="sns_email" value="<?php echo $email?1:0 ?>">
        <input type="hidden" name="event" value="">

        <div class="form-list floating px-3">

          <div class="input-row position-relative<?php echo $email?' active':'' ?>" data-role="input-email">
            <label>이메일 주소</label>
            <input type="email" name="email" placeholder="이메일 주소" data-role="email" value="<?php echo $email ?>"<?php echo $email?' readonly':'' ?> data-role="email">
            <div class="invalid-tooltip" id="email-feedback"></div>
          </div>

          <?php if ($name): ?>
          <input type="hidden" name="name" value="<?php echo $name ?>">
          <?php else: ?>
          <div class="input-row position-relative">
            <label>이름</label>
            <input type="text" name="name" placeholder="이름"  data-role="name" value="<?php echo $name ?>" <?php echo $name?' readonly':'' ?>>
            <div class="invalid-tooltip" id="name-feedback">이름을 입력해주세요.</div>
          </div>
          <?php endif; ?>

        </div>
      </form>

      <div class="content-padded<?php echo $name && $email?'':' d-none'?>" data-role="agreement">
        <p class="pl-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-all">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">전체동의 <small class="text-muted">(선택 항목 포함)</small></span>
          </label>
        </p>
        <p class="pl-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-policy">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">
              이용약관과 개인정보수집안내
              <button type="button"
                data-target="#page-social-doc"
                data-start="#page-social-main"
                data-toggle="page"
                class="btn btn-secondary btn-sm ml-2">보기</button>
            </span>
          </label>
        </p>
        <p class="pl-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-event">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">이벤트,서비스 안내 수신 <small class="text-muted">(선택)</small></span>
          </label>
        </p>
        <button type="button" class="btn btn-secondary btn-block mt-4 js-submit" disabled>
          확인
        </button>
      </div>

      <div class="content-padded text-muted small" data-role="notice">
        <?php echo $sns_name_ko ?> 계정으로 <?php echo $_HS['name'] ?>에 회원가입 합니다.<br>
        가입완료 시에 회원님의 <?php echo $sns_name_ko ?> 계정과 자동연결 됩니다.
      </div>

    </main>
  </section>

  <section class="page right" id="page-social-doc">
    <header class="bar bar-nav bar-light bg-white px-0">
      <button class="btn btn-link btn-nav pull-left p-x-1" data-history="back">
        <span class="icon icon-left-nav"></span>
      </button>
      <h1 class="title">서비스 약관</h1>
    </header>

    <div class="bar bar-standard bar-header-secondary bar-light bg-white p-x-0">
			<nav class="nav nav-inline">
			  <a class="nav-link active" href="#page-social-policy" data-toggle="tab">이용약관</a>
			  <a class="nav-link" href="#page-social-privacy" data-toggle="tab">개인정보취급방침</a>
			</nav>
		</div>
    <div class="content">
      <div class="tab-pane content-padded" id="page-social-policy">
      </div>
      <div class="tab-pane content-padded d-none" id="page-social-privacy">
      </div>
		</div>
  </section>

</div><!-- /.modal -->

<script>

var modal_join_social = $('#modal-join-social')
var f = document.getElementById('joinForm');


modal_join_social.modal('show')

modal_join_social.on('shown.rc.modal', function () {

})

//회원가입 시 입력항목 유용성 체크
modal_join_social.find('.input-row input').keyup(function(){

  var item_email_check = modal_join_social.find('[name=check_email]')

  $(this).removeClass('is-invalid')

  if ($(this).val().length >= 1) {
    $(this).parents('.input-row').addClass('active');
    item_email_check.val(1)
  } else {
    $(this).parents('.input-row').removeClass('active');
    item_email_check.val(0)
  }

  if (item_email_check.val()==1) {
    $('[data-role="showAgreement"]').removeAttr('disabled')
  } else {
    $('[data-role="showAgreement"]').attr('disabled',true)
  }

})

// 회원가입 시 '다음'버튼 터치시 유효성 체크 및 동의항목 출력
$('body').on('tap click','[data-role="showAgreement"]:enabled',function(){
  var _input = document.querySelector('#modal-join-social [data-role="email"]');
  var input =  modal_join_social.find('[data-role="email"]')
  var msg =  modal_join_social.find('#email-feedback')

  if (!chkEmailAddr(_input.value)) {
    input.focus()
    input.addClass('is-invalid')
    msg.text('이메일 형식이 아닙니다.')
    return false;
  }

  $(this).addClass('d-none')
  modal_join_social.find('[data-role="agreement"]').removeClass('d-none')
  modal_join_social.find('.bar-tab').addClass('d-none')

  setTimeout(function(){
    $.notify({message: '약관동의가 필요합니다.'},{type: 'default'});
  }, 500);

});

// 회원가입 시 전체동의 체크박스 처리
modal_join_social.find('#checkbox-all').change(function(e) {
  if ($(this).prop('checked')){
    $('#checkbox-policy').prop('checked',true)
    $('#checkbox-event').prop('checked',true)
    $('#joinForm').find('[name="event"]').val(1)
    modal_join_social.find('.js-submit').removeClass('btn-secondary').addClass('btn-primary').attr('disabled',false) // 확인 버튼 활성화 처리
  } else {
    $('#checkbox-policy').prop('checked',false)
    $('#checkbox-event').prop('checked',false)
    $('#joinForm').find('[name="event"]').val(0)
    modal_join_social.find('.js-submit').addClass('btn-secondary').removeClass('btn-primary').attr('disabled',true) // 확인 버튼 비활성화 처리
  }
});

// 회원가입 시 약관사항이 체크되어야 회원가입 확인버튼이 활성화 됨
modal_join_social.find('#checkbox-policy').change(function(e) {
  if ($(this).prop('checked') && $('#checkbox-policy').prop('checked')){
    modal_join_social.find('.js-submit').removeClass('btn-secondary').addClass('btn-primary').attr('disabled',false) // 확인 버튼 활성화 처리
  } else {
    modal_join_social.find('.js-submit').addClass('btn-secondary').removeClass('btn-primary').attr('disabled',true) // 확인 버튼 비활성화 처리
  }
});

// 회원가입 시 아벤트,서비스 안내 수신
modal_join_social.find('#checkbox-event').change(function(e) {
  if ($(this).prop('checked') && $('#checkbox-event').prop('checked')){
    $('#joinForm').find('[name="event"]').val(1)
  } else {
    $('#joinForm').find('[name="event"]').val(0)
  }
});

// 이용약관 / 개인정보취급방침 문서 자세히 보기
$('#page-social-doc').on('shown.rc.page', function (event) {
  var button = $(event.relatedTarget)
  var type = button.data('type')
  var page = $(this)

  setTimeout(function(){
    page.find('#page-social-policy').loader({  //  로더 출력
      position:   "inside"
    });
    $.post(rooturl+'/?r='+raccount+'&m=site&a=get_postData',{
       id : 'policy',
       _mtype : 'page'
    },function(response){
       page.find('#page-social-policy').loader("hide");
       var result = $.parseJSON(response);
       var policy=result.article;
       page.find('#page-social-policy').html(policy);
    });
    $.post(rooturl+'/?r='+raccount+'&m=site&a=get_postData',{
       id : 'privacy',
       _mtype : 'page'
    },function(response){
       var result = $.parseJSON(response);
       var privacy=result.article;
       page.find('#page-social-privacy').html(privacy);
    });
  }, 300);
})

$('#page-social-doc').on('hidden.rc.page', function () {
  var page = $(this)
  page.find('#page-social-policy').html('');
  page.find('#page-social-privacy').html('');
})

// 회원가입 실행
modal_join_social.on('tap click','.js-submit',function(){
  $(this).attr("disabled",true).text('진행중...');
  setTimeout(function(){
    getIframeForAction(f);
    f.submit();
  }, 300);
});
</script>

<?php endif; ?>

<!-- https://github.com/hilios/jQuery.countdown -->
<?php getImport('jquery.countdown','jquery.countdown.min','2.2.0','js')?>

<script>

var modal_join = $('#modal-join') //회원가입 모달
var page_join_main = $('#page-join-main') // 회원가입 시작페이지
var page_join_form = $('#page-join-form') // 이메일 또는 휴대폰 입력폼 페이지
var page_join_code = $('#page-join-code') // 인증번호 입력폼 페이지
var input_phone = page_join_form.find('[data-role="input-phone"]')
var input_email = page_join_form.find('[data-role="input-email"]')
var btn_send = page_join_form.find('[data-act="send_code"]')

function doCountdown(type) {
  modal_join.find('[data-'+type+'-countdown]').each(function() {
    var $this = $(this), finalDate = $(this).data(type+'-countdown');
    $this.html('');
    $this.countdown(finalDate, function(event) {
      $this.html('['+event.strftime('%M:%S')+']');
    });
  });
};

$(function () {
  // 회원가입 모달이 열리기전에, 액션페이지 초기화
  modal_join.on('show.rc.modal', function () {
    page_join_main.addClass('page center').removeClass('transition left')
  	page_join_form.addClass('page right').removeClass('transition center')
    page_join_code.addClass('page right').removeClass('transition center')
    if ($('#drawer-left').length) {
      setTimeout(function(){ $('#drawer-left').drawer('hide'); }, 1000); // 왼쪽 드로워 닫기
    }
  })
})

//휴대폰(이메일)입력 페이지가 호출될때
page_join_form.on('shown.rc.page', function () {
  //각종 상태 초기화
  page_join_form.find('input').removeClass('is-invalid is-valid') //에러항목 초기화
  page_join_form.find('.input-row').removeClass('active') //상태초기화
  page_join_form.find('.bar-tab [data-type="phone"]').removeClass('d-none')
  page_join_form.find('.bar-tab [data-type="email"]').addClass('d-none')
  input_phone.addClass('d-none')
  input_email.removeClass('d-none')
  input_phone.find('[name="phone"]').val('')
  input_email.find('[name="email"]').val('')
  btn_send.attr('data-type','email')
  setTimeout(function(){input_email.find('[name="email"]').focus();}, 400);
})

//회원가입 시 입력항목 변경  (휴대폰-이메일 전환)
page_join_form.on('tap','[data-role="change-input"]',function(){
  var type = $(this).data('type')
  page_join_form.find('[data-role="change-input"]').removeClass('d-none')
  page_join_form.find('[data-act="send_code"]').attr('data-type',type)
  page_join_form.find('.input-row').removeClass('active') //상태초기화
  $(this).addClass('d-none')
  page_join_form.find('input').removeClass('is-invalid is-valid') //에러항목 초기화
  if (type=='email') {
    page_join_form.find('[name="phone"]').val('') // 입력항목 초기화
    page_join_form.find('[data-role="input-email"]').removeClass('d-none')
    page_join_form.find('[data-role="input-phone"]').addClass('d-none')
    setTimeout(function(){ page_join_form.find('[name="email"]').focus() }, 10);
  } else {
    page_join_form.find('[name="email"]').val('') // 입력항목 초기화
    page_join_form.find('[data-role="input-phone"]').removeClass('d-none')
    page_join_form.find('[data-role="input-email"]').addClass('d-none')
    setTimeout(function(){ page_join_form.find('[name="phone"]').focus() }, 10);
  }
});

$('.page').find(".form-list.floating .input-row input").on('keyup', function(event) {
  if ($(this).val().length >= 1) {
    $(this).parents('.input-row').addClass('active');
  } else {
    $(this).parents('.input-row').removeClass('active');
  }
})

// 상태표시 흔적 초기화
modal_join.find('input').keyup(function(){
  $(this).removeClass('is-invalid is-valid')
});

// 본인인증 코드발송
page_join_form.on('tap','[data-act="send_code"]',function(){
  var button = $(this)
  var act = 'send_code'
  var type = button.attr('data-type')
  var device = button.attr('data-device')

  if (type=='email') {
    var input = page_join_form.find('[name="email"]')
    var _input = document.querySelector('#page-join-form [name="email"]');
    var target = input.val()
    var msg = page_join_form.find('[data-role="emailErrorBlock"]')

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
    var input = page_join_form.find('[name="phone"]')
    var _input = document.querySelector('#page-join-form [name="phone"]');
    var target = input.val()
    var msg = page_join_form.find('[data-role="phoneErrorBlock"]')

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

  button.attr('disabled',true);
  var url = rooturl+'/?r='+raccount+'&m=member&a=join_guestAuth&act='+act+'&type='+type+'&target='+target+'&device='+device

  getIframeForAction();

  page_join_code.find('[data-role="target"]').text(target)

  setTimeout(function() {
    frames.__iframe_for_action__.location.href = url;
  }, 700);

});

// 인증번호 입력페이지가 호출될때
page_join_code.on('shown.rc.page', function (event) {

  //각종 상태 초기화
  page_join_code.find('input').val('')

  page_join_code.find('input').removeClass('is-invalid is-valid') //에러항목 초기화
  page_join_code.find('.input-row').removeClass('active') //상태초기화
  page_join_code.find('.bar-tab [data-type="email"]').removeClass('d-none')
  page_join_code.find('.bar-tab [data-type="phone"]').addClass('d-none')

  setTimeout(function(){page_join_code.find('[name="confirm_phone_code"]').focus();}, 400);
})

// 본인인증 코드확인
page_join_code.on('tap','[data-act="confirm_code"]',function(){
  var button = $(this)
  var act = 'confirm_code'
  var type = button.data('type')
  var device = button.data('device')

  if (type=='email') {
    var input = page_join_code.find('[name="confirm_email_code"]')
    var code = input.val()
    var msg = page_join_code.find('[data-role="emailCodeBlock"]')

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
    var input = page_join_code.find('[name="confirm_phone_code"]')
    var code = input.val()
    var msg = page_join_code.find('[data-role="phoneCodeBlock"]')

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
    page_join_code.loader({ //로더 출력
      text:       "확인중...",
      position:   "overlay"
    });
  }, 300);

  var url = rooturl+'/?r='+raccount+'&m=member&a=join_guestAuth&act='+act+'&type='+type+'&code='+code+'&device='+device

  getIframeForAction();
  setTimeout(function() {
    frames.__iframe_for_action__.location.href = url;
  }, 700);

});

// 탭기능
 $(document).on('tap click','[data-toggle="tab"]',function(event){
  event.preventDefault();
  event.stopPropagation();
  var target =  $(this).attr('href')
  $('[data-toggle="tab"]').removeClass('active')
  $(this).addClass('active')
  $('.tab-pane').addClass('d-none')
  $(target).removeClass('d-none')
});

</script>
