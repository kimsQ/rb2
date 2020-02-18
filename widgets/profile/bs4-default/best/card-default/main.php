<?php
$orderby = 'desc';
$recnum = $wdgvar['line']; // 한 열에 출력할 카드 갯수
$totalCardRow=ceil($wdgvar['limit']/$recnum); // row 갯수
$total_card_num = $totalCardRow*$recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$query = 'site='.$s.' and ';
$_WHERE1= $query.'date >= '.date("Ymd", strtotime($wdgvar['term'])).' and '.$wdgvar['sort'].'>0';

if ($wdgvar['sort']=='post_hit') $_WHERE2= 'mbruid,sum(post_hit) as post_hit';
if ($wdgvar['sort']=='post_likes') $_WHERE2= 'mbruid,sum(post_likes) as post_likes';
if ($wdgvar['sort']=='post_dislikes') $_WHERE2= 'mbruid,sum(post_dislikes) as post_dislikes';
if ($wdgvar['sort']=='post_comment') $_WHERE2= 'mbruid,sum(post_comment) as post_comment';
if ($wdgvar['sort']=='follower') $_WHERE2= 'mbruid,sum(follower) as follower';

$_RCD	= getDbSelect($table['s_mbrday'],$_WHERE1.' group by mbruid order by '.$wdgvar['sort'].' '.$orderby.' limit 0,'.$wdgvar['limit'],$_WHERE2);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['s_mbrdata'],'memberuid='.$_R['mbruid'],'*');
?>

<section class="widget widget-profile-best-card mb-5">
  <header class="d-flex justify-content-between align-items-center mb-2">
    <div class="">

      <div class="media align-items-center">
        <i class="material-icons mr-2">emoji_events</i>
        <div class="media-body">
          <h5 class="my-0">
            <?php echo $wdgvar['title']?>
            <small class="ml-2 text-muted f13"><?php echo $wdgvar['subtitle']?></small>
          </h5>
        </div>
      </div>

    </div>
    <div class="">
      <?php echo date("m/d", strtotime($wdgvar['term'])).'~'. date("m/d", strtotime("now"))  ?>
    </div>
  </header>

  <div class="card-deck">

    <?php if (!empty($RCD)): ?>
    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm card-mask">
      <a href="<?php echo getProfileLink($R['memberuid']) ?>" class="position-relative">
        <img src="<?php echo getCoverSrc($R['memberuid'],600,350) ?>" class="card-img-top" alt="...">
        <span class="position-absolute badge badge-primary f15 px-2 rounded-0 rank-icon" style="left:0;top:0"><?php echo $i ?></span>
        <span class="position-absolute" data-role="avatar" style="left: 50%;bottom: -15px;margin-left: -32px;">
          <img src="<?php echo getAvatarSrc($R['memberuid'],'64') ?>" class="rounded-circle mr-3 shadow-sm" alt="..." style="width:64px">
        </span>
      </a>
      <div class="card-body pb-2 text-muted f14">
        <p class="card-text line-clamp-3 mb-2 text-center"><?php echo$R['nic'] ?></p>
        <p class="card-text mb-0">
          <span class="text-muted f13"><?php echo getStrCut(stripslashes($R['bio']),100,'..') ?></span>
        </p>
      </div>
      <div class="card-footer border-top-0 bg-white py-1 px-3 d-flex justify-content-between">
        <div>
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">thumb_up</i>
            <span class="ml-1 f13"><?php echo $R['likes_post'] ?></span>
          </button>
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">thumb_down</i>
            <span class="ml-1 f13"><?php echo $R['dislikes_post'] ?></span>
          </button>
        </div>
        <div class="">
          <button type="button" class="btn btn-link text-muted px-1 text-decoration-none">
            <i class="material-icons align-text-bottom f20">visibility</i>
            <span class="ml-1 f13"> <?php echo $R['hit_post'] ?></span>
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
