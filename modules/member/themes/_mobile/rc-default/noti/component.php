<!-- 사이트 페이지 -->
<section class="page right" id="page-noti-list">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">
      새 알림
      <?php if ($my['uid']): ?>
      <span class="badge badge-danger badge-inverted ml-2" data-role="noti-status"><?php echo $my['num_notice']==0?'':$my['num_notice']?></span>
      <?php endif; ?>
    </h1>
  </header>

  <div class="content bg-white">

    <?php if ($my['uid']): ?>
    <ul class="table-view table-view-full border-top-0 my-0 bg-white" data-role="noti-list">
      <!-- 드러어가 열릴때, 여기에 알림정보를 받아옴 -->
    </ul>
    <?php else: ?>
    <p class="content-padded">

      <small class="text-muted">
        내 알림을 확인하기 위해서는 로그인이 필요합니다.
      </small>

      <button type="button" class="btn btn-secondary btn-block mt-3" data-toggle="modal" data-target="#modal-login">
        로그인 하기
      </button>
    </p>

    <?php endif; ?>
  </div>
</section>

<!-- Sheet -->
<div id="sheet-noti" class="sheet">

  <div class="card card-full">
    <div class="card-header bg-primary px-2 clearfix rounded-0" data-history="back" style="padding-bottom: 8px;">
      <div class="pull-left">
        <span data-role="micon" style="vertical-align: middle;"></span>
        <span data-role="title" class="ml-1" style="vertical-align: middle;"></span>
      </div>
      <div class="pull-right">
        <a class="icon icon-close" role="button"></a>
      </div>
    </div>
    <div class="card-body">

      <div class="content-padded">

        <div class="media">
          <span class="media-left">
            <img class="img-circle" src="" style="width:60px" data-role="avatar">
          </span>
          <div class="media-body">
            <span data-role="message"></span>
            <div>
              <span class="badge badge-default badge-inverted" data-role="from"></span>
              <span class="badge badge-default badge-inverted"><i class="fa fa-clock-o" aria-hidden="true"></i> </span>
              <span class="badge badge-default badge-inverted" data-role="d_regis"></span>
            </div>
          </div>
        </div>

      </div>

    </div><!-- /.card-body -->
    <div class="card-footer bg-white px-2"  data-role="has-referer">
      <a href="" class="btn btn-outline-primary btn-block" data-role="referer">
        <span data-role="acton-label">내용확인</span>
      </a>
    </div><!-- /.card-footer -->
  </div><!-- /.card -->
</div> <!-- /.sheet -->


<script>

var page_noti_list = $('#page-noti-list');
var sheet_noti = $('#sheet-noti');  // 알림보기 시트

$(function() {

  page_noti_list.on('show.rc.page', function (event) {

    var page = $(this);

    if (memberid) {
      var page_content = page_noti_list.find('.content')
      $.get(rooturl+'/?r='+raccount+'&m=notification&a=get_notiList',{
          sort: noti_sort,
          orderby: noti_orderby,
          recnum: noti_recnum,
          callMod: 'unread'
        },function(response){
         var result = $.parseJSON(response);
         var num=result.num;
         var tpg=result.tpg;
         var content=result.content;

         page.find('[data-role="noti-list"]').html(content);
         page.find('[data-plugin="timeago"]').timeago();
  			 bar.find('[data-role="noti-status"]').text(num);
         page.find('[data-role="noti-status"]').text(num);
         page.find('[data-role="noti-list"]').attr('data-totalPage',tpg);
         moreNOTI(page_content,tpg)
      });
    }

  });

  page_noti_list.on('hidden.rc.page', function (event) {

    var page = $(this);

    if (memberid) {
      page.find('.content').infinitescroll('destroy') //무한스크롤 리셋
      page.append('<div class="content bg-white"><ul class="table-view table-view-full my-0 bg-white border-top-0" data-role="noti-list"></ul></div>');
    }

  });

  sheet_noti.on('show.rc.sheet', function (event) {
    var item = $(event.relatedTarget)
    var from = item.data('from')
    var avatar = item.data('avatar')
    var uid = item.data('uid')
    var micon = item.data('icon')
    var cell = item.closest('.table-view-cell')
    cell.attr('tabindex','-1').focus().removeClass('table-view-active');  // 모달을 호출한 아이템을 포커싱 처리함 (css로 배경색 적용)
    sheet_noti.find('[data-role="from"]').text(from)
    sheet_noti.find('[data-role="avatar"]').attr('src',avatar)
    sheet_noti.find('[data-role="micon"]').addClass(micon)
    $.post(rooturl+'/?r='+raccount+'&m=notification&a=get_notiData',{
         uid : uid
      },function(response){
       var result = $.parseJSON(response);
       var referer=result.referer;
       var button=result.button;
       var d_regis=result.d_regis;
       var title=result.title;
       var message=result.message;
       sheet_noti.find('[data-role="title"]').text(title)
       sheet_noti.find('[data-role="message"]').html(message)
       sheet_noti.find('[data-role="d_regis"]').text(d_regis)

       if (referer) {
         sheet_noti.find('[data-role="referer"]').attr('href',referer)
         sheet_noti.find('[data-role="not-referer"]').addClass('d-none')
         sheet_noti.find('[data-role="has-referer"]').removeClass('d-none')
         sheet_noti.find('[data-role="acton-label"]').text(button?button:'내용확인')
       }
       else {
         sheet_noti.find('[data-role="not-referer"]').removeClass('d-none')
         sheet_noti.find('[data-role="has-referer"]').addClass('d-none')
       }
    });

  })

  sheet_noti.on('hidden.rc.sheet', function (event) {
    //내용 초기화
    var item = $(event.relatedTarget)
    var noti_badge  = $('[data-role="noti-status"]')
    sheet_noti.find('[data-role="from"]').html('')
    sheet_noti.find('[data-role="referer"]').removeClass('d-none')
    sheet_noti.find('[data-role="micon"]').removeAttr('class')
    sheet_noti.find('[data-role="acton-label"]').text('')
    sheet_noti.find('[data-role="message"]').html('')
    sheet_noti.find('[data-role="d_regis"]').text('')
    sheet_noti.find('[data-role="not-referer"]').removeClass('d-none')
    sheet_noti.find('[data-role="has-referer"]').addClass('d-none')
    var noti_badge  = $('[data-role="noti-status"]')
    $.post(rooturl+'/?r='+raccount+'&m=notification&a=get_notiNum_ajax',function(response){
       var result = $.parseJSON(response);
       var noti_badge_num=result.num;
       noti_badge.text(noti_badge_num)
    });

  })

});

</script>
