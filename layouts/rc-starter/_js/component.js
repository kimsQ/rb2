var page_main = $('#page-main');

//사이트
var page_site_page = $('#page-site-page');  // 사이트 모듈 페이지
var modal_site_settings = $('#modal-site-settings'); //사이드

//게시판
var page_bbs_list = $('#page-bbs-list');  // 게시판 목록
var page_bbs_view = $('#page-bbs-view');  // 게시물 보기
var page_bbs_write = $('#page-bbs-write');  // 게시물 작성
var page_bbs_write_category = $('#page-bbs-write-category');  // 게시물 작성 > 카테고리 선택
var page_bbs_write_attach = $('#page-bbs-write-attach');  // 게시물 작성 > 카테고리 선택
var page_bbs_qnalist = $('#page-bbs-qnalist');  // 1:1 상담 게시판 목록
var page_bbs_qnaview = $('#page-bbs-qnaview');  // 1:1 상담 게시판 보기
var page_bbs_qnawrite = $('#page-bbs-qnawrite');  // 1:1 상담 게시판 쓰기

var popup_link_share =  $('#popup-link-share'); //링크 공유
var kakao_link_btn = $('#kakao-link-btn')  //카카오톡 링크공유 버튼

function _getBbsList(bid,cat,page,collapse) {

  $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_bbsList',{
     bid : bid,
     cat : cat,
     collapse : collapse
  },function(response){
     var result = $.parseJSON(response);
     var error=result.error;
     var list=result.list;
     var category=result.category;
     if (error) {
       setTimeout(function(){
         history.back();
         page.find('.content').loader('hide');
         setTimeout(function(){ $.notify({message: error},{type: 'default'}); }, 400);
         return false
       }, 300);
     } else {
       var list=result.list;
       page.find('[data-role="main"]').html(list);
       page.find('.content').loader('hide');
       if (category) {
         page.find('.bar-header-secondary').removeClass('d-none');
         page.find('[data-role="category"]').html(category);
       }
     }
  });
}

