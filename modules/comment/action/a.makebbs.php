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

if (!$name) getLink('','','채팅방 이름을 입력해 주세요.','');
if (!$id) getLink('','','채팅방 아이디를 입력해 주세요.','');

if ($bid)
{
	$R = getDbData($table[$m.'list'],"id='".$bid."'",'*');
	$QVAL = "name='$name',type='$type',owner_id='$owner_id',members='$members',t_start='$t_start',t_end='$t_end',category='$category',imghead='$imghead',imgfoot='$imgfoot',puthead='$puthead',putfoot='$putfoot',addinfo='$addinfo',writecode='$writecode'";
	getDbUpdate($table[$m.'list'],$QVAL,"id='".$bid."'");
	$backUrl = $g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=makebbs&iframe=Y&uid='.$R['uid'];
	$msg = '채팅방 설정내용이 수정되었습니다.';	
}
else {

	if(getDbRows($table[$m.'list'],"id='".$id."'")) getLink('','','이미 같은 아이디의 채팅방이 존재합니다.','');

	$Ugid = getDbCnt($table[$m.'list'],'max(gid)','') + 1;
	$QKEY = "gid,id,name,type,owner_id,members,t_start,t_end,category,num_r,d_last,d_regis,imghead,imgfoot,puthead,putfoot,addinfo,writecode";
	$QVAL = "'$Ugid','$id','$name','$type','$owner_id','$members','$t_start','$t_end','$category','0','','".$date['totime']."','$imghead','$imgfoot','$puthead','$putfoot','$addinfo','$writecode'";
	getDbInsert($table[$m.'list'],$QKEY,$QVAL);


	$backUrl = $g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=makebbs&iframe=Y&uid='.getDbCnt($table[$m.'list'],'max(uid)','');
	$msg ='새 채팅방이 만들어졌습니다. ';
}


$fdset = array('layout','skin','m_skin','perm_g_view','perm_g_write','perm_l_view','perm_l_write','admin','hitcount','recnum','sbjcut','newtime','display');

$gfile= $g['dir_module'].'var/var.'.$id.'.php';
$fp = fopen($gfile,'w');
fwrite($fp, "<?php\n");
foreach ($fdset as $val)
{
	fwrite($fp, "\$d['bbs']['".$val."'] = \"".trim(${$val})."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($gfile,0707);

getLink('reload','parent.',$msg,'');
?>