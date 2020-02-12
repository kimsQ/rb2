<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

if ($inbox == 3)
{
	$sqlque = 'by_mbruid='.$_M['uid'];
}
else
{
	$sqlque = 'my_mbruid='.$_M['memberuid'];
	if ($inbox) $sqlque .= " and inbox='".$inbox."'";
	if ($where && $keyw)
	{
		$sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');
	}
}
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';

$RCD = getDbArray($table['s_paper'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_paper'],$sqlque);
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
			<div>
				<select name="inbox" class="form-control form-control-sm custom-select" onchange="this.form.submit();">
					<option value="">구분</option>
					<option value="1"<?php if($inbox==1):?> selected="selected"<?php endif?>>받은쪽지함</option>
					<option value="2"<?php if($inbox==2):?> selected="selected"<?php endif?>>쪽지보관함</option>
					<option value="3"<?php if($inbox==3):?> selected="selected"<?php endif?>>보낸쪽지함</option>
				</select>
			</div>
		</div><!-- /.d-flex -->

		<div id="search-more-bbs" class="mt-2 collapse<?php if($_SESSION['sh_bbslist']):?> show<?php endif?>">
			<div class="form-inline">
				<div class="input-daterange input-group input-group-sm" id="datepicker">
					<input type="text" class="form-control form-control-sm" name="d_start" placeholder="시작일" value="<?php echo $d_start?>">
					<span class="p-2">~</span>
					<input type="text" class="form-control form-control-sm" name="d_finish" placeholder="종료일" value="<?php echo $d_finish?>">
				</div>
				<button class="btn btn-light ml-1" type="submit"><i class="fa fa-search"></i></button>
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
				<col width="80">
				<col width="50">
				<col>
				<col width="130">
			</colgroup>
			<thead class="small text-muted">
				<tr>
					<th><input type="checkbox"  class="checkAll-act-list" data-toggle="tooltip" title="전체선택"></th>
					<th>번호</th>
					<th><?php echo $inbox==3?'받는이':'보낸이'?></th>
					<th></th>
					<th>내용</th>
					<th>날짜</th>
				</tr>
			</thead>
			<tbody>
				<?php while($R=db_fetch_array($RCD)):?>
					<?php $R['content']=str_replace('&nbsp;',' ',$R['content'])?>
						<?php $M=getDbData($table['s_mbrdata'],'memberuid='.$R[($index==3?'m':'b').'y_mbruid'],'*')?>
				<tr>
					<td><input type="checkbox" name="members[]"  onclick="checkboxCheck();" class="mbr-act-list" value="<?php echo $R['uid']?>"></td>
					<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
					<td><span class="badge badge-pill badge-dark"><?php echo $M[$_HS['nametype']]?$M[$_HS['nametype']]:'시스템'?></span></td>
					<td><span class="badge badge-pill badge-dark"><?php echo $R['d_read']?getDateFormat($R['d_read'],'Y.m.d H:i 열람'):'읽지않음'?></span></td>
					<td class="text-left">
						<?php echo getStrCut(strip_tags($R['content']),50,'..')?>
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
