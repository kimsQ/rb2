<section>

	<h1 class="h4 my-5 text-center">'<?php echo $keyword ?>' 	<small class="text-muted">포스트 검색결과 <?php echo $NUM ?>개</small></h1>

	<hr>
	<?php if ($NUM): ?>
	<ul class="list-unstyled" data-plugin="markjs">
	<?php foreach($RCD as $R):?>
	<?php $R['mobile']=isMobileConnect($R['agent'])?>

	<li class="media my-4">
		<?php if ($R['featured_img']): ?>

			<a href="<?php echo getPostLink($R,0) ?>" class="position-relative mr-3">
				<img src="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'180x100'):getPreviewResize('/files/noimage.png','180x100') ?>" alt="">
				<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
			</a>
		<?php endif; ?>

		<div class="media-body">
			<h5 class="mt-0 mb-1">
				<a href="<?php echo getPostLink($R,0) ?>">
					<?php echo checkPostPerm($R)?stripslashes($R['subject']):'[비공개 포스트]'?>
				</a>
			</h5>
			<?php if (checkPostPerm($R)): ?>
			<div class="text-muted mb-1"><?php echo $R['review']?></div>
			<div class="mb-1">
				<ul class="list-inline d-inline-block ml-2 f13 text-muted">
					<li class="list-inline-item">조회 <?php echo $R['hit']?> </li>
					<li class="list-inline-item">좋아요 <?php echo $R['likes']?> </li>
					<li class="list-inline-item">댓글 <?php echo $R['comment']?> </li>
					<li class="list-inline-item"><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></li>
				</ul>
				<span class="ml-2 f13 text-muted">
					<i class="fa fa-folder-o mr-1" aria-hidden="true"></i> <?php echo getAllPostCat($m,$R['category']) ?>
				</span>
				<span class="ml-2 f13 text-muted">
					<!-- 태그 -->
					<?php $_tags=explode(',',$R['tag'])?>
					<?php $_tagn=count($_tags)?>
					<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
					<?php $_tagk=trim($_tags[$i])?>
					<a class="badge badge-light" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>">
						# <?php echo $_tagk?>
					</a>
					<?php endfor?>
				</span>
				<span class="badge badge-secondary ml-2"><?php echo checkPostOwner($R) && $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>
			</div>
			<?php else: ?>
			<div class="text-muted py-3">
				이 포스트에 대한 액세스 권한이 없습니다.
			</div>
			<?php endif; ?>
		</div>

	</li>
	<?php endforeach?>
	</ul>

	<?php else: ?>

		<div class="p-5 text-center text-muted">
			자료가 없습니다.
		</div>

	<?php endif; ?>

	<footer class="d-flex justify-content-between mt-5">
		<div class=""></div>

		<?php if ($NUM > $recnum): ?>
		<ul class="pagination mb-0">
			<?php echo getPageLink(10,$p,$TPG,'')?>
		</ul>
		<?php endif; ?>

		<div class="">
		</div>
	</footer>

</section>

<!-- markjs js : https://github.com/julmot/mark.js -->
<?php getImport('markjs','jquery.mark.min','8.11.1','js')?>

<script>

$( document ).ready(function() {

	// marks.js
	$('[data-plugin="markjs"]').mark("<?php echo $keyword ?>");

});

</script>
