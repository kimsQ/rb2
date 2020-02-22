<?php
function getMDname($id)
{
	global $typeset;
	if ($typeset[$id]) return $typeset[$id];
	else return $id;
}
$typeset = array
(
	'_join.complete'=>'회원가입 완료',
	'_join.auth'=>'회원가입시 본인인증',
	'_pw.auth'=>'비밀번호 재설정 본인인증',
	'_settings.auth.email'=>'이메일 추가시 본인인증',
	'_settings.auth.phone'=>'휴대폰 추가시 본인인증',
);
$doc = $doc ? $doc : 'email';
$type = $type ? $type : '_join.complete';
?>

<?php getImport('codemirror','lib/codemirror',false,'css')?>
<?php getImport('codemirror','lib/codemirror',false,'js')?>
<?php getImport('codemirror','theme/'.$d['admin']['codeeidt'],false,'css')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/xml/xml',false,'js')?>
<?php getImport('codemirror','mode/javascript/javascript',false,'js')?>
<?php getImport('codemirror','mode/css/css',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/clike/clike',false,'js')?>
<?php getImport('codemirror','mode/php/php',false,'js')?>

<div class="row no-gutters">
	<div class="col-sm-4 col-md-3 col-xl-3 d-none d-sm-block sidebar" id="tab-content-list">

		<div id="accordion">
			<div class="card border-0">
				<div class="card-header p-0">
					<a class="d-block accordion-toggle muted-link<?php if($_SESSION['member_msgdoc_collapse']):?> collapsed<?php endif?>"
						data-toggle="collapse"
						onclick="sessionSetting('member_msgdoc_collapse','','','');"
						href="#emaildoc" aria-expanded="true">
						<i class="fa fa-envelope-o fa-fw"></i>
						이메일 본문 양식
					</a>
				</div>
				<div class="collapse<?php if(!$_SESSION['member_msgdoc_collapse']):?> show<?php endif?>" id="emaildoc" data-parent="#accordion">
					<div class="list-group list-group-flush">
						<?php $tdir = $g['path_module'].$module.'/doc/email/'?>
						<?php $dirs = opendir($tdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..')continue?>
						<?php $_type = str_replace('.txt','',$skin)?>
							<a href="<?php echo $g['adm_href']?>&amp;doc=email&amp;type=<?php echo $_type?>" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action <?php if($doc=='email' && $_type==$type):?>active<?php endif?> doc-style">
								<?php echo getMDname($_type)?>
								 <span class="badge badge-dark"><?php echo $_type?></span>
							</a>
						<?php endwhile?>
						<?php closedir($dirs)?>
					</div>
				</div><!-- /.collapse -->
			</div><!-- /.card -->

			<div class="card border-0">
				<div class="card-header p-0">
					<a class="d-block accordion-toggle muted-link<?php if($_SESSION['member_msgdoc_collapse']!='smsdoc'):?> collapsed<?php endif?>"
						data-toggle="collapse"
						onclick="sessionSetting('member_msgdoc_collapse','smsdoc','','');"
						href="#smsdoc" aria-expanded="true">
						<i class="fa fa-mobile fa-lg fa-fw"></i>
						휴대폰 문자 양식
					</a>
				</div>
				<div class="collapse<?php if($_SESSION['member_msgdoc_collapse']=='smsdoc'):?> show<?php endif?>" id="smsdoc" data-parent="#accordion">
					<div class="list-group list-group-flush">
						<?php $tdir = $g['path_module'].$module.'/doc/sms/'?>
						<?php $dirs = opendir($tdir)?>
						<?php while(false !== ($skin = readdir($dirs))):?>
						<?php if($skin=='.' || $skin == '..')continue?>
						<?php $_type = str_replace('.txt','',$skin)?>
							<a href="<?php echo $g['adm_href']?>&amp;doc=sms&amp;type=<?php echo $_type?>" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action <?php if($doc=='sms' && $_type==$type):?>active<?php endif?> doc-style">
								<?php echo getMDname($_type)?>
								 <span class="badge badge-dark"><?php echo $_type?></span>
							</a>
						<?php endwhile?>
						<?php closedir($dirs)?>
					</div>
				</div><!-- /.collapse -->
			</div><!-- /.card -->

		</div><!-- /#accordion -->

	</div>
	<div class="col-sm-8 col-md-9 ml-sm-auto col-xl-9" id="tab-content-view">

		<form class="card" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="msgdoc_regis">
			<input type="hidden" name="doc" value="<?php echo $doc?>">
			<input type="hidden" name="type" value="<?php echo $type?>">

			<div class="card-header page-body-header">
				<?php if ($doc=='email'): ?><i class="fa fa-envelope-o fa-fw"></i><?php else: ?><i class="fa fa-mobile fa-lg fa-fw"></i><?php endif; ?>
				<span><?php echo getMDname($type)?> <span class="badge badge-primary badge-pill">양식수정</span></span>
			</div>
			<div class="card-body">
				<div class="small text-muted">
					<ul class="pl-3">
						<li>내용에는 다음과 같은 치환문자를 사용할 수 있습니다.</li>
						<li>사이트명: <code>{SITE}</code> / 회원이름 : <code>{NAME}</code> / 닉네임 <code>{NICK}</code> / 아이디 <code>{ID}</code> / 이메일 <code>{EMAIL}</code> / 휴대폰 <code>{PHONE}</code>/ 가입일시 <code>{DATE}</code></li>
					</ul>
				</div>
				<!-- 에디터 -->
				 <div class="editor">
					 <?php if ($doc=='email'): ?>

							<div class="card">
								<div class="card-header pt-0" style="padding-left: 10px">
									<ul class="nav nav-tabs card-header-tabs" role="tablist">
		 						   <li class="nav-item">
		 						     <a class="nav-link active py-3" id="email-code-tab" data-toggle="tab" href="#email-code" role="tab" aria-controls="home" aria-selected="true">
											 <i class="fa fa-code fa-fw" aria-hidden="true"></i>
											 소스코드
										 </a>
		 						   </li>
		 						   <li class="nav-item">
		 						     <a class="nav-link py-3" id="email-preview-tab" data-toggle="tab" href="#email-preview" role="tab" aria-controls="profile" aria-selected="false">
											 <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
											 미리보기
										 </a>
		 						   </li>
		 						 </ul>
								</div>
								<div class="card-body tab-content p-0">
									<div class="tab-pane fade show active" id="email-code" role="tabpanel">
										<textarea name ="content" id="email-code-textarea" class="d-none form-control f13" rows="21"><?php echo htmlspecialchars(implode('',file($g['path_module'].$module.'/doc/'.$doc.'/'.$type.'.txt')))?></textarea>
									</div>
									 <div class="tab-pane fade" id="email-preview" role="tabpanel">
										 <?php
										 $email_header = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
										 $email_footer = implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
										 $_email_header = str_replace('{SITE}',$_HS['name'],$email_header); //사이트명
										 $_email_footer = str_replace('{SITE}',$_HS['name'],$email_footer); //사이트명
										 ?>
										 <?php echo $_email_header ?>
										 <div id="email-preview-content"></div>
										 <?php echo $_email_footer ?>
									 </div>
								</div>
								<div class="card-footer small text-muted">
									이메일 헤더/풋터 양식은 <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=admin#emailTemplate">시스템 환경설정</a>에서 지정할수 있습니다.
								</div>
							</div><!-- /.card -->

							<script>
								var editor_html = CodeMirror.fromTextArea(getId('email-code-textarea'), {
									mode: "application/x-httpd-php",
									indentUnit: 2,
									lineNumbers: true,
									matchBrackets: false,
									indentWithTabs: true
								});
							</script>

					<?php else: ?>

						<div class="card phone my-5" style="width: 35%">
							<div class="card-header d-flex justify-content-between align-items-center">
								<i class="fa fa-signal" aria-hidden="true"></i>
								SMS
								<i class="fa fa-battery-half" aria-hidden="true"></i>
							</div>
							<div class="card-body p-0">
								<textarea name ="content" class="form-control f13 py-3"  rows="3" onKeyUp="checkByte(this.form);"><?php echo htmlspecialchars(implode('',file($g['path_module'].$module.'/doc/'.$doc.'/'.$type.'.txt')))?></textarea>
							</div>
							<div class="card-footer">
								<small class="text-muted"><code id="HNSpnByte"></code> 80 바이트 이하로 입력하세요.</small>
							</div>
						</div>

						<div class="card">
							<div class="card-body p-3 small text-muted">
								<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i> 휴대폰 문자메시지(SMS) 발송을 위해서는 <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=admin">발송설정</a> 및 <a href="https://kimsq.com/blog/post/25" target="_blank">충전</a>이 필요합니다.
							</div>

						</div>

					 <?php endif; ?>

				</div>


				<!-- /에티터 -->
			</div><!-- /.card-body -->

			<div class="card-footer">
				<div class="form-row">
					<div class="col">
						<button type="submit" class="btn btn-outline-primary btn-block">수정</button>
					</div>
					<?php if(!$typeset[$type]):?>
					<div class="col">
						<button class="btn btn-outline-danger btn-block" onclick="delCheck('<?php echo $doc?>','<?php echo $type?>');" type="button">삭제</button>
					</div>
					<?php endif?>
				</div>
				<hr>

				<div class="card">
					<div class="card-header">
						새로 만들기
					</div>
					<div class="card-body">
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text"><?php echo $doc=='email'?'이메일':'SMS' ?> 양식</span>
							</div>
							<input type="text" name="newdoc" value="" size="15" class="form-control" placeholder="신규양식 이름..">
							<div class="input-group-append">
						    <button class="btn btn-outline-secondary" type="submit">신규 등록</button>
						  </div>
						</div>
						<small class="text-muted">
							이 양식으로 새로운 양식을 생성할 수 있습니다.
							 새로운 양식명 (영문소문자+숫자+_ 조합)을 입력하신 후 [신규등록] 버튼을 눌러주세요.
						</small>
					</div>
				</div><!-- /.card -->

				<?php if ($doc=='email'): ?>
				<div class="card">
					<div class="card-header">
						 이메일 헤더/풋터
					</div>
					<div class="card-body">
						<small class="text-muted">
							메일 헤더,풋터가 적용된 공통 메일 양식을 관리하려면 <a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=admin&front=main">시스템 모듈 > 환경설정 > 이메일 양식</a> 를 참고해 주세요.
						</small>
					</div>
				</div><!-- /.card -->
				<?php endif; ?>



			</div><!-- /.card-footer -->

		</form><!-- /.card -->
	</div>
</div>


<script type="text/javascript">

function showHTML() {
	$('#email-preview-content').html($('#email-code-textarea').val());
}

function checkByte(frm) {
	var totalByte = 0;
	var message = frm.content.value;
	for(var i =0; i < message.length; i++) {
		var currentByte = message.charCodeAt(i);
		if(currentByte > 128) totalByte += 2;
		else totalByte++;
	}
	document.getElementById("HNSpnByte").innerText = totalByte + " 바이트 /";
}

function ToolCheck(compo) {
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}

function delCheck(d,t) {
	if (confirm('정말로 삭제하시겠습니까?   '))
	{
		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=msgdoc_delete&doc='+ d +'&type=' + t;
	}
}

function saveCheck(f) {

	if (f.content.value == '')
	{
		$('.note-editable').focus();
      alert('내용을 입력해 주세요.       ');
      return false;
	}
	if (f.newdoc.value != '')
	{
		if (!chkIdValue(f.newdoc.value))
		{
			alert('양식명은 영문소문자/숫자/_ 만 사용가능합니다.      ');
			f.newdoc.value = '';
			f.newdoc.focus();
			return false;
		}
	}
}


$(document).ready(function() {

	putCookieAlert('msgdoc_result') // 실행결과 알림 메시지 출력

	$('[data-toggle=tooltip]').tooltip();

	$('#email-preview-tab').on('shown.bs.tab', function (e) {
		showHTML()
	})

});

</script>
