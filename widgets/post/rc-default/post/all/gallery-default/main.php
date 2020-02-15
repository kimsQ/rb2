<?php
$_postque = 'site='.$s.' and display=5';
if ($my['uid'])  $_postque .= ' or display=4';

$_RCD=getDbArray($table['postindex'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>

<section class="widget border-bottom<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

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

  <main class="px-3 <?php echo $wdgvar['show_header']=='show'?' pt-1':' pt-3' ?>">
    <div class="row">
      <?php $i=0;foreach($RCD as $_R):$i++;?>
      <div class="col-xs-6 mb-3">
        <div class="" data-target="#page-post-view"
          data-toggle="page"
          data-start="#page-main"
          data-url="/post/<?php echo $_R['cid'] ?>"
          data-featured="<?php echo getPreviewResize(getUpImageSrc($_R),'640x360') ?>"
          data-format="<?php echo $_R['format']==2?'video':'doc' ?>"
          data-provider="<?php echo getFeaturedimgMeta($_R,'provider'); ?>"
          data-videoid="<?php echo getFeaturedimgMeta($_R,'name'); ?>"
          data-uid="<?php echo $_R['uid'] ?>"
          data-title="<?php echo $_R['subject'] ?>">
          <div class="position-relative">
            <img src="<?php echo getPreviewResize(getUpImageSrc($_R),'350x196') ?>" class="img-fluid" alt="">
            <?php if ($_R['format']==2): ?>
            <?php if ($wdgvar['duration']=='show'): ?>
            <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_R) ?></time>
            <?php else: ?>
            <i class="fa fa-play-circle-o fa-lg position-absolute" style="right:8px;bottom:8px;color: rgba(255, 255, 255, 0.9);"></i>
            <?php endif; ?>
            <?php endif; ?>
          </div>
          <div class="mt-2 px-1">
            <div class="line-clamp-2">
              <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
            </div>
            <?php if ($wdgvar['author']=='true'): ?>
            <span class="badge badge-primary badge-inverted"><?php echo getProfileInfo($_R['mbruid'],$_HS['nametype']) ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach?>
    </div><!-- /.row -->
  </main>

</section>
