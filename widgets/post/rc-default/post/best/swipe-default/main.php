<?php
$query = 'site='.$s;
if ($my['uid']) $query .= ' and display>3';
else $query .= ' and display=5';

$_WHERE1= $query.' and date >= '.date("Ymd", strtotime($wdgvar['term'])).' and '.$wdgvar['sort'].'>0';

if ($wdgvar['sort']=='hit') $_WHERE2= 'data,sum(hit) as hit';
if ($wdgvar['sort']=='likes') $_WHERE2= 'data,sum(likes) as likes';
if ($wdgvar['sort']=='comment') $_WHERE2= 'data,sum(comment) as comment';

$orderby = 'desc';
$active_ranking = (int)$wdgvar['ranking']+1;

$_RCD	= getDbSelect($table['postday'],$_WHERE1.' group by data order by '.$wdgvar['sort'].' '.$orderby.' limit 0,'.$wdgvar['limit'],$_WHERE2);

while($R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'uid='.$R['data'],'*');
?>

<section class="widget border-bottom<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

  <?php if ($wdgvar['show_header']=='show'): ?>
  <header>
    <h3><?php echo $wdgvar['title'] ?></h3>
    <small class="ml-2 text-muted f13"><?php echo $wdgvar['subtitle']?></small>
  </header>
  <?php endif; ?>

  <main class="position-relative px-3 <?php echo $wdgvar['show_header']=='show'?' pt-1':' pt-3' ?>">

    <div class="swiper-container js-swipe-default" style="height: 280px">
      <div class="swiper-wrapper">
        <?php $i=0;foreach($RCD as $_R):$i++;?>
        <div class="swiper-slide">
          <div class=""
            <?php if ($wdgvar['vtype']=='modal'): ?>
            data-toggle="modal"
            data-target="#modal-post-view"
            <?php else: ?>
            data-toggle="page"
            data-target="#page-post-view"
            data-start="#page-main"
            <?php endif; ?>
            data-url="/post/<?php echo $_R['cid'] ?>"
            data-featured="<?php echo getPreviewResize(getUpImageSrc($_R),'640x360') ?>"
            data-format="<?php echo $_R['format']==2?'video':'doc' ?>"
            data-provider="<?php echo getFeaturedimgMeta($_R,'provider'); ?>"
            data-videoid="<?php echo getFeaturedimgMeta($_R,'name'); ?>"
            data-uid="<?php echo $_R['uid'] ?>"
            data-title="<?php echo $_R['subject'] ?>">
            <div class="position-relative">
              <span class="rank-icon <?php echo $wdgvar['ranking']!='false' && $i<$active_ranking?' active':'' ?>" style="line-height: 1.6;">
                <span><?php echo $i ?></span>
              </span>
              <img src="<?php echo getPreviewResize(getUpImageSrc($_R),'640x360') ?>" class="img-fluid" alt="">
              <?php if ($_R['format']==2): ?>
              <?php if ($wdgvar['duration']=='show'): ?>
              <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_R) ?></time>
              <?php else: ?>
              <i class="fa fa-play-circle-o fa-lg position-absolute" style="right:15px;bottom:15px;color: rgba(255, 255, 255, 0.9);"></i>
              <?php endif; ?>
              <?php endif; ?>
            </div>
            <div class="mt-2 px-1">
              <div class="line-clamp-1 mb-1">
                <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
              </div>
              <?php if ($wdgvar['author']=='true'): ?>
              <span class="badge badge-default badge-inverted"><?php echo getProfileInfo($_R['mbruid'],$_HS['nametype']) ?></span>
              <?php endif; ?>
              <span class="badge badge-default badge-inverted"><?php echo getDateFormat($_R['d_regis'],'Y.m.d H:i')?></span>
            </div>
          </div>
        </div>
        <?php endforeach?>
      </div><!-- /.swiper-wrapper -->
      <div class="swiper-pagination" style="bottom:18px"></div>
    </div><!-- /.swiper-container -->

  </main>

</section>

<script>
  var swiper = new Swiper('.widget .js-swipe-default', {
    spaceBetween: 30,
    pagination: {
      el: '.widget .js-swipe-default .swiper-pagination',
    },
  });
</script>
