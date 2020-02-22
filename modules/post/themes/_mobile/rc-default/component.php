<!--
포스트 모듈 컴포넌트 모음

1. 페이지 : 전체 포스트
2. 페이지 : 전체 리스트
3. 페이지 : 리스트 보기
4. 페이지   : 전체 카테고리
5. 페이지 : 특정 카테고리 보기
6. 페이지 : 키워드 보기
7. 페이지 : 최근에 본 포스트
8. 페이지 : 내 포스트 관리
9. 페이지 : 내 리스트 관리
10. 페이지 : 나중에 볼 포스트
11. 페이지 : 좋아요 한 포스트
12. 페이지 : 포스트 보기
13. 페이지 : 포스트 사진 보기
14. 페이지 : 새 포스트
15. 모달 : 포스트 보기
16. 모달 : 포스트 사진 보기
17. 모달 : 포스트 좋아요 보기
18. 모달 : 전체 포스트
19. 모달 : 전체 리스트
20. 모달 : 리스트 보기
21. 모달 : 포스트 검색 (임시)
22. 팝업 : 포스트 옵션 더보기
23. 팝업 : 포스트 신고
24. 팝업 : 정렬방식 변경
25. 팝업 :  새 재생목록
26. 시트 : 포스트 필터
27. 시트 : 리스트 저장
-->

<!-- 페이지 : 전체포스트 -->
<div class="page right" id="page-post-allpost" data-role="postFeed">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left px-3" role="button" data-history="back">arrow_back</a>
    <?php if ($d['post']['writeperm']): ?>
    <a role="button" data-toggle="popup"
      href="#popup-post-newPost"
      data-start="#page-post-allpost"
      data-title="새 포스트"
      class="icon material-icons pr-3 pl-2 pull-right">
      add_box
    </a>
    <?php endif; ?>
    <a class="icon pull-right material-icons px-2" role="button"
      data-toggle="sheet"
      data-target="#sheet-post-filter"
      data-backdrop="static">tune</a>
    <span class="title title-left" data-history="back" data-role="title">전체 포스트</span>
  </header>
  <main role="main" class="content bg-faded">
    <div data-role="list"></div>
    <div data-role="none" hidden>
      <div class="d-flex justify-content-center align-items-center" style="height: 70vh">
        <div class="text-xs-center text-reset">
          <div class="material-icons mb-4" style="font-size: 100px;color:#ccc">
            subscriptions
          </div>
          <h5>나만의 채널을 시작합니다.</h5>
          <small class="text-muted">당신만울 위한 모바일 베이스캠프</small>

          <div class="mt-4 text-xs-center">
            <?php if ($my['uid']): ?>
            <a class="btn btn-primary btn-lg" role="button"
              href="#popup-post-newPost"
              data-toggle="popup"
              data-start="#page-post-allpost"
              data-url="/post/write"
              data-title="새 포스트">
              포스트 작성
            </a>
            <?php else: ?>
            <a class="btn btn-primary btn-lg" role="button"
              href="#modal-login"
              data-toggle="modal"
              data-title="로그인">
              로그인
            </a>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 전체 리스트 -->
<div class="page right" id="page-post-alllist">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon material-icons pull-right pl-2 pr-3" role="button" data-toggle="modal" data-target="#modal-post-search">search</a>
    <a class="icon pull-right material-icons px-2" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
    <span class="title title-left" data-history="back">전체 리스트</span>
  </header>
  <main role="main" class="content">
    <ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list"></ul>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 리스트 보기 -->
<div class="page right" id="page-post-listview">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
  	<a class="icon material-icons pull-right px-3 mirror" role="button" data-toggle="popup" data-target="#popup-link-share" data-url>reply</a>
    <span class="title title-left" data-history="back" data-role="title">리스트 보기</span>
  </header>
  <section class="content">
  	<div data-role="box"></div>
  </section>
</div><!-- /.page -->

<!-- 페이지   : 전체 카테고리 -->
<div class="page right" id="page-post-category">
  <header class="bar bar-nav bar-light bg-faded px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <span class="title title-left" data-history="back" data-role="title"></span>
  </header>
  <main role="main" class="content">
  	<?php getWidget('post/rc-post-cat-collapse',array('smenu'=>'0','limit'=>'4','collid'=>'tree-post','dispfmenu'=>'1','collapse'=>'1'))?>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 특정 카테고리 보기 -->
<div class="page right" id="page-post-category-view">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon material-icons pull-right pl-2 pr-3" role="button" data-toggle="modal" data-target="#modal-post-search">search</a>
    <a class="icon pull-right material-icons px-2" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
    <span class="title title-left" data-history="back" >
      <span data-role="title"></span>
    </span>
  </header>
  <div class="bar bar-standard bar-header-secondary bar-light bg-faded p-x-0">
  <span class="bg_shadow shadow_before"></span>
  <span class="bg_shadow shadow_after"></span>
  <div class="swiper-container-thumbs">
    <nav class="swiper-wrapper"></nav>
  </div>
</div>
  <main role="main" class="content">
    <div class="swiper-container">
      <div class="swiper-wrapper">
      </div><!-- /.swiper-wrapper -->
    </div><!-- /.swiper-container -->
  	<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list"></ul>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 키워드 보기 -->
