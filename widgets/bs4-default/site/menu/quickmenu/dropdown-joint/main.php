<?php
  $_MENUQ1=getDbData($table['s_menu'],'site='.$s." and id='".$wdgvar['smenu']."'",'uid,name');
  $_MENUQ2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_MENUQ1['uid'].' and hidden=0 order by gid asc','*');
?>

<div class="btn-group dropup">
  <button type="button" class="btn btn-white btn-sm dropdown-toggle"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-width: 170px">
    <?php echo $_MENUQ1['name'] ?>
  </button>
  <div class="dropdown-menu dropdown-menu-right shadow-sm f14" style="min-width: 170px">
    <?php while($_M2=db_fetch_array($_MENUQ2)):?>
    <a class="dropdown-item" href="<?php echo $_M2['joint']?>" target="_blank">
      <?php echo $_M2['name']?>
    </a>
    <?php endwhile?>
  </div>
</div>
