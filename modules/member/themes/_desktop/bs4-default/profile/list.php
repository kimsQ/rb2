<?php
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 12;
$listque = 'mbruid='.$_MP['uid'].' and site='.$s;
$where = 'name|tag';

if ($sort != 'gid') $orderby= 'desc';

if ($my['uid']) $listque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $listque .= ' and display = 5'; // 전체공개 포스트만 출력

if ($where && $keyword)
{
	if (strstr('[name][nic][id][ip]',$where)) $listque .= " and ".$where."='".$keyword."'";
	else if ($where == 'term') $listque .= " and d_regis like '".$keyword."%'";
	else $listque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['postlist'],$listque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['postlist'],$listque);
$TPG = getTotalPage($NUM,$recnum);

$c_recnum = 3; // 한 열에 출력할 카드 갯수
$totalCardDeck=ceil($NUM/$c_recnum); // card-deck 갯수 ($NUM 은 해당 데이타의 총 card 갯수 getDbRows 이용)
$total_card_num = $totalCardDeck*$c_recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

switch ($sort) {
	case 'd_regis'     : $sort_txt='생성순';break;
	case 'd_last'   : $sort_txt='최신순';break;
	default        : $sort_txt='기본';break;
}
?>

<div class="page-wrapper row">
	<div class="col-3 page-nav">

		<?php include $g['dir_module_skin'].'_vcard.php';?>
	</div>

	<div class="col-9 page-main">
		<?php include $g['dir_module_skin'].'_nav.php';?>

		<section>

			<header class="d-flex justify-content-between align-items-end my-3">
				<div>
					<?php echo number_format($NUM)?>개 <small class="text-muted">(<?php echo $p?>/<?php echo $TPG?>페이지)</small>
				</div>

				<form name="listsearchf" action="<?php echo $g['page_reset'] ?>" method="get" class="form-inline">

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

						<div class="dropdown-menu shadow-sm" style="min-width: 85px;">
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='gid'?' active':'' ?>" type="button" data-value="gid">
								기본
							</button>
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='d_regis'?' active':'' ?>" type="button" data-value="d_regis">
								생성순
							</button>
							<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $sort=='d_last'?' active':'' ?>" type="button" data-value="d_last">
								최신순
							</button>
						</div>
					</div>

					<input type="text" name="keyword" size="30" value="<?php echo $_keyword?>" class="form-control form-control-sm ml-2" placeholder="제목 또는 태그 검색">
					<button class="btn btn-white btn-sm ml-1" type="submit">검색</button>

					<?php if ($keyword): ?>
					<a class="btn btn-light btn-sm ml-1" href="<?php echo $g['page_reset'] ?>">리셋</a>
					<?php endif; ?>

					<?php if ($_IS_PROFILEOWN): ?>
					<a href="<?php echo RW('mod=dashboard&page=list')?>" class="btn btn-light btn-sm ml-2 text-danger">관리</a>
					<?php endif; ?>

				</form>

			</header>

			<div class="card-deck" data-plugin="markjs">

				<?php $i=0;while($R=db_fetch_array($RCD)):$i++?>
				<div class="card border-0">
					<a href="<?php echo getListLink($R,1) ?>" class="position-relative">
						<img class="img-fluid" src="<?php echo getPreviewResize(getListImageSrc($R['uid']),'320x180') ?>" alt="">
						<span class="list_mask">
							<span class="txt"><?php echo $R['num']?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
						</span>
					</a>
					<div class="card-body px-0 pt-2 pb-4">
			      <h5 class="card-title h6 mb-1">
							<a class="text-decoration-none text-reset" href="<?php echo getListLink($R,1)?>">
								<?php echo $R['name']?>
							</a>
						</h5>
			      <p class="card-text text-muted f13">
							<span class="text-muted">업데이트: <time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_last'],'c')?>"></time></span>
							<?php if(getNew($R['d_last'],12)):?><small class="text-danger">new</small><?php endif?>

							<?php if ($_IS_PROFILEOWN): ?>
							<span class="badge badge-secondary ml-2 align-top"><?php echo $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>
							<?php endif; ?>
						</p>
			    </div>
				</div><!-- /.card -->

				<?php
					$print_card_num++; // 카드 출력될 때마 1씩 증가
					$lack_card_num = $total_card_num - $print_card_num;
				 ?>

				<?php if(!($i%$c_recnum)):?></div><div class="card-deck"><?php endif?>
				<?php endwhile?>

				<?php if($lack_card_num ):?>
				<?php for($j=0;$j<$lack_card_num;$j++):?>
				 <div class="card border-0"></div>
				<?php endfor?>
			  <?php endif?>
			</div>

			<?php if(!$NUM):?>
			<div class="d-flex align-items-center justify-content-center" style="height: 40vh">
				<div class="text-muted">리스트가 없습니다.</div>
			</div>
			<?php endif?>

			<footer class="d-flex justify-content-center align-items-center my-4">

				<?php if ($NUM > $recnum): ?>
		    <ul class="pagination mb-0">
					<?php echo getPageLink(10,$p,$TPG,$_N)?>
		    </ul>
				<?php endif; ?>

		  </footer>

		</section>

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->

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
