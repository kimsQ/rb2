<?php
$B = getDbData($table['bbslist'],'id="'.$wdgvar['bbsid'].'"','uid');
$size = '400x250'; // 사진 사이즈

if ($wdgvar['view']=='modal') {
  @include $g['path_var'].'bbs/var.'.$wdgvar['bbsid'].'.php';
  $d['bbs']['skin'] = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
  $g['url_module_skin'] = $g['s'].'/modules/bbs/themes/'.$d['bbs']['skin'];
  $g['dir_module_skin'] = $g['path_module'].'bbs/themes/'.$d['bbs']['skin'].'/';
  @include_once $g['dir_module_skin'].'_widget.php';
}

$_RCD=getDbArray($table['bbsdata'],($wdgvar['bbsid']?'bbs='.$B['uid'].' and ':'').'display=1 and site='.$_HS['uid'],'*','gid','asc',$wdgvar['limit'],1);
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수
if (db_num_rows($_RCD) > $recnum) $totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
else  $totalCardRow = 1;
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;
?>

<section class="widget-bbs-card-01 mb-4">
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

        <?php if ($wdgvar['view']=='modal'): ?>
        <a class="text-nowrap text-truncate muted-link"
          href="#modal-bbs-view" data-toggle="modal"
          data-bid="<?php echo $wdgvar['bbsid'] ?>"
          data-uid="<?php echo $_R['uid'] ?>"
          data-url="<?php echo getBbsPostLink($_R)?>"
          data-cat="<?php echo $_R['category'] ?>"
          data-title="<?php echo $wdgvar['title']?>"
          data-subject="<?php echo $_R['subject']?>">
          <?php else: ?>
          <a class="text-nowrap text-truncate muted-link" href="<?php echo getBbsPostLink($_R)?>">
          <?php endif; ?>
          <img src="<?php echo getUpImageSrc($_R)?getPreviewResize(getUpImageSrc($_R),$size):'/files/noimage_'.$size.'.png' ?>" alt="" class="card-img-top">
        </a>
        <div class="card-body">
          <h6 class="card-title mb-0">
            <a class="muted-link" href="<?php echo getBbsPostLink($_R)?>">
              <?php echo $_R['subject'] ?>
            </a>
          </h6>
          <time class="text-muted small" data-plugin="timeago" datetime="<?php echo getDateFormat($_R['d_regis'],'c')?>">
            <?php echo getDateFormat($_R['d_regis'],'Y.m.d')?>
          </time>
          <?php if(getNew($_R['d_regis'],24)):?><span class="rb-new ml-1"></span><?php endif?>

          <div class="card-text text-muted f12 mt-2">
            <?php echo getStrCut(str_replace('&nbsp;',' ',strip_tags($_R['content'])),100,'..')?>
          </div>

        </div>

        <div class="card-footer d-table p-0 text-center text-muted w-100">
          <ul class="d-table-row">
            <li class="d-table-cell p-2 border-right">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
               <span data-role="likes"><?php echo $_R['likes']?></span>
            </li>
            <li class="d-table-cell p-2 border-right">
              <i class="fa fa-eye" aria-hidden="true"></i>
              <?php echo $_R['hit']?>
            </li>
            <li class="d-table-cell p-2">
              <i class="fa fa-comment-o" aria-hidden="true"></i>
              <span data-role="total_comment"><?php echo $_R['comment']?></span>
            </li>
          </ul>
        </div>
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
