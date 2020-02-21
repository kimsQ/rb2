
<div id="modal-settings-profile" class="modal">

  <form id="memberForm" role="form" action="<?php echo $g['s']?>/" method="post" hidden>
    <input type="hidden" name="r" value="<?php echo $r?>">
    <input type="hidden" name="m" value="member">
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

  <div class="page center" id="page-settings-profile">
    <header class="bar bar-nav bg-white px-0">
      <a class="icon icon-close pull-left px-3" data-history="back" role="button"></a>
      <h1 class="title" data-history="back">프로필 수정</h1>
    </header>
    <nav class="bar bar-tab bar-light bg-faded">
    	<a class="tab-item bg-white text-primary"
        data-target="#modal-member-profile"
        data-toggle="profile"
        data-url="<?php echo getProfileLink($my['uid']); ?>"
        data-mbruid="<?php echo $my['uid'] ?>"
        data-nic="<?php echo $my['nic'] ?>" role="button">
    		내 채널 보기
    	</a>
    </nav>
  	<main class="content bg-faded">

      <ul class="table-view bg-white m-t-0 border-top-0">
  			<li class="table-view-cell">
  		    <a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-avatar">

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
  		        <p> 프로필 사진을 변경해 보세요.</p>
  		      </div>
  		    </a>
  		  </li>
        <li class="table-view-cell">
          <a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-cover">
            <img class="media-object pull-left bg-faded" data-role="cover" src="<?php echo getCoverSrc($my['uid'],'100','100') ?>" width="49" height="49">
            <div class="media-body">
              배경 이미지
              <p>프로필 배경이미지를 변경해보세요.</p>
            </div>
          </a>
        </li>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" href="#page-settings-name" data-start="#page-settings-profile" data-title="이름">
  					<span class="badge badge-primary badge-inverted" data-role="name"><?php echo $my['name'] ?></span>
  					이름
  				</a>
  			</li>
        <li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" href="#page-settings-nic" data-start="#page-settings-profile" data-title="채널명">
  					<span class="badge badge-primary badge-inverted" data-role="nic"><?php echo $my['nic'] ?></span>
  					채널명
  				</a>
  			</li>
        <li class="table-view-cell">
          <a class="navigate-right" data-toggle="page" href="#page-settings-pemail" data-start="#page-settings-profile" data-title="공개 이메일">
            <span class="badge badge-primary badge-inverted" data-role="email"><?php echo $my['email_profile']?$my['email_profile']:'미표시' ?></span>
            공개 이메일
          </a>
        </li>
        <?php if($d['member']['form_settings_tel1']):?>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-tel1" data-title="유선전화">
  					<?php if ($my['tel1']): ?>
  					<span class="badge badge-primary badge-inverted" data-role="tel1"><?php echo $my['tel1'] ?></span>
  					<?php else: ?>
  					<span class="badge badge-default badge-inverted" data-role="tel1">미등록</span>
  					<?php endif; ?>
  					유선전화
  				</a>
  			</li>
        <?php endif; ?>

  			<?php if($d['member']['form_settings_birth']):?>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-birth" data-title="생년월일">
  					<?php if ($my['birth1']): ?>
  					<span class="badge badge-primary badge-inverted" data-role="birth"><?php echo $my['birth1'] ?>.<?php echo substr($my['birth2'],0,2) ?>.<?php echo substr($my['birth2'],2,4) ?></span>
  					<?php else: ?>
  					<span class="badge badge-default badge-inverted" data-role="birth">미등록</span>
  					<?php endif; ?>
  					생년월일
  				</a>
  			</li>
  			<?php endif?>

  			<?php if($d['member']['form_settings_sex']):?>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-sex" data-title="성별">
  					<?php if ($my['sex']): ?>
  					<span class="badge badge-primary badge-inverted" data-role="sex"><?php echo $my['sex']==1?'남성':'여성' ?></span>
  					<?php else: ?>
  					<span class="badge badge-default badge-inverted" data-role="sex">미등록</span>
  					<?php endif; ?>
  					성별
  				</a>
  			</li>
  			<?php endif?>

  			<?php if($d['member']['form_settings_bio']):?>
  			<li class="table-view-cell">
  		    <a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-bio" data-title="간단소개">
  		      <div class="media-body">
  		        간단소개
  		        <p data-role="bio" class="text-muted mt-1"><?php echo $my['bio']?></p>
  		      </div>
  					<?php if (!$my['bio']): ?>
  					<span class="badge badge-default badge-inverted" data-role="_bio">미등록</span>
  					<?php endif; ?>
  		    </a>
  		  </li>
  			<?php endif?>

  			<?php if($d['member']['form_settings_home']):?>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-home">
  					<?php if ($my['home']): ?>
  					<span class="badge badge-primary badge-inverted" data-role="home"><?php echo $my['home'] ?></span>
  					<?php else: ?>
  					<span class="badge badge-default badge-inverted" data-role="home">미등록</span>
  					<?php endif; ?>
  					홈페이지
  				</a>
  			</li>
  			<?php endif?>

  			<?php if($d['member']['form_settings_job']):?>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-job">
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
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-marr">
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
  				<a class="navigate-right" data-toggle="page" data-start="#page-settings-profile" href="#page-settings-addfield">
  					추가정보
  				</a>
  			</li>
  			<?php endif?>
  		</ul>

  	</main>
  </div><!-- /.page -->

  <!-- Target Page : 프로필 설정 -->
  <div class="page right" id="page-settings-avatar" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">프로필 설정</h1>
    </header>
    <nav class="bar bar-tab bar-dark bar-dark bg-inverse border-top-0">
    	<a class="tab-item bg-primary js-save" role="button">
    		저장하기
    	</a>
    </nav>
    <div class="content bg-white">
      <div class="content-padded">

        <?php if($d['member']['form_settings_avatar']):?>
        <div class="avatar-wrapper p-t-2<?php echo  $my['photo']?' active':'' ?>" data-role="avatar-wrapper">

          <div class="avatar-blank">
            <span>
              <img class="img-circle js-avatar-img m-x-auto" src="<?php echo $g['s']?>/files/avatar/0.svg" alt="" width="160">
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
              <a class="btn btn-secondary" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=member&amp;a=member_photo_delete" onclick="return hrefCheck(this,true,'정말로 삭제 하시겠습니까?');">
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
          <input type="hidden" name="m" value="member">
          <input type="hidden" name="a" value="member_photo">
          <input type="file" name="upfile" class="hidden" id="rb-upfile-avatar" accept="image/jpg, image/gif, image/jpeg, image/png">
        </form>
        <?php endif?>

      </div>
    </div>
  </div>

  <!-- Target Page : 커버이미지 설정 -->
  <div class="page right" id="page-settings-cover" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">배경 이미지 설정</h1>
    </header>
    <nav class="bar bar-tab bar-dark bar-dark bg-inverse border-top-0">
    	<a class="tab-item bg-primary js-save" role="button">
    		저장하기
    	</a>
    </nav>
    <div class="content bg-white">
      <div class="cover-wrapper<?php echo  $my['cover']?' active':'' ?>" data-role="cover-wrapper">

        <div class="cover-blank mt-5">
          <span>
            <i class="fa fa-picture-o fa-5x text-muted m-x-auto" aria-hidden="true"></i>
            <span class="fa-stack fa-lg js-cover-img">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-camera fa-stack-1x fa-inverse"></i>
            </span>
          </span>
          <p class="m-t-1 text-muted">배경이미지를 등록해 보세요.</p>
        </div><!-- /.avatar-blank -->

        <div class="cover-photo">
          <span class="cover-photo">
            <img class="img-fluid" data-role="cover" src="<?php echo getCoverSrc($my['uid'],'680','350') ?>" alt="<?php echo $my[$_HS['nametype']]?>">
          </span>
          <div class="m-t-1">
            <a class="btn btn-secondary" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=member&amp;a=member_cover_delete" onclick="return hrefCheck(this,true,'정말로 삭제 하시겠습니까?');">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
              현재 사진삭제
            </a>

          </div>
        </div><!-- /.avatar-photo -->

      </div><!-- /.avatar-wrapper -->

      <form name="MbrCoverForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
        <input type="hidden" name="r" value="<?php echo $r?>">
        <input type="hidden" name="m" value="member">
        <input type="hidden" name="a" value="member_cover">
        <input type="file" name="upfile" class="hidden" id="rb-upfile-cover" accept="image/jpg, image/gif, image/jpeg, image/png">
      </form>

    </div>
  </div>

  <!-- Target Page : 이름 설정 -->
  <div class="page right" id="page-settings-name" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">이름 설정</h1>
    </header>

    <nav class="bar bar-tab bar-dark bar-dark bg-inverse border-top-0">
    	<a class="tab-item bg-primary" data-act="submit" role="button">
    		저장하기
    	</a>
    </nav>
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

  <!-- Target Page : 공개 이메일 설정 -->
  <div class="page right" id="page-settings-pemail" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">공개 이메일 설정</h1>
    </header>

    <nav class="bar bar-tab bar-dark bar-dark bg-inverse border-top-0">
      <a class="tab-item bg-primary js-save" role="button">
        저장하기
      </a>
    </nav>
    <div class="content">
      <div class="content-padded">

        <div class="form-group">
          <select class="form-control custom-select" name="email_profile">
            <option value="">선택하세요.</option>
            <?php while($R=db_fetch_array($RCD)):?>
            <option value="<?php echo $R['email'] ?>"<?php echo ($my['email_profile']==$R['email'])?' selected':'' ?>>
              <?php echo $R['email'] ?>
            </option>
            <?php endwhile?>
          </select>
        </div>
        <small class="form-text text-muted">
          이메일 관리에서 이메일을 추가할수 있으며, 본인인증된 메일만 지정할수 있습니다.
        </small>


      </div>
    </div>
  </div>

  <!-- Target Page : 채널명 설정 -->
  <div class="page right" id="page-settings-nic" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-role="title" data-history="back">채널명 설정</h1>
    </header>
    <nav class="bar bar-tab bar-dark bar-dark bg-inverse border-top-0">
    	<a class="tab-item bg-primary" data-act="submit" role="button">
    		저장하기
    	</a>
    </nav>
    <div class="content">
      <div class="content-padded">
        <div class="input-group input-group-lg">
          <input type="text" class="form-control" name="nic" value="<?php echo $my['nic']?>"  maxlength="20" required  autocomplete="off">
        </div>

        <div class="form-control-feedback" id="hLayernic"></div>
        <div class="invalid-feedback">
          닉네임을 입력해 주세요.
        </div>
        <small class="form-text text-muted">
          사용하고 싶은 닉네임을 입력해 주세요 (8자이내 중복불가)
        </small>

      </div>
    </div>
  </div>

  <?php if($d['member']['form_settings_tel1']):?>
  <!-- Target Page : 전화번호 설정 -->
  <div class="page right" id="page-settings-tel1" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">유선전화 설정</h1>
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
  <div class="page right" id="page-settings-birth" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">생년월일 설정</h1>
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
  <div class="page right" id="page-settings-sex" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">성별 설정</h1>
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
  <div class="page right" id="page-settings-bio" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <h1 class="title" data-history="back">간단소개 설정</h1>
    </header>
    <nav class="bar bar-tab bar-dark bar-dark bg-inverse border-top-0">
    	<a class="tab-item bg-primary" data-act="submit" role="button">
    		저장하기
    	</a>
    </nav>
    <div class="content">
      <div class="content-padded">
        <textarea class="form-control" name="bio" rows="5" placeholder="간략한 소개글을 입력해주세요."><?php echo $my['bio']?></textarea>
      </div>
    </div>
  </div>
  <?php endif?>

  <?php if($d['member']['form_settings_home']):?>
  <!-- Target Page : 홈페이지 설정 -->
  <div class="page right" id="page-settings-home" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
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
  <div class="page right" id="page-settings-job" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
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
  <div class="page right" id="page-settings-marr" >
    <header class="bar bar-nav bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
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


