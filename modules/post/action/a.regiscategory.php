<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$codhead = trim($codhead);
$codfoot = trim($codfoot);
$recnum  = trim($recnum);

// 임시-featured_img 필드 없는 경우, 생성
$_tmp = db_query("SHOW COLUMNS FROM ".$table[$m.'category']." WHERE `Field` = 'featured_img'",$DB_CONNECT);
if(!db_num_rows($_tmp)) {
	$_tmp = ("alter table ".$table[$m.'category']." ADD featured_img varchar(50) NOT NULL");
	db_query($_tmp, $DB_CONNECT);
}

if ($cat && !$vtype) {
	$R = getUidData($table[$m.'category'],$cat);
	$imghead = $R['imghead'];
	$imgfoot = $R['imgfoot'];
	$imgset = array('head','foot');
	for ($i = 0; $i < 2; $i++)
	{
		$tmpname	= $_FILES['img'.$imgset[$i]]['tmp_name'];
		$realname	= $_FILES['img'.$imgset[$i]]['name'];
		$fileExt	= strtolower(getExt($realname));
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$userimg	= sprintf('%05d',$R['uid']).'_'.$imgset[$i].'.'.$fileExt;

		$saveFile	= $g['path_file'].$m.'/category/'.$userimg;

		if (is_uploaded_file($tmpname)) {
			if (!strstr('[gif][jpg][png][swf]',$fileExt))
			{
				getLink('','','헤더/풋터파일은 gif/jpg/png/swf 파일만 등록할 수 있습니다.','');
			}
			if (!is_dir($g['path_file'].$m.'/category/')) {
				mkdir($g['path_file'].$m.'/category/',0707);
			}
			move_uploaded_file($tmpname,$saveFile);
			@chmod($saveFile,0707);
			${'img'.$imgset[$i]} = $userimg;
		}
	}

	$QVAL = "id='$id',hidden='$hidden',reject='$reject',name='$name',";
	$QVAL.= "layout='$layout',layout_mobile='$layout_mobile',skin='$skin',skin_mobile='$skin_mobile',imghead='$imghead',imgfoot='$imgfoot',puthead='$puthead',putfoot='$putfoot',recnum='$recnum',sosokmenu='$sosokmenu',featured_img='$featured_img'";
	getDbUpdate($table[$m.'category'],$QVAL,'uid='.$cat);

	$vfile = $g['path_file'].$m.'/code/'.sprintf('%05d',$cat);

	if (!is_dir($g['path_file'].$m.'/code/')) {
		mkdir($g['path_file'].$m.'/code/',0707);
	}

	if (trim($codhead))
	{
		$fp = fopen($vfile.'.header.php','w');
		fwrite($fp, trim(stripslashes($codhead)));
		fclose($fp);
		@chmod($vfile.'.header.php',0707);
	}
	else {
		if(is_file($vfile.'.header.php'))
		{
			unlink($vfile.'.header.php');
		}
	}


	if (trim($codfoot))
	{
		$fp = fopen($vfile.'.footer.php','w');
		fwrite($fp, trim(stripslashes($codfoot)));
		fclose($fp);
		@chmod($vfile.'.footer.php',0707);
	}
	else {
		if(is_file($vfile.'.footer.php'))
		{
			unlink($vfile.'.footer.php');
		}
	}


	if ($subcopy == 1)
	{
		include_once $g['dir_module'].'_main.php';
		$subQue = getPostCategoryCodeToSql($table[$m.'category'],$cat,'uid');
		if ($subQue)
		{
			getDbUpdate($table[$m.'category'],"hidden='".$hidden."',reject='".$reject."',layout='".$layout."',layout_mobile='".$layout_mobile."',skin='".$skin."',skin_mobile='".$skin_mobile."'","uid <> ".$cat." and (".$subQue.")");
		}
	}

	setrawcookie('result_post_category', rawurlencode('카테고리 등록정보가 변경 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}
else {
	$MAXC = getDbCnt($table[$m.'category'],'max(gid)','depth='.($depth+1).' and parent='.$parent);
	$sarr = explode(',' , trim($name));
	$slen = count($sarr);
	if ($depth > 4) getLink('','','카테고리는 최대 5단계까지 등록할 수 있습니다.','');

	for ($i = 0 ; $i < $slen; $i++)
	{
		if (!$sarr[$i]) continue;
		$gid	= $MAXC+1+$i;
		$xdepth	= $depth+1;
		$xname	= trim($sarr[$i]);
		$xnarr	= explode('=',$xname);

		$QKEY = "gid,site,id,is_child,parent,depth,hidden,reject,name,layout,layout_mobile,skin,skin_mobile,imghead,imgfoot,puthead,putfoot,recnum,num,sosokmenu,featured_img";
		$QVAL = "'$gid','".$_HS['uid']."','".$xnarr[1]."','0','$parent','$xdepth','$hidden','$reject','$xnarr[0]','$layout','$layout_mobile','$skin','$skin_mobile','','','','','$recnum','0','$sosokmenu','$featured_img'";
		getDbInsert($table[$m.'category'],$QKEY,$QVAL);
		$lastcat = getDbCnt($table[$m.'category'],'max(uid)','');

		if (!$xnarr[1]) {
			getDbUpdate($table[$m.'category'],"id='".$lastcat."'",'uid='.$lastcat);
		} else {
			$ISCODE = getDbData($table[$m.'category'],"uid<> ".$lastcat." and id='".$xnarr[1]."' and site=".$s,'*');
			if ($ISCODE['uid']) {
				getDbUpdate($table[$m.'category'],"id='".$lastcat."'",'uid='.$lastcat);
			}
		}

	}
	if ($parent)
	{
		getDbUpdate($table[$m.'category'],'is_child=1','uid='.$parent);
	}
	db_query("OPTIMIZE TABLE ".$table[$m.'category'],$DB_CONNECT);

	setrawcookie('result_post_category', rawurlencode('카테고리가 등록 되었습니다.'));
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=category&cat='.$lastcat.'&code='.($code?$code.'/'.$lastcat:$lastcat).'#site-cate-info','parent.','','');

}
?>
