<?php
$B = getDbData($table['bbslist'],'id="'.$wdgvar['bid'].'"','uid');
$size = '400x250'; // 사진 사이즈
$_RCD=getDbArray($table['bbsdata'],($wdgvar['bid']?'bbs='.$B['uid'].' and ':'').'display=1 and notice=0 and site='.$_HS['uid'],'*','gid','asc',$wdgvar['limit'],1);
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수
if (db_num_rows($_RCD) > $recnum) $totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
else  $totalCardRow = 1;
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;
?>

<section class="widget mb-4">
  <header class="d-flex justify-content-between align-items-center py-2 border-bottom">
    <strong><?php echo $wdgvar['title']?></strong>
    <?php if($wdgvar['link']):?>
    <a href="<?php echo $wdgvar['link']?>" class="muted-link small">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php endif?>
  </header>

  <div class="row gutter-half mt-3" data-role="bbs-list">

    <?php $i=0;while($_R=db_fetch_array($_RCD)):$i++?>
    <div class="col">
      <div class="card" id="item-<?php echo $_R['uid'] ?>">
        <a class="text-nowrap text-truncate muted-link" href="<?php echo getBbsPostLink($_R)?>">
          <img src="<?php echo getPreviewResize(getUpImageSrc($_R),$size) ?>" alt="" class="card-img-top">
        </a>
      </div><!-- /.card -->
    </div><!-- /.col -->

    <?php
      $print_card_num++; // 카드 출력될 때마 1씩 증가
      $lack_card_num = $total_card_num - $print_card_num;
     ?>
    <?php if(!($i%$recnum)):?></div><div class="row gutter-half mt-3" data-role="bbs-list"><?php endif?>
    <?php endwhile?>
    <?php if($lack_card_num ):?>
      <?php for($j=0;$j<$lack_card_num;$j++):?>
       <div class="col"></div>
      <?php endfor?>
    <?php endif?>

  </div>  <!-- /.row -->
</section><!-- /.widget -->
