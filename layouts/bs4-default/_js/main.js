/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.4 데스크탑 시작하기 레이아웃 스크립트 (bs4-starter)
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2019 redblock inc
 * --------------------------------------------------------------------------
 */

var noti_sort = 'uid';
var noti_orderby = 'desc';
var noti_recnum = '10';

$('[data-plugin="timeago"]').timeago();  // 상대시간 플러그인 초기화

// 사용자 액션에 대한 피드백 메시지 제공을 위해 액션 실행후 쿠키에 저장된 결과 메시지를 출력시키고 초기화 시킵니다.
putCookieAlert('site_common_result') // 실행결과 알림 메시지 출력

$(document).ready(function() {

	// navbar dropdown 로그인 - 실행
	$('#popover-loginform').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		var form = $(this)
		siteLogin(form)
	});

	// navbar dropdown 로그인 - 로그인 영역 내부 클릭시 dropdown 닫히지 않도록
	$(document).on('click', '#navbarPopoverLogin .dropdown-menu', function (e) {
		e.stopPropagation();
	});

	// navbar dropdown 로그인 - dropdown 열릴때
	$('#navbarPopoverLogin').on('shown.bs.dropdown', function () {
		$(this).find('[name=id]').focus()  // 아이디 focus
		$(this).find('.form-control').val('').removeClass('is-invalid')  //에러이력 초기화
	})
	$(document).on('keyup','#popover-loginform .form-control',function(){
		$(this).removeClass('is-invalid') //에러 흔적 초기화
	});

	// navbar dropdown 내알림보기 - dropdown 열릴때
	$('#navbarPopoverNoti').on('show.bs.dropdown', function () {
		var dropdown = $(this)
		var mobile = ''
		 $('.js-tooltip').tooltip('hide')
		 dropdown.attr('data-original-title','')
			dropdown.find('[data-role="noti-list"]').isLoading({
				text: "불러오는중...",
				position: "inside"
			});
		 $.post(rooturl+'/?r='+raccount+'&m=notification&a=get_notiList',{
				 sort: noti_sort,
				 orderby: noti_orderby,
				 recnum: noti_recnum,
				 callMod: 'unread'
			 },function(response){
				var result = $.parseJSON(response);
				var content=result.content;
				dropdown.find('[data-role="noti-list"]').html(content);
				dropdown.find('[data-plugin="timeago"]').timeago();
				dropdown.find('[data-role="noti-status"]').text('');
		 });
	})

	// navbar dropdown 알림보기 - dropdown 닫힐때
	$('#navbarPopoverNoti').on('hidden.bs.dropdown', function () {
		var dropdown = $(this)
	  dropdown.attr('data-original-title','알림')
		dropdown.find('[data-role="noti-list"]').html('');
	})

	//modal 로그인 - 실행
	$('#modal-login').find('form').submit(function(e){
		e.preventDefault();
		e.stopPropagation();
		var form = $(this)
		siteLogin(form)
	});

	// modal 로그인 - modal 열릴때
	$('#modal-login').on('shown.bs.modal', function () {
		$(this).find('[name=id]').focus() // 아이디 focus
		$(this).find('.form-control').val('').removeClass('is-invalid')  //에러 흔적 초기화
	})

 $("#modal-login").find('.form-control').keyup(function() {
	 $(this).removeClass('is-invalid') //에러 흔적 초기화
 });

//modal 변경
 $(document).on('click','[data-toggle="changeModal"]', function (e) {
	 var $this   = $(this)
	 var href    = $this.attr('href')
	 var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, '')))
   var $start = $($this.closest('.modal'))
	 if ($this.is('a')) e.preventDefault()
	 $start.modal('hide')
	 setTimeout(function(){ $target.modal({show:true,backdrop:'static'}); }, 300);
 });

	$('[data-toggle="tooltip"]').tooltip()  // 툴팁 플러그인 초기화
	$('.js-tooltip').tooltip();

  initPhotoSwipeFromDOM('[data-plugin="photoswipe"]'); // 포토갤러리 초기화

	//외부서비스 사용자 인증요청
	$('[data-connect]').on("click", function(){
		var provider = $(this).data('connect')

		// /core/engine/cssjs.engine.php 참고
		if (provider=='naver') var target = connect_naver
		if (provider=='kakao') var target = connect_kakao
		if (provider=='google') var target = connect_google
		if (provider=='facebook') var target = connect_facebook
		if (provider=='instagram') var target = connect_instagram
    var referer = window.location.href  // 연결후, 원래 페이지 복귀를 위해

    $("body").isLoading({
      text:       "연결 중..",
      position:   "overlay"
    });
    $.post(rooturl+'/?r='+raccount+'&m=connect&a=save_referer',{
    	referer : referer
  		},function(response,status){

        if(status=='success'){
          document.location = target;
        }else{
          alert(status);
        }
    });
	});

  // 로그아웃
  $('[data-act="logout"]').click(function(){
    $('body').isLoading({
      position: 'inside',
      text:   '<div class="d-flex justify-content-center align-items-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>',
    });
    getIframeForAction('');
    setTimeout(function(){
      frames.__iframe_for_action__.location.href = '/?r=home&m=site&a=logout';
    }, 100);
  });

  // history.back
  $(document).on('click','[data-history="back"]',function(){
    window.history.back();
  });

  $('[data-toggle="searchbox"]').click(function(){
    $('.header').toggleClass('searching')
    $('.header [data-role="searchbox"] input').val('').focus()

  });



})
