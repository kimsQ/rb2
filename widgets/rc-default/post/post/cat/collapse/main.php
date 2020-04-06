<?php
if (!function_exists('getPostCategoryWidgetCollapse'))
{
	function getPostCategoryWidgetCollapse($site,$table,$is_child,$parent,$depth,$id,$w,$_C)
	{
		global $_CA;
		$CD = getDbSelect($table,($site?'site='.$site.' and ':'').'hidden=0 and parent='.$parent.' and depth='.($depth+1).($w['mobile']?'':'').' order by gid asc','*');
		if(db_num_rows($CD))
		{
?>


<ul class="table-view mt-0 bg-white border-top-0" id="<?php echo $w['collid']?>">
	<?php
	while($C = db_fetch_array($CD)):
	$CD1 = getDbSelect($table,($site?'site='.$site.' and ':'').'hidden=0 and parent='.$C['uid'].' and depth='.($C['depth']+1).' order by gid asc','*');
	$_newTree	= ($id?$id.'/':'').$C['id'];
	$_newTreeB	= str_replace('/','-',$_newTree);
	$_href		= $w['link']=='bookmark'?'#'.$_newTreeB:RW('c='.$_newTree);
	$_name		= $C['name'];
	$_target	= $C['target']=='_blank'?' target="_blank"':'';
	$_addattr	= $C['addattr']?' '.$C['addattr']:'';
	$_isActive	= in_array($C['id'],$_CA);
	?>
	<?php if($C['is_child'] && $w['limit'] > 1 && $w['collapse']):?>
	<li class="table-view-cell">
		<a data-toggle="collapse" data-parent="#<?php echo $w['collid']?>" href="#<?php echo $w['collid']?>-<?php echo $C['uid']?>" class="navigate-updown collapsed<?php if($_isActive):?> active<?php endif?>">
			<?php echo $C['name']?>
		</a>

		<ul class="table-view collapse<?php if($_isActive):?> in<?php endif?>" id="<?php echo $w['collid']?>-<?php echo $C['uid']?>">
			<?php if($w['dispfmenu']):?>
			<li class="table-view-cell"><a href="#page-post-category-view" data-start="#page-post-category" data-toggle="page" data-title="<?php echo $_name?>" data-index="0" data-parent="<?php echo $C['uid']?>" data-category="<?php echo $C['uid']?>">전체보기</a></li>
			<?php endif?>
			<?php $i=1;while($C1 = db_fetch_array($CD1)):?>
			<li class="table-view-cell<?php if(in_array($C1['id'],$_CA)):?> table-view-info<?php endif?>">
				<a class="" href="#page-post-category-view" data-start="#page-post-category" data-toggle="page" data-title="<?php echo $_name?>" data-index="<?php echo $i ?>" data-parent="<?php echo $C1['parent']?>" data-category="<?php echo $C1['uid']?>" data-url="/post/category/<?php echo $C1['uid']?>">
					<?php echo $C1['name']?>
				</a>
			</li>
			<?php $i++;endwhile?>
		</ul>
	</li>
	<?php else:?>
	<li class="table-view-cell<?php if($_isActive):?> active<?php endif?>">
		<a href="#page-post-category-view" data-start="#page-post-category" data-toggle="page" data-title="<?php echo $C['name']?>" data-index="0"  data-parent="<?php echo $C['uid']?>" data-category="<?php echo $C['uid']?>">
			<?php echo $C['name']?>
			<?php if($C['is_child']):?><span class="branch"></span><?php endif?>
		</a>
		<?php if($C['is_child'] && $w['limit'] > 1 && $_isActive):?>
		<ul class="table-view">
			<?php while($C1 = db_fetch_array($CD1)):?>
			<li class="table-view-cell<?php if(in_array($C1['id'],$_CA)):?> table-view-info<?php endif?>">
				<a href="#page-post-category-view" data-start="#page-post-category" data-toggle="page">
					<?php echo $C1['name']?>
				</a>
			</li>
			<?php endwhile?>
		</ul>
		<?php endif?>
	</li>
	<?php endif?>
	<?php endwhile?>
</ul>
<?php
		}
	}
}
$wddvar['limit'] = $wddvar['limit'] < 3 ? $wddvar['limit'] : 2;
if ($wdgvar['smenu'] < 0)
{
	if (strstr($c,'/'))
	{
		$wdgvar['mnarr'] = explode('/',$c);
		$wdgvar['count'] = (- $wdgvar['smenu']) - 1;
		for ($j = 0; $j <= $wdgvar['count']; $j++) $wdgvar['sid'] .= $wdgvar['mnarr'][$j].'/';
		$wdgvar['sid'] = $wdgvar['sid'] ? substr($wdgvar['sid'],0,strlen($wdgvar['sid'])-1): '';
		$wdgvar['path'] = getDbData($table['postcategory'],"id='".$wdgvar['mnarr'][$wdgvar['count']]."'",'uid,depth');
		$wdgvar['smenu'] = $wdgvar['path']['uid'];
		$wdgvar['depth'] = $wdgvar['path']['depth'];
	}
	else {
		$wdgvar['sid'] = $c;
		$wdgvar['smenu'] = $_HM['uid'];
		$wdgvar['depth'] = $_HM['depth'];
	}
}
else if ($wdgvar['smenu'])
{
	$wdgvar['mnarr'] = explode('/',$wdgvar['smenu']);
	$wdgvar['count'] = count($wdgvar['mnarr']);
	for ($j = 0; $j < $wdgvar['count']; $j++)
	{
		$wdgvar['path'] = getDbData($table['postcategory'],'uid='.(int)$wdgvar['mnarr'][$j],'uid,id,depth');
		$wdgvar['sid'] .= $wdgvar['path']['id'].'/';
		$wdgvar['smenu'] = $wdgvar['path']['uid'];
		$wdgvar['depth'] = $wdgvar['path']['depth'];
	}
	$wdgvar['sid'] = $wdgvar['sid'] ? substr($wdgvar['sid'],0,strlen($wdgvar['sid'])-1): '';
}
else {
	$wdgvar['depth'] = 0;
}
$wdgvar['olimit']= $wdgvar['limit'];
$wdgvar['limit'] = $wdgvar['limit'] + $wdgvar['depth'];
getPostCategoryWidgetCollapse($s,$table['postcategory'],0,$wdgvar['smenu'],$wdgvar['depth'],$wdgvar['sid'],$wdgvar,array());
?>
