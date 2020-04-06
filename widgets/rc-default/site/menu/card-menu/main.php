<section class="widget rc-card-quickmenu content-padded">
  <div class="row gutter-half">
    <?php
      $_MENUQ1=getDbData($table['s_menu'],'site='.$s." and id='".$d['layout']['front_quick']."'",'uid');
      $_MENUQ2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_MENUQ1['uid'].' and hidden=0 and mobile=1 order by gid asc','*');
    ?>
    <?php while($_M2=db_fetch_array($_MENUQ2)):?>

    <?php
      if($_M2['upload']) {
    		$ufilesArray = getArrayString($_M2['upload']);
    		$_IMG = getDbData($table['s_upload'], 'uid='.$ufilesArray['data'][0], '*');
        $Topimg_URL = $_IMG['url'].$_IMG['folder'].'/'.$_IMG['tmpname'];
    	}
    ?>

    <div class="col-xs-6 mb-2">
      <a class="card text-center" href="<?php echo RW('c='.$d['layout']['front_quick'].'/'.$_M2['id'])?>" >
        <?php if ($_M2['upload']): ?>
        <img src="<?php echo getPreviewResize($Topimg_URL,'n')?>" alt="" class="card-img-top img-fluid">
        <?php endif; ?>
        <div class="card-block p-2">
          <h5 class="card-title"><?php echo $_M2['addinfo']?> </h5>
          <small class="card-text text-muted"><?php echo $_M2['name']?></small>
        </div>
      </a><!-- /.card -->
    </div><!-- /.col-4 -->
    <?php endwhile?>

  </div><!-- /.row -->
</section>
