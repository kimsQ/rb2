<?php
$levelnum = getDbData($table['s_mbrlevel'],'gid=1','*');
$levelname= getDbData($table['s_mbrlevel'],'uid='.$_M['level'],'*');
$sosokname= getDbData($table['s_mbrgroup'],'uid='.$_M['mygroup'],'*');
$joinsite = getDbData($table['s_site'],'uid='.$_M['site'],'*');
$M1 = getUidData($table['s_mbrid'],$_M['memberuid']);
$lastlogdate = -getRemainDate($_M['last_log']);

// 연결계정 정보
$my_naver = getDbData($table['s_mbrsns'],"mbruid='".$_M['uid']."' and sns='naver'",'*');
$my_kakao = getDbData($table['s_mbrsns'],"mbruid='".$_M['uid']."' and sns='kakao'",'*');
$my_google = getDbData($table['s_mbrsns'],"mbruid='".$_M['uid']."' and sns='google'",'*');
$my_facebook = getDbData($table['s_mbrsns'],"mbruid='".$_M['uid']."' and sns='facebook'",'*');
$my_instagram = getDbData($table['s_mbrsns'],"mbruid='".$_M['uid']."' and sns='instagram'",'*');

//이메일,휴대폰,배송지 목록 출력 공통쿼리
$sqlque = 'mbruid='.$_M['uid'];
?>


