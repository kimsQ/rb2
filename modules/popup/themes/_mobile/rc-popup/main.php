<?php
  $ufilesArray = getArrayString($POP['upload']);
  $_IMG = getDbData($table['s_upload'], 'uid='.$ufilesArray['data'][0], '*');
  $popupImg_URL = $_IMG['url'].$_IMG['folder'].'/'.$_IMG['tmpname'];

?>

<!-- 팝업 popup -->
<div class="popup zoom" id="popup-<?php echo $POP['uid']?>">
  <div class="popup-content">
    <nav class="bar bar-standard bar-footer bg-white">
      <div class="row">
        <div class="col-xs-6">
          <button type="button" class="btn btn-secondary btn-block" id="popCheck_<?php echo $POP['uid']?>">오늘 열지않기</button>
        </div>
        <div class="col-xs-6 p-l-0">
          <button type="button" class="btn btn-secondary btn-block" data-history="back">
            닫기
            <?php echo $popup_test ?>
          </button>
        </div>
      </div>
    </nav>
    <div class="content"<?php if ($POP['bgcolor']): ?> style="background-color: <?php echo $POP['bgcolor'] ?>"<?php endif; ?>>

      <?php if ($POP['type']=='code'): ?>
      <div class="content-padded">
        <?php echo getContents($POP['content'],$POP['html'])?>
      </div>
      <?php else: ?>
      <a href="<?php echo $_IMG['linkurl'] ?>" target="_blank">
        <img src="<?php echo $popupImg_URL?>" alt="<?php echo $POP['name'] ?>" class="img-fluid">
      </a>
      <?php endif; ?>

    </div>
  </div>
</div>



<script type="text/javascript">

  $(function () {

    setTimeout(function(){
      $('#popup-<?php echo $POP['uid']?>').popup({
        show:true,
        backdrop: 'static'
      });
    }, 500);

    // 오늘 하루 그만 보기 체크
    $("#popCheck_<?php echo $POP['uid']?>").tap(function(){
     var nowcookie = getCookie('popview');
     window.history.back();
     setCookie('popview', '[<?php echo $POP['uid']?>]' + nowcookie , 1);
    });

  })

</script>
