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

    <?php foreach($RCD as $_R):?>
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
          <?php if(getNew($_R['d_regis'],24)):?>
          <small class="rb-new mr-1" aria-hidden="true"></small>
          <?php endif?>
          <?php echo getStrCut(stripslashes($_R['subject']),100,'..') ?>
        </span>
      </a>
    </li>
    <?php endforeach?>
    <?php if(!db_num_rows($_RCD)):?>
    <li class="table-view-cell text-muted">게시물이 없습니다.</li>
    <?php endif?>
  </ul>
<?php endif; ?>

</section>
