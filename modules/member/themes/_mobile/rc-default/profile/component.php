<!--
회원 모듈 프로필 포론트 컴포넌트 모음

1. 페이지 : 프로필 메인
1. 모달 : 프로필 메인

-->

<div data-role="profile-wapper">

  <div id="modal-member-profile" class="modal fast" data-mbruid="" data-role="profile">
    <header class="bar bar-nav px-0 border-bottom-0" data-snap-ignore="true">
      <a class="icon material-icons pull-left px-3" role="button" data-history="back">arrow_back</a>
      <a class="icon material-icons pull-right pl-2 pr-3" role="button" data-toggle="modal" data-target="#modal-search">search</a>
      <h1 class="title title-left" data-history="back">
        <span data-role="title"></span>
      </h1>
    </header>
    <div class="bar bar-header-secondary  border-bottom-0 p-x-0 shadow-sm">
      <nav class="nav nav-inline" style="margin-top: 0.1875rem;"></nav>
    </div>
    <div class="content bg-white" data-control="scroll" data-type="updown" data-defaultHeight="180"></div>
  </div><!-- /.modal -->

</div>

<div id="sheet-member-profile" class="sheet shadow-sm">
  <div class="content-padded py-1">
    <div class="media" data-history="back">
      <span class="media-left media-middle">
        <img data-role="avatar" class="border rounded-circle" style="width:4.6875rem">
      </span>
      <div class="media-body">
        <h6 class="media-heading mb-2">
          <span data-role="nic"></span>
          <small class="ml-1 text-muted" data-role="ismy"></small>
        </h6>
        <p class="text-muted f12 mb-1 pr-2 line-clamp-3" data-role="bio" style="line-height: 1.35"></p>
        <div class="d-flex justify-content-between align-items-end">
          <div class="">
            <span class="badge badge-inverted">구독자 <span class="ml-1" data-role="num_follower"></span></span>
            <span class="badge badge-inverted">포스트 <span class="ml-1" data-role="num_post"></span></span>
            <span class="badge badge-inverted">리스트 <span class="ml-1" data-role="num_list"></span></span>
          </div>
          <div class="">

          </div>
        </div><!-- /.d-flex -->
      </div>
    </div>
  </div>
  <ul class="table-view mb-0">
    <li class="table-view-cell" data-role="follower">
      구독
      <span class="badge badge-pill d-none" data-role="isfollowing">구독중</span>
      <button type="button" class="btn btn-outline-primary d-none"
        data-title="채널을 구독하시겠습니까?"
        data-subtext="채널을 구독하려면 로그인하세요."
        data-toggle="follow"
        data-mbruid="">
        구독하기
      </button>
    </li>
    <li class="table-view-cell">
      <a class="navigate-right" data-toggle="profile" data-target="#modal-member-profile" data-change="true">
        채널 바로가기
      </a>
    </li>
  </ul>
</div>

<script src="/modules/member/themes/<?php echo $d['member']['theme_mobile']?>/profile/profile.js<?php echo $g['wcache']?>" ></script>
<script src="/modules/member/themes/<?php echo $d['member']['theme_mobile']?>/profile/component.js<?php echo $g['wcache']?>" ></script>
