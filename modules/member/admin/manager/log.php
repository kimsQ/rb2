<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 10;

$sqlque = 'mbruid='.$_M['uid'];
if ($siteuid) $sqlque .= ' and site='.$siteuid;
if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($where && $keyw)
{
	$sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');
}
$RCD = getDbArray($table['s_referer'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_referer'],$sqlque);
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
					고급검색
				</button>
			</div>
			<div class="form-inline">
				<select name="siteuid" class="form-control form-control-sm custom-select" onchange="this.form.submit();">
					<option value="">전체 사이트</option>
					<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
					<?php while($S = db_fetch_array($SITES)):?>
					<option value="<?php echo $S['uid']?>"<?php if($S['uid']==$siteuid):?> selected<?php endif?>><?php echo $S['name']?> (<?php echo $S['id']?>)</option>
					<?php endwhile?>
				</select>

				<select name="bid" class="form-control form-control-sm custom-select ml-2" onchange="this.form.submit();">
					<option value="">전체 게시판</option>
					<?php $_BBSLIST = getDbArray($table['bbslist'],'','*','gid','asc',0,1)?>
					<?php while($_B=db_fetch_array($_BBSLIST)):?>
					<option value="<?php echo $_B['uid']?>"<?php if($_B['uid']==$bid):?> selected="selected"<?php endif?>>ㆍ<?php echo $_B['name']?>(<?php echo $_B['id']?>)</option>
					<?php endwhile?>
					<?php if(!db_num_rows($_BBSLIST)):?>
					<option value="">등록된 게시판이 없습니다.</option>
					<?php endif?>
				</select>

			</div><!-- /.form-inline -->
		</div><!-- /.d-flex -->

		<div id="search-more-bbs" class="mt-3 collapse<?php if($_SESSION['sh_bbslist']):?> show<?php endif?>">
			<div class="d-flex justify-content-between align-items-center">
				<div class="form-inline input-daterange" id="datepicker">
					<input type="text" class="form-control form-control-sm" name="d_start" placeholder="시작일" value="<?php echo $d_start?>">
					<span class="px-1">~</span>
					<input type="text" class="form-control form-control-sm" name="d_finish" placeholder="종료일" value="<?php echo $d_finish?>">
					<button class="btn btn-light btn-sm ml-1" type="submit"><i class="fa fa-search"></i></button>
				</div><!-- /.form-inline -->
				<div class="form-inline">
					<select name="where" class="form-control form-control-sm custom-select">
						<option<?php if($where=='ip'):?> selected<?php endif?> value="ip">아이피</option>
						<option<?php if($where=='referer'):?> selected<?php endif?> value="referer">접속경로</option>
					</select>
					<input type="text" name="keyw" class="form-control form-control-sm ml-1" placeholder="검색어를 입력해주세요." value="<?php echo $keyw?>">
					<button class="btn btn-light ml-1" type="submit"><i class="fa fa-search"></i>검색</button>
					<button class="btn btn-light ml-1" type="button" onclick="this.form.keyw.value='';this.form.submit();">리셋</button>
				</div><!-- /.form-inline -->
			</div><!-- /.d-flex -->
		</div><!-- /.collapse -->
 </form>
</div>

<table class="table table-sm table-hover border-bottom mt-3 text-center f12">
	<thead class="small text-muted">
		<tr>
			<th>번호</th>
			<th>아이피</th>
			<th class="rb-url">접속경로</th>
			<th>브라우저</th>
			<th>기기</th>
			<th>날짜</th>
		</tr>
	</thead>
	<tbody>
		<?php while($R=db_fetch_array($RCD)):?>
		<?php $_browzer=getBrowzer($R['agent'])?>
		<?php $_deviceKind=isMobileConnect($R['agent'])?>
		<?php $_deviceType=getDeviceKind($R['agent'],$_deviceKind)?>
		<tr>
			<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
			<td><?php echo $R['ip']?></td>
			<td class="rb-url"><a href="<?php echo $R['referer']?>" target="_blank"><?php echo getDomain($R['referer'])?></a></td>
			<td><?php echo strtoupper($_browzer)?></td>
			<td>
				<?php if($_browzer=='Mobile'):?>
				<small class="badge badge-<?php echo $_deviceType=='tablet'?'danger':'warning'?>" data-tooltip="tooltip" title="<?php echo $_deviceKind?>"><?php echo $_deviceType?></small>
				<?php else:?>
				<small class="badge badge-dark">DESKTOP</small>
				<?php endif?>
			</td>
			<td class="rb-update">
				<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?>"></time>
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

<ul class="pagination pagination-sm justify-content-center py-3">
	<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
</ul>
