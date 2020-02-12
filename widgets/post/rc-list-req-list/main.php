<?php $lists = explode(',',$wdgvar['lists']);?>

<?php if ($wdgvar['lists']): ?>
<div class="mt-0 content-padded">

  <header class="d-flex justify-content-between mb-1">
    <h3><?php echo $wdgvar['title'] ?></h3>
    <div class="f13 text-muted" data-toggle="page" href="#page-post-alllist" data-start="#page-main" data-url="<?php echo $wdgvar['link'] ?>">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </div>
  </header>

  <ul class="media-list">

      <?php foreach($lists as $_s):?>
      <?php $_R = getDbData($table['postlist'],"id='".$_s."'",'*'); ?>
      <?php if (!$_R['uid']) continue; ?>
      <li class="media mb-2"
      data-target="#page-post-listview"
      data-toggle="page"
      data-start="<?php echo $wdgvar['start'] ?>"
    	data-uid="<?php echo $_R['uid'] ?>"
    	data-title="<?php echo $_R['name'] ?>"
    	data-featured="<?php echo getPreviewResize(getListImageSrc($_R['uid']),'480x270'); ?>"
      data-url="/list/<?php echo $_s ?>" data-id="<?php echo $_s ?>">

        <div class="media-left">
      		<span class="embed-responsive embed-responsive-16by9 bg-faded">
            <img src="<?php echo getPreviewResize(getListImageSrc($_R['uid']),'480x270'); ?>" class="media-object img-fluid" alt="" style="width:160px">
            <span class="list_mask">
              <span class="txt"><?php echo $_R['num'] ?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
            </span>
          </span>
        </div>

        <div class="media-body pt-1">
          <h4 class="media-heading f15 line-clamp-2"><?php echo $_R['name'] ?></h4>
      		<div class="f14">동영상 <?php echo $_R['num'] ?>개</div>
      		<ul class="list-inline f13 text-muted mt-1 mb-0">
      			<li class="list-inline-item"><?php echo getProfileInfo($_R['mbruid'],'nic') ?></li>
      			<li class="list-inline-item"><time data-plugin="timeago" datetime="<?php echo getDateFormat($_R['d_modify']?$_R['d_modify']:$_R['d_regis'],'c') ?>"></time></li>
      		</ul>
        </div>

      </li>
      <?php endforeach; ?>

  </ul>
</div><!-- /.content-padded -->
<?php endif; ?>
