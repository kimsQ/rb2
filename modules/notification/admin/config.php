<?php
$g['notiVarForSite'] = $g['path_var'].'site/'.$r.'/notification.var.php';
include_once file_exists($g['notiVarForSite']) ? $g['notiVarForSite'] : $g['path_module'].$module.'/var/var.php';
?>

<div id="configbox" class="p-4">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r ?>">
		<input type="hidden" name="m" value="<?php echo $module ?>">
		<input type="hidden" name="a" value="config">

		<h4>알림 설정</h4>

		<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">알림간격</label>
			<div class="col-lg-10 col-xl-9">
				<select name="sec" class="form-control custom-select">
					<?php for($i = 10; $i < 61; $i=$i+5):?>
					<option value="<?php echo $i?>"<?php if($d['ntfc']['sec']==$i):?> selected<?php endif?>><?php echo sprintf('%d 초',$i)?></option>
					<?php endfor?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">알림갯수처리</label>
			<div class="col-lg-10 col-xl-9">
				<select name="num" class="form-control custom-select">
					<option value="10"<?php if($d['ntfc']['num']==10):?> selected<?php endif?>><?php echo sprintf('%d 개 이상일 경우',10)?> +10</option>
					<option value="50"<?php if($d['ntfc']['num']==50):?> selected<?php endif?>><?php echo sprintf('%d 개 이상일 경우',50)?> +50</option>
					<option value="99"<?php if($d['ntfc']['num']==99):?> selected<?php endif?>><?php echo sprintf('%d 개 이상일 경우',99)?> +99</option>
					<option value="100"<?php if($d['ntfc']['num']==100):?> selected<?php endif?>><?php echo sprintf('%d 개 이상일 경우',100)?> +100</option>
					<option value="999"<?php if($d['ntfc']['num']==999):?> selected<?php endif?>><?php echo sprintf('%d 개 이상일 경우',999)?> +999</option>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">알림차단 모듈</label>
			<div class="col-lg-10 col-xl-9">

				<?php $_MODULES=getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
				<?php while($_MD=db_fetch_array($_MODULES)):?>
				<div class="custom-control custom-checkbox custom-control-inline">
				  <input type="checkbox" class="custom-control-input" id="module_members_<?php echo $_MD['id']?>" name="module_members[]" value="<?php echo $_MD['id']?>"<?php if(strstr($d['ntfc']['cut_modules'],'['.$_MD['id'].']')):?> checked<?php endif?>>
				  <label class="custom-control-label" for="module_members_<?php echo $_MD['id']?>"><?php echo $_MD['name']?> <small class="text-muted">(<?php echo $_MD['id']?>)</small></label>
				</div>
				<?php endwhile?>

				<p class="form-text text-muted mt-3">
					알림을 원천적으로 차단할 모듈을 선택해주세요.
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-10 offset-lg-2 col-xl-9 offset-xl-2">
				<button type="submit" class="btn btn-outline-primary btn-lg my-4<?php if($g['device']):?> btn-block<?php endif?>">저장하기</button>
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