$( document ).ready(function() {

  // 일반 페이지 보기
  page_site_page.on('show.rc.page', function (event) {
    var button = $(event.relatedTarget);
    var id = button.attr('data-id');
    var type = button.attr('data-type');

    page_site_page.find('[data-role="main"]').loader({  //  로더 출력
      position:   "inside"
    });
    $.post(rooturl+'/?r='+raccount+'&m=site&a=get_postData',{
       id : id,
       _mtype : type
    },function(response){
       var result = $.parseJSON(response);
       var error=result.error;
       var article=result.article;
       if (error) {
         setTimeout(function(){
           history.back();
           page_site_page.find('[data-role="main"]').loader('hide');
           setTimeout(function(){ $.notify({message: error},{type: 'default'}); }, 400);
           return false
         }, 300);
       } else {
         page_site_page.find('[data-role="main"]').loader("hide");
         page_site_page.find('[data-role="main"]').html(article);
         Iframely('oembed[url]') // oembed 미디어 변환
       }
    });
  })

  page_site_page.on('hidden.rc.page', function (event) {
    page_site_page.find('[data-role="main"]').html('');
  })

  // // 게시판 목록 가져오기
  // page_bbs_list.on('show.rc.page', function (event) {
  //   var button = $(event.relatedTarget);
  //   var bid = button.attr('data-id');
  //   var cat= button.attr('data-category');
  //   var collapse = button.attr('data-collapse');
  //   page_bbs_list.find('.content').loader({
  //     position: "inside"
  //   });
  //   getBbsList(bid,cat,page_bbs_list,collapse)
  // })
  //
  // page_bbs_list.on('hidden.rc.page', function (event) {
  //   page_bbs_list.find('.bar-header-secondary').addClass('d-none');
  // })
  //
  // page_bbs_list.find('[data-role="category"]').on('change', function () {
  //   var option = $(this).find(':selected');
  //   var bid = option.attr('data-bid');
  //   var collapse = option.attr('data-collapse');
  //   var cat = option.val();
  //   getBbsList(bid,cat,page_bbs_list,collapse)
  // });
  //
  // // 게시물 보기
  // page_bbs_view.on('show.rc.page', function (event) {
  //   var button = $(event.relatedTarget);
  //   var uid = button.attr('data-uid');
  //
  //   $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
  //      uid : uid,
  //      markup_file : 'view_simple'
  //   },function(response){
  //      var result = $.parseJSON(response);
  //      var error=result.error;
  //      var article=result.article;
  //      var mypost = result.mypost;
  //      if (error) {
  //        setTimeout(function(){
  //          history.back();
  //          page_bbs_view.find('.content').loader('hide');
  //          setTimeout(function(){ $.notify({message: error},{type: 'default'}); }, 400);
  //          return false
  //        }, 300);
  //      } else {
  //        // page_bbs_view.find('.content').loader('hide');
  //        page_bbs_view.find('[data-role="main"]').html(article);
  //
  //        if (!mypost) page_bbs_view.find('[data-role="toolbar"]').remove()
  //
  //      }
  //   });
  // })

  // 게시판(1:1상담) 목록 가져오기
  page_bbs_qnalist.on('show.rc.page', function (event) {
    var button = $(event.relatedTarget);
    var bid = button.attr('data-id');
    var cat= button.attr('data-category');
    var collapse = button.attr('data-collapse');
    page_bbs_qnalist.find('.content').loader({
      position: "inside"
    });
    getBbsList(bid,cat,page_bbs_qnalist,collapse)
  })

  page_bbs_qnalist.on('hidden.rc.page', function (event) {
    page_bbs_qnalist.find('.bar-header-secondary').addClass('d-none');
  })

  //링크 공유 팝업이 열릴때
  popup_link_share.on('shown.rc.popup', function (event) {
    var popup = $(this)
    var subject = popup.attr('data-subject');
    var review = popup.attr('data-review');
    var featured = popup.attr('data-featured');
    var link = popup.attr('data-link');
    var protocol = $(location).attr('protocol');
    var host = $(location).attr('host');
    var url = protocol+'//'+host+link;
    var featured_url = protocol+'//'+host+featured;
    var entry = popup.attr('data-entry');

    popup.find('[data-role="youtube"]').attr('data-clipboard-text',url+'?ref=yt')
    popup.find('[data-role="instagram"]').attr('data-clipboard-text',url+'?ref=ig')
    popup.find('[data-role="facebook"]').attr('data-clipboard-text',url+'?ref=fb')
    popup.find('[data-role="band"]').attr('data-clipboard-text',url+'?ref=bd')
    popup.find('[data-role="naverblog"]').attr('data-clipboard-text',url+'?ref=nb')
    popup.find('[data-role="navercafe"]').attr('data-clipboard-text',url+'?ref=nc')
    popup.find('[data-role="kakaostory"]').attr('data-clipboard-text',url+'?ref=ks')
    popup.find('[data-role="twitter"]').attr('data-clipboard-text',url+'?ref=tt')
    popup.find('[data-role="email"]').attr('data-clipboard-text',url+'?ref=em')
    popup.find('[data-role="sms"]').attr('data-clipboard-text',url+'?ref=sm')
    popup.find('[data-role="etc"]').attr('data-clipboard-text',url)
    popup.find('[data-role="uid"]').attr('data-clipboard-text',entry)

    //카카오톡 링크공유
    kakao_link_btn.off('click').click(function() {
       kakaoTalkSend({
         subject : subject,
         review : review,
         featured : featured_url,
         link : url,
       })
     });

  })

  popup_link_share.on('hidden.rc.popup', function (event) {
    var popup = popup_link_share;
    popup.removeAttr('data-link').removeAttr('data-subject').removeAttr('data-review').removeAttr('data-featured').removeAttr('data-entry');
    popup.find('[data-role]').removeAttr('data-clipboard-text');
  })


  modal_site_settings.on('shown.rc.modal', function (e) {
    var modal = $(this)
    modal.find('[name="main_post_req"]').val('');
    $.post(rooturl+'/?r='+raccount+'&m=site&a=get_sitecode',{
      },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var main_post_req=result.main_post_req;
          modal.find('[name="main_post_req"]').val(main_post_req);
        } else {
          alert(status);
        }
    });
  })

  modal_site_settings.find('[data-act="submit"]').click(function(){
    var button = $(this)
    var modal = modal_site_settings;
    var main_post_req = modal.find('[name="main_post_req"]').val();
    button.addClass('disabled');
    setTimeout(function(){
      $.post(rooturl+'/?r='+raccount+'&m=site&a=regissitecode',{
        main_post_req : main_post_req
        },function(response,status){
          if(status=='success'){
            button.removeClass('disabled');
            $.notify({message: '저장 되었습니다.'},{type: 'default'});
          } else {
            alert(status);
          }
      });
    }, 200);
  });


});
