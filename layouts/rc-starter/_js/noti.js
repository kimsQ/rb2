/**
 * --------------------------------------------------------------------------
 * FCM(Firebase 클라우드 메시징)을 활용한 포그라운드 알림 처리 (모바일 전용)
 * 참조코드 : https://github.com/firebase/quickstart-js/tree/master/messaging
 * Licensed under an Apache-2 license.
 * Firebase Quickstart Samples for Web https://firebase.google.com
 * --------------------------------------------------------------------------
 */

firebase.initializeApp({'messagingSenderId': fcmSenderId});

const messaging = firebase.messaging();

messaging.usePublicVapidKey(fcmVAPID); //FCM 웹 푸시 인증서 키쌍(VAPID)

const permissionDivId = 'permission_div';
const permissionAlertId = 'permission_alert';
const tokenDivId = 'token_div';
const pushSettingId = 'push_setting';
const pushDisabledId = 'push_disabled';
const popupNoti = $('#popup-noti');

if (isNewUser(memberid)) {
  console.log('새 사용자로 로그인 되었습니다.')
  deleteToken() // 기존 토큰 삭제
  window.localStorage.clear(); // 로컬 스토리지 초기화
}

// 인스턴스 ID 토큰이 업데이트되면 콜백이 시작됩니다.
messaging.onTokenRefresh(function() {
  messaging.getToken().then(function(refreshedToken) {
    console.log('토큰이 새로고침 되었습니다.'); // 새 인스턴스 ID 토큰이 아직 전송되지 않았 음을 나타냅니다.
    setTokenSentToServer(false);
    sendTokenToServer(refreshedToken); // 인스턴스 ID 토큰을 앱 서버로 전송합니다.
    resetNotiUI(); // 새로운 인스턴스 ID 토큰을 표시하고 모든 이전 메시지의 UI를 지웁니다.
  }).catch(function(err) {
    console.log('새로 변경된 토큰을 검색 할 수 없습니다. ', err);
  });
});

// - 앱에 포커스가 있는 동안 메시지가 수신됩니다.
messaging.onMessage(function(payload) {
  console.log('메시지가 도착했습니다. ', payload);

  var result = JSON.stringify(payload, null, 2);
  var msg = JSON.parse(result);
  var title=msg.notification.title;
  var mbody=msg.notification.body;
  var icon=msg.notification.icon;
  var _mbody = mbody.replace(/(\n|\r\n)/g, '<br>');
  var noti_badge  = $('[data-role="noti-status"]')

  $.post(rooturl+'/?r='+raccount+'&m=notification&a=get_notiNum_ajax',function(response){
     var result = $.parseJSON(response);
     var noti_badge_num=result.num;
     noti_badge.text(noti_badge_num)
  });

  $.notify({
    icon: icon,
    title: title,
    message: mbody
  }, {
    type: 'media',
    delay: 3000,
    icon_type: 'image',
    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
      '<img data-notify="icon" class="img-circle pull-left">' +
      '<span data-notify="title">{1}</span>' +
      '<span data-notify="message">{2}</span>' +
      '</div>'
  });


});

function resetNotiUI() {
  clearMessages();
  showToken('처리중...');
  setMemberId(memberid)  // 로그인 사용자의 아이디를 로컬 스토리지에 저장

  // Get Instance ID token. Initially this makes a network call, once retrieved
  // subsequent calls to getToken will return from cache. 이후의 getToken의 호출은 캐쉬로부터 돌아옵니다.
  messaging.getToken().then(function(currentToken) {
    if (currentToken) {
      sendTokenToServer(currentToken);
      updateUIForPushEnabled(currentToken);
    } else {

      if (!isRequestPermission()) {
        setRequestPermission(false)
      }
      console.log('사용할수 있는 인스턴스 ID 토큰이 없습니다. 알림권한을 요청하십시오.');
      setTimeout(function(){
        updateUIForPushPermissionRequired();  // 알림권한요청 UI 를 보여줌.
      }, 1000);
      setTokenSentToServer(false);
    }
  }).catch(function(err) {
    console.log('알림권한이 없거나 토큰을 검색하는 중 오류가 발생했습니다. ', err);
    updateUIForPushDisabled()
    setRequestPermission(false)
  });
}

function showToken(currentToken) {
  // 콘솔과 페이지에서 토큰을 보여줌
  var tokenElement = document.querySelector('.token');
  if (tokenElement) {
    tokenElement.textContent = currentToken;
  }
}


// Rb2에 인스턴스 ID 토큰을 보내세요.:
// - 이 앱으로 메시지를 다시 보내세요.
// - 주제 토큰 구독 / 탈퇴
function sendTokenToServer(currentToken) {
  if (!isTokenSentToServer()) {
    console.log('Rb2 서버에 토큰 보내기 중 ...');

    var agent = navigator.userAgent, match;
    var browser, version;

    if((match = agent.match(/MSIE ([0-9]+)/)) || (match = agent.match(/Trident.*rv:([0-9]+)/))) browser = 'Internet Explorer';
    else if(match = agent.match(/Chrome\/([0-9]+)/)) browser = 'Chrome';
    else if(match = agent.match(/Firefox\/([0-9]+)/)) browser = 'Firefox';
    else if(match = agent.match(/Safari\/([0-9]+)/)) browser = 'Safari';
    else if((match = agent.match(/OPR\/([0-9]+)/)) || (match = agent.match(/Opera\/([0-9]+)/))) browser = 'Opera';
    else browser = 'Unknown';

    if(browser !== 'Unknown') version = match[1];

    $.post(rooturl+'/?r='+raccount+'&m=notification&a=save_token',{
        browser : browser,
        version : version,
        token : currentToken
      },function(response){
       var result = $.parseJSON(response);
      console.log('토큰이 저장되었습니다.' + currentToken)
    });
    setTokenSentToServer(true);
  } else {
    console.log('토큰이 이미 서버에 전송 되었으므로 토큰이 변경되지 않는한 재전송되지 않습니다.');
  }
}

