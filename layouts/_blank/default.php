<?php if($noTags=='Y'):?>
<?php include __KIMS_CONTENT__ ?>
<?php else:?>
<!DOCTYPE html>
<html lang="<?php echo $lang['admin']['flag']?>">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body id="rb-body" class="lang-<?php echo $lang['admin']['flag']?><?php if($g['device']):?> rb-device-connect<?php endif?>">

	<div id="content-main">
	<?php include __KIMS_CONTENT__ ?>
	</div>

	<?php include $g['dir_layout'].'/_includes/_import.foot.php' ?>
</body>
</html>
<?php endif?>
