<div class="modal-header">
	<h5 class="modal-title"><i class="fa fa-code fa-lg"></i> 위젯코드</h5>
	<button type="button" class="close js-hideModal">&times;</button>
</div>
<div class="modal-body">
	<textarea id="rb-widget-code-area" class="form-control border border-primary" readonly></textarea>
</div>
<div class="modal-footer d-flex justify-content-between">
	<button type="button" class="btn btn-outline-primary btn-block js-hideModal" data-plugin="clipboard" data-clipboard-target="#rb-widget-code-area">복사하기</button>
</div>

<!-- clipboard.js  : https://github.com/zenorocha/clipboard.js -->
<?php getImport('clipboard','clipboard.min','1.5.5','js') ?>

<script>

$(function () {
	var clipboard = new Clipboard('[data-plugin="clipboard"]');

	setTimeout(function(){
		$('#rb-widget-code-area').focus().select();

		$('#rb-widget-code-area').focus(function(){
			$(this).on("mouseup.a keyup.a", function(e){
				$(this).off("mouseup.a keyup.a").select();
			});
		});
	}, 300);

	$(".js-hideModal").click(function() {
		setTimeout(function(){
			hideModal()
		}, 100);
	});

})


function hideModal(){
	parent.$('.rb-modal-x').modal('hide');
}


function modalSetting(){
	getId('rb-widget-code-area').innerHTML = parent.frames._modal_iframe_modal_window.getId('rb-widget-code-result').value;
	parent.getId('_modal_dialog_top_').style.top = '120px';
	parent.getId('_modal_dialog_top_').style.paddingRight = '20px';
	parent.getId('_modal_dialog_top_').style.width = '100%';
	parent.getId('_modal_dialog_top_').style.maxWidth = '600px';
	parent.getId('_modal_iframe_sub_').style.height = '250px';
}
modalSetting();
</script>

<style>
#rb-widget-code-area {
	width: 100%;
	height: 100%;
	border: 0;
	padding: 10px;
	line-height: 150%;
	font-size: 12px;
	background-color: #eee;
	min-height: 80px;
}
#rb-widget-code-area::selection {
  background: rgba(255,238,51,0.99);
}
</style>
