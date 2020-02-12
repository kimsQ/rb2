<?php $package_step = $package_step ? $package_step : 1?>

<div id="modal-package-install">
	<div class="modal-body bg-white">

		<div class="p-3">
			<ul class="list-inline mb-0">
				<li class="list-inline-item<?php if($package_step==1):?> active<?php endif?>"><span class="badge badge-secondary">Step 1</span> <span><?php echo '패키지 안내'?></span></li>
				<li class="list-inline-item<?php if($package_step==2):?> active<?php endif?>"><span class="badge badge-secondary">Step 2</span> <span><?php echo '설치하기'?></span></li>
				<li class="list-inline-item<?php if($package_step==3):?> active<?php endif?>"><span class="badge badge-secondary">Step 3</span> <span><?php echo '완료'?></span></li>
			</ul>
		</div>

		<div class="tab-content">
			<?php if($package_step==1):?>
				<div id="tab1">
					<form name="_download_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data">
						<input type="hidden" name="r" value="<?php echo $r?>">
						<input type="hidden" name="m" value="<?php echo $module?>">
						<input type="hidden" name="a" value="download_package">
						<input type="hidden" name="package_step" value="<?php echo $package_step?>">

						<?php
							include $g['path_module'].$module.'/var/var.php';
							include $g['path_core'].'function/rss.func.php';
							$packageData = getUrlData($d['market']['url'].'&iframe=Y&page=client.project.package&pid='.$pid,10);
							$packageData = explode('[RESULT:',$packageData);
							$packageData = explode(':RESULT]',$packageData[1]);
							$packageData = $packageData[0];
							echo $packageData;
						?>
				</form>
			</div>
			<?php endif?>

			<?php if($package_step==2):?>
			<?php include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.php' ?>
			<div id="tab2">
				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-cube fa-3x"></i>
						<h4 class="text-center text-muted">
							패키지를 적용할 준비가<br>완료 되었습니다.
						</h4>
					</div>
					<div class="col-sm-8">
						<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" role="form">
							<input type="hidden" name="r" value="<?php echo $r?>">
							<input type="hidden" name="m" value="<?php echo $module?>">
							<input type="hidden" name="a" value="add_package">
							<input type="hidden" name="package_step" value="<?php echo $package_step?>">
							<input type="hidden" name="package_folder" value="<?php echo $package_folder?>">

							<div class="well">
								<div class="form-group form-row">
									<label for="" class="col-sm-3 control-label">패키지명</label>
									<div class="col-sm-9">
										<p class="form-control-static">
											<?php echo $d['package']['name']?>
										</p>
									</div>
								</div>
								<div class="form-group form-row">
									<label for="" class="col-sm-3 control-label">적용사이트</label>
									<div class="col-sm-8">
										<select name="siteuid" class="form-control">
											<option value="">신규생성 후 적용</option>
											<option value="">-------------------------------</option>
											<?php $_SITES_ALL = getDbArray($table['s_site'],'','*','gid','asc',0,1)?>
											<?php while($_R = db_fetch_array($_SITES_ALL)):?>
											<option value="<?php echo $_R['uid']?>"><?php echo $_R['name']?></option>
											<?php endwhile?>
										</select>
										<span class="help-block">운영중인 사이트에는 적용하지 마십시오.</span>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<a class="collapsed" data-toggle="collapse" href="#package-options" onclick="detailCheck();"><i class="fa fa-cog"></i> 설치옵션 및 세부내용<span class="pull-right"></span></a>
								</div>


								<div class="card-body collapse" id="package-options">
									<div class="form-group form-row">
										<label class="col-sm-3 control-label">설치옵션</label>
										<div class="col-sm-9">
											<?php foreach($d['package']['execute'] as $_key => $_val):?>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="ACT_<?php echo $_val[0]?>" value="1"<?php if($_val[2]):?> checked<?php endif?>>
													<?php echo $_val[1]?>
												</label>
											</div>
											<?php endforeach?>
										</div>
									</div>
									<?php if(is_file($g['path_tmp'].'app/'.$package_folder.'/_settings/readme.txt')):?>
									<div class="form-group form-row">
										<label class="col-sm-3 control-label">설치내용</label>
										<div class="col-sm-9">
											<?php readfile($g['path_tmp'].'app/'.$package_folder.'/_settings/readme.txt')?>
										</div>
									</div>
									<?php endif?>
								</div>


							</div>
						</form>
					</div>
				</div>
			</div>
			<?php endif?>

			<?php if($package_step==3):?>
			<div id="tab3">
				<div class="row">
					<div class="col-sm-4 text-center rb-icon">
						<i class="fa fa-home fa-3x"></i>
						<h4 class="text-center text-muted">
							설치가 완료 되었습니다.
						</h4>
					</div>
					<div class="col-sm-8">
						<div class="text-center">
							<br><br>
							<a href="<?php echo $g['s']?>/?r=<?php echo $siteid?>&amp;panel=Y" class="btn btn-primary btn-lg" target="_top">
								<i class="fa fa-share"></i> 사이트 접속하기
							</a>
							<br><br>
							<hr><?php echo sprintf('%s 패키지가<br><strong>%s</strong>에 설치 완료 되었습니다.',urldecode($package_name),urldecode($site_name))?>
						</div>
					</div>
				</div>
			</div>
			<?php endif?>

		</div>
	</div>
</div>


<!-- @부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->

<div id="_modal_header" hidden>
    <h5 class="modal-title"><i class="fa fa-plus-circle fa-lg"></i> Rb 패키지 설치 </h5>
		<button type="button" class="close" onclick="frames._modal_iframe_modal_window.mClose();">
			<span aria-hidden="true">&times;</span>
		</button>