function isTokenSentToServer() {
  return window.localStorage.getItem('sentToServer') == 1;
}

function setTokenSentToServer(sent) {
  window.localStorage.setItem('sentToServer', sent ? 1 : 0);
}

function isRequestPermission() {
  return window.localStorage.getItem('setRequestPermission') == 1;
}

function setRequestPermission(allow) {
  window.localStorage.setItem('setRequestPermission', allow ? 1 : 0);
}

function isNewUser(memberid) {
  return window.localStorage.getItem('setMemberId') != memberid;
}

function setMemberId(memberid) {
  window.localStorage.setItem('setMemberId', memberid ? memberid : 0);
}

function showHideDiv(divId, show) {
  const div = document.querySelector('#' + divId);

  if (div) {
    if (show) {
      div.style = 'display: visible';
    } else {
      div.style = 'display: none';
    }
  }
}

function showHideSheet(divId, show) {
  const sheet = $('#' + divId);
  if (sheet) {
    if (show) {
      sheet.sheet('show')
    } else {
      // sheet.sheet('hide')
    }
  }
}

function showHidePopup(divId, show) {
  const popup = $('#' + divId);
  if (popup) {
    if (show) {
      popup.popup('show')
    } else {
      // popup.popup('hide')
    }
  }
}

function requestPermission() {
  console.log('권한 요청 중 ...');
  messaging.requestPermission().then(function() {
    var nt_web = '';  //알림수신
    var nt_fcm = '1'; //푸시 알림수신
    console.log('알림권한이 부여 되었습니다.');
    showHideSheet(permissionAlertId, false);
    setTimeout(function(){ $.notify({message: '알림권한이 부여 되었습니다.'}); }, 500);
    resetNotiUI();

    $.post(rooturl+'/?r='+raccount+'&m=notification&a=notice_config_user',{
       mobile : true,
       sendAjax : true,
       nt_web : nt_web,
       nt_email : nt_email,
       nt_fcm : nt_fcm
      },function(response){
       var result = $.parseJSON(response);
       var error=result.error;
       if (!error) console.log('웹알림/푸시알림 수신처리 되었습니다.')
    });

  }).catch(function(err) {
    var nt_fcm = '';
    showHidePopup(permissionAlertId, false);
    showHideDiv(permissionDivId, false);
    showHideDiv(pushDisabledId, true);
    console.log('알림을 실행 할수있는 권한이 없습니다.', err);
    $.notify({message: '알림 권한이 차단 되었습니다.'},{type: 'danger'});
  });
}

function deleteToken() {
  // 인스턴스 ID 토큰 삭제.
  // [START delete_token]
  messaging.getToken().then(function(currentToken) {
    messaging.deleteToken(currentToken).then(function() {
      console.log('토큰이 삭제 되었습니다.');
      setTokenSentToServer(false);
      // [START_EXCLUDE]
      // 토큰이 삭제되면 관련 UI를 업데이트 합니다..
      resetNotiUI();
      // [END_EXCLUDE]
    }).catch(function(err) {
      console.log('토큰을 삭제할 수 없습니다. ', err);
    });
    // [END delete_token]
  }).catch(function(err) {
    console.log('인스턴스 ID 토큰을 가져 오는 중 오류가 발생했습니다. ', err);
  });
}

// 메시지 내용을 초기화 합니다.
function clearMessages() {}

function updateUIForPushEnabled(currentToken) {
  $('#'+permissionAlertId).removeClass('active')
  $('.backdrop').remove()
  showHideDiv(tokenDivId, true);
  showHideDiv(pushSettingId, true);
  showHideDiv(permissionDivId, false);
  showToken(currentToken);
}

function updateUIForPushDisabled() {
  showHideDiv(pushDisabledId, true);
  showHideDiv(pushSettingId, false);
  showHidePopup(permissionAlertId, false);
}

function updateUIForPushPermissionRequired() {
  if (!isRequestPermission()) {
    console.log('브라우저 알림 권한요청 이력이 없음')
    if (!nt_web) {
      setTimeout(function(){ showHideSheet(permissionAlertId, true); }, 2000);
    } else {
      console.log('사용자의 모든 알림수신을 차단하였습니다.')
    }
  } else {
    console.log('브라우저 알림 권한요청 이력이 있음')
    showHideDiv(permissionDivId, true);
  }
}

//알림권한 요청 sheet가 닫혔을때(나중에 설정)
$('#permission_alert').on('hidden.rc.sheet', function () {
  setRequestPermission(true)  // 요청이력을 로컬 스토리지에 저장하여 이후에 띄우지 않음
  showHideDiv(permissionDivId, true);
})

resetNotiUI();
