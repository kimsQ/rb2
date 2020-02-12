<div class="card shadow-sm" id="widget-post-best">
	<div class="card-header d-flex justify-content-between align-items-end">
		<ul class="nav nav-tabs card-header-tabs">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#bset-hit" data-sort="hit">조회순</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#bset-likes" data-sort="likes">좋아요순</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#bset-dislikes" data-sort="dislikes">싫어요순</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#bset-comment" data-sort="comment">댓글순</a>
			</li>
		</ul>
		<small class="text-muted" data-toggle="tooltip" title="<?php echo date('m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-7,substr($date['today'],0,4)))?>~<?php echo getDateFormat($date['today'],'m/d')?>">최근 일주일</small>
	</div>

	<div class="tab-content">
	  <div class="tab-pane show active" id="bset-hit" role="tabpanel">
			<ul class="list-group list-group-flush" role="list"></ul>
			<div role="loader">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
			<div role="none" class="d-none">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<span class="text-muted">포스트가 없습니다.</span>
				</div>
			</div>
		</div>
	  <div class="tab-pane" id="bset-likes" role="tabpanel">
			<ul class="list-group list-group-flush" role="list"></ul>
			<div role="loader">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
			<div role="none" class="d-none">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<span class="text-muted">포스트가 없습니다.</span>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="bset-dislikes" role="tabpanel">
			<ul class="list-group list-group-flush" role="list"></ul>
			<div role="loader">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
			<div role="none" class="d-none">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<span class="text-muted">포스트가 없습니다.</span>
				</div>
			</div>
		</div>
	  <div class="tab-pane" id="bset-comment" role="tabpanel">

			<ul class="list-group list-group-flush" role="list"></ul>
			<div role="loader">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<div class="spinner-border" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
			<div role="none" class="d-none">
				<div class="d-flex justify-content-center align-items-center"  style="height:432px">
					<span class="text-muted">포스트가 없습니다.</span>
				</div>
			</div>
		</div>
	</div>


</div>

<script>

function getWidgetPostbest(target,sort) {

	$(target).find('[role="list"]').html('');
	$(target).find('[role="loader"]').removeClass('d-none');

	$.post(rooturl+'/?r='+raccount+'&m=post&a=get_postBest',{
		dashboard : 'Y',
		sort : sort,
		markup_file : 'dashboard-media',
		d_start : '<?php echo 'site='.$s.' and date >= '.date("Ymd", strtotime("-1 week")); ?>',  //일주일전
		limit : 10
		},function(response,status){
			if(status=='success'){
				var result = $.parseJSON(response);
				var list=result.list;

				if (list) {
					$(target).find('[role="list"]').html(list)
					$(target).find('[role="loader"]').addClass('d-none');
					$(target).find('[data-plugin="timeago"]').timeago();  // 상대시간 플러그인 초기화
				} else {
					$(target).find('[role="loader"]').addClass('d-none');
					$(target).find('[role="none"]').removeClass('d-none');
				}
			} else {
				alert(status);
			}
	});
}

$( document ).ready(function() {
	$('#widget-post-best').find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  var target = $(this).attr('href') // newly activated tab
		var sort = $(this).data('sort')
		getWidgetPostbest(target,sort)
	})

	getWidgetPostbest('#bset-hit','hit');

});

</script>
