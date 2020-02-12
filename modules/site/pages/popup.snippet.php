<div id="snippetbox">
	<iframe src="http://docs.kimsq.com/rb2/_snippet/index.php?selectLang=<?php echo $lang['admin']['flag']?>" width="100%" height="600" frameborder="0"></iframe>
</div>

<script>
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '1000px';
	parent.getId('_modal_iframe_modal_window').style.height = '600px';
	parent.getId('_modal_body_modal_window').style.height = '630px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>
