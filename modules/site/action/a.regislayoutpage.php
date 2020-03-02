<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_HS = getDbData($table['s_site'],"id='".$r."'",'*');

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$layout = dirname($_HS['m_layout']);
	$notify_type = 'default';
} else {
  $layout = dirname($_HS['layout']);
	$notify_type = 'success';
}

$g['layoutPageVarForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.'.$page.'.php';
$_tmpdfile = is_file($g['layoutPageVarForSite']) ? $g['layoutPageVarForSite'] : $g['path_layout'].$layout.'/_var/_var.'.$page.'.php';

include $_tmpdfile;

$fp = fopen($g['layoutPageVarForSite'],'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['layout']['main_widgets'] = \"".trim($main_widgets)."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($g['layoutPageVarForSite'],0707);

setrawcookie('site_common_result', rawurlencode('저장 되었습니다'));
getLink('reload','parent.frames._ADMPNL_.','','');

?>
