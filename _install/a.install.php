<?php
if(!defined('__KIMS__')) exit;

if ($sitelang)
{
	$_langfile = $g['path_root'].'_install/language/'.$sitelang.'/lang.action.php';
	if (is_file($_langfile)) include $_langfile;
}

$moduledir = array();
$_oldtable = array();
$_tmptable = array();
$_tmpdfile = $g['path_var'].'db.info.php';
$_tmptfile = $g['path_var'].'table.info.php';
include $g['path_core'].'function/sys.func.php';
include $g['path_core'].'function/dir.func.php';
include $g['path_core'].'function/db.mysql.func.php';
$date = getVDate(0);

if (is_file($_tmpdfile)) getLink('./index.php','','','');

$DB_CONNECT = @mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if (!$DB_CONNECT)
{
	echo '<script>parent.isSubmit=false;parent.stepCheck("prev");parent.stepCheck("prev");</script>';
	getLink('','',_LANG('a002','install'),'');
}

$ISRBDB = db_fetch_array(db_query('select count(*) from '.$dbhead.'_s_module',$DB_CONNECT));
if ($ISRBDB[0])
{
	echo '<script>parent.isSubmit=false;parent.stepCheck("prev");parent.stepCheck("prev");</script>';
	getLink('','',_LANG('a004','install'),'');
}

@chmod($g['path_tmp'],0707);
@chmod($g['path_page'],0707);
@chmod($g['path_file'],0707);
@chmod($g['path_var'],0707);

