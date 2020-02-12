<header class="bar bar-nav bar-light bg-white px-0" data-history="back">
  <a class="icon icon icon-close pull-right p-x-1" role="button"title="드로어닫기"></a>
  <h1 class="title">
    새 알림
    <?php if ($my['uid']): ?>
    <span class="badge badge-danger badge-inverted ml-2" data-role="noti-status"><?php echo $my['num_notice']==0?'':$my['num_notice']?></span>
    <?php endif; ?>
  </h1>
</header>

<?php if ($my['uid']): ?>
  <nav class="bar bar-tab bar-light bg-white">
    <a class="tab-item" role="button" href="<?php echo RW('mod=noti')?>">
      <span class="icon icon-list"></span>
      <span class="tab-label">전체알림</span>
    </a>
    <a class="tab-item" role="button" href="<?php echo $g['s'] ?>/?r=<?php echo $r ?>&mod=settings&page=noti">
      <span class="icon icon-gear"></span>
      <span class="tab-label">알림설정</span>
    </a>
  </nav>
</nav>
<?php endif; ?>

<div class="content bg-faded">

  <?php if ($my['uid']): ?>
  <ul class="table-view table-view-full my-0 bg-white" data-role="noti-list">
    <!-- 드러어가 열릴때, 여기에 알림정보를 받아옴 -->
  </ul>
  <?php else: ?>
  <p class="content-padded">

    <small class="text-muted">
      내 알림을 확인하기 위해서는 로그인이 필요합니다.
    </small>

    <button type="button" class="btn btn-secondary btn-block mt-3" data-toggle="modal" data-target="#modal-login">
      로그인 하기
    </button>
  </p>

  <?php endif; ?>



</div>
