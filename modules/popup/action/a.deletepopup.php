<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

getDbDelete($table['s_popup'],'uid='.$uid);

setrawcookie('result_popup_main', rawurlencode('팝업이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','', $history);
?>
