<footer class="footer footer-<?php echo $d['layout']['footer_theme'] ?> mt-auto">

	<div class="<?php echo $d['layout']['footer_container'] ?> px-0">
		<div class="d-flex justify-content-between align-items-center">

			<?php echo getLayoutLogo($d['layout'],'footer') ?>

			<div class="<?php echo $d['layout']['footer_logo']?'text-center':'' ?>">
				<ul class="list-inline mb-3">
					<li class="list-inline-item">
						<a href="<?php echo RW('mod=policy')?>" class="muted-link">이용약관</a>
					</li>
					<li class="list-inline-item">
						<a href="<?php echo RW('mod=privacy')?>" class="muted-link">개인정보취급방침</a>
					</li>
					<?php if ($d['layout']['footer_link']) getWidget('site/bs4-default/menu/quickmenu/list-inline',array('smenu'=>$d['layout']['footer_link']));?>
				</ul>
				<p>
					<?php echo $d['layout']['company_name'] ?> <span class="split">|</span> 대표이사 : <?php echo $d['layout']['company_ceo'] ?> <span class="split">|</span> 개인정보 보호 최고책임자 : <?php echo $d['layout']['company_manager'] ?> <br>
					사업자등록번호 : <?php echo $d['layout']['company_num'] ?> <span class="split">|</span> 통신판매업신고번호 <?php echo $d['layout']['company_num2'] ?> <br>
					주소 : <?php echo $d['layout']['company_addr'] ?><br>
					메일 : <?php echo $d['layout']['contact_email'] ?>
					| 전화 : <?php echo $d['layout']['contact_tel'] ?>
					<?php echo $d['layout']['contact_fax']?'| 팩스 : '.$d['layout']['contact_fax']:'' ?><br>

					<span class="d-block text-muted mt-2">© <?php echo $d['layout']['company_name']?$d['layout']['company_name']:'company' ?> <?php echo $date['year']?></span>
					</p>
			</div>


			<div class="text-right footer-contact">

				<div class="sns">

					<?php if ($d['layout']['sns_youtube']): ?>
					<a href="<?php echo $d['layout']['sns_youtube'] ?>" target="_blank">
						<img src="<?php echo $g['img_layout']?>/icon/ico_youtube.png" alt="">
					</a>
					<?php endif; ?>

					<?php if ($d['layout']['sns_instagram']): ?>
					<a href="<?php echo $d['layout']['sns_instagram'] ?>" target="_blank">
						<img src="<?php echo $g['img_layout']?>/icon/ico_instagram.webp" alt="">
					</a>
					<?php endif; ?>

					<?php if ($d['layout']['sns_facebook']): ?>
					<a href="<?php echo $d['layout']['sns_facebook'] ?>" target="_blank">
						<img src="<?php echo $g['img_layout']?>/icon/ico_facebook.webp" alt="">
					</a>
					<?php endif; ?>

					<?php if ($d['layout']['sns_nblog']): ?>
					<a href="<?php echo $d['layout']['sns_nblog'] ?>" target="_blank">
						<img src="<?php echo $g['img_layout']?>/icon/ico_nblog.webp" alt="">
					</a>
					<?php endif; ?>

				</div>

				<?php if ($d['layout']['footer_family']): ?>
					<!-- 패밀리 사이트 -->
				<div class="mt-4">
					<?php getWidget('site/bs4-default/menu/quickmenu/dropdown-joint',array('smenu'=>$d['layout']['footer_family']));?>
				</div>
				<?php endif; ?>

			</div>

		</div>

	</div>

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
