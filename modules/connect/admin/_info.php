<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">
<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<?php @include $g['path_module'].$module.'/var/var.moduleinfo.php' ?>

<article class="rb-docs markdown-body px-5 pt-3">
	<h1><?php echo sprintf('%s 모듈정보',ucfirst($MD['name']))?></h1>

	<div class="pb-5 readme">
		<?php readfile($g['path_module'].$module.'/README.md')?>
	</div>

	<div class="pb-5">
		<h2>라이센스</h2>
		<textarea class="form-control" rows="10"><?php readfile($g['path_module'].$module.'/LICENSE')?></textarea>
	</div>
</article>

<script type="text/javascript">
$(function () {
	$(".markdown-body .readme").markdown();
})
</script>
