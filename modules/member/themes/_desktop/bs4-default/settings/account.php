
<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
	<nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>

	<div class="col-9 page-main">

	  <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
		<div class="subhead mt-0">
			<h2 class="subhead-heading">회원계정 관리</h2>
		</div>
		<?php include_once $g['dir_module_skin'].'_lock.php'?>
		<?php else: ?>
			<div class="subhead mt-0">
				<h2 class="subhead-heading">비밀번호 <?php echo $my['last_pw']?'변경':'등록' ?></h2>
			</div>
			<form class="card" id="pwChangeForm" role="form" action="<?php echo $g['s']?>/" method="post">
				<div class="card-header">
					<div class="media">
			      <i class="fa fa-key fa-3x mx-3" aria-hidden="true"></i>
			      <div class="media-body">
							<?php if ($my['last_pw']): ?>
							현재 비밀번호는 <mark><?php echo getDateFormat($my['last_pw'],'Y.m.d')?></mark> 에 변경(등록)되었으며 <mark><?php echo -getRemainDate($my['last_pw'])?>일</mark>이 경과되었습니다. <br>
							비밀번호는 가급적 주기적으로 변경해 주세요.
							<?php else: ?>
							본 계정은 소셜로그인을 통해 가입된 계정으로 현재 비밀번호가 등록되어 있지 않습니다.<br>
							비밀번호를 등록하면 비밀번호를 통한 로그인이 가능합니다.
							<?php endif; ?>

			      </div>
			    </div>
				</div>
				<div class="card-body">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="a" value="settings_account">
					<input type="hidden" name="act" value="pw">
					<input type="hidden" name="check_pw1" value="0">
					<input type="hidden" name="check_pw2" value="0">

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">신규 비밀번호</label>
						<div class="col-sm-10">
							<input type="password" class="form-control w-50" name="pw1" value="" onkeyup="pw1Check();" placeholder="비밀번호(6~16자리)">
							<div class="invalid-tooltip" id="pw1-feedback"></div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">비밀번호 확인</label>
						<div class="col-sm-10">
							<input type="password" class="form-control w-50" name="pw2" value="" placeholder="한번 더 입력하세요.">
							<div class="invalid-tooltip" id="pw2-feedback"></div>
						</div>
					</div>

				</div><!-- ./card-body -->
				<div class="card-footer d-flex justify-content-between align-items-center">
					<?php if ($my['last_pw']): ?>
					<button type="submit" class="btn btn-light">
						<span class="not-loading">변경하기</span>
						<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 변경중 ...</span>
					</button>
					<?php else: ?>
					<span></span>
					<button type="submit" class="btn btn-light">
						<span class="not-loading">등록하기</span>
						<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 등록중 ...</span>
					</button>
					<?php endif; ?>
				</div>

			</form><!-- /.card -->


			<div class="subhead mt-5">
				<h2 class="subhead-heading">아이디 변경</h2>
			</div>
			<div class="card">
				<div class="card-body">

					<ul class="list-unstyled">
						<li>· 회원님의 공개 프로필 주소는 <a href="/@<?php echo $my['id'] ?>" target="_blank"><?php echo $_SERVER['HTTP_HOST']; ?>/@<?php echo $my['id'] ?></a> 입니다.</li>
						<li>· 아이디는 계정이 만들어질때 자동으로 생성되며 중복되지 않을 경우 변경등록이 가능합니다.</li>
						<li>· 아이디는 로그인 및 공개 프로필 주소에 활용됩니다.</li>
					</ul>

					<hr>

					<form id="idChangeForm" role="form" action="<?php echo $g['s']?>/" method="post">
						<input type="hidden" name="r" value="<?php echo $r?>">
						<input type="hidden" name="m" value="<?php echo $m?>">
						<input type="hidden" name="a" value="settings_account">
						<input type="hidden" name="act" value="id">
						<input type="hidden" name="check_id" value="1">

						<div class="form-group row my-5">
							<label class="col-sm-2 col-form-label text-center">아이디</label>
							<div class="col-sm-10">
								<div class="input-group w-75 position-relative mb-0">
								  <input type="text" class="form-control" name="id" placeholder="아이디" value="<?php echo $my['id'] ?>" size="13" maxlength="13" onkeyup="idCheck(this,'id-feedback');">
									<div class="invalid-tooltip" id="id-feedback"></div>
									<div class="input-group-append">
										<button type="submit" class="btn btn-light">
											<span class="not-loading">변경하기</span>
											<span class="is-loading">처리중 ...</span>
										</button>
									</div>
								</div>

							</div>
						</div>

					</form>

				</div>
			</div>


			<div class="subhead mt-5">
				<h2 class="subhead-heading">회원탈퇴</h2>
			</div>


			<form class="card" name="procForm" role="form" action="<?php echo $g['s']?>/" method="post">

				<div class="card-header">
					<div class="media">
						<i class="fa fa-user-times fa-3x mx-3" aria-hidden="true"></i>
						<div class="media-body">
							사용하고 계신 아이디 (<code><?php echo $my['id'] ?></code>) 는 탈퇴할 경우 재사용 및 복구가 불가능합니다. <br>
							탈퇴한 아이디는 본인과 타인 모두 재사용 및 복구가 불가하오니 신중하게 선택하시기 바랍니다.
						</div>
					</div>
				</div>
				<div class="card-body">
					<ul class="list-unstyled">
						<li>· 탈퇴 후 회원정보 및 개인형 서비스 이용기록은 모두 삭제됩니다.</li>
						<li>· 회원정보 및 개인형 서비스 이용기록은 모두 삭제되며, 삭제된 데이터는 복구되지 않습니다.</li>
						<li>· 삭제되는 내용을 확인하시고 필요한 데이터는 미리 백업을 해주세요.</li>
						<li>· 탈퇴 후에는 아이디 (<code><?php echo $my['id'] ?></code>)로 다시 가입할 수 없으며 아이디와 데이터는 복구할 수 없습니다.</li>
						<li>· 게시판형 서비스에 남아 있는 게시글과 댓글은 탈퇴 후 삭제할 수 없습니다.</li>
					</ul>

					<div class="custom-control custom-checkbox f16">
						<input type="checkbox" class="custom-control-input" id="reaveCheck">
						<label class="custom-control-label" for="reaveCheck">위 내용을 모두 확인하였습니다.</label>
					</div>

					<hr>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center">아이디</label>
						<div class="col-sm-10">
							<input type="text" name="id" readonly class="form-control-plaintext" value="<?php echo $my['id'] ?>">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center">이름</label>
						<div class="col-sm-10">
							<input type="text" name="name" readonly class="form-control-plaintext" value="<?php echo $my['name'] ?>">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center">비밀번호</label>
						<div class="col-sm-8">
							<input type="password" name="pw" id="password" class="form-control form-control-lg" placeholder="" required="" autocomplete="new-pw">
							<div class="invalid-feedback mt-2" data-role="passwordErrorBlock"></div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label text-center"></label>
						<div class="col-sm-8">
							<input type="password" name="pw2" class="form-control form-control-lg" placeholder="다시 한번 입력해주세요."  required="" value="">
							<div class="invalid-feedback mt-2" data-role="passwordErrorBlock"></div>

							<p class="mt-3 mb-0 text-muted">회원탈퇴를 원하시면 비밀번호를 입력하신 후 ‘탈퇴하기’ 버튼을 클릭해 주세요.</p>

						</div>
					</div>

				</div>

				<div class="card-footer d-flex justify-content-between align-items-center">
					<a href="<?php echo RW('mod=password_reset')?>">비밀번호를 분실했어요.</a>
					<button type="submit" class="btn btn-light text-danger">탈퇴하기</button>
				</div>

			</form><!-- /.card -->

			<script type="text/javascript">

			var f_pw = getId('pwChangeForm');  // dom 선택자
			var form_pw = $('#pwChangeForm'); // jquery 선택자

			var f_id = getId('idChangeForm');  // dom 선택자
			var form_id = $('#idChangeForm'); // jquery 선택자

			function pw1Check() {
				var layer = 'pw1-feedback';

				if (!f_pw.pw1.value) {
					f_pw.pw1.classList.remove('is-valid','is-invalid');
				} else {

					f_pw.classList.remove('was-validated');
					f_pw.pw1.classList.add('is-invalid');
					f_pw.pw1.classList.remove('is-valid');

					if (f_pw.pw1.value.length < 6 || f_pw.pw1.value.length > 16)
					{
						getId(layer).innerHTML = '영문/숫자/특수문자중 2개 이상의 조합으로 최소 6~16자로 입력하셔야 합니다.';
						f_pw.pw1.focus();
						f_pw.check_pw1.value = '0';
						return false;
					}
					if (getTypeCheck(f_pw.pw1.value,"abcdefghijklmnopqrstuvwxyz"))
					{
						getId(layer).innerHTML = '비밀번호가 영문만으로 입력되었습니다.\n비밀번호는 영문/숫자/특수문자중 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
						f_pw.pw1.focus();
						f_pw.check_pw1.value = '0';
						return false;
					}
					if (getTypeCheck(f_pw.pw1.value,"1234567890"))
					{
						getId(layer).innerHTML = '비밀번호가 숫자만으로 입력되었습니다.\n비밀번호는 영문/숫자/특수문자중 2개 이상의 조합으로 최소 6자이상 입력하셔야 합니다.';
						f_pw.pw1.focus();
						f_pw.check_pw1.value = '0';
						return false;
					}

					f_pw.pw1.classList.add('is-valid');
					f_pw.pw1.classList.remove('is-invalid');
					getId(layer).innerHTML = '';
					f_pw.check_pw1.value = '1';
				}

			}

			function pw2Check() {
				var layer = 'pw2-feedback';

				if (!f_pw.pw1.value) {
					f_pw.pw2.value = '';
					f_pw.pw1.focus();
				} else {
					f_pw.classList.remove('was-validated');
					f_pw.pw2.classList.add('is-invalid');
					f_pw.pw2.classList.remove('is-valid');

					if (f_pw.pw1.value != f_pw.pw2.value)
					{
						getId(layer).innerHTML = '비밀번호가 일치하지 않습니다.';
						f_pw.classList.remove('was-validated');
						f_pw.pw2.focus();
						f_pw.check_pw2.value = '0';
						return false;
					}

					f_pw.pw2.classList.add('is-valid');
					f_pw.pw2.classList.remove('is-invalid');
					getId(layer).innerHTML = '';

				 f_pw.check_pw2.value = '1';
				}
			}

			function idCheck(obj,layer) {

				if (!obj.value)
				{
					eval('obj.form.check_'+obj.name).value = '0';
					obj.classList.remove('is-invalid');
					getId(layer).innerHTML = '';
				}
				else {
					if (obj.value.length < 4 || obj.value.length > 13 || !getTypeCheck(obj.value,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_"))
					{
						obj.form.check_id.value = '0';
						obj.classList.add('is-invalid');
						obj.focus();
						getId(layer).innerHTML = '4~13자 이내에서 영문 대소문자,숫자,_ 만 사용할 수 있습니다';
						return false;
					} else {
						obj.form.check_id.value = '1';
						obj.classList.remove('is-invalid');
					}
				}
			}

			$(function () {

				putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

				//비밀번호 변경시 입력항목 유용성 체크
				form_pw.find('[name="pw2"]').keyup(function(){
					$(this).removeClass('is-invalid is-valid')
				});

				// 비밀번호 변경 실행
				f_pw.addEventListener('submit', function(event) {
					event.preventDefault();
					event.stopPropagation();

					if (f_pw.pw1.value == '') {
						f_pw.pw1.focus()
						f_pw.pw1.classList.add('is-invalid')
						getId('pw1-feedback').innerHTML = '패스워드를 입력해주세요.';
						return false;
					}
					if (f_pw.check_pw1.value == '0') {
						f_pw.pw2.value = ''
						f_pw.pw2.classList.remove('is-valid','is-invalid');
						f_pw.check_pw2.value = '0'
						f_pw.pw1.focus();
						return false;
					}

					pw2Check()

					if (f_pw.pw2.value == '') {
				    f_pw.pw2.focus()
				    f_pw.pw2.classList.add('is-invalid')
						getId('pw2-feedback').innerHTML = '패스워드를 한번더 입력해주세요.';
				    return false;
				  }


					if (f_pw.check_pw1.value == '0' || f_pw.check_pw2.value == '0') {
						return false;
					}

					form_pw.find('[type="submit"]').attr("disabled",true);

					f_pw.classList.add('was-validated');

					form_pw.find('.form-control').removeClass('is-invalid')  //에러이력 초기화
					setTimeout(function(){
						getIframeForAction(f_pw);
						f_pw.submit();
					}, 500);

				});

				//아이디 변경 실행
				f_id.addEventListener('submit', function(event) {
					event.preventDefault();
					event.stopPropagation();

					if (f_id.id.value == '') {
						f_id.id.focus()
						f_id.id.classList.add('is-invalid')
						getId('id-feedback').innerHTML = '아이디를 입력해주세요.';
						return false;
					}
					if (f_id.check_id.value == '0') {
						f_id.id.value = ''
						f_id.id.classList.remove('is-valid','is-invalid');
						f_id.check_id.value = '0'
						f_id.id.focus();
						return false;
					}

					form_id.find('[type="submit"]').attr("disabled",true);
					form_id.find('.form-control').removeClass('is-invalid')  //에러이력 초기화
					setTimeout(function(){
						getIframeForAction(f_id);
						f_id.submit();
					}, 300);

				});


				$('[data-toggle="actionIframe"]').click(function() {
					getIframeForAction('');
					frames.__iframe_for_action__.location.href = $(this).attr("data-url");
				});

			})

			</script>


		<?php endif; ?>

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>
