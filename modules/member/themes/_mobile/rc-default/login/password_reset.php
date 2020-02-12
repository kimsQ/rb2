<header class="bar bar-nav bar-light bg-faded">
	<a class="icon icon-left-nav pull-left" role="button" data-history="back"></a>
  <h1 class="title">임시 비밀번호 요청</h1>
</header>


<?php $id_or_email='회원가입시 등록한 '.($d['member']['login_emailid']?'아이디':'이메일').'을 입력해주세요.'?>

<div class="content">

	<form id="request_tmpPW" class="content-padded" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="a" value="pw_tmp">

		<div id="notice"></div>

		<div class="">
			<div class="card-body">
				<div class="form-group">
					<label for="join_email" class="control-label">
						등록된 이메일을 입력해 주세요.
					</label>
					<input type="email" id="email_field" class="form-control" name="email"  placeholder="이메일을 입력해주세요." required autofocus value="<?php echo $my['email'] ?>">
				</div>
				<div class="div">
					<button type="submit" class="btn btn-primary btn-block">임시 비밀번호 요청</button>

					<?php if (!$my['email']): ?>
					<button type="button" class="btn btn-secondary btn-block" data-target="#findEmail" data-toggle="modal">이메일 찾기</button>
					<?php endif; ?>

				</div>
			</div><!-- /.card-boy -->


		<div class="rb-complete m-t-1">
			<p>
				몇분이 지나도 메일수신이 안되었을 경우, 스펨 메일함을 확인해 보시고 기타사항에 대해서는 관리자에게 문의해주세요.
				<mark>임시 비밀번호로 로그인한 후, 비밀번호를 변경해주세요.</mark>
			</p>

			<?php if ($my['uid']): ?>
			<a href="#" class="btn btn-light btn-block">비밀번호 변경 페이지로 돌아가기</a>
			<?php else: ?>
			<a href="#modal-login" data-toggle="modal" class="btn btn-secondary btn-block">로그인 하기</a>
			<?php endif; ?>

		</div>


	</form>

</div>

<!-- 이메일 찾기  -->

<!-- Modal -->
<div id="findEmail" class="modal">
  <header class="bar bar-nav bar-light bg-faded">
    <a class="icon icon-close pull-right" data-dismiss="modal" role="button"></a>
    <h1 class="title"><i class="fa fa-search"></i> 이메일 찾기</h1>
  </header>
  <div class="content bg-faded">
		<form name="procForm1" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $m?>" />
			<input type="hidden" name="a" value="email_search" />

			<p class="f12 mb-3 content-padded">
				회원가입시 등록한 이름(실명)과 아이디를 입력하시면 이메일을 확인하실 수 있습니다.
			</p>

			<div class="card">
		    <div class="form-list">
					<input type="text" name="name" id="join_name" placeholder="등록된 이름을 입력 해주세요." required>
					<input type="text" name="id" id="join_id" placeholder="등록된 <?php echo $d['member']['login_emailid']?'아이디':'이메일'?>를 입력 해주세요." required>
		    </div>
		  </div>

			<div class="content-padded">
				 <button type="submit" class="btn btn-secondary btn-block">찾기</button>
			</div>
		</form>
  </div>
</div>


<script type="text/javascript">

$('#findEmail').on('shown.bs.modal', function () {
  $('#join_name').val('').trigger('focus')
	$('#join_id').val('')
})


function pwCheck(f)
{
	if (f.new_id.value == '')
	{
		alert('<?php echo $d['member']['login_emailid']?'이메일을':'아이디를'?> 입력해 주세요.   ');
		f.new_id.focus();
		return false;
	}
	if (f.id_auth.value == '2')
	{
		if (f.new_pw_a.value == '')
		{
			alert('답변을 입력해 주세요.   ');
			f.new_pw_a.focus();
			return false;
		}
	}
	if (f.id_auth.value == '3')
	{
		if (f.new_pw1.value == '')
		{
			alert('새 패스워드를 입력해 주세요.');
			f.new_pw1.focus();
			return false;
		}
		if (f.new_pw2.value == '')
		{
			alert('새 패스워드를 한번더 입력해 주세요.');
			f.new_pw2.focus();
			return false;
		}
		if (f.new_pw1.value != f.new_pw2.value)
		{
			alert('새 패스워드가 일치하지 않습니다.');
			f.new_pw1.focus();
			return false;
		}

		alert('입력하신 패스워드로 재등록 되었습니다.');
	}
}

</script>
