<div class="card">

	<div class="card-body">

		<p>
			연결할 페이지를 선택해 주세요.
		</p>

		<button type="button" class="btn btn-light" onclick="dropJoint('<?php echo $g['s']?>/?m=<?php echo $smodule?>&front=join');">
			회원가입
		</button>
		<button type="button" class="btn btn-light" onclick="dropJoint('<?php echo $g['s']?>/?m=<?php echo $smodule?>&front=login');">
			로그인
		</button>
		<button type="button" class="btn btn-light" onclick="dropJoint('<?php echo $g['s']?>/?m=<?php echo $smodule?>&front=profile');">
			프로필
		</button>
		<button type="button" class="btn btn-light" onclick="dropJoint('<?php echo $g['s']?>/?m=<?php echo $smodule?>&front=settings');">
			개인정보 관리
		</button>
	</div>

</div>
