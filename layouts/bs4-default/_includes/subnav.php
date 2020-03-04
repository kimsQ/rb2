<?php $_MENUS2=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_FHM['uid'].' and hidden=0 and depth=2 order by gid asc','*')?>
<?php $_MENUSN=db_num_rows($_MENUS2)?>
<?php if($_MENUN || $_CA[0]):?>

<?php if ($d['layout']['sidebar_titlebar']=='false'): ?>
<h3 class="page-nav-title bg-secondary text-white"><?php echo $_FHM['name'] ?></h3>
<?php endif; ?>

<ul class="nav flex-column">
  <?php $_i=0;while($_M2=db_fetch_array($_MENUS2)):$_i++?>
  <li class="nav-item<?php if($_MENUSN==$_i):?> _last<?php endif?>">
    <a class="nav-link<?php if($_M2['id']==$_CA[1]):?> active<?php endif?>" href="<?php echo RW('c='.$_CA[0].'/'.$_M2['id'])?>" target="<?php echo $_M2['target']?>">
      <?php echo $_M2['name']?>
    </a>
  <?php if(($_HM['uid']==$_M2['uid']||$_HM['parent']==$_M2['uid'])&&$_M2['is_child']):?>
  <ul class="nav flex-column ml-2">
  <?php $_MENUS3=getDbSelect($table['s_menu'],'site='.$s.' and parent='.$_M2['uid'].' and hidden=0 and depth=3 order by gid asc','*')?>
  <?php while($_M3=db_fetch_array($_MENUS3)):?>
  <li class="nav-item">
    <a class="nav-link<?php if($_M3['uid']==$_HM['uid']):?> active<?php endif?>" href="<?php echo RW('c='.$_CA[0].'/'.$_CA[1].'/'.$_M3['id'])?>" target="<?php echo $_M3['target']?>">
      <?php echo $_M3['name']?>
    </a>
  </li>
  <?php endwhile?>
</ul>
<?php endif?>
</li>
<?php endwhile?>
<?php if(!$_MENUSN):?>
<li class="text-muted text-center p-5 border">서브메뉴가 없습니다.</li>
<?php endif?>
</ul>

<?php endif?>
