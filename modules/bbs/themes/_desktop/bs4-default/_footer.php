<!-- 게시판 픗터 파일 -->
<?php if ($g['add_footer_img']): ?>
<div class="my-3">
  <img src="<?php echo $g['add_footer_img'] ?>" alt="" class="img-fluid my-3">
</div>
<?php endif; ?>

<!-- 게시판 픗터 코드 -->
<?php if ($g['add_footer_inc']) include_once $g['add_footer_inc'];?>
