<div class="page center" id="page-main">
  <header class="bar bar-nav bar-dark bg-primary px-0">
    <a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
    <h1 class="title" data-location="reload">
      <i class="fa fa-user fa-fw mr-1 text-muted" aria-hidden="true"></i> 회원계정 관리
    </h1>
  </header>
  <main class="content bg-faded">
    <ul class="table-view bg-white m-t-0 animated fadeIn delay-1">
      <li class="table-view-cell">
        <a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-pw">
          <?php if ($my['last_pw']): ?>
          <span class="badge badge-default badge-inverted"><?php echo -getRemainDate($my['last_pw'])?>일전 변경</span>
          <?php endif; ?>
          <i class="fa fa-key fa-fw mr-1 text-muted" aria-hidden="true"></i> 비밀번호 <?php echo $my['last_pw']?'변경':'등록' ?>
        </a>
      </li>
      <li class="table-view-cell">
        <a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-id">
          <span class="badge badge-default badge-inverted"><?php echo $my['id'] ?></span>
          <i class="fa fa-id-badge fa-fw mr-1 text-muted" aria-hidden="true"></i> 아이디 변경
        </a>
      </li>
      <li class="table-view-cell">
        <a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-leave">
          <i class="fa fa-ban fa-fw mr-1 text-muted" aria-hidden="true"></i> 탈퇴
        </a>
      </li>
    </ul>
  </main>
</div><!-- /.page -->

<!-- Target Page : 비밀번호 변경 -->
<div id="page-pw" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title"><i class="fa fa-key fa-fw text-muted" aria-hidden="true"></i> 비밀번호 <?php echo $my['only_sns']?'등록':'변경' ?></h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-primary btn-block">변경하기</button>
	</div>
	<div class="content bg-faded">

		<form name="procForm" class="content-padded" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $m?>">
				<input type="hidden" name="front" value="<?php echo $front?>">
				<input type="hidden" name="a" value="pw_update">

				<div class="form-group">
					<label>새 비밀번호</label>
					<input type="password" class="form-control" name="pw1" id="pw1" placeholder="8자이상 영문과 숫자만 사용할 수 있습니다.">
					<small class="form-text text-muted"></small>
				</div>

				<div class="form-group">
					<label>새 비밀번호 확인</label>
					<input type="password" class="form-control" name="pw2" id="pw2" placeholder="변경할 비밀번호를 한번 더 입력하세요">
					<small class="form-text text-muted"></small>
				</div>
		 </form>

		 <div class="content-padded">
			<?php if ($my['only_sns']): ?>
				<p class="text-muted">비밀번호를 등록하면 비밀번호를 통한 로그인이 가능합니다.</p>
			<?php else: ?>
			<p class="text-muted">현재 비밀번호는 <code><?php echo getDateFormat($my['last_pw'],'Y.m.d')?></code> 에 변경(등록)되었으며 <code>
			<?php echo -getRemainDate($my['last_pw'])?>일</code>이 경과되었습니다.
			비밀번호는 가급적 주기적으로 변경해 주세요.</p>
			<?php endif; ?>
 		</div>

	</div>
</div><!-- /.page -->

<div class="page right" id="page-id">
  <header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title"><i class="fa fa-id-badge fa-fw text-muted" aria-hidden="true"></i> 아이디 변경</h1>
	</header>
	<div class="content">
		<div class="content-padded">



		</div>
	</div>
</div><!-- /.page -->

<!-- Target Page : 회원탈퇴 -->
<div id="page-leave" class="page right">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title"><i class="fa fa-ban fa-fw text-muted" aria-hidden="true"></i>  회원탈퇴</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button type="button" class="btn btn-outline-danger btn-block">탈퇴</button>
	</div>
	<div class="content">
		<div class="content-padded">

			회원님은 <span class="badge badge-default badge-inverted"><?php echo -getRemainDate($my['d_regis'])?>일전 가입</span>에 가입

		</div>
	</div>
</div><!-- /.page -->