<div class="page right" id="page-post-keyword">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon pull-right material-icons px-3" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
    <span class="title title-left" data-history="back" data-role="title">키워드 보기</span>
  </header>
  <main role="main" class="content">
    <ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list"></ul>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 최근에 본 포스트 -->
<div class="page right" id="page-post-myhistory">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <span class="title title-left" data-history="back">기록</span>
  </header>
  <main role="main" class="content">
    <div class="content-padded">
      <ul class="media-list" data-role="list"></ul>
    </div>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 내 포스트 관리 -->
<div class="page right" id="page-post-mypost">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon pull-right material-icons px-3" role="button" data-toggle="sheet" data-target="#sheet-post-filter">tune</a>
    <span class="title title-left" data-history="back">내 포스트</span>
  </header>
  <main role="main" class="content">
    <div class="content-padded">
      <ul class="media-list" data-role="list"></ul>
    </div>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 내 리스트 관리 -->
<div class="page right" id="page-post-mylist">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon pull-right material-icons px-3" role="button" data-toggle="sheet" data-target="#sheet-post-filter">tune</a>
    <span class="title title-left" data-history="back" data-role="title">내 재생목록</span>
  </header>
  <main role="main" class="content">
    <div class="content-padded">
      <ul class="media-list" data-role="list"></ul>
    </div>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 나중에 볼 포스트 -->
<div class="page right" id="page-post-saved">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon pull-right material-icons px-3" role="button" data-toggle="sheet" data-target="#sheet-post-filter">tune</a>
    <span class="title title-left" data-history="back" data-role="title">나중에 볼 포스트</span>
  </header>
  <main role="main" class="content">
    <div class="content-padded">
      <ul class="media-list" data-role="list"></ul>
    </div>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 좋아요 한 포스트 -->
<div class="page right" id="page-post-liked">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon pull-right material-icons px-3" role="button" data-toggle="sheet" data-target="#sheet-post-filter">tune</a>
    <span class="title title-left" data-history="back" data-role="title">좋아요 한 포스트</span>
  </header>
  <main role="main" class="content">
    <div class="content-padded">
      <ul class="media-list" data-role="list"></ul>
    </div>
  </main>
</div><!-- /.page -->

<!-- 페이지 : 포스트 보기 -->
<div class="page right" id="page-post-view" data-role="view">
</div><!-- /.page -->

<!-- 페이지 : 포스트 사진 크게보기 -->
<div class="page right" id="page-post-photo" data-role="post-photo">
  <header class="bar bar-nav bar-dark bg-black pl-0 border-bottom-0" style="opacity: 0.7;;height: 3.7rem;">
    <a class="icon pull-left material-icons px-3 text-white" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back" style="line-height: 1.2;padding-top: .75rem">
      <div data-role="title" class="pr-2 text-nowrap text-truncate"></div><small class="text-muted">포스트 보기</small>
    </h1>
  </header>
  <div class="bar bar-footer bar-dark bg-black text-muted border-top-0" style="opacity: 0.7;">
    <div class="swiper-pagination"></div>
  </div>
  <div class="content bg-black py-0">
    <div class="d-flex" style="height:100vh">
      <div class="swiper-container align-self-center" style="height:100vh">
        <div class="swiper-wrapper align-items-center">
          <div class="swiper-slide">
            <div class="swiper-zoom-container">
              <img src="">
            </div>
          </div>
        </div>
    </div>
    </div>
  </div>
</div>

<!-- 모달 : 포스트 보기 -->
<div class="modal" id="modal-post-view" data-role="view">
</div><!-- /.modal -->

