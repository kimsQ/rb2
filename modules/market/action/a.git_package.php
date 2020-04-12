<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result=array();
$result['error']=false;

$ACT_CM = 1; //메뉴생성
$ACT_CP = 1; //페이지 생성
$ACT_CBBS = 1; //게시판 생성

include $g['path_module'].$m.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];

if ($d['market']['url']) {
	include $g['path_core'].'function/rss.func.php';


	$packageData = getUrlData($d['market']['url'].'&iframe=Y&page=client.check_package&_clientu='.$g['s'].'&_clientr='.$r.'&package='.$package.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'].'&ip='.$_SERVER['REMOTE_ADDR'],10);

	$_installData = explode('[PACK:',$packageData);
	$_installData = explode(':PACK]',$_installData[1]);
	$_installData = $_installData[0];

	$_extData = explode('[LIST:',$packageData);
	$_extData = explode(':LIST]',$_extData[1]);
	$_extData = $_extData[0];
	$_extarr = getArrayString($_extData);

	$list;
	foreach ($_extarr['data'] as $_val) {

		$extData =explode(',' , $_val);
		$path    = $extData[0];
		$folder  = $extData[1];
		$name    = $extData[2];
		$owner   = $extData[3];
		$token   = $extData[4];

		if ($token) {
			$git = 'https://'.$token.'@github.com/'.$owner.'/'.$name.'.git';
		} else {
			$git = 'https://github.com/'.$owner.'/'.$name.'.git';
		}

		$command	= 'cd '.$path.' && git clone '.$git.' '.$folder;

		exec($command,$command_output,$command_return);

		if ($command_return != 0) {
			$result['error']=$command.'실패 했습니다.';
		}

		// 모듈일 경우 DB테이블 생성
		if ($path=='modules') {

			$module		= $folder;
			$_tmptable2 = $table;
			$table		= array();
			$table_db	= $g['path_module'].$module.'/_setting/db.table.php';
			$table_sc	= $g['path_module'].$module.'/_setting/db.schema.php';
			if(is_file($table_db)) {
				$_tmptable1 = array();
				$_tmptfile  = $g['path_var'].'table.info.php';
				include $table_db;
				include $table_sc;

				$_tmptable1 = $table;
				rename($table_db,$table_db.'.done');

				$fp = fopen($_tmptfile,'w');
				fwrite($fp, "<?php\n");
				foreach($_tmptable2 as $key => $val) fwrite($fp, "\$table['$key'] = \"$val\";\n");
				foreach($_tmptable1 as $key => $val) fwrite($fp, "\$table['$key'] = \"$val\";\n");
				fwrite($fp, "?>");
				fclose($fp);
				@chmod($_tmptfile,0707);
			}
			else {
				if(is_file($table_db.'.done')) include $table_db.'.done';
			}

			$maxgid = getDbCnt($_tmptable2['s_module'],'max(gid)','');

			$QKEY = "gid,system,hidden,mobile,name,id,tblnum,icon,d_regis";
			$QVAL = "'".($maxgid+1)."','0','0','1','".getFolderName($g['path_module'].$module)."','$module','".count($table)."','kf-module','".$date['totime']."'";

			getDbInsert($_tmptable2['s_module'],$QKEY,$QVAL);
		}

	}

	if ($_installData) {
		$insData =explode(',' , $_installData);
		$_name    = $insData[0];
		$_owner   = $insData[1];
		$_token   = $insData[2];

		if ($_token) {
			$_git = 'https://'.$_token.'@github.com/'.$_owner.'/'.$_name.'.git';
		} else {
			$_git = 'https://github.com/'.$_owner.'/'.$_name.'.git';
		}

		$_path = $g['path_tmp'].'app';
		$package_folder = 'package-'.$date['totime'];
		$_command	= 'cd '.$_path.' && git clone '.$_git.' '.$package_folder;

		exec($_command,$_command_output,$_command_return);

		if ($_command_return != 0) {
			$result['error']=$_command.'실패 했습니다.';
		}

	}

} else {
	$result['error']='마켓 접속정보를 확인해주세요.';
	echo json_encode($result);
	exit;
}

require $g['path_core'].'function/dir.func.php';
include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.php';

if($siteuid) {
	$S = getUidData($table['s_site'],$siteuid);
	getDbUpdate($table['s_site'],"layout='".$d['package']['layout']."',m_layout='".$d['package']['layout_mobile']."',rewrite='".$d['package']['rewrite']."'",'uid='.$S['uid']);

	//기존메뉴삭제
	if ($ACT_DM) {
		$_MENUS = getDbSelect($table['s_menu'],'site='.$S['uid'].' order by gid asc','*');
		while($_M = db_fetch_array($_MENUS)) {
			@unlink($g['path_var'].'menu/'.$_M['imghead']);
			@unlink($g['path_var'].'menu/'.$_M['imgfoot']);

			getDbDelete($table['s_seo'],'rel=1 and parent='.$_M['uid']);
		}

		getDbDelete($table['s_menu'],'site='.$S['uid']);
		db_query("OPTIMIZE TABLE ".$table['s_menu'],$DB_CONNECT);
		db_query("OPTIMIZE TABLE ".$table['s_seo'],$DB_CONNECT);
		DirDelete($g['path_page'].$S['id'].'-menus');
	}
	//기존페이지삭제
	if ($ACT_DP) {
		$_PAGES = getDbSelect($table['s_page'],'site='.$S['uid'].' order by uid asc','*');
		while($_P = db_fetch_array($_PAGES)) {
			getDbDelete($table['s_seo'],'rel=2 and parent='.$_P['uid']);
		}

		getDbDelete($table['s_page'],'site='.$S['uid']);
		db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT);
		db_query("OPTIMIZE TABLE ".$table['s_seo'],$DB_CONNECT);
		DirDelete($g['path_page'].$S['id'].'-pages');
	}

	@rename($g['path_tmp'].'app/'.$package_folder.'/pages/'.$d['package']['siteid'].'-menus',$g['path_tmp'].'app/'.$package_folder.'/pages/'.$S['id'].'-menus');
	@rename($g['path_tmp'].'app/'.$package_folder.'/pages/'.$d['package']['siteid'].'-pages',$g['path_tmp'].'app/'.$package_folder.'/pages/'.$S['id'].'-pages');
	@rename($g['path_tmp'].'app/'.$package_folder.'/_var/site/'.$d['package']['siteid'],$g['path_tmp'].'app/'.$package_folder.'/_var/site/'.$S['id']);
}
else {

	$MAXC = getDbCnt($table['s_site'],'max(gid)','');
	$gid = $MAXC + 1;

	$name = 'SITE '.$gid;
	$label = 'SITE '.$gid;
	$id = 's'.date('His');

	$QKEY = "gid,id,name,label,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
	$QVAL = "'".$gid."','".$id."','".$name."','".$label."','{subject} | {site}','0','fa fa-home','".$d['package']['layout']."','0','".$d['package']['layout_mobile']."','0','','1','','nic','0','".$d['package']['rewrite']."','0','1','',''";
	getDbInsert($table['s_site'],$QKEY,$QVAL);
	$LASTUID = getDbCnt($table['s_site'],'max(uid)','');
	db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT);
	getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$LASTUID','','','','ALL',''");

	$vfile = $g['path_var'].'sitephp/'.$LASTUID.'.php';
	$fp = fopen($vfile,'w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($vfile,0707);

	mkdir($g['path_var'].'site/'.$id,0707);
	@chmod($g['path_var'].'site/'.$id,0707);

	@rename($g['path_tmp'].'app/'.$package_folder.'/pages/'.$d['package']['siteid'].'-menus',$g['path_tmp'].'app/'.$package_folder.'/pages/'.$id.'-menus');
	@rename($g['path_tmp'].'app/'.$package_folder.'/pages/'.$d['package']['siteid'].'-pages',$g['path_tmp'].'app/'.$package_folder.'/pages/'.$id.'-pages');
	@rename($g['path_tmp'].'app/'.$package_folder.'/_var/site/'.$d['package']['siteid'],$g['path_tmp'].'app/'.$package_folder.'/_var/site/'.$id);

	$S = getUidData($table['s_site'],$LASTUID);
}

