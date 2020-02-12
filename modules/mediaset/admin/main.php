<?php
include $g['path_module'].$module.'/function.php';
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);

$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 201 ? $recnum : 20;

$account = $SD['uid'];
$sqlque	= 'uid';
$sqlque .= ' and site='.$account;
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($filekind)
{
	if ($filekind == 1)
	{
		if ($filetype == 2) $sqlque .= ' and type<0';
		else $sqlque .= ' and (type=-1 or type=2)';
	}
	else if ($filekind == 2)
	{
		if ($filetype == 2) $sqlque .= ' and type=0';
		else $sqlque .= ' and (type=0 or type=5)';
	}
	else
	{
		if ($filetype) $sqlque .= ' and fileonly=0';
		else $sqlque .= ' and fileonly=1';
	}
}
else {
	if ($filetype)
	{
		if ($filetype == 1) $sqlque .= ' and type>0';
		else $sqlque .= ' and type<1';
	}
}
if ($fserver)
{
	if ($fserver == 1) $sqlque .= ' and fserver=0';
	else $sqlque .= ' and fserver=1';
}
if ($where && $keyw)
{
	if (strstr('[mbruid]',$where)) $sqlque .= " and ".$where."='".$keyw."'";
	else $sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');
}
$RCD = getDbArray($table['s_upload'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_upload'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div id="uplist" class="">

	<form name="procForm" action="<?php echo $g['s']?>/" method="get" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="module" value="<?php echo $module?>">
		<input type="hidden" name="front" value="<?php echo $front?>">

		<div class="p-3">
			<div class="form-group row">
				<label class="col-md-1 col-form-label text-md-center">필터</label>
				<div class="col-md-11 col-lg-10">
					<div class="form-row">
						<div class="col-sm-3">
							<select name="filekind" class="form-control custom-select" onchange="this.form.submit();">
								<option value="">파일종류(전체)</option>
								<option value="1"<?php if($filekind==1):?> selected<?php endif?>>사진</option>
								<option value="2"<?php if($filekind==2):?> selected<?php endif?>>동영상</option>
								<option value="3"<?php if($filekind==3):?> selected<?php endif?>>기타</option>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="filetype" class="form-control custom-select" onchange="this.form.submit();">
							<option value="">첨부방식(전체)</option>
							<option value="1"<?php if($filetype==1):?> selected<?php endif?>>직접첨부</option>
							<option value="2"<?php if($filetype==2):?> selected<?php endif?>>외부링크</option>
							</select>
						</div>
						<div class="col-sm-3">
							<select name="fserver" class="form-control custom-select" onchange="this.form.submit();">
							<option value="">첨부서버(전체)</option>
							<option value="1"<?php if($fserver==1):?> selected<?php endif?>>현재서버</option>
							<option value="2"<?php if($fserver==2):?> selected<?php endif?>>원격서버</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div id="search-more" class="collapse<?php if($_SESSION['sh_mediaset']):?> show<?php endif?>">

				<div class="form-group row">
					<label class="col-md-1 col-form-label text-md-center">기간</label>
					<div class="col-md-11 col-lg-10">
						<div class="form-row">
							<div class="col-sm-6">
								<div class="input-daterange input-group" id="datepicker">
									<input type="text" class="form-control" name="d_start" placeholder="시작일 선택" value="<?php echo $d_start?>">
									<span class="input-group-addon px-2 text-muted border-0" style="background-color: transparent">~</span>
									<input type="text" class="form-control" name="d_finish" placeholder="종료일 선택" value="<?php echo $d_finish?>">
									<span class="input-group-append">
										<button class="btn btn-light" type="submit">기간적용</button>
									</span>
								</div>
							</div>
							<div class="col-sm-6">
								<span class="button-group">
									<button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>','<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>');">어제</button>
									<button class="btn btn-light" type="button" onclick="dropDate('<?php echo getDateFormat($date['today'],'Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">오늘</button>
									<button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-7,substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">일주</button>
									<button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">한달</button>
									<button class="btn btn-light" type="button" onclick="dropDate('<?php echo getDateFormat(substr($date['today'],0,6).'01','Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">당월</button>
									<button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>01','<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>31');">전월</button>
									<button class="btn btn-light" type="button" onclick="dropDate('','');">전체</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-1 col-form-label text-md-center">정렬</label>
					<div class="col-md-11 col-lg-10">
						<div class="btn-toolbar">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-light<?php if($sort=='gid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="gid" name="sort"<?php if($sort=='gid'):?> checked<?php endif?>> 등록일
								</label>
								<label class="btn btn-light<?php if($sort=='down'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="down" name="sort"<?php if($sort=='down'):?> checked<?php endif?>> 다운로드
								</label>
								<label class="btn btn-light<?php if($sort=='size'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="size" name="sort"<?php if($sort=='size'):?> checked<?php endif?>> 사이즈
								</label>
								<label class="btn btn-light<?php if($sort=='width'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="width" name="sort"<?php if($sort=='width'):?> checked<?php endif?>> 가로
								</label>
								<label class="btn btn-light<?php if($sort=='height'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="height" name="sort"<?php if($sort=='height'):?> checked<?php endif?>> 세로
								</label>
							</div>
							<div class="btn-group btn-group-toggle ml-2" data-toggle="buttons">
								<label class="btn btn-light<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i> 역순
								</label>
								<label class="btn btn-light<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i> 정순
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-1 col-form-label text-md-center">검색</label>
					<div class="col-md-10 col-lg-10">
						<div class="input-group">
							<span class="input-group-prepend">
								<select name="where" class="form-control custom-select">
									<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>파일명</option>
									<option value="caption"<?php if($where=='caption'):?> selected="selected"<?php endif?>>캡션</option>
									<option value="ext"<?php if($where=='ext'):?> selected="selected"<?php endif?>>확장자</option>
									<option value="mbruid"<?php if($where=='mbruid'):?> selected="selected"<?php endif?>>회원UID</option>
								</select>
							</span>
							<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control">
							<span class="input-group-append">
								<button class="btn btn-light" type="submit">검색</button>
							</span>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-1 col-form-label text-md-center">출력</label>
					<div class="col-md-11 col-lg-10">
						<div class="row">
							<div class="col-sm-2">
								<select name="recnum" onchange="this.form.submit();" class="form-control custom-select">
									<option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>><?php echo sprintf('%d개',20)?></option>
									<option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>><?php echo sprintf('%d개',35)?></option>
									<option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>><?php echo sprintf('%d개',50)?></option>
									<option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>><?php echo sprintf('%d개',75)?></option>
									<option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>><?php echo sprintf('%d개',90)?></option>
								</select>
							</div>
							<div class="col-sm-2">

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="offset-sm-1 col-sm-10">
					<button type="button" class="btn btn-link muted-link rb-advance<?php if(!$_SESSION['sh_mediaset']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#search-more" onclick="sessionSetting('sh_mediaset','1','','1');">고급검색 <small></small></button>
					<a href="<?php echo $g['adm_href']?>" class="btn btn-link muted-link">초기화</a>
				</div>
			</div>

		</div>
	</form>


	<div class="mb-2 px-3">
		<small><?php echo number_format($NUM)?> 개</small>
		<span class="badge badge-dark"><?php echo $p?>/<?php echo $TPG.($TPG>1?'pages':'page')?></span>
	</div>

	<form name="listForm" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="">


		<div class="">
			<table class="table table-striped f13">
				<thead class="text-muted">
					<tr>
						<th><label data-tooltip="tooltip" title="선택"><input type="checkbox" class="checkAll-file-user"></label></th>
						<th>번호</th>
						<th class="rb-left">파일명</th>
						<th>소유자</th>
						<th>서버</th>
						<th>폴더</th>
						<th>사이즈</th>
						<th>다운</th>
						<th>날짜</th>
					</tr>
				</thead>
				<tbody>

				<?php $_i=0;while($R=db_fetch_array($RCD)):?>
				<?php $file_ext=$R['ext']?>

				<tr>
					<td><input type="checkbox" name="upfile_members[]" value="<?php echo $R['uid']?>" class="rb-file-user" onclick="checkboxCheck();"></td>
					<td>
						<?php echo $NUM-((($p-1)*$recnum)+$_rec++)?>
					</td>
					<td class="rb-left">
						<i class="fa fa-file-image-o fa-fw" data-tooltip="tooltip" title="<?php echo $file_ext?>"></i>
						<a href="<?php echo getMediaLink($R,1,'b')?>" target="_blank"><?php echo $R['name']?></a>
					</td>
					<?php if($R['mbruid']):?>
					<?php $M=getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'memberuid,name,nic')?>
					<td>
						<a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-mbrinfo muted-link" onmousedown="mbrIdDrop('<?php echo $R['mbruid']?>','profile');">
							<?php echo $M[$_HS['nametype']]?>
						</a>
					</td>
					<?php else:?>
					<td>비회원</td>
					<?php endif?>
					<td><span class="badge badge-dark"><?php echo getDomain($R['url'])?></span></td>
					<td><span class="badge badge-dark"><?php echo $R['folder']?></span></td>
					<td><span class="badge badge-dark"><?php echo $R['size']?getSizeFormat($R['size'],1):''?></span></td>
					<td>
						<a class="badge badge-dark" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=download&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" title="다운로드" data-tooltip="tooltip">
						<?php echo $R['size']?$R['down']:''?>
						</a>
					</td>
					<td class="rb-update">
						<time class="timeago text-muted" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?>"></time>
					</td>
				</tr>
				<?php $_i++;endwhile?>
				</tbody>
			</table>
		</div>

		<?php if(!$NUM):?>
		<div class="rb-none">첨부파일이 없습니다.</div>
		<?php endif?>

		<div class="d-flex justify-content-between p-3">
			<div>
				<button type="button" onclick="chkFlag('upfile_members[]');checkboxCheck();" class="btn btn-light">선택/해제</button>
				<button type="button" onclick="actCheck('multi_delete');" class="btn btn-light" id="rb-action-btn" disabled>삭제</button>
			</div>
			<ul class="pagination">
				<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
			</ul>

		</div>
	</form>

</div>

<!-- bootstrap-datepicker,  http://eternicode.github.io/bootstrap-datepicker/  -->
<?php getImport('bootstrap-datepicker','css/datepicker3',false,'css')?>
<?php getImport('bootstrap-datepicker','js/bootstrap-datepicker',false,'js')?>
<?php getImport('bootstrap-datepicker','js/locales/bootstrap-datepicker.kr',false,'js')?>


<?php include $g['path_module'].'member/admin/_modal.php';?>

<style type="text/css">
.datepicker {z-index: 1151 !important;}
</style>
<script>
$('.input-daterange').datepicker({
	format: "yyyy/mm/dd",
	todayBtn: "linked",
	language: "kr",
	calendarWeeks: true,
	todayHighlight: true,
	autoclose: true
});
</script>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko',false,'js')?>
<script>
jQuery(document).ready(function() {
	$(".rb-update time").timeago();
});

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

$(".checkAll-file-user").click(function(){
	$(".rb-file-user").prop("checked",$(".checkAll-file-user").prop("checked"));
	checkboxCheck();
});
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('upfile_members[]');
    var n = l.length;
    var i;
	var j=0;

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true) j++;
	}
	if (j) getId('rb-action-btn').disabled = false;
	else getId('rb-action-btn').disabled = true;
}
function memberSelect(uid)
{
	var f = document.procForm;
	f.where.value = 'mbruid';
	f.keyw.value = uid;
	f.submit();
}
function dropDate(date1,date2)
{
	var f = document.procForm;
	f.d_start.value = date1;
	f.d_finish.value = date2;
	f.submit();
}
function actCheck(act)
{
	var f = document.listForm;
    var l = document.getElementsByName('upfile_members[]');
    var n = l.length;
	var j = 0;
    var i;

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('선택된 파일이 없습니다.      ');
		return false;
	}
	if (act == 'multi_delete')
	{
		if (confirm('정말로 삭제 하시겠습니까?       '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}

	return false;
}

// 회원 이름,닉네임 클릭시 uid & mod( 탭 정보 : info, main, post 등) 지정하는 함수
var _mbrModalUid;
var _mbrModalMod;
function mbrIdDrop(uid,mod)
{
	_mbrModalUid = uid;
	_mbrModalMod = mod;
}

// 회원정보 modal 호출하는 함수 : 위에서 지정한 회원 uid & mod 로 호출한다 .
$('.rb-modal-mbrinfo').on('click',function() {
  modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=member&amp;front=modal.mbrinfo&amp;uid=')?>'+_mbrModalUid+'&amp;tab='+_mbrModalMod);
});
</script>
