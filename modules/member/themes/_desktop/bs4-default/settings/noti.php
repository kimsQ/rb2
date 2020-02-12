<?php
$emailque= 'mbruid='.$my['uid'].' and d_verified<>0';
$RCD = getDbArray($table['s_mbremail'],$emailque,'*','uid','asc',0,1);

$NT_DATA = explode('|',$my['noticeconf']);
$nt_web = $NT_DATA[0];
$nt_email = $NT_DATA[1];
$nt_fcm = $NT_DATA[2];
$nt_modules = getArrayString($NT_DATA[3]);
$nt_members = getArrayString($NT_DATA[4]);

$phone_que = 'mbruid='.$my['uid'].' and device="phone"';
$tablet_que = 'mbruid='.$my['uid'].'  and device="tablet"';
$desktop_que = 'mbruid='.$my['uid'].' and device="desktop"';

$PTK = getDbData($table['s_iidtoken'],$phone_que,'*');
$TTK = getDbData($table['s_iidtoken'],$tablet_que,'*');
$DTK = getDbData($table['s_iidtoken'],$desktop_que,'*');

?>
<?php getImport('font-kimsq','css/font-kimsq',false,'css')?>

<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
  <nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>
  <div class="col-9 page-main">

    <div class="subhead mt-0">
      <h2 class="subhead-heading">알림 관리</h2>
    </div>

    <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
    <?php include_once $g['dir_module_skin'].'_lock.php'?>
    <?php else: ?>

    <p>알림을 수신하면 웹 사이트내의 정보는 물론 회원님이 언급되거나 관련된 정보들을 실시간으로 받아보실 수 있습니다.</p>

    <div id="save-config">

      <form name="procForm" action="<?php echo $g['s']?>/" method="post">
  			<input type="hidden" name="r" value="<?php echo $r?>">
  			<input type="hidden" name="m" value="notification">
  			<input type="hidden" name="a" value="notice_config_user">

        <div class="card mb-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            사이트 알림
  					<div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
  						<label class="btn <?php if($nt_web==''):?>btn-primary active<?php else:?>btn-light<?php endif?>" onclick="btnCheck(this);">
  							<input type="radio"  value="" name="nt_web"<?php if($nt_web==''):?> checked<?php endif?> id="nt_web" autocomplete="off"> ON
  						</label>
  						<label class="btn <?php if($nt_web=='1'):?>btn-secondary active<?php else:?>btn-light<?php endif?>" onclick="btnCheck(this);">
  							<input type="radio" value="1" name="nt_web"<?php if($nt_web=='1'):?> checked<?php endif?> id="nt_web_1" autocomplete="off"> OFF
  						</label>
  					</div>
          </div>

          <?php if ($nt_web==''): ?>
          <ul class="list-group list-group-flush">
    				<li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="media w-75">
                <i class="fa fa-envelope-o fa-fx mr-4 fa-2x text-muted align-self-center" aria-hidden="true"></i>
                <div class="media-body">
                  이메일 알림
                  <div class="input-group mt-1">
                    <select class="form-control custom-select" name="email_noti">
                      <option value="">사용안함</option>
                      <?php while($R=db_fetch_array($RCD)):?>
                      <option value="<?php echo $R['email'] ?>"<?php echo ($my['email_noti']==$R['email'])?' selected':'' ?>>
                        <?php echo $R['email'] ?>
                      </option>
                      <?php endwhile?>
                    </select>
                    <div class="invalid-tooltip">
                      이메일을 저장해 주세요.
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary js-submit" type="button">
                        <span class="not-loading">저장</span>
                        <span class="is-loading">저장중..</span>
                      </button>
                    </div>
                  </div>
                  <small class="form-text text-muted mt-2">
                    알림발송시 지정된 이메일로도 알림내용이 발송됩니다.<br>
                    <a href="<?php echo $g['url_reset']?>&amp;page=email">이메일 관리</a>에서 추가 할수있으며, 본인인증된 메일만 추가할 수 있습니다.
                  </small>
                </div>
              </div>
              <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons" id="nt_email" data-email="<?php echo $my['email_noti']?>">
                <label class="btn <?php if($nt_email=='1'):?>btn-primary active<?php else:?>btn-light<?php endif?>">
                  <input type="radio" value="1" name="nt_email"<?php if($nt_email=='1'):?> checked<?php endif?> autocomplete="off" id="nt_email_1" <?php echo $my['email_noti']?'':'disabled'?>> ON
                </label>
                <label class="btn <?php if($nt_email==''):?>btn-secondary active<?php else:?>btn-light<?php endif?>">
                  <input type="radio" value="" name="nt_email"<?php if($nt_email==''):?> checked<?php endif?>  autocomplete="off" id="nt_email_0"> OFF
                </label>
              </div>
    				</li>

            <?php if ($g['push_active']==1): ?>
            <li class="list-group-item" id="permission_div" style="display: none">
              <div class="w-100">
                <div class="media w-100">
                  <i class="fa fa-bolt mr-3 fa-fw fa-2x text-muted align-self-center" aria-hidden="true"></i>
                  <div class="media-body">
                    푸시 알림 <span class="badge badge-pill badge-light"></span>
                    <small class="d-block note mt-2 pr-3">
                      데스크탑 푸시알림을 수신하면 공지사항은 물론 회원님이 게시글에 대한 피드백 또는 내가 언급된 글에 대한 정보들을 실시간으로 받아보실 수 있습니다.
                    </small>
                  </div>
                  <button class="btn btn-light" id="RequestPermission">권한요청</button>
                </div>
              </div>
            </li>

            <li class="list-group-item" id="push_setting" style="display: none">
              <div class="media w-100">
                <i class="fa fa-bolt mr-3 fa-fw fa-2x text-muted align-self-center" aria-hidden="true"></i>
                <div class="media-body">
                  푸시 알림 <span class="badge badge-pill badge-light"></span>
                  <small class="d-block note mt-2 pr-3">
                    알림발송시 푸시 알림으로 알림내용이 발송됩니다.
                  </small>
                </div>
                  <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons" id="nt_fcm">
                    <label class="btn <?php if($nt_fcm=='1'):?>btn-primary active<?php else:?>btn-light<?php endif?>">
                      <input type="radio" value="1" name="nt_fcm"<?php if($nt_fcm=='1'):?> checked<?php endif?> autocomplete="off" id="nt_fcm_1"> ON
                    </label>
                    <label class="btn <?php if($nt_fcm==''):?>btn-secondary active<?php else:?>btn-light<?php endif?>">
                      <input type="radio" value="" name="nt_fcm"<?php if($nt_fcm==''):?> checked<?php endif?> autocomplete="off" id="nt_fcm_0"> OFF
                    </label>
                  </div>
                </div>
              </li>

            <li class="list-group-item" id="push_disabled" style="display: none">
              <div class="media w-100">
                <span class="fa-stack fa-lg align-self-center text-muted mr-3">
                  <i class="fa fa-bolt fa-stack-1x"></i>
                  <i class="fa fa-ban fa-stack-2x"></i>
                </span>
                <div class="media-body">
                  푸시 알림 <span class="badge badge-pill badge-light text-danger align-text-top">차단됨</span>
                  <small class="d-block note mt-2 pr-3">
                    알림발송이 차단 되었습니다. 상태를 해제하려면 브라우저의 설정변경이 필요합니다.
                    <a class="ml-1" href="chrome://settings/content/notifications" target="_blank">자세히보기</a>
                  </small>
                </div>
              </div>
    				</li>
            <?php elseif ($g['push_active']==2): ?>
            <li class="list-group-item">
              <div class="media w-100">
                <i class="fa fa-bolt mr-3 fa-fw fa-2x text-muted align-self-center" aria-hidden="true"></i>
                <div class="media-body">
                  푸시 알림 <span class="badge badge-pill badge-light text-muted align-text-top">점검중</span>
                  <small class="d-block note mt-2 pr-3 text-danger">
                    푸시알림을 위한 연결정보가 없습니다. 관리자에게 문의하세요.
                  </small>
                </div>
            </div>
            </li>
            <?php else: ?>
            <li class="list-group-item">
              <div class="media w-100">
                <i class="fa fa-bolt mr-3 fa-fw fa-2x text-muted align-self-center" aria-hidden="true"></i>
                <div class="media-body">
                  푸시 알림 <span class="badge badge-pill badge-light text-muted align-text-top">미지원</span>
                  <small class="d-block note mt-2 pr-3">
                    푸시알림이 지원되지 않는 브라우저 입니다.<br>지원 브라우저 : 크롬(Chrome), 파이어폭스(Firefox)
                  </small>
                </div>
            </div>
            </li>
            <?php endif; ?>
          </ul>

          <?php else: ?>

          <div class="card-block p-5 note text-center">
            알림이 꺼져서 소식을 받을 수 없습니다.<br>알림을 켜서 글, 댓글, 나를 언급한 글 등 중요알림을 받아보세요.
          </div>

          <?php endif; ?>
        </div>

        <?php if ($nt_web==''): ?>

          <?php if ($nt_fcm=='1'): ?>
          <div class="card" id="token_div" style="display: none;" class="mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>
                인스턴스 토큰
                <i class="fa fa-question-circle-o" aria-hidden="true" role="button"
                data-toggle="popover" title="인스턴스 ID 토큰"
                data-content="<span class='text-muted f12'>처음 시작할 때 클라이언트 앱 인스턴스에 대한 등록 토큰이 생성됩니다.
                Instance ID는 앱의 인스턴스마다의 고유한 값입니다.<br><br>[ 다음과 같은 경우에 토큰은 변경됩니다. ]<br>
                - 인스턴스 ID를 삭제할 경우<br>- 앱이 새 기기에서 복원된 경우<br>- 사용자가 앱을 제거/재설치한 경우<br>- 사용자가 앱 데이터를 초기화한 경우</span>
                ">
                </i>
              </span>
              <button class="btn btn-light btn-sm js-sendTest"
                data-toggle="popover" title="푸시알림 테스트"
                data-content="<span class='text-muted f12'>등록된 토큰을 기반으로 데스크탑과 모바일로<br>푸시알림 메시지가 각각 발송됩니다.<br>알림이 수신된다면 정상적으로 셋팅된 것입니다.<br><br>알림이 수신되지 않는다면 토큰을 <mark>재발급</mark> 해주세요. </span>">
                 <span class="not-loading">나에게 푸시알림 보내기</span>
                 <span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 보내는중 ...</span>
              </button>
            </div>
            <div class="card-body">

              <div class="media">
                <span class="mr-3 text-center">
                  <i class="fa fa-desktop fa-3x align-self-center fa-border text-muted" aria-hidden="true"></i><br>
                  <span class="mt-3 f12 text-muted">데스크탑 전용</span>
                </span>
                <div class="media-body">
                  <p class="mb-2" style="word-break: break-all;">
                    <span class="token note"></span>
                  </p>

                  <div class="d-flex justify-content-between">
                    <div>
                      <span class="badge badge-pill badge-secondary"><?php echo $DTK['browser'] ?> <?php echo $DTK['version'] ?></span>
                      <span class="badge badge-pill badge-light">
                        등록일시 : <?php echo getDateFormat($DTK['d_update']?$DTK['d_update']:$DTK['d_regis'],'Y.m.d H:i')?>
                      </span>
                    </div>
                    <button class="btn btn-light btn-sm js-deleteToken">
                      <i class="fa fa-refresh fa-fw" aria-hidden="true"></i>
                      재발급
                    </button>
                  </div><!-- /.d-flex -->

                </div>
              </div>

              <hr>

              <div class="media">
                <span class="mr-3 text-center">
                  <i class="fa fa-mobile fa-3x fa-border text-muted" aria-hidden="true" style="width: 70px"></i><br>
                  <span class="mt-3 f12 text-muted">스마트폰 전용</span>
                </span>
                <div class="media-body align-self-center">
                  <?php if ($PTK['token']): ?>
                  <p class="mb-2" style="word-break: break-all;">
                    <span class="note"><?php echo $PTK['token'] ?></span>
                  </p>

                  <div class="d-flex justify-content-between">
                    <div>
                      <span class="badge badge-pill badge-secondary"><?php echo $PTK['browser'] ?> <?php echo $PTK['version'] ?></span>
                      <span class="badge badge-pill badge-light">
                        등록일시 : <?php echo getDateFormat($PTK['d_update']?$PTK['d_update']:$PTK['d_regis'],'Y.m.d H:i')?>
                      </span>
                    </div>
                    <div>
                      <span class="badge badge-light">재발급은 스마트폰에서만 지원됩니다.</span>
                    </div>
                  </div><!-- /.d-flex -->

                  <?php else: ?>
                  <div class="d-flex justify-content-between mb-4">
                    <span class="note">저장된 토큰이 없습니다.</span>
                    <div>
                      <span class="badge badge-light">발급은 스마트폰에서만 가능합니다.</span>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>

              <hr>

              <div class="media">
                <span class="mr-3 text-center">
                  <i class="fa fa-tablet fa-3x fa-border text-muted" aria-hidden="true" style="width: 70px"></i><br>
                  <span class="mt-3 f12 text-muted">태블릿 전용</span>
                </span>
                <div class="media-body align-self-center">
                  <?php if ($TTK['token']): ?>
                  <p class="mb-2" style="word-break: break-all;">
                    <span class="note"><?php echo $TTK['token'] ?></span>
                  </p>

                  <div class="d-flex justify-content-between">
                    <div>
                      <span class="badge badge-pill badge-secondary"><?php echo $TTK['browser'] ?> <?php echo $TTK['version'] ?></span>
                      <span class="badge badge-pill badge-light">
                        등록일시 : <?php echo getDateFormat($TTK['d_update']?$TTK['d_update']:$TTK['d_regis'],'Y.m.d H:i')?>
                      </span>
                    </div>
                    <div>
                      <span class="badge badge-light">재발급은 스마트폰에서만 지원됩니다.</span>
                    </div>
                  </div><!-- /.d-flex -->

                  <?php else: ?>
                  <div class="d-flex justify-content-between mb-4">
                    <span class="note">저장된 토큰이 없습니다.</span>
                    <div>
                      <span class="badge badge-light">발급은 태블릿에서만 가능합니다.</span>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>

            </div>
            <div class="card-footer">
              <span class="note">
                인스턴스 토큰은 푸시알림에 활용되며 기기별로 1개만 저장 됩니다.<br>
                접속기기가 변경되면 토큰 또한 변경되며, 변경된 토큰정보는 로그인 후 갱신저장 됩니다.<br>
                푸시알림이 수신되지 않는다면, 토큰 '재발급'을 시도해 보세요. 알림 메시지를 받았다면 정상 입니다.
              </span>
            </div>
          </div>
          <?php endif; ?>

          <div class="card my-3">
    				<div class="card-header">
    					모듈별 설정
    				</div>

            <ul class="list-group list-group-flush">
              <?php $_MODULES=getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
      				<?php while($_MD=db_fetch_array($_MODULES)):?>
              <li class="list-group-item justify-content-between list-group-item-action align-items-center<?php if(strstr($d['ntfc']['cut_modules'],'['.$_MD['id'].']')):?> d-none<?php else: ?> d-flex<?php endif?>">

                <div class="media w-75">
                  <i class="<?php echo $_MD['icon']?> fa-fw fa-2x mr-3 align-self-center text-muted"></i>
                  <div class="media-body">
                    <h5 class="mt-0"><?php echo $_MD['name']?> <span class="badge badge-pill badge-light align-text-top"><?php echo ucfirst($_MD['id'])?></span></h5>
                    <p class="note">내글에 댓글등록시, 좋아요/싫어요시</p>
                  </div>
                </div>

                <div class="btn-group btn-group-sm btn-group-toggle module_members" role="group" data-toggle="buttons" data-module="<?php echo $_MD['id']?>">
                  <button type="button" class="btn btn-<?php if(strstr($NT_DATA[3],'['.$_MD['id'].']') === false):?>primary active<?php else: ?>light<?php endif?>" data-act="on">ON</button>
                  <button type="button" class="btn btn-<?php if(strstr($NT_DATA[3],'['.$_MD['id'].']')):?>secondary active<?php else: ?>light<?php endif?>" data-act="off">OFF</button>
                </div>

              </li>
              <?php endwhile?>
            </ul>
    			</div><!-- /.card -->


  			<div class="card mb-3">
  				<div class="card-header">
            <i class="fa fa-ban fa-fw fa-lg" aria-hidden="true"></i>
  					알림발송이 차단된 회원
  				</div>

          <ul class="list-group list-group-flush">
            <?php $_i=0;foreach($nt_members['data'] as $_md):?>
            <?php $_R=getDbData($table['s_mbrdata'],'memberuid='.$_md,'*')?>
            <li class="list-group-item d-flex justify-content-between list-group-item-action align-items-center">

              <div class="media">
								<a class="mr-3" href="<?php echo getProfileLink($_R['memberuid']) ?>"
									data-toggle="getMemberLayer"
									data-mbruid="<?php echo $_R['memberuid'] ?>">
									<img class="rounded " src="<?php echo getAvatarSrc($_R['memberuid'],'36') ?>" alt="" width=36>
								</a>
								<div class="media-body">
									<h5 class="f14 mt-0 mb-1">
										<?php if($_R['name']):?>
										<a class="muted-link" href="<?php echo getProfileLink($_R['memberuid']) ?>"
				              data-toggle="getMemberLayer"
				              data-mbruid="<?php echo $_R['memberuid'] ?>">
				              <?php echo $_R['name']?> <span class="badge badge-pill badge-light align-text-top"><?php echo $_R['nic']?></span>
				            </a>
										<?php else: ?>
										<span class="badge badge-pill badge-light">시스템</span>
										<?php endif?>
									</h5>
                  <small><?php echo getDateFormat($_R['d_regis'],'Y.m.d')?> 가입</small>
								</div>
							</div>

              <a class="btn btn-light btn-sm" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=notification&amp;a=notice_config_user&amp;member_uid=<?php echo $_R['memberuid']?>" onclick="return hrefCheck(this,true,'정말로 해제하시겠습니까?');">
                해제
              </a>
            </li>
            <?php $_i++;endforeach?>
          </ul>

  				<?php if(!$nt_members['count']):?>
  				<div class="rb-none text-center p-5 text-muted f12">
  					차단된 회원이 없습니다.<br>
            <a href="<?php echo RW('mod=noti')?>">내 알림함</a> 에서 차단할 회원을 지정할 수 있습니다.
  				</div>
  				<?php endif?>
  			</div><!-- /.card -->
        <?php endif; ?>

  		</form>

    </div><!-- /#save-config -->


    <?php endif; ?>

  </div><!-- /.page-main -->
