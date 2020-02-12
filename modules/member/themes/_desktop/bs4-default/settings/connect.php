
<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
	<nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>

	<div class="col-9 page-main">

		<div class="subhead mt-0">
			<h2 class="subhead-heading">연결계정 관리</h2>
		</div>
	  <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
		<?php include_once $g['dir_module_skin'].'_lock.php'?>
		<?php else: ?>
			<p class="text-muted">외부의 소셜미디어 계정을 연결하고 통합관리 합니다. 연결된 소셜미디어로 사용자인증 및 연결을 지원합니다.</p>
			<ul class="list-group">

				<?php if ($d['connect']['use_n']): ?>
			  <li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://naver.com" target="_blank" class="muted-link">
							<img class="rounded-circle<?php echo !$my_naver['uid']?' filter grayscale':'' ?>" src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버" width="28">
							네이버
						</a>
					</div>
					<div class="">
						<?php if ($my_naver['uid']): ?>
						<small class="mr-3 text-muted">
							<?php echo getDateFormat($my_naver['d_regis'],'Y.m.d H:i') ?> 연결
						</small>
						<button type="button" class="btn btn-outline-secondary" data-act="del" data-uid="<?php echo $my_naver['uid'] ?>">
							연결끊기
						</button>
						<?php else: ?>
						<button type="button" class="btn btn-outline-primary" data-connect="naver" role="button">
							연결하기
						</button>
						<?php endif; ?>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_k']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://kakao.com" target="_blank" class="muted-link">
							<img class="rounded-circle<?php echo !$my_kakao['uid']?' filter grayscale':'' ?>" src="<?php echo $g['img_core']?>/sns/kakao.png" alt="카카오" width="28">
							카카오
						</a>
					</div>
					<div class="">
						<?php if ($my_kakao['uid']): ?>
						<small class="mr-3 text-muted">
							<?php echo getDateFormat($my_kakao['d_regis'],'Y.m.d H:i') ?> 연결
						</small>
						<button type="button" class="btn btn-outline-secondary" data-act="del" data-uid="<?php echo $my_kakao['uid'] ?>">
							연결끊기
						</button>
						<?php else: ?>
						<button type="button" class="btn btn-outline-primary" data-connect="kakao" role="button">
							연결하기
						</button>
						<?php endif; ?>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_g']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://google.com" target="_blank" class="muted-link">
							<img class="rounded-circle<?php echo !$my_google['uid']?' filter grayscale':'' ?>" src="<?php echo $g['img_core']?>/sns/google.png" alt="구글" width="28">
							구글
						</a>
					</div>
					<div class="">
						<?php if ($my_google['uid']): ?>
						<small class="mr-3 text-muted">
							<?php echo getDateFormat($my_google['d_regis'],'Y.m.d H:i') ?> 연결
						</small>
						<button type="button" class="btn btn-outline-secondary" data-act="del" data-uid="<?php echo $my_google['uid'] ?>">
							연결끊기
						</button>
						<?php else: ?>
						<button type="button" class="btn btn-outline-primary" data-connect="google" role="button">
							연결하기
						</button>
						<?php endif; ?>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_f']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://facebook.com" target="_blank" class="muted-link">
							<img class="rounded-circle<?php echo !$my_facebook['uid']?' filter grayscale':'' ?>" src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북" width="28">
							페이스북
						</a>
					</div>
					<div class="">
						<?php if ($my_facebook['uid']): ?>
						<small class="mr-3 text-muted">
							<?php echo getDateFormat($my_facebook['d_regis'],'Y.m.d H:i') ?> 연결
						</small>
						<button type="button" class="btn btn-outline-secondary" data-act="del" data-uid="<?php echo $my_facebook['uid'] ?>">
							연결끊기
						</button>
						<?php else: ?>
						<button type="button" class="btn btn-outline-primary" data-connect="facebook" role="button">
							연결하기
						</button>
						<?php endif; ?>
					</div>
				</li>
				<?php endif; ?>

				<?php if ($d['connect']['use_i']): ?>
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<div class="">
						<a href="http://instagram.com" target="_blank" class="muted-link">
							<img class="rounded-circle<?php echo !$my_instagram['uid']?' filter grayscale':'' ?>" src="<?php echo $g['img_core']?>/sns/instagram.png" alt="인스타그램" width="28">
							인스타그램
						</a>
					</div>
					<div class="">
						<?php if ($my_instagram['uid']): ?>
						<small class="mr-3 text-muted">
							<?php echo getDateFormat($my_instagram['d_regis'],'Y.m.d H:i') ?> 연결
						</small>
						<button type="button" class="btn btn-outline-secondary" data-act="del" data-uid="<?php echo $my_instagram['uid'] ?>">
							연결끊기
						</button>
						<?php else: ?>
						<button type="button" class="btn btn-outline-primary" data-connect="instagram" role="button">
							연결하기
						</button>
						<?php endif; ?>
					</div>
				</li>
				<?php endif; ?>

			</ul>


		<?php endif; ?>

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>


<script type="text/javascript">

$(function () {

  putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

  // sns 삭제
  $('[data-act="del"]').click(function() {
    if (confirm('정말로 연결을 끊으시겠습니까?   ')){
      var uid = $(this).data('uid')
      var act = 'del'
      var url = rooturl+'/?r='+raccount+'&m=member&a=settings_connect&act='+act+'&uid='+uid
      $(this).attr('disabled',true)
      getIframeForAction();
      frames.__iframe_for_action__.location.href = url;
    }
  });

})

</script>
