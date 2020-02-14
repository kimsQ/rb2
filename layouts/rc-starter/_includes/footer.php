<footer class="footer">

  <nav class="nav mb-2">
    <a class="nav-link" href="#page-site-page" data-start="#page-main" data-toggle="page" data-title="이용약관" data-id="policy" data-type="page" data-url="<?php echo RW('mod=policy') ?>" href="<?php echo RW('mod=policy') ?>">이용약관</a>
    <span class="divider">|</span>
    <a class="nav-link"href="#page-site-page" data-start="#page-main" data-toggle="page" data-title="개인정보취급방침" data-id="privacy" data-type="page" data-url="<?php echo RW('mod=privacy') ?>">개인정보취급방침</a>
    <span class="divider">|</span>
    <a class="nav-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=pcmode">PC화면</a>
    <span class="divider">|</span>
    <a class="nav-link" data-toggle="fullscreen">전체화면</a>
  </nav>

  <p>© <?php echo $d['layout']['company_name']?$d['layout']['company_name']:'company' ?> <?php echo $date['year']?></p>

  <!-- 스탠다드 라이센스 없이는 아래 킴스큐 로고를 삭제할 수 없습니다. -->
  <a href="https://kimsq.com" target="_blank" class="text-reset"><i class="kf kf-bi-01 text-reset"></i></a>
</footer>
