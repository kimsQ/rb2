<header class="bar bar-nav bar-light bg-white px-0" data-snap-ignore="true">
  <a href="#drawer-left" data-toggle="drawer" class="icon icon-bars pull-left p-x-1" role="button"></a>

  <?php if($d['layout']['header_noti']=='true'):?>
  <a class="icon pull-right p-r-1 pl-1" role="button" data-toggle="drawer" href="#drawer-right" data-direction="right" data-showType="expand" data-history="true">
    <span class="material-icons ">notifications_none</span>
    <span class="badge badge-pill badge-danger noti-status" data-role="noti-status"><?php echo $my['num_notice']==0?'':$my['num_notice']?></span>
  </a>
  <?php endif?>

  <?php if($d['layout']['header_search']=='true'):?>
  <a class="icon material-icons pull-right px-1" role="button" data-toggle="modal" href="#modal-search" data-title="검색">search</a>
  <?php endif?>

  <a class="title" data-href="<?php echo RW(0)?>" data-text="새로고침">
    <?php echo $d['layout']['header_file']?'<img src="'.$g['url_layout'].'/_var/'.$d['layout']['header_file'].'">':stripslashes($d['layout']['header_title'])?>
  </a>
</header>
