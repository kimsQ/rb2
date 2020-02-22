<!--
게시판 테마 컴포넌트 모음

1. Modal : 게시판 글쓰기
2. Popup : 글쓰기 취소확인
3. Popup : 댓글관리
4. Popover : 게시물 관리
5. Popover : 게시물 관리
6. Sheet : 신규 댓글작성

-->

<?php if ($m!='bbs'): ?>
<section id="page-bbs-list" class="page right" data-role="bbs-list">
  <header class="bar bar-nav bar-light bg-white p-x-0" data-role="bar-nav">
    <a class="icon pull-left material-icons px-3" role="button" data-history="back" data-role="hback">arrow_back</a>
    <a href="#popover-bbs-listMarkup" data-toggle="popover" data-bid="<?php echo $bid ?>" class="icon icon-more-vertical pull-right pl-2 pr-3"></a>
    <h1 class="title title-left" data-role="title" data-history="back">게시판</h1>
  </header>
  <div class="content" data-role="bbs-list">
  </div>
</section>
<?php endif; ?>

<!-- 게시판 카테고리 -->
<div id="page-bbs-category" class="page right" data-role="bbs-search">
  <header class="bar bar-nav bar-light bg-white px-0 border-bottom-0">
    <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">분류  <span class="badge badge-default badge-inverted ml-2" data-role="title"></span></h1>
  </header>
  <div class="content">
  </div>
</div>

<div id="page-bbs-result" class="page right">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">
      <span data-role="title">게시판 검색결과</span>
      <span data-role="bname" class="badge badge-default badge-inverted ml-2"></span>
    </h1>
  </header>
  <div class="content" data-role="bbs-list">
  </div>
</div>

<!-- Page : 게시물 보기 -->
<section id="page-bbs-view" class="page right" data-role="bbs-view">
  <input type="hidden" name="bid" value="">
  <input type="hidden" name="uid" value="">

  <header class="bar bar-nav bar-light bg-white p-x-0" data-scroll-header>
    <a class="icon pull-left material-icons px-3" role="button" data-history="back" data-role="hback">arrow_back</a>
    <a href="#popover-bbs-view" data-toggle="popover" class="icon icon-more-vertical pull-right pl-2 pr-3" data-role="owner" data-url=""></a>
    <a class="icon material-icons pull-right px-3 mirror" id="btn-linkShare" data-role="linkShare">reply</a>
    <h1 class="title title-left" data-role="title" data-history="back"></h1>
  </header>

  <main class="content">

    <div class="d-flex justify-content-between align-items-center content-padded my-3">

      <a class="media" style="width:15rem"
        data-toggle="sheet"
        data-avatar=""
        data-mbruid=""
        href="#sheet-member-profile">
        <img class="media-object pull-left rb-avatar img-rounded bg-faded" src="" style="width:2.55rem;height:2.55rem" data-role="avatar">
        <div class="media-body rb-meta ml-2" style="line-height: 1.2;">
          <strong class="f14 text-black" data-role="name"></strong> <br>
          <span class="badge badge-default badge-inverted font-weight-normal" data-role="d_regis"></span>
          <span class="badge badge-default badge-inverted font-weight-normal">조회 <span data-role="hit"></span></span>
        </div>
      </a>

      <div class="">
        <button type="button" class="btn btn-outline-secondary"
          data-toggle="move"
          data-target="[data-role='comment-box']"
          data-page="#page-bbs-view" data-role="btn_comment">
          <i class="fa fa-comment-o" aria-hidden="true"></i>
          <span data-role="total_comment" class="badge badge-default badge-inverted"></span>
        </button>
      </div>

    </div><!-- /.clearfix -->

    <div class="content-padded mt-4" data-role="post">
      <span data-role="cat" data-act="category" class="badge badge-primary badge-inverted"></span>
      <h3 data-role="subject" class="h5 font-weight-bold"></h3>
    </div>
    <div data-role="article">
      <div class="text-xs-center">다시 시도해주세요.</div>
    </div>

    <!-- 댓글출력 -->
    <div data-role="comment_box"></div>

  </main>
