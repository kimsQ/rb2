<?php
$LIST=getDbData($table['postlist'],"id='".$wdgvar['listid']."'",'*');

$_postque = 'site='.$s.' and list="'.$LIST['uid'].'"';
$_RCD=getDbArray($table['postlist_index'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'uid='.$_R['data'],'*');
?>

<?php if ($wdgvar['listid']): ?>
<section class="widget bg-white<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

  <?php if ($wdgvar['show_header']=='show'): ?>
  <header>
    <h3>
      <span class="badge badge-info badge-outline align-bottom mr-1"><?php echo $wdgvar['title_badge'] ?></span>
      <?php echo $LIST['name'] ?>
    </h3>
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

  <ul class="table-view table-view-full<?php echo $wdgvar['show_header']=='hide' && $wdgvar['margin_top']=='false'?' border-top-0':''  ?>">

    <?php $i=0;foreach($RCD as $_R):$i++;?>
    <?php if ($i<=$wdgvar['highlight']): ?>
    <li class="table-view-cell">
      <a data-uid="<?php echo $_R['uid'] ?>"
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
        data-title="<?php echo $_R['subject'] ?>">

        <?php if (getUpImageSrc($_R)): ?>
        <div class="position-relative pull-left mr-2">
          <img class="media-object border"
            src="<?php echo getPreviewResize(getUpImageSrc($_R),'231x130') ?>" style="width:95px">
          <?php if ($_R['format']==2): ?>
          <?php if ($wdgvar['duration']=='show'): ?>
          <time class="badge badge-default bg-black rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_R) ?></time>
          <?php else: ?>
          <i class="fa fa-play-circle-o fa-lg position-absolute" style="right:8px;bottom:8px;color: rgba(255, 255, 255, 0.9);"></i>
          <?php endif; ?>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="media-body">
          <span class="line-clamp-2">
            <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
          </span>
          <div class="d-flex justify-content-between mt-1">
            <time <?php echo $wdgvar['timeago']=='true'?'data-plugin="timeago"':'' ?> datetime="<?php echo getDateFormat($_R['d_regis'],'c')?>" class="badge badge-default badge-inverted">
              <?php echo getDateFormat($_R['d_regis'],'Y.m.d H:i')?>
            </time>
            <?php if($_R['comment']):?>
            <span class="badge badge-default badge-inverted">
              <i class="fa fa-comment-o mr-1" aria-hidden="true"></i>
              <?php echo $_R['comment']?><?php echo $_R['oneline']?'+'.$_R['oneline']:''?>
            </span>
            <?php endif?>
          </div>
        </div>
      </a>
    </li>
    <?php else: ?>
    <li class="table-view-cell">
      <a data-uid="<?php echo $_R['uid'] ?>"
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
        data-title="<?php echo $_R['subject'] ?>">
        <span class="line-clamp-1">
          <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
        </span>
      </a>
    </li>
    <?php endif; ?>


    <?php endforeach?>
    <?php if(!db_num_rows($_RCD)):?>
    <li class="table-view-cell text-muted">게시물이 없습니다.</li>
    <?php endif?>
  </ul>
<?php endif; ?>

</section>
