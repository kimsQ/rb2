<?php
$phone_que = 'mbruid='.$_M['uid'].' and device="phone"';
$tablet_que = 'mbruid='.$_M['uid'].'  and device="tablet"';
$desktop_que = 'mbruid='.$_M['uid'].' and device="desktop"';

$PTK = getDbData($table['s_iidtoken'],$phone_que,'*');
$TTK = getDbData($table['s_iidtoken'],$tablet_que,'*');
$DTK = getDbData($table['s_iidtoken'],$desktop_que,'*');

?>


<div class="card" id="token_div" style="">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>
      인스턴스 토큰
    </span>
    <button class="btn btn-light btn-sm js-sendTest" data-toggle="popover" title="" data-content="<span class='text-muted f12'>등록된 토큰을 기반으로 데스크탑과 모바일로<br>푸시알림 메시지가 각각 발송됩니다.<br>메시지가 수신된다면 정상적으로 셋팅된 것입니다.</span>" data-original-title="푸시알림 테스트">
       <span class="not-loading">회원에게 테스트 푸시알림 전송</span>
       <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 보내는중 ...</span>
    </button>
  </div>
  <div class="card-body">

    <div class="media">
      <span class="mr-3 text-center">
        <i class="fa fa-desktop fa-3x align-self-center" aria-hidden="true" style="width: 70px"></i><br>
        <span class="mt-3 f12 text-muted">데스크탑</span>
      </span>
      <div class="media-body">
        <?php if ($DTK['token']): ?>
        <dl class="row mb-0 f12 text-muted">
          <dt class="col-2">브라우저</dt>
          <dd class="col-9"><?php echo $DTK['browser'] ?> <?php echo $DTK['version'] ?></dd>
          <dt class="col-2">등록일시</dt>
          <dd class="col-9"><?php echo getDateFormat($DTK['d_update']?$DTK['d_update']:$DTK['d_regis'],'Y.m.d H:i')?></dd>
          <dt class="col-2">토큰</dt>
          <dd class="col-9 mb-0" style="word-break: break-all;"><?php echo $DTK['token'] ?></dd>
        </dl>
        <?php else: ?>
        <div class="py-3 text-muted small">
          등록된 토큰이 없습니다.
        </div>
        <?php endif; ?>
      </div>
    </div>

    <hr>

    <div class="media">
      <span class="mr-3 text-center">
        <i class="fa fa-mobile fa-3x" aria-hidden="true" style="width: 70px"></i><br>
        <span class="mt-3 f12 text-muted">스마트폰</span>
      </span>
      <div class="media-body align-self-center">
        <?php if ($PTK['token']): ?>
        <dl class="row mb-0 f12 text-muted">
          <dt class="col-2">브라우저</dt>
          <dd class="col-9"><?php echo $PTK['browser'] ?> <?php echo $PTK['version'] ?></dd>
          <dt class="col-2">등록일시</dt>
          <dd class="col-9"><?php echo getDateFormat($PTK['d_update']?$PTK['d_update']:$PTK['d_regis'],'Y.m.d H:i')?></dd>
          <dt class="col-2">토큰</dt>
          <dd class="col-9 mb-0" style="word-break: break-all;"><?php echo $PTK['token'] ?></dd>
        </dl>
        <?php else: ?>
        <div class="py-3 text-muted small">
          등록된 토큰이 없습니다.
        </div>
        <?php endif; ?>

      </div>
    </div>

    <hr>

    <div class="media">
      <span class="mr-3 text-center">
        <i class="fa fa-tablet fa-3x" aria-hidden="true" style="width: 70px"></i><br>
        <span class="mt-3 f12 text-muted">태블릿</span>
      </span>
      <div class="media-body align-self-center">
        <?php if ($TTK['token']): ?>
        <dl class="row mb-0 f12 text-muted">
          <dt class="col-2">브라우저</dt>
          <dd class="col-9"><?php echo $TTK['browser'] ?> <?php echo $TTK['version'] ?></dd>
          <dt class="col-2">등록일시</dt>
          <dd class="col-9"><?php echo getDateFormat($TTK['d_update']?$TTK['d_update']:$TTK['d_regis'],'Y.m.d H:i')?></dd>
          <dt class="col-2">토큰</dt>
          <dd class="col-9 mb-0" style="word-break: break-all;"><?php echo $TTK['token'] ?></dd>
        </dl>
        <?php else: ?>
        <div class="py-3 text-muted small">
          등록된 토큰이 없습니다.
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <span class="f12 text-muted">
      인스턴스 ID 토큰은 푸시알림에 활용되며 기기별로 1개만 저장 됩니다.<br>
      접속기기가 변경되면 토큰 또한 변경되며, 변경된 토큰정보는 로그인 후 갱신저장 됩니다.
    </span>
  </div>
</div>

<script>

$('.js-sendTest').click(function(event) {
  event.preventDefault();
  var btn = $(this)
  var popover = $('[data-toggle="popover"]')
  // popover.popover('hide')
  btn.attr('disabled',true)
  var title = '<?php echo $_HS['name'] ?> 데스크탑에서 보낸 푸시알림'
  var message = '푸시알림이 정상적으로 수신되었습니다.'
  $.post(rooturl+'/?r='+raccount+'&m=notification&a=push_testonly',{
     mbruid : '<?php echo $_M['uid'] ?>',
     title : title,
     message : message
    },function(response){
     var result = $.parseJSON(response);
     var error=result.error;
     if (!error) {
       btn.attr('disabled',false)
       console.log('테스트 푸시알림이 수신 되었습니다.')
     }
   });
});
</script>
