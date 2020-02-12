<?php
  $ufilesArray = getArrayString($POP['upload']);
  $_IMG = getDbData($table['s_upload'], 'uid='.$ufilesArray['data'][0], '*');
  $popupImg_URL = $_IMG['url'].$_IMG['folder'].'/'.$_IMG['tmpname'];
?>



<style>
<?php if ($POP['position']=='manual'): ?>
.modal,
.modal-dialog,
.modal-content {
  position: absolute;
}
body,
.modal {
  padding-right: 0 !important
}

<?php endif; ?>

<?php if ($POP['draggable']): ?>
.modal.rb-popup .modal-content {
	cursor: move;
}
<?php endif; ?>
</style>

<!-- 팝업 모달-->
<div class="modal fade rb-popup" tabindex="-1" role="dialog" id="popup-<?php echo $POP['uid']?>"
  style="<?php if ($POP['position']=='manual'): ?><?php if ($POP['center']): ?>left: 50%;top: 50%;<?php endif; ?>width:<?php echo $POP['width']?>px; <?php echo $POP['center']?'margin-top':'top'?>: <?php echo $POP['ptop']?>px; <?php echo $POP['center']?'margin-left':'left'?> : <?php echo $POP['pleft']?>px<?php endif; ?>">
  <div class="modal-dialog <?php if ($POP['position']=='vcenter'): ?>modal-dialog-centered<?php endif; ?>" role="document">
    <div class="modal-content" style="width:<?php echo $POP['width']?>px;">
      <div class="modal-body" style="max-height: 500px;overflow-y:auto;background-color: <?php echo $POP['bgcolor'] ?>">
        <?php if ($POP['type']=='code'): ?>
        <div class="p-2">
          <?php echo getContents($POP['content'],$POP['html'])?>
        </div>
        <?php else: ?>
        <a href="<?php echo $_IMG['linkurl'] ?>" target="_blank">
          <img src="<?php echo $popupImg_URL?>" alt="" class="img-fluid">
        </a>
        <?php endif; ?>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-light btn-sm" id="popCheck_<?php echo $POP['uid']?>">오늘하루 열지않기</button>
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

<?php if ($POP['draggable']): ?>
<?php getImport('jquery-ui','jquery-ui-custom.min','1.12.1','js')?>
<?php endif; ?>


<script type="text/javascript">

  $(function () {

    $('#popup-<?php echo $POP['uid']?>').modal({
      <?php if ($POP['position']=='manual'): ?>
      backdrop: false
      <?php else: ?>
      backdrop: 'static'
      <?php endif; ?>
    });

    // 오늘 하루 그만 보기 체크
    $("#popCheck_<?php echo $POP['uid']?>").click(function(){
     var nowcookie = getCookie('popview');
     setCookie('popview', '[<?php echo $POP['uid']?>]' + nowcookie , 1);
     $('#popup-<?php echo $POP['uid']?>').modal('hide');
    });


    <?php if ($POP['position']=='manual'): ?>
    $('body').removeClass('modal-open')
    <?php endif; ?>

    <?php if ($POP['draggable']): ?>
    // draggable modal
    $(".rb-popup").draggable({
     handle: ".modal-content"
    });
    <?php endif; ?>

  })

</script>
