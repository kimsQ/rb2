<?php

$LIST=getDbData($table['postlist'],"id='".$wdgvar['listid']."'",'*');

$_postque = 'site='.$s.' and list="'.$LIST['uid'].'"';
$_RCD=getDbArray($table['postlist_index'],$_postque,'*','gid','asc',$wdgvar['limit'],1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'uid='.$_R['data'],'*');
?>

<?php if ($wdgvar['listid']): ?>
<section class="widget mb-4">
  <?php if ($wdgvar['disTitle']=='true'): ?>
  <header class="d-flex justify-content-between align-items-center d-flex justify-content-between align-items-center mb-2 content-padded">

    <?php if ($LIST['uid']): ?>
    <div class="">
      <div class="media align-items-center">
        <div class="media-body">
          <h5 class="my-0">
            <a href="" class="text-decoration-none text-reset" data-url="<?php echo getListLink($LIST,1) ?>">
              <?php echo $LIST['name'] ?>
            </a>
            <a href="<?php echo getProfileLink($LIST['mbruid']) ?>" class="ml-2 text-decoration-none text-muted f13">
              <?php echo getProfileInfo($LIST['mbruid'],'nic') ?>
            </a>
          </h5>
        </div>
      </div>

    </div>
    <div class="">
      <a href="<?php echo getListLink($LIST,1) ?>" class="btn btn-white btn-sm">더보기</a>
    </div>
    <?php else: ?>
    <div class="text-center text-danger">
      리스트 아이디를 확인해주세요.
    </div>
    <?php endif; ?>

  </header>
  <?php endif; ?>

  <div class="card-deck border-bottom">

    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card<?php echo $wdgvar['cardmargin']=='true'?'':' card-full' ?>">
      <a class="position-relative"
        href="#modal-post-view"
        data-toggle="modal"
        data-url="<?php echo getPostLink($R,1) ?>"
        data-featured="<?php echo getPreviewResize(getUpImageSrc($R),'650x365') ?>"
        data-format="<?php echo $R['format']==2?'video':'doc' ?>"
        data-provider="<?php echo getFeaturedimgMeta($R,'provider'); ?>"
        data-videoid="<?php echo getFeaturedimgMeta($R,'name'); ?>"
        data-uid="<?php echo $R['uid'] ?>"
        data-title="<?php echo $R['subject'] ?>">

        <img src="<?php echo getPreviewResize(getUpImageSrc($R),'650x365') ?>" class="card-img-top img-fluid" alt="...">
        <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($R) ?></time>
      </a>
      <div class="card-block">
        <p class="card-text line-clamp-2 mb-2">
          <a class="text-reset text-decoration-none" href="<?php echo getPostLink($R,1) ?>">
            <?php echo getStrCut(stripslashes($R['subject']),100,'..') ?>
          </a>
        </p>
        <ul class="list-inline d-inline-block f13 text-muted mb-0">
          <li class="list-inline-item">조회수 <?php echo $R['hit']?>회</li>
          <li class="list-inline-item">
            •<time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
          </li>
        </ul>
      </div>
    </div>

    <?php endforeach?>


    <?php if(!db_num_rows($_RCD)):?>
    <div class="card text-xs-center text-muted p-5 small">
      자료가 없습니다.
    </div>
    <?php endif?>

  </div><!-- /.card-deck -->

</section>
<?php else: ?>
<div class="p-5 mb-4 text-muted text-center border">리스트 아이디를 지정해주세요.</div>
<?php endif; ?>
