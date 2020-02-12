/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.5 모바일 기본형 게시판 테마 스크립트 (rc-default): list.js
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2019 redblock inc
 * --------------------------------------------------------------------------
 */

function getBbsList(bid,cat,search,page){
  var _markup = localStorage.getItem('bbs-'+bid+'-listMarkup');
  var markup = _markup?_markup:'media';
  var markup_list=markup+'-list'; // 목록 마크업
  var markup_item=markup+'-item'; // 아이템 마크업
  var page = $(page);
  var container = page.find('[data-role="bbs-list"]');

  if (search) {
    var search = search.split(";");
    var keyword = search[0];
    var where = search[1] ;
  } else {
    var keyword = '';
    var where = '';
  }

  page.attr('data-bid',bid);
  page.find('[data-role="bar-tab"]').remove();

  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_listData',{
      bid : bid,
    },function(response){
      var result = $.parseJSON(response);
      var error=result.error;
      var theme=result.theme;
      var theme_css = '/modules/bbs/themes/'+theme+'/_main.css';
      var recnum=result.recnum;
      var totalPage = result.TPG;
      var totalNUM = result.NUM;
      var sort=result.sort;
      var orderby=result.orderby;
      var bar_tab=result.bar_tab;

      var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
      var prevNUM = currentPage * recnum;
      var moreNUM = totalNUM - prevNUM ;

      if (error) {
        history.back();
        setTimeout(function(){ $.notify({message: error},{type: 'default'}) }, 500);
      } else {
        page.find('[data-role="bar-nav"]').after(bar_tab);

        if (!$('link[href="'+theme_css+'"]').length)
          $('<link/>', {
             rel: 'stylesheet',
             type: 'text/css',
             href: theme_css
          }).appendTo('head');

        container.empty();
        container.append('<div data-role="notice" class="d-none"></div><div data-role="post"></div>');
        container.find('[data-role="post"]').loader({ position: 'inside' });

        $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postList',{
           bid : bid,
           sort: sort,
           orderby: orderby,
           recnum: recnum,
           markup_list : markup_list,
           markup_item : markup_item,
           keyword : keyword,
           where : where,
           cat : cat,
           p : 1
        },function(response){
           var result = $.parseJSON(response);
           var error=result.error;
           var list=result.list;
           if (error) {
             history.back();
             setTimeout(function(){ $.notify({message: '다시 시도해 주세요.'},{type: 'default'}) }, 500);
           } else {
             var num=result.num;
             var num_notice=result.num_notice;
             var list_post=result.list_post;
             var list_notice=result.list_notice;

             // 상태 초기화
             container.find('[data-role="post"]').html('');
             container.find('[data-role="notice"]').html('');

             container.find('[data-role="post"]').html(list_post);
             container.find('[data-role="notice"]').html(list_notice);
             container.find('[data-plugin="timeago"]').timeago();
             container.find('[data-plugin="markjs"]').mark(keyword); // marks.js
             container.find('[data-role="notice"]').removeClass('d-none');

             if (cat || keyword) {
               container.find('[data-role="post"] [data-role="toolbar"]').removeClass('d-none');
               container.find('[data-role="notice"]').addClass('d-none');
               container.find('[data-start]').attr('data-start','#page-bbs-result');

               if (!num) {
                 container.find('[data-role="empty"] [type="button"]').removeClass('d-none');
               }
             }

             overScrollEffect_bbs(page_bbs_list)
             pullToRefresh_bbs(page_bbs_list)

             //무한 스크롤
             container.infinitescroll({
               dataSource: function(helpers, callback){
                 var nextPage = parseInt(currentPage)+1;
                 if (totalPage>currentPage) {
                   $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postList',{
                       bid : bid,
                       sort: sort,
                       orderby: orderby,
                       recnum: recnum,
                       markup_list : markup_list,
                       markup_item : markup_item,
                       keyword : keyword,
                       where : where,
                       cat : cat,
                       p : nextPage
                   },function(response) {
                       var result = $.parseJSON(response);
                       var error = result.error;
                       var list=result.list_post;
                       var page=result.page;
                       if(error) alert(result.error_comment);
                       callback({ content: list });
                       currentPage++; // 현재 페이지 +1
                       console.log(currentPage+'페이지 불러옴')
                       container.find('[data-role="list-wrapper"]').attr('data-page',page);
                       container.find('[data-plugin="timeago"]').timeago();
                       //container.find('[data-plugin="markjs"]').mark(keyword); // marks.js
                   });
                 } else {
                   callback({ end: true });
                   console.log('더이상 불러올 페이지가 없습니다.')
                 }
               },
               appendToEle : container.find('[data-role="post"] [data-role="list-wrapper"]'),
               percentage : 75,  // 95% 아래로 스크롤할때 다움페이지 호출
               hybrid : false  // true: 버튼형, false: 자동
             });
           }
        });
      }

    })
  }, 100);
};
