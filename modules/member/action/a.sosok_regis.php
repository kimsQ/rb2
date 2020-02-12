<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$i = 0;
foreach($sosokmembers as $val)
{
	getDbUpdate($table['s_mbrgroup'],'gid='.($i++).",name='".trim(${'name_'.$val})."'",'uid='.$val);
}

if ($name)
{
	getDbInsert($table['s_mbrgroup'],'gid,name,num',"'".$i."','".trim($name)."','0'");
}
setrawcookie('member_group_result', rawurlencode('그룹 설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
