<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
$SITEN = db_num_rows($SITES);
include $g['path_core'].'function/menu.func.php';
$ISCAT = getDbRows($table['s_menu'],'site='.$_HS['uid']);
if($cat){
	$CINFO = getUidData($table['s_menu'],$cat);
	$_SEO = getDbData($table['s_seo'],'rel=1 and parent='.$CINFO['uid'],'*');
	$ctarr = getMenuCodeToPath($table['s_menu'],$cat,0);	$ctnum = count($ctarr);
	$CINFO['code'] = '';
	for ($i = 0; $i < $ctnum; $i++) {
		$CXA[] = $ctarr[$i]['uid'];
		$CINFO['code'] .= $ctarr[$i]['id'].($i < $ctnum-1 ? '/' : '');
		$_code .= $ctarr[$i]['uid'].($i < $ctnum-1 ? '/' : '');
	}
	$code = $code ? $code : $_code;
}
$catcode = '';
$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';

if ($is_regismode){
	$CINFO['menutype'] = '4';
	$CINFO['name']	   = '';
	$CINFO['joint']	   = '';
	$CINFO['redirect'] = '';
	$CINFO['hidden']   = '';
	$CINFO['target']   = '';
	$CINFO['imghead']  = '';
	$CINFO['imgfoot']  = '';
	$CINFO['imgicon']  = '';
}
$menuType = array('','모듈연결','코드편집','메뉴연결','문서편집');
?>

