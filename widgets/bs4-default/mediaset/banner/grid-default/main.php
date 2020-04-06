<?php
$_mediasetque = 'site='.$s.' and category="'.$wdgvar['category'].'"';
$_RCD=getDbArray($table['s_upload'],$_mediasetque,'*','pid','asc',$wdgvar['limit'],1);
?>
<section class="widget mb-3 ">

  <div class="<?php echo $wdgvar['container']?$wdgvar['container']:$d['layout']['home_container'] ?>">

    <div class="py-5">

      <?php if ($wdgvar['show_header']=='show'): ?>
      <header>
        <h5 class="widget-title text-center mb-4">
          <?php echo $wdgvar['title'] ?>
        </h5>
      </header>
      <?php endif; ?>

      <div class="row gutter-half">

        <?php $i=0;foreach($_RCD as $_R):?>
        <div class="<?php echo $wdgvar['line'] ?>">
          <a href="<?php echo $_R['linkurl']?$_R['linkurl']:'#' ?>" target="<?php echo $wdgvar['linktarget'] ?>">
            <img src="<?php echo $_R['src'] ?>" class="img-fluid" alt="">
          </a>
        </div>
        <?php $i++;endforeach?>

      </div>

    </div>

  </div>
</section>
