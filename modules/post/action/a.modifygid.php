<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'] || !$type) getLink('','','정상적인 접근이 아닙니다.','');

$i = 1;

if ($type=='list') {
  foreach($listmembers as $val) getDbUpdate($table[$m.'list'],'gid='.($i++),'uid='.$val);
  setrawcookie('list_action_result', rawurlencode('순서가 변경되었습니다.|success'));  // 처리여부 cookie 저장
}

if ($type=='post') {
  foreach($listmembers as $val) getDbUpdate($table[$m.'list_index'],'gid='.($i++),'data='.$val);
  setrawcookie('listview_action_result', rawurlencode('순서가 변경되었습니다.|success'));  // 처리여부 cookie 저장
}

getLink('reload','parent.','','');
?>