<div id="catebody" class="row no-gutters">
	<nav id="category" class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar">
		<div id="accordion">
			<div class="card border-0">
				<div class="card-header p-0">
					<a class="d-block accordion-toggle muted-link<?php if($_SESSION['site_menu_collapse']):?> collapsed<?php endif?>"
						 data-toggle="collapse"
					   onclick="sessionSetting('site_menu_collapse','','','');"
						 href="#menutree">
						<i class="fa fa-sitemap fa-lg fa-fw"></i>
						메뉴구조
					</a>
				</div>

				<div class="collapse<?php if(!$_SESSION['site_menu_collapse']):?> show<?php endif?>" id="menutree" data-parent="#accordion">

					<?php if($ISCAT):?>
					<div class="card-body">
						<?php $_treeOptions=array('site'=>$s,'table'=>$table['s_menu'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>false,'allOpen'=>false,'bookmark'=>'site-menu-info')?>
						<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
						<?php echo getTreeMenu($_treeOptions,$code,0,0,'')?>
					</div>

					<div class="card-footer">
						<div class="btn-group dropup btn-block">
							<button type="button" class="btn btn-light dropdown-toggle btn-block" data-toggle="dropdown">
								<i class="fa fa-download fa-lg"></i> 구조 내려받기
							</button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xml" target="_blank">XML로 생성/받기</a>
								<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=xls" target="_action_frame_<?php echo $m?>">엑셀로 받기</a>
								<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=txt" target="_action_frame_<?php echo $m?>">텍스트파일로 받기</a>
								<a class="dropdown-item" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=dumpmenu&amp;type=package_menu" target="_action_frame_<?php echo $m?>">패키지용 데이터 받기</a>
								</div>
						</div>
					</div>
					<?php else: ?>
					<div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 9.1rem);">
						 <div><i class="fa fa-exclamation-circle fa-3x mb-2" aria-hidden="true"></i> <br>등록된 메뉴가 없습니다. </div>
					</div>
					<?php endif?>

				</div>
			</div>

			<?php if($g['device']):?><a name="site-menu-info"></a><?php endif?>
			<div class="card">
				<div class="card-header p-0">
					<a class="d-block accordion-toggle muted-link<?php if($_SESSION['site_menu_collapse']!='order'):?> collapsed<?php endif?>"
						 data-toggle="collapse"
 					   onclick="sessionSetting('site_menu_collapse','order','','');"
						 href="#menuOrder">
						<i class="fa fa-retweet fa-lg fa-fw"></i>
						순서 조정
					</a>
				</div>
				<div class="collapse<?php if($_SESSION['site_menu_collapse']=='order'):?> show<?php endif?>" id="menuOrder" data-parent="#accordion" >
					<?php if($CINFO['is_child']||(!$cat&&$ISCAT)):?>
					<form role="form" action="<?php echo $g['s']?>/" method="post">
						<input type="hidden" name="r" value="<?php echo $r?>">
						<input type="hidden" name="m" value="<?php echo $module?>">
						<input type="hidden" name="a" value="modifymenugid">

						<div class="card-body">
							<div class="dd" id="nestable-menu">
								<ol class="dd-list">
								<?php $_MENUS=getDbSelect($table['s_menu'],'site='.$s.' and parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
								<?php $_i=1;while($_M=db_fetch_array($_MENUS)):?>
								<li class="dd-item" data-id="<?php echo $_i?>">
								<input type="checkbox" name="menumembers[]" value="<?php echo $_M['uid']?>" checked class="d-none">
								<div class="dd-handle"><i class="fa fa-arrows fa-fw"></i> <?php echo $_M['name']?></div>
								</li>
								<?php $_i++;endwhile?>
								</ol>
							</div>
						</div>
					</form>

					<!-- nestable : https://github.com/dbushell/Nestable -->
					<?php getImport('nestable','jquery.nestable',false,'js') ?>
					<script>
					$('#nestable-menu').nestable();
					$('.dd').on('change', function() {
						var f = document.forms[0];
						getIframeForAction(f);
						f.submit();
					});
					</script>

					<?php else:?>

					<div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 15.6rem);">
						 <div>
							 <i class="fa fa-exclamation-circle fa-3x mb-2" aria-hidden="true"></i> <br>
							 <?php if($cat):?>
							 <?php echo sprintf('[%s] 하위에 등록된 메뉴가 없습니다.',$CINFO['name'])?>
							 <?php else:?>
							 등록된 메뉴가 없습니다.
							 <?php endif?>
						 </div>
					</div>

					<?php endif?>
				</div>
			</div>

		</div>
	</nav>
	<div id="catinfo" class="col-sm-8 col-md-8 ml-sm-auto col-xl-9">
		<form class="card rounded-0 border-0" name="procForm" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" onsubmit="return saveCheck(this);" autocomplete="off">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="regismenu">
			<input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>">
			<input type="hidden" name="code" value="<?php echo $code?>">
			<input type="hidden" name="vtype" value="<?php echo $vtype?>">
			<input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>">
			<input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>">
			<input type="hidden" name="perm_g" value="<?php echo $CINFO['perm_g']?>">
			<input type="hidden" name="seouid" value="<?php echo $_SEO['uid']?>">
			<input type="hidden" name="layout" value="">
			<input type="hidden" name="m_layout" value="">
			<input type="hidden" name="menutype" value="<?php echo $CINFO['uid']?$CINFO['menutype']:4?>">

			<div class="card-header d-flex justify-content-between align-items-center page-body-header">

				<?php if($is_regismode):?>
				<input type="hidden" name="mobile" value="1">
				<?php if($vtype == 'sub'):?>서브메뉴 만들기<?php else:?>최상위 메뉴 만들기<?php endif?>
				<?php else:?>
				<h4 class="h5 mb-0">메뉴 등록정보 <span class="badge badge-primary badge-pill"><?php echo $CINFO['name']?></span></h4>
				<a href="<?php echo $g['adm_href']?>" class="btn btn-light"><i class="fa fa-plus"></i> 최상위 새 메뉴</a>
				<?php endif?>

			</div><!-- /.card-header -->


			<div class="card-body">

				<?php if($vtype == 'sub'):?>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">상위메뉴</label>
					<div class="col-lg-10 col-xl-9">
						<ol class="breadcrumb">
							<?php for ($i = 0; $i < $ctnum; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid']) ?>
							<li class="breadcrumb-item"><a class="muted-link" href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>"><?php echo $ctarr[$i]['name']?></a></li>
							<?php $catcode .= $ctarr[$i]['id'].'/';endfor?>
						</ol>
					</div>
					</div>
					<?php else:?>

				<?php if($cat):?>
					<div class="form-group row">
					<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">상위메뉴</label>
					<div class="col-lg-10 col-xl-9">
						<ol class="breadcrumb">
							<?php for ($i = 0; $i < $ctnum-1; $i++):$subcode=$subcode.($i?'/'.$ctarr[$i]['uid']:$ctarr[$i]['uid'])?>
							<li class="breadcrumb-item">
								<a class="muted-link" href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $ctarr[$i]['uid']?>&amp;code=<?php echo $subcode?>">
									<?php echo $ctarr[$i]['name']?>
								</a>
							</li>
							<?php $delparent=$ctarr[$i]['uid'];$catcode .= $ctarr[$i]['id'].'/';endfor?>
							<?php if(!$delparent):?>최상위 메뉴<?php endif?>
						</ol>
					</div>
					</div>
				<?php endif?>
				<?php endif?>

					<div class="form-group row rb-outside">
					<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">메뉴명</label>
					<div class="col-lg-10 col-xl-9">
						<?php if($is_fcategory):?>
						<div class="input-group input-group-lg">
								<?php if($CINFO['uid']):?>
								<span class="input-group-append">
									<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" title="메뉴의 형식">
										<span id="rb-document-type"><?php echo $menuType[$CINFO['menutype']]?></span>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="#" onclick="docType(4,'<?php echo $menuType[4]?>');"><i class="fa fa-file-text-o"></i> <?php echo $menuType[4]?></a>
										<a class="dropdown-item" href="#" onclick="docType(2,'<?php echo $menuType[2]?>');"><i class="fa fa-code"></i> <?php echo $menuType[2]?></a>
										<a class="dropdown-item" href="#" onclick="docType(1,'<?php echo $menuType[1]?>');"><i class="kf kf-module"></i> <?php echo $menuType[1]?></a>
										<a class="dropdown-item" href="#" onclick="docType(3,'<?php echo $menuType[3]?>');"><i class="fa fa-sitemap"></i> <?php echo $menuType[3]?></a>
									</div>
								</span>
								<?php endif?>

							<input class="form-control border-left-0" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$cat && !$g['device']):?> autofocus<?php endif?> required autocomplete="off">
							<span class="input-group-append">
								<a href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;vtype=sub" class="btn btn-light" data-tooltip="tooltip" title="서브메뉴 만들기">
									<i class="fa fa-share fa-rotate-90 fa-lg"></i>
								</a>
							</span>
							<span class="input-group-append">
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletemenu&amp;cat=<?php echo $cat?>&amp;parent=<?php echo $delparent?>&amp;code=<?php echo substr($catcode,0,strlen($catcode)-1)?>" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');" class="btn btn-light rounded-0" data-tooltip="tooltip" title="메뉴삭제">
									<i class="fa fa-trash-o fa-lg"></i>
								</a>
							</span>
						</div>

						<?php else:?>

						<div class="input-group input-group-lg">
							<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $CINFO['name']?>"<?php if(!$g['device']):?> autofocus<?php endif?> required  autocomplete="off">
							<span class="input-group-append">
								<button class="btn btn-light rb-help-btn rounded-0" type="button" data-toggle="collapse" data-target="#guide_new" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
							</span>
						</div>

						<div id="guide_new" class="collapse help-block">

							<small class="form-text text-muted">
								복수의 메뉴를 한번에 등록하시려면 메뉴명을 콤마(,)로 구분해 주세요.'<br>
								보기: <code>회사소개,커뮤니티,고객센터</code>
							</small>
							<small class="form-text text-muted">
								메뉴코드를 같이 등록하시려면 다음과 같은 형식으로 등록해 주세요.<br>
								보기: <code>회사소개=company,커뮤니티=community,고객센터=center</code>
							</small>

						</div>
						<?php endif?>

						</div>
				</div>

					<div class="tab-content<?php if(!$CINFO['uid']||$vtype=='sub'):?> d-none<?php endif?>">

						<div class="form-group form-row" id="editBox1"<?php if($CINFO['menutype']!=1):?> hidden<?php endif?>>
							<div class="col-lg-10 col-xl-9 offset-lg-2">
								<fieldset>
									<div class="input-group">
										<input type="text" name="joint" id="jointf" value="<?php echo $CINFO['joint']?>" class="form-control">
										<span class="input-group-append">
											<button class="btn btn-light rb-modal-module" type="button" title="모듈연결" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window"><i class="fa fa-link fa-lg"></i></button>
										</span>
										<span class="input-group-append">
											<button class="btn btn-light" type="button" title="미리보기" data-tooltip="tooltip" onclick="getId('jointf').value!=''?window.open(getId('jointf').value):alert('모듈연결 주소를 등록해 주세요.');">Go!</button>
										</span>
									</div>
								</fieldset>
								<div class="form-text mt-2">

									<div class="custom-control custom-checkbox">
									  <input type="checkbox" class="custom-control-input" name="redirect" id="xredirect" value="1"<?php if($CINFO['redirect']):?> checked<?php endif?>>
									  <label class="custom-control-label" for="xredirect">입력된 주소로 리다이렉트 시켜줍니다. <small> (외부주소 링크시 사용)</small></label>
									</div>

									<small>
										<ul class="text-muted pl-3 mt-1">
											<li>이 메뉴에 연결시킬 모듈이 있을 경우 모듈연결을 클릭한 후 선택해 주세요.</li>
											<li>모듈 연결주소가 지정되면 이 메뉴를 호출시 연결주소의 모듈이 출력됩니다.</li>
											<li>접근권한은 연결된 모듈의 권한설정을 따릅니다.</li>
										</ul>
									</small>
								</div>
							</div>
						</div>
						<div class="form-group form-row" id="editBox2"<?php if($CINFO['menutype']!=2):?> hidden<?php endif?>>
							<div class="col-lg-10 col-xl-9 offset-lg-2">

								<p class="text-muted small mb-1">파일경로</p>
								<ol class="breadcrumb  mb-2 py-1 small">
								 <li class="breadcrumb-item active">기본 &nbsp; : </li>
								 <li class="breadcrumb-item">pages</li>
								 <li class="breadcrumb-item"><?php echo $r ?>-menus</li>
								 <li class="breadcrumb-item"><a href="#" class="rb-modal-code" data-toggle="buttons"><?php echo $CINFO['id']?>.php</a></li>
							 </ol>
								<ol class="breadcrumb py-1 small">
									<li class="breadcrumb-item active">모바일 : </li>
									<li class="breadcrumb-item">pages</li>
									<li class="breadcrumb-item"><?php echo $r ?>-menus</li>
									<li class="breadcrumb-item"><a href="#" class="rb-modal-code-mobile" data-toggle="buttons"><?php echo $CINFO['id']?>.mobile.php</a></li>
								</ol>

								<small>
									<ul class="form-text text-muted pl-3 mt-3">
										<li>직접편집은 <code>PHP</code> <code>HTML</code> <code>CSS</code> <code>JS</code> 코드로 직접 편집할 수 있습니다.</li>
										<li>FTP로 접속후 텍스트 에디터를 통해 파일편집을 추천합니다.</li>
										<li>간단한 편집은 <a href="#" data-toggle="buttons" class="badge badge-dark rb-modal-code"><i class="fa fa-code"></i> 편집기</a> 활용하시면 편리합니다.</li>
									</ul>
								</small>
							</div>
						</div>
						<div class="form-group form-row" id="editBox3"<?php if($CINFO['menutype']!=3):?> hidden<?php endif?>>
							<div class="col-lg-10 col-xl-9 offset-lg-2">
								<fieldset>

									<select name="joint_menu" class="form-control custom-select" >
								    <option value="">연결시킬 메뉴를 선택해 주세요.</option>
								    <option value="" disabled>--------------------------------</option>
								    <?php include_once $g['path_core'].'function/menu1.func.php'?>
								    <?php $cat=$CINFO['joint']?>
								    <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
							    </select>

								</fieldset>
								<div class="form-text mt-2">
									<small class="text-muted mt-1">
										선택된 메뉴로 리다이렉트 됩니다.
									</small>
								</div>
							</div>
						</div>

						<div class="form-group form-row" id="editBox4"<?php if($CINFO['menutype']!=4):?> hidden<?php endif?>>
							<div class="col-lg-10 col-xl-9 offset-lg-2">
								<fieldset<?php if($CINFO['menutype']!=4):?> disabled<?php endif?>>
									<div class="btn-group btn-group-justified" data-toggle="buttons">
										<button type="button" class="btn btn-light rb-modal-wysiwyg">기본</button>
										<button type="button" class="btn btn-light rb-modal-wysiwyg-mobile">모바일 전용</button>

									</div>
								</fieldset>
								<div class="form-text mt-2">
									<small>
										<ul class="form-text text-muted pl-3 mt-3">
											<li>마크다운 문법을 사용하여 문서를 편집할 수 있습니다.</li>
											<li>소스코드로 작성한 페이지를 마크다운으로 재편집하면 소스코드가 변형될 수 있으니 유의하세요.</li>
										</ul>
									</small>
								</div>
							</div>
						</div>
					</div>

				<?php if($CINFO['uid']&&!$vtype):?>
					<div class="form-group row rb-outside">
						<label class="col-lg-2 col-form-label text-lg-right"></label>
						<div class="col-lg-10 col-xl-9">

							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="mobileCheck"  name="mobile" value="1"<?php if($CINFO['mobile']||!$CINFO['uid']):?> checked<?php endif?>>
							  <label class="custom-control-label" for="mobileCheck">모바일 출력</label>
							</div>

						</div>
					</div>


				<div class="form-group row rb-outside">
					<label class="col-lg-2 col-form-label text-lg-right">코드</label>
					<div class="col-lg-10 col-xl-9">
						<input class="form-control" placeholder="미등록시 자동생성 됩니다." type="text" name="id" value="<?php echo $CINFO['id']?>" maxlength="20">
						<button type="button" class="btn btn-link text-muted mt-2 pl-0" data-toggle="collapse" data-target="#guide_menucode">
							<i class="fa fa-question-circle fa-fw"></i>
							메뉴를 잘 표현할 수 있는 단어로 입력해 주세요.
						</button>

						<div id="guide_menucode" class="collapse">
							<small>
								<ul class="form-text text-muted pl-3 mt-2">
									<li>영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.</li>
									<li>보기) 메뉴호출주소 : <code><?php echo RW('c=<span class="b">CODE</span>')?></code></li>
									<li>메뉴코드는 중복될 수 없습니다.</li>
								</ul>
							</small>
						</div>
					</div>
				</div>

				<?php $_url_1 = $g['s'].'/?r='.$r.'&c='.($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id'])?>
				<?php $_url_2 = $g['s'].'/'.$r.'/c/'.($vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id'])?>
				<?php $_url_3 =$vtype?substr($catcode,0,strlen($catcode)-1):$catcode.$CINFO['id'] ?>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">주소</label>
					<div class="col-lg-10 col-xl-9">

						<div class="input-group" style="margin-bottom: 5px">
							<div class="input-group-prepend">
								<span class="input-group-text">물리주소</span>
							</div>
							<input id="_url_m_1_" type="text" class="form-control" value="<?php echo $_url_1?>" readonly>
							<span class="input-group-append">
								<a href="#." class="btn btn-light js-clipboard" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#_url_m_1_"><i class="fa fa-clipboard"></i></a>
								<a href="<?php echo $_url_1?>" target="_blank" class="btn btn-light" data-tooltip="tooltip" title="접속">Go!</a>
							</span>
						</div>

						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">고유주소</span>
							</div>
							<input id="_url_m_2_" type="text" class="form-control" value="<?php echo $_url_2?>" readonly>
							<span class="input-group-append">
								<a href="#." class="btn btn-light js-clipboard" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#_url_m_2_"><i class="fa fa-clipboard"></i></a>
								<a href="<?php echo $_url_2?>" target="_blank" class="btn btn-light" data-tooltip="tooltip" title="접속">Go!</a>
							</span>
						</div>

						<div class="input-group mt-2">
							<div class="input-group-prepend">
								<span class="input-group-text">코드삽입</span>
							</div>
							<input id="_url_m_3_" type="text" class="form-control" value="&lt;?php echo RW('c=<?php echo $_url_3?>') ?&gt;" readonly>
							<span class="input-group-append">
								<a href="#." class="btn btn-light js-clipboard" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#_url_m_3_"><i class="fa fa-clipboard"></i></a>
							</span>
						</div>

					</div>
				</div>
				<?php endif?>


					<div id="menu-settings" class="mt-5">
							<!-- 메타설정-->
							<div class="card mb-2" id="menu-settings-meta">
								<div class="card-header p-0">
									<a class="d-block pl-3 pr-4 muted-link<?php if(!$code && $_SESSION['sh_site_menu_1']!=1):?> collapsed<?php endif?>" data-toggle="collapse" href="#menu-settings-meta-body">
										메타설정
									</a>
								</div>
								<div id="menu-settings-meta-body" class="panel-collapse collapse<?php if($code && $_SESSION['sh_site_menu_1']==1):?> show<?php endif?>" data-parent="#menu-settings">
									<div class="card-body">
										<div class="form-group row rb-outside">
											<label class="col-lg-2 col-form-label text-lg-right">타이틀</label>
											<div class="col-lg-10 col-xl-9">
												<div class="input-group">
													<input type="text" class="form-control rb-title" name="title" value="<?php echo $_SEO['title']?>" maxlength="60" placeholder="50-60자 내에서 작성해 주세요.">
													<span class="input-group-append">
														<button class="btn btn-light rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_title" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
													</span>
												</div>
												<div class="mt-2 collapse" id="guide_title">
													<small>
														<code>&lt;meta name=&quot;title&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.
													</small>
												</div>
											</div>
										</div>

										<div class="form-group row rb-outside">
											<label class="col-lg-2 col-form-label text-lg-right">설명</label>
											<div class="col-lg-10 col-xl-9">
												<textarea name="description" class="form-control rb-description_" rows="5" placeholder="150-160자 내에서 작성해 주세요."><?php echo $_SEO['description']?></textarea>
												<a class="badge badge-pill badge-dark mt-2" href="#guide_description" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i>도움말</a>
												<div class="collapse" id="guide_description">
													<small class="text-muted">
														<code>&lt;meta name=&quot;description&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.<br>
															검색 결과에 표시되는 문자를 지정합니다.설명글은 엔터없이 입력해 주세요.<br>
															보기)웹 프레임워크의 혁신 - 킴스큐 Rb 에 대한 다운로드,팁 공유등을 제공합니다. <a href=&quot;http://moz.com/learn/seo/meta-description&quot; target=&quot;_blank&quot;>참고</a>
													</small>
												</div>
											</div>
										</div>


											<div class="form-group row">

												<label class="col-lg-2 col-form-label text-lg-right">키워드</label>
											<div class="col-lg-10 col-xl-9">
												<input name="keywords" class="form-control" placeholder="콤마(,)로 구분하여 입력해 주세요." value="<?php echo $_SEO['keywords']?>">
												<a class="badge badge-pill badge-dark mt-2" href="#guide_keywords" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i>도움말</a>
												<div class="help-block collapse" id="guide_keywords">
													<small class="text-muted">
														<code>&lt;meta name=&quot;keywords&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.<br>
															핵심 키워드를 콤마로 구분하여 20개 미만으로 엔터없이 입력해 주세요.<br>
															보기)킴스큐,킴스큐Rb,CMS,웹프레임워크,큐마켓
													</small>
												</div>
											</div>
										</div>
											<div class="form-group row">
												<label class="col-lg-2 col-form-label text-lg-right">크롤링</label>
												<div class="col-lg-10 col-xl-9">
													<input name="classification" class="form-control" placeholder="" value="<?php echo $_SEO['uid']?$_SEO['classification']:'ALL'?>">
													<a class="badge badge-pill badge-dark mt-2" href="#guide_classification" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i>도움말</a>
													<div class="help-block collapse" id="guide_classification">
														<small class="text-muted">
															<code>&lt;meta name=&quot;robots&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.<br>
															all,noindex,nofollow,none 등으로 지정할 수 있습니다.<br>
														</small>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-lg-2 col-form-label text-lg-right">메타이미지</label>
												<div class="col-lg-10 col-xl-9">
													<div class="input-group">
														<input class="form-control rb-modal-photo-drop" onmousedown="_mediasetField='meta_image_src&dfiles='+this.value;" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window" type="text" name="image_src" id="meta_image_src" value="<?php echo $_SEO['image_src']?$_SEO['image_src']:''?>">
														<div class="input-group-append">
															<button class="btn btn-light rb-modal-photo1" type="button" title="포토셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
																<i class="fa fa-photo fa-lg"></i>
															</button>
														</div>
													</div>

													<a class="badge badge-pill badge-dark mt-2" href="#guide_image_src" data-toggle="collapse" ><i class="fa fa-question-circle fa-fw"></i>도움말</a>
													<div class="help-block collapse" id="guide_image_src">
														<small class="text-muted">
															이미지를 등록하시면 소셜미디어에 이 이미지를 포함하여 전송할 수 있습니다.<br>
															이미지를 직접 지정하려면 이미지의 URL을 입력해 주세요.<br>
														</small>
													</div>
												</div>
											</div>
										</div>

										<div class="card-footer">
											<small class="text-muted">
												<i class="fa fa-info-circle fa-lg fa-fw"></i> meta 정보 설정은 검색엔진최적화, 소셜미디어 최적화와 직접 관련이 있습니다.
											</small>
									</div>
								</div>
							</div>

							<div class="card" id="menu-settings-advance"><!--고급설정-->

								<div class="card-header p-0">
									<a class="d-block pl-3 pr-4 muted-link<?php if(!$code && $_SESSION['sh_site_menu_1']!=2):?> collapsed<?php endif?>" data-toggle="collapse" href="#menu-settings-advance-body">
										고급설정
									</a>
								</div>

								<div id="menu-settings-advance-body" class="panel-collapse collapse<?php if($code && $_SESSION['sh_site_menu_1']==2):?> show<?php endif?>" data-parent="#menu-settings">
								<div class="card-body">
										<div class="form-group row">
											<label class="col-lg-2 col-form-label text-lg-right">레이아웃</label>
											<div class="col-lg-10 col-xl-9">
												<div class="form-row">
													<div class="col-sm-6" id="rb-layout-select">
														<select class="form-control custom-select" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','custom-select');">
															<?php $_layoutHexp=explode('/',$_HS['layout'])?>
															<option value="0">사이트 레이아웃 (<?php echo $_layoutHexp[0]?>)</option>
															<option disabled>--------------------</option>
															<?php $_layoutExp1=explode('/',$CINFO['layout'])?>
															<?php $dirs = opendir($g['path_layout'])?>
															<?php while(false !== ($tpl = readdir($dirs))):?>
															<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
															<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?> (<?php echo $tpl?>)</option>
															<?php endwhile?>
															<?php closedir($dirs)?>
														</select>
													</div>
													<div class="col-sm-6" id="rb-layout-select2">
														<select class="form-control custom-select" name="layout_1_sub"<?php if(!$CINFO['layout']):?> disabled<?php endif?>>
															<?php if(!$CINFO['layout']):?><option>서브 레이아웃</option><?php endif?>
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
													<div class="col-sm-6" id="rb-m_layout-select">
														<select class="form-control custom-select" name="m_layout_1" onchange="getSubLayout(this,'rb-m_layout-select2','m_layout_1_sub','custom-select');">
															<?php if ($_HS['m_layout']): ?>
															<?php $_layoutHexp=explode('/',$_HS['m_layout'])?>
															<option value="0">사이트 레이아웃 (<?php echo $_layoutHexp[0]?>)</option>
															<?php else: ?>
															<option value="0">&nbsp;사용안함 (기본 레이아웃 적용)</option>
															<?php endif; ?>
															<option disabled>--------------------</option>
															<?php $_layoutExp1=explode('/',$CINFO['m_layout'])?>
															<?php $dirs = opendir($g['path_layout'])?>
															<?php while(false !== ($tpl = readdir($dirs))):?>
															<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
															<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
															<?php endwhile?>
															<?php closedir($dirs)?>
														</select>
													</div>
													<div class="col-sm-6" id="rb-m_layout-select2">
														<select class="form-control custom-select" name="m_layout_1_sub"<?php if(!$CINFO['m_layout']):?> disabled<?php endif?>>
															<?php if(!$CINFO['m_layout']):?><option value="0">서브 레이아웃</option><?php endif?>
															<?php $dirs1 = opendir($g['path_layout'].$_layoutExp1[0])?>
															<?php while(false !== ($tpl1 = readdir($dirs1))):?>
															<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
															<option value="<?php echo $tpl1?>"<?php if($_layoutExp1[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
															<?php endwhile?>
															<?php closedir($dirs1)?>
														</select>
													</div>
												</div>
												<?php if (!$_HS['m_layout']): ?>
												<small class="d-block mt-2 form-text text-muted">모바일 레이아웃을 지정하지 않으면 기본 레이아웃으로 설정됩니다.</small>
												<?php endif; ?>
											</div>
										</div>

										<div class="form-group row">
										<label class="col-lg-2 col-form-label text-lg-right">메뉴옵션</label>
										<div class="col-lg-10 col-xl-9">
											<div class="btn-group btn-group-toggle btn-group-justified" data-toggle="buttons">
												<label class="btn btn-light<?php if($CINFO['target']):?> active<?php endif?>">
													<input type="checkbox" name="target" value="_blank"<?php if($CINFO['target']):?> checked<?php endif?>>
													<i class="fa fa-window-restore" aria-hidden="true"></i>
													새창열기
												</label>
												<label class="btn btn-light<?php if($CINFO['hidden']):?> active<?php endif?>">
													<input type="checkbox" name="hidden" value="1"<?php if($CINFO['hidden']):?> checked<?php endif?>>
													<i class="fa fa-eye-slash" aria-hidden="true"></i>
													메뉴숨김
												</label>
												<label class="btn btn-light<?php if($CINFO['reject']):?> active<?php endif?>">
													<input type="checkbox" name="reject" value="1"<?php if($CINFO['reject']):?> checked<?php endif?>>
													<i class="fa fa-lock" aria-hidden="true"></i>
													메뉴잠금
												</label>
											</div>

											<a class="badge badge-pill badge-dark ml-3" data-toggle="collapse" href="#guide_mpro"><i class="fa fa-question-circle fa-fw"></i>도움말</a>

											<div id="guide_mpro" class="collapse">
												<dl class="row text-muted mt-3">
													<dt class="col-sm-2">모바일출력</dt>
													 <dd class="col-sm-10">모바일 레이아웃 사용시 이 메뉴를 출력합니다.</dd>
													<dt class="col-sm-2">새창열기</dt>
													 <dd class="col-sm-10">이 메뉴를 클릭시 새창으로 엽니다.</dd>
													<dt class="col-sm-2">메뉴숨김</dt>
													 <dd class="col-sm-10">메뉴를 출력하지 않습니다.(링크접근가능)</dd>
													<dt class="col-sm-2">메뉴잠금</dt>
													 <dd class="col-sm-10">메뉴의 접근을 차단합니다.(링크접근불가)</dd>
												</dl>
											</div>
										</div>
									</div>

										<div class="form-group row">
										<label class="col-lg-2 col-form-label text-lg-right">허용등급</label>
										<div class="col-lg-10 col-xl-9">
											<select class="form-control custom-select" name="perm_l">
												<option value="">전체허용</option>
												<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
												<?php while($_L=db_fetch_array($_LEVEL)):?>
												<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$CINFO['perm_l']):?> selected<?php endif?>><?php echo sprintf('%s 이상',$_L['name'].'('.number_format($_L['num']).')')?></option>
												<?php if($_L['gid'])break; endwhile?>
											</select>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-lg-right">차단그룹</label>
										<div class="col-lg-10 col-xl-9">
											<select class="form-control custom-select" name="_perm_g" multiple size="5">
												<option value=""<?php if(!$CINFO['perm_g']):?> selected="selected"<?php endif?>>차단안함</option>
												<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
												<?php while($_S=db_fetch_array($_SOSOK)):?>
												<option value="<?php echo $_S['uid']?>"<?php if(strstr($CINFO['perm_g'],'['.$_S['uid'].']')):?> selected<?php endif?>><?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
												<?php endwhile?>
											</select>

											<a class="badge badge-pill badge-dark mt-2" data-toggle="collapse" href="#guide_permg"><i class="fa fa-question-circle fa-fw"></i>도움말</a>
											<div id="guide_permg" class="collapse">
												<small>
													<ul class="text-muted mt-2">
														<li>복수의 그룹을 선택하려면 드래그하거나 <kbd>Ctrl</kbd> 를 누른다음 클릭해 주세요.</li>
													</ul>
												</small>
											</div>


											</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-2 col-form-label text-lg-right">캐시적용</label>
										<div class="col-lg-10 col-xl-9">
											<?php $cachefile = $g['path_page'].$r.'-menus/'.$CINFO['id'].'.txt'?>
											<?php $cachetime = file_exists($cachefile) ? implode('',file($cachefile)) : 0?>
											<select name="cachetime" class="form-control custom-select">
												<option value="">적용안함</option>
												<?php for($i = 1; $i < 61; $i++):?>
												<option value="<?php echo $i?>"<?php if($cachetime==$i):?> selected="selected"<?php endif?>><?php echo sprintf('%02d 분',$i)?></option>
												<?php endfor?>
											</select>

											<a class="badge badge-pill badge-dark mt-2" data-toggle="collapse" href="#guide_cache">
												<i class="fa fa-question-circle fa-fw"></i>도움말
											</a>

											<ul id="guide_cache" class="collapse mt-2 text-muted">
												<li><small>DB접속이 많거나 위젯을 많이 사용하는 메뉴일 경우 캐시를 적용하면 서버부하를 줄 일 수 있으며 속도를 높일 수 있습니다.</small></li>
												<li class="text-danger"><small>실시간 처리가 요구되는 메뉴일 경우 적용하지 마세요.</small></li>
											</ul>
										</div>
									</div>

										<div class="form-group row">
											<label class="col-lg-2 col-form-label text-lg-right">미디어</label>
											<div class="col-lg-10 col-xl-9">
												<div class="input-group">
													<input class="form-control rb-modal-photo-drop" type="text" name="upload" id="mediaset" value="<?php echo $CINFO['upload']?$CINFO['upload']:''?>" onmousedown="_mediasetField='mediaset&dfiles='+this.value;" data-toggle="modal" data-target="#modal_window">
													<div class="input-group-append">
														<button class="btn btn-light rb-modal-photo" type="button" title="포토셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
															<i class="fa fa-photo fa-lg"></i>
														</button>
														<button class="btn btn-light rb-modal-video" type="button" title="비디오셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
															<i class="fa fa-video-camera fa-lg"></i>
														</button>
													</div>
												</div>
												<a class="badge badge-pill badge-dark mt-2" data-toggle="collapse" href="#guide_mediaset">
													<i class="fa fa-question-circle fa-fw"></i>도움말
												</a>
												<ul id="guide_mediaset" class="collapse mt-2 text-muted">
													<li><small>여기에 연결시킬 미디어 파일을 지정할 수 있습니다.</small></li>
													<li><small>지정된 미디어는 필요에 따라 사용될 수 있습니다.</small></li>
												</ul>
											</div>
										</div>


										<div class="form-group row">
										<label class="col-lg-2 col-form-label text-lg-right">코드확장</label>
										<div class="col-lg-10 col-xl-9">
											<div class="panel-group" style="margin-bottom:0;">
												<div class="card">

													<div class="card-header p-0">
														<a class="d-block pl-3 pr-4 muted-link collapsed" data-toggle="collapse" href="#menu_header" onclick="sessionSetting('sh_site_menu_3','1','','1');">
															문서헤더
															<?php if($CINFO['uid']&&($CINFO['imghead']||is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.header.php'))):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
														</a>
													</div>

														<div id="menu_header" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_3']):?> show<?php endif?>">
														<div class="card-body">

															<div class="form-group row">
																<label class="col-lg-2 col-form-label text-lg-right" for="menuheader-InputFile">헤더파일</label>
																<div class="col-lg-10 col-xl-9">
																	<input type="file" name="imghead" id="menuheader-InputFile">
																	<?php if($CINFO['imghead']):?>
																		<p class="form-control-static">
																			<a class="btn bnt-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=head" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">삭제</a>
																			<a class="btn btn-link" href="<?php echo $g['s']?>/_var/menu/<?php echo $CINFO['imghead']?>" target="_blank">등록파일 보기</a>
																		</p>
																	<?php else:?>
																	<small class="help-block">(gif/jpg/png 가능)</small>
																	<?php endif?>
																</div>
															</div>

															<div class="form-group row mb-0">
																<label class="col-lg-2 col-form-label text-lg-right">
																	헤더코드
																</label>
																<div class="col-lg-10">
																	<textarea name="codhead" id="codheadArea" class="form-control" rows="5"><?php if(is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.header.php')) echo htmlspecialchars(implode('',file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.header.php')))?></textarea>
																</div>
															</div>
														</div>
													</div>
												</div>

													<div class="card mt-2">
													<div class="card-header p-0">
														<a class="d-block pl-3 pr-4 muted-link collapsed" data-toggle="collapse" href="#menu_footer" onclick="sessionSetting('sh_site_menu_4','1','','1');">
															문서풋터
															<?php if($CINFO['uid']&&($CINFO['imgfoot']||is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.footer.php'))):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
														</a>
													</div>

														<div id="menu_footer" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_4']):?> show<?php endif?>">
														<div class="card-body">

															<div class="form-group row">
																<label class="col-lg-2 col-form-label text-lg-right" for="menuheader-InputFile">풋터파일</label>
																<div class="col-lg-10">
																	<input type="file" name="imgfoot" id="menufooter-InputFile">
																	<?php if($CINFO['imgfoot']):?>
																		<p class="form-control-static">
																			<a class="btn btn-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=foot" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">삭제</a>
																			<a class="btn btn-link" href="<?php echo $g['s']?>/_var/menu/<?php echo $CINFO['imgfoot']?>" target="_blank">등록파일 보기</a>
																		</p>
																	<?php else:?>
																	<small class="help-block">(gif/jpg/png 가능)</small>
																	<?php endif?>
																</div>
															</div>

															<div class="form-group row mb-0">
																<label class="col-lg-2 col-form-label text-lg-right">
																	풋터코드
																</label>
																<div class="col-lg-10">
																	<textarea name="codfoot" id="codfootArea" class="form-control" rows="5"><?php if(is_file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.footer.php')) echo htmlspecialchars(implode('',file($g['path_page'].$r.'-menus/'.$CINFO['id'].'.footer.php')))?></textarea>
																</div>
															</div>

															</div>
													</div>
												</div>

												<div class="card mt-2">
													<div class="card-header p-0">
														<a class="d-block pl-3 pr-4 muted-link collapsed" data-toggle="collapse" href="#menu_addinfo" onclick="sessionSetting('sh_site_menu_5','1','','1');">
															부가필드
															<?php if($CINFO['addinfo']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
														</a>
													</div>

														<div id="menu_addinfo" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_5']):?> show<?php endif?>">
														<div class="card-body">
															<div class="form-group row mb-0">
																<label class="col-lg-2 col-form-label text-lg-right">부가필드</label>
																<div class="col-lg-10">
																	<textarea name="addinfo" class="form-control" rows="3"><?php echo htmlspecialchars($CINFO['addinfo'])?></textarea>
																	<small class="form-text text-muted">이 메뉴에 대해서 추가적인 정보가 필요할 경우 사용하며 필드명은<code>[addinfo]</code> 입니다.</small>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="card mt-2">
													<div class="card-header p-0">
														<a class="d-block pl-3 pr-4 muted-link collapsed" data-toggle="collapse" href="#menu_addattr" onclick="sessionSetting('sh_site_menu_6','1','','1');">
															속성추가
															<?php if($CINFO['addattr']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
														</a>
													</div>

													<div id="menu_addattr" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_6']):?> show<?php endif?>">
													<div class="card-body">
														<div class="form-group row mb-0">
															<label class="col-lg-2 col-form-label text-lg-right">추가 속성</label>
															<div class="col-lg-10">
																<input type="text" name="addattr" class="form-control" placeholder="예: rel=&quot;nofollow&quot; 또는 data-scroll 등" value="<?php echo htmlspecialchars($CINFO['addattr'])?>">
																<small class="form-text text-muted"><code>&lt;a href="#"  &gt;</code> 태그 내부에 속성으로 추가 됩니다.</small>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="card mt-2">
												<div class="card-header p-0">
													<a class="d-block pl-3 pr-4 muted-link collapsed" data-toggle="collapse" href="#menu_icon" onclick="sessionSetting('sh_site_menu_7','1','','1');">
														아이콘
														<?php if($CINFO['imgicon']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
													</a>
												</div>

												<div id="menu_icon" class="panel-collapse collapse<?php if($_SESSION['sh_site_menu_7']):?> show<?php endif?>">
												<div class="card-body">

													<div class="form-group row">
														<label class="col-lg-2 col-form-label text-lg-right" for="menuicon-InputFile">아이콘</label>
														<div class="col-lg-10 col-xl-9">
															<input type="file" name="imgicon" id="menuicon-InputFile">
															<?php if($CINFO['imgicon']):?>
																<p class="form-control-static">
																	<a class="btn bnt-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=menu_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=icon" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">삭제</a>
																	<a class="btn btn-link" href="<?php echo $g['s']?>/_var/menu/<?php echo $CINFO['imgicon']?>" target="_blank">등록파일 보기</a>
																</p>
															<?php else:?>
															<small class="help-block">(gif/jpg/png 가능)</small>
															<?php endif?>
														</div>
													</div>

												</div>
											</div>

										</div>
									</div>
									</div>
							</div>
							</div>
						</div>
				</div>


				<?php if($is_fcategory && $CINFO['is_child']):?>
				<div class="custom-control custom-checkbox mt-3">
				  <input type="checkbox" class="custom-control-input" name="subcopy" id="cubcopy" value="1">
				  <label class="custom-control-label" for="cubcopy">이 설정을 서브메뉴에도 일괄적용 <small class="text-muted">(메뉴숨김, 레이아웃, 권한)</small></label>
				</div>
				<?php endif?>


				<button class="btn btn-outline-primary btn-block btn-lg my-4" id="rb-submit-button" type="submit">
					<?php echo $CINFO['uid']?'속성변경':'신규메뉴 등록' ?>
				</button>

			</div><!-- /.card-body -->


		</form>
	</div>
</div>

<!-- bootstrap-maxlength -->
<?php getImport('bootstrap-maxlength','bootstrap-maxlength.min',false,'js')?>

<script>

var _mediasetField='';
$(document).ready(function() {

	//사이트 셀렉터 출력
	$('[data-role="siteSelector"]').removeClass('d-none')

	$('input.rb-title').maxlength({
		alwaysShow: true,
		threshold: 10,
		warningClass: "label label-success",
		limitReachedClass: "label label-danger",
	});

		$('textarea.rb-description').maxlength({
		alwaysShow: true,
		threshold: 10,
		warningClass: "label label-success",
		limitReachedClass: "label label-danger",
	});

	$('.rb-modal-code').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=source&cat=<?php echo $cat?>&code=<?php echo $code?>');
	});
	$('.rb-modal-code-mobile').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=source&cat=<?php echo $cat?>&code=<?php echo $code?>&mobileOnly=Y');
	});
	$('.rb-modal-wysiwyg').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=source&wysiwyg=Y&cat=<?php echo $cat?>&code=<?php echo $code?>');
	});
	$('.rb-modal-wysiwyg-mobile').on('click',function() {
		goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=admin&module=site&front=_edit&_mtype=menu&uid=<?php echo $CINFO['uid']?>&type=source&wysiwyg=Y&cat=<?php echo $cat?>&code=<?php echo $code?>&mobileOnly=Y');
	});
	$('.rb-modal-module').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;system=popup.joint&amp;dropfield=jointf')?>');
	});
	$('.rb-modal-photo').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=mediaset')?>');
	});
	$('.rb-modal-photo1').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=meta_image_src')?>');
	});
	$('.rb-modal-video').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.video.media&amp;dropfield=mediaset')?>');
	});
	$('.rb-modal-photo-drop').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=')?>'+_mediasetField);
	});

	$('#menu-settings-meta-body').on('show.bs.collapse', function () {
		sessionSetting('sh_site_menu_1','1','','')
	})
	$('#menu-settings-meta-body').on('hidden.bs.collapse', function () {
		sessionSetting('sh_site_menu_1','','','')
	})
	$('#menu-settings-advance-body').on('show.bs.collapse', function () {
		sessionSetting('sh_site_menu_1','2','','')
	})
	$('#menu-settings-advance-body').on('hidden.bs.collapse', function () {
		sessionSetting('sh_site_menu_1','','','')
	})

});
</script>

