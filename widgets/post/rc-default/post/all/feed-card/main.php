<section class="widget" data-role="postFeed">
  <div data-role="list"></div>

  <div data-role="none" hidden>
    <div class="py-5">
      <div class="text-xs-center text-reset">
        <?php if ($my['uid']): ?>
        <a class="btn btn-outline-primary" role="button"
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
