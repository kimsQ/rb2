<?php $posts = explode(',',$wdgvar['posts']);?>

<div class="mt-0 content-padded">
  <header>
    <h3><?php echo $wdgvar['title'] ?></h3>
  </header>
  <div class="swiper-container js-swiper-gallery">
    <div class="swiper-wrapper">
      <?php foreach($posts as $_s):?>
      <?php $_R = getDbData($table['postdata'],"cid='".$_s."'",'*'); ?>
      <?php if (!$_R['uid']) continue; ?>
      <div class="swiper-slide" style="width: 40%">
        <div class="card card-video border-0 text-left m-0"
          data-target="#page-post-view"
          data-toggle="page"
          data-start="<?php echo $wdgvar['start'] ?>"
          data-url="/post/<?php echo $_s ?>"
          data-featured="<?php echo getPreviewResize(getUpImageSrc($_R),'640x360') ?>"
          data-format="<?php echo $_R['format']==2?'video':'doc' ?>"
          data-provider="<?php echo getFeaturedimgMeta($_R,'provider'); ?>"
          data-videoid="<?php echo getFeaturedimgMeta($_R,'name'); ?>"
          data-uid="<?php echo $_R['uid'] ?>"
          data-title="<?php echo $_R['subject'] ?>">
          <div class="position-relative">
            <img src="<?php echo getPreviewResize(getUpImageSrc($_R),'250x300') ?>" alt="" class="img-fluid">
            <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px" data-role="time">
              <?php echo getUpImageTime($_R) ?>
            </time>
          </div>
          <p class="text-xs-center text-muted mt-1 line-clamp-2" style="font-size: 0.875rem">
            <?php echo $_R['subject'] ?>
          </p>
        </div>
      </div><!-- /.swiper-slide -->
      <?php endforeach; ?>

    </div>
  </div>
</div><!-- /.content-padded -->




<script>

var swiper_post_gallery = new Swiper('.js-swiper-gallery', {
  spaceBetween: 10,
  slidesPerView: 'auto'
});
</script>
