<style media="screen">
.nav-table {
  display: table;
  width: 100%;
  font-size: .9375rem;
  border-radius: 0;
  border-collapse:collapse;
}
.nav-table-row {
  display: table-row;
}
.nav-table-cell {
  display: table-cell;
  overflow: hidden;
  width: 25%;
  max-width: 6.25rem;
  min-height: 1rem;
  padding: .75rem 0 .625rem;
  color: #666;
  letter-spacing: -.0625rem;
  white-space: nowrap;
  text-overflow: ellipsis;
  text-align: center;
  border: .0625rem solid rgba(0, 0, 0, 0.075);;
}
.nav-table-cell:active {
  background-color: #f4f4f4
}
.nav-table-cell.active,
.nav-table-cell:active {
  color: #0275d8 !important;
}

</style>

<?php
$_MENUQ1=getDbData($table['s_menu'],'site='.$s." and id='".$wdgvar['startmenu']."'",'uid');
$_MENUQ2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_MENUQ1['uid'].' and hidden=0 and mobile=1 order by gid asc','*');
$_MENUQN=db_num_rows($_MENUQ2)
?>
<nav class="nav nav-table">
  <div class="nav-table-row">
    <?php $_i=0;while($_M2=db_fetch_array($_MENUQ2)):$_i++?>
    <a  class="nav-table-cell" href="<?php echo RW('c='.$wdgvar['startmenu'].'/'.$_M2['id'])?>" target="<?php echo $_M2['target']?>" role="button">
      <?php echo $_M2['name']?>
    </a>
  <?php if(!($_i%$wdgvar['row'])):?></div><div class="nav-table-row"><?php endif?>
  <?php endwhile?>

    <?php if(!$_MENUQN):?>
    <div>퀵메뉴가 없습니다.</div>
    <?php endif?>

  </div>
</nav>