<script>

putCookieAlert('result_menu') // 실행결과 알림 메시지 출력

function saveCheck(f) {

  <?php if(!$SITEN):?>
  alert('사이트가 등록되지 않았습니다.\n먼저 사이트를 만들어주세요.');
  return false;
  <?php endif?>

  var l1 = f._perm_g;
  var n1 = l1.length;
  var i;
  var s1 = '';
  for (i = 0; i < n1; i++) {
    if (l1[i].selected == true && l1[i].value != '') {
      s1 += '[' + l1[i].value + ']';
    }
  }
  f.perm_g.value = s1;

  if (f.id) {
    if (f.id.value == '') {
      alert('메뉴코드를 입력해 주세요.');
      f.id.focus();
      return false;
    }
    if (!chkFnameValue(f.id.value)) {
      alert('메뉴코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다.');
      f.id.focus();
      return false;
    }
  }

	<?php if($CINFO['menutype']=='1'):?>
	if (f.menutype.value == '1')
	{
		if (f.joint.value == '')
		{
			alert('모듈을 연결해주세요.      ');
			f.joint.focus();
			return false;
		}
	}
	<?php endif?>

	<?php if($CINFO['menutype']=='3'):?>
	if (f.menutype.value == '3')
	{
		if (f.joint_menu.value == '')
		{
			alert('메뉴를 연결해주세요.      ');
			f.joint_menu.focus();
			return false;
		}
	}
	<?php endif?>

	getIframeForAction(f);

  if (f.layout_1.value != '0') f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
  else f.layout.value = '';
  if (f.m_layout_1.value != '0') f.m_layout.value = f.m_layout_1.value + '/' + f.m_layout_1_sub.value;
  else f.m_layout.value = '';

}

