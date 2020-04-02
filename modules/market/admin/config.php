<?php
include $g['path_module'].$module.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];
?>

<div id="configbox" class="p-4">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m ?>" onsubmit="return saveCheck(this);" class="form-horizontal" autocomplete="off">
		<input type="hidden" name="r" value="<?php echo $r ?>">
		<input type="hidden" name="m" value="<?php echo $module ?>">
		<input type="hidden" name="a" value="config">

		<h4>큐마켓 연결설정</h4>

		<div class="form-group row">
			<label class="col-lg-2 col-form-label pt-3">킴스큐 회원 아이디 또는 이메일</label>
			<div class="col-lg-10 col-xl-8">
				<input class="form-control form-control-lg" type="text" name="userid" value="<?php echo $d['market']['userid']?$d['market']['userid']:'' ?>" required>
				<small class="form-text text-muted">
					<a href="https://kimsq.com" target="_blank">킴스큐 포탈</a> 회원 아이디 또는 이메일
				</small>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-lg-2 col-form-label pt-3">프로젝트 키</label>
			<div class="col-lg-10 col-xl-8">
				<input class="form-control form-control-lg" type="text" name="key" value="<?php echo $d['market']['key']?$d['market']['key']:'' ?>" required>
				<small class="form-text text-muted">
					<a href="https://kimsq.com/project/my" target="_blank">내 프로젝트</a>에 접속하여 키를 확인할 수 있습니다.
				</small>
			</div>
		</div>

		<div class="form-group form-row">
			<div class="offset-sm-2 col-sm-10">
				<button type="submit" class="btn btn-primary btn-lg<?php if($g['device']):?> btn-block<?php endif?>">저장하기</button>

				<div class="mt-4">
					<small class="text-muted">
						프로젝트 키는 프로젝트의 정식판 여부를 확인하여 마켓이용과 지원에 활용됩니다.
						<a href="https://kimsq.com/docs/c/start/market" class="btn btn-light btn-sm" target="_blank">도움말</a>
					</small>
				</div>

			</div>
		</div>
	</form>

</div>

<script>

putCookieAlert('market_action_result') // 실행결과 알림 메시지 출력

function saveCheck(f) {
	getIframeForAction(f);
	return true;
}
</script>