</div>
<div id="_modal_footer" hidden>
	<?php if($package_step==3):?>
	<button type="button" class="btn btn-light pull-left" disabled>취소</button>
	<button type="button" class="btn btn-primary" disabled>완료</button>
	<?php else:?>
	<button type="button" class="btn btn-light pull-left" onclick="frames._modal_iframe_modal_window.mClose();">취소</button>
	<?php if($package_step==2):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.install();" id="afterChooseFileNext">다음</button>
	<?php endif?>
	<?php if($package_step==1):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.getFiles();" id="afterChooseFileNext" data-pid="<?php echo $pid ?>">다음</button>
<?php endif?>
	<?php endif?>
</div>


<script>
var _per = 0;
function progressbar()
{
	if(_per == 0) $('#progress-bar').removeClass('d-none');

	if (_per < 100)
	{
		_per = _per + 10;
		getId('progress-bar').children[0].style.width = (_per>100?100:_per)+ '%';
		setTimeout("progressbar();",100);
	}
	else {
		parent.getId('afterChooseFileNext').disabled = false;
	}
}
function detailCheck()
{
/*
	var h = document.body.scrollHeight;

	parent.getId('_modal_iframe_modal_window').style.height = (h+400)+'px'
	parent.getId('_modal_body_modal_window').style.height = (h+400)+'px';
*/
}
function nextStep()
{
	location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=admin&module=<?php echo $module?>&front=modal.package&package_type=<?php echo $package_type?>&&package_step=2';
}
function install()
{
	var f = document._upload_form_;
	getIframeForAction(f);
	f.submit();
	parent.getId('afterChooseFileNext').innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> Installing ...';
	parent.getId('afterChooseFileNext').disabled = true;
}
function getFiles()
{
	var f = document._download_form_;

	if (confirm('정말로 패키지를 다운받으시겠습니까?    '))
	{
		// var version = ver.value;
		parent.document.title = '패키지 다운로드 중';
		parent.getId('afterChooseFileNext').innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i> 다운로드중 ...';
		parent.getId('afterChooseFileNext').disabled = true;
		// console.log(version)
		// frames.download_frame.location.href = './index.php?install=download&version=' + version + '&sitelang='+lang;
		// frames.download_frame.location.href = './index.php?install=download&version=' + version + '&sitelang='+lang;

		// getIframeForAction('');
		// parent.frames.__iframe_for_action__.location.href = $g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;a=download_package';

		getIframeForAction(f);
		f.submit();
	}

}
function mClose()
{
	location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=add_package&package_step=delete';
	parent.$('#modal_window').modal('hide');
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '400px'
	parent.getId('_modal_body_modal_window').style.height = '400px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
document.body.onresize = document.body.onload = function()
{
	setTimeout("modalSetting();",100);
	setTimeout("modalSetting();",200);
}
</script>


<style>
#modal-package-install .modal-body {
  min-height: 400px;
  max-height: calc(100vh - 175px);
  overflow-y: auto;
  padding: 15px
}

#modal-package-install .tab-content {
  padding: 20px 0
}


/* breadcrumb */

#modal-package-install .breadcrumb {
  margin: -15px -15px 15px;
  border-radius: 0;
  padding: 10px 15px;
}

#modal-package-install .breadcrumb a {
  color: #999;
}

#modal-package-install .breadcrumb a:hover {
  text-decoration: none;
}

#modal-package-install .breadcrumb .active a {
  color: #428bca;
  font-weight: bold;
}

#modal-package-install .breadcrumb .badge {
  background-color: #999;
}

#modal-package-install .breadcrumb .active .badge {
  background-color: #428bca;
}

#modal-package-install h4 {
  line-height: 1.5
}

#modal-package-install .page-header {
  margin-top: 20px;
}

#modal-package-install .list-group {
  margin-bottom: 10px;
}

#modal-package-install .rb-icon {
  font-size: 70px;
	color: #444
}

#modal-package-install .label {
  display: inline;
  padding: .2em .6em .3em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25em;
}

#modal-package-install .pager {
  margin: 0;
}


/* tab2 */


#tab2 .panel-heading a {
  display: inline-block;
  font-family: FontAwesome;
  font-style: normal;
  font-weight: normal;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
}

#tab2 .panel-heading a {
  color: #666;
  display: block;
}

#tab2 .panel-heading a:hover {
  text-decoration: none;
}

#tab2 .panel-heading span:before {
  content: " \f078";
}

#tab2 .panel-heading .collapsed span:before {
  content: " \f054";
}


/* responsive */

@media (min-width: 992px) {
  .modal-lg {
    width: 780px;
  }
}

@media (max-width: 768px) {
  #modal-package-install .breadcrumb .badge {
    padding: 5px 15px
  }
  #modal-package-install .breadcrumb .badge {
    font-size: 18px
  }
  #modal-package-install .rb-icon {
    font-size: 40px
  }
  #modal-package-install .tab-content {
    padding: 0
  }
  #tab1 .btn {
    display: block;
    width: 100%
  }
}


/* 김성호 */

#modal-package-install ul {
  color: #666;
}

#modal-package-install ul .active {
  font-weight: bold;
  color: #428BCA;
}

#modal-package-install ul .active .badge {
  background: #428BCA;
}


#modal-package-install .modal-body {
  padding: 0;
}

#modal-package-install .tab-content {
  clear: both;
  padding: 40px 20px 0 20px;
}

#rb-body .tab-content {
  border: 0;
}
</style>
