<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);
$SITEN   = db_num_rows($SITES);
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;
$_WHERE='uid>0';
$account = $SD['uid'];
if($account) $_WHERE .=' and site='.$account;
if ($d_start) $_WHERE .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $_WHERE .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($bid) $_WHERE .= ' and bbs='.$bid;
if ($category) $_WHERE .= " and category ='".$category."'";
if ($notice) $_WHERE .= ' and notice=1';
if ($hidden) $_WHERE .= ' and hidden=1';
if ($where && $keyw)
{
	if (strstr('[name][nic][id][ip]',$where)) $_WHERE .= " and ".$where."='".$keyw."'";
	else $_WHERE .= getSearchSql($where,$keyw,$ikeyword,'or');
}
$RCD = getDbArray($table[$module.'data'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table[$module.'data'],$_WHERE);
$TPG = getTotalPage($NUM,$recnum);
?>

<div class="row no-gutters">

	<nav class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar sidebar-right">

		<form name="procForm" action="<?php echo $g['s']?>/" method="get">
			 <input type="hidden" name="r" value="<?php echo $r?>">
			 <input type="hidden" name="m" value="<?php echo $m?>">
			 <input type="hidden" name="module" value="<?php echo $module?>">
			 <input type="hidden" name="front" value="<?php echo $front?>">

			<div id="accordion" role="tablist">
			  <div class="card">
			    <div class="card-header p-0" role="tab">
						<a class="d-block muted-link<?php if($_SESSION['bbs_post_collapse']!='filter'):?> collapsed<?php endif?>" data-toggle="collapse" href="#collapse-filter" role="button" aria-expanded="true" aria-controls="collapseOne" onclick="sessionSetting('bbs_post_collapse','filter','','');">
							필터
						</a>
			    </div>

			    <div id="collapse-filter" class="collapse<?php if($_SESSION['bbs_post_collapse']=='filter'):?> show<?php endif?>" role="tabpanel" data-parent="#accordion">
			      <div class="card-body">

							<select name="bid" class="form-control custom-select mb-2" onchange="this.form.submit();">
								<option value="">사이트 전체 게시판</option>
								<?php $_BBSLIST = getDbArray($table[$module.'list'],'site='.$account,'*','gid','asc',0,1)?>
								<?php while($_B=db_fetch_array($_BBSLIST)):?>
								<option value="<?php echo $_B['uid']?>"<?php if($_B['uid']==$bid):?> selected="selected"<?php endif?>>ㆍ<?php echo $_B['name']?>(<?php echo $_B['id']?> - <?php echo number_format($_B['num_r'])?>)</option>
								<?php endwhile?>
								<?php if(!db_num_rows($_BBSLIST)):?>
								<option value="">등록된 게시판이 없습니다.</option>
								<?php endif?>
							</select>

							<select name="category" onchange="this.form.submit();" class="form-control custom-select mb-2">
								<?php $getCate=db_query("select * from rb_bbs_data where bbs='".$bid."' and category<>'' group by category",$DB_CONNECT)?>
								<option value="0">전체 카테고리</option>
								<?php while($ct=db_fetch_array($getCate)):?>
								<option value="<?php echo $ct['category']?>" <?php if($category==$ct['category']):?> selected="selected"<?php endif?>><?php echo $ct['category']?></option>
								<?php endwhile?>
								<?php if(!db_num_rows($getCate)):?>
								<option value="">등록된 카테고리가 없습니다.</option>
								<?php endif?>
						 </select>

						 <div class="mb-2">

							 <div class="custom-control custom-checkbox custom-control-inline">
							   <input type="checkbox" class="custom-control-input" id="notice" name="notice" value="Y"<?php if($notice=='Y'):?> checked<?php endif?> onclick="this.form.submit();">
							   <label class="custom-control-label" for="notice">공지글</label>
							 </div>

							 <div class="custom-control custom-checkbox custom-control-inline">
							   <input type="checkbox" class="custom-control-input" id="hidden" name="hidden" value="Y"<?php if($hidden=='Y'):?> checked<?php endif?> onclick="this.form.submit();">
							   <label class="custom-control-label" for="hidden">비밀글</label>
							 </div>

						 </div>

						 <div class="input-daterange input-group input-group-sm mb-2" id="datepicker">
							 <input type="text" class="form-control" name="d_start" placeholder="시작일 선택" value="<?php echo $d_start?>">
							 <input type="text" class="form-control" name="d_finish" placeholder="종료일 선택" value="<?php echo $d_finish?>">
							 <span class="input-group-append">
								 <button class="btn btn-light" type="submit">기간적용</button>
							 </span>
						 </div>


						 <span class="btn-group btn-group-toggle">
							 <button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>','<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>');">어제</button>
							 <button class="btn btn-light" type="button" onclick="dropDate('<?php echo getDateFormat($date['today'],'Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">오늘</button>
							 <button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-7,substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">일주</button>
						 </span>

						 <span class="btn-group btn-group-toggle">
							 <button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">한달</button>
							 <button class="btn btn-light" type="button" onclick="dropDate('<?php echo getDateFormat(substr($date['today'],0,6).'01','Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">당월</button>
							 <button class="btn btn-light" type="button" onclick="dropDate('<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>01','<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>31');">전월</button>
							 <button class="btn btn-light" type="button" onclick="dropDate('','');">전체</button>
						 </span>


			      </div>
			    </div>
			  </div>
			  <div class="card">
			    <div class="card-header p-0" role="tab">
						<a class="d-block muted-link<?php if($_SESSION['bbs_post_collapse']!='sort'):?> collapsed<?php endif?>" data-toggle="collapse" href="#collapse-sort" role="button" aria-expanded="false" aria-controls="collapseTwo" onclick="sessionSetting('bbs_post_collapse','sort','','');">
							정렬
						</a>
			    </div>
			    <div id="collapse-sort" class="collapse<?php if($_SESSION['bbs_post_collapse']=='sort'):?> show<?php endif?>" role="tabpanel" data-parent="#accordion">
			      <div class="card-body">

							<div class="btn-toolbar">
								<div class="btn-group btn-group-sm btn-group-toggle mb-2" data-toggle="buttons">
									<label class="btn btn-light<?php if($sort=='gid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="gid" name="sort"<?php if($sort=='gid'):?> checked<?php endif?>> 등록일
									</label>
									 <label class="btn btn-light<?php if($sort=='hit'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="hit" name="sort"<?php if($sort=='hit'):?> checked<?php endif?>> 조회
									</label>
									<label class="btn btn-light<?php if($sort=='down'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="down" name="sort"<?php if($sort=='down'):?> checked<?php endif?>> 다운
									</label>
									<label class="btn btn-light<?php if($sort=='comment'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="comment" name="sort"<?php if($sort=='comment'):?> checked<?php endif?>> 댓글
									</label>
									<label class="btn btn-light<?php if($sort=='oneline'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="oneline" name="sort"<?php if($sort=='oneline'):?> checked<?php endif?>> 한줄의견
									</label>
								</div>
								<div class="btn-group btn-group-sm btn-group-toggle mb-2" data-toggle="buttons">
									<label class="btn btn-light<?php if($sort=='likes'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="likes" name="sort"<?php if($sort=='likes'):?> checked<?php endif?>> 좋아요
									</label>
									<label class="btn btn-light<?php if($sort=='dislikes'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="dislikes" name="sort"<?php if($sort=='dislikes'):?> checked<?php endif?>> 비좋아요
									</label>
									<label class="btn btn-light<?php if($sort=='report'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="report" name="sort"<?php if($sort=='report'):?> checked<?php endif?>> 신고
									</label>
								</div>

								<div class="btn-group btn-group-sm btn-group-toggle mb-2" data-toggle="buttons">
									<label class="btn btn-light<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i>역순
									</label>
									<label class="btn btn-light<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
										<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i>정순
									</label>
								</div>
							</div>


			      </div>
			    </div>
			  </div>
			  <div class="card">
					<div class="card-header p-0" role="tab">
						<a class="d-block muted-link<?php if($_SESSION['bbs_post_collapse']!='search'):?> collapsed<?php endif?>" data-toggle="collapse" href="#collapse-search" role="button" aria-expanded="false" aria-controls="collapseTwo" onclick="sessionSetting('bbs_post_collapse','search','','');">
							검색
						</a>
			    </div>
			    <div id="collapse-search" class="collapse<?php if($_SESSION['bbs_post_collapse']=='search'):?> show<?php endif?>" role="tabpanel" data-parent="#accordion">
			      <div class="card-body">

							<select name="where" class="form-control custom-select mb-2">
								 <option value="subject|tag"<?php if($where=='subject|tag'):?> selected="selected"<?php endif?>>제목+태그</option>
								<option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>본문</option>
								<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>이름</option>
								<option value="nic"<?php if($where=='nic'):?> selected="selected"<?php endif?>>닉네임</option>
								<option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
								<option value="ip"<?php if($where=='ip'):?> selected="selected"<?php endif?>>아이피</option>
							</select>
							<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control mb-2">
							<button class="btn btn-light btn-block" type="submit">검색</button>

			      </div>
			    </div>
			  </div>
			</div>

			<div class="p-3">
				<div class="input-group input-group-sm mb-3">
				  <div class="input-group-prepend">
				    <label class="input-group-text">출력수</label>
				  </div>
					<select name="recnum" onchange="this.form.submit();" class="form-control custom-select">
						<option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>>20개</option>
						<option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>>35개</option>
						<option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>>50개</option>
						<option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>>75개</option>
						<option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>>90개</option>
					</select>
				</div>

				<?php if($NUM):?>
				<div style="padding: .74rem">
					<a href="<?php echo $g['adm_href']?>" class="btn btn-block btn-light<?php echo $keyw?' active':'' ?>">검색조건 초기화</a>
				</div>
				<?php endif?>
			</div>

		</form>



	</nav>
	<div class="col-sm-8 col-md-8 mr-sm-auto col-xl-9">

		<?php if($NUM):?>
		<form class="card rounded-0 border-0" name="listForm" action="<?php echo $g['s']?>/" method="post">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="">

			<div class="card-header border-0">
				<?php echo number_format($NUM)?> 개
				<span class="badge badge-pill badge-dark"><?php echo $p?>/<?php echo $TPG?> 페이지</span>
			</div>

			<div class="table-responsive">
				<table class="table table-sm table-striped text-center mb-0">
					<thead class="small text-muted">
						<tr>
							<th><label data-tooltip="tooltip" title="선택"><input type="checkbox" class="checkAll-post-user"></label></th>
							<th>번호</th>
							<th>게시판</th>
							<th>제목</th>
							<th>이름</th>
							<th>조회</th>
							<th>다운</th>
							<th>좋아요</th>
							<th>신고</th>
							<th>날짜</th>
						</tr>
					</thead>
		      <tbody class="text-muted">
					<?php while($R=db_fetch_array($RCD)):?>
					<?php $R['mobile']=isMobileConnect($R['agent'])?>
					<?php $B = getUidData($table[$module.'list'],$R['bbs']); ?>
					<tr>
						<td><input type="checkbox" name="post_members[]" value="<?php echo $R['uid']?>" class="rb-post-user" onclick="checkboxCheck();"/></td>
						<td>
						    <small class="text-muted"><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></small>
						</td>
						<td>
							<small class="text-muted"><?php echo $B['name'] ?></small>
						</td>
						<td class="text-left">
							<?php if($R['notice']):?><i class="fa fa-volume-up"></i><?php endif?>
							<?php if($R['mobile']):?><i class="fa fa-mobile f-lg"></i><?php endif?>
							<?php if($R['category']):?><span class="badge badge-pill badge-dark"><?php echo $R['category']?></span><?php endif?>
							<a class="muted-link" href="<?php echo getBbsPostLink($R)?>" target="_blank">
								<?php echo getStrCut($R['subject'],'30','..')?>
							</a>
							<?php if(strstr($R['content'],'.jpg')):?>
								<span class="badge badge-dark" data-toggle="tooltip" title="사진"><i class="fa fa-camera-retro fa-lg"></i></span>
								<?php endif?>
							<?php if($R['upload']):?>
	            <span class="badge badge-dark" data-toggle="tooltip" title="첨부파일">
	              <i class="fa fa-paperclip fa-lg"></i>
	            </span>
	            <?php endif?>
							<?php if($R['hidden']):?><i class="fa fa-lock fa-lg"></i><?php endif?>
							<?php if($R['comment']):?><span class="badge badge-pill badge-dark"><?php echo $R['comment']?><?php if($R['oneline']):?>+<?php echo $R['oneline']?><?php endif?></span><?php endif?>
							<?php if(getNew($R['d_regis'],24)):?><small class="text-danger">new</small><?php endif?>
						</td>
						<?php if($R['id']):?>
						<td>
							<a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-mbrinfo muted-link" onmousedown="mbrIdDrop('<?php echo $R['mbruid']?>','post');">
								<?php echo $R[$_HS['nametype']]?>
							</a>
						</td>
						<?php else:?>
						<td><?php echo $R[$_HS['nametype']]?></td>
						<?php endif?>
						<td><strong><?php echo $R['hit']?></strong></td>
						<td><?php echo $R['down']?></td>
						<td><?php echo $R['likes']?></td>
						<td><?php echo $R['report']?></td>
						<td>
							<small class="text-muted"><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></small>
						</td>
					</tr>
			     <?php endwhile?>
				 </tbody>
				</table>
			</div><!-- /.table-responsive -->

			<div class="card-footer d-flex justify-content-between">
				<div>
					<button type="button" onclick="chkFlag('post_members[]');checkboxCheck();" class="btn btn-light btn-sm">선택/해제 </button>
					<button type="button" onclick="actCheck('multi_delete');" class="btn btn-light btn-sm rb-action-btn" disabled>삭제</button>
					<button type="button" onclick="actCheck('multi_copy');" class="btn btn-light btn-sm rb-action-btn" disabled >복사</button>
					<button type="button" onclick="actCheck('multi_move');" class="btn btn-light btn-sm rb-action-btn" disabled >이동</button>
				</div>
				<ul class="pagination mb-0">
					<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				</ul>
			</div>


		</form>

		<?php else: ?>
			<div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
			 <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
				 <p>등록된 게시글이 없습니다.</p>
			 </div>
		 </div>
		<?php endif?>


	</div>
</div><!-- /.row -->


<!-- bootstrap-datepicker,  http://eternicode.github.io/bootstrap-datepicker/  -->
<?php getImport('bootstrap-datepicker','css/datepicker3',false,'css')?>
<?php getImport('bootstrap-datepicker','js/bootstrap-datepicker',false,'js')?>
<?php getImport('bootstrap-datepicker','js/locales/bootstrap-datepicker.kr',false,'js')?>

<?php include $g['path_module'].'member/admin/_modal.php';?>

<script>

putCookieAlert('bbs_post_result') // 실행결과 알림 메시지 출력

$('.input-daterange').datepicker({
	format: "yyyy/mm/dd",
	todayBtn: "linked",
	language: "kr",
	calendarWeeks: true,
	todayHighlight: true,
	autoclose: true
});

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

// 선택박스 체크 이벤트 핸들러
$(".checkAll-post-user").click(function(){
	$(".rb-post-user").prop("checked",$(".checkAll-post-user").prop("checked"));
	checkboxCheck();
});
// 선택박스 체크시 액션버튼 활성화 함수
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('post_members[]');
    var n = l.length;
    var i;
	var j=0;
	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true) j++;
	}
	if (j) $('.rb-action-btn').prop("disabled",false);
	else $('.rb-action-btn').prop("disabled",true);
}
// 기간 검색 적용 함수
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
    var l = document.getElementsByName('post_members[]');
    var n = l.length;
	var j = 0;
    var i;
	var s = '';
    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
			s += '['+l[i].value+']';
		}
	}
	if (!j)
	{
		alert('선택된 게시물이 없습니다.      ');
		return false;
	}

	if (act == 'multi_delete')
	{
		if(confirm('정말로 삭제하시겠습니까?    '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}
	else {
		OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=<?php echo $m?>&module=<?php echo $module?>&front=movecopy&type='+act+'&postuid='+s);
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
