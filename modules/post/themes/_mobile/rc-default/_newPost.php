<?php
$wdgvar['limit'] = 3; //전체 출력수
$postque = 'mbruid='.$M1['memberuid'].' and site='.$s.' and data <>'.$R['uid'];

if ($my['uid']) $postque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $postque .= ' and display = 5'; // 전체공개 포스트만 출력

$_RCD=getDbArray($table['postmember'],$postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');

$_NUM = getDbRows($table['postmember'],$postque);
?>


<section class="widget-post-card-01">

  <?php if ($_NUM): ?>
  <ul class="table-view table-view-sm border-top-0 mt-2" data-role="newPost">

    <?php $i=0;foreach($RCD as $POST):$i++;?>
      <li class="media mb-2">

        <a href="<?php echo getPostLink($POST,1) ?>" class="position-relative mr-2">
          <img class="" src="<?php echo getPreviewResize(getUpImageSrc($POST),'160x90') ?>" alt="" >
          <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($POST) ?></time>
        </a>

        <div class="media-body">
          <h5 class="h6 my-1 font-weight-light line-clamp-3">
            <a href="<?php echo getPostLink($POST,1) ?>" class="text-reset" ><?php echo stripslashes($POST['subject'])?></a>
          </h5>
          <div class="mb-1">
            <ul class="list-inline d-inline-block f13 text-muted">
              <li class="list-inline-item">조회수 <?php echo $POST['hit']?>회 </li>
              <li class="list-inline-item">
                <time data-plugin="timeago" datetime="<?php echo getDateFormat($POST['d_regis'],'c')?>"></time>
              </li>
            </ul>

          </div>
        </div>
      </li>
    <?php endforeach?>

  </ul>
  <?php else: ?>
  <div class="p-5 text-muted text-center border mb-3">
    내역이 없습니다.
  </div>
  <?php endif; ?>

</section><!-- /.widget -->
