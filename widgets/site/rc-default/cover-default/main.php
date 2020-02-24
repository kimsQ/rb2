<style>
.profile-card .bg_profile {
  position: relative;
  height: 9.375rem;
  background-position: 50% 50%;
  background-size: cover;
}
.profile-card .bg_profile:before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  height: 100%;
  background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,.3) 100%);
  background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,.3) 100%);
  background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,rgba(0,0,0,.3) 100%);
  content: '';
}
.profile-card main {
  padding-top:2.1rem;
  padding-bottom:2.1rem
}
.profile-card .nav-control {
  position: relative;
  display: table;
  overflow: hidden;
  font-size: .75rem;
  font-weight: 400;
  background-color: #eceeef;
  border: none;
  border-top: 0.0625rem solid #f0f0f0;
  border-radius: 0;
}
.profile-card .nav-control .nav-link {
  padding-top: .475rem;
  padding-bottom: .4375rem;
  border-left: none;
  background-color: #fff;
  font-size: 0.875rem;
  line-height: 1.9rem;
}
.profile-card .nav-control .nav-link.active {
  background-color: #fff;
  color: #333;
  font-weight: bold;
  border-bottom: 0.0625rem solid #000;
}
.profile-card .btn-circle-secondary {
  padding: 0;
  color: #373a3c;
  background-color: #fff;
  border-radius: 50%;
  height: 3.5rem;
  min-width: 3.5rem;
  width: 3.5rem;
  border: none;
  box-shadow : none
}
.profile-card .btn-circle-secondary i {
  background-color: #f7f7f7;
  border-radius: 100%;
  padding : .75rem;
  color: #555;
}
.profile-card .btn-circle-secondary small {
  margin-top: .6rem;
  display: block;
  font-size: 0.75rem
}
.profile-card .btn-circle-secondary:focus {
  outline: none
}
.profile-card .appicon {
  position: absolute;
  border-radius: 1.5rem;
  width:5rem;
  left:50%;
  margin-left:-2.5rem;
  bottom:-1.25rem
}
</style>

<section class="widget mt-0 border-top-0 border-bottom profile-card" data-role="siteCardFull">

  <div class="bg_profile" style="background-image: url('');background-color: #fff;">
    <img src="/_core/images/touch/homescreen-200x200.png" class="appicon" data-href="<?php echo RW(0)?>" data-text="새로고침">
  </div>

  <main class="text-xs-center">
    <h5><?php echo $wdgvar['title'] ?></h5>
    <small class="d-block mb-4 text-muted">
      <?php echo $wdgvar['subtitle']?$wdgvar['subtitle']:'사진, 동영상, 카드뷰 등 다양한 형태로 발행하는 브랜드 소식' ?>
    </small>

    <button type="button" class="btn btn-circle-secondary btn-sm">
      <i class="material-icons">share</i>
      <small>공유하기</small>
    </button>
    <a href="tel://<?php echo $d['layout']['contact_tel'] ?>" class="btn btn-circle-secondary btn-sm ml-4">
      <i class="material-icons">phone</i>
      <small>전화문의</small>
    </a>
    <button type="button" class="btn btn-circle-secondary btn-sm ml-4">
      <i class="material-icons">comment</i>
      <small>카톡상담</small>
    </button>
  </main>

  <?php if ($my['uid']): ?>
  <nav class="nav nav-control">
    
    <?php if ($d['post']['writeperm']): ?>
    <a class="nav-link" href="#popup-post-newPost"
      data-toggle="popup"
      data-start="<?php echo $wdgvar['start'] ?>"
      data-url="/post/write"
      data-title="새 포스트">
      포스트 작성
    </a>
    <?php endif; ?>

    <?php if ($d['layout']['company_name']): ?>
    <a class="nav-link" href="#page-site-info" data-toggle="page" data-start="#page-main">
      홈 정보 보기
    </a>
    <?php else: ?>
    <a class="nav-link" href="#" data-href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=settings&prelayout=rc-starter/blank' ?>">
      홈 정보 편집
    </a>
    <?php endif; ?>

  </nav>
  <?php endif; ?>

</section>
