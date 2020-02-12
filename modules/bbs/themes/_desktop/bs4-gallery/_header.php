<!-- 게시판 헤더 파일 -->
<?php if ($g['add_header_img']): ?>
<div class="my-3">
  <img src="<?php echo $g['add_header_img'] ?>" alt="" class="img-fluid">
</div>
<?php endif; ?>

<!-- 게시판 헤더 코드 -->
<?php if ($g['add_header_inc']) include_once $g['add_header_inc'];?>