</section>

<!-- Page : 게시물 사진 크게보기 -->
<section id="page-bbs-photo" class="page right" data-role="bbs-photo">
  <header class="bar bar-nav bar-dark bg-black pl-0 border-bottom-0" style="opacity: 0.7;;height: 3.7rem;">
    <a class="icon pull-left material-icons px-3 text-white" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back" style="line-height: 1.2;padding-top: .75rem">
      <div data-role="subject" class="pr-2 text-nowrap text-truncate"></div><small class="text-muted" data-role="title"></small>
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
</section>

<!-- Page : 게시물 좋아요한 사람 -->
<section id="page-bbs-opinion"  class="page right" data-role="bbs-opinion">
  <input type="hidden" name="bid" value="">
  <input type="hidden" name="uid" value="">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon pull-left material-icons px-3" role="button" data-history="back" data-role="hback">arrow_back</a>
    <h1 class="title title-left" data-history="back">좋아요한 사람</h1>
  </header>
  <div class="content">
    <div class="content-padded" data-role="post">
      <h3 data-role="subject" class="rb-article-title line-clamp-3"></h3>
      <span data-role="cat" class="badge badge-primary badge-inverted"></span>
    </div>

    <div class="text-xs-center my-4">
      <button type="button" class="btn btn-outline-secondary btn-lg" data-send="ajax" data-toggle="opinion" data-uid="" data-opinion="like" data-effect="heartbeat" data-role="btn_post_like">
        <i class="fa fa fa-heart-o fa-fw fa-lg" aria-hidden="true"></i>
        <span data-role="likes_17351" class="badge badge-inverted"></span>
      </button>
    </div>

    <!-- 좋아요 목록 -->
    <ul class="table-view" data-role="list"></ul>

  </div>
</section>

<!-- 게시물 보기 -->
<section id="modal-bbs-view" class="modal fast" data-role="bbs-view">
  <input type="hidden" name="bid" value="">
  <input type="hidden" name="uid" value="">
  <input type="hidden" name="theme" value="">
  <header class="bar bar-nav bar-light bg-white p-x-0" data-scroll-header>
    <a class="icon pull-left material-icons px-3" role="button" data-history="back" data-role="hback">arrow_back</a>
    <a class="icon material-icons pull-left px-3" role="button" data-href="/" data-text="홈으로 이동" data-role="gohome">house</a>

    <a href="#popover-bbs-view" data-toggle="popover" class="icon icon-more-vertical pull-right pl-2 pr-3" data-role="owner" data-url=""></a>

    <a class="icon material-icons pull-right px-3 mirror" id="btn-linkShare"
      data-role="linkShare"
      data-subject="{$subject}"
      data-url=""
      data-likes="{$likes}"
      data-image="{$featured_img}"
      data-desc="">reply
    </a>

  </header>
  <main class="content">

    <div class="clearfix content-padded">

      <div class="pull-xs-left">

        <div class="media" style="width:15rem"
          data-mbruid=""
          data-toggle="sheet"
          data-target="#sheet-member-profile">
          <img class="media-object pull-left rb-avatar img-circle bg-faded" src="" style="width:2.25rem;height:2.25rem" data-role="avatar">
          <div class="media-body rb-meta m-l-1">
            <span class="badge badge-default badge-inverted" data-role="name"></span> <br>
            <span class="badge badge-default badge-inverted" data-role="d_regis"></span>
            <span class="badge badge-default badge-inverted">조회 <span data-role="hit"></span></span>
          </div>
        </div>

      </div>

      <div class="pull-xs-right pt-1">
        <button type="button" class="btn btn-outline-secondary"
          data-toggle="move"
          data-target="[data-role='comment-box']"
          data-page="#page-bbs-view" data-role="btn_comment">
          <i class="fa fa-comment-o" aria-hidden="true"></i>
          <span data-role="total_comment" class="badge badge-default badge-inverted"></span>
        </button>
      </div>

    </div><!-- /.clearfix -->
    <hr>
    <div class="content-padded" data-role="post">
      <span data-role="cat" class="badge badge-primary badge-inverted"></span>
      <h3 data-role="subject" class="rb-article-title"></h3>
    </div>
    <div data-role="article" data-plugin="photoswipe">
      <div class="p-4 text-xs-center">다시 시도해주세요.</div>
    </div>

    <!-- 댓글출력 -->
    <div data-role="comment_box"></div>

  </main>
