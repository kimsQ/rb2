<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

for ($i = 1; $i < 101; $i++)
{
	$name = ${'name_'.$i};
	$login = ${'login_'.$i};
	$post = ${'post_'.$i};
	$comment = ${'comment_'.$i};
	getDbUpdate($table['s_mbrlevel'],"gid=0,name='$name',login='$login',post='$post',comment='$comment'",'uid='.$i);
}
getDbUpdate($table['s_mbrlevel'],'gid=1','uid='.$num);

setrawcookie('member_group_result', rawurlencode('레벨 설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