<!-- 모달 : 포스트 통계 -->
<div class="modal fast" id="modal-post-analytics" data-start="<?php echo date("Ymd", strtotime("-1 week")); ?>">

  <section class="page center" id="page-post-analytics-main">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon icon-close pull-left px-3" data-history="back" role="button"></a>
      <h1 class="title" data-history="back">통계</h1>
    </header>
    <div class="content">

      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center text-muted" style="height:70vh">
          <div class="spinner-border mr-2" role="status"></div>
        </div>
      </div>
      <div class="d-none" data-role="article">
        <div class="border-bottom">
          <div class="media content-padded">
            <span class="media-left">
              <div class="embed-responsive embed-responsive-16by9 bg-faded">
                <img class="media-object bg-faded" src="" alt="" data-role="featured" style="width:110px">
                <time class="badge badge-default bg-black rounded-0 position-absolute f12 p-1" style="right:0;bottom:0" data-role="time"></time>
              </div>
            </span>
            <div class="media-body">
              <h5 class="media-heading f15 line-clamp-2 mb-0" data-role="subject"></h5>
              <small data-role="nic" class="text-muted"></small> <small class="text-muted ml-2">조회수 <span data-role="hit"></span>회</small>
            </div>
          </div>
        </div>

        <canvas class="my-3"></canvas>

        <ul class="table-view">

          <li class="table-view-cell">
            <a class="navigate-right" data-toggle="page" data-target="#page-post-analytics-referer" data-start="#page-post-analytics-main">
              유입경로
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" data-toggle="page" data-target="#page-post-analytics-device" data-start="#page-post-analytics-main">
              디바이스별
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" data-toggle="page" data-target="#page-post-analytics-side" data-start="#page-post-analytics-main">
              외부유입
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" data-toggle="page" data-target="#page-post-analytics-likes" data-start="#page-post-analytics-main">
              <span class="badge badge-pill" data-role="likes"></span>
              좋아요
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" data-toggle="page" data-target="#page-post-analytics-dislikes" data-start="#page-post-analytics-main">
              <span class="badge badge-pill" data-role="dislikes"></span>
              싫어요
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" data-toggle="page" data-target="#page-post-analytics-comment" data-start="#page-post-analytics-main">
              <span class="badge badge-pill" data-role="comment"></span>
              댓글
            </a>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <section class="page right" id="page-post-analytics-referer">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">유입경로</h1>
    </header>
    <div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center"  style="height:385px">
          <div class="spinner-border text-muted" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div data-role="canvas">
        <div class="d-flex justify-content-center align-items-center"  style="height:80vh">
          <canvas></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="page right" id="page-post-analytics-device">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">디바이스별</h1>
    </header>
    <div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center"  style="height:385px">
          <div class="spinner-border text-muted" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div data-role="canvas">
        <div class="d-flex justify-content-center align-items-center"  style="height:80vh">
          <canvas></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="page right" id="page-post-analytics-side">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">외부유입</h1>
    </header>
    <div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center"  style="height:385px">
          <div class="spinner-border text-muted" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div data-role="canvas">
        <div class="d-flex justify-content-center align-items-center"  style="height:80vh">
          <canvas></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="page right" id="page-post-analytics-likes">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">좋아요</h1>
    </header>
    <div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center"  style="height:385px">
          <div class="spinner-border text-muted" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div data-role="canvas">
        <div class="d-flex justify-content-center align-items-center"  style="height:80vh">
          <canvas></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="page right" id="page-post-analytics-dislikes">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">싫어요</h1>
    </header>
    <div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center"  style="height:385px">
          <div class="spinner-border text-muted" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div data-role="canvas">
        <div class="d-flex justify-content-center align-items-center"  style="height:80vh">
          <canvas></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="page right" id="page-post-analytics-comment">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">댓글</h1>
    </header>
    <div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center"  style="height:385px">
          <div class="spinner-border text-muted" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div data-role="canvas">
        <div class="d-flex justify-content-center align-items-center"  style="height:80vh">
          <canvas></canvas>
        </div>
      </div>
    </div>
  </section>

</div><!-- /.modal -->

<!-- 모달 : 포스트 사진 보기 -->
<section id="modal-post-photo" class="modal fast" data-role="post-photo">
  <header class="bar bar-nav bar-dark bg-black px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
   <h1 class="title" data-role="title" data-history="back">제목</h1>
  </header>
  <div class="bar bar-standard bar-header-secondary bar-dark bg-black">
     <h1 class="title text-muted"><small><i class="fa fa-expand mr-2" aria-hidden="true"></i> 이미지를 터치해서 확대해서 볼 수 있습니다.</small></h1>
  </div>
  <div class="bar bar-footer bar-dark bg-black text-muted">
    <div class="swiper-pagination"></div>
  </div>
  <div class="content bg-black">
    <div class="d-flex" style="height:78vh">
      <div class="swiper-container align-self-center" style="height:78vh">
        <div class="swiper-wrapper">
        </div>
    </div>
      <!-- Add Navigation -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</section>

<!-- 모달 : 포스트 좋아요 보기 -->
<section id="modal-post-opinion" class="modal fast" data-role="post-photo">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">좋아요</h1>
  </header>
  <div class="content">
    <div class="content-padded">
      <ul class="media-list" data-role="list"></ul>
    </div>
  </div>
</section>

<!-- 모달 : 전체 포스트 -->
<div id="modal-post-allpost" class="modal fast">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon material-icons pull-right pl-2 pr-3" role="button" data-toggle="modal" data-target="#modal-post-search">search</a>
  	<a class="icon pull-right material-icons px-2" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
  	<span class="title title-left" data-toggle="reload">전체 포스트</span>
  </header>
  <section class="content bg-faded">
  	<div data-role="list"></div>
  </section>
</div>

<!-- 모달 : 전체 리스트 -->
<div id="modal-post-alllist" class="modal">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <a class="icon material-icons pull-right pl-2 pr-3" role="button" data-toggle="modal" data-target="#modal-post-search">search</a>
  	<a class="icon pull-right material-icons px-2" role="button" data-toggle="sheet" data-target="#sheet-post-filter" data-backdrop="static">tune</a>
  	<span class="title title-left" data-toggle="reload">전체 리스트</span>
  </header>
  <section class="content">
  	<ul class="table-view table-view-sm mt-2 border-top-0 border-bottom-0" data-role="list"></ul>
  </section>
</div>

<!-- 모달 : 리스트 보기 -->
<div id="modal-post-listview" class="modal zoom">
  <header class="bar bar-nav bar-light bg-white px-0">
  	<a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
  	<span class="title title-left" data-toggle="reload">리스트 보기</span>
  </header>
  <section class="content">
  	<div data-role="box"></div>
  </section>
</div>

<!-- 모달 : 포스트 검색 -->
<div id="modal-post-search" class="modal fast">
  <header class="bar bar-nav bar-light bg-white">
    <a class="icon icon-close pull-right" data-history="back" role="button"></a>
    <h1 class="title">Modal</h1>
  </header>
  <div class="content">
    <p class="content-padded">
    </p>
  </div>
