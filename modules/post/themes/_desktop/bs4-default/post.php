<?php
$c_recnum = $d['post']['rownum']; // 한 열에 출력할 카드 갯수
$totalCardDeck=ceil($NUM/$c_recnum); // card-deck 갯수 ($NUM 은 해당 데이타의 총 card 갯수 getDbRows 이용)
$total_card_num = $totalCardDeck*$c_recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

switch ($sort) {
	case 'gid'       : $sort_txt='생성순';break;
	case 'd_modify'  : $sort_txt='최신순';break;
	case 'hit'       : $sort_txt='조회순';break;
	case 'likes'     : $sort_txt='좋아요순';break;
	case 'dislikes'  : $sort_txt='싫어요순';break;
	case 'comment'   : $sort_txt='댓글순';break;
}
?>

<section>

	<div class="d-flex justify-content-between align-items-center mt-4">
		<h3 class="mb-0">
			전체 포스트
		</h3>
		<div class="">
		</div>
	</div>

	<div class="d-flex align-items-center border-top border-dark pt-4 pb-3" role="filter">
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
			<?php endif; ?>

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
					<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='dislikes'?' active':'' ?>" type="button" data-value="dislikes">
						싫어요순
					</button>
					<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='comment'?' active':'' ?>" type="button" data-value="comment">
						댓글순
					</button>
				</div>
			</div>

			<div class="input-group ml-2">
			  <input type="text" name="keyword" class="form-control" placeholder="제목,리뷰,태그 검색" value="<?php echo $_keyword?>">
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

		<div class="card-deck" data-role="post-list" data-plugin="markjs">

			<?php $i=0;foreach($RCD as $R):$i++?>

			<div class="card mb-3">
				<?php if ($R['featured_img']): ?>
				<a href="<?php echo getPostLink($R,0) ?>" class="position-relative">
					<img src="<?php echo checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'400x225'):getPreviewResize('/files/noimage.png','300x168') ?>" class="img-fluid" alt="">
					<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
				</a>
				<?php endif; ?>
				<div class="card-body p-3">
					<h5 class="card-title h6 mb-1 line-clamp-2">
						<a class="muted-link" href="<?php echo getPostLink($R,0) ?>">
							<?php echo checkPostPerm($R)?stripslashes($R['subject']):'[비공개 포스트]'?>
						</a>
					</h5>
					<?php if (checkPostPerm($R)): ?>
					<ul class="list-inline f13 text-muted mb-0">
						<li class="list-inline-item">조회 <?php echo $R['hit']?> </li>
						<li class="list-inline-item">좋아요 <?php echo $R['likes']?> </li>
						<li class="list-inline-item">댓글 <?php echo $R['comment']?> </li>
					</ul>
					<time class="text-muted small" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>"></time>
					<?php if(getNew($R['d_regis'],$d['post']['newtime'])):?><i class="material-icons align-middle">fiber_new</i><?php endif?>
					<span class="badge badge-secondary ml-2"><?php echo checkPostOwner($R) && $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>
					<?php endif; ?>

				</div><!-- /.card-body -->
			</div><!-- /.card -->
			<?php
	      $print_card_num++; // 카드 출력될 때마 1씩 증가
	      $lack_card_num = $total_card_num - $print_card_num;
	     ?>

	    <?php if(!($i%$c_recnum)):?></div><div class="card-deck mt-3" data-role="post-list" data-plugin="markjs"><?php endif?>
	    <?php endforeach?>

	    <?php if($lack_card_num ):?>
	      <?php for($j=0;$j<$lack_card_num;$j++):$i++;?>
	       <div class="card border-0" style="background-color: transparent"></div>
	       <?php if(!($i%$c_recnum)):?></div><div class="card-deck mt-3" data-role="post-list" data-plugin="markjs"><?php endif?>
	      <?php endfor?>
	    <?php endif?>
		</div><!-- /.card-deck -->


	<?php else: ?>

		<div class="p-5 text-center text-muted">
			등록된 포스트가 없습니다.
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
