<div class="card mb-3">
  <div class="card-header">
    설정하기
  </div>
  <div class="list-group list-group-flush">
    <a href="<?php echo RW('mod=settings&page=main')?>" class="list-group-item list-group-item-action<?php if($page=='main'):?> selected<?php endif?>">
      프로필 관리
    </a>
    <a href="<?php echo RW('mod=settings&page=account')?>" class="list-group-item list-group-item-action<?php if($page=='account'):?> selected<?php endif?>">
      회원계정 관리
    </a>
    <?php if ($d['member']['login_social']): ?>
    <a href="<?php echo RW('mod=settings&page=connect')?>" class="list-group-item list-group-item-action<?php if($page=='connect'):?> selected<?php endif?>">
      연결계정 관리
    </a>
    <?php endif; ?>
    <a href="<?php echo RW('mod=settings&page=email')?>" class="list-group-item list-group-item-action<?php if($page=='email'):?> selected<?php endif?>">
      이메일 관리
    </a>
    <a href="<?php echo RW('mod=settings&page=phone')?>" class="list-group-item list-group-item-action<?php if($page=='phone'):?> selected<?php endif?>">
      휴대폰 관리
    </a>
    <a href="<?php echo RW('mod=settings&page=shipping')?>" class="list-group-item list-group-item-action<?php if($page=='shipping'):?> selected<?php endif?>">
      배송지 관리
    </a>
    <a href="<?php echo RW('mod=settings&page=noti')?>" class="list-group-item list-group-item-action<?php if($page=='noti'):?> selected<?php endif?>">
      알림 설정
    </a>
    <?php if ($g['push_active']): ?>
    <a href="<?php echo RW('mod=settings&page=pwa')?>" class="d-none list-group-item list-group-item-action<?php if($page=='pwa'):?> selected<?php endif?>">
      웹앱 설치내역
    </a>
    <?php endif; ?>
  </div>
</div>
