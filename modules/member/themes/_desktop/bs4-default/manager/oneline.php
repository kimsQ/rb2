<?php
include_once $g['dir_module_skin'].'_menu.php';

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

$bbsque = 'mbruid='.$M['memberuid'];
if ($account) $bbsque .= ' and site='.$account;

if ($where && $keyword)
{
	if (strstr('[name][nic][id][ip]',$where)) $bbsque .= " and ".$where."='".$keyword."'";
	else if ($where == 'term') $bbsque .= " and d_regis like '".$keyword."%'";
	else $bbsque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_oneline'],$bbsque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_oneline'],$bbsque);
$TPG = getTotalPage($NUM,$recnum);
?>


<div id="bbslist">

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>

		<div class="category">
			<select name="account" class="account" onchange="goHref('<?php echo str_replace('&amp;','&',$g['url_reset'])?>&page=<?php echo $page?>&account='+this.value);">
			<option value="">&nbsp;+ 전체사이트</option>
			<option value="">----------------</option>
			<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,1)?>
			<?php while($S = db_fetch_array($SITES)):?>
			<option value="<?php echo $S['uid']?>"<?php if($account==$S['uid']):?> selected="selected"<?php endif?>>ㆍ<?php echo $S['name']?></option>
			<?php endwhile?>
			<?php if(!db_num_rows($SITES)):?>
			<option value="">등록된 사이트가 없습니다.</option>
			<?php endif?>
			</select>
		</div>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="comment" />
	<input type="hidden" name="a" value="" />


	<table summary="한줄의견리스트 입니다.">
	<caption>한줄의견리스트</caption>
	<colgroup>
	<col width="30">
	<col width="50">
	<col>
	<col width="90">
	</colgroup>
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" class="hand" alt="" onclick="chkFlag('oneline_members[]');" /></th>
	<th scope="col">번호</th>
	<th scope="col">한줄의견</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $_R=getUidData($table['s_comment'],$R['parent'])?>
	<?php $R['mobile']=isMobileConnect($R['agent'])?>
	<tr>
	<td><input type="checkbox" name="oneline_members[]" value="<?php echo $R['uid']?>" /></td>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="sbj">
		<?php if($R['mobile']):?><img src="<?php echo $g['img_core']?>/_public/ico_mobile.gif" class="imgpos" alt="모바일" title="모바일(<?php echo $R['mobile']?>)로 등록된 글입니다" /><?php endif?>
		<a href="<?php echo getCyncUrl($_R['cync'].',CMT:'.$_R['uid'].',s:'.$R['site'])?>#CMT" target="_blank"><?php echo getStrCut($R['content'],40,'..')?></a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr>
	<?php endwhile?>

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td>1</td>
	<td class="sbj1">한줄의견이 없습니다.</td>
	<td><?php echo getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr>
	<?php endif?>

	</tbody>
	</table>


	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
	</div>


	<input type="button" value="선택/해제" class="btngray" onclick="chkFlag('oneline_members[]');" />
	<input type="button" value="삭제" class="btnblue" onclick="actCheck('multi_oneline_delete');" />

	</form>


	<div class="searchform">
		<form name="bbssearchf" action="<?php echo $g['s']?>/">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="mbruid" value="<?php echo $mbruid?>" />
		<input type="hidden" name="account" value="<?php echo $account?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />
		<input type="hidden" name="page" value="<?php echo $page?>" />
		<input type="hidden" name="sort" value="<?php echo $sort?>" />
		<input type="hidden" name="orderby" value="<?php echo $orderby?>" />
		<input type="hidden" name="recnum" value="<?php echo $recnum?>" />
		<input type="hidden" name="type" value="<?php echo $type?>" />
		<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
		<input type="hidden" name="skin" value="<?php echo $skin?>" />

		<select name="where">
		<option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>내용</option>
		</select>

		<input type="text" name="keyword" size="30" value="<?php echo $_keyword?>" class="input" />
		<input type="submit" value=" 검색 " class="btngray" />
		</form>
	</div>

</div>

<script type="text/javascript">
//<![CDATA[
// list
function actCheck(act)
{
	var f = document.procForm;
    var l = document.getElementsByName('oneline_members[]');
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
		alert('선택된 한줄의견이 없습니다.      ');
		return false;
	}

	if(confirm('정말로 삭제하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
}


document.title = "<?php echo $M[$_HS['nametype']]?>님의 한줄의견";
self.resizeTo(800,750);

//]]>
</script>
