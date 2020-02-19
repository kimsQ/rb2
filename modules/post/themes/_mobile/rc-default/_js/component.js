var page_post_allpost =  $('#page-post-allpost'); //전체 포스트
var page_post_alllist =  $('#page-post-alllist'); //전체 리스트
var page_post_listview =  $('#page-post-listview'); //특정 리스트 보기
var page_post_keyword =  $('#page-post-keyword'); //키워드 보기
var page_post_category_view =  $('#page-post-category-view'); //카테고리 보기
var page_post_myhistory =  $('#page-post-myhistory'); //최근에 본 포스트
var page_post_mypost =  $('#page-post-mypost'); //내 포스트 관리
var page_post_mylist =  $('#page-post-mylist'); //내 리스트 관리
var page_post_saved=  $('#page-post-saved'); // 내 포스트 저장내역(나중에 볼 동영상)
var page_post_liked=  $('#page-post-liked'); // 좋아요한 포스트
var page_post_view =  $('#page-post-view'); //포스트 보기
var page_post_photo= $('#page-post-photo'); //포스트 사진보기
var page_post_edit_main = $('#page-post-edit-main'); // 포스트 작성 메인
var page_post_edit_attach =  $('#page-post-edit-attach'); //포스트 작성 첨부파일 추가
var page_post_edit_link = $('#page-post-edit-link'); // 포스트 작성 링크추가
var page_post_edit_review = $('#page-post-edit-review'); // 포스트 작성 리뷰입력
var page_post_edit_tag = $('#page-post-edit-tag'); // 포스트 작성 태그입력
var page_post_edit_advan = $('#page-post-edit-advan'); // 포스트 작성 고급설정
var page_post_edit_category = $('#page-post-edit-category'); //포스트 작성 카테고리입력
var page_post_edit_mediaset = $('#page-post-edit-mediaset'); //포스트 작성 미디어셋설정
var page_post_edit_imageGoodsTag = $('#page-post-edit-imageGoodsTag'); //포스트 작성 상품태그 설정
var page_post_edit_goodslist = $('#page-post-edit-goodslist'); //포스트 작성 상품연결
var page_post_edit_goodsview = $('#page-post-edit-goodsview'); //포스트 작성 연결상품보기
var page_post_analytics_main = $('#page-post-analytics-main'); // 포스트 통계분석 메인
var page_post_analytics_hit = $('#page-post-analytics-hit'); // 포스트 통계분석 유입추이
var page_post_analytics_referer = $('#page-post-analytics-referer'); // 포스트 통계분석 유입경로
var page_post_analytics_device = $('#page-post-analytics-device'); // 포스트 통계분석 디바이스별
var page_post_analytics_side = $('#page-post-analytics-side'); // 포스트 통계분석 외부유입
var page_post_analytics_likes = $('#page-post-analytics-likes'); // 포스트 통계분석 좋아요
var page_post_analytics_dislikes = $('#page-post-analytics-dislikes'); // 포스트 통계분석 싫어요
var page_post_analytics_comment = $('#page-post-analytics-comment'); // 포스트 통계분석 댓글

var modal_post_allpost =  $('#modal-post-allpost'); //전체 포스트
var modal_post_alllist =  $('#modal-post-alllist'); //전체 리스트
var modal_post_listview =  $('#modal-post-listview'); //리스트 보기
var modal_post_write = $('#modal-post-write'); //포스트 작성
var modal_post_twit = $('#modal-post-twit'); // 포스트 간단글 쓰기
var modal_post_view =  $('#modal-post-view'); //포스트 보기
var modal_post_photo =  $('#modal-post-photo'); //포스트 사진 보기
var modal_post_opinion =  $('#modal-post-opinion'); //포스트 좋아요 보기
var modal_post_analytics =  $('#modal-post-analytics'); //포스트 통계분석

var popup_post_postMore = $('#popup-post-postMore'); // 포스트 옵션 더보기
var popup_post_report = $('#popup-post-report'); // 포스트 신고
var popup_post_sort = $('#popup-post-sort'); // 정열방식 변경
var popup_post_newList = $('#popup-post-newList'); // 새 재생목록
var popup_post_newPost = $('#popup-post-newPost'); // 새 포스트작성을 위한 작업선택
var popup_post_delConfirm = $('#popup-post-delConfirm'); // 포스트 삭제 확인

var sheet_post_listadd = $('#sheet-post-listadd'); // 포스트 리스트에 저장
var sheet_post_linkadd = $('#sheet-post-linkadd'); // 새 포스트작성을 위한 링크추가
var sheet_post_photoadd = $('#sheet-post-photoadd'); // 새 포스트작성을 위한 사진 추가
var sheet_post_filter = $('#sheet-post-filter')  // 리스트 필터링,정별방식 설정

var popover_post_display = $('#popover-post-display') // 새 포스트 작성을 위한 공개설정