</div>


<!-- 5. 모달 : 설정 -->
<div id="modal-settings-general" class="modal">

  <div class="page center" id="page-settings-main">
    <header class="bar bar-nav bg-white px-0">
      <a class="icon icon-close pull-left px-3" data-history="back" role="button"></a>
      <h1 class="title" data-history="back">설정</h1>
    </header>

  	<main class="content bg-faded">

      <ul class="table-view bg-white mt-0 mb-2 border-top-0">
        <li class="table-view-cell">
          <a class=""
            data-target="#modal-member-profile"
            data-toggle="profile"
            data-mbruid="<?php echo $my['uid'] ?>"
            data-change="true"
            data-url="<?php echo getProfileLink($my['uid']); ?>"
            data-nic="<?php echo $my['nic'] ?>">
            <img class="media-object pull-left img-circle" src="<?php echo getAvatarSrc($my['uid'],'130') ?>" style="width:65px;height:65px">
            <div class="media-body">
              <?php echo $my['name'] ?>
              <p>
                <?php echo $my['email'] ?><br><span class="f13">구독자 <?php echo number_format($my['num_follower']) ?> 명</span>
                <?php if ($my['admin']): ?><span class="badge badge-pill badge-danger">ADMIN</span><?php endif; ?>

              </p>
            </div>
          </a>
          <button class="btn btn-secondary" data-toggle="changeModal" data-target="#modal-settings-profile">
            프로필 수정
          </button>
        </li>

  			<li class="table-view-cell">
  				<a class="navigate-right"
            data-toggle="page"
            href="#page-settings-account"
            data-start="#page-settings-main"
            data-url="/settings?page=account"
            data-title="회원계정">
  					<span class="badge badge-default badge-inverted"><?php echo $my['id'] ?></span>
  					회원계정
  				</a>
  			</li>
  			<li class="table-view-cell">
  				<a class="navigate-right"
            data-toggle="page"
            href="#page-settings-email"
            data-start="#page-settings-main"
            data-url="/settings?page=email"
            data-title="이메일 관리">
  					<span class="badge badge-default badge-inverted"><?php echo $my['email']?$my['email']:'미등록' ?></span>
  					이메일
  				</a>
  			</li>
  			<li class="table-view-cell">
  				<a class="navigate-right"
            data-toggle="page"
            href="#page-settings-phone"
            data-start="#page-settings-main"
            data-url="/settings?page=phone"
            data-title="휴대폰 관리">
  					<span class="badge badge-default badge-inverted"><?php echo $my['phone']?$my['phone']:'미등록' ?></span>
  					휴대폰
  				</a>
  			</li>
  			<li class="table-view-cell">
  				<a class="navigate-right"
            data-toggle="page"
            href="#page-settings-noti"
            data-start="#page-settings-main"
            data-url="/settings?page=noti"
            data-title="알림설정">
  					<?php if ($nt_web==''): ?>
  					<span class="badge badge-primary badge-pill">ON</span>
  					<?php else: ?>
  					<span class="badge badge-default badge-outline">OFF</span>
  					<?php endif; ?>
  					알림설정
  				</a>
  			</li>
  			<!-- 소셜미디어 연결 -->
  			<?php if ($d['member']['login_social']): ?>
  			<?php $isSNSlogin = getDbData($table['s_mbrsns'],'memberuid='.$my['uid'],'*'); ?>
  			<li class="table-view-cell">
  				<a class="navigate-right" data-toggle="page" href="#page-settings-connect" data-start="#page-settings-main" data-title="연결계정 관리">
  					<span class="badge badge-inverted">
  						<?php if ($my_naver['uid']): ?><img class="rounded-circle" src="/_core/images/sns/naver.png" alt="네이버" width="22"><?php endif; ?>
  						<?php if ($my_kakao['uid']): ?><img class="rounded-circle" src="/_core/images/sns/kakao.png" alt="카카오" width="22"><?php endif; ?>
  						<?php if ($my_google['uid']): ?><img class="rounded-circle" src="/_core/images/sns/google.png" alt="구글" width="22"><?php endif; ?>
  						<?php if ($my_facebook['uid']): ?><img class="rounded-circle" src="/_core/images/sns/facebook.png" alt="페이스북" width="22"><?php endif; ?>
  						<?php if ($my_instagram['uid']): ?><img class="rounded-circle" src="/_core/images/sns/instagram.png" alt="인스타그램" width="22"><?php endif; ?>
  					</span>
  					연결계정
  				</a>
  			</li>
  			<?php endif; ?>
  			<li class="table-view-cell">
  				<a class="navigate-right"
            data-toggle="page"
            href="#page-settings-shipping"
            data-start="#page-settings-main"
            data-url="/settings?page=shipping"
            data-title="배송지 관리">
  					<span class="badge badge-default badge-inverted">
  						<?php echo $my_shipping_num?number_format($my_shipping_num).' 곳':'미등록'?>
  					</span>
  					배송지 관리
  				</a>
  			</li>
        <?php if ($my['admin']): ?>
         <li class="table-view-cell table-view-divider small">관리자 전용</li>
         <li class="table-view-cell">
           <a data-href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=settings&prelayout=rc-starter/blank' ?>">
             레이아웃 편집
           </a>
         </li>
         <li class="table-view-cell">
           <a data-href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=system&prelayout=rc-starter/blank' ?>" data-text="업데이트를 확인하는 중..">
             시스템 정보
           </a>
         </li>
         <?php endif; ?>
  		</ul>

      <ul class="table-view bg-white mb-2">
        <li class="table-view-cell">
          <a class="" href="#popup-logout" data-toggle="popup">
            로그아웃
          </a>
        </li>
      </ul>

  	</main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-account">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">회원계정</span>
    </header>
    <main class="content">
      <ul class="table-view bg-white m-t-0 animated fadeIn delay-1 border-top-0">
        <li class="table-view-cell">
          <a class="navigate-right" data-toggle="page" data-start="#page-settings-account" href="#page-settings-pw">
            <?php if ($my['last_pw']): ?>
            <span class="badge badge-default badge-inverted"><?php echo -getRemainDate($my['last_pw'])?>일전 변경</span>
            <?php endif; ?>
            비밀번호 <?php echo $my['last_pw']?'변경':'등록' ?>
          </a>
        </li>
        <li class="table-view-cell">
          <a class="navigate-right" data-toggle="page" data-start="#page-settings-account" href="#page-settings-id">
            <span class="badge badge-default badge-inverted"><?php echo $my['id'] ?></span>
            아이디 변경
          </a>
        </li>
        <li class="table-view-cell">
          <a class="navigate-right" data-toggle="page" data-start="#page-settings-account" href="#page-settings-leave">
            탈퇴
          </a>
        </li>
      </ul>
    </main>
  </div><!-- /.page -->

  <!-- 비밀번호 -->
  <div class="page right" id="page-settings-pw" >
  	<header class="bar bar-nav bar-light bg-white px-0">
  		<a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <button class="btn btn-link btn-nav pull-right p-l-1 p-r-2" data-act="changePW">
        <span class="not-loading">변경</span>
        <span class="is-loading">
          <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="sr-only">처리중...</span>
          </div>
        </span>
      </button>

  		<h1 class="title">비밀번호 <?php echo $my['only_sns']?'등록':'변경' ?></h1>
  	</header>
  	<div class="content">

  		<form id="pwChangeForm" class="content-padded" role="form" action="<?php echo $g['s']?>/" method="post" autocomplete="off">
  				<input type="hidden" name="r" value="<?php echo $r?>">
  				<input type="hidden" name="m" value="member">
  				<input type="hidden" name="a" value="pw_update">
          <input type="hidden" name="check_pw1" value="0">
          <input type="hidden" name="check_pw2" value="0">

  				<div class="form-group position-relative">
  					<label>새 비밀번호</label>
  					<input type="password" class="form-control" name="pw1" placeholder="8자이상 영문과 숫자만 사용할 수 있습니다." autocomplete="off" data-role="pw1">
  					<div class="invalid-tooltip" data-role="pw1CodeBlock"></div>
  				</div>

  				<div class="form-group position-relative">
  					<label>새 비밀번호 확인</label>
  					<input type="password" class="form-control" name="pw2" placeholder="변경할 비밀번호를 한번 더 입력하세요" autocomplete="off" data-role="pw2">
  					<div class="invalid-tooltip" data-role="pw2CodeBlock"></div>
  				</div>

          <div class="content-padded mt-3">
           <?php if ($my['only_sns']): ?>
             <p class="text-muted small">비밀번호를 등록하면 비밀번호를 통한 로그인이 가능합니다.</p>
           <?php else: ?>
           <p class="text-muted small">현재 비밀번호는 <code><?php echo getDateFormat($my['last_pw'],'Y.m.d')?></code> 에 변경(등록)되었으며 <code>
           <?php echo -getRemainDate($my['last_pw'])?>일</code>이 경과되었습니다.
           비밀번호는 가급적 주기적으로 변경해 주세요.</p>
           <?php endif; ?>
         </div>

  		 </form>

  	</div>
  </div><!-- /.page -->

  <!-- 아이디 변경 -->
  <div class="page right" id="page-settings-id">
    <header class="bar bar-nav bar-light bg-white px-0">
  		<a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
  		<h1 class="title">아이디 변경</h1>
  	</header>
  	<div class="content">
  		<div class="content-padded">



  		</div>
  	</div>
  </div><!-- /.page -->

  <!-- 회원탈퇴 -->
  <div class="page right" id="page-settings-leave" >
  	<header class="bar bar-nav bar-light bg-white px-0">
  		<a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
  		<h1 class="title">회원탈퇴</h1>
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

  <div class="page right" id="page-settings-email">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">이메일 관리</span>
    </header>
    <main class="content">

    </main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-phone">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">휴대폰 관리</span>
    </header>
    <main class="content">

    </main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-noti">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">알림설정</span>
    </header>
    <main class="content">
      <form id="procForm" role="form" action="<?php echo $g['s']?>/" method="post">
  			<input type="hidden" name="r" value="<?php echo $r?>">
  			<input type="hidden" name="m" value="notification">
  			<input type="hidden" name="a" value="notice_config_user">
  			<input type="hidden" name="mobile" value="1">
  			<input type="hidden" name="nt_web" value="<?php echo $nt_web ?>">
  			<input type="hidden" name="nt_email" value="<?php echo $nt_email ?>">
  			<input type="hidden" name="nt_fcm" value="<?php echo $nt_fcm ?>">
  			<input type="hidden" name="reload" value="">

  			<ul class="table-view bg-white mt-0 mb-0 border-top-0">
  				<li class="table-view-cell media" style="padding-right: 6rem ">
  					<i class="media-object pull-left fa fa-bell-o fa-fw mt-1 mr-2 text-muted" aria-hidden="true"></i>
  					<div class="media-body">
  						 사이트 알림
  						 <p>OFF 설정시 모든알림이 차단됩니다.</p>
  					</div>
  					<div data-toggle="switch" class="switch<?php echo $nt_web==''?' active':'' ?>" id="nt_web">
  						<div class="switch-handle"></div>
  					</div>
  				</li>
  				<?php if ($nt_web==''): ?>
  				<li class="table-view-cell">
  					<a class="navigate-right" data-toggle="page" data-start="#page-settings-noti" href="#page-settings-noti-email">
  						<span class="badge badge-<?php echo $nt_email=='1'?'primary badge-pill':'default badge-outline' ?>  nt-label" data-role="email"> </span>
  						<i class="fa fa-envelope-o fa-fw mr-2 text-muted" aria-hidden="true"></i> 이메일 알림
  					</a>
  				</li>


  				<?php if ($g['push_active']==1): ?>
  				<li class="table-view-cell" id="push_setting" style="display: block">
  					<a class="navigate-right" data-toggle="page" data-start="#page-settings-noti" href="#page-settings-noti-fcm">
  						<span class="badge badge-<?php echo $nt_fcm=='1'?'primary badge-pill':'default badge-outline' ?> nt-label" data-role="fcm"> </span>
  						<i class="fa fa-bolt fa-fw fa-lg mr-1 text-muted" aria-hidden="true"></i> 푸시 알림
  					</a>
  				</li>

  				<li class="table-view-cell" id="permission_div" style="display: none">
  					<a class="navigate-right" href="" id="RequestPermission">
  						<span class="badge badge-primary badge-outline">권한요청</span>
  						<i class="fa fa-bolt fa-lg fa-fw mt-2 mr-2 text-muted" aria-hidden="true"></i> 푸시 알림
  					</a>
  				</li>

  				<li class="table-view-cell" id="push_disabled" style="display: none">
  					<a class="navigate-right" href="https://support.google.com/chrome/answer/114662?hl=ko&co=GENIE.Platform%3DAndroid&oco=1" target="_blank">
  						<i class="media-object pull-left fa fa-bolt fa-lg fa-fw mt-2 mr-2 text-muted" aria-hidden="true"></i>
  						<span class="badge badge-danger badge-outline">해제</span>
  						<div class="media-body">
  							푸시 알림 차단됨
  							<p class="mr-4">
  								알림발송이 차단되었습니다.<br> 상태를 해제하려면 설정변경이 필요합니다.
  							</p>
  						</div>
  					</a>
  				</li>
  				<?php elseif ($g['push_active']==2): ?>
  				<li class="table-view-cell">
  					<i class="media-object pull-left fa fa-bolt fa-fw mt-1 mr-2 text-muted" aria-hidden="true"></i>
  					<div class="media-body">
  						 푸시 알림이 지원되지 않습니다.
  						 <p class="text-danger">푸시알림을 위한 연결정보가 없습니다.<br>관리자에게 문의하세요.</p>
  					</div>
  				</li>
  				<?php else: ?>
  				<li class="table-view-cell">
  					<i class="media-object pull-left fa fa-bolt fa-fw mt-1 mr-2 text-muted" aria-hidden="true"></i>
  					<div class="media-body">
  						 푸시 알림이 지원되지 않습니다.
  						 <p>안드로이드(Android)기기에서 지원됩니다.</p>
  					</div>
  				</li>
  				<?php endif; ?>

  				<li class="table-view-cell table-view-divider">
  					모듈별 설정
  				</li>
  				<?php $_MODULES=getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
  				<?php while($_MD=db_fetch_array($_MODULES)):?>

  				<li class="table-view-cell<?php if(strstr($d['ntfc']['cut_modules'],'['.$_MD['id'].']')):?> d-none<?php endif?>" style="padding-right: 6rem " >
  					<div class="media-body">
  						<i class="<?php echo $_MD['icon']?> fa-fw mr-2 text-muted"></i>
  						<?php echo $_MD['name']?>
  					</div>
  					<div data-toggle="switch" class="module_members switch<?php echo strstr($NT_DATA[3],'['.$_MD['id'].']')?'':' active' ?>" data-module="<?php echo $_MD['id']?>" id="module_members_<?php echo $_MD['id']?>">
  						<div class="switch-handle"></div>
  					</div>
  				</li>
  				<?php endwhile?>
  					<li class="table-view-cell table-view-divider">알림발송이 차단된 회원</li>

  					<?php $_i=0;foreach($nt_members['data'] as $_md):?>
  					<?php $_R=getDbData($table['s_mbrdata'],'memberuid='.$_md,'*')?>
  					<li class="table-view-cell">
  						<div class="media">
  							<img class="img-circle mr-3" src="<?php echo getAvatarSrc($_R['memberuid'],'96') ?>" alt="" width="48" height="48">
  							<div class="media-body">
  								<h5 class="f14 mt-1 mb-0">
  									<?php if($_R['name']):?>
  									<?php echo $_R['name']?> <span class="badge badge-default badge-inverted align-text-top ml-2"><?php echo $_R['nic']?></span>
  									<?php else: ?>
  									<span class="badge badge-outline">시스템</span>
  									<?php endif?>
  								</h5>
  								<span class="badge badge-default badge-inverted"><?php echo getDateFormat($_R['d_regis'],'Y.m.d')?> 가입</span>
  							</div>
  						</div>

  						<a class="btn btn-secondary btn-sm" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=notification&amp;a=notice_config_user&amp;member_uid=<?php echo $_R['memberuid']?>" onclick="return hrefCheck(this,true,'정말로 해제하시겠습니까?');">
  							차단해제
  						</a>
  					</li>
  					<?php $_i++;endforeach?>

  					<?php if(!$nt_members['count']):?>
  					<li class="table-view-cell text-xs-center p-4 small text-muted">
  						차단된 회원이 없습니다.
  					</li>
  					<?php endif?>

  				<?php endif?>

  			</ul>

  			<?php if ($nt_web): ?>
  			<div class="p-5 text-xs-center text-muted">
  				알림이 꺼져서 소식을 받을 수 없습니다. <br>
  				알림을 켜서 글, 댓글, 나 언급한 글 등<br>
  				중요알림을 받아보세요.
  			</div>
  			<?php endif?>

  		</form>
    </main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-noti-email">
  	<header class="bar bar-nav bar-light bg-white px-0">
  		<a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
  		<h1 class="title" data-location="reload"><i class="fa fa-envelope-o fa-fw text-muted" aria-hidden="true"></i> 이메일 알림</h1>
  	</header>
  	<main class="content bg-faded">
  		<ul class="table-view bg-white m-t-0 animated fadeIn delay-1">
  			<li class="table-view-cell" style="padding-right: 6rem ">
  				<div class="media-body">
  					이메일 알림
  					<p>알림발송시 이메일도 받음</p>
  				</div>
  				<div data-toggle="switch" class="switch<?php echo $nt_email==1?' active':'' ?>" id="nt_email">
  					<div class="switch-handle"></div>
  				</div>
  			</li>
  		</ul>

  		<div class="content-padded">
  			<div class="form-group">
  				<label for="exampleSelect2">수신 이메일</label>
  				<select class="form-control custom-select form-control-lg" name="email_noti">
  					<option value="">사용안함</option>
  					<?php while($R=db_fetch_array($RCD)):?>
  					<option value="<?php echo $R['email'] ?>"<?php echo ($my['email_noti']==$R['email'])?' selected':'' ?>>
  						<?php echo $R['email'] ?>
  					</option>
  					<?php endwhile?>
  				</select>
  				<p class="form-text text-muted mt-3">
  					<a href="/?r=home&amp;mod=settings&amp;page=email">이메일 관리</a>에서 추가 할수있으며, 본인인증된 메일만 추가할 수 있습니다.
  				</p>
  				<button type="button" class="btn btn-outline-primary btn-block mt-3 js-submit">
  					<span class="not-loading">저장</span>
  					<span class="is-loading">저장중..</span>
  				</button>

  			</div>
  		</div>

  	</main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-noti-fcm">
  	<header class="bar bar-nav bar-light bg-white px-0">
  		<a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
  		<h1 class="title" data-history="back"><i class="fa fa-bolt fa-fw text-muted" aria-hidden="true"></i> 푸시 알림</h1>
  	</header>
  	<main class="content bg-faded">

  		<ul class="table-view bg-white mt-0 mb-0 animated fadeIn delay-1">
  			<li class="table-view-cell" style="padding-right: 6rem ">
  				<div class="media-body">
  					푸시 알림
  				</div>
  				<div data-toggle="switch" class="switch<?php echo $nt_fcm==1?' active':'' ?>" id="nt_fcm">
  					<div class="switch-handle"></div>
  				</div>
  			</li>
  		</ul>

  		<div id="token_div" class="<?php echo $nt_fcm==1?'':'d-none' ?>">

  			<ul class="table-view bg-white m-t-0 animated fadeIn delay-1" style="margin-top: -.0625rem!important ">
  				<li class="table-view-divider">
  					<i class="fa fa-mobile fa-lg mr-2 text-muted" aria-hidden="true"></i>
  					인스턴스 ID 토큰
  				</li>
  				<li class="table-view-cell" style="line-height: 1.2;">
  					<small class="token text-muted" style="word-break: break-all;"></small>
  					<button class="btn btn-secondary js-deleteToken">
  						재발급
  					</button>
  				</li>
  			</ul>

  			<div class="content-padded text-muted small">

  				<button type="button" class="btn btn-secondary btn-block js-sendTest">
  					<span class="not-loading">나에게 푸시알림 보내기</span>
  					<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 보내는중 ...</span>
  				</button>
  				<p class="mt-3">
  					푸시알림이 수신되지 않는다면, 토큰 '재발급'을 시도해 보세요. 알림메시지를 받았다면 정상 입니다.
  				</p>
  				<p>
  					인스턴스 ID 토큰은 푸시알림에 활용됩니다.
  					접속한 기기가 변경되면 토큰 또한 변경됩니다.
  				</p>

  			</div>

  		</div><!-- /#token_div -->

  	</main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-connect">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">연결계정 관리</span>
    </header>
    <main class="content">
      <ul class="table-view bg-white m-t-0 border-top-0">
        <?php if ($d['connect']['use_n']): ?>
        <li class="table-view-cell" style="padding-right: 6rem ">
          <img class="media-object pull-left rounded-circle <?php echo !$my_naver['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/naver.png" alt="네이버" width="28">
          <div class="media-body">
            네이버
            <?php if ($my_naver['uid']): ?>
            <p><?php echo getDateFormat($my_naver['d_regis'],'Y.m.d H:i') ?> 연결</p>
            <?php endif; ?>
          </div>
          <div data-toggle="switch" class="switch<?php echo $my_naver['uid']?' active':'' ?>" id="reception_sms">
            <div class="switch-handle"></div>
          </div>
        </li>
        <?php endif; ?>

        <?php if ($d['connect']['use_k']): ?>
        <li class="table-view-cell" style="padding-right: 6rem ">
          <img class="media-object pull-left rounded-circle<?php echo !$my_kakao['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/kakao.png" alt="카카오" width="28">
          <div class="media-body">
            카카오
            <?php if ($my_kakao['uid']): ?>
            <p><?php echo getDateFormat($my_kakao['d_regis'],'Y.m.d H:i') ?> 연결</p>
            <?php endif; ?>
          </div>
          <div data-toggle="switch" class="switch<?php echo $my_kakao['uid']?' active':'' ?>" id="reception_sms">
            <div class="switch-handle"></div>
          </div>
        </li>
        <?php endif; ?>

        <?php if ($d['connect']['use_g']): ?>
        <li class="table-view-cell" style="padding-right: 6rem ">
          <img class="media-object pull-left rounded-circle<?php echo !$my_google['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/google.png" alt="구글" width="28">
          <div class="media-body">
            구글
            <?php if ($my_google['uid']): ?>
            <p><?php echo getDateFormat($my_google['d_regis'],'Y.m.d H:i') ?> 연결</p>
            <?php endif; ?>
          </div>
          <div data-toggle="switch" class="switch<?php echo $my_google['uid']?' active':'' ?>" id="reception_sms">
            <div class="switch-handle"></div>
          </div>
        </li>
        <?php endif; ?>

        <?php if ($d['connect']['use_f']): ?>
        <li class="table-view-cell" style="padding-right: 6rem ">
          <img class="media-object pull-left rounded-circle<?php echo !$my_facebook['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/facebook.png" alt="페이스북" width="28">
          <div class="media-body">
            페이스북
            <?php if ($my_facebook['uid']): ?>
            <p><?php echo getDateFormat($my_facebook['d_regis'],'Y.m.d H:i') ?> 연결</p>
            <?php endif; ?>
          </div>
          <div data-toggle="switch" class="switch<?php echo $my_facebook['uid']?' active':'' ?>" id="reception_sms">
            <div class="switch-handle"></div>
          </div>
        </li>
        <?php endif; ?>

        <?php if ($d['connect']['use_i']): ?>
        <li class="table-view-cell" style="padding-right: 6rem ">
          <img class="media-object pull-left rounded-circle<?php echo !$my_instagram['uid']?' filter grayscale':'' ?>" src="/_core/images/sns/instagram.png" alt="인스타그램" width="28">
          <div class="media-body">
            인스타그램
            <?php if ($my_instagram['uid']): ?>
            <p><?php echo getDateFormat($my_instagram['d_regis'],'Y.m.d H:i') ?> 연결</p>
            <?php endif; ?>
          </div>
          <div data-toggle="switch" class="switch<?php echo $my_instagram['uid']?' active':'' ?>" id="reception_sms">
            <div class="switch-handle"></div>
          </div>
        </li>
        <?php endif; ?>
      </ul>

      <div class="content-padded">
        <p class="text-muted">외부의 소셜미디어 계정을 연결하고 통합관리 합니다. 연결된 소셜미디어로 사용자인증 및 연결을 지원합니다.</p>
      </div>
    </main>
  </div><!-- /.page -->

  <div class="page right" id="page-settings-shipping">
    <header class="bar bar-nav bar-light bg-white px-0">
      <a class="icon pull-left material-icons px-3" role="button" data-history="back">arrow_back</a>
      <span class="title title-left" data-history="back" data-role="title">배송지 관리</span>
    </header>
    <main class="content">

    </main>
  </div><!-- /.page -->


</div><!-- /.modal -->


<script src="/modules/member/themes/<?php echo $d['member']['theme_mobile']?>/settings/component.js<?php echo $g['wcache']?>" ></script>
