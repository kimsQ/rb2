<?php
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$where = $where?$where:'subject|tag|review';
$sort	= 'gid';
$orderby= 'asc';

$_WHERE = 'site='.$s;
if (!$my['uid']) $_WHERE .= ' and display=5';
else $_WHERE .= ' and display>3';
$_WHERE .= getSearchSql($where,$wdgvar['tag'],$ikeyword,'or');

$TCD = getDbArray($table['postdata'],$_WHERE,'*',$sort,$orderby,$wdgvar['limit'],1);
while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
?>

<?php if ($wdgvar['tag']): ?>
<section class="widget mb-4">
  <header class="d-flex justify-content-between align-items-center mb-2">

    <?php if ($wdgvar['tag']): ?>
    <div class="">
      <div class="media align-items-center">
        <i class="material-icons mr-2">flag</i>
        <div class="media-body">
          <h5 class="my-0">
            <?php if ($wdgvar['tag']): ?>
            #<?php echo $wdgvar['tag'] ?>
            <?php else: ?>
            <span class="text-danger">키워드를 설정해 주세요.</span>
            <?php endif; ?>
            <small class="ml-2 text-muted f13"><?php echo $wdgvar['subtitle'] ?></small>
          </h5>
        </div>
      </div>

    </div>
    <div class="">
      <a href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo $wdgvar['tag'] ?>" class="btn btn-white btn-sm">더보기</a>
    </div>
    <?php else: ?>
    <div class="text-center text-danger">
      태그를 설정해 주세요.
    </div>
    <?php endif; ?>
  </header>

  <div class="card-deck">

    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm">
      <div class="card-header bg-white border-bottom-0 text-muted f13">
        <a href="<?php echo getProfileLink($R['mbruid']) ?>" class="text-reset text-decoration-none">
          <img src="<?php echo getAvatarSrc($R['mbruid'],'24') ?>" class="rounded-circle mr-2" alt="" style="width:24px"> <?php echo getProfileInfo($R['mbruid'],$_HS['nametype']) ?>
          <span class="ml-1">• <time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time></span>
        </a>
      </div>
      <div class="card-body pt-0 pb-2 f14">

        <a href="<?php echo getPostLink($R,0) ?>" class="media text-reset text-decoration-none">
          <div class="media-body">
            <div class="line-clamp-1">
              <?php echo getStrCut(stripslashes($R['subject']),100,'..') ?>
            </div>
            <div class="line-clamp-4 f13 text-muted ">
              <?php echo $R['review'] ?>
            </div>
          </div>
          <img src="<?php echo getPreviewResize(getUpImageSrc($R),'100x100') ?>" class="ml-3" alt="...">
        </a>

      </div>
      <div class="card-footer border-top-0 bg-white py-1 px-3 d-flex justify-content-between">
        <div>
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">thumb_up</i>
            <span class="ml-1 f13"><?php echo $R['likes'] ?></span>
          </button>
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">thumb_down</i>
            <span class="ml-1 f13"><?php echo $R['dislikes'] ?></span>
          </button>
        </div>
        <div class="">
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">comment</i>
            <span class="ml-1 f13"><?php echo $R['comment'] ?></span>
          </button>
        </div>
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

    <?php if(!db_num_rows($TCD)):?>
    <div class="card text-center text-muted p-5">
      자료가 없습니다.
    </div>
    <?php endif?>

  </div><!-- /.card-deck -->

</section>
<?php else: ?>
<div class="p-5 mb-4 text-muted text-center border">태그를 지정해 주세요.</div>
<?php endif; ?>
