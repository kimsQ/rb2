<!DOCTYPE html>
<html lang="ko" class="h-100">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body class="rb-layout-default d-flex flex-column h-100 <?php echo 'header-'.$d['layout']['header_position'] ?> <?php echo 'header-'.$d['layout']['header_type'] ?>">

	<?php include $g['dir_layout'].'/_includes/permissionAlert.php' ?>

	<?php include $g['dir_layout'].'/_includes/header.'.$d['layout']['header_type'].'.php' ?>

	<?php if ($c && $d['layout']['default_breadcrumb']!='false') include $g['dir_layout'].'/_includes/breadcrumb.'.$d['layout']['default_breadcrumb'].'.php' ?>

	<?php if ($c && $d['layout']['default_titlebar']!='false') include $g['dir_layout'].'/_includes/subtitlebar.'.$d['layout']['default_titlebar'].'.php' ?>

	<main role="main" class="<?php echo $d['layout']['default_bgcolor'] ?>">
		<div class="<?php echo $d['layout']['default_container'] ?> px-0 py-4">

			<?php if ($c && $d['layout']['default_menutitle']!='false')
				include $g['dir_layout'].'/_includes/submenutitle.'.$d['layout']['default_menutitle'].'.php' ?>

				<article class="rb-article">
					<?php include __KIMS_CONTENT__ ?>
				</article>

		</div><!-- /.container -->
	</main>

	<?php include $g['dir_layout'].'/_includes/footer.'.$d['layout']['footer_type'].'.php' ?>
	<?php include $g['dir_layout'].'/_includes/component.php' ?>
	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
