<!-- 컴포넌트 모음 -->

<!-- 회원가입 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_mobile'].'/join/component.php'; ?>

<!-- 로그인 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_mobile'].'/login/component.php';  ?>

<!-- 알림 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_mobile'].'/noti/component.php';  ?>

<!-- 설정 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_mobile'].'/settings/component.php';  ?>

<!-- 프로필 -->
<?php include_once $g['path_module'].'member/themes/'.$d['member']['theme_mobile'].'/profile/component.php';  ?>

<!-- 포스트 -->
<?php include_once $g['path_module'].'post/themes/'.$d['post']['skin_mobile'].'/component.php';  ?>

<!-- 게시판 -->
<?php include_once $g['path_module'].'bbs/themes/'.$d['bbs']['skin_mobile'].'/component.php';  ?>

<!-- 댓글 -->
<?php include_once $g['path_module'].'comment/themes/'.$d['comment']['skin_mobile'].'/component.php';  ?>

<!-- 사이트 페이지 -->
<div class="page right" id="page-site-page">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
  	<a class="icon material-icons pull-right px-3 mirror" role="button" data-toggle="popup" data-target="#popup-link-share" data-url>reply</a>
    <h1 class="title title-left" data-role="title" data-history="back"></h1>
  </header>
  <main role="main" class="content bg-white">
    <div data-role="main" class="content-padded"></div>
  </main>
</div>

<!-- 통합검색 -->
<div id="modal-search" class="modal fast">
	<header class="bar bar-nav bg-white p-2">
	  <form class="input-group input-group-lg border border-primary" action="<?php echo $g['s']?>/" id="modal-search-form">
			<input type="hidden" name="r" value="<?php echo $r?>">
	    <input type="hidden" name="m" value="search">
	    <input type="search" name="keyword" class="form-control bg-white" placeholder="검색어 입력" id="search-input" required autocomplete="off">
			<span class="input-group-btn hidden" data-role="keyword-reset" >
	      <button class="btn btn-link pr-2" type="button" data-act="keyword-reset" tabindex="-1">
	        <i class="fa fa-times-circle" aria-hidden="true"></i>
	      </button>
	    </span>
			<span class="input-group-btn">
			  <button class="btn btn-link text-primary" type="submit" id="modal-search-submit">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</span>
	  </form>
	</header>
	<nav class="bar bar-tab bar-light bg-faded bg-white">
	  <a class="tab-item" role="button" data-history="back">
	    취소
	  </a>
	</nav>

	<main class="content bg-faded">
		<div class="content-padded">

		</div>
	</main>
</div><!-- /.modal -->

<!-- 로그아웃-->
<div id="popup-logout" class="popup zoom">
  <div class="popup-content">
    <header class="bar bar-nav">
      <h1 class="title">로그아웃 전에 확인해주세요.</h1>
    </header>
    <nav class="bar bar-standard bar-footer">
      <div class="row">
        <div class="col-xs-6">
          <button type="button" class="btn btn-secondary btn-block" data-history="back">취소</button>
        </div>
        <div class="col-xs-6 p-l-0">
          <button type="button" class="btn btn-primary btn-block" data-act="logout">로그이웃</button>
        </div>
      </div>
    </nav>
    <div class="content">
      <div class="p-a-3 text-xs-center">
				정말로 로그아웃 하시겠습니까?
			</div>
    </div>
  </div>
</div>

