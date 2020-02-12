<?php

$_WHERE = 'site='.$s;
$where = 'name|tag';

if ($listid) {

	$_IS_LISTOWN=getDbRows($table[$m.'list'],'mbruid='.$my['uid'].' and uid='.$LIST['uid']);
	$_perm['list_owner'] = $my['admin'] || $_IS_LISTOWN  ? true : false;

	if (!$LIST['uid'] || ($LIST['display']==1&&!$_perm['list_owner']) || ($LIST['display']==4 && !$my['uid'])) $mod = '_404';

	if ($mbrid) {
		$M = getDbData($table['s_mbrid'],"id='".$mbrid."'",'*');
		$MBR = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
	}

	$_WHERE .= ' and list="'.$LIST['uid'].'"';
	$TCD = getDbArray($table[$m.'list_index'],$_WHERE,'*','gid','asc',$recnum,$p);
	$NUM = getDbRows($table[$m.'list_index'],$_WHERE);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table[$m.'data'],'uid='.$_R['data'],'*');

} else {

  if ($my['uid']) $_WHERE .= ' and display > 3';  // 회원공개와 전체공개 리스트 출력
  else $_WHERE .= ' and display = 5'; // 전체공개 리스트만 출력

  if ($keyword) $_WHERE .= getSearchSql($where,$keyword,$ikeyword,'or');
  $sort = $sort?$sort:'d_regis';
  $RCD = getDbArray($table[$m.'list'],$_WHERE,'*',$sort,'desc',$recnum,$p);
  $NUM = getDbRows($table[$m.'list'],$_WHERE);
  $TPG = getTotalPage($NUM,$recnum);

}

?>
