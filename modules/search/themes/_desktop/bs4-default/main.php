<div id="rb-search-body" class="mb-4">

	<header class="header">
		<form name="RbSearchForm" action="<?php echo $_HS['rewrite']? RW('m=search'):$g['s'].'/'?>" class="py-4" role="form" data-role="searchform">

			<?php if (!$_HS['rewrite']): ?>
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<?php endif; ?>

			<input type="hidden" name="where" value="<?php echo $where?>">
			<input type="hidden" name="swhere" value="<?php echo $swhere?>">
			<input type="hidden" name="sort" value="<?php echo $sort?>">
			<input type="hidden" name="orderby" value="<?php echo $orderby?>">

			<div class="<?php echo $d['layout']['header_container'] ?>">
				<div class="row align-items-center">

					<div class="col-8 pr-0">

						<div class="media align-items-center">
							<h1 class="h2 mb-0 mr-4">
								<a class="navbar-brand" href="<?php  echo RW(0) ?>"
									style="background-image:url(<?php echo $d['layout']['header_logo']?$g['url_var_site'].'/'.$d['layout']['header_logo'].$g['wcache']:''?>);background-size:<?php echo $d['layout']['header_logo_size'] ?>%">
									<?php echo !$d['layout']['header_logo']?$d['layout']['header_title'] :'' ?>
								</a>
							</h1>
							<div class="media-body">
								<div class="input-group input-group-lg shadow-sm dropdown">
									<input type="search" name="q" class="form-control bg-white border-0 rounded-0" value="<?php echo $q?>" data-plugin="autocomplete" autocomplete="off" required>
									<div class="input-group-append">
										<button class="btn btn-outline-primary border-0 rounded-0" type="submit"><i class="fa fa-search"></i></button>
									</div>
								</div><!-- /.input-group -->
							</div><!-- /.media-body -->
						</div>
					</div><!-- /.col-8 -->

					<div class="col-4">


					</div><!-- /.col-4 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</form>

		<nav class="navbar navbar-expand-lg navbar-light bg-white border-top border-bottom" data-role="lnb">
			<div class="container">
				<ul class="navbar-nav mr-auto">
	       <li class="nav-item <?php if($swhere=='all'):?> active<?php endif?>">
	         <a class="nav-link" href="<?php echo $g['url_where']?>all">통합검색</a>
	       </li>
				 <?php $_ResultArray['spage']=0;foreach($d['search_order'] as $_key => $_val):if(!strstr($_val[1],'['.$r.']'))continue?>
	       <li class="nav-item<?php if($swhere==$_key):?> active<?php endif?>" id="nav_<?php echo $_key?>" data-num="">
	         <a class="nav-link" href="<?php echo $g['url_where'].$_key?>" id=nav_<?php echo $_key?>>
						 <?php echo $_val[0]?>
					 </a>
	       </li>
				 <?php $_ResultArray['spage']++;endforeach?>
	     </ul>
			 <?php if($q):?>
				<span class="navbar-text f13">
					총 <strong id="rb_sresult_num_all">0</strong> 건이 검색 되었습니다.
				</span>
				<?php endif?>
			 <div class="ml-3">
				 <select class="form-control custom-select custom-select-sm" data-header="정열방식" onchange="searchSortChange(this);">
					 <option value="desc"<?php if($orderby=='desc'):?> selected<?php endif?>>최신순</option>
					 <option value="asc"<?php if($orderby=='asc'):?> selected<?php endif?>>과거순</option>
				 </select>
			 </div>
			</div><!-- /.container -->
		</nav>
	</header>

	<main>
		<div class="<?php echo $d['layout']['home_container'] ?>">

			<div class="row">
				<main class="col-8 border-right py-4" data-plugin="markjs">

					<div data-role="section-list">
						<?php $_ResultArray['num']=array()?>
						<?php if($q):?>
						<?php foreach($d['search_order'] as $_key => $_val):if(!strstr($_val[1],'['.$r.']'))continue?>
						<?php $_iscallpage=($swhere == 'all' || $swhere == $_key)?>
						<?php if($_iscallpage):?>
						<?php if(is_file($_val[2].'.css')) echo '<link href="'.$_val[2].'.css" rel="stylesheet">'?>
						<section id="rb_search_panel_<?php echo $_key?>" class="d-none" data-role="section-item">
							<header class="mb-3">
								<strong><?php echo $_val[0]?></strong>
								<small><span class="text-muted" data-role="sresult_num_tt_<?php echo $_key?>"></span> 건</small>
							</header>
							<?php endif?>

							<!-- 검색결과 -->
							<?php include $_val[2].'.php' ?>
							<!-- @검색결과 -->

							<?php if($_iscallpage):?>
							<?php if($swhere==$_key):?>
							<footer>
								<ul class="pagination  justify-content-center mb-0">
									<script>getPageLink(5,<?php echo $p?>,<?php echo getTotalPage($_ResultArray['num'][$_key],$d['search']['num2'])?>,'');</script>
								</ul>
							</footer>
							<?php else:?>
							<?php if($_ResultArray['num'][$_key] > $d['search']['num1']):?>
							<footer>
								<div class="rb-more-search">
									<a href="<?php echo $g['url_where'].$_key?>">더보기 <i class="fa fa-angle-right"></i></a>
								</div>
							</footer>
							<?php endif?>
							<?php endif?>
						</section>
					<?php endif?>
					<?php endforeach?>
					</div>

					<section id="search_no_result" class="d-none my-5">
						<h5 class="mb-4"><strong>'<?php echo $q ?>'</strong> 에 대한 검색결과가 없습니다.</h5>
						<ul class="list-unstyled text-muted f13">
							<li>ㆍ검색어의 단어 수를 줄이거나, 보다 일반적인 단어로 검색해 보세요.</li>
							<li>ㆍ두 단어 이상의 키워드로 검색 하신 경우, 정확하게 띄어쓰기를 한 후 검색해 보세요.</li>
							<li>ㆍ키워드에 있는 특수문자를 뺀 후에 검색해 보세요.</li>
						</ul>
					</section>

					<?php else:?>

					<section id="rb-searchresult-none">
						<div class="text-center p-5 text-muted">
							검색어를 입력해 주세요.
						</div>
					</section>
					<?php endif?>
					<section id="rb-searchpage-none" class="d-none">
						<h3>검색 페이지가 설정되어 있지 않습니다.</h3>
					</section>
				</main>
				<aside class="col-4 py-4">

					<?php
					$recnum	= 10;
					$sort	= $sort		? $sort		: 'hit';
					$orderby= $orderby	? $orderby	: 'desc';
					$query = 'site='.$s.' and ';
					$_WHERE1= $query.'date >= '.date('Ymd', strtotime('-1 month'));
					$_WHERE2= 'keyword,sum(hit) as hit';
					$RCD	= getDbSelect($table['s_tag'],$_WHERE1.' group by keyword order by '.$sort.' '.$orderby.' limit 0,'.$recnum,$_WHERE2);
					?>

					<section data-role="section-item">
						<header class="d-flex justify-content-between">
							<strong>기간별 주요 키워드 </strong>
							<small class="text-muted"><?php echo date("m/d", strtotime("-1 month")).'~'. date("m/d", strtotime("now"))?></small>
						</header>

						<div class="container mt-2">
							<div class="row">
								<?php $j=0;while($G=db_fetch_array($RCD)):$j++?>

								<div class="col-6 bg-light py-1 mb-1">
									<a class="text-reset d-block f13" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=search&amp;q=<?php echo urlencode($G['keyword'])?>" title="<?php echo $G['keyword']?>">
										<span class="badge badge-light mr-2"><?php echo $j?>.</span>
										<?php echo getStrCut($G['keyword'],6,'..')?>
										<small class="text-muted"><?php echo $G['hit']?>건</small>
									</a>
								</div>


								<?php endwhile?>
								<?php if(!$j):?>
									<div class="nodata">지정된 기간내에 기록된 키워드가 없습니다.</div>
								<?php endif?>
							</div>
						</div>


					</section>


				</aside>
			</div><!-- /.row -->
		</div><!-- /.container -->
	</main>

	<footer class="border-top">

		<div class="pt-5 text-center">
			<form name="RbSearchForm2" action="<?php echo $_HS['rewrite']? RW('m=search'):$g['s'].'/'?>" class="mx-auto" role="form" data-role="searchform" style="width :460px">

				<?php if (!$_HS['rewrite']): ?>
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $m?>">
				<?php endif; ?>

				<input type="hidden" name="where" value="<?php echo $where?>">
				<input type="hidden" name="swhere" value="<?php echo $swhere?>">
				<input type="hidden" name="sort" value="<?php echo $sort?>">
				<input type="hidden" name="orderby" value="<?php echo $orderby?>">

				<div class="input-group input-group-lg shadow-sm">
					<input type="text" name="q" class="form-control bg-white border-0 rounded-0" value="<?php echo $q?>" autocomplete="off" required>
					<div class="input-group-append">
						<button class="btn btn-outline-primary border-0 rounded-0" type="submit"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</form>

			<div class="footer_comm mt-4 mb-5">
				<a href="<?php echo RW('mod=policy')?>" class="link_info">개인정보취급방침</a>
				<span class="txt_bar">|</span>
				<a href="<?php echo RW('mod=privacy')?>" class="link_info">이용약관</a>
				<span class="txt_bar">|</span>
				<span class="link_info">© <?php echo $d['layout']['company_name'] ?> <?php echo $date['year']?></span>
			</div>

		</div>

	</footer>

