<?php
if ($my['uid'] && $d['layout']['main_dashboard']=='true') getLink('/dashboard','','','');

if ($d['layout']['main_type']=='postFeed') {
  getWidget('post/rc-post-all-scroll',array('wrapper'=>'[data-role="postFeed"].widget','start'=>'#page-main','recnum'=>5));
} else {

  $g['layoutPageVForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.main.php';   // 레이아웃 메인페이지 웨젯설정
  include is_file($g['layoutPageVForSite']) ? $g['layoutPageVForSite'] : $g['dir_layout'].'_var/_var.main.php';
  getWidgetList($d['layout']['main_widgets']);

}
?>



<div class="swiper-container" id="main--event">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <a href="#page-shop-category2" data-start="#page-main" data-toggle="page" data-title="풍성한 상차림" data-index="0" data-parent="2" data-category="2">
        <img src="/thumb-ssl/640x360/u/i.ytimg.com/vi/7DFwLa-dyVk/maxresdefault_live.jpg" alt="" class="img-fluid">
      </a>
    </div>
    <div class="swiper-slide">
      <a href="#"><img src="/files/mobile-main-03.jpg" alt="" class="img-fluid"></a>
    </div>
    <div class="swiper-slide">
      <a href="#"><img src="/files/mobile-main-04.jpg" alt="" class="img-fluid"></a>
    </div>
    <div class="swiper-slide">
      <a href="#"><img src="/files/mobile-main-05.jpg" alt="" class="img-fluid"></a>
    </div>
    <div class="swiper-slide">
      <a href="#"><img src="/files/mobile-main-06.jpg" alt="" class="img-fluid"></a>
    </div>
    <div class="swiper-slide">
      <a href="#"><img src="/files/mobile-main-07.jpg" alt="" class="img-fluid"></a>
    </div>
  </div>
  <!-- Add Pagination -->
  <div class="swiper-pagination">
  </div>
</div>


<section class="content-padded mt-3 mb-4 widget">
  <header class="mb-1">
    <h3>추천 스토리</h3>
    <a href="#" data-act="swiperMainTo" data-index="3">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
  </header>
  <div class="row">
    <div class="col-xs-6">
      <a href="#page-post-view"
        data-toggle="page"
        data-start="#page-main"
        data-uid=""
        data-url="/post/0000000"
        data-src="/files/tmp/review-01_600x600.jpg"
        data-title="궁이 보이는 집, 어느 신혼부부의 평온한 한옥라이프">
        <img src="/thumb-ssl/640x360/u/i.ytimg.com/vi/E-nve-V7GGQ/maxresdefault_live.jpg" class="img-fluid" alt="">
        <div class="widget-title mt-2">
          궁이 보이는 집, 어느 신혼부부의 평온한 한옥라이프
        </div>
      </a>
    </div>
    <div class="col-xs-6">
      <a href="#page-post-view"
        data-toggle="page"
        data-start="#page-main"
        data-uid=""
        data-url="/post/0000000"
        data-src="/files/tmp/review-02_600x600.jpg"
        data-category="온라인 집들이"
        data-title="특별한 거실 인테리어 팁! with 데스커">
        <img src="/thumb-ssl/320x180/u/i.ytimg.com/vi/6Lhm65YCD7Q/mqdefault.jpg" class="img-fluid" alt="">
        <div class="widget-title mt-2">
          특별한 거실 인테리어 팁! with 데스커
        </div>
      </a>
    </div>
    <div class="col-xs-6">
      <a href="#page-post-view-video"
        data-toggle="page"
        data-start="#page-main"
        data-uid=""
        data-url="/post/0000000"
        data-src="t1u1tH-WaLg"
        data-title="식물과 함께하는 온기(溫氣) 넘치는 신혼집">
        <div class="position-relative">
          <img src="/thumb-ssl/320x180/u/i.ytimg.com/vi/7DFwLa-dyVk/maxresdefault_live.jpg" class="img-fluid" alt="">
          <span class="badge badge-default position-absolute card-meta card-meta-time">3:52</span>
        </div>
        <div class="widget-title mt-2">
          식물과 함께하는 온기(溫氣) 넘치는 신혼집
        </div>

      </a>
    </div>
    <div class="col-xs-6">
      <a href="#page-post-view-video"
        data-toggle="page"
        data-start="#page-main"
        data-uid=""
        data-url="/post/0000000"
        data-src="4DzBFe91CZs"
        data-title="[맘&앙팡] 제3회 엄마꿈틀 마켓 1편">
        <div class="position-relative">
          <img src="/thumb-ssl/320x180/u/i.vimeocdn.com/video/836550173_295x166.jpg" class="img-fluid" alt="">
          <span class="badge badge-default position-absolute card-meta card-meta-time">2:30</span>
        </div>
        <div class="widget-title mt-2">
          [맘&앙팡] 제3회 엄마꿈틀 마켓 1편
        </div>
      </a>
    </div>
  </div>
</section>

<section class="mt-4">
  <a href="#page-site-page" data-start="#page-main" data-toggle="page" data-title="배송안내" data-id="delivery" data-type="page" data-url="<?php echo RW('mod=delivery')?>">
    <img src="/files/mobile-banner-01.png" alt="" class="img-fluid">
  </a>
</section>

<section class="ad_section mt-5 border-top bg-light" style="background-image: url(/files/banner-02.png);">
  <div class="container text-xs-center">
    <div class="position-relative">
      <h4><strong>키즈룸</strong> 데코</h4>
      <p>소중한 내 아이, 사랑스런 공간에서 자라나길.</p>
      <a  href="#page-shop-category" data-start="#page-main" data-toggle="page" data-title="키즈룸 데코" data-index="0" data-parent="11" data-category="11" class="btn btn-outline-secondary">자세히 보기</a>
    </div>

  </div>
</section>

<section class="widget rb-photogrid content-padded">
  <header class="mb-1">
    <h3>인기 키즈룸</h3>
    <a href="#" data-act="swiperMainTo" data-index="2">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
  </header>
  <p class="mb-1">
    <small class="text-muted">한주의 인기사진 1위,2위,3위는 5,000P를 드립니다.</small>
  </p>
  <div class="row gutter-half">
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon active"><span>1</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-01_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon active"><span>2</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-02_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon active"><span>3</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-03_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon"><span>4</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-04_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon"><span>5</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-05_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon"><span>6</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-06_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon"><span>7</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-07_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon"><span>8</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-08_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
    <div class="col-xs-4">
      <a href="#page-detail" data-toggle="page" data-start="#page-main" data-src="">
        <span class="rank-icon"><span>9</span></span>
        <small class="nic-name">틴틴이</small>
        <img src="/files/tmp/kids-09_200x200.png" class="img-fluid img-rounded border" alt="">
      </a>
    </div>
  </div>
</section>

<section class="mt-4">
  <a href="#page-site-page" data-start="#page-main" data-toggle="page" data-title="배송안내" data-id="delivery" data-type="page" data-url="<?php echo RW('mod=delivery')?>">
    <img src="/files/mobile-banner-01.png" alt="" class="img-fluid">
  </a>
</section>


<ul class="table-view bg-white">
  <li class="table-view-cell">
    <a href="#page-post-view-video" class="navigate-right"
      data-toggle="page"
      data-start="#page-main"
      data-uid=""
      data-url="/post/0000000"
      data-src="oEB54AcMJ6Q"
      data-title="진짜로 입냄새가 없어졌다!😬 이걸로도 입냄새 안 없어지면 포기해야 한다는 전설의 아이템!">
      <img class="media-object pull-left" src="/files/tmp/kids-01_200x200.png" style="width:64px">
      <div class="media-body">
        진짜로 입냄새가 없어졌다!😬 이걸로도 입냄새 안 없어지면 포기해야 한다는 전설의 아이템!
        <p>
          <small>틴틴이</small>
          <small class="ml-1">조회 10</small>
          <small class="ml-1">댓글 10+1</small>
          <small class="ml-1">좋아요 10</small>
          <small class="ml-1">3일전</small>
        </p>
      </div>
    </a>
  </li>
  <li class="table-view-cell">
    <a href="#page-post-view-video" class="navigate-right"
      data-toggle="page"
      data-start="#page-main"
      data-uid=""
      data-url="/post/0000000"
      data-src="oEB54AcMJ6Q"
      data-title="진짜로 입냄새가 없어졌다!😬 이걸로도 입냄새 안 없어지면 포기해야 한다는 전설의 아이템!">
      <img class="media-object pull-left" src="/files/tmp/kids-01_200x200.png" style="width:64px">
      <div class="media-body">
        진짜로 입냄새가 없어졌다!😬
        <p>
          <small>틴틴이</small>
          <small class="ml-1">조회 10</small>
          <small class="ml-1">댓글 10+1</small>
          <small class="ml-1">좋아요 10</small>
          <small class="ml-1">3일전</small>
        </p>
      </div>
    </a>
  </li>
</ul>
