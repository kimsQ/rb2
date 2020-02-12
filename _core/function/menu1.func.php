<?php
//카테고리출력
function getMenuShowSelect($site,$table,$j,$parent,$depth,$uid,$hidden,$id)
{
	global $cat,$_isUid;
	static $j;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$nId = ($id?$id.'/':'').$C[$_isUid.'id'];
		$j++;
		echo '<option class="selectcat'.$C['depth'].'" value="'.$nId.'"'.($nId==$cat?' selected':'').'>';
		for($i=1;$i<$C['depth'];$i++) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if ($C['depth'] > 1) echo 'ㄴ';
		echo $C['name'].($C['num']?' ('.$C['num'].')':'').'</option>';
		if ($C['is_child']) getMenuShowSelect($site,$table,$j,$C['uid'],$C['depth'],$uid,$hidden,$nId);
	}
}

function getMenuShowSelectCode($site,$table,$j,$parent,$depth,$uid,$hidden,$id)
{
	global $cat,$_isUid;
	static $j;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$nId = $C[$_isUid.'id'];
		$j++;
		echo '<option class="selectcat'.$C['depth'].'" value="'.$nId.'"'.($nId==$cat?' selected':'').'>';
		for($i=1;$i<$C['depth'];$i++) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if ($C['depth'] > 1) echo 'ㄴ';
		echo $C['name'].($C['num']?' ('.$C['num'].')':'').'</option>';
		if ($C['is_child']) getMenuShowSelectCode($site,$table,$j,$C['uid'],$C['depth'],$uid,$hidden,$nId);
	}
}
?>
