<?php

if ($layout) {

	$versionForLayout = $g['path_layout'].$layout.'/_var/_var.version.php';
	if (file_exists($versionForLayout)) {
		include $versionForLayout;
		include $g['path_core'].'function/rss.func.php';

		$lastest_version = trim(getUrlData($d['github']['lastest'].$g['wcache'],10));
		$current_version = $_SESSION['current_version']?$_SESSION['current_version']:$d['layout']['version'];
		$_current_version = str_replace('.','',$current_version);
		$_lastest_version = str_replace('.','',$lastest_version);

		$git_version = shell_exec('git --version');
	  $command_reset	= 'git reset --hard';
	  $command_pull	= 'git pull origin master';

		if ($_lastest_version-$_current_version > 0) $try_update = true;
		else $try_update = false;

		$sort	= $sort ? $sort : 'uid';
		$orderby= $orderby ? $orderby : 'desc';
		$recnum	= $recnum && $recnum < 201 ? $recnum : 20;
		$listque	= 'module="'.$module.'" and target="'.$layout.'"';

		$RCD = getDbArray($table['s_gitlog'],$listque,'*',$sort,$orderby,$recnum,$p);
		$NUM = getDbRows($table['s_gitlog'],$listque);
		$TPG = getTotalPage($NUM,$recnum);
		$_SESSION['current_version'] = '';

  }
}

?>

<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">

