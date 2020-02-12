<?php include $g['path_module'].$module.'/var/var.php' ?>

<div id="configbox" class="p-4">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m ?>" onsubmit="return saveCheck(this);" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r ?>">
		<input type="hidden" name="m" value="<?php echo $module ?>">
		<input type="hidden" name="a" value="config">

		<h4>큐마켓 연결설정</h4>

		<div class="form-group form-row">
			<label class="col-sm-2 control-label">큐마켓 URL</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="url" value="<?php echo $d['market']['url']?>" placeholder="">
			</div>
		</div>

		<div class="form-group form-row">
			<div class="offset-sm-2 col-sm-10">
				<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>">저장하기</button>
			</div>
		</div>
	</form>

</div>




<script>
function saveCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>
