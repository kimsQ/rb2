<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error']=false;

if ($_mtype == 'page')
{

	if (is_file($g['path_page'].$r.'-pages/'.$id.'.mobile.php')) {
		$_filekind = $r.'-pages/'.$id.'.mobile';
	} else {
		$_filekind = $r.'-pages/'.$id;
	}

	$_filesbj = $_HP['name'];
}
if ($_mtype == 'menu')
{
	if (is_file($g['path_page'].$r.'-menus/'.$id.'.mobile.php')) {
		$_filekind = $r.'-menus/'.$id.'.mobile';
	} else {
		$_filekind = $r.'-menus/'.$id;
	}

	$_filesbj = $_HM['name'];
}

$__SRC__ = is_file($g['path_page'].$_filekind.'.php') ? implode('',file($g['path_page'].$_filekind.'.php')) : '';

if (!$__SRC__) {
  $result['error']='존재하기 않는 페이지 입니다.';
  echo json_encode($result);
  exit;
}


$result['article'] = getContents($__SRC__,'HTML');

echo json_encode($result);
exit;
?>
