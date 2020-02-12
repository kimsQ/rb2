<?php
$B = getDbData($table['bbslist'],'id="'.$wdgvar['bid'].'"','uid');
$size = $wdgvar['width'].'x'.$wdgvar['height']; // 사진 사이즈
$print_width = $wdgvar['width'] / 2;  // 실제 출력할 사진의 가로사이즈 (모바일 디스플레이의 특성상 2배수 해상도 필요)

include_once $g['path_var'].'bbs/var.'.$wdgvar['bid'].'.php';
$d['bbs']['skin'] = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
$d['bbs']['c_mskin_modal'] = $d['bbs']['c_mskin_modal']?$d['bbs']['c_mskin_modal']:$d['bbs']['comment_mobile_modal'];

$g['url_module_skin'] = $g['s'].'/modules/bbs/themes/'.$d['bbs']['skin'];
$g['dir_module_skin'] = $g['path_module'].'bbs/themes/'.$d['bbs']['skin'].'/';
include_once $g['dir_module_skin'].'_widget.php';
?>

<section class="widget">
  <header class="d-flex justify-content-between align-items-center p-2">
    <strong><?php echo $wdgvar['title']?></strong>
    <?php if($wdgvar['link']):?>
    <a href="<?php echo $wdgvar['link']?>" class="muted-link small">
      더보기 <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
    <?php endif?>
  </header>
  <ul class="widget table-view table-view-full" data-role="bbs-list">

    <?php $_RCD=getDbArray($table['bbsdata'],($wdgvar['bid']?'bbs='.$B['uid'].' and ':'').'display=1 and site='.$_HS['uid'],'*','gid','asc',$wdgvar['limit'],1)?>
    <?php while($_R=db_fetch_array($_RCD)):?>
    <li class="table-view-cell media" id="item-<?php echo $_R['uid'] ?>">
      <a role="button" id="item-<?php echo $_R['uid'] ?>"
        href="#modal-bbs-view" data-toggle="modal"
        data-bid="<?php echo $wdgvar['bid'] ?>"
        data-uid="<?php echo $_R['uid'] ?>"
        data-url="<?php echo getBbsPostLink($_R)?>"
        data-cat="<?php echo $_R['category'] ?>"
        data-title="<?php echo $wdgvar['title']?>"
        data-subject="<?php echo $_R['subject'] ?>">
        <img class="media-object pull-left" src="<?php echo getPreviewResize(getUpImageSrc($_R),$size) ?>" style="width: <?php echo $print_width ?>px">
        <div class="media-body">
          <?php if(getNew($_R['d_regis'],24)):?>
          <small class="rb-new mr-1" aria-hidden="true"></small>
          <?php endif?>
           <?php echo $_R['subject']?>
          <p><?php echo $_R['category']?></p>
        </div>
      </a>
    </li>
    <?php endwhile?>

  </ul>
</section>
