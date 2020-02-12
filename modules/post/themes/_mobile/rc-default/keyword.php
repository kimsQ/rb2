<header class="bar bar-nav bar-light bg-white px-0">
	<a class="icon material-icons pull-left px-3" role="button" data-href="<?php echo RW(0)?>" data-text="홈으로 이동">house</a>
	<a class="title" data-href="<?php echo RW(0)?>" data-text="홈으로 이동">
    <?php echo $d['layout']['header_file']?'<img src="'.$g['url_layout'].'/_var/'.$d['layout']['header_file'].'">':stripslashes($d['layout']['header_title'])?>
  </a>
</header>

<div class="bar bar-standard bar-header-secondary bar-light bg-white px-0">
	<a class="icon pull-right material-icons px-3" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
	<span class="title">#<?php echo $keyword ?></span>
</div>

<section class="content">
	<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list"></ul>
</section>


<script src="<?php echo $g['url_module_skin'] ?>/_js/keyword.js<?php echo $g['wcache']?>" ></script>

<script>

$( document ).ready(function() {

	getPostKeyword({
		wrapper : $('[data-role="list"]'),
		keyword : '<?php echo $keyword ?>',
		markup    : 'keyword-row',  // 테마 > _html > keyword-row.html
		start : '#page-main',
		totalNUM  : '<?php echo $NUM?>',
    recnum    : <?php echo $recnum ?>,
		totalPage : '<?php echo getTotalPage($NUM,$recnum)?>',
		sort      : '<?php echo $sort ?>',
		orderby   : 'desc',
		none : '<div class="p-5 text-xs-center text-muted">포스트가 없습니다.</div>'

	});

});

</script>
