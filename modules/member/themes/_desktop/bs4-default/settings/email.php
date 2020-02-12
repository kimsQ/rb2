<?php
$sqlque0 = 'mbruid='.$my['uid'];
$sqlque1 = 'mbruid='.$my['uid'].' and base=1 and backup=0';
$sqlque2 = 'mbruid='.$my['uid'].' and base=0';
$sqlque3 = 'mbruid='.$my['uid'].' and backup=0 and d_verified<>0';
$sqlque4 = 'mbruid='.$my['uid'].' and base=0 and d_verified<>0';

$PCD = getDbArray($table['s_mbremail'],$sqlque1,'*','uid','asc',0,1);
$RCD = getDbArray($table['s_mbremail'],$sqlque2,'*','uid','asc',0,1);
$VCD = getDbArray($table['s_mbremail'],$sqlque3,'*','uid','asc',0,1);
$SCD = getDbArray($table['s_mbremail'],$sqlque4,'*','uid','asc',0,1);

$NUM = getDbRows($table['s_mbremail'],$sqlque0);
$NUM_VCD = getDbRows($table['s_mbremail'],$sqlque3);
?>

<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
  <nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>
  <div class="col-9 page-main">

    <div class="subhead mt-0">
      <h2 class="subhead-heading">이메일 관리</h2>
    </div>

    <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
    <?php include_once $g['dir_module_skin'].'_lock.php'?>
    <?php else: ?>

      <?php if (!$NUM): ?>
      <div class="card p-5 text-center text-muted">
        <i class="fa fa-envelope-o fa-3x mb-2" aria-hidden="true"></i>
        등록된 이메일이 없습니다.
      </div>
      <?php endif; ?>

      <ul class="list-group">

      <?php while($P=db_fetch_array($PCD)):?>
      <?php $codeValid=getValid($P['d_code'],$d['member']['settings_keyexpire']); ?>
        <li class="list-group-item" id="item-<?php echo $P['uid'] ?>">
          <div class=" d-flex justify-content-between align-items-center">
            <?php if ($P['d_verified']): ?>
            <div>
              <i class="fa fa-envelope-o fa-fw text-muted" aria-hidden="true"></i>
              <strong><?php echo $P['email'] ?></strong>
              <?php if ($P['base']): ?><span class="badge badge-primary">기본</span><?php endif; ?>
              <?php if ($my['email_profile']==$P['email']): ?><span class="badge badge-light">프로필 공개</span><?php endif; ?>
              <?php if ($my['email_noti']==$P['email']): ?><span class="badge badge-light">알림수신</span><?php endif; ?>
            </div>
            <?php else: ?>
            <div>
              <i class="fa fa-envelope-o fa-fw text-muted" aria-hidden="true"></i>
              <span class="text-muted"><?php echo $P['email'] ?></span>
              <?php if ($P['base']): ?><span class="badge badge-primary">기본</span><?php endif; ?>
              <span class="badge badge-secondary">미인증</span>
            </div>
            <div>
              <button type="button" class="btn btn-sm btn-light" data-act="send_code" data-uid="<?php echo $P['uid'] ?>">
                <span class="not-loading"><?php echo $codeValid?'재발송':'본인확인 인증번호 발송' ?></span>
                <span class="is-loading">발송중..</span>
              </button>
            </div>
            <?php endif; ?>
          </div>
          <div class="<?php echo $P['d_code'] && $codeValid?'':'d-none' ?>" data-role="verify_email_area">
            <div class=" d-flex justify-content-between align-items-center">
              <div style="width: 35%">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">인증번호</span>
                  </div>
                  <input type="number" class="form-control" name="confirm_code_<?php echo $P['uid'] ?>" data-role="code">
                  <div class="invalid-tooltip"></div>
                  <div class="input-group-append">
                    <button class="btn btn-light" type="button" data-act="confirm_code" data-uid="<?php echo $P['uid'] ?>">
                      <span class="not-loading">확인</span>
                      <span class="is-loading">확인중..</span>
                    </button>
                  </div>
                </div>
              </div>
              <div class="mt-2 text-right">
                <small class="form-text text-success mb-2">
                  인증번호를 발송했습니다.(유효시간 <?php echo $d['member']['settings_keyexpire'] ?>분)
                  <span
                    data-role="countdown"
                    data-countdown="<?php echo $P['d_code']?date("Y/m/d H:i:s",strtotime ("+".$d['member']['settings_keyexpire']." minutes",strtotime($P['d_code']))):''; ?>">
                  </span>
                    <br>인증번호가 오지 않으면 입력하신 정보가 정확한지 확인하여 주세요.
                </small>
              </div>
            </div><!-- /.d-flex -->
          </div><!-- /#verify_email_area -->
        </li>
      <?php endwhile?>

      <?php while($R=db_fetch_array($RCD)):?>
      <?php $codeValid=getValid($R['d_code'],$d['member']['settings_keyexpire']); ?>
      <li class="list-group-item" id="item-<?php echo $R['uid'] ?>">
        <div class=" d-flex justify-content-between align-items-center">
          <?php if ($R['d_verified']): ?>
          <div>
            <i class="fa fa-envelope-o fa-fw text-muted" aria-hidden="true"></i> <?php echo $R['email'] ?>
            <?php if ($R['backup']): ?><span class="badge badge-warning">백업</span><?php endif; ?>
            <?php if ($my['email_profile']==$R['email']): ?><span class="badge badge-light">프로필 공개</span><?php endif; ?>
            <?php if ($my['email_noti']==$R['email']): ?><span class="badge badge-light">알림수신</span><?php endif; ?>
          </div>
          <div>
            <?php if (!$R['base']): ?>
            <button type="button" class="btn btn-link muted-link py-0" data-act="del" data-toggle="tooltip" title="삭제" data-uid="<?php echo $R['uid'] ?>">
              <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
            </button>
          <?php endif; ?>
          </div>
          <?php else: ?>
          <div>
            <span class="text-muted"><?php echo $R['email'] ?></span>
            <span class="badge badge-secondary">미인증</span>
          </div>
          <div>
            <button type="button" class="btn btn-sm btn-light" data-act="send_code" data-uid="<?php echo $R['uid'] ?>">
              <span class="not-loading"><?php echo $codeValid?'재발송':'본인확인 인증번호 발송' ?></span>
              <span class="is-loading">발송중..</span>
            </button>
            <button type="button" class="btn btn-link muted-link py-0" data-act="del" data-toggle="tooltip" title="삭제" data-uid="<?php echo $R['uid'] ?>">
              <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
            </button>
          </div>
          <?php endif; ?>
        </div><!-- /.d-flex -->
        <div class="<?php echo $R['d_code'] && $codeValid?'':'d-none' ?>" data-role="verify_email_area">
          <div class=" d-flex justify-content-between align-items-center">
            <div style="width: 35%">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">인증번호</span>
                </div>
                <input type="number" class="form-control" name="confirm_code_<?php echo $R['uid'] ?>" data-role="code">
                <div class="invalid-tooltip"></div>
                <div class="input-group-append">
                  <button class="btn btn-light" type="button" data-act="confirm_code" data-uid="<?php echo $R['uid'] ?>">
                    <span class="not-loading">확인</span>
                    <span class="is-loading">확인중..</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="mt-2 text-right">
              <small class="form-text text-success mb-2">
                인증번호를 발송했습니다.(유효시간 <?php echo $d['member']['settings_keyexpire'] ?>분)
                <span
                  data-role="countdown"
                  data-countdown="<?php echo $R['d_code']?date("Y/m/d H:i:s",strtotime ("+".$d['member']['settings_keyexpire']." minutes",strtotime($R['d_code']))):''; ?>">
                </span>
                  <br>인증번호가 오지 않으면 입력하신 정보가 정확한지 확인하여 주세요.
              </small>
            </div>
          </div><!-- /.d-flex -->
        </div><!-- /#verify_email_area -->

      </li>
      <?php endwhile?>
      </ul>

      <form class="my-4" id="emailsForm" role="form" action="<?php echo $g['s']?>/" method="post" novalidate>
        <fieldset<?php echo ($NUM==5)?' disabled':'' ?>>
          <input type="hidden" name="r" value="<?php echo $r?>">
          <input type="hidden" name="m" value="<?php echo $m?>">
          <input type="hidden" name="a" value="settings_email">
          <input type="hidden" name="act" value="add">

          <label class="font-weight-bold">이메일 추가</label>
          <div class="form-inline">
            <input type="email" name="email" class="form-control" style="width: 50%" required placeholder="<?php echo ($NUM==5)?'최대 5개까지 추가할 수 있습니다.':'' ?>">
            <button type="submit" class="btn btn-light ml-2<?php echo ($NUM==5)?' d-none':'' ?>">
              <span class="not-loading">추가</span>
              <span class="is-loading">추가중..</span>
            </button>
            <div class="invalid-feedback mt-2">이메일을 입력해주세요.</div>
          </div>
        </fieldset>
      </form>

      <?php if ($NUM): ?>
      <hr>
      <div class="mt-4">
        <label class="font-weight-bold">기본 이메일</label>
        <p>기본 이메일은 계정과 관련된 주요알림을 수신합니다.</p>

        <div class="form-inline" id="save-primary">
          <select class="form-control custom-select">
            <?php if ($NUM_VCD): ?>
            <?php while($V=db_fetch_array($VCD)):?>
            <option value="<?php echo $V['uid'] ?>"<?php echo $V['base']?' selected':'' ?>>
              <?php echo $V['email'] ?>
            </option>
            <?php endwhile?>
            <?php else: ?>
            <option value="">인증된 이메일이 없습니다.</option>
            <?php endif; ?>
          </select>
          <?php if ($NUM_VCD): ?>
          <button type="button" class="btn btn-light ml-2 js-submit" >
            <span class="not-loading">저장</span>
            <span class="is-loading">저장중..</span>
          </button>
          <?php endif; ?>
        </div>
        <small class="form-text text-muted mt-2">
          본인인증된 메일만 지정할 수 있습니다.
        </small>
      </div>

      <hr>
      <div class="mt-4">
        <label class="font-weight-bold">백업 이메일</label>
        <p>
          백업 이메일은 기본 이메일을 사용할 수 없을때, 비밀번호 초기화를 위해 사용됩니다.
        </p>
        <div class="form-inline" id="save-backup">
          <select class="form-control custom-select">
            <option value="all"<?php echo ($my['email_backup']==1)?' selected':'' ?>>인증된 메일전체</option>
            <option value="none"<?php echo ($my['email_backup']==0)?' selected':'' ?>>기본 이메일만 사용</option>
            <option disabled>---------------</option>
            <?php while($S=db_fetch_array($SCD)):?>
            <option value="<?php echo $S['uid'] ?>"<?php echo $S['backup']?' selected':'' ?>>
              <?php echo $S['email'] ?>
            </option>
            <?php endwhile?>

          </select>
          <button type="button" class="btn btn-light ml-2 js-submit">
            <span class="not-loading">저장</span>
            <span class="is-loading">저장중..</span>
          </button>
        </div>
        <small class="form-text text-muted mt-2">
          본인인증된 메일만 지정할 수 있습니다.
        </small>
      </div>


      <hr>
      <h4 class="mt-4">환경 설정</h3>

      <div class="mt-3" id="save-config">

        <div class="custom-control custom-radio mt-2">
          <input type="radio" id="mailing_1" name="mailing" value="1"<?php if($my['mailing']):?> checked="checked"<?php endif?> class="custom-control-input">
          <label class="custom-control-label" for="mailing_1">뉴스레터나 공지이메일을 수신받겠습니다.</label>
        </div>
        <div class="custom-control custom-radio mt-2">
          <input type="radio" id="mailing_0" name="mailing" value="0"<?php if(!$my['mailing']):?> checked="checked"<?php endif?> class="custom-control-input">
          <label class="custom-control-label" for="mailing_0">계정과 관련된 메일만 수신합니다.</label>
        </div>

        <button type="button" class="btn btn-light mt-4 js-submit">
          <span class="not-loading">저장</span>
          <span class="is-loading">저장중..</span>
        </button>

      </div>
      <?php endif; ?>

    <?php endif; ?>

  </div><!-- /.page-main -->
