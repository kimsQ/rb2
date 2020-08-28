<?php
function getMDname($id)
{
	global $typeset;
	if ($typeset[$id]) return $typeset[$id];
	else return $id;
}
$typeset = array
(
	'_opinion'=>'좋아요/싫어요',
	'_mention'=>'회원언급',
	'_new.post'=>'새글 등록',
	'_report'=>'게시물 신고'
);
$type = $type ? $type : '_opinion';
?>

<div class="row no-gutters">
	<div class="col-sm-4 col-md-3 col-xl-3 d-none d-sm-block sidebar" id="tab-content-list">

		<div class="card border-0">
			<div class="card-header">
				양식목록
			</div>
			<div class="collapse<?php if(!$_SESSION['member_msgdoc_collapse']):?> show<?php endif?>" id="notidoc">
				<div class="list-group list-group-flush">
					<?php $tdir = $g['path_module'].$module.'/var/noti/'?>
					<?php $dirs = opendir($tdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..')continue?>
					<?php $_type = str_replace('.php','',$skin)?>
						<a href="<?php echo $g['adm_href']?>&amp;type=<?php echo $_type?>" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action <?php if($_type==$type):?>active<?php endif?> doc-style pl-4">
							<?php echo getMDname($_type)?>
							 <span class="badge badge-dark"><?php echo $_type?></span>
						</a>
					<?php endwhile?>
					<?php closedir($dirs)?>
				</div>
			</div><!-- /.collapse -->
		</div><!-- /.card -->

	</div>
	<div class="col-sm-8 col-md-9 ml-sm-auto col-xl-9" id="tab-content-view">

		<form class="card border-0" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="notidoc_regis">
			<input type="hidden" name="type" value="<?php echo $type?>">

			<div class="card-header page-body-header">
				<?php if ($doc=='email'): ?><i class="fa fa-envelope-o fa-fw"></i><?php else: ?><i class="fa fa-bell-o fa-lg fa-fw"></i><?php endif; ?>
				<span><?php echo getMDname($type)?> <span class="badge badge-primary badge-pill">양식수정</span></span>
			</div>
			<div class="card-body">
				<?php
				$cfile = $g['path_var'].$module.'/noti/'.$type.'.php';
				$gfile = $g['path_module'].$module.'/var/noti/'.$type.'.php';
				if (is_file($cfile)) {
					include_once $cfile;
				} else {
					include_once $gfile;
				}
				?>
				<div class="card">
					<div class="card-header">
						<i class="fa fa-bell-o mr-1" aria-hidden="true"></i> 알림 메시지 편집
					</div>
					<div class="card-body" id="noti-msg">

						<div class="media">
						  <img class="mr-3" src="<?php echo $g['s'].'/files/avatar/0.svg' ?>" alt="회원 아바타" style="width: 100px">
						  <div class="media-body">

								<div class="form-group">
									<label class="sr-only">타이틀</label>
									<input type="text" class="form-control" name="noti_title" value="<?php echo $d['bbs']['noti_title'] ?>" placeholder="알림 제목을 입력해 주세요.">
									<small class="form-text text-muted">
									  회원이름 : <code>{MEMBER}</code> / 닉네임 <code>{NICK}</code> / 게시판명 <code>{BBS}</code>/ 좋아요(싫어요)  <code>{OPINION_TYPE}</code>
									</small>
								</div>
								<div class="form-group">
									<label class="sr-only">메세지 입력</label>
									<textarea name="noti_body" class="form-control" placeholder="알림내용을 입력해 주세요." rows="5"><?php echo $d['bbs']['noti_body'] ?></textarea>
									<small class="form-text text-muted">
										회원이름 : <code>{MEMBER}</code> / 게시판명 <code>{BBS}</code> / 게시물제목 <code>{SUBJECT}</code>
									</small>
								</div>
								<div class="form-group mb-0">
									<label>연결링크 버튼명</label>
									<input type="text" class="form-control" name="noti_button" value="<?php echo $d['bbs']['noti_button'] ?>" placeholder="버튼명을 입력해 주세요.">
								</div>

						  </div>
						</div>
					</div>

					<div class="card-footer">
						<?php if ($type=='_opinion'): ?>
							<dl class="row small text-muted mb-0">
								<dt class="col-2">발송시점</dt>
								<dd class="col-10">게시물에 좋아요(싫어요)를 추가(취소) 시</dd>
								<dt class="col-2">수신대상</dt>
								<dd class="col-10">게시물 등록회원</dd>
							<dl>
						<?php endif; ?>

						<?php if ($type=='_new.post'): ?>
							<dl class="row small text-muted mb-0">
								<dt class="col-2">발송시점</dt>
								<dd class="col-10">게시판 신규 게시물 등록시</dd>
								<dt class="col-2">수신대상</dt>
								<dd class="col-10">게시판 관리자</dd>
							<dl>
						<?php endif; ?>

						<?php if ($type=='_report'): ?>
							<dl class="row small text-muted mb-0">
								<dt class="col-2">발송시점</dt>
								<dd class="col-10">게시물 신고시</dd>
								<dt class="col-2">수신대상</dt>
								<dd class="col-10">게시판 관리자</dd>
							<dl>
						<?php endif; ?>

						<?php if ($type=='_new.notice'): ?>
							<dl class="row small text-muted mb-0">
								<dt class="col-2">발송시점</dt>
								<dd class="col-10">게시판 공지글 등록시</dd>
								<dt class="col-2">수신대상</dt>
								<dd class="col-10">알림수신을 허용한 전체회원</dd>
							<dl>
						<?php endif; ?>

						<?php if ($type=='_mention'): ?>
							<dl class="row small text-muted mb-0">
								<dt class="col-2">발송시점</dt>
								<dd class="col-10">게시글에 회원언급 등록시</dd>
								<dt class="col-2">수신대상</dt>
								<dd class="col-10">언급된 회원(들)</dd>
							<dl>
						<?php endif; ?>

					</div>

				</div><!-- /.card -->

			</div><!-- /.card-body -->

			<div class="card-footer">
				<div class="form-row">
					<div class="col">
						<button type="submit" class="btn btn-outline-primary btn-block">수정</button>
					</div>
				</div>


			</div><!-- /.card-footer -->

		</form><!-- /.card -->
	</div>
</div>


<script type="text/javascript">


function saveCheck(f) {

	if (f.content.value == '')
	{
		$('.note-editable').focus();
      alert('내용을 입력해 주세요.       ');
      return false;
	}
}


$(document).ready(function() {

	putCookieAlert('msgdoc_result') // 실행결과 알림 메시지 출력

	$('[data-toggle=tooltip]').tooltip();


});

</script>