<section class="pt-4 f13">
	<div class="row no-gutters">
		<div class="col-sm-3 col-lg-3 text-center">
			<br><br>
			<p>
				<img alt="avatar" src="<?php echo getAvatarSrc($_M['uid'],'120') ?>" width="120" height="120" class="rounded-circle">
			</p>

			<a class="btn btn-light btn-sm" href="/@<?php echo $_M['id']?>" target="_blank">프로필 페이지</a>
		</div>
		<div class="col-sm-4 col-lg-4">

			<dl class="row no-gutters f13 mb-0">

				<dt class="col-4 text-muted">ㆍ 계정 이메일</dt>
				<dd class="col-8">
					<?php echo $_M['email']?$_M['email']:'<span class="text-muted">미등록</span>'?>
					<?php if ($_M['mailing']): ?>
					<span class="badge badge-pill badge-dark">공지수신</span>
					<?php endif; ?>
				</dd>


			  <dt class="col-4 text-muted">ㆍ 아이디</dt>
			  <dd class="col-8"><?php echo $_M['id']?></dd>

				<dt class="col-4 text-muted">ㆍ 회원그룹</dt>
			  <dd class="col-8">
					<?php echo $sosokname['name']?>
				</dd>


				<dt class="col-4 text-muted">ㆍ 이름</dt>
			  <dd class="col-8">
					<?php echo $_M['name']?>
					<?php if($_M['sex']):?><span class="badge badge-pill badge-dark"><?php echo getSex($_M['sex'])?>성</span><?php endif?>
				</dd>

				<dt class="col-4 text-muted">ㆍ 닉네임</dt>
				<dd class="col-8"><?php echo $_M['nic']?></dd>


				<?php if ($_M['tel']): ?>
				<dt class="col-4 text-muted">ㆍ 전화</dt>
				<dd class="col-8"><?php echo $_M['tel']?$_M['tel']:'<small class="text-muted">미등록</small>'?></dd>
				<?php endif; ?>

				<dt class="col-4 text-muted">ㆍ 가입일</dt>
				<dd class="col-8">
					<?php echo getDateFormat($_M['d_regis'],'Y.m.d H:i')?>
					<span class="badge badge-pill badge-dark"><?php echo sprintf('%d일전',-getRemainDate($_M['d_regis']))?></span>
				</dd>

				<dt class="col-4 text-muted">ㆍ 최근접속</dt>
				<dd class="col-8">
					<?php if($_M['last_log']):?><?php echo getDateFormat($_M['last_log'],'Y.m.d H:i')?>
						<span class="badge badge-pill badge-dark"><?php echo sprintf('%d일전',-getRemainDate($_M['last_log']))?><?php else:?><small>기록없음</small></span>
					<?php endif?>
				</dd>

				<?php if ($_M['home']): ?>
				<dt class="col-4 text-muted">ㆍ 홈페이지</dt>
				<dd class="col-8">
					<a href="<?php echo $_M['home'] ?>" target="_blank" class="muted-link"><?php echo $_M['home'] ?></a>
				</dd>
				<?php endif; ?>

			</dl>
		</div>

		<div class="col-sm-5 col-lg-5">

			<dl class="row f13 mb-0">

				<dt class="col-4 text-muted">ㆍ 계정 휴대폰</dt>
				<dd class="col-8">
					<?php echo $_M['phone']?substr($_M['phone'], 0,3).'-'.substr($_M['phone'], 3,4).'-'.substr($_M['phone'], 7,4):'<small class="text-muted">미등록</small>'?>
					<?php if ($_M['sms']): ?>
					<span class="badge badge-pill badge-dark">공지수신</span>
					<?php endif; ?>
				</dd>

				<dt class="col-4 text-muted">ㆍ 비밀번호</dt>
			  <dd class="col-8">
					<?php echo $_M['last_pw']?'<span class="text-muted">'.getDateFormat($_M['last_pw'],'Y.m.d').' 등록</span>':'<small class="text-muted">미등록</small>'?>
				</dd>

				<?php if($_M['birth1']):?>
			  <dt class="col-4 text-muted">ㆍ 나이/성별</dt>
			  <dd class="col-8">
					<?php echo getAge($_M['birth1'])?>세
					<?php if($_M['birth1']&&$_M['sex']):?> / <?php echo getSex($_M['sex'])?>성<?php endif?>
				</dd>


				<dt class="col-4 text-muted">ㆍ 생년월일</dt>
			  <dd class="col-8">
					<?php echo $_M['birth1']?>/<?php echo substr($_M['birth2'],0,2)?>/
					<?php echo substr($_M['birth2'],2,2)?>
					<?php if($_M['birthtype']):?><span class="badge badge-pill badge-dark">음력</span><?php endif?>
				</dd>
				<?php endif?>

				<dt class="col-4 text-muted">ㆍ 회원등급</dt>
			  <dd class="col-8">
					<?php echo $levelname['name']?> <span class="badge badge-pill badge-dark"><?php echo $_M['level']?> / <?php echo $levelnum['uid']?></span>
				</dd>

				<dt class="col-4 text-muted">ㆍ 가입사이트</dt>
				<dd class="col-8">
					<?php echo $joinsite['name']?>
				</dd>

			</dl>
		</div>

	</div>

	<div class="row no-gutters">

		<div class="offset-sm-3 col">

			<dl class="row">

				<?php if($_M['bio']):?>
				<dt class="col-2 text-muted">ㆍ 간단소개</dt>
				<dd class="col-10">
					<?php echo $_M['bio']?>
				</dd>
				<?php endif?>

				<?php if($_M['marr1']):?>
				<dt class="col-2 text-muted">ㆍ 결혼기념일</dt>
			  <dd class="col-10">
					<?php echo $_M['marr1']?>/<?php echo substr($_M['marr2'],0,2)?>/
					<?php echo substr($_M['marr2'],2,2)?>
				</dd>
				<?php endif?>

				<?php if($_M['location']):?>
				<dt class="col-2 text-muted">ㆍ 거주지역</dt>
				<dd class="col-4">
					<?php echo $_M['location']?>
				</dd>
				<?php endif?>

				<?php if($_M['job']):?>
				<dt class="col-2 text-muted">ㆍ 직업</dt>
				<dd class="col-4">
					<?php echo $_M['job']?>
				</dd>
				<?php endif?>
			</dl>

			<table class="table table-bordered text-center" style="width: 95%">
				<colgroup>
					<col width="33.3%">
					<col width="33.3%">
					<col width="33.3%">
				</colgroup>
				<thead class="small text-muted">
					<th>포인트</th>
					<th>적립금</th>
					<th>예치금</th>
				</thead>
				<tbody class="f16">
					<tr>
						<td>
							<?php echo number_format($_M['point'])?> <span class="badge badge-pill badge-dark">사용 : <?php echo number_format($_M['usepoint'])?></span>
						</td>
						<td>
							<?php echo number_format($_M['cash'])?>
						</td>
						<td>
							<?php echo number_format($_M['money'])?>
						</td>
					</tr>
				</tbody>

			</table>

			<dl class="row">
				<?php $g['memberAddFieldSite'] = $g['path_var'].'site/'.$r.'/member.add_field.txt'; ?>
				<?php $_add = file_exists($g['memberAddFieldSite']) ? file($g['memberAddFieldSite']) : file($g['path_module'].'member/var/add_field.txt');?>
				<?php foreach($_add as $_key):?>
				<?php $_val = explode('|',trim($_key))?>
				<?php if($_val[6]) continue?>
				<?php $_myadd1 = explode($_val[0].'^^^',$_M['addfield'])?>
				<?php $_myadd2 = explode('|||',$_myadd1[1])?>
				<dt class="col-2 text-muted">ㆍ <?php echo $_val[1]?></dt>
				<dd class="col-10">
					<?php echo $_myadd2[0] ?>
				</dd>
				<?php endforeach?>

			</dl>

			<dl class="row mb-3">
				<dt class="col-2 text-muted pt-3">ㆍ 연결계정</dt>
				<dd class="col-10">
					<ul class="list-group" style="width:95%">
						<?php if ($my_naver['uid']): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<img class="rounded-circle mr-2 align-top" src="/_core/images/sns/naver.png" alt="네이버" width="20">
								네이버
							</div>
							<span class="badge badge-pill badge-dark">
								<?php echo getDateFormat($my_naver['d_regis'],'Y.m.d H:i') ?> 연결
							</span>
						</li>
						<?php endif?>
						<?php if ($my_kakao['uid']): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<img class="rounded-circle mr-2 align-top" src="/_core/images/sns/kakao.png" alt="카카오" width="20">
								카카오
							</div>
							<span class="badge badge-pill badge-dark">
								<?php echo getDateFormat($my_kakao['d_regis'],'Y.m.d H:i') ?> 연결
							</span>
						</li>
						<?php endif?>
						<?php if ($my_google['uid']): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<img class="rounded-circle mr-2 align-top" src="/_core/images/sns/google.png" alt="구글" width="20">
								구글
							</div>
							<span class="badge badge-pill badge-dark">
								<?php echo getDateFormat($my_google['d_regis'],'Y.m.d H:i') ?> 연결
							</span>
						</li>
						<?php endif?>
						<?php if ($my_facebook['uid']): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<img class="rounded-circle mr-2 align-top" src="/_core/images/sns/facebook.png" alt="페이스북" width="20">
								페이스북
							</div>
							<span class="badge badge-pill badge-dark">
								<?php echo getDateFormat($my_facebook['d_regis'],'Y.m.d H:i') ?> 연결
							</span>
						</li>
						<?php endif?>
						<?php if ($my_instagram['uid']): ?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<img class="rounded-circle mr-2 align-top" src="/_core/images/sns/instagram.png" alt="인스타그램" width="20">
								인스타그램
							</div>
							<span class="badge badge-pill badge-dark">
								<?php echo getDateFormat($my_instagram['d_regis'],'Y.m.d H:i') ?> 연결
							</span>
						</li>
						<?php endif?>
						<?php if (!$my_naver['uid'] && !$my_kakao['uid'] && !$my_google['uid'] && !$my_facebook['uid'] && !$my_instagram['uid'] ): ?>
						<li class="list-group-item d-flex align-items-center justify-content-center">
							<small class="text-muted">연결된 외부계정이 없습니다.</small>
						</li>
						<?php endif; ?>
					</ul>
				</dd>
			</dl>

			<dl class="row mb-3">
				<dt class="col-2 text-muted pt-3">ㆍ 이메일 목록</dt>
				<dd class="col-10">
					<?php
					$ECD = getDbArray($table['s_mbremail'],$sqlque,'*','uid','asc',0,1);
					$NUM_MAIL = getDbRows($table['s_mbremail'],$sqlque);
					?>

					<ul class="list-group" style="width:95%">
						<?php while($E=db_fetch_array($ECD)):?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<i class="fa fa-envelope-o fa-fw text-muted" aria-hidden="true"></i>
								<strong><?php echo $E['email'] ?></strong>
							</div>
							<div class="">
								<?php if ($E['base']): ?><span class="badge badge-pill badge-primary">기본</span><?php endif; ?>
								<?php if ($_M['email_profile']==$E['email']): ?><span class="badge badge-pill badge-dark">프로필 공개</span><?php endif; ?>
								<?php if ($_M['email_noti']==$E['email']): ?><span class="badge badge-pill badge-dark">알림수신</span><?php endif; ?>
								<?php if (!$E['d_verified']): ?><span class="badge badge-pill badge-dark">미인증</span><?php endif; ?>
							</div>
						</li>
						<?php endwhile?>
						<?php if (!$NUM_MAIL): ?>
						<li class="list-group-item d-flex align-items-center justify-content-center">
							<small class="text-muted">등록된 이메일이 없습니다.</small>
						</li>
						<?php endif; ?>
					</ul>
				</dd>
			</dl>

			<dl class="row mb-3">
				<dt class="col-2 text-muted pt-3">ㆍ 휴대폰 목록</dt>
				<dd class="col-10">
					<?php
					$PCD = getDbArray($table['s_mbrphone'],$sqlque,'*','uid','asc',0,1);
					$NUM_PHONE = getDbRows($table['s_mbrphone'],$sqlque);
					?>
					<ul class="list-group" style="width:95%">
						<?php while($P=db_fetch_array($PCD)):?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="">
								<i class="fa fa-mobile fa-lg fa-fw text-muted" aria-hidden="true"></i>
								<strong><?php echo substr($P['phone'], 0,3).'-'.substr($P['phone'], 3,4).'-'.substr($P['phone'], 7,4) ?></strong>
							</div>
							<div class="">
								<?php if ($P['base']): ?><span class="badge badge-pill badge-primary">기본</span><?php endif; ?>
								<?php if (!$P['d_verified']): ?><span class="badge badge-pill badge-dark">미인증</span><?php endif; ?>
							</div>
            </li>
						<?php endwhile?>
						<?php if (!$NUM_PHONE): ?>
						<li class="list-group-item d-flex align-items-center justify-content-center">
							<small class="text-muted">등록된 휴대폰이 없습니다.</small>
						</li>
						<?php endif; ?>
					</ul>

				</dd>
			</dl>

			<dl class="row">
				<dt class="col-2 text-muted pt-3">ㆍ 배송지 목록</dt>
				<dd class="col-10">
					<?php
					$SCD = getDbArray($table['s_mbrshipping'],$sqlque,'*','uid','asc',0,1);
					$NUM_SHIPPING = getDbRows($table['s_mbrshipping'],$sqlque);
					?>
					<ul class="list-group" style="width:95%">
						<?php while($S=db_fetch_array($SCD)):?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div class="media">
								<span class="text-center align-self-center mr-3">
									<i class="fa fa-truck text-muted fa-lg" aria-hidden="true"></i><br>
									<span class="badge badge-pill badge-dark mt-2"><?php echo $S['label'] ?></span>
								</span>

							  <div class="media-body small text-muted">

							    <span class="mr-2"><?php echo $S['zip'] ?></span>
									<?php echo $S['addr1'] ?><br><?php echo $S['addr2'] ?>
									( <?php echo $S['name'] ?> / <?php echo $S['tel1'] ?> <?php echo $S['tel2']?' / '.$S['tel2']:'' ?> )
							  </div>
							</div>
							<div class="">
								<?php if ($S['base']): ?><span class="badge badge-pill badge-primary">기본</span><?php endif; ?>
							</div>
						</li>
						<?php endwhile?>

						<?php if (!$NUM_SHIPPING): ?>
						<li class="list-group-item d-flex align-items-center justify-content-center">
							<small class="text-muted">등록된 배송지가 없습니다.</small>
						</li>
						<?php endif; ?>
					</ul>
				</dd>
			</dl>

		</div>
	</div>

</section>
