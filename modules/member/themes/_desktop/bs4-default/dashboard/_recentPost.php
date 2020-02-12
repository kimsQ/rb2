<?php
$wdgvar['limit'] = 9; //전체 출력수
$wdgvar['recnum'] =3; //한 열에 출력할 카드 갯수
$wdgvar['title'] ='최근 포스트';
$wdgvar['link'] = RW('mod=dashboard&page=post');
$recnum = $wdgvar['recnum']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$_postque = 'mbruid='.$my['uid'].' and site='.$s.' and auth=1';
$_NUM = getDbRows($table['postmember'],$_postque);
$_RCD=getDbArray($table['postmember'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>

<section class="widget-post-card-01">
  <header class="d-flex justify-content-between align-items-center py-2">
    <strong><?php echo $wdgvar['title']?></strong>

    <div class="">
      <?php if($wdgvar['link'] && $_NUM):?>
      <a href="<?php echo $wdgvar['link']?>" class="muted-link small">
        더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
      </a>
      <?php endif?>
    </div>

  </header>

  <?php if ($_NUM): ?>
  <div class="card-deck" data-role="post-list">

    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm" id="item-<?php echo $_R['uid'] ?>">
      <a class="position-relative" href="<?php echo getPostLink($R,1) ?>" target="_blank">
        <img src="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'300x168'):getPreviewResize('/files/noimage.png','300x168') ?>" alt="" class="card-img-top">
        <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
        <span class="badge badge-primary rounded-0 position-absolute" style="left:0px;top:0px"><?php echo $R['mbruid']!=$my['uid']?'공유':'' ?></span>
      </a>
      <div class="card-body p-3">
        <h6 class="card-title mb-0 line-clamp-2">
          <a class="muted-link" href="<?php echo RW('m=post&mod=write&cid='.$R['cid']) ?>">
            <?php echo checkPostPerm($R)?getStrCut(stripslashes($R['subject']),100,'..'):'[비공개 포스트]'?>
          </a>
        </h6>
        <small class="text-muted small" >업데이트 : <time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time></small>
      </div><!-- /.card-body -->
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

  </div><!-- /.card-deck -->
  <?php else: ?>
  <div class="text-center text-muted small py-5 border">
    <a href="<?php echo RW('m=post&mod=write')?>" class="btn btn-primary">
      포스트 작성하기
    </a>
  </div>
  <?php endif; ?>

</section><!-- /.widget -->
