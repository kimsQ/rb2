<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);


getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&layout='.$_layout.'&sublayout='.$_sublayout,'parent.',sprintf('[%s] 파일이 수정되었습니다.',$codeFile),'');
?>