function pullToRefresh_post(page){

  if (page.find('.snap-content').length) var wrapper = page.find('.snap-content');
  else  var wrapper = page;

  wrapper.find('.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  wrapper.find('.content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    var page_contentY = wrapper.scrollTop();
    if (page_contentY === 0 && page_endY > page_startY ) {
      if (page_endY-page_startY>150) {

        var list_ele = wrapper.find('[data-role="list"]');
        list_ele.html('');
        var content_html = wrapper.find('.content').clone();
        wrapper.find('.content').infinitescroll('destroy');
        wrapper.append(content_html);
        var list_ele = wrapper.find('[data-role="list"]');
        list_ele.loader({ position: 'inside' });

        getPostAll({
          wrapper : list_ele,
          start : '#'+page.attr('id'),
          markup    : 'post-row',  // 테마 > _html > post-row-***.html
          recnum    : 5,
          sort      : 'gid',
          none : wrapper.find('[data-role="none"]').html(),
          paging : 'infinit'
        })
      }
    }
  })
}

// 전체 포스트 보기
page_post_allpost.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var start = button.attr('data-start')
  var page = $(this);
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');

  getPostAll({
    wrapper : wrapper,
    start : '#page-post-allpost',
    markup    : 'post-row',  // 테마 > _html > post-row-***.html
    recnum    : 5,
    sort      : 'gid',
    none : page.find('[data-role="none"]').html(),
    paging : 'infinit'
  });
})

// 전체 리스트 보기
page_post_alllist.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');

  getPostListAll({
    wrapper : wrapper,
    start : '#page-post-alllist',
    markup    : 'list-row',  // 테마 > _html > list-row.html
    totalNUM  : '',
    recnum    : '',
    totalPage : '',
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  });
})

//포스트 : 특정 리스트 보기
page_post_listview.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var wrapper = page.find('[data-role="box"]');
  var listid = button.attr('data-id');
  wrapper.html('');

  getPostListview({
    listid : listid,
    wrapper : wrapper,
    markup    : 'listview-box',  // 테마 > _html > listview-box.html
    totalNUM  : '',
    recnum    : '',
    totalPage : '',
    sort      : '',
    orderby   : '',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  });
})

page_post_keyword.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var keyword = button.attr('data-keyword')?button.attr('data-keyword'):page.attr('data-keyword');
  var wrapper = page.find('[data-role="list"]');
  page.find('[data-role="title"]').text('# '+keyword);
  wrapper.html('');

  var settings={
    wrapper : wrapper,
    start : '#page-post-keyword',
    markup    : 'keyword-row',  // 테마 > _html > post-card-full.html
    keyword : keyword,
    totalNUM  : '',
    recnum    : '',
    totalPage : '',
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }

  getPostKeyword(settings);

})

page_post_category_view.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var category = button.attr('data-category');
  var wrapper = page.find('[data-role="list"]');


  var swiper_shop_category_thumbs = document.querySelector('#page-post-category-view .bar-standard .swiper-container-thumbs').swiper;
  var swiper_shop_category_body = document.querySelector('#page-post-category-view .content .swiper-container').swiper;

  if (swiper_shop_category_thumbs) swiper_shop_category_thumbs.destroy(true,true);
  if (swiper_shop_category_body) swiper_shop_category_body.destroy(true,true);

  var button = $(event.relatedTarget)
  var intial_index = button.data('index')
  var category_parent = button.data('parent')?button.data('parent'):0;

  // 초기화
  page.find('.bar-standard').removeClass('d-none')
  page.find('.bar-standard .swiper-wrapper').html('')
  page.find('.content .swiper-wrapper').html('');

  $.post(rooturl+'/?r='+raccount+'&m=post&a=set_swiperCategory',{
       parent : category_parent,
       markup_file : 'category'
    },function(response){

     var result = $.parseJSON(response);
     var nav_links=result.nav_links;
     var num=result.num;
     var swiper_slides=result.swiper_slides;
     page.find('.bar-standard .swiper-wrapper').html(nav_links)
     page.find('.content .swiper-wrapper').html(swiper_slides)

     if (!num) page.find('.bar-standard').addClass('d-none')

    //  page.find('.content').loader({
    //   text:       "불러오는중...",
    //   position:   "overlay",
    // });

    var item = page.find('.bar-standard .nav-link')

    var slidesPerView = num>3?4:3

    var swiper_shop_category_thumbs = new Swiper('#page-post-category-view .bar-standard .swiper-container-thumbs', {
      slidesPerView: slidesPerView,
      freeMode: true,
      freeModeSticky : true,
      watchSlidesVisibility: true,
      // watchSlidesProgress: true,
      slidesOffsetAfter	: 0,
      initialSlide: intial_index,
      navigation: {
        nextEl: '.shadow_after',
        prevEl: '.shadow_before',
      },
      slidesOffsetBefore: 0,
      slidesOffsetAfter : 0
    });

    var swiper_shop_category_body = new Swiper('#page-post-category-view .content .swiper-container', {
      spaceBetween: 10,
      autoHeight: true,
      initialSlide: intial_index,
      navigation: {
        nextEl: '.shadow_after',
        prevEl: '.shadow_before',
      },
      thumbs: {
        swiper: swiper_shop_category_thumbs,
        slideThumbActiveClass: 'active',
        slidesPerView: slidesPerView,
        freeMode: true,
        freeModeSticky : true,
        watchSlidesVisibility: true,
        // watchSlidesProgress: true,
        slidesOffsetBefore: 0,
        slidesOffsetAfter : 0
      },
      on: {
        init: function () {
          console.log('swiper 초기화 완료');
          var intial_slide = page.find('.content .swiper-slide:eq('+intial_index+')')

          // $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_goodsList',{
          //      cat : category,
          //      markup_file : 'category_cols'
          //   },function(response){
          //
          //    var result = $.parseJSON(response);
          //    var list=result.list;
          //
          //    setTimeout(function(){
          //      page.find('.content').loader("hide");
          //      intial_slide.html(list);
          //    }, 100);
          // });
        },
      },
    });

    swiper_shop_category_body.on('slideChange', function () {
      console.log('slide changed');

      var active_index = swiper_shop_category_body.activeIndex
      var active_slide = page.find('.content .swiper-slide:eq('+active_index+')')
      var category = active_slide.data('category')
      var title = active_slide.data('title')

      console.log('category:'+category)

      active_slide.html('');
      page.find('.content').loader({
        text:       "불러오는중...",
        position:   "overlay",
      });

      $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_goodsList',{
           cat : category,
           markup_file : 'category_cols'
        },function(response){

         var result = $.parseJSON(response);
         var list=result.list;

         active_slide.html(list);
         page.find('.content').scrollTop(0);
         page.find('.content').loader("hide");
         setTimeout(function(){
           swiper_shop_category_body.updateAutoHeight();
         }, 100);

      })
    })
  })

  var settings={
    wrapper : wrapper,
    start : '#page-post-category-view',
    markup    : 'category-row',  // 테마 > _html > post-card-full.html
    category : category,
    totalNUM  : '',
    recnum    : 10,
    totalPage : '',
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }

  getPostCategory(settings);

})

