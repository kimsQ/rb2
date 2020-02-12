<?php
function getSearchFileList($folder)
{
	$incs = array();
	$dirh = opendir($folder);
	while(false !== ($files = readdir($dirh)))
	{
		if(substr($files,-4)!='.php') continue;
		$incs[] = str_replace('.php','',$files);
	}
	closedir($dirh);
	return $incs;
}

$g['searchVarForSite'] = $g['path_var'].'site/'.$r.'/search.var.php';
$_tmpdfile = file_exists($g['searchVarForSite']) ? $g['searchVarForSite'] : $g['path_module'].$module.'/var/var.search.php';
include_once $_tmpdfile;

$device = $mobile?'mobile':'desktop';
include_once $g['path_module'].$module.'/var/var.order.'.$device.'.php';

$MODULE_LIST = getDbArray($table['s_module'],'','*','gid','asc',0,$p);
$_names = array();
$PAGESET = array();
$TMPST = array();
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN = db_num_rows($SITES);
?>

<div class="row no-gutters" id="search-body">
	<div class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar">

		<div class="border border-primary">
			<select class="form-control custom-select border-0" name="device" onchange="goHref('<?php echo $g['s']?>/?m=<?php echo $m?>&module=<?php echo $module?>&front=<?php echo $front?>&autoCheck=Y&searchfile=<?php echo $searchfile?>&r=<?php echo $r?>&mobile='+this.value);">
			  <option value=""<?php if(!$mobile):?> selected<?php endif?>>데스크탑</option>
			  <option value="1"<?php if($mobile):?> selected<?php endif?>>모바일</option>
			</select>
		</div>

		<div class="panel-group" id="accordion">
			<div class="card">
				<div class="card-header p-0">
					<a class="accordion-toggle muted-link d-block<?php if($_SESSION['search_main_collapse']):?> collapsed<?php endif?>"
						data-toggle="collapse" href="#collapseOne"
						onclick="sessionSetting('search_main_collapse','','','');">
						<i class="fa fa-search fa-lg fa-fw"></i>
						통합검색 지원모듈
					</a>
				</div>

				<div class="panel-collapse collapse<?php if(!$_SESSION['search_main_collapse']):?> show<?php endif?>" id="collapseOne" data-parent="#accordion">
					<div class="card-body">
						<?php $_i=0;while($MD = db_fetch_array($MODULE_LIST)):?>
						<?php
							if ($mobile){
								$forsearching_folder=$g['path_module'].$MD['id'].'/for-searching/_mobile';
							}else{
								$forsearching_folder=$g['path_module'].$MD['id'].'/for-searching/_desktop';
							}
						?>
						<?php if(!is_dir($forsearching_folder)) continue?>
						<div class="mt-2 py-1">
							<h6 class="mb-0">
								<small class="text-muted"><i class="<?php echo $MD['icon']?>"></i> <?php echo $MD['name']?> (<?php echo $MD['id']?>)</small>
							</h6>
							<div class="dd">
								<ol class="dd-list">
									<?php foreach(getSearchFileList($forsearching_folder) as $_file):?>
									<?php $device = $mobile?'mobile.':'desktop.' ?>
									<?php $_namefile = $g['path_module'].$module.'/var/names/'.$device.$MD['id'].'-'.$_file.'.txt'?>
									<?php $_names = is_file($_namefile) ? explode('|',implode('',file($_namefile))):array()?>
									<?php $PAGESET[$MD['id'].'_'.$_file] = array('filename'=>$_file,'filerename'=>$_names[0]?$_names[0]:$_file,'moduleid'=>$MD['id'],'modulename'=>$MD['name'],'site'=>$_names[1],'filepath'=>$forsearching_folder.'/'.$_file)?>
									<li class="dd-item dd3-item<?php if($MD['id'].'/'.$_file==$searchfile):?> rb-active<?php endif?>">
										<div class="dd-handle dd3-handle dd3-handle-none"></div>
										<div class="dd3-content">
											<i class="fa fa-file" style="position:absolute;left:10px;top:10px;color:#000;"></i>
											<a href="<?php echo $g['adm_href']?>&amp;searchfile=<?php echo $MD['id'].'/'.$_file?>&amp;mobile=<?php echo $mobile?>"><?php echo $_file?>.php</a>
										</div>
									</li>
									<?php endforeach?>
								</ol>
							</div>
						</div>
						<?php $_i++;endwhile?>
						<?php if(!$_i):?>
						<div class="card-body rb-none">
							통합검색 지원모듈이 없습니다.
						</div>
						<?php endif?>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header p-0">
					<a class="accordion-toggle muted-link d-block<?php if(!$_SESSION['search_main_collapse']):?> collapsed<?php endif?>" data-toggle="collapse" href="#collapseTwo" onclick="sessionSetting('search_main_collapse','order','','');">
						<i class="fa fa-retweet fa-lg fa-fw"></i>
						출력옵션 및 순서조정
					</a>
				</div>
				<div class="panel-collapse collapse<?php if($_SESSION['search_main_collapse']):?> show<?php endif?>" id="collapseTwo" data-parent="#accordion">
					<form role="form" action="<?php echo $g['s']?>/" method="post">
						<input type="hidden" name="r" value="<?php echo $r?>">
						<input type="hidden" name="m" value="<?php echo $module?>">
						<input type="hidden" name="a" value="order">
						<input type="hidden" name="mobile" value="<?php echo $mobile?>">
						<input type="hidden" name="auto" value="">
						<input type="hidden" name="autoCheck" value="<?php echo $autoCheck ?>">
						<div class="card-body">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
									<?php $_i=0;if(count($d['search_order'])):foreach($d['search_order'] as $_key => $_val):?>
									<?php if(!is_array($PAGESET[$_key]))continue?>
									<li class="dd-item dd3-item<?php if($PAGESET[$_key]['moduleid'].'/'.$PAGESET[$_key]['filename']==$searchfile):?> rb-active<?php endif?>" data-id="<?php echo $_i?>">
										<div class="dd-handle dd3-handle"></div>
										<div class="dd3-content"><a href="<?php echo $g['adm_href']?>&amp;searchfile=<?php echo $PAGESET[$_key]['moduleid'].'/'.$PAGESET[$_key]['filename']?>&amp;mobile=<?php echo $mobile?>" title="<?php echo $PAGESET[$_key]['filename']?>.php" data-tooltip="tooltip"><?php echo $PAGESET[$_key]['filerename']?></a> <small title="<?php echo $PAGESET[$_key]['modulename']?>" data-tooltip="tooltip">(<?php echo $PAGESET[$_key]['moduleid']?>)</small></div>
										<div class="dd-checkbox">
											<input type="checkbox" name="searchmembers[]" value="<?php echo $PAGESET[$_key]['moduleid']?>_<?php echo $PAGESET[$_key]['filename']?>|<?php echo $PAGESET[$_key]['filerename']?>|<?php echo $PAGESET[$_key]['site']?>|<?php echo $PAGESET[$_key]['filepath']?>" checked class="d-none"><i class="fa fa-eye-<?php echo strstr($PAGESET[$_key]['site'],'['.$r.']')?'open':'close rb-eye-close'?>"></i>
										</div>
									</li>
									<?php $_i++;endforeach;$_nowOrderNum=$_i;endif?>
									<?php foreach($PAGESET as $_key => $_val):?>
									<?php if(is_array($d['search_order'][$_key]))continue?>
									<li class="dd-item dd3-item<?php if($_val['moduleid'].'/'.$_val['filename']==$searchfile):?> rb-active<?php endif?>" data-id="<?php echo $_i?>">
										<div class="dd-handle dd3-handle"></div>
										<div class="dd3-content"><a href="<?php echo $g['adm_href']?>&amp;searchfile=<?php echo $_val['moduleid'].'/'.$_val['filename']?>&amp;mobile=<?php echo $mobile?>" title="<?php echo $_val['filename']?>.php" data-tooltip="tooltip"><?php echo $_val['filerename']?></a> <small title="<?php echo $_val['modulename']?>" data-tooltip="tooltip">(<?php echo $_val['moduleid']?>)</small></div>
										<div class="dd-checkbox">
											<input type="checkbox" name="searchmembers[]" value="<?php echo $_val['moduleid']?>_<?php echo $_val['filename']?>|<?php echo $_val['filerename']?>|<?php echo $_val['site']?>|<?php echo $_val['filepath']?>" checked class="hidden"><i class="fa fa-eye-<?php echo strstr($_val['site'],'['.$r.']')?'open':'close rb-eye-close'?>"></i>
										</div>
									</li>
									<?php $_i++;endforeach;$_nowOrderNum=$_i?>
								</ol>
							</div>
						</div>
						<?php if(!$_i):?>
						<div class="card-body rb-none">
							등록된 검색페이지가 없습니다.
						</div>
						<?php endif?>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-8 col-md-8 ml-sm-auto col-xl-9">

		<?php
		if($searchfile):
		$_searchfl = str_replace('/','-',$searchfile);
		$device = $mobile?'mobile.':'desktop.';
		$_namefile = $g['path_module'].$module.'/var/names/'.$device.$_searchfl.'.txt';

		if (is_file($_namefile)) $_names = explode('|',implode('',file($_namefile)));
		else $_names = array();
		?>

		<form name="procForm" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return procCheck(this);" class="card rounded-0 border-0">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="search_edit">
			<input type="hidden" name="mobile" value="<?php echo $mobile?>">
			<input type="hidden" name="namefile" value="<?php echo $_searchfl?>">
			<input type="hidden" name="searchfile" value="<?php echo $searchfile?>">


			<div class="card-header d-flex justify-content-between align-items-center py-1">
				등록정보 및 사이트 지정
				<div class="">
					<a href="<?php echo $g['adm_href']?>" class="btn btn-light"><i class="fa fa-cog"></i> 통합검색 설정</a>
					<div class="btn-group rb-btn-view">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" class="btn btn-light">접속하기</a>
						<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu dropdown-menu-right" role="menu">
							<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" target="_blank">
								<i class="fa fa-external-link"></i> 새창으로 보기
							</a>
						</div>
					</div>
				</div>
			</div><!-- /.card-header -->

			<div class="card-body">
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">검색명칭</label>
					<div class="col-lg-10 col-xl-9">
						<input type="text" name="name" value="<?php echo $_names[0]?$_names[0]:$_searchfl?>" class="form-control">
						<p class="form-text text-muted">
							<small>이 파일의 검색페이지 명칭을 적절한 용어로 지정해 주세요.</small>
						</p>
					</div>
				</div>
				<div class="form-group row">

					<?php while($S = db_fetch_array($SITES)):$TMPST[]=array($S['name'],$S['id'])?><?php endwhile?>

					<label class="col-lg-2 col-form-label text-lg-right">출력사이트</label>
					<div class="col-lg-10 col-xl-9 pt-1">
						<?php foreach($TMPST as $_val):?>
						<div class="custom-control custom-checkbox custom-control-inline">
						  <input type="checkbox" class="custom-control-input" id="aply_sites_<?php echo $_val[1]?>" name="aply_sites[]" value="<?php echo $_val[1]?>"<?php if(strstr($_names[1],'['.$_val[1].']')):?> checked<?php endif?>>
						  <label class="custom-control-label" for="aply_sites_<?php echo $_val[1]?>"><?php echo $_val[0]?> <small class="text-muted">(<?php echo $_val[1]?>)</small></label>
						</div>
						<?php endforeach?>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-lg-10 offset-lg-2 col-xl-9 offset-xl-2 clearfix">
						<div class="btn-group">
							<button type="button" class="btn btn-light" onclick="checkboxChoice('aply_sites[]',true);">전체선택</button>
							<button type="button" class="btn btn-light" onclick="checkboxChoice('aply_sites[]',false);">전체취소</button>
						</div>
						<button class="btn btn-primary ml-3" type="submit" id="rb-submit-button"><i class="fa fa-check fa-lg"></i> 저장하기</button>
					</div>
				</div>
			</div><!-- /.card-body -->
		</form><!-- /.card -->


		<?php else:?>
		<form name="saveForm" role="form" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);" class="card rounded-0 border-0">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="config">
			<input type="hidden" name="layout" value="">
			<input type="hidden" name="m_layout" value="">

			<div class="card-header d-flex justify-content-between align-items-center py-1">
				검색범위
				<div class="">
					<div class="btn-group rb-btn-view">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" class="btn btn-light">전체</a>
						<button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu dropdown-menu-right" role="menu">
							<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>" target="_blank">
								<i class="fa fa-external-link"></i> 최근 3년
							</a>
						</div>
					</div>
				</div>
			</div><!-- /.card-header -->

			<div class="card-body">
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">검색테마</label>
					<div class="col-lg-10 col-xl-9">
						<select class="form-control custom-select" name="theme">
							<optgroup label="데스크탑">
								<?php $dirs = opendir($g['path_module'].$module.'/themes/_desktop')?>
								<?php while(false !== ($theme = readdir($dirs))):?>
								<?php if(strpos('_..',$theme))continue?>
								<option value="_desktop/<?php echo $theme?>"<?php if($d['search']['theme']=='_desktop/'.$theme):?> selected<?php endif?>><?php echo $theme?></option>
								<?php endwhile?>
								<?php closedir($dirs)?>
							</optgroup>
							<optgroup label="모바일">
								<?php $dirs = opendir($g['path_module'].$module.'/themes/_mobile')?>
								<?php while(false !== ($theme = readdir($dirs))):?>
								<?php if(strpos('_..',$theme))continue?>
								<option value="_mobile/<?php echo $theme?>"<?php if($d['search']['theme']=='_mobile/'.$theme):?> selected<?php endif?>><?php echo $theme?></option>
								<?php endwhile?>
								<?php closedir($dirs)?>
							</optgroup>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">
						<span class="badge badge-dark">모바일</span>
					</label>
					<div class="col-lg-10 col-xl-9">
						<select class="form-control custom-select" name="m_theme">
							<optgroup label="데스크탑">
								<?php $dirs = opendir($g['path_module'].$module.'/themes/_desktop')?>
								<?php while(false !== ($theme = readdir($dirs))):?>
								<?php if(strpos('_..',$theme))continue?>
								<option value="_desktop/<?php echo $theme?>"<?php if($d['search']['m_theme']=='_desktop/'.$theme):?> selected<?php endif?>><?php echo $theme?></option>
								<?php endwhile?>
								<?php closedir($dirs)?>
							</optgroup>
							<optgroup label="모바일">
								<?php $dirs = opendir($g['path_module'].$module.'/themes/_mobile')?>
								<?php while(false !== ($theme = readdir($dirs))):?>
								<?php if(strpos('_..',$theme))continue?>
								<option value="_mobile/<?php echo $theme?>"<?php if($d['search']['m_theme']=='_mobile/'.$theme):?> selected<?php endif?>><?php echo $theme?></option>
								<?php endwhile?>
								<?php closedir($dirs)?>
							</optgroup>

						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">검색범위</label>
					<div class="col-lg-10 col-xl-9">
						<select name="term" class="form-control custom-select">
							<option value="360"<?php if($d['search']['term']==360):?> selected="selected"<?php endif?>>전체</option>
							<option value="36"<?php if($d['search']['term']==36):?> selected="selected"<?php endif?>>최근 3년</option>
							<option value="24"<?php if($d['search']['term']==24):?> selected="selected"<?php endif?>>최근 2년</option>
							<option value="12"<?php if($d['search']['term']==12):?> selected="selected"<?php endif?>>최근 1년</option>
							<option value="6"<?php if($d['search']['term']==6):?> selected="selected"<?php endif?>>최근 6개월</option>
							<option value="3"<?php if($d['search']['term']==3):?> selected="selected"<?php endif?>>최근 3개월</option>
							<option value="1"<?php if($d['search']['term']==1):?> selected="selected"<?php endif?>>최근 한달</option>
						</select>
						<p class="form-text text-muted">
							<small>검색양에 따라 처리속도가 느려질 수 있습니다. 적절한 기간을 지정해 주세요.</small>
						</p>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">검색 결과수</label>
					<div class="col-lg-10 col-xl-9">

						<div class="input-group" style="width:250px">
							<div class="input-group-prepend">
						    <span class="input-group-text">통합검색시</span>
						  </div>
							<input type="text" name="num1" size="5" value="<?php echo $d['search']['num1']?>" class="form-control text-center">
							<div class="input-group-append">
						    <span class="input-group-text">개</span>
						  </div>
						</div>
						<div class="input-group" style="width:250px;margin-top:10px">
							<div class="input-group-prepend">
						    <span class="input-group-text">세부검색시</span>
						  </div>
							<input type="text" name="num2" size="5" value="<?php echo $d['search']['num2']?>" class="form-control text-center">
							<div class="input-group-append">
						    <span class="input-group-text">개</span>
						  </div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">레이아웃</label>
					<div class="col-lg-10 col-xl-9">

						<div class="form-row">
							<div class="col-sm-6" id="rb-layout-select">
								<select class="form-control custom-select" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','');">
									<?php $_layoutHexp=explode('/',$_HS['layout'])?>
									<option value="0">사이트 레이아웃(<?php echo getFolderName($g['path_layout'].$_layoutHexp[0])?>)</option>
									<?php $_layoutExp1=explode('/',$d['search']['layout'])?>
									<?php $dirs = opendir($g['path_layout'])?>
									<?php while(false !== ($tpl = readdir($dirs))):?>
									<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
									<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
									<?php endwhile?>
									<?php closedir($dirs)?>
								</select>
							</div>
							<div class="col-sm-6" id="rb-layout-select2">
								<select class="form-control custom-select" name="layout_1_sub"<?php if(!$d['search']['layout']):?> disabled<?php endif?>>
									<?php if(!$d['search']['layout']):?><option>서브 레이아웃</option><?php endif?>
									<?php $dirs1 = opendir($g['path_layout'].$_layoutExp1[0])?>
									<?php while(false !== ($tpl1 = readdir($dirs1))):?>
									<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
									<option value="<?php echo $tpl1?>"<?php if($_layoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
									<?php endwhile?>
									<?php closedir($dirs1)?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">
						<span class="badge badge-dark">모바일</span>
					</label>
					<div class="col-lg-10 col-xl-9">

						<div class="form-row">
							<div class="col-sm-6" id="rb-layout-select3">
								<select class="form-control custom-select" name="m_layout_1" required onchange="getSubLayout(this,'rb-layout-select4','m_layout_1_sub','');">
									<?php $_mlayoutHexp=explode('/',$_HS['m_layout'])?>
									<option value="0">사이트 레이아웃(<?php echo getFolderName($g['path_layout'].$_mlayoutHexp[0])?>)</option>
									<?php $_mlayoutExp1=explode('/',$d['search']['m_layout'])?>
									<?php $dirs = opendir($g['path_layout'])?>
									<?php while(false !== ($tpl = readdir($dirs))):?>
									<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
									<option value="<?php echo $tpl?>"<?php if($_mlayoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
									<?php endwhile?>
									<?php closedir($dirs)?>
								</select>
							</div>
							<div class="col-sm-6" id="rb-layout-select4">
								<select class="form-control custom-select" name="m_layout_1_sub"<?php if(!$d['search']['m_layout']):?> disabled<?php endif?>>
									<?php if(!$d['search']['m_layout']):?><option>서브 레이아웃</option><?php endif?>
									<?php $dirs1 = opendir($g['path_layout'].$_mlayoutExp1[0])?>
									<?php while(false !== ($tpl1 = readdir($dirs1))):?>
									<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
									<option value="<?php echo $tpl1?>"<?php if($_mlayoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
									<?php endwhile?>
									<?php closedir($dirs1)?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">외부검색</label>
					<div class="col-lg-10 col-xl-9">
						<textarea name="searchlist" class="form-control" rows="5"><?php echo trim(implode('',file($g['path_module'].$module.'/var/search.list.txt')))?></textarea>
						<p class="form-text text-muted">
							<small>검색엔진명과 검색URL을 콤마(,)로 구분해서 등록해 주세요. 외부검색을 이용해 검색어를 선택된 검색엔진으로 연결해 줍니다.</small>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-10 offset-lg-2 col-xl-9 offset-xl-2">
						<button type="submit" class="btn btn-outline-primary btn-lg my-4 btn-block" id="rb-submit-button">확인</button>
					</div>
				</div>
			</div><!-- /.card-body -->
		</form><!-- /.card -->

		<?php endif?>

	</div>
</div>




<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js')?>
<script>
$(document).ready(function() {

	putCookieAlert('search_config_result') // 실행결과 알림 메시지
	$('#nestable-menu').nestable();
	$('.dd').on('change', function() {
		orderUpdate();
	});

	<?php if (!$searchfile): ?>
	//사이트 셀렉터 출력
	$('[data-role="siteSelector"]').removeClass('d-none')
	<?php endif; ?>

});

function orderUpdate()
{
	var f = document.forms[0];
	f.auto.value = '1';
	getIframeForAction(f);
	f.submit();
}
function procCheck(f)
{
	if (f.name.value == '')
	{
		alert('검색 페이지명을 입력해 주세요.   ');
		f.name.focus();
		return false;
	}

	getIframeForAction(f);
	return confirm('정말로 실행하시겠습니까?  ');
}
function saveCheck(f)
{
	if(f.layout_1.value != '0') f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	else f.layout.value = '';

	if(f.m_layout_1.value != '0') f.m_layout.value = f.m_layout_1.value + '/' + f.m_layout_1_sub.value;
	else f.m_layout.value = '';

	getIframeForAction(f);
	// return confirm('정말로 실행하시겠습니까?   ');
}
<?php if($_nowOrderNum != count($d['search_order']) || $autoCheck=='Y'):?>
setTimeout("orderUpdate();",100);
<?php endif?>

</script>
