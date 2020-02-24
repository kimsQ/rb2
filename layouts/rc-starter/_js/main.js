/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.4 모바일 시작하기 레이아웃 스크립트 (rc-starter)
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2019 redblock inc
 * --------------------------------------------------------------------------
 */

var bar = $('.bar')
var drawer_left = $('#drawer-left')
var drawer_right = $('#drawer-right')

var noti_sort = 'uid';
var noti_orderby = 'desc';
var noti_recnum = '10';

function moreNOTI(container,totalPage){
  var noti_currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
  container.infinitescroll({
    dataSource: function(helpers, callback){
      var noti_nextPage = parseInt(noti_currentPage)+1;
      console.log('noti_totalpage: '+totalPage)
      console.log('noti_currentPage: '+noti_currentPage)
      console.log('noti_sort: '+noti_sort)
      $.get(rooturl+'/?r='+raccount+'&m=notification&a=get_notiList',{
          page : noti_nextPage,
          sort: noti_sort,
          orderby: noti_orderby,
          recnum: noti_recnum,
          callMod: 'unread'
      },function(response) {
          var result = $.parseJSON(response);
          var error = result.error;
          var content = result.content;
          if(error) alert(result.error_comment);
          callback({ content: content });
          noti_currentPage++; // 현재 페이지 +1
          console.log(noti_currentPage+'페이지 불러옴')
          $('[data-plugin="timeago"]').timeago();
          if (totalPage<=noti_currentPage) {
            container.infinitescroll('end')
            console.log('더이상 불러올 알림이 없습니다.')
          }
      });
    },
    appendToEle : container.find('.table-view'),
    percentage : 95,  // 95% 아래로 스크롤할때 다음 페이지 호출
    hybrid : false  // true: 버튼형, false: 자동
  });

}

function edgeEffect(container,pos,show) {
  var topEdge = $('#topEdge');
  var bottomEdge = $('#bottomEdge');
  var bar_nav_height = container.find('.bar-nav:not(.onscroll):not(.d-none)').height();
  var bar_standard_height = container.find('.bar-standard:not(.d-none)').height();
  var bar_header_secondary = container.find('.bar-header-secondary:not(.d-none)').height();
  var bar_tab_height = container.find('.bar-tab:not(.d-none)').height();
  var bar_footer_secondary_height = container.find('.bar-footer-secondary:not(.d-none)').height();
  var bar_footer_height  = container.find('.bar-footer:not(.d-none)').height();
  var top_margin = bar_nav_height + bar_header_secondary + bar_standard_height;
  var bottom_margin = bar_tab_height + bar_footer_secondary_height + bar_footer_height;
  topEdge.css("opacity", "0");
  bottomEdge.css("opacity", "0");
  if (pos=='top' && show=='show') {
   topEdge.clearQueue();
   topEdge.css('top',top_margin?top_margin:0);
   topEdge.animate({height:'42px', opacity:'.5'}, 100);
   topEdge.animate({height:'0', opacity:'0'}, 600);
   setTimeout(function(){ topEdge.clearQueue() }, 680);
  }
  if (pos=='bottom' && show=='show') {
   bottomEdge.clearQueue();
   bottomEdge.css('bottom',bottom_margin?bottom_margin:0);
   bottomEdge.animate({height:'42px', opacity:'.5'}, 100);
   bottomEdge.animate({height:'0', opacity:'0'}, 600);
   setTimeout(function(){ bottomEdge.clearQueue() }, 680);
  }
  if (pos=='bottom' && show=='hide') {
   bottomEdge.css("opacity", "0");
  }
}

