<?php
if(!defined('__KIMS__')) exit;

if (is_file($g['main']))
{
	if (!$system)
	{
		if(!$g['mobile'] || $_SESSION['pcmode']=='Y')
		{
			if (!$g['head']['cod'])
			{
				$g['codhead'] = $g['path_page'].$r.'-menus/'.$_HM['id'].'.header.php';
				if(is_file($g['codhead'])) include $g['codhead'];
			}
			if ($_HM['imghead'])
			{
				if (strstr($_HM['imghead'],'swf')) echo '<div><embed id="swf_menu_header" src="'.$g['s'].'/_var/menu/'.$_HM['imghead'].'"></embed></div>';
				else echo '<div><img id="img_menu_header" src="'.$g['s'].'/_var/menu/'.$_HM['imghead'].'" alt="" /></div>';
			}
		}

		$d['cachetime'] = file_exists($d['page']['cctime']) ? implode('',file($d['page']['cctime'])) : 0;

		if ($d['cachetime'] && substr($d['page']['source'],0,8)=='./pages/')
		{
			$g['cache'] = str_replace('.php','.cache',$d['page']['source']);
			$g['recache'] = true;
			if(file_exists($g['cache']))
			{
				if(mktime() - filemtime($g['cache']) > $d['cachetime'] * 60) unlink($g['cache']);
				else
				{
					readfile($g['cache']);
					$g['recache'] = false;
				}
			}
			if ($g['recache'])
			{
				ob_start();

				include $g['main'];

				$g['buffer'] = ob_get_contents();
				ob_end_clean();
				echo $g['buffer'];

				$fp = fopen($g['cache'],'w');
				fwrite($fp,$g['buffer']);
				fclose($fp);
				@chmod($g['cache'],0707);
			}
		}
		else {
			include $g['main'];
		}

		if(!$g['mobile'] || $_SESSION['pcmode']=='Y')
		{
			if ($_HM['imgfoot'])
			{
				if (strstr($_HM['imgfoot'],'swf')) echo '<div><embed id="swf_menu_footer" src="'.$g['s'].'/_var/menu/'.$_HM['imgfoot'].'"></embed></div>';
				else echo '<div><img id="img_menu_footer" src="'.$g['s'].'/_var/menu/'.$_HM['imgfoot'].'" alt="" /></div>';
			}
			if (!$g['foot']['cod'])
			{
				$g['codfoot'] = $g['path_page'].$r.'-menus/'.$_HM['id'].'.footer.php';
				if(is_file($g['codfoot'])) include $g['codfoot'];
			}
		}
	}
	else {
		include $g['main'];
	}
}
else
{
	getLink($g['s'].'/?r='.$r,'','','');
}
?>
