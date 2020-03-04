<header class="header">

	<div class="<?php echo $d['layout']['header_container'] ?> px-0">
		<div class="d-flex justify-content-between align-items-center pt-1">
			<div class=""></div>
			<div class="">
				<nav class="nav top-nav">

					<?php if (!$my['uid']): ?>

					<?php if ($d['layout']['login_type']=='modal'): ?>
					<a class="nav-link" href="#modal-login" data-toggle="modal">로그인</a>
					<?php else: ?>
					<a class="nav-link" href="<?php echo RW('mod=login')?>">로그인</a>
					<?php endif; ?>

					<a class="nav-link" href="#modal-join" data-toggle="modal" data-backdrop="static">회원가입</a>
					<?php else: ?>
					<div class="dropdown">
						<button class="nav-link btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo $my['email'] ?>
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
							<span class="dropdown-menu-arrow"></span>
							<h6 class="dropdown-header"><?php echo $my['nic'] ?> 님</h6>

							<?php if ($d['post']['writeperm']): ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo RW('m=post&mod=write')?>">
								새 포스트
							</a>
							<?php endif; ?>

							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo RW('mod=dashboard')?>">
								대시보드
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo getProfileLink($my['uid'])?>">
								프로필
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo RW('mod=settings')?>">
								설정
							</a>
							<button class="dropdown-item" type="button" data-act="logout" role="button">
								로그아웃
							</button>
							<?php if ($my['admin']): ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="/admin" target="_top">관리자모드</a>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>

					<a class="nav-link" href="<?php echo RW('mod=cscenter')?>">고객센터</a>
				</nav>
			</div>
		</div>
	</div>

	<div class="<?php echo $d['layout']['header_container'] ?> px-0">
		<div class="d-flex justify-content-start align-items-center navbar p-0">

			<?php echo getLayoutLogo($d['layout'])?>

			<div class="ml-3" >
				<form class="form-inline" action="<?php echo $_HS['rewrite']? RW('m=search'):$g['s'].'/'?>" role="search" data-role="searchform">
					<?php if (!$_HS['rewrite']): ?>
					<input type="hidden" name="r" value="<?php echo $r ?>">
					<input type="hidden" name="m" value="search">
					<?php endif; ?>

					<div class="input-group input-group-lg dropdown shadow-sm">
						<input type="search" name="q" class="form-control bg-white border-0 rounded-0" value="<?php echo $q ?>" data-plugin="autocomplete" autocomplete="off" required="">
						<div class="input-group-append">
							<button class="btn btn-white border-0 rounded-0" type="submit"><i class="fa fa-search"></i></button>
						</div>
					</div>

				</form>
			</div>

			<div class="ml-auto">
				<a href="https://pf.kakao.com/_XrQxkM" taget="_blank">
					<img src="https://t1.daumcdn.net/daumtop_deco/banner/corona19_G.png" width="260" height="84" class="img_thumb" alt="광고 신종코로나바이러스감염증 예방수칙">
				</a>
			</div>

		</div><!-- /.d-flex -->
	</div><!-- /.container -->

	<section class="border-top" style="margin-left:-15px;margin-right:-15px">
		<div class="inner">
			<div class="<?php echo $d['layout']['header_container'] ?> px-0">
				<ul class="nav nav-fill" data-role="menu">
					<?php if ($d['layout']['header_allcat']=='true'): ?>
					<li class="nav-item">
						<a class="nav-link" href="/c/1">
							<i class="material-icons align-text-bottom">menu</i>
							전체 카테고리
						</a>
					</li>
					<?php endif; ?>
					<?php getWidget('site/bs4-default/menu/navbar/'.$d['layout']['header_menu'],array('smenu'=>'0','limit'=>$d['layout']['header_menu_limit'],'dropdown'=>'1',));?>
				</ul>
			</div>
		</div>
	</section>

</header>
