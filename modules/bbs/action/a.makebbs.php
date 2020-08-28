<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id   = $id ? trim($id) : $bid;
$name = trim($name);
$codhead = trim($codhead);
$codfoot = trim($codfoot);
$category = trim($category);
$addinfo = trim($addinfo);
$writecode = trim($writecode);
$puthead = $inc_head_list.$inc_head_view.$inc_head_write;
$putfoot = $inc_foot_list.$inc_foot_view.$inc_foot_write;

if ($send_mod=='ajax') {
	$_HS = getDbData($table['s_site'],"id='".$r."'",'uid');
	$site = $_HS['uid'];
	$result=array();
	$result['error']=false;
}

if (!$name) getLink('','','게시판이름을 입력해 주세요.','');
if (!$id) getLink('','','아이디를 입력해 주세요.','');

if ($bid)
{
	$R = getDbData($table[$m.'list'],"id='".$bid."'",'*');
	$imghead = $R['imghead'];
	$imgfoot = $R['imgfoot'];
	$imgset = array('head','foot');

	for ($i = 0; $i < 2; $i++)
	{
		$tmpname	= $_FILES['img'.$imgset[$i]]['tmp_name'];
		$realname	= $_FILES['img'.$imgset[$i]]['name'];
		$fileExt	= strtolower(getExt($realname));
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$userimg	= $R['id'].'_'.$imgset[$i].'.'.$fileExt;
		$saveFile	= $g['dir_module'].'var/files/'.$userimg;

		if (is_uploaded_file($tmpname))
		{
			if (!strstr('[gif][jpg][png]',$fileExt))
			{
				getLink('','','헤더/풋터파일은 gif/jpg/png 파일만 등록할 수 있습니다.','');
			}
			move_uploaded_file($tmpname,$saveFile);
			@chmod($saveFile,0707);

			${'img'.$imgset[$i]} = $userimg;
		}
	}

	$QVAL = "site='$site',name='$name',category='$category',imghead='$imghead',imgfoot='$imgfoot',puthead='$puthead',putfoot='$putfoot',addinfo='$addinfo',writecode='$writecode'";
	getDbUpdate($table[$m.'list'],$QVAL,"id='".$bid."'");

	$vfile = $g['dir_module'].'var/code/'.$R['id'];

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
	$backUrl = $g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=makebbs&iframe=Y&uid='.$R['uid'];
}
else {

	if (getDbRows($table[$m.'list'],"id='".$id."'")) {
		if ($send_mod=='ajax') {
			$result['error']='id_exists';
			echo json_encode($result);
			exit;
		} else {
			getLink('','','이미 같은 아이디의 게시판이 존재합니다.','');
		}
	}

	$imgset = array('head','foot');

	for ($i = 0; $i < 2; $i++)
	{
		$tmpname	= $_FILES['img'.$imgset[$i]]['tmp_name'];
		$realname	= $_FILES['img'.$imgset[$i]]['name'];
		$fileExt	= strtolower(getExt($realname));
		$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
		$userimg	= $id.'_'.$imgset[$i].'.'.$fileExt;
		$saveFile	= $g['dir_module'].'var/files/'.$userimg;

		if (is_uploaded_file($tmpname))
		{
			if (!strstr('[gif][jpg][png][swf]',$fileExt))
			{
				getLink('','','헤더/풋터파일은 gif/jpg/png/swf 파일만 등록할 수 있습니다.','');
			}
			move_uploaded_file($tmpname,$saveFile);
			@chmod($saveFile,0707);

			${'img'.$imgset[$i]} = $userimg;
		}
	}

	$Ugid = getDbCnt($table[$m.'list'],'max(gid)','') + 1;
	$QKEY = "gid,site,id,name,category,num_r,d_last,d_regis,imghead,imgfoot,puthead,putfoot,addinfo,writecode";
	$QVAL = "'$Ugid','".$site."','$id','$name','$category','0','','".$date['totime']."','$imghead','$imgfoot','$puthead','$putfoot','$addinfo','$writecode'";
	getDbInsert($table[$m.'list'],$QKEY,$QVAL);

	$lastbbs = getDbCnt($table[$m.'list'],'max(uid)','');

	$mfile = $g['dir_module'].'var/code/'.$id;

	if (trim($codhead))
	{
		$fp = fopen($mfile.'.header.php','w');
		fwrite($fp, trim(stripslashes($codhead)));
		fclose($fp);
		@chmod($mfile.'.header.php',0707);
	}

	if (trim($codfoot))
	{
		$fp = fopen($mfile.'.footer.php','w');
		fwrite($fp, trim(stripslashes($codfoot)));
		fclose($fp);
		@chmod($mfile.'.footer.php',0707);
	}
	$backUrl = $g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=makebbs&iframe=Y&uid='.getDbCnt($table[$m.'list'],'max(uid)','');
}


$fdset = array('layout','m_layout','skin','m_skin','editor','m_editor','a_skin','a_mskin','c_skin','c_mskin','c_hidden',
	'perm_g_list','perm_g_view','perm_g_write','perm_g_down','perm_l_list','perm_l_view','perm_l_write','perm_l_down',
	'admin','hitcount','recnum','sbjcut','newtime','rss','sosokmenu','point1','point2','point3','display','hidelist','snsconnect',
	'noti_notice','noti_newpost','noti_opinion','noti_mention','noti_report');

if (!is_dir($g['path_var'].'bbs')) mkdir($g['path_var'].'bbs');
$gfile= $g['path_var'].'bbs/var.'.$id.'.php';
$fp = fopen($gfile,'w');
fwrite($fp, "<?php\n");
foreach ($fdset as $val)
{
	fwrite($fp, "\$d['bbs']['".$val."'] = \"".trim(${$val})."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($gfile,0707);

if ($bid) {
	setrawcookie('result_bbs_main', rawurlencode($name.' 게시판 등록정보가 변경 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
} else {
	if ($send_mod=='ajax') {
		echo json_encode($result);
		exit;
	} else {
		setrawcookie('result_bbs_main', rawurlencode($name.' 게시판이 생성 되었습니다.|success'));  // 처리여부 cookie 저장
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=main_detail&uid='.$lastbbs,'parent.','','');
	}
}

?>
