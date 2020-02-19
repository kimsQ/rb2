/**
 * --------------------------------------------------------------------------
 * kimsQ Rb v2.4.5 데스크탑 기본형 게시판 테마 스크립트 (bs4-default): _main.js
 * Homepage: http://www.kimsq.com
 * Licensed under RBL
 * Copyright 2020 redblock inc
 * --------------------------------------------------------------------------
 */


$(function () {

  // 사용자 액션에 대한 피드백 메시지 제공을 위해 액션 실행후 쿠키에 저장된 결과 메시지를 출력시키고 초기화 시킵니다.
  putCookieAlert('bbs_action_result') // 실행결과 알림 메시지 출력

  $('[data-toggle="print"]').click(function() {
    window.print()
  });

  $('[data-toggle="actionIframe"]').click(function() {
    getIframeForAction('');
    frames.__iframe_for_action__.location.href = $(this).attr("data-url");
  });

  //게시물 목록에서 프로필 풍선(popover) 띄우기
  $('[data-toggle="getMemberLayer"]').popover({
    container: 'body',
    trigger: 'manual',
    html: true,
    content: function () {
      var uid = $(this).attr('data-uid')
      var mbruid = $(this).attr('data-mbruid')
      var type = 'popover'
      $.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileData',{
         mbruid : mbruid,
         type : type
        },function(response){
         var result = $.parseJSON(response);
         var profile=result.profile;
         $('#popover-item-'+uid).html(profile);
       });
      return '<div id="popover-item-'+uid+'" class="p-1">불러오는 중...</div>';
    }
  })
  .on("mouseenter", function () {
    var _this = this;
    $(this).popover("show");
    $(".popover").on("mouseleave", function () {
      $(_this).popover('hide');
    });
  }).on("mouseleave", function () {
    var _this = this;
    setTimeout(function () {
      if (!$(".popover:hover").length) {
        $(_this).popover("hide");
      }
    }, 300);
  });

})
