<?php
function getMDname($id)
{
	global $typeset;
	if ($typeset[$id]) return $typeset[$id];
	else return $id;
}
$typeset = array
(
	'_join'=>'회원가입',
	'_settings_account_pw'=>'비밀번호 변경',
	'_settings_account_id'=>'아이디 변경'
);
$type = $type ? $type : '_join';
?>

<div class="row no-gutters">
	<div class="col-sm-4 col-md-3 col-xl-3 d-none d-sm-block sidebar" id="tab-content-list">

		<div class="card">
			<div class="card-header">
				양식목록
			</div>
			<div class="list-group list-group-flush">
				<?php $tdir = $g['path_module'].$module.'/var/noti/'?>
				<?php $dirs = opendir($tdir)?>
				<?php while(false !== ($skin = readdir($dirs))):?>
				<?php if($skin=='.' || $skin == '..')continue?>
				<?php $_type = str_replace('.php','',$skin)?>
					<a href="<?php echo $g['adm_href']?>&amp;doc=noti&amp;type=<?php echo $_type?>" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action <?php if($_type==$type):?>active<?php endif?> doc-style pl-4">
						<?php echo getMDname($_type)?>
						 <span class="badge badge-dark"><?php echo $_type?></span>
					</a>
				<?php endwhile?>
				<?php closedir($dirs)?>
			</div>
		</div><!-- /.card -->

	</div>
	<div class="col-sm-8 col-md-9 ml-sm-auto col-xl-9" id="tab-content-view">

		<form class="card" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="msgdoc_regis">
			<input type="hidden" name="doc" value="<?php echo $doc?>">
			<input type="hidden" name="type" value="<?php echo $type?>">

			<div class="card-header">
				<?php if ($doc=='email'): ?><i class="fa fa-envelope-o fa-fw"></i><?php else: ?><i class="fa fa-bell-o fa-lg fa-fw"></i><?php endif; ?>
				<span><?php echo getMDname($type)?> <span class="badge badge-primary badge-pill">양식수정</span></span>
			</div>
			<div class="card-body">
				<div class="small text-muted">
					<ul class="pl-3">
						<li>내용에는 다음과 같은 치환문자를 사용할 수 있습니다.</li>
						<li>사이트명: <code>{SITE}</code> / 회원이름 : <code>{MEMBER}</code> / 닉네임 <code>{NICK}</code> / 게시판명 <code>{BBS}</code> / 게시물제목 <code>{SUBJECT}</code></li>
					</ul>
				</div>
				<?php include_once $g['path_module'].$module.'/var/noti/'.$type.'.php'; ?>
				<div class="card w-75">
					<div class="card-header">
						<i class="fa fa-bell-o mr-1" aria-hidden="true"></i> 알림 메시지 편집
					</div>
					<div class="card-body" id="noti-msg">

						<div class="media">
						  <img class="mr-3" src="/_var/avatar/0.svg" alt="회원 아바타" style="width: 100px">
						  <div class="media-body">

								<div class="form-group">
									<label class="sr-only">타이틀</label>
									<input type="url" class="form-control" name="join_notice_title" value="<?php echo $d['member']['noti_title'] ?>" placeholder="알림 제목을 입력해 주세요.">
								</div>
								<div class="form-group">
									<label class="sr-only">메세지 입력</label>
									<textarea name="join_notice_msg" class="form-control" placeholder="알림내용을 입력해 주세요." rows="5"><?php echo $d['member']['noti_body'] ?></textarea>
								</div>
								<div class="form-group mb-0">
									<label>연결링크 버튼명</label>
									<input type="text" class="form-control" name="join_notice_button" value="<?php echo $d['member']['noti_button'] ?>" placeholder="버튼명을 입력해 주세요.">
								</div>

						  </div>
						</div>

					</div>
				</div><!-- /.card -->

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

			</div><!-- /.card-footer -->

		</form><!-- /.card -->
	</div>
</div>


<script type="text/javascript">


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


});

</script>
