<?php
$sqlque= 'mbruid='.$my['uid'].' and d_verified<>0';
$RCD = getDbArray($table['s_mbremail'],$sqlque,'*','uid','asc',0,1);
$PCD = getDbArray($table['s_mbrphone'],$sqlque,'*','uid','asc',0,1);
?>


<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
  <nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>
  <div class="col-9 page-main">

    <div class="subhead mt-0">
      <h2 class="subhead-heading">프로필 관리</h2>
    </div>

    <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
    <?php include_once $g['dir_module_skin'].'_lock.php'?>
    <?php else: ?>

      <!-- 프로필 커버 이미지 -->
      <div class="d-flex justify-content-between align-items-end bg-light border p-3 mt-3 mb-4" style="height:255px;background-size: cover;background-image: url('<?php echo getCoverSrc($my['uid'],'940','255') ?>');">
        <div class="">
          <button type="button" data-toggle="cover" class="btn btn-light">
            <span class="fa fa-upload fa-lg"></span> 사진 업로드
          </button>
        </div>
        <?php if($my['cover']):?>
          <a class="btn btn-light" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=cover_delete&amp;reload=Y" title="<?php echo $my['cover']?>" onclick="return hrefCheck(this,true,'정말로 삭제 하시겠습니까?');">
            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> 현재 사진삭제
          </a>
        <?php endif?>
      </div>

      <div class="clearfix">
        <form class="float-left" id="memberForm" role="form" action="<?php echo $g['s']?>/" method="post" style="width: 500px;" novalidate>
          <input type="hidden" name="r" value="<?php echo $r?>">
          <input type="hidden" name="m" value="<?php echo $m?>">
          <input type="hidden" name="front" value="<?php echo $front?>">
          <input type="hidden" name="a" value="settings_main">
          <input type="hidden" name="act" value="info">
          <input type="hidden" name="check_nic" value="<?php echo $my['nic']?1:0?>">

          <div class="form-group">
            <label>이름 <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="<?php echo $my['name']?>" maxlength="10" required>
          </div>

          <?php if($d['member']['form_settings_nic']):?>
          <div class="form-group">
            <label>닉네임<?php if($d['member']['form_settings_nic_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <input type="text" class="form-control" name="nic" value="<?php echo $my['nic']?>"  maxlength="20" onblur="sameCheck(this,'hLayernic');">
            <div class="invalid-feedback" id="hLayernic"></div>
            <small class="form-text text-muted mt-2">
              웹사이트에서 사용하고 싶은 이름을 입력해 주세요 (8자이내 중복불가)
            </small>
          </div>
          <?php endif?>

          <?php if($d['member']['form_settings_email_profile']):?>
          <div class="form-group" id="select-email-profile">
            <label>공개 이메일 <?php if($d['member']['form_settings_email_profile_required']):?><span class="text-danger">*</span><?php endif?></label>

            <?php if ($my['email']): ?>
            <select class="form-control custom-select" name="email_profile"<?php if($d['member']['form_settings_email_profile_required']):?> required<?php endif?>>
              <option value="">선택하세요.</option>
              <?php while($R=db_fetch_array($RCD)):?>
              <option value="<?php echo $R['email'] ?>"<?php echo ($my['email_profile']==$R['email'])?' selected':'' ?>>
                <?php echo $R['email'] ?>
              </option>
              <?php endwhile?>
            </select>
            <div class="invalid-feedback mt-2">프로필에 공개할 이메일을 선택하세요.</div>
            <small class="form-text text-muted mt-2">
              <a href="<?php echo $g['url_reset']?>&amp;page=email">이메일 관리</a>에서 이메일을 추가할수 있으며, 본인인증된 메일만 지정할수 있습니다.
            </small>
            <?php else: ?>
            <select class="form-control custom-select" onChange="window.document.location.href=this.options[this.selectedIndex].value;">
              <option value="">선택하세요.</option>
              <option value="<?php echo $g['url_reset']?>&amp;page=email">메일 추가하기</option>
            </select>
            <small class="form-text text-muted mt-2">
              본인인증된 메일만 추가할 수 있습니다.
            </small>
            <?php endif; ?>

          </div>
          <?php endif?>

          <hr>

          <?php if($d['member']['form_settings_birth']):?>
          <div class="form-group">
            <label>생년월일<?php if($d['member']['form_settings_birth_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <div class="form-inline">
              <select class="form-control custom-select" name="birth_1">
                <option value="">년도</option>
                <?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
                <option value="<?php echo $i?>"<?php if($my['birth1']==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="birth_2">
                <option value="">월</option>
                <?php $birth_2=substr($my['birth2'],0,2)?>
                <?php for($i = 1; $i < 13; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_2==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="birth_3">
                <option value="">일</option>
                <?php $birth_3=substr($my['birth2'],2,2)?>
                <?php for($i = 1; $i < 32; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_3==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <div class="custom-control custom-checkbox ml-3">
                <input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1"<?php if($my['birthtype']):?> checked="checked"<?php endif?>>
                <label class="custom-control-label" for="birthtype">음력</label>
              </div>
              <div class="invalid-feedback mt-2">
                생년월일을 지정해 주세요.
              </div>
            </div><!-- /.form-inline -->
          </div>
        	<?php endif?>

          <?php if($d['member']['form_settings_sex']):?>
          <div class="form-group">
            <label>성별 <?php if($d['member']['form_settings_sex_required']):?><span class="text-danger">*</span><?php endif?></label>
            <div id="radio-sex">
              <div class="custom-control custom-radio  custom-control-inline">
                <input type="radio" id="sex_1" name="sex" class="custom-control-input" value="1"<?php if($my['sex']==1):?> checked="checked"<?php endif?> required>
                <label class="custom-control-label" for="sex_1">남성</label>
              </div>
              <div class="custom-control custom-radio  custom-control-inline">
                <input type="radio" id="sex_2" name="sex" class="custom-control-input" value="2"<?php if($my['sex']==2):?> checked="checked"<?php endif?> required>
                <label class="custom-control-label text-nowrap" for="sex_2">여성</label>
                <div class="invalid-feedback ml-4">성별을 선택해 주세요.</div>
              </div>

            </div>

          </div>
        	<?php endif?>

        <?php if($d['member']['form_settings_bio']):?>
          <div class="form-group">
            <label>간단소개<?php if($d['member']['form_settings_bio_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <textarea class="form-control" name="bio" rows="3" placeholder="간략한 소개글을 입력해주세요."><?php echo $my['bio']?></textarea>
            <div class="invalid-feedback">
              간단소개를 입력해 주세요.
            </div>
          </div>
          <?php endif?>

          <?php if($d['member']['form_settings_home']):?>
          <div class="form-group">
            <label>홈페이지<?php if($d['member']['form_settings_home_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <input type="text" class="form-control" name="home" value="<?php echo $my['home']?>" placeholder="URL을 입력하세요.">
            <div class="invalid-feedback">
              홈페이지 주소를 입력해주세요.
            </div>
          </div>
          <?php endif?>

          <?php if($d['member']['form_settings_tel']):?>
            <div class="form-group">
              <label>일반전화 <?php if($d['member']['form_settings_tel_required']):?><span class="text-danger">*</span><?php endif?></label>
              <?php $tel1=explode('-',$my['tel'])?>
              <div class="form-inline">
                <input type="text" name="tel_1" value="<?php echo $tel1[0]?>" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
                <input type="text" name="tel_2" value="<?php echo $tel1[1]?>" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
                <input type="text" name="tel_3" value="<?php echo $tel1[2]?>" maxlength="4" size="4" class="form-control">
                <div class="invalid-feedback">
                  전화번호를 입력해주세요.
                </div>
              </div><!-- /.form-inline -->
            </div>
        	<?php endif?>


          <?php if($d['member']['form_settings_location']):?>
          <div class="form-group">
            <label>거주지역<?php if($d['member']['form_settings_location_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <select class="form-control custom-select" name="location">
              <option value="">&nbsp;+ 선택하세요</option>
              <option value="" disabled>------------------</option>
              <?php
              $_tmpvfile = $g['path_module'].$m.'/var/location.txt';
              $_location=file($_tmpvfile);
              ?>
              <?php foreach($_location as $_val):?>
              <option value="<?php echo trim($_val)?>"<?php if(trim($_val)==$my['location']):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_val)?></option>
              <?php endforeach?>
            </select>
            <div class="invalid-feedback">
              거주지를 선택해 주세요.
            </div>
          </div>
        	<?php endif?>

          <?php if($d['member']['form_settings_job']):?>
          <div class="form-group">
            <label>직업<?php if($d['member']['form_settings_job_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <select class="form-control custom-select" name="job">
              <option value="">&nbsp;+ 선택하세요</option>
              <option value="" disabled>------------------</option>
              <?php
                $_tmpvfile = $g['path_module'].$m.'/var/job.txt';
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
        	<?php endif?>

        	<?php if($d['member']['form_settings_marr']):?>
          <div class="form-group">
            <label>결혼기념일<?php if($d['member']['form_settings_marr_required']):?> <span class="text-danger">*</span><?php endif?></label>
            <div class="form-inline">
              <select class="form-control custom-select" name="marr_1">
                <option value="">년도</option>
                <?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
                <option value="<?php echo $i?>"<?php if($i==$my['marr1']):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="marr_2">
                <option value="">월</option>
                <?php for($i = 1; $i < 13; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($my['marr2'],0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <select class="form-control custom-select ml-2" name="marr_3">
                <option value="">일</option>
                <?php for($i = 1; $i < 32; $i++):?>
                <option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($my['marr2'],2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
                <?php endfor?>
              </select>
              <div class="invalid-feedback">
                결혼기념일을 입력해주세요.
              </div>
            </div><!-- /.form-inline -->
          </div>
        	<?php endif?>

          <?php if($d['member']['form_settings_add']):?>
          <?php $g['memberAddFieldSite'] = $g['path_var'].'site/'.$_HS['id'].'/member.add_field.txt'; ?>
    			<?php $_add = file_exists($g['memberAddFieldSite']) ? file($g['memberAddFieldSite']) : file($g['path_module'].'member/var/add_field.txt');?>
        	<?php foreach($_add as $_key):?>
        	<?php $_val = explode('|',trim($_key))?>
        	<?php if($_val[6]) continue?>
        	<?php $_myadd1 = explode($_val[0].'^^^',$my['addfield'])?>
        	<?php $_myadd2 = explode('|||',$_myadd1[1])?>

        	<div class="form-group">
            <label><?php echo $_val[1]?><?php if($_val[5]):?> <span class="text-danger">*</span><?php endif?></label>

          	<div class="">
            	<?php if($_val[2]=='text'):?>
            	<input type="text" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_myadd2[0]?>" <?php if($_val[5]):?> required<?php endif?>>
            	<?php endif?>
            	<?php if($_val[2]=='password'):?>
            	<input type="password" name="add_<?php echo $_val[0]?>" class="form-control" value="<?php echo $_myadd2[0]?>" <?php if($_val[5]):?> required<?php endif?>>
            	<?php endif?>
            	<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
            	<select name="add_<?php echo $_val[0]?>" class="form-control custom-select"<?php if($_val[5]):?> required<?php endif?>>
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
                <input type="radio" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"  name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>"<?php if(trim($_sval)==$_myadd2[0]):?> checked="checked"<?php endif?> class="custom-control-input">
                <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
              </div>
            	<?php endforeach?>
            	</div>
            	<?php endif?>
            	<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
            	<div class="shift">
            	<?php foreach($_skey as $_sval):?>
              <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"  name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>"<?php if(strstr($_myadd2[0],'['.trim($_sval).']')):?> checked="checked"<?php endif?> >
                <label class="custom-control-label" for="add_<?php echo $_val[0]?>_<?php echo trim($_sval)?>"><?php echo trim($_sval)?></label>
              </div>
            	<?php endforeach?>
            	</div>
            	<?php endif?>
            	<?php if($_val[2]=='textarea'):?>
            	<textarea name="add_<?php echo $_val[0]?>" rows="5" class="form-control" <?php if($_val[5]):?> required<?php endif?>><?php echo $_myadd2[0]?></textarea>
            	<?php endif?>
            </div>

          </div>
        	<?php endforeach?>
          <?php endif?>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary btn-block js-submit">
              <span class="not-loading">수정하기</span>
              <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 수정중 ...</span>
            </button>
          </div>
        </form>

        <?php if($d['member']['form_settings_avatar']):?>
        <aside class="edit-profile-avatar float-right">
          <dl class="form-group">
            <dt class="mb-2">프로필 사진</dt>
            <dd>
              <div data-toggle="avatar" role="button" class="position-relative rounded border">
                <img src="<?php echo getAvatarSrc($my['uid'],'200') ?>" width="200" height="200" alt="" class="">
                <i class="position-absolute fa fa-upload fa-3x" aria-hidden="true" data-toggle="tooltip" title="사진을 변경합니다." data-placement="right"></i>
              </div>
              <div class="mt-2">
              <?php if($my['photo']):?>
                <a class="btn btn-light btn-block" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=avatar_delete&amp;reload=Y" title="<?php echo $my['photo']?>" onclick="return hrefCheck(this,true,'정말로 삭제 하시겠습니까?');">
                  <i class="fa fa-trash fa-fw" aria-hidden="true"></i> 현재 사진삭제
                </a>
              <?php else: ?>

              <div class="text-center">
                <small class="text-muted">gif/jpg/png - 250*250픽셀 이상</small>
              </div>
              <?php endif?>
              </div>

              <form name="MbrPhotoForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
                <input type="hidden" name="r" value="<?php echo $r?>">
                <input type="hidden" name="m" value="<?php echo $m?>">
                <input type="hidden" name="a" value="avatar">
                <input type="file" name="upfile" id="rb-upfile-avatar" accept="image/gif, image/jpg, image/jpeg, image/png" class="d-none">
              </form>

              <form name="MbrCoverForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
                <input type="hidden" name="r" value="<?php echo $r?>">
                <input type="hidden" name="m" value="<?php echo $m?>">
                <input type="hidden" name="a" value="cover">
                <input type="file" name="upfile" id="rb-upfile-cover" accept="image/gif, image/jpg, image/jpeg, image/png" class="d-none">
              </form>

            </dd>
          </dl>
        </aside><!-- /.edit-profile-avatar -->
        <?php endif; ?>

      </div>


    <?php endif; ?>

  </div><!-- /.page-main -->
</div><!-- /.row -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>


<script>

var f = document.getElementById("memberForm");  //dom 선택자
var form = $('#memberForm');  //jquery 선택자

function sameCheck(obj,layer) {
	if (!obj.value)
	{
		eval('obj.form.check_'+obj.name).value = '0';
		getId(layer).innerHTML = '';
	}
	else
	{
    form.find('.form-control').removeClass('is-valid is-invalid')  //에러항목 초기화
		if (obj.name == 'email')
		{
			if (!chkEmailAddr(obj.value))
			{
				obj.form.check_email.value = '0';
				obj.focus();
				getId(layer).innerHTML = '이메일형식이 아닙니다.';
				return false;
			}
		}
		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&a=same_check&fname=' + obj.name + '&fvalue=' + obj.value + '&flayer=' + layer;
	}
}

$(function () {

  putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

  f.addEventListener('submit', function(event) {

    event.preventDefault();
    event.stopPropagation();

    form.find('.form-control').removeClass('is-invalid')  // 에러이력 초기화

  	if (f.check_nic.value == '0')
  	{
  		f.nic.classList.add('is-invalid')
  		f.nic.focus();
  		return false;
  	}

    <?php if($d['member']['form_settings_email_profile']&&$d['member']['form_settings_email_profile_required']):?>
    if (f.email_profile.value == '')
    {
      getId('select-email-profile').classList.add('was-validated');
      f.email_profile.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_settings_birth']&&$d['member']['form_settings_birth_required']):?>
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

    <?php if($d['member']['form_settings_sex']&&$d['member']['form_settings_sex_required']):?>
  	if (f.sex[0].checked == false && f.sex[1].checked == false)
  	{
      getId('radio-sex').classList.add('was-validated');
      f.sex[0].focus();
  		return false;
  	}
  	<?php endif?>

    <?php if($d['member']['form_settings_bio']&&$d['member']['form_settings_bio_required']):?>
  	if (f.bio.value == '')
  	{
      f.bio.classList.add('is-invalid');
  		f.bio.focus();
  		return false;
  	}
  	<?php endif?>

    <?php if($d['member']['form_settings_home']&&$d['member']['form_settings_home_required']):?>
  	if (f.home.value == '')
  	{
      f.home.classList.add('is-invalid');
  		f.home.focus();
  		return false;
  	}
  	<?php endif?>

    <?php if($d['member']['form_settings_tel']&&$d['member']['form_settings_tel_required']):?>
    if (f.tel_1.value == '')
    {
      f.tel_1.classList.add('is-invalid');
      f.tel_1.focus();
      return false;
    }
    if (f.tel_2.value == '')
    {
      f.tel_2.classList.add('is-invalid');
      f.tel_2.focus();
      return false;
    }
    if (f.tel_3.value == '')
    {
      f.tel_3.classList.add('is-invalid');
      f.tel_3.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_settings_location']&&$d['member']['form_settings_location_required']):?>
    if (f.location.value == '')
    {
      f.location.classList.add('is-invalid');
      f.location.focus();
      return false;
    }
    <?php endif?>

    <?php if($d['member']['form_settings_job']&&$d['member']['form_settings_job_required']):?>
  	if (f.job.value == '')
  	{
      f.job.classList.add('is-invalid');
  		f.job.focus();
  		return false;
  	}
  	<?php endif?>

    <?php if($d['member']['form_settings_marr']&&$d['member']['form_settings_marr_required']):?>
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

    //가입 추가항목 체크
    <?php if($d['member']['form_settings_add']):?>
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
    <?php endif?>

    $('.js-submit').attr("disabled",true);

    setTimeout(function(){
      getIframeForAction(f);
      f.submit();
    }, 500);

  });
})

</script>
