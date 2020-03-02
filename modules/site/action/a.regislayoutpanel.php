<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$device = $_POST['device'];

$_HS = getDbData($table['s_site'],"id='".$r."'",'*');

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$layout = dirname($_HS['m_layout']);
	$device = 'mobile';
} else {
  $layout = dirname($_HS['layout']);
	$device = 'desktop';
}

$g['layoutVarForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.var.php';
$_tmpdfile = is_file($g['layoutVarForSite']) ? $g['layoutVarForSite'] : $g['path_layout'].$layout.'/_var/_var.php';
include $themelang2 ? $themelang2 : $themelang1;
include $_tmpdfile;

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
				$fileName	= $_key.'_'.$_v[0].'.'.$fileExt;
				$saveFile	= $g['path_var'].'site/'.$r.'/'.$fileName;
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
					unlink( $g['path_var'].'site/'.$r.'/'.$fileName);
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
setrawcookie('site_common_result', rawurlencode('변경 되었습니다.'));  // 알림처리를 위한 로그인 상태 cookie 저장
getLink('reload','parent.frames._ADMPNL_.','','');
?>
