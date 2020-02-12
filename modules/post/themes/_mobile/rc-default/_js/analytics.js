function setPostTrendChart(ctx,uid,mod,unit,start) {

	$.post(rooturl+'/?r='+raccount+'&m=post&a=get_postTrend',{
    uid : uid,
		mod : mod,
    unit : unit,
		d_start : start
		},function(response,status){
			if(status=='success'){
				var result = $.parseJSON(response);
        var type=result.type;
        var data=result.data;
        var options=result.options;
				var postChart = new Chart(ctx, {
					type: type,
					data: data,
					options: options
				});
				$('[data-role="canvas"]').removeClass('d-none');
				$('[data-role="loader"]').addClass('d-none');

			} else {
				alert(status);
			}
	});
}

page_post_analytics_hit.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'hit';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})

page_post_analytics_referer.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'referer';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})

page_post_analytics_device.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'device';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})

page_post_analytics_side.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'side';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})

page_post_analytics_likes.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'likes';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})

page_post_analytics_dislikes.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'dislikes';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})

page_post_analytics_comment.on('show.rc.page', function(event) {
  var modal = modal_post_analytics;
  var uid = modal.attr('data-uid');
  var page = $(this);
  var ctx = page.find('canvas');
  var mod = 'comment';
  var start = modal.attr('data-start');
  page.find('[data-role="canvas"]').addClass('d-none');
	page.find('[data-role="loader"]').removeClass('d-none');
  setTimeout(function(){
    setPostTrendChart(ctx,uid,mod,'day',start);
  }, 400);
})