//메뉴생성
if ($ACT_CM) {
	include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.menu.php';
	$QKEY = "gid,site,is_child,parent,depth,id,menutype,mobile,hidden,reject,name,target,redirect,joint,perm_g,perm_l,layout,m_layout,imghead,imgfoot,addattr,num,d_last,addinfo,upload";
	foreach($d['package']['menus'] as $R)
	{
		$_parent = 0;
		if ($R['parent'])
		{
			$_PRTUID = getDbData($table['s_menu'],'site='.$S['uid']." and id='".$R['parent']."'",'uid');
			$_parent = $_PRTUID['uid'];
		}

		$QVAL = "'".$R['gid']."','".$S['uid']."','".$R['is_child']."','".$_parent."','".$R['depth']."','".$R['id']."','".$R['menutype']."','".$R['mobile']."','".$R['hidden']."','0','".$R['name']."','".$R['target']."','".$R['redirect']."','".$R['joint']."','','0','".$R['layout']."','".$R['m_layout']."','".$R['imghead']."','".$R['imgfoot']."','".$R['addattr']."','0','','".$R['addinfo']."','".$R['upload']."'";
		getDbInsert($table['s_menu'],$QKEY,$QVAL);
		$lastmenu = getDbCnt($table['s_menu'],'max(uid)','');
		getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'1','$lastmenu','','','','ALL',''");
	}
}
//페이지생성
if ($ACT_CP) {
	include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.page.php';
	$QKEY = "site,pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,m_layout,joint,hit,linkedmenu,d_regis,d_last,upload,featured_img,member,extra";
	foreach($d['package']['pages'] as $R)
	{
		if (is_file($g['path_page'].$S['id'].'-pages/'.$R['id'].'.php')) continue;
		$QVAL = "'".$S['uid']."','".$R['pagetype']."','".$R['ismain']."','".$R['mobile']."','".$R['id']."','".$R['category']."','".$R['name']."','','0','".$R['layout']."','".$R['m_layout']."','".$R['joint']."','0','".$R['linkedmenu']."','".$date['totime']."','".$date['totime']."','".$R['upload']."','".$R['featured_img']."','1',''";
		getDbInsert($table['s_page'],$QKEY,$QVAL);
		$lastpage = getDbCnt($table['s_page'],'max(uid)','');
		getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$lastpage','','','','ALL',''");
	}
}

