<?php
if(!defined('__KIMS__')) exit;

$data = array();

$p		= $p ? $p : 1;
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;
$sort	= $sort		? $sort		: 'hit';
$orderby= $orderby	? $orderby	: 'desc';
$query = 'site='.$s.' and ';
$_WHERE1= $query.'keyword like "%'.$q.'%"';
$_WHERE2= 'keyword,sum(hit) as hit';
$Tags	= getDbSelect($table['s_tag'],$_WHERE1.' group by keyword order by '.$sort.' '.$orderby.' limit 0,'.$recnum,$_WHERE2);

$tagData = '';
while($R=db_fetch_array($Tags)){
  $tagData .= $R['keyword'].'|'.$R['hit'].',';
}
$data['taglist'] = $tagData;

echo json_encode($data);
exit;
?>