</div>

<!-- 모달 : 포스트 편집 -->
<div class="modal" id="modal-post-write" data-role="write">

  <section class="page center" id="page-post-edit-main">

    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon icon-close pull-left px-3" data-history="back" role="button"></a>
      <button class="btn btn-link btn-nav pull-right px-4" data-act="submit">
        <span class="not-loading">
          저장
        </span>
        <span class="is-loading">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="sr-only">저장중...</span>
          </div>
        </span>
      </button>
      <a href="#popover-post-display" data-toggle="popover" class="title title-left ml-3">
        <span data-role="display_label" style="min-width: 38px;display: inline-block"></span>
        <span class="icon icon-caret ml-1" style="top: 2px;"></span>
      </a>
    </header>
    <header class="bar bar-nav bar-light bg-faded p-x-0 border-top" data-role="editor-nav">
      <div class="d-flex align-items-center">
        <div class="toolbar-container w-100"></div>
        <?php if ($g['mobile']!='iphone' && $g['mobile']!='ipad'): ?>
        <div class="flex-shrink-1 border-left text-xs-center" style="min-width:4rem">
          <button class="btn btn-link" type="button">완료</button>
        </div>
      <?php endif; ?>
      </div>
    </header>

    <main role="main" class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center text-muted" style="height:70vh">
          <div class="spinner-border" role="status"></div>
        </div>
      </div>
      <form name="writeForm" method="post" class="d-none bg-white">

        <input type="hidden" name="uid" value="">
        <input type="hidden" name="category_members" value="">
        <input type="hidden" name="list_members" value="">
        <input type="hidden" name="upload" id="upfilesValue" value="">
        <input type="hidden" name="member" value="">
        <input type="hidden" name="featured_img" value="">
        <input type="hidden" name="html" value="HTML">
        <input type="hidden" name="display" value="1">
        <input type="hidden" name="dis_like">
        <input type="hidden" name="dis_comment">
        <input type="hidden" name="dis_listadd">
        <input type="hidden" name="goods">

        <div class="content-padded my-0 editor-focused-hide">
          <div class="media">
            <span class="media-left media-middle position-relative pr-0 mr-2 d-none">
              <img class="media-object bg-faded" src="" alt="" data-role="featured" style="height:58px">
              <time class="badge badge-default bg-black rounded-0 position-absolute f12 p-1" style="right:1px;bottom:1px" data-role="time"></time>
              <span class="badge badge-default bg-black rounded-0 position-absolute f12 p-1" style="right:1px;bottom:1px" data-role="attachNum"></span>
            </span>
            <div class="media-body f14" style="max-height: 300px;overflow: auto">
              <div class="form-list floating mb-1">
                <div class="input-row pl-1">
                  <label class="small text-muted">제목</label>
                  <textarea class="form-control p-0 border-0 mb-0" rows="2" name="subject" data-role="subject" data-plugin="autosize" placeholder="제목 입력..."></textarea>
                </div>
              </div>
            </div>
          </div><!-- /.media -->
        </div><!-- /.content-padded -->

        <div data-role="editor" class="mb-4" style="margin-top: -5px;">
          <div data-role="editor-body" class="editable-container" style="color:#55595c"></div>
        </div>


        <ul class="table-view editor-focused-hide mb-0 bg-faded" id="post-attach-tree">
  			  <li class="table-view-cell">
  					<a class="navigate-right collapsed" data-toggle="collapse" data-parent="#post-attach-tree" data-target="#post-collapse-attach-file">
              <span class="badge badge-default badge-inverted" data-role="attachNum"></span>
  			      사진 및 파일
  			    </a>
  			    <!-- 2depth -->
            <div class="table-view collapse mb-0" id="post-collapse-attach-file" role="tabpanel" >
              <?php getWidget('_default/attach-rc',array('parent_module'=>'post','theme'=>'_mobile/rc-post-file','attach_handler_photo'=>'[data-role="attach-handler-photo"]','parent_data'=>$R,'attach_object_type'=>'photo'));?>
            </div>
  			  </li>


  				<li class="table-view-cell">
  					<a class="navigate-right collapsed" data-toggle="collapse" data-parent="#post-attach-tree" data-target="#post-collapse-attach-link">
              <span class="badge badge-default badge-inverted" data-role="linkNum"></span>
  			      링크
  			    </a>
  			    <!-- 2depth -->
  			    <div class="table-view collapse mb-0" id="post-collapse-attach-link">
              <?php getWidget('_default/attach-rc',array('parent_module'=>'post','theme'=>'_mobile/rc-post-link','parent_data'=>$R,'attach_object_type'=>'photo'));?>
            </div>
  			  </li>

  			</ul>

        <ul class="table-view editor-focused-hide bg-white" style="margin-top:-1px">
          <li class="table-view-cell">
            <a class="navigate-right" href="#page-post-edit-review" data-start="#page-post-edit-main" data-toggle="page">
              <span class="badge badge-default badge-inverted"></span>
              요약
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="#page-post-edit-tag" data-start="#page-post-edit-main" data-toggle="page">
              <span class="badge badge-default badge-inverted"></span>
              태그
            </a>
          </li>
          <?php if (getDbRows($table['postcategory'],'site='.$s.' and reject=0 and hidden=0') && $d['post']['categoryperm'] ): ?>
          <li class="table-view-cell">
            <a class="navigate-right" href="#page-post-edit-category" data-start="#page-post-edit-main" data-toggle="page">
              카테고리 설정
            </a>
          </li>
          <?php endif; ?>
          <li class="table-view-cell">
            <a class="navigate-right" href="#page-post-edit-advan" data-start="#page-post-edit-main" data-toggle="page">
              고급설정
            </a>
          </li>
          <?php if ($d['post']['goodsperm']): ?>
          <li class="table-view-cell d-none">
            <a class="navigate-right" href="#page-post-edit-goodslist" data-start="#page-post-edit-main" data-toggle="page">
              <span class="badge badge-default badge-inverted" data-role="goodsNum"></span>
              상품연결
            </a>
          </li>
          <?php endif; ?>
        </ul>

      </form><!-- /.content-padded -->

    </main>
  </section>

  <section class="page right" id="page-post-edit-review">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back">요약설명</span>
    </header>
    <nav class="bar bar-tab bar-light bg-white">
      <a class="tab-item text-muted" role="button" data-history="back">
        확인
      </a>
    </nav>
    <main class="content">
      <textarea class="form-control border-0" rows="5" name="review" placeholder="요약설명을 입력해주세요."></textarea>
    </main>
  </section>

  <section class="page right" id="page-post-edit-tag">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back">태그 <small class="text-muted ml-3">콤마(,)로 구분하여 입력해주세요.</small></span>
    </header>
    <nav class="bar bar-tab bar-light bg-white">
      <a class="tab-item text-muted" role="button" data-history="back">
        확인
      </a>
    </nav>
    <main class="content">
      <div class="content-padded">
        <textarea class="form-control border-0" rows="5" name="tag" placeholder="태그를 입력해주세요"></textarea>
      </div>
    </main>
  </section>

  <section class="page right" id="page-post-edit-advan">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back">고급설정</span>
    </header>
    <main class="content">
      <ul class="table-view mt-0 border-top-0">
        <li class="table-view-cell">
          포맷
          <div class="select custom-select border-0">
            <select name="format" class="pl-3">
              <option value="1">doc</option>
              <option value="2">video</option>
              <option value="3">adv</option>
            </select>
          </div>
        </li>
        <li class="table-view-cell">
          댓글 사용
          <div data-toggle="switch" data-role="dis_comment" class="switch active">
            <div class="switch-handle"></div>
          </div>
        </li>
        <li class="table-view-cell">
          좋아요 사용
          <div data-toggle="switch" data-role="dis_like" class="switch active">
            <div class="switch-handle"></div>
          </div>
        </li>
        <li class="table-view-cell">
          저장 허용
          <div data-toggle="switch" data-role="dis_listadd" class="switch active">
            <div class="switch-handle"></div>
          </div>
        </li>
      </ul>
    </main>
  </section>

  <section class="page right" id="page-post-edit-category">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back">카테고리 설정</span>
    </header>
    <main class="content">

      <div data-role="box" style="margin-top:-1px"></div>

    </main>
  </section>

  <section class="page right" id="page-post-edit-mediaset">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">미디어셋 설정</span>
    </header>
    <main class="content">

      <div class="content-padded" data-role="box"></div>

    </main>
  </section>

  <section class="page right" id="page-post-edit-imageGoodsTag">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back">상품 태그하기</span>
    </header>
    <main class="content">

      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">Slide 1</div>
          <div class="swiper-slide">Slide 2</div>
        </div>
      </div>

      <div class="p-5 text-xs-center text-muted">
        상품을 태그하려면 사진을 누르세요.<br>더 보려면 살짝 미세요.
      </div>

    </main>
  </section>

  <section class="page right" id="page-post-edit-goodslist" data-role="search">
    <header class="bar bar-nav py-1 px-0 bg-white">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <form class="input-group input-group-lg bg-white">
  	    <input type="search" name="keyword" class="form-control pl-0" placeholder="상품명을 입력하세요." id="search-input-goods" required="" autocomplete="off" data-plugin="autocomplete">
  			<span class="input-group-btn d-none" data-role="keyword-reset">
  	      <button class="btn btn-link pr-1" type="button" data-act="keyword-reset" tabindex="-1">
  	        <i class="fa fa-times-circle" aria-hidden="true"></i>
  	      </button>
  	    </span>
  	  </form>
    </header>
    <main class="content bg-white">
      <div class="content-backdrop d-none" data-role="backdrop"></div>
      <ol class="table-view bg-white border-top-0" data-role="attach-goods" data-sortable="goods" style="margin-top:-1px"></ol>
    </main>
  </section>

  <section class="page right" id="page-post-edit-goodsview" data-role="search">
    <input type="hidden" class="form-control" name="goods" placeholder="준비중...">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back">상품 상세보기</span>
    </header>
    <main class="content">

    </main>
  </section>

