<footer class="footer footer-<?php echo $d['layout']['footer_theme'] ?> mt-auto border-top-0">

	<div class="footer-quick">
		<div class="<?php echo $d['layout']['footer_container'] ?> px-0">

			<div class="d-flex justify-content-between align-items-center">

				<ul class="list-inline mb-0">
					<li class="list-inline-item">
						<a href="<?php echo RW('mod=policy')?>" class="muted-link">이용약관</a>
					</li>
					<li class="list-inline-item">
						<a href="<?php echo RW('mod=privacy')?>" class="muted-link">개인정보취급방침</a>
					</li>

					<?php if ($my['uid']): ?>
					<li class="list-inline-item">
						<a href="#" data-act="logout" class="muted-link" title="">
							로그아웃
						</a>
					</li>
					<?php else: ?>

					<?php if ($d['layout']['login_type']=='modal'): ?>
					<li class="list-inline-item">
						<a href="#modal-login" data-toggle="modal" class="muted-link" title="모달형 로그인">
							로그인
						</a>
					</li>
					<?php else: ?>
					<li class="list-inline-item">
						<a href="<?php echo RW('mod=login')?>" class="muted-link" title="페이지형 로그인">
							로그인
						</a>
					</li>
					<?php endif; ?>

					<?php endif; ?>
				</ul>

				<div class="text-muted small">
					<!-- 스탠다드 라이센스 없이는 아래 킴스큐 로고를 삭제할 수 없습니다. -->
					powered by <a href="https://kimsq.com" target="_blank" class="text-reset ml-1"><i class="kf kf-bi-01 text-reset"></i></a>
				</div>

				<?php if ($d['layout']['footer_family']): ?>
					<!-- 패밀리 사이트 -->
				<?php getWidget('site/bs4-default/menu/quickmenu/dropdown-joint',array('smenu'=>$d['layout']['footer_family']));?>
				<?php endif; ?>

			</div><!-- /.d-flex -->

		</div><!-- /.container -->
	</div><!-- /.quick-menu -->

</footer>
