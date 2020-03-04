<header class="header">

	<div class="container-fluid px-0">
		<div class="d-flex justify-content-between align-items-center navbar p-0">

			<h1 class="my-0 h5 font-weight-normal">
				<a class="navbar-brand" href="<?php  echo RW(0) ?>"
					style="background-image:url(<?php echo $d['layout']['header_logo']?$g['url_var_site'].'/'.$d['layout']['header_logo'].$g['wcache']:''?>);background-size:<?php echo $d['layout']['header_logo_size'] ?>%">
					<?php echo !$d['layout']['header_logo']?$d['layout']['header_title'] :'' ?>
				</a>
			</h1>

			<div class="form-inline">
				<?php if ($d['layout']['header_search']=='true'):?>
				<form action="<?php echo $_HS['rewrite']? RW('m=search'):$g['s'].'/'?>" role="search">
					<?php if (!$_HS['rewrite']): ?>
					<input type="hidden" name="r" value="<?php echo $r ?>">
					<input type="hidden" name="m" value="search">
					<?php endif; ?>
					<input class="form-control mr-sm-2" type="search" placeholder="통합검색" aria-label="Search" name="q" value="<?php echo $q ?>" autocomplete="off">
				</form>
				<?php endif?>

				<ul class="nav">
					<?php if ($my['uid']): ?>

					<?php else: ?>
					<?php if ($d['layout']['login_type']=='modal'): ?>
					<a class="nav-link" href="#modal-login" data-toggle="modal">로그인</a>
					<?php else: ?>
					<a class="nav-link" href="<?php echo RW('mod=login')?>">로그인</a>
					<?php endif; ?>

					<?php endif; ?>
				</ul>
			</div>

		</div><!-- /.d-flex -->
	</div><!-- /.container -->

</header>