//메인페이지 지정
$MP = getDbData($table['s_page'],"ismain=1 and site=".$S['uid'],'uid');
getDbUpdate($table['s_site'],"startpage='".$MP['uid']."',m_startpage=''",'uid='.$S['uid']);

//플러그인설치
if (is_dir($g['path_tmp'].'app/'.$package_folder.'/plugins')) {
	$dirh = opendir($g['path_tmp'].'app/'.$package_folder.'/plugins');
	while(false !== ($filename = readdir($dirh)))
	{
		if($filename == '.' || $filename == '..') continue;
		if (is_dir($g['path_plugin'].$filename)) continue;

		if (!$d['ov'][$filename])
		{
			$plVersion = '';
			$dirh1 = opendir($g['path_tmp'].'app/'.$package_folder.'/plugins/'.$filename);
			while(false !== ($filename1 = readdir($dirh1)))
			{
				if($filename1 == '.' || $filename1 == '..' || is_file($g['path_tmp'].'app/'.$package_folder.'/plugins/'.$filename.'/'.$filename1)) continue;
				if(is_dir($g['path_plugin'].$filename.'/'.$filename1)) continue;
				$plVersion = $filename1;
			}
			closedir($dirh1);

			$_tmpdfile = $g['path_var'].'plugin.var.php';
			$fp = fopen($_tmpdfile,'w');
			fwrite($fp, "<?php\n");
			foreach ($d['ov'] as $_key_ => $_val_)
			{
				fwrite($fp, "\$d['ov']['".$_key_."'] = '".trim($_val_)."';\n");
			}
			fwrite($fp, "\$d['ov']['".$filename."'] = '".$plVersion."';\n");
			fwrite($fp, "?>");
			fclose($fp);
			@chmod($_tmpdfile,0707);
		}
	}
	closedir($dirh);
}

