var memberForm = document.getElementById("memberForm");

var modal_settings_general =  $('#modal-settings-general'); // 계정설정 모달
var modal_settings_profile = $('#modal-settings-profile'); // 프로필 설정

var page_settings_main =  $('#page-settings-main'); // 설정메인
var page_settings_account =  $('#page-settings-account'); //회원계정
var page_settings_email =  $('#page-settings-email'); //이메일 관리
var page_settings_phone =  $('#page-settings-phone'); //휴대폰 관리
var page_settings_noti =  $('#page-settings-noti'); //알림설정
var page_settings_connect =  $('#page-settings-connect'); //연결계정
var page_settings_shipping =  $('#page-settings-shipping'); //배송지관리
var page_settings_name =  $('#page-settings-name'); //이름변경

var page_settings_profile = $('#page-settings-profile') //프로필 수정 메인
var page_settings_avatar = $('#page-settings-avatar') //아바타
var page_settings_cover = $('#page-settings-cover') //배경이미지
var page_settings_nic = $('#page-settings-nic') //닉네임
var page_settings_tel1 =  $('#page-settings-tel1'); //유선전화
var page_settings_bio =  $('#page-settings-bio'); //간단설명

function saveMemberInfo(mbruid,field) {
  var wrapper = settings.wrapper;
  var keyword=settings.keyword; // keyword

  $.post(rooturl+'/?r='+raccount+'&m=member&a=info_update',{
    sort : sort,
    keyword : keyword,
    recnum : recnum,
    p : currentPage,
    markup_file : markup_file,
    start : start
  },function(response,status){
    if(status=='success'){
      var result = $.parseJSON(response);
      var list=result.list;
      var num=result.num;

      wrapper.loader('hide');
      if (num) wrapper.html(list)
      else wrapper.html(none)


    } else {
      alert(status);
    }
  });

} // saveMemberInfo

modal_settings_general.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  modal.attr('data-mbruid','');
  $('#modal-post-view').find('[data-act="pauseVideo"]').click();  //유튜브 비디오 일시정지
})


page_settings_main.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

})

// 회원계정
page_settings_account.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  console.log('계정관리')

})

// 이메일 관리
page_settings_email.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  page.find('.content').loader({ position: 'inside' });

  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=member&a=get_emailList',{
    },function(response){
      var result = $.parseJSON(response);
      var error=result.error;
      var list=result.list;

      if (error) {
        history.back();
        setTimeout(function(){ $.notify({message: error},{type: 'default'}) }, 500);
      } else {
        page.find('.content').html(list)
      }

    })

  }, 300);

})


// 휴대폰 관리
page_settings_phone.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  page.find('.content').loader({ position: 'inside' });

  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=member&a=get_phoneList',{
    },function(response){
      var result = $.parseJSON(response);
      var error=result.error;
      var list=result.list;

      if (error) {
        history.back();
        setTimeout(function(){ $.notify({message: error},{type: 'default'}) }, 500);
      } else {
        page.find('.content').html(list)
      }

    })

  }, 300);

})

// 알림설정
page_settings_noti.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  console.log('알림설정')

})

// 연결계정
page_settings_connect.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  console.log('연결계정')

})

// 배송지관리
page_settings_shipping.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  page.find('.content').loader({ position: 'inside' });

  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=member&a=get_shippingList',{
    },function(response){
      var result = $.parseJSON(response);
      var error=result.error;
      var list=result.list;

      if (error) {
        history.back();
        setTimeout(function(){ $.notify({message: error},{type: 'default'}) }, 500);
      } else {
        page.find('.content').html(list)
      }

    })

  }, 300);

})

// 아바타 변경
page_settings_avatar.find(".js-avatar-img").tap(function() {
  $("#rb-upfile-avatar").click();
});
page_settings_avatar.find("#rb-upfile-avatar").change(function() {
  var f = document.MbrPhotoForm;
  getIframeForAction(f);
  setTimeout(function() {
    page_settings_avatar.find('.content').loader({
      text:       "업로드중...",
      position:   "overlay"
    });
  }, 300); //가상 키보드가 내려오는 시간동안 대기
  f.submit();
});