</div><!-- /.modal -->

<!-- 모달 : 포스트 간단글 쓰기-->
<div class="modal" id="modal-post-twit" data-role="write">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon icon-close pull-left px-3" data-history="back" role="button"></a>

    <button class="btn btn-link btn-nav pull-right pl-2 pr-4" data-act="submit" data-display="5">
      <span class="not-loading">
        올리기
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="sr-only">저장중...</span>
        </div>
      </span>
    </button>
    <button class="btn btn-link btn-nav text-muted pull-right px-2" data-act="submit" data-display="1">
      <span class="not-loading">
        임시저장
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="sr-only">저장중...</span>
        </div>
      </span>
    </button>
  </header>
  <main class="content">
    <div class="content-padded my-0 editor-focused-hide">
      <div class="media mt-3">
        <span class="media-left  position-relative pr-0 mr-2">
          <img class="media-object img-circle" src="<?php echo getAvatarSrc($my['uid'],'84') ?>" style="height:42px">
        </span>
        <div class="media-body f14" style="max-height: 300px;overflow: auto">
          <div class="form-list mt-2">
            <div class="input-row pl-1 border-bottom-0">
              <label class="sr-only">제목</label>
              <textarea class="form-control p-0 border-0 mb-0" rows="2" name="subject" data-plugin="autosize" placeholder="오늘 하루, 어떤 일이 있었나요?"></textarea>
            </div>
          </div>
        </div>
      </div><!-- /.media -->
    </div><!-- /.content-padded -->
  </main>
