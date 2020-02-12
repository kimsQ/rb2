<?php
include_once $g['dir_module_skin'].'_menu.php';

$type	= $type ? $type : 'point';
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

$sqlque = 'my_mbruid='.$M['memberuid'];
if ($price == '1') $sqlque .= ' and price > 0';
if ($price == '2') $sqlque .= ' and price < 0';
if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_'.$type],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_'.$type],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

?>



<div id="pointlist">

	<div class="info">

		<div class="article">

			<span class="tx">
			<a class="<?php if($type=='point'):?>b <?php endif?>hand" onclick="document.hideForm.type.value='point';document.hideForm.submit();">포인트</a> |
			<a class="<?php if($type=='cash'):?>b <?php endif?>hand" onclick="document.hideForm.type.value='cash';document.hideForm.submit();">적립금</a> |
			<a class="<?php if($type=='money'):?>b <?php endif?>hand" onclick="document.hideForm.type.value='money';document.hideForm.submit();">예치금</a>
			</span>

			<?php echo number_format($M[$type])?> (<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">

			<form name="giveForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return giveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $m?>" />
			<input type="hidden" name="a" value="admin_action" />
			<input type="hidden" name="act" value="give_point" />
			<input type="checkbox" name="mbrmembers[]" value="<?php echo $M['memberuid']?>" checked="checked" class="hide" />
			<input type="hidden" name="pointType" value="<?php echo $type?>" />

			<select name="how" class="sm">
			<option value="+">+</option>
			<option value="-">-</option>
			</select>
			<input type="text" name="price" size="5" class="input" /><?php echo $type=='point'?'P':'원'?> | 지급사유 :
			<input type="text" name="comment" size="35" class="input" />
			<input type="submit" class="btngray" value="지급(차감)" />
			</form>

		</div>
		<div class="clear"></div>
	</div>

	<form name="hideForm" action="<?php echo $g['s']?>/" method="get">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="mbruid" value="<?php echo $mbruid?>" />
	<input type="hidden" name="page" value="<?php echo $page?>" />
	<input type="hidden" name="type" value="<?php echo $type?>" />
	<input type="hidden" name="price" value="<?php echo $price?>" />
	</form>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="포인트 리스트입니다.">
	<caption>포인트</caption>
	<colgroup>
	<col width="30">
	<col width="50">
	<col width="80">
	<col>
	<col width="90">
	</colgroup>
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" class="hand" alt="" onclick="chkFlag('members[]');" /></th>
	<th scope="col">번호</th>
	<th scope="col">
		<select onchange="document.hideForm.price.value=this.value;document.hideForm.submit();">
		<option value="">&nbsp;+ 전체</option>
		<option value="">-----</option>
		<option value="1"<?php if($price=='1'):?> selected="selected"<?php endif?>>획득</option>
		<option value="2"<?php if($price=='2'):?> selected="selected"<?php endif?>>사용</option>
		</select>
	</th>
	<th scope="col">내역</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
	<td><input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" /></td>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="cat"><?php echo ($R['price']>0?'+':'').number_format($R['price'])?></td>
	<td class="sbj">
		<?php echo $R['content']?>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr>
	<?php endwhile?>

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td>1</td>
	<td class="cat">-</td>
	<td class="sbj1">내역이 없습니다.</td>
	<td><?php echo getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr>
	<?php endif?>

	</tbody>
	</table>


	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
	</div>

	<input type="text" name="category" id="iCategory" value="" class="input none" />
	<input type="button" value="선택/해제" class="btngray" onclick="chkFlag('members[]');" />
	<input type="button" value="내역정리" class="btnblue" onclick="actCheck('point_sum');" />
	<input type="button" value="삭제" class="btnblue" onclick="actCheck('point_delete');" />

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
function giveCheck(f)
{
	if (f.price.value == '')
	{
		alert('지급할 포인트를 입력해 주세요.   ');
		f.price.focus();
		return false;
	}
	if (f.comment.value == '')
	{
		alert('지급사유를 입력해 주세요.   ');
		f.comment.focus();
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

	if(confirm('정말로 실행하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
}

document.title = "<?php echo $M[$_HS['nametype']]?>님의 포인트";
self.resizeTo(800,750);

//]]>
</script>


