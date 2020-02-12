<ul class="nav nav-tabs mb-4">
  <li class="nav-item">
    <a class="nav-link rounded-0<?php echo $layoutPage=='settings' &&  !$type?' active':''?>"
      href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=settings'?>">
      레이아웃 편집
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link rounded-0<?php echo $layoutPage=='settings' &&  $type?' active':''?>"
      href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=settings&type=mainedit'?>">
      메인 꾸미기
    </a>
  </li>
</ul>