</div>

<!-- 팝업 : 포스트 옵션 더보기 -->
<div id="popup-post-postMore" class="popup zoom">
  <div class="popup-content">
    <ul class="table-view table-view-full text-xs-center rounded-0" data-role="list" style="max-height: 328px;">
    </ul>
  </div>
</div>

<!-- 팝업 : 포스트 신고 -->
<div id="popup-post-report" class="popup zoom">
  <div class="popup-content rounded-0">
    <header class="bar bar-nav bg-white">
      <h1 class="title">컨텐츠 신고</h1>
    </header>
    <nav class="bar bar-tab">
      <a class="tab-item bg-white" role="button" data-history="back">
        취소
      </a>
      <a class="tab-item bg-white active" role="button" data-act="submit">
        신고
      </a>
    </nav>
    <div class="content rounded-0">
      <div class="p-3">

        <div class="custom-controls-stacked">
          <label class="custom-control custom-radio">
            <input id="radio-01" type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">성적인 콘텐츠</span>
          </label>

          <label class="custom-control custom-radio">
            <input id="radio-02" type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">폭력적 또는 혐오스러운 콘텐츠</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">증오 또는 악의적인 콘텐츠</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">유해한 위험 행위</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">아동 학대</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">테러 조장</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">스팸 또는 사용자를 현혹하는 콘텐츠</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">권리 침해</span>
          </label>

          <label class="custom-control custom-radio">
            <input type="radio" name="report" class="custom-control-input">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">기타</span>
          </label>
        </div>

        <div class="mt-1">
          <small class="text-muted">
          커뮤니티 가이드를 위반한 계정은 제재를 받게 되며 심각하거나 반복적인 위반 행위에 대해서는 계정 해지 조치가 취해질 수 있습니다.
          </small>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- 팝업 : 정렬방식 변경 -->
<div id="popup-post-sort" class="popup zoom">
  <div class="popup-content">
    <ul class="table-view table-view-full text-xs-center rounded-0">
      <li class="table-view-cell">
        <a class="" data-toggle="sort" data-sort="hit">
          조회순
        </a>
      </li>
      <li class="table-view-cell">
        <a class="" data-toggle="sort" data-sort="hit">
          좋아요순
        </a>
      </li>
      <li class="table-view-cell">
        <a class="" data-toggle="sort" data-sort="d-regis" data-orderby="asc">
          추가된 날짜 (오래된순)
        </a>
      </li>
      <li class="table-view-cell" data-toggle="sort" data-sort="d-regis" data-orderby="desc">
        <a class="">
          추가된 날짜 (최신순)
        </a>
      </li>
    </ul>
  </div>
</div>

<!-- 팝업 : 새 재생목록 -->
<div id="popup-post-newList" class="popup zoom">
  <div class="popup-content rounded-0">
    <div class="content rounded-0" style="min-height: 110px;">
      <div class="p-a-1">
        <h5>새 재생목록</h5>
        <div class="form-list stacked mt-3 mb-1">
				  <input type="text" placeholder="제목" name="name" class="border-primary px-0 py-2" autocomplete="off">

          <div class="input-row px-0 mt-3 border-bottom-0">
            <label class="text-muted mb-1">개인정보보호</label>
            <select class="form-control custom-select mb-0" name="display" style="height: inherit;">
              <?php $displaySet=explode('||',$d['displaySet'])?>
  						<?php $i=1;foreach($displaySet as $displayLine):if(!trim($displayLine))continue;$dis=explode(',',$displayLine)?>
              <option value="<?php echo $i ?>" class="<?php echo $dis[0]=='일부공개'?'d-none':'' ?>"><?php echo $dis[0]?></option>
  						<?php $i++;endforeach?>
            </select>
          </div>

				</div>

        <div class="text-xs-right">
          <button type="button" class="btn btn-lg btn-link text-muted mr-2" data-history="back">취소</button>
          <button type="button" class="btn btn-lg btn-link" data-act="submit">
            <span class="not-loading">
							만들기
						</span>
            <span class="is-loading">
              <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </span>
          </button>
        </div>

			</div>
    </div>
  </div>
