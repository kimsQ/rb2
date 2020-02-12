<?php
function getDashboardDirList($folder)
{
	$incs = array();
	$dirh = opendir($folder);
	while(false !== ($files = readdir($dirh))) 
	{ 
		if(substr($files,0,1)=='.') continue;
		$incs[] = $files;
	} 
	closedir($dirh);
	return $incs;
}
$d['admwidget'] = array();
$_widgetList = getDashboardDirList($g['path_module'].$module.'/widgets');
$_mywidget = $g['path_module'].$module.'/var/'.$my['uid'].'.php';
if(is_file($_mywidget)) include $_mywidget;
?>
<div id="bookmark" class="xrow">
	<form action="<?php echo $g['s']?>/" method="post" class="rb-form">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="">
	<input type="hidden" name="reaction" value="">
	<input type="hidden" name="flag" value="">
		<div class="dd" id="nestable-menu">
			<ol class="dd-list">
				<?php $_i=1;foreach($d['admwidget'] as $_key => $_val):?>
				<?php if(!is_file($g['path_module'].$module.'/widgets/'.$_key.'/main.php'))continue?>
				<li class="dd-item dd3-item" data-id="<?php echo $_i?>">
					<div class="dd-handle dd3-handle"></div>
					<div class="dd3-content"><a><?php echo getFolderName($g['path_module'].$module.'/widgets/'.$_key)?></a></div>
					<div class="dd-checkbox" title="진열" data-tooltip="tooltip">
						<input type="checkbox" class="hidden" name="dashboard_widgets_order[]" value="<?php echo $_key?>" checked>
						<input type="checkbox" name="dashboard_widgets[]" value="1"<?php if($_val=='true'):?> checked<?php endif?> style="cursor:pointer;"><i></i>
					</div>
				</li>
				<?php $_i++;endforeach?>
				<?php foreach($_widgetList as $_key):?>
				<?php if($d['admwidget'][$_key])continue?>
				<li class="dd-item dd3-item" data-id="<?php echo $_i?>">
					<div class="dd-handle dd3-handle"></div>
					<div class="dd3-content"><a><?php echo getFolderName($g['path_module'].$module.'/widgets/'.$_key)?></a></div>
					<div class="dd-checkbox" title="진열" data-tooltip="tooltip">
						<input type="checkbox" class="hidden" name="dashboard_widgets_order[]" value="<?php echo $_key?>" checked>
						<input type="checkbox" name="dashboard_widgets[]" value="1" style="cursor:pointer;"><i></i>
					</div>
				</li>
				<?php $_i++;endforeach?>
			</ol>
		</div>
	</form>
</div>


<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js') ?>
<script>
$('#nestable-menu').nestable();
$('.dd').on('change', function() {
	var f = document.forms[0];
	getIframeForAction(f);
	f.a.value = 'dashboard_order';
	f.flag.value = getCheck();
	f.submit();
});
</script>


<!-- basic -->
<script>
function getCheck()
{
	var f  = document.forms[0];
    var l = document.getElementsByName('dashboard_widgets[]');
    var n = l.length;
    var i;
	var s='';
	for (i=0; i < n; i++) s += l[i].checked + ',';

	return s;
}
function actQue(act)
{
	var f = document.forms[0];
	getIframeForAction(f);
	f.a.value = act;
	f.flag.value = getCheck();
	f.reaction.value = 'Y';
	f.submit();
	f.msg.value = '';
}
</script>


















<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
	<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><i class="kf kf-dashboard fa-lg"></i> <?php echo _LANG('a3001','dashboard')?></h4>
</div>
<div id="_modal_footer" class="hidden">
	<ul class="list-inline clearfix">
		<li class="pull-left">
			<button type="button" class="btn btn-default" onclick="frames._modal_iframe_modal_window.checkboxChoice('dashboard_widgets[]',true);">
				<?php echo _LANG('a3002','dashboard')?>
			</button>
			<button type="button" class="btn btn-default" onclick="frames._modal_iframe_modal_window.checkboxChoice('dashboard_widgets[]',false);">
				<?php echo _LANG('a3003','dashboard')?>
			</button>
		</li>
		<li class="pull-right">
			<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.actQue('dashboard_order');">
				<?php echo _LANG('a3004','dashboard')?>
			</button>
		</li>
	</ul>
