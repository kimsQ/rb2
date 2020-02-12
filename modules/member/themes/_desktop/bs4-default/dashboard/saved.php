<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

$sqlque = 'mbruid='.$my['uid'];
if ($category) $sqlque .= " and category='".$category."'";
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_saved'],$sqlque,'*',$sort,$orderby,$recnum,$p);

$NUM = getDbRows($table['s_saved'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$g['page_reset']	= RW('mod=dashboard&page='.$page);
$g['page_list']	= $g['page_reset'].getLinkFilter('',array($category?'category':''));
$g['pagelink']	= $g['page_list'];

?>


<div class="container">
	<div class="subhead mt-0">
		<h2 class="mb-0">
			저장내역
		</h2>
	</div>

	<div class="d-flex align-items-center border-top border-dark pt-4 pb-3" role="filter">
		<span class="f18">전체 <span class="text-primary"><?php echo number_format($NUM)?></span> 건</span>
		<div class="form-inline ml-auto">

			<label class="sr-only">분류</label>
			<div class="dropdown">
				<a class="btn btn-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php echo $category?$category:'분류 : 전체' ?>
				</a>

				<div class="dropdown-menu shadow-sm" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item d-flex justify-content-between align-items-center" href="<?php echo RW('mod=dashboard&page=saved')?>">
						전체
						<small><?php echo number_format(getDbRows($table['s_saved'],'mbruid='.$my['uid']))?></small>
					</a>

					<div class="dropdown-divider"></div>
					<h6 class="dropdown-header">게시판</h6>
					<?php $_CATS = getDbSelect($table['s_saved'],"mbruid=".$my['uid']." and category<>'' group by category",'category')?>
					<?php while($_R=db_fetch_array($_CATS)):?>
					<a class="dropdown-item d-flex justify-content-between align-items-center<?php if($_R['category']==$category):?> active<?php endif?>" href="<?php echo RW('mod=dashboard&page=saved')?>&category=<?php echo $_R['category']?>">
						<?php echo $_R['category']?>
						<span class="badge badge-pill"><?php echo number_format(getDbRows($table['s_saved'],'mbruid='.$my['uid'].' and  category="'.$_R['category'].'"'))?></span>
					</a>
					<?php endwhile?>


				</div>
			</div>

			<div class="input-group ml-2">
				<input type="text" class="form-control" placeholder="제목 검색">
				<div class="input-group-append">
					<button class="btn btn-white text-muted border-left-0" type="button">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</div>
			</div>

		</div><!-- /.form-inline -->
	</div><!-- /.d-flex -->

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />
		<input type="hidden" name="a" value="" />

		<table class="table text-center border-bottom">
			<colgroup>
				<col width="50">
				<col width="50">
				<col width="100">
				<col>
				<col width="150">
			</colgroup>
			<thead class="thead-light">
				<tr>
					<th scope="col">
						<i class="fa fa-check-square-o fa-lg" aria-hidden="true"  onclick="chkFlag('members[]');" role="button" data-toggle="tooltip" title="전체선택"></i>
					</th>
					<th scope="col">번호</th>
					<th scope="col">분류</th>
					<th scope="col">제목</th>
					<th scope="col">저장날짜</th>
				</tr>
			</thead>
			<tbody>

				<?php while($R=db_fetch_array($RCD)):?>
				<tr>
					<td><input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" /></td>
					<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
					<td><?php echo $R['category']?></td>
					<td class="text-left">
						<a href="<?php echo $R['url']?>" class="muted-link" target="_blank"><?php echo $R['subject']?></a>
						<?php if(getNew($R['d_regis'],24)):?><small class="text-danger">new</small><?php endif?>
					</td>
					<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
				</tr>
				<?php endwhile?>

				<?php if(!$NUM):?>
				<tr>
					<td colspan="5" class="text-center text-muted p-5">저장된 자료가 없습니다.</td>
				</tr>
				<?php endif?>

			</tbody>
		</table>

		<div class="d-flex justify-content-between my-4">
			<div class="form-inline">
				<input type="text" name="category" id="iCategory" value="" class="form-control none" />

				<button type="button" class="btn btn-light ml-1" onclick="actCheck('saved_category');">
					분류지정
				</button>
				<button type="button" class="btn btn-light ml-2" onclick="actCheck('saved_delete');">
					삭제
				</button>
			</div><!-- /.form-inline -->

			<?php if ($NUM > $recnum): ?>
			<ul class="pagination mb-0">
				<?php echo getPageLink(10,$p,$TPG,'')?>
			</ul>
			<?php endif; ?>
		</div>
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
