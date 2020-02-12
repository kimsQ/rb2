<?php
include $g['path_module'].$module.'/var/var.php';
$bbs_time=$d['bbs']['time']; // 아래 $d 배열과 충돌을 피하기 위해서 별도로 지정
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 301 ? $recnum : 30;
$bbsque	= 'uid';
$account = $SD['uid'];
if ($account) $bbsque .= ' and site='.$account;

if ($where && $keyw)
{
	if (strstr('[id]',$where)) $bbsque .= " and ".$where."='".$keyw."'";
	else $bbsque .= getSearchSql($where,$keyw,$ikeyword,'or');
}

$RCD = getDbArray($table[$module.'list'],$bbsque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table[$module.'list'],$bbsque);
$TPG = getTotalPage($NUM,$recnum);

$_LEVELNAME = array('l0'=>'전체허용');
$_LEVELDATA=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1);
while($_L=db_fetch_array($_LEVELDATA)) $_LEVELNAME['l'.$_L['uid']] = $_L['name'].' 이상';

$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);
$SITEN   = db_num_rows($SITES);
?>

<div class="row">

	<div class="col-sm-4 col-md-4 col-xl-3 d-none sidebar">

		<div id="accordion" role="tablist" style="height: calc(100vh - 10rem);">
			<form name="procForm" action="<?php echo $g['s']?>/" method="get">
				 <input type="hidden" name="r" value="<?php echo $r?>">
				 <input type="hidden" name="m" value="<?php echo $m?>">
				 <input type="hidden" name="module" value="<?php echo $module?>">
				 <input type="hidden" name="front" value="<?php echo $front?>">

					<div class="card">
						<div class="card-header p-0">
							<a class="d-block muted-link collapsed" href="#collapse-sort" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapse-sort">
								정렬
							</a>
						</div>
						<div id="collapse-sort" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
						 <div class="card-body">
							 <div class="btn-group btn-group-toggle btn-group-sm mb-2" data-toggle="buttons">
								<label class="btn btn-light<?php if($sort=='gid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="gid" name="sort"<?php if($sort=='gid'):?> checked<?php endif?>> 지정순서
								</label>
								<label class="btn btn-light<?php if($sort=='uid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="uid" name="sort"<?php if($sort=='uid'):?> checked<?php endif?>> 개설일
								</label>
								<label class="btn btn-light<?php if($sort=='num_r'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="num_r" name="sort"<?php if($sort=='num_r'):?> checked<?php endif?>> 게시물수
								</label>
								<label class="btn btn-light<?php if($sort=='d_last'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="d_last" name="sort"<?php if($sort=='d_last'):?> checked<?php endif?>> 최근게시
								</label>
							 </div>

							 <div class="btn-group btn-group-toggle btn-group-sm mb-3" data-toggle="buttons">
								<label class="btn btn-light<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i> 정순
								</label>
								<label class="btn btn-light<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i> 역순
								</label>
							 </div>

							 <div class="input-group">
								 <div class="input-group-prepend">
									 <span class="input-group-text">출력수</span>
								 </div>
								 <select name="recnum" onchange="this.form.submit();" class="form-control custom-select">
									 <option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>>20 개</option>
									 <option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>>35 개</option>
									 <option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>>50 개</option>
									 <option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>>75 개</option>
									 <option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>>90 개</option>
								 </select>
							 </div>

						 </div>
					 </div>
					</div> <!-- .card -->

					<div class="card">
						<div class="card-header p-0">
							<a class="collapsed d-block muted-link" href="#collapse-search" data-toggle="collapse" href="#collapse-search" role="button" aria-expanded="false" aria-controls="collapse-search">
								게시판 검색
							</a>
						</div>
						<div class="collapse<?php if($_SESSION['sh_mediaset']):?> show<?php endif?>" id="collapse-search">
							<div class="card-body">


								<div class="input-group mb-3">
									<select name="where" class="form-control custom-select" style="width: 30px">
										<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>게시판명</option>
										<option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
									</select>

									<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control">

								</div>
								<button class="btn btn-outline-secondary" type="submit">검색</button>
							</div>
						</div>
					</div>

				 <!-- 고급검색 시작 -->
				 <div id="search-more" class="collapse<?php if($_SESSION['sh_mediaset']):?> in<?php endif?>">

						 <div class="form-group">
						 <label class="col-sm-1 control-label">검색</label>
						 <div class="col-sm-10">
							 <div class="input-group input-group-sm">
								<span class="input-group-btn hidden-xs" style="width:165px">
									<select name="where" class="form-control btn btn-light">
										<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>게시판명</option>
													 <option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
									</select>
								</span>
								<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">검색</button>
								</span>
								<span class="input-group-btn">
									<button class="btn btn-light" type="button" onclick="location.href='<?php echo $g['adm_href']?>';">리셋</button>
								</span>
							 </div>
						</div>
						</div> <!-- .form-group -->
				 </div>
				 <!-- 고급검색 끝 -->

				 <div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button type="button" class="btn btn-link rb-advance<?php if(!$_SESSION['sh_mediaset']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#search-more" onclick="sessionSetting('sh_mediaset','1','','1');">고급검색 <small></small></button>

						</div>
				</div>
			</form>
		</div>  <!-- .rb-heading well well-sm : 검색영역 회색 박스  -->

		<?php if($NUM):?>
		<div class="p-2">
			<a href="<?php echo $g['adm_href']?>" class="btn btn-light btn-block">검색조건 초기화</a>
			<a href="<?php echo $g['adm_href']?>&amp;front=main_detail"  class="btn btn-outline-primary btn-block">
				<i class="fa fa-plus"></i> 새 게시판 만들기
			</a>
		</div>
		<?php endif?>

	</div><!-- /.sidebar -->
	<div class="col-sm-12 col-md-12 col-xl-12">

		<div class="card p-2 mb-0 bg-dark d-flex justify-content-between pr-4">

			<form class="form-inline" name="procForm" action="<?php echo $g['s']?>/" method="get">
			 <input type="hidden" name="r" value="<?php echo $r?>">
			 <input type="hidden" name="m" value="<?php echo $m?>">
			 <input type="hidden" name="module" value="<?php echo $module?>">
			 <input type="hidden" name="front" value="<?php echo $front?>">

				<select class="form-control custom-select" name="sort" onchange="this.form.submit();">
					<option value="gid" selected="selected">지정순서</option>
					<option value="uid">개설일</option>
					<option value="num_r">게시물수</option>
					<option value="d_last">최근게시</option>
				</select>

				<select class="form-control custom-select" name="orderby" onchange="this.form.submit();">
					<option value="desc">역순</option>
					<option value="asc" selected="selected">정순</option>
				</select>

				<select class="form-control custom-select mr-sm-2" name="recnum" onchange="this.form.submit();">
					<option value="30" selected="selected">30개</option>
					<option value="60">60개</option>
					<option value="90">90개</option>
					<option value="120">120개</option>
					<option value="150">150개</option>
					<option value="180">180개</option>
					<option value="210">210개</option>
					<option value="240">240개</option>
					<option value="270">270개</option>
					<option value="300">300개</option>
				</select>

				<select class="form-control custom-select mr-sm-1" name="where">
					<option value="name">게시판명</option>
					<option value="id">아이디</option>
				</select>

				<label class="sr-only" for="inlineFormInputName2">검색</label>
				<input type="text" class="form-control mr-sm-2" placeholder="" name="keyw" value="<?php echo stripslashes($keyw)?>" >

				<button type="submit" class="btn btn-light">검색</button>
				<button type="button" class="btn btn-light" onclick="location.href='<?php echo $g['adm_href']?>';">리셋</button>

				<?php if ($NUM): ?>
				<a href="<?php echo $g['adm_href']?>&amp;front=main_detail"  class="btn btn-outline-primary ml-auto">
					<i class="fa fa-plus"></i> 새 게시판 만들기
				</a>
				<?php endif; ?>

			</form>



		</div>


		<?php if($NUM):?>


		<!-- 리스트 시작  -->
		<form class="card rounded-0 border-0" name="listForm" action="<?php echo $g['s']?>/" method="post">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="">

			<div class="table-responsive">
				<table class="table table-striped text-center mb-0">
					<thead class="small text-muted">
						<tr>
							<th class="py-0"><label data-tooltip="tooltip" title="선택"><input type="checkbox" class="checkAll-email-user"></label></th>
							<th>번호</th>
							<th>아이디</th>
							<th>게시판명</th>
							<th>게시물</th>
							<th>최근게시</th>
							<th>분류</th>
							<th>연결</th>
							<th>레이아웃</th>
							<th>접근권한</th>
							<th>포인트</th>
							<th>관리</th>
						</tr>
					</thead>

					<?php while($R=db_fetch_array($RCD)):?>
					<?php $L=getOverTime($date['totime'],$R['d_last'])?>
					<?php $d=array();include $g['path_var'].$module.'/var.'.$R['id'].'.php';?>
					<?php
						 $sbj_tooltip.='최신글제외 : '.($d['bbs']['display']?'Yes':'No').'<br />';
						 $sbj_tooltip.='쿼리생략 : '.($d['bbs']['hidelist']?'Yes':'No').'<br />';
						 $sbj_tooltip.='RSS발행 : '.($d['bbs']['rss']?'Yes':'No').'<br />';
						 $sbj_tooltip.='조회수증가 : '.($d['bbs']['hitcount']?'계속증가':'1회만증가(세션적용)').'<br />';
						 $sbj_tooltip.='게시물출력수 : '.$d['bbs']['recnum'].'개<br />';
						 $sbj_tooltip.='제목끊기 : '.$d['bbs']['sbjcut'].'자<br />';
						 $sbj_tooltip.='새글유지 : '.$d['bbs']['newtime'].'시간<br />';
						 $sbj_tooltip.='추가관리자 : '.($d['bbs']['admin']?$d['bbs']['admin']:'없음').'<br />';

						 $lay_tooltip .='레이아웃 : '.($d['bbs']['layout']?'':'사이트 대표레이아웃').'<br />';
						 $lay_tooltip .='게시판테마(desktop) : '.($d['bbs']['skin']?getFolderName($g['path_module'].$module.'/theme/'.$d['bbs']['skin']).'('.basename($d['bbs']['skin']).')':'대표테마').'<br />';
						 $lay_tooltip .='게시판테마(mobile) : '.($d['bbs']['m_skin']?getFolderName($g['path_module'].$module.'/theme/'.$d['bbs']['m_skin']).'('.basename($d['bbs']['m_skin']).')':'대표테마').'<br />';
						 $lay_tooltip .='댓글테마(desktop) : '.($d['bbs']['cskin']?getFolderName( $g['path_module'].'comment/theme/'.$d['bbs']['cskin']).'('.basename($d['bbs']['cskin']).')':'대표테마').'<br />';
						 $lay_tooltip .='댓글테마(mobile) : '.($d['bbs']['c_mskin']?getFolderName($g['path_module'].'comment/theme/'.$d['bbs']['c_mskin']).'('.basename($d['bbs']['c_mskin']).')':'대표테마').'<br />';

						 $perm_tooltip .='목록 : '.$_LEVELNAME['l'.$d['bbs']['perm_l_list']].'<br />';
						 $perm_tooltip .='열람 : '.$_LEVELNAME['l'.$d['bbs']['perm_l_view']].'<br />';
						 $perm_tooltip .='쓰기 : '.$_LEVELNAME['l'.$d['bbs']['perm_l_write']].'<br />';
						 $perm_tooltip .='다운 : '.$_LEVELNAME['l'.$d['bbs']['perm_l_down']].'<br />';

						 $point_tooltip .='등록 : '.number_format($d['bbs']['point1']).'P 지급<br />';
						 $point_tooltip .='열람 : '.number_format($d['bbs']['point2']).'P 차감<br />';
						 $point_tooltip .='다운 : '.number_format($d['bbs']['point3']).'P 차감';
					?>

					<tr>
						<td><input type="checkbox" name="bbs_members[]" value="<?php echo $R['uid']?>" class="rb-email-user" onclick="checkboxCheck();"/></td>
						<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
						<td><a href="<?php echo RW('m='.$module.'&bid='.$R['id'])?>" target="_blank"><?php echo $R['id']?></a></td>
						<td><input class="form-control" type="text" name="name_<?php echo $R['uid']?>" value="<?php echo $R['name']?>" data-toggle="popover" data-content="<?php echo $sbj_tooltip?>"></td>
						<td>
							<span class="badge badge-pill badge-dark"><?php echo number_format($R['num_r'])?></span>
							</td>
						<td>
							<time class="small text-muted" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_last'],'c')?>">
								<?php echo getDateFormat($R['d_last'],'Y.m.d')?>
							</time>
							<?php if(getNew($R['d_last'],24)):?> <small class="text-danger">N</small><?php endif?>
						</td>
						<td>
							<span class="badge badge-pill badge-dark"><?php echo $R['category']?'Y':'N'?></span>
						</td>
						<td>
							<span class="badge badge-pill badge-dark"><?php echo $d['bbs']['sosokmenu']?'<span>Y</span>':'N'?></span>
						</td>
						<td><span data-toggle="popover" data-content="<?php echo $lay_tooltip?>" class="badge badge-pill badge-dark"><?php echo $d['bbs']['layout']?'<i>Y</i>':'N'?> / <?php echo $d['bbs']['skin']?'<i>Y</i>':'N'?> / <?php echo $d['bbs']['c_skin']?'<i>Y</i>':'N'?></span></td>
						<td><span data-toggle="popover" data-content="<?php echo $perm_tooltip?>" class="badge badge-pill badge-dark"><?php echo $d['bbs']['perm_l_list']?> / <?php echo $d['bbs']['perm_l_view']?> / <?php echo $d['bbs']['perm_l_write']?></span></td>
						<td><span data-toggle="popover" data-content="<?php echo $point_tooltip?>" class="badge badge-pill badge-dark"><?php echo number_format($d['bbs']['point1'])?> / <?php echo number_format($d['bbs']['point2'])?> / <?php echo number_format($d['bbs']['point3'])?></span></td>
						<td>
							<a class="btn btn-light" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletebbs&amp;uid=<?php echo $R['uid']?>" onclick="return hrefCheck(this,true,'삭제하시면 모든 게시물이 지워지며 복구할 수 없습니다.\n정말로 삭제하시겠습니까?');" class="del">삭제</a>
							<a class="btn btn-light" href="<?php echo $g['adm_href']?>&amp;front=main_detail&amp;uid=<?php echo $R['uid']?>&amp;account=<?php echo $account?>">설정</a>
						</td>
					</tr>
					<?php endwhile?>
				</table>
			</div><!-- /.table-responsive -->

			<div class="card-footer d-flex justify-content-between">
				<div>
					<button type="button" onclick="chkFlag('bbs_members[]');checkboxCheck();" class="btn btn-sm btn-light">선택/해제</button>
					<button type="button" onclick="actCheck('multi_config');" class="btn btn-sm btn-light" id="rb-action-btn">수정</button>
				</div>
				<ul class="pagination">
					<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
					<?php //echo getPageLink(5,$p,$TPG,'')?>
				</ul>
			</div><!-- .card-footer -->
	</form><!-- .card -->

	<?php else: ?>

		<div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
			 <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
				 <p>등록된 게시판이 없습니다.</p>
				 <a href="<?php echo $g['adm_href']?>&amp;front=main_detail"  class="btn btn-outline-primary btn-block">
			 	 	<i class="fa fa-plus"></i> 새 게시판 만들기
			 	 </a>
			 </div>
		 </div>

	<?php endif?>

	</div>
</div><!-- /.row -->


<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago','1.6.1','js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko','1.6.1','js')?>

<!-- basic -->
<script>

$(function () {

	//사이트 셀렉터 출력
	$('[data-role="siteSelector"]').removeClass('d-none')

	$('[data-plugin="timeago"]').timeago();

	$('[data-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	})

	putCookieAlert('result_bbs_main') // 실행결과 알림 메시지 출력

})

$(".checkAll-file-user").click(function(){
	$(".rb-file-user").prop("checked",$(".checkAll-file-user").prop("checked"));
	checkboxCheck();
});
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('bbs_members[]');
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
    var l = document.getElementsByName('bbs_members[]');
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
		alert('선택된 게시판이 없습니다.     ');
		return false;
	}
	if (act == 'multi_config')
	{
		if (confirm('정말로 실행하시겠습니까?       '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}

	return false;
}
</script>
