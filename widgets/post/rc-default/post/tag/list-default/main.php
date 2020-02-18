<?php
$where = $wdgvar['where']?$wdgvar['where']:'subject|tag|review';
$sort	= $wdgvar['sort']?$wdgvar['sort']:'gid';

if ($sort=='gid') $orderby= 'asc';
else $orderby= 'desc';

$_WHERE = 'site='.$s;
if (!$my['uid']) $_WHERE .= ' and display=5';
else $_WHERE .= ' and display>3';
$_WHERE .= getSearchSql($where,$wdgvar['tag'],$ikeyword,'or');

$_RCD = getDbArray($table['postdata'],$_WHERE,'*',$sort,$orderby,$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = $_R;
?>

<section class="widget bg-white<?php echo $wdgvar['margin_top']=='true'?'':' mt-0 border-top-0' ?>">

  <?php if ($wdgvar['show_header']=='show'): ?>
  <header>
    <h3>
      <?php echo $wdgvar['title']?$wdgvar['title']:'<span class="badge badge-info badge-outline mr-1">키워드</span> '.$wdgvar['tag'] ?>
    </h3>
    <a href="#page-post-keyword"
      data-toggle="page"
      data-keyword="<?php echo $wdgvar['tag'] ?>"
      data-start="#page-main"
      data-title="# <?php echo $wdgvar['tag'] ?> 검색결과"
      data-url="/post/search?keyword=<?php echo $wdgvar['tag'] ?>">
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
          <?php if(getNew($_R['d_regis'],$wdgvar['newtime'])):?>
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

</section>
