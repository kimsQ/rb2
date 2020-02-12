<?php
include_once $g['dir_module_skin'].'_menu.php';

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

if ($inbox == 3)
{
	$sqlque = 'by_mbruid='.$M['memberuid'];
}
else
{
	$sqlque = 'my_mbruid='.$M['memberuid'];
	if ($inbox) $sqlque .= " and inbox='".$inbox."'";
	if ($where && $keyword)
	{
		$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
	}
}
$RCD = getDbArray($table['s_paper'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_paper'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

?>



<div id="paperlist">

	<div class="info">

		<div class="article">
			<?php echo number_format($NUM)?>개(<?php echo $p?>/<?php echo $TPG?>페이지)
		</div>
		<div class="category">

			<select onchange="goHref('<?php echo str_replace('&amp;','&',$g['url_page'])?>&inbox='+this.value);">
			<option value="">&nbsp;+ 전체</option>
			<option value="">-------------</option>
			<option value="1"<?php if($inbox==1):?> selected="selected"<?php endif?>>받은쪽지함</option>
			<option value="2"<?php if($inbox==2):?> selected="selected"<?php endif?>>쪽지보관함</option>
			<option value="3"<?php if($inbox==3):?> selected="selected"<?php endif?>>보낸쪽지함</option>
			</select>

		</div>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="" />

	<table summary="쪽지 리스트입니다.">
	<caption>쪽지</caption>
	<colgroup>
	<col width="30">
	<col width="50">
	<col width="80">
	<col width="20">
	<col>
	<col width="90">
	</colgroup>
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" class="hand" alt="" onclick="chkFlag('members[]');" /></th>
	<th scope="col">번호</th>
	<th scope="col"><?php echo $inbox==3?'받는이':'보낸이'?></th>
	<th scope="col"></th>
	<th scope="col">내용</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $R['content']=str_replace('&nbsp;',' ',$R['content'])?>
	<?php $M=getDbData($table['s_mbrdata'],'memberuid='.$R[($index==3?'m':'b').'y_mbruid'],'*')?>
	<tr>
	<td><input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" /></td>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="cat"><?php echo $M[$_HS['nametype']]?$M[$_HS['nametype']]:'시스템'?></td>
	<td><img src="<?php echo $g['img_core']?>/_public/ico_paper.gif" alt=""<?php if($R['d_read']):?> title="<?php echo getDateFormat($R['d_read'],'Y.m.d H:i 열람')?>" class="isread"<?php endif?> /></td>
	<td class="sbj">
		<a href="#." title="<?php echo getStrCut(htmlspecialchars(strip_tags($R['content'])),100,'...')?>" onmouseover="qTilePop(this);" onmouseout="qTilePopKill(this);"><?php echo getStrCut(strip_tags($R['content']),50,'..')?></a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr>
	<?php endwhile?>

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td>1</td>
	<td class="cat">시스템</td>
	<td><img src="<?php echo $g['img_core']?>/_public/ico_paper.gif" alt="" /></td>
	<td class="sbj1">쪽지가 없습니다.</td>
	<td><?php echo getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr>
	<?php endif?>

	</tbody>
	</table>


	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
	</div>

	<?php if($inbox < 3):?>
	<input type="button" value="삭제" class="btngray" onclick="actCheck('paper_delete');" />
	<?php if($inbox!=2):?>
	<input type="button" value="보관" class="btngray" onclick="actCheck('paper_save');" />
	<?php endif?>
	<?php endif?>

	</form>


</div>

<div id="qTilePopDiv"></div>

<script type="text/javascript">
//<![CDATA[
// list
function qTilePop(obj)
{
    var content ='<div style="width:300px;line-height:150%;font-family:dotum;color:#666666;border:#999999 solid 1px;padding:3px;background:lightyellow;">'+obj.title+'</div>';
	skn.style.position= 'absolute';
	skn.style.display = 'block';
	skn.style.zIndex = '1';
	itt = obj.title;
	obj.title = '';
	skn.innerHTML = content;
}
function get_mouse(e)
{
    var x = myagent != 'ie' ? e.pageX : event.x + (document.documentElement.clientLeft || document.body.clientLeft);
    var y = myagent != 'ie' ? e.pageY : event.y + (document.documentElement.clientTop || document.body.clientTop);
    skn.style.left = (x - 0) + 'px';
    skn.style.top  = (y + 20) + 'px';
}
function qTilePopKill(obj)
{
	obj.title = itt;
	itt = '';
	skn.style.top = '10000';
	skn.style.display = 'none';
}
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

	if(confirm('정말로 실행하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
}
if (myagent != 'ie') document.captureEvents(Event.MOUSEMOVE);
document.onmousemove = get_mouse;

var skn = getId('qTilePopDiv');
var itt = '';


document.title = "<?php echo $M[$_HS['nametype']]?>님의 쪽지함";
self.resizeTo(800,750);

//]]>
</script>


