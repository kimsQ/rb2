<?php
$NT_DATA = explode('|',$my['noticeconf']);
$nt_web = $NT_DATA[0];
$_add = file($g['path_var'].'site/'.$_HS['id'].'/member.add_field.txt');
$my_shipping_num = getDbRows($table['s_mbrshipping'],'mbruid='.$my['uid']);
?>

<!-- Start Page -->
<div id="page-main" class="page center">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-home pull-left p-x-1" role="button" data-href="<?php  echo RW(0) ?>"></a>
		<h1 class="title" data-location="reload">설정</h1>
	</header>
	<main class="content bg-faded">

		<ul class="table-view bg-white m-t-0 animated fadeIn delay-1">
			<li class="table-view-cell">
		    <a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-profile">

					<?php if($d['member']['form_settings_avatar']):?>
					<img class="media-object pull-left img-circle bg-faded" data-role="avatar" src="<?php echo getAvatarSrc($my['uid'],'100') ?>" width="49">
					<?php endif; ?>

		      <div class="media-body">

						<?php if (!$my['nic']): ?>
						<span data-role="name"><?php echo $my['name'] ?></span>
						<?php else: ?>
						<span data-role="nic"><?php echo $my['nic'] ?></span>
						<?php endif; ?>
						<?php if ($my['admin']): ?><span class="badge badge-danger badge-outline">ADMIN</span><?php endif; ?>
		        <p> <?php echo $d['member']['form_settings_nic']?'닉네임과 ':'' ?>사진을 변경해 보세요.</p>
		      </div>
		    </a>
		  </li>
			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=account">
					<span class="badge badge-default badge-inverted"><?php echo $my['id'] ?></span>
					<i class="fa fa-user fa-fw text-muted mr-1" aria-hidden="true"></i> 회원계정
				</a>
			</li>
			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=email">
					<span class="badge badge-default badge-inverted"><?php echo $my['email']?$my['email']:'미등록' ?></span>
					<i class="fa fa-envelope fa-fw mr-1 text-muted" aria-hidden="true"></i> 이메일
				</a>
			</li>
			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=phone">
					<span class="badge badge-default badge-inverted"><?php echo $my['phone']?$my['phone']:'미등록' ?></span>
					<i class="fa fa-mobile fa-lg fa-fw text-muted" aria-hidden="true"></i> 휴대폰
				</a>
			</li>
			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=noti">
					<?php if ($nt_web==''): ?>
					<span class="badge badge-primary badge-pill">ON</span>
					<?php else: ?>
					<span class="badge badge-default badge-outline">OFF</span>
					<?php endif; ?>
					<i class="fa fa-bell fa-fw mr-1 text-muted" aria-hidden="true"></i> 알림설정
				</a>
			</li>
			<!-- 소셜미디어 연결 -->
			<?php if ($d['member']['login_social']): ?>
			<?php $isSNSlogin = getDbData($table['s_mbrsns'],'memberuid='.$my['uid'],'*'); ?>
			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=connect">
					<span class="badge badge-inverted">
						<?php if ($my_naver['uid']): ?><img class="rounded-circle" src="/_core/images/sns/naver.png" alt="네이버" width="22"><?php endif; ?>
						<?php if ($my_kakao['uid']): ?><img class="rounded-circle" src="/_core/images/sns/kakao.png" alt="카카오" width="22"><?php endif; ?>
						<?php if ($my_google['uid']): ?><img class="rounded-circle" src="/_core/images/sns/google.png" alt="구글" width="22"><?php endif; ?>
						<?php if ($my_facebook['uid']): ?><img class="rounded-circle" src="/_core/images/sns/facebook.png" alt="페이스북" width="22"><?php endif; ?>
						<?php if ($my_instagram['uid']): ?><img class="rounded-circle" src="/_core/images/sns/instagram.png" alt="인스타그램" width="22"><?php endif; ?>
					</span>
					<i class="fa fa-user-plus fa-fw mr-1 text-muted" aria-hidden="true"></i> 연결계정
				</a>
			</li>
			<?php endif; ?>
			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=shipping">
					<span class="badge badge-default badge-inverted">
						<?php echo $my_shipping_num?number_format($my_shipping_num).' 곳':'미등록'?>
					</span>
					<i class="fa fa-truck fa-fw text-muted mr-1" aria-hidden="true"></i> 배송지 관리
				</a>
			</li>

			<li class="table-view-cell">
				<a class="navigate-right" data-href="<?php echo$g['url_reset']?>&page=point">
					<span class="badge badge-default badge-inverted"><?php echo number_format($my['point'])?> P</span>
					<i class="fa fa-product-hunt mr-1 fa-fw text-muted" aria-hidden="true"></i> 포인트 내역
				</a>
			</li>

			<li class="table-view-cell">
				<a class="navigate-right" href="#popup-logout" data-toggle="popup">
					<i class="fa fa-sign-out fa-fw mr-1 text-muted" aria-hidden="true"></i> 로그아웃
				</a>
			</li>
			<li class="table-view-divider">
				<i class="fa fa-address-card-o fa-fw mr-1" aria-hidden="true"></i> 개인정보
			</li>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-name">
					<span class="badge badge-default badge-inverted" data-role="name"><?php echo $my['name'] ?></span>
					이름
				</a>
			</li>

			<?php if($d['member']['form_settings_tel1']):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-tel1">
					<?php if ($my['tel1']): ?>
					<span class="badge badge-default badge-inverted" data-role="tel1"><?php echo $my['tel1'] ?></span>
					<?php else: ?>
					<span class="badge badge-default badge-inverted" data-role="tel1">미등록</span>
					<?php endif; ?>
					유선전화
				</a>
			</li>
			<?php endif?>

			<?php if($d['member']['form_settings_birth']):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-birth">
					<?php if ($my['birth1']): ?>
					<span class="badge badge-default badge-inverted" data-role="birth"><?php echo $my['birth1'] ?>.<?php echo substr($my['birth2'],0,2) ?>.<?php echo substr($my['birth2'],2,4) ?></span>
					<?php else: ?>
					<span class="badge badge-default badge-inverted" data-role="birth">미등록</span>
					<?php endif; ?>
					생년월일
				</a>
			</li>
			<?php endif?>

			<?php if($d['member']['form_settings_sex']):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-sex">
					<?php if ($my['sex']): ?>
					<span class="badge badge-default badge-inverted" data-role="sex"><?php echo $my['sex']==1?'남성':'여성' ?></span>
					<?php else: ?>
					<span class="badge badge-default badge-inverted" data-role="sex">미등록</span>
					<?php endif; ?>
					성별
				</a>
			</li>
			<?php endif?>

			<?php if($d['member']['form_settings_bio']):?>
			<li class="table-view-cell">
		    <a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-bio">
		      <div class="media-body">
		        간단소개
		        <p data-role="bio"><?php echo $my['bio']?></p>
		      </div>
					<?php if (!$my['bio']): ?>
					<span class="badge badge-default badge-inverted" data-role="_bio">미등록</span>
					<?php endif; ?>
		    </a>
		  </li>
			<?php endif?>

			<?php if($d['member']['form_settings_home']):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-home">
					<?php if ($my['home']): ?>
					<span class="badge badge-default badge-inverted" data-role="home"><?php echo $my['home'] ?></span>
					<?php else: ?>
					<span class="badge badge-default badge-inverted" data-role="home">미등록</span>
					<?php endif; ?>
					홈페이지
				</a>
			</li>
			<?php endif?>

			<?php if($d['member']['form_settings_job']):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-job">
					<?php if ($my['job']): ?>
					<span class="badge badge-default badge-inverted" data-role="job"><?php echo $my['job'] ?></span>
					<?php else: ?>
					<span class="badge badge-default badge-inverted" data-role="job">미등록</span>
					<?php endif; ?>
					직업
				</a>
			</li>
			<?php endif?>

			<?php if($d['member']['form_settings_marr']):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-marr">
					<?php if ($my['marr1']): ?>
					<span class="badge badge-default badge-inverted" data-role="marr"><?php echo $my['marr1'] ?>.<?php echo substr($my['marr2'],0,2) ?>.<?php echo substr($my['marr2'],2,4) ?></span>
					<?php else: ?>
					<span class="badge badge-default badge-inverted" data-role="marr">미등록</span>
					<?php endif; ?>
					결혼기념일
				</a>
			</li>
			<?php endif?>

			<?php if($_add):?>
			<li class="table-view-cell">
				<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-addfield">
					추가정보
				</a>
			</li>
			<?php endif?>
		</ul>


		<form id="memberForm" role="form" action="<?php echo $g['s']?>/" method="post" hidden>
		  <input type="hidden" name="r" value="<?php echo $r?>">
		  <input type="hidden" name="m" value="<?php echo $m?>">
		  <input type="hidden" name="front" value="<?php echo $front?>">
		  <input type="hidden" name="a" value="info_update">
		  <input type="hidden" name="act" value="info">
			<input type="hidden" name="send_mod" value="ajax">
		  <input type="hidden" name="check_nic" value="<?php echo $my['nic']?1:0?>">
			<input type="hidden" name="check_email" value="<?php echo $my['email']?1:0?>">
			<input type="hidden" name="name" value="<?php echo $my['name']?>">
			<input type="hidden" name="nic" value="<?php echo $my['nic']?>">
			<input type="hidden" name="email" value="<?php echo $my['email']?>">

			<?php $tel1=explode('-',$my['tel1'])?>
			<input type="hidden" name="tel1_1" value="<?php echo $tel1[0]?>">
			<input type="hidden" name="tel1_2" value="<?php echo $tel1[1]?>">
			<input type="hidden" name="tel1_3" value="<?php echo $tel1[2]?>">

			<?php $tel2=explode('-',$my['tel2'])?>
			<input type="hidden" name="tel2_1" value="<?php echo $tel2[0]?>">
			<input type="hidden" name="tel2_2" value="<?php echo $tel2[1]?>">
			<input type="hidden" name="tel2_3" value="<?php echo $tel2[2]?>">

			<?php $birth_2=substr($my['birth2'],0,2)?>
			<?php $birth_3=substr($my['birth2'],2,2)?>
			<input type="hidden" name="birth_1" value="<?php echo $my['birth1']?>">
			<input type="hidden" name="birth_2" value="<?php echo $birth_2?>">
			<input type="hidden" name="birth_3" value="<?php echo $birth_3?>">
			<input type="hidden" name="birthtype" value="<?php echo $my['birthtype']?>">

			<input type="hidden" name="remail" value="<?php echo $my['mailing']?>">
			<input type="hidden" name="sms" value="<?php echo $my['sms']?>">

			<input type="hidden" name="sex" value="<?php echo $my['sex']?>">

			<input type="hidden" name="zip" value="<?php echo $my['zip']?>">
			<input type="hidden" name="addr1" value="<?php echo $my['addr1']?>">
			<input type="hidden" name="addr2" value="<?php echo $my['addr2']?>">

			<input type="hidden" name="bio" value="<?php echo $my['bio']?>">
			<input type="hidden" name="home" value="<?php echo $my['home']?>">
			<input type="hidden" name="job" value="<?php echo $my['job']?>">

			<input type="hidden" name="marr_1" value="<?php echo $my['marr1']?>">
			<input type="hidden" name="marr_2" value="<?php echo substr($my['marr2'],0,2)?>">
			<input type="hidden" name="marr_3" value="<?php echo substr($my['marr2'],2,4)?>">

			<?php foreach($_add as $_key):?>
			<?php $_val = explode('|',trim($_key))?>
			<?php if($_val[6]) continue?>
			<?php $_myadd1 = explode($_val[0].'^^^',$my['addfield'])?>
			<?php $_myadd2 = explode('|||',$_myadd1[1])?>

			<?php if ($_val[2]=='checkbox'): ?>
			<input type="hidden" name="add_<?php echo $_val[0]?>[]" value="<?php echo $_myadd2[0]?>">
			<?php else: ?>
			<input type="hidden" name="add_<?php echo $_val[0]?>" value="<?php echo $_myadd2[0]?>">
			<?php endif; ?>
			<?php endforeach?>

		</form>

	</main>
