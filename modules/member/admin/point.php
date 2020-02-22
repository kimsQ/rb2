<?php
$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);
$SITEN   = db_num_rows($SITES);

$type	= $type ? $type : 'point';
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

//사이트선택적용
//$accountQue = $account ? 'a.site='.$account.' and ':'';
$_WHERE ='uid>0';
if ($d_start) $_WHERE .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $_WHERE .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($flag == '+') $_WHERE .= ' and price > 0';
if ($flag == '-') $_WHERE .= ' and price < 0';

if ($where && $keyw)
{
	if ($keyw=='my_mbruid') $_WHERE .= ' and my_mbruid='.$keyw;
	else $_WHERE .= getSearchSql($where,$keyw,$ikeyword,'or');
}
$RCD = getDbArray($table['s_'.$type],$_WHERE,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_'.$type],$_WHERE);
$TPG = getTotalPage($NUM,$recnum);
?>

<div class="row no-gutters">

	<div class="col-sm-4 col-md-4 col-xl-3 d-none d-sm-block sidebar sidebar-right">

		<form name="procForm" action="<?php echo $g['s']?>/" method="get" class="card border-0">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="module" value="<?php echo $module?>">
			<input type="hidden" name="front" value="<?php echo $front?>">
			<input type="hidden" name="type" value="<?php echo $type?>">

			<div class="card-body">
				<div class="form-group">
			    <label>기간</label>
					<span class="input-daterange" id="datepicker">
						<div class="input-group input-group-sm mb-1">
							<div class="input-group-prepend">
								<span class="input-group-text">시작일</span>
							</div>
						  <input type="text" class="form-control" name="d_start" placeholder="선택" value="<?php echo $d_start?>">
						</div>
						<div class="input-group input-group-sm mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">종료일</span>
							</div>
						  <input type="text" class="form-control" name="d_finish" placeholder="선택" value="<?php echo $d_finish?>">
						</div>
					</span>

					<button class="btn btn-light btn-block mb-2" type="submit">기간적용</button>
					<div class="btn-group">
						<button class="btn btn-light" onclick="dropDate('2017/12/27','2017/12/27');">어제</button>
						<button class="btn btn-light" onclick="dropDate('2017/12/28','2017/12/28');">오늘</button>
						<button class="btn btn-light" onclick="dropDate('2017/12/21','2017/12/28');">일주</button>
					</div>
					<div class="btn-group">
						<button class="btn btn-light" onclick="dropDate('2017/11/28','2017/12/28');">한달</button>
						<button class="btn btn-light" onclick="dropDate('2017/12/01','2017/12/28');">당월</button>
						<button class="btn btn-light" onclick="dropDate('2017/11/01','2017/11/31');">전월</button>
						<button class="btn btn-light" onclick="dropDate('','');">전체</button>
					</div>
			  </div>

				<hr>

				<div class="form-group mb-3">
			    <label>검색</label>

					<select name="where" class="form-control custom-select mb-2">
						<option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>내용</option>
						<option value="my_mbruid"<?php if($where=='my_mbruid'):?> selected="selected"<?php endif?>>회원코드</option>
					</select>

			    <input type="text" class="form-control mb-2" name="keyw" value="<?php echo stripslashes($keyw)?>" placeholder="검색어 입력">
					<button class="btn btn-light btn-block" type="submit">검색</button>
			  </div>

				<hr>


				<div class="form-group">
			    <label>필터</label>
					<select name="flag" class="form-control custom-select" onchange="this.form.submit();">
						<option value="">&nbsp;+ 구분</option>
						<option value="+"<?php if($flag=='+'):?> selected="selected"<?php endif?>>획득</option>
						<option value="-"<?php if($flag=='-'):?> selected="selected"<?php endif?>>사용</option>
					</select>

					<div class="btn-group btn-group-sm btn-group-toggle w-100 mt-2" data-toggle="buttons">
						<label class="btn btn-light w-50<?php if($sort=='uid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
							<input type="radio" value="uid" name="sort"<?php if($sort=='uid'):?> checked<?php endif?>> 등록일
						</label>
						 <label class="btn btn-light w-50<?php if($sort=='price'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
							<input type="radio" value="price" name="sort"<?php if($sort=='price'):?> checked<?php endif?>>금액
						</label>
					</div>

					<div class="btn-group btn-group-sm btn-group-toggle w-100 mt-2" data-toggle="buttons">
						<label class="btn btn-light w-50<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
							<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i> 내림차순
						</label>
						<label class="btn btn-light w-50<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
							<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i> 오름차순
						</label>
					</div>
			  </div>
			</div><!-- /.card-body -->

			<div class="card-footer">
				<a href="<?php echo $g['adm_href']?>" class="btn btn-light btn-block">검색조건 초기화</a>
			</div>

		</form>




	</div><!-- /.sidebar -->
	<div class="col-sm-8 col-md-8 mr-sm-auto col-xl-9">

		<?php if($NUM):?>
		<form class="card rounded-0 border-0 page-body-header" name="listForm" action="<?php echo $g['s']?>/" method="post">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="">
			<input type="hidden" name="pointType" value="<?php echo $type?>">

			<div class="card-header d-flex justify-content-between align-items-center border-0">
				<span class="pull-left">
					 총 <?php echo number_format($NUM)?>개
					 <span class="badge badge-pill badge-dark"><?php echo $p?>/<?php echo $TPG?> 페이지</span>
				</span>
				<div class="">
					<div class="btn-group">
						 <a href="<?php echo '/?'.$_SERVER['QUERY_STRING']?>&amp;p=<?php echo $p-1?>" class="btn btn-light btn-page" <?php echo $p>1?'':'disabled'?> data-toggle="tooltip" data-placement="bottom" title="" data-original-title="이전">
								<i class="fa fa-chevron-left fa-lg"></i>
						 </a>
						 <a href="<?php echo '/?'.$_SERVER['QUERY_STRING']?>&amp;p=<?php echo $p+1?>" class="btn btn-light btn-page" <?php echo $NUM>($p*$recnum)?'':'disabled'?> data-toggle="tooltip" data-placement="bottom" title="" data-original-title="다음">
								<i class="fa fa-chevron-right fa-lg"></i>
							</a>
					</div>
					<div class="btn-group">
						 <div class="btn-group dropup hidden-xs">
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" >
									<i class="fa fa-list"></i> <?php echo $recnum?>개씩  <span class="caret"></span>
								 </button>
								<div class="dropdown-menu dropdown-menu-right" role="menu">
									<a class="dropdown-item<?php $recnum=='20'?' active':''?>" href="<?php echo $g['adm_href']?>&amp;recnum=20">20개 출력</a>
									<a class="dropdown-item<?php $recnum=='35'?' active':''?>" href="<?php echo $g['adm_href']?>&amp;recnum=35">35개 출력</a>
									<a class="dropdown-item<?php $recnum=='50'?' active':''?>" href="<?php echo $g['adm_href']?>&amp;recnum=50">50개 출력</a>
									<a class="dropdown-item<?php $recnum=='75'?' active':''?>" href="<?php echo $g['adm_href']?>&amp;recnum=75">75개 출력</a>
									<a class="dropdown-item<?php $recnum=='90'?' active':''?>" href="<?php echo $g['adm_href']?>&amp;recnum=90">90개 출력</a>
								</div>
							</div>
					 </div>
				</div>

			</div>
			<!-- //.card-heade -->

		   <!-- 리스트 테이블 시작-->
		 	<table class="table table-hover text-center">
				<colgroup>
					<col width="50">
					<col width="50">
					<col width="50">
					<col width="50">
					<col width="80">
					<col>
					<col width="100">
				</colgroup>
				<thead class="small text-muted">
					<tr>
						<th class="py-0">

						</th>
						<th>번호</th>
						<th>획득/사용자</th>
						<th>획득/사용액</th>
						<th>지급자</th>
						<th>내용</th>
						<th>날짜</th>
				   </tr>
				</thead>
				<tbody>
					<?php while($R=db_fetch_array($RCD)):?>
					<?php $M1=getDbData($table['s_mbrdata'],'memberuid='.$R['my_mbruid'],'*')?>
					<?php if($R['by_mbruid']){$M2=getDbData($table['s_mbrdata'],'memberuid='.$R['by_mbruid'],'*');}else{$M2=array();}?>
					<tr>	<!-- 라인이 체크된 경우 warning 처리됨  -->
						<td>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input checkAll-member" id="mbrmembers_<?php echo $R['uid']?>" name="point_members[]"  onclick="checkboxCheck();"  value="<?php echo $R['uid']?>">
								<label class="custom-control-label" for="mbrmembers_<?php echo $R['uid']?>"></label>
							</div>
						</td>
						<td><?php echo ($NUM-((($p-1)*$recnum)+$_recnum++))?></td>
						<td><a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-mbrinfo" onmousedown="mbrIdDrop('<?php echo $M1['memberuid']?>','point');" data-toggle="tooltip" title="획득/사용내역"><?php echo $M1['name']?></a></td><!-- main -->
					   <td><span class="badge badge-pill badge-dark"><?php echo number_format($R['price'])?></span></td>
						<td>
							<span class="badge badge-pill badge-dark">
							<?php if($M2['memberuid']):?>
							 <a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-mbrinfo" onmousedown="mbrIdDrop('<?php echo $M2['memberuid']?>','point');" data-toggle="tooltip" title="획득/사용내역"><?php echo $M1[$_HS['nametype']]?></a></td><!-- post -->
						   <?php else:?>
						   	시스템
					 		<?php endif?>
							</span>
            </td>
          	 <td class="text-left"><?php echo strip_tags($R['content'])?></td>
					   <td> <small class="text-muted"><?php echo getDateFormat($R['d_regis'],'Y.m.d')?></small></td>
		         </tr>
		         <?php endwhile?>
				</tbody>
			</table>
			<!-- 리스트 테이블 끝 -->


		   <!--목록에 체크된 항목이 없을 경우  fieldset이 disabled 됨-->
			<div class="card-footer btn-toolbar justify-content-between">
				<fieldset id="list-bottom-fset" disabled> <!--목록에 체크된 항목이 없을 경우  fieldset이 disabled 됨-->
					<button type="button" class="btn btn-light" onclick="actQue('point_multi_delete');">삭제</button>
				</fieldset>

				<ul class="pagination pagination justify-content-center">
					<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				</ul>

			</div> <!-- // .card-footer-->
		</form><!-- // .card-->




		<?php else:?>
			<div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
				 <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
					 <p>조건에 해당하는 자료가 없습니다.</p>
					 <a href="<?php echo $g['adm_href']?>" class="btn btn-light btn-block mt-2">
				 	 	검색조건 초기화
				 	 </a>
				 </div>
			 </div>
		<?php endif?>

	</div>
</div><!-- /.row -->



<!-- bootstrap-datepicker,  http://eternicode.github.io/bootstrap-datepicker/  -->
<?php getImport('bootstrap-datepicker','css/datepicker3',false,'css')?>
<?php getImport('bootstrap-datepicker','js/bootstrap-datepicker',false,'js')?>
<?php getImport('bootstrap-datepicker','js/locales/bootstrap-datepicker.kr',false,'js')?>
<!-- basic -->
<script>

putCookieAlert('result_member_point') // 실행결과 알림 메시지 출력

$('.input-daterange').datepicker({
	format: "yyyy/mm/dd",
	todayBtn: "linked",
	language: "kr",
	calendarWeeks: true,
	todayHighlight: true,
	autoclose: true
});

// 툴팁 이벤트
$('[data-toggle=tooltip]').tooltip();

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

// 선택박스 체크 이벤트 핸들러
$("#checkAll-member").click(function(){
	$(".rb-member").prop("checked",$(".checkAll-member").prop("checked",true));
	checkboxCheck();
});

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


// 선택박스 체크시 액션버튼 활성화 함수
function checkboxCheck()
{
	var f = document.listForm;
  var l = document.getElementsByName('point_members[]');
  var n = l.length;
  var i;
	var j=0;

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true){
          $(l[i]).parent().parent().parent().addClass('table-active'); // 선택된 체크박스 tr 강조표시
			j++;
		}else{
			$(l[i]).parent().parent().parent().removeClass('table-active');
		}
	}
	// 하단 회원관리 액션 버튼 상태 변경
	if (j) $('#list-bottom-fset').prop("disabled",false);
	else $('#list-bottom-fset').prop("disabled",true);
}

function actQue(flag)
{
	var f = document.listForm;
  var l = document.getElementsByName('point_members[]');
  var n = l.length;
  var i;
	var j=0;

	if (flag == 'point_multi_delete')
	{
		for	(i = 0; i < n; i++)
		{
			if (l[i].checked == true)
			{
				j++;
			}
		}
		if (!j)
		{
			alert('항목을 선택해주세요.     ');
			return false;
		}

		if (confirm('정말로 실행하시겠습니까?     '))
		{
			getIframeForAction(f);
			f.a.value = flag;
			f.submit();
		}
	}
	return false;
}

// 기간 검색 적용 함수
function dropDate(date1,date2)
{
	var f = document.procForm;
	f.d_start.value = date1;
	f.d_finish.value = date2;
	f.submit();
}

</script>
