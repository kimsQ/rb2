<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

include_once $g['path_core'].'function/dir.func.php';

if ($type == 'module')
{
	DirDelete($g['path_module'].$pack);
}
if ($type == 'layout')
{
	DirDelete($g['path_layout'].$pack);
}
if ($type == 'widget')
{
	DirDelete($g['path_widget'].str_replace('.','',str_replace('./widgets/','',$pack)));
}
if ($type == 'switch')
{
	DirDelete($g['path_switch'].$pack);
}
if ($type == 'bbstheme')
{
	DirDelete($g['path_module'].'bbs/theme/'.$pack);
}

if ($type == 'widget')
{
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=pack&type=widget','parent.','','');
}
else {
	getLink('reload','parent.','','');
}
?>