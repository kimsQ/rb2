<?php
$g['memberAgree1ForSite'] = $g['path_var'].'site/'.$r.'/member.agree1.txt';
$agree1File = file_exists($g['memberAgree1ForSite']) ? $g['memberAgree1ForSite'] : $g['dir_module'].'var/agree1.txt';

$g['memberAgree2ForSite'] = $g['path_var'].'site/'.$r.'/member.agree2.txt';
$agree2File = file_exists($g['memberAgree2ForSite']) ? $g['memberAgree2ForSite'] : $g['dir_module'].'var/agree2.txt';

$g['memberAgree3ForSite'] = $g['path_var'].'site/'.$r.'/member.agree3.txt';
$agree3File = file_exists($g['memberAgree3ForSite']) ? $g['memberAgree3ForSite'] : $g['dir_module'].'var/agree3.txt';

$g['memberAgree4ForSite'] = $g['path_var'].'site/'.$r.'/member.agree4.txt';
$agree4File = file_exists($g['memberAgree4ForSite']) ? $g['memberAgree4ForSite'] : $g['dir_module'].'var/agree4.txt';

$g['memberAgree5ForSite'] = $g['path_var'].'site/'.$r.'/member.agree5.txt';
$agree5File = file_exists($g['memberAgree5ForSite']) ? $g['memberAgree5ForSite'] : $g['dir_module'].'var/agree5.txt';
?>

<?php if ($d['member']['join_social'] && $skip!='socialLogin'): ?>
<header class="bar bar-nav bar-dark bg-primary px-0">
	<a class="icon icon-home pull-left p-x-1" role="button" href="<?php  echo RW(0) ?>"></a>
	<h1 class="title">회원가입</h1>
</header>
<main class="content bg-faded">

  <div class="content-padded mt-3">

		<?php if ($d['connect']['use_n']): ?>
		<button type="button" class="btn btn-lg btn-secondary btn-block btn-login btn-naver" data-connect="naver" role="button">
			네이버 계정으로 회원가입
		</button>
		<?php endif; ?>

		<?php if ($d['connect']['use_k']): ?>
		<button type="button" class="btn btn-lg btn-secondary btn-block btn-login btn-kakaotalk" data-connect="kakao" role="button">
			카카오 계정으로 회원가입
		</button>
		<?php endif; ?>

		<?php if ($d['connect']['use_g']): ?>
		<button type="button" class="btn btn-lg btn-secondary btn-block btn-login btn-google" data-connect="google" role="button">
			구글 계정으로 회원가입
		</button>
		<?php endif; ?>

		<?php if ($d['connect']['use_f']): ?>
		<button type="button" class="btn btn-lg btn-secondary btn-block btn-login btn-facebook" data-connect="facebook" role="button">
			페이스북 계정으로 회원가입
		</button>
		<?php endif; ?>

		<?php if ($d['connect']['use_i']): ?>
		<button type="button" class="btn btn-lg btn-secondary btn-block btn-login btn-instagram" data-connect="instagram" role="button">
			인스타그램 계정으로 회원가입
		</button>
		<?php endif; ?>

		<span class="section-divider" style="z-index: 1;"><span>또는</span></span>

		<a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&mod=join&skip=socialLogin" class="btn btn-lg btn-secondary btn-block" >
			일반 회원가입
		</a>

	</div>

