<?php
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

if ($my['uid']) $_postque = 'site='.$s.' and display>3';
else $_postque = 'site='.$s.' and display=5';

$_RCD=getDbArray($table['postindex'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>
<section class="widget mb-4">
  <header class="d-flex justify-content-between align-items-center mb-2">
    <div class="">

      <div class="media align-items-center">
        <div class="media-body">
          <h5 class="my-0">
            <?php echo $wdgvar['title']?>
            <small class="ml-2 text-muted f13"><?php echo $wdgvar['subtitle']?></small>
          </h5>
        </div>
      </div>

    </div>
    <div class="">
      <?php if($wdgvar['link']):?>
      <a href="<?php echo $wdgvar['link']?>" class="btn btn-white btn-sm">더보기</a>
      <?php endif?>
    </div>
  </header>

  <div class="card-deck">

    <?php if (!empty($RCD)): ?>
    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm">
      <a class="position-relative" href="<?php echo getPostLink($R,1) ?>">
        <img src="<?php echo getPreviewResize(getUpImageSrc($R),'400x225') ?>" class="card-img-top" alt="...">
        <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($R) ?></time>
      </a>
      <div class="card-body py-3">
        <p class="card-text line-clamp-2 mb-2">
          <a class="text-reset text-decoration-none" href="<?php echo getPostLink($R,1) ?>">
            <?php echo getStrCut(stripslashes($R['subject']),100,'..') ?>
          </a>
        </p>
        <a href="<?php echo getProfileLink($R['mbruid']) ?>" class="d-block f14 text-muted text-decoration-none">
          <?php echo getProfileInfo($R['mbruid'],$_HS['nametype']) ?>
        </a>
        <ul class="list-inline d-inline-block f13 text-muted mb-0">
          <li class="list-inline-item">조회수 <?php echo $R['hit']?>회</li>
          <li class="list-inline-item">
            •<time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
          </li>
        </ul>
      </div>
    </div>

    <?php
      $print_card_num++; // 카드 출력될 때마 1씩 증가
      $lack_card_num = $total_card_num - $print_card_num;
     ?>

    <?php if(!($i%$recnum)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
    <?php endforeach?>

    <?php if($lack_card_num ):?>
      <?php for($j=0;$j<$lack_card_num;$j++):$i++;?>
       <div class="card border-0" style="background-color: transparent"></div>
       <?php if(!($i%$recnum)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
      <?php endfor?>
    <?php endif?>

    <?php else:?>
    <div class="card text-center text-muted p-5">
      자료가 없습니다.
    </div>
    <?php endif?>

  </div><!-- /.card-deck -->

</section>
