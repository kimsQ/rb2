<h3><?php echo $wdgvar['title'] ?></h3>
<section class="widget-quick">
  <div class="row gutter-half">
    <?php
      $_MENUQ1=getDbData($table['s_menu'],'site='.$s." and id='".$wdgvar['smenu']."'",'uid');
      $_MENUQ2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_MENUQ1['uid'].' and hidden=0 order by gid asc','*');
    ?>
    <?php while($_M2=db_fetch_array($_MENUQ2)):?>

    <?php
      if($_M2['upload']) {
    		$ufilesArray = getArrayString($_M2['upload']);
    		$_IMG = getDbData($table['s_upload'], 'uid='.$ufilesArray['data'][0], '*');
        $Topimg_URL = $_IMG['url'].$_IMG['folder'].'/'.$_IMG['tmpname'];
    	}
    ?>

    <div class="col-4 mb-3">
      <div class="card text-center bg-secondary border-0" <?php if ($_M2['upload']): ?>style="background-image: url('<?php echo getPreviewResize($Topimg_URL,'z')?>')"<?php endif; ?>>
        <a href="<?php echo RW('c='.$wdgvar['smenu'].'/'.$_M2['id'])?>" class="card-body text-white">
          <h4 class="card-title"><?php echo $_M2['addinfo']?> </h4>
          <p class="card-text mb-0"><?php echo $_M2['name']?></p>
        </a>
      </div><!-- /.card -->
    </div><!-- /.col-4 -->
    <?php endwhile?>

  </div><!-- /.row -->
</section>