</div>

<!-- Target Page : 프로필 설정 -->
<div id="page-profile" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">프로필 설정</h1>
	</header>

	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">저장하기</button>
	</div>
	<div class="content bg-faded">
		<div class="content-padded">
			<div class="input-group input-group-lg">
			  <span class="input-group-addon">닉네임</span>
			  <input type="text" class="form-control" name="nic" value="<?php echo $my['nic']?>"  maxlength="20" required  autocomplete="off">
			</div>

			<div class="form-control-feedback" id="hLayernic"></div>
			<div class="invalid-feedback">
				닉네임을 입력해 주세요.
			</div>
			<small class="form-text text-muted">
				사용하고 싶은 닉네임을 입력해 주세요 (8자이내 중복불가)
			</small>

			<?php if($d['member']['form_settings_avatar']):?>
			<div class="avatar-wrapper p-t-2<?php echo  $my['photo']?' active':'' ?>" data-role="avatar-wrapper">

				<div class="avatar-blank">
					<span>
						<img class="img-circle js-avatar-img m-x-auto" src="<?php echo $g['s']?>/_var/avatar/0.svg" alt="" width="160">
						<span class="fa-stack fa-lg js-avatar-img">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-camera fa-stack-1x fa-inverse"></i>
						</span>
					</span>
					<p class="m-t-1 text-muted">아바타를 등록해 보세요.</p>
				</div><!-- /.avatar-blank -->

				<div class="avatar-photo">
					<span class="avatar-photo">
						<img class="img-circle m-x-auto" data-role="avatar" src="<?php echo getAvatarSrc($my['uid'],'320') ?>" alt="<?php echo $my[$_HS['nametype']]?>" width="160">
					</span>
					<div class="m-t-1">
						<a class="btn btn-secondary" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=member_photo_delete" onclick="return hrefCheck(this,true,'정말로 삭제 하시겠습니까?');">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
							현재 사진삭제
						</a>

						<div class="btn-group btn-group-lg m-t-2" role="group" hidden>
						  <button type="button" class="btn btn-secondary"><i class="fa fa-undo" aria-hidden="true"></i> 반시계방향</button>
						  <button type="button" class="btn btn-secondary"><i class="fa fa-repeat" aria-hidden="true"></i> 시계방향</button>
						</div>
					</div>
				</div><!-- /.avatar-photo -->

			</div><!-- /.avatar-wrapper -->

			<form name="MbrPhotoForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $m?>">
				<input type="hidden" name="a" value="member_photo">
				<input type="file" name="upfile" class="hidden" id="rb-upfile-avatar" accept="image/jpg">
			</form>
			<?php endif?>

		</div>
	</div>
