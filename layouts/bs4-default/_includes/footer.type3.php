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
					<?php if ($d['layout']['footer_link']) getWidget('bs4-default/site/menu/quickmenu/list-inline',array('smenu'=>$d['layout']['footer_link']));?>
				</ul>

				<!-- 스탠다드 라이센스 없이는 아래 킴스큐 로고를 삭제할 수 없습니다. -->
				<div class="text-muted">
					© <?php echo $d['layout']['company_name']?$d['layout']['company_name']:'company' ?> <?php echo $date['year']?>
				</div>

				<?php if ($d['layout']['footer_family']): ?>
					<!-- 패밀리 사이트 -->
				<?php getWidget('bs4-default/site/menu/quickmenu/dropdown-joint',array('smenu'=>$d['layout']['footer_family']));?>
				<?php endif; ?>

			</div><!-- /.d-flex -->

		</div><!-- /.container -->
	</div><!-- /.quick-menu -->

	<!-- 스탠다드 라이센스 없이는 아래 킴스큐 로고를 삭제할 수 없습니다. -->
	<div class="footer-quick">
		<div class="<?php echo $d['layout']['footer_container'] ?> px-0">
			<div class="text-center">
				<div class="text-muted small">
					powered by <a href="https://kimsq.com" target="_blank" class="text-reset ml-1"><i class="kf kf-bi-01 text-reset"></i></a>
				</div>
			</div><!-- /.d-flex -->
		</div><!-- /.container -->
	</div><!-- /.quick-menu -->

</footer>
