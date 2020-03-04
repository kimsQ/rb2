<!-- 알림수신을 위한 권한요청 (권한이 설정되지 않은 경우만 표시) -->
<div class="alert alert-light mb-0 rounded-0" role="alert" id="permission_alert" style="display: none">
  <div class="d-flex justify-content-between">
    <p class="f13 mb-0">
      <i class="fa fa-bell fa-fw text-primary" aria-hidden="true"></i> 데스크탑 푸시알림을 수신하면 공지사항은 물론 회원님이 게시글에 대한 피드백 또는 내가 언급된 글에 대한 정보들을 실시간으로 받아보실 수 있습니다.
      <a href="#" class="alert-link" onclick="requestPermission()"><u>권한 설정</u></a>
    </p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" title="나중에 하기">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
