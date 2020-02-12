<?php
$_postque = 'site='.$s.' and display=5';
if ($my['uid'])  $_postque .= ' or display=4';

$_RCD=getDbArray($table['postindex'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
?>

<div class="content-padded">

  <header class="">
    <h3><?php echo $wdgvar['title'] ?></h3>
    <div class="f13 text-muted" data-toggle="page" data-target="#page-post-allpost" data-start="#page-main" data-url="<?php echo $wdgvar['link'] ?>">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </div>
  </header>

  <div class="row">

    <?php $i=0;foreach($RCD as $_R):$i++;?>
    <div class="col-xs-6">
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
          <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_R) ?></time>
        </div>


        <div class="line-clamp-1 mt-1 f14 text-muted">
          <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
        </div>
      </div>
    </div>
    <?php endforeach?>

  </div>


</div><!-- /.content-padded -->
