<?php
$wdgvar['limit'] = 3; //전체 출력수
$wdgvar['recnum'] =3; //한 열에 출력할 카드 갯수
$wdgvar['title'] ='최근 포스트';
$recnum = $wdgvar['recnum']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$postque = 'mbruid='.$_MP['uid'].' and site='.$s;

if ($my['uid']) $postque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $postque .= ' and display = 5'; // 전체공개 포스트만 출력

$_RCD=getDbArray($table['postmember'],$postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');

$_NUM = getDbRows($table['postmember'],$postque);
?>

<section class="widget-post-card-01">
  <header class="d-flex justify-content-between align-items-center py-2">
    <strong><?php echo $wdgvar['title']?></strong>
    <?php if($wdgvar['link']):?>
    <a href="<?php echo $wdgvar['link']?>" class="muted-link small">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php endif?>
  </header>

  <?php if ($_NUM): ?>
  <div class="row gutter-half" data-role="post-list">

    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="col">
      <div class="card border-0" id="item-<?php echo $_R['uid'] ?>">

        <a class="text-nowrap text-truncate muted-link position-relative" href="<?php echo getPostLink($R,1) ?>">
          <img src="<?php echo getPreviewResize(getUpImageSrc($R),'320x180') ?>" alt="" class="card-img-top border">
          <time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo getUpImageTime($R) ?></time>
        </a>
        <div class="card-body py-3 px-0">
          <h6 class="card-title mb-0 line-clamp-2">
            <a class="muted-link" href="<?php echo getPostLink($R,1) ?>">
              <?php echo getStrCut(stripslashes($R['subject']),100,'..')?>
            </a>
          </h6>
          <time class="text-muted small" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>"></time>
          <span class="badge badge-light"><?php echo  checkPostOwner($R) && $R['display']!=5?$g['displaySet']['label'][$R['display']]:'' ?></span>
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
    포스트가 없습니다.
  </div>
  <?php endif; ?>

</section><!-- /.widget -->
