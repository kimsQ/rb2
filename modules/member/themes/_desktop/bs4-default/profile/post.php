<?php
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;
$postque = 'mbruid='.$_MP['uid'].' and site='.$s;

if ($my['uid']) $postque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $postque .= ' and display = 5'; // 전체공개 포스트만 출력

if ($sort == 'gid' && !$keyword) {

	$TCD = getDbArray($table['postmember'],$postque,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
	$NUM = getDbRows($table['postmember'],$postque);

} else {

	if ($where && $keyword) {
		if (strstr('[name][nic][id][ip]',$where)) $postque .= " and ".$where."='".$keyword."'";
		else if ($where == 'term') $postque .= " and d_regis like '".$keyword."%'";
		else $postque .= getSearchSql($where,$keyword,$ikeyword,'or');
	}

	$orderby = 'desc';
	$NUM = getDbRows($table['postdata'],$postque);
	$TCD = getDbArray($table['postdata'],$postque,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
}

$TPG = getTotalPage($NUM,$recnum);

switch ($sort) {
	case 'gid' : $sort_txt='생성순';break;
	case 'hit'     : $sort_txt='조회순';break;
	case 'likes'   : $sort_txt='추천순';break;
	case 'comment' : $sort_txt='댓글순';break;
	default        : $sort_txt='최신순';break;
}
?>

<div class="page-wrapper row">
	<div class="col-3 page-nav">

		<?php include $g['dir_module_skin'].'_vcard.php';?>
	</div>

	<div class="col-9 page-main">

		<?php include $g['dir_module_skin'].'_nav.php';?>

		<section>

			<header class="d-flex justify-content-between align-items-center my-3">
				<div>
					<?php echo number_format($NUM)?>개 <small class="text-muted">(<?php echo $p?>/<?php echo $TPG?>페이지)</small>
				</div>

				<form name="postsearchf" method="get" action="<?php echo $g['page_reset'] ?>" class="form-inline">

					<?php if ($_HS['rewrite']): ?>
					<input type="hidden" name="sort" value="<?php echo $sort?>">
					<?php else: ?>
					<input type="hidden" name="r" value="<?php echo $r?>">
					<?php if($_mod):?>
					<input type="hidden" name="mod" value="<?php echo $_mod?>">
					<?php else:?>
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="front" value="<?php echo $front?>">
					<?php endif?>
					<input type="hidden" name="page" value="<?php echo $page?>">
					<input type="hidden" name="sort" value="<?php echo $sort?>">
					<input type="hidden" name="orderby" value="<?php echo $orderby?>">
					<input type="hidden" name="recnum" value="<?php echo $recnum?>">
					<input type="hidden" name="type" value="<?php echo $type?>" />
					<input type="hidden" name="mbrid" value="<?php echo $_MP['id']?>">
					<?php endif; ?>

					<div class="dropdown" data-role="sort">
						<a class="btn btn-white btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							정열 : <?php echo $sort_txt ?>
						</a>
						<div class="dropdown-menu shadow-sm" style="min-width: 100px;">
							<button class="dropdown-item<?php echo $sort=='gid'?' active':'' ?>" type="button" data-value="gid">
								생성순
							</button>
							<button class="dropdown-item<?php echo $sort=='d_modify'?' active':'' ?>" type="button" data-value="d_modify">
								최신순
							</button>
							<button class="dropdown-item<?php echo $sort=='hit'?' active':'' ?>" type="button" data-value="hit">
								조회순
							</button>
							<button class="dropdown-item<?php echo $sort=='likes'?' active':'' ?>" type="button" data-value="likes">
								추천순
							</button>
							<button class="dropdown-item<?php echo $sort=='comment'?' active':'' ?>" type="button" data-value="comment">
								댓글순
							</button>
						</div>
					</div>

					<select name="where" class="form-control custom-select custom-select-sm ml-1">
						<option value="subject|tag"<?php if($where=='subject|tag'):?> selected="selected"<?php endif?>>제목+태그</option>
						<option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>본문</option>
					</select>

					<input type="text" name="keyword" size="30" value="<?php echo $_keyword?>" class="form-control form-control-sm ml-1">
					<button class="btn btn-white btn-sm ml-1" type="submit">검색</button>

					<?php if ($keyword): ?>
					<a class="btn btn-light btn-sm ml-1" href="<?php echo $g['page_reset']?>">리셋</a>
					<?php endif; ?>

					<?php if ($_IS_PROFILEOWN): ?>
					<a href="<?php echo RW('mod=dashboard&page='.$page)?>" class="btn btn-white text-danger btn-sm ml-2">관리</a>
					<?php endif; ?>

				</form><!-- /.form-inline -->

			</header>

			<ul class="list-unstyled" data-plugin="markjs">

				<?php if (!empty($RCD)): ?>
				<?php foreach($RCD as $R):?>
			  <li class="media mt-4">

					<a href="<?php echo getPostLink($R,1) ?>" class="position-relative mr-3">
						<img class="border" src="<?php echo getPreviewResize(getUpImageSrc($R),'180x100') ?>" alt="">
						<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo getUpImageTime($R) ?></time>
					</a>

			    <div class="media-body">
			      <h5 class="my-1 font-weight-light line-clamp-2">
							<a href="<?php echo getPostLink($R,1) ?>" class="text-reset text-decoration-none" ><?php echo stripslashes($R['subject'])?></a>
						</h5>
						<div class="mb-1">
							<ul class="list-inline d-inline-block f13 text-muted">
								<li class="list-inline-item">조회 <?php echo $R['hit']?> </li>
								<li class="list-inline-item">추천 <?php echo $R['likes']?> </li>
								<li class="list-inline-item">댓글 <?php echo $R['comment']?> </li>
								<li class="list-inline-item">
									<time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
									<?php if(getNew($R['d_regis'],12)):?><small class="text-danger">new</small><?php endif?>
								</li>
							</ul>

							<?php if ($R['category']): ?>
							<span class="ml-2 f13 text-muted">
								<i class="fa fa-folder-o mr-1" aria-hidden="true"></i> <?php echo getAllPostCat('post',$R['category']) ?>
							</span>
							<?php endif; ?>

							<div class="">
								<?php if ($R['tag']): ?>
								<span class="f13 text-muted mr-1">
									<!-- 태그 -->
									<?php $_tags=explode(',',$R['tag'])?>
									<?php $_tagn=count($_tags)?>
									<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
									<?php $_tagk=trim($_tags[$i])?>
									<a class="badge badge-light" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>"><?php echo $_tagk?></a>
									<?php endfor?>
								</span>
								<?php endif; ?>

								<span class="badge badge-secondary"><?php echo checkPostOwner($R) && $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>

							</div>

						</div>
			    </div>
			  </li>
				<?php endforeach?>
				<?php endif?>

				<?php if(!$NUM):?>
				<li>
					<div class="d-flex align-items-center justify-content-center" style="height: 40vh">
						<div class="text-muted">포스트가 없습니다.</div>
					</div>
				</li>
				<?php endif?>

			</ul>

			<footer class="d-flex justify-content-between mt-5">
				<div class=""></div>

				<?php if ($NUM > $recnum): ?>
				<ul class="pagination mb-0">
					<?php echo getPageLink(10,$p,$TPG,$_N)?>
				</ul>
				<?php endif; ?>

				<div class="">
				</div>
			</footer>

		</section>

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->

<script>

$( document ).ready(function() {

	// 툴바
	$('[name="postsearchf"] .dropdown-item').click(function(){
		var form = $('[name="postsearchf"]');
		var value = $(this).attr('data-value');
		var role = $(this).closest('.dropdown').attr('data-role');
		form.find('[name="'+role+'"]').val(value)
		form.submit();
	});

	// marks.js
	$('[data-plugin="markjs"]').mark("<?php echo $keyword ?>");

});


</script>
