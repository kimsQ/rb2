<header class="bar bar-nav bar-dark bg-primary px-0">
  <a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
  <h1 class="title" data-location="reload">
    <i class="fa fa-user-plus fa-fw mr-1 text-muted" aria-hidden="true"></i> 연결계정 관리
  </h1>
</header>

<main class="content bg-faded">

  <ul class="table-view bg-white m-t-0 animated fadeIn delay-1">
    <?php if ($d['connect']['use_n']): ?>
    <li class="table-view-cell" style="padding-right: 6rem ">
      <img class="media-object pull-left rounded-circle <?php echo !$my_naver['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/naver.png" alt="네이버" width="28">
      <div class="media-body">
        네이버
        <?php if ($my_naver['uid']): ?>
        <p><?php echo getDateFormat($my_naver['d_regis'],'Y.m.d H:i') ?> 연결</p>
        <?php endif; ?>
      </div>
      <div data-toggle="switch" class="switch<?php echo $my_naver['uid']?' active':'' ?>" id="reception_sms">
        <div class="switch-handle"></div>
      </div>
    </li>
    <?php endif; ?>

    <?php if ($d['connect']['use_k']): ?>
    <li class="table-view-cell" style="padding-right: 6rem ">
      <img class="media-object pull-left rounded-circle<?php echo !$my_kakao['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/kakao.png" alt="카카오" width="28">
      <div class="media-body">
        카카오
        <?php if ($my_kakao['uid']): ?>
        <p><?php echo getDateFormat($my_kakao['d_regis'],'Y.m.d H:i') ?> 연결</p>
        <?php endif; ?>
      </div>
      <div data-toggle="switch" class="switch<?php echo $my_kakao['uid']?' active':'' ?>" id="reception_sms">
        <div class="switch-handle"></div>
      </div>
    </li>
    <?php endif; ?>

    <?php if ($d['connect']['use_g']): ?>
    <li class="table-view-cell" style="padding-right: 6rem ">
      <img class="media-object pull-left rounded-circle<?php echo !$my_google['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/google.png" alt="구글" width="28">
      <div class="media-body">
        구글
        <?php if ($my_google['uid']): ?>
        <p><?php echo getDateFormat($my_google['d_regis'],'Y.m.d H:i') ?> 연결</p>
        <?php endif; ?>
      </div>
      <div data-toggle="switch" class="switch<?php echo $my_google['uid']?' active':'' ?>" id="reception_sms">
        <div class="switch-handle"></div>
      </div>
    </li>
    <?php endif; ?>

    <?php if ($d['connect']['use_f']): ?>
    <li class="table-view-cell" style="padding-right: 6rem ">
      <img class="media-object pull-left rounded-circle<?php echo !$my_facebook['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/facebook.png" alt="페이스북" width="28">
      <div class="media-body">
        페이스북
        <?php if ($my_facebook['uid']): ?>
        <p><?php echo getDateFormat($my_facebook['d_regis'],'Y.m.d H:i') ?> 연결</p>
        <?php endif; ?>
      </div>
      <div data-toggle="switch" class="switch<?php echo $my_facebook['uid']?' active':'' ?>" id="reception_sms">
        <div class="switch-handle"></div>
      </div>
    </li>
    <?php endif; ?>

    <?php if ($d['connect']['use_i']): ?>
    <li class="table-view-cell" style="padding-right: 6rem ">
      <img class="media-object pull-left rounded-circle<?php echo !$my_instagram['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/instagram.png" alt="인스타그램" width="28">
      <div class="media-body">
        인스타그램
        <?php if ($my_instagram['uid']): ?>
        <p><?php echo getDateFormat($my_instagram['d_regis'],'Y.m.d H:i') ?> 연결</p>
        <?php endif; ?>
      </div>
      <div data-toggle="switch" class="switch<?php echo $my_instagram['uid']?' active':'' ?>" id="reception_sms">
        <div class="switch-handle"></div>
      </div>
    </li>
    <?php endif; ?>
  </ul>

  <div class="content-padded">
    <p class="text-muted">외부의 소셜미디어 계정을 연결하고 통합관리 합니다. 연결된 소셜미디어로 사용자인증 및 연결을 지원합니다.</p>
  </div>

</main>
