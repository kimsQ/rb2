	<form name="addForm" class="f13 p-4" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="admin_member_add">
		<input type="hidden" name="id" value="<?php echo $_M['id']?>">
		<input type="hidden" name="uid" value="<?php echo $_M['uid']?>">
		<input type="hidden" name="avatar" value="<?php echo $_M['photo']?>">
		<input type="hidden" name="check_id" value="1">
		<input type="hidden" name="check_nic" value="1">
		<input type="hidden" name="check_email" value="1">
		<input type="hidden" name="check_phone" value="1">
		<input type="submit" style="position:absolute;left:-1000px;">


		<div class="row">
			<div class="col">

				<div class="media">
					<img alt="avatar" src="<?php echo getAvatarSrc($_M['uid'],'64') ?>" width="64" height="64" class="rounded-circle mr-3">
					<div class="media-body">
						<p class="mb-1">
							<input type="file" name="upfile" class="hidden" id="rb-upfile-avatar" accept="image/jpg" onchange="getId('rb-photo-btn').innerHTML='이미지 파일 선택됨';">
							<button type="button" class="btn btn-light btn-sm" onclick="$('#rb-upfile-avatar').click();" id="rb-photo-btn">
								<i class="fa fa-upload" aria-hidden="true"></i>
								업로드
							</button>
						</p>
						<span class="text-muted">
							<strong>사이즈</strong>는 250*250 <strong>이상</strong>
							<?php if($_M['photo']):?> <label>( <input type="checkbox" name="avatar_delete" value="1"> 현재 아바타 삭제 )</label><?php endif?>
						</span>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="sr-only">비밀번호</label>
					<input type="password" class="form-control form-control-sm mb-2" name="pw1" placeholder="새 비밀번호">
					<input type="password" class="form-control form-control-sm" name="pw2" placeholder="비밀번호 재입력">
				</div>

				<div class="form-group row">
					<label class="col-sm-2 col-form-label">아이디</label>
					<div class="col-sm-10 pt-2">
						<span><?php echo $_M['id']?></span>
					</div>
				</div>

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">이름</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="name" placeholder="" value="<?php echo $_M['name']?>" maxlength="10">
					</div>
				</div>

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">이메일</label>
					<div class="col-sm-10">

						<select class="form-control custom-select form-control-sm" name="email">
							<option value="">&nbsp;+ 선택하세요</option>
							<option value="" disabled>------------------</option>
							<?php
							$sqlque = 'mbruid='.$_M['uid'];
							$ECD = getDbArray($table['s_mbremail'],$sqlque,'*','uid','asc',0,1);
							$NUM_MAIL = getDbRows($table['s_mbremail'],$sqlque);
							?>
							<?php while($E=db_fetch_array($ECD)):?>
							<option value="<?php echo $E['email']?>"<?php if($E['email']==$_M['email']):?> selected="selected"<?php endif?>>
								<?php echo $E['email']?> <?php if (!$E['d_verified']): ?>(미인증)<?php endif; ?>
							</option>
							<?php endwhile?>
							<?php if (!$NUM_MAIL): ?>
							<option value="" disabled selected="selected">등록된 이메일이 없습니다.</option>
							<?php endif; ?>
						</select>

						<div class=" mt-2">
							<div class="custom-control custom-checkbox custom-control-inline">
								<input type="checkbox" class="custom-control-input" id="remail" name="remail" value="1"<?php if($_M['mailing']):?> checked="checked"<?php endif?> <?php echo !$_M['email']?' disabled':'' ?>>
								<label class="custom-control-label" for="remail">뉴스레터나 공지이메일을 수신받겠습니다.</label>
							</div>
						</div>


					</div>
				</div>

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">휴대전화</label>
					<div class="col-sm-10">
						<select class="form-control custom-select form-control-sm" name="phone">
							<option value="">&nbsp;+ 선택하세요</option>
							<option value="" disabled>------------------</option>
							<?php
							$sqlque = 'mbruid='.$_M['uid'];
							$PCD = getDbArray($table['s_mbrphone'],$sqlque,'*','uid','asc',0,1);
							$NUM_PHONE = getDbRows($table['s_mbrphone'],$sqlque);
							?>
							<?php while($P=db_fetch_array($PCD)):?>
							<option value="<?php echo $P['phone']?>"<?php if($P['phone']==$_M['phone']):?> selected="selected"<?php endif?>>
								<?php echo substr($P['phone'], 0,3).'-'.substr($P['phone'], 3,4).'-'.substr($P['phone'], 7,4) ?> <?php if (!$P['d_verified']): ?>(미인증)<?php endif; ?>
							</option>
							<?php endwhile?>
							<?php if (!$NUM_PHONE): ?>
							<option value="" disabled selected="selected">등록된 휴대폰이 없습니다.</option>
							<?php endif; ?>
						</select>

						<div class="pt-2">
							<div class="custom-control custom-checkbox custom-control-inline">
								<input type="checkbox" class="custom-control-input" id="sms" name="sms" value="1"<?php if($_M['sms']):?> checked="checked"<?php endif?><?php echo !$_M['phone']?' disabled':'' ?>>
								<label class="custom-control-label" for="sms">이벤트와 공지 SMS를 수신 받겠습니다.</label>
							</div>
						</div>

					</div>
				</div>


			</div><!-- /.col -->
			<div class="col border-left">

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">닉네임</label>
					<div class="col-sm-10">
						<div class="input-group">
							<input type="text" class="form-control form-control-sm" name="nic" placeholder="" value="<?php echo $_M['nic']?>" maxlength="20" onchange="sendCheck('rb-nickcheck','nic');">
							<span class="input-group-append">
								<button type="button" class="btn btn-light" id="rb-nickcheck" onclick="sendCheck('rb-nickcheck','nic');">중복확인</button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">전화번호</label>
					<div class="col-sm-10">
						<?php $tel=explode('-',$_M['tel'])?>
						<div class="form-inline">
							<input type="text" name="tel_1" value="<?php echo $tel[0]?>" maxlength="4" size="4" class="form-control form-control-sm">
							<input type="text" name="tel_2" value="<?php echo $tel[1]?>" maxlength="4" size="4" class="form-control form-control-sm ml-2">
							<input type="text" name="tel_3" value="<?php echo $tel[2]?>" maxlength="4" size="4" class="form-control form-control-sm ml-2">
							<div class="invalid-feedback">
								전화번호를 입력해주세요.
							</div>
						</div><!-- /.form-inline -->

					</div>
				</div>



				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">생년월일</label>
					<div class="col-sm-10">

						<div class="form-inline">
							<select class="form-control custom-select form-control-sm" name="birth_1">
								<option value="">년도</option>
								<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
								<option value="<?php echo $i?>"<?php if($_M['birth1']==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
								<?php endfor?>
							</select>
							<select class="form-control custom-select ml-2 form-control-sm" name="birth_2">
								<option value="">월</option>
								<?php $birth_2=substr($_M['birth2'],0,2)?>
								<?php for($i = 1; $i < 13; $i++):?>
								<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_2==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
								<?php endfor?>
							</select>
							<select class="form-control custom-select ml-2 form-control-sm" name="birth_3">
								<option value="">일</option>
								<?php $birth_3=substr($_M['birth2'],2,2)?>
								<?php for($i = 1; $i < 32; $i++):?>
								<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_3==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
								<?php endfor?>
							</select>
							<div class="custom-control custom-checkbox ml-3">
								<input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1"<?php if($_M['birthtype']):?> checked="checked"<?php endif?>>
								<label class="custom-control-label" for="birthtype">음력</label>
							</div>
							<div class="invalid-feedback">
								생년월일을 지정해 주세요.
							</div>
						</div><!-- /.form-inline -->

					</div>
				</div>

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">성별</label>
					<div class="col-sm-10 pt-1">
						<div class="custom-control custom-radio  custom-control-inline">
							<input type="radio" id="sex_1" name="sex" class="custom-control-input" value="1"<?php if($_M['sex']==1):?> checked="checked"<?php endif?>>
							<label class="custom-control-label" for="sex_1">남성</label>
						</div>
						<div class="custom-control custom-radio  custom-control-inline">
							<input type="radio" id="sex_2" name="sex" class="custom-control-input" value="2"<?php if($_M['sex']==2):?> checked="checked"<?php endif?>>
							<label class="custom-control-label" for="sex_2">여성</label>
						</div>
						<div class="invalid-feedback">
							성별을 선택해 주세요.
						</div>
					</div>
				</div>

				<hr>
				<div class="form-group">
					<label>간단소개</label>
					<textarea class="form-control" name="bio" rows="2" placeholder="간단소개를 입력해 주세요."><?php echo $_M['bio']?></textarea>
				</div>
				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">홈페이지</label>
					<div class="col-sm-10">
						<input type="text" class="form-control form-control-sm" name="home" value="<?php echo $_M['home']?>" placeholder="URL을 입력하세요.">
						<div class="invalid-feedback">
							홈페이지 주소를 입력해주세요.
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">거주지역</label>
					<div class="col-sm-10">
						<select class="form-control custom-select form-control-sm" name="location">
							<option value="">&nbsp;+ 선택하세요</option>
							<option value="" disabled>------------------</option>
							<?php
							$_tmpvfile = $g['path_module'].$module.'/var/location.txt';
							$_location=file($_tmpvfile);
							?>
							<?php foreach($_location as $_val):?>
							<option value="<?php echo trim($_val)?>"<?php if(trim($_val)==$_M['location']):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_val)?></option>
							<?php endforeach?>
						</select>
						<div class="invalid-feedback">
							거주지역을 선택해 주세요.
						</div>
					</div>
				</div>
				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">직업</label>
					<div class="col-sm-10">
						<select class="form-control custom-select form-control-sm" name="job">
							<option value="">&nbsp;+ 선택하세요</option>
							<option value="" disabled>------------------</option>
							<?php
							$_tmpvfile = $g['path_module'].$module.'/var/job.txt';
							$_job=file($_tmpvfile);
							?>
							<?php foreach($_job as $_val):?>
							<option value="<?php echo trim($_val)?>"<?php if(trim($_val)==$_M['job']):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_val)?></option>
							<?php endforeach?>
						</select>
						<div class="invalid-feedback">
							직업을 선택해 주세요.
						</div>
					</div>
				</div>

				<div class="form-group row no-gutters">
					<label class="col-sm-2 col-form-label">결혼기념일</label>
					<div class="col-sm-10">

						<div class="form-inline">

							<select class="form-control custom-select form-control-sm" name="marr_1">
								<option value="">년도</option>
								<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
								<option value="<?php echo $i?>"<?php if($i==$_M['marr1']):?> selected="selected"<?php endif?>><?php echo $i?></option>
								<?php endfor?>
							</select>
							<select class="form-control custom-select ml-2 form-control-sm" name="marr_2">
								<option value="">월</option>
								<?php for($i = 1; $i < 13; $i++):?>
								<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($_M['marr2'],0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
								<?php endfor?>
							</select>
							<select class="form-control custom-select ml-2 form-control-sm" name="marr_3">
								<option value="">일</option>
								<?php for($i = 1; $i < 32; $i++):?>
								<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($_M['marr2'],2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
								<?php endfor?>
							</select>
							<div class="invalid-feedback">
								결혼기념일을 입력해주세요.
							</div>
						</div><!-- /.form-inline -->
					</div>
				</div>

			</div><!-- /.col -->
		</div><!-- /.row -->
		<hr>
		<div class="row">
			<div class="col">

				<?php $g['memberAddFieldSite'] = $g['path_var'].'site/'.$r.'/member.add_field.txt'; ?>
				<?php $_add = file_exists($g['memberAddFieldSite']) ? file($g['memberAddFieldSite']) : file($g['path_module'].'member/var/add_field.txt');?>
				<?php foreach($_add as $_key):?>
				<?php $_val = explode('|',trim($_key))?>
				<?php if($_val[6]) continue?>
				<?php $_myadd1 = explode($_val[0].'^^^',$_M['addfield'])?>
				<?php $_myadd2 = explode('|||',$_myadd1[1])?>

				<div class="form-group row">
					<label class="col-sm-2 col-form-label"><?php echo $_val[1]?></label>
					<div class="col-sm-10 pt-2">
						<?php if($_val[2]=='text'):?>
						<input type="text" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_myadd2[0]?>" />
						<?php endif?>
						<?php if($_val[2]=='password'):?>
						<input type="password" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_myadd2[0]?>" />
						<?php endif?>
						<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
						<select name="add_<?php echo $_val[0]?>" class="form-control custom-select">
						<option value="">&nbsp;+ 선택하세요</option>
						<?php foreach($_skey as $_sval):?>
						<option value="<?php echo trim($_sval)?>"<?php if(trim($_sval)==$_myadd2[0]):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_sval)?></option>
						<?php endforeach?>
						</select>
						<?php endif?>
						<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
						<div class="shift">
						<?php foreach($_skey as $_sval):?>
						<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>"<?php if(trim($_sval)==$_myadd2[0]):?> checked="checked"<?php endif?> class="custom-control-input">
						  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
						</div>
						<?php endforeach?>
						</div>
						<?php endif?>
						<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
						<div class="shift">
						<?php foreach($_skey as $_sval):?>
						<div class="custom-control custom-checkbox custom-control-inline">
						  <input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>"<?php if(strstr($_myadd2[0],'['.trim($_sval).']')):?> checked="checked"<?php endif?>>
						  <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
						</div>
						<?php endforeach?>
						</div>
						<?php endif?>
						<?php if($_val[2]=='textarea'):?>
						<textarea name="add_<?php echo $_val[0]?>" rows="5" class="form-control"><?php echo $_myadd2[0]?></textarea>
						<?php endif?>
					</div>
				</div><!-- /.form-group -->
				<?php endforeach?>

			</div><!-- /.col -->
		</div><!-- /.row -->


	</form>

	<form name="actionform" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="admin_member_add_check">
		<input type="hidden" name="type" value="">
		<input type="hidden" name="fvalue" value="">
	</form>





<script>


	$(function() {

	});

</script>
