/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.4 데스크탑 갤러리 게시판 테마 스크립트 (bs4-gallery): openGallery.js
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2018 redblock inc
 * --------------------------------------------------------------------------
 */


$(function () {

  var pswpElement = document.querySelectorAll('.pswp-comment')[0];
  var modal = $('.pswp-comment')

  //목록에서 photoswipe 연결
  $('[data-toggle="openGallery"]').click(function(e) {
    var category = $(this).data('category')
    var subject = $(this).data('subject')
    var bid = $(this).data('bid')
    var uid = $(this).data('uid')
    var url = $(this).data('url')
    var bbs_title = document.title
    var linkShare = $('#rb-share').html();

    $(this).closest('.card').attr('tabindex','-1').focus();

    modal.find('[name="uid"]').val(uid)
    modal.find('[name="bid"]').val(bid)
    modal.find('[data-role="subject"]').text(subject);
    history.pushState({ data: 'pushpush' }, subject, url);

    $('body').addClass('modal-open')  // 페이지 스크롤바를 제거하기 위해

    // 게시물 가져오기 및 댓글 셋팅
    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
       bid : bid,
       uid : uid,
       AttachListType : 'object',
       mod : 'view'
      },function(response){
       // modal.find('[data-role="article"]').loader("hide");
       var result = $.parseJSON(response);
       var article=result.article;
       var adddata=result.adddata;

       var hidden=result.hidden;
       var hidden_attach=result.hidden_attach;
       var mypost=result.mypost;
       var items=result.photo;

       var is_post_liked=result.is_post_liked;
       var is_post_disliked=result.is_post_disliked;
       var is_post_saved=result.is_post_saved;
       var is_post_tag=result.is_post_tag;

       var bbs_c_hidden=result.bbs_c_hidden;  // 댓글 사용여부
       var theme_use_reply=result.theme_use_reply;
       var theme_show_tag=result.theme_show_tag;
       var theme_show_upfile=result.theme_show_upfile;
       var theme_show_like=result.theme_show_like;
       var theme_show_dislike=result.theme_show_dislike;
       var theme_show_share=result.theme_show_share;

       if (category) {
         modal.find('[data-role="category"]').html('<span class="badge badge-pill badge-secondary d-inline-block align-top">'+category+'</span>');
       } else {
         modal.find('[data-role="category"]').html('');
       }
       modal.find('[data-role="article"]').html(article);
       modal.find('[data-role="url"]').attr('href',url);
       modal.find('[data-role="share"]').attr('data-url',url)
       modal.find('[data-toggle="popover"]').popover({
        content: linkShare
      })

       Iframely('.pswp [data-role="article"] oembed[url]') // oembed 미디어 변환

       if (is_post_liked) modal.find('[data-role="btn_post_like"]').addClass('active');
       if (is_post_disliked) modal.find('[data-role="btn_post_dislike"]').addClass('active')
       if (is_post_saved) modal.find('[data-role="btn_post_saved"]').addClass('active')

       if (bbs_c_hidden) {
        modal.find('[data-role="btn_comment"]').remove()  // 댓글 바로가기 버튼 제거
        modal.find('[data-role="comment-area"]').remove()  // 댓글 영역 제거
        modal.find('[data-role="comment-alert"]').removeClass('d-none') // 댓글 미사용 알림글 출력
       }

       if (theme_show_like==0) {
        modal.find('[data-role="btn_post_like"]').remove()  // 좋아요 버튼 제거
       }
       if (theme_show_dislike==0) {
        modal.find('[data-role="btn_post_dislike"]').remove()  // 싫어요 버튼 제거
       }
       if (theme_show_share==0) {
        modal.find('[data-role="share"]').remove()  // sns공유 버튼 제거
       }

       if (theme_show_tag==0 || !is_post_tag) {
        modal.find('[data-role="post_tags"]').remove()  // 테그목록 제거
       }

       // photosiwpe 초기화

       // define options (if needed)
       var options = {
         history: false,
         focus: false,
         closeOnScroll: false,
         closeOnVerticalDrag: false,
         showAnimationDuration: 0,
         hideAnimationDuration: 0,
         timeToIdle: 4000,
         loop: false,
         mainClass: 'pswp-comment'
       };

        if (!items) {
          alert('첨부된 사진이 없습니다.');
          return false
        }
        if (items.length==0) {
          alert('표시할 사진이 없습니다. 이미지 숨김 처리여부를 확인해 주세요.');
          return false
        }

       var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
       gallery.init();

       var counter =  '('+modal.find('.pswp__counter').text().replace(/ /g, '')+') ';
       document.title = counter+subject+'-'+bbs_title  // 브라우저 타이틀 재설정

       if (hidden  || hidden_attach) {  // 권한이 없거나 비밀글 이거나 첨부파일 권한이 없을 경우 일때
        modal.find('[data-role="attach-photo"]').empty()
        modal.find('[data-role="attach-video"]').empty()
        modal.find('[data-role="attach-audio"]').empty()
        modal.find('[data-role="attach-file"]').empty()
        modal.find('.pswp__container .pswp__item').empty()
        modal.find('.pswp__subject').empty()
        modal.find('.pswp__counter').empty()
        modal.find('.pswp__caption__center').empty()
        modal.find('.pswp__top-bar').addClass('d-none')
        modal.find('.pswp__button').addClass('d-none')
       }

       //슬라이드 갱신 후에
       gallery.listen('afterChange', function() {
         var counter =  '('+modal.find('.pswp__counter').text().replace(/ /g, '')+') ';
         document.title = counter+subject+'-'+bbs_title  // 브라우저 타이틀 재설정
       });

       // 갤러리 닫기
       modal.on('click','.pswp__button--close',function(){
         gallery.close();
       });

       //히스토리 백
       $(window).on('popstate',function(event) {
         modal.addClass('history');
         gallery.close();
       });

       // 갤러리가 닫힐때
       gallery.listen('close', function() {
         modal.find('[data-role="article"]').html(''); // 본문영역 내용 비우기
         modal.find('.commentting-container').html(''); // 댓글영역 내용 비우기

         if (!modal.hasClass('history')) window.history.back(); //히스토리백

         setTimeout(function(){
           modal.removeClass('history');
         }, 100);

         $('.popover').remove() // 링크공유 popover 제거

         $('#item-'+uid).focus() // 목록 아이템 포커스 처리
         $('[data-toggle="tooltip"]').tooltip('hide')
         $('body').removeClass('modal-open')  // 페이지 스크롤바 원상복귀를 위해
         document.title = bbs_title  // 게시판의 원래 타이틀 복귀
       });

       // 댓글 출력 함수 정의
       var get_Rb_Comment = function(p_module,p_table,p_uid,theme){
         modal.find('.commentting-container').Rb_comment({
          moduleName : 'comment', // 댓글 모듈명 지정 (수정금지)
          parent : p_module+'-'+p_uid, // rb_s_comment parent 필드에 저장되는 형태가 p_modulep_uid 형태임 참조.(- 는 저장시 제거됨)
          parent_table : p_table, // 부모 uid 가 저장된 테이블 (게시판인 경우 rb_bbs_data : 댓글, 한줄의견 추가/삭제시 전체 합계 업데이트용)
          theme_name : theme, // 댓글 테마
          containerClass :'rb-commentting', // 본 엘리먼트(#commentting-container)에 추가되는 class
          recnum: 5, // 출력갯수
          commentPlaceHolder : '댓글을 입력해 주세요...',
          noMoreCommentMsg : '댓글 없음 ',
          useEnterSend: true,
          commentLength : 200, // 댓글 입력 글자 수 제한
         });
       }

       // 댓글 출력 함수 실행
       var p_module = 'bbs';
       var p_table = 'rb_bbs_data';
       var p_uid = uid; // 게시물 고유번호 적용
       var theme = '_desktop/bs4-modal';

       if (!hidden) {
         get_Rb_Comment(p_module,p_table,p_uid,theme);
       }

       if (!mypost) {  // 내글이 아니거나 관리자가 아닐때
        modal.find('[data-role="myToolbar"]').remove()  // 수정,삭제가 포함된 툴바,첨부파일,댓글을 제거함
       }

    });
  });


  // 댓글이 셋팅된 이후에..
  $('.pswp-comment').find('.commentting-container').on('shown.rb.comment',function(){
    var modal = $('.pswp')
    modal.find('[data-toggle="popover"]').popover({
     trigger: 'hover'
   })
  });

  // 댓글이 등록된 후에
  $('.pswp-comment').find('.commentting-container').on('saved.rb.comment',function(){

    var modal = $('.pswp')
    var bid = modal.find('[name="bid"]').val()
    var uid = modal.find('[name="uid"]').val()
    var theme = modal.find('[name="theme"]').val()
    var list_item = $('#item-'+uid)
    var showComment_Ele = modal.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
    var showComment_ListEle = list_item.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element

    modal.find('.timeline-vscroll').animate({scrollTop : 0}, 100);  // 스크롤 상단 이동
    modal.find('.add-comment').click(function() {
      var uid = $(this).data('parent')
      var textarea = $('[data-role="oneline-input-'+uid+'"]')
      setTimeout(function(){ textarea.focus(); }, 200); // 한줄의견 추가시에 textarea focus 처리하기
    });
    modal.find('[data-toggle="popover"]').popover({
       trigger: 'hover'
     })
    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
         bid : bid,
         uid : uid,
         theme : theme,
         mod : 'view'
      },function(response){
         var result = $.parseJSON(response);
         var total_comment=result.total_comment;
         showComment_Ele.text(total_comment); // 모달 상단 최종 댓글수량 합계 업데이트
         showComment_ListEle.text(total_comment); // 게시물 목록 해당 항목의 최종 댓글수량 합계 업데이트
         console.log(total_comment)
    });

    $(this).find('[data-role="commentWrite-container"] textarea').removeAttr('style')
  })

  // 댓글이 수정된 후에
  $('.pswp-comment').find('.commentting-container').on('edited.rb.comment',function(){
    setTimeout(function(){
      $.notify({message: '댓글이 수정 되었습니다.'},{type: 'success'});
    }, 300);
  })

  // 한줄의견이 등록된 이후에..
  $('.pswp-comment').find('.commentting-container').on('saved.rb.oneline',function(){
    var modal = $('.pswp')
    var bid = modal.find('[name="bid"]').val()
    var uid = modal.find('[name="uid"]').val()
    var theme = modal.find('[name="theme"]').val()
    var list_item = $('#page-bbs-list').find('#item-'+uid)
    var showComment_Ele = modal.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
    var showComment_ListEle = list_item.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
    modal.find('[data-toggle="popover"]').popover({
       trigger: 'hover'
     })

    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
         bid : bid,
         uid : uid,
         theme : theme,
         mod : 'view'
      },function(response){
         var result = $.parseJSON(response);
         var total_comment=result.total_comment;
         // $.notify({message: '한줄의견이 등록 되었습니다.'},{type: 'success'});
         showComment_Ele.text(total_comment); // 최종 댓글수량 합계 업데이트
         showComment_ListEle.text(total_comment); // 게시물 목록 해당 항목의 최종 댓글수량 합계 업데이트
    });
  });


  // 한줄의견이 수정 후에
  $('.pswp-comment').find('.commentting-container').on('edited.rb.oneline',function(){
    setTimeout(function(){
      $.notify({message: '의견이 수정 되었습니다.'},{type: 'success'});
    }, 300);
  })

  //좋아요,싫어요
  $('.pswp-comment').on('click','[data-toggle="opinion"]',function(){
    var modal = $('.pswp')
    var send = $(this).data('send')
    var uid = $(this).data('uid')
    var opinion = $(this).data('opinion')
    var effect = $(this).data('effect')
    var myid = $(this).data('myid')
    var bid = modal.find('[name="bid"]').val()

    if(!memberid){
      $('#modal-login').modal()  // 비로그인 일 경우 로그인 모달 호출
      return false;
    }

    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=opinion',{
      send : send,
      opinion : opinion,
      uid : uid,
      memberid : memberid,
      bid : bid
      },function(response){
       var result = $.parseJSON(response);
       var error=result.error;
       var is_post_liked=result.is_post_liked;
       var is_post_disliked=result.is_post_disliked;
       var likes=result.likes;
       var dislikes=result.dislikes;
       var msg=result.msg;
       var msgType=result.msgType;

       if (!error) {
         if (opinion=='like') {
           if (is_post_liked) {
             var msg = '좋아요가 취소 되었습니다.';
             var msgType = 'success';
             $('[data-role="btn_post_like"]').removeClass('active '+effect);
           }
           else {
             var msg = '좋아요가 추가 되었습니다.';
             var msgType = 'success';
             $('[data-role="btn_post_like"]').addClass('active '+effect);
             $('[data-role="btn_post_dislike"]').removeClass('active '+effect);
           }
         }
         if (opinion=='dislike') {
           if (is_post_disliked) {
             var msg = '싫어요 취소 되었습니다.';
             var msgType = 'danger';
             $result['msgType'] = 'danger';
             $('[data-role="btn_post_dislike"]').removeClass('active '+effect);
           }
           else {
             var msg = '싫어요 추가 되었습니다.';
             var msgType = 'success';
             $('[data-role="btn_post_dislike"]').addClass('active '+effect)
             $('[data-role="btn_post_like"]').removeClass('active '+effect)
           }
         }
         $('[data-role="likes_'+uid+'"]').text(likes)
         $('[data-role="dislikes_'+uid+'"]').text(dislikes)
         $('#item-'+uid).find('[data-role="likes"]').text(likes)
         $('#item-'+uid).find('[data-role="dislikes"]').text(dislikes)
       }
       $.notify({message: msg},{type: msgType});
     });
   });

  //게시물 링크저장(스크랩)
  $('.pswp-comment').on('click','[data-toggle="saved"]',function(){
   var send = $(this).data('send')
   var uid = $(this).data('uid')

   if(!memberid){
     $('#modal-login').modal()  // 비로그인 일 경우 로그인 모달 호출
     return false;
   }

   $.post(rooturl+'/?r='+raccount+'&m=bbs&a=saved',{
     send : send,
     uid : uid
     },function(response){
      var result = $.parseJSON(response);
      var error=result.error;
      var is_post_saved=result.is_post_saved;
      var msg=result.msg;
      var msgType=result.msgType;

      if (!error) {
        if (is_post_saved) {
          var msg = '게시물이 저장함에서 삭제되었습니다.';
          var msgType = 'danger';
          $('[data-role="btn_post_saved"]').removeClass('active');
        }
        else {
          var msg = '게시물이 저장함에 추가되었습니다.';
          var msgType = 'success';
          $('[data-role="btn_post_saved"]').addClass('active');
        }
      }
      $.notify({message: msg},{type: msgType});
    });
  });

  //링크 공유 팝오버가 열릴때
  $('.pswp-comment').on('shown.bs.popover','[data-toggle="popover"]',function(event){
    var ele = $(this) // 팝오버를 호출한 아이템 정의
    var path = ele.attr('data-url')?ele.attr('data-url'):''
    var host = $(location).attr('origin');
    var sbj = ele.attr('data-subject')?ele.attr('data-subject'):'' // 버튼에서 제목 추출
    var email = ele.attr('data-email')?ele.attr('data-email'):'' // 버튼에서 이메일 추출
    var desc = ele.attr('data-desc')?ele.attr('data-desc'):'' // 버튼에서 요약설명 추출
    var imageUrl = ele.attr('data-imageUrl')?ele.attr('data-imageUrl'):'' // 버튼에서 대표이미지 경로 추출
    var popover = $('.popover')

    var enc_link = encodeURIComponent(host+path) // URL 인코딩
    var enc_sbj = encodeURIComponent(sbj) // 제목 인코딩
    var facebook = 'http://www.facebook.com/sharer.php?u=' + enc_link;
    var twitter = 'https://twitter.com/intent/tweet?url=' + enc_link + '&text=' + sbj;
    var naver = 'http://share.naver.com/web/shareView.nhn?url=' + enc_link + '&title=' + sbj;
    var kakaostory = 'https://story.kakao.com/share?url=' + enc_link + '&title=' + enc_sbj;
    var email = 'mailto:' + email + '?subject=링크공유-' + enc_sbj+'&body='+ enc_link;

    popover.find('[data-role="share"]').val(host+path)
    popover.find('[data-role="share"]').focus(function(){
      $(this).on("mouseup.a keyup.a", function(e){
        $(this).off("mouseup.a keyup.a").select();
      });
    });

    popover.find('[data-role="facebook"]').attr('href',facebook)
    popover.find('[data-role="twitter"]').attr('href',twitter)
    popover.find('[data-role="naver"]').attr('href',naver)
    popover.find('[data-role="kakaostory"]').attr('href',kakaostory)
    popover.find('[data-role="email"]').attr('href',email)

    var clipboard = new ClipboardJS('[data-plugin="clipboard"]');
    clipboard.on('success', function (e) {
      $(e.trigger)
      .attr('title', '복사완료!')
      .tooltip('_fixTitle')
      .tooltip('show')
      .attr('title', '클립보드 복사')
      .tooltip('_fixTitle')
      e.clearSelection()
    })

  })

  //링크 공유팝오버 외부 클릭시 닫고, 내부클릭시 유지함
  $('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
      if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        $(this).popover('hide');
      }
    });
  });

})
