<header class="d-flex justify-content-between align-items-center py-2">
	<strong>전체 포스트 추이</strong>
	<div class="mr-2">
		<a href="/dashboard?page=analytics" class="muted-link small d-none">
			더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
		</a>
	</div>
</header>

<div class="card shadow-sm" id="widget-post-chart">
	<div class="card-header d-flex justify-content-between align-items-end">
		<ul class="nav nav-tabs card-header-tabs">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#chart-hit" data-mod="hit">조회수</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#chart-likes" data-mod="likes">좋아요</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#chart-dislikes" data-mod="dislikes">싫어요</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#chart-comment" data-mod="comment">댓글</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#chart-follower" data-mod="follower">구독자</a>
			</li>
		</ul>
		<small class="text-muted" data-toggle="tooltip" title="<?php echo date("m/d", strtotime("-1 week")).'~'. date("m/d", strtotime("now"))  ?>">
			최근 일주일
		</small>
	</div>
	<div class="tab-content card-body">
		<div data-chart="loader">
			<div class="d-flex justify-content-center align-items-center"  style="height:267px">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
		<div class="tab-pane show active" id="chart-hit" role="tabpanel">
			<canvas class="d-none"></canvas>
		</div>
		<div class="tab-pane" id="chart-likes" role="tabpanel">
			<canvas class="d-none"></canvas>
		</div>
		<div class="tab-pane" id="chart-dislikes" role="tabpanel">
			<canvas class="d-none"></canvas>
		</div>
		<div class="tab-pane" id="chart-comment" role="tabpanel">
			<canvas class="d-none"></canvas>
		</div>
		<div class="tab-pane" id="chart-follower" role="tabpanel">
			<canvas class="d-none"></canvas>
		</div>
	</div>
</div>

<script>

function setWidgetPostLineChart(ele,mod) {

	if (mod=='hit') var chartSet = ['조회수 추이','#cce5ff','#004085']; //label ,backgroundColor,borderColor
	if (mod=='likes') var chartSet = ['좋아요 추이','#d4edda','#155724'];
	if (mod=='dislikes') var chartSet = ['싫어요 추이','#d4edda','#155724'];
	if (mod=='comment') var chartSet = ['댓글 추이','#f8d7da','#721c24'];
	if (mod=='follower') var chartSet = ['구독자 추이','#ffeeba','#856404'];

	var ctx = $(ele).find('canvas');
	ctx.addClass('d-none');
	$('[data-chart="loader"]').removeClass('d-none');

	$.post(rooturl+'/?r='+raccount+'&m=member&a=get_mbrTrend',{
		mod : mod,
		d_start : '<?php echo date("Ymd", strtotime("-1 week")); ?>'  //일주일전
		},function(response,status){
			if(status=='success'){
				var result = $.parseJSON(response);
				var type=result.type;
        var data=result.data;
        var options=result.options;

				var mbrChart = new Chart(ctx, {
					type: type,
					data: data,
					options: options
				});

				ctx.removeClass('d-none');
				$('[data-chart="loader"]').addClass('d-none');

			} else {
				alert(status);
			}
	});
}

$(document).ready(function(){

	setWidgetPostLineChart('#chart-hit','hit');

	$('#widget-post-chart').find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(this).attr('href');
		var mod = $(this).data('mod');
		var ele = $(target).find('canvas');
		setWidgetPostLineChart(target,mod);
	})

});

</script>
