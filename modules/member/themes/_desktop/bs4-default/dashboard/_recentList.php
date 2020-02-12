<?php
$wdgvar['limit'] = 6; //전체 출력수
$wdgvar['recnum'] =3; //한 열에 출력할 카드 갯수
$wdgvar['title'] ='최근 리스트';
$wdgvar['link'] = RW('mod=dashboard&page=list');
$recnum = $wdgvar['recnum']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$_listque = 'mbruid='.$my['uid'].' and site='.$s;
$_NUM = getDbRows($table['postlist'],$_listque);
$_RCD=getDbArray($table['postlist'],$_listque,'*','gid','asc',$wdgvar['limit'],1);
?>

<section class="widget-post-card-01">
  <header class="d-flex justify-content-between align-items-center py-2">
    <strong><?php echo $wdgvar['title']?></strong>
    <?php if($wdgvar['link'] && $_NUM):?>
    <a href="<?php echo $wdgvar['link']?>" class="muted-link small">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php endif?>
  </header>

  <?php if ($_NUM): ?>
  <div class="card-deck" data-role="post-list">

    <?php $i=0;foreach($_RCD as $R):$i++;?>
    <div class="card shadow-sm" id="item-<?php echo $_R['uid'] ?>">

      <a class="position-relative" href="<?php echo RW('mod=dashboard&page=list_view&id='.$R['id'])?>">
        <img src="<?php echo getPreviewResize(getListImageSrc($R['uid']),'300x168') ?>" alt="" class="card-img-top">
        <span class="list_mask">
          <span class="txt"><?php echo $R['num']?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
        </span>
      </a>
      <div class="card-body p-3">
        <h6 class="card-title mb-0 line-clamp-2">
          <a class="muted-link" href="<?php echo RW('mod=dashboard&page=list_view&id='.$R['id'])?>">
            <?php echo getStrCut($R['name'],100,'..')?>
          </a>
        </h6>
        <small class="text-muted small" >업데이트 : <time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_last']?$R['d_last']:$R['d_regis'],'c')?>"></time></small>
      </div>

    </div><!-- /.card -->

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

  </div>  <!-- /.row -->
  <?php else: ?>
  <div class="text-center text-muted small py-5 border">
    리스트가 없습니다.
  </div>
  <?php endif; ?>

</section><!-- /.widget -->
