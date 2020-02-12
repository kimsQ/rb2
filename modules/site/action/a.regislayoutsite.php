<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_HS = getDbData($table['s_site'],"id='".$r."'",'*');

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$layout = dirname($_HS['m_layout']);
	$device = 'mobile';
} else {
  $layout = dirname($_HS['layout']);
	$device = 'desktop';
}

//사이트별 레이아웃 설정 변수
$g['layoutVarForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.var.php';
include $g['path_layout'].$layout.'/_var/_var.config.php';

$fp = fopen($g['layoutVarForSite'],'w');
fwrite($fp, "<?php\n");

foreach($d['layout']['dom'] as $_key => $_val)
{
	if(!count($_val[2])) continue;
	foreach($_val[2] as $_v)
	{
		if($_v[1] == 'checkbox')
		{
			foreach(${'layout_'.$_key.'_'.$_v[0].'_chk'} as $_chk)
			{
				${'layout_'.$_key.'_'.$_v[0]} .= $_chk.',';
			}

			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".trim(${'layout_'.$_key.'_'.$_v[0]})."\";\n");
			${'layout_'.$_key.'_'.$_v[0]} = '';
		}
		else if ($_v[1] == 'textarea')
		{
			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".htmlspecialchars(str_replace('$','',trim(${'layout_'.$_key.'_'.$_v[0]})))."\";\n");
		}
		else if ($_v[1] == 'file')
		{

			$tmpname	= $_FILES['layout_'.$_key.'_'.$_v[0]]['tmp_name'];
			if (is_uploaded_file($tmpname))
			{
				$realname	= $_FILES['layout_'.$_key.'_'.$_v[0]]['name'];
				$fileExt	= strtolower(getExt($realname));
				$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
				$fileName	= $r.'_'.$_key.'_'.$_v[0].'.'.$fileExt;
				$saveFile	= $g['path_layout'].$layout.'/_var/'.$fileName;
				if (!strstr('[gif][jpg][png][swf]',$fileExt))
				{
					continue;
				}

				move_uploaded_file($tmpname,$saveFile);
				@chmod($saveFile,0707);
			}
			else {
				$fileName	= $d['layout'][$_key.'_'.$_v[0]];
				if ($fileName && ${'layout_'.$_key.'_'.$_v[0].'_del'})
				{
					unlink( $g['path_layout'].$layout.'/_var/'.$fileName);
					$fileName = '';
				}
			}
			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".$fileName."\";\n");
		}
		else {
			fwrite($fp, "\$d['layout']['".$_key.'_'.$_v[0]."'] = \"".htmlspecialchars(str_replace('$','',trim(${'layout_'.$_key.'_'.$_v[0]})))."\";\n");
		}
	}
}


fwrite($fp, "?>");
fclose($fp);
@chmod($g['layoutVarForSite'],0707);

if ($send_mod=='ajax') {

	echo '<script type="text/javascript">';
	echo 'parent.$.notify({message: "저장 되었습니다"},{type: "default"});';
	echo 'parent.$("[data-act=submit]").attr("disabled", false);';
	echo '</script>';
	exit();

} else {

	setrawcookie('site_common_result', rawurlencode('저장 되었습니다|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}

?>
