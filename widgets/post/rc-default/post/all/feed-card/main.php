<section class="widget" data-role="postFeed">
  <div data-role="list"></div>

  <div data-role="none" hidden>
    <div class="d-flex justify-content-center align-items-center" style="height: 70vh">
      <div class="text-xs-center text-reset">
        <div class="material-icons mb-4" style="font-size: 100px;color:#ccc">
          subscriptions
        </div>
        <h5>나만의 채널을 시작합니다.</h5>
        <small class="text-muted">당신만울 위한 모바일 베이스캠프</small>

        <div class="mt-4 text-xs-center">
          <?php if ($my['uid']): ?>
          <a class="btn btn-primary btn-lg" role="button"
            href="#popup-post-newPost"
            data-toggle="popup"
            data-start="<?php echo $wdgvar['start'] ?>"
            data-url="/post/write"
            data-title="새 포스트">
            포스트 작성
          </a>
          <?php else: ?>
          <a class="btn btn-primary btn-lg" role="button"
            href="#modal-login"
            data-toggle="modal"
            data-title="로그인">
            로그인
          </a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</section>

<script>

$( document ).ready(function() {

    getPostAll({
      wrapper : $('<?php echo $wdgvar['wrapper'] ?> [data-role="list"]'),
      start : '<?php echo $wdgvar['start'] ?>',
      markup    : 'post-row',  // 테마 > _html > post-row-***.html
      recnum    : <?php echo $wdgvar['recnum'] ?>,
      sort      : 'gid',
      none : $('<?php echo $wdgvar['wrapper'] ?>').find('[data-role="none"]').html(),
      paging : 'infinit'
    })

});

</script>