</div>

<!-- Target Page : 이름 설정 -->
<div id="page-name" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">이름 설정</h1>
	</header>

	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<input type="text" class="form-control form-control-lg" name="name" value="<?php echo $my['name']?>"  maxlength="20" required  autocomplete="off">
			<div class="form-control-feedback"></div>
			<div class="invalid-feedback">
				이름 입력해 주세요.
			</div>
			<small class="form-text text-muted">
				사용하고 싶은 이름 입력해 주세요 (8자이내 중복불가)
			</small>


		</div>
	</div>
</div>

<?php if($d['member']['form_settings_tel1']):?>
<!-- Target Page : 전화번호 설정 -->
<div id="page-tel1" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">유선전화 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<div class="form-group">
				<label>전화번호 <?php if($d['member']['form_settings_tel1_required']):?><span class="text-danger">*</span><?php endif?></label>
				<?php $tel1=explode('-',$my['tel1'])?>
				<div class="form-row">
				  <div class="col-xs-4">
				    <input type="text" name="tel1_1" value="<?php echo $tel1[0]?>" maxlength="4" size="4" class="form-control form-control-lg" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
				  </div>
				  <div class="col-xs-4">
				    <input type="text" name="tel1_2" value="<?php echo $tel1[1]?>" maxlength="4" size="4"  class="form-control form-control-lg" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
				  </div>
				  <div class="col-xs-4">
				    <input type="text" name="tel1_3" value="<?php echo $tel1[2]?>" maxlength="4" size="4" class="form-control form-control-lg" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
				  </div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php endif?>

