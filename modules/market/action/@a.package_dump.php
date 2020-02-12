<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($del == 'Y')
{
	require $g['path_core'].'function/dir.func.php';
	DirDelete('./_package');
	getLink('reload','parent.','패키지 파일이 삭제되었습니다.','');
}
else {
	require $g['path_core'].'function/dir.func.php';
	@mkdir('./_package',0707);
	@mkdir('./_package/rb',0707);
	@mkdir('./_package/rb/_core',0707);
	@mkdir('./_package/rb/_tmp',0707);
	@mkdir('./_package/rb/_var',0707);
	@mkdir('./_package/rb/files',0707);
	@mkdir('./_package/rb/layouts',0707);
	@mkdir('./_package/rb/switchs',0707);
	@mkdir('./_package/rb/widgets',0707);
	@mkdir('./_package/rb/modules',0707);
	@mkdir('./_package/rb/modules/bbs',0707);
	@mkdir('./_package/rb/modules/bbs/var',0707);
	@mkdir('./_package/rb/pages',0707);
	@mkdir('./_package/rb/pages/menu',0707);
	@mkdir('./_package/rb/pages/image',0707);


	$fp = fopen('./_package/dump_site.dat','w');
	foreach($_HS as $_key => $_val)
	{
		if (!strpos(',,layout,m_layout,lang,dtd,nametype,',','.$_key.',')) continue;
		fwrite($fp,$_key."\t".$_val."\t\n");
	}
	fclose($fp);

	$fp = fopen('./_package/dump_menu.dat','w');
	$_MENUS = getDbSelect($table['s_menu'],'site='.$_HS['uid'].' order by uid asc','*');
	while($R=db_fetch_array($_MENUS))
	{
		//$_SEO = getDbData($table['s_seo'],'rel=1 and parent='.$R['uid'],'*');
		fwrite($fp,$R['uid']."\t".$R['gid']."\t".$R['isson']."\t".$R['parent']."\t".$R['depth']."\t".$R['id']."\t".$R['menutype']."\t".$R['mobile']."\t".$R['hidden']."\t".$R['reject']."\t".$R['name']."\t".$R['target']."\t".$R['redirect']."\t".$R['joint']."\t".$R['layout']."\t".$R['imghead']."\t".$R['imgfoot']."\t".$R['puthead']."\t".$R['putfoot']."\t\n");
		
		$_xfile1 = $g['path_page'].'menu/'.sprintf('%05d',$R['uid']);
		$_xfile2 = './_package/rb/pages/menu/'.sprintf('%05d',$R['uid']);

		@copy($_xfile1.'.php',$_xfile2.'.php');
		@copy($_xfile1.'.widget.php',$_xfile2.'.widget.php');
		@copy($_xfile1.'.mobile.php',$_xfile2.'.mobile.php');
		@copy($_xfile1.'.css',$_xfile2.'.css');
		@copy($_xfile1.'.js',$_xfile2.'.js');
		@copy($_xfile1.'.header.php',$_xfile2.'.header.php');
		@copy($_xfile1.'.footer.php',$_xfile2.'.footer.php');
	}
	fclose($fp);

	$fp = fopen('./_package/dump_page.dat','w');
	$_PAGES = getDbSelect($table['s_page'],'','*');
	while($R=db_fetch_array($_PAGES))
	{
		//$_SEO = getDbData($table['s_seo'],'rel=2 and parent='.$R['uid'],'*');
		fwrite($fp,$R['pagetype']."\t".$R['ismain']."\t".$R['mobile']."\t".$R['id']."\t".$R['category']."\t".$R['name']."\t".$R['layout']."\t".$R['joint']."\t".$R['sosokmenu']."\t\n");

		$_xfile1 = $g['path_page'].$R['id'];
		$_xfile2 = './_package/rb/pages/'.$R['id'];

		@copy($_xfile1.'.php',$_xfile2.'.php');
		@copy($_xfile1.'.widget.php',$_xfile2.'.widget.php');
		@copy($_xfile1.'.mobile.php',$_xfile2.'.mobile.php');
		@copy($_xfile1.'.css',$_xfile2.'.css');
		@copy($_xfile1.'.js',$_xfile2.'.js');

	}
	fclose($fp);


	$fp = fopen('./_package/dump_bbs.dat','w');
	$_BBS = getDbSelect($table['bbslist'],'uid order by gid asc','*');
	while($R=db_fetch_array($_BBS))
	{
		fwrite($fp,$R['id']."\t".$R['name']."\t".$R['category']."\t".$R['imghead']."\t".$R['imgfoot']."\t".$R['puthead']."\t".$R['putfoot']."\t\n");

		$_xfile1 = $g['path_module'].'bbs/var/var.'.$R['id'];
		$_xfile2 = './_package/rb/modules/bbs/var/var.'.$R['id'];

		@copy($_xfile1.'.php',$_xfile2.'.php');
	}
	fclose($fp);

	$fp = fopen('./_package/readme.txt','w');
	fwrite($fp,"패키지 안내문\n------------------\n");
	fwrite($fp,"여기(/_package/readme.txt)에 이 패키지의 설명글을 작성해 주세요.\n");
	fwrite($fp,"이 패키지는 샘플이므로 실제 적용가능한 패키지를 구성하려면 매뉴얼을 참조하세요.\n");
	fwrite($fp,"이 샘플패키지는 '적용취소' 버튼을 클릭하면 삭제할 수 있습니다.\n");
	fclose($fp);

	$fp = fopen('./_package/package.rule.php','w');
	fwrite($fp, "<?php\n");

	fwrite($fp, "// 이 패키지의 명칭을 지정합니다.\n");
	fwrite($fp, "\$d['package']['name'] = \"[".$_HS['name']." - 사이트패키지]\";\n\n");
	fwrite($fp, "// 이 패키지에 포함된 확장요소들을 배열로 지정합니다.\n");
	fwrite($fp, "// 설치가 필요한 신규모듈일 경우 array 안에 모듈폴더명을 지정합니다.\n");
	fwrite($fp, "\$d['package']['elements'] = array\n");
	fwrite($fp, "(\n");
	fwrite($fp, "	'샘플 레이아웃' => array(),\n");
	fwrite($fp, "	'샘플 신규모듈' => array(''),\n");
	fwrite($fp, ");\n");
	fwrite($fp, "?>");
	fclose($fp);

	getLink('reload','parent.','패키지용 샘플파일이 만들어졌습니다.','');
}
?>