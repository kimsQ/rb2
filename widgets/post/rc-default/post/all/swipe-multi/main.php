<?php
$_postque = 'site='.$s.' and display=5';
if ($my['uid'])  $_postque .= ' or display=4';

$_RCD=getDbArray($table['postindex'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>

<section class="widget swipe-default border-bottom<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

  <?php if ($wdgvar['show_header']=='show'): ?>
  <header>
    <h3><?php echo $wdgvar['title'] ?></h3>
    <a href="#page-post-allpost"
      data-toggle="page"
      data-start="#page-main"
      data-title="<?php echo $wdgvar['title'] ?>"
      data-url="<?php echo $wdgvar['link'] ?>">
      더보기
    </a>
  </header>
  <?php endif; ?>

  <main class="position-relative pl-3 pb-3 <?php echo $wdgvar['show_header']=='show'?' pt-0':' pt-3' ?>">

    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php $i=0;foreach($RCD as $_R):$i++;?>
        <div class="swiper-slide" style="width: <?php echo $wdgvar['perview'] ?>">
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
              <img src="<?php echo getPreviewResize(getUpImageSrc($_R),'500x280') ?>" class="img-fluid border" alt="">
              <?php if ($_R['format']==2): ?>
              <?php if ($wdgvar['duration']=='show'): ?>
              <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_R) ?></time>
              <?php else: ?>
              <i class="fa fa-play-circle-o fa-lg position-absolute" style="right:6px;bottom:6px;color: rgba(255, 255, 255, 0.9);"></i>
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
    </div><!-- /.swiper-container -->

  </main>

</section>

<script>
  var swiper = new Swiper('.widget.swipe-default .swiper-container', {
    spaceBetween: 10,
    slidesPerView: 'auto'
  });
</script>
