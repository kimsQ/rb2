<div data-role="loader">
  <div class="d-flex justify-content-center align-items-center text-muted" style="height:90vh">
    <div class="spinner-border" role="status"></div>
  </div>
</div>

<div class="d-flex justify-content-center align-items-center text-muted" style="height:80vh">
  <button class="btn btn-secondary btn-block"
    data-toggle="profile"
    data-target="#modal-member-profile"
    data-mbruid="<?php echo $_MP['uid'] ?>"
    data-title="<?php echo $mbrid ?>"
    data-url="/@<?php echo $mbrid ?>">
    프로필 열기
  </button>
</div>

<script>

$( document ).ready(function() {
  $('[data-role="loader"]').addClass('d-none');
  $('[data-toggle="profile"]').click();
});

</script>