function boxDeco(layer1,layer2)
{
	if(getId(layer1).className.indexOf('default') == -1) $("#"+layer1).addClass("border-light").removeClass("border-primary");
	else $("#"+layer1).addClass("border-primary").removeClass("border-light");
	$("#"+layer2).addClass("border-light").removeClass("border-primary");
}
function docType(n,str)
{
	$('#rb-document-type').html(str);
	$('#editBox1').addClass('d-none').removeAttr('hidden');
	$('#editBox2').addClass('d-none').removeAttr('hidden');
	$('#editBox3').addClass('d-none').removeAttr('hidden');
	$('#editBox4').addClass('d-none').removeAttr('hidden');
	$('#editBox'+n).removeClass('d-none');
	getIframeForAction(document.procForm);

	if (document.procForm.layout_1.value != '0') document.procForm.layout.value = document.procForm.layout_1.value + '/' + document.procForm.layout_1_sub.value;
  else document.procForm.layout.value = '';
  if (document.procForm.m_layout_1.value != '0') document.procForm.m_layout.value = document.procForm.m_layout_1.value + '/' + document.procForm.m_layout_1_sub.value;
  else document.procForm.m_layout.value = '';

	document.procForm.menutype.value = n;
	document.procForm.joint.value = '';
	document.procForm.joint_menu.value = '';
	document.procForm.redirect.value = '';
	document.procForm.submit();
}

</script>