</main>
<?php else: ?>
<form name="procForm" action="<?php echo $g['s']?>/" method="get">
  <input type="hidden" name="r" value="<?php echo $r?>">
  <input type="hidden" name="m" value="<?php echo $_m?>">
  <input type="hidden" name="front" value="<?php echo $front?>">
  <input type="hidden" name="mod" value="<?php echo $_GET['mod']?>">
  <input type="hidden" name="page" value="forms">

  <header class="bar bar-nav bar-dark bg-primary px-0">
  	<a class="icon icon-home pull-left p-x-1" role="button" href="<?php  echo RW(0) ?>"></a>
  	<h1 class="title">회원가입</h1>
  </header>
  <div class="bar bar-standard bar-header-secondary rb-step bg-white">
		<ul class="nav nav-inline">
      <li class="nav-item active">
        <span class="badge badge-pill badge-default">1</span>
		    <a class="nav-link">약관</a>
		  </li>
		  <li class="nav-item">
        <span class="badge badge-pill badge-default">2</span>
		    <a class="nav-link">아이디</a>
		  </li>
		  <li class="nav-item">
        <span class="badge badge-pill badge-default">3</span>
		    <a class="nav-link">비밀번호</a>
		  </li>
		  <li class="nav-item">
        <span class="badge badge-pill badge-default">4</span>
		    <a class="nav-link">이름</a>
		  </li>
			<li class="nav-item">
        <span class="badge badge-pill badge-default">5</span>
		    <a class="nav-link">이메일</a>
		  </li>
			<li class="nav-item">
        <span class="badge badge-pill badge-default">6</span>
		    <a class="nav-link">닉네임</a>
		  </li>
			<li class="nav-item">
        <span class="badge badge-pill badge-default">7</span>
		    <a class="nav-link">부가정보</a>
		  </li>
		</ul>
	</div>
  <footer class="bar bar-footer bar-light bg-faded">
    <button class="btn btn-secondary btn-block" type="button" disabled="true" id="next">다음단계로</button>
  </footer>

  <main class="content bg-faded">
    <div class="card card-full join-ageement m-b-2 animated fadeIn delay-1">
      <div class="card-header clearfix">
        <h4 class="card-title h5 pull-xs-left">이용약관</h4>
        <a href="#modal-docs" class="btn btn-secondary pull-xs-right" data-toggle="modal" data-title="이용약관" data-type="agreement">
          자세히보기
        </a>
      </div>
      <div class="card-block p-t-0">
        <textarea class="form-control" rows="4" id="agreement"><?php readfile($agree1File)?></textarea>
        <p>
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-agreement">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">위 내용을 확인 하였으며 이에 동의함</span>
          </label>
        </p>

      </div>
    </div><!-- /.card -->


    <div class="card card-full join-ageement m-b-2 animated fadeIn delay-1">
      <div class="card-header clearfix">
        <h4 class="card-title h5 pull-xs-left">개인정보 취급방침</h4>
        <a href="#modal-docs" class="btn btn-secondary pull-xs-right" data-toggle="modal" data-title="개인정보취급방침" data-type="privacy">
          자세히보기
        </a>
      </div>
      <div class="card-block p-t-0">
        <textarea class="form-control" rows="4" id="privacy"><?php readfile($agree2File)?><?php readfile($agree3File)?><?php readfile($agree4File)?><?php readfile($agree5File)?></textarea>
        <p>
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkbox-privacy">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">위 내용을 확인 하였으며 이에 동의함</span>
          </label>
        </p>
      </div>
    </div><!-- /.card -->
  </main>

</form>

<?php endif; ?>

<!-- Modal : 자세히보기 -->
<div id="modal-docs" class="modal">
  <header class="bar bar-nav bar-light bg-faded">
    <a class="icon icon-close pull-right" data-history="back" role="button"></a>
    <h1 class="title" data-role="title">문서제목</h1>
  </header>
  <div class="bar bar-standard bar-footer bar-light bg-faded">
    <button class="btn btn-secondary btn-block" data-history="back">닫기</button>
  </div>
  <div class="content">
    <p class="content-padded" data-role="docs">
    </p>
  </div>
</div>

<script type="text/javascript">

$('.custom-control-input').attr('checked', false); //  페이지 진입시에 체크박스 초기화

// 모두 체크해야 다음버튼이 활성화 됨
$(".custom-control-input").change(function(e) {
  if ($('#checkbox-agreement').prop('checked') && $('#checkbox-privacy').prop('checked')){
    $('#next').removeClass('btn-secondary').addClass('btn-primary').attr('disabled',false) // 버튼활성화 처리하고
    $('#next').click(function() { $('form[name="procForm"]').submit(); });  // 다음 버튼을 클릭하면 다음단계로 진행
  } else {
    $('#next').addClass('btn-secondary').removeClass('btn-primary').attr('disabled',true) // 모두 체크되지 않으면 다음버튼을 비활성 처리함
  }
});

// 자세히 보기 모달
var agreement_docs = $('#agreement').val().replace(/\n/g, '<br>')
var privacy_docs = $('#privacy').val().replace(/\n/g, '<br>')

$('#modal-docs').on('shown.rc.modal', function (event) {
  var button = $(event.relatedTarget)
  var type = button.data('type')
  $(this).find('.content').scrollTop(0);
  if (type == 'agreement') {
    $(this).find('[data-role="docs"]').html(agreement_docs)
  } else {
    $(this).find('[data-role="docs"]').html(privacy_docs)
  }
})

</script>
