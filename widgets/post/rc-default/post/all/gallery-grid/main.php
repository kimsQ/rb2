<?php
$_postque = 'site='.$s.' and display=5';
if ($my['uid'])  $_postque .= ' or display=4';

$_RCD=getDbArray($table['postindex'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>

<section class="widget border-bottom<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?> rb-photogrid">

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

  <main class="content-padded <?php echo $wdgvar['show_header']=='show'?' pt-0':' pt-3' ?>">
    <?php if ($wdgvar['subtitle']): ?>
    <p class="mb-1 content-padded">
      <small class="text-muted"><?php echo $wdgvar['subtitle'] ?>.</small>
    </p>
    <?php endif; ?>
    <div class="row gutter-half">
      <?php $i=0;foreach($RCD as $_R):$i++;?>
      <div class="col-xs-4">
        <a class=""
          <?php if ($wdgvar['vtype']=='modal'): ?>
          data-toggle="modal"
          href="#modal-post-view"
          <?php else: ?>
          data-toggle="page"
          href="#page-post-view"
          data-start="#page-main"
          <?php endif; ?>
          data-url="/post/<?php echo $_R['cid'] ?>"
          data-featured="<?php echo getPreviewResize(getUpImageSrc($_R),'640x360') ?>"
          data-format="<?php echo $_R['format']==2?'video':'doc' ?>"
          data-provider="<?php echo getFeaturedimgMeta($_R,'provider'); ?>"
          data-videoid="<?php echo getFeaturedimgMeta($_R,'name'); ?>"
          data-uid="<?php echo $_R['uid'] ?>"
          data-title="<?php echo $_R['subject'] ?>">
          <span class="rank-icon active"></span>
          <?php if ($wdgvar['author']=='true'): ?>
          <small class="nic-name"><?php echo getProfileInfo($_R['mbruid'],$_HS['nametype']) ?></small>
          <?php endif; ?>

          <?php if ($_R['format']==2): ?>
          <?php if ($wdgvar['duration']=='show'): ?>
          <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_R) ?></time>
          <?php else: ?>
          <i class="fa fa-play-circle-o position-absolute" style="right:8px;bottom:5px;color: rgba(255, 255, 255, 0.8);"></i>
          <?php endif; ?>
          <?php endif; ?>

          <img src="<?php echo getPreviewResize(getUpImageSrc($_R),'350x350') ?>" class="img-fluid" alt="">
        </a>
      </div>
      <?php endforeach?>
    </div><!-- /.row -->
  </main>

</section>
