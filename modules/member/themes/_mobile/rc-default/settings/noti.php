<?php
$emailque= 'mbruid='.$my['uid'].' and d_verified<>0';
$RCD = getDbArray($table['s_mbremail'],$emailque,'*','uid','asc',0,1);

$NT_DATA = explode('|',$my['noticeconf']);
$nt_web = $NT_DATA[0];
$nt_email = $NT_DATA[1];
$nt_fcm = $NT_DATA[2];
$nt_modules = getArrayString($NT_DATA[3]);
$nt_members = getArrayString($NT_DATA[4]);
?>

<style>
.nt-label.badge-primary:before {
	content: 'ON'
}
.nt-label.badge-default:before {
	content: 'OFF'
}

</style>

<?php getImport('font-kimsq','css/font-kimsq',false,'css')?>

<div class="page center" id="page-main">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title" data-location="reload">
			<i class="fa fa-bell-o fa-fw mr-1 text-muted" aria-hidden="true"></i> 알림설정
		</h1>
	</header>

	<main class="content bg-faded">

		<form id="procForm" role="form" action="<?php echo $g['s']?>/" method="post">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="notification">
			<input type="hidden" name="a" value="notice_config_user">
			<input type="hidden" name="mobile" value="1">
			<input type="hidden" name="nt_web" value="<?php echo $nt_web ?>">
			<input type="hidden" name="nt_email" value="<?php echo $nt_email ?>">
			<input type="hidden" name="nt_fcm" value="<?php echo $nt_fcm ?>">
			<input type="hidden" name="reload" value="">

			<ul class="table-view bg-white mt-0 mb-0 animated fadeIn delay-1">
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
					<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-email">
						<span class="badge badge-<?php echo $nt_email=='1'?'primary badge-pill':'default badge-outline' ?>  nt-label" data-role="email"> </span>
						<i class="fa fa-envelope-o fa-fw mr-2 text-muted" aria-hidden="true"></i> 이메일 알림
					</a>
				</li>


				<?php if ($g['push_active']==1): ?>
				<li class="table-view-cell" id="push_setting" style="display: block">
					<a class="navigate-right" data-toggle="page" data-start="#page-main" href="#page-fcm">
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

<div class="page right" id="page-email">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
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


<div class="page right" id="page-fcm">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
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


<div id="popup-noti" class="popup zoom">
  <div class="popup-content">
    <header class="bar bar-nav bar-light bg-faded">
      <h1 class="title text-xs-left pl-3">
        <i class="fa fa-bell-o fa-fw" aria-hidden="true"></i>
        <span data-role="from"></span>
      </h1>
      <div class="btn pull-right">
        <span class="badge badge-default badge-inverted"><i class="fa fa-clock-o" aria-hidden="true"></i> </span>
        <span class="badge badge-default badge-inverted" data-role="d_regis"></span>
      </div>
    </header>

    <nav class="bar bar-standard bar-footer bg-faded d-none" data-role="not-referer">
      <button type="button" class="btn btn-secondary btn-block" data-history="back">닫기</button>
    </nav>


    <nav class="bar bar-standard bar-footer bg-faded" data-role="has-referer">
      <div class="row">
        <div class="col-xs-6">
          <button type="button" class="btn btn-secondary btn-block" data-history="back">닫기</button>
        </div>
        <div class="col-xs-6 p-l-0">
          <a href="" class="btn btn-primary btn-block" data-role="referer">내용확인</a>
        </div>
      </div>
    </nav>


    <div class="content">
      <p class="content-padded" data-role="message"></p>
    </div>
  </div>
</div>


<script>

$(function() {

	 var f = document.getElementById("procForm");
	 var form = $('#procForm')

	 putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

	//알림수신설정(웹알림)
	$('#nt_web').on('changed.rc.switch', function (event) {
		var handle = $(event.relatedTarget)
		var button = handle.closest('.switch')
		form.find('[name="reload"]').val(1);
		if (button.hasClass('active')){
			form.find('[name="nt_web"]').val('');
		} else {
			form.find('[name="nt_web"]').val(1);
		}
		getIframeForAction(f);
		f.submit();
	})

	//알림수신설정(이메일 알림)
	$('#nt_email').on('changed.rc.switch', function (event) {
		var handle = $(event.relatedTarget)
		var button = handle.closest('.switch')
		if (button.hasClass('active')){
			form.find('[name="nt_email"]').val(1);
		} else {
			form.find('[name="nt_email"]').val('');
		}
		getIframeForAction(f);
		f.submit();
	})

	// 알림 수신용 이메일 지정
	$('#page-email').find('.js-submit').tap(function() {
		var form = $('#page-email')
		var email_noti = form.find('[name=email_noti]').val();
		var act = 'save_config'
		var url = rooturl+'/?r='+raccount+'&m=member&a=settings_noti&act='+act+'&email_noti='+email_noti+'&mobile=1'
		$(this).attr('disabled',true)
		getIframeForAction();
		setTimeout(function(){
			frames.__iframe_for_action__.location.href = url;
		}, 300);
	});


	//알림수신설정(FCM 알림)
	$('#nt_fcm').on('changed.rc.switch', function (event) {
		var handle = $(event.relatedTarget)
		var button = handle.closest('.switch')
		if (button.hasClass('active')){
			form.find('[name="nt_fcm"]').val(1);
			$('#token_div').removeClass('d-none')
		} else {
			form.find('[name="nt_fcm"]').val('');
			$('#token_div').addClass('d-none')
		}
		getIframeForAction(f);
		f.submit();
	})

	//모듈별 차단설정
	$('.module_members').on('changed.rc.switch', function (event) {
		var handle = $(event.relatedTarget)
		var button = handle.closest('.switch')
		var mid = button.data('module')
		if (button.hasClass('active')){
			var url = rooturl+'/?r='+raccount+'&m=notification&a=notice_config_user&module_id='+mid+'&mobile=1'
		} else {
			var url = rooturl+'/?r='+raccount+'&m=notification&a=multi_delete_user&module_id='+mid+'&deltype=off_module&mobile=1'
		}
		console.log(url)
		getIframeForAction();
		frames.__iframe_for_action__.location.href = url;
	})

	$('#RequestPermission').click(function(event) {
    event.preventDefault();
    requestPermission()
  });
  $('.js-deleteToken').click(function(event) {
    event.preventDefault();
    deleteToken()
  });
	$('.js-sendTest').click(function(event) {
		event.preventDefault();
    var btn = $(this)
    btn.attr('disabled',true)
		var title = '<?php echo $_HS['name'] ?> 모바일에서 보낸 푸시알림'
    var message = '푸시알림이 정상적으로 수신되었습니다.'
    $.post(rooturl+'/?r='+raccount+'&m=notification&a=push_testonly',{
   		 mbruid : '<?php echo $my['uid'] ?>',
			 title : title,
       message : message
      },function(response){
       var result = $.parseJSON(response);
       var error=result.error;
       if (!error) {
         btn.attr('disabled',false)
         console.log('테스트 푸시알림가 수신 되었습니다.')
       }
     });
	});

});

</script>
