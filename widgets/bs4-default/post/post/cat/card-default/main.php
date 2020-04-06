<?php
$wdgvar['link'] = RW('mod=dashboard&page=post');
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$CAT  = getDbData($table['postcategory'],"id='".$wdgvar['cat']."'",'*');

include_once $g['path_module'].'post/_main.php';

$_postque = 'site='.$s.' and ('.getPostCategoryCodeToSql($table['postcategory'],$wdgvar['cat']).')';
if (!$my['uid']) $_postque .= ' and display<>4';

$_RCD=getDbArray($table['postcategory_index'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'uid='.$_R['data'],'*');
?>

<section class="widget mb-4">
  <header class="d-flex justify-content-between align-items-center mb-2">

    <?php if ($CAT['uid']): ?>
    <div class="">
      <div class="media align-items-center">
        <i class="material-icons mr-2">folder</i>
        <div class="media-body">
          <h5 class="my-0">
            <a href="#" class="text-reset text-decoration-none">
              <?php echo $CAT['name'] ?>
            </a>
          </h5>
        </div>
      </div>

    </div>
    <div class="">
      <a href="#" class="btn btn-white btn-sm">더보기</a>
    </div>
    <?php else: ?>
    <div class="text-center text-danger">
      카테고리 아이디를 확인해주세요.
    </div>
    <?php endif; ?>

  </header>

  <div class="card-deck">

    <?php if (!empty($RCD)): ?>
    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm">
      <a class="position-relative" href="<?php echo getPostLink($R,0) ?>">
        <img src="<?php echo getPreviewResize(getUpImageSrc($R),'400x225') ?>" class="card-img-top" alt="...">
        <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($R) ?></time>
      </a>
      <div class="card-body">
        <p class="card-text line-clamp-2 mb-2">
          <a class="text-reset text-decoration-none" href="<?php echo getPostLink($R,0) ?>">
            <?php echo getStrCut(stripslashes($R['subject']),100,'..') ?>
          </a>
        </p>
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
    <?php endif?>

    <?php if($lack_card_num ):?>
      <?php for($j=0;$j<$lack_card_num;$j++):$i++;?>
       <div class="card border-0" style="background-color: transparent"></div>
       <?php if(!($i%$recnum)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
      <?php endfor?>
    <?php endif?>

    <?php if(!$_RCD):?>
    <div class="card text-center text-muted p-5">
      자료가 없습니다.
    </div>
    <?php endif?>

  </div><!-- /.card-deck -->

</section>
