<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$uid)	getLink('','','정상적인 접근이 아닙니다.','');
$insFile = $g['dir_module'].'var/install/'.$uid.'.txt';
if (is_file($insFile))
{
	getLink('','','이미 설치된 자료입니다.','');
}
else {


	include $g['dir_module'].'var/var.php';
	if(!$d['market']['url']) getLink('','','환경설정 페이지에서 큐마켓URL을 등록해 주세요.','');
	if(!$d['market']['id']||!$d['market']['pw']) getLink('','','환경설정 페이지에서 킴스큐 회원정보를 등록해 주세요.','');

	include $g['path_core'].'function/rss.func.php';
	$appData = getUrlData($d['market']['url'].'&a=client.install&uid='.$uid.'&id='.$d['market']['id'].'&pw='.$d['market']['pw'],10);
	$appArray= explode('|',$appData);
	
	if ($appArray[3])	getLink('','',$appArray[3],'');
	if (!$appArray[2])	getLink('','','정상적인 자료가 아닙니다.','');
	if ($appArray[4] != 6)
	{
		if (!$appArray[0] || !$appArray[1]) getLink('','','원격설치를 지원하지 않는 자료입니다.','');
	}
	$marketUrl = explode('/',$d['market']['url']);
	$marketData = getUrlData('http://'.$marketUrl[2].'/modules/qmarket/upload/data/'.$appArray[2],10);

	$appfiletype  = substr($appArray[0],0,6);
	if (strstr($appArray[1],'bbs/theme/')) $appfiletype = 'bbstheme';
	$folder = './'.$appArray[0].'/';
	$subfolder = explode('/',$appArray[1]);
	$subfoldern= count($subfolder)-1;
	$nSubfolder = '';
	if (strpos(',_pc,_mobile,',$subfolder[$subfoldern]))
	{
		getLink('','','원격설치 형식에 맞지 않는 자료같습니다.\\n다운로드 받아서 설치해 주세요.','');
	}
	for ($i = 0; $i < $subfoldern; $i++)
	{
		$nSubfolder .= $subfolder[$i].'/';
	}
	if ($appArray[4] == 6) $appfiletype = 'package';
	$installaction= array
	(
		'module'=>array('module_pack_upload','rb_module_app.zip'),
		'widget'=>array('pack_upload','rb_widget_app.zip'),
		'layout'=>array('pack_upload','rb_layout_app.zip'),
		'bbstheme'=>array('pack_upload','rb_bbstheme_app.zip'),
		'switch'=>array('pack_upload','rb_switch_app.zip'),
		'package'=>array('package_upload','rb_package_app.zip'),
	);

	if ($installaction[$appfiletype][0]=='') getLink('','','원격설치 형식에 맞지 않는 자료입니다.\\n다운로드 받아서 설치해 주세요.','');

	$extPath  = $g['path_tmp'].'app';
	$extPath1 = $extPath.'/';
	$saveFile = $extPath1.$installaction[$appfiletype][1];

	$fp = fopen($saveFile,'w');
	fwrite($fp,$marketData);
	fclose($fp);
	@chmod($saveFile,0707);

	getLink($g['s'].'/?r='.$r.'&m='.$m.'&a='.$installaction[$appfiletype][0].'&remote=Y&type='.$appfiletype.'&folder='.$folder.'&subfolder='.$nSubfolder.'&insfolder='.$appArray[1].'&uid='.$uid,'','','');
}
?>