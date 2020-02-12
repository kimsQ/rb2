<?php
//동기화URL
function getCyncUrl($cync)
{
	if (!$cync) return $GLOBALS['g']['r'];
	$_r = getArrayString($cync);
	$_r = $_r['data'][5];
	if ($GLOBALS['_HS']['rewrite']&&strpos('_'.$_r,'m:bbs,bid:'))
	{
		$_r = str_replace('m:bbs','b',$_r);
		$_r = str_replace(',bid:','/',$_r);
		$_r = str_replace(',uid:','/',$_r);
		$_r = str_replace(',CMT:','/',$_r);
		$_r = str_replace(',s:','/s',$_r);
		return $GLOBALS['g']['r'].'/'.$_r;
	}
	else return $GLOBALS['g']['s'].'/?'.($GLOBALS['_HS']['usescode']?'r='.$GLOBALS['_HS']['id'].'&amp;':'').str_replace(':','=',str_replace(',','&amp;',$_r));
}

$SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1);
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;
$_WHERE='uid>0';
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
$RCD = getDbArray($table['s_comment'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_comment'],$_WHERE);
$TPG = getTotalPage($NUM,$recnum);


?>
<div class="page-header">
 <h4>댓글 리스트  </h4>
</div>
<form name="procForm" action="<?php echo $g['s']?>/" method="get" class="form-horizontal rb-form">
	 <input type="hidden" name="r" value="<?php echo $r?>" />
	 <input type="hidden" name="m" value="<?php echo $m?>" />
	 <input type="hidden" name="module" value="<?php echo $module?>" />
	 <input type="hidden" name="front" value="<?php echo $front?>" />

	 <div class="rb-heading well well-sm">
	 	 <div class="form-group">
	 	 	  <label class="col-sm-1 control-label">필터 </label>
	 	 	  <div class="col-sm-10">
	 	 	  	  <div class="row">
	 	 	  	  	   <div class="col-sm-3">
	 	 	  	  	       <select name="account" class="form-control input-sm" onchange="this.form.submit();">
								 <option value="">+ 전체사이트</option>
								 <option value="">--------------------</option>
								 <?php while($S = db_fetch_array($SITES)):?>
								 <option value="<?php echo $S['uid']?>"<?php if($account==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?></option>
								 <?php endwhile?>
								 <?php if(!db_num_rows($SITES)):?>
								 <option value="">등록된 사이트가 없습니다.</option>
								 <?php endif?>
							 </select>
	 	 	  	  	   </div>
	 	 	  	  	 </div> <!-- .row -->
	 	 	  	 </div> <!-- .col-sm-10 -->
	 	 	 </div> <!-- .form-group -->
	 	 	 <!-- 고급검색 시작 -->
	 	 	 <div id="search-more" class="collapse<?php if($_SESSION['sh_bbspost']):?> in<?php endif?>">
            <div class="form-group">
			 	 	  <label class="col-sm-1 control-label">옵션 </label>
			 	 	  <div class="col-sm-10">
			 	 	  	  <div class="row">
			 	 	  	  	  <div class="col-sm-2">
						    	  <label class="checkbox" style="margin-top:0">
							        <input  type="checkbox"  name="notice" value="Y"<?php if($notice=='Y'):?> checked<?php endif?> onclick="this.form.submit();"  class="form-control"> <i></i>공지글
							     </label>
							 </div>
						    <div class="col-sm-2">
						 	    <label class="checkbox" style="margin-top:0">
						          <input  type="checkbox" name="hidden" value="Y"<?php if($hidden=='Y'):?> checked<?php endif?> onclick="this.form.submit();"  class="form-control"><i></i>비밀글
						       </label>
						    </div>
			 	 	  	 </div>
		         </div>
		       </div>
				<div class="form-group">
					<label class="col-sm-1 control-label">기간</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-5">
								<div class="input-daterange input-group input-group-sm" id="datepicker">
									<input type="text" class="form-control" name="d_start" placeholder="시작일 선택" value="<?php echo $d_start?>">
									<span class="input-group-addon">~</span>
									<input type="text" class="form-control" name="d_finish" placeholder="종료일 선택" value="<?php echo $d_finish?>">
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit">기간적용</button>
									</span>
								</div>
							</div>
							<div class="col-sm-3 hidden-xs">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>','<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-1,substr($date['today'],0,4)))?>');">어제</button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo getDateFormat($date['today'],'Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">오늘</button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-7,substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">일주</button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/d',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">한달</button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo getDateFormat(substr($date['today'],0,6).'01','Y/m/d')?>','<?php echo getDateFormat($date['today'],'Y/m/d')?>');">당월</button>
									<button class="btn btn-default" type="button" onclick="dropDate('<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>01','<?php echo date('Y/m/',mktime(0,0,0,substr($date['today'],4,2)-1,substr($date['today'],6,2),substr($date['today'],0,4)))?>31');">전월</button>
									<button class="btn btn-default" type="button" onclick="dropDate('','');">전체</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group hidden-xs">
					<label class="col-sm-1 control-label">정렬</label>
					<div class="col-sm-10">
						<div class="btn-toolbar">
							<div class="btn-group btn-group-sm" data-toggle="buttons">
								<label class="btn btn-default<?php if($sort=='gid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="uid" name="sort"<?php if($sort=='uid'):?> checked<?php endif?>> 등록일
								</label>
								 <label class="btn btn-default<?php if($sort=='hit'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="hit" name="sort"<?php if($sort=='hit'):?> checked<?php endif?>> 조회
								</label>
								<label class="btn btn-default<?php if($sort=='down'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="down" name="sort"<?php if($sort=='down'):?> checked<?php endif?>> 다운
								</label>
								<label class="btn btn-default<?php if($sort=='oneline'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="oneline" name="sort"<?php if($sort=='oneline'):?> checked<?php endif?>> 한줄의견
								</label>
								<label class="btn btn-default<?php if($sort=='score1'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="score1" name="sort"<?php if($sort=='score1'):?> checked<?php endif?>> 점수1
								</label>
								<label class="btn btn-default<?php if($sort=='score2'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="score2" name="sort"<?php if($sort=='score2'):?> checked<?php endif?>> 점수2
								</label>
								<label class="btn btn-default<?php if($sort=='report'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="report" name="sort"<?php if($sort=='report'):?> checked<?php endif?>> 신고
								</label>
							</div>
							<div class="btn-group btn-group-sm" data-toggle="buttons">
								<label class="btn btn-default<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i>역순
								</label>
								<label class="btn btn-default<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
									<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i>정순
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label">검색</label>
					<div class="col-sm-10">
						<div class="input-group input-group-sm">
							<span class="input-group-btn hidden-xs" style="width:165px">
								<select name="where" class="form-control btn btn-default">
								   <option value="subject"<?php if($where=='subject'):?> selected="selected"<?php endif?>>제목</option>
									<option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>본문</option>
									<option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>이름</option>
									<option value="nic"<?php if($where=='nic'):?> selected="selected"<?php endif?>>닉네임</option>
									<option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
									<option value="ip"<?php if($where=='ip'):?> selected="selected"<?php endif?>>아이피</option>
								</select>
							</span>
							<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">검색</button>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-label">출력</label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-2">
								<select name="recnum" onchange="this.form.submit();" class="form-control input-sm">
									<option value="20"<?php if($recnum==20):?> selected="selected"<?php endif?>>20</option>
									<option value="35"<?php if($recnum==35):?> selected="selected"<?php endif?>>35</option>
									<option value="50"<?php if($recnum==50):?> selected="selected"<?php endif?>>50</option>
									<option value="75"<?php if($recnum==75):?> selected="selected"<?php endif?>>75</option>
									<option value="90"<?php if($recnum==90):?> selected="selected"<?php endif?>>90</option>
								</select>
							</div>
							<div class="col-sm-2">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-10">
					<button type="button" class="btn btn-link rb-advance<?php if(!$_SESSION['sh_bbspost']):?> collapsed<?php endif?>" data-toggle="collapse" data-target="#search-more" onclick="sessionSetting('sh_bbspost','1','','1');">고급검색<small></small></button>
					<a href="<?php echo $g['adm_href']?>" class="btn btn-link">초기화</a>
				</div>
			</div>
		</div>
	</form>
