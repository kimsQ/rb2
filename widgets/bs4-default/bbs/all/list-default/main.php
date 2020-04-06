<?php
$B = getDbData($table['bbslist'],'id="'.$wdgvar['bid'].'"','uid');
?>

<section class="widget mb-4">
  <header class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
    <strong><?php echo $wdgvar['title']?></strong>
    <?php if($wdgvar['link']):?>
    <a href="<?php echo $wdgvar['link']?>" class="muted-link small">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php endif?>
  </header>
  <ul class="list-group list-group-flush" data-role="bbs-list">

    <?php $_RCD=getDbArray($table['bbsdata'],($wdgvar['bid']?'bbs='.$B['uid'].' and ':'').'display=1 and site='.$_HS['uid'],'*','gid','asc',$wdgvar['limit'],1)?>
  	<?php while($_R=db_fetch_array($_RCD)):?>

    <li class="list-group-item d-flex justify-content-between align-items-center px-0" id="item-<?php echo $_R['uid'] ?>">
      <a class="text-nowrap text-truncate muted-link" href="<?php echo getBbsPostLink($_R)?>">
        <?php echo getStrCut($_R['subject'],$wdgvar['sbjcut'],'..')?>
      </a>
      <?php if(getNew($_R['d_regis'],24)):?><span class="rb-new mx-1"></span><?php endif?>
      <?php if($_R['comment']):?><span class="badge badge-light"><?php echo $_R['comment']?><?php if($_R['oneline']):?>+<?php echo $_R['oneline']?><?php endif?></span><?php endif?>
    </li>
    <?php endwhile?>
    <?php if(!db_num_rows($_RCD)):?><div class="none"></div><?php endif?>
  </ul>
</section><!-- /.widget -->
