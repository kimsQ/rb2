<?php
if ($_mtype == 'page')
{
	$_HP = getUidData($table['s_page'],$uid);
	$_filekind = $r.'-pages/'.$_HP['id'];
	$_filetype= '페이지';
	$_filesbj = $_HP['name'];
	$_infopage = $g['s'].'/?r='. $r.'&amp;m='.$m.'&amp;module='.$module.'&amp;front='.$_mtype.'&amp;uid='.$uid.'&amp;cat='.urlencode($cat).'&amp;p='.$p.'&amp;recnum='.$recnum.'&amp;keyw='.urlencode($keyw);
}
if ($_mtype == 'menu')
{
	$_HM = getUidData($table['s_menu'],$uid);
	$_filekind = $r.'-menus/'.$_HM['id'];
	$_filetype = '메뉴';
	$_filesbj = $_HM['name'];
	$_infopage = $g['s'].'/?r='. $r.'&amp;m='.$m.'&amp;module='.$module.'&amp;front='.$_mtype.'&amp;cat='.$uid.'&amp;code='.$code;
	include $g['path_core'].'function/menu.func.php';
	$ctarr = getMenuCodeToPath($table['s_menu'],$_HM['uid'],0);
	$ctnum = count($ctarr);
	$_HM['code'] = '';
	for ($i = 0; $i < $ctnum; $i++) $_HM['code'] .= $ctarr[$i]['id'].($i < $ctnum-1 ? '/' : '');
}

$filekind_array = explode('/', $_filekind);

if($type == 'source'):
$_editArray = array(
	'source' => array('','HTML (Basic)','.php'),
	'mobile' => array('mobile','HTML (Mobile Only)','.mobile.php'),
	'css' => array('css','CSS','.css'),
	'js' => array('js','Javascript','.js'),
);

$source = is_file($g['path_page'].$_filekind.'.php') ? implode('',file($g['path_page'].$_filekind.'.php')) : '' ;
$mobile = is_file($g['path_page'].$_filekind.'.mobile.php') ? implode('',file($g['path_page'].$_filekind.'.mobile.php')) : '';
?>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko',false,'js')?>