page_post_myhistory.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var id = page.attr('id');
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');
  var settings={
    wrapper : wrapper,
    start : '#'+id,
    markup    : 'post-mediaList',  // 테마 > _html > post-mediaList.html
    recnum    : 10,
    sort      : 'uid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">내역이 없습니다.</div<</div>'
  }
  setTimeout(function(){getMyHistory(settings)}, 200);
  page.find('.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('.content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    if (page_endY-page_startY>200) {
      getMyHistory(settings);
    }
  });
})

page_post_mypost.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var id = page.attr('id');
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');
  var settings={
    wrapper : wrapper,
    start : '#'+id,
    markup    : 'post-mediaList',  // 테마 > _html > post-mediaList.html
    recnum    : 10,
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }
  setTimeout(function(){getMyPost(settings)}, 200);
  page.find('.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('.content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    if (page_endY-page_startY>200) {
      getMyPost(settings);
    }
  });
})

// 작업중
sheet_post_filter.on('hidden.rc.sheet', function(event) {
  var sheet = $(this);
  sheet.find('[data-act="submit"]').attr('disabled',false );

})

sheet_post_filter.find('.nav-link').click(function(){
  var button = $(this)
  var sheet = sheet_post_filter;
  var sort = button.attr('data-sort');
  var submit = sheet.find('[data-act="submit"]')
  sheet.find('.nav-link').removeClass('active');
  button.addClass('active');
  submit.attr('data-sort',sort);
});

sheet_post_filter.find('[data-act="submit"]').click(function(){
  var button = $(this)
  var sort = button.attr('data-sort');
  var sheet = sheet_post_filter;
  button.attr('disabled',true );

  var page = page_post_mypost;
  var id = 'page-post-mypost';
  var wrapper = page.find('[data-role="list"]');

  setTimeout(function(){
    history.back();
    wrapper.html('');
    var contianer_html = page.find('.content').clone().wrapAll('<div/>').parent().html();
    page.find('.content').infinitescroll('destroy');
    page.append(contianer_html);
    var _wrapper = page.find('[data-role="list"]');
    getMyPost({
      wrapper : _wrapper,
      start : '#'+id,
      markup    : 'post-mediaList',  // 테마 > _html > post-mediaList.html
      recnum    : 10,
      sort      : sort,
      none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
    })
  }, 400);

});

page_post_mypost.on('hidden.rc.page', function(event) {
  var page = $(this);
  page.find('.content [data-role="list"]').empty();
  page.find('.infinitescroll-end').remove();
  var markup = page.find('.content').clone().wrapAll("<div/>").parent().html();
  page.find('.content').infinitescroll('destroy');
  page.append(markup);
})

