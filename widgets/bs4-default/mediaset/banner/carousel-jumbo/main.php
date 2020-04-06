<style>
.widget.carousel-jumbo .carousel-item {
  background-repeat: no-repeat;
  background-position: 50% 50%;
  background-size: auto auto
}
</style>

<?php
$_mediasetque = 'site='.$s.' and category="'.$wdgvar['category'].'"';
$_RCD=getDbArray($table['s_upload'],$_mediasetque,'*','pid','asc',$wdgvar['limit'],1);
?>

<section class="widget carousel carousel-jumbo mb-4"  class="carousel slide" data-ride="carousel" id="banner-main">

  <?php if ($wdgvar['category']): ?>
  <ol class="carousel-indicators">
    <?php $i=0;foreach($_RCD as $_R):?>
    <li data-target="#banner-main" data-slide-to="<?php echo $i ?>" class="<?php echo $i==0?' active':'' ?>"></li>
    <?php $i++;endforeach?>
  </ol>

  <div class="carousel-inner">
    <?php $i=0;foreach($_RCD as $_R):?>
    <div class="carousel-item<?php echo $i==0?' active':'' ?>" style="height: 350px;background-image: url('<?php echo $_R['src'] ?>')" >
      <?php if ($_R['linkurl']): ?>
      <a href="<?php echo $_R['linkurl'] ?>" target="<?php echo $wdgvar['linktarget'] ?>">
        <img src="/_core/images/blank.gif" alt="" style="width: 100%;height:350px">
        <div class="carousel-caption d-none d-md-block">
          <h5><?php echo $_R['caption'] ?></h5>
          <p><?php echo $_R['description'] ?></p>
        </div>
      </a>
      <?php else: ?>
      <div class="carousel-caption d-none d-md-block">
        <div class="carousel-caption d-none d-md-block">
          <h5><?php echo $_R['caption'] ?></h5>
          <p><?php echo $_R['description'] ?></p>
        </div>
      </div>
      <?php endif; ?>
    </div>
  <?php $i++;endforeach?>
  </div>

  <a class="carousel-control-prev" href="#banner-main" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">이전</span>
  </a>
  <a class="carousel-control-next" href="#banner-main" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">다음</span>
  </a>

  <?php if(!db_num_rows($_RCD)):?>
  <div class="d-flex justify-content-center align-items-center text-muted bg-light" style="height: 350px">
    자료가 없습니다.
  </div>
  <?php endif?>

  <?php else: ?>
  <div class="d-flex justify-content-center align-items-center text-muted bg-light" style="height: 350px">
    미디어셋 카테고리를 지정해 주세요.
  </div>
  <?php endif; ?>

</section>

<script>
$('.carousel').carousel({
  <?php if ($wdgvar['autoplay']!='false') echo 'interval: '.$wdgvar['autoplay'] ?>
})
</script>
