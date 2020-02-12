/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.5 모바일 기본형 게시판 테마 스크립트 (rc-default): view.js
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2019 redblock inc
 * --------------------------------------------------------------------------
 */

function getBbsView(settings){
  var type=settings.type; //컴포넌트 타입
  var mid=settings.mid; // 컴포넌트 아이디
  var ctheme=settings.ctheme; // 댓글테마
  var landing = settings.landing;
  var page = $('[data-role="bbs-view"]')
  var sheet_comment_write = $('#sheet-comment-write') // 댓글 작성 sheet
  var page_bbs_photo = $('#page-bbs-photo');  // 샤진 크게보기 페이지
  var page_bbs_opinion = $('#page-bbs-opinion');
  var popup_linkshare = $('#popup-link-share')  //링크공유 팝업
  var kakao_link_btn = $('#kakao-link-btn')  //카카오톡 링크공유 버튼
  var popover_bbs_view = $('#popover-bbs-view') // 게시물 관리 팝오버

  //  게시물보기 모달이 보여질때 : 게시물 본문영역 셋팅
  $(mid).on('show.rc.'+type, function(event) {
    var ele = $(event.relatedTarget) // 모달을 호출한 아이템 정의
    var start = $(ele).attr('data-start')?$(ele).attr('data-start'):''; // 시작페이지
    var bid = $(ele).attr('data-bid')?$(ele).attr('data-bid'):''; // 게시판 아이디
    var uid = $(ele).attr('data-uid')?$(ele).attr('data-uid'):''; // 대상 PK
    var subject = $(ele).attr('data-subject')?$(ele).attr('data-subject'):''; // 제목
    var cat = $(ele).attr('data-cat')?$(ele).attr('data-cat'):''; // 카테고리
    var url = $(ele).attr('data-url')?$(ele).attr('data-url'):''; // url
    var name = $(ele).attr('data-name')?$(ele).attr('data-name'):''; // name
    var mbruid = $(ele).attr('data-mbruid')?$(ele).attr('data-mbruid'):''; // 작성자 회원 고유번호
    var mbrid = $(ele).attr('data-mbrid')?$(ele).attr('data-mbrid'):''; // 작성자 회원아이디
    var avatar = $(ele).attr('data-avatar')?$(ele).attr('data-avatar'):''; // avatar
    var comment = $(ele).attr('data-comment')?$(ele).attr('data-comment'):''; // comment
    var hit = $(ele).attr('data-hit')?$(ele).attr('data-hit'):''; // hit
    var likes = $(ele).attr('data-likes')?$(ele).attr('data-likes'):''; // likes
    var d_regis = $(ele).attr('data-dregis')?$(ele).attr('data-dregis'):''; // d_regis
    var markup = $(ele).attr('data-markup')?$(ele).attr('data-markup'):''; // 마크업
    var item = ele.closest('.table-view-cell')
		var move =  ele.attr('data-move');
    item.attr('tabindex','-1').focus();  // 모달을 호출한 아이템을 포커싱 처리함 (css로 배경색 적용)
    var modal = $(this);
    if (start) page.attr('data-start',start);
    page.find('[name="uid"]').val(uid);
    page.find('[name="bid"]').val(bid);
    page.find('[data-role="cat"]').text(cat).attr('data-cat',cat);
    page.find('[data-role="name"]').text(name);
    page.find('[data-role="total_comment"]').text(comment);
    page.find('[data-target="#page-member-profile"]').attr('data-mbruid',mbruid).attr('data-url','/@'+mbrid);
    page.find('[data-toggle="sheet"][data-avatar]').attr('data-nic',name).attr('data-avatar',avatar).attr('data-mbruid',mbruid);
    page.find('[data-role="avatar"]').attr('src',avatar);
    page.find('[data-role="hit"]').text(hit);
    page.find('[data-role="likes"]').text(likes);
    page.find('[data-role="likes"]').text(likes);
    page.find('[data-role="d_regis"]').text(d_regis);
    page.find('.bar-nav [data-role="toolbar"]').attr('data-uid',uid);
    page.find('[data-role="article"]').loader({  //  로더 출력
      position:   "inside"
    });

    if (landing) {
      page.find('[data-role="hback"]').addClass('d-none');
      page.find('[data-role="gohome"]').removeClass('d-none');
    } else {
      page.find('[data-role="hback"]').removeClass('d-none');
      page.find('[data-role="gohome"]').addClass('d-none');
    }

    setTimeout(function(){
      $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
           bid : bid,
           uid : uid,
           markup_file : markup,
           mod : 'view'
        },function(response){
         modal.find('[data-role="article"]').loader("hide");
         var result = $.parseJSON(response);
         var _uid=result.uid;
         var article=result.article;
         var featured_img = result.featured_img;
         var adddata=result.adddata;
         var attachNum = result.attachNum;
         var attachFileTheme = result.theme_attachFile;
         var hidden=result.hidden;
         var hidden_attach=result.hidden_attach;
         var mypost=result.mypost;
         var bname=result.bname;

         var is_post_liked=result.is_post_liked;
         var is_post_disliked=result.is_post_disliked;
         var is_post_tag=result.is_post_tag;

         var bbs_c_hidden=result.bbs_c_hidden;  // 댓글 사용여부
         var theme=result.theme;
         var theme_css = '/modules/bbs/themes/'+theme+'/_main.css';
         var theme_use_reply=result.theme_use_reply;
         var theme_show_tag=result.theme_show_tag;
         var theme_show_upfile=result.theme_show_upfile;
         var theme_show_like=result.theme_show_like;
         var theme_show_dislike=result.theme_show_dislike;
         var theme_show_share=result.theme_show_share;

         if (!_uid) {
           history.back();
           setTimeout(function(){
             $.notify({message: '존재하지 않는 게시물 입니다.'},{type: 'default'});
             $('[data-role="bbs-list"]').find('#item-'+uid).slideUp();
           }, 600);
         }

         if (!$('link[href="'+theme_css+'"]').length)
           $('<link/>', {
              rel: 'stylesheet',
              type: 'text/css',
              href: theme_css
           }).appendTo('head');

         page.find('[data-role="linkShare"]').attr('data-subject',subject).attr('data-image',featured_img).attr('data-url',url);
         page.find('[data-role="article"]').html(article);
         page.find('[data-act="category"]').attr('data-bname',bname);
         page.find('[data-act="tag"]').attr('data-bname',bname);

         Iframely('[data-role="article"] oembed[url]') // oembed 미디어 변환

         page.find('[data-role="linkShare"]').attr('data-url',url);
         page.find('.bar-nav [data-toggle="popover"]').attr('data-url',url).attr('data-bid',bid).attr('data-uid',uid);

         if (is_post_liked) {
           modal.find('[data-role="btn_post_like"]').addClass('active');
           page_bbs_opinion.find('[data-role="btn_post_like"]').addClass('active');
         }
         if (is_post_disliked) {
           modal.find('[data-role="btn_post_dislike"]').addClass('active');
           page_bbs_opinion.find('[data-role="btn_post_dislike"]').addClass('active')
         }

         if (bbs_c_hidden) {
          page.find('[data-role="btn_comment"]').remove()  // 좋아요 버튼 제거
         }

         if (theme_show_like==0) {
          page.find('[data-role="btn_post_like"]').remove()  // 좋아요 버튼 제거
         }
         if (theme_show_dislike==0) {
          page.find('[data-role="btn_post_dislike"]').remove()  // 싫어요 버튼 제거
         }
         if (theme_show_share==0) {
          page.find('[data-role="linkShare"]').remove()  // sns공유 버튼 제거
         }

         if (theme_show_tag==0 || !is_post_tag) {
          page.find('[data-role="post_tags"]').remove()  // 테그목록 제거
         }

         // 첨부파일이 있을 경우
         if (attachNum) {

           $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=getAttachFileList',{
                p_module : 'bbs',
                uid : uid,
                theme_file : attachFileTheme,
                mod : 'view'
             },function(response){
              var result = $.parseJSON(response);

              var photo=result.photo;
              var photo_full=result.photo_full;
              var video=result.video;
              var audio=result.audio;
              var file=result.file;
              var zip=result.zip;
              var doc=result.doc;

              if (photo) {  // 첨부 이미지가 있을 경우
                page.find('[data-role="attach-photo"]').removeClass('hidden').html(photo)
                i=0;
                page.find('[data-role="attach-photo"] [data-toggle="page"]').each(function(i) {
                  $(this).attr('data-index',i);i=++i;
                });
                page_bbs_photo.find('.swiper-wrapper').html(photo_full)
              }

              if (video) {  // 첨부 비디오가 있을 경우
                page.find('[data-role="attach-video"]').removeClass('hidden').html(video)
              }

              if (audio) {  // 첨부 오디오가 있을 경우
                page.find('[data-role="attach-audio"]').removeClass('hidden').html(audio)
              }

              if (doc) {  // 첨부 문서 있을 경우
                page.find('[data-role="attach-file"]').removeClass('hidden').html(doc)
              }

              if (zip) {  // 첨부 압축파일이 있을 경우
                page.find('[data-role="attach-file"]').removeClass('hidden').html(zip)
              }

              if (file) {  // 첨부 기타파일이 있을 경우
                page.find('[data-role="attach-file"]').removeClass('hidden').html(file)
              }

              if (theme_show_upfile==0) {
               page.find('[data-role="attach"]').remove()  // 첨부목록 제거
              }

            });

         }

         // 댓글 출력 함수 정의
         var get_Rb_Comment = function(p_module,p_table,p_uid,theme){
           modal.find('[data-role="comment_box"]').Rb_comment({
            moduleName : 'comment', // 댓글 모듈명 지정 (수정금지)
            parent : p_module+'-'+p_uid, // rb_s_comment parent 필드에 저장되는 형태가 p_modulep_uid 형태임 참조.(- 는 저장시 제거됨)
            parent_table : p_table, // 부모 uid 가 저장된 테이블 (게시판인 경우 rb_bbs_data : 댓글, 한줄의견 추가/삭제시 전체 합계 업데이트용)
            theme_name : theme, // 댓글 테마
            containerClass :'', // 본 엘리먼트(#commentting-container)에 추가되는 class
            recnum: 5, // 출력갯수
            commentPlaceHolder : '댓글을 입력해주세요.',
            noMoreCommentMsg : '댓글 없음 ',
            commentLength : 200, // 댓글 입력 글자 수 제한
            toolbar : ['imageUpload'] // 툴바 항목
           });
         }
         // 댓글 출력 함수 실행
         var p_module = 'bbs';
         var p_table = 'rb_bbs_data';
         var p_uid = uid; // 게시물 고유번호 적용
         var theme = ctheme;
         var comment_theme_css = '/modules/comment/themes/'+ctheme+'/css/style.css';

         if (!hidden && _uid) {

           if (!$('link[href="'+comment_theme_css+'"]').length)
             $('<link/>', {
                rel: 'stylesheet',
                type: 'text/css',
                href: comment_theme_css
             }).appendTo('head');

           get_Rb_Comment(p_module,p_table,p_uid,theme);
         }

         //댓글영역 바로가기 일 경우,
         if (move=='comment') {
           setTimeout(function(){
             var top = page.find('[data-role="comment-box"]').offset().top;  // 타켓의 위치값
             var bar_height = page.find('.bar-nav').height();  // bar-nav의 높이값
             page.find('.content').animate({ scrollTop: (top-bar_height)-15 }, 100);
           }, 200);
         }

         $('#popover-bbs-view').find('[data-role="toolbar"]').remove();  //popover 항목 초기화

         if (memberid) {  // 로그인 상태 일때
          var item_memberid = '<li class="table-view-cell" data-toggle="postSaved" data-send="ajax" data-role="toolbar" data-history="back">저장하기</li>';
          $('#popover-bbs-view').find('.table-view').prepend(item_memberid)  // 수정,삭제 버튼을 추가함
         }

         if (mypost) {  // 내글이 아니거나 관리자 일때
          var items_mypost = '<li class="table-view-cell" data-toggle="postEdit" data-history="back" data-role="toolbar">수정하기</li><li class="table-view-cell" data-toggle="PostDelete" data-role="toolbar">삭제하기</li>';
          $('#popover-bbs-view').find('.table-view').prepend(items_mypost)  // 수정,삭제 버튼을 추가함
         }

         if (hidden || hidden_attach) {  // 권한이 없거나 비밀글 이거나 첨부파일 권한이 없을 경우 일때
          modal.find('[data-role="attach-photo"]').empty()
          modal.find('[data-role="attach-video"]').empty()
          modal.find('[data-role="attach-audio"]').empty()
          modal.find('[data-role="attach-file"]').empty()
         }

      });
    }, 300);

  })

  //  게시물보기 모달이 보여진 후에..
   $(mid).on('shown.rc.'+type, function(event) {
    var ele = $(event.relatedTarget) // element that triggered the modal
    var uid = ele.data('uid') // 게시물 고유번호 추출
    var modal = $(this);
   });

   //링크공유 버튼을 터치 할때
   $(mid).on('tap','#btn-linkShare',function(){
     if (navigator.share === undefined) {  //webshare.api가 지원되지 않는 환경
  			popup_linkshare.popup('show')
  		} else {
  			var ele = $(this)
  		  var sbj = ele.attr('data-subject')?ele.attr('data-subject'):'' // 버튼에서 제목 추출
  		  var desc = ele.attr('data-desc')?ele.attr('data-desc'):'' // 버튼에서 요약설명 추출
  			var host = $(location).attr('origin');
  			var path = ele.attr('data-url')?ele.attr('data-url'):''
  			var link = host+path // 게시물 보기 URL
  			navigator.share({
  	        title: sbj,
  	        text: desc,
  	        url: link,
  	    })
        .then(() => console.log('성공적으로 공유되었습니다.'))
        .catch((error) => console.log('공유에러', error));
  		}
   });

   //좋아요,싫어요
   $(document).on('tap','[data-toggle="opinion"]',function(){
     var send = $(this).data('send')
     var uid = $(this).data('uid')
     var opinion = $(this).data('opinion')
     var effect = $(this).data('effect')
     var myid = $(this).data('myid')
     var bid = $(mid).find('[name="bid"]').val()
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
        var is__post_disliked=result.is_post_disliked;
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
        $.notify({message: msg},{type: 'default'});
      });
    });

    //게시물 링크저장(스크랩)
    $(document).on('tap','[data-toggle="postSaved"]',function(){
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

   //게시물보기 모달(페이지)이 닫혔을 때
   $(mid).on('hidden.rc.'+type, function() {
      var modal = $(this);
      var uid = modal.find('[name="uid"]').val()
      var list_parent =  $('[data-role="bbs-list"]').find('#item-'+uid)
      modal.find('.bar-nav [data-role="toolbar"]').removeAttr('data-uid')
      list_parent.attr('tabindex','-1').focus();  // 모달을 호출한 아이템을 포커싱 처리함 (css로 배경색 적용)
      modal.find('[name="uid"]').val('')
      modal.find('[data-role="article"]').html(''); // 본문영역 내용 비우기
      modal.find('[data-role="hback"]').removeClass('d-none');
      modal.find('[data-role="gohome"]').addClass('d-none');
      modal.find('[data-role="attach-photo"]').addClass('hidden').empty() // 사진 영역 초기화
      modal.find('[data-role="attach-video"]').addClass('hidden').empty() // 비디오 영역 초기화
      modal.find('[data-role="attach-audio"]').addClass('hidden').empty() // 오디오 영역 초기화
      modal.find('[data-role="attach-file"]').addClass('hidden').empty() // 기타파일 영역 초기화
      modal.find('[data-role="comment_box"]').html(''); // 댓글영역 내용 비우기
      page_bbs_photo.find('.swiper-wrapper').html('')  // 사진크게보기 영역 초기화
   });

	 // 게시물 보기 에서 댓글이 등록된 이후에 ..
   $(mid).find('[data-role="comment_box"]').on('saved.rb.comment',function(){
     window.history.back(); //댓글작성 sheet 내림
     var modal = $(mid)
     var bid = modal.find('[name="bid"]').val()
     var uid = modal.find('[name="uid"]').val()
     var theme = modal.find('[name="theme"]').val()
		 var list_item = $('[data-role="bbs-list"]').find('#item-'+uid)
     var showComment_Ele_1 = modal.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
	   var showComment_ListEle = list_item.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element

     $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
          bid : bid,
          uid : uid,
          theme : theme
       },function(response){
          var result = $.parseJSON(response);
          var total_comment=result.total_comment;
					// $.notify({message: '댓글이 등록 되었습니다.'},{type: 'default'});
          showComment_Ele_1.text(total_comment); // 모달 상단 최종 댓글수량 합계 업데이트
					showComment_ListEle.text(total_comment); // 게시물 목록 해당 항목의 최종 댓글수량 합계 업데이트
     });
   });

   // 게시물 보기 모달에서 한줄의견이 등록된 이후에..
   $(mid).find('[data-role="comment_box"]').on('saved.rb.oneline',function(){
     window.history.back(); //댓글작성 sheet 내림
     var modal = $(mid)
     var bid = modal.find('[name="bid"]').val()
     var uid = modal.find('[name="uid"]').val()
     var theme = modal.find('[name="theme"]').val()
 		 var list_item = $('[data-role="bbs-list"]').find('#item-'+uid)
     var showComment_Ele_1 = modal.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element

	   var showComment_ListEle = list_item.find('[data-role="total_comment"]'); // 댓글 숫자 출력 element
     $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_postData',{
          bid : bid,
          uid : uid,
          theme : theme
       },function(response){
          var result = $.parseJSON(response);
          var total_comment=result.total_comment;
          //$.notify({message: '한줄의견이 등록 되었습니다.'},{type: 'default'});
          modal.find('[data-kcact="reload"]').click(); // 댓글 새로 불러오기
          showComment_Ele_1.text(total_comment); // 최종 댓글수량 합계 업데이트
					showComment_ListEle.text(total_comment); // 게시물 목록 해당 항목의 최종 댓글수량 합계 업데이트
     });
   });

   // 댓글이 수정된 후에..
   $(mid).find('[data-role="comment_box"]').on('edited.rb.comment',function(){
     setTimeout(function(){
       history.back()
       $.notify({message: '댓글이 수정 되었습니다.'},{type: 'default'});
     }, 300);
   })

   // 한줄의견이 수정 후에
   $(mid).find('[data-role="comment_box"]').on('edited.rb.oneline',function(){
     setTimeout(function(){
       history.back()
       $.notify({message: '답글이 수정 되었습니다.'},{type: 'default'});
     }, 300);
   })

   //링크 공유 팝업이 열릴때
   popup_linkshare.on('shown.rc.popup', function (event) {
     var ele = $(event.relatedTarget)
     var path = ele.attr('data-url')?ele.attr('data-url'):''
     var host = $(location).attr('origin');
     var title= "게시물 공유"
     var sbj = ele.attr('data-subject')?ele.attr('data-subject'):'' // 버튼에서 제목 추출
     var email = ele.attr('data-email')?ele.attr('data-email'):'' // 버튼에서 이메일 추출
     var desc = ele.attr('data-desc')?ele.attr('data-desc'):'' // 버튼에서 요약설명 추출
     var image = ele.attr('data-image')?ele.attr('data-image'):'' // 버튼에서 대표이미지 경로 추출
     var popup = $(this)

     var link = host+path // 게시물 보기 URL
     var enc_link = encodeURIComponent(host+path) // URL 인코딩
     var imageUrl = host+image // 대표이미지 URL
     var enc_sbj = encodeURIComponent(sbj) // 제목 인코딩
     var facebook = 'http://www.facebook.com/sharer.php?u=' + enc_link;
     var twitter = 'https://twitter.com/intent/tweet?url=' + enc_link + '&text=' + sbj;
     var naver = 'http://share.naver.com/web/shareView.nhn?url=' + enc_link + '&title=' + sbj;
     var kakaostory = 'https://story.kakao.com/share?url=' + enc_link + '&title=' + enc_sbj;
     var email = 'mailto:' + email + '?subject=링크공유-' + enc_sbj+'&body='+ enc_link;

     popup.find('[data-role="title"]').text(title)
     popup.find('[data-role="share"]').val(host+path)
     popup.find('[data-role="share"]').focus(function(){
       $(this).on("mouseup.a keyup.a", function(e){
         $(this).off("mouseup.a keyup.a").select();
       });
     });

     popup.find('[data-role="facebook"]').attr('href',facebook)
     popup.find('[data-role="twitter"]').attr('href',twitter)
     popup.find('[data-role="naver"]').attr('href',naver)
     popup.find('[data-role="kakaostory"]').attr('href',kakaostory)
     popup.find('[data-role="email"]').attr('href',email)

     //카카오 링크
     function sendLink() {
       Kakao.Link.sendDefault({
         objectType: 'feed',
         content: {
           title: sbj,
           description: desc,
           imageUrl: imageUrl,
           link: {
             mobileWebUrl: link,
             webUrl: link
           }
         },
         buttons: [
           {
             title: '바로가기',
             link: {
               mobileWebUrl: link,
               webUrl: link
             }
           },
         ]
       });
     }

     //카카오톡 링크공유
      kakao_link_btn.click(function() {
        sendLink()
      });
  })

  page_bbs_photo.on('show.rc.page', function (e) {
    var ele = $(e.relatedTarget)
    var index = ele.attr('data-index');
    var uid = ele.attr('data-uid');
    var page = $(this);

    var title = page_bbs_view.find('[data-role="title"]').text();
    var subject = page_bbs_view.find('[data-role="subject"]').text();

    page.find('[data-role="title"]').text(title);
    page.find('[data-role="subject"]').text(subject);

    var bbs_photo_swiper = new Swiper('#page-bbs-photo .swiper-container', {
      zoom: true,
      initialSlide: index,
      spaceBetween: 30,
      pagination: {
        el: '#page-bbs-photo .swiper-pagination',
        type: 'fraction',
      },
      navigation: {
        nextEl: '#page-bbs-photo .swiper-button-next',
        prevEl: '#page-bbs-photo .swiper-button-prev',
      },
      on: {
        init: function () {
          page_bbs_photo.find('.swiper-container').css('height','100vh');
        },
      },
    });

  })

  page_bbs_photo.on('hidden.rc.page', function () {
    // swiper destroy
    var bbs_photo_swiper = document.querySelector('#page-bbs-photo .swiper-container').swiper
    bbs_photo_swiper.destroy(false, true);

    // 줌상태 초기화
    setTimeout(function(){
      page_bbs_photo.find('.swiper-zoom-container').removeAttr('style');
      page_bbs_photo.find('.swiper-zoom-container img').removeAttr('style');
    }, 500);
  })


  //게시물 수정
  $(document).on('tap','[data-toggle="postEdit"]',function() {
    var bid = $(this).attr('data-bid');
    var uid = $(this).attr('data-uid');
    modal_bbs_write.find('[name="bid"]').val(bid);
    modal_bbs_write.find('[name="uid"]').val(uid);
    setTimeout(function(){modal_bbs_write.modal()}, 50);
  });

  // 게시물 삭제
  $(document).on('tap','[data-toggle="PostDelete"]',function() {

    var uid = $(this).data('uid');
    var bid = $(mid).find('[name="bid"]').val();

    history.back();

    setTimeout(function(){
      if (confirm('정말 삭제하시겠습니까?    ')){

        $('.content').loader({
          text:       "삭제중...",
          position:   "overlay"
        });

        $.post(rooturl+'/?r='+raccount+'&m=bbs&a=delete',{
          send : 'ajax',
          uid : uid,
          bid : bid
          },function(response){
           var result = $.parseJSON(response);
           var error=result.error;
           var num=result.num;

           if (!error) {
             $('.content').loader('hide');
             history.back();
             setTimeout(function(){
               if (!num) location.reload();
               else $('#item-'+uid).slideUp();
             }, 700);
           }
         });
      }
    }, 10);

  });

  //첨부된 사진 크게보기 페이지 호출
  $(document).on('click','figure.image',function(){
    if (!$(this).hasClass('ck-widget')) {
      var page_start = $(this).closest('.page').attr('id');
      var src = $(this).find('img').attr('src')
      $('#page-bbs-photo').page({ start: '#'+page_start });
      $('#page-bbs-photo').find('.swiper-slide img').attr('src',src)
      var swiper = new Swiper('#page-bbs-photo .swiper-container', {
        zoom: true,
      });
    }
    return false;
  });

  // 게시물 좋아요 목록보기
	page_bbs_opinion.on('show.rc.page', function(event) {

		var button = $(event.relatedTarget);
		var page = $(this);
		var bid = button.attr('data-bid');
		var uid = button.attr('data-uid');
		var url = button.attr('data-url');
		var opinion =  button.attr('data-opinion');

		page.find('[name="uid"]').val(uid);
		page.find('[name="bid"]').val(bid);
		page.find('[data-toggle="opinion"]').attr('data-uid',uid);

		page.find('[data-role="list"]').loader({  //  로더 출력
			position:   "inside"
		});

		setTimeout(function(){
      $.post(rooturl+'/?r='+raccount+'&m=bbs&a=get_opinionList',{
           uid : uid,
           opinion : opinion
        },function(response){
         page.find('[data-role="list"]').loader("hide");
				 var result = $.parseJSON(response);
				 var _uid=result.uid;
				 var list=result.list;
				 var num=result.num;

				 if (num) {
					 page.find('[data-role="list"]').html(list);
				 } else {
				 	page.find('[data-role="list"]').html('<li class="table-view-cell text-muted">좋아요가 없습니다.</li>');
				 }


			 });
		 }, 300);
	});

	page_bbs_opinion.on('hidden.rc.page', function(event) {
		var page = $(this);
		var uid = page.find('[name="uid"]').val()
		var list_parent =  $('[data-slide="feed"]').find('#item-'+uid)
		list_parent.attr('tabindex','-1').focus();  // 모달을 호출한 아이템을 포커싱 처리함 (css로 배경색 적용)
	});

};