//스위치설치
$_switchset = array('start','top','head','foot','end');
$newSwitches = array();
foreach ($_switchset as $_key) {
	if (is_dir($g['path_tmp'].'app/'.$package_folder.'/switches/'.$_key)) {
		$dirh1 = opendir($g['path_tmp'].'app/'.$package_folder.'/switches/'.$_key);
		while(false !== ($filename1 = readdir($dirh1))) {
			if($filename1 == '.' || $filename1 == '..') continue;
			if(is_dir($g['path_switch'].$_key.'/'.$filename1)) continue;
			$newSwitches[] = array($_key,$filename1);
		}
		closedir($dirh1);
	}
}

if (count($newSwitches)) {
	$_ufile = $g['path_var'].'switch.var.php';
	$fp = fopen($_ufile,'w');
	fwrite($fp, "<?php\n");
	foreach ($_switchset as $_key) {
		foreach ($d['switch'][$_key] as $name => $sites) {
			fwrite($fp, "\$d['switch']['".$_key."']['".$name."'] = \"".$sites."\";\n");
		}
	}
	foreach($newSwitches as $_val) {
		fwrite($fp, "\$d['switch']['".$_val[0]."']['".$_val[1]."'] = \"\";\n");
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_ufile,0707);
}

//게시판 생성
if ($ACT_CBBS) {
	include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.bbs.php';
	$QKEY = "gid,site,id,name,category,num_r,d_last,d_regis,imghead,imgfoot,puthead,putfoot,addinfo,writecode";
	foreach($d['package']['bbs'] as $R)
	{
		$maxgid = getDbCnt($table['bbslist'],'max(gid)','');
		$QVAL = "'".($maxgid+1)."','".$S['uid']."','".$R['id']."','".$R['name']."','".$R['category']."','".$R['num_r']."','".$date['totime']."','".$date['totime']."','".$R['imghead']."','".$R['imgfoot']."','".$R['puthead']."','".$R['putfoot']."','".$R['addinfo']."','".$R['writecode']."'";
		getDbInsert($table['bbslist'],$QKEY,$QVAL);
	}
}

//추가 실행
if (is_file($g['path_tmp'].'app/'.$package_folder.'/_settings/run.php')) {
	include $g['path_tmp'].'app/'.$package_folder.'/_settings/run.php';
}

DirDelete($g['path_tmp'].'app/'.$package_folder.'/.git');
DirDelete($g['path_tmp'].'app/'.$package_folder.'/_settings');
$extPath = $g['path_tmp'].'app';
$extPath1= $extPath.'/'.$package_folder.'/';
$tgFolder= './';
DirCopy($extPath1,$tgFolder);
DirDelete($extPath);
mkdir($extPath,0707);
@chmod($extPath,0707);

//getLink($g['s'].'/?r='.$r.'&iframe=Y&m=admin&module='.$m.'&front=modal.package&package_step=3&siteid='.$S['id'].'&site_name='.urlencode($S['name']).'&package_name='.urlencode($d['package']['name']),'parent.','','');
$result['error']='패키지가 설치되었습니다.';
echo json_encode($result);
exit;
?>
