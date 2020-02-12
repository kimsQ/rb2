<?php
$vtype	= $vtype ? $vtype : 'point';
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 10;

$sqlque = 'my_mbruid='.$my['uid'];
if ($type == '1') $sqlque .= ' and price > 0';
if ($type == '2') $sqlque .= ' and price < 0';
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_'.$vtype],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_'.$vtype],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$g['page_reset']	= RW('mod=dashboard&page='.$page);
$g['page_list']	= $g['page_reset'].getLinkFilter('',array($type?'type':''));
$g['pagelink']	= $g['page_list'];

?>

<div class="container">

	<div class="d-flex justify-content-between align-items-center subhead mt-0">
		<h3 class="mb-0">
			포인트 내역 <span class="badge badge-pill badge-dark align-top"><?php echo number_format($my['point'])?> P</span>
		</h3>
		<div class="">
				<button type="button" class="btn btn-white" onclick="actCheck('point_sum');">내역정리</button>
		</div>
	</div>

	<div class="d-flex align-items-center border-top border-dark pt-4 pb-3" role="filter">
		<span class="f18">전체 <span class="text-primary"><?php echo number_format($NUM)?></span> 건</span>
		<div class="form-inline ml-auto">

			<label class="sr-only">상태</label>
			<form name="hideForm" action="<?php echo $g['page_reset']?>" method="get">
				<input type="hidden" name="page" value="<?php echo $page?>">

				<select name="type" class="form-control custom-select" onchange="this.form.submit();">
					<option value="">구분 : 전체</option>
					<option value="1"<?php if($type=='1'):?> selected="selected"<?php endif?>>획득</option>
					<option value="2"<?php if($type=='2'):?> selected="selected"<?php endif?>>사용</option>
				</select>
			</form>


		</div><!-- /.form-inline -->
	</div><!-- /.d-flex -->

	<form name="procForm" action="<?php echo $g['s']?>/" method="post"  onsubmit="return submitCheck(this);">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="a" value="">
		<input type="hidden" name="pointType" value="<?php echo $vtype?>">

		<table class="table table-hover mb-0 text-center">
			<colgroup>
				<col width="50">
				<col width="80">
				<col>
				<col width="150">
			</colgroup>
			<thead>
			<tr>
				<th scope="col" class="side1">
					<i class="fa fa-check-square-o fa-lg" aria-hidden="true"  onclick="chkFlag('members[]');" role="button" data-toggle="tooltip" title="전체선택"></i>
				</th>
				<th scope="col">금액</th>
				<th scope="col">내역</th>
				<th scope="col" class="side2">날짜</th>
			</tr>
			</thead>
			<tbody>

			<?php while($R=db_fetch_array($RCD)):?>
			<tr>
				<td><input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" /></td>
				<td><?php echo ($R['price']>0?'+':'').number_format($R['price'])?></td>
				<td class="text-left">
					<?php echo $R['content']?>
					<?php if(getNew($R['d_regis'],24)):?><small class="text-danger">new</small><?php endif?>
				</td>
				<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
			</tr>
			<?php endwhile?>

			<?php if(!$NUM):?>
			<tr>
				<td><input type="checkbox" disabled="disabled" /></td>
				<td class="cat">-</td>
				<td class="sbj1">내역이 없습니다.</td>
				<td></td>
			</tr>
			<?php endif?>

			</tbody>
		</table>

		<nav aria-label="Page navigation" class="d-flex justify-content-between my-4">
			<div>
				<button type="button" class="btn btn-white" onclick="actCheck('point_delete');">삭제</button>
			</div>

			<?php if ($NUM > $recnum): ?>
			<ul class="pagination">
				<?php echo getPageLink(10,$p,$TPG,'')?>
			</ul>
			<?php endif; ?>
		</nav>

	</form>

</div>

<script type="text/javascript">
//<![CDATA[
function submitCheck(f)
{
	if (f.a.value == '')
	{
		return false;
	}
}
function actCheck(act)
{
	var f = document.procForm;
    var l = document.getElementsByName('members[]');
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
		alert('선택된 항목이 없습니다.      ');
		return false;
	}

	if (act == 'saved_category')
	{
		if (getId('iCategory').style.display == 'inline')
		{
			if (f.category.value == '')
			{
				alert('지정하려는 분류명을 입력해 주세요.   ');
				f.category.focus();
				return false;
			}
		}
		else {
			getId('iCategory').style.display = 'inline';
			f.category.focus();
			return false;
		}
	}

	if(confirm('정말로 실행하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
}
//]]>
</script>
