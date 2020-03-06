<!DOCTYPE html>
<html lang="ko">
<head>
<?php include $g['dir_layout'].'/_includes/_import.head.php' ?>
</head>
<body class="rb-layout-docs d-flex flex-column h-100">

	<?php include $g['dir_layout'].'/_includes/header.docs.php' ?>

	<main role="main" class="<?php echo $d['layout']['docs_container'] ?> px-0 py-4 rb-article">
		<article class="rb-article">
			<?php include __KIMS_CONTENT__ ?>
		</article>
	</main><!-- /.container -->

	<?php include $g['dir_layout'].'/_includes/footer.'.$d['layout']['docs_footer'].'.php' ?>
	<?php include $g['dir_layout'].'/_includes/component.php' ?>
	<?php include $g['dir_layout'].'/_includes/_import.foot.php'?>

</body>
</html>
