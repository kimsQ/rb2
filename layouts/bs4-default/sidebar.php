<!DOCTYPE html>
<html lang="ko">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body class="rb-layout-sidebar d-flex flex-column h-100 <?php echo 'header-'.$d['layout']['header_position'] ?> <?php echo 'header-'.$d['layout']['header_type'] ?>">

	<?php include $g['dir_layout'].'/_includes/header.'.$d['layout']['header_type'].'.php' ?>

	<?php if ($c && $d['layout']['sidebar_titlebar']!='false') include $g['dir_layout'].'/_includes/subtitlebar.'.$d['layout']['sidebar_titlebar'].'.php' ?>

	<main role="main" class="py-3 <?php echo $d['layout']['sidebar_bgcolor'] ?>">
		<div class="<?php echo $d['layout']['sidebar_container'] ?>">
			<div class="page-wrapper row">

				<nav class="page-nav col bg-white pl-0">
					<?php include $g['dir_layout'].'/_includes/subnav.php' ?>
				</nav><!-- /.page-nav -->

				<div class="page-main col bg-white py-3 px-4">
					<?php if ($c && $d['layout']['sidebar_breadcrumb']!='false')
						include $g['dir_layout'].'/_includes/breadcrumb.'.$d['layout']['sidebar_breadcrumb'].'.php' ?>

					<?php if ($c && $d['layout']['sidebar_menutitle']!='false')
						include $g['dir_layout'].'/_includes/submenutitle.'.$d['layout']['sidebar_menutitle'].'.php' ?>

					<?php include __KIMS_CONTENT__ ?>
				</div><!-- /.page-main -->

			</div><!-- /.page-wrapper -->
		</div><!-- /.container -->
	</main>

	<?php include $g['dir_layout'].'/_includes/footer.'.$d['layout']['footer_type'].'.php' ?>
	<?php include $g['dir_layout'].'/_includes/component.php' ?>
	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
