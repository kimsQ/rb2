//FCM 메시지 수신
firebase.initializeApp({
  'messagingSenderId': fcmSenderId  //FCM 발신자 ID
});

console.log('FCM 초기화됨')
const messaging = firebase.messaging();


// 백그라운드에서 받은 알림 설정(웹 앱이 닫혀 있거나 브라우저 포커스가 아님)
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('서비스워커 에서 백그라우드 메시지를 받았습니다. ', payload);

  var data;
  data = payload.data.json();

  var notificationTitle = data.title;
  var notificationOptions = {
    body: data.body,
    icon: icon,  //푸시알림 아이콘
    requireInteraction: true  //사용자가 알림을 닫거나 클릭하기 전까지 알림표시(데스크탑 전용옵션)
  };

  return self.registration.showNotification('requireInteraction: true',notificationTitle,
    notificationOptions);
});