</section>

<!-- 게시판 검색 -->
<div id="modal-bbs-search" class="modal fast">
  <header class="bar bar-nav bar-light bg-white border-bottom-0 px-0">
    <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left">검색 <span class="badge badge-default badge-inverted ml-2" data-role="title"></span></h1>
  </header>
  <div class="content">
    <form class="content-padded" data-role="search">

      <div class="form-group">
        <label class="sr-only">검색어</label>
        <input type="search" class="form-control" placeholder="검색어를 입력해주세요." name="keyword" value="" autocomplete="off" required>
      </div>

      <div class="form-group">
        <label class="sr-only">검색범위</label>
        <select class="form-control" name="where">
          <option value="subject|tag">제목+태그</option>
          <option value="content">본문</option>
          <option value="name">이름</option>
          <option value="nic">닉네임</option>
          <option value="id">아이디</option>
        </select>
      </div>

    </form>
  </div>
</div>

<!-- 게시판 글쓰기 -->
<div id="modal-bbs-write" class="modal fast" data-role="write">
  <input type="hidden" name="bid" value="">
  <input type="hidden" name="name" value="<?php echo $my['name']?>">
  <input type="hidden" name="uid" value="">
  <input type="hidden" name="reply" value="">
  <input type="hidden" name="notice" value="">
  <input type="hidden" name="hidden" value="">
  <input type="hidden" name="category" value="">
  <input type="hidden" name="tag" value="">
  <input type="hidden" name="featured_img" value="">
  <input type="hidden" name="upfiles" id="upfilesValue" value="">
  <input type="hidden" name="pcode" value="">
  <input type="hidden" name="backtype" value="ajax">

  <section id="page-bbs-write-main" class="page center">
  	<header class="bar bar-nav bar-light bg-white p-x-0" data-role="write-nav">
      <a class="icon pull-left material-icons p-x-1" role="button" data-history="back">arrow_back</a>
  		<button class="btn btn-link btn-nav pull-right p-x-2 d-none" type="button" data-act="submit">
        <span class="not-loading"></span>
        <span class="is-loading">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="sr-only">저장중...</span>
          </div>
        </span>
  	  </button>
  		<h1 class="title title-left" data-history="back">
  			글쓰기 <span class="badge badge-default badge-inverted ml-2" data-role="title"></span>
  		</h1>
  	</header>

    <header class="bar bar-nav bar-light bg-white p-x-0 border-top" data-role="editor-nav">
      <div class="d-flex align-items-center">
        <div class="toolbar-container w-100"></div>
        <?php if ($g['mobile']!='iphone' && $g['mobile']!='ipad'): ?>
        <div class="flex-shrink-1 border-left text-xs-center" style="min-width:4rem">
          <button class="btn btn-link" type="button">완료</button>
        </div>
      <?php endif; ?>
      </div>
    </header>

  	<div class="content">
      <div data-role="loader">
        <div class="d-flex justify-content-center align-items-center text-muted" style="height:70vh">
          <div class="spinner-border text-primary mr-2" role="status"></div>
        </div>
      </div>
  		<form class="d-none">

  			<div class="form-list m-b-0">
  				<?php if(!$my['id']):?>
  		     <div class="input-row">
  		       <label>이름</label>
  		       <input type="text" name="name" placeholder="이름을 입력해 주세요." value="" class="form-control" autocomplete="off">
  		     </div>
  				 <?php if(!$R['uid']||$reply=='Y'):?>
  				 <div class="input-row">
  					 <label>암호</label>
  					 <input type="password" name="pw" placeholder="암호는 게시글 수정 및 삭제에 필요합니다." value="" class="form-control" autocomplete="off">
            <?php if($R['hidden']&&$reply=='Y'):?>
            <small class="form-text text-muted">비밀답변은 비번을 수정하지 않아야 원게시자가 열람할 수 있습니다.</small>
            <?php endif?>
  				 </div>
  				 <?php endif?>
  				 <?php endif?>

  					<input type="text" name="subject" placeholder="제목 입력..." value="" autocomplete="off">

  			 </div><!-- /.form-list -->

         <div data-role="editor" style="margin-top: -5px;" class="mb-5">
           <div data-role="editor-body" class="editable-container" style="color:#55595c"></div>
         </div>

         <ul class="table-view table-view-full editor-focused-hide mb-0 bg-faded" id="bbs-attach-tree">
   			  <li class="table-view-cell">
   					<a class="navigate-right collapsed" data-toggle="collapse" data-parent="#bbs-attach-tree" data-target="#bbs-collapse-attach-file">
               <span class="badge badge-default badge-inverted" data-role="attachNum"></span>
   			      사진 및 파일
   			    </a>
   			    <!-- 2depth -->
             <div class="collapse mb-0" id="bbs-collapse-attach-file" role="tabpanel" >
               <?php if ($m!='post') getWidget('_default/attach-rc',array('parent_module'=>'bbs','theme'=>'_mobile/rc-post-file','attach_handler_photo'=>'#modal-bbs-write [data-role="attach-handler-photo"]','parent_data'=>$R,'attach_object_type'=>'photo'));?>
             </div>
   			  </li>
   				<li class="table-view-cell">
   					<a class="navigate-right collapsed" data-toggle="collapse" data-parent="#bbs-attach-tree" data-target="#bbs-collapse-attach-link">
               <span class="badge badge-default badge-inverted" data-role="linkNum"></span>
   			      링크
   			    </a>
   			    <!-- 2depth -->
   			    <div class="collapse mb-0" id="bbs-collapse-attach-link">
               <?php if ($m!='post') getWidget('_default/attach-rc',array('parent_module'=>'bbs','theme'=>'_mobile/rc-post-link','parent_data'=>$R,'attach_object_type'=>'link'));?>
             </div>
   			  </li>
   			</ul>

         <ul class="table-view editor-focused-hide bg-white border-top-0" data-role="bbs-meta">
         </ul>

  		</form>

  	</div>
  </section>

  <section id="page-bbs-write-category" class="page right">
  	<header class="bar bar-nav bar-light bg-white p-x-0">
      <a class="icon pull-left material-icons p-x-1" role="button" data-history="back">arrow_back</a>
      <a class="icon icon-check pull-right text-primary p-x-1" role="button" data-history="back"></a>
  		<h1 class="title title-left" data-history="back">
  			카테고리
  		</h1>
  	</header>
  	<div class="content bg-white">
  		<ul class="table-view m-t-0 bg-white border-top-0">
  			<li class="table-view-divider f12 text-muted bg-white border-bottom-0"><?php echo $_catexp[0]?></li>
  			<?php for($i = 1; $i < $_catnum; $i++):if(!$_catexp[$i])continue;?>
  		  <li class="table-view-cell radio" >
  		    <label class="custom-control custom-radio">
  		      <input id="radio-<?php echo $_catexp[$i]?>" name="radio" type="radio" class="custom-control-input" value="<?php echo $_catexp[$i]?>" <?php if($_catexp[$i]==$R['category']||$_catexp[$i]==$cat):?> checked<?php endif?>>
  		      <span class="custom-control-indicator"></span>
  		      <span class="custom-control-description">
  						<?php echo $_catexp[$i]?>
  					</span>
  		    </label>
  		  </li>
  			<?php endfor?>
  		</ul>
  	</div>
  </section>

  <section id="page-bbs-write-attach" class="page right">
  	<header class="bar bar-nav bar-light bg-white p-x-0">
  		<button class="btn btn-link btn-nav pull-left p-x-1" type="button" data-history="back">
  			<span class="icon icon-left-nav"></span>
  			본문작성
  	  </button>
  		<h1 class="title">
  			파일첨부
  		</h1>
  	</header>
  	<div class="bar bar-standard bar-footer bar-light bg-white">
  		<button class="btn btn btn-outline-primary btn-block" data-role="attach-handler-file" data-type="file" title="파일첨부" role="button" data-loading-text="업로드 중...">
  			<i class="fa fa-upload" aria-hidden="true"></i> 파일 불러오기
  		</button>
  	</div>
  	<div class="content bg-faded">

  		<!-- 첨부파일 업로드 -->
  		<?php //include $g['dir_module_skin'].'_uploader.php'?>

  	</div><!-- /.content -->

  </section>

  <section id="page-bbs-write-tag" class="page right">
  	<header class="bar bar-nav bar-light bg-white p-x-0">
      <a class="icon pull-left material-icons p-x-1" role="button" data-history="back">arrow_back</a>
      <a class="icon icon-check pull-right text-primary p-x-1" role="button" data-history="back"></a>
  		<h1 class="title title-left" data-history="back">
  			태그
  		</h1>
  	</header>
  	<div class="content bg-white">
  		<textarea class="form-control border-0" rows="5" name="tag" placeholder="콤마(,)로 구분하여 입력해주세요."><?php echo htmlspecialchars($R['tag'])?></textarea>
  		<div class="content-padded text-muted">
  			<small>이 게시물을 가장 잘 표현할 수 있는 단어를 콤마(,)로 구분해서 입력해 주세요. 통합검색시에 검색어 추천시에 활용됩니다.</small>
  		</div>
  	</div>
  </section>


