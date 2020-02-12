<?php
function getOpenSrcList()
{
	global $g;
	$incs = array();
	$dirh = opendir($g['path_plugin']);
	while(false !== ($folder = readdir($dirh)))
	{
		if($folder == '.' || $folder == '..') continue;
		$incs[] = $folder;
	}
	closedir($dirh);
	return $incs;
}
function _DirSizeNum($file)
{
	$sfile = $file.'/size.txt';
	if (is_file($sfile))
	{
		$info = explode(',',implode('',file($sfile)));
		$plugin = array();
		$plugin['size'] = $info[0];
		$plugin['num'] = $info[1];
		return $plugin;
	}
	else {
		$plugin = DirSizeNum($file);
		$fp = fopen($sfile,'w');
		fwrite($fp,$plugin['size'].','.$plugin['num']);
		fclose($fp);
		@chmod($sfile,0707);
		return $plugin;
	}
}
$_openSrcs = getOpenSrcList();
$_openSrcn = count($_openSrcs);
include $g['path_core'].'function/dir.func.php';
?>

<div id="plugins" class="p-4">

	<h4><?php echo sprintf('플러그인 <span>(총 %d개 / <span id="_sum_size_"></span>)</span>',$_openSrcn)?></h4>

	<form name="pluginForm" action="<?php echo $g['s']?>/" method="post" class="rb-form" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="plugin_config">
		<input type="hidden" name="isdelete" value="">

		<div class="rb-files table-responsive">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="rb-check"></th>
						<th class="rb-name">플러그인명</th>
						<th class="rb-size">용량(파일수)</th>
						<th class="rb-update">등록일</th>
						<th class="rb-version">적용버전</th>
					</tr>
				</thead>
				<tbody>

					<?php $_sumPluginsSize=0?>
					<?php foreach($_openSrcs as $_key_):?>
					<?php $plCtime = filectime($g['path_plugin'].$_key_)?>
					<?php $plugins = _DirSizeNum($g['path_plugin'].$_key_)?>
					<?php $_sumPluginsSize+=$plugins['size']?>
					<tr>
						<td class="rb-check">
							<label class="form-check mt-2">
							  <input type="checkbox" class="form-check-input position-static" name="pluginmembers[]" value="<?php echo $_key_?>">
							</label>
						</td>
						<td class="rb-name"><i class="fa fa-folder fa-lg"></i> &nbsp;<a><?php echo $_key_?></a></td>
						<td class="rb-size"><?php echo getSizeFormat($plugins['size'],1)?> (<?php echo $plugins['num']?>)</td>
						<td class="rb-update">
							<time class="timeago" data-toggle="tooltip" datetime="<?php echo date('c',$plCtime)?>" data-tooltip="tooltip" title="<?php echo date('Y.m.d H:i',$plCtime)?>"></time>
						</td>
						<td class="rb-version">
							<select name="ov[<?php echo $_key_?>]" class="form-control custom-select">
								<?php $incs = array()?>
								<?php $dirh = opendir($g['path_plugin'].$_key_)?>
								<?php while(false !== ($version = readdir($dirh))):?>
								<?php if($version=='.'||$version=='..')continue?>
								<?php if(!strstr($version,'.') || !is_dir($g['path_plugin'].$_key_.'/'.$version)) continue?>
								<option value="<?php echo $version?>"<?php if($version==$d['ov'][$_key_]):?> selected="selected"<?php endif?>><?php echo $version?></option>
								<?php endwhile?>
								<?php closedir($dirh)?>
							</select>
						</td>
					</tr>
					<?php endforeach?>

				</tbody>
			</table>
		</div>

		<div class="bottom-action my-4">
			<div class="btn-group" role="toolbar">
				<button type="button" class="btn btn-danger" onclick="deletePlugin('<?php echo $_key_?>','1');"><i class="fa fa-trash-o fa-lg"></i> 전체삭제</button>
				<button type="button" class="btn btn-danger" onclick="deletePlugin('<?php echo $_key_?>','2');"><i class="fa fa-trash-o fa-lg"></i> 버전삭제</button>
				<button type="button" class="btn btn-default rb-modal-add-plugin" data-toggle="modal" data-target="#modal_window"><i class="fa fa-upload fa-lg"></i> 플러그인 추가</button>
				<button type="submit" class="btn btn-primary pull-right rb-resave"><i class="fa fa-check fa-fw"></i> 버전변경</button>
			</div>
		</div>

	</form>

	<div class="bg-light border rounded p-3 text-muted">
		킴스큐에서는 오픈소스로 제공되는 다양한 외부 플러그인들이 사용되고 있습니다.<br>
		현재 사용되고 있는 플러그인들의 최신버젼이나 최적화된 버젼을 동적으로 설정할 수 있습니다.<br>
		<span class="hidden-xs">삽입코드 예시 <code> &lt;?php  getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css') ?&gt;</code></span>
	</div>
</div>


<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.'.$lang['admin']['time1'],false,'js')?>
<script>
jQuery(document).ready(function() {
	$(".rb-update time").timeago();
});
$(document).ready(function()
{
	$('.rb-modal-add-plugin').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=plugin&amp;reload=Y')?>');
	});
});
</script>

<script>
function deletePlugin(plugin,type)
{
	var f  = document.pluginForm;
    var l = document.getElementsByName('pluginmembers[]');
    var n = l.length;
    var i;
	var j=0;

	for (i=0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
		}
	}
	if (j == 0)
	{
		alert('삭제할 플러그인을 선택해 주세요.   ');
		return false;
	}
	if (confirm('사용중인 플러그인을 삭제하면 사이트에 오류가 발생할 수 있습니다.\n그래도 삭제하시겠습니까?   '))
	{
		getIframeForAction(f);
		f.isdelete.value = type;
		f.submit();
	}
	return false;
}
function saveCheck(f)
{
	if(confirm('정말로 실행하시겠습니까?   '))
	{
		getIframeForAction(f);
		return true;
	}
	return false;
}
function saveCheck1()
{
	var f = document.pluginForm;
	getIframeForAction(f);
	f.submit();
}
getId('_sum_size_').innerHTML = '<?php echo getSizeFormat($_sumPluginsSize,2)?>';
<?php if($resave=='Y'):?>
setTimeout("saveCheck1();",100);
<?php endif?>
</script>
