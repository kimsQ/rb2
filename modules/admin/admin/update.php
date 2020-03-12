<?php
include $g['path_core'].'function/rss.func.php';
include $g['path_module'].'market/var/var.php';
include $g['path_module'].$module.'/var/var.version.php';
$lastest_version = trim(getUrlData($d['github']['lastest'].$g['wcache'],10));
$current_version = $_SESSION['current_version']?$_SESSION['current_version']:$d['admin']['version'];
$_current_version = str_replace('.','',$current_version);
$_lastest_version = str_replace('.','',$lastest_version);
$git_version = shell_exec('git --version');
if ($_lastest_version-$_current_version > 0) $try_update = true;
else $try_update = false;

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 201 ? $recnum : 20;
$listque	= 'uid';

$RCD = getDbArray($table['s_gitlog'],$listque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_gitlog'],$listque);
$TPG = getTotalPage($NUM,$recnum);
$_SESSION['current_version'] = '';

if ($git_version ) {
	$_skip_worktree  = shell_exec('git ls-files -v | grep ^S');
	$skip_worktree = str_replace('S ', '', $_skip_worktree);
}

?>

<div id="update-body" class="p-4">
	<div class="media my-3">
		<div class="mr-3 align-self-center version">
			<span class=" kf-bi-01" style="font-size: 38px"> </span> <span class="h3 ml-2">Rb <code><?php echo $current_version?></code></span>
		</div>
		<div class="media-body f12 text-muted">
			원격 업데이트를 이용하시면 킴스큐Rb를 항상 최신의 상태로 유지할 수 있습니다. <br>패치 및 업데이트 내용에 따라서 업데이트를 진행해 주세요.
		</div>
	</div>
</div>

<form name="updateForm" method="post" action="<?php echo $g['s']?>/" target="_action_frame_admin" class="p-4">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="admin">
	<input type="hidden" name="a" value="update">
	<input type="hidden" name="remote" value="<?php echo $d['github']['remote'] ?>">
	<input type="hidden" name="current_version" value="<?php echo $current_version?>">
	<input type="hidden" name="lastest_version" value="<?php echo $lastest_version?>">

	<?php if ($try_update): ?>

		<?php if ($git_version): ?>
			<?php if (is_dir('./.git')): ?>
			<button type="button" data-toggle="modal" data-target="#modal-update-confirm" class="btn btn-primary">
				최신 <?php echo $lastest_version ?> 업데이트
			</button>
			<?php else: ?>
			<button type="button" data-act="gitinit" class="btn btn-outline-success mt-3">
				업데이트 환경 초기화
			</button>
			<?php endif; ?>
		<?php else: ?>
		<div class="alert alert-danger content-padded f14" role="alert">
			<strong>[git 설치필요]</strong> 버전관리를 위해 git 설치가 필요합니다. 호스팅 제공업체 또는 서버 관리자에게 요청해주세요.
		</div>
		<?php endif; ?>

	<?php else: ?>
	<div class="d-block text-muted my-2">최신 버전 입니다.</div>
	<?php endif; ?>

</form>

<?php if ($NUM): ?>
<div class="update-info table-responsive">
	<table class="table f13 text-center">
		<thead class="small text-muted">
			<tr>
				<th>버전</th>
				<th>적용일시</th>
				<th>상세내역</th>
			</tr>
		</thead>
		<tbody class="text-muted">

			<?php while($R=db_fetch_array($RCD)):?>
			<tr>
				<td>
					<?php if(getNew($R['d_regis'],12)):?><span class="rb-new mr-1"></span><?php endif?>
					<?php echo $R['version']?>
				</td>
				<td><?php echo getDateFormat($R['d_regis'],'Y년 m월 d일 H시 i분')?></td>
				<td>
					<button type="button" class="btn btn-light btn-sm"
						data-toggle="modal"
						data-target="#modal-update-info"
						data-uid="<?php echo $R['uid']?>">
						보기
					</button>
				</td>
			</tr>
			<?php endwhile?>

		</tbody>
	</table>

	<?php if($TPG>1):?>
	<nav class="my-4">
		<ul class="pagination justify-content-center">
			<script>getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
		</ul>
	</nav>
	<?php endif?>

</div>
<?php endif; ?>

<div class="p-4">
	<strong>유의사항</strong>
	<ul class="mt-2 mb-0 list-unstyled text-muted small">
		<li>원격 업데이트는 킴스큐의 기본 패키지 파일들을 항상 최신의 상태로 유지할 수 있는 시스템입니다.</li>
		<li><a href="<?php echo $d['github']['remote'] ?>" target="_blank">킴스큐 Rb 저장소</a> 의 master 브랜치의 최신 코드가 적용됩니다.</li>
		<li>수정하거나 추가한 코드가 있을 경우, 수정내역이 삭제되므로 업데이트 실행전 레이아웃 또는 테마를 별도저장 해주세요.</li>
	</ul>

	<hr>

	<strong class="d-block mt-4">업데이트에서 특정 파일을 제외하는 방법</strong>

	<ul class="mt-2 mb-0 list-unstyled text-muted small">
		<li>쉘(ssh)접속 후, 아래 명령어로 제외목록에 추가할 수 있습니다.</li>
	</ul>
	<dl class="row small mt-2 text-muted">
	  <dt class="col-2">제외목록에 추가</dt>
	  <dd class="col-9"><code>git update-index --skip-worktree [file]</code></dd>
		<dt class="col-2">제외목록에서 제외</dt>
		<dd class="col-9"><code>git update-index --no-skip-worktree [file]</code></dd>
	</dl>
	<?php if ($skip_worktree): ?>
	<div class="form-group mt-2">
		<label for="">업데이트에서 제외된 파일 <span class="badge badge-light">skip-worktree</span></label>
		<textarea class="form-control f13" rows="5" readonly><?php echo $skip_worktree ?></textarea>
	</div>
	<?php endif; ?>

</div>


<div class="modal" id="modal-update-info" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
					업데이트 상세내역
					<small class="ml-2 text-muted" data-role="version"></small>
				</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-muted">
				<div style="min-height:300px">
					<code class="f13" data-role="output"></code>
				</div>
				<div class="d-flex justify-content-between mt-3">
					<small class="text-muted" data-role="d_regis"></small>
					<small class="text-muted">작업자 : <span data-role="name"></span></small>
				</div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-update-confirm" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
					업데이트 전 유의사항
					<small class="ml-2 text-muted" data-role="version"></small>
				</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body f14">
				<div>
					<p>업데이트시 최신 코드가 적용됩니다.</p>
					<p><span class="badge badge-danger">주의</span> 기본 파일에서 수정 또는 추가한 코드가 있을 경우 해당내역이 삭제됩니다.</p>
					<p><span class="text-danger">업데이트 실행전 수정내역을 별도저장 해야 합니다.</span></p>
				</div>

				<?php if ($skip_worktree): ?>
				<div class="form-group mt-2">
					<label for="">업데이트에서 제외된 파일</label>
					<textarea class="form-control f13" rows="3" readonly><?php echo $skip_worktree ?></textarea>
				</div>
				<?php endif; ?>

      </div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
				<button type="button" class="btn btn-primary" data-act="submit">
					<span class="not-loading">
		        확인 했습니다
		      </span>
		      <span class="is-loading">
		        <span class="spinner-border spinner-border-sm mr-1" role="status"></span>
						 처리중...
		      </span>
				</button>
			</div>
    </div>
  </div>
</div>


<script>

putCookieAlert('system_update_result');

$('#modal-update-confirm [data-act="submit"]').click(function(){
  $(this).attr('disabled', true );
  setTimeout(function(){
    $('[name="updateForm"]').submit();
  }, 1000);
});

$('[data-act="gitinit"]').click(function(){
  $(this).attr( 'disabled', true );
  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=admin&a=gitinit',{
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;
          var msg=result.msg;
          if (error) {
            $.notify({message: msg},{type: 'default'});
            $(this).attr( 'disabled', false );
            return false
          } else {
            location.reload();
          }
        } else {
          $.notify({message: '다시 시도해 주세요.'},{type: 'default'});
          $(this).attr( 'disabled', false );
          return false
        }
      });
  }, 1000);
});

$('#modal-update-info').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var uid = button.attr('data-uid')
  var modal = $(this)
	$.post(rooturl+'/?r='+raccount+'&m=admin&a=get_updateData',{
		uid : uid
	 },function(response,status){
			if(status=='success'){
				var result = $.parseJSON(response);
				var version=result.version;
				var output=result.output;
				var name=result.name;
				var d_regis=result.d_regis;
				modal.find('[data-role="version"]').text(version);
				modal.find('[data-role="d_regis"]').text(d_regis);
				modal.find('[data-role="name"]').text(name);
				modal.find('[data-role="output"]').text(output);
			} else {
				$.notify({message: '다시 시도해 주세요.'},{type: 'danger'});
				return false
			}
		});
})

</script>
