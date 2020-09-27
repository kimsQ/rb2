<!DOCTYPE html>
<html lang="ko" class="h-100">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body class="rb-layout-home d-flex flex-column h-100 <?php echo 'header-'.$d['layout']['header_position'] ?> <?php echo 'header-'.$d['layout']['header_type'] ?>">

	<?php include $g['dir_layout'].'/_includes/permissionAlert.php' ?>

	<?php include $g['dir_layout'].'/_includes/header.'.$d['layout']['header_type'].'.php' ?>

	<main role="main" class="<?php echo $d['layout']['home_container'] ?>">
		<?php include __KIMS_CONTENT__ ?>
	</main><!-- /.container -->

	<?php include $g['dir_layout'].'/_includes/footer.'.$d['layout']['footer_type'].'.php' ?>
	<?php include $g['dir_layout'].'/_includes/component.php' ?>
	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
