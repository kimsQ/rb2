<?php
if(!defined('__KIMS__')) exit;
if ($system)
{
	if (strpos('[popup.joint][popup.widget]',$system))
	{
		if (!$my['admin'])
		{
			$system = 'nopage';
		}
	}
	$g['dir_module_skin'] = $g['dir_module'].'pages/';
	$g['url_module_skin'] = $g['url_module'].'/pages';
	$g['img_module_skin'] = $g['url_module_skin'].'/images';
	$g['dir_module_mode'] = $g['dir_module_skin'].$system;
	$g['url_module_mode'] = $g['url_module_skin'].'/'.$system;
	$g['main'] = $g['dir_module_mode'].'.php';
}
else
{
	$_SEO_SITE = getDbData($table['s_seo'],'rel=0 and parent='.$_HS['uid'],'*');

	if ($_HM['uid'])
	{
		if (!$my['admin'])
		{
			if ($_HM['perm_l'] > $my['level'] || strpos('_'.$_HM['perm_g'],'['.$my['sosok'].']'))
			{
				getLink($g['s'].'/?r='.$r.'&system=guide.perm&_menu='.$_HM['uid'],'','','');
			}
		}
		if($_HM['menutype'] == 1)
		{
			if($m == $g['sys_module'])
			{
				if (!$mod) $_HP = getUidData($table['s_page'],$_HS['startpage']);
				else $_HP = getDbData($table['s_page'],"id='".$mod."'",'*');
				if($_HP['uid']) $_HM['layout'] = $_HP['layout'];
			}
			else {
				getLink($g['s'].'/?r='.$r,'','','');
			}
		}
		else
		{
			$g['dir_module_skin'] = $g['path_page'].$r.'-menus/';
			$g['url_module_skin'] = $g['s'].'/pages/'.$r.'-menus';
			$g['img_module_skin'] = $g['url_module_skin'].'/images';
			$g['dir_module_mode'] = $g['dir_module_skin'].$_HM['id'];
			$g['url_module_mode'] = $g['url_module_skin'].'/'.$_HM['id'];
			$g['main'] = $g['path_page'].$r.'-menus/'.$_HM['id'].'.php';
			if ($g['device'])
			{
				if (is_file($g['path_page'].$r.'-menus/'.$_HM['id'].'.mobile.php'))
				{
					$g['main'] = $g['path_page'].$r.'-menus/'.$_HM['id'].'.mobile.php';
				}
			}
			$d['page']['cctime'] = $g['path_page'].$r.'-menus/'.$_HM['id'].'.txt';
			$d['page']['source'] = $g['main'];
		}
		$_SEO = getDbData($table['s_seo'],'rel=1 and parent='.$_HM['uid'],'*');
		if ($_SEO['uid'])
		{
			$g['meta_tit'] = $_SEO['title'];
			$g['meta_key'] = $_SEO['keywords'];
			$g['meta_des'] = $_SEO['description'];
			$g['meta_bot'] = $_SEO['classification'];
			if ($_SEO['image_src']) $g['meta_img'] =  getMetaImage($_SEO['image_src']);
			else $g['meta_img'] = $_SEO_SITE['image_src']?getMetaImage($_SEO_SITE['image_src']):$g['img_core'].'/noimage_kimsq.png';
		}
		else {
			$g['meta_tit']   = $_HM['name'];
		}
	}
	if ($_HP['uid'])
	{
		if (!$my['admin'])
		{
			if ($_HP['perm_l'] > $my['level'] || strpos('_'.$_HP['perm_g'],'['.$my['sosok'].']'))
			{
				getLink($g['s'].'/?r='.$r.'&system=guide.perm&_page='.$_HP['uid'],'','','');
			}
		}
		if ($_HP['pagetype'] == 1)
		{
			getLink($g['s'].'/?r='.$r,'','','');
		}
		else
		{
			$_HM['layout'] = $_HP['layout'];
			$_HM['m_layout'] = $_HP['m_layout']?$_HP['m_layout']:$_HP['layout'];
			$g['dir_module_skin'] = $g['path_page'].$r.'-pages/';
			$g['url_module_skin'] = $g['s'].'/pages/'.$r.'-pages';
			$g['img_module_skin'] = $g['url_module_skin'].'/images';
			$g['dir_module_mode'] = $g['dir_module_skin'].$_HP['id'];
			$g['url_module_mode'] = $g['url_module_skin'].'/'.$_HP['id'];
			$g['main'] = $g['path_page'].$r.'-pages/'.$_HP['id'].'.php';
			if ($g['device'])
			{
				if (is_file($g['path_page'].$r.'-pages/'.$_HP['id'].'.mobile.php'))
				{
					$g['main'] = $g['path_page'].$r.'-pages/'.$_HP['id'].'.mobile.php';
				}
			}
			$d['page']['cctime'] = $g['path_page'].$r.'-pages/'.$_HP['id'].'.txt';
			$d['page']['source'] = $g['main'];
		}
		if($_HP['linkedmenu'])
		{
			$_CA = explode('/',$_HP['linkedmenu']);
			$g['location'] = '<a href="'.RW(0).'">HOME</a>';
			$_tmp['count'] = count($_CA);
			$_tmp['split_id'] = '';
			for ($_i = 0; $_i < $_tmp['count']; $_i++)
			{
				$_tmp['location'] = getDbData($table['s_menu'],"id='".$_CA[$_i]."'",'*');
				$_tmp['split_id'].= ($_i?'/':'').$_tmp['location']['id'];
				$g['location']   .= ' &gt; <a href="'.RW('c='.$_tmp['split_id']).'">'.$_tmp['location']['name'].'</a>';
			}
			$g['location'] .= ' &gt; <a href="'.RW('mod='.$_HP['id']).'">'.$_HP['name'].'</a>';
		}
		$_SEO = getDbData($table['s_seo'],'rel=2 and parent='.$_HP['uid'],'*');
		if ($_SEO['uid']) {
			if ($_HP['ismain']) {
				$g['meta_tit'] = $_SEO['title']?$_SEO['title']:$_SEO_SITE['title'];
				$g['meta_key'] = $_SEO['keywords']?$_SEO['keywords']:$_SEO_SITE['keywords'];
				$g['meta_des'] = $_SEO['description']?$_SEO['description']:$_SEO_SITE['description'];
				$g['meta_bot'] = $_SEO['classification']?$_SEO['classification']:$_SEO_SITE['classification'];
			} else {
				$g['meta_tit'] = $_SEO['title'];
				$g['meta_key'] = $_SEO['keywords'];
				$g['meta_des'] = $_SEO['description'];
				$g['meta_bot'] = $_SEO['classification'];
			}
			if ($_SEO['image_src']) $g['meta_img'] =  getMetaImage($_SEO['image_src']);
			else $g['meta_img'] = $_SEO_SITE['image_src']?getMetaImage($_SEO_SITE['image_src']):$g['img_core'].'/noimage_kimsq.png';
		} else {
			$g['meta_tit']   = $_HP['name'];
			$g['meta_key']   = $_HP['name'].','.$_HP['name'];
		}
	}
	if(!is_file($g['main']))
	{
		if ($_HM['uid'])
		{
			getLink($g['s'].'/?r='.$r,'','','');
		}
		else {
			if ($g['device'])
			{
				if ($_HS['m_startpage'])
				{
					getLink($g['s'].'/?r='.$r,'','','');
				}
				else {
					$d['site_layout'] = dirname($_HS['m_layout']?$_HS['m_layout']:$_HS['layout']);
					$g['dir_module_mode'] = $g['path_layout'].$d['site_layout'].'/_pages/main';
					$g['url_module_mode'] = $g['s'].'/layouts/'.$d['site_layout'].'/_pages/main';
					$g['main'] = $g['path_layout'].$d['site_layout'].'/_pages/main.php';
				}
			}
			else {
				if ($_HS['startpage'])
				{
					getLink($g['s'].'/?r='.$r,'','','');
				}
				else {
					$d['site_layout'] = dirname($_HS['layout']);
					$g['dir_module_mode'] = $g['path_layout'].$d['site_layout'].'/_pages/main';
					$g['url_module_mode'] = $g['s'].'/layouts/'.$d['site_layout'].'/_pages/main';
					$g['main'] = $g['path_layout'].$d['site_layout'].'/_pages/main.php';
				}
			}
		}
	}
}
?>
