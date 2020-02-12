<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);
$sfile = $g['path_switch'].$switch.'/main.php';
$nfile = $g['path_switch'].$switch.'/name.txt';
$sinfo = explode('/',$switch);
if (is_file($sfile))
{
	$fp = fopen($nfile,'w');
	fwrite($fp,$name);
	fclose($fp);
	$fp = fopen($sfile,'w');
	fwrite($fp,trim(stripslashes($switch_code)));
	fclose($fp);
	@chmod($nfile,0707);
	@chmod($sfile,0707);
	$_newsites = '';
	foreach($aply_sites as $sites) $_newsites.= '['.$sites.']';
	$_ufile = $g['path_var'].'switch.var.php';
	$fp = fopen($_ufile,'w');
	fwrite($fp, "<?php\n");
	foreach ($d['switch'] as $_key => $_val)
	{
		foreach ($d['switch'][$_key] as $_val1 => $_val2)
		{
			if ($switch == $_key.'/'.$_val1)
			{
				fwrite($fp, "\$d['switch']['".$_key."']['".$_val1."'] = \"".$_newsites."\";\n");
			}
			else {
				fwrite($fp, "\$d['switch']['".$_key."']['".$_val1."'] = \"".$d['switch'][$_key][$_val1]."\";\n");
			}
		}
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_ufile,0707);
}
setrawcookie('admin_switch_result', rawurlencode('스위치 설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
