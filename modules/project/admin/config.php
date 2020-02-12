<?php include $g['path_module'].$module.'/var/var.php' ?>

<div id="configbox" class="p-4">


	<div class="card mb-3">
		<div class="card-header">
			프로젝트 키
		</div>
		<div class="card-body">

			<span class="form-text text-muted mb-4">
				프로젝트 키는 킴스큐 프로젝트와 호스팅 계정간의 제반정보의 연동을 위한 인증 및 지원을 위해 활용되며 호스팅 개설시 부여됩니다.<br>
				key가 맞지 않거나 분실시에는 <a href="https://kimsq.com" target="_blank">kimsq.com</a> 에 로그인 후, 나의 프로젝트 > 호스팅 > kimsQ 설치 페이지에서 확인할 수 있습니다.<br>
				기타 문의 사항은 live@kimsq.com 또는 전화 1544-1507 로 문의 바랍니다.
			</span>

			<form name="procKey" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="a" value="key">

				<div class="input-group input-group-lg">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
					</div>
					<input class="form-control js-key" type="text" name="key" value="<?php echo trim(implode('',file($g['path_var'].'project.key.txt')))?>" required  autocomplete="off">
					<div class="input-group-append">
						<button class="btn btn-light" type="submit">저장</button>
					</div>
				</div>

			</form>

		</div>
	</div>

</div>




<script>


putCookieAlert('project_config_result') // 실행결과 알림 메시지 출력

$(".js-key").focus(function(){
  $(this).on("mouseup.a keyup.a", function(e){
    $(this).off("mouseup.a keyup.a").select();
  });
});

function saveCheck(f)
{
	if (confirm('정말로 실행하시겠습니까?       '))
	{
		getIframeForAction(f);
		return true;
	}
	return false;
}

</script>
