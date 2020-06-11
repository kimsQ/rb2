<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
//메뉴->XML출력
function getMenuXml($site,$table,$j,$parent,$depth,$uid,$code)
{
	global $g;
	static $j,$string;
	$xdepth = $depth+1;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' and hidden=0 order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		$code = $code.$C['id'].'/';
		$_code = substr($code,0,strlen($code)-1);

		if ($xdepth==1)
		{
			$string .= "\t<!-- ".$C['name']."-->\n\t";
		}
		else {
			for ($i = 0; $i < $xdepth; $i++) $string .= "\t";
		}
		$string .= '<depth'.$xdepth.' name="'.$C['name'].'" ename="'.$C['id'].'" link="'.RW('c='.$_code).'" target="'.$C['target'];

		if ($C['is_child'])
		{
			$string .= '">'."\n";
			getMenuXml($site,$table,$j,$C['uid'],$C['depth'],$uid,$code);

			for ($i = 0; $i < $xdepth; $i++) $string .= "\t";
			$string .= '</depth'.$xdepth.'>'."\n";
		}
		else {
			$string .= '" />'."\n";
		}
		if ($xdepth==1) $string .= "\n";
		$code = '';
	}
	return $string;
}
//메뉴->XLS출력
function getMenuXls($site,$table,$j,$parent,$depth,$uid,$mset,$code)
{
	global $g,$r;
	static $j,$string;
	$xdepth = $depth+1;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		$code = $code.$C['id'].'/';
		$_code = substr($code,0,strlen($code)-1);

		$string .= '<tr>';
		$string .= '<td>'.$xdepth.'</td>';
		$string .= '<td>'.($xdepth==1?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==2?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==3?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==4?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==5?$C['name']:'').'</td>';
		$string .= '<td>'.$C['uid'].'</td>';
		$string .= '<td>'.$C['id'].'</td>';
		$string .= '<td>'.RW('c='.$_code).'</td>';
		$string .= '<td>'.$g['s'].'/index.php?r='.$r.'&amp;c='.$_code.'</td>';
		$string .= '<td>'.$mset[$C['menutype']].'</td>';
		$string .= '<td>'.($C['mobile']?'Y':'').'</td>';
		$string .= '<td>'.($C['target']?'Y':'').'</td>';
		$string .= '<td>'.($C['hidden']?'Y':'').'</td>';
		$string .= '<td>'.($C['reject']?'Y':'').'</td>';
		$string .= '<td>'.($C['redirect']?'Y':'').'</td>';
		$string .= '<td>'.$C['joint'].'</td>';
		$string .= '</tr>';

		if ($C['is_child'])
		{
			getMenuXls($site,$table,$j,$C['uid'],$C['depth'],$uid,$mset,$code);
		}
		$code = '';
	}
	return $string;
}
//메뉴->TXT출력
function getMenuTxt($site,$table,$j,$parent,$depth,$uid,$code)
{
	global $g;
	static $j,$string;
	$xdepth = $depth+1;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		$code = $code.$C['id'].'/';
		$_code = substr($code,0,strlen($code)-1);

		for ($i = 0; $i < $depth; $i++) $string .= "\t";
		$string .= '['.$xdepth.']'.($C['hidden']?'[숨김]':'').($C['reject']?'[차단]':'').($C['target']?'[새창]':'').$C['name']." = ".RW('c='.$_code)."\r\n";

		if ($C['is_child'])
		{
			getMenuTxt($site,$table,$j,$C['uid'],$C['depth'],$uid,$code);
		}
		if ($xdepth==1) $string .= "\r\n";

		$code = '';
	}
	return $string;
}
//메뉴->패키지용
function getMenuPackage($site,$table,$j,$parent,$depth,$uid)
{
	global $g;
	static $j,$string;
	$xdepth = $depth+1;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$_parent = $C['parent'] ? getDbData($table,($site?'site='.$site.' and ':'').'uid='.$C['parent'],'id') : array();
		$j++;
		for ($i = 0; $i < $depth; $i++) $string .= "\t";
		$string .= "\tarray('name'=>'".$C['name']."','id'=>'".$C['id']."','menutype'=>'".$C['menutype']."','mobile'=>'".$C['mobile']."','hidden'=>'".$C['hidden']."','target'=>'".$C['target']."','redirect'=>'".$C['redirect']."','joint'=>'".$C['joint']."','layout'=>'".$C['layout']."','imghead'=>'".$C['imghead']."','imgfoot'=>'".$C['imgfoot']."','imgicon'=>'".$C['imgicon']."','addattr'=>'".$C['addattr']."','depth'=>'".$C['depth']."','parent'=>'".$_parent['id']."','is_child'=>'".$C['is_child']."','gid'=>'".$C['gid']."',),\r\n";

		if ($C['is_child'])
		{
			getMenuPackage($site,$table,$j,$C['uid'],$C['depth'],$uid);
		}
	}
	return $string;
}

