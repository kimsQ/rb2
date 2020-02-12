<?php
$sort	= 'uid';
$orderby= 'desc';
$recnum	= 15;
$mbrque	= 'my_mbruid='.$_MP['uid'];

if ($where && $keyword) $mbrque .= getSearchSql($where,$keyword,$ikeyword,'or');
$RCD = getDbArray($table['s_friend'],$mbrque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_friend'],$mbrque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div class="page-wrapper row">
	<div class="col-3 page-nav">

		<?php include $g['dir_module_skin'].'_vcard.php';?>
	</div>

	<div class="col-9 page-main">

		<?php include $g['dir_module_skin'].'_nav.php';?>

		<ul class="list-group list-group-flush border-top-0">

			<?php $i=0;while($_R=db_fetch_array($RCD)):$i++?>
			<?php $num_follower = getProfileInfo($_R['by_mbruid'],'num_follower');?>
			<?php $_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$_R['by_mbruid']); ?>

			<li class="list-group-item d-flex justify-content-between align-items-center px-0" data-mbruid="<?php echo $_R['by_mbruid'] ?>">

				<div class="media w-75 align-items-center">
					<a href="<?php echo getProfileLink($_R['by_mbruid'])?>" class="mr-3">
						<img alt="" class="rounded-lg border" src="<?php echo getAvatarSrc($_R['by_mbruid'],'50') ?>" width="50" height="50" >
					</a>
					<div class="media-body">
						<a href="<?php echo getProfileLink($_R['by_mbruid'])?>" class="text-decoration-none text-reset">
							<span class="f4 link-gray-dark"><?php echo getProfileInfo($_R['by_mbruid'],'nic')?></span>
						</a>
						<p class="text-muted small mb-0">
							구독자 <span data-role="num_follower"><?php echo number_format($num_follower)?></span>명
						</p>
					</div>
				</div><!-- /.media -->

				<div class="">

					<?php if ($my['uid']): ?>
					<?php if($my['uid']!=$_R['by_mbruid']):?>
					<button type="button" class="btn btn-primary btn-sm<?php echo $_isFollowing ?' active':''?>"
					 data-act="actionIframe"
					 data-toggle="button"
					 data-role="follow"
					 data-url="<?php echo $g['s'].'/?r='.$r.'&amp;m=member&amp;a=profile_follow&amp;mbruid='.$_R['by_mbruid']?>">
						팔로우
					</button>
					<?php endif?>
					<?php else: ?>
					<span class="dropdown">
						<button type="button" class="btn btn-primary" data-toggle="dropdown">
							팔로우
						</button>
						<div class="dropdown-menu dropdown-menu-right shadow" style="min-width: 350px;">
							<div class="py-3 px-4">
								<h6><?php echo $M1[$_HS['nametype']] ?>님의 포스트를 구독하시겠습니까?</h6>
								<p class="f13 text-muted mb-0">구독하려면 로그인하세요.</p>
							</div>
							<div class="dropdown-divider"></div>
							<div class="px-3 text-right">
								<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modal-login">
									로그인
								</button>
							</div>
						</div>
					</span>
					<?php endif; ?>

			  </div>

			</li><!-- /.list-group-item  -->
			<?php endwhile?>

		</ul>

		<?php if(!$NUM):?>

		<div class="d-flex align-items-center justify-content-center" style="height: 40vh">
			<div class="text-muted">자료가 없습니다.</div>
		</div>

		<?php else:?>
		<nav aria-label="Page navigation" class="mt-4">
			<?php if ($NUM > $recnum): ?>
			<ul class="pagination justify-content-center">
				<?php echo getPageLink(10,$p,$TPG,$_N)?>
			</ul>
			<?php endif; ?>
		</nav>
		<?php endif?>

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->
