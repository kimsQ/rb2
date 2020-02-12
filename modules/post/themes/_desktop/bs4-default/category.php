<?php
switch ($sort) {
	case 'gid'     : $sort_txt='생성순';break;
	case 'd_modify'   : $sort_txt='최신순';break;
	case 'hit'   : $sort_txt='조회순';break;
	case 'likes'   : $sort_txt='좋아요순';break;
	case 'comment'   : $sort_txt='댓글순';break;
}
?>

<section>

	<div class="row">
		<div class="col-3">

			<div class="card">
				<div class="card-header">
					<a href="<?php echo RW('m=post&mod=category') ?>" class="muted-link" title="전체보기">카테고리</a>
				</div>
				<div class="card-body">
					<?php $_treeOptions=array('site'=>$s,'table'=>$table[$m.'category'],'dispNum'=>$my['uid']?true:false,'dispHidden'=>true,'dispCheckbox'=>false,'allOpen'=>true)?>
					<?php $_treeOptions['link'] = RW('m=post&cat=')?>
					<?php echo getTreeCategory($_treeOptions,$code,0,0,'')?>
				</div>
			</div><!-- /.card -->

		</div>
		<div class="col-9">

			<header class="d-flex justify-content-between align-items-center border-bottom border-dark mt-2 pb-2">
				<h3 class="mb-0">
					<?php echo $CAT['name']?$CAT['name']:'전체 카테고리' ?>
				</h3>
				<div class="">
				</div>
			</header>

			<div class="d-flex align-items-center py-3" role="filter">
				<span class="f18">전체 <span class="text-primary"><?php echo number_format($NUM)?></span> 개</span>


				<form name="postsearchf" action="<?php echo $g['page_reset'] ?>" method="get" class="form-inline ml-auto">

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
					<input type="hidden" name="code" value="<?php echo $code?>">

					<label class="mt-1 mr-2 sr-only">정열</label>
					<div class="dropdown" data-role="sort">
						<a class="btn btn-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							정열 : <?php echo $sort_txt ?>
						</a>

						<div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuLink" style="min-width: 116px;">
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='gid'?' active':'' ?>" type="button" data-value="gid">
								생성순
							</button>
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='d_modify'?' active':'' ?>" type="button" data-value="d_modify">
								최신순
							</button>
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='hit'?' active':'' ?>" type="button" data-value="hit">
								조회순
							</button>
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='likes'?' active':'' ?>" type="button" data-value="likes">
								좋아요순
							</button>
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='comment'?' active':'' ?>" type="button" data-value="comment">
								댓글순
							</button>
						</div>
					</div>

					<div class="input-group ml-2">
					  <input type="text" name="keyword" class="form-control" placeholder="제목,요약,태그 검색" value="<?php echo $_keyword?>">
					  <div class="input-group-append">
					    <button class="btn btn-white text-muted border-left-0" type="submit">
								<i class="fa fa-search" aria-hidden="true"></i>
							</button>
							<?php if ($keyword): ?>
							<a class="btn btn-white ml-1" href="<?php echo $g['post_reset'] ?>">리셋</a>
							<?php endif; ?>
					  </div>
					</div>

				</form><!-- /.form-inline -->
			</div><!-- /.d-flex -->

			<?php if ($NUM): ?>
			<ul class="list-unstyled" data-plugin="markjs">
				<?php foreach($RCD as $R):?>
				<li class="media my-4">
					<?php if ($R['featured_img']): ?>
					<a href="<?php echo getPostLink($R,0) ?>" class="position-relative mr-3">
						<img src="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'180x100'):getPreviewResize('/files/noimage.png','180x100') ?>" alt="">
						<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
					</a>
					<?php endif; ?>

					<div class="media-body">
						<h5 class="mt-0 mb-1">
							<a class="text-decoration-none text-reset" href="<?php echo getPostLink($R,0) ?>">
								<?php echo checkPostPerm($R)?stripslashes($R['subject']):'[비공개 포스트]'?>
							</a>
						</h5>
						<?php if (checkPostPerm($R)): ?>
						<div class="mb-1">
							<ul class="list-inline d-inline-block f13 text-muted">
								<li class="list-inline-item">조회 <?php echo $R['hit']?> </li>
								<li class="list-inline-item">좋아요 <?php echo $R['likes']?> </li>
								<li class="list-inline-item">댓글 <?php echo $R['comment']?> </li>
								<li class="list-inline-item">
									<time class="text-muted" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
								</li>
							</ul>

							<?php if ($R['category']): ?>
							<span class="ml-2 f13 text-muted">
								<i class="fa fa-folder-o mr-1" aria-hidden="true"></i> <?php echo getAllPostCat($m,$R['category']) ?>
							</span>

							<?php endif; ?>

							<span class="ml-2 f13 text-muted">
								<!-- 태그 -->
								<?php $_tags=explode(',',$R['tag'])?>
								<?php $_tagn=count($_tags)?>
								<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
								<?php $_tagk=trim($_tags[$i])?>
								<a class="badge badge-light" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>"><?php echo $_tagk?></a>
								<?php endfor?>
							</span>
							<span class="badge badge-secondary ml-2"><?php echo checkPostOwner($R) && $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>
						</div>
					</div>
					<?php else: ?>
						<p class="text-muted py-3">
							이 포스트에 대한 액세스 권한이 없습니다.
						</p>
					<?php endif; ?>

				</li>
			  <?php endforeach?>
			</ul>

			<?php else: ?>
			<div class="d-flex align-items-center justify-content-center" style="height: 50vh">
				<div class="text-muted">
					포스트가 없습니다.
				</div>
			</div>
			<?php endif; ?>

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

		</div>
	</div><!-- /.row -->

</section>

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
