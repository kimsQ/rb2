<?php
if (!function_exists('getMenuWidgetCollapse'))
{
	function getMenuWidgetCollapse($site,$table,$is_child,$parent,$depth,$id,$w,$_C)
	{
		global $_CA;
		$CD = getDbSelect($table,($site?'site='.$site.' and ':'').'hidden=0 and mobile=1 and parent='.$parent.' and depth='.($depth+1).($w['mobile']?' and mobile=1':'').' order by gid asc','*');
		if(db_num_rows($CD))
		{
?>
	<li class="table-view-cell table-view-divider small">메뉴</li>
	<?php
	while($C = db_fetch_array($CD)):
	$CD1 = getDbSelect($table,($site?'site='.$site.' and ':'').'hidden=0 and mobile=1 and parent='.$C['uid'].' and depth='.($C['depth']+1).' order by gid asc','*');
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
		<a data-toggle="collapse" data-parent="#<?php echo $w['accordion']?$w['collid']:''?>" href="#<?php echo $w['collid']?>-<?php echo $C['uid']?>" class="navigate-updown collapsed<?php if($_isActive):?> active<?php endif?>">
			<?php echo $C['name']?>
		</a>

		<ul class="table-view collapse<?php if($_isActive):?> in<?php endif?>" id="<?php echo $w['collid']?>-<?php echo $C['uid']?>">
			<?php if($w['dispfmenu']):?>
			<li class="table-view-cell"><a data-href="<?php echo $_href?>"<?php echo $_addattr.$_target?> data-toggle="drawer-close"><?php echo $_name?></a></li>
			<?php endif?>
			<?php while($C1 = db_fetch_array($CD1)):?>
			<li class="table-view-cell<?php if(in_array($C1['id'],$_CA)):?> table-view-info<?php endif?>">
				<a class="" data-href="<?php echo $w['link']=='bookmark'?'#'.$_newTreeB.'-'.$C1['id']:RW('c='.$_newTree.'/'.$C1['id'])?>" data-toggle="drawer-close" <?php if($C1['addattr']):?> <?php echo $C1['addattr']?><?php endif?><?php if($C1['target']):?> target="<?php echo $C1['target']?>"<?php endif?>>
					<?php echo $C1['name']?>
				</a>
			</li>
			<?php endwhile?>
		</ul>
	</li>
	<?php else:?>
	<li class="table-view-cell<?php if($_isActive):?> table-view-info<?php endif?>">
		<a data-href="<?php echo $_href?>"<?php echo $_addattr.$_target?>  data-toggle="drawer-close">
			<?php echo $C['name']?>
			<?php if($C['is_child']):?><span class="branch"></span><?php endif?>
		</a>
		<?php if($C['is_child'] && $w['limit'] > 1 && $_isActive):?>
		<ul class="table-view">
			<?php while($C1 = db_fetch_array($CD1)):?>
			<li class="table-view-cell<?php if(in_array($C1['id'],$_CA)):?> table-view-info<?php endif?>">
				<a data-href="<?php echo $w['link']=='bookmark'?'#'.$_newTreeB.'-'.$C1['id']:RW('c='.$_newTree.'/'.$C1['id'])?>" data-toggle="drawer-close" <?php if($C1['addattr']):?> <?php echo $C1['addattr']?><?php endif?><?php if($C1['target']):?> target="<?php echo $C1['target']?>"<?php endif?>>
					<?php echo $C1['name']?>
				</a>
			</li>
			<?php endwhile?>
		</ul>
		<?php endif?>
	</li>
	<?php endif?>
	<?php endwhile?>
<?php
		}
	}
}
$wdgvar['limit'] = $wdgvar['limit'] < 6 ? $wdgvar['limit'] : 5;
if ($wdgvar['smenu'] < 0)
{
	if (strstr($c,'/'))
	{
		$wdgvar['mnarr'] = explode('/',$c);
		$wdgvar['count'] = (- $wdgvar['smenu']) - 1;
		for ($j = 0; $j <= $wdgvar['count']; $j++) $wdgvar['sid'] .= $wdgvar['mnarr'][$j].'/';
		$wdgvar['sid'] = $wdgvar['sid'] ? substr($wdgvar['sid'],0,strlen($wdgvar['sid'])-1): '';
		$wdgvar['path'] = getDbData($table['s_menu'],"id='".$wdgvar['mnarr'][$wdgvar['count']]."'",'uid,depth');
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
		$wdgvar['path'] = getDbData($table['s_menu'],'uid='.(int)$wdgvar['mnarr'][$j],'uid,id,depth');
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
getMenuWidgetCollapse($s,$table['s_menu'],0,$wdgvar['smenu'],$wdgvar['depth'],$wdgvar['sid'],$wdgvar,array());
?>
