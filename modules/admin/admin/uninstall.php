<div id="uninstall" class="p-4">
			<div class="media">
			<div class="page-header"><h4>삭제 정보</h4></div>
			<dl class="row">
			<hr>
			<?php if($d['admin']['ftp_use']):?>
			<?php else:?>
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>">FTP 계정등록후 제거를 추천 드립니다.</a>
		</div>
		<div class="card-footer">
<!-- Modal -->
			<div class="modal-footer">
<form name="sendForm" action="<?php echo $g['s']?>/" method="post">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="">
	<input type="hidden" name="type" value="">
	<input type="hidden" name="pass" value="">
</form>

<script>
function sendCheck(id)
{
	if (getId('_ftp_pass_').value == '')
	{
		alert('FTP 패스워드를 입력해 주세요.   ');
		getId('_ftp_pass_').focus();
		return false;
	}
	var f = document.sendForm;
	f.a.value = 'email_check';
	f.type.value = id;
	f.pass.value = getId('_ftp_pass_').value;
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
}
function uninstall()
{
	var f = document.sendForm;
	f.a.value = 'uninstall';
	getIframeForAction(f);
	f.submit();
}
</script>