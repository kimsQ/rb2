<?php
$_WHERE = 'site='.$s;
$where = $where?$where:'subject|tag|review';

if ($sort == 'gid' && !$keyword  && !$listid) {

	if (!$my['uid']) $_WHERE .= ' and display<>4';

	if ($cat)  $_WHERE .= ' and ('.getPostCategoryCodeToSql($table[$m.'category'],$cat).')';
	$TCD = getDbArray($table[$m.'category_index'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
	$NUM = getDbRows($table[$m.'category_index'],$_WHERE);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table[$m.'data'],'uid='.$_R['data'],'*');

} else {

	if (!$my['uid']) $_WHERE .= ' and display<>4';

	if ($where && $keyword) {
		if (strpos('[nic][id][ip]',$where)) $_WHERE .= " and ".$where."='".$keyword."'";
		else if ($where == 'term') $_WHERE .= " and d_regis like '".$keyword."%'";
		else $_WHERE .= getSearchSql($where,$keyword,$ikeyword,'or');
	}

	if ($cat) $_WHERE .= ' and ('.getPostCategoryCodeToSql2($table[$m.'category'],$cat).')';
	$orderby = $sort == 'gid'?'asc':'desc';
	$TCD = getDbArray($table[$m.'data'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
	$NUM = getDbRows($table[$m.'data'],$_WHERE);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
}

$TPG = getTotalPage($NUM,$recnum);

?>
