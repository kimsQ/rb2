<div class="user-profile-nav">
  <nav class="nav underline-nav">
    <a class="nav-link f16<?php if ($page=='main'): ?> active<?php endif; ?>" href="/<?php echo $mbrid ?>">요약</a>
    <a class="nav-link f16<?php if ($page=='bbs'): ?> active<?php endif; ?>" href="/<?php echo $mbrid ?>?page=project" data-toggle="tooltip" title="프로젝트">
      게시물 <span class="badge badge-pill badge-light"> <?php echo $NUM_PROJECT ?> </span>
    </a>
    <a class="nav-link f16<?php if ($page=='comment'): ?> active<?php endif; ?>" href="/<?php echo $mbrid ?>?page=project" data-toggle="tooltip" title="프로젝트">
      댓글 <span class="badge badge-pill badge-light"> <?php echo $NUM_PROJECT ?> </span>
    </a>
    <a class="nav-link f16<?php if ($page=='follower'): ?> active<?php endif; ?>" href="/<?php echo $mbrid ?>?page=follower" data-toggle="tooltip" title="팔로워">
      팔로워
      <span class="badge badge-pill badge-light"> <?php echo getDbRows($table['s_friend'],'by_mbruid='.$_MH['uid'])?></span>
    </a>
    <a class="nav-link f16<?php if ($page=='following'): ?> active<?php endif; ?>" href="/<?php echo $mbrid ?>?page=following" data-toggle="tooltip" title="팔로잉">
      팔로잉
      <span class="badge badge-pill badge-light"> <?php echo getDbRows($table['s_friend'],'my_mbruid='.$_MH['uid'])?></span>
    </a>

  </nav>
</div>
