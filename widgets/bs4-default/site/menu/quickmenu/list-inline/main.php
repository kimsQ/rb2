<?php
$wdgvar_smenu_arr = explode('/' , $wdgvar['smenu']);
$wdgvar_smenu_arr_end =  array_pop($wdgvar_smenu_arr);
$_MENUQ1=getDbData($table['s_menu'],'site='.$s." and id='".$wdgvar_smenu_arr_end."'",'uid,name');
$_MENUQ2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_MENUQ1['uid'].' and hidden=0 order by gid asc','*');
?>

<?php while($_M2=db_fetch_array($_MENUQ2)):?>
<li class="list-inline-item">
  <a class="muted-link" href="<?php echo RW('c='.$wdgvar['smenu'].'/'.$_M2['id'])?>">
    <?php echo $_M2['name']?>
  </a>
</li>
<?php endwhile?>