<div class="page-header">
	<h4>
		<small><?php echo number_format($NUM)?> 개 ( <?php echo $p?>/<?php echo $TPG.($TPG>1?'pages':'page')?> )</small>
	</h4>
</div>
<form name="listForm" action="<?php echo $g['s']?>/" method="post">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th><label data-tooltip="tooltip" title="선택"><input type="checkbox" class="checkAll-post-user"></label></th>
					<th>번호</th>
					<th>제목</th>
					<th>이름</th>
					<th>조회</th>
					<th>다운</th>
					<th>점수1</th>
					<th>점수2</th>
					<th>신고</th>
					<th>날짜</th>
				</tr>
			</thead>
	     <tbody>
			<?php while($R=db_fetch_array($RCD)):?>
			<?php $R['mobile']=isMobileConnect($R['agent'])?>
			<tr>
				<td><input type="checkbox" name="comment_members[]" value="<?php echo $R['uid']?>" class="rb-post-user" onclick="checkboxCheck();"/></td>
				<td>
				    <?php echo $NUM-((($p-1)*$recnum)+$_rec++)?>
				</td>
				<td>
					<?php if($R['notice']):?><i class="fa fa-volume-up"></i><?php endif?>
					<?php if($R['mobile']):?><i class="fa fa-mobile f-lg"></i><?php endif?>
					<a href="<?php echo getCyncUrl($R['cync'].',CMT:'.$R['uid'].',s:'.$R['site'])?>#CMT" target="_blank"><?php echo $R['subject']?></a>
					<?php if(strstr($R['content'],'.jpg')):?><i class="fa fa-picture-o"></i><?php endif?>
					<?php if($R['upload']):?><i class="glyphicon glyphicon-floppy-disk"></i><?php endif?>
					<?php if($R['hidden']):?><i class="fa fa-lock fa-lg"></i><?php endif?>
					<?php if($R['oneline']):?><span class="comment">[<?php echo $R['oneline']?>]</span><?php endif?>
					<?php if(getNew($R['d_regis'],24)):?><small class="label label-danger">new</small><?php endif?>
				</td>
				<?php if($R['id']):?>
				<td><a href="javascript:OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&m=member&front=manager&page=post&mbruid=<?php echo $R['mbruid']?>');" title="게시정보"><?php echo $R[$_HS['nametype']]?></a></td>
				<?php else:?>
				<td><?php echo $R[$_HS['nametype']]?></td>
				<?php endif?>
				<td><strong><?php echo $R['hit']?></strong></td>
				<td><?php echo $R['down']?></td>
				<td><?php echo $R['score1']?></td>
				<td><?php echo $R['score2']?></td>
				<td><?php echo $R['report']?></td>
				<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
			</tr>
	     <?php endwhile?>
	</tbody>
	</table>
    <?php if(!$NUM):?>
    	<div class="rb-none">게시물이 없습니다.</div>
	<?php endif?>
		<div class="rb-footer clearfix">
			<div class="pull-right">
				<ul class="pagination">
				<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
				<?php //echo getPageLink(5,$p,$TPG,'')?>
				</ul>
			</div>
			<div>
				<button type="button" onclick="chkFlag('comment_members[]');checkboxCheck();" class="btn btn-default btn-sm">선택/해제 </button>
				<button type="button" onclick="actCheck('comment_multi_delete');" class="btn btn-default btn-sm rb-action-btn" disabled>삭제</button>
			</div>
		</div>
	</form>
</div>
<!-- Modal -->
<div class="modal fade" id="MoveCopy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
<!-- bootstrap-datepicker,  http://eternicode.github.io/bootstrap-datepicker/  -->
<?php getImport('bootstrap-datepicker','css/datepicker3',false,'css')?>
<?php getImport('bootstrap-datepicker','js/bootstrap-datepicker',false,'js')?>
<?php getImport('bootstrap-datepicker','js/locales/bootstrap-datepicker.kr',false,'js')?>
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
<script type="text/javascript">
//<![CDATA[
// 선택박스 체크 이벤트 핸들러
$(".checkAll-post-user").click(function(){
	$(".rb-post-user").prop("checked",$(".checkAll-post-user").prop("checked"));
	checkboxCheck();
});
// 선택박스 체크시 액션버튼 활성화 함수
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('comment_members[]');
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
    var l = document.getElementsByName('comment_members[]');
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

	if (act == 'comment_multi_delete')
	{
		if(confirm('정말로 삭제하시겠습니까?    '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}
	return false;
}
//]]>
</script>
