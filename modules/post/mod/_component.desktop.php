<!-- modal : 포스트 좋아요/싫어요 목록 -->
<div class="modal" tabindex="-1" role="dialog" id="modal-post-opinion">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px">
    <div class="modal-content">
      <div class="modal-header border-bottom-0 bg-light">

        <div class="media align-items-center">
          <span class="position-relative mr-3">
            <img class="border" data-role="featured_img" src="" alt="" style="width:100px">
          </span>
          <div class="media-body">
            <h5 class="f14 my-1 line-clamp-2">
              <span class="font-weight-light" data-role="subject"></span>
            </h5>
            <div class="mb-1">
              <ul class="list-inline d-inline-block f13 text-muted mb-0">
                <li class="list-inline-item">조회 <span data-role="hit"></span></li>
                <li class="list-inline-item">좋아요 <span data-role="likes"></span></li>
                <li class="list-inline-item">댓글 <span data-role="comment"></span></li>
              </ul>
            </div>
          </div>
        </div>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <nav class="bg-light" style="margin-top: -5px;">
        <div class="nav nav-tabs nav-fill" role="tablist">
          <a class="nav-item nav-link active rounded-0 border-left-0" data-toggle="tab" href="#post-likesList" role="tab" data-opinion="like">
            좋아요 <span class="badge" data-role="like-num"></span>
          </a>
          <a class="nav-item nav-link rounded-0" data-toggle="tab" href="#post-dislikesList" role="tab" data-opinion="dislike">
            싫어요  <span class="badge" data-role="dislike-num"></span>
          </a>
        </div>
      </nav>
      <div class="modal-body p-0" style="min-height: 300px">

        <div data-role="loader" class="d-none">
          <div class="d-flex justify-content-center align-items-center"  style="height:300px">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>

        <div class="tab-content p-0">
          <div class="tab-pane active" id="post-likesList" role="tabpanel" data-role="like">
            <div class="list-group list-group-flush" data-role="list"></div>
          </div>
          <div class="tab-pane" id="post-dislikesList" role="tabpanel" data-role="dislike">
            <div class="list-group list-group-flush" data-role="list"></div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- modal : 포스트 통계 -->
<div class="modal" tabindex="-1" role="dialog" id="modal-post-analytics">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0 bg-light">

        <div class="media align-items-center">
          <span class="position-relative mr-3">
            <img class="border" data-role="featured_img" src="" alt="" style="width:100px">
          </span>
          <div class="media-body">
            <h5 class="f14 my-1 line-clamp-2">
              <span class="font-weight-light" data-role="subject"></span>
            </h5>
            <div class="mb-1">
              <ul class="list-inline d-inline-block f13 text-muted mb-0">
                <li class="list-inline-item">조회 <span data-role="hit"></span></li>
                <li class="list-inline-item">좋아요 <span data-role="likes"></span></li>
                <li class="list-inline-item">싫어요 <span data-role="dislikes"></span></li>
                <li class="list-inline-item">댓글 <span data-role="comment"></span></li>
              </ul>
            </div>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <nav class="bg-light" style="margin-top: -5px;">
        <div class="nav nav-tabs nav-fill" role="tablist">
          <a class="nav-item nav-link active rounded-0 border-left-0" data-toggle="tab" href="#chart-post-hit" data-mod="hit" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            유입추이
          </a>
          <a class="nav-item nav-link rounded-0 " data-toggle="tab" href="#chart-post-referer" data-mod="referer" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            유입경로
          </a>
          <a class="nav-item nav-link rounded-0" data-toggle="tab" href="#chart-post-device" data-mod="device" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            디바이스별
          </a>
          <a class="nav-item nav-link rounded-0" data-toggle="tab" href="#chart-post-side" data-mod="side" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            외부유입
          </a>
          <a class="nav-item nav-link rounded-0" data-toggle="tab" href="#chart-post-likes" data-mod="likes" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            좋아요
          </a>
          <a class="nav-item nav-link rounded-0" data-toggle="tab" href="#chart-post-dislikes" data-mod="dislikes" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            싫어요
          </a>
          <a class="nav-item nav-link rounded-0 border-right-0" data-toggle="tab" href="#chart-post-comment" data-mod="comment" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-unit="day" role="tab">
            댓글
          </a>
        </div>
      </nav>
      <div class="modal-body" style="min-height: 420px">

        <div data-role="loader">
          <div class="d-flex justify-content-center align-items-center"  style="height:385px">
            <div class="spinner-border text-muted" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>


        <div class="tab-content">
          <div class="tab-pane active" id="chart-post-hit" role="tabpanel"></div>
          <div class="tab-pane" id="chart-post-referer" role="tabpanel"></div>
          <div class="tab-pane" id="chart-post-device" role="tabpanel"></div>
          <div class="tab-pane" id="chart-post-side" role="tabpanel"></div>
          <div class="tab-pane" id="chart-post-likes" role="tabpanel"></div>
          <div class="tab-pane" id="chart-post-dislikes" role="tabpanel"></div>
          <div class="tab-pane" id="chart-post-comment" role="tabpanel"></div>
        </div>
      </div>


      <div class="modal-footer bg-light">

        <div class="mr-auto">

          <select class="form-control custom-select mr-2" data-toggle="term" data-mod="hit" style="width: 150px">
            <option selected value="<?php echo date("Ymd", strtotime("-1 week")); ?>" data-d_start="<?php echo date("Y.m.d", strtotime("-1 week")); ?>" data-unit="day">
              최근 1주
            </option>
            <option value="<?php echo date("Ymd", strtotime("-2 week")); ?>" data-d_start="<?php echo date("Y.m.d", strtotime("-2 week")); ?>" data-unit="day">
              최근 2주
            </option>
            <option value="<?php echo date("Ymd", strtotime("-3 week")); ?>" data-d_start="<?php echo date("Y.m.d", strtotime("-3 week")); ?>" data-unit="day">
              최근 3주
            </option>
            <option value="<?php echo date("Ymd", strtotime("-1 month")); ?>" data-d_start="<?php echo date("Y.m.d", strtotime("-1 month")); ?>" data-unit="day">
              최근 1달
            </option>
            <option value="<?php echo date("Ymd", strtotime("-1 year")); ?>" data-d_start="<?php echo date("Y.m", strtotime("-1 year")); ?>.01" data-unit="month">
              최근 1년
            </option>
          </select>

        </div>

        <span data-role="term">
          <span data-role="d_start"><?php echo date("Y.m.d", strtotime("-1 week")); ?></span>
          ~
          <?php echo date("Y.m.d", strtotime("now")) ?></span>
      </div>

    </div>
  </div>