<!-- 직접 꾸미기 -->
<div id="rb-page-source" class="<?php echo $wysiwyg=='Y'?'rb-docs':'' ?><?php if($_SESSION['editor_sidebar']=='right'):?> rb-fixed-sidebar<?php endif?>">

	<nav class="d-flex align-items-center py-2 pl-4 pr-5 bg-white">

		<a href="<?php echo $_infopage?>" class="text-center">
			<i class="fa fa-file-text fa-2x" data-toggle="tooltip" title="등록정보"></i>
		</a>

		<div class="ml-1">
			<h4 class="h5 mt-2 mb-0 ml-3">
				<?php echo $_filesbj?> <span class="badge badge-primary"><?php echo $mobileOnly?'모바일 전용':'' ?></span>
			</h4>

			<div class="d-flex">
				<ul class="nav ml-2">
					<li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle pb-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          파일
		        </a>

		        <div class="dropdown-menu">
							<?php if ($wysiwyg=='Y'): ?>
							<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>">소스코드 편집</a>
							<?php else: ?>
							<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;wysiwyg=Y&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>">에디터 편집</a>
							<?php endif; ?>

		          <div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletemenu&amp;cat=<?php echo $cat?>&amp;back=Y" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');"><?php echo $_mtype=='menu'?'메뉴':'페이지' ?> 삭제</a>
		        </div>

		      </li>
					<li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle pb-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          삽입
		        </a>
		        <div class="dropdown-menu">
							<?php if($wysiwyg=='Y'):?>
							<a class="dropdown-item rb-modal-photoset" href="#." data-toggle="modal" data-target="#modal_window">포토셋</a>
							<a class="dropdown-item rb-modal-videoset" href="#." data-toggle="modal" data-target="#modal_window">비디오셋</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item rb-modal-widgetcode" href="#." onclick="InserHTMLtoEditor('<hr>')">가로줄</a>
		          <a class="dropdown-item rb-modal-widgetedit" href="#." data-toggle="modal" data-target="#modal_window">위젯</a>
							<?php else:?>
							<a class="dropdown-item rb-modal-widgetcode" href="#." data-toggle="modal" data-target="#modal_window">위젯</a>
							<?php endif?>
		        </div>
		      </li>
				</ul>

				<?php if ($_HM['d_last'] || $_HP['d_last']): ?>
				<div class="navbar-text text-muted ml-3">
					<time class="timeago" datetime="<?php echo getDateFormat($_HM['d_last'],'c')?>" data-role="d_last">
						<?php echo getDateFormat(($_mtype == 'menu')?$_HM['d_last']:$_HP['d_last'],'Y.m.d')?>
					</time>
					에 마지막으로 수정했습니다.
				</div>
				<?php endif; ?>
			</div>

		</div>

		<div class="d-none">

			<?php if ($wysiwyg=='Y'): ?>

				<?php if ($mobileOnly): ?>
					<div class="p-3 mb-3 alert-danger" role="alert" style="z-index:900">
						<i class="fa fa-mobile fa-3x fa-pull-left" aria-hidden="true"></i>
						본 파일은 <strong>모바일 전용</strong> 파일으로 모바일 기기에서만 출력됩니다. 내용이 없으면 자동삭제 됩니다.
						PHP 또는 Javascript 가 포함된 경우에는 <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>" class="alert-link"><i class="fa fa-code" aria-hidden="true"></i> 소스코드 편집모드</a> 를 이용해 주세요.
					</div>
					<?php  $_filekind= $_filekind.'.mobile'; ?>
				<?php else: ?>
					<div class="p-3 mb-3 alert-danger mx-3 d-none" role="alert" style="z-index:900">

						<?php if (is_file($g['path_page'].$_filekind.'.mobile.php')): ?>
						<i class="fa fa-desktop fa-3x fa-pull-left" aria-hidden="true"></i>
						본 파일은 데스크탑에서만 출력됩니다.
						<?php else: ?>
						<i class="fa fa-desktop fa-3x fa-pull-left" aria-hidden="true"></i>
						<i class="fa fa-mobile fa-3x fa-pull-left" aria-hidden="true"></i>
						본 파일은 모든 기기에서 출력됩니다.  모바일 전용 컨텐츠를 구분하려면 <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;markdown=Y&amp;mobileOnly=Y&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>" class="alert-link">모바일 전용파일</a>을 생성해 주세요.<br>
						<?php endif; ?>

					 PHP 또는 Javascript 가 포함된 경우에는 <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=_edit&amp;_mtype=<?php echo $_mtype?>&amp;type=source&amp;uid=<?php echo $uid?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>" class="alert-link"><i class="fa fa-code" aria-hidden="true"></i> 소스코드 편집모드</a> 를 이용해 주세요.
					</div>
				<?php endif; ?>

				<div class="mx-3">
					<ol class="breadcrumb bg-white text-dark mb-0">
						<li class="breadcrumb-item"><i class="fa fa-folder text-muted fa-fw" aria-hidden="true"></i> root</li>
						<li class="breadcrumb-item">pages</li>
						<?php if($_mtype=='menu'):?>
						<li class="breadcrumb-item">menu</li>
						<?php endif?>
						<li class="breadcrumb-item"><?php echo $filekind_array[0]?></li>
						<li class="breadcrumb-item active"><?php echo $filekind_array[1]?>.php</li>
					</ol>
					<div class="pr-3">
					</div>
				</div>
			<?php endif; ?>



		</div>


		<div class="ml-auto rb-top-btnbox">

				<?php if ($_mtype == 'page'):$_viewpage=RW('mod='.$_HP['id'])?>
				<!-- 페이지 -->
				<a  href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>&amp;uid=<?php echo $uid?>&amp;cat=<?php echo urlencode($cat)?>&amp;p=<?php echo $p?>&amp;recnum=<?php echo $recnum?>&amp;keyw=<?php echo urlencode($keyw)?>" class="btn btn-light border-0">
					페이지 등록정보
				</a>
				<a href="<?php echo $_viewpage?>" class="btn btn-light border-0" target="_blank" data-toggle="tooltip" title="미리보기(새창)">
					<i class="fa fa-share fa-lg" aria-hidden="true"></i>
				</a>
				<button type="button" class="btn btn-primary js-submit">
					<span class="not-loading">
						저장하기
					</span>
					<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i></span>
				</button>

				<?php else:$_viewpage=RW('c='.$_HM['code'])?>
				<!-- 메뉴 -->
				<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=<?php echo $_mtype?>&amp;cat=<?php echo $uid?>&amp;code=<?php echo $code?>" class="btn btn-light border-0">
					등록정보
				</a>
				<a href="<?php echo $_viewpage?>" class="btn btn-light border-0" target="_blank" data-toggle="tooltip" title="미리보기(새창)">
					<i class="fa fa-share fa-lg" aria-hidden="true"></i>
				</a>
				<button type="button" class="btn btn-primary js-submit">
					<span class="not-loading">
						저장하기
					</span>
					<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i></span>
				</button>
				<?php endif?>
			</div>
	</nav>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return sourcecheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="sourcewrite">
		<input type="hidden" name="type" value="<?php echo $_mtype?>">

		<?php if ($wysiwyg=='Y'): ?>
		<textarea name="source" hidden><?php echo $source ?></textarea>
		<textarea name="mobile" hidden><?php echo $mobile ?></textarea>
		<?php endif; ?>

		<?php if($_mtype=='menu'):?>
		<input type="hidden" name="uid" value="<?php echo $_HM['uid']?>">
		<input type="hidden" name="id" value="<?php echo $_HM['id']?>">
		<input type="hidden" name="upload" id="upfilesValue" value="<?php echo $_HM['upload']?>">
		<input type="hidden" name="featured_img" value="<?php echo $_HM['featured_img']?>">
		<?php else:?>
		<input type="hidden" name="uid" value="<?php echo $_HP['uid']?>">
		<input type="hidden" name="id" value="<?php echo $_HP['id']?>">
		<input type="hidden" name="upload" id="upfilesValue" value="<?php echo $_HP['upload']?>">
		<input type="hidden" name="featured_img" value="<?php echo $_HP['featured_img']?>">
		<?php endif?>
		<input type="hidden" name="wysiwyg" value="<?php echo $wysiwyg?>">
		<input type="hidden" name="editFilter" value="<?php echo $d['admin']['editor']?>">

		<?php
		if($wysiwyg=='Y'):
		$__SRC__ = is_file($g['path_page'].$_filekind.'.php') ? implode('',file($g['path_page'].$_filekind.'.php')) : '';
		include $g['path_plugin'].$d['admin']['editor'].'/import.system.php';
		?>

		<?php else:?>
		<div id="tab-edit-area">
			<div class="form-group mb-0">
				<div class="panel-group" id="accordion">
					<?php $_i=1;foreach($_editArray as $_key => $_val):?>
					<div class="card mb-0 rounded-0">
						<div class="card-header p-0 rounded-0">
							<a class="d-block collapsed muted-link" data-toggle="collapse" href="#site-code-<?php echo $_key?>" onclick="sessionSetting('sh_sys_page_edit','<?php echo $_key?>','','');">
								<?php echo $_val[1]?>
								<?php if(is_file($g['path_page'].$_filekind.$_val[2])):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
							</a>
						</div>
						<div id="site-code-<?php echo $_key?>" class="panel-collapse collapse<?php if(($_key==$_SESSION['sh_sys_page_edit']) || (!$_SESSION['sh_sys_page_edit']&&$_i==1)):?> show<?php endif?>" data-parent="#accordion" >

							<div class="rb-codeview">
								<div class="rb-codeview-header d-flex justify-content-between align-items-center">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><i class="fa fa-folder" aria-hidden="true"></i></li>
										<li class="breadcrumb-item">root</li>
										<li class="breadcrumb-item">pages</li>
										<?php if($_mtype=='menu'):?>
										<li class="breadcrumb-item">menu</li>
										<?php endif?>
										<li class="breadcrumb-item active"><?php echo str_replace('menu/','',$_filekind).$_val[2]?></li>
									</ol>
								</div>
								<div class="rb-codeview-body">
									<textarea name="<?php echo $_key?>" id="code_<?php echo $_key?>" class="form-control f13 d-none" rows="35"><?php if(is_file($g['path_page'].$_filekind.$_val[2])) echo htmlspecialchars(implode('',file($g['path_page'].$_filekind.$_val[2])))?></textarea>
								</div>
								<div class="rb-codeview-footer">
									<ul class="list-inline">
										<li><code><?php echo is_file($g['path_page'].$_filekind.$_val[2])?count(file($g['path_page'].$_filekind.$_val[2])):'0'?> lines</code></li>
										<li><code><?php echo is_file($g['path_page'].$_filekind.$_val[2])?getSizeFormat(@filesize($g['path_page'].$_filekind.$_val[2]),2):'0B'?></code></li>
										<li class="pull-right">파일을 편집한 후 저장 버튼을 클릭하면 실시간으로 사용자 페이지에 적용됩니다.</li>
									</ul>
								</div>
							</div>

						</div>
					</div>
					<?php $_i++;endforeach?>
				</div>
			</div>

		</div>
		<?php endif?>

		<div class="rb-attach-sidebar bg-white">

      <div class="sidebar-header d-flex justify-content-between align-items-center pt-1 px-2 position-absolute" style="top:1px;right:1px;">
        <div class=""></div>
        <button type="button" class="close js-closeSidebar btn" aria-label="Close" data-toggle="tooltip" title="첨부패널 닫기">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
          <a class="nav-link rounded-0 border-top-0 border-left-0<?php if(!$_COOKIE['editor_sidebar_tab']):?> active<?php endif?>" id="tab-file" data-toggle="tab" href="#pane-file" role="tab" aria-controls="file" aria-selected="true" onclick="setCookie('editor_sidebar_tab','',1);">
            첨부파일
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-0 border-top-0 <?php if($_COOKIE['editor_sidebar_tab']=='link'):?> active<?php endif?>" id="tab-link" data-toggle="tab" href="#pane-link" role="tab" aria-controls="media" aria-selected="false" onclick="setCookie('editor_sidebar_tab','link',1);">
            외부링크
          </a>
        </li>
				<li class="nav-item">
					<a class="nav-link rounded-0 border-top-0 border-right-0<?php if($_COOKIE['editor_sidebar_tab']=='toc'):?> active<?php endif?>" id="tab-toc" data-toggle="tab" href="#pane-toc" role="tab" aria-controls="media" aria-selected="false" onclick="setCookie('editor_sidebar_tab','toc',1);">
						목차
					</a>
				</li>
      </ul>
      <div class="tab-content mt-3">
        <div class="tab-pane px-2<?php if(!$_COOKIE['editor_sidebar_tab']):?> show active <?php endif?>" id="pane-file" role="tabpanel">
          <?php getWidget('_default/attach',array('parent_module'=>'site','theme'=>'_desktop/bs4-system-attach','attach_handler_photo'=>'[data-role="attach-handler-photo"]','parent_data'=>($_mtype=='page'?$_HP:$_HM),'attach_object_type'=>'file','wysiwyg'=>$wysiwyg));?>
  				<p>
  					<small class="text-muted">
  						사진,파일,비디오,오디오를 한번에 최대 최대 <?php echo str_replace('M','',ini_get('upload_max_filesize'))?>MB 까지 업로드 할수 있습니다.<br>

  					</small>
  				</p>
        </div>
        <div class="tab-pane px-2<?php if($_COOKIE['editor_sidebar_tab']=='link'):?> show active <?php endif?>" id="pane-link" role="tabpanel">

          <?php getWidget('_default/attach',array('parent_module'=>'site','theme'=>'_desktop/bs4-system-link','attach_handler_photo'=>'[data-role="attach-handler-photo"]','parent_data'=>($_mtype=='page'?$_HP:$_HM),'wysiwyg'=>1));?>

        </div><!-- /.tab-pane -->
				<div class="tab-pane px-4<?php if($_COOKIE['editor_sidebar_tab']=='toc'):?> show active <?php endif?>" id="pane-toc" role="tabpanel">

					<?php if ($wysiwyg): ?>
					<nav id="toc" class="ml-3"></nav>
					<?php else: ?>
					<div class="text-center py-5 text-muted">
						에디터 편집 화면에서 표시됩니다.
					</div>
					<?php endif; ?>


				</div><!-- /.tab-pane -->
      </div><!-- /.tab-content -->

  	</div><!-- .rb-attach-sidebar -->
	</form>

