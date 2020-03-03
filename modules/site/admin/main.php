<?php
$R=array();

if ($my['super'] && !$my['adm_site']) {
	$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p);
	$SITEN = db_num_rows($SITES);
} else {
	$SITES = getArrayString($my['adm_site']);
	$SITEN = $SITES[count];
}

$PAGES1 = getDbArray($table['s_page'],'site='.$s.' and ismain=1','*','uid','asc',0,$p);
$PAGES2 = getDbArray($table['s_page'],'site='.$s.' and mobile=1','*','uid','asc',0,$p);

if ($type != 'makesite')
{
	$R = $_HS;
	$_SEO = getDbData($table['s_seo'],'rel=0 and parent='.$R['uid'],'*');
}

if ($R['uid'])
{
	$DOMAINS = getDbArray($table['s_domain'],'site='.$R['uid'],'*','gid','asc',0,$p);
	$DOMAINN = db_num_rows($DOMAINS);
}
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4 col-lg-4 col-xl-4 d-none d-sm-block sidebar">
			<form action="<?php echo $g['s']?>/" method="post">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $module?>">
				<input type="hidden" name="a" value="siteorder_update">

				<div class="dd py-4 pl-3" id="site-icons" style="height: calc(100vh - 10.5rem);overflow: auto;">
					<ol class="dd-list list-inline">

						<?php if ($my['super'] && !$my['adm_site']): ?>

							<?php while($S = db_fetch_array($SITES)):?>
								<li class="dd-item<?php if($S['uid']==$R['uid']):?> rb-active<?php endif?> mb-0" data-id="_site_<?php echo $S['id']?>_">
								<input type="checkbox" name="sitemembers[]" value="<?php echo $S['uid']?>" class="d-none" checked>
									<a href="<?php echo $g['s']?>/?r=<?php echo $S['id']?>&amp;m=<?php echo $m?>&amp;pickmodule=<?php echo $module?>&amp;panel=Y" target="_parent"<?php if($type=='makesite'):?> class="active"<?php endif?>>
										<span class="rb-site-icon <?php echo $S['icon']?$S['icon']:'fa fa-home'?>" id="_site_icon_<?php echo $S['id']?>"></span>
										<span class="rb-site-label"><?php echo $S['label']?></span>
									</a>
								<div class="dd-handle"></div>
								</li>
								<?php endwhile?>

						<?php else: ?>
							<?php $_i=0;foreach($SITES['data'] as $val):?>
							<?php $_SD = getUidData($table['s_site'],$val); ?>
							<li class="dd-item<?php if($_SD['uid']==$R['uid']):?> rb-active<?php endif?> mb-0" data-id="_site_<?php echo $_SD['id']?>_">
							<input type="checkbox" name="sitemembers[]" value="<?php echo $_SD['uid']?>" class="d-none" checked>
								<a href="<?php echo $g['s']?>/?r=<?php echo $_SD['id']?>&amp;m=<?php echo $m?>&amp;pickmodule=<?php echo $module?>&amp;panel=Y" target="_parent"<?php if($type=='makesite'):?> class="active"<?php endif?>>
									<span class="rb-site-icon <?php echo $_SD['icon']?$_SD['icon']:'fa fa-home'?>" id="_site_icon_<?php echo $_SD['id']?>"></span>
									<span class="rb-site-label"><?php echo $_SD['label']?></span>
								</a>
							<div class="dd-handle"></div>
							</li>
							<?php $_i++;endforeach?>
						<?php endif; ?>

						</ol>
					</div>
					<?php if ($my['super']): ?>
					<a href="<?php echo $g['adm_href']?>&amp;type=makesite&amp;nosite=<?php echo $nosite?>" class="rb-add<?php if($type=='makesite'):?> active<?php endif?>" data-tooltip="tooltip" title="사이트 추가"><i class="fa fa-plus fa-3x"></i></a>
					<?php endif; ?>
			</form>
		</div><!-- /.sidebar -->

		<div class="col-sm-8 ml-sm-auto col-lg-8 col-xl-8 pt-3">
		<form name="procForm" class="rb-form" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="regissite">
			<input type="hidden" name="site_uid" value="<?php echo $R['uid']?>">
			<input type="hidden" name="seouid" value="<?php echo $_SEO['uid']?>">
			<input type="hidden" name="usescode" value="<?php echo !$R['gid']?0:1?>">
			<input type="hidden" name="icon" value="<?php echo $R['icon']?$R['icon']:'fa fa-home'?>">
			<input type="hidden" name="backgo" value="admin">
			<input type="hidden" name="iconaction" value="">
			<input type="hidden" name="nosite" value="<?php echo $nosite?>">
			<input type="hidden" name="layout" value="">
			<input type="hidden" name="m_layout" value="">

			<div class="page-header d-flex justify-content-between align-self-center mt-0" id="home-site-info">
				<h4 class="h5 mb-0">
					기본 정보
				</h4>

				<div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#site-info">
				  <input type="checkbox" class="custom-control-input" id="customCheck1">
				  <label class="custom-control-label" for="customCheck1">사이트 코드</label>
				</div>

			</div>

			<div class="form-group row rb-outside">
				<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">라벨</label>
				<div class="col-lg-10 col-xl-9">
					<div class="input-group input-group-lg">
						<input type="text" name="label" value="<?php echo $R['label']?>" class="form-control"<?php if(!$R['uid'] && !$g['device']):?> autofocus<?php endif?> autocomplete="off" required>
						<span class="input-group-append">
							<button class="btn btn-light rb-modal-iconset" type="button" data-toggle="modal" data-target="#modal_window" data-tooltip="tooltip" title="라벨 아이콘"><i id="_label_icon_btn_" class="fa fa-globe fa-lg"></i></button>
							<?php if($R['uid']):?>
							<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletesite&amp;account=<?php echo $R['uid']?>" onclick="return hrefCheck(this,true,'사이트관련 모든 데이터가 삭제됩니다.\n정말로 선택된 사이트를 삭제하시겠습니까?');" class="btn btn-light rounded-0" data-tooltip="tooltip" title="사이트 삭제">
								<i class="fa fa-trash-o fa-lg"></i>
							</a>
							<?php endif?>
						</span>

					</div>
				</div>
			</div>

			<div class="collapse" id="site-info">
				<div class="form-group row rb-outside">
					<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">사이트명</label>
					<div class="col-lg-10 col-xl-9">
						<input class="form-control form-control-lg" placeholder="" type="text" name="name" value="<?php echo $R['name']?>">
						<small class="form-text text-muted"><code>&lt;title&gt; &lt;/title&gt;</code>내부의 <code>{site}</code> 변수에 적용됩니다.</small>
					</div>
				</div>
				<div class="form-group row rb-outside">
					<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">코드</label>
					<div class="col-lg-10 col-xl-9">
						<div class="input-group input-group-lg">
							<input class="form-control" placeholder="미입력 시 자동으로 부여됩니다." type="text" name="id" value="<?php echo $R['id']?>" id="site-code">
							<span class="input-group-append">
								<button class="btn btn-light rb-help-btn rounded-0" type="button" data-toggle="collapse" data-tooltip="tooltip" title="사이트 코드" data-target="#guide_sitecode"><i class="fa fa-question fa-lg text-muted"></i></button>
							</span>
						</div>
						<ul id="guide_sitecode" class="collapse form-text text-muted mt-3 pl-3">
							<li><small>단일 도메인으로 복수의 사이트를 운영할 수 있습니다.</small></li>
							<li><small>사이트별로 계정아이디를 등록합니다.(영문대/소문자+숫자+_ 조합으로 등록할 수 있습니다)</small></li>
							<li><small>영문사이트 서비스 연결 예제 : <code>kimsq.com/rb/kr</code> , <code>kimsq.com/rb/en</code></small></li>
						</ul>
					</div>
				</div>
			</div>


			<div class="page-header d-flex justify-content-between align-self-center mt-5" id="home-site-info">
				<h4 class="h5 mb-0">
					레이아웃
				</h4>

				<div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#layout-mobile">
					<input type="checkbox" class="custom-control-input" id="customCheck2"<?php if($R['m_layout']):?> checked<?php endif?>>
					<label class="custom-control-label" for="customCheck2">모바일 전용 레이아웃 사용</label>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">기본</label>
				<div class="col-lg-10 col-xl-9">
					<div class="form-row">
						<div class="col-sm-6" id="rb-layout-select">
							<select class="form-control custom-select custom-select-lg" name="layout_1" required onchange="getSubLayout(this,'rb-layout-select2','layout_1_sub','custom-select custom-select-lg');" style="letter-spacing: -1px;">
								<?php $_layoutExp1=explode('/',$R['layout'])?>
								<?php $dirs = opendir($g['path_layout'])?>
								<?php $_i=0;while(false !== ($tpl = readdir($dirs))):?>
								<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
									<?php if(!$_i&&!$R['layout']) $_layoutExp1[0] = $tpl?>
								<option value="<?php echo $tpl?>"<?php if($_layoutExp1[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo $tpl?>)</option>
								<?php $_i++;endwhile?>
								<?php closedir($dirs)?>
							</select>
						</div>
						<div class="col-sm-6" id="rb-layout-select2">
							<select class="form-control custom-select custom-select-lg" name="layout_1_sub"<?php if(!$_layoutExp1[0]):?> disabled<?php endif?>>
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

			<div class="collapse<?php if($R['m_layout']):?> show<?php endif?>" id="layout-mobile">

				<div class="form-group row">
					<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">모바일 전용</label>
					<div class="col-lg-10 col-xl-9">
						<div class="form-row">
							<div class="col-sm-6" id="rb-mlayout-select">
								<select class="form-control custom-select custom-select-lg" name="m_layout_1" required onchange="getSubLayout(this,'rb-mlayout-select2','m_layout_1_sub','custom-select custom-select-lg');" style="letter-spacing: -1px;">
									<option value="0">사용안함 (기본 레이아웃 적용)</option>
									<option disabled>--------------------</option>
									<?php $_layoutExp2=explode('/',$R['m_layout'])?>
										<?php $dirs = opendir($g['path_layout'])?>
										<?php while(false !== ($tpl = readdir($dirs))):?>
										<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
										<option value="<?php echo $tpl?>"<?php if($_layoutExp2[0]==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_layout'].$tpl)?> (<?php echo $tpl?>)</option>
										<?php endwhile?>
										<?php closedir($dirs)?>
								</select>
							</div>

								<div class="col-sm-6" id="rb-mlayout-select2">
									<select class="form-control custom-select custom-select-lg" name="m_layout_1_sub"<?php if(!$R['m_layout']):?> disabled<?php endif?>>
										<?php if(!$R['m_layout']):?><option>서브 레이아웃</option><?php endif?>
										<?php $dirs1 = opendir($g['path_layout'].$_layoutExp2[0])?>
										<?php while(false !== ($tpl1 = readdir($dirs1))):?>
										<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
										<option value="<?php echo $tpl1?>"<?php if($_layoutExp2[1]==$tpl1):?> selected<?php endif?>><?php echo str_replace('.php','',$tpl1)?></option>
										<?php endwhile?>
										<?php closedir($dirs1)?>
									</select>
							</div>
						</div>

						<span class="form-text">
							<a class="badge badge-pill badge-dark" data-toggle="collapse" href="#guide_mobile">도움말</a>
						</span>

						<ul id="guide_mobile" class="collapse form-text text-muted pl-3">
							<li><small>모바일기기로 접속시 출력할 사이트 레이아웃(UI)을 지정합니다.</small></li>
							<li><small>모바일 전용 레이아웃을 지정하지 않으면 모바일 기기로 접속시 기본 레이아웃으로 적용됩니다.</small></li>
							<li><small>모바일 기기에 대해 정의하려면 디바이스 설정 을 이용하세요. <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=device">more</a></small></li>
						</ul>
					</div>
				</div>

			</div>

			<div class="collapse<?php if($_SESSION['sh_site_main_1']):?> show<?php endif?>" id="site-advance"><!-- 고급설정 레이어 -->


				<div class="page-header d-flex justify-content-between align-self-center mt-5">
					<h4 class="h5 mb-0">메인 페이지</h4>

					<div class="custom-control custom-checkbox" data-toggle="collapse" data-target="#index-mobile">
					  <input type="checkbox" class="custom-control-input" id="customCheck3" <?php if($R['m_startpage']):?> checked<?php endif?>>
					  <label class="custom-control-label" for="customCheck3">모바일 전용 메인 페이지 사용</label>
					</div>

				</div>


				<div class="form-group row">
					<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">기본</label>
					<div class="col-lg-10 col-xl-9">
						<select class="form-control custom-select custom-select-lg" name="startpage" required>
							<option>레이아웃에 포함된 메인페이지</option>
							<option disabled><i class="fa fa-edit"></i>페이지 리스트 ↓</option>
							<?php while($S = db_fetch_array($PAGES1)):?>
							<option value="<?php echo $S['uid']?>"<?php if($R['startpage']==$S['uid']):?> selected<?php endif?>><?php echo $S['name']?>(<?php echo $S['id']?>)</option>
							<?php endwhile?>
						</select>
						<span class="form-text">
							<a class="badge badge-pill badge-dark" data-toggle="collapse" href="#guide_mainpage">도움말</a>
						</span>
						<div id="guide_mainpage" class="collapse form-text text-muted">
							<li><small>메인페이지는 웹사이트에 접속했을때 레이아웃(틀)을 제외한 첫 화면을 의미합니다.</small></li>
							<li><small>일반적으로 메인페이지는 레이아웃에 포함되어 있으나 임의의 페이지를 지정하여 대체할 수도 있습니다.</small></li>
							<li><small>레이아웃에 포함되어 있는 메인페이지 대신 자체의 페이지를 사용하려면 해당 페이지를 지정해 주세요.</small></li>
							<li><small>자체 페이지는 페이지에서 만들 수 있습니다. <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=page">more</a></small></li>
						</div>
					</div>
				</div>

				<div class="collapse<?php if($R['m_startpage']):?> show<?php endif?>" id="index-mobile">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label col-form-label-lg text-lg-right">모바일 전용</label>
						<div class="col-lg-10 col-xl-9">
							<select class="form-control custom-select custom-select-lg" name="m_startpage" required>
								<option>레이아웃에 포함된 메인페이지</option>
								<option disabled><i class="fa fa-edit"></i>페이지 리스트 ↓</option>
								<?php while($S = db_fetch_array($PAGES2)):?>
								<option value="<?php echo $S['uid']?>"<?php if($R['m_startpage']==$S['uid']):?> selected<?php endif?>><?php echo $S['name']?>(<?php echo $S['id']?>)</option>
								<?php endwhile?>
							</select>
						</div>
					</div>
				</div>


				<div class="page-header mt-5">
					<h4 class="h5">고급 설정</h4>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">타이틀 구성</label>
					<div class="col-lg-10 col-xl-9">
						<div class="input-group">
							<input class="form-control" placeholder="" type="text" name="title" value="<?php echo $R['uid']?$R['title']:'{subject} | {site}'?>">
							<span class="input-group-append">
								<button class="btn btn-light rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_title" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
							</span>
						</div>
						<ul id="guide_title" class="collapse form-text text-muted pl-3 mt-3">
							<li><small>입력내용은 브라우저의 <code>&lt;title&gt; &lt;/title&gt;</code> 내부에 출력됩니다.</small></li>
							<li><small>검색엔진 결과 페이지와 소셜미디어 공유 링크 제목등에 사용됩니다.</small></li>
							<li><small><code>{site}</code>에는 사이트명이 치환됩니다.</small></li>
							<li><small><code>{subject}</code>에는 메뉴명, 페이지 제목등이 치환 됩니다.</small></li>
							<li><small><code>{location}</code>에는 현재위치가 치환 됩니다.</small></li>
						</ul>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">퍼포먼스</label>
					<div class="col-sm-9 pt-1">

						<div class="custom-control custom-checkbox custom-control-inline">
						  <input type="checkbox" class="custom-control-input" id="customCheck_rewrite" name="rewrite" value="1"<?php if($R['rewrite']):?> checked<?php endif?>>
						  <label class="custom-control-label" for="customCheck_rewrite">고유주소 (Permalink)</label>
						</div>

						<div class="custom-control custom-checkbox custom-control-inline">
						  <input type="checkbox" class="custom-control-input" id="customCheck_buffer" name="buffer" value="1"<?php if($R['buffer']):?> checked<?php endif?>>
						  <label class="custom-control-label" for="customCheck_buffer">버퍼전송</label>
						</div>


						<a class="badge badge-pill badge-dark" data-toggle="collapse" href="#guide_rewrite">도움말</a>

						<div  id="guide_rewrite" class="collapse form-text text-muted">
							<small>
								<dl>
									<dt>고유주소 사용</dt>
									<dd>
										<p>
											긴 주소줄을 간단하게 줄일 수 있습니다.(서버에서 rewrite_mod 를 허용해야합니다)<br>
											보기) <code>./?r=home&amp;c=menu</code> -> <code>/home/c/menu</code>
										</p>
									</dd>
								</dl>
								<hr>
								<dl>
									<dt>버퍼전송사용</dt>
									<dd>
										실행결과를 브라우져에 출력해주는 과정에서 버퍼에 담아두었다가 실행이 완료되면 화면에 출력해 줍니다.<br>
										실행속도가 느릴경우 화면이 일부분만 출력되는 것을 한번에 열리도록 합니다.<br>
									</dd>
								</dl>
							</small>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">연결 도메인</label>
					<div class="col-sm-9">
						<?php if($R['uid']):?>
						<?php if($DOMAINN):?>
						<ul class="list-unstyled">
							<?php while($D=db_fetch_array($DOMAINS)):?>
							<li class="pt-2">
								<span class="fa fa-globe"></span>
								<a href="//<?php echo $D['name']?>" target="_blank" class="muted-link"><?php echo $D['name']?></a>
							</li>
							<?php endwhile?>
						</ul>
						<?php else:?>
						<div class="form-control-static">
							<span class="text-muted">
								<span class="fa fa-info-circle"></span>
								연결된 도메인이 없습니다.
							</span>
							<a class="badge badge-pill badge-dark" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=domain&amp;selsite=<?php echo $R['uid']?>&amp;type=makedomain">도메인 연결하기</a>
						</div>
						<?php endif?>
						<?php else:?>
						<p class="form-control-static">
							<span class="text-muted">
								<span class="fa fa-info-circle"></span>
								사이트 생성 후 연결할 수 있습니다.
							</span>
						</p>
						<?php endif?>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">사이트 언어</label>
					<div class="col-lg-10 col-xl-9">
						<div class="input-group">
							<select name="sitelang" class="form-control custom-select">
								<option value=""<?php if(!$R['lang']):?> selected<?php endif?>>시스템 언어 (<?php echo getFolderName($g['path_module'].$module.'/language/'.$d['admin']['syslang'])?>)</option>
								<?php if(is_dir($g['path_module'].$module.'/language')):?>
								<?php $dirs = opendir($g['path_module'].$module.'/language')?>
								<?php while(false !== ($tpl = readdir($dirs))):?>
								<?php if($tpl=='.'||$tpl=='..'||$tpl==$d['admin']['syslang'])continue?>
								<option value="<?php echo $tpl?>"<?php if($R['lang']==$tpl):?> selected<?php endif?>><?php echo getFolderName($g['path_module'].$module.'/language/'.$tpl)?></option>
								<?php endwhile?>
								<?php closedir($dirs)?>
								<?php endif?>
							</select>
							<span class="input-group-append">
								<button class="btn btn-light rb-help-btn" type="button" data-toggle="collapse" data-tooltip="tooltip" title="도움말" data-target="#guide_language"><i class="fa fa-question fa-lg text-muted"></i></button>
							</span>
						</div>

							<div id="guide_language" class="collapse form-text text-muted">
							<small>
								이 사이트의 사용자모드에 대한 언어를 제어합니다.<br>
								<?php echo sprintf("지정된 언어가 포함되어 있지 않은 모듈이 사용될 경우에는 기본언어인 <strong>%s</strong>로 적용됩니다.",getFolderName($g['path_module'].$module.'/language/'.$d['admin']['syslang']))?>
							</small>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">서비스상태</label>
					<div class="col-sm-9 pt-1">

						<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" class="custom-control-input" id="open_1" name="open" value="1"<?php if(!$R['uid']||$R['open']=='1'):?> checked<?php endif?>>
						  <label class="custom-control-label" for="open_1">정상 서비스</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" class="custom-control-input" id="open_2" name="open" value="2"<?php if($R['open']=='2'):?> checked<?php endif?>>
						  <label class="custom-control-label" for="open_2">관리자 오픈</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" class="custom-control-input" id="open_3" name="open" value="3"<?php if($R['open']=='3'):?> checked<?php endif?>>
						  <label class="custom-control-label" for="open_3">정지</label>
						</div>


					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">이름표시</label>
					<div class="col-sm-9 pt-2">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="nametype_nic" name="nametype" value="nic"<?php if(!$R['uid'] || $R['nametype']=='nic'):?> checked<?php endif?>>
							<label class="custom-control-label" for="nametype_nic">닉네임</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" class="custom-control-input" id="nametype_name" name="nametype" value="name"<?php if($R['nametype']=='name'):?> checked<?php endif?>>
						  <label class="custom-control-label" for="nametype_name">이름</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
						  <input type="radio" class="custom-control-input" id="nametype_id" name="nametype" value="id"<?php if($R['nametype']=='id'):?> checked<?php endif?>>
						  <label class="custom-control-label" for="nametype_id">아이디</label>
						</div>


					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">시간조정</label>
					<div class="col-lg-10 col-xl-9">
						<select class="form-control custom-select" name="timecal">
							<?php for($i = -23; $i < 24; $i++):?>
							<option value="<?php echo $i?>"<?php if($i == $R['timecal']):?> selected<?php endif?>><?php if($i > 0):?>+<?php endif?><?php echo $i?sprintf('%s 시간',$i):'조정안함'?></option>
							<?php endfor?>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">코드삽입</label>
					<div class="col-lg-10 col-xl-9">
						<div class="panel-group">
							<div class="card mb-2">
								<div class="card-header p-0">
									<a class="d-block muted-link collapsed" data-toggle="collapse" href="#site-code-head" onclick="sessionSetting('sh_site_main_2','1','','1');">
										head 코드 <?php if($R['headercode']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
										<small><code>&lt;head&gt; &lt;/head&gt;</code> 태그 내부에 삽입할 코드를 등록해 주세요.</small>
									</a>
								</div>
								<div id="site-code-head" class="panel-collapse collapse<?php if($_SESSION['sh_site_main_2']):?> show<?php endif?>">
									<div class="card-body">
										<textarea name="headercode" class="form-control" rows="7"><?php echo htmlspecialchars($R['headercode'])?></textarea>
									</div>
								</div>
							</div>
							<div class="card mb-2">
								<div class="card-header p-0">
									<a class="d-block muted-link collapsed" data-toggle="collapse" href="#site-code-foot" onclick="sessionSetting('sh_site_main_3','1','','1');">
										foot 코드 <?php if($R['footercode']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
										<small><code>&lt;/body&gt;&lt;/html&gt;</code> 태그 직전에 삽입할 코드를 등록해 주세요.</small>
									</a>
								</div>

									<div id="site-code-foot" class="panel-collapse collapse<?php if($_SESSION['sh_site_main_3']):?> show<?php endif?>">
									<div class="card-body">
										<textarea name="footercode" class="form-control" rows="7"><?php echo htmlspecialchars($R['footercode'])?></textarea>
									</div>
								</div>
							</div>

							<div class="card mb-2">
								<div class="card-header p-0">
									<a class="d-block muted-link collapsed" data-toggle="collapse" href="#site-code-php" onclick="sessionSetting('sh_site_main_4','1','','1');">
										PHP코드 <?php if($R['uid']&&filesize($g['path_var'].'sitephp/'.$R['uid'].'.php')):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
											<small>이 사이트 전용 <code>&lt;?php ?&gt;</code> 를 등록해 주세요.</small>
									</a>
								</div>

									<div id="site-code-php" class="panel-collapse collapse<?php if($_SESSION['sh_site_main_4']):?> show<?php endif?>">
									<div class="card-body">
										<textarea name="sitephpcode" class="form-control" rows="7"><?php if($R['uid']&&is_file($g['path_var'].'sitephp/'.$R['uid'].'.php')) echo htmlspecialchars(implode('',file($g['path_var'].'sitephp/'.$R['uid'].'.php')))?></textarea>
									</div>
								</div>
							</div>

							<div class="card mb-2">
								<div class="card-header p-0">
									<a class="d-block muted-link collapsed" data-toggle="collapse" href="#site-code-googleanalytics" onclick="sessionSetting('sh_site_main_5','1','','1');">
										구글 웹로그 분석 <?php if($R['dtd']):?><i class="fa fa-check-circle" title="내용있음" data-tooltip="tooltip"></i><?php endif?>
											<small>이 사이트 전용 Google Analytics <code>추적 ID</code> 를 등록해 주세요.</small>
									</a>
								</div>

									<div id="site-code-googleanalytics" class="panel-collapse collapse<?php if($_SESSION['sh_site_main_5']):?> show<?php endif?>">
									<div class="card-body">
										<input name="dtd" type="text" class="form-control input-lg" placeholder="" value="<?php echo $R['dtd']?>">
										<small class="form-text">
												<a href="http://www.google.com/analytics/" target="_blank">Google 웹로그 분석</a> 코드를 사이트에 추가하세요  (예 : <code>UA-000000-01</code>)
												<a href="https://support.google.com/analytics/answer/1032385?hl=<?php echo $lang['site']['time1']?>" target="_blank">Tracking ID 찾기</a>,
												<a href="https://support.google.com/analytics/?hl=<?php echo $lang['site']['time1']?>#topic=3544906" target="_blank">도움말</a>
											</small>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="rb-advance my-5">
				<button type="button" class="btn btn-light<?php if(!$_SESSION['sh_site_main_1']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#site-advance" onclick="sessionSetting('sh_site_main_1','1','','1');">
					고급설정 <small class="rb-ca2"></small>
				</button>
				<button type="button" class="btn btn-light<?php if(!$_SESSION['sh_site_main_m']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#site-meta" onclick="sessionSetting('sh_site_main_m','1','','1');">
					메타설정 <small class="rb-ca1"></small>
				</button>
			</div>

			<div class="collapse<?php if($_SESSION['sh_site_main_m']):?> show<?php endif?>" id="site-meta"><!-- 메타설정 레이어 -->
				<div class="page-header">
					<h4 class="mb-0">메타 설정</h4>
				</div>
				<div class="form-group row rb-outside">
					<label class="col-lg-2 col-form-label text-lg-right">타이틀</label>
					<div class="col-lg-10 col-xl-9">
						<div class="input-group">
							<input type="text" class="form-control rb-title" name="meta_title" value="<?php echo $_SEO['title']?>" maxlength="60" placeholder="50-60자 내에서 작성해 주세요.">
							<span class="input-group-append">
								<button class="btn btn-light rb-help-btn" type="button" data-toggle="collapse" data-target="#guide_title_meta" data-tooltip="tooltip" title="도움말"><i class="fa fa-question fa-lg text-muted"></i></button>
							</span>
						</div>
						<div class="form-text collapse mt-2" id="guide_title_meta">
							<small>
								<code>&lt;meta name=&quot;title&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.
							</small>
						</div>
					</div>
				</div>
				<div class="form-group row rb-outside">
					<label class="col-lg-2 col-form-label text-lg-right">설명</label>
					<div class="col-lg-10 col-xl-9">
						<textarea name="meta_description" class="form-control rb-description" rows="5" placeholder="150-160자 내에서 작성해 주세요." maxlength="160"><?php echo $_SEO['description']?></textarea>
						<a class="mt-2 badge badge-pill badge-dark" href="#guide_description" data-toggle="collapse" >도움말</a>
						<div class="collapse" id="guide_description">
							<small class="form-text text-muted">
								<code>&lt;meta name=&quot;description&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.<br>
								검색 결과에 표시되는 문자를 지정합니다. 설명글은 엔터없이 입력해 주세요.<br>
								보기)웹 프레임워크의 혁신 - 킴스큐 Rb 에 대한 다운로드,팁 공유등을 제공합니다. <a href=&quot;http://moz.com/learn/seo/meta-description&quot; target=&quot;_blank&quot;>참고</a>
							</small>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">키워드</label>
					<div class="col-lg-10 col-xl-9">
						<input name="meta_keywords" class="form-control" placeholder="콤마(,)로 구분하여 입력해 주세요." value="<?php echo $_SEO['keywords']?>">
						<small class="mt-2 badge badge-pill badge-dark"><a class="muted-link" href="#guide_keywords" data-toggle="collapse" >도움말</a></small>
						<div class="collapse" id="guide_keywords">
							<small class="form-text text-muted">
								<code>&lt;meta name=&quot;keywords&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.
								핵심 키워드를 콤마로 구분하여 20개 미만으로 엔터없이 입력해 주세요.<br>
								보기)킴스큐,킴스큐Rb,CMS,웹프레임워크,큐마켓
							</small>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">크롤링</label>
					<div class="col-lg-10 col-xl-9">
						<input name="meta_classification" class="form-control" placeholder="" value="<?php echo $_SEO['uid']?$_SEO['classification']:'ALL'?>">
						<a class="mt-2 badge badge-pill badge-dark" href="#guide_classification" data-toggle="collapse" >도움말</a>
						<div class="form-text collapse" id="guide_classification">
							<small class="form-text text-muted">
								<code>&lt;meta name=&quot;robots&quot; content=&quot;&quot;&gt;</code> 내부에 삽입됩니다.
								all,noindex,nofollow,none 등으로 지정할 수 있습니다.
							</small>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">메타이미지</label>
					<div class="col-lg-10 col-xl-9">
						<div class="input-group">
							<input class="form-control rb-modal-photo-drop" onmousedown="_mediasetField='meta_image_src&dfiles='+this.value;" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window" type="text" name="meta_image_src" id="meta_image_src" value="<?php echo $_SEO['image_src']?$_SEO['image_src']:''?>">
							<div class="input-group-append">
								<button class="btn btn-light rb-modal-photo1" type="button" title="포토셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
									<i class="fa fa-photo fa-lg"></i>
								</button>
							</div>
						</div>

						<a class="mt-2 badge badge-pill badge-dark" href="#guide_image_src" data-toggle="collapse" >도움말</a>
						<div class="form-text collapse" id="guide_image_src">
							<small class="form-text text-muted">
								이미지를 등록하시면 소셜미디어에 이 이미지를 포함하여 전송할 수 있습니다.
								이미지를 직접 지정하려면 이미지의 URL을 입력해 주세요.
							</small>
						</div>
					</div>
				</div>

			</div>

			<button class="btn btn-outline-primary btn-block btn-lg my-4" id="rb-submit-button" type="submit">
				<?php echo $R['uid']?'사이트 속성 변경':'신규 사이트 만들기' ?>
			</button>

		</form>

	</div><!-- /.container-fluid -->

	</div>


</div>


<?php include $g['path_module'].$module.'/action/a.inscheck.php' ?>


<?php if($SITEN>1):?>
<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js')?>
<script>
$('#site-icons').nestable();
$('.dd').on('change', function() {
	var f = document.forms[0];
	getIframeForAction(f);
	f.submit();
});
</script>
<?php endif?>

<!-- bootstrap-maxlength -->
<?php getImport('bootstrap-maxlength','bootstrap-maxlength.min',false,'js')?>
<script>

putCookieAlert('result_site') // 실행결과 알림 메시지 출력

$('#site-info').on('shown.bs.collapse', function () {
  $('#site-code').focus()
})

	$('input.rb-title').maxlength({
		alwaysShow: true,
		threshold: 10,
		warningClass: "label label-success",
		limitReachedClass: "label label-danger"
	});

	$('textarea.rb-description').maxlength({
		alwaysShow: true,
		threshold: 10,
		warningClass: "label label-success",
		limitReachedClass: "label label-danger"
	});
</script>


<!-- modal -->
<script>
	var _mediasetField='';
	$(document).ready(function() {
		$('.rb-modal-iconset').on('click',function() {
			modalSetting('modal_window','<?php echo getModalLink('site/pages/modal.icons')?>');
		});
		$('.rb-modal-photo1').on('click',function() {
			modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=meta_image_src')?>');
		});
		$('.rb-modal-photo-drop').on('click',function() {
			modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=')?>'+_mediasetField);
		});
	});