</div>


<script>

function setPostTrendChart(ctx,uid,mod,unit,start) {

	ctx.addClass('d-none');
	$('[data-role="loader"]').removeClass('d-none');

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
				ctx.removeClass('d-none');
				$('[data-role="loader"]').addClass('d-none');

			} else {
				alert(status);
			}
	});
}


$( document ).ready(function() {

  $('#modal-post-opinion').on('shown.bs.modal', function (e) {
    var modal = $(this);
    var button = $(e.relatedTarget);
    var uid = button.attr('data-uid');
    var opinion = button.attr('data-opinion');

    var item = button.closest('[data-role="item"]');
    var subject = item.attr('data-subject');
    var featured_img = item.attr('data-featured_img');
    var hit = item.attr('data-hit');
    var likes = item.attr('data-likes');
    var comment = item.attr('data-comment');

    modal.find('[data-role="loader"]').removeClass('d-none');
    modal.find('[data-role="like"] [data-role="list"]').html(''); //초기화
    modal.find('[data-role="like-num"]').text('');
    modal.find('[data-role="dislike"] [data-role="list"]').html('');
    modal.find('[data-role="dislike-num"]').text('');

    if (opinion=='like') modal.find('.nav-tabs .nav-link:first-child').tab('show');
    else modal.find('.nav-tabs .nav-link[data-opinion="dislike"]').tab('show');

    modal.attr('data-uid',uid);
    modal.find('[data-role="subject"]').text(subject);
    modal.find('[data-role="featured_img"]').attr('src',featured_img);

    $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postData',{
      uid : uid
  		},function(response,status){
  			if(status=='success'){
  				var result = $.parseJSON(response);
          var hit=result.hit;
          var likes=result.likes;
          var comment=result.comment;
          modal.find('[data-role="hit"]').text(hit);
          modal.find('[data-role="likes"]').text(likes);
          modal.find('[data-role="comment"]').text(comment);

  			} else {
  				alert(status);
  			}
  	});

		setTimeout(function(){
      $.post(rooturl+'/?r='+raccount+'&m=post&a=get_opinionList',{
           uid : uid,
           opinion : opinion,
           markup_file : 'opinion-item'
        },function(response){
				 var result = $.parseJSON(response);
				 var _uid=result.uid;
				 var list=result.list;
				 var num=result.num;
         var num_like=result.num_like;
         var num_dislike=result.num_dislike;
         modal.find('[data-role="loader"]').addClass('d-none');
         if (num_like) modal.find('[data-role="like-num"]').text(num_like);
         if (num_dislike) modal.find('[data-role="dislike-num"]').text(num_dislike);

				 if (num) {
					 modal.find('[data-role="'+opinion+'"] [data-role="list"]').html(list);
				 } else {
				 	modal.find('[data-role="'+opinion+'"] [data-role="list"]').html('<div class="py-5 text-center text-muted">자료가 없습니다.</div>');
				 }

			 });
		 }, 300);
  })

  //좋아요/싫어요 탭 선택시
  $('#modal-post-opinion').find('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    var modal = $('#modal-post-opinion');
    var uid = modal.attr('data-uid');
    var tab = e.target;
    var opinion = $(tab).attr('data-opinion');

    modal.find('[data-role="loader"]').removeClass('d-none');
    modal.find('[data-role="'+opinion+'"] [data-role="list"]').html(''); //초기화

    setTimeout(function(){
      $.post(rooturl+'/?r='+raccount+'&m=post&a=get_opinionList',{
           uid : uid,
           opinion : opinion,
           markup_file : 'opinion-item'
        },function(response){
         var result = $.parseJSON(response);
         var _uid=result.uid;
         var list=result.list;
         var num=result.num;
         modal.find('[data-role="loader"]').addClass('d-none');

         if (num) {
           modal.find('[data-role="'+opinion+'"] [data-role="list"]').html(list);
           modal.find('[data-role="'+opinion+'-num"]').text(num);
         } else {
          modal.find('[data-role="'+opinion+'"] [data-role="list"]').html('<div class="py-5 text-center text-muted">자료가 없습니다.</div>');
         }

       });
     }, 100);


  })


  $('#modal-post-analytics').on('shown.bs.modal', function (e) {
    var modal = $(this);
    var button = $(e.relatedTarget);
    var uid = button.attr('data-uid');
    var mod = 'hit';

    var item = button.closest('[data-role="item"]');
    var subject = item.attr('data-subject');
    var featured_img = item.attr('data-featured_img');

    modal.find('.tab-pane').html('<canvas style="height: 450px"></canvas>')
    var ctx = $('#chart-post-hit').find('canvas');
    modal.attr('data-uid',uid);
    modal.find('[data-role="subject"]').text(subject);
    modal.find('[data-role="featured_img"]').attr('src',featured_img);

    $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postData',{
      uid : uid
  		},function(response,status){
  			if(status=='success'){
  				var result = $.parseJSON(response);
          var hit=result.hit;
          var likes=result.likes;
          var dislikes=result.dislikes;
          var comment=result.comment;
          modal.find('[data-role="hit"]').text(hit);
          modal.find('[data-role="likes"]').text(likes);
          modal.find('[data-role="dislikes"]').text(dislikes);
          modal.find('[data-role="comment"]').text(comment);

  			} else {
  				alert(status);
  			}
  	});

    setPostTrendChart(ctx,uid,mod,'day',<?php echo date("Ymd", strtotime("-1 week")); ?>);
    modal.find('.nav-tabs .nav-link:first-child').tab('show');
  })

  $('#modal-post-analytics').on('hidden.bs.modal', function (e) {
    var modal = $(this);
    modal.find('.tab-pane canvas').remove()
    modal.find('[data-toggle="term"] option:first').prop("selected", true);
  })

  $('#modal-post-analytics').find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var modal = $('#modal-post-analytics')
    var tab = $(e.target).attr('href');
    var uid = modal.attr('data-uid');
    var start = $(e.target).attr('data-start');
    var mod = $(e.target).attr('data-mod');
    var unit = $(e.target).attr('data-unit');
    var ctx = $('#chart-post-'+mod).find('canvas');
    modal.find('[data-toggle="term"]').attr('data-mod',mod);
    setPostTrendChart(ctx,uid,mod,unit,start);
  })

  $('#modal-post-analytics').find('[data-toggle="term"]').change(function(){
    var modal = $('#modal-post-analytics');
    var uid = modal.attr('data-uid');
    var start = $(this).val();
    var mod = $(this).attr('data-mod');
    var unit = $(this).find(':selected').attr('data-unit');
    var d_start = $(this).find(':selected').attr('data-d_start');
    var ctx = $('#chart-post-'+mod).find('canvas');
    setPostTrendChart(ctx,uid,mod,unit,start);
    modal.find('a[data-toggle="tab"]').attr('data-start',start)
    modal.find('[data-role="d_start"]').text(d_start)
  });


});

</script>