function kakaoTalkSend(settings) {
  var title = settings.subject;
  var description = settings.review?settings.review:'';
  var imageUrl = settings.featured?settings.featured:'';
  var link = settings.link+'?ref=kt'  // 카카오톡 파라미터 추가;

  if (!kakao_jskey) {
    $.notify({message: '카카오 연동설정을 확인해주세요.'},{type: 'default'});
    return false
  }

  Kakao.Link.sendDefault({
    objectType: 'feed',
    content: {
      title: title,
      description: description,
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

function overScrollEffect(page){
  page.find('main.content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('main.content').on('touchmove',function(event){
    var page_moveY = event.originalEvent.changedTouches[0].pageY;
    var page_contentY = $(this).scrollTop();
    var tab_id = $(this).attr('data-tab');
    if (page_contentY === 0 && page_moveY > page_startY && !document.body.classList.contains('refreshing')) {
      if (page_moveY-page_startY>50) {
        edgeEffect(page,'top','show'); // 스크롤 상단 끝
      }
    }
    if( (page_moveY < page_startY) && ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)) {
      if (page_startY-page_moveY>50) {
        edgeEffect(page.find('main.content'),'bottom','show'); // 스크롤 하단 끝
      }
    }
  });
}

function pullToRefresh(page){
  page.find('.snap-content .content').on('touchstart',function(event){
    page_startY = event.originalEvent.changedTouches[0].pageY;
  });
  page.find('.snap-content .content').on('touchend',function(event){
    var page_endY=event.originalEvent.changedTouches[0].pageY;
    var page_contentY = $(this).scrollTop();
    if (page_contentY === 0 && page_endY > page_startY ) {
      if (page_endY-page_startY>150) {
        $.loader({ text: '새로고침' });
        location.reload();
      }
    }
  })

}

$('[data-plugin="timeago"]').timeago();  // 상대시간 플러그인 초기화

$(document).ready(function() {


  overScrollEffect(page_main.find('.snap-content'));
  // pullToRefresh(page_main);

  $('[data-toggle="fullscreen"]').click(function() {
    toggleFullScreen()
  });

  $('[data-open="newPost"]').click(function() {
    var url = $(this).attr('data-url');
    var start = $(this).attr('data-start');
    drawer_left.drawer('hide')

    if (start=='#page-main') {
      setTimeout(function(){
        $('#popup-post-newPost').popup({
          title :'작업선택',
          url : 'post/write'
        }).attr('data-start',start);
      }, 350);
    } else {
      setTimeout(function(){
        $('#page-post-allpost').page({
          start : '#page-main',
          title : '최신 포스트'
        });
        setTimeout(function(){
          $('#popup-post-newPost').popup({
            title :'작업선택',
            url : 'post/write'
          }).attr('data-start',start);
        }, 350);
      }, 300);
    }
  });

  $('[data-toggle="goMypage"]').click(function() {
    var url = $(this).attr('data-url');
    var target = $(this).attr('data-target');
    var start = $(this).attr('data-start');
    var title = $(this).attr('data-title');
    drawer_left.drawer('hide')
    setTimeout(function(){
      $(target).page({
        title :title,
        start : start,
        url : url
      });
    }, 300);
  });

  if(navigator.userAgent.indexOf("Mac") > 0) {
    $("body").addClass("mac-os");
  }

  putCookieAlert('site_common_result') // 로그인/로그아웃 알림 메시지 출력

  $(document).on('tap','[data-toggle="changeModal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var type    = $this.attr('data-type')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, '')))
    var $start = $($this.closest('.modal'))
    if ($this.is('a')) e.preventDefault()
    $start.modal('hide').removeClass('active')
    setTimeout(function(){ $target.modal('show'); }, 100);
	});

	//modal 로그인 - 실행
	$('#modal-login').find('form').submit( function(e){
		e.preventDefault();
		e.stopPropagation();
		var form = $(this)
		siteLogin(form)
	});

	// modal 로그인이 닫혔을대
	$('#modal-login').on('hidden.rc.modal', function () {
	  $(this).find('input').removeClass('is-invalid') // 에러흔적 초기화
	})

	$("#modal-login").find('input').keyup(function() {
 	 $(this).removeClass('is-invalid') //에러 발생후 다시 입력 시도시에 에러 흔적 초기화
  });

  // 로그아웃
  $('[data-act="logout"]').tap(function(){
    history.back(); // 팝업닫기
    $.loader({ text: "잠시만 기다리세요..." });
    getIframeForAction('');
    setTimeout(function(){
      frames.__iframe_for_action__.location.href = '/?r=home&m=site&a=logout';
    }, 300);
  });

	// 드로어(사이드메뉴영역) 닫기
  $('body').on('tap click','[data-toggle="drawer-close"]',function(){
		drawer_left.drawer('hide')
    drawer_right.drawer('hide')
	});

	//검색 모달이 열렸을때
	$('#modal-search').on('shown.rc.modal', function () {
		setTimeout(function() {
			$('#search-input').val('').focus();
		}, 50);

		$('#search-input').autocomplete({
      lookup: function (query, done) {

         $.getJSON(rooturl+"/?m=tag&a=searchtag", {q: query}, function(res){
             var sg_tag = [];
             var data_arr = res.taglist.split(',');//console.log(data.usernames);
             $.each(data_arr,function(key,tag){
                 var tagData = tag.split('|');
                 var keyword = tagData[0];
                 var hit = tagData[1];
                 sg_tag.push({"value":keyword,"data":hit});
             });
             var result = {
                 suggestions: sg_tag
             };
              done(result);
         });
     },
        onSelect: function (suggestion) {
					if ($('#search-input').val().length >= 1) {
			      $( "#modal-search-form" ).submit();
			    }
        }
    });
	})

	// 검색버튼과 검색어 초기화 버튼 동적 출력
  $('#search-input').on('keyup', function(event) {
    var modal = $('#modal-search')
    modal.find('[data-role="keyword-reset"]').addClass("hidden"); // 검색어 초기화 버튼 숨김
    modal.find("#drawer-search-footer").addClass('hidden') //검색풋터(검색버튼 포함) 숨김
    if ($(this).val().length >= 2) {
      modal.find('[data-role="keyword-reset"]').removeClass("hidden");
    }
  });

	// 검색어 입력필드 초기화
  $('body').on('tap click','[data-act="keyword-reset"]',function(){
    var modal = $('#modal-search')
    modal.find("#search-input").val('').autocomplete('clear'); // 입력필드 초기화
    setTimeout(function(){
      modal.find("#search-input").focus(); // 입력필드 포커싱
      modal.find('[data-role="keyword-reset"]').addClass("hidden"); // 검색어 초기화 버튼 숨김
    }, 10);
  });

  // 바로가기
  $(document).on('tap','[data-toggle="move"]',function(event){
    var button =  $(this);
    var target =  button.attr('data-target');
    var page = button.attr('data-page')?button.attr('data-page'):'body'; // 컨테이너
    var top = $(target).offset().top;  // 타켓의 위치값
    var bar_height = $(page).find('.bar-nav').height();  // bar-nav의 높이값
    $(page).find('.content').animate({ scrollTop: (top-bar_height)-15 }, 300);
  });

	// 검색모달이 닫혔을때
  $('#modal-search').on('hidden.rc.modal', function () {
		var modal = $(this)
    $('#search-input').autocomplete('clear');
		$('.autocomplete-suggestions').remove();
    modal.find('[data-role="keyword-reset"]').addClass("hidden"); // 검색어 초기화 버튼 숨김'
  })

	//외부서비스 사용자 인증요청
  $('body').on('tap click','[data-connect]',function(){
    var provider = $(this).data('connect')

		// /core/engine/cssjs.engine.php 참고
		if (provider=='naver') var target = connect_naver
		if (provider=='kakao') var target = connect_kakao
		if (provider=='google') var target = connect_google
		if (provider=='facebook') var target = connect_facebook
		if (provider=='instagram') var target = connect_instagram
    var referer = window.location.href  // 연결후, 원래 페이지 복귀를 위해

    $(".content").loader({
      text:       "연결 중...",
      position:   "overlay"
    });

    $.post(rooturl+'/?r='+raccount+'&m=connect&a=save_referer',{
    	referer : referer
  		},function(response,status){

        if(status=='success'){
          setTimeout(function() {
  					$(".content").loader("hide");
  		      document.location = target;
  		    }, 500);
        }else{
          alert(status);
        }
    });
	});

  // 페이지 이동
  $(document).on('tap','[data-href]',function(){
    var text = $(this).attr("data-text")?$(this).attr("data-text"):'이동중..';
    var url = $(this).attr("data-href");
    if ($(this).attr("data-toggle")=='drawer-close') {
      drawer_left.drawer('hide')
      drawer_right.drawer('hide')
      setTimeout(function(){
        $.loader({ text: text });
        location.href = url;
      }, 200);
    } else {
      $.loader({ text: text });
      location.href = url;
    }
  });


  //링크복사
  var clipboard = new ClipboardJS('[data-toggle="linkCopy"]');
  $(document).on('tap','[data-toggle="linkCopy"]',function(){
    setTimeout(function(){
      $.notify({message: '링크가 복사 되었습니다.'},{type: 'default'});
    }, 300);
  });

  $(document).on('click','[data-toggle="linkShare"]',function(){
    var ele = $(this)
    var sbj = ele.attr('data-subject'); // 버튼에서 제목 추출
    var desc = ele.attr('data-desc'); // 버튼에서 요약설명 추출
    var featured = ele.attr('data-featured');
    var link = ele.attr('data-link');
    var title = ele.attr('data-title')?ele.attr('data-title'):'링크 공유';
    var hback = ele.attr('data-hback');
    var entry = ele.attr('data-entry');
    var delay = 10;

    if (hback) {
      history.back();
      delay = 100;
    }
    setTimeout(function(){
      if (ios_Token) {  // iOS 네이티브앱 일 경우
        shareNative(sbj,link)
     } else if (navigator.share === undefined) {  //webshare.api가 지원되지 않는 환경

       popup_link_share.attr('data-link',link).attr('data-subject',sbj).attr('data-review',desc).attr('data-featured',featured).attr('data-entry',entry);
       setTimeout(function(){
         popup_link_share.popup({
            title : title
         })
       }, 300);

      } else {
        navigator.share({
            title: sbj,
            text: desc,
            url: link,
        })
        .then(() => console.log('성공적으로 공유되었습니다.'))
        .catch((error) => console.log('공유에러', error));
      }
    }, delay);
  });

});
