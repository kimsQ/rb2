<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/foot.engine.php'?>

<!-- 포토모달 : photoswipe http://photoswipe.com/documentation/getting-started.html -->
<?php getImport('photoswipe','photoswipe','4.1.1','css') ?>
<?php getImport('photoswipe','default-skin/default-skin','4.1.1','css') ?>
<?php getImport('photoswipe','photoswipe.min','4.1.1','js') ?>
<?php getImport('photoswipe','photoswipe-ui-default.min','4.1.1','js') ?>
<script src="<?php echo $g['url_layout']?>/_js/photoswipe.js"></script>

<!-- 소셜공유시 URL 클립보드저장 : clipboard.js  : https://github.com/zenorocha/clipboard.js-->
<?php getImport('clipboard','clipboard.min','2.0.4','js') ?>

<!-- 입력 textarea 자동확장 -->
<?php getImport('autosize','autosize.min','3.0.14','js')?>

<!-- markjs js : https://github.com/julmot/mark.js -->
<?php getImport('markjs','jquery.mark.min','8.11.1','js')?>

<!-- linkifyjs : https://github.com/Soapbox/linkifyjs -->
<?php getImport('linkifyjs','linkify.min','2.1.8','js')?>
<?php getImport('linkifyjs','linkify-string.min','2.1.8','js')?>

<!-- bootstrap-notify : https://github.com/mouse0270/bootstrap-notify -->
<?php getImport('bootstrap-notify','bootstrap-notify.min','3.1.3','js')?>

<!-- 댓글출력시 필요 -->
<?php if ($g['broswer']!='MSIE 11' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 9'): ?>
  <?php if ($mod!='write'): ?>
  <?php getImport('ckeditor5','decoupled-document/build/ckeditor',false,'js');  ?>
  <?php getImport('ckeditor5','decoupled-document/build/translations/ko',false,'js');  ?>
  <?php endif; ?>
  <script src="<?php echo $g['url_root']?>/modules/comment/lib/Rb.comment.js"></script>
<?php else: ?>
  <script src="<?php echo $g['url_root']?>/modules/comment/lib/Rb.comment.old.js"></script>
<?php endif; ?>


<!-- 레이아웃 공용 스크립트 -->
<script src="<?php echo $g['url_layout']?>/_js/main.js<?php echo $g['wcache']?>"></script>

<?php if($_SERVER['HTTPS'] == 'on' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 11'):?>
<script>
if ('serviceWorker' in navigator && 'PushManager' in window) {
  console.log('서비스워커와 푸시가 지원되는 브라우저 입니다.');
  window.addEventListener('load', () => {
   navigator.serviceWorker.register('<?php echo $g['s']?>/sw.js');
 });
} else {
  console.warn('푸시 메시징이 지원되지 않는 브라우저 입니다.');
}
</script>
<?php endif?>
