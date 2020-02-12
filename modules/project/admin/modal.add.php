<?php
$addExtensionSet = array
(
	'module' => array('모듈',$g['path_module'],'rb_module_모듈폴더명.zip'),
	'layout' => array('레이아웃',$g['path_layout'],'rb_layout_레이아웃폴더명.zip'),
	'widget' => array('위젯',$g['path_widget'],'rb_widget_위젯분류폴더명_위젯폴더명.zip'),
	'switch' => array('스위치',$g['path_switch'],'rb_switch_스위치종류_스위치폴더명.zip'),
	'plugin' => array('플러그인',$g['path_plugin'],'rb_plugin_플러그인폴더명_버전.zip'),
	'dashboard' => array('대시보드',$g['path_module'].'dashboard/widgets','rb_dashboard_대시보드폴더명.zip'),
	'etc' => array('기타자료','/root/','rb_etc_자료명.zip'),
);
?>

<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="add_<?php echo $addType?>">
	<input type="hidden" name="reload" value="<?php echo $reload?>">

	<div class="modal-body bg-white">

		<div class="py-5">
			<div id="uplocation" class="mb-3">
				<code>업로드 위치 : <?php echo str_replace('./','/root/',$addExtensionSet[$addType][1])?></code>
			</div>
			<input type="file" name="upfile" id="packageupfile" class="hidden" onchange="progressbar();">
			<button type="button" class="btn btn-secondary btn-block" id="fileselectbtn" onclick="$('#packageupfile').click();">파일선택</button>
		</div>


		<hr>


		<div class="progress progress-striped active hidden" id="progress-bar">
			<div class="progress-bar" role="progressbar" aria-valuemax="100"></div>
		</div>

		<ul class="list-unstyled mt-4 text-secondary">
			<li><?php echo sprintf('킴스큐에서 제공하는 공식 %s만 업로드할 수 있습니다.',$addExtensionSet[$addType][0])?></li>
			<li><?php echo sprintf('파일형식은 <code>%s</strong></code> 이어야 합니다.',$addExtensionSet[$addType][2])?></li>
			<li><?php echo 'FTP로 직접 추가하시려면 매뉴얼에 따라 추가해 주세요.'?></li>
			<li><?php echo sprintf('이미 같은명칭의 %s 폴더가 존재할 경우 덧씌워지니 주의하세요.',$addExtensionSet[$addType][0])?></li>
		</ul>
	</div>
</form>




<!-- @부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->

<div id="_modal_header" hidden>
	<h5 class="modal-title" id="myModalLabel">
		<i class="fa fa-upload fa-lg"></i> <?php echo sprintf('%s 추가',$addExtensionSet[$addType][0])?>
	</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div id="_modal_footer" hidden>
	<button class="btn btn-light pull-left" data-dismiss="modal" type="button">취소</button>
	<button class="btn btn-primary" type="button" onclick="frames._modal_iframe_modal_window.getFiles();" id="afterChooseFileNext" disabled>추가하기</button>
</div>


<script>
var _per = 0;
function progressbar()
{
	if(_per == 0)
	{
		$('#progress-bar').removeClass('hidden');
		$('#uplocation').addClass('hidden');
	}

	if (_per < 100)
	{
		_per = _per + 10;
		getId('progress-bar').children[0].style.width = (_per>100?100:_per)+ '%';
		setTimeout("progressbar();",100);
	}
	else {
		parent.getId('afterChooseFileNext').disabled = false;
		_per = 0;
	}
}
function getFiles()
{
	var f = document._upload_form_;
	if (f.upfile.value == '')
	{
		alert('파일이 선택되지 않았습니다.   ');
		return false;
	}
	getIframeForAction(f);
	f.submit();
	parent.getId('afterChooseFileNext').innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> Uploading ...';
	parent.getId('afterChooseFileNext').disabled = true;
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '330px'
	parent.getId('_modal_body_modal_window').style.height = '330px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
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
body {
	background: #fff;
}
</style>