</div>

<!-- 글쓰기 취소확인 -->
<div id="popup-bbs-cancelCheck" class="popup zoom">
  <div class="popup-content">
    <nav class="bar bar-tab">
      <a class="tab-item" role="button" data-toggle="cancelCheck" data-value="no">
        아니요
      </a>
      <a class="tab-item border-left text-primary" role="button" data-toggle="cancelCheck" data-value="yes">
        예
      </a>
    </nav>
    <div class="content" style="min-height: 115px;">
      <div class="p-a-2 text-xs-center">글쓰기를 취소 하시겠습니까?</div>
    </div>
  </div>
</div>

<!-- 게시물 관리 -->
<div id="popover-bbs-view" class="popover">
  <ul class="table-view">
    <!-- 저장,수정,삭제 항목 동적 추가 -->
    <li class="table-view-cell" data-toggle="linkCopy" data-history="back">URL 복사</li>
    <li class="table-view-cell" data-toggle="linkShare" data-history="back">공유하기...</li>
  </ul>
</div>

<!-- 게시물 관리 -->
<div id="popover-bbs-listMarkup" class="popover">
  <ul class="table-view">
    <li class="table-view-divider"><small>목록타입 변경</small></li>
    <li class="table-view-cell" data-toggle="listMarkup" data-markup="media" data-bid="">
      <i class="material-icons align-middle" style="vertical-align: middle;">view_list</i>
      섬네일형
    </li>
    <li class="table-view-cell" data-toggle="listMarkup" data-markup="avatar" data-bid="">
      <i class="material-icons align-middle" style="vertical-align: middle;">person_pin</i>
      아바타형
    </li>
    <li class="table-view-cell" data-toggle="listMarkup" data-markup="card" data-bid="">
      <i class="material-icons align-middle" style="vertical-align: middle;">view_stream</i>
      카드형
    </li>
    <li class="table-view-cell" data-toggle="listMarkup" data-markup="gallery" data-bid="">
      <i class="material-icons align-middle" style="vertical-align: middle;">view_module</i>
      갤러리형
    </li>
  </ul>
</div>

<?php $bbs_theme_path = '/modules/bbs/themes/'.($bid?$d['bbs']['skin']:$d['bbs']['skin_mobile']);?>
<script src="<?php echo $bbs_theme_path ?>/_js/list.js<?php echo $g['wcache']?>" ></script>
<script src="<?php echo $bbs_theme_path ?>/_js/view.js<?php echo $g['wcache']?>" ></script>
<script src="<?php echo $bbs_theme_path ?>/_js/component.js<?php echo $g['wcache']?>" ></script>