page_post_mylist.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var id = page.attr('id');
  var num = page.attr('data-num');
  var tpg = page.attr('data-tpg');
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');
  var settings={
    wrapper : wrapper,
    start : '#'+id,
    markup    : 'list-mediaList',  // 테마 > _html > list-mediaList.html
    recnum    : 10,
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 리스트가 없습니다.</div<</div>'
  }
  setTimeout(function(){getMyList(settings)}, 200);
  page.find('.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('.content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    if (page_endY-page_startY>200) {
      getMyList(settings);
    }
  });
})

page_post_mylist.on('hidden.rc.page', function(event) {
  var page = $(this);
  page.find('.content [data-role="list"]').empty();
  page.find('.infinitescroll-end').remove();
  var markup = page.find('.content').clone().wrapAll("<div/>").parent().html();
  page.find('.content').infinitescroll('destroy');
  page.append(markup);
})

page_post_saved.on('shown.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var id = page.attr('id');
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');

  var settings={
    wrapper : wrapper,
    start : '#'+id,
    markup    : 'post-mediaList',  // 테마 > _html > list-mediaList.html
    recnum    : 10,
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }

  setTimeout(function(){getPostSaved(settings)}, 200);
  page.find('.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('.content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    if (page_endY-page_startY>200) {
      getPostSaved(settings);
    }
  });
})

page_post_saved.on('hidden.rc.page', function(event) {
  var page = $(this);
  page.find('.content [data-role="list"]').empty();
  page.find('.infinitescroll-end').remove();
  var markup = page.find('.content').clone().wrapAll("<div/>").parent().html();
  page.find('.content').infinitescroll('destroy');
  page.append(markup);
})

page_post_liked.on('shown.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var id = page.attr('id');
  var wrapper = page.find('[data-role="list"]');
  wrapper.html('');
  var settings={
    wrapper : wrapper,
    start : '#'+id,
    markup    : 'post-mediaList',  // 테마 > _html > list-mediaList.html
    recnum    : 10,
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }
  setTimeout(function(){getPostLiked(settings)}, 200);
  page.find('.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('.content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    if (page_endY-page_startY>200) {
      getPostLiked(settings);
    }
  });
})

page_post_liked.on('hidden.rc.page', function(event) {
  var page = $(this);
  page.find('.content [data-role="list"]').empty();
  page.find('.infinitescroll-end').remove();
  var markup = page.find('.content').clone().wrapAll("<div/>").parent().html();
  page.find('.content').infinitescroll('destroy');
  page.append(markup);
})

page_post_view.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var format = button.attr('data-format');
  var uid = button.attr('data-uid');
  var list = button.attr('data-list');
  var featured = button.attr('data-featured');
  var provider = button.attr('data-provider');
  var videoId = button.attr('data-videoId');
  var url = button.attr('data-url');

  switch(format) {
    case '1':
      format = 'doc';
      break;
    case '2':
      format = 'video';
      break;
    case '3':
      format = 'adv';
      break;
  }

  setTimeout(function(){
    getPostView({
      mod : 'page',
      format : format,
      uid : uid,
      list : list,
      featured : featured,
      provider : provider,
      videoId : videoId,
      wrapper : page,
      url : url
    });
  }, 100);
})

page_post_view.on('hidden.rc.page', function(event) {
  var page = $(this);
  page.empty()
})

modal_post_allpost.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var wrapper = modal.find('[data-role="list"]');
  wrapper.html('');

  var settings={
    wrapper : wrapper,
    markup    : 'post-row',  // 테마 > _html > post-card-full.html
    totalNUM  : '',
    recnum    : '',
    totalPage : '',
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }

  getPostAll(settings);

})

modal_post_alllist.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var wrapper = modal.find('[data-role="list"]');
  wrapper.html('');

  var settings={
    wrapper : wrapper,
    markup    : 'list-row',  // 테마 > _html > list-row.html
    totalNUM  : '',
    recnum    : '',
    totalPage : '',
    sort      : 'gid',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  }

  getPostListAll(settings);

})

modal_post_listview.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var wrapper = modal.find('[data-role="box"]');
  var listid = button.attr('data-id');
  wrapper.html('');

  getPostListview({
    listid : listid,
    wrapper : wrapper,
    markup    : 'listview-box',  // 테마 > _html > list-tableview.html
    totalNUM  : '',
    recnum    : '',
    totalPage : '',
    sort      : '',
    orderby   : '',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">등록된 포스트가 없습니다.</div<</div>'
  });

})

