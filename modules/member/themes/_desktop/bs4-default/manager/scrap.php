<?php
include_once $g['dir_module_skin'].'_menu.php';

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

$sqlque = 'mbruid='.$M['memberuid'];
if ($category) $sqlque .= " and category='".$category."'";
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_scrap'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_scrap'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

?>



<div id="scraplist">

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">

			<select onchange="goHref('<?php echo str_replace('&amp;','&',$g['url_page'])?>&category='+this.value);">
			<option value="">&nbsp;+ 전체</option>
			<option value="">-------------</option>
			<?php $_CATS = getDbSelect($table['s_scrap'],"mbruid=".$M['memberuid']." and category<>'' group by category",'category')?>
			<?php while($_R=db_fetch_array($_CATS)):?>
			<option value="<?php echo $_R['category']?>"<?php if($_R['category']==$category):?> selected="selected"<?php endif?>>ㆍ<?php echo $_R['category']?></option>
			<?php endwhile?>
			</select>

		</div>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="스크랩 리스트입니다.">
	<caption>스크랩</caption>
	<colgroup>
	<col width="30">
	<col width="50">
	<col width="100">
	<col>
	<col width="90">
	</colgroup>
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" class="hand" alt="" onclick="chkFlag('members[]');" /></th>
	<th scope="col">번호</th>
	<th scope="col">분류</th>
	<th scope="col">제목</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
	<td><input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" /></td>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="cat"><?php echo $R['category']?></td>
	<td class="sbj">
		<a href="<?php echo $R['url']?>" target="_blank"><?php echo $R['subject']?></a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr>
	<?php endwhile?>

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td>1</td>
	<td class="cat">알림</td>
	<td class="sbj1">스크랩자료가 없습니다.</td>
	<td><?php echo getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr>
	<?php endif?>

	</tbody>
	</table>


	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
	</div>

	<input type="text" name="category" id="iCategory" value="" class="input none" />
	<input type="button" value="분류지정" class="btngray" onclick="actCheck('scrap_category');" />
	<input type="button" value="삭제" class="btngray" onclick="actCheck('scrap_delete');" />

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

	if (act == 'scrap_category')
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

document.title = "<?php echo $M[$_HS['nametype']]?>님의 스크랩";
self.resizeTo(800,750);

//]]>
</script>