</div>



<script>
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '400px';
	parent.getId('_modal_iframe_modal_window').style.height = '450px';
	parent.getId('_modal_body_modal_window').style.height = '450px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_header_modal_window').style.background = '#3F424B';
	parent.getId('_modal_header_modal_window').style.color = '#fff';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
document.body.onresize = document.body.onload = function()
{
	setTimeout("modalSetting();",100);
	setTimeout("modalSetting();",200);
}
</script>


<style>
#rb-body {
	background: #ffffff;
}
.xrow {
	padding:0 10px 0 10px;
	margin: 0;
}
/**
 * Nestable
 */

.dd { 
    position: relative; 
    display: block; 
    margin: 0; 
    padding: 0; 
    max-width: 600px; 
    list-style: none; 
    line-height: 20px
}

.dd-list { 
    display: block; 
    position: relative; 
    margin: 0; 
    padding: 0; 
    list-style: none
}

.dd-item,
.dd-empty,
.dd-placeholder { 
    display: block; 
    position: relative;
    margin: 0; 
    padding: 0; 
    min-height: 20px; 
    line-height: 20px
}

.dd-handle { 
    display: block; 
    height: 35px; 
    margin: 5px 0; 
    padding: 5px 10px; 
    color: #333; 
    text-decoration: none; 
    font-weight: bold; 
    border: 1px solid #ddd;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}

.dd-handle:hover { color: #2ea8e5; background: #fff; }


.dd-placeholder,
.dd-empty { 
    margin: 5px 0; 
    padding: 0; 
    min-height: 30px; 
    background: #f2fbff; 
    border: 1px dashed #b6bcbf; 
    box-sizing: border-box; 
    -moz-box-sizing: border-box
}

.dd-empty { 
    border: 1px dashed #bbb; 
    min-height: 100px; 
    background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { 
    position: absolute; 
    pointer-events: none; 
    z-index: 9999
}

.dd-dragel > .dd-item .dd-handle { margin-top: 0 }

.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1)
}

/**
 * Nestable Extras
 */


#nestable-menu { padding: 0; margin: 20px 0; }

#nestable-output,

@media only screen and (min-width: 700px) {

    .dd { float: left; width: 100%; }
    .dd + .dd { margin-left: 2%; }

}

.dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

.dd3-content { 
    display: block; 
    height: 35px; 
    margin: 5px 0; 
    line-height: 20px;
    padding: 6px 10px 4px 40px; 
    color: #333; 
    border: 1px solid #ddd;
    background: #eee;
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}

.dd3-content a { 
    color: #666
}

.dd3-content:hover { 
    color: #2ea8e5; 
    background: #f5f5f5
}

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-item > button { margin-left: 30px; }

.dd3-handle { 
	position: absolute; 
	margin: 0; 
	left: 0; 
	top: 0; 
	cursor: pointer; 
	width: 30px; 
	text-indent: 100%; 
	white-space: nowrap; 
	overflow: hidden;
    border: 1px solid #ddd;
    background: #ddd;

    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    cursor: move
}

.dd-checkbox {
	line-height: 28px;
	position: absolute; 
	margin: 0; 
	right: 0; 
	top: 0; 
	width: 30px; 
    padding: 5px 20px 10px 5px;

}

.dd3-handle:before { 
    font-family: 'FontAwesome';
    content: '\f047'; 
    display: block; 
    position: absolute; 
    left: 5px; 
    top: 6px; 
    text-align: center; 
    text-indent: 0; 
    color: #888; 
    font-size: 18px; 
    font-weight: normal
}

.dd3-handle:hover { 
    background: #ddd
}

.panel-footer ul.list-inline {
    margin-bottom: 0
}


#bookmark .rb-none {
    line-height: 300px;
    text-align: center;
    color: #999
}

</style>

