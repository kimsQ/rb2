<!DOCTYPE html>
<html lang="ko">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body class="rb-layout-full" style="padding-top:50px">

	<nav class="navbar fixed-top navbar-expand navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php  echo RW(0) ?>">
				<?php echo $d['layout']['header_file']?'<img src="'.$g['url_layout'].'/_var/'.$d['layout']['header_file'].'">':stripslashes($d['layout']['header_title'])?>
			</a>

			<div class="">

				<?php if($d['layout']['header_login']=='true'):?>
				<ul class="navbar-nav">
				<?php if ($my['uid']): ?>
					<li class="nav-item dropdown">
					  <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-role="tooltip" title="프로필보기 및 회원계정관리">
					    <img src="<?php echo getAvatarSrc($my['uid'],'20') ?>" width="20" height="20" alt="" class="rounded d-inline-block align-top">
							<?php echo $my['nic'] ?>
					  </a>
					  <div class="dropdown-menu dropdown-menu-right">
					    <h6 class="dropdown-header"><?php echo $my['nic'] ?> 님</h6>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo RW('m=post&mod=write')?>">
								새 포스트
							</a>
							<a class="dropdown-item" href="<?php echo RW('mod=dashboard')?>">
								대시보드
							</a>
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
							<a class="dropdown-item text-danger" href="/?m=admin&pickmodule=site&panel=Y" target="_top">관리자모드</a>
							<?php endif; ?>
					  </div>
					</li>
					<?php else: ?>
					<li class="nav-item">
						<a class="nav-link" href="#modal-join" data-toggle="modal" data-backdrop="static">회원가입</a>
					</li>
					<li class="nav-item position-relative" id="navbarPopoverLogin">
						<a class="nav-link dropdown-toggle" href="#modal-login" data-toggle="modal" aria-haspopup="true" aria-expanded="false" title="모달형 로그인">
							로그인
						</a>
					</li>

					<?php endif; ?>
		    </ul>
				<?php endif?>
			</div>
		</div><!-- /.container -->
	</nav>

	<?php include __KIMS_CONTENT__ ?>

	<?php include $g['dir_layout'].'/_includes/component.php' ?>
	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
