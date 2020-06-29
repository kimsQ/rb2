<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$category = trim($category);
$name = trim($name);
$joint = trim(str_replace('&amp;','&',$joint));
$hit = 0;
$d_regis = $date['totime'];
$title = trim($title);
$keywords = trim($keywords);
$description = trim($description);
$classification = trim($classification);
$upload = trim($upload);
$image_src = trim($image_src);
$extra = trim($extra);

if (strstr($joint,'&c=')||strstr($joint,'?c='))
{
	getLink('','','연결주소에 사용할 수 없는 파라미터가 있습니다.','');
}

if (($orign_id && $orign_id != $id) || !$orign_id)
{
	$R = getDbData($table['s_page'],"site=".$s." and id='".$id."'",'*');
	if ($R['uid']) getLink('','','동일한 아이디의 페이지가 존재합니다.','');
}

if ($uid)
{

	if ($orign_id != $id)
	{
		$mfile1 = $g['path_page'].$r.'-pages/'.$orign_id.'.php';
		$mfile2 = $g['path_page'].$r.'-pages/'.$id.'.php';
		@rename($mfile1,$mfile2);
		@chmod($mfile2,0707);
		@unlink($g['path_page'].$r.'-pages/'.$orign_id.'.txt');
	}
	if ($cachetime)
	{
		$fp = fopen($g['path_page'].$r.'-pages/'.$id.'.txt','w');
		fwrite($fp, $cachetime);
		fclose($fp);
		@chmod($g['path_page'].$r.'-pages/'.$id.'.txt',0707);
	}
	else {
		if (file_exists($g['path_page'].$r.'-pages/'.$id.'.txt'))
		{
			unlink($g['path_page'].$r.'-pages/'.$id.'.txt');
		}
	}

	$QVAL = "pagetype='$pagetype',ismain='$ismain',mobile='$mobile',id='$id',category='$category',name='$name',perm_g='$perm_g',perm_l='$perm_l',layout='$layout',m_layout='$m_layout',joint='$joint',linkedmenu='$linkedmenu',d_last='$d_regis',upload='$upload',extra='$extra'";
	getDbUpdate($table['s_page'],$QVAL,'uid='.$uid);

	$_SEO = getDbData($table['s_seo'],'uid='.(int)$seouid,'uid');
	if($_SEO['uid']) getDbUpdate($table['s_seo'],"title='$title',keywords='$keywords',description='$description',classification='$classification',image_src='$image_src'",'uid='.$_SEO['uid']);
	else getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$uid','$title','$keywords','$description','$classification','$image_src'");

	if ($backgo)
	{
		if ($iframe=='Y') getLink(RW('mod='.$id),'parent.parent.','','');
		else getLink(RW('mod='.$id),'parent.','','');
	}
	else {
		setrawcookie('result_page', rawurlencode('페이지 등록정보가 변경 되었습니다.|success'));  // 처리여부 cookie 저장
		getLink('reload','parent.','','');
	}
}
else {

	$sarr = explode(',' , trim($name));
	$slen = count($sarr);

	for ($i = 0 ; $i < $slen; $i++)
	{
		if (!$sarr[$i]) continue;

		$xname	= trim($sarr[$i]);
		$xnarr	= explode('=',$xname);
		$xnid	= $xnarr[1] ? $xnarr[1] : $id;

		if(getDbRows($table['s_page'],"site=".$s." and id='".$xnid."'")) continue;

		$mfile = $g['path_page'].$r.'-pages/'.$xnid.'.php';
		$fp = fopen($mfile,'w');
		fwrite($fp,'');
		fclose($fp);
		@chmod($mfile,0707);

		if ($cachetime)
		{
			$fp = fopen($g['path_page'].$r.'-pages/'.$xnid.'.txt','w');
			fwrite($fp, $cachetime);
			fclose($fp);
			@chmod($g['path_page'].$r.'-pages/'.$xnid.'.txt',0707);
		}

		$QKEY = "site,pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,m_layout,joint,hit,linkedmenu,d_regis,d_last,upload,mbruid,extra";
		$QVAL = "'$s','$pagetype','$ismain','$mobile','$xnid','$category','$xnarr[0]','$perm_g','$perm_l','$layout','$m_layout','$joint','$hit','$linkedmenu','$d_regis','$d_regis','$upload','".$my['uid']."','$extra'";
		getDbInsert($table['s_page'],$QKEY,$QVAL);
		$lastpage = getDbCnt($table['s_page'],'max(uid)','');
		getDbInsert($table['s_seo'],'rel,parent,title,keywords,description,classification,image_src',"'2','$lastpage','$title','$keywords','$description','$classification','$image_src'");

	}

	db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT);
	setrawcookie('result_page', rawurlencode('페이지가 등록 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=page&uid='.$lastpage.'&cat='.urlencode($cat).'&renum='.$recnum.'&p='.$p.'&keyw='.urlencode($keyw),'parent.','','');
}
?>
