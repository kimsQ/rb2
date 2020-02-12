<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$name = trim($name);
$label = trim($label);
$title = trim($title);
$headercode = trim($headercode);
$footercode = trim($footercode);
$meta_title = trim($meta_title);
$meta_keywords = trim($meta_keywords);
$meta_description = trim($meta_description);
$meta_classification = trim($meta_classification);
$meta_image_src = trim($meta_image_src);

if ($site_uid)
{
	$ISID = getDbData($Table['s_site'],"uid<>".$site_uid." and id='".$id."'",'*');
	if ($ISID['uid']) getLink('','','이미 동일한 명칭의 사이트 코드가 존재합니다.','');

	if(strstr(','.$d['admin']['site_cutid'].',',','.$id.',')) {
		getLink('','','사용할 수 없는 사이트 코드 입니다.','');
	}

	if ($iconaction)
	{
		getDbUpdate($table['s_site'],"icon='$icon'",'uid='.$site_uid);
		exit;
	}

	$QVAL = "id='$id',name='$name',label='$label',title='$title',titlefix='$titlefix',icon='$icon',layout='$layout',startpage='$startpage',m_layout='$m_layout',m_startpage='$m_startpage',lang='$sitelang',open='$open',dtd='$dtd',nametype='$nametype',timecal='$timecal',rewrite='$rewrite',buffer='$buffer',usescode='$usescode',headercode='$headercode',footercode='$footercode'";
	getDbUpdate($table['s_site'],$QVAL,'uid='.$site_uid);

	$_SEO = getDbData($table['s_seo'],'uid='.(int)$seouid,'uid');
	if($_SEO['uid']) getDbUpdate($table['s_seo'],"title='$meta_title',keywords='$meta_keywords',description='$meta_description',classification='$meta_classification',image_src='$meta_image_src'",'uid='.$_SEO['uid']);
	else getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$site_uid','$meta_title','$meta_keywords','$meta_description','$meta_classification','$meta_image_src'");

	$vfile = $g['path_var'].'sitephp/'.$site_uid.'.php';
	$fp = fopen($vfile,'w');
	fwrite($fp, trim(stripslashes($sitephpcode)));
	fclose($fp);
	@chmod($vfile,0707);

	if ($r != $id)
	{
		rename($g['path_page'].$r.'-menus',$g['path_page'].$id.'-menus');
		rename($g['path_page'].$r.'-pages',$g['path_page'].$id.'-pages');
		rename($g['path_var'].'site/'.$r,$g['path_var'].'site/'.$id);
	}
	setrawcookie('result_site', rawurlencode('사이트가 등록정보가 변경되었습니다.|success'));  // 처리여부 cookie 저장
	if ($r != $id || $name != $_HS['name'])
	{
		getLink($g['s'].'/?r='.$id.'&pickmodule='.$m.'&panel=Y','parent.parent.','','');
	}
	else {
		if ($iframe=='Y') getLink('reload','parent.parent.','','');
		else getLink('reload','parent.','','');
	}
}
else {

	if (!$id)
	{
		$id = 's'.date('His');
	}
	if (!$title)
	{
		$title = $name;
	}

	$ISID = getDbData($Table['s_site'],"id='".$id."'",'*');
	if ($ISID['uid']) getLink('','','이미 동일한 명칭의 사이트 코드가 존재합니다.','');

	$MAXC = getDbCnt($table['s_site'],'max(gid)','');
	$gid = $MAXC + 1;
	$name = $name?trim($name):trim($label);

	$QKEY = "gid,id,name,label,title,titlefix,icon,layout,startpage,m_layout,m_startpage,lang,open,dtd,nametype,timecal,rewrite,buffer,usescode,headercode,footercode";
	$QVAL = "'$gid','$id','$name','$label','$title','$titlefix','$icon','$layout','$startpage','$m_layout','$m_startpage','$sitelang','$open','$dtd','$nametype','$timecal','$rewrite','$buffer','$usescode','$headercode','$footercode'";
	getDbInsert($table['s_site'],$QKEY,$QVAL);
	$LASTUID = getDbCnt($table['s_site'],'max(uid)','');
	db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT);
	getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'0','$LASTUID','$meta_title','$meta_keywords','$meta_description','$meta_classification','$meta_image_src'");


	$vfile = $g['path_var'].'sitephp/'.$LASTUID.'.php';
	$fp = fopen($vfile,'w');
	fwrite($fp, trim(stripslashes($sitephpcode)));
	fclose($fp);
	@chmod($vfile,0707);

	mkdir($g['path_page'].$id.'-menus',0707);
	mkdir($g['path_page'].$id.'-pages',0707);
	mkdir($g['path_page'].$id.'-menus/images',0707);
	mkdir($g['path_page'].$id.'-pages/images',0707);
	mkdir($g['path_var'].'site/'.$id,0707);
	@chmod($g['path_page'].$id.'-menus',0707);
	@chmod($g['path_page'].$id.'-pages',0707);
	@chmod($g['path_page'].$id.'-menus/images',0707);
	@chmod($g['path_page'].$id.'-pages/images',0707);
	@chmod($g['path_var'].'site/'.$id,0707);

	$mfile = $g['path_page'].$id.'-menus/_main';
	$fp = fopen($mfile.'.css','w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile.'.css',0707);
	$fp = fopen($mfile.'.js','w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile.'.js',0707);

	$pfile = $g['path_page'].$id.'-pages/_main';
	$fp = fopen($pfile.'.css','w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($pfile.'.css',0707);
	$fp = fopen($pfile.'.js','w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($pfile.'.js',0707);

	//매니페스트 파일생성
	$manifestfile = $g['path_var'].'site/'.$id.'/manifest.json';
	$fp = fopen($manifestfile,'w');
	$iconsURL = $g['s'].'/_core/images/touch/';
	$icons =  array(
						array('src'=>$iconsURL.'homescreen-128x128.png','sizes'=>'128x128','type'=>'image/png'),
						array('src'=>$iconsURL.'homescreen-144x144.png','sizes'=>'144x144','type'=>'image/png'),
						array('src'=>$iconsURL.'homescreen-168x168.png','sizes'=>'168x168','type'=>'image/png'),
						array('src'=>$iconsURL.'homescreen-192x192.png','sizes'=>'192x192','type'=>'image/png'),
						array('src'=>$iconsURL.'homescreen-512x512.png','sizes'=>'512x512','type'=>'image/png')
					);

	$mnObj->name = $name;
	$mnObj->short_name = $name;
	$mnObj->icons = $icons;
	$mnObj->start_url = '/';
	$mnObj->display = 'standalone';
	$mnObj->background_color = '#333';
	$mnObj->theme_color = '#333';
	$mnObj->gcm_sender_id = '103953800507';  //FCM 자바스크립트 클라이언트에 공통되는 고정된 값입니다.

	$manifestJSON = json_encode($mnObj,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
	$_manifestJSON = str_replace("\/", "/", $manifestJSON);
	fwrite($fp, $_manifestJSON);
	fclose($fp);
	@chmod($manifestfile,0707);

	setrawcookie('result_site', rawurlencode('사이트가 등록 되었습니다.|success'));  // 처리여부 cookie 저장
	if ($nosite=='Y')
	{
		getLink($g['s'].'/?r='.$id.'&m=admin&pickmodule='.$m.'&panel=Y','parent.','','');
	}
	else {
		getLink($g['s'].'/?r='.$id.'&m=admin&pickmodule='.$m.'&panel=Y','parent.parent.','','');
	}
}
?>
