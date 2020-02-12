<div class="page-wrapper row">
		<nav class="col-3 page-nav">
	    <?php include_once $g['dir_module_skin'].'_nav.php'?>
	  </nav>

		<div class="col-9 page-main">

			<div class="subhead mt-0">
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
						<label class="col-sm-2 col-form-label text-center">패스워드</label>
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
					<a href="<?php echo RW('mod=password_reset')?>">패스워드를 분실했어요.</a>
					<button type="submit" class="btn btn-light text-danger">탈퇴하기</button>
				</div>

			</form><!-- /.card -->







		</div><!-- /.page-main -->
	</div><!-- /.page-wrapper -->

<script type="text/javascript">



</script>
