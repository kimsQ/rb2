<?php
if (!$_dashboardInclude && $g['device'])
{
	getLink($g['s'].'/?r='.$r.'&m='.$m.'&module='.$module.'&front=mobile.shortcut','','','');
}

include $g['path_core'].'function/rss.func.php';
include $g['path_module'].'market/var/var.php';
$_serverinfo = explode('/',$d['market']['url']);
$_updatelist = getUrlData('http://'.$_serverinfo[2].'/__update/update.v2.txt',10);
$_updatelist = explode("\n",$_updatelist);
$_updatelength = count($_updatelist)-1;
$_lastupdate = explode(',',trim($_updatelist[$_updatelength-1]));
$_isnewversion = is_file($g['path_var'].'update/'.$_lastupdate[1].'.txt') ? true : false;

$d['admwidget'] = array();
$_mywidget = $g['path_module'].$module.'/var/'.$my['uid'].'.php';
if(is_file($_mywidget)) include $_mywidget;
?>

<div id="rb-dashboard">
	<?php if($_lastupdate[0] && !$_isnewversion):?>
	<div id="rb-update-alert" class="alert alert-danger fade in">
		<?php if($_lastupdate[2]):?>
		<a href="<?php echo $_lastupdate[2]?>" class="alert-link" target="_blank" title="업데이트 내용보기" data-tooltip="tooltip">Rb <?php echo $_lastupdate[0]?></a>
		<?php else:?>
		<a href="#." class="alert-link" title="정보가 없는 업데이트입니다." data-tooltip="tooltip">Rb <?php echo $_lastupdate[0]?></a>
		<?php endif?>
		업데이트가 있습니다.
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=admin&amp;front=update" class="alert-link">지금 업데이트 하시겠습니까?</a>
	</div>
	<?php endif?>

	<div id="rb-widgets-body" class="row">

		<?php $_i=0;foreach($d['admwidget'] as $_key => $_val):?>
		<?php if(!is_file($g['path_module'].$module.'/widgets/'.$_key.'/main.php'))continue?>
		<?php if($_val=='true'):?>
		<?php include getLangFile($g['path_module'].$module.'/widgets/'.$_key.'/lang.',$d['admin']['syslang'],'.php') ?>
		<?php include $g['path_module'].$module.'/widgets/'.$_key.'/var.php' ?>
		<div class="col-md-<?php echo $d['admdash']['col']?> col-lg-<?php echo $d['admdash']['col']?>">
			<link href="<?php echo $g['s']?>/modules/<?php echo $module?>/widgets/<?php echo $_key?>/main.css" rel="stylesheet">
			<div class="card<?php if($_SESSION['sh-dash-'.$_key]):?> rb-bottom-none<?php endif?>">
				<div class="card-header">
					<a class="rb-collapse btn btn-link" data-toggle="collapse" data-target="#wedget-<?php echo $_key?>">
						<i onclick="checkArrow(this);" title="숨기기" data-tooltip="tooltip">×</i>
						<i onclick="checkArrow(this);" title="접기/펼치기" data-tooltip="tooltip"><?php echo $_SESSION['sh-dash-'.$_key]?'▼':'▲'?></i>
					</a>
					<?php echo $d['admdash']['title']?>
				</div>
				<div class="collapse<?php if(!$_SESSION['sh-dash-'.$_key]):?> in<?php endif?>" id="wedget-<?php echo $_key ?>">

					<?php include $g['path_module'].$module.'/widgets/'.$_key.'/main.php' ?>
					<?php if($d['admdash']['more']): ?>
					<div class="panel-footer rb-more"><a href="<?php echo $d['admdash']['more']?>">more</a></div>
					<?php endif?>
				</div>
			</div>
		</div>
		<?php $_i++;endif?>
		<?php endforeach?>

		<div id="rb-guide-wrapper" class="rb-guide-wrapper<?php if($_i):?> d-none<?php endif?>">
			<div class="rb-guide-wrapper-inner">
				<div class="container-fluid py-5">
					<h1 class="h3">
						<i class="kf kf-widget fa-4x text-muted pb-3 d-block"></i>
						설정된 위젯이 없습니다.
					</h1>
					<small class="text-muted">
						위젯을 이용해서 <?php echo $my['name'] ?>님만의 대시보드를 꾸며보세요.
						<br class="hidden-xs">
						자주 사용하는 위젯을 원하는 위치에 진열할 수 있습니다.
					</small>
					<p>
						<br>
						<br>
						<a id="rb-dashboard-edit-btn" class="btn btn-outline-primary rb-modal-dashboard" href="#." data-toggle="modal" data-target="#modal_window">
							<i class="glyphicon glyphicon-ok"></i>
							대시보드 꾸미기
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


<form name="actionForm" action="<?php echo $g['s']?>/" method="post">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $module?>">
<input type="hidden" name="a" value="dashboard_order">
<input type="hidden" name="widget" value="">
</form>

<script>
document.ondblclick = function()
{
	//$('#rb-dashboard-edit-btn').click();
}
$(document).ready(function()
{
	$('.rb-modal-dashboard').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m='.$m.'&amp;module='.$module.'&amp;front=modal.dashboard')?>');
	});
	<?php if(!$g['device']):?>
	$('#rb-admin-page-content').removeClass('tab-content');
	$('#rb-admin-ul-tabs').removeClass('nav nav-tabs rb-nav-tabs');
	<?php endif?>
});
function checkArrow(obj)
{
	var sid = obj.parentNode.parentNode.parentNode.children[1].id.replace('wedget-','');
	if (obj.innerHTML == '×')
	{
		obj.parentNode.parentNode.parentNode.parentNode.className += ' hidden';

		var f = document.actionForm;
		var wd = getId('rb-widgets-body');
		var wn = wd.children.length;
		var i;
		var j = 0;
		for (i = 0; i < wn-1; i++)
		{
			if (wd.children[i].className.indexOf('hidden') != -1) j++;
		}
		if (wn-1 == j)
		{
			$('#rb-guide-wrapper').removeClass('hidden');
		}
		else {
			$('#rb-guide-wrapper').addClass('hidden');
		}
		f.widget.value = sid;
		getIframeForAction(f);
		f.submit();
	}
	else {
		if (obj.innerHTML == '▼')
		{
			obj.innerHTML = '▲';
			obj.parentNode.parentNode.parentNode.className = obj.parentNode.parentNode.parentNode.className.replace(' rb-bottom-none','');
		}
		else
		{
			obj.innerHTML = '▼';
			obj.parentNode.parentNode.parentNode.className += ' rb-bottom-none';
		}
		sessionSetting('sh-dash-'+sid,'1','','1');
	}
}
</script>