</div><!-- /.row -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>

<!-- https://github.com/hilios/jQuery.countdown -->
<?php getImport('jquery.countdown','jquery.countdown.min','2.2.0','js')?>

<script>

var form = $('#emailsForm')
var f = document.getElementById('emailsForm');

function doCountdown() {
  $(document).find('[data-countdown]').each(function() {
    var $this = $(this), finalDate = $(this).data('countdown');
    $this.countdown(finalDate, function(event) {
      $this.html('['+event.strftime('%M:%S')+']');
    });
  });
};

$(function () {

  doCountdown(); //인증번호 유효시간 카운트다운

  putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

  // 본인인증 코드발송
  $('[data-act="send_code"').click(function() {
    var uid = $(this).data('uid')
    var act = 'send_code'
    var url = rooturl+'/?r='+raccount+'&m=member&a=settings_email&act='+act+'&uid='+uid
    $(this).attr('disabled',true)
    getIframeForAction();
    frames.__iframe_for_action__.location.href = url;
    $(this).text('재발송')
  });

  // 본인인증 코드 확인
  $('[data-act="confirm_code"').click(function() {
    var uid = $(this).data('uid')
    var item = $('#item-'+uid)
    var input = $('[name=confirm_code_'+uid+']')
    var tooltip = item.find('.invalid-tooltip')
    var code = input.val()

    if (!code) {
      tooltip.text('인증번호를 입력해주세요.')
      input.focus().addClass('is-invalid')
      return false;
    }

    var act = 'confirm_code'
    var url = rooturl+'/?r='+raccount+'&m=member&a=settings_email&act='+act+'&uid='+uid+'&code='+code
    $(this).attr('disabled',true)
    getIframeForAction();
    frames.__iframe_for_action__.location.href = url;
  });

  // 상태표시 흔적 및 실행버튼 초기화
  form.find('[name="email"]').keyup(function(){
    $(this).removeClass('is-invalid is-valid')
    form.find('[type="submit"]').attr("disabled",false);
  });

  $('[data-role="code"]').keyup(function(){
    $(this).removeClass('is-invalid is-valid')
  });

  // 이메일 삭제
  $('[data-act="del"]').click(function() {
    if (confirm('정말로 삭제하시겠습니까?   ')){
      var uid = $(this).data('uid')
      var act = 'del'
      var url = rooturl+'/?r='+raccount+'&m=member&a=settings_email&act='+act+'&uid='+uid
      $(this).attr('disabled',true)
      getIframeForAction();
      frames.__iframe_for_action__.location.href = url;
    }
  });

  // 기본 이메일 저장
  $('#save-primary').find('.js-submit').click(function() {
    var form = $('#save-primary')
    var uid = form.find('select').val()
    var act = 'save_primary'
    var url = rooturl+'/?r='+raccount+'&m=member&a=settings_email&act='+act+'&uid='+uid
    $(this).attr('disabled',true)
    getIframeForAction();
    setTimeout(function(){
      frames.__iframe_for_action__.location.href = url;
    }, 500);
  });

  // 백업 이메일 저장
  $('#save-backup').find('.js-submit').click(function() {
    var form = $('#save-backup')
    var uid = form.find('select').val()
    var act = 'save_backup'
    var url = rooturl+'/?r='+raccount+'&m=member&a=settings_email&act='+act+'&uid='+uid
    $(this).attr('disabled',true)
    getIframeForAction();
    setTimeout(function(){
      frames.__iframe_for_action__.location.href = url;
    }, 500);
  });

  // 환경설정 저장
  $('#save-config').find('.js-submit').click(function() {
    var form = $('#save-config')
    var mailing = form.find(':radio[name="mailing"]:checked').val();
    var act = 'save_config'
    var url = rooturl+'/?r='+raccount+'&m=member&a=settings_email&act='+act+'&mailing='+mailing
    $(this).attr('disabled',true)
    getIframeForAction();
    setTimeout(function(){
      frames.__iframe_for_action__.location.href = url;
    }, 300);
  });
})

$('#emailsForm').submit(function() {

  var form = $(this)
  var layer = form.find('.invalid-feedback')
  var input = form.find('[name="email"]')
  var btn = form.find('[type="submit"]')

  var obj = f.email

  getIframeForAction(f);

  // 상태초기화
  input.removeClass('is-invalid is-valid')
  btn.attr("disabled",false);

  if (f.checkValidity() === false) {
    input.focus()
    input.addClass('is-invalid')
    layer.text('이메일을 입력해주세요.')
    return false;
  }

  if (!chkEmailAddr(obj.value)) {
    input.focus()
    input.addClass('is-invalid')
    layer.text('이메일 형식이 아닙니다.')
    return false;
  }

  btn.attr("disabled",true);


});


</script>
