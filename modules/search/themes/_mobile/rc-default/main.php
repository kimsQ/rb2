<!-- markjs js : https://github.com/julmot/mark.js -->
<?php getImport('markjs','jquery.mark.min','8.11.1','js')?>

<header class="bar bar-nav bar-dark bg-primary pl-0 pr-1">
	<form name="RbSearchForm" action="<?php echo $g['s']?>/" class="input-group" role="form" id="search-form" style="top: 0;">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="where" value="<?php echo $where?>">
		<input type="hidden" name="swhere" value="all">
		<input type="hidden" name="term" value="<?php echo $term?>">
		<input type="hidden" name="orderby" value="<?php echo $orderby?>">
		<span class="input-group-btn" data-role="return-result">
			<a class="icon icon-left-nav pull-left px-2" role="button" href="<?php  echo RW(0) ?>"></a>
    </span>
	  <input type="search" class="form-control border-0" placeholder="검색어를 입력하세요." value="<?php echo $_keyword?>" id="search-input-page" name="keyword"  autocomplete="off">
		<span class="input-group-btn hidden" data-role="reset-keyword">
      <button class="btn btn-secondary px-3" type="button" data-act="keyword-reset" tabindex="-1">
        <i class="fa fa-times-circle fa-lg" aria-hidden="true"></i>
      </button>
    </span>
	</form>
</header>

<!-- Block button in standard bar fixed below top bar -->
<div class="bar bar-standard bar-header-secondary bar-light bg-white">
	<nav class="nav nav-inline">
		<a id="nav_search_all" class="nav-link<?php if($swhere=='all'):?> active<?php endif?>" href="<?php echo $g['url_where'] ?>all" data-control="push" data-transition="fade" data-act="moreResult">전체</a>
		<a id="nav_site_page" class="nav-link<?php if($swhere=='site_page'):?> active<?php endif?>" href="<?php echo $g['url_where'] ?>site_page" data-control="push" data-transition="fade" data-act="moreResult">페이지</a>
		<a id="nav_bbs_post" class="nav-link<?php if($swhere=='bbs_post'):?> active<?php endif?>" href="<?php echo $g['url_where'] ?>bbs_post" data-control="push" data-transition="fade" data-act="moreResult">게시물</a>
		<a id="nav_mediaset_photo" class="nav-link<?php if($swhere=='mediaset_photo'):?> active<?php endif?>" href="<?php echo $g['url_where'] ?>mediaset_photo" data-control="push" data-transition="fade" data-act="moreResult">사진</a>
		<a id="nav_mediaset_youtube" class="nav-link<?php if($swhere=='mediaset_youtube'):?> active<?php endif?>" href="<?php echo $g['url_where'] ?>mediaset_youtube" data-control="push" data-transition="fade" data-act="moreResult">동영상</a>
		<a id="nav_mediaset_file" class="nav-link<?php if($swhere=='mediaset_file'):?> active<?php endif?>" href="<?php echo $g['url_where'] ?>mediaset_file" data-control="push" data-transition="fade" data-act="moreResult">파일</a>
	</nav>
</div>
<div class="bar bar-standard bar-footer bar-light bg-faded hidden" id="search-footer">
  <button class="btn btn-secondary btn-block" id="search-form-submit">검색</button>
</div>

