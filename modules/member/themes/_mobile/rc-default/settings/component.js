var memberForm = document.getElementById("memberForm");

var modal_settings_general =  $('#modal-settings-general'); // 계정설정 모달
var modal_settings_profile = $('#modal-settings-profile'); // 프로필 설정

var page_settings_main =  $('#page-settings-main'); // 설정메인
var page_settings_account =  $('#page-settings-account'); //회원계정
var page_settings_pw = $('#page-settings-pw'); //비밀번호 변경
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

function pwChangeCheck(obj,layer) {
	var f = document.getElementById('pwChangeForm');
	if (!obj.value)
	{
		obj.classList.remove('is-invalid');
		layer.innerHTML = '';
	}
	else
	{
		if (obj.name == 'pw1') {
			f.classList.remove('was-validated');

			if (f.pw1.value.length < 6 || f.pw1.value.length > 16) {

				f.check_pw1.value = '0';
				f.classList.remove('was-validated');
				obj.classList.add('is-invalid');
				obj.classList.remove('is-valid');


				layer.innerHTML = '영문/숫자 2개 이상 조합 6~16자로 입력';
				obj.focus();
				return false;
			}
			if (getTypeCheck(f.pw1.value,"abcdefghijklmnopqrstuvwxyz")) {
				layer.innerHTML = '비밀번호가 영문만으로 입력되었습니다.\n영문/숫자 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
				obj.focus();
				return false;
			}
			if (getTypeCheck(f.pw1.value,"1234567890")) {
				layer.innerHTML = '비밀번호가 숫자만으로 입력되었습니다.\n영문/숫자 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
				obj.focus();
				return false;
			}
			f.pw1.classList.add('is-valid');
			f.pw1.classList.remove('is-invalid');
			layer.innerHTML = '';
			f.check_pw1.value = '1';
		}

		if (obj.name == 'pw2') {
			f.classList.remove('was-validated');
			obj.classList.add('is-invalid');
			obj.classList.remove('is-valid');

			if (f.pw1.value != f.pw2.value)
			{
				layer.innerHTML = '비밀번호가 일치하지 않습니다.';
				f.classList.remove('was-validated');
				obj.focus();
				f.check_pw2.value = '0';
				return false;
			}

			f.pw2.classList.add('is-valid');
			f.pw2.classList.remove('is-invalid');
			layer.innerHTML = '';

		 f.check_pw2.value = '1';
		}

	}
}

modal_settings_general.on('show.rc.modal', function(event) {
  var button = $(event.relatedTarget);
  var modal = $(this);
  modal.attr('data-mbruid','');
  $('#modal-post-view').find('[data-act="pauseVideo"]').click();  //유튜브 비디오 일시정지
  if ($('#drawer-left').length) {
    setTimeout(function(){ $('#drawer-left').drawer('hide'); }, 1000); // 왼쪽 드로워 닫기
  }
})

page_settings_main.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);

})

// 비밀번호 변경
page_settings_pw.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  page.find('[type="password"]').val('')
})


//비밀번호 유용성 체크
page_settings_pw.find('input').keyup(function(){
  var item = $(this).attr('data-role')
  var item_pw_check = page_settings_pw.find('#page-settings-pw [name=check_pw]').val()
  if (item =='pw1') {
    element = document.querySelector('#page-settings-pw [name="pw1"]');
    feedback = document.querySelector('#page-settings-pw [data-role="pw1CodeBlock"]');
    pwChangeCheck(element,feedback)
  }
  if (item =='pw2') {
    element = document.querySelector('#page-settings-pw [name="pw2"]');
    feedback = document.querySelector('#page-settings-pw [data-role="pw2CodeBlock"]');
    pwChangeCheck(element,feedback)
  }
});


page_settings_pw.find('[data-act="changePW"]').click(function(){
  var button = $(this)
  var page = page_settings_pw;
  var f = document.getElementById('pwChangeForm');
  button.attr('disabled',true);

  if (f.check_pw1.value == '0' || f.check_pw2.value == '0') {
    button.attr('disabled',false);
    return false;
  }

  page.find('.form-control').removeClass('is-invalid')  //에러이력 초기화

  setTimeout(function(){
    getIframeForAction(f);
    f.submit();
  }, 1000);
});

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