// 배경이미지 변경
page_settings_cover.find(".js-cover-img").tap(function() {
  $("#rb-upfile-cover").click();
});
page_settings_cover.find("#rb-upfile-cover").change(function() {
  var f = document.MbrCoverForm;
  getIframeForAction(f);
  setTimeout(function() {
    page_settings_cover.find('.content').loader({
      text:       "업로드중...",
      position:   "overlay"
    });
  }, 300); //가상 키보드가 내려오는 시간동안 대기
  f.submit();
});

// 이름변경
page_settings_name.on('shown.rc.page', function(event) {
  setTimeout(function() {
    page_settings_name.find('input').focus().putCursorAtEnd();
  }, 300);
})
page_settings_name.on('hidden.rc.page', function(event) {
  page_settings_name.find('input').blur()
})
page_settings_name.find('[data-act="submit"]').click(function(){
  var input =  page_settings_name.find('[name="name"]')
  var name = input.val()
  if (!name) {
    input.focus();
    return false
  }
  page_settings_profile.find('[data-role="name"]').removeClass('animated fadeIn');
  $('#memberForm').find('[name="name"]').val(name);
  setTimeout(function() {
    page_settings_name.find('.content').loader({
      text:       "변경중...",
      position:   "overlay"
    });
  }, 300); //가상 키보드가 내려오는 시간동안 대기
  setTimeout(function() {
    page_settings_name.find('.content').loader("hide");
    history.back();  // 메인 페이지로 복귀
    setTimeout(function() {
      getIframeForAction(memberForm);
      memberForm.submit();
      page_settings_profile.find('[data-role="name"]').text(name).addClass('animated fadeIn');
    }, 500); //페이지 전환효과 소요시간동안 대기
  }, 700);
});

// 닉네임(채널) 변경
page_settings_nic.on('shown.rc.page', function(event) {
  setTimeout(function() {
    page_settings_nic.find('input').focus().putCursorAtEnd();
  }, 300);
})
page_settings_nic.on('hidden.rc.page', function(event) {
  page_settings_nic.find('input').blur();
})
page_settings_nic.find('[data-act="submit"]').click(function(){
  var input =  page_settings_nic.find('[name="nic"]')
  var nic = input.val()
  if (!nic) {
    input.focus();
    return false
  }
  page_settings_profile.find('[data-role="nic"]').removeClass('animated fadeIn');
  $('#memberForm').find('[name="nic"]').val(nic);
  setTimeout(function() {
    page_settings_nic.find('.content').loader({
      text:       "변경중...",
      position:   "overlay"
    });
  }, 300); //가상 키보드가 내려오는 시간동안 대기
  setTimeout(function() {
    page_settings_nic.find('.content').loader("hide");
    history.back();  // 메인 페이지로 복귀
    setTimeout(function() {
      getIframeForAction(memberForm);
      memberForm.submit();
      page_settings_profile.find('[data-role="nic"]').text(nic).addClass('animated fadeIn');
    }, 500); //페이지 전환효과 소요시간동안 대기
  }, 700);
});


// 유선전화
page_settings_tel1.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

  console.log('유선전화')

})

// 간단설명
page_settings_bio.on('show.rc.page', function(event) {
  setTimeout(function() {
    page_settings_bio.find('textarea').focus().putCursorAtEnd();
  }, 300);
})
page_settings_bio.on('hidden.rc.page', function(event) {
  page_settings_bio.find('textarea').blur();
})
page_settings_bio.find('[data-act="submit"]').click(function(){
  var textarea =  page_settings_bio.find('[name="bio"]')
  var bio = textarea.val()
  if (!bio) {
    textarea.focus();
    return false
  }
  page_settings_profile.find('[data-role="bio"]').removeClass('animated fadeIn');
  $('#memberForm').find('[name="bio"]').val(bio);
  setTimeout(function() {
    page_settings_bio.find('.content').loader({
      text:       "변경중...",
      position:   "overlay"
    });
  }, 300); //가상 키보드가 내려오는 시간동안 대기
  setTimeout(function() {
    page_settings_bio.find('.content').loader("hide");
    history.back();  // 메인 페이지로 복귀
    setTimeout(function() {
      getIframeForAction(memberForm);
      memberForm.submit();
      page_settings_profile.find('[data-role="bio"]').text(bio).addClass('animated fadeIn');
    }, 500); //페이지 전환효과 소요시간동안 대기
  }, 700);

});
