<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$term1 = $year1.$month1.$day1.$hour1.$min1.'00';
$term2 = $year2.$month2.$day2.$hour2.$min2.'00';
$name = trim(strip_tags($name));

if ($uid) {
	$QVAL = "hidden='".$hidden."',admin='".$admin."',term0='".$term0."',term1='".$term1."',term2='".$term2."',name='".$name."',content='".$source."',m_content='".$m_source."',html='".$html."',m_html='".$m_html."',upload='".$upload."',m_upload='".$m_upload."',position='".$position."',center='".$center."',";
	$QVAL.= "ptop='".$ptop."',pleft='".$pleft."',width='".$width."',draggable='".$draggable."',type='".$type."',m_type='".$m_type."',dispage='".$dispage."',skin='".$skin."',m_skin='".$m_skin."',bgcolor='".$bgcolor."'";

	getDbUpdate($table['s_popup'],$QVAL,'uid='.$uid);
	setrawcookie('result_popup_main', rawurlencode('팝업내용이 수정되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

} else {

	$QKEY = "hidden,admin,term0,term1,term2,name,content,m_content,html,m_html,upload,m_upload,position,center,ptop,pleft,width,draggable,type,m_type,dispage,skin,m_skin,bgcolor";
	$QVAL = "'$hidden','$admin','$term0','$term1','$term2','$name','$source','$m_source','$html','$m_html','$upload','$m_upload','$position','$center','$ptop','$pleft','$width','$draggable','$type','$m_type','$dispage','$skin','$m_skin','$bgcolor'";

	getDbInsert($table['s_popup'],$QKEY,$QVAL);
	$lastpopup = getDbCnt($table['s_popup'],'max(uid)','');

	setrawcookie('result_popup_main', rawurlencode('팝업이 신규 생성되었습니다.|success'));  // 처리여부 cookie 저장
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=main&uid='.$lastpopup,'parent.','','');
}
?>
