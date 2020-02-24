<header class="bar bar-nav bar-light px-0" data-snap-ignore="true">
  <a href="#drawer-left" data-toggle="drawer" class="icon icon-bars pull-left p-x-1" role="button"></a>

  <?php if($my['uid'] && $d['layout']['header_noti']=='true'):?>
  <a class="icon pull-right p-r-1 pl-1" role="button"
    data-toggle="page"
    href="#page-noti-list"
    data-start="#page-main"
    data-url="<?php echo RW('mod=noti')?>">
    <span class="material-icons ">notifications_none</span>
    <span class="badge badge-pill badge-danger noti-status" data-role="noti-status"><?php echo $my['num_notice']==0?'':$my['num_notice']?></span>
  </a>
  <?php endif?>

  <?php if($d['layout']['header_search']=='true'):?>
  <a class="icon material-icons pull-right px-1" role="button"
    data-toggle="modal"
    href="#modal-search"
    data-url="/search"
    data-title="검색">search</a>
  <?php endif?>

  <h1 class="title" data-href="<?php echo RW(0)?>" data-text="새로고침">
    <?php echo $d['layout']['header_title']?stripslashes($d['layout']['header_title']):$_HS['name'] ?>
  </h1>
</header>
