<?php if ($g['mobile']&&$_SESSION['pcmode']!='Y'): ?>
<header class="bar bar-nav bar-light bg-faded">
  <a class="icon icon-left-nav pull-left" role="button" data-history="back"></a>
  <h1 class="title"><?php echo $B['name'] ?></h1>
</header>
<div class="content">
	<div class="content-padded text-xs-center text-muted pt-5">

		<h3 class="">
			<div class="d-block mb-3"><i class="fa fa-exclamation-circle fa-lg fa-2x"></i></div>
			서비스 안내
		</h3>

		<ul class="list-unstyled text-left mt-4 small">
      <?php if ($my['uid']): ?>
      <li>요청하신 게시판의 접근권한이 없습니다.</li>
      <?php else: ?>
			<li>요청하신 게시판에는 권한이 있어야 접근하실 수 있습니다.</li>
			<li>로그인 후에 이용하세요.</li>
      <?php endif; ?>
		</ul>
    <?php if (!$my['uid']): ?>
    <button type="button" class="btn btn-outline-primary btn-block mt-3" data-toggle="modal" data-target="#modal-login">로그인 하기</button>
    <?php endif; ?>

		<button type="button" class="btn btn-secondary btn-block mt-2" data-history="back">이전가기</button>

	</div>
</div><!-- /.content -->

<?php else: ?>
<div class="mt-5 mx-auto w-50 text-center text-center text-muted">

	<h3 class="mb-3">
		<div class="d-block mb-3"><i class="fa fa-exclamation-circle fa-lg fa-3x"></i></div>
		서비스 안내
	</h3>

	<ul class="list-unstyled my-4">
    <?php if ($my['uid']): ?>
    <li>요청하신 게시판의 접근권한이 없습니다.</li>
    <?php else: ?>
		<li>요청하신 게시판에는 권한이 있어야 접근하실 수 있습니다.</li>
		<li>로그인 후에 이용하세요.</li>
    <?php endif; ?>
	</ul>
  <?php if (!$my['uid']): ?>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login">로그인 하기</button>
  <?php endif; ?>
	<button type="button" class="btn btn-light" onclick="history.back();">이전가기</button>

</div>
<?php endif; ?>