</div>


<?php if($wysiwyg!='Y' && $d['admin']['codeeidt']):?>
<!-- codemirror -->
<style>
.CodeMirror {
	font-weight: normal;
	font-family: Menlo,Monaco,Consolas,"Courier New",monospace !important;
}
</style>
<?php getImport('codemirror','lib/codemirror',false,'css')?>
<?php getImport('codemirror','lib/codemirror',false,'js')?>
<?php getImport('codemirror','theme/'.$d['admin']['codeeidt'],false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/xml/xml',false,'js')?>
<?php getImport('codemirror','mode/javascript/javascript',false,'js')?>
<?php getImport('codemirror','mode/css/css',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/clike/clike',false,'js')?>
<?php getImport('codemirror','mode/php/php',false,'js')?>


<script>

$(function () {

	var editor_php1 = CodeMirror.fromTextArea(getId('code_source'), {
		mode: "application/x-httpd-php",
	    indentUnit: 2,
	    lineNumbers: true,
	    matchBrackets: true,
	    indentWithTabs: true,
			theme: '<?php echo $d['admin']['codeeidt']?>',
		extraKeys: {
			"F11": function(cm) {
			  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function(cm) {
			  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			}
		}
	});
	var editor_php2 = CodeMirror.fromTextArea(getId('code_mobile'), {
		mode: "application/x-httpd-php",
	    indentUnit: 4,
	    lineNumbers: true,
	    matchBrackets: true,
	    indentWithTabs: true,
		theme: '<?php echo $d['admin']['codeeidt']?>',
		extraKeys: {
			"F11": function(cm) {
			  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function(cm) {
			  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			}
		}
	});
	var editor_css = CodeMirror.fromTextArea(getId('code_css'), {
		mode: "text/css",
	    indentUnit: 4,
	    lineNumbers: true,
	    matchBrackets: true,
	    indentWithTabs: true,
		theme: '<?php echo $d['admin']['codeeidt']?>',
		extraKeys: {
			"F11": function(cm) {
			  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function(cm) {
			  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			}
		}
	});
	var editor_js = CodeMirror.fromTextArea(getId('code_js'), {
		mode: "text/javascript",
	    indentUnit: 4,
	    lineNumbers: true,
	    matchBrackets: true,
	    indentWithTabs: true,
		theme: '<?php echo $d['admin']['codeeidt']?>',
		extraKeys: {
			"F11": function(cm) {
			  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function(cm) {
			  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			}
		}
	});
	editor_php1.setSize('100%','450px');
	editor_php2.setSize('100%','450px');
	editor_css.setSize('100%','450px');
	editor_js.setSize('100%','450px');


	$('#site-code-source').on('shown.bs.collapse', function () {
		editor_php1.refresh();
	})
	$('#site-code-mobile').on('shown.bs.collapse', function () {
		editor_php2.refresh();
	})
	$('#site-code-css').on('shown.bs.collapse', function () {
		editor_css.refresh();
	})
	$('#site-code-js').on('shown.bs.collapse', function () {
		editor_js.refresh();
	})

	<?php if ($mobileOnly=='Y'): ?>
	$('#site-code-mobile').collapse('show')
	<?php endif; ?>

})

_isCodeEdit = true;
function _codefullscreen()
{
	if(_nowArea == 'source') editor_php1.setOption('fullScreen', !editor_php1.getOption('fullScreen'));
	if(_nowArea == 'mobile') editor_php2.setOption('fullScreen', !editor_php2.getOption('fullScreen'));
	if(_nowArea == 'css') editor_css.setOption('fullScreen', !editor_css.getOption('fullScreen'));
	if(_nowArea == 'js') editor_js.setOption('fullScreen', !editor_js.getOption('fullScreen'));
}
</script>
<!-- @codemirror -->
<?php endif?>

<script>

_nowArea = '';


$(".timeago").timeago();

$(".js-openSidebar").click(function(){
	$('#rb-page-source').addClass('rb-fixed-sidebar');
	sessionSetting('editor_sidebar','right','','');
});

$(".js-closeSidebar").click(function(){
	$('#rb-page-source').removeClass('rb-fixed-sidebar');
	sessionSetting('editor_sidebar','','','');
	$('[data-toggle="tooltip"]').tooltip('hide')
});

$(".js-submit").click(function() {

	$(this).attr("disabled",true);

	var f = document.procForm;

	<?php if ($wysiwyg=='Y'): ?>
	var editorData = editor.getData();

	<?php if ($mobileOnly=='Y'): ?>
	$('[name="mobile"]').val(editorData);
	<?php else: ?>
	$('[name="source"]').val(editorData);
	<?php endif; ?>

	<?php endif; ?>

	// 첨부파일 uid 를 upfiles 값에 추가하기
	var attachfiles=$('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
	var new_upfiles='';
	if(attachfiles){
		for(var i=0;i<attachfiles.length;i++) {
		 new_upfiles+=attachfiles[i];
		}
		$('input[name="upload"]').val(new_upfiles);
	}

	$("#toc").empty();
	doToc();

	setTimeout(function(){
		getIframeForAction(f);
		f.submit();
	}, 500);
});

getId('rb-more-tab-<?php echo $_mtype=='page'?'3':'2'?>').className = 'active';
</script>
<?php endif?>

<script>

function doToc() {
	Toc.init({
		$nav: $("#toc"),
		$scope: $(".document-editor__editable-container h2,.document-editor__editable-container h3,.document-editor__editable-container h4")
	});
}

// smoothScroll : https://github.com/cferdinandi/smooth-scroll
var scroll_content = new SmoothScroll('[data-toggle="toc"] a[href*="#"]',{
	ignore: '[data-scroll-ignore]'
});


$(document).ready(function() {

	Toc.init({
		$nav: $("#toc"),
		$scope: $(".document-editor__editable-container h2, .document-editor__editable-container h3")
	});

	$('.document-editor__editable-container').scrollspy({
		target: '#toc'
	});

	$('.rb-modal-widgetcode').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget&amp;isWcode=Y')?>');
	});
	$('.rb-modal-widgetedit').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget&amp;isWcode=Y&amp;isEdit=Y')?>');
	});
	$('.rb-modal-photoset').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=editor')?>');
	});
	$('.rb-modal-videoset').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.video.media&amp;dropfield=editor')?>');
	});
	$('.rb-modal-widgetcall').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget')?>&amp;dropfield=-1');
	});
	$('.rb-modal-widgetcall-modify').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.widget')?>&amp;dropfield='+_Wdropfield+'&amp;option='+_Woption);
	});

	putCookieAlert('site_edit_result') // 실행결과 알림 메시지 출력

});

</script>
