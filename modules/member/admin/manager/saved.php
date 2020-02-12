<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 5;

$sqlque = 'mbruid='.$_M['uid'];
if ($category) $sqlque .= " and category='".$category."'";
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($where && $keyw)
{
	$sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');
}
$RCD = getDbArray($table['s_saved'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_saved'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div class="manager-list pt-3 px-3">

	<form name="searchForm" action="<?php echo $g['s']?>/" method="get">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="module" value="<?php echo $module?>">
		<input type="hidden" name="front" value="<?php echo $front?>">
		<input type="hidden" name="tab" value="<?php echo $tab?>">
		<input type="hidden" name="uid" value="<?php echo $_M['uid']?>">
		<input type="hidden" name="p" value="<?php echo $p?>">
		<input type="hidden" name="iframe" value="<?php echo $iframe?>">

		<div class="d-flex justify-content-between align-items-center">
			<div>
				<small><?php echo sprintf('총 %d건',$NUM)?></small>
				<span class="badge badge-pill badge-dark"><?php echo $p?>/<?php echo $TPG?> 페이지</span>
				<button type="button" class="btn btn-link btn-sm muted-link" data-toggle="collapse" data-target="#search-more-bbs" onclick="sessionSetting('sh_bbslist','1','','1');">
					고급 검색
				</button>
			</div>
			<div class="form-inline">
				<select name="category" class="form-control form-control-sm custom-select mr-2" onchange="this.form.submit();">
					<option value="">분류</option>
					<?php $_CATS = getDbSelect($table['s_saved'],"mbruid=".$M['memberuid']." and category<>'' group by category",'category')?>
					<?php while($_R=db_fetch_array($_CATS)):?>
					<option value="<?php echo $_R['category']?>"<?php if($_R['category']==$category):?> selected="selected"<?php endif?>>ㆍ<?php echo $_R['category']?></option>
					<?php endwhile?>
				</select>
			</div><!-- /.form-inline -->
		</div><!-- /.d-flex -->

		<div id="search-more-bbs" class="mt-2 collapse<?php if($_SESSION['sh_bbslist']):?> show<?php endif?>">
			<div class="form-inline">
				<div class="input-daterange input-group input-group-sm" id="datepicker">
					<input type="text" class="form-control form-control-sm" name="d_start" placeholder="시작일" value="<?php echo $d_start?>">
					<span class="p-2">~</span>
					<input type="text" class="form-control form-control-sm" name="d_finish" placeholder="종료일" value="<?php echo $d_finish?>">
				</div>
				<button class="btn btn-light ml-2" type="submit"><i class="fa fa-search"></i></button>
			</div><!-- /.form-inline -->
		</div>
	</div><!-- /.collapse -->
 </form>
</div>

<form name="adm_list_form" class="mt-3" action="<?php echo $g['s']?>/" method="get">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $m?>">
	<input type="hidden" name="module" value="comment">
	<input type="hidden" name="front" value="<?php echo $front?>">
	<input type="hidden" name="tab" value="<?php echo $tab?>">
	<input type="hidden" name="p" value="<?php echo $p?>">
	<input type="hidden" name="iframe" value="<?php echo $iframe?>">
	<input type="hidden" name="a" value="">
		 <div class="table-responsive">
		<table class="table table-hover f13 text-center">
			<colgroup>
				<col width="50">
				<col width="50">
				<col width="100">
				<col>
				<col width="130">
			</colgroup>

			<thead class="small text-muted">
				<tr>
					<th><input type="checkbox"  class="checkAll-act-list" data-toggle="tooltip" title="전체선택"></th>
					<th>번호</th>
					<th>분류</th>
					<th>제목</th>
					<th>날짜</th>
				</tr>
			</thead>
			<tbody>
				<?php while($R=db_fetch_array($RCD)):?>
					<?php $R['mobile']=isMobileConnect($R['agent'])?>
				<tr>
					<td><input type="checkbox" name="members[]"  onclick="checkboxCheck();" class="mbr-act-list" value="<?php echo $R['uid']?>"></td>
					<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
					<td>
						<span class="badge badge-pill badge-dark"><?php echo $R['category']?></span>
					</td>
					<td class="text-left">
						<a href="<?php echo $R['url']?>" target="_blank"><?php echo $R['subject']?></a>
						<?php if(getNew($R['d_regis'],24)):?><small class="text-danger">New</small><?php endif?>
					</td>
							<td class="rb-update">
						<time class="timeago small text-muted" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?>"></time>
					</td>
				</tr>
				<?php endwhile?>
			</tbody>
		</table>
			<?php if(!$NUM):?>
			<div class="text-muted text-center py-4">
				<i class="fa fa-exclamation-circle fa-2x mb-1 d-block" aria-hidden="true"></i>
				<small>데이타가 없습니다.</small>
			</div>
			 <?php endif?>
 </div>

	 <ul class="pagination pagination-sm justify-content-center py-3">
		 <script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
	 </ul>

</form>
