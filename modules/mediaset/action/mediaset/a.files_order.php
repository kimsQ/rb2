<?php
if(!defined('__KIMS__')) exit;

$i = 0;
foreach($photomembers as $file_uid)
{
	$val = explode('|',$file_uid);
	getDbUpdate($table['s_upload'],'pid='.$i,'uid='.$val[0]);
	$i++;
}
setrawcookie('mediaset_result', rawurlencode('순서가 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