modal_post_view.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var format = button.attr('data-format');
  var uid = button.attr('data-uid');
  var _uid = modal.attr('data-uid');
  var list = button.attr('data-list');
  var featured = button.attr('data-featured');
  var provider = button.attr('data-provider');
  var videoId = button.attr('data-videoId');
  var url = button.attr('data-url');
  var landing = button.attr('data-landing');

  switch(format) {
    case '1':
      format = 'doc';
      break;
    case '2':
      format = 'video';
      break;
    case '3':
      format = 'adv';
      break;
  }

  modal.attr('data-format',format).attr('data-uid',uid);

  if (uid!=_uid) {
    modal.removeClass('miniplayer');
    modal.empty();
  }

  if(modal.hasClass("miniplayer") === true ) {
    modal.removeClass('miniplayer');
  } else {

    setTimeout(function(){
      getPostView({
        mod : 'modal',
        format : format,
        uid : uid,
        list : list,
        featured : featured,
        provider : provider,
        videoId : videoId,
        wrapper : modal,
        url : url,
        landing : landing
      });
    }, 100);

  }

})

modal_post_view.on('hide.rc.modal', function(event) {
  var modal = $(this);
  var format = modal.attr('data-format');
  var profile_num = $('[data-role="profile-wapper"]').find('.modal.active').length;

  if (format=='video') {
    modal.addClass('miniplayer');
    $('body').addClass('miniplayer');
    if (profile_num) modal.addClass('no-bartab');
  } else {
    modal.empty()
  }
})

modal_post_opinion.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var uid = button.attr('data-uid');
  var modal = $(this);
  if (!uid) uid = modal.attr('data-uid');
  var wrapper = modal.find('[data-role="list"]');
  modal_post_view.find('[data-act="pauseVideo"]').click();  //유튜브 비디오 일시정지
  getPostOpinion({
    uid : uid,
    wrapper : wrapper,
    opinion : 'like',
    markup : '_opinionList',
    none : '<div class="d-flex justify-content-center align-items-center" style="height: 80vh"><div class="text-xs-center text-muted">자료가 없습니다.</div<</div>'
  });
})

//포스트 작성
modal_post_write.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var uid = button.attr('data-uid');
  var url = button.attr('data-url');

  if (!memberid) {
    modal.modal('hide');
    setTimeout(function(){ modal_login.modal();}, 100);
    return false;
  }

  if (!uid) {
    var uid = modal.attr('data-uid');
  } else {
    modal.attr('data-uid',uid);
  }

  modal.find('[data-act="submit"]').attr('disabled', false);
  modal.find('[data-role="loader"]').removeClass('d-none') //로더 초기화
  modal.find('form').addClass('d-none')

  setTimeout(function(){
    setPostWrite({
      uid : uid,
      wrapper : modal,
    });
  }, 300);
})

modal_post_write.on('hidden.rc.modal', function(event) {
  var modal = $(this);
  // 입력사항 초기화
  modal.removeAttr('data-uid');
  modal.find('[data-role="subject"]').val('');
  modal.find('[data-role="featured"]').attr('src','')
  modal.find('[data-role="time"]').text('');
  modal.find('.form-list.floating .input-row').removeClass('active');
  modal.find('[data-role="attach-preview-photo"]').html('');
  modal.find('[data-role="attachNum"]').text('');
  modal.find('[data-role="featured"]').closest('.media-left').addClass('d-none');

  if(modal.find('[data-act="submit"]').is(":disabled")) var submitting = true;
  modal.find('[name="uid"]').val(''); // uid 초기화
  modal.find('[name="pcode"]').val(''); // pcode 초기화
  modal.removeAttr('data-after');

  // var content = editor_post.getData();

  editor_post.destroy();  //에디터 제거
  console.log('editor_post.destroy');
  setTimeout(function(){ modal.find('[data-role="editor-body"]').empty(); }, 100);

  // if (!submitting && (content || subject)) {
  //   setTimeout(function(){
  //     popup_post_cancelCheck.popup({
  //       backdrop: 'static'
  //     });  // 글쓰기 취소확인 팝업 호출
  //   }, 200);
  // }

})

modal_post_write.find('[data-act="submit"]').click(function(){
  var button = $(this)
  button.attr('disabled',true );
  setTimeout(function(){
    savePost(document.writeForm)
  }, 600);
});


modal_post_twit.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var uid = button.attr('data-uid');
  var url = button.attr('data-url');
  var placeholder = button.attr('data-placeholder');

  if (!memberid) {
    modal.modal('hide');
    setTimeout(function(){ modal_login.modal();}, 100);
    return false;
  }

  if (!uid) {
    var uid = modal.attr('data-uid');
  } else {
    modal.attr('data-uid',uid);
  }

  if (placeholder) {
    modal.find('[name="subject"]').attr('placeholder',placeholder);
  }

  modal.find('[data-act="submit"]').attr('disabled', false);
  modal.find('[name="subject"]').removeAttr('style').val('');
  setTimeout(function(){ modal.find('[name="subject"]').focus();}, 100);
  autosize(modal.find('[data-plugin="autosize"]'));
})

modal_post_twit.find('[data-act="submit"]').click(function(){
  var button = $(this);
  var modal = modal_post_twit;
  var display = button.attr('data-display');
  var subject = modal.find('[name="subject"]').val();

  if (!subject) {
    $.notify({message: '내용을 입력해주세요.'},{type: 'default'});
    modal.find('[name="subject"]').focus();
    return false;
  }

  button.attr('disabled',true );
  setTimeout(function(){
    saveTwit(display,subject);
  }, 500);
});

