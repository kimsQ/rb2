<?php
$query = 'site='.$s;
if ($my['uid']) $query .= ' and display>3';
else $query .= ' and display=5';

$_WHERE1= $query.' and date >= '.date("Ymd", strtotime($wdgvar['term'])).' and '.$wdgvar['sort'].'>0';

if ($wdgvar['sort']=='hit') $_WHERE2= 'data,sum(hit) as hit';
if ($wdgvar['sort']=='likes') $_WHERE2= 'data,sum(likes) as likes';
if ($wdgvar['sort']=='comment') $_WHERE2= 'data,sum(comment) as comment';

$orderby = 'desc';
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수

$_RCD	= getDbSelect($table['postday'],$_WHERE1.' group by data order by '.$wdgvar['sort'].' '.$orderby.' limit 0,'.$wdgvar['limit'],$_WHERE2);

if (db_num_rows($_RCD) > $recnum) $totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
else  $totalCardRow = 1;

$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'uid='.$_R['data'],'*');
?>

<section class="widget widget-post-best-card mb-4">
  <header class="d-flex justify-content-between align-items-center mb-2">
    <div class="">

      <div class="media align-items-center">
        <i class="material-icons mr-2">emoji_objects</i>
        <div class="media-body">
          <h5 class="my-0">
            <?php echo $wdgvar['title']?>
            <small class="ml-2 text-muted f13"><?php echo $wdgvar['subtitle']?></small>
          </h5>
        </div>
      </div>

    </div>
    <div class="">
    </div>
  </header>

  <div class="card-deck">

    <?php if (!empty($RCD)): ?>
    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm card-mask">
      <a href="<?php echo getPostLink($R,1) ?>" class="position-relative">
        <img src="<?php echo getPreviewResize(getUpImageSrc($R),'400x225') ?>" class="card-img-top" alt="...">
        <span class="position-absolute badge badge-primary f15 px-2 rounded-0 rank-icon" style="left:0;top:0"><?php echo $i ?></span>
        <time class="badge badge-dark rounded-0 position-absolute f14 font-weight-light" style="right:0;bottom:0"><?php echo getUpImageTime($R) ?></time>
      </a>
      <div class="card-body pb-0 f14">
        <a href="<?php echo getPostLink($R,1) ?>" class="text-reset text-decoration-none line-clamp-2 mb-1"><?php echo$R['subject'] ?></a>
        <a href="<?php echo getProfileLink($R['mbruid']) ?>" class="d-block f13 text-muted text-decoration-none">
          <?php echo getProfileInfo($R['mbruid'],$_HS['nametype']) ?>
        </a>
      </div>
      <div class="card-footer border-top-0 bg-white py-1 px-3 d-flex justify-content-between">
        <div>
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">thumb_up</i>
            <span class="ml-1 f13"><?php echo $R['likes'] ?></span>
          </button>
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">visibility</i>
            <span class="ml-1 f13"><?php echo $R['hit'] ?></span>
          </button>
        </div>
        <div class="">
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">comment</i>
            <span class="ml-1 f13"> <?php echo $R['comment'] ?></span>
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
      <?php for($j=0;$j<$lack_card_num;$j++):?>
       <div class="card border-0" style="background-color: transparent"></div>
      <?php endfor?>
    <?php endif?>

    <?php else: ?>
    <div class="card text-center text-muted p-5">
      자료가 없습니다.
    </div>
    <?php endif?>

  </div><!-- /.card-deck -->


</section>
