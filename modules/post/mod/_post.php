<?php
if(!defined('__KIMS__')) exit;

$postque = 'site='.$s;

if (!$my['uid']) $postque .= ' and display=5';
else $postque .= ' and display>3';

$RCD = array();

if ($sort == 'gid' && !$keyword)
{
	$NUM = getDbRows($table[$m.'index'],$postque);
	$TCD = getDbArray($table[$m.'index'],$postque,'gid',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table[$m.'data'],'gid='.$_R['gid'],'*');
}
else {

	$orderby = 'desc';
	$where = 'subject|review|tag';

	if ($where && $keyword) {
		if (strpos('[name][nic][id][ip]',$where)) $postque .= " and ".$where."='".$keyword."'";
		else if ($where == 'term') $postque .= " and d_regis like '".$keyword."%'";
		else $postque .= getSearchSql($where,$keyword,$ikeyword,'or');
	}
	$NUM = getDbRows($table[$m.'data'],$postque);
	$TCD = getDbArray($table[$m.'data'],$postque,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
}
$TPG = getTotalPage($NUM,$recnum);
?>
