<?php
include_once $g['dir_module_skin'].'_menu.php';

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;
$type	= $type	? $type : 'follower';

if ($type == 'follower')
{
	$sqlque = 'by_mbruid='.$M['memberuid'];
	if ($category) $sqlque .= " and category='".$category."'";
}
elseif($type == 'following')
{
	$sqlque = 'my_mbruid='.$M['memberuid'];
}
else {
	$sqlque = 'my_mbruid='.$M['memberuid'].' and rel=1';
}

if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_friend'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_friend'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$_NUM = array();
$_NUM['follower'] = getDbRows($table['s_friend'],'by_mbruid='.$M['memberuid']);
$_NUM['following'] = getDbRows($table['s_friend'],'my_mbruid='.$M['memberuid']);
$_NUM['friend'] = getDbRows($table['s_friend'],'my_mbruid='.$M['memberuid'].' and rel=1');
?>



<div id="friendlist">

	<div class="info">

		<div class="article">
			<a href="<?php echo $g['url_page']?>&amp;type=friend"<?php if($type=='friend'):?> class="b"<?php endif?>>맞팔</a><span class="num">(<?php echo $_NUM['friend']?>)</span></span> <span>|</span>
			<a href="<?php echo $g['url_page']?>&amp;type=follower"<?php if($type=='follower'):?> class="b"<?php endif?>>팔로워</a><span class="num">(<?php echo $_NUM['follower']?>)</span> <span>|</span>
			<a href="<?php echo $g['url_page']?>&amp;type=following"<?php if($type=='following'):?> class="b"<?php endif?>>팔로잉</a><span class="num">(<?php echo $_NUM['following']?>)
		</div>
		<div class="category">

			<?php if($type != 'follower'):?>
			<select onchange="goHref('<?php echo str_replace('&amp;','&',$g['url_page'])?>&type=<?php echo $type?>&category='+this.value);">
			<option value="">&nbsp;+ 전체</option>
			<option value="">-------------</option>
			<?php $_CATS = getDbSelect($table['s_friend'],"my_mbruid=".$M['memberuid']." and category<>'' group by category",'category')?>
			<?php while($_R=db_fetch_array($_CATS)):?>
			<option value="<?php echo $_R['category']?>"<?php if($_R['category']==$category):?> selected="selected"<?php endif?>>ㆍ<?php echo $_R['category']?></option>
			<?php endwhile?>
			</select>
			<?php endif?>

		</div>
		<div class="clear"></div>
	</div>


	<table summary="친구 리스트입니다.">
	<caption>친구</caption>
	<colgroup>
	<col width="50">
	<col>
	<col width="60">
	<col width="100">
	<col width="90">
	</colgroup>
	<thead>
	<tr>
	<th scope="col" class="side1">번호</th>
	<th scope="col">이름</th>
	<th scope="col">관계</th>
	<th scope="col">그룹</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $_M=getDbData($table['s_mbrdata'],'memberuid='.$R[($type=='follower'?'m':'b').'y_mbruid'],'*')?>
	<?php $_M1=getUidData($table['s_mbrid'],$_M['memberuid'])?>
	<tr>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="sbj">
		<a class="hand" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.papersend&iframe=Y&id=<?php echo $d['member']['login_emailid']?$_M['email']:$_M1['id']?>');"><?php echo $_M[$_HS['nametype']]?>(<?php echo $d['member']['login_emailid']?$_M['email']:$_M1['id']?>)</a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td class="cat"><?php echo $R['rel']?'맞팔':($type=='follower'?'팔로워':'팔로잉')?></td>
	<td class="cat"><?php echo $R['category']&&$type!='follower'?$R['category']:'-'?></td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr>
	<?php endwhile?>

	<?php if(!$NUM):?>
	<tr>
	<td>1</td>
	<td class="sbj1">
		<?php if($type=='friend'):?>
		등록된 맞팔친구가 없습니다.
		<?php elseif($type=='follower'):?>
		팔로워가 없습니다.
		<?php else:?>
		팔로잉중인 회원이 없습니다.
		<?php endif?>
	</td>
	<td>-</td>
	<td>-</td>
	<td><?php echo getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr>
	<?php endif?>

	</tbody>
	</table>


	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'');</script>
	</div>


</div>


<script type="text/javascript">
//<![CDATA[

document.title = "<?php echo $M[$_HS['nametype']]?>님의 친구";
self.resizeTo(800,750);

//]]>
</script>


