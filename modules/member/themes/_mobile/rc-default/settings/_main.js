$(function() {

  var f = document.getElementById("memberForm");
  var page_main = $('#page-main')
  var page_profile = $('#page-profile')
  var page_name = $('#page-name')
  var page_tel1 = $('#page-tel1')
  var page_tel2 = $('#page-tel2')
  var page_birth = $('#page-birth')
  var page_sex = $('#page-sex')
  var page_addr = $('#page-addr')
  var page_bio = $('#page-bio')
  var page_home = $('#page-home')
  var page_job = $('#page-job')
  var page_marr = $('#page-marr')

  function _submit() {
    getIframeForAction(f);
    f.submit();
  }

  $(".js-avatar-img").tap(function() {
    $("#rb-upfile-avatar").click();
  });
  $("#rb-upfile-avatar").change(function() {
    var f = document.MbrPhotoForm;
    getIframeForAction(f);
    setTimeout(function() {
      page_profile.find('.content').loader({
        text:       "업로드중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기
    f.submit();
  });


  $(".js-btn-action-iframe").click(function() {
    getIframeForAction('');
    frames.__iframe_for_action__.location.href = $(this).attr("data-href");
  });

  $('#reception_sms').on('changed.rc.switch', function (event) {
    var handle = $(event.relatedTarget)
    var button = handle.closest('.switch')
    if (button.hasClass('active')){
      console.log('문자 수신설정 되었습니다.')
      page_main.find('[name="sms"]').val(1);
    } else {
      console.log('문자 수신해제 되었습니다.')
      page_main.find('[name="sms"]').val(0);
    }
    _submit() // submit 실행
  })

  $('#reception_email').on('changed.rc.switch', function (event) {
    var handle = $(event.relatedTarget)
    var button = handle.closest('.switch')
    if (button.hasClass('active')){
      console.log('이메일 수신설정 되었습니다.')
      page_main.find('[name="remail"]').val(1);
    } else {
      console.log('이메일 수신해제 되었습니다.')
      page_main.find('[name="remail"]').val(0);
    }
    _submit() // submit 실행
  })

  // 닉네임 시작
  page_profile.find('.js-save').tap(function() {
    var nic = page_profile.find('[name="nic"]').val()
    page_main.find('[data-role="nic"]').removeClass('animated fadeIn');
    page_main.find('[name="nic"]').val(nic);

    setTimeout(function() {
      page_profile.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_profile.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="nic"]').text(nic).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 이름변경 시작
  page_name.find('.js-save').tap(function() {
    var name = page_name.find('[name="name"]').val()
    page_main.find('[data-role="name"]').removeClass('animated fadeIn');
    page_main.find('[name="name"]').val(name);

    setTimeout(function() {
      page_name.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_name.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="name"]').text(name).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 유선전화 시작
  page_tel1.find('.js-save').tap(function() {
    var tel1_1 = page_tel1.find('[name="tel1_1"]').val()
    var tel1_2 = page_tel1.find('[name="tel1_2"]').val()
    var tel1_3 = page_tel1.find('[name="tel1_3"]').val()
    var tel1 = tel1_1+'-'+tel1_2+'-'+tel1_3
    page_main.find('[data-role="tel1"]').removeClass('animated fadeIn');
    page_main.find('[name="tel1_1"]').val(tel1_1);
    page_main.find('[name="tel1_2"]').val(tel1_2);
    page_main.find('[name="tel1_3"]').val(tel1_3);

    setTimeout(function() {
      page_tel1.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_tel1.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="tel1"]').text(tel1).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 휴대전화 시작
  page_tel2.find('.js-save').tap(function() {
    var tel2_1 = page_tel2.find('[name="tel2_1"]').val()
    var tel2_2 = page_tel2.find('[name="tel2_2"]').val()
    var tel2_3 = page_tel2.find('[name="tel2_3"]').val()
    var tel2 = tel2_1+'-'+tel2_2+'-'+tel2_3
    page_main.find('[data-role="tel2"]').removeClass('animated fadeIn');
    page_main.find('[name="tel2_1"]').val(tel2_1);
    page_main.find('[name="tel2_2"]').val(tel2_2);
    page_main.find('[name="tel2_3"]').val(tel2_3);

    setTimeout(function() {
      page_tel2.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_tel2.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="tel2"]').text(tel2).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 생년월일 시작
  page_birth.find('.js-save').tap(function() {
    var birth_1 = page_birth.find('[name="birth_1"]').val()
    var birth_2 = page_birth.find('[name="birth_2"]').val()
    var birth_3 = page_birth.find('[name="birth_3"]').val()
    var birthtype = page_birth.find('[name="birthtype"]:checked').val()
    var birth = birth_1+'.'+birth_2+'.'+birth_3
    page_main.find('[data-role="birth"]').removeClass('animated fadeIn');
    page_main.find('[name="birth_1"]').val(birth_1);
    page_main.find('[name="birth_2"]').val(birth_2);
    page_main.find('[name="birth_3"]').val(birth_3);
    page_main.find('[name="birthtype"]').val(birthtype);

    setTimeout(function() {
      page_birth.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_birth.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="birth"]').text(birth).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 성별 시작
  page_sex.find('.js-save').tap(function() {
    var sex = page_sex.find('[name="sex"]:checked').val()
    page_main.find('[data-role="sex"]').removeClass('animated fadeIn');
    page_main.find('[name="sex"]').val(sex);

    setTimeout(function() {
      page_sex.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_sex.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        if (sex==1) page_main.find('[data-role="sex"]').text('남성').addClass('animated fadeIn');
        if (sex==2) page_main.find('[data-role="sex"]').text('여성').addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 주소 시작
  page_addr.find('.js-save').tap(function() {
    var zip = page_addr.find('[name="zip"]').val()
    var addr1 = page_addr.find('[name="addr1"]').val()
    var addr2 = page_addr.find('[name="addr2"]').val()
    page_main.find('[data-role="addr1"]').removeClass('animated fadeIn');
    page_main.find('[name="zip"]').val(zip);
    page_main.find('[name="addr1"]').val(addr1);
    page_main.find('[name="addr2"]').val(addr2);

    setTimeout(function() {
      page_addr.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_addr.find('.content').loader("hide");
      _submit() // submit 실행
      page_main.find('[data-role="addr1"]').text(addr1).addClass('animated fadeIn');
      page_main.find('[data-role="addr"]').text('');
    }, 700);
  });

  // 간단설명 시작
  page_bio.find('.js-save').tap(function() {
    var bio = page_bio.find('[name="bio"]').val()
    page_main.find('[data-role="bio"]').removeClass('animated fadeIn');
    page_main.find('[name="bio"]').val(bio);

    setTimeout(function() {
      page_bio.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_bio.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="bio"]').text(bio).addClass('animated fadeIn');
        page_main.find('[data-role="_bio"]').text('').addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 홈페이지 변경 시작
  page_home.find('.js-save').tap(function() {
    var home = page_home.find('[name="home"]').val()
    page_main.find('[data-role="home"]').removeClass('animated fadeIn');
    page_main.find('[name="home"]').val(home);

    setTimeout(function() {
      page_home.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_home.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="home"]').text(home).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 직업 변경 시작
  page_job.find('.js-save').tap(function() {
    var job = page_job.find('[name="job"]').val()
    page_main.find('[data-role="job"]').removeClass('animated fadeIn');
    page_main.find('[name="job"]').val(job);

    setTimeout(function() {
      page_job.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_job.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="job"]').text(job).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });

  // 결혼기념일 시작
  page_marr.find('.js-save').tap(function() {
    var marr_1 = page_marr.find('[name="marr_1"]').val()
    var marr_2 = page_marr.find('[name="marr_2"]').val()
    var marr_3 = page_marr.find('[name="marr_3"]').val()
    var marr = marr_1+'.'+marr_2+'.'+marr_3
    page_main.find('[data-role="marr"]').removeClass('animated fadeIn');
    page_main.find('[name="marr_1"]').val(marr_1);
    page_main.find('[name="marr_2"]').val(marr_2);
    page_main.find('[name="marr_3"]').val(marr_3);

    setTimeout(function() {
      page_marr.find('.content').loader({
        text:       "변경중...",
        position:   "overlay"
      });
    }, 300); //가상 키보드가 내려오는 시간동안 대기

    setTimeout(function() {
      page_marr.find('.content').loader("hide");
      window.history.back();  // 메인 페이지로 복귀
      setTimeout(function() {
        _submit() // submit 실행
        page_main.find('[data-role="marr"]').text(marr).addClass('animated fadeIn');
      }, 500); //페이지 전환효과 소요시간동안 대기
    }, 700);
  });


  $(document).on('click','#execDaumPostcode',function(){

    // 우편번호 찾기 화면을 넣을 element
    var element_wrap = document.getElementById('postLayer');

    function execDaumPostcode() {
      daum.postcode.load(function(){
        new daum.Postcode({
             oncomplete: function(data) {
               // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
               // 각 주소의 노출 규칙에 따라 주소를 조합한다.
               // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
               var fullAddr = data.address; // 최종 주소 변수
               var extraAddr = ''; // 조합형 주소 변수

               // 기본 주소가 도로명 타입일때 조합한다.
               if(data.addressType === 'R'){
                   //법정동명이 있을 경우 추가한다.
                   if(data.bname !== ''){
                       extraAddr += data.bname;
                   }
                   // 건물명이 있을 경우 추가한다.
                   if(data.buildingName !== ''){
                       extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                   }
                   // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                   fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
               }

               // 우편번호와 주소 정보를 해당 필드에 넣는다.
               document.getElementById('zip1').value = data.zonecode; //5자리 새우편번호 사용
               document.getElementById('addr1').value = fullAddr;
               $('#modal-DaumPostcode').removeClass('active')  // 우편번호 검색모달을 숨김
             },

             // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
             width : '100%',
             height : '100%'
         }).embed(element_wrap);
        });
         // element_wrap.style.display = 'block';

        $('#modal-DaumPostcode').modal('show')
    }
    execDaumPostcode()

  })


});
