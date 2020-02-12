<?php
$B = getDbData($table['bbslist'],'id="'.$wdgvar['bid'].'"','*');
include_once $g['path_module'].'bbs/themes/'.$d['bbs']['skin_mobile'].'/_widget.php';
?>

<section class="widget bg-white">

  <header class="d-flex justify-content-between align-items-center p-2">
    <strong><?php echo $wdgvar['title']?></strong>
    <?php if($wdgvar['link']):?>
    <a class="muted-link small"
      href="#page-bbs-list"
      data-toggle="page"
      data-start="#page-main"
      data-bid="<?php echo $wdgvar['bid'] ?>"
      data-url="<?php echo $wdgvar['link'] ?>"
      data-title="<?php echo $wdgvar['title']?>">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php endif?>
  </header>

  <ul class="table-view mb-0" data-role="bbs-list">

    <?php $_RCD=getDbArray($table['bbsdata'],($wdgvar['bid']?'bbs='.$B['uid'].' and ':'').'display=1 and site='.$_HS['uid'],'*','gid','asc',$wdgvar['limit'],1)?>
  	<?php while($_R=db_fetch_array($_RCD)):?>

    <li class="table-view-cell" id="item-<?php echo $_R['uid'] ?>">
      <a class="text-nowrap text-truncate"
        href="#page-bbs-view" data-toggle="page"
        data-start="#page-main"
        data-bid="<?php echo $wdgvar['bid'] ?>"
        data-uid="<?php echo $_R['uid'] ?>"
        data-url="<?php echo getBbsPostLink($_R)?>"
        data-cat="<?php echo $_R['category'] ?>"
        data-title="<?php echo $wdgvar['title']?>"
        data-name="<?php echo $_R['nic']?>"
        data-mbruid="<?php echo $_R['mbruid']?>"
        data-hit="<?php echo $_R['hit']?>"
        data-d_regis="<?php echo getDateFormat($_R['d_regis'],'Y.m.d H:i'); ?>"
        data-comment="<?php echo $_R['comment']?><?php echo $_R['oneline']?'+'.$_R['oneline']:'' ?>"
        data-avatar="<?php echo getAvatarSrc($_R['mbruid'],'150'); ?>"
        data-subject="<?php echo $_R['subject'] ?>">
        <?php if(getNew($_R['d_regis'],24)):?>
        <small class="rb-new mr-1" aria-hidden="true"></small>
        <?php endif?>
        <?php echo $_R['subject'] ?>
      </a>
      <span class="badge badge-inverted" data-role="total_comment">
        <?php echo $_R['comment']?><?php echo $_R['oneline']?'+'.$_R['oneline']:'' ?>
      </span>

    </li>
    <?php endwhile?>
    <?php if(!db_num_rows($_RCD)):?>
      <li class="table-view-cell text-muted">게시물이 없습니다.</li>
    <?php endif?>
  </ul>
</section><!-- /.widget -->