</div>

<!-- 팝업 : 새 포스트 작업선택   -->
<div id="popup-post-newPost" class="popup zoom">
  <div class="popup-content rounded-0">
    <header class="bar bar-nav">
      <a class="icon icon-close pull-right" data-history="back" role="button"></a>
      <h1 class="title" data-role="title">새 포스트</h1>
    </header>
    <div class="content rounded-0" style="min-height: 185px;">
      <div class="px-3 pb-3">
        <div class="row">
          <div class="col-xs-4">
            <button type="button" class="btn btn-block btn-link text-muted" data-toggle="newpost" data-type="twit">
              <div class="material-icons" style="font-size: 60px;">
                format_quote
              </div>
              <div><small class="text-muted">간단글</small></div>
            </button>
          </div>
          <div class="col-xs-4">
            <button type="button" class="btn btn-block btn-link text-muted" data-toggle="newpost" data-type="editor">
              <div class="material-icons" style="font-size: 60px;">
                notes
              </div>
              <div><small class="text-muted">긴글 작성</small></div>
            </button>
          </div>
          <div class="col-xs-4">
            <button type="button" class="btn btn-block btn-link text-muted" data-toggle="newpost" data-type="link">
              <div class="material-icons" style="font-size: 60px;">
                link
              </div>
              <div><small class="text-muted">링크 추가</small></div>
            </button>
          </div>
          <div class="col-xs-4">
            <button type="button" class="btn btn-block btn-link text-muted" data-toggle="newpost" data-type="photo">
              <div class="material-icons" style="font-size: 60px;">
                insert_photo
              </div>
              <div><small class="text-muted">사진 추가</small></div>
            </button>
          </div>
          <div class="col-xs-4">
            <button type="button" class="btn btn-block btn-link text-muted" data-toggle="newpost" data-type="youtube">
              <div class="fa fa-youtube-square text-muted" style="font-size: 60px;">
              </div>
              <div style="margin-top:3px"><small class="text-muted">내 영상 추가</small></div>
            </button>
          </div>
          <div class="col-xs-4">
            <button type="button" class="btn btn-block btn-link text-muted" data-toggle="newpost" data-type="map">
              <div class="material-icons" style="font-size: 60px;">
                room
              </div>
              <div><small class="text-muted">장소 추가</small></div>
            </button>
          </div>
        </div><!-- /.row -->
      </div>
    </div>
  </div>
</div>

<!-- 팝업 : 삭제확인 안내-->
<div id="popup-post-delConfirm" class="popup zoom">
  <div class="popup-content rounded-0">
    <div class="content rounded-0" style="min-height: 110px;">
      <div class="p-a-1">
        <h5 data-role="title">정말로 삭제하시겠습니까?</h5>
				<span data-role="subtext" class="f14 text-muted"></span>
        <div class="text-xs-right mt-4">
          <button type="button" class="btn btn-link text-muted mr-2" data-history="back">취소</button>
          <button type="button" class="btn btn-link" data-act="submit">
            <span class="not-loading">
              삭제
            </span>
            <span class="is-loading">
              <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">처리중...</span>
              </div>
            </span>
          </button>
        </div>
			</div>
    </div>
  </div>
</div>

<!-- 시트 : 포스트 필터 -->
<div id="sheet-post-filter" class="sheet shadow">
  <header class="bar bar-nav bar-light bg-white px-0">

    <button class="btn btn-link btn-nav pull-right px-3" data-act="submit" data-sort="gid">
      <span class="not-loading">
        적용
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="sr-only">처리중...</span>
        </div>
      </span>
    </button>

    <h1 class="title">보기옵션</h1>
  </header>
  <div style="padding-top: 2.75rem;">
    <div class="content-padded py-5">

      <div class="text-xs-center mb-2 text-muted">정렬 선택</div>
      <div class="nav nav-control">
        <a class="nav-link active" role="button" data-sort="gid">등록순</a>
        <a class="nav-link" role="button" data-sort="hit">조회순</a>
        <a class="nav-link" role="button" data-sort="likes">좋아요순</a>
        <a class="nav-link" role="button" data-sort="comment">댓글순</a>
      </div>
    </div>
  </div>
</div>

<!-- 시트 : 리스트 저장 -->
<div id="sheet-post-listadd" class="sheet shadow">
  <header class="bar bar-nav bar-light bg-white">
    <button class="btn btn-link btn-nav pull-right px-3" data-toggle="newList">
      새 재생목록
    </button>
    <h1 class="title title-left px-3">포스트 저장</h1>
  </header>
  <nav class="bar bar-tab bar-light bg-white">
    <a class="tab-item text-muted" role="button" data-history="back">
      취소
    </a>
    <a class="tab-item text-primary" role="button" data-act="submit">
      저장
    </a>
  </nav>
  <main>
    <div class="content-padded px-1">

      <div class="d-flex justify-content-between align-items-center py-2">
        <label class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" type="checkbox" id="saved" name="saved" {$is_saved}>
          <span class="custom-control-indicator"></span>
          <span class="custom-control-description" for="saved">나중에 볼 동영상</span>
        </label>
        <i class="material-icons text-muted mr-2" data-toggle="tooltip" title="비공개">lock</i>
      </div>

      <div data-role="list-selector"></div>

    </div>
  </main>
