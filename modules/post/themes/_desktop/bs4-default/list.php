<?php
$c_recnum = $d['post']['rownum']; // 한 열에 출력할 카드 갯수
$totalCardDeck=ceil($NUM/$c_recnum); // card-deck 갯수 ($NUM 은 해당 데이타의 총 card 갯수 getDbRows 이용)
$total_card_num = $totalCardDeck*$c_recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

switch ($sort) {
	case 'gid'     : $sort_txt='생성순';break;
	case 'd_last'   : $sort_txt='최신순';break;
}
?>

<section>

	<div class="d-flex justify-content-between align-items-center mt-4">
		<h3 class="mb-0">
			전체 리스트
		</h3>
		<div class="">
		</div>
	</div>

	<div class="d-flex align-items-center border-top border-dark pt-4 pb-3" role="filter">
		<span class="f18">전체 <span class="text-primary"><?php echo number_format($NUM)?></span> 개</span>

		<form name="listsearchf" action="<?php echo $g['page_reset'] ?>" method="get" class="form-inline ml-auto">

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

			<label class="mt-1 mr-2 sr-only">정열</label>
			<div class="dropdown" data-role="sort">
				<a class="btn btn-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					정열 : <?php echo $sort_txt ?>
				</a>

				<div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuLink" style="min-width: 116px;">
					<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='gid'?' active':'' ?>" type="button" data-value="gid">
						생성순
					</button>
					<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='d_last'?' active':'' ?>" type="button" data-value="d_last">
						최신순
					</button>
				</div>
			</div>

			<div class="input-group ml-2">
			  <input type="text" name="keyword" class="form-control" placeholder="리스트명 검색" value="<?php echo $_keyword?>">
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

	<div class="card-deck" data-plugin="markjs">

		<?php $i=0;foreach($RCD as $R):$i++?>
		<div class="card mb-3">
			<a href="<?php echo getListLink($R,0) ?>" class="position-relative">
				<img src="<?php echo getPreviewResize(getListImageSrc($R['uid']),'320x180') ?>" class="img-fluid" alt="">
				<span class="list_mask">
					<span class="txt"><?php echo $R['num']?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
				</span>
				<img class="list_avatar shadow-sm" src="<?php echo getAvatarSrc($R['mbruid'],'50') ?>" width="50" height="50" alt="">
			</a>

			<div class="card-body pt-5 p-3">
				<h5 class="card-title h6 mb-1">
					<a class="muted-link" href="<?php echo getListLink($R,0) ?>">
						<?php echo $R['name']?>
					</a>
				</h5>
				<span class="small text-muted">업데이트: <time class="text-muted" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_last'],'c')?>"></time></span>
				<?php if(getNew($R['d_last'],$d['post']['newtime'])):?><span class="rb-new ml-1"></span><?php endif?>
			</div><!-- /.card-body -->
		</div><!-- /.card -->

		<?php
      $print_card_num++; // 카드 출력될 때마 1씩 증가
      $lack_card_num = $total_card_num - $print_card_num;
     ?>

    <?php if(!($i%$c_recnum)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
    <?php endforeach?>

    <?php if($lack_card_num ):?>
      <?php for($j=0;$j<$lack_card_num;$j++):$i++;?>
       <div class="card border-0" style="background-color: transparent"></div>
       <?php if(!($i%$c_recnum)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
      <?php endfor?>
    <?php endif?>
	</div><!-- /.card-deck -->


	<?php else: ?>

		<div class="p-5 text-center text-muted">
			등록된 리스트가 없습니다.
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
	$('[name="listsearchf"] .dropdown-item').click(function(){
		var form = $('[name="listsearchf"]');
		var value = $(this).attr('data-value');
		var role = $(this).closest('.dropdown').attr('data-role');
		form.find('[name="'+role+'"]').val(value)
		form.submit();
	});

	// marks.js
	$('[data-plugin="markjs"]').mark("<?php echo $keyword ?>");

});

</script>
