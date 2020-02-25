<!--
회원가입 관련 컴포넌트 모음
1. 모달 : modal-join :         회원가입 시작모달 (회원가입 방식선택)
2. 모달 : modal-join-site :    이메일/휴대폰 일반인증(본인인증) 후 가입정보 입력
3. 모달 : modal-join-social :  소셜미디어 사용자인증 후 가입정보 입력 (기존계정 연결 포함)
-->

<div class="modal" id="modal-join" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header border-bottom-0" style="background-color: rgba(0,0,0,.03);">
        <h5 class="modal-title mx-auto">회원가입</h5>
      </div>

      <?php if ($d['member']['join_byEmail'] || $d['member']['join_byPhone']): ?>
      <div class="card text-center border-0" style="margin-top: -15px">

        <div class="card-header">
          <ul class="nav nav-tabs nav-justified card-header-tabs">
            <?php if ($d['member']['join_byEmail']): ?>
            <li class="nav-item">
              <a class="nav-link<?php echo $d['member']['join_byEmail']?' active':'' ?>" id="tab-email" data-toggle="tab" href="#pane-email">
                이메일로 가입
              </a>
            </li>
          <?php endif; ?>

            <?php if ($d['member']['join_byPhone']): ?>
            <li class="nav-item">
              <a class="nav-link<?php echo ($d['member']['join_byPhone'] && !$d['member']['join_byEmail'])?' active':'' ?>" id="tab-phone" data-toggle="tab" href="#pane-phone">
                휴대폰 번호로 가입
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="card-body tab-content">

          <div class="tab-pane fade<?php echo $d['member']['join_byEmail']?' show active':'' ?>" id="pane-email" role="tabpanel" aria-labelledby="tab-email">

            <div class="input-group input-group-lg mt-3">
              <input type="email" class="form-control" name="email" placeholder="이메일 주소" tabindex="1" autocorrect="off" autocapitalize="off" required value="">
              <div class="invalid-tooltip" data-role="emailErrorBlock"></div>
              <div class="input-group-append">
                <button class="btn btn-light" type="button" data-act="send_code" data-type="email">
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
                  <button class="btn btn-outline-primary" type="button" data-act="confirm_code" data-type="email">
                    <span class="not-loading">확인</span>
                    <span class="is-loading"><i class="fa fa-spinner fa-spin"></i></span>
                  </button>
                </div>
              </div>
            </div><!-- /.d-none -->

          </div><!-- /.tab-pane -->
          <div class="tab-pane fade<?php echo ($d['member']['join_byPhone'] && !$d['member']['join_byEmail'])?' show active':'' ?>" id="pane-phone" role="tabpanel" aria-labelledby="tab-phone">

            <div class="input-group input-group-lg mt-3">
              <input type="tel" class="form-control" name="phone" placeholder="휴대폰 번호" tabindex="1" autocorrect="off" autocapitalize="off" required>
              <div class="invalid-tooltip" data-role="phoneErrorBlock"></div>
              <div class="input-group-append">
                <button class="btn btn-light" type="button" data-act="send_code" data-type="phone">
                  <span class="not-loading">확인</span>
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
                  <button class="btn btn-outline-primary" type="button" data-act="confirm_code"  data-type="phone">
                    <span class="not-loading">확인</span>
                    <span class="is-loading"><i class="fa fa-spinner fa-spin"></i></span>
                  </button>
                </div>
              </div>
            </div><!-- /.d-none -->

          </div><!-- /.tab-pane -->


        </div><!-- /.card-body tab-content-->
      </div><!-- /.card -->
      <?php endif; ?>

      <?php if ($d['member']['join_bySocial']): ?>

      <?php if ($d['member']['join_byEmail'] || $d['member']['join_byPhone']): ?>
      <span class="section-divider" style="z-index: 1080;"><span>또는</span></span>
      <?php endif; ?>

      <div class="modal-body pt-0">

        <div class="mx-auto mt-3">

          <?php if ($d['connect']['use_k']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-kakao" data-connect="kakao" role="button">
            <span></span>
            <span class="f14">카카오톡 계정으로 가입하기</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_n']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-naver" data-connect="naver" role="button">
            <span></span>
            <span class="f14">네이버 계정으로 가입하기</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_g']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-google" data-connect="google" role="button">
            <span class="fa fa-google"></span>
            <span class="f14">구글 계정으로 가입하기</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_f']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-facebook" data-connect="facebook" role="button">
            <span class="fa fa-facebook"></span>
            <span class="f14">페이스북 계정으로 가입하기</span>
          </button>
          <?php endif; ?>

          <?php if ($d['connect']['use_i']): ?>
          <button type="button" class="btn btn-lg btn-block btn-social btn-instagram" data-connect="instagram" role="button">
            <span class="fa fa-instagram"></span>
            <span class="f14">인스타그램 계정으로 가입하기</span>
          </button>
          <?php endif; ?>
        </div>

      </div>
      <?php endif; ?>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-link muted-link" data-dismiss="modal">닫기</button>
        <a href="#modal-login" data-toggle="changeModal" tabindex="6" class="btn btn-link muted-link">로그인으로 가기</a>
      </div>
    </div>
  </div>
</div>

<!-- https://github.com/hilios/jQuery.countdown -->
<?php getImport('jquery.countdown','jquery.countdown.min','2.2.0','js')?>

<script>

  var modal_join = $('#modal-join')

  // 이전입력항목 초기화
  modal_join.on('show.bs.modal', function () {
    modal_join.find('#tab-email').tab('show')
    modal_join.find('input').removeClass('is-invalid').val('')
    modal_join.find('[data-role="verify_email_area"]').addClass('d-none')
    modal_join.find('[data-role="verify_phone_area"]').addClass('d-none')
    modal_join.find('[data-act="send_code"] .not-loading').text('다음')
  })

  modal_join.on('shown.bs.modal', function () {
    modal_join.find('[name="email"]').trigger('focus')
  })

  function doCountdown(type) {
    modal_join.find('[data-'+type+'-countdown]').each(function() {
      var $this = $(this), finalDate = $(this).data(type+'-countdown');
      $this.html('');
      $this.countdown(finalDate, function(event) {
        $this.html('['+event.strftime('%M:%S')+']');
      });
    });
  };

  // 상태표시 흔적 초기화
  modal_join.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    modal_join.find('input').removeClass('is-invalid is-valid')
  })

  // 상태표시 흔적 초기화
  modal_join.find('input').keyup(function(){
    $(this).removeClass('is-invalid is-valid')
  });

  // 본인인증 코드발송
  modal_join.find('[data-act="send_code"]').click(function() {
    var button = $(this)
    var act = 'send_code'
    var type = button.data('type')

    if (type=='email') {
      var input = modal_join.find('[name="email"]')
      var _input = document.querySelector('#modal-join [name="email"]');
      var target = input.val()
      var msg = modal_join.find('[data-role="emailErrorBlock"]')

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
      var input = modal_join.find('[name="phone"]')
      var _input = document.querySelector('#modal-join [name="phone"]');
      var target = input.val()
      var msg = modal_join.find('[data-role="phoneErrorBlock"]')

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

    button.prop("disabled", true); // 버튼형 로더 적용
    var url = rooturl+'/?r='+raccount+'&m=member&a=join_guestAuth&act='+act+'&type='+type+'&target='+target

    getIframeForAction();
    frames.__iframe_for_action__.location.href = url;

  });

  // 본인인증 코드확인
  modal_join.find('[data-act="confirm_code"]').click(function() {
    var button = $(this)
    var act = 'confirm_code'
    var type = button.data('type')

    if (type=='email') {
      var input = modal_join.find('[name="confirm_email_code"]')
      var code = input.val()
      var msg = modal_join.find('[data-role="emailCodeBlock"]')

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
      var input = modal_join.find('[name="confirm_phone_code"]')
      var code = input.val()
      var msg = modal_join.find('[data-role="phoneCodeBlock"]')

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

    button.prop("disabled", true); // 버튼형 로더 적용
    var url = rooturl+'/?r='+raccount+'&m=member&a=join_guestAuth&act='+act+'&type='+type+'&code='+code

    getIframeForAction();
    frames.__iframe_for_action__.location.href = url;

  });

</script>

<?php if ($call_modal_join_site): ?>
<?php
$email	= $_SESSION['JOIN']['email']; //본인확인된 이메일
$phone	= $_SESSION['JOIN']['phone']; //본인확인된 휴대폰번호
unset($_SESSION['JOIN']); //본인확인 세션 초기화
?>
<div class="modal fade" id="modal-join-site" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">

    <div class="modal-content">

			<div class="modal-body">
        <div class="text-center">
          <h2>회원가입</h2>
        </div>

        <form id="memberForm" class="mt-3" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off" novalidate>
          <input type="hidden" name="r" value="<?php echo $r?>">
          <input type="hidden" name="m" value="member">
          <input type="hidden" name="a" value="join">
          <input type="hidden" name="check_pw" value="0">
          <input type="hidden" name="check_name" value="0">

          <?php if($d['member']['form_join_nic']):?>
          <input type="hidden" name="check_nic" value="0">
          <?php endif?>

          <?php if ($email): ?>
          <div class="form-group">
            <label>이메일 <span class="text-danger">*</span></label>
            <input type="email" class="form-control form-control-lg" name="email" value="<?php echo $email ?>" readonly>
          </div>
          <?php endif; ?>

          <?php if ($phone): ?>
          <div class="form-group">
            <label>휴대폰 <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" name="phone" value="<?php echo $phone ?>" readonly>
          </div>
          <?php endif; ?>

          <div class="form-group position-relative">
            <label>이름 <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" name="name" id="name" value="<?php echo $name ?>" placeholder="이름" autocomplete="off" data-role="name">
            <div class="invalid-tooltip" id="name-feedback"></div>
          </div>

          <div class="form-group position-relative">
            <label>비밀번호 <span class="text-danger">*</span></label>
            <input type="password" class="form-control form-control-lg" name="pw1" value="" placeholder="비밀번호(6~16자)" autocomplete="off" data-role="pw">
            <div class="invalid-tooltip" id="pw-feedback"></div>
          </div>

          <?php if($d['member']['form_join_nic']):?>
          <div class="form-group">
            <label>닉네임<?php if($d['member']['form_join_nic_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <input type="text" class="form-control" name="nic" id="nic" value="<?php echo $nic?>" placeholder="닉네임을 입력해 주세요." onblur="sameCheck(this,'nic-feedback');">
            <div class="invalid-feedback" id="nic-feedback"></div>
            <small class="form-text text-muted">2~12자로 사용할 수 있습니다.</small>
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_birth']):?>
          <div class="form-group">
            <label>생년월일<?php if($d['member']['form_join_birth_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <div class="form-inline">
              <select class="form-control custom-select" name="birth_1">
                <option value="">년도</option>
                <?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
                <option value="<?php echo $i?>"<?php if(substr($i,-2)==substr($regis_jumin1,0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="birth_2">
                <option value="">월</option>
                <?php $birth_2=substr($my['birth2'],0,2)?>
                <?php for($i = 1; $i < 13; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="birth_3">
                <option value="">일</option>
                <?php $birth_3=substr($my['birth2'],2,2)?>
                <?php for($i = 1; $i < 32; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,4,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <div class="custom-control custom-checkbox ml-3">
                <input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1">
                <label class="custom-control-label" for="birthtype">음력</label>
              </div>
              <div class="invalid-feedback">
                생년월일을 지정해 주세요.
              </div>
            </div><!-- /.form-inline -->
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_bio']):?>
          <div class="form-group">
            <label>간단소개<?php if($d['member']['form_join_bio_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <textarea class="form-control" name="bio" rows="3" placeholder="간략한 소개글을 입력해주세요."><?php echo $my['bio']?></textarea>
            <div class="invalid-feedback">
              간단소개를 입력해 주세요.
            </div>
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_sex']):?>
          <div class="form-group">
            <label>성별 <?php if($d['member']['form_join_sex_required']):?><span class="text-danger">*</span><?php endif?></label>

            <div id="radio-sex">
              <div class="custom-control custom-radio  custom-control-inline">
                <input type="radio" id="sex_1" name="sex" class="custom-control-input" value="1"<?php if($regis_jumin2&&(substr($regis_jumin2,0,1)%2)==1):?> checked="checked"<?php endif?> required>
                <label class="custom-control-label" for="sex_1">남성</label>
              </div>
              <div class="custom-control custom-radio  custom-control-inline">
                <input type="radio" id="sex_2" name="sex" class="custom-control-input" value="2"<?php if($regis_jumin2&&(substr($regis_jumin2,0,1)%2)==0):?> checked="checked"<?php endif?> required>
                <label class="custom-control-label text-nowrap" for="sex_2">여성</label>
                <div class="invalid-feedback ml-4">성별을 선택해 주세요.</div>
              </div>
            </div>

          </div>
          <?php endif?>

          <?php if($d['member']['form_join_home']):?>
          <div class="form-group">
            <label>홈페이지<?php if($d['member']['form_join_home_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <input type="text" class="form-control" name="home" value="" placeholder="URL을 입력하세요.">
            <div class="invalid-feedback">
              홈페이지 주소를 입력해주세요.
            </div>
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_tel']):?>
          <div class="form-group">
            <label>일반전화 <?php if($d['member']['form_join_tel_required']):?><span class="text-danger">*</span><?php endif?></label>
            <div class="form-inline">
              <input type="text" name="tel_1" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
              <input type="text" name="tel_2" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
              <input type="text" name="tel_3" value="" maxlength="4" size="4" class="form-control">
              <div class="invalid-feedback">
                전화번호를 입력해주세요.
              </div>
            </div><!-- /.form-inline -->
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_location']):?>
          <div class="form-group">
            <label>거주지역<?php if($d['member']['form_join_location_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <select class="form-control custom-select" name="location">
              <option value="">&nbsp;+ 선택하세요</option>
              <option value="" disabled>------------------</option>
              <?php
              $_tmplfile =  $g['path_module'].'member/var/location.txt';
              $_location=file($_tmplfile);
              ?>
              <?php foreach($_location as $_val):?>
              <option value="<?php echo trim($_val)?>">ㆍ<?php echo trim($_val)?></option>
              <?php endforeach?>
            </select>
            <div class="invalid-feedback">
              거주지역을 선택해 주세요.
            </div>
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_job']):?>
          <div class="form-group">
            <label>직업<?php if($d['member']['form_join_job_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <select class="form-control custom-select" name="job">
              <option value="">&nbsp;+ 선택하세요</option>
              <option value="" disabled>------------------</option>
              <?php
              $_tmpvfile =  $g['path_module'].'member/var/job.txt';
              $_job=file($_tmpvfile);
              ?>
              <?php foreach($_job as $_val):?>
              <option value="<?php echo trim($_val)?>">ㆍ<?php echo trim($_val)?></option>
              <?php endforeach?>
            </select>
            <div class="invalid-feedback">
              직업을 선택해 주세요.
            </div>
          </div>
          <?php endif?>

          <?php if($d['member']['form_join_marr']):?>
          <div class="form-group">
            <label>결혼기념일<?php if($d['member']['form_join_marr_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <div class="form-inline">

              <select class="form-control custom-select" name="marr_1">
                <option value="">년도</option>
                <?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
                <option value="<?php echo $i?>"><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="marr_2">
                <option value="">월</option>
                <?php for($i = 1; $i < 13; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="marr_3">
                <option value="">일</option>
                <?php for($i = 1; $i < 32; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
                <?php endfor?>
              </select>
              <div class="invalid-feedback">
                결혼기념일을 입력해주세요.
              </div>
            </div><!-- /.form-inline -->
          </div>
          <?php endif?>

          <!-- 추가 가입항목 -->
          <?php if($d['member']['form_join_add']):?>
          <?php $g['memberAddFieldSite'] = $g['path_var'].'site/'.$_HS['id'].'/member.add_field.txt'; ?>
    			<?php $_add = file_exists($g['memberAddFieldSite']) ? file($g['memberAddFieldSite']) : file($g['path_module'].'member/var/add_field.txt');?>
    			<?php foreach($_add as $_key):?>
    			<?php $_val = explode('|',trim($_key))?>
    			<?php if($_val[6]) continue?>
    			<div class="form-group">
    				<label><?php echo $_val[1]?><?php if($_val[5]):?><span class="text-danger">*</span><?php endif?></label>

    				<?php if($_val[2]=='text'):?>
    				<input type="text" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_val[3]?>"<?php if($_val[5]):?> required<?php endif?>>
    				<?php endif?>
    				<?php if($_val[2]=='password'):?>
    				<input type="password" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_val[3]?>"<?php if($_val[5]):?> required<?php endif?>>
    				<?php endif?>
    				<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
    				<select name="add_<?php echo $_val[0]?>" class="form-control custom-select"<?php if($_val[5]):?> required<?php endif?>>
    					<option value="">&nbsp;+ 선택하세요</option>
    					<?php foreach($_skey as $_sval):?>
    					<option value="<?php echo trim($_sval)?>">ㆍ<?php echo trim($_sval)?></option>
    					<?php endforeach?>
    				</select>
    				<?php endif?>
    				<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
    				<div class="">
    				<?php foreach($_skey as $_sval):?>
    				<div class="custom-control custom-radio custom-control-inline">
    				  <input type="radio" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>" class="custom-control-input">
    				  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
    				</div>
    				<?php endforeach?>
    				</div>
    				<?php endif?>
    				<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
    				<div>
    				<?php foreach($_skey as $_sval):?>
    				<div class="custom-control custom-checkbox custom-control-inline">
    				  <input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>">
    				  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
    				</div>
    				<?php endforeach?>
    				</div>
    				<?php endif?>
    				<?php if($_val[2]=='textarea'):?>
    				<textarea name="add_<?php echo $_val[0]?>" rows="5" class="form-control"<?php if($_val[5]):?> required<?php endif?>><?php echo $_val[3]?></textarea>
    				<?php endif?>

    			</div><!-- /.form-group -->
    			<?php endforeach?>
          <?php endif?>

          <div class="d-flex justify-content-between mt-4 position-relative">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="agreecheckbox" name="agreecheckbox">
              <label class="custom-control-label" for="agreecheckbox">서비스 약관에 동의합니다.</label>
              <div class="invalid-feedback">
                회원으로 가입을 원하실 경우, 약관에 동의하셔야 합니다.
              </div>
            </div>
            <a href="<?php echo RW('mod='.$d['member']['join_joint_policy']) ?>" class="muted-link" target="_blank">약관보기</a>
          </div>

          <button class="btn btn-outline-primary btn-block btn-lg js-submit mt-2" type="submit">
            <span class="not-loading">가입하기</span>
            <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 회원가입 중 ...</span>
          </button>

        </form>
			</div><!-- /.modal-body -->

      <div class="modal-footer p-2">
        <button type="button" class="btn btn-link btn-block muted-link" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

<script>

  var modal_join_site = $('#modal-join-site')
  var f = document.getElementById('memberForm');

  //회원가입 항목 유용성 체크
  function joinCheck(obj,layer) {
  	if (!obj.value)
  	{
      obj.classList.remove('is-invalid');
  		getId(layer).innerHTML = '';
  	}
  	else
  	{
      if (obj.name == 'name') {
        if (obj.value.length > 1) {
          f.check_name.value = '1';
          f.name.classList.add('is-valid');
          f.name.classList.remove('is-invalid');
        } else {
          f.check_name.value = '0';
          f.name.classList.add('is-invalid');
          getId(layer).innerHTML = '이름을 2자 이상으로 입력해주세요.';
          f.name.focus();
          return false;
        }
      }
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

  	}
  }

  modal_join_site.modal('show')

  modal_join_site.on('shown.bs.modal', function () {
    modal_join_site.find('[name="name"]').trigger('focus')
    modal_join_site.find('[name="pw1"]').val('')
  })

  //회원가입 시 입력항목 유용성 체크
  modal_join_site.find('input.form-control').keyup(function(){
    var item = $(this).data('role')
    var item_pw_check = modal_join_site.find('[name=check_pw]').val()
    var item_name_check = modal_join_site.find('[name=check_name]').val()

    if (item=='pw') {
      element = f.pw1
      joinCheck(element,'pw-feedback')
    }
    if (item=='name') {
      element = f.name
      joinCheck(element,'name-feedback')
    }

  });


</script>
<?php endif; ?>


<?php if ($call_modal_join_social): ?>
<?php
$avatar_data=array('src'=>$_photo,'width'=>150,'height'=>150);
$user_avatar_src=getTimThumb($avatar_data);
unset($_SESSION['SL']); //본인확인 세션 초기화
?>

<!-- 1. 일반모달 : 소셜로그인 인증후, 회원가입 -->
<div class="modal fade" id="modal-join-social" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">

    <div class="modal-content">
			<ul class="nav nav-tabs nav-justified">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#pane-join-social"  id="nav-join-social" style="border-top-right-radius: 0">신규가입</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#pane-join-combine" style="border-top-left-radius: 0" id="nav-join-combine">기존계정 연결</a>
				</li>
			</ul>

			<div class="tab-content modal-body">
	      <div class="tab-pane fade show active" id="pane-join-social">

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

					<div class="text-center">
	    			<h2>회원가입</h2>
	    			<span class="text-muted f13">
              <?php echo $sns_name_ko ?> 계정으로 <?php echo $_HS['name'] ?>에 회원가입 합니다.<br>
              가입완료 시에 회원님의 <?php echo $sns_name_ko ?> 계정과 자동연결 됩니다.</span>
	    		</div>

	    		<form id="memberForm" class="mt-3" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off" novalidate>
	    			<input type="hidden" name="r" value="<?php echo $r?>">
	    			<input type="hidden" name="m" value="member">
	    			<input type="hidden" name="front" value="<?php echo $front?>">
	    			<input type="hidden" name="a" value="join">
	    			<input type="hidden" name="check_id" value="1">
            <input type="hidden" name="check_name" value="1">
	    			<input type="hidden" name="check_nic" value="0">
	    			<input type="hidden" name="sns_access_token" value="<?php echo $sns_access_token?>">
	    			<input type="hidden" name="sns_refresh_token" value="<?php echo $sns_refresh_token?>">
	    			<input type="hidden" name="sns_expires_in" value="<?php echo $sns_expires_in?>">
	    			<input type="hidden" name="snsname" value="<?php echo $sns_name?>">
	    			<input type="hidden" name="snsuid" value="<?php echo $snsuid?>">
	          <input type="hidden" name="_photo" value="<?php echo $_photo ?>">
            <input type="hidden" name="sns_email" value="<?php echo $email?1:0 ?>">
            <input type="hidden" name="check_email" value="<?php echo $email?1:0 ?>">

            <?php if($d['member']['form_join_nic']):?>
            <input type="hidden" name="check_nic" value="0">
            <?php endif?>

	    			<div class="form-group">
	    		    <label>이름</label>
	    				<input type="text" class="form-control form-control-lg" name="name" id="name" value="<?php echo $name ?>" placeholder="이름" autocomplete="off"  placeholder="이름" readonly>
	    				<div class="invalid-feedback" id="name-feedback">이름을 입력해주세요.</div>
	    		  </div>

            <div class="form-group">
	    				<label>이메일 <span class="text-danger">*</span></label>
	    				<input type="email" class="form-control form-control-lg" name="email" id="email" value="<?php echo $email ?>" placeholder="이메일" onblur="sameCheck(this,'email-feedback');"<?php echo $email?' readonly':'' ?>>
	    				<div class="invalid-feedback mt-2" id="email-feedback"></div>
	    			</div>

	    			<?php if($d['member']['form_join_nic']):?>
	    			<div class="form-group">
	    		    <label>닉네임<?php if($d['member']['form_join_nic_required']):?> <span class="text-danger">*</span><?php endif?></label>
	    				<input type="text" class="form-control" name="nic" id="nic" value="<?php echo $nic?>" placeholder="닉네임을 입력해 주세요." onblur="sameCheck(this,'nic-feedback');">
	    				<div class="invalid-feedback mt-2" id="nic-feedback"></div>
	    		  </div>
	    			<?php endif?>

            <?php if($d['member']['form_join_birth']):?>
      		  <div class="form-group">
      		    <label>생년월일<?php if($d['member']['form_join_birth_required']):?> <span class="text-danger">*</span><?php endif?></label>
      				<div class="form-inline">
      					<select class="form-control custom-select" name="birth_1">
      						<option value="">년도</option>
      						<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
      						<option value="<?php echo $i?>"<?php if(substr($i,-2)==substr($regis_jumin1,0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
      						<?php endfor?>
      					</select>
      					<select class="form-control custom-select ml-2" name="birth_2">
      						<option value="">월</option>
      						<?php $birth_2=substr($my['birth2'],0,2)?>
      						<?php for($i = 1; $i < 13; $i++):?>
      						<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
      						<?php endfor?>
      					</select>
      					<select class="form-control custom-select ml-2" name="birth_3">
      						<option value="">일</option>
      						<?php $birth_3=substr($my['birth2'],2,2)?>
      						<?php for($i = 1; $i < 32; $i++):?>
      						<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,4,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
      						<?php endfor?>
      					</select>
      					<div class="custom-control custom-checkbox ml-3">
      						<input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1">
      						<label class="custom-control-label" for="birthtype">음력</label>
      					</div>
      					<div class="invalid-feedback">
      						생년월일을 지정해 주세요.
      					</div>
      				</div><!-- /.form-inline -->
      		  </div>
      			<?php endif?>

            <?php if($d['member']['form_join_bio']):?>
	    		  <div class="form-group">
	    		    <label>간단소개<?php if($d['member']['form_join_bio_required']):?> <span class="text-danger">*</span><?php endif?></label>
	    				<textarea class="form-control" name="bio" rows="3" placeholder="간략한 소개글을 입력해주세요."><?php echo $my['bio']?></textarea>
	    				<div class="invalid-feedback">
	    					간단소개를 입력해 주세요.
	    				</div>
	    		  </div>
	    		  <?php endif?>

	    			<?php if($d['member']['form_join_sex']):?>
	    		  <div class="form-group">
	    		    <label>성별 <?php if($d['member']['form_join_sex_required']):?><span class="text-danger">*</span><?php endif?></label>

              <div id="radio-sex">
  	    				<div class="custom-control custom-radio  custom-control-inline">
  	    					<input type="radio" id="sex_1" name="sex" class="custom-control-input" value="1"<?php if($regis_jumin2&&(substr($regis_jumin2,0,1)%2)==1):?> checked="checked"<?php endif?> required>
  	    					<label class="custom-control-label" for="sex_1">남성</label>
  	    				</div>
  	    				<div class="custom-control custom-radio  custom-control-inline">
  	    					<input type="radio" id="sex_2" name="sex" class="custom-control-input" value="2"<?php if($regis_jumin2&&(substr($regis_jumin2,0,1)%2)==0):?> checked="checked"<?php endif?> required>
  	    					<label class="custom-control-label text-nowrap" for="sex_2">여성</label>
                  <div class="invalid-feedback ml-4">성별을 선택해 주세요.</div>
  	    				</div>
              </div>

	    		  </div>
	    			<?php endif?>

	    		  <?php if($d['member']['form_join_home']):?>
	    		  <div class="form-group">
	    		    <label>홈페이지<?php if($d['member']['form_join_home_required']):?> <span class="text-danger">*</span><?php endif?></label>
	    				<input type="text" class="form-control" name="home" value="" placeholder="URL을 입력하세요.">
	    				<div class="invalid-feedback">
	    					홈페이지 주소를 입력해주세요.
	    				</div>
	    		  </div>
	    		  <?php endif?>

  			    <?php if($d['member']['form_join_tel']):?>
    		    <div class="form-group">
    		      <label>일반전화 <?php if($d['member']['form_join_tel_required']):?><span class="text-danger">*</span><?php endif?></label>
    					<div class="form-inline">
    						<input type="text" name="tel_1" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
    						<input type="text" name="tel_2" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
    						<input type="text" name="tel_3" value="" maxlength="4" size="4" class="form-control">
    						<div class="invalid-feedback">
    							전화번호를 입력해주세요.
    						</div>
    					</div><!-- /.form-inline -->
    		    </div>
  			    <?php endif?>

            <?php if($d['member']['form_join_location']):?>
	    		  <div class="form-group">
	    		    <label>거주지역<?php if($d['member']['form_join_location_required']):?> <span class="text-danger">*</span><?php endif?></label>
	    				<select class="form-control custom-select" name="location">
	    					<option value="">&nbsp;+ 선택하세요</option>
	    					<option value="" disabled>------------------</option>
	    					<?php
	    					$_tmplfile =  $g['path_module'].'member/var/location.txt';
	    					$_location=file($_tmplfile);
	    					?>
	    					<?php foreach($_location as $_val):?>
	    					<option value="<?php echo trim($_val)?>">ㆍ<?php echo trim($_val)?></option>
	    					<?php endforeach?>
	    				</select>
	    				<div class="invalid-feedback">
	    					거주지역을 선택해 주세요.
	    				</div>
	    		  </div>
	    			<?php endif?>

	    		  <?php if($d['member']['form_join_job']):?>
	    		  <div class="form-group">
	    		    <label>직업<?php if($d['member']['form_join_job_required']):?> <span class="text-danger">*</span><?php endif?></label>
	    				<select class="form-control custom-select" name="job">
	    					<option value="">&nbsp;+ 선택하세요</option>
	    					<option value="" disabled>------------------</option>
	    					<?php
                $_tmpvfile =  $g['path_module'].'member/var/job.txt';
	    					$_job=file($_tmpvfile);
	    					?>
	    					<?php foreach($_job as $_val):?>
	    					<option value="<?php echo trim($_val)?>">ㆍ<?php echo trim($_val)?></option>
	    					<?php endforeach?>
	    				</select>
	    				<div class="invalid-feedback">
	    					직업을 선택해 주세요.
	    				</div>
	    		  </div>
	    			<?php endif?>

            <?php if($d['member']['form_join_marr']):?>
      		  <div class="form-group">
      		    <label>결혼기념일<?php if($d['member']['form_join_marr_required']):?> <span class="text-danger">*</span><?php endif?></label>
      				<div class="form-inline">

      					<select class="form-control custom-select" name="marr_1">
      						<option value="">년도</option>
      						<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
      						<option value="<?php echo $i?>"><?php echo $i?></option>
      						<?php endfor?>
      					</select>
      					<select class="form-control custom-select ml-2" name="marr_2">
      						<option value="">월</option>
      						<?php for($i = 1; $i < 13; $i++):?>
      						<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
      						<?php endfor?>
      					</select>
      					<select class="form-control custom-select ml-2" name="marr_3">
      						<option value="">일</option>
      						<?php for($i = 1; $i < 32; $i++):?>
      						<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
      						<?php endfor?>
      					</select>
      					<div class="invalid-feedback">
      						결혼기념일을 입력해주세요.
      					</div>
      				</div><!-- /.form-inline -->
      		  </div>
      			<?php endif?>

            <!-- 추가 가입항목 -->
            <?php if($d['member']['form_join_add']):?>
            <?php $g['memberAddFieldSite'] = $g['path_var'].'site/'.$_HS['id'].'/member.add_field.txt'; ?>
      			<?php $_add = file_exists($g['memberAddFieldSite']) ? file($g['memberAddFieldSite']) : file($g['path_module'].'member/var/add_field.txt');?>
      			<?php foreach($_add as $_key):?>
      			<?php $_val = explode('|',trim($_key))?>
      			<?php if($_val[6]) continue?>
      			<div class="form-group">
      				<label><?php echo $_val[1]?><?php if($_val[5]):?><span class="text-danger">*</span><?php endif?></label>

      				<?php if($_val[2]=='text'):?>
      				<input type="text" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_val[3]?>"<?php if($_val[5]):?> required<?php endif?>>
      				<?php endif?>
      				<?php if($_val[2]=='password'):?>
      				<input type="password" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_val[3]?>"<?php if($_val[5]):?> required<?php endif?>>
      				<?php endif?>
      				<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
      				<select name="add_<?php echo $_val[0]?>" class="form-control custom-select"<?php if($_val[5]):?> required<?php endif?>>
      					<option value="">&nbsp;+ 선택하세요</option>
      					<?php foreach($_skey as $_sval):?>
      					<option value="<?php echo trim($_sval)?>">ㆍ<?php echo trim($_sval)?></option>
      					<?php endforeach?>
      				</select>
      				<?php endif?>
      				<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
      				<div class="">
      				<?php foreach($_skey as $_sval):?>
      				<div class="custom-control custom-radio custom-control-inline">
      				  <input type="radio" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>" class="custom-control-input">
      				  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
      				</div>
      				<?php endforeach?>
      				</div>
      				<?php endif?>
      				<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
      				<div>
      				<?php foreach($_skey as $_sval):?>
      				<div class="custom-control custom-checkbox custom-control-inline">
      				  <input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>">
      				  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
      				</div>
      				<?php endforeach?>
      				</div>
      				<?php endif?>
      				<?php if($_val[2]=='textarea'):?>
      				<textarea name="add_<?php echo $_val[0]?>" rows="5" class="form-control"<?php if($_val[5]):?> required<?php endif?>><?php echo $_val[3]?></textarea>
      				<?php endif?>

      			</div><!-- /.form-group -->
      			<?php endforeach?>
            <?php endif?>

	    			<div class="d-flex justify-content-between mt-4">
	    				<div class="custom-control custom-checkbox">
	    					<input type="checkbox" class="custom-control-input" id="agreecheckbox" name="agreecheckbox">
	    					<label class="custom-control-label" for="agreecheckbox">서비스 약관에 동의합니다.</label>
	    					<div class="invalid-feedback">
	    						회원으로 가입을 원하실 경우, 약관에 동의하셔야 합니다.
	    					</div>
	    				</div>

	    				<a href="<?php echo RW('mod='.$d['member']['join_joint_policy']) ?>" class="muted-link" target="_blank">약관보기</a>
	    			</div>

	    			<button class="btn btn-outline-primary btn-block btn-lg js-submit mt-2" type="submit">
	    				<span class="not-loading">가입하기</span>
	    				<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 회원가입 중 ...</span>
	    			</button>

	    			<div class="d-flex justify-content-between align-items-center mt-3">
	    				<span class="text-muted">혹시 기존 회원이신가요 ?</span>
	    				<button class="btn btn-link js-tab-combine" type="button">
	    					기존 계정에 연결하기
	    				</button>
	    			</div>

	    		</form>

	      </div><!-- /.tab-pane -->
				<div class="tab-pane fade" id="pane-join-combine">

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

					<div class="text-center">
	    			<h2>계정통합</h2>
	    			<span class="f13 text-muted">
							이미, <?php echo $_HS['name'] ?>에 회원계정을 가지고 계시면 로그인을 해주세요.<br>
							<?php echo $name ?>님의 <?php echo $sns_name_ko ?> 계정과 통합됩니다. <br>
							하나의 회원계정으로 다양한 서비스를 이용해 보세요.
						</span>
	    		</div>

          <form class="form-signin mt-4" id="page-loginform" action="<?php echo $g['s']?>/" method="post" novalidate>
            <input type="hidden" name="r" value="<?php echo $r?>">
            <input type="hidden" name="a" value="login">
            <input type="hidden" name="referer" value="<?php echo $referer ? $referer : $_SERVER['HTTP_REFERER']?>">
            <input type="hidden" name="form" value="">
            <input type="hidden" name="snsname" value="<?php echo $sns_name?>">
            <input type="hidden" name="snsuid" value="<?php echo $snsuid?>">

            <fieldset>
              <div class="form-group">
                <label for="">이메일 또는 휴대폰 번호</label>
                <input type="text" name="id" id="id" value="<?php echo $email ?>" class="form-control" placeholder="" tabindex="1" autocorrect="off" autocapitalize="off">
                <div class="invalid-feedback mt-2" data-role="idErrorBlock"></div>
              </div>

              <div class="form-group">
                <label for="">
                  패스워드
                  <a href="<?php echo RW('mod=password_reset') ?>" class="label-link" id="password_reset">비밀번호를 잊으셨나요?</a>
                </label>
                <input type="password" name="pw1" id="password" class="form-control" placeholder="" tabindex="2" required>
                <div class="invalid-feedback mt-2" data-role="passwordErrorBlock"></div>
              </div>

              <div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#page-collapsealert">
                <input type="checkbox" class="custom-control-input" id="page-loginCookie" name="login_cookie" value="checked" tabindex="4">
                <label class="custom-control-label" for="page-loginCookie">로그인 상태 유지</label>
              </div>

              <div class="collapse" id="page-collapsealert">
                <div class="alert alert-danger f12 mb-3">
                  개인정보 보호를 위해, 개인 PC에서만 사용해 주세요.
                </div>
              </div>

              <button class="btn btn-lg btn-outline-primary btn-block mt-3" type="submit" id="rb-submit" data-role="submit" tabindex="3">
                <span class="not-loading">로그인</span>
                <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 로그인중 ...</span>
              </button>


            </fieldset>

          </form>

				</div><!-- /.pane -->
			</div><!-- /.tab-content -->

      <div class="modal-footer p-2">
        <button type="button" class="btn btn-link btn-block muted-link" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#modal-join-social').modal('show')

	$('#modal-join-social').on('shown.bs.modal', function () {
	  $(this).find('[name="email"]').trigger('focus')
	})

	$('.js-tab-combine').on('click', function (e) {
	  e.preventDefault()
	  $('#nav-join-combine').tab('show')
	})

	$('#nav-join-social').on('shown.bs.tab', function (e) {
		$('#pane-join-social').find('[name="email"]').focus()
	})

	$('#nav-join-combine').on('shown.bs.tab', function (e) {
		$('#pane-join-combine').find('[id="id"]').focus()
	})

	//modal 계정연결하기 - 실행
  $('#modal-combine').find('form').submit(function(e){
 	 e.preventDefault();
 	 e.stopPropagation();
 	 var form = $(this)
 	 siteLogin(form)
  });


  $("#modal-combine").find('.form-control').keyup(function() {
 	  $(this).removeClass('is-invalid') //에러 흔적 초기화
  });

</script>

<?php endif; ?>

<?php if ($call_modal_join_site || $call_modal_join_social): ?>
<script>

  var f = document.getElementById('memberForm'); // dom 선택자
  var form = $('#memberForm'); // jquery 선택자

  function sameCheck(obj,layer) {
  	if (!obj.value)
  	{
  		eval('f.check_'+obj.name).value = '0';
  		f.classList.remove('was-validated');
  		obj.classList.remove('is-invalid','is-valid');
  		getId(layer).innerHTML = '';
  	}
  	else
  	{
  		if (obj.name == 'email')
  		{
  			if (!chkEmailAddr(obj.value))
  			{
  				f.check_email.value = '0';
  				setTimeout(function() {
  							obj.focus();
  					}, 0);
  				f.classList.remove('was-validated');
  				obj.classList.add('is-invalid');
  				obj.classList.remove('is-valid');
  				getId(layer).innerHTML = '이메일형식이 아닙니다';
  				return false;
  			} else {
          obj.classList.remove('is-invalid');
        }
  		}
  		if (obj.name == 'nic')
  		{
  			if (obj.value.length < 2 || obj.value.length > 12 )
  			{
  				f.check_nic.value = '0';
  				setTimeout(function() {
  					obj.focus();
  				}, 0);
  				f.classList.remove('was-validated');
  				obj.classList.add('is-invalid');
  				obj.classList.remove('is-valid');
  				getId(layer).innerHTML = '2~12자로 사용할 수 있습니다.';
  				return false;
  			} else {
          obj.classList.remove('is-invalid');
        }
  		}
  		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=member&a=same_check&fname=' + obj.name + '&fvalue=' + obj.value + '&flayer=' + layer;
  	}
  }


  $('#memberForm').submit( function(event){

    event.preventDefault();
    event.stopPropagation();

    form.find('.form-control').removeClass('is-invalid')  //에러이력 초기화

    if (f.name.value == '')
    {
      f.name.focus();
      f.name.classList.add('is-invalid');
      getId('name-feedback').innerHTML = '이름을 입력해주세요.';
      return false;
    }
    if (f.check_name.value == '0')
    {
      f.name.classList.add('is-invalid')
      f.name.focus();
      return false;
    }
    <?php if ($call_modal_join_social): ?>
    if (f.email.value == '')
    {
      f.email.classList.add('is-invalid');
      getId('email-feedback').innerHTML = '이메일을 입력해주세요.';
      f.email.focus();
      return false;
    }
    <?php endif; ?>

    <?php if ($call_modal_join_site): ?>
    if (f.pw1.value == '')
    {
      f.pw1.classList.add('is-invalid');
      getId('pw-feedback').innerHTML = '비밀번호를 입력해주세요.';
      f.pw1.focus();
      return false;
    }
    if (f.check_pw.value == '0')
    {
      f.pw1.classList.add('is-invalid')
      f.pw1.focus();
      return false;
    }
    <?php endif; ?>

    <?php if($d['member']['form_join_nic']&&$d['member']['form_join_nic_required']):?>
    if (f.nic.value == '')
    {
      f.nic.classList.add('is-invalid');
      getId('nic-feedback').innerHTML = '닉네임을 입력해주세요.';
      f.nic.focus();
      return false;
    }
    <?php endif; ?>

    <?php if($d['member']['form_join_birth']&&$d['member']['form_join_birth_required']):?>
    if (f.birth_1.value == '')
    {
      f.birth_1.classList.add('is-invalid');
      f.birth_1.focus();
      return false;
    }
    if (f.birth_2.value == '')
    {
      f.birth_2.classList.add('is-invalid');
      f.birth_2.focus();
      return false;
    }
    if (f.birth_3.value == '')
    {
      f.birth_3.classList.add('is-invalid');
      f.birth_3.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_join_bio']&&$d['member']['form_join_bio_required']):?>
    if (f.bio.value == '')
    {
      f.bio.classList.add('is-invalid');
      f.bio.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_join_sex']&&$d['member']['form_join_sex_required']):?>
    if (f.sex[0].checked == false && f.sex[1].checked == false)
  	{
      getId('radio-sex').classList.add('was-validated');
      f.sex[0].focus();
  		return false;
  	}
    <?php endif?>

    <?php if($d['member']['form_join_home']&&$d['member']['form_join_home_required']):?>
    if (f.home.value == '')
    {
      f.home.classList.add('is-invalid');
      f.home.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_join_tel']&&$d['member']['form_join_tel_required']):?>
    if (f.tel_1.value == '')
    {
      f.tel_1.classList.add('is-invalid');
      f.tel_1.focus();
      return false;
    }
    if (f.tel_2.value == '')
    {
      f.tel_2.classList.add('is-invalid');
      f.tel_2.focus();
      return false;
    }
    if (f.tel_3.value == '')
    {
      f.tel_3.classList.add('is-invalid');
      f.tel_3.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_join_location']&&$d['member']['form_join_location_required']):?>
    if (f.location.value == '')
    {
      f.location.classList.add('is-invalid');
      f.location.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_join_job']&&$d['member']['form_join_job_required']):?>
    if (f.job.value == '')
    {
      f.job.classList.add('is-invalid');
      f.job.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_join_marr']&&$d['member']['form_join_marr_required']):?>
    if (f.marr_1.value == '')
    {
      f.marr_1.classList.add('is-invalid');
      f.marr_1.focus();
      return false;
    }
    if (f.marr_2.value == '')
    {
      f.marr_2.classList.add('is-invalid');
      f.marr_2.focus();
      return false;
    }
    if (f.marr_3.value == '')
    {
      f.marr_3.classList.add('is-invalid');
      f.marr_3.focus();
      return false;
    }
    <?php endif?>

    //가입 추가항목 체크
    <?php if($d['member']['form_join_add']):?>
    var radioarray;
		var checkarray;
		var i;
		var j = 0;
		<?php foreach($_add as $_key):?>
		<?php $_val = explode('|',trim($_key))?>
		<?php if(!$_val[5]||$_val[6]) continue?>
		<?php if($_val[2]=='text' || $_val[2]=='password' || $_val[2]=='select' || $_val[2]=='textarea'):?>
		if (f.add_<?php echo $_val[0]?>.value == '')
		{
			alert('<?php echo $_val[1]?>이(가) <?php echo $_val[2]=='select'?'선택':'입력'?>되지 않았습니다.     ');
			f.add_<?php echo $_val[0]?>.focus();
			return false;
		}
		<?php endif?>
		<?php if($_val[2]=='radio'):?>
		j = 0;
		radioarray = f.add_<?php echo $_val[0]?>;
		for (i = 0; i < radioarray.length; i++)
		{
			if (radioarray[i].checked == true) j++;
		}
		if (!j)
		{
			alert('<?php echo $_val[1]?>이(가) 선택되지 않았습니다.     ');
			radioarray[0].focus();
			return false;
		}
		<?php endif?>
		<?php if($_val[2]=='checkbox'):?>
		j = 0;
		checkarray = document.getElementsByName("add_<?php echo $_val[0]?>[]");
		for (i = 0; i < checkarray.length; i++)
		{
			if (checkarray[i].checked == true) j++;
		}
		if (!j)
		{
			alert('<?php echo $_val[1]?>이(가) 선택되지 않았습니다.     ');
			checkarray[0].focus();
			return false;
		}
		<?php endif?>
		<?php endforeach?>
    <?php endif?>

    // 약관체크
    if (f.agreecheckbox.checked == false){
      f.agreecheckbox.classList.add('is-invalid');
      f.agreecheckbox.focus();
      return false;
    }


    <?php if ($call_modal_join_site): ?>  // 사이트형 회원가입
    <?php if($d['member']['form_join_nic']):?>
    if (f.check_pw.value == '0' || f.check_name.value == '0' ||  f.check_nic.value == '0') {
      event.preventDefault();
      event.stopPropagation();
    }
    <?php else: ?>
    if (f.check_pw.value == '0' || f.check_name.value == '0') {
      event.preventDefault();
      event.stopPropagation();
    }
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($call_modal_join_social): ?>  // 소셜형 회원가입
    <?php if($d['member']['form_join_nic']):?>
    if (f.check_email.value == '0' ||  f.check_nic.value == '0') {
      event.preventDefault();
      event.stopPropagation();
    }
    <?php else: ?>
    if (f.check_email.value == '0') {
      event.preventDefault();
      event.stopPropagation();
    }
    <?php endif; ?>
    <?php endif; ?>

    $('.js-submit').attr("disabled",true);

    setTimeout(function(){
      getIframeForAction(f);
      f.submit();
    }, 500);

  });
</script>
<?php endif; ?>