modal_post_analytics.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  var uid = modal.attr('data-uid');

  modal.find('[data-role="loader"]').removeClass('d-none');
  modal.find('[data-role="article"]').addClass('d-none');

  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postData',{
    uid : uid
    },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var subject = result.subject.replace(/&quot;/g, '"');
        var featured=result.featured;
        var time=result.time;
        var nic=result.nic;
        var hit=result.hit;
        var likes=result.likes;
        var dislikes=result.dislikes;
        var comment=result.comment;
        modal.find('[data-role="subject"]').text(subject);
        modal.find('[data-role="featured"]').attr('src',featured);
        modal.find('[data-role="nic"]').text(nic);
        modal.find('[data-role="hit"]').text(hit);
        modal.find('[data-role="time"]').text(time);
        modal.find('[data-role="likes"]').text(likes);
        modal.find('[data-role="dislikes"]').text(dislikes);
        modal.find('[data-role="comment"]').text(comment);
        modal.find('[data-role="loader"]').addClass('d-none');
        modal.find('[data-role="article"]').removeClass('d-none');


        var ctx = page_post_analytics_main.find('canvas');
        var mod = 'hit';
        var start = modal.attr('data-start');
        setPostTrendChart(ctx,uid,mod,'day',start);


      } else {
        alert(status);
      }
  });
})

popup_post_postMore.on('show.rc.popup', function(event) {
  var button = $(event.relatedTarget);
  var popup = $(this);
  var uid = button.attr('data-uid');
  popup.attr('data-uid',uid);
  getPostMore(uid);
})

popup_post_postMore.on('hidden.rc.popup', function(event) {
  var popup = $(this);
  popup.find('[data-role="list"]').empty();
})

popup_post_report.on('show.rc.popup', function(event) {
  var button = $(event.relatedTarget);
  var popup = $(this);
  var uid = button.attr('data-uid');
  popup.attr('data-uid',uid);
})

popup_post_report.find('[data-act="submit"]').click(function(){
  var popup = popup_post_report;
  var uid = popup.attr('data-uid');
  $(this).attr('disabled',true );
  history.back();

  $.notify({message: '신고 되었습니다'},{type: 'default'});
  return false;

  // setTimeout(function(){
  //   $.post(rooturl+'/?r='+raccount+'&m=post&a=report',{
  //     uid : uid,
  //     subject : subject,
  //     content : content
  //     },function(response,status){
  //       if(status=='success'){
  //         $.notify({message: '신고 되었습니다'},{type: 'default'});
  //       } else {
  //         alert(status);
  //       }
  //   });
  // }, 100);
});

popup_post_delConfirm.find('[data-act="submit"]').click(function(){
  var button = $(this)
  var popup = popup_post_delConfirm
  var uid = popup.attr('data-uid');
  button.attr('disabled',true );

  setTimeout(function(){
    button.attr('disabled',false );
    history.back();

    $.post(rooturl+'/?r='+raccount+'&m=post&a=delete',{
      uid : uid,
      send_mod : 'ajax'
      },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;

          if (!error) {
            $(document).find('[data-role="item"][data-uid="'+uid+'"]').slideUp().addClass('none');
            var num = $('[data-role="postFeed"] [data-role="list"]').find('[data-role="item"]:not(.none)').length
            if (!num) {
              var html = $('[data-role="postFeed"] [data-role="none"]').html();
              $('[data-role="postFeed"] [data-role="list"]').html(html)
              $('[data-role="postFeed"] [data-role="list"] > div').addClass('animated fadeIn delay-1');
            } else {
              setTimeout(function(){
                $.notify({message: '삭제 되었습니다.'},{type: 'default'});
              }, 700);
            }
          } else {
            $.notify({message: error},{type: 'danger'}); // 작성권한 없음
            return false
          }

        } else {
          alert(status);
        }
    });

  }, 400);
});

sheet_post_listadd.on('show.rc.sheet', function(event) {
  var sheet = $(this);
  var uid = sheet.attr('data-uid');
  sheet.find('[data-role="list-selector"]').loader({ position: 'inside' });
  $.post(rooturl+'/?r='+raccount+'&m=post&a=get_listMy',{
    uid : uid,
    markup_file : 'radio-stacked'
  },function(response){
    var result = $.parseJSON(response);
    var list=result.list;
    var is_saved=result.is_saved;

    sheet.find('[data-role="list-selector"]').html(list);
    if (is_saved) sheet.find('[name="saved"]').prop("checked", true);
    else sheet.find('[name="saved"]').prop("checked", false);
  });
})