<div class="content bg-faded" data-role="panal-result">
	<main class="rb-main" data-plugin="markjs">

		<?php if($keyword && $swhere == 'all'):?>
		<div id="rb-sortbar" class="card p-a-1 bg-white">
			총 <span id="rb_sresult_num_all" class="badge badge-primary badge-outline">0</span> 건이 검색 되었습니다.
		</div>

		<div id="search_no_result" class="d-none content-padded">
			<div class="alert alert-info text-xs-center"><strong>&lsquo;<span><?php echo $keyword;?></span>&rsquo;에 대한 검색결과가 없습니다.</strong></div>
			<ul class="list-unstyled text-muted">
				<li>검색어의 철자를 정확하게 입력했는지 확인해 보세요.</li>
				<li>연관된 다른 검색어나 비슷한 의미의 일반적인 단어를 입력하여 찾아 보세요.</li>
			</ul>
			<p>
				<a href="<?php  echo RW(0) ?>" class="btn btn-secondary btn-block">홈으로</a>
			</p>
		</div>

		<?php endif?>


		<?php $_ResultArray['num']=array()?>
		<?php if($keyword):?>
		<?php foreach($d['search_order'] as $_key => $_val):if(!strstr($_val[1],'['.$r.']'))continue?>
			<?php $_iscallpage=($swhere == 'all' || $swhere == $_key)?>
			<?php if($_iscallpage):?>
				<?php if(is_file($_val[2].'.css')) echo '<link href="'.$_val[2].'.css" rel="stylesheet">'?>
				<section id="rb_search_panel_<?php echo $_key?>" class="widget mb-2">
					<header>
						<div class="content-padded">
							<?php echo $_val[0]?>
							<small class="ml-2"><span id="rb_sresult_num_tt_<?php echo $_key?>" class="text-danger">0</span> 건</small>
						</div>

					</header>
					<?php endif?>

					<!-- 검색결과 -->
					<div class="">
					<?php include $_val[2].'.php' ?>
					</div>
					<!-- @검색결과 -->
					<?php if($_iscallpage): ?>
						<?php if($swhere==$_key): ?>
						<footer>
							<div class="p-x-0">
								<?php echo getPageLink_RC(3,$p,getTotalPage($_ResultArray['num'][$_key],$d['search']['num2']),'1')?>
							</div>
						</footer>
						<?php else:?>
							<?php if($_ResultArray['num'][$_key] > $d['search']['num1']):?>
							<footer class="p-2 text-xs-right">
								<a href="<?php echo $g['url_where'].$_key ?>" class="btn btn-link text-muted" data-control="push" data-transition="fade" data-act="moreResult">
									<?php echo $_val[0]?> 더보기 <i class="fa fa-arrow-circle-o-right fa-lg" aria-hidden="true"></i>
								</a>
							</footer>
							<?php endif ?>
						<?php endif?>
				</section>

			<?php endif?>

		<?php endforeach?>

		<?php else:?>
		<div id="rb-searchresult-none" class="content-padded">
			<p>검색어를 입력해 주세요.</p>
		</div>
		<?php endif?>
	</main>
</div><!-- /.content -->

<script>

// 통합검색 입력창
var doSearchInput = function(){

	$('#search-input-page').focus(function(){
		var keyword = $(this).val()
		var modal = $('#modal-search')
		$('.loader-overlay').remove()
		modal.modal('show')
		setTimeout(function(){
			$('#search-input').val(keyword).focus()
			modal.find('[data-role="keyword-reset"]').removeClass('hidden')
		}, 310);
	});

};

var doSearchResult  = function(){

	function searchSortChange(obj)
	{
		var f = document.RbSearchForm;
		f.orderby.value = obj.value;
		f.submit();
	}
	function searchTermChange(obj)
	{
		var f = document.RbSearchForm;
		f.term.value = obj.value;
		f.submit();
	}
	function searchWhereChange(obj)
	{
		var f = document.RbSearchForm;
		f.where.value = obj.value;
		f.submit();
	}

	// marks.js
	$('[data-plugin="markjs"]').mark("<?php echo $keyword ?>");

	<?php $total = 0?>

	<?php foreach($_ResultArray['num'] as $_key => $_val):$total+=$_val?>

	  if ($('#rb_sresult_num_tt_<?php echo $_key?>')) {
			$('#rb_sresult_num_tt_<?php echo $_key?>').text('<?php echo $_val?>')
		}

		<?php if(!$_val):?>
		$('#rb_search_panel_<?php echo $_key?>').addClass('d-none')
		$('#nav_<?php echo $_key?>').addClass('d-none')
		<?php endif?>

	<?php endforeach?>

	var search_result_total = <?php echo $swhere=='all'?$total:$_ResultArray['num'][$swhere]?>;
	if(search_result_total==0){
		$("#search_no_result").removeClass("d-none");
		$('.bar-header-secondary').remove()
	}
	$('#rb_sresult_num_all').text(search_result_total)

	<?php if(!$_ResultArray['spage']):?>
	if(getId('rb-sortbar')) getId('rb-sortbar').className = 'd-none';
	<?php endif?>

};

$(function () {

	// 검색관련 스크립트 실행
	doSearchInput();
	doSearchResult();

})

</script>
