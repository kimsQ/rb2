<?php
$R = getDbData($table['s_guestauth'],'token="'.$token.'"','email');
?>

<section class="row justify-content-center my-5 mx-0">
	<div class="col-5">

		<div class="text-center">
			<h2>회원가입</h2>
		</div>

		<div class="border bg-light p-3 my-5" role="alert">
			<i class="fa fa-exclamation-triangle fa-3x fa-pull-left" aria-hidden="true"></i>
			유효기간이 만료되었거나, 정상적인 토큰이 아닙니다. 다시 인증 받으시기 바랍니다.
		</div>

		<button type="button" class="btn btn-light btn-block" data-toggle="modal" data-target="#modal-join">
			회원가입 하기
		</button>

		<div class="text-center my-3">
			<span class="position-relative d-inline-block">
				<img src="<?php echo $user_avatar_src ?>" alt=<?php echo $name ?>"" class="rounded-circle border">
				<span class="position-absolute" style="bottom:0;right:0">
					<img src="<?php echo $g['img_core']?>/sns/<?php echo $sns_name ?>.png" alt="<?php echo $sns_name ?>" class="rounded-circle" width="48">
				</span>
			</span>
		</div>

		<form id="memberForm" class="my-3" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="front" value="<?php echo $front?>">
			<input type="hidden" name="a" value="join">
			<input type="hidden" name="check_id" value="1">
			<input type="hidden" name="check_nic" value="0">
			<input type="hidden" name="sns_access_token" value="<?php echo $sns_access_token?>">
			<input type="hidden" name="sns_refresh_token" value="<?php echo $sns_refresh_token?>">
			<input type="hidden" name="sns_expires_in" value="<?php echo $sns_expires_in?>">
			<input type="hidden" name="snsname" value="<?php echo $sns_name?>">
			<input type="hidden" name="snsuid" value="<?php echo $snsuid?>">
      <input type="hidden" name="_photo" value="<?php echo $_photo ?>">

			<?php if ($R['email']): ?>
			<input type="hidden" name="verified_email" value="1">
			<?php else: ?>
			<input type="hidden" name="check_email" value="0">
			<?php endif; ?>

			<?php if ($R['email']): ?>
			<div class="form-group">
				<label class="sr-only">이메일 <span class="text-danger">*</span></label>
				<input type="email" class="form-control form-control-lg" name="email" value="<?php echo $R['email'] ?>" placeholder="이메일" readonly>
				<div class="invalid-feedback" id="email-feedback">이메일을 입력해주세요.</div>
			</div>
			<?php endif; ?>


			<div class="form-group">
		    <label class="sr-only">이름</label>
				<input type="text" class="form-control form-control-lg" name="name" id="name" value="<?php echo $name ?>" placeholder="이름" autocomplete="off"  placeholder="이름">
				<div class="invalid-feedback">이름을 입력해주세요.</div>
		  </div>



			<?php if($d['member']['form_join_nic']):?>
			<div class="form-group">
		    <label>닉네임<?php if($d['member']['form_join_nic_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<input type="text" class="form-control" name="nic" id="nic" value="<?php echo $nic?>" placeholder="닉네임을 입력해 주세요." onblur="sameCheck(this,'nic-feedback');">
				<div id="nic-feedback"></div>
				<div class="invalid-feedback">닉네임을 입력해주세요.</div>
				<small class="form-text text-muted">2~12자로 사용할 수 있습니다.</small>
		  </div>
			<?php endif?>

			<?php if($d['member']['form_join_tel1']):?>
		    <div class="form-group">
		      <label>전화번호 <?php if($d['member']['form_join_tel1_required']):?><span class="text-danger">*</span><?php endif?></label>
					<div class="form-inline">
						<input type="text" name="tel1_1" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
						<input type="text" name="tel1_2" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
						<input type="text" name="tel1_3" value="" maxlength="4" size="4" class="form-control">
						<div class="invalid-feedback">
							전화번호를 입력해주세요.
						</div>
					</div><!-- /.form-inline -->
		    </div>
			<?php endif?>

			<?php if($d['member']['form_join_tel2']):?>
		    <div class="form-group">
		      <label>휴대전화 <?php if($d['member']['form_join_tel2_required']):?><span class="text-danger">*</span><?php endif?></label>
					<div class="form-inline">
						<input type="text" name="tel2_1" value="" maxlength="3" size="4" class="form-control"><span class="px-1">-</span>
						<input type="text" name="tel2_2" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
						<input type="text" name="tel2_3" value="" maxlength="4" size="4" class="form-control">
						<div class="custom-control custom-checkbox ml-3">
							<input type="checkbox" class="custom-control-input" id="sms" name="sms" value="1"<?php if($my['sms']):?> checked="checked"<?php endif?>>
							<label class="custom-control-label" for="sms">알림문자를 받겠습니다.</label>
						</div>
						<div class="invalid-feedback">
							휴대전화 번호를 입력해주세요.
						</div>
					</div><!-- /.form-inline -->
		    </div>
			<?php endif?>

			<?php if($d['member']['form_join_birth']):?>
		  <div class="form-group">
		    <label>생년월일<?php if($d['member']['form_join_birth_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<div class="form-inline">
					<select class="form-control custom-select" name="birth_1">
						<option value="">년도</option>
						<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
						<option value="<?php echo $i?>"<?php if(substr($i,-2)==substr($regis_jumin1,0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
						<?php endfor?>
					</select>
					<select class="form-control custom-select ml-2" name="birth_2">
						<option value="">월</option>
						<?php $birth_2=substr($my['birth2'],0,2)?>
						<?php for($i = 1; $i < 13; $i++):?>
						<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
						<?php endfor?>
					</select>
					<select class="form-control custom-select ml-2" name="birth_3">
						<option value="">일</option>
						<?php $birth_3=substr($my['birth2'],2,2)?>
						<?php for($i = 1; $i < 32; $i++):?>
						<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($regis_jumin1,4,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
						<?php endfor?>
					</select>
					<div class="custom-control custom-checkbox ml-3">
						<input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1">
						<label class="custom-control-label" for="birthtype">음력</label>
					</div>
					<div class="invalid-feedback">
						생년월일을 지정해 주세요.
					</div>
				</div><!-- /.form-inline -->
		  </div>
			<?php endif?>

			<?php if($d['member']['form_join_sex']):?>
		  <div class="form-group">
		    <label>성별 <?php if($d['member']['form_join_sex_required']):?><span class="text-danger">*</span><?php endif?></label>
				<div class="custom-control custom-radio  custom-control-inline">
					<input type="radio" id="sex_1" name="sex" class="custom-control-input" value="1"<?php if($regis_jumin2&&(substr($regis_jumin2,0,1)%2)==1):?> checked="checked"<?php endif?> >
					<label class="custom-control-label" for="sex_1">남성</label>
				</div>
				<div class="custom-control custom-radio  custom-control-inline">
					<input type="radio" id="sex_2" name="sex" class="custom-control-input" value="2"<?php if($regis_jumin2&&(substr($regis_jumin2,0,1)%2)==0):?> checked="checked"<?php endif?>>
					<label class="custom-control-label" for="sex_2">여성</label>
				</div>
				<div class="invalid-feedback">
					성별을 선택해 주세요.
				</div>
		  </div>
			<?php endif?>

			<?php if($d['member']['form_join_addr']):?>
		  <div class="form-group">
		    <label>주소 <?php if($d['member']['form_join_addr_required']):?><span class="text-danger">*</span><?php endif?></label>
				<div id="addrbox">
					<div class="form-row">
					 <div class="form-group col-3">
						 <input type="text" class="form-control" name="zip_1" value="" id="zip" maxlength="5" size="5" readonly>
					 </div>
					 <div class="form-group col-6">
						 <button type="button" class="btn btn-light" role="button" id="execDaumPostcode">우편번호찾기</button>
					 </div>
				 </div>
				 <input type="text" class="form-control mb-2" name="addr1" id="addr1" value="" readonly>
				 <input type="text" class="form-control mb-2" name="addr2" id="addr2" value="">
				 <div class="invalid-feedback">
					 주소를 입력해주세요.
				 </div>

				</div><!-- /#addrbox -->

				<?php if($d['member']['form_join_overseas']):?>
				<div class="">
					<?php if($my['addr0']=='해외'):?>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="overseas" name="overseas" value="1" checked="checked" onclick="overseasChk(this);">
						<label class="custom-control-label" for="overseas" id="overseas_ment">해외거주자 입니다.</label>
					</div>
					<?php else:?>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="overseas" name="overseas" value="1" onclick="overseasChk(this);">
						<label class="custom-control-label" for="overseas" id="overseas_ment">해외거주자일 경우 체크해 주세요.</label>
					</div>
					<?php endif?>
				</div>
				<?php endif?>

				<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
				<script>
					$(function() {
						$("#execDaumPostcode").click(function() {
							// 우편번호 찾기 화면을 넣을 element
							var element_wrap = document.getElementById('postLayer');

							function execDaumPostcode() {
									new daum.Postcode({
											 oncomplete: function(data) {
													 // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

													 // 각 주소의 노출 규칙에 따라 주소를 조합한다.
													 // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
													 var fullAddr = data.address; // 최종 주소 변수
													 var extraAddr = ''; // 조합형 주소 변수

													 // 기본 주소가 도로명 타입일때 조합한다.
													 if(data.addressType === 'R'){
															 //법정동명이 있을 경우 추가한다.
															 if(data.bname !== ''){
																	 extraAddr += data.bname;
															 }
															 // 건물명이 있을 경우 추가한다.
															 if(data.buildingName !== ''){
																	 extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
															 }
															 // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
															 fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
													 }

													 // 우편번호와 주소 정보를 해당 필드에 넣는다.
													 document.getElementById('zip').value = data.zonecode; //5자리 새우편번호 사용
													 document.getElementById('addr1').value = fullAddr;
													 $('#modal-DaumPostcode').modal('hide')// 우편번호 검색모달을 숨김
													 $('#addr2').focus()
											 },

											 // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
											 width : '100%',
											 height : '100%'
									 }).embed(element_wrap);
									 element_wrap.style.display = 'block';
									$('#modal-DaumPostcode').modal('show')
							}
							execDaumPostcode()

						})
					});
				</script>

		  </div>

			<!-- Modal -->
			<div id="modal-DaumPostcode" class="modal fade" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">우편번호 찾기</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body p-0" id="postLayer" style="height: 500px">
			      </div>
			    </div>
			  </div>
			</div>

		  <?php endif?>


			<?php if($d['member']['form_join_bio']):?>
		  <div class="form-group">
		    <label>간단소개<?php if($d['member']['form_join_bio_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<textarea class="form-control" name="bio" rows="3" placeholder="간략한 소개글을 입력해주세요."><?php echo $my['bio']?></textarea>
				<div class="invalid-feedback">
					간단소개를 입력해 주세요.
				</div>
		  </div>
		  <?php endif?>

		  <?php if($d['member']['form_join_home']):?>
		  <div class="form-group">
		    <label>홈페이지<?php if($d['member']['form_join_home_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<input type="text" class="form-control" name="home" value="" placeholder="URL을 입력하세요.">
				<div class="invalid-feedback">
					홈페이지 주소를 입력해주세요.
				</div>
		  </div>
		  <?php endif?>

		  <?php if($d['member']['form_join_job']):?>
		  <div class="form-group">
		    <label>직업<?php if($d['member']['form_join_job_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<select class="form-control custom-select" name="job">
					<option value="">&nbsp;+ 선택하세요</option>
					<option value="" disabled>------------------</option>
					<?php
					$g['memberJobVarForSite'] = $g['path_var'].'site/'.$r.'/member.job.txt';
					$_tmpvfile = file_exists($g['memberJobVarForSite']) ? $g['memberJobVarForSite'] : $g['path_module'].$module.'/var/member.job.txt';
					$_job=file($_tmpvfile);
					?>
					<?php foreach($_job as $_val):?>
					<option value="<?php echo trim($_val)?>">ㆍ<?php echo trim($_val)?></option>
					<?php endforeach?>
				</select>
				<div class="invalid-feedback">
					직업을 선택해 주세요.
				</div>
		  </div>
			<?php endif?>

			<?php if($d['member']['form_join_marr']):?>
		  <div class="form-group">
		    <label>결혼기념일<?php if($d['member']['form_join_marr_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<div class="form-inline">

					<select class="form-control custom-select" name="marr_1">
						<option value="">년도</option>
						<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
						<option value="<?php echo $i?>"><?php echo $i?></option>
						<?php endfor?>
					</select>
					<select class="form-control custom-select ml-2" name="marr_2">
						<option value="">월</option>
						<?php for($i = 1; $i < 13; $i++):?>
						<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
						<?php endfor?>
					</select>
					<select class="form-control custom-select ml-2" name="marr_3">
						<option value="">일</option>
						<?php for($i = 1; $i < 32; $i++):?>
						<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
						<?php endfor?>
					</select>
					<div class="invalid-feedback">
						결혼기념일을 입력해주세요.
					</div>
				</div><!-- /.form-inline -->
		  </div>
			<?php endif?>


			<!-- 추가 가입항목 -->
			<?php $_add = file($g['path_var'].'site/'.$_HS['id'].'/member.add_field.txt')?>
			<?php foreach($_add as $_key):?>
			<?php $_val = explode('|',trim($_key))?>
			<?php if($_val[6]) continue?>
			<div class="form-group">
				<label><?php echo $_val[1]?><?php if($_val[5]):?><span class="text-danger">*</span><?php endif?></label>

				<?php if($_val[2]=='text'):?>
				<input type="text" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_val[3]?>"<?php if($_val[5]):?> required<?php endif?>>
				<?php endif?>
				<?php if($_val[2]=='password'):?>
				<input type="password" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_val[3]?>"<?php if($_val[5]):?> required<?php endif?>>
				<?php endif?>
				<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
				<select name="add_<?php echo $_val[0]?>" class="form-control custom-select"<?php if($_val[5]):?> required<?php endif?>>
					<option value="">&nbsp;+ 선택하세요</option>
					<?php foreach($_skey as $_sval):?>
					<option value="<?php echo trim($_sval)?>">ㆍ<?php echo trim($_sval)?></option>
					<?php endforeach?>
				</select>
				<?php endif?>
				<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
				<div class="">
				<?php foreach($_skey as $_sval):?>
				<div class="custom-control custom-radio custom-control-inline">
				  <input type="radio" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>" class="custom-control-input">
				  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
				</div>
				<?php endforeach?>
				</div>
				<?php endif?>
				<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
				<div>
				<?php foreach($_skey as $_sval):?>
				<div class="custom-control custom-checkbox custom-control-inline">
				  <input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>">
				  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
				</div>
				<?php endforeach?>
				</div>
				<?php endif?>
				<?php if($_val[2]=='textarea'):?>
				<textarea name="add_<?php echo $_val[0]?>" rows="5" class="form-control"<?php if($_val[5]):?> required<?php endif?>><?php echo $_val[3]?></textarea>
				<?php endif?>

			</div><!-- /.form-group -->
			<?php endforeach?>



			<div class="d-flex justify-content-between mt-4">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="agreecheckbox" name="agreecheckbox">
					<label class="custom-control-label" for="agreecheckbox">서비스 약관에 동의합니다.</label>
					<div class="invalid-feedback">
						회원으로 가입을 원하실 경우, 약관에 동의하셔야 합니다.
					</div>
				</div>

				<a href="<?php echo RW('mod=policy') ?>" class="muted-link" target="_blank">약관보기</a>
			</div>

			<button class="btn btn-outline-primary btn-block btn-lg js-submit mt-5" type="submit">
				<span class="not-loading">가입하기</span>
				<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 회원가입 중 ...</span>
			</button>


		</form>

	</div><!-- .col_*-->
</section><!-- /.row -->

<script type="text/javascript">

var f = document.getElementById("memberForm");

function overseasChk(obj) {
	if (obj.checked == true)
	{
    $('#addrbox').addClass('d-none')
    $('#overseas_ment').text('해외거주자 입니다.')
	}
	else {
    $('#addrbox').removeClass('d-none')
    $('#overseas_ment').text('해외거주자일 경우 체크해 주세요.')
	}
}

function sameCheck(obj,layer) {
	if (!obj.value)
	{
		eval('f.check_'+obj.name).value = '0';
		f.classList.remove('was-validated');
		obj.classList.remove('is-invalid','is-valid');
		getId(layer).innerHTML = '';
	}
	else
	{
		if (obj.name == 'email')
		{
			if (!chkEmailAddr(obj.value))
			{
				f.check_email.value = '0';
				setTimeout(function() {
							obj.focus();
					}, 0);
				f.classList.remove('was-validated');
				obj.classList.add('is-invalid');
				obj.classList.remove('is-valid');
				getId(layer).innerHTML = '이메일형식이 아닙니다';
				return false;
			}
		}
		if (obj.name == 'nic')
		{
			if (obj.value.length < 2 || obj.value.length > 12 )
			{
				f.check_nic.value = '0';
				setTimeout(function() {
					obj.focus();
				}, 0);
				f.classList.remove('was-validated');
				obj.classList.add('is-invalid');
				obj.classList.remove('is-valid');
				getId(layer).innerHTML = '사용할 수 없는 닉네임 입니다.';
				return false;
			}
		}
		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&a=same_check&fname=' + obj.name + '&fvalue=' + obj.value + '&flayer=' + layer;
	}
}

function _submit() {
	getIframeForAction(f);
	f.submit();
}


$(function () {

	$('#memberForm').submit( function(event){

		if (f.name.value == '')
		{
			f.name.classList.add('is-invalid');
			f.name.focus();
			return false;
		}

		if (f.check_email.value == '0')
		{
			f.email.classList.add('is-invalid');
			f.email.focus();
			return false;
		}

		<?php if($d['member']['form_join_nic_required']):?>
		if (f.check_nic.value == '0')
		{
			f.nic.classList.add('is-invalid')
			f.nic.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_tel1']&&$d['member']['form_join_tel1_required']):?>
		if (f.tel1_1.value == '')
		{
			f.tel1_1.classList.add('is-invalid');
			f.tel1_1.focus();
			return false;
		}
		if (f.tel1_2.value == '')
		{
			f.tel1_2.classList.add('is-invalid');
			f.tel1_2.focus();
			return false;
		}
		if (f.tel1_3.value == '')
		{
			f.tel1_3.classList.add('is-invalid');
			f.tel1_3.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_tel2']&&$d['member']['form_join_tel2_required']):?>
		if (f.tel2_1.value == '')
		{
			f.tel2_1.classList.add('is-invalid');
			f.tel2_1.focus();
			return false;
		}
		if (f.tel2_2.value == '')
		{
			f.tel2_2.classList.add('is-invalid');
			f.tel2_2.focus();
			return false;
		}
		if (f.tel2_3.value == '')
		{
			f.tel2_3.classList.add('is-invalid');
			f.tel2_3.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_birth']&&$d['member']['form_join_birth_required']):?>
		if (f.birth_1.value == '')
		{
			f.birth_1.classList.add('is-invalid');
			f.birth_1.focus();
			return false;
		}
		if (f.birth_2.value == '')
		{
			f.birth_2.classList.add('is-invalid');
			f.birth_2.focus();
			return false;
		}
		if (f.birth_3.value == '')
		{
			f.birth_3.classList.add('is-invalid');
			f.birth_3.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_sex']&&$d['member']['form_join_sex_required']):?>
		if (f.sex[0].checked == false && f.sex[1].checked == false)
		{
			f.sex.classList.add('is-invalid');
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_addr']&&$d['member']['form_join_addr_required']):?>
		if (!f.overseas || f.overseas.checked == false)
		{
			if (f.addr1.value == ''||f.addr2.value == '')
			{
				f.addr2.classList.add('is-invalid');
				f.addr2.focus();
				return false;
			}
		}
		<?php endif?>

		<?php if($d['member']['form_join_bio']&&$d['member']['form_join_bio_required']):?>
		if (f.bio.value == '')
		{
			f.bio.classList.add('is-invalid');
			f.bio.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_home']&&$d['member']['form_join_home_required']):?>
		if (f.home.value == '')
		{
			f.home.classList.add('is-invalid');
			f.home.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_job']&&$d['member']['form_join_job_required']):?>
		if (f.job.value == '')
		{
			f.job.classList.add('is-invalid');
			f.job.focus();
			return false;
		}
		<?php endif?>

		<?php if($d['member']['form_join_marr']&&$d['member']['form_join_marr_required']):?>
		if (f.marr_1.value == '')
		{
			f.marr_1.classList.add('is-invalid');
			f.marr_1.focus();
			return false;
		}
		if (f.marr_2.value == '')
		{
			f.marr_2.classList.add('is-invalid');
			f.marr_2.focus();
			return false;
		}
		if (f.marr_3.value == '')
		{
			f.marr_3.classList.add('is-invalid');
			f.marr_3.focus();
			return false;
		}
		<?php endif?>


		var radioarray;
		var checkarray;
		var i;
		var j = 0;
		<?php foreach($_add as $_key):?>
		<?php $_val = explode('|',trim($_key))?>
		<?php if(!$_val[5]||$_val[6]) continue?>
		<?php if($_val[2]=='text' || $_val[2]=='password' || $_val[2]=='select' || $_val[2]=='textarea'):?>
		if (f.add_<?php echo $_val[0]?>.value == '')
		{
			alert('<?php echo $_val[1]?>이(가) <?php echo $_val[2]=='select'?'선택':'입력'?>되지 않았습니다.     ');
			f.add_<?php echo $_val[0]?>.focus();
			return false;
		}
		<?php endif?>
		<?php if($_val[2]=='radio'):?>
		j = 0;
		radioarray = f.add_<?php echo $_val[0]?>;
		for (i = 0; i < radioarray.length; i++)
		{
			if (radioarray[i].checked == true) j++;
		}
		if (!j)
		{
			alert('<?php echo $_val[1]?>이(가) 선택되지 않았습니다.     ');
			radioarray[0].focus();
			return false;
		}
		<?php endif?>
		<?php if($_val[2]=='checkbox'):?>
		j = 0;
		checkarray = document.getElementsByName("add_<?php echo $_val[0]?>[]");
		for (i = 0; i < checkarray.length; i++)
		{
			if (checkarray[i].checked == true) j++;
		}
		if (!j)
		{
			alert('<?php echo $_val[1]?>이(가) 선택되지 않았습니다.     ');
			checkarray[0].focus();
			return false;
		}
		<?php endif?>
		<?php endforeach?>


		if (f.check_id.value == '0' || f.check_email.value == '0' || f.check_pw.value == '0') {
			event.preventDefault();
			event.stopPropagation();
		}

		if (f.agreecheckbox.checked == false){
			$('#agreecheckbox').addClass('is-invalid')
			f.agreecheckbox.focus();
			return false;
		}

		$('.js-submit').attr("disabled",true);
		setTimeout("_submit();",500);

		event.preventDefault();
		event.stopPropagation();
		}
	);

})
</script>
