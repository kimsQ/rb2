<div class="container-fluid">
	<div class="row" id="layout-code">
		<div class="col-sm-4 col-md-4 col-xl-4 d-none d-sm-block sidebar">
			<div class="card">
				<div class="card-header">
					<a class="accordion-toggle muted-link" data-toggle="collapse" data-parent="#accordion" href="#collapmetane">
						<i class="fa kf kf-layout fa-lg fa-fw"></i> 레이아웃
					</a>
				</div>
				<div class="panel-collapse collapse show" id="collapmetane">
					<div class="card-body">
						<div style="min-height:250px;height: calc(100vh - 13.2rem);">
							<div class="rb-tree">
								<ul id="tree-layout">
								<?php $numSub=array()?>
								<?php $layout = $layout ? $layout : dirname($_HS['layout'])?>
								<?php $sublayout = $sublayout ? $sublayout : 'default.php'?>
								<?php $_sublayout = str_replace('.php','',$sublayout)?>
								<?php $dirs = opendir($g['path_layout'])?>
								<?php $_i=1;while(false !== ($tpl = readdir($dirs))):?>
								<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
								<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
								<li>
									<div class="rb-tree">
										<a data-toggle="collapse" href="#tree-layout-<?php echo $_i?>" class="rb-branch<?php if($tpl!=$layout):?> collapsed<?php endif?>"><span><?php echo getFolderName($g['path_layout'].$tpl)?></span> <small>(<?php echo $tpl?>)</small></a>
										<ul id="tree-layout-<?php echo $_i?>" class="collapse<?php if($tpl==$layout):?> show<?php endif?>">
											<?php $numSub[$tpl]=0;while(false !== ($tpl1 = readdir($dirs1))):?>
											<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
											<li>
												<a href="#." class="rb-leaf"></a>
												<a href="<?php echo $g['adm_href']?>&amp;layout=<?php echo $tpl?>&amp;sublayout=<?php echo $tpl1?>"><span<?php if($tpl==$layout&&$tpl1==$sublayout):?> class="rb-active"<?php endif?>><?php echo str_replace('.php','',$tpl1)?></span></a>
											</li>
											<?php $numSub[$tpl]++;endwhile?>
										</ul>
									</div>
								</li>
								<?php $_i++;endwhile?>
								</ul>
							</div>
						</div>
					</div>

					<div class="card-footer">
						<a class="btn btn-light btn-block rb-modal-add-layout" data-toggle="modal" href="#modal_window">레이아웃 추가</a>
					</div>
				</div>
			</div>
		</div>

		<a name="__code__"></a>
		<div class="col-sm-8 col-md-8 ml-sm-auto col-xl-8 pt-3">
			<div class="page-header mt-0">
				<h4>
					<?php echo getFolderName($g['path_layout'].$layout)?> <small>( <?php echo $layout?> )</small>
					<span class="badge badge-primary"><?php echo $_sublayout?></span>

					<div class="pull-right rb-top-btnbox hidden-xs">
						<div class="btn-group rb-btn-view">
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numSub=<?php echo $numSub[$layout]?>&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" class="btn btn-light" onclick="return hrefCheck(this,true,'현재 사용중인 레이아웃을 삭제하면 중대한 오류가 발생합니다.\n사용중인 레이아웃인지 다시한번 확인해 주세요.\n정말로 삭제하시겠습니까?');">삭제</a>
							<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right" role="menu">
								<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numSub=1&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" onclick="return hrefCheck(this,true,'현재 사용중인 레이아웃을 삭제하면 중대한 오류가 발생합니다.\n사용중인 레이아웃인지 다시한번 확인해 주세요.\n정말로 삭제하시겠습니까?');">
									삭제 (<?php echo getFolderName($g['path_layout'].$layout)?>)
								</a>
							</div>
						</div>

						<div class="btn-group rb-btn-view">
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numCopy=1&amp;layout=<?php echo $layout?>&amp;sublayout=<?php echo $sublayout?>" class="btn btn-light" onclick="return hrefCheck(this,true,'정말로 복사하시겠습니까?');">복사</a>
							<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right" role="menu">
								<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=layout_delete&amp;numCopy=2&amp;layout=<?php echo $layout?>" onclick="return hrefCheck(this,true,'정말로 복사하시겠습니까?');">
									복사 (<?php echo getFolderName($g['path_layout'].$layout)?>)
								</a>
							</div>
						</div>

					</div>
				</h4>
			</div>
			<ul class="nav nav-pills rb-nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link<?php if(!$selfile&&($_SESSION['sh_layout_tab']=='tab_php'||!$_SESSION['sh_layout_tab'])):$_etcfile=$sublayout?> active<?php endif?>" href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile=<?php echo $sublayout?>#__code__" onmousedown="sessionSetting('sh_layout_tab','tab_php','','');">Layout</a>
				</li>
				<li class="nav-item">
					<a class="nav-link<?php if(!$selfile&&$_SESSION['sh_layout_tab']=='tab_css'):$_etcfile=$_sublayout.'.css'?> active<?php endif?>" href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile=<?php echo $_sublayout?>.css#__code__" onmousedown="sessionSetting('sh_layout_tab','tab_css','','');">CSS</a>
				</li>
				<li class="nav-item">
					<a class="nav-link<?php if(!$selfile&&$_SESSION['sh_layout_tab']=='tab_js'):$_etcfile=$_sublayout.'.js'?> active<?php endif?>" href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&etcfile=<?php echo $_sublayout?>.js#__code__" onmousedown="sessionSetting('sh_layout_tab','tab_js','','');">Javascript</a>
				</li>
				<li class="nav-item ml-auto">
					<select class="form-control custom-select" onchange="location.href='<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&module=<?php echo $module?>&layout=<?php echo $layout?>&sublayout=<?php echo $sublayout?>&selfile=Y&etcfile='+this.value+'#__code__';">
						<option value="">Others</option>
						<?php $dirs = opendir($g['path_layout'].$layout.'/')?>
						<?php while(false !== ($tpl = readdir($dirs))):?>
						<?php if(substr($tpl,0,1) != '_' || $tpl == '_images' || is_file($g['path_layout'].$layout.'/'.$tpl))continue?>
						<?php $dirs1 = opendir($g['path_layout'].$layout.'/'.$tpl)?>
						<optgroup label="<?php echo $tpl?>" style="background:#333;color:#fff;">
						<?php while(false !== ($tpl1 = readdir($dirs1))):?>
						<?php if(!strstr($tpl1,'.php')&&!strstr($tpl1,'.css')&&!strstr($tpl1,'.js'))continue?>
						<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($etcfile==$tpl.'/'.$tpl1):?> selected<?php endif?> style="background:#fff;color:#000;"><?php echo $tpl1?></option>
						<?php endwhile?>
						<?php closedir($dirs1)?>
						</optgroup>
						<?php endwhile?>
						<?php closedir($dirs)?>
					</select>
				</li>
			</ul>
			<?php $etcfile = $etcfile ? $etcfile : $_etcfile?>
			<?php $codfile = $g['path_layout'].$layout.'/'.$etcfile?>
			<?php $codeext = getExt($codfile)?>
			<?php $codeset = array('php' => 'application/x-httpd-php','css' => 'text/css','js' => 'text/javascript')?>
			<div id="tab-edit-area" class="tab-content">
				<div class="tab-pane fade active show" id="tab_etc">
					<form action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="a" value="layout_update">
					<input type="hidden" name="m" value="<?php echo $module?>">
					<input type="hidden" name="layout" value="<?php echo $layout?>">
					<input type="hidden" name="sublayout" value="<?php echo $sublayout?>">
					<input type="hidden" name="editfile" value="<?php echo $etcfile?>">
						<div class="rb-files">
							<div class="rb-codeview">
								<div class="rb-codeview-header d-flex align-items-center justify-content-between">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">파일경로 :</li>
										<li class="breadcrumb-item">root</li>
										<li class="breadcrumb-item">layouts</li>
										<li class="breadcrumb-item"><?php echo $layout?></li>
										<li class="breadcrumb-item"><?php echo str_replace('/','</li><li class="active">',$etcfile)?></li>
									</ol>
									<button type="button" class="btn btn-secondary btn-sm" data-tooltip="tooltip" title="전체화면" onclick="editFullSize('tab-edit-area',this);"><i class="fa fa-arrows-alt fa-lg"></i></button>
								</div>
								<div class="rb-codeview-body">
									<textarea name="code" id="__code__" class="form-control" rows="35"><?php if(is_file($codfile)) echo htmlspecialchars(implode('',file($codfile)))?></textarea>
								</div>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
								    <span class="input-group-text">레이아웃명</span>
								  </div>
									<input type="text" name="name" value="<?php echo getFolderName($g['path_layout'].$layout)?>" class="form-control">
									<div class="input-group-prepend">
										<span class="input-group-text">레이아웃 폴더</span>
									</div>
									<input type="text" name="newLayout" value="<?php echo $layout?>" class="form-control">
									<div class="input-group-prepend">
										<span class="input-group-text">서브 레이아웃</span>
									</div>
									<input type="text" name="newSLayout" value="<?php echo $_sublayout?>" class="form-control">
								</div>
								<div class="rb-codeview-footer">
									<ul class="list-inline">
										<li><code><?php echo is_file($codfile) ? count(file($g['path_layout'].$layout.'/'.$etcfile)).' lines':'0 line'?></code></li>
										<li><code><?php echo is_file($codfile) ? getSizeFormat(@filesize($g['path_layout'].$layout.'/'.$etcfile),2) : '0 Byte'?></code></li>
										<li class="pull-right">파일을 편집한 후 저장 버튼을 클릭하면 실시간으로 사용자 페이지에 적용됩니다.</li>
									</ul>
								</div>
							</div>
						</div>

						<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4">저장하기</button>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>



<?php if($d['admin']['codeeidt']):?>
<!-- codemirror -->
<style>
.CodeMirror {
	font-size: 13px;
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
<?php getImport('codemirror','mode/clike/clike',false,'js')?>
<?php getImport('codemirror','mode/php/php',false,'js')?>
<?php getImport('codemirror','mode/css/css',false,'js')?>
<script>
var editor = CodeMirror.fromTextArea(getId('__code__'), {
	mode: "<?php echo $codeset[$codeext]?$codeset[$codeext]:'application/x-httpd-php'?>",
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
editor.setSize('100%','550px');
_isCodeEdit = true;
function _codefullscreen()
{
	editor.setOption('fullScreen', !editor.getOption('fullScreen'));
}
</script>
<!-- @codemirror -->
<?php endif?>


<script>
$(document).ready(function()
{
	$('.rb-modal-add-layout').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=market&amp;front=modal.add&amp;addType=layout&amp;reload=Y')?>');
	});
});
function saveCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>
