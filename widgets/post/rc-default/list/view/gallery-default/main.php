<?php
$LIST=getDbData($table['postlist'],"id='".$wdgvar['listid']."'",'*');

$_postque = 'site='.$s.' and list="'.$LIST['uid'].'"';
$_RCD=getDbArray($table['postlist_index'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'uid='.$_R['data'],'*');
?>

<section class="widget border-bottom<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

  <?php if ($wdgvar['show_header']=='show'): ?>
  <header>
    <h3><?php echo $LIST['name'] ?></h3>
    <a href="#page-post-listview"
      data-toggle="page"
      data-start="#page-main"
      data-id="<?php echo $wdgvar['listid'] ?>"
      data-title="<?php echo $LIST['name'] ?>"
      data-url="<?php echo getListLink($LIST,0) ?>">
      더보기
    </a>
  </header>
  <?php endif; ?>

  <main class="px-3 <?php echo $wdgvar['show_header']=='show'?' pt-1':' pt-3' ?>">
    <div class="row">
      <?php $i=0;foreach($RCD as $_R):$i++;?>
      <div class="col-xs-6 mb-3">
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