<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<div class="row no-gutters">
  <div class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar"><!-- 좌측영역 시작 -->
    <div class="card border-0 f14">
      <div class="card-header">
        <small>목록</small>
      </div>

      <div class="list-group list-group-flush">
        <?php $i=0?>
        <?php $dirs = opendir($g['path_layout'])?>
        <?php while(false !== ($tpl = readdir($dirs))):?>
				<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
        <?php $i++?>
        <a href="<?php echo $g['adm_href']?>&amp;layout=<?php echo $tpl?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if($layout==$tpl):?> active<?php endif?>">
          <?php echo getFolderName($g['path_layout'].$tpl)?></span>
          <span class="badge badge-<?php echo $theme=='_desktop/'.$tpl?'primary':'dark' ?> badge-pill"><?php echo $tpl?></span>
        </a>
        <?php endwhile?>
        <?php closedir($dirs)?>

      </div>

      <?php if(!$i):?>
      <div class="none">등록된 레이아웃이 없습니다.</div>
      <?php endif?>


    </div> <!-- 좌측 card 끝 -->
  </div>  <!-- 좌측 영역 끝 -->
  <div class="col-sm-8 col-md-8 ml-sm-auto col-xl-9">

    <?php if($layout):?>
    <div class="card rounded-0 border-0">

      <div class="card-header p-0 page-body-header">
        <ol class="breadcrumb rounded-0 mb-0 bg-transparent text-muted f13">
          <li class="breadcrumb-item">root</li>
          <li class="breadcrumb-item">layouts</li>
          <li class="breadcrumb-item"><?php echo $layout?></li>
        </ol>
      </div>

			<?php if (file_exists($versionForLayout)): ?>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#readme" data-toggle="tab" onclick="setCookie('moduleLayoutTab','readme',1);">
            안내문서
          </a>
        </li>

        <li class="nav-item editor">
          <a class="nav-link" href="#update" data-toggle="tab" onclick="setCookie('moduleLayoutTab','update','1');">
						<?php echo $try_update?'<i class="fa fa-circle text-primary f12 mr-1" aria-hidden="true"></i>':'' ?>
						업데이트
          </a>
        </li>
      </ul>
			<?php endif; ?>

      <div class="tab-content">

        <div class="tab-pane show active" id="readme" role="tabpanel" aria-labelledby="readme-tab">

          <?php if (is_file($g['path_layout'].$layout.'/README.md')): ?>
          <div class="markdown-body p-4 readme"><?php readfile($g['path_layout'].$layout.'/README.md')?></div>
          <?php else: ?>

            <div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
      			 <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
      				 <p>레이아웃 안내문서가 없습니다.</p>
      			 </div>
      		 </div>

          <?php endif; ?>

          <?php if (is_file($g['path_layout'].$layout.'/LICENSE')): ?>
          <div class="py-5 px-4">
            <h5>라이센스</h5>
            <textarea class="form-control" rows="10"><?php readfile($g['path_layout'].$layout.'/LICENSE')?></textarea>
          </div>
          <?php endif; ?>

        </div>

				<?php if (file_exists($versionForLayout)): ?>
        <div class="tab-pane pr-2" id="update" role="tabpanel" aria-labelledby="update-tab">

					<div class="p-4">

						<div class="media">
							<div class="align-self-center mr-4">
								<div class="rb-box">
									<i class="rb-icon kf kf-layout"></i><br>
									<i class="rb-name">layout</i>
								</div>
							</div>
						  <div class="media-body">
						    <strong ><?php echo $layout ?></strong> <?php echo $d['layout']['version'] ?>
								<?php echo $try_update?'':'<span class="badge badge-light ml-2">최신버전</span>' ?>
								<div class="f12 text-muted mb-2">
									선택된 레이아웃에 대한 업데이트 정보입니다.
								</div>
								<?php if ($try_update): ?>
								<?php if ($git_version): ?>
								<form name="updateForm" method="post" action="<?php echo $g['s']?>/" target="_action_frame_<?php echo $m?>">
									<input type="hidden" name="r" value="<?php echo $r?>">
									<input type="hidden" name="m" value="<?php echo $module?>">
									<input type="hidden" name="a" value="layout_update">
									<input type="hidden" name="current_version" value="<?php echo $current_version?>">
									<input type="hidden" name="lastest_version" value="<?php echo $lastest_version?>">
									<input type="hidden" name="layout" value="<?php echo $layout ?>">
									<input type="hidden" name="remote" value="<?php echo $d['github']['remote'] ?>">

									<button type="button" class="btn btn-outline-primary rounded-0"
									  data-toggle="modal" data-target="#modal-update-confirm" data-path="layouts">
										최신 버전 <?php echo $lastest_version ?> 업데이트
									</button>
								</form>
								<?php else: ?>
								<div class="alert alert-danger content-padded f14" role="alert">
									<strong>[git 설치필요]</strong> 버전관리를 위해 git 설치가 필요합니다. 호스팅 제공업체 또는 서버 관리자에게 요청해주세요.
								</div>
								<?php endif; ?>
								<?php else: ?>
								<button type="button" class="btn btn-light mb-2">
									최신 업데이트가 없습니다.
								</button>
								<?php endif; ?>
						  </div>
						</div>

						<?php if ($NUM): ?>
						<div class="update-info table-responsive mt-4">
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

						<?php if ($try_update): ?>
						<div class="mt-5">
							<p class="mb-2">
								<i class="fa fa-question-circle fa-lg"></i>
								<strong>업데이트 유의사항</strong>
							</p>

							<ul class="mb-0 list-unstyled text-muted small">
								<li>원격 업데이트는 레이아웃을 항상 최신의 상태로 유지할 수 있는 시스템입니다.</li>
								<li>직접 수정하거나 추가한 코드가 포함된 파일이 업데이트 내역에 포함되어 있을 경우, 해당사항이 덧씌워 지므로 업데이트 전에 레이아웃을 별도 백업 해주세요.</li>
							</ul>
						</div>
						<?php endif; ?>


					</div>

        </div><!-- /.tab-pane -->
				<?php endif; ?>

      </div><!-- /.tab-content -->



    <?php else:?>

      <div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
       <div class="">
         <i class="fa kf-layout fa-3x mb-3" aria-hidden="true"></i>
         <p>레이아웃을 선택해 주세요.</p>

         <ul class="list list-unstyled small">
          <li>레이아웃은 사이트의 외형을 변경할 수 있는 요소입니다.</li>
          <li>레이아웃설정은 사이트의 외형만 제어하며 내부시스템에는 영향을 주지 않습니다.</li>
        </ul>
       </div>
     </div>



    <?php endif?>

		</div>
  </div> <!-- 우측영역 끝 -->
</div> <!--.row -->

<div class="modal" id="modal-update-info" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
					레이아웃 업데이트 상세내역 <span class="badge badge-light"><?php echo $layout ?></span>
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


<script type="text/javascript">

putCookieAlert('layout_action_result') // 실행결과 알림 메시지 출력

$('.markdown-body').markdown();

$('#modal-update-confirm [data-act="submit"]').click(function(){
  $(this).attr('disabled', true );
  setTimeout(function(){
    $('[name="updateForm"]').submit();
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
