<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$i = 0;
foreach($menumembers as $val) getDbUpdate($table['s_menu'],'gid='.($i++),'uid='.$val);
setrawcookie('result_menu', rawurlencode('순서가 변경되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