if ($type == 'xml')
{
	$filename = 'menu_'.$_HS['id'].'.xml';
	$filepath = $g['path_var'].'xml/'.$filename;

	$fp = fopen($filepath,'w');
	fwrite($fp,"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
	fwrite($fp,"<menu>\n\n");
	fwrite($fp,"\t<!-- ".$_HS['name']."-메뉴구조 -->\n");
	fwrite($fp,getMenuXml($s,$table['s_menu'],0,0,0,0,''));
	fwrite($fp,"</menu>\n");
	fclose($fp);
	@chmod($filepath,0707);

	$filesize = filesize($filepath);

	header("Content-Type: application/octet-stream");
	header("Content-Length: " .$filesize);
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	header("Cache-Control: private, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");

	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
	exit;

}
else if($type == 'xls')
{

	header("Content-type: application/vnd.ms-excel;" );
	header("Content-Disposition: attachment; filename=menu_".$_HS['id'].".xls" );
	header("Content-Description: PHP4 Generated Data" );

	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
	echo '<table border="1">';
	echo '<thead>';
	echo '<th>단계</th>';
	echo '<th>1차메뉴</th>';
	echo '<th>2차메뉴</th>';
	echo '<th>3차메뉴</th>';
	echo '<th>4차메뉴</th>';
	echo '<th>5차메뉴</th>';
	echo '<th>고유키(PK)</th>';
	echo '<th>메뉴코드</th>';
	echo '<th>현재주소</th>';
	echo '<th>물리주소</th>';
	echo '<th>메뉴형식</th>';
	echo '<th>모바일</th>';
	echo '<th>새창</th>';
	echo '<th>숨김</th>';
	echo '<th>차단</th>';
	echo '<th>리다이렉트</th>';
	echo '<th>연결주소</th>';
	echo '</thead>';
	echo '<tbody>';
	echo getMenuXls($s,$table['s_menu'],0,0,0,0,array('','모듈','위젯','코딩'),'');
	echo '</tbody>';
	echo '</table>';
	exit;
}
else if($type == 'txt')
{

	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=menu_".$_HS['id'].".txt" );
	header("Content-Description: PHP4 Generated Data" );
	echo $_HS['name']."-메뉴구조\r\n";
	echo "-------------------------------------------------------------------------\r\n\r\n";
	echo getMenuTxt($s,$table['s_menu'],0,0,0,0,'');
	exit;
}
else if($type == 'package_menu')
{

	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=var.menu.php" );
	header("Content-Description: PHP4 Generated Data" );
	echo "<?php\r\n";
	echo "\$d['package']['menus'] = array(\r\n";
	echo getMenuPackage($s,$table['s_menu'],0,0,0,0);
	echo ");\r\n";
	echo "?>\r\n";
	exit;
}
else if($type == 'package_page')
{
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=var.page.php" );
	header("Content-Description: PHP4 Generated Data" );
	echo "<?php\r\n";
	echo "\$d['package']['pages'] = array(\r\n";
	$PAGES = getDbArray($table['s_page'],'site='.$s,'*','d_update','desc',0,1);
	while($R = db_fetch_array($PAGES))
	{
		echo "\tarray('name'=>'".$R['name']."','id'=>'".$R['id']."','pagetype'=>'".$R['pagetype']."','ismain'=>'".$R['ismain']."','mobile'=>'".$R['mobile']."','category'=>'".$R['category']."','layout'=>'".$R['layout']."','joint'=>'".$R['joint']."','linkedmenu'=>'".$R['linkedmenu']."'),\r\n";
	}
	echo ");\r\n";
	echo "?>\r\n";
	exit;
}
?>
