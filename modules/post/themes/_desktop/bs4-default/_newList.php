<?php
$wdgvar['limit'] = 3; //전체 출력수
$wdgvar['title'] ='최근 리스트';
$listque = 'mbruid='.$M1['memberuid'].' and site='.$s;

if ($my['uid']) $listque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $listque .= ' and display = 5'; // 전체공개 포스트만 출력

if ($list) $listque .= ' and id <>'.$list;

$_RCD=getDbArray($table['postlist'],$listque,'*','gid','asc',$wdgvar['limit'],1);
$_NUM = getDbRows($table['postlist'],$listque);
?>

<section class="widget-post-card-01">
  <header class="d-flex justify-content-between align-items-center py-2">
    <span><?php echo $wdgvar['title']?></span>
  </header>

  <?php if ($_NUM): ?>
  <ul class="list-unstyled">

    <?php $i=0;foreach($_RCD as $LIST):$i++;?>
    <li class="media mb-2">

      <a href="<?php echo getListLink($LIST,1) ?>" class="position-relative mr-2">
        <img class="" src="<?php echo getPreviewResize(getListImageSrc($LIST['uid']),'160x90') ?>" alt="">
        <span class="list_mask">
          <span class="txt"><?php echo $LIST['num']?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
        </span>
      </a>

      <div class="media-body">
        <h5 class="h6 my-1 font-weight-light line-clamp-3">
          <a href="<?php echo getListLink($LIST,1) ?>" class="text-reset" ><?php echo $LIST['name']?></a>
        </h5>
        <div class="mb-1">
          <ul class="list-inline d-inline-block f13 text-muted">
            <li class="list-inline-item">
              <time data-plugin="timeago" datetime="<?php echo getDateFormat($LIST['d_regis'],'c')?>"></time>
            </li>
          </ul>

        </div>
      </div>
    </li>
    <?php endforeach?>
  </ul>
  <?php else: ?>
  <div class="p-5 text-muted text-center border mb-3">
    리스트가 없습니다.
  </div>
  <?php endif; ?>
</section><!-- /.widget -->
