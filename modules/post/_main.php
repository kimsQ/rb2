<?php

//카테고리 출력
function getPostCategoryShow($table,$j,$parent,$depth,$uid,$CXA,$hidden)
{
	global $path,$cat,$g;
	global $MenuOpen,$numhidden,$checkbox,$headfoot;
	static $j;
	$CD=getDbSelect($table,'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		if(@in_array($C['uid'],$CXA)) $MenuOpen .= 'trees[0].tmB('.$j.');';
		$numprintx = !$numhidden && $C['num'] ? '&lt;span class="num"&gt;('.$C['num'].')&lt;/span&gt;' : '';
		$C['name'] = $headfoot && ($C['imghead']||$C['imgfoot']||$C['codhead']||$C['codfoot']) ? '&lt;b&gt;'.$C['name'].'&lt;b&gt;' : $C['name'];
		$name = $C['uid'] != $cat ? addslashes($C['name']): '&lt;span class="on"&gt;'.addslashes($C['name']).'&lt;/span&gt;';
		$name = '&lt;span class="ticon tdepth'.$C['depth'].'"&gt;&lt;/span&gt;&lt;span class="name ndepth'.$C['depth'].'"&gt;'.$name.'&lt;/span&gt;';
		if($checkbox) $icon1 = '&lt;input type="checkbox" name="members[]" value="'.$C['uid'].'" /&gt;';
		$icon2 = $C['hidden'] ? ' &lt;img src="'.$g['img_core'].'/_public/ico_hidden.gif" class="hidden" alt="숨김상태" /&gt;' : '';
		if ($C['is_child'])
		{
			echo "['".$icon1.$name.$icon2.$numprintx."','".$C['uid']."',";
			getPostCategoryShow($table,$j,$C['uid'],$C['depth'],$uid,$CXA,$hidden);
			echo "],\n";
		}
		else {
			echo "['".$icon1.$name.$icon2.$numprintx."','".$C['uid']."',''],\n";
		}
	}
}
//카테고리 코드->경로
function getPostCategoryCodeToPath($table,$cat,$j)
{
	global $DB_CONNECT;
	static $arr;
	$R=getUidData($table,$cat);
	if($R['parent'])
	{
		$arr[$j]['uid'] = $R['uid'];
		$arr[$j]['id'] = $R['id'];
		$arr[$j]['name']= $R['name'];
		getPostCategoryCodeToPath($table,$R['parent'],$j+1);
	}
	else {
		$C=getUidData($table,$cat);
		$arr[$j]['uid'] = $C['uid'];
		$arr[$j]['id'] = $C['id'];
		$arr[$j]['name']= $C['name'];
	}
	sort($arr);
	reset($arr);
	return $arr;
}
//카테고리코드->SQL
function getPostCategoryCodeToSql($table,$cat)
{
	$R=getDbData($table,'id="'.$cat.'"','*');
	if ($R['uid']) $sql .= 'category='.$R['uid'].' or ';
	if ($R['is_child'])
	{
		$RDATA=getDbSelect($table,'parent='.$R['uid'],'uid,is_child');
		while($C=db_fetch_array($RDATA)) $sql .= getPostCategoryCodeToSqlX($table,$C['uid'],$C['is_child']);
	}
	return substr($sql,0,strlen($sql)-4);
}
function getPostCategoryCodeToSql2($table,$cat)
{
	$R=getDbData($table,'id="'.$cat.'"','*');
	if ($R['uid']) $sql .= 'category like "%['.$R['uid'].']%" or ';
	if ($R['is_child'])
	{
		$RDATA=getDbSelect($table,'parent='.$R['uid'],'uid,is_child');
		while($C=db_fetch_array($RDATA)) $sql .= getPostCategoryCodeToSqlY($table,$C['uid'],$C['is_child']);
	}
	return substr($sql,0,strlen($sql)-4);
}
//카테고리코드->SQL
function getPostCategoryCodeToSqlX($table,$cat,$is_child)
{
	$sql = 'category='.$cat.' or ';
	if ($is_child)
	{
		$RDATA=getDbSelect($table,'parent='.$cat,'uid,is_child');
		while($C=db_fetch_array($RDATA)) $sql .= getPostCategoryCodeToSqlX($table,$C['uid'],$C['is_child']);
	}
	return $sql;
}
function getPostCategoryCodeToSqlY($table,$cat,$is_child)
{
	$sql = 'category like "%['.$cat.']%" or ';
	if ($is_child)
	{
		$RDATA=getDbSelect($table,'parent='.$cat,'uid,is_child');
		while($C=db_fetch_array($RDATA)) $sql .= getPostCategoryCodeToSqlY($table,$C['uid'],$C['is_child']);
	}
	return $sql;
}
//카테고리출력
function getCategoryShowSelect($table,$j,$parent,$depth,$uid,$hidden)
{
	global $cat;
	static $j;
	$CD=getDbSelect($table,'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		echo '<option class="selectcat'.$C['depth'].'" value="'.$C['uid'].'"'.($C['uid']==$cat?' selected="selected"':'').'>';
		if(!$depth) echo 'ㆍ';
		for($i=1;$i<$C['depth'];$i++) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if ($C['depth'] > 1) echo 'ㄴ';
		echo $C['name'].'</option>';
		if ($C['is_child']) getCategoryShowSelect($table,$j,$C['uid'],$C['depth'],$uid,$hidden);
	}
}

