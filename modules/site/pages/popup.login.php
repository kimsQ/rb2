<div id="rb-modal-body">
	<form name="LayoutLogForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return layoutLogCheck(this);" role="form">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="a" value="login">
		<input type="hidden" name="referer" value="">
		<input type="hidden" name="isModal" value="Y">

		<div class="form-group">
			<label class="sr-only" for="username">아이디 또는 이메일</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>" id="username" name="id" placeholder="아이디 또는 이메일" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label class="sr-only" for="password">Password</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" id="password" name="pw" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>" placeholder="패스워드" class="form-control">
			</div>
		</div>
		<div class="checkbox">
			<label><input name="idpwsave" class="rb-confirm" type="checkbox" value="checked"<?php if($_COOKIE['svshop']):?> checked<?php endif?>> 아이디/패스워드 기억하기</label>
		</div>
		<button type="submit" class="btn btn-primary btn-block btn-lg">로그인</button>
	</form>
</div>

<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><i class="fa fa-sign-in fa-lg"></i> 로그인 </h4>
</div>

<div id="_modal_footer" class="hidden">
	<a href="#" class="btn btn-default btn-block" data-dismiss="modal" aria-hidden="true">닫기</a>
</div>

<script>
var bootmsg = '<div class="media"><div class="media-body" style="font-size:12px;">';
	bootmsg+= '<h4 class="media-heading">로그인 정보를 저장하시겠습니까?</h4>';
	bootmsg+= '로그인 정보를 저장할 경우 다음접속시 정보를 입력하지 않으셔도 되지만,PC를 여러사람이 사용하는 공공장소에서는 체크하지 마세요.<br>';
	bootmsg+= '</div></div>';

$('.rb-confirm').on('click', function() {
	bootbox.confirm(bootmsg, function(result){
		document.LayoutLogForm.idpwsave.checked = result;
	});
	$('.bootbox .media-heading').css({'font-weight':'bold','margin-bottom':'8px'});
	$('.bootbox .modal-footer').css({'margin-top':'0','background-color':'#f2f2f2'});
	$('.bootbox .modal-footer .btn-default').addClass('pull-left');
});
function layoutLogCheck(f)
{
	if (f.id.value == '')
	{
		alert('아이디나 이메일주소를 입력해 주세요.');
		f.id.focus();
		return false;
	}
	if (f.pw.value == '')
	{
		alert('패스워드를 입력해 주세요.');
		f.pw.focus();
		return false;
	}
	f.referer.value = parent.location.href;
	getIframeForAction(f);
	return true;
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '400px';
	parent.getId('_modal_iframe_modal_window').style.height = '210px';
	parent.getId('_modal_body_modal_window').style.height = '210px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>
