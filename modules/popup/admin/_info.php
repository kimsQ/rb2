<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">
<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<?php @include $g['path_module'].$module.'/var/var.moduleinfo.php' ?>

<article class="rb-docs markdown-body px-5 pt-3">
	<h1><?php echo sprintf('%s 모듈정보',ucfirst($MD['name']))?></h1>

	<nav class="nav">
		<a class="nav-link<?php if(!$d['moduleinfo']['market']):?> disabled<?php endif?>" href="<?php echo $d['moduleinfo']['market']?>" target="_blank">
			<i class="fa fa-shopping-cart fa-fw fa-lg"></i>마켓보기
		</a>
		<a class="nav-link<?php if(!$d['moduleinfo']['github']):?> disabled<?php endif?>" href="<?php echo $d['moduleinfo']['github']?>" target="_blank">
			<i class="fa fa-github fa-fw fa-lg"></i>저장소 보기
		</a>
		<a class="nav-link<?php if(!$d['moduleinfo']['issue']):?> disabled<?php endif?>" href="<?php echo $d['moduleinfo']['issue']?>" target="_blank">
			<i class="fa fa-bug fa-fw fa-lg"></i>이슈 접수
		</a>
		<a class="nav-link<?php if(!$d['moduleinfo']['website']):?> disabled<?php endif?>" href="<?php echo $d['moduleinfo']['website']?>" target="_blank">
			<i class="fa fa-home fa-fw fa-lg"></i>웹사이트
		</a>
		<a class="nav-link<?php if(!$d['moduleinfo']['help']):?> disabled<?php endif?>" href="<?php echo $d['moduleinfo']['help']?>" target="_blank">
			<i class="fa fa-question-circle fa-fw fa-lg"></i>도움말
		</a>
	</nav>

	<div class="pb-5 readme">
		<?php readfile($g['path_module'].$module.'/README.md')?>
	</div>

	<div class="pb-5">
		<h2>라이센스</h2>
		<textarea class="form-control" rows="10"><?php readfile($g['path_module'].$module.'/LICENSE')?></textarea>
	</div>
</article>

<script type="text/javascript">
	$(".markdown-body .readme").markdown();
</script>
