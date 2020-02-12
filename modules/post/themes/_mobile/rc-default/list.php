<header class="bar bar-nav bar-light bg-white px-0">
	<a class="icon material-icons pull-left px-3" role="button" data-href="<?php echo RW(0)?>" data-text="홈으로 이동">house</a>
	<a class="icon material-icons pull-right pl-2 pr-3" role="button" data-toggle="modal" data-target="#modal-post-search">search</a>
	<a class="icon pull-right material-icons px-2" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
	<a class="title" data-href="<?php echo RW(0)?>" data-text="홈으로 이동">
    <?php echo $d['layout']['header_file']?'<img src="'.$g['url_layout'].'/_var/'.$d['layout']['header_file'].'">':stripslashes($d['layout']['header_title'])?>
  </a>
</header>

<section class="content">
	<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list"></ul>
</section>

<script src="<?php echo $g['url_module_skin'] ?>/_js/list.js<?php echo $g['wcache']?>" ></script>

<script>

	var settings={
		wrapper : $('[data-role="list"]'),
		start : '#page-main',
		markup    : 'list-row',  // 테마 > _html > list-tableview.html
		totalNUM  : '<?php echo $NUM?>',
    recnum    : <?php echo $recnum ?>,
		totalPage : '<?php echo getTotalPage($NUM,$recnum)?>',
		sort      : '<?php echo $sort ?>',
		orderby   : '<?php echo $orderby ?>',
		none : '<div class="p-5 text-xs-center text-muted">등록된 리스트가 없습니다.</div>'
	}

	getPostListAll(settings);

	//목록 다시 불러오기
	$('[data-toggle="reload"]').click(function(){
		$('[data-role="list"]').empty();
		$('.infinitescroll-end').remove();

		console.log(settings.recnum)
	  getPostListAll(settings);
	});

</script>
