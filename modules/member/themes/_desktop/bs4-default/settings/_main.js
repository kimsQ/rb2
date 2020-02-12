$(function () {

  $('[data-toggle="avatar"]').click(function() {
     $("#rb-upfile-avatar").click();
  });
  $("#rb-upfile-avatar").change(function() {
    var f = document.MbrPhotoForm;
    getIframeForAction(f);
    f.submit();
  });

  $('[data-toggle="cover"]').click(function() {
     $("#rb-upfile-cover").click();
  });
  $("#rb-upfile-cover").change(function() {
    var f = document.MbrCoverForm;
    getIframeForAction(f);
    f.submit();
  });


  //본인확인을 위한 로그인
  $('#page-confirmPW').submit(function(e){
    e.preventDefault();
    e.stopPropagation();
    var form = $(this)
    siteLogin(form)
  });

  //외부서비스 사용자 인증요청
  $('[data-reauth]').on("click", function(){
    var provider = $(this).data('reauth')
    // /core/engine/cssjs.engine.php 참고
    if (provider=='naver') var target = reauth_naver
    if (provider=='kakao') var target = reauth_kakao
    if (provider=='google') var target = reauth_google
    if (provider=='facebook') var target = reauth_facebook
    if (provider=='instagram') var target = reauth_instagram
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

  // 최근탭 고정처리
  var tab = Cookies.get('lock-nav');
  if (tab=='social') $('#tab-social').tab('show')
  else $('#tab-passwd').tab('show')

  $('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var button = $(e.target) // newly activated tab
    var id = button.attr('href')
    if (id=='#pane-passwd') Cookies.set('lock-nav', 'passwd');
    else	Cookies.set('lock-nav', 'social');
  })


  // 로그인 에러 흔적 초기화
  $("#page-confirmPW").find('.form-control').keyup(function() {
    $(this).removeClass('is-invalid')
  });



})
