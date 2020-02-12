<?php
  $listque	= 'mbruid='.$my['uid'];
  $_RCD = getDbArray($table[$m.'list'],$listque,'*','gid','asc',30,1);
  $NUM = getDbRows($table[$m.'list'],$listque);
?>

<div data-role="list-selector">
  <?php foreach($_RCD as $_R):?>
  <?php $is_list =  getDbRows($table[$m.'list_index'],'data='.$R['uid'].' and list='.$_R['uid'])  ?>
  <div class="d-flex justify-content-between align-items-center px-3 py-2">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" id="listRadio<?php echo $_R['uid'] ?>" name="postlist_members[]" value="<?php echo $_R['uid'] ?>" class="custom-control-input" <?php echo $is_list?' checked':'' ?>>
      <label class="custom-control-label" for="listRadio<?php echo $_R['uid'] ?>"><?php echo $_R['name'] ?></label>
    </div>
    <i class="material-icons text-muted mr-2" data-toggle="tooltip" title="<?php echo $g['displaySet']['label'][$_R['display']] ?>"><?php echo $g['displaySet']['icon'][$_R['display']] ?></i>
  </div>
  <?php endforeach?>

</div>

<?php if(!$NUM):?>
<div class="text-center text-muted p-5">리스트가 없습니다.</div>
<?php endif?>