// create empty folder
DirMake($g['path_page']);
DirMake($g['path_file']);
DirMake($g['path_tmp']);
DirMake($g['path_tmp'].'app');
DirMake($g['path_tmp'].'backup');
DirMake($g['path_tmp'].'cache');
DirMake($g['path_tmp'].'cache/HTMLPurifier');
DirMake($g['path_tmp'].'out');
DirMake($g['path_tmp'].'session');
DirMake($g['path_tmp'].'widget');
DirMake($g['path_var'].'menu');
DirMake($g['path_var'].'peak');
DirMake($g['path_var'].'update');
DirMake($g['path_var'].'xml');
DirMake($g['path_var'].'site');
DirMake($g['path_var'].'sitephp');
DirMake($g['path_var'].'bbs');
DirMake($g['path_layout'].'default/_images');
DirMake($g['path_switch'].'top');

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$DB['host'] = '".$dbhost."';\n");
fwrite($fp, "\$DB['name'] = '".$dbname."';\n");
fwrite($fp, "\$DB['user'] = '".$dbuser."';\n");
fwrite($fp, "\$DB['pass'] = '".$dbpass."';\n");
fwrite($fp, "\$DB['head'] = '".$dbhead."';\n");
fwrite($fp, "\$DB['port'] = '".$dbport."';\n");
fwrite($fp, "\$DB['type'] = '".$dbtype."';\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);
$DB['type'] = $dbtype;
$DB['head'] = $dbhead;

if (is_file($_tmptfile))
{
	include_once $_tmptfile;
	$_oldtable = $table;
}

$dirh = opendir($g['path_module']);
while(false !== ($_file = readdir($dirh)))
{
	if($_file == '.' || $_file == '..') continue;

	if(is_file($g['path_module'].$_file.'/_setting/db.table.php'))
	{
		$table = array();
		$module= $_file;
		include $g['path_module'].$_file.'/_setting/db.table.php';
		include $g['path_module'].$_file.'/_setting/db.schema.php';

		foreach($table as $key => $val) $_tmptable[$key] = $val;
		rename($g['path_module'].$_file.'/_setting/db.table.php',$g['path_module'].$_file.'/_setting/db.table.php.done');

		$moduledir[$_file] = array($_file,count($table));
	}
	else {
		$moduledir[$_file] = array($_file,0);
	}
	DirMake($g['path_module'].$_file.'/update');
}
closedir($dirh);

$fp = fopen($_tmptfile,'w');
fwrite($fp, "<?php\n");
foreach($_oldtable as $key => $val)
{
	if (!$_tmptable[$key])
	{
		fwrite($fp, "\$table['$key'] = \"$val\";\n");
	}
}
foreach($_tmptable as $key => $val)
{
	fwrite($fp, "\$table['$key'] = \"$val\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmptfile,0707);

include $_tmptfile;

$gid = 0;
$mdlarray = array('admin','market','module','site','layout','mediaset','domain','device','notification','search','member','post','bbs','comment','tag','popup','dashboard','connect','widget');
foreach($mdlarray as $_val)
{
	$new_modulename = $g['path_module'].$moduledir[$_val][0].'/name.txt';

	$QUE = "insert into ".$table['s_module']."
	(gid,sys,hidden,mobile,name,id,tblnum,icon,d_regis,lang)
	values
	('".$gid."','1','".(strstr('[admin][market][site][member][post][bbs][comment][popup][connect][widget]','['.$_val.']')?0:1)."','1','".($sitelang&&is_file($new_modulename)?implode('',file($new_modulename)):getFolderName($g['path_module'].$moduledir[$_val][0]))."','".$moduledir[$_val][0]."','".$moduledir[$_val][1]."','kf-".($_val=='site'?'home':($_val=='mediaset'?'upload':($_val=='notification'?'notify':($_val=='popup'?'popup':$_val))))."','".$date['totime']."','')";
	db_query($QUE,$DB_CONNECT);
	$gid++;
}

$siteid = $siteid ? $siteid : 'home';
$layout = 'bs4-default/default.php';
$m_layout = 'rc-starter/default.php';

$QKEY = "gid,id,name,label,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
$QVAL = "'0','".$siteid."','$sitename','$sitename','{subject} | {site}','0','','$layout','','$m_layout','','','1','','nic','0','$rewrite','0','0','',''";
getDbInsert($table['s_site'],$QKEY,$QVAL);
db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT);
$S = getDbData($table['s_site'],"id='".$siteid."'",'*');
$LASTUID = $S['uid'];
getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$LASTUID','','','','ALL',''");

mkdir($g['path_page'].$siteid.'-menus',0707);
mkdir($g['path_page'].$siteid.'-pages',0707);
mkdir($g['path_page'].$siteid.'-menus/images',0707);
mkdir($g['path_page'].$siteid.'-pages/images',0707);
mkdir($g['path_var'].'site/'.$siteid,0707);

@chmod($g['path_page'].$siteid.'-menus',0707);
@chmod($g['path_page'].$siteid.'-pages',0707);
@chmod($g['path_page'].$siteid.'-menus/images',0707);
@chmod($g['path_page'].$siteid.'-pages/images',0707);
@chmod($g['path_var'].'site/'.$siteid,0707);

$vfile = $g['path_var'].'sitephp/1.php';
$fp = fopen($vfile,'w');
fwrite($fp, trim(stripslashes($sitephpcode)));
fclose($fp);
@chmod($vfile,0707);

$mfile = $g['path_page'].$siteid.'-menus/_main';
$fp = fopen($mfile.'.css','w');
fwrite($fp,'');
fclose($fp);
@chmod($mfile.'.css',0707);
$fp = fopen($mfile.'.js','w');
fwrite($fp,'');
fclose($fp);
@chmod($mfile.'.js',0707);

$pfile = $g['path_page'].$siteid.'-pages/_main';
$fp = fopen($pfile.'.css','w');
fwrite($fp,'');
fclose($fp);
@chmod($pfile.'.css',0707);
$fp = fopen($pfile.'.js','w');
fwrite($fp,'');
fclose($fp);
@chmod($pfile.'.js',0707);

//매니페스트 파일생성
$manifestfile = $g['path_var'].'site/'.$siteid.'/manifest.json';
$fp = fopen($manifestfile,'w');
$iconsURL = $g['s'].'/_core/images/touch/';
$icons =  array(
					array('src'=>$iconsURL.'homescreen-128x128.png','sizes'=>'128x128','type'=>'image/png'),
					array('src'=>$iconsURL.'homescreen-144x144.png','sizes'=>'144x144','type'=>'image/png'),
					array('src'=>$iconsURL.'homescreen-168x168.png','sizes'=>'168x168','type'=>'image/png'),
					array('src'=>$iconsURL.'homescreen-192x192.png','sizes'=>'192x192','type'=>'image/png'),
					array('src'=>$iconsURL.'homescreen-512x512.png','sizes'=>'512x512','type'=>'image/png')
				);

$mnObj->name = $sitename;
$mnObj->short_name = $sitename;
$mnObj->icons = $icons;
$mnObj->start_url = '/';
$mnObj->display = 'standalone';
$mnObj->background_color = '#221E1F';
$mnObj->theme_color = '#221E1F';
$mnObj->gcm_sender_id = '103953800507';  //FCM 자바스크립트 클라이언트에 공통되는 고정된 값입니다.

$manifestJSON = json_encode($mnObj,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
$_manifestJSON = str_replace("\/", "/", $manifestJSON);
fwrite($fp, $_manifestJSON);
fclose($fp);
@chmod($manifestfile,0707);

$pagesarray = array
(
	'main'=>array('메인','2','1','1','','',''),
	'privacy'=>array('개인정보취급방침','3','0','0','bs4-default/docs.php','rc-starter/blank-drawer.php',''),
	'policy'=>array('이용약관','3','0','0','bs4-default/docs.php','rc-starter/blank-drawer.php',''),
	'cscenter'=>array('고객센터','3','0','0','bs4-default/default.php','rc-starter/blank-drawer.php',''),
	'login'=>array('로그인','1','0','1','bs4-default/blank.php','rc-starter/blank-drawer.php','/?m=member&front=login'),
	'join'=>array('회원가입','1','0','1','bs4-default/blank.php','rc-starter/blank-drawer.php','/?m=member&front=join'),
	'settings'=>array('개인정보수정','1','0','1','bs4-default/default.php','rc-starter/blank-drawer.php','/?m=member&front=settings'),
	'password_reset'=>array('비밀번호찾기','1','0','1','bs4-default/default.php','rc-starter/blank-drawer.php','/?m=member&front=login&page=password_reset'),
	'saved'=>array('저장함','1','0','1','bs4-default/default.php','rc-starter/blank-drawer.php','/?m=member&front=saved'),
	'noti'=>array('알림함','1','0','1','bs4-default/default.php','rc-starter/blank-drawer.php','/?m=member&front=noti'),
	'profile'=>array('프로필','1','0','1','bs4-default/default.php','rc-starter/blank-drawer.php','/?m=member&front=profile'),
	'dashboard'=>array('대시보드','1','0','1','bs4-default/dashboard.php','rc-starter/blank-drawer.php','/?m=member&front=dashboard')
);
foreach($pagesarray as $_key => $_val)
{
	$QUE = "insert into ".$table['s_page']."
	(site,pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,m_layout,joint,hit,d_regis,d_last,upload,featured_img)
	values
	('$LASTUID','$_val[1]','$_val[2]','$_val[3]','$_key','"._LANG('a007','install')."','$_val[0]','','0','$_val[4]','$_val[5]','$_val[6]','0','".$date['totime']."','','0','')";
	db_query($QUE,$DB_CONNECT);
	$lastpage = getDbCnt($table['s_page'],'max(uid)','');
	getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$lastpage','$title','$keywords','$description','ALL',''");
	$mfile = $g['path_page'].$siteid.'-pages/'.$_key.'.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,$_val[0]);
	fclose($fp);
	@chmod($mfile,0707);
	$mfile = $g['path_page'].$siteid.'-pages/'.$_key.'.widget.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile,0707);
}

db_query("insert into ".$table['s_mbrid']." (site,id,pw)values('1','".$id."','".getCrypt($pw1,$date['totime'])."')",$DB_CONNECT);
$my['super'] = 1;
$my['admin'] = 1;
$nick = $nick ? $nick : _LANG('a008','install');
$sex = $sex ? $sex : 0;
$cellphone = $tel_1 && $tel_2 && $tel_3 ? $tel_1.'-'.$tel_2.'-'.$tel_3 : '';
$birth1 = $birth_1 ? $birth_1 : 0;
$birth2 = $birth_2 && $birth_3 ? $birth_2.$birth_3 : 0;

$QUE = "insert into ".$table['s_mbrdata']."
(memberuid,site,auth,mygroup,level,comp,super,admin,adm_view,
email,name,nic,grade,photo,cover,home,sex,birth1,birth2,birthtype,phone,tel,
job,marr1,marr2,sms,mailing,smail,point,usepoint,money,cash,num_login,bio,now_log,last_log,last_pw,is_paper,d_regis,tmpcode,sns,noticeconf,num_notice,addfield)
values
('1','1','1','1','1','0','".$my['super']."','".$my['admin']."','',
'".$email."','".$name."','".$nick."','','','','','".$sex."','".$birth1."','".$birth2."','".$birthtype."','".$cellphone."','',
'','0','0','1','1','0','0','0','0','0','1','','1','".$date['totime']."','".$date['today']."','0','".$date['totime']."','','','','0','')";
db_query($QUE,$DB_CONNECT);

$QUE = "insert into ".$table['s_mbremail']."
(mbruid,email,base,backup,d_regis,d_code,d_verified)
values
('1','".$email."','1','0','".$date['totime']."','','".$date['totime']."')";
db_query($QUE,$DB_CONNECT);


$groupset = array('A','B','C','D','E','F','G','H');
$i = 0;
foreach ($groupset as $_val)
{
	getDbInsert($table['s_mbrgroup'],'gid,name,num',"'".$i."','"._LANG('a010','install').$_val."','".(!$i?1:0)."'");
	$i++;
}
for ($i = 1; $i < 101; $i++) getDbInsert($table['s_mbrlevel'],'gid,name,num,login,post,comment',"'".($i==20?1:0)."','"._LANG('a011','install').$i."','".($i==1?1:0)."','0','0','0'");

$_tmpdfile = $g['path_module'].'admin/var/var.system.php';
include $_tmpdfile;
if ($d['admin']['syslang'] != $sitelang)
{
	$d['admin']['syslang'] = $sitelang;
	$fp = fopen($_tmpdfile,'w');
	fwrite($fp, "<?php\n");
	foreach ($d['admin'] as $key => $val)
	{
		fwrite($fp, "\$d['admin']['".$key."'] = \"".addslashes(stripslashes($val))."\";\n");
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_tmpdfile,0707);
}

//레이아웃 설정파일 생성
$layoutset = array('bs4-default','rc-starter');
foreach ($layoutset as $_val) {

	if ($_val=='rc-starter') {
		$_layout = explode('/', $m_layout);
		$layout_header_search = "true";
		$layout_header_noti = "true";
		$layout_main_type = 'postAllFeed';
	} else {
		$_layout = explode('/', $layout);
		$layout_main_dashboard = "false";
		$layout_header_type = "type1";
		$layout_header_menu = "dropdown-hover";
		$layout_header_menu_limit = "3";
		$layout_header_search = "button";
		$layout_header_allcat = "false";
		$layout_header_login  = "true";
		$layout_header_container = "container";
	  $layout_home_container = "container";
	  $layout_default_container = "container";
		$layout_default_titlebar = "false";
	  $layout_sidebar_container = "container";
		$layout_sidebar_titlebar = "false";
	  $layout_docs_container = "container";
	  $layout_footer_container = "container";
		$layout_footer_type = "type1";
	}

	$layout_header_title = $sitename;

	$g['layoutVarForSite'] = $g['path_var'].'site/'.$siteid.'/layout.'.$_val.'.var.php';
	include $g['path_layout'].$_layout[0].'/_var/_var.config.php';

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
}

setcookie('svshop', $id.'|'.$pw1, time()+60*60*24*30, '/');
$_SESSION['mbr_uid'] = 1;
$_SESSION['mbr_pw']  = getCrypt($pw1,$date['totime']);

DirDelete('./_install');

shell_exec('git init');
shell_exec('git remote add origin https://github.com/kimsQ/rb2.git');

// putNotice(1,'admin',0,sprintf(_LANG('a012','install'),$name,$name),'','');
getLink('./index.php?r='.$siteid.'&iframe=Y&system=guide.install','parent.','','');
?>