sheet_post_linkadd.on('show.rc.sheet', function(event) {
  var button = $(event.relatedTarget)
  var sheet = $(this);
  var act = button.attr('data-act');
  if (!memberid) {
    sheet.modal('hide');
    setTimeout(function(){ modal_login.modal();}, 100);
    return false;
  }
  if (act) sheet.find('button').attr('data-act',act);
  sheet.find('input').val('');
  // setTimeout(function(){ sheet.find('input').focus(); }, 10);
  sheet.find('button').attr('disabled',false );
})

// 링크저장
sheet_post_linkadd.on('click','[data-act="submit"]',function(){
  var button = $(this)
  var input = sheet_post_linkadd.find('input');
  var url = input.val();
  var link_url_parse = $('<a>', {href: url});
  var start = sheet_post_linkadd.attr('data-start');

  if (!url) {
    input.focus();
    // $.notify({message: '복사한 링크를 붙여넣기 하세요.'},{type: 'default'});
    return false
  }
  button.attr('disabled',true);

  //네이버 블로그 URL의 실제 URL 변환
  if ((link_url_parse.prop('hostname')=='blog.naver.com' || link_url_parse.prop('hostname')=='m.blog.naver.com' ) && link_url_parse.prop('pathname')) {
    var nblog_path_arr = link_url_parse.prop('pathname').split("/");
    var nblog_id = nblog_path_arr[1];
    var nblog_pid = nblog_path_arr[2];
    if (nblog_pid) {
      var url =  'https://blog.naver.com/PostView.nhn?blogId='+nblog_id+'&logNo='+nblog_pid;
    } else {
      var url = 'https://blog.naver.com/PostList.nhn?blogId='+nblog_id;
    }
  }

  savePostByLink(url,start);
});

sheet_post_listadd.find('[data-act="submit"]').click(function(){
  var sheet = sheet_post_listadd;
  var uid = sheet.attr('data-uid');
  var saved = sheet.find('input[name="saved"]').is(":checked") == true?1:0;
  var list_sel=sheet.find('input[name="postlist_members[]"]');
  var list_arr=sheet.find('input[name="postlist_members[]"]:checked').map(function(){return $(this).val();}).get();
  var list_n=list_arr.length;
  var list_members='';
  for (var i=0;i <list_n;i++) {
    if(list_arr[i]!='')  list_members += '['+list_arr[i]+']';
  }
  $(this).attr('disabled',true );
  history.back();
  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=post&a=update_listindex',{
      uid : uid,
      saved : saved,
      list_members : list_members
      },function(response,status){
        if(status=='success'){
          $.notify({message: '저장 되었습니다'},{type: 'default'});
        } else {
          alert(status);
        }
    });
  }, 100);
});


sheet_post_listadd.find('[data-toggle="newList"]').click(function(){
  var sheet = sheet_post_listadd;
  var uid = sheet.attr('data-uid');
  popup_post_newList.attr('data-uid',uid);
  history.back();
  setTimeout(function(){
    popup_post_newList.popup();
  }, 100);
});

popup_post_newList.on('shown.rc.popup', function(event) {
  var popup = $(this);
  setTimeout(function(){
    popup.find('[name="name"]').focus()
  }, 400);
})

popup_post_newList.on('hidden.rc.popup', function(event) {
  var popup = $(this);
  // 상태 초기화
  popup.find('[name="name"]').val('');
  popup.find('[name="display"]').val("1").prop("selected", true);
  popup.find('[data-act="submit"]').attr('disabled',false );
})

popup_post_newList.find('[data-act="submit"]').click(function(){
  var popup = popup_post_newList;
  var uid = popup.attr('data-uid');
  var name = popup.find('[name="name"]').val();
  var display = popup.find('[name="display"]').val();

  if (!name) {
    popup.find('[name="name"]').focus();
    return false
  }

  $(this).attr('disabled',true );

  setTimeout(function(){
    history.back();

    $.post(rooturl+'/?r='+raccount+'&m=post&a=regis_list',{
      name : name,
      display : display,
      send_mod: 'ajax'
      },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var list_members=result.uid;

          $.post(rooturl+'/?r='+raccount+'&m=post&a=update_listindex',{
            uid : uid,
            saved : 0,
            list_members : list_members
            },function(response,status){
              if(status=='success'){
                $.notify({message: name+' 에 저장 되었습니다'},{type: 'default'});
              } else {
                alert(status);
              }
          });

        } else {
          alert(status);
        }

    });
  }, 800);

});

// popup_post_newPost
popup_post_newPost.on('show.rc.popup', function(event) {
  if (!memberid) {
    popup_post_newPost.modal('hide');
    setTimeout(function(){ modal_login.modal();}, 100);
    return false;
  }
  var popup = $(this);
  var button = $(event.relatedTarget);
  var start = button.attr('data-start');
  popup.attr('data-start',start);
  modal_post_view.find('[data-act="pauseVideo"]').click();  //유튜브 비디오 일시정지
})

