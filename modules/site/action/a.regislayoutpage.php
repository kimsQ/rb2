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

$area_arr = explode(',',$area);

$fp = fopen($g['layoutPageVarForSite'],'w');
fwrite($fp, "<?php\n");

foreach ($area_arr as $key ) {
	fwrite($fp, "\$d['layout']['".$key."'] = \"".trim(${$key})."\";\n");
}

fwrite($fp, "?>");
fclose($fp);
@chmod($g['layoutPageVarForSite'],0707);

echo '<script type="text/javascript">';
echo 'parent.$.notify({message: "저장 되었습니다"},{type: "'.$notify_type.'"});';
echo 'parent.$("[data-act=reset]").removeClass("d-none");';
echo 'parent.$("[data-act=submit]").attr("disabled", false);';
echo '</script>';
exit();

?>
