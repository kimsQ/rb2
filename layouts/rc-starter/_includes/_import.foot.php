<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/foot.engine.php'?>

<!-- youtube iframe_api -->
<script src="https://www.youtube.com/player_api"></script>

<!-- 입력 textarea 자동확장 -->
<?php getImport('autosize','autosize.min','3.0.14','js')?>

<!-- jQuery-Autocomplete : https://github.com/devbridge/jQuery-Autocomplete -->
<?php getImport('jQuery-Autocomplete','jquery.autocomplete.min','1.3.0','js') ?>

<!-- jquery.shorten : https://github.com/viralpatel/jquery.shorten -->
<?php getImport('jquery.shorten','jquery.shorten.min','1.0','js')?>

<!-- linkifyjs : https://github.com/Soapbox/linkifyjs -->
<?php getImport('linkifyjs','linkify.min','2.1.8','js')?>
<?php getImport('linkifyjs','linkify-string.min','2.1.8','js')?>

<!-- moment -->
<?php getImport('moment','moment','2.22.2','js');?>
<?php getImport('moment-duration-format','moment-duration-format','2.2.2','js');?>

<!-- Chart.js : https://github.com/chartjs/Chart.js/  -->
<?php getImport('Chart.js','Chart','2.8.0','css') ?>
<?php getImport('Chart.js','Chart.bundle.min','2.8.0','js') ?>

<!-- markjs js : https://github.com/julmot/mark.js -->
<?php getImport('markjs','jquery.mark.min','8.11.1','js')?>

<!-- 댓글출력시 필요 -->
<?php if ($mod!='write'): ?>
<?php getImport('ckeditor5','decoupled-document/build/ckeditor','16.0.0','js');  ?>
<?php getImport('ckeditor5','decoupled-document/build/translations/ko','16.0.0','js');  ?>
<?php endif; ?>
<script src="<?php echo $g['url_root']?>/modules/comment/lib/Rb.comment.js<?php echo $g['wcache']?>"></script>

<!-- 레이아웃 공용 스크립트 -->
<script src="<?php echo $g['url_layout']?>/_js/main.js<?php echo $g['wcache']?>"></script>

<?php if($_SERVER['HTTPS'] == 'on' && ($g['mobile']!='ipad' || $g['mobile']!='iphone') ):?>
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
