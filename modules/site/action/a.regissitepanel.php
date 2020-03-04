	<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$name = trim($name);
$title = trim($title);

if ($site_uid)
{
	$ISID = getDbData($Table['s_site'],"uid<>".$site_uid." and id='".$id."'",'*');
	if ($ISID['uid']) getLink('','','이미 동일한 명칭의 계정아이디가 존재합니다.','');

	$QVAL = "id='$id',name='$name',title='$title',layout='$layout',startpage='$startpage',m_layout='$m_layout',m_startpage='$m_startpage',open='$open'";
	getDbUpdate($table['s_site'],$QVAL,'uid='.$site_uid);

	if ($_HS['id'] != $id)
	{
		rename($g['path_page'].$_HS['id'].'-menus',$g['path_page'].$id.'-menus');
		rename($g['path_page'].$_HS['id'].'-pages',$g['path_page'].$id.'-pages');
	}
}

if ($_HS['id'] != $id || $_HS['name'] != $name)
{
	getLink($g['s'].'/?r='.$id.'&panel=Y&_admpnl_='.urlencode($referer),'parent.parent.','변경되었습니다','');
}
else {
	//getLink('reload','parent.frames._ADMPNL_.','변경되었습니다','');
	setrawcookie('site_common_result', rawurlencode('변경 되었습니다.'));  // 알림처리를 위한 로그인 상태 cookie 저장
	getLink('reload','parent.frames._ADMPNL_.','','');
}
?>