</div>

<!-- markjs js : https://github.com/julmot/mark.js -->
<?php getImport('markjs','jquery.mark.min','8.11.1','js')?>

<!-- jQuery-Autocomplete : https://github.com/devbridge/jQuery-Autocomplete -->
<?php getImport('jQuery-Autocomplete','jquery.autocomplete.min','1.3.0','js') ?>


<script>

document.title = '<?php echo $q?$q.'-':''?> 검색 | <?php echo $g['browtitle']?>';

function searchSortChange(obj)
{
	var f = document.RbSearchForm;
	f.orderby.value = obj.value;
	f.submit();
}

// Textarea 또는 Input의 끝으로 커서 이동
jQuery.fn.putCursorAtEnd = function() {
  return this.each(function() {
    var $el = $(this),
        el = this;
    if (!$el.is(":focus")) {
     $el.focus();
    }
    if (el.setSelectionRange) {
      var len = $el.val().length * 2;
      setTimeout(function() {
        el.setSelectionRange(len, len);
      }, 1);
    } else {
      $el.val($el.val());
    }
    this.scrollTop = 999999;
  });
};


<?php $total = 0?>

$(function () {

	<?php foreach($_ResultArray['num'] as $_key => $_val):$total+=$_val?>

		if ($('[data-role="sresult_num_tt_<?php echo $_key?>"]')) {
			$('[data-role="sresult_num_tt_<?php echo $_key?>"]').text('<?php echo $_val?>')
		}

		<?php if($_val):?>
		$('#rb_search_panel_<?php echo $_key?>').removeClass('d-none').addClass('active')
		$('#nav_<?php echo $_key?>').attr('data-num',<?php echo $_val?>);
		<?php else: ?>
		$('#rb_search_panel_<?php echo $_key?>').remove()
		<?php endif?>

	<?php endforeach?>

	var search_result_total = <?php echo $swhere=='all'?$total:$_ResultArray['num'][$swhere]?>;
	if(search_result_total==0){
		$("#search_no_result").removeClass("d-none");
	}
	$('#rb_sresult_num_all').text(search_result_total)
	$('[name="RbSearchForm"]').find('[name="q"]').focus().putCursorAtEnd()

	<?php if(!$_ResultArray['spage']):?>
	if(getId('rb-sortbar')) getId('rb-sortbar').className = 'd-none';
	<?php endif?>

	// marks.js
	$('[data-plugin="markjs"]').mark("<?php echo $q ?>");

	$('[data-plugin="autocomplete"]').autocomplete({
		width : 467,
		lookup: function (query, done) {

			 $.getJSON(rooturl+"/?m=tag&a=searchtag", {q: query}, function(res){
					 var sg_tag = [];
					 var data_arr = res.taglist.split(',');//console.log(data.usernames);
					 $.each(data_arr,function(key,tag){
						 var tagData = tag.split('|');
						 var keyword = tagData[0];
						 var hit = tagData[1];
						 sg_tag.push({"value":keyword,"data":hit});
					 });
					 var result = {
						 suggestions: sg_tag
					 };
						done(result);
			 });
	 },
			onSelect: function (suggestion) {
				if ($('[data-plugin="autocomplete"]').val().length >= 1) {
					$('[name="RbSearchForm"]').submit();
				}
			}
	});


})

</script>
