<?php
if(!defined('__KIMS__')) exit;

$g['notiVarForSite'] = $g['path_var'].'site/'.$r.'/notification.var.php';
include_once file_exists($g['notiVarForSite']) ? $g['notiVarForSite'] : $g['path_module'].'notification/var/var.php';

$N = explode('|',$my['noticeconf']);
$send_email = $N[1]?1:0;
$send_push = $N[2]?1:0;
?>

<?php if ($my['uid'] && $g['push_active']==1): ?>
  <!-- FCM -->
  <script src="<?php echo $g['s']?>/_var/fcm.info.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.2.0/firebase-messaging.js"></script>
  <script src="<?php echo $g['url_layout']?>/_js/noti.js"></script>
  <div class="token" hidden></div>

  <?php if (!$send_push): ?>
  <script>
    console.log('푸시알림이 비활성화 되어 <?php echo $d['ntfc']['sec']?>초 마다 알림사항을 체크합니다.')
    setTimeout(function(){
      var src = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=notification&a=get_notiNum&browtitle=<?php echo $g['browtitle']?>'
      $("iframe[name=pushframe]").attr('src',src)
    }, <?php echo $d['ntfc']['sec']?>000);

  </script>
  <?php endif; ?>
<?php endif; ?>
