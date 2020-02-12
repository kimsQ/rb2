<?php
//메뉴출력
function getMenuShow($site,$table,$j,$parent,$depth,$uid,$CXA,$hidden)
{
	global $cat,$g;
	global $MenuOpen,$numhidden,$checkbox,$headfoot;
	static $j;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		if(@in_array($C['uid'],$CXA)) $MenuOpen .= 'trees[0].tmB('.$j.');';
		$numprintx = !$numhidden && $C['num'] ? '&lt;span class="num"&gt;('.$C['num'].')&lt;/span&gt;' : '';
		$C['name'] = $headfoot && ($C['imghead']||$C['imgfoot']||$C['codhead']||$C['codfoot']) ? '&lt;b&gt;'.$C['name'].'&lt;b&gt;' : $C['name'];
		$name = $C['uid'] != $cat ? addslashes($C['name']): '&lt;span class="on"&gt;'.addslashes($C['name']).'&lt;/span&gt;';
		$name = '&lt;span class="ticon tdepth'.$C['depth'].'"&gt;&lt;/span&gt;&lt;span class="name'.($C['hidden']||$C['reject']?' hidden':'').' ndepth'.$C['depth'].'"&gt;'.$name.'&lt;/span&gt;';

		if($checkbox) $icon1 = '&lt;input type="checkbox" name="members[]" value="'.$C['uid'].'" /&gt;';
		$icon2 = $C['mobile'] ? ' &lt;img src="'.$g['img_core'].'/_public/ico_mobile.gif" class="mobile" alt="" /&gt;' : '';
		$icon3 = $C['reject'] ? ' &lt;img src="'.$g['img_core'].'/_public/ico_hidden.gif" alt="" /&gt;' : '';

		if ($C['is_child'])
		{
			echo "['".$icon1.$name.$icon2.$numprintx."','".$C['uid']."',";
			getMenuShow($site,$table,$j,$C['uid'],$C['depth'],$uid,$CXA,$hidden);
			echo "],\n";
		}
		else {
			echo "['".$icon1.$name.$icon2.$icon3.$numprintx."','".$C['uid']."',''],\n";
		}
	}
}


//메뉴코드->경로
function getMenuCodeToPath($table,$cat,$j)
{
	global $DB_CONNECT;
	static $arr;

	$R=getUidData($table,$cat);
	if($R['parent'])
	{
		$arr[$j]['uid'] = $R['uid'];
		$arr[$j]['id'] = $R['id'];
		$arr[$j]['name']= $R['name'];
		getMenuCodeToPath($table,$R['parent'],$j+1);
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
//메뉴코드->SQL
function getMenuCodeToSql($table,$cat,$f)
{
	static $sql;

	$R=getUidData($table,$cat);
	if ($R['uid']) $sql .= $f.'='.$R['uid'].' or ';
	if ($R['is_child'])
	{
		$RDATA=getDbSelect($table,'parent='.$R['uid'],'uid');
		while($C=db_fetch_array($RDATA)) getMenuCodeToSql($table,$C['uid'],$f);
	}
	return substr($sql,0,strlen($sql)-4);
}
?>