</script>

<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>

<script>

$('.form-horizontal').bootstrapValidator({
	message: 'This value is not valid',
	<?php if(!$g['device']):?>
	feedbackIcons: {
		valid: 'fa fa-check',
		invalid: 'fa fa-times',
		validating: 'fa fa-refresh'
	},
	<?php endif?>
	fields: {
		name: {
			message: 'The menu is not valid',
			validators: {
				notEmpty: {
					message: '사이트 라벨을 입력해 주세요.'
				}
			}
		},
		id: {
			validators: {
				notEmpty: {
					message: '사이트 코드를 입력해 주세요.'
				},
				regexp: {
					regexp: /^[a-zA-Z0-9_\-]+$/,
					message: '사이트 코드는 영문대소문자/숫자/_/- 만 사용할 수 있습니다.'
				}
			}
		},

	}
});
</script>

<!-- basic -->
<script>
function saveCheck(f)
{
	f.layout.value = f.layout_1.value + '/' + f.layout_1_sub.value;
	if(f.m_layout_1.value != '0') f.m_layout.value = f.m_layout_1.value + '/' + f.m_layout_1_sub.value;
	else f.m_layout.value = '';

	getIframeForAction(f);
	return true;
}
function iconDrop(val)
{
	var f = document.procForm;
	f.icon.value = val;
	<?php if($type!='makesite'):?>
	iconDropAply();
	<?php else:?>
	getId('_label_icon_btn_').className = '';
	$('#_label_icon_btn_').addClass(val);
	$('#modal_window').modal('hide');
	<?php endif?>
}
function iconDropAply()
{
	var f = document.procForm;
	getIframeForAction(f);
	f.iconaction.value = '1';
	f.submit();
	f.iconaction.value = '';
	getId('_site_icon_<?php echo $R['id']?>').className = 'rb-site-icon';
	$('#_site_icon_<?php echo $R['id']?>').addClass(f.icon.value);
	$('#modal_window').modal('hide');
}

// 고급 설정
$('#site-code-head').on('shown.bs.collapse', function () {
  $(this).find('textarea').focus()
})
$('#site-code-head').on('shown.bs.collapse', function () {
  $(this).find('textarea').focus()
})
$('#site-code-foot').on('shown.bs.collapse', function () {
  $(this).find('textarea').focus()
})
$('#site-code-php').on('shown.bs.collapse', function () {
  $(this).find('textarea').focus()
})
$('#site-code-googleanalytics').on('shown.bs.collapse', function () {
  $(this).find('input').focus()
})
</script>