popup_post_newPost.find('[data-toggle="newpost"]').click(function(){
  var popup = popup_post_newPost;
  var button = $(this);
  var type =  button.attr('data-type');
  var start = popup_post_newPost.attr('data-start');

  history.back();
  setTimeout(function(){

    if (type=='link') {
      sheet_post_linkadd.sheet('show').attr('data-start',start);
      sheet_post_linkadd.find('button').attr('data-act','submit');
    } else if (type=='photo') {
      sheet_post_photoadd.sheet({backdrop: 'static'}).attr('data-start',start);
    } else if (type=='twit') {
      modal_post_twit.modal({title: '새 포스트', url : '/post/write'}).attr('data-start',start);
    } else if (type=='youtube') {
      $.notify({message: '구글계정 연결이 필요합니다.'},{type: 'default'});
    } else if (type=='map') {
      $.notify({message: '준비중 입니다.'},{type: 'default'});
    } else {
      modal_post_write.modal({title: '새 포스트',url: '/post/write'}).attr('data-start',start)
    }

  }, 200);

});

sheet_post_photoadd.on('show.rc.sheet', function(event) {
  var sheet = $(this);
  sheet.find('[data-role="attach-preview-photo"]').empty();
  if (!memberid) {
    sheet.sheet('hide');
    setTimeout(function(){ modal_login.modal();}, 100);
    return false;
  }
})

sheet_post_photoadd.on('hidden.rc.sheet', function(event) {
  var sheet = $(this);
  sheet.find('[data-act="attach"]').attr('disabled',false );
  sheet.find('[data-act="submit"]').removeClass('active').addClass('text-muted');
  sheet.find('[data-role="none"]').removeClass('d-none');
  sheet.find('[data-role="guide"]').removeClass('d-none');
  sheet.find('[data-role="attach-preview-photo"]').empty();
  sheet.find('[data-role="attach-preview-file"]').empty();
  sheet.find('[data-role="attach-preview-audio"]').empty();
  sheet.find('[data-role="attach-preview-video"]').empty();
})

sheet_post_photoadd.find('[data-act="attach"]').click(function(){
  var button = $(this)
  var sheet = sheet_post_photoadd;
  modal_post_write.find('[data-role="attach-files"]').RbUploadFile(post_upload_settings); // 아작스 폼+input=file 엘리먼트 세팅
  modal_post_write.find('[data-role="attach-files"]').RbAttachTheme(post_attach_settings);
  modal_post_write.find('[data-role="attach-handler-photo"]').click();
});

sheet_post_photoadd.find('[data-act="submit"]').click(function(){
  var sheet = $(this)
  var num = $('#sheet-post-photoadd').find('[data-role="attach-item"]').length;
  var start = $('#sheet-post-photoadd').attr('data-start');

  if (num==0) {
    $.notify({message: '사진을 첨부 해주세요.'},{type: 'default'});
    return false
  }

  // 대표이미지가 없을 경우, 첫번째 업로드 사진을 지정함
  var featured_img_input = $('#sheet-post-photoadd').find('input[name="featured_img"]'); // 대표이미지 input
  var featured_img_uid = featured_img_input.val();
  var modal_featured = modal_post_write.find('[data-role="featured"]');

  if(featured_img_uid ==0){ // 대표이미지로 지정된 값이 없는 경우
    var first_attach_img_li = $('#sheet-post-photoadd').find('[data-role="attach-preview-photo"] li:first'); // 첫번째 첨부된 이미지 리스트 li
    var first_attach_img_src = first_attach_img_li.find('img').attr('src');
    if (first_attach_img_src) modal_featured.attr('src',first_attach_img_src);
  } else {
    var featured_attach_img_src = $('#sheet-post-photoadd').find('[data-id="'+featured_img_uid+'"] img').attr('src');
    if (featured_attach_img_src) modal_featured.attr('src',featured_attach_img_src);
  }

  var list = $(document).find('#sheet-post-photoadd [data-role="attach-preview-photo"]').html();

  modal_featured.closest('.media-left').removeClass('d-none');
  history.back();
  modal_post_write.find('[data-role="attachNum"]').text(num==0?'':num);
  modal_post_write.find('[data-role="attach-preview-photo"]').html(list);
  setTimeout(function(){
    modal_post_write.modal({title: '새 포스트', url : '/post/write'}).attr('data-start',start);
  }, 200);
});

popover_post_display.find('[data-toggle="display"]').click(function(){
  var item = $(this)
  var popover = popover_post_display;
  var display = item.attr('data-display');
  var label = item.attr('data-label');
  popover_post_display.find('.badge').empty();
  item.find('.badge').html('<span class="icon icon-check"></span>');
  page_post_edit_main.find('[data-role="display_label"]').text(label);
  page_post_edit_main.find('[name="display"]').val(display);
  history.back();
});


$(document).on('click','.modal.miniplayer .miniplayer-control .js-close',function(){
  modal_post_view.removeClass('miniplayer no-bartab active').css('display','none').empty();
  $('body').removeClass('miniplayer');
});
