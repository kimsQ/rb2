<div data-role="loader">
  <div class="d-flex justify-content-center align-items-center text-muted" style="height:90vh">
    <div class="spinner-border" role="status"></div>
  </div>
</div>

<div class="d-flex justify-content-center align-items-center text-muted" style="height:90vh">
  <div class="w-75">
    <button type="button" data-location="reload" class="btn btn-secondary btn-block">
      새로고침
    </button>
    <button type="button" data-href="/" data-text="홈으로 이동" class="btn btn-secondary btn-block">
      홈으로 이동
    </button>
  </div>
</div>


<?php getImport('ckeditor5','decoupled-document/build/ckeditor',false,'js');  ?>
<?php getImport('ckeditor5','decoupled-document/build/translations/ko',false,'js');  ?>

<script>

var uid = '<?php echo $R['uid'] ?>';

$( document ).ready(function() {

  $('[data-role="loader"]').addClass('d-none');
  if (uid) modal_post_write.attr('data-uid',uid);
  modal_post_write.modal();

});

</script>