function getTreePostCategoryCheck($conf,$uid,$depth,$parent,$tmpcode) {
	global $table;
	$ctype = $conf['ctype']?$conf['ctype']:'uid';
	$id = 'tree_'.filterstr(microtime());
	$tree = '<div class="rb-tree"><ul id="'.$id.'">';
	$CD=getDbSelect($conf['table'],($conf['site']?'site='.$conf['site'].' and ':'').'depth='.($depth+1).' and parent='.$parent.($conf['dispHidden']?' and hidden=0':'').($conf['mobile']?' and mobile=1':'').' order by gid asc','*');

	$_i = 0;
	while($C=db_fetch_array($CD))
	{

		$tcheck= getDbRows($table['postcategory_index'],'data='.$uid.' and category='.$C['uid']);

		$tree.= '<li>';
		if ($C['is_child'])
		{
			$tree.= '<a data-toggle="collapse" href="#'.$id.'-'.$_i.'-'.$C['uid'].'" class="rb-branch'.($conf['allOpen']?'':' collapsed').'"></a>';
			if ($conf['userMenu']=='link') $tree.= '<span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<span class="form-group form-check mb-0">';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" form-check-input name="tree_members[]" id="check'.$C['uid'].'" value="'.$C['uid'].'" '.($tcheck?' checked':'').'>';
			if($C['hidden']) $tree.='<u title="숨김" data-tooltip="tooltip">';
			$tree.= '<label class="form-check-label" for="check'.$C['uid'].'">'.$C['name'].'</label>';
			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if($C['hidden']) $tree.='</span>';
			$tree.='</u>';
			if(!$conf['hideIcon'])
			{
				if($C['target']) $tree.= ' <i class="fa fa-window-restore fa-fw" title="새창" data-tooltip="tooltip"></i>';
				if($C['reject']) $tree.= ' <i class="fa fa-lock fa-lg fa-fw" title="차단" data-tooltip="tooltip"></i>';
			}

			$tree.= '<ul id="'.$id.'-'.$_i.'-'.$C['uid'].'" class="collapse'.($conf['allOpen']?' show':'').'">';
			$tree.= getTreePostCategoryCheck($conf,$uid,$C['depth'],$C['uid'],$rcode);
			$tree.= '</ul>';
		}
		else {
			$tree.= '<a href="#." class="rb-leaf"></a>';
			if ($conf['userMenu']=='link') $tree.= '<span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a class="form-group form-check mb-0">';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" class="form-check-input" name="tree_members[]" id="check'.$C['uid'].'" value="'.$C['uid'].'" '.($tcheck?' checked':'').'>';
			if($C['hidden']) $tree.='<u title="숨김" data-tooltip="tooltip">';
			$tree.= '<label class="form-check-label" for="check'.$C['uid'].'">'.$C['name'].'</label>';
			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if($C['hidden']) $tree.='</u>';
			$tree.='</a>';


			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="fa fa-mobile fa-lg fa-fw" title="모바일" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= ' <i class="fa fa-window-restore fa-fw" title="새창" data-tooltip="tooltip"></i>';
				if($C['reject']) $tree.= ' <i class="fa fa-lock fa-lg fa-fw" title="차단" data-tooltip="tooltip"></i>';
			}
		}
		$tree.= '</li>';
		$_i++;
	}
	$tree.= '</ul></div>';
	return $tree;
}

?>
