<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$act = $act ? $act : 'package_upload';


if ($act == 'package_upload')
{
	if ($remote == 'Y')
	{
		$saveFile = $g['path_tmp'].'app/rb_package_app.zip';

		require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
		require $g['path_core'].'function/dir.func.php';
			
		$extractor = new ArchiveExtractor();
		$extractor -> extractArchive($saveFile,'./');
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=pack','parent.','패키지가 정상적으로 등록되었습니다.','');
	}
	else {

		$folder		= './';
		$tmpname	= $_FILES['upfile']['tmp_name'];
		$realname	= $_FILES['upfile']['name'];
		$fileExt	= strtolower(getExt($realname));
		$extPath	= $g['path_tmp'].'app';
		$extPath1	= $extPath.'/';
		$saveFile	= $extPath1.$date['totime'].'.zip';

		if (is_uploaded_file($tmpname))
		{
			if (substr($realname,0,11) != 'rb_package_')
			{
				getLink('','','킴스큐용 패키지가 아닙니다.','');
			}
			if ($fileExt != 'zip')
			{
				getLink('','','패키지는 반드시 zip압축 포맷이어야 합니다.','');
			}

			move_uploaded_file($tmpname,$saveFile);

			require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
			require $g['path_core'].'function/dir.func.php';
			
			$extractor = new ArchiveExtractor();
			$extractor -> extractArchive($saveFile,$extPath1);
			unlink($saveFile);
			DirCopy($extPath1,$folder);
			DirDelete($extPath);
			mkdir($extPath,0707);
			@chmod($extPath,0707);
		}
		getLink('reload','parent.','패키지가 정상적으로 등록되었습니다.','');
	}
}
if ($act == 'package_cancel')
{
	require $g['path_core'].'function/dir.func.php';
	DirDelete('./_package');
	getLink('reload','parent.','패키지 적용이 취소되었습니다.','');
}
if ($act == 'package_aply') {

	require $g['path_core'].'function/dir.func.php';

	if ($aply_site == '1')
	{
		$_site = file('./_package/dump_site.dat');
		foreach($_site as $_val)
		{
			if (!trim($_val)) continue;
			$_r = explode("\t",$_val);
			getDbUpdate($table['s_site'],$_r[0]."='".$_r[1]."'",'uid='.$site);
		}
	}
	if ($aply_menu == '1')
	{

		$_MENUS = getDbSelect($table['s_menu'],'site='.$site.' order by gid asc','*');
		while($R=db_fetch_array($_MENUS))
		{
			getDbDelete($table['s_menu'],'uid='.$R['uid']);
			getDbDelete($table['s_seo'],'rel=1 and parent='.$R['uid']);

			$_xfile = $g['path_page'].'menu/'.sprintf('%05d',$R['uid']);

			unlink($_xfile.'.php');
			unlink($_xfile.'.widget.php');
			@unlink($_xfile.'.mobile.php');
			@unlink($_xfile.'.css');
			@unlink($_xfile.'.js');
			@unlink($_xfile.'.header.php');
			@unlink($_xfile.'.footer.php');
			
			@unlink($_xfile.'.txt');
			@unlink($_xfile.'.cache');
			@unlink($_xfile.'.widget.cache');
			@unlink($_xfile.'.mobile.cache');

			@unlink($g['path_var'].'menu/'.$R['imghead']);
			@unlink($g['path_var'].'menu/'.$R['imgfoot']);	
		}

		$_menu = file('./_package/dump_menu.dat');
		$_xarr = array();
		foreach($_menu as $_val)
		{
			if (!trim($_val)) continue;
			$_r = explode("\t",$_val);

			getDbInsert($table['s_menu'],'gid,site,isson,parent,depth,id,menutype,mobile,hidden,reject,name,target,redirect,joint,layout,imghead,imgfoot,puthead,putfoot',"'".$_r[1]."','".$site."','".$_r[2]."','0','".$_r[4]."','".$_r[5]."','".$_r[6]."','".$_r[7]."','".$_r[8]."','".$_r[9]."','".$_r[10]."','".$_r[11]."','".$_r[12]."','".$_r[13]."','".$_r[14]."','".$_r[15]."','".$_r[16]."','".$_r[17]."','".$_r[18]."'");
			$lastmenu = getDbCnt($table['s_menu'],'max(uid)','');
			$_xarr['p'.$_r[0]] = $lastmenu;
			if($_r[3]) 
			{
				getDbUpdate($table['s_menu'],'parent='.$_xarr['p'.$_r[3]],'uid='.$lastmenu);
			}
			else {
				getDbUpdate($table['s_menu'],'parent=0','uid='.$lastmenu);
			}


			$_xfile1 = './_package/rb/pages/menu/'.sprintf('%05d',$_r[0]);
			$_xfile2 = './_package/rb/pages/menu/'.sprintf('%05d',$lastmenu);

			@rename($_xfile1.'.php',$_xfile2.'.php');
			@rename($_xfile1.'.widget.php',$_xfile2.'.widget.php');
			@rename($_xfile1.'.mobile.php',$_xfile2.'.mobile.php');
			@rename($_xfile1.'.css',$_xfile2.'.css');
			@rename($_xfile1.'.js',$_xfile2.'.js');
			@rename($_xfile1.'.header.php',$_xfile2.'.header.php');
			@rename($_xfile1.'.footer.php',$_xfile2.'.footer.php');
		}
	}
	if ($aply_page == '1')
	{
		$_page = file('./_package/dump_page.dat');
		foreach($_page as $_val)
		{
			if (!trim($_val)) continue;
			$_r = explode("\t",$_val);
			$_p = getDbData($table['s_page'],"id='".$_r[3]."'",'uid');
			if ($_p['uid'])
			{
				getDbUpdate($table['s_page'],"pagetype='".$_r[0]."',ismain='".$_r[1]."',mobile='".$_r[2]."',id='".$_r[3]."',category='".$_r[4]."',name='".$_r[5]."',layout='".$_r[6]."',joint='".$_r[7]."',sosokmenu='".$_r[8]."'",'uid='.$_p['uid']);
			}
			else {
				getDbInsert($table['s_page'],'pagetype,ismain,mobile,id,category,name,layout,joint,sosokmenu',"'".$_r[0]."','".$_r[1]."','".$_r[2]."','".$_r[3]."','".$_r[4]."','".$_r[5]."','".$_r[6]."','".$_r[7]."','".$_r[8]."'");
			}
		}
	}

	if ($aply_bbs == '1')
	{
		$maxgid = getDbCnt($table['bbslist'],'max(gid)','');
		$_bbs = file('./_package/dump_bbs.dat');
		foreach($_bbs as $_val)
		{
			if (!trim($_val)) continue;
			$_r = explode("\t",$_val);

			$_p = getDbData($table['bbslist'],"id='".$_r[0]."'",'uid');
			if ($_p['uid']) continue;
			
			$maxgid++;
			getDbInsert($table['bbslist'],'gid,id,name,category,imghead,imgfoot,puthead,putfoot',"'".$maxgid."','".$_r[0]."','".$_r[1]."','".$_r[2]."','".$_r[3]."','".$_r[4]."','".$_r[5]."','".$_r[6]."'");
		}
	}

	DirCopy('./_package/rb','./');
	DirDelete('./_package');

	getLink('reload','parent.','패키지가 적용되었습니다.','');
}
?>