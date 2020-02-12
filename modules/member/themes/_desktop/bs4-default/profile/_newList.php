<?php
$wdgvar['limit'] = 3; //전체 출력수
$wdgvar['recnum'] =3; //한 열에 출력할 카드 갯수
$wdgvar['title'] ='최근 리스트';
$recnum = $wdgvar['recnum']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$listque = 'mbruid='.$_MP['uid'].' and site='.$s;

if ($my['uid']) $listque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $listque .= ' and display = 5'; // 전체공개 포스트만 출력

$_RCD=getDbArray($table['postlist'],$listque,'*','gid','asc',$wdgvar['limit'],1);
$_NUM = getDbRows($table['postlist'],$listque);
?>

<section class="widget-post-card-01">
  <header class="d-flex justify-content-between align-items-center py-2">
    <strong><?php echo $wdgvar['title']?></strong>
  </header>

  <?php if ($_NUM): ?>
  <div class="row gutter-half" data-role="post-list">

    <?php $i=0;foreach($_RCD as $R):$i++;?>
    <div class="col">
      <div class="card border-0" id="item-<?php echo $_R['uid'] ?>">

        <a class="position-relative" href="<?php echo getListLink($R,1) ?>">
          <img src="<?php echo getPreviewResize(getListImageSrc($R['uid']),'320x180') ?>" alt="" class="card-img-top border">
          <span class="list_mask">
            <span class="txt"><?php echo $R['num']?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
          </span>
        </a>
        <div class="card-body py-3 px-0">
          <h6 class="card-title mb-0 line-clamp-2">
            <a class="muted-link" href="<?php echo getListLink($R,1) ?>">
              <?php echo getStrCut($R['name'],100,'..')?>
            </a>
          </h6>
          <time class="text-muted small" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>"></time>
          <?php if ($_IS_PROFILEOWN): ?>
          <span class="badge badge-light"><?php echo $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>
          <?php endif; ?>

        </div>

      </div><!-- /.card -->
    </div><!-- /.col -->

    <?php
      $print_card_num++; // 카드 출력될 때마 1씩 증가
      $lack_card_num = $total_card_num - $print_card_num;
     ?>

    <?php if(!($i%$recnum)):?></div><div class="row gutter-half mt-3" data-role="post-list"><?php endif?>
    <?php endforeach?>

    <?php if($lack_card_num ):?>
      <?php for($j=0;$j<$lack_card_num;$j++):?>
       <div class="col"></div>
      <?php endfor?>
    <?php endif?>

  </div>  <!-- /.row -->
  <?php else: ?>
  <div class="p-5 text-muted text-center border mb-3">
    리스트가 없습니다.
  </div>
  <?php endif; ?>
</section><!-- /.widget -->