<?php if($d['member']['form_settings_birth']):?>
<!-- Target Page : 생년월일 설정 -->
<div id="page-birth" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">생년월일 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<div class="form-group">
				<label>생년월일 <?php if($d['member']['form_settings_birth_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<div class="form-row m-b-1">
					<div class="col-xs-4">
						<select class="form-control custom-select" name="birth_1">
		      		<option value="">년도</option>
		      		<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
		      		<option value="<?php echo $i?>"<?php if($my['birth1']==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
		      		<?php endfor?>
		    		</select>
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<select class="form-control custom-select" name="birth_2">
		      		<option value="">월</option>
		      		<?php $birth_2=substr($my['birth2'],0,2)?>
		      		<?php for($i = 1; $i < 13; $i++):?>
		      		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_2==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
		      		<?php endfor?>
		    		</select>
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<select class="form-control custom-select" name="birth_3">
		      		<option value="">일</option>
		      		<?php $birth_3=substr($my['birth2'],2,2)?>
		      		<?php for($i = 1; $i < 32; $i++):?>
		      		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_3==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
		      		<?php endfor?>
		    		</select>
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
				</div>
				<label class="custom-control custom-checkbox m-t-3">
					<input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1"<?php if($my['birthtype']):?> checked="checked"<?php endif?>>
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">음력</span>
				</label>
			</div>

		</div>
	</div>
</div>
<?php endif?>

<?php if($d['member']['form_settings_sex']):?>
<!-- Target Page : 성별 설정 -->
<div id="page-sex" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">성별 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">


			<div class="form-group">
				<label>성별 <?php if($d['member']['form_settings_sex_required']):?><span class="text-danger">*</span><?php endif?></label>
				<div class="form-group">
					<label class="custom-control custom-radio">
						<input type="radio" class="custom-control-input" name="sex" class="custom-control-input" value="1"<?php if($my['sex']==1):?> checked="checked"<?php endif?>>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">남성</span>
					</label>
					<label class="custom-control custom-radio">
						<input type="radio" class="custom-control-input" name="sex" class="custom-control-input" value="2"<?php if($my['sex']==2):?> checked="checked"<?php endif?>>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">여성</span>
					</label>
				</div>
			</div>


		</div>
	</div>
</div>
<?php endif?>

<?php if($d['member']['form_settings_bio']):?>
<!-- Target Page : 간단소개 설정 -->
<div id="page-bio" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">간단소개 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<div class="form-group">
		    <label>간단소개 <?php if($d['member']['form_settings_bio_required']):?> <span class="text-danger">*</span><?php endif?></label>
		    <textarea class="form-control" name="bio" rows="5" placeholder="간략한 소개글을 입력해주세요."><?php echo $my['bio']?></textarea>
				<div class="invalid-feedback">
					간단소개를 입력해 주세요.
				</div>
		  </div>

		</div>
	</div>
</div>
<?php endif?>

<?php if($d['member']['form_settings_home']):?>
<!-- Target Page : 홈페이지 설정 -->
<div id="page-home" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">홈페이지 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<div class="form-group">
		    <label>홈페이지<?php if($d['member']['form_settings_home_required']):?> <span class="text-danger">*</span><?php endif?></label>
		    <input type="url" class="form-control form-control-lg" name="home" value="<?php echo $my['home']?>" placeholder="URL을 입력하세요." autocomplete="off">
				<div class="invalid-feedback">
					홈페이지 주소를 입력해주세요.
				</div>
		  </div>


		</div>
	</div>
</div>
<?php endif?>

<?php if($d['member']['form_settings_job']):?>
<!-- Target Page : 직업 설정 -->
<div id="page-job" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">직업 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<div class="form-group">
		    <label>직업<?php if($d['member']['form_settings_job_required']):?> <span class="text-danger">*</span><?php endif?></label>
		    <select class="form-control custom-select" name="job">
					<option value="">&nbsp;+ 선택하세요</option>
	    		<option value="" disabled>------------------</option>
	        <?php
	        $g['memberJobVarForSite'] = $g['path_var'].'site/'.$r.'/member.job.txt';
	      	$_tmpvfile = file_exists($g['memberJobVarForSite']) ? $g['memberJobVarForSite'] : $g['path_module'].$module.'/var/member.job.txt';
	        $_job=file($_tmpvfile);
	        ?>
	    		<?php foreach($_job as $_val):?>
	    		<option value="<?php echo trim($_val)?>"<?php if(trim($_val)==$my['job']):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_val)?></option>
	    		<?php endforeach?>
		    </select>
				<div class="invalid-feedback">
					직업을 선택해 주세요.
				</div>
		  </div>


		</div>
	</div>
</div>
<?php endif?>

<?php if($d['member']['form_settings_marr']):?>
<!-- Target Page : 결혼기념일 설정 -->
<div id="page-marr" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">결혼기념일 설정</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<div class="form-group">
				<label>결혼기념일 <?php if($d['member']['form_settings_marr_required']):?> <span class="text-danger">*</span><?php endif?></label>
				<?php $tel2=explode('-',$my['tel2'])?>
				<div class="form-row m-b-1">
					<div class="col-xs-4">
						<select class="form-control custom-select" name="marr_1">
							<option value="">년도</option>
		      		<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
		      		<option value="<?php echo $i?>"<?php if($i==$my['marr1']):?> selected="selected"<?php endif?>><?php echo $i?></option>
		      		<?php endfor?>
		    		</select>
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<select class="form-control custom-select" name="marr_2">
							<option value="">월</option>
		      		<?php for($i = 1; $i < 13; $i++):?>
		      		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($my['marr2'],0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
		      		<?php endfor?>
		    		</select>
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<select class="form-control custom-select" name="marr_3">
							<option value="">일</option>
		      		<?php for($i = 1; $i < 32; $i++):?>
		      		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($my['marr2'],2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
		      		<?php endfor?>
		    		</select>
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
<?php endif?>

<!-- Target Page : 추가 가입항목 -->
<div id="page-addfield" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title">추가정보</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block js-save">변경하기</button>
	</div>
	<div class="content">
		<div class="content-padded">

			<?php $_add = file($g['path_var'].'site/'.$_HS['id'].'/member.add_field.txt')?>
			<?php foreach($_add as $_key):?>
			<?php $_val = explode('|',trim($_key))?>
			<?php if($_val[6]) continue?>
			<?php $_myadd1 = explode($_val[0].'^^^',$my['addfield'])?>
			<?php $_myadd2 = explode('|||',$_myadd1[1])?>

			<div class="form-group">
		    <label><?php echo $_val[1]?><?php if($_val[5]):?> <span class="text-danger">*</span><?php endif?></label>
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
				<div class="custom-controls-stacked">
				<?php foreach($_skey as $_sval):?>
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"  name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>"<?php if(trim($_sval)==$_myadd2[0]):?> checked="checked"<?php endif?> class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<label class="custom-control-description" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
				</div>
				<?php endforeach?>
				</div>
				<?php endif?>
				<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
				<div class="custom-controls-stacked">
				<?php foreach($_skey as $_sval):?>
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"  name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>"<?php if(strstr($_myadd2[0],'['.trim($_sval).']')):?> checked="checked"<?php endif?> >
					<span class="custom-control-indicator"></span>
					<label class="custom-control-description" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
				</div>

				<?php endforeach?>
				</div>
				<?php endif?>
				<?php if($_val[2]=='textarea'):?>
				<textarea name="add_<?php echo $_val[0]?>" rows="5" class="form-control"><?php echo $_myadd2[0]?></textarea>
				<?php endif?>
		  </div>

			<?php endforeach?>

		</div>
	</div>
</div>

<?php if ($_add): ?>
<script>

//추가정보 전용
var f = document.getElementById("memberForm");
var page_main = $('#page-main')
var page_addfield = $('#page-addfield')

page_addfield.find('.js-save').tap(function() {

	<?php foreach($_add as $_key):?>

	<?php $_val = explode('|',trim($_key))?>
	<?php if($_val[6]) continue?>
	<?php $_myadd1 = explode($_val[0].'^^^',$my['addfield'])?>
	<?php $_myadd2 = explode('|||',$_myadd1[1])?>

	<?php if ($_val[2]=='radio'): ?>
	var add_<?php echo $_val[0]?> = page_addfield.find('[name="add_<?php echo $_val[0]?>"]:checked').val()
	page_main.find('[name="add_<?php echo $_val[0]?>"]').val(add_<?php echo $_val[0]?>);

	<?php elseif ($_val[2]=='checkbox'): ?>
	var add_checkbox = page_main.find('[name="add_<?php echo $_val[0]?>[]"]')
	add_checkbox.val('');

	page_addfield.find('[name="add_<?php echo $_val[0]?>[]"]:checked').each(function() {
		var item = $(this).val();
		var item2 = add_checkbox.val();
		add_checkbox.val(item2+'['+item+']');
	});

	<?php else: ?>
	var add_<?php echo $_val[0]?> = page_addfield.find('[name="add_<?php echo $_val[0]?>"]').val()
	page_main.find('[name="add_<?php echo $_val[0]?>"]').val(add_<?php echo $_val[0]?>);
	<?php endif; ?>

	<?php endforeach?>

	setTimeout(function() {
		$('#page-addfield').find('.content').loader({
			text:       "변경중...",
			position:   "overlay"
		});
	}, 300); //가상 키보드가 내려오는 시간동안 대기

	setTimeout(function() {
		$('#page-addfield').find('.content').loader("hide");
		window.history.back();  // 메인 페이지로 복귀
		setTimeout(function() {
			getIframeForAction(f);
	    f.submit();
		}, 500); //페이지 전환효과 소요시간동안 대기
	}, 700);
});

</script>
<?php endif; ?>
