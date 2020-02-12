/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.4 데스크탑 기본형 게시판 테마 스크립트 (bs4-default): getPostData.js
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2018 redblock inc
 * --------------------------------------------------------------------------
 */


function getPostData(modal_settings){

  var mid=modal_settings.mid; // 모달 아이디
  var ctheme=modal_settings.ctheme; // 댓글테마

  //  게시물보기 모달이 보여질때 : 게시물 본문영역 셋팅
  $(mid).on('show.bs.modal', function(event) {
    var ele = $(event.relatedTarget) // 모달을 호출한 아이템 정의
    var bid = $(ele).attr('data-bid')?$(ele).attr('data-bid'):''; // 게시판 아이디
    var uid = $(ele).attr('data-uid')?$(ele).attr('data-uid'):''; // 대상 PK
    var subject = $(ele).attr('data-subject')?$(ele).attr('data-subject'):''; // 테마
    var url = $(ele).attr('data-url')?$(ele).attr('data-url'):''; // 게시물 랜딩 URL
    var item = ele.closest('tr')
    var linkShare = $('#rb-share').html();
    item.attr('tabindex','-1').focus();  // 모달을 호출한 아이템을 포커싱 처리함 (css로 배경색 적용)
    var modal = $(this)
    modal.find('[name="uid"]').val(uid)
    modal.find('[name="bid"]').val(bid)
    modal.find('[data-role="title"]').text(subject)
    history.pushState({ data: 'pushpush' }, subject, url);

    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
         bid : bid,
         uid : uid,
         mod : 'view'
      },function(response){
       var result = $.parseJSON(response);
       var article=result.article;
       var adddata=result.adddata;
       var photo=result.photo;
       var video=result.video;
       var audio=result.audio;
       var youtube=result.youtube;
       var file=result.file;
       var zip=result.zip;
       var doc=result.doc;
       var hidden=result.hidden;
       var hidden_attach=result.hidden_attach;
       var mypost=result.mypost;

       var is_post_liked=result.is_post_liked;
       var is_post_disliked=result.is_post_disliked;
       var is_post_saved=result.is_post_saved;
       var is_post_tag=result.is_post_tag;

       var bbs_c_hidden=result.bbs_c_hidden;  // 댓글 사용여부
       var theme_use_reply=result.theme_use_reply;
       var theme_show_tag=result.theme_show_tag;
       var theme_show_upfile=result.theme_show_upfile;
       var theme_show_saved=result.theme_show_saved;
       var theme_show_like=result.theme_show_like;
       var theme_show_dislike=result.theme_show_dislike;
       var theme_show_share=result.theme_show_share;

       modal.find('[data-role="subject"]').text(subject)
       modal.find('[data-role="article"]').html(article);

       Iframely('.modal [data-role="article"] oembed[url]') // oembed 미디어 변환

       modal.find('[data-role="url"]').attr('href',url);
       modal.find('[data-role="share"]').attr('data-url',url)
       modal.find('[data-toggle="popover"]').popover({
        container: 'body',
        content: linkShare
      })

       if (is_post_liked) modal.find('[data-role="btn_post_like"]').addClass('active');
       if (is_post_disliked) modal.find('[data-role="btn_post_dislike"]').addClass('active')
       if (is_post_saved) modal.find('[data-role="btn_post_saved"]').addClass('active')

       if (bbs_c_hidden) {
        modal.find('[data-role="btn_comment"]').remove()  // 댓글 바로가기 버튼 제거
        modal.find('[data-role="comment-area"]').remove()  // 댓글 영역 제거
        modal.find('[data-role="comment-alert"]').removeClass('d-none') // 댓글 미사용 알림글 출력
       }

       if (theme_show_saved==0) {
        modal.find('[data-role="btn_post_saved"]').remove()  // 좋아요 버튼 제거
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

       if (photo) {  // 첨부 이미지가 있을 경우
         modal.find('[data-role="attach-photo"]').removeClass('hidden').html(photo)
         initPhotoSwipeFromDOM('[data-plugin="photoswipe"]');
       }

       if (video) {  // 첨부 비디오가 있을 경우
         modal.find('[data-role="attach-video"]').removeClass('hidden').html(video)
         modal.find('[data-plugin="mediaelement"]').mediaelementplayer(); // http://www.mediaelementjs.com/
         modal.find('.mejs__overlay-button').css('margin','0') //mejs-player 플레이버튼 위치재조정
       }

       if (audio) {  // 첨부 오디오가 있을 경우
         modal.find('[data-role="attach-audio"]').removeClass('hidden').html(audio)
         modal.find('[data-plugin="mediaelement"]').mediaelementplayer(); // http://www.mediaelementjs.com/
       }

       if (doc) {  // 첨부 문서 있을 경우
         modal.find('[data-role="attach-file"]').removeClass('hidden').html(doc)
       }

       if (zip) {  // 첨부 압축파일이 있을 경우
         modal.find('[data-role="attach-file"]').removeClass('hidden').html(zip)
       }

       if (file) {  // 첨부 기타파일이 있을 경우
         modal.find('[data-role="attach-file"]').removeClass('hidden').html(file)
       }

       if (youtube) {  // 첨부 유튜브가 있을 경우
         modal.find('[data-role="attach-youtube"]').removeClass('hidden').html(youtube)
         modal.find('[data-plugin="mediaelement"]').mediaelementplayer(); // http://www.mediaelementjs.com/
       }

       if (theme_show_upfile==0) {
        modal.find('[data-role="attach"]').remove()  // 첨부목록 제거
       }


       // 댓글 출력 함수 정의
       var get_Rb_Comment = function(p_module,p_table,p_uid,theme){
         modal.find('.commentting-container').Rb_comment({
          moduleName : 'comment', // 댓글 모듈명 지정 (수정금지)
          parent : p_module+'-'+p_uid, // rb_s_comment parent 필드에 저장되는 형태가 p_modulep_uid 형태임 참조.(- 는 저장시 제거됨)
          parent_table : p_table, // 부모 uid 가 저장된 테이블 (게시판인 경우 rb_bbs_data : 댓글, 한줄의견 추가/삭제시 전체 합계 업데이트용)
          theme_name : theme, // 댓글 테마
          containerClass :'rb-commentting', // 본 엘리먼트(#commentting-container)에 추가되는 class
          recnum: 7, // 출력갯수
          commentPlaceHolder : '댓글을 입력해 주세요.',
          noMoreCommentMsg : '댓글 없음 ',
          commentLength : 200, // 댓글 입력 글자 수 제한
          useEnterSend: true,
          toolbar : [] // 툴바 항목
         });
       }

       // 댓글 출력 함수 실행
       var p_module = 'bbs';
       var p_table = 'rb_bbs_data';
       var p_uid = uid; // 게시물 고유번호 적용
       var theme = ctheme;

       if (!hidden) {
         get_Rb_Comment(p_module,p_table,p_uid,theme);
       }

       if (!mypost) {  // 내글이 아니거나 관리자가 아닐때
        modal.find('[data-role="toolbar"]').remove()  // 수정,삭제가 포함된 툴바,첨부파일,댓글을 제거함
       }

       if (hidden || hidden_attach) {  // 권한이 없거나 비밀글 이거나 첨부파일 권한이 없을 경우 일때
        modal.find('[data-role="attach-photo"]').empty()
        modal.find('[data-role="attach-video"]').empty()
        modal.find('[data-role="attach-audio"]').empty()
        modal.find('[data-role="attach-file"]').empty()
       }

       setTimeout(function(){ // 첨부된 이미지들이 전부 로드되어야 정확안 높이를 구할수 있음. 로드시간 확보를 위한 대기시간
         var post_height = modal.find('[data-role="post"]').height(); // 게시물 영역의 높이
         modal.find('[data-role="post"]').attr('height',post_height)
       }, 500);

    });
  })

    // 댓글 버튼 클릭시에 댓글 입력창 포커스 처리
    $(mid).on('click','.js-comment-focus',function(){
      $('#meta-description-content').focus().addClass('animated bounce')
    });

   //좋아요,싫어요
   $(mid).on('click','[data-toggle="opinion"]',function(){
     var modal = $(mid)
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

        if (!error) {
          if (opinion=='like') {
            if (is_post_liked) {
              var msg = '좋아요가 취소 되었습니다.';
              $('[data-role="btn_post_like"]').removeClass('active '+effect);
            }
            else {
              var msg = '좋아요가 추가 되었습니다.';
              $('[data-role="btn_post_like"]').addClass('active '+effect);
              $('[data-role="btn_post_dislike"]').removeClass('active '+effect);
            }
          }
          if (opinion=='dislike') {
            if (is_post_disliked) {
              var msg = '싫어요 취소 되었습니다.';
              $('[data-role="btn_post_dislike"]').removeClass('active '+effect);
            }
            else {
              var msg = '싫어요 추가 되었습니다.';
              $('[data-role="btn_post_dislike"]').addClass('active '+effect)
              $('[data-role="btn_post_like"]').removeClass('active '+effect)
            }
          }
          $('[data-role="likes_'+uid+'"]').text(likes)
          $('[data-role="dislikes_'+uid+'"]').text(dislikes)
        }
        $.notify({message: msg},{type: 'success'});
      });
    });

   //게시물보기 모달이 닫혔을 때
   $(mid).on('hidden.bs.modal', function() {
      var modal = $(this);
      var uid = modal.find('[name="uid"]').val()
      var list_parent =  $('[data-role="bbs-list"]').find('#item-'+uid)

      if (!modal.hasClass('history')) window.history.back(); //히스토리백


      modal.find('[data-role="article"]').html(''); // 본문영역 내용 비우기
      modal.find('.commentting-container').html(''); // 댓글영역 내용 비우기

      modal.find('[data-role="attach-photo"]').addClass('hidden').empty() // 사진 영역 초기화
      modal.find('[data-role="attach-video"]').addClass('hidden').empty() // 비디오 영역 초기화
      modal.find('[data-role="attach-youtube"]').addClass('hidden').empty() // 유튜브 영역 초기화
      modal.find('[data-role="attach-audio"]').addClass('hidden').empty() // 오디오 영역 초기화
      modal.find('[data-role="attach-file"]').addClass('hidden').empty() // 기타파일 영역 초기화

     setTimeout(function(){
       list_parent.attr('tabindex','-1').focus();  // 모달을 호출한 아이템을 포커싱 처리함 (css로 배경색 적용)
       modal.removeClass('history');
     }, 10);
   });

   //히스토리 백
   $(window).on('popstate',function(event) {
     $(mid).addClass('history');
     $(mid).modal('hide')
   });

   //게시물 보기 모달에서 댓글이 셋팅된 이후에..
   $(mid).find('.commentting-container').on('shown.rb.comment',function(){
     var modal = $(mid)
     modal.find('[data-toggle="popover"]').popover({
      trigger: 'hover'
    })
   });

	 // 게시물 보기 모달에서 댓글이 등록된 이후에..
   $(mid).find('.commentting-container').on('saved.rb.comment',function(){
     var modal = $(mid)
     var bid = modal.find('[name="bid"]').val()
     var uid = modal.find('[name="uid"]').val()
     var theme = modal.find('[name="theme"]').val()
		 var list_item = $('[data-role="bbs-list"]').find('#item-'+uid)
     var showComment_Ele = modal.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
	   var showComment_ListEle = list_item.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element

     modal.find('.timeline-vscroll').animate({scrollTop : 0}, 100); // 스크롤 상단 이동
     modal.find('[data-toggle="tooltip"]').tooltip()
     modal.find('.add-comment').click(function() {
       var uid = $(this).data('parent')
       var textarea = $('[data-role="oneline-input-'+uid+'"]')
       setTimeout(function(){ textarea.focus(); }, 200); // 한줄의견 추가시에 textarea focus 처리하기
     });
     modal.find('#meta-description-content').removeAttr("style"); //댓글 입력창 크기 원상복귀

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
					// $.notify({message: '댓글이 등록 되었습니다.'},{type: 'success'});
          showComment_Ele.text(total_comment); // 모달 상단 최종 댓글수량 합계 업데이트
					showComment_ListEle.text(total_comment); // 게시물 목록 해당 항목의 최종 댓글수량 합계 업데이트
     });
   });

   // 게시물 보기 모달에서 한줄의견이 등록된 이후에..
   $(mid).find('.commentting-container').on('saved.rb.oneline',function(){
     var modal = $(mid)
     var bid = modal.find('[name="bid"]').val()
     var uid = modal.find('[name="uid"]').val()
     var theme = modal.find('[name="theme"]').val()
 		 var list_item = $('[data-role="bbs-list"]').find('#item-'+uid)
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

   // 댓글이 수정된 후에
   $(mid).find('.commentting-container').on('edited.rb.comment',function(){
     setTimeout(function(){
       $.notify({message: '댓글이 수정 되었습니다.'},{type: 'success'});
     }, 300);
   })

   // 한줄의견이 수정 후에
   $(mid).find('.commentting-container').on('edited.rb.oneline',function(){
     setTimeout(function(){
       $.notify({message: '의견이 수정 되었습니다.'},{type: 'success'});
     }, 300);
   })


   //게시물 링크저장(스크랩)
   $(mid).on('click','[data-toggle="saved"]',function(){
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
            var msgType = 'successs';
            $('[data-role="btn_post_saved"]').removeClass('active');
          }
          else {
            var msg = '게시물이 저장함에 추가되었습니다.';
            var msgType = 'successs';
            $('[data-role="btn_post_saved"]').addClass('active');
          }
        }
        $.notify({message: msg},{type: 'success'});
      });
    });

    //링크 공유 팝오버가 열릴때
    $(mid).on('shown.bs.popover','[data-toggle="popover"]',function(event){
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

}