<!-- 팝업 : 링크공유 -->
<div id="popup-link-share" class="popup zoom">
  <div class="popup-content rounded-0">
    <header class="bar bar-nav rounded-0">
      <a class="icon icon-close pull-right" data-history="back" role="button"></a>
      <h1 class="title">
				링크 복사
			</h1>
    </header>
    <div class="content text-xs-center rounded-0">

      <ul class="table-view mt-0" style="max-height: 400px;">
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/kakaotalk.png" alt="카카오톡" class="media-object pull-left img-circle" style="width:38px">
          카카오톡
          <button class="btn btn-secondary" id="kakao-link-btn">링크공유</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/youtube.png" alt="유튜브" class="media-object pull-left img-circle" style="width:38px">
          유튜브
          <button class="btn btn-secondary" data-role="youtube" data-toggle="linkCopy" data-clipboard-text="">
            링크복사
          </button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/instagram.png" alt="인스타그램" class="media-object pull-left img-circle" style="width:38px">
          인스타그램
          <button class="btn btn-secondary" data-role="instagram" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북공유" class="media-object pull-left img-circle" style="width:38px">
          페이스북
          <button class="btn btn-secondary" data-role="facebook" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/band.png" alt="밴드" class="media-object pull-left img-circle" style="width:38px">
          밴드
          <button class="btn btn-secondary" data-role="band" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버 카페" class="media-object pull-left img-circle" style="width:38px">
          네이버 카페
          <button class="btn btn-secondary" data-role="naver" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/kakaostory.png" alt="카카오스토리" class="media-object pull-left img-circle" style="width:38px">
          카카오스토리
          <button class="btn btn-secondary" data-role="kakaostory" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/twitter.png" alt="트위터" class="media-object pull-left img-circle" style="width:38px">
          트위터
          <button class="btn btn-secondary" data-role="twitter" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/mail.png" alt="이메일" class="media-object pull-left img-circle" style="width:38px">
          이메일
          <button class="btn btn-secondary" data-role="email" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <img src="<?php echo $g['img_core']?>/sns/sms.png" alt="SMS" class="media-object pull-left img-circle" style="width:38px">
          SMS
          <button class="btn btn-secondary" data-role="sms" data-toggle="linkCopy">링크복사</button>
        </li>
        <li class="table-view-cell media align-items-center">
          <span class="ml-2">기타</span>
          <button class="btn btn-secondary" data-role="etc" data-toggle="linkCopy">링크복사</button>
        </li>

        <?php if ($my['admin']): ?>
        <li class="table-view-cell media align-items-center">
          <span class="ml-2">고유번호</span>
          <button class="btn btn-secondary" data-role="uid" data-toggle="linkCopy">복사</button>
        </li>
        <?php endif; ?>
      </ul>





    </div><!-- /.content -->
  </div><!-- /.popup-content -->
</div><!-- /.popup -->

<!-- 푸시알림 권한요청 -->
<div id="permission_alert" class="sheet">

  <div class="card card-full">

    <div class="card-header bg-primary">
      <i class="fa fa-bell-o fa-fw" aria-hidden="true"></i> 푸시알림 수신을 위한 권한요청
    </div>
    <div class="card-body">
      <div class="content-padded text-muted">
        <p>푸시알림을 허용하면 공지사항은 물론 게시글에 대한 피드백 또는 내가 언급된 글에 대한 정보들을 실시간으로 받아보실 수 있습니다.</p>
        <p>나중에 하기를 선택하실 경우, 설정 페이지에서 재설정 할 수 있습니다.</p>
      </div>
    </div>
    <div class="card-footer bg-white">
      <div class="row">
        <div class="col-xs-6">
          <button type="button" class="btn btn-secondary btn-block" data-history="back">나중에 하기</button>
        </div>
        <div class="col-xs-6 p-l-0">
          <button class="btn btn-outline-primary btn-block" onclick="requestPermission()">지금 설정하기</button>
        </div>
      </div>
    </div>
  </div><!-- /.card -->

</div>

<!-- 첨부파일 설정 -->
<div id="sheet-attach-moreAct" class="sheet bg-faded">
  <ul class="table-view table-view-full bg-white mb-0">
    <li class="table-view-cell table-view-divider" data-dismiss="sheet"><span data-role="title"></span></li>
    <li class="table-view-cell">
      <a data-attach-act="featured-img">
        대표이미지 설정
      </a>
    </li>
    <li class="table-view-cell d-none">
      <a data-attach-act="showhide">
        정보수정
      </a>
    </li>
    <li class="table-view-cell">
      <a data-attach-act="delete">
        삭제
      </a>
    </li>
  </ul>
</div>

<script src="<?php echo $g['url_layout']?>/_js/component.js"></script>
