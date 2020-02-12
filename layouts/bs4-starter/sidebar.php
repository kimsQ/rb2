<!DOCTYPE html>
<html lang="ko">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body class="rb-layout-default">

	<?php include $g['dir_layout'].'/_includes/header.php' ?>

	<main role="main" class="container px-0">
		<div class="page-wrapper row">
			<nav class="page-nav col">
				<?php include $g['dir_layout'].'/_includes/subnav.php' ?>
			</nav><!-- /.page-nav -->
			<div class="page-main col">
				<?php include __KIMS_CONTENT__ ?>
			</div><!-- /.page-main -->
		</div><!-- /.page-wrapper -->
	</main><!-- /.container -->

	<?php include $g['dir_layout'].'/_includes/footer.php' ?>
	<?php include $g['dir_layout'].'/_includes/component.php' ?>
	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
