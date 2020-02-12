<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'mbruid='.$my['uid'];
if ($category) $sqlque .= " and category='".$category."'";
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_saved'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_saved'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

?>

<div class="container">

	<div class="subhead mt-0">
		<h2 class="subhead-heading">
			<i class="fa fa-bookmark-o fa-fw" aria-hidden="true"></i> 내 저장함
		</h2>
		<span class="text-muted">스크랩한 게시물을 모아볼수 있습니다.</span>
	</div>

	<div class="row mt-3">
		<div class="col-3">


			<nav class="nav flex-column nav-pills">
			  <a class="nav-link filter-item d-flex justify-content-between align-items-center<?php echo !$category?' active':'' ?>" href="<?php echo $g['url_page']?>">
			    전체보기
			    <span class="badge badge-pill"><?php echo number_format(getDbRows($table['s_saved'],'mbruid='.$my['uid']))?></span>
			  </a>

				<?php $_CATS = getDbSelect($table['s_saved'],"mbruid=".$my['uid']." and category<>'' group by category",'category')?>
				<?php while($_R=db_fetch_array($_CATS)):?>
			  <a class="nav-link filter-item d-flex justify-content-between align-items-center<?php if($_R['category']==$category):?> active<?php endif?>" href="<?php echo $g['url_page']?>&category=<?php echo $_R['category']?>">
			    <?php echo $_R['category']?>
			    <span class="badge badge-pill"><?php echo number_format(getDbRows($table['s_saved'],'mbruid='.$my['uid'].' and  category="'.$_R['category'].'"'))?></span>
			  </a>
				<?php endwhile?>
			</nav>

		</div><!-- /.col-3 -->
		<div class="col-9">
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
					<ul class="pagination mb-0">
						<?php echo getPageLink(10,$p,$TPG,'')?>
					</ul>
				</div>
			</form>
		</div><!-- /.col-9 -->
	</div><!-- /.row -->

</div><!-- /.container -->


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