</div>

<!-- 시트 : 새 포스트 링크추가 -->
<div id="sheet-post-linkadd" class="sheet shadow" style="height: 93px;">
  <header class="bar bar-nav bar-light bg-white">
    <h1 class="title title-left px-3">링크 추가</h1>
  </header>
  <main>
    <div class="input-group" data-role="linkadd_input" style="top: 0.1rem;">
      <input type="text" class="form-control border-0" placeholder="복사한 URL을 여기에 붙여주세요.">
      <span class="input-group-btn">
        <button class="btn btn-link text-muted" type="button" style="top: 0.1rem;outline:none" data-act="submit">
          <span class="not-loading">
            <i class="material-icons">send</i>
          </span>
          <span class="is-loading">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="sr-only">처리중...</span>
            </div>
          </span>
        </button>
      </span>
    </div>
  </main>
</div>

<!-- 시트 : 새 포스트 사진 추가 -->
<div id="sheet-post-photoadd" class="sheet shadow" style="top: 40vh;">
  <header class="bar bar-nav bar-light bg-white">
    <button class="btn btn-link text-muted  btn-nav pull-right px-3" data-act="attach">
      <span class="not-loading">
        추가
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="sr-only">업로드중...</span>
        </div>
      </span>
    </button>
    <h1 class="title title-left px-3">사진 추가</h1>
  </header>
  <nav class="bar bar-tab bar-light bg-white">
    <a class="tab-item text-muted" role="button" data-history="back">
      취소
    </a>
    <a class="tab-item text-muted" role="button" data-act="submit" disabled>
      다음
    </a>
  </nav>
  <main>
    <div data-role="none">
      <div class="d-flex justify-content-center align-items-center" style="height: 43vh">
          <div class="text-xs-center" data-act="attach">
            <div class="material-icons mb-4" style="font-size: 100px;color:#ccc">
              image_search
            </div>
            <h5>새로운 사진을 올려 주세요.</h5>
            <small class="text-muted">포토 라이브러리에서 원하는 사진을 선택해주세요.</small>
          </div>
        </div>
    </div>
    <div class="content-padded">
      <input type="hidden" name="featured_img" value="">
      <ul class="table-view mb-0 border-0" data-role="attach-preview-photo" data-plugin="sortable"></ul>
      <div class="file-upload-container"></div>
    </div>
  </main>
</div>

<!-- Popover-->
<div id="popover-post-display" class="popover">
  <ul class="table-view" style="line-height: 1.2;max-height: 325px;">

    <li class="table-view-cell">
      <a class="d-flex align-items-center" data-toggle="display" data-display="1" data-label="비공개">
        <span class="badge badge-inverted"><span class="icon icon-check"></span></span>
        <i class="media-object pull-left media-middle material-icons f28 ml-1 mr-3 text-muted" data-role="icon">lock</i>
         <div class="media-body">
           비공개
           <p><small>나만 볼수있음</small></p>
         </div>
      </a>
    </li>
    <li class="table-view-cell">
      <a class="d-flex align-items-center" data-toggle="display" data-display="2" data-label="일부공개">
        <span class="badge badge-inverted"><span class=""></span></span>
        <i class="media-object pull-left media-middle material-icons f28 ml-1 mr-3 text-muted" data-role="icon">how_to_reg</i>
         <div class="media-body">
           일부공개
           <p><small>지정된 친구만 볼수 있음</small></p>
         </div>
      </a>
    </li>
    <li class="table-view-cell">
      <a class="d-flex align-items-center" data-toggle="display" data-display="3" data-label="미등록">
        <span class="badge badge-inverted"><span class=""></span></span>
        <i class="media-object pull-left media-middle material-icons f28 ml-1 mr-3 text-muted" data-role="icon">insert_link</i>
         <div class="media-body">
           미등록
           <p><small>링크 있는 사용자만 볼 수 있음. 로그인 불필요</small></p>
         </div>
      </a>
    </li>
    <li class="table-view-cell">
      <a class="d-flex align-items-center" data-toggle="display" data-display="4" data-label="회원공개">
        <span class="badge badge-inverted"><span class=""></span></span>
        <i class="media-object pull-left media-middle material-icons f28 ml-1 mr-3 text-muted" data-role="icon">people_alt</i>
         <div class="media-body">
           회원공개
           <p><small>사이트 회원만 볼수 있음. 로그인 필요</small></p>
         </div>
      </a>
    </li>
    <li class="table-view-cell">
      <a class="d-flex align-items-center" data-toggle="display" data-display="5" data-label="전체공개">
        <span class="badge badge-inverted"><span class=""></span></span>
        <i class="media-object pull-left media-middle material-icons f28 ml-1 mr-3 text-muted" data-role="icon">public</i>
         <div class="media-body">
           전체공개
           <p><small>모든 사용자가 검색하고 볼 수 있음</small></p>
         </div>
      </a>
    </li>
  </ul>
</div>


<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/component.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/post.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/list.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/list_view.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/view.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/keyword.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/category.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/best.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/write.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/myhistory.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/mypost.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/mylist.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/saved.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/liked.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/feed.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/opinion.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/more.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/post/themes/<?php echo $d['post']['skin_mobile'] ?>/_js/analytics.js<?php echo $g['wcache']?>" ></script>
