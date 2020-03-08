<header class="header">

	<div class="<?php echo $d['layout']['header_container'] ?> px-0">
		<div class="d-flex align-items-center navbar p-0">

			<?php echo getLayoutLogo($d['layout'],'header')?>

			<div class="inner mr-auto flex-fill">

				<ul class="nav" data-role="menu">
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

				<?php if ($d['layout']['header_search']=='button'):?>
				<form class="form-inline" action="<?php echo $_HS['rewrite']? RW('m=search'):$g['s'].'/'?>" role="search" data-role="searchbox">
					<?php if (!$_HS['rewrite']): ?>
					<input type="hidden" name="r" value="<?php echo $r ?>">
					<input type="hidden" name="m" value="search">
					<?php endif; ?>
					<div class="input-group input-group-lg dropdown border-0 w-100">
						<input type="text" name="q" class="form-control bg-white border-0 rounded-0" value="<?php echo $q ?>" data-plugin="autocomplete" autocomplete="off" required="" placeholder="검색어를 입력해주세요.">
					</div>
				</form>
				<?php endif?>

			</div>

			<div class="form-inline">

				<?php if ($d['layout']['header_search']=='input'):?>
				<form action="<?php echo $_HS['rewrite']? RW('m=search'):$g['s'].'/'?>" role="search">
					<?php if (!$_HS['rewrite']): ?>
					<input type="hidden" name="r" value="<?php echo $r ?>">
					<input type="hidden" name="m" value="search">
					<?php endif; ?>
					<input class="form-control mr-sm-2" type="search" placeholder="통합검색" aria-label="Search" name="q" value="<?php echo $q ?>" autocomplete="off">
				</form>
				<?php elseif ($d['layout']['header_search']=='button'): ?>
				<button type="button" class="btn btn-link text-muted" data-toggle="searchbox">
					<i class="fa fa-search fa-lg" aria-hidden="true"></i>
				</button>
				<?php endif?>

				<?php if ($d['layout']['header_login']=='true'): ?>
				<ul class="nav">
					<?php if ($my['uid']): ?>
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
					<?php else: ?>
					<?php if ($d['layout']['login_type']=='modal'): ?>
					<a class="nav-link" href="#modal-login" data-toggle="modal">로그인</a>
					<?php else: ?>
					<a class="nav-link" href="<?php echo RW('mod=login')?>">로그인</a>
					<?php endif; ?>

					<?php endif; ?>
				</ul>
				<?php endif; ?>

			</div>

		</div><!-- /.d-flex -->
	</div><!-- /.container -->

</header>
