<?php

$phone_que = 'mbruid='.$my['uid'].' and device="phone"';
$tablet_que = 'mbruid='.$my['uid'].'  and device="tablet"';
$desktop_que = 'mbruid='.$my['uid'].' and device="desktop"';

$PTK = getDbData($table['s_iidtoken'],$phone_que,'*');
$TTK = getDbData($table['s_iidtoken'],$tablet_que,'*');
$DTK = getDbData($table['s_iidtoken'],$desktop_que,'*');

?>


<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
  <nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>
  <div class="col-9 page-main">

    <div class="subhead mt-0">
      <h2 class="subhead-heading">웹앱 설치내역</h2>
    </div>

    <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
    <?php include_once $g['dir_module_skin'].'_lock.php'?>
    <?php else: ?>

    <p class="note">웹앱은 안드로이드 크롬 및 내장 브라우저의 기능인 '홈 화면에 추가' 를 통해 내 폰에 설치할 수 있습니다. 두번째 접속시에는 자동으로 '홈 화면에 추가' 대화상자가 자동으로 호출되어 쉬운 설치를 지원합니다.</p>

    <div class="card mt-2">
      <div class="card-header">
        서비스 워커
      </div>
      <div class="card-body">
        <button class="js-install-sw btn btn-outline-primary">서비스워커 설치</button>
        <button class="js-uninstall-sw btn btn-outline-primary">서비스 워커 제거</button>
      </div>
    </div>

    <?php endif; ?>

  </div><!-- /.page-main -->
</div><!-- /.row -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>


<script>

const installSW = document.querySelector('.js-install-sw');
const uninstallSW = document.querySelector('.js-uninstall-sw');

installSW.addEventListener('click', () => {
  navigator.serviceWorker.register('<?php echo $g['s']?>/sw.js');
  navigator.serviceWorker.register('<?php echo $g['s']?>/firebase-messaging-sw.js');
});

uninstallSW.addEventListener('click', () => {
  navigator.serviceWorker.getRegistration('/')
  .then((reg) => {
    return reg.unregister();
  })
});


putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력


$('[data-toggle="popover"]').popover({
  trigger: 'hover',
  html : true
})


</script>
