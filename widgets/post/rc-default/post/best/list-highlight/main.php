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

<section class="widget bg-white">

  <?php if ($wdgvar['show_header']=='show'): ?>
  <header>
    <h3><?php echo $wdgvar['title'] ?></h3>
    <small class="ml-2 text-muted f13"><?php echo $wdgvar['subtitle']?></small>
  </header>
  <?php endif; ?>
  <ul class="table-view table-view-full">

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

        <div class="pull-left mr-3 pt-3">
          <strong class="text-primary"><span><?php echo $i ?></span></strong>
        </div>

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
          <strong class="text-primary mr-2"><?php echo $i ?></strong>
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

</section>
