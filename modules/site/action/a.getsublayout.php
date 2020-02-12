<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
?>

<script>
var tags = '';
var block = parent.getId('<?php echo $sid?>');
<?php if($layout):?>
tags += '<select class="form-control<?php echo $sclass?' '.$sclass:''?>" name="<?php echo $sname?>">';
<?php $dirs1 = opendir($g['path_layout'].$layout)?>
<?php while(false !== ($tpl1 = readdir($dirs1))):?>
<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
tags += '<option value="<?php echo $tpl1?>"><?php echo str_replace('.php','',$tpl1)?></option>';
<?php endwhile?>
<?php closedir($dirs1)?>
<?php else:?>
tags += '<select class="form-control<?php echo $sclass?' '.$sclass:''?>" name="<?php echo $sname?>" disabled>';
tags += '<option>서브 레이아웃</option>';
<?php endif?>
tags += '</select>';
block.innerHTML = tags;
</script>

<?php
exit;
?>
