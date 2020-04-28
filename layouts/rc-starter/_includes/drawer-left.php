<header class="bar bar-nav bar-light bg-white px-0">
  <?php if ($my['uid']): ?>
  <a class="icon icon icon-gear pull-right p-x-1" role="button" data-toggle="modal" href="#modal-settings-general" data-url="/settings"></a>
  <h1 class="title" data-toggle="profile" data-target="#modal-member-profile" data-mbruid="<?php echo $my['uid'] ?>">
    <img class="mt-2 mr-2 pull-left img-circle bg-faded" data-role="avatar" src="<?php echo getAvatarSrc($my['uid'],'56') ?>" style="width:1.75rem">
    <small><?php echo $my['nic']?$my['nic']:$my['name'] ?></small>
  </h1>
  <?php else: ?>
  <a class="icon icon icon-close pull-right p-x-1" role="button" data-toggle="drawer-close" title="드로어닫기"></a>
  <h1 class="title" role="button" data-toggle="modal" href="#modal-login" data-title="<?php echo stripslashes($d['layout']['header_title'])?>">
    로그인 하세요
  </h1>
  <?php endif; ?>
</header>

<?php if ($d['post']['writeperm']): ?>
<nav class="bar bar-tab bg-white">
  <a class="tab-item active bg-primary<?php echo $m=='bbs'?' d-none':'' ?>" role="button"
    data-open="newPost"
    data-start="<?php echo $d['layout']['main_type']=='postAllFeed'?'#page-main':'#page-post-allpost' ?>"
    data-url="/post/write">
    새 포스트
  </a>
</nav>
<?php endif; ?>

<?php if (!$my['uid']): ?>
<nav class="bar bar-tab bg-white">
  <a class="tab-item" role="button" href="#modal-join" data-toggle="modal" data-url="">
    <span class="icon material-icons">account_circle</span>
    <span class="tab-label">회원가입</span>
  </a>
  <a class="tab-item" role="button" href="#modal-login" data-toggle="modal" data-title="<?php echo stripslashes($d['layout']['header_title'])?>">
    <span class="icon material-icons">input</span>
    <span class="tab-label">로그인</span>
  </a>
</nav>
<?php endif; ?>


<div class="content bg-white">

  <ul class="table-view bg-white mt-0 mb-2 border-top-0" id="drawer-menu">

    <li class="table-view-cell">
  		<a class="" data-href="<?php echo RW(0)?>" data-toggle="drawer-close">
  			<div class="media-body">
  				홈
  			</div>
  		</a>
  	</li>

    <?php getWidget('rc-default/site/menu/drawer-default',array('smenu'=>'0','limit'=>'2','link'=>'link','collid'=>'drawer-menu','accordion'=>'1','collapse'=>'1',))?>

    <?php if ($d['layout']['main_type']!='postAllFeed'): ?>
    <li class="table-view-cell table-view-divider small">포스트</li>
    <li class="table-view-cell">
      <a data-toggle="goMypage" data-target="#page-post-allpost" data-start="#page-main" data-title="최신 포스트"  data-url="/post">
        <span class="badge badge-default badge-inverted"><?php echo $my['num_post']?number_format($my['num_post']):'' ?></span>
        <div class="media-body">
          최신 포스트
        </div>
      </a>
    </li>
    <?php endif; ?>

    <?php if ($my['uid']): ?>
    <li class="table-view-cell table-view-divider small">내 보관함</li>

    <?php if ($d['post']['writeperm']): ?>
    <li class="table-view-cell">
      <a data-toggle="goMypage" data-target="#page-post-mypost" data-start="#page-main" data-title="내 포스트"  data-url="<?php echo RW('mod=dashboard&page=post')?>">
        <span class="badge badge-default badge-inverted"><?php echo $my['num_post']?number_format($my['num_post']):'' ?></span>
        <div class="media-body">
          내 포스트
        </div>
      </a>
    </li>
    <?php endif; ?>

    <li class="table-view-cell">
      <a data-toggle="goMypage" data-target="#page-post-mylist" data-start="#page-main" data-title="내 리스트" data-url="<?php echo RW('mod=dashboard&page=list')?>">
        <span class="badge badge-default badge-inverted"><?php echo $my['num_list']?number_format($my['num_list']):'' ?></span>
        <div class="media-body">
          내 리스트
        </div>
      </a>
    </li>
    <li class="table-view-cell">
      <a data-toggle="goMypage" data-target="#page-post-saved" data-start="#page-main" data-title="나중에 볼 포스트" data-url="<?php echo RW('mod=dashboard&page=saved')?>">
        <span class="badge badge-default badge-inverted"></span>
        <div class="media-body">
          나중에 볼 포스트
        </div>
      </a>
    </li>
    <li class="table-view-cell">
      <a data-toggle="goMypage" data-target="#page-post-liked" data-start="#page-main" data-title="좋아요 한 포스트">
        <span class="badge badge-default badge-inverted"></span>
        <div class="media-body">
          좋아요 한 포스트
        </div>
      </a>
    </li>
    <?php endif; ?>

    <?php if ($my['admin']): ?>
    <li class="table-view-cell table-view-divider small">관리자 전용</li>
    <li class="table-view-cell">
      <a data-href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=settings&prelayout=rc-starter/blank' ?>" data-toggle="drawer-close">
        레이아웃 편집
      </a>
    </li>
    <li class="table-view-cell">
      <a data-href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=system&prelayout=rc-starter/blank' ?>" data-toggle="drawer-close" data-text="업데이트를 확인하는 중..">
        시스템 정보
      </a>
    </li>
    <?php endif; ?>
  </ul>

</div>
