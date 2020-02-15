<?php
$_postque = 'site='.$s.' and display=5';
if ($my['uid'])  $_postque .= ' or display=4';

$_RCD=getDbArray($table['postindex'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>

<section class="widget rb-jumbotron border-bottom <?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

  <div class="swiper-container js-swipe-jumbotron">
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
          <div class="<?php echo $wdgvar['mask']=='show'?'rb-photomask':'' ?>">
            <img src="<?php echo getPreviewResize(getUpImageSrc($_R),'640x360') ?>" class="img-fluid" alt="">
            <?php if ($wdgvar['subject']=='show'): ?>
            <div class="position-absolute text-white w-75 pl-3" style="left:1px;bottom:15px">
              <div class="line-clamp-1 mb-1">
                <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
              </div>
            </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
      <?php endforeach?>
    </div><!-- /.swiper-wrapper -->
    <div class="swiper-pagination small badge badge-pill"></div>
  </div><!-- /.swiper-container -->

</section>





<script>
  var swiper = new Swiper('.widget .js-swipe-jumbotron', {
    centeredSlides: true,

    <?php if ($wdgvar['effect']=='fade'): ?>
    effect: 'fade',
    <?php endif; ?>

    <?php if ($wdgvar['autoplay']=='true'): ?>
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    <?php endif; ?>

    pagination: {
      el: '.widget .js-swipe-jumbotron .swiper-pagination',
      type: 'fraction'
    },
  });
</script>
