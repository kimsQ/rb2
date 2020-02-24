<!-- Sheet : 답글(oneline)보기 -->
<div id="sheet-comment-online" class="sheet">
  <header class="bar bar-nav bar-light bg-white" data-history="back" >
    <a class="icon icon-close pull-right px-2" role="button"></a>
    <h1 class="title title-left px-3">답글</h1>
  </header>
  <main class="pb-0" data-role="comment">
    <ul class="media-list mt-3 mb-0" data-role="list"></ul>
  </main>
</div>

<!-- Sheet : 신규 댓글작성 -->
<div id="sheet-comment-write" class="sheet">
  <fieldset data-role="commentWrite-container">
    <div data-role="comment-input-wrapper">
      <ul class="table-view mb-0 collapse" id="sheet-comment-write-toolbar">
        <li class="table-view-cell text-muted bg-faded">
          비밀글
          <small class="ml-1">운영자에게만 공개</small>
          <div data-toggle="switch" data-role="comment-hidden" class="switch">
            <div class="switch-handle"></div>
          </div>
        </li>
        <li class="table-view-cell py-0 px-2 bg-faded">
          <div class="toolbar-container align-self-end"></div>
        </li>
      </ul>
      <div class="d-flex border-0 rounded-0 align-items-center" data-role="form">
        <img class="img-circle bg-faded ml-3" data-role="avatar" src="<?php echo getAvatarSrc($my['uid'],'100') ?>" style="width:2.25rem;height:2.25rem">
        <section class="w-100">
          <div data-role="editor">
        		<div data-role="comment-input" id="meta-description-content" class="border-0"></div>
        	</div>
        </section>
        <button class="btn btn-link align-self-end" type="submit" data-kcact="regis">
          <span class="not-loading">
            <i class="material-icons">send</i>
          </span>
          <span class="is-loading">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </span>
        </button>
        <button class="btn btn-link align-self-end" type="button" data-toggle="collapse" data-target="#sheet-comment-write-toolbar">
          <i class="material-icons">more_vert</i>
        </button>
      </div>
    </div>
  </fieldset>
</div>

<!-- Popup : 댓글관리 -->
<div id="popup-comment-mypost" class="popup zoom">
  <div class="popup-content">
    <div class="content" style="min-height: 5rem;">
      <ul class="table-view table-view-full mt-0 text-xs-center">
        <li class="table-view-cell">
          <a data-toggle="commentWrite" data-act="edit">수정하기</a>
        </li>
        <li class="table-view-cell">
          <a data-kcact="delete">삭제하기</a>
        </li>

        <li class="table-view-cell" data-role="comment">
          <a data-kcact="notice">상단고정 <span></span></a>
        </li>

        <li class="table-view-cell d-none">
          <a data-kcact="report">신고하기</a>
        </li>
        <li class="table-view-cell" data-role="comment">
          <a data-toggle="commentWrite">댓글 답글쓰기</a>
        </li>
      </ul>
    </div>
  </div>
</div>


<script src="/modules/comment/lib/Rb.comment.js"></script>
<script src="/modules/comment/themes/<?php echo $d['comment']['skin_mobile'] ?>/component.js<?php echo $g['wcache']?>" ></script>
