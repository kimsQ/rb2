<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 301 ? $recnum : 12;
$popupque	= '';

// 키워드 검색 추가
if ($keyw)
{
	$popupque .= "(name like '%".$keyw."%')";
}

$POPUPS = getDbArray($table['s_popup'],$popupque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_popup'],$popupque);
$TPG = getTotalPage($NUM,$recnum);

if ($uid)
{
	$R = getUidData($table['s_popup'],$uid);
}
if ($R['uid'])
{
	$year1	= substr($R['term1'],0,4);
	$month1	= substr($R['term1'],4,2);
	$day1	= substr($R['term1'],6,2);
	$hour1	= substr($R['term1'],8,2);
	$min1	= substr($R['term1'],10,2);
	$year2	= substr($R['term2'],0,4);
	$month2	= substr($R['term2'],4,2);
	$day2	= substr($R['term2'],6,2);
	$hour2	= substr($R['term2'],8,2);
	$min2	= substr($R['term2'],10,2);
	$width =$R['width'];
	$height =$R['height'];

}
else {
	$year1	= substr($date['today'],0,4);
	$month1	= substr($date['today'],4,2);
	$day1	= substr($date['today'],6,2);
	$hour1	= 0;
	$min1	= 0;
	$year2	= substr($date['today'],0,4);
	$month2	= substr($date['today'],4,2);
	$day2	= substr($date['today'],6,2);
	$hour2	= 23;
	$min2	= 59;
	$R['width'] = 400;
	$R['height']= 400;
}
?>

<div id="rb-popup" class="row no-gutters">
	<div class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar"><!-- 좌측  내용 -->
		<div class="panel-group" id="accordion">
			<div class="card border-0">
				<div class="card-header d-flex justify-content-between p-2">
					<span>팝업 목록 <?php if ($NUM): ?><span class="badge badge-pill badge-dark dueday"><?php echo $NUM ?> 개</span><?php endif; ?></span>
					<button type="button" class="btn btn-link muted-link py-0<?php if(!$_SESSION['sh_popup_search']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#panel-search" onclick="sessionSetting('sh_popup_search','1','','1');getSearchFocus();">
						<i class="fa fa-search"></i>
					</button>
				</div>
				<div class="card-body p-0">
					<div id="panel-search" class="collapse<?php if($_SESSION['sh_popup_search']):?> show<?php endif?>">
						<form role="form" action="<?php echo $g['s']?>/" method="get">
						<input type="hidden" name="r" value="<?php echo $r?>">
						<input type="hidden" name="m" value="<?php echo $m?>">
						<input type="hidden" name="module" value="<?php echo $module?>">
						<input type="hidden" name="front" value="<?php echo $front?>">

						<div class="panel-heading rb-search-box">
							<div class="input-group w-100">
								<div class="input-group-prepend">
									<span class="input-group-text">출력수</span>
								</div>
								<select class="form-control custom-select" name="recnum" onchange="this.form.submit();">
									<option value="15"<?php if($recnum==15):?> selected<?php endif?>>15</option>
									<option value="30"<?php if($recnum==30):?> selected<?php endif?>>30</option>
									<option value="60"<?php if($recnum==60):?> selected<?php endif?>>60</option>
									<option value="100"<?php if($recnum==100):?> selected<?php endif?>>100</option>
								</select>
							</div>
						</div>
						<div class="rb-keyword-search input-group">
							<input type="text" name="keyw" class="form-control" value="<?php echo $keyw?>" placeholder="등록된 팝업 검색어 입력">
							<div class="input-group-append">
								<button class="btn btn-light" type="submit">검색</button>
							</div>
						</div>
						</form>
					</div>
					<?php if($NUM):?>
					<div class="pb-2" style="height: calc(100vh - 14rem);" data-role="list">
						<div class="list-group list-group-flush border-bottom">
							<?php while($PR = db_fetch_array($POPUPS)):?>
							<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?php if($PR['uid']==$uid):?> border border-primary<?php endif?>" href="<?php echo $g['adm_href']?>&amp;p=<?php echo $p?>&amp;uid=<?php echo $PR['uid']?>">
								<span>
									<?php echo $PR['name']?>

									<?php if ($PR['term0'] || ($PR['term1'] < $date['totime'] && $PR['term2'] > $date['totime'])): ?>
									<?php if($PR['admin']):?>
									<span class="badge badge-pill badge-dark text-danger" data-toggle="tooltip" title="관리자 전용"><i class="fa fa-lock" aria-hidden="true"></i></span>
									<?php endif?>
									<?php endif; ?>

									<?php if($PR['term0']):?>
									<span class="badge badge-pill badge-dark">기간제한없음</span>
									<?php endif?>
									<?php if(!$PR['term0'] && ($PR['term1'] < $date['totime'] && $PR['term2'] > $date['totime'])):?>
									<time data-plugin="timeago" class="badge badge-pill badge-dark dueday" data-toggle="tooltip" datetime="<?php echo getDateFormat($PR['term2'],'c')?>" title="<?php echo  getDateFormat($PR['term2'],'Y/m/d H:i')?>"></time>
									<?php endif?>

								</span>
								<span>

									<?php if (!$PR['hidden']): ?>
									<?php if ($PR['term0'] || ($PR['term1'] < $date['totime'] && $PR['term2'] > $date['totime'])): ?>
									<i class="fa fa-circle text-success ml-auto" data-toggle="tooltip" title="활성"></i>
									<?php endif; ?>
									<?php else: ?>
									<i class="fa fa-circle text-secondary ml-auto" data-toggle="tooltip" title="일시중지"></i>
									<?php endif; ?>

								</span>
							</a>
							<?php endwhile?>
						</div>
					</div>

					<ul class="pagination justify-content-center mt-4">
						<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
					</ul>

					<?php else:?>
					<div class="d-flex justify-content-center align-items-center text-muted" style="height: calc(100vh - 10rem);">

						<div class="text-center">
							<i class="fa fa-exclamation-circle fa-3x mb-2 d-block" aria-hidden="true"></i>
							등록된 팝업이 없습니다.
						</div>

					</div>
					<?php endif?>
				</div>



				<div class="card-footer">
				 	 <a href="<?php echo $g['adm_href']?>&amp;newpop=Y" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> 새 팝업 만들기</a>
				 </div>

			</div>

			<?php if($g['device']):?><a name="popup-info"></a><?php endif?>
		</div>
	</div><!-- //좌측  내용 끝 -->

	<!-- 우측 내용 시작 -->
	<div id="tab-content-view" class="col-sm-8 col-md-8 ml-sm-auto col-xl-9">

		<form class="card rounded-0 border-0" role="form" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $module?>" />
			<input type="hidden" name="front" value="<?php echo $front?>" />
			<input type="hidden" name="a" value="regispopup" />
			<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />
			<input type="hidden" name="dispage" value="<?php echo $R['dispage']?>" />

			<div class="card-header d-flex justify-content-between align-items-center page-body-header">
				<?php echo $R['uid']?'팝업 등록정보':'새 팝업 만들기' ?>
			</div><!-- /.card-header -->
			<div class="card-body">

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">팝업이름</label>
					<div class="col-lg-10 col-xl-9">
						<?php if($R['uid']):?>
						<div class="input-group">
							<input type="text" name="name" value="<?php echo $R['name']?>" class="form-control"<?php if(!$g['device']):?> autofocus<?php endif?>>
							<span class="input-group-append">
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletepopup&amp;uid=<?php echo $R['uid']?>"  class="btn btn-light" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');" data-tooltip="tooltip" title="팝업 삭제">
									<i class="fa fa-trash-o fa-lg"></i>
								</a>
							</span>
						</div>
						<?php else:?>
						<input class="form-control" placeholder="" type="text" name="name" value="<?php echo $R['name']?>"<?php if(!$g['device']):?> autofocus<?php endif?>>
						<?php endif?>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">노출옵션</label>
					<div class="col-sm-10 pt-1">
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" class="custom-control-input" id="hidden" name="hidden" value="1"<?php if($R['hidden']):?> checked<?php endif?>>
							<label class="custom-control-label" for="hidden">일시중지</label>
						</div>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" class="custom-control-input" id="admin" name="admin" value="1"<?php if(!$uid || $R['admin']):?> checked<?php endif?>>
							<label class="custom-control-label" for="admin"><i class="fa fa-lock" aria-hidden="true"></i> 관리자 전용</label>
						</div>

					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">노출기간</label>
					<div class="col-sm-10 pt-1">
						<div class="custom-control custom-checkbox custom-control-inline">
						  <input type="checkbox" class="custom-control-input" id="term0" name="term0" value="1"<?php if($R['term0']):?> checked<?php endif?>>
						  <label class="custom-control-label" for="term0">제한없음</label>
						</div>
					</div>
				</div>

				<div data-role="term" <?php if($R['term0']):?> class="d-none"<?php endif?>>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label text-lg-right">시작일</label>
						<div class="col-lg-10">
							<div class="form-inline">
								<div class="input-group">
									<select name="year1" class="form-control custom-select">
										<?php for($i=$date['year'];$i<$date['year']+2;$i++):?>
										<option value="<?php echo $i?>"<?php if($year1==$i):?> selected<?php endif?>>
											<?php echo $i?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">년</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="month1" class="form-control custom-select">
										<?php for($i=1;$i<13;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($month1==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">월</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="day1" class="form-control custom-select">
										<?php for($i=1;$i<32;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($day1==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>(<?php echo getWeekday(date('w',mktime(0,0,0,$month1,$i,$year1)))?>)
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">일</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="hour1" class="form-control custom-select">
										<?php for($i=0;$i<24;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($hour1==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">시</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="min1" class="form-control custom-select">
										<?php for($i=0;$i<60;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($min1==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-prepend">
								    <span class="input-group-text">분</span>
								  </div>
								</div>
							</div><!-- /.form-inline -->
						</div>
					</div>

					<div class="form-group row">
						<label class="col-lg-2 col-form-label text-lg-right">종료일</label>
						<div class="col-lg-10">

							<div class="form-inline">
								<div class="input-group">
									<select name="year2" class="form-control custom-select">
										<?php for($i=$date['year'];$i<$date['year']+2;$i++):?>
										<option value="<?php echo $i?>"<?php if($year2==$i):?> selected<?php endif?>>
											<?php echo $i?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">년</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="month2" class="form-control custom-select">
										<?php for($i=1;$i<13;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($month2==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">월</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="day2" class="form-control custom-select">
										<?php for($i=1;$i<32;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($day2==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>(<?php echo getWeekday(date('w',mktime(0,0,0,$month2,$i,$year2)))?>)
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">일</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="hour2" class="form-control custom-select">
										<?php for($i=0;$i<24;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($hour2==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-append">
								    <span class="input-group-text">시</span>
								  </div>
								</div>
								<div class="input-group ml-1">
									<select name="min2" class="form-control custom-select">
										<?php for($i=0;$i<60;$i++):?>
										<option value="<?php echo sprintf('%02d',$i)?>"<?php if($min2==$i):?> selected<?php endif?>>
											<?php echo sprintf('%02d',$i)?>
										</option>
										<?php endfor?>
									</select>
									<div class="input-group-prepend">
								    <span class="input-group-text">분</span>
								  </div>
								</div>
							</div><!-- /.form-inline -->

						</div>
					</div>
				</div><!-- /data-role="term" -->

				<div class="form-group row">
					<label class="col-lg-2 col-form-label text-lg-right">배경색</label>
					<div class="col-sm-6">

						<div class="input-group colorpicker-component w-50" id="colorpicker">
						  <input type="text" class="form-control" placeholder="" name="bgcolor" value="<?php echo $R['bgcolor']?$R['bgcolor']:'#fff' ?>" >
						  <div class="input-group-append input-group-addon border-0" style="background-color: none">
								<span class="input-group-text"><i></i></span>
						  </div>
						</div>
						<small class="form-text text-muted mt-2">
						</small>

					</div>
				</div>

				<hr>

				<div class="card mb-3">
					<div class="card-header">
						<i class="fa fa-desktop fa-fw"></i> 데스크탑 팝업
					</div><!-- /.card-header -->
					<div class="card-body">

						<div class="form-group row">
							 <label class="col-lg-2 col-form-label text-lg-right">테마</label>
								<div class="col-lg-10 col-xl-9">
								 <select name="skin" class="form-control custom-select" id="popup-theme">

									 <?php $_skinHexp=explode('/',$d['bbs']['skin_main'])?>
									 <option value="">선택하세요.</option>
									 <option disabled>--------------------</option>
									 <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
									 <?php $dirs = opendir($tdir)?>
									 <?php while(false !== ($skin = readdir($dirs))):?>
									 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
									 <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($R['skin']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
									 <?php endwhile?>
									 <?php closedir($dirs)?>
								 </select>
							 </div> <!-- .col-sm-10  -->
						 </div> <!-- .form-group  -->


			 				<div id="popup-size">
			 					<div class="form-group row">
			 						<label class="col-lg-2 col-form-label text-right">노출크기</label>
			 						<div class="col-md-5 col-sm-10">
			 							<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">가로</span>
											</div>
			 								<input type="text" name="width" value="<?php echo $R['width']?>" class="form-control" placeholder="가로">
			 								<div class="input-group-append">
			 							    <span class="input-group-text">px</span>
			 							  </div>
			 							</div>
			 							<small class="form-text text-muted">세로 크기는 컨텐츠 높이 따라 동적으로 할당 됩니다.</small>
			 						</div>
			 					</div>
			 				</div>

			 				<div id="popup-position">
			 					<div class="form-group row">
			 						<label class="col-lg-2 col-form-label text-lg-right">노출위치</label>
			 						<div class="col-md-8 col-sm-10">

										<div class="btn-group btn-group-toggle" data-toggle="buttons">
										  <label class="btn btn-light<?php if ($R['position'] == 'default' || !$R['position'] ): ?> active<?php endif; ?>">
										    <input type="radio" name="position" autocomplete="off"  value="default"<?php if ($R['positon'] == 'default' || !$R['position']): ?> checked<?php endif; ?>>
												상단중앙
										  </label>
										  <label class="btn btn-light<?php if ($R['position'] == 'vcenter'): ?> active<?php endif; ?>">
										    <input type="radio" name="position" autocomplete="off" value="vcenter"<?php if ($R['position'] == 'vcenter'): ?> checked<?php endif; ?>>
												정중앙
										  </label>
											<label class="btn btn-light<?php if ($R['position'] == 'manual'): ?> active<?php endif; ?>">
												<input type="radio" name="position" autocomplete="off" value="manual"<?php if ($R['position'] == 'manual'): ?> checked<?php endif; ?>>
												위치지정
											</label>
										</div>

										<div class="mt-3 <?php if ($R['position'] != 'manual'): ?> d-none<?php endif; ?>" id="position-manual">

											<div class="input-group">
				 								<input type="text" name="ptop" value="<?php echo $R['ptop']?$R['ptop']:0?>" class="form-control" placeholder="위쪽">
				 								<div class="input-group-prepend">
				 							    <span class="input-group-text">x</span>
				 							  </div>
				 								<input type="text" name="pleft" value="<?php echo $R['pleft']?$R['pleft']:0?>" class="form-control" placeholder="왼쪽">
				 								<div class="input-group-append">
				 							    <div class="input-group-text">
				 							      <input class="mr-2" type="checkbox" name="center" value="1"<?php if($R['center']):?> checked<?php endif?>> 중앙에서 위치계산
				 							    </div>
				 							  </div>
				 							</div><!-- /.input-group -->
											<small class="form-text text-muted">위쪽 * 왼쪽의 단위는 픽셀입니다.</small>

											<div class="custom-control custom-checkbox custom-control-inline my-3">
												<input type="checkbox" class="custom-control-input" id="draggable" name="draggable" value="1"<?php if($R['draggable']):?> checked<?php endif?>>
												<label class="custom-control-label" for="draggable"><i class="fa fa-arrows" aria-hidden="true"></i> 드래그 이동 가능</label>
											</div>

										</div><!-- /#positon-manual -->

			 						</div>




			 					</div>
			 				</div>


							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-lg-right">내용</label>
								<div class="col-md-9 col-sm-10">

									<div class="btn-group btn-group-toggle" data-toggle="buttons">
									  <label class="btn btn-light<?php if ($R['type'] == 'photoset' || !$R['type'] ): ?> active<?php endif; ?>">
									    <input type="radio" name="type" autocomplete="off"  value="photoset"<?php if ($R['type'] == 'photoset' || !$R['type']): ?> checked<?php endif; ?>>
											<i class="fa fa-picture-o fa-fw" aria-hidden="true"></i>
											포토셋
									  </label>
									  <label class="btn btn-light<?php if ($R['type'] == 'code'): ?> active<?php endif; ?>">
									    <input type="radio" name="type" autocomplete="off" value="code"<?php if ($R['type'] == 'code'): ?> checked<?php endif; ?>>
											<i class="fa fa-code fa-fw" aria-hidden="true"></i>
											직접입력
									  </label>
									</div>

								</div>
							</div>

							<div class="tab-content">
								<div class="tab-pane fade<?php if ($R['type'] == 'photoset' || !$R['type']): ?> show active<?php endif; ?>" id="type-photoset">
									<div class="form-group row mb-0">
										<label class="col-lg-2 col-form-label text-lg-right"></label>
										<div class="col-lg-10 col-xl-9">
											<div class="input-group">
												<input class="form-control rb-modal-photo-drop" type="text" name="upload" id="mediaset" value="<?php echo $R['upload']?$R['upload']:''?>" onmousedown="_mediasetField='mediaset&dfiles='+this.value;" data-toggle="modal" data-target="#modal_window">
												<div class="input-group-append">
													<button class="btn btn-light rb-modal-photo" type="button" title="포토셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
														<i class="fa fa-photo fa-lg"></i>
													</button>
												</div>
											</div>
											<ul class="list-unstyled mt-2 text-muted">
												<li><small>여기에 연결시킬 미디어 파일을 지정할 수 있습니다.</small></li>
											</ul>
										</div>
									</div>
								</div><!-- /.tab-pane -->
								<div class="tab-pane fade<?php if ($R['type'] == 'code'): ?> show active<?php endif; ?>" id="type-code" role="tabpanel">
									<div class="form-group row mb-0">
										<label class="col-lg-2 col-form-label text-lg-right"></label>
										<div class="col-md-9 col-sm-10">
											<input type="hidden" name="html" value="<?php echo $R['html']?$R['html']:'HTML'?>">
											<textarea class="form-control f12" rows="10" name="source"><?php echo $R['content']?></textarea>
											<small class="form-text text-muted mt-2">
												이미지는 <a class="rb-modal-photo" data-toggle="modal" href="#modal_window">포토셋</a> 에 업로드 후, 원본보기 링크에서 경로를 확인해 주세요.
	 									 </small>
										</div>
									</div>
								</div><!-- /.tab-pane -->
							</div><!-- /.tab-content -->

					</div><!-- /.card-body -->
				</div><!-- /.card -->


				<div class="card">
					<div class="card-header">
						<i class="fa fa-mobile fa-lg fa-fw"></i> 모바일 팝업
					</div><!-- /.card-header -->
					<div class="card-body">

						<div class="form-group row">
		 				 <label class="col-lg-2 col-form-label text-lg-right">테마</label>
		 					<div class="col-lg-10 col-xl-9">
		 						 <select name="m_skin" class="form-control custom-select">
		 							 <?php $_skinmHexp=explode('/',$d['bbs']['skin_mobile'])?>
		 							 <option value="">선택하세요.</option>
		 							 <option disabled>--------------------</option>
									 <?php $tdir = $g['path_module'].$module.'/themes/_mobile/'?>
									 <?php $dirs = opendir($tdir)?>
									 <?php while(false !== ($skin = readdir($dirs))):?>
									 <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
									 <option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($R['m_skin']=='_mobile/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
									 <?php endwhile?>
									 <?php closedir($dirs)?>
		 						 </select>
		 					 </div> <!-- .col-sm-10  -->
		 			 </div> <!-- .form-group  -->

					 <div class="form-group row">
						 <label class="col-lg-2 col-form-label text-lg-right">내용</label>
						 <div class="col-md-9 col-sm-10">

							 <div class="btn-group btn-group-toggle" data-toggle="buttons">
								 <label class="btn btn-light<?php if ($R['m_type'] == 'photoset' || !$R['m_type']): ?> active<?php endif; ?>">
									 <input type="radio" name="m_type" autocomplete="off"  value="photoset"<?php if ($R['m_type'] == 'photoset' || !$R['m_type']): ?> checked<?php endif; ?>>
									 <i class="fa fa-picture-o fa-fw" aria-hidden="true"></i>
									 포토셋
								 </label>
								 <label class="btn btn-light<?php if ($R['m_type'] == 'code'): ?> active<?php endif; ?>">
									 <input type="radio" name="m_type" autocomplete="off" value="code"<?php if ($R['m_type'] == 'code'): ?> checked<?php endif; ?>>
									 <i class="fa fa-code fa-fw" aria-hidden="true"></i>
									 직접입력
								 </label>
							 </div>

						 </div>
					 </div>

					 <div class="tab-content">
						 <div class="tab-pane fade<?php if ($R['m_type'] == 'photoset' || !$R['m_type']): ?> show active<?php endif; ?>" id="m-type-photoset">
							 <div class="form-group row mb-0">
								 <label class="col-lg-2 col-form-label text-lg-right"></label>
								 <div class="col-lg-10 col-xl-9">
									 <div class="input-group">
										 <input class="form-control rb-modal-photo-drop" type="text" name="m_upload" id="_mediaset" value="<?php echo $R['m_upload']?$R['m_upload']:''?>" onmousedown="_mediasetField='_mediaset&dfiles='+this.value;" data-toggle="modal" data-target="#modal_window">
										 <div class="input-group-append">
											 <button class="btn btn-light rb-modal-photo-mobile" type="button" title="포토셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
												 <i class="fa fa-photo fa-lg"></i>
											 </button>
										 </div>
									 </div>
									 <ul class="list-unstyled mt-2 text-muted">
										 <li><small>여기에 연결시킬 미디어 파일을 지정할 수 있습니다.</small></li>
									 </ul>
								 </div>
							 </div>
						 </div><!-- /.tab-pane -->
						 <div class="tab-pane fade<?php if ($R['m_type'] == 'code'): ?> show active<?php endif; ?>" id="m-type-code" role="tabpanel">
							 <div class="form-group row mb-0">
								 <label class="col-lg-2 col-form-label text-lg-right"></label>
								 <div class="col-md-9 col-sm-10">
									 <input type="hidden" name="html" value="<?php echo $R['m_html']?$R['m_html']:'HTML'?>">
									 <textarea class="form-control f12" rows="10" name="m_source"><?php echo $R['m_content']?></textarea>
									 <small class="form-text text-muted mt-2">
										 이미지는 <a class="rb-modal-photo" data-toggle="modal" href="#modal_window">포토셋</a> 에 업로드 후, 원본보기 링크에서 경로를 확인해 주세요.
									</small>
								 </div>
							 </div>
						 </div><!-- /.tab-pane -->
					 </div><!-- /.tab-content -->

					</div><!-- /.card-body -->
				</div><!-- /.card -->






				<hr>


				<div class="card">
					<div class="card-header">
						<i class="kf-home fa-fw"></i> 노출 사이트 지정
					</div><!-- /.card-header -->
					<div class="card-body">
						<?php $i=0?>
						<?php $dispagex = explode('|',$R['dispage'])?>
						<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
						<?php while($S = db_fetch_array($SITES)):?>
						<div class="form-group row">
							<label class="col-lg-2 col-form-label text-lg-right"><?php echo $S['name']?></label>
							<div class="col-md-9 col-sm-10">
								<div class="d-none">
									<input type="checkbox" name="sitemembers[]" value="[<?php echo $S['uid']?>]" checked />
								</div>
								<div class="input-group">
									<input type="text" name="pagemembers[]" value="<?php echo str_replace('m['.$S['uid'].']','',str_replace('[s['.$S['uid'].']]','',str_replace('[c['.$S['uid'].']]','',$dispagex[$i])))?>" class="form-control" />
									<div class="input-group-append">
										<div class="input-group-text">
											<input class="mr-2" type="checkbox" name="cutmembers[]" value="[<?php echo $S['uid']?>]"<?php if(strstr($dispagex[$i],'[c['.$S['uid'].']]')):?> checked<?php endif?>>
											전체차단
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $i++?>
						<?php endwhile?>

					</div><!-- /.card-body -->
					<div class="card-footer">
						<div class="text-muted mb-3">
							<i class="fa fa-power-off fa-3x fa-pull-left" aria-hidden="true"></i>
							<strong class="d-block">
								<a href="<?php echo $g['s']?>/?r=<?php echo $r ?>&m=admin&module=admin&front=switch&switchdir=foot/popup">팝업 스위치 설정</a>이 필요합니다.
							</strong>
							<small class="text-muted">적용 사이트에 팝업 스위치가 켜지지 않은 경우, 팝업이 뜨지 않습니다. 팝업 스위치가 켜져 있는지 확인해 보세요.</small>
						</div>
						<hr>
						<small class="text-muted">사이트별로 노출할 페이지 및 메뉴를 지정할 수 있습니다.<br>
							특정 페이지만 출력시 : <code>[페이지ID][페이지ID]...</code> 의 형식으로 출력페이지를 등록<br>
							특정메뉴만 출력시 : <code>[메뉴코드][메뉴코드]...</code> 의 형식으로 출력메뉴를 등록. <br>
							전체차단 항목에 체크하지 않으면 모든 페이지에 대해서 팝업이 출력됩니다.</small>
					</div>
				</div><!-- /.card -->

				<hr>

				<button type="submit" class="btn btn-outline-primary btn-block btn-lg">
					<?php echo $R['uid']?'팝업 속성 변경':'새 팝업 만들기' ?>
				</button>


			</div><!-- /.card-body -->

		</form>
	</div>
</div>
<div class="modal" id="popup-preview">
   <div class="modal-cont">
		   <div class="modal-body">
		       <!-- 아작스 모달내용 출력 -->
		    </div>
		    <div id="popclose">
			    <form name="pop">
			      <input type="checkbox" name="x" checked="cbecked" /> 오늘 하루 이창을 그만 엽니다.
			       <a href="#" data-dismiss="modal"> close</a>
			    </form>
			  </div>
	 </div>
</div>
<style>
#popclose {z-index:1200;width:100%;padding:2px 0;height:25px;background:#343434;text-align:center;color:#ffffff;}
#popclose a {color:#fff;margin-left: 20px;}
#popclose a:hover {color:#fff;text-decoration: none;}
#popup-preview .modal-cont {width:<?php echo $width?>px;height:<?php echo $height?>px;margin-top:<?php echo $R['ptop']?>px;margin-left:<?php echo $R['pleft']?>px;background: #fff;}
#popup-preview .modal-body {width:<?php echo $width?>px;height:<?php echo $height?>px;padding:0;overflow:hidden;}
</style>
<?php if($R['scroll']):?>
<style>
.modal-body {padding:0;overflow-x: hidden;overflow-y: scroll;}
</style>
<?php endif?>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago','1.6.1','js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko','1.6.1','js')?>

<!-- bootstrap-colorpicker -->
<?php getImport('bootstrap-colorpicker','css/bootstrap-colorpicker','3.0.0-beta.1','css')?>
<?php getImport('bootstrap-colorpicker','js/bootstrap-colorpicker.min','3.0.0-beta.1','js')?>

<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()

	jQuery.timeago.settings.allowFuture = true;
	$('[data-plugin="timeago"]').timeago();

  $(".dueday").each(function(){
    var dueday = $(this).text()
    var dueday2 = dueday.replace("전", "지남").replace("후", "남음");
    $(this).text(dueday2)
  });

	$('#colorpicker').colorpicker();

	$('#term0').change(function(){
		if ($(this).is(':checked')) {
			$('[data-role="term"]').addClass('d-none')
		} else {
			$('[data-role="term"]').removeClass('d-none')
		}
	});

	$('input:radio[name="position"]').change(function(){
		if ($(this).val() == 'manual') {
			$('#position-manual').removeClass('d-none')
		} else {
			$('#position-manual').addClass('d-none')
		}
	});

	$('input:radio[name="type"]').change(function(){
		if ($(this).val() == 'photoset') {
			$('#type-photoset').addClass('show active')
			$('#type-code').removeClass('show active')
		}
		if ($(this).val() == 'code') {
			$('#type-code').addClass('show active')
			$('#type-photoset').removeClass('show active')
			setTimeout(function(){$('#type-code').find('textarea').focus() }, 100);
		}
	});

	$('input:radio[name="m_type"]').change(function(){
		if ($(this).val() == 'photoset') {
			$('#m-type-photoset').addClass('show active')
			$('#m-type-code').removeClass('show active')
		}
		if ($(this).val() == 'code') {
			$('#m-type-code').addClass('show active')
			$('#m-type-photoset').removeClass('show active')
			setTimeout(function(){$('#m-type-code').find('textarea').focus() }, 100);
		}
	});

	putCookieAlert('result_popup_main') // 실행결과 알림 메시지 출력

	$("#popup-theme").change(function(){
		var theme =  this.value
		if (theme == '_desktop/bs4-modal') {
			$("#popup-size").css('display','block');
			$("#popup-position").css('display','block');
		} else {
			$("#popup-size").css('display','none');
			$("#popup-position").css('display','none');
		}
	});

	$('.rb-modal-photo').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=mediaset')?>');
	});
	$('.rb-modal-photo-mobile').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=_mediaset')?>');
	});
	$('.rb-modal-photo-drop').on('click',function() {
		modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=')?>'+_mediasetField);
	});


})


// 팝업 미리보기 모달창 호출
function popUpModalSet(uid)
{
   var ajax=getHttprequest(rooturl+'/?r='+raccount+'&m=admin&module=<?php echo $module?>&front=preview&uid='+uid,'');
   var result=getAjaxFilterString(ajax,'RESULT');
   result=result.replace(/&nbsp;/gi,'');
   $('#popup-preview').find('.modal-body').html(result);
   $('#popup-preview').modal({show:true});
   $('.modal-backdrop').remove(); // 백드롭 없앤다.
}

//<![CDATA[


function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}

function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('팝업이름을 입력해 주세요.');
		f.name.focus();
		return false;
	}

	if (f.width.value == "")
	{
		alert('팝업창의 가로폭을 입력해 주세요');
		f.width.focus();
		return false;
	}

	if (f.skin.value == '')
	{
		alert('데스크탑 팝업 테마를 지정해 주세요.      ');
		f.skin.focus();
		return false;
	}

	if (f.m_skin.value == '')
	{
		alert('모바일 팝업 테마를 지정해 주세요.      ');
		f.m_skin.focus();
		return false;
	}

    var s = document.getElementsByName('sitemembers[]');
    var c = document.getElementsByName('cutmembers[]');
    var l = document.getElementsByName('pagemembers[]');
    var n = l.length;
    var i;
	var cs = '';

    for (i = 0; i < n; i++)
	{
		if (c[i].checked == true)
		{
			cs += '[c'+s[i].value+']';
		}
		if (l[i].value == '')
		{
			cs += '[s'+s[i].value+']' + '|';
		}
		else {
			cs += l[i].value.replace(/\[/g,'[m'+s[i].value) + '|';
		}
	}

	f.dispage.value = cs;

	getIframeForAction(f);
	f.submit();

}
//]]>
</script>