</div><!-- /.row -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>


<script>

var f = document.procForm;

$(function () {

  putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

  // 지정된 이메일이 없는 경우, 이메일 알림을 설정을 시도할 경우 에러출력
  $('#nt_email_1:disabled').parent('.btn').click(function() {
     $('[name="email_noti"]').addClass('is-invalid')
  });

  //알림설정 저장
  $('[data-toggle="buttons"]').find('[type="radio"]').change(function(){
    var btn_group = $(this).closest('.btn-group')
    var btn = $(this).closest('.btn')
    btn_group.find('.btn').removeClass('btn-primary').addClass('btn-light')
    btn.addClass('btn-primary').removeClass('btn-light')
    getIframeForAction(f);
  	f.submit();
   });

  // 이메일 저장
  $('#save-config').find('.js-submit').click(function() {
    var form = $('#save-config')
    var email_noti = form.find('[name=email_noti]').val();
    var act = 'save_config'
    var url = rooturl+'/?r='+raccount+'&m=member&a=settings_noti&act='+act+'&email_noti='+email_noti
    $(this).attr('disabled',true)
    getIframeForAction();
    frames.__iframe_for_action__.location.href = url;
  });

  //모듈별 차단설정
  $('.module_members').find('.btn').click(function() {
    var btn = $(this)
    var btn_group = btn.closest('.btn-group')
    var mid = btn_group.data('module')
    var act = btn.data('act')
    if (act=='on'){
      btn_group.find('.btn').removeClass('btn-secondary btn-primary').addClass('btn-light')
      btn.addClass('btn-primary').removeClass('btn-light')
      var url = rooturl+'/?r='+raccount+'&m=notification&a=notice_config_user&module_id='+mid
    } else {
      btn.addClass('btn-secondary').removeClass('btn-light')
      var url = rooturl+'/?r='+raccount+'&m=notification&a=multi_delete_user&module_id='+mid+'&deltype=off_module'
    }
    console.log(url)
    getIframeForAction();
    frames.__iframe_for_action__.location.href = url;
  });

  //게시물 목록에서 프로필 풍선(popover) 띄우기
	$('[data-toggle="getMemberLayer"]').popover({
		container: 'body',
		trigger: 'manual',
		html: true,
		content: function () {
			var uid = $(this).attr('data-uid')
			var mbruid = $(this).attr('data-mbruid')
			var type = 'popover'
			$.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileData',{
				 mbruid : mbruid,
				 type : type
				},function(response){
				 var result = $.parseJSON(response);
				 var profile=result.profile;
				 $('#popover-item-'+uid).html(profile);
			 });
			return '<div id="popover-item-'+uid+'" class="p-1">불러오는 중...</div>';
		}
	})
	.on("mouseenter", function () {
		var _this = this;
		$(this).popover("show");
		$(".popover").on("mouseleave", function () {
			$(_this).popover('hide');
		});
	}).on("mouseleave", function () {
		var _this = this;
		setTimeout(function () {
			if (!$(".popover:hover").length) {
				$(_this).popover("hide");
			}
		}, 30);
	});


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
    var popover = $('[data-toggle="popover"]')
    popover.popover('hide')
    btn.attr('disabled',true)
		var title = '<?php echo $_HS['name'] ?> 데스크탑에서 보낸 푸시알림'
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
         console.log('테스트 푸시알림이 수신 되었습니다.')
       }
     });
  });

  $('[data-toggle="popover"]').popover({
    trigger: 'hover',
    html : true
  })

})

</script>
