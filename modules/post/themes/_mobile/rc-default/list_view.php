<header class="bar bar-nav bar-light bg-white">
	<a class="icon material-icons pull-left px-3" role="button" data-href="<?php echo RW(0)?>" data-text="홈으로 이동">house</a>
	<a class="icon material-icons pull-right pl-2 pr-3 mirror" role="button" data-toggle="popup" data-target="#popup-link-share" data-url>reply</a>
	<a class="title" data-href="<?php echo RW(0)?>" data-text="새로고침">
    <?php echo $d['layout']['header_file']?'<img src="'.$g['url_layout'].'/_var/'.$d['layout']['header_file'].'">':stripslashes($d['layout']['header_title'])?>
  </a>
</header>

<section class="content">

	<div data-role="box"></div>

</section>

<script src="<?php echo $g['url_module_skin'] ?>/_js/list_view.js<?php echo $g['wcache']?>" ></script>

<script>

	var settings={
		listid : '<?php echo $listid?>',
		wrapper : $('[data-role="box"]'),
		markup    : 'listview-box',  // 테마 > _html > list-tableview.html
		totalNUM  : '<?php echo $NUM?>',
    recnum    : <?php echo $recnum ?>,
		totalPage : '<?php echo getTotalPage($NUM,$recnum)?>',
		sort      : '<?php echo $sort ?>',
		orderby   : '<?php echo $orderby ?>',
		none : '<div class="p-5 text-xs-center text-muted">등록된 포스트가 없습니다.</div>'
	}

	getPostListview(settings);

	//목록 다시 불러오기
	$('[data-toggle="reload"]').click(function(){
		$('[data-role="list"]').empty();
		$('.infinitescroll-end').remove();

		console.log(settings.recnum)
	  getPostListview(settings);
	});

</script>
