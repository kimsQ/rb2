<?php
if(!defined('__KIMS__')) exit;

//if (!$_SESSION['wcode']||$_SESSION['wcode']!=$pcode) exit;
$result= array();
$result['error'] = false;

if (!$bid){
   $result['error']	= true;
   $result['error_msg'] = '게시판 아이디가 지정되지 않았습니다.';
   echo json_encode($result,true);
   exit;	
} 
$B = getDbData($table[$m.'list'],"id='".$bid."'",'*');

include_once $g['dir_module'].'var/var.php';
include_once $g['dir_module'].'var/var.'.$B['id'].'.php';

$bbsuid		= $B['uid'];
$bbsid		= $B['id'];
$mbruid		= $my['uid'];
$id			= $my['id'];
$name		= $my['uid'] ? $my['name'] : trim($name);
$nic		= $my['uid'] ? $my['nic'] : $name;
$category	= trim($category);
$subject	= $my['admin'] ? trim($subject) : htmlspecialchars(trim($subject));
$content	= trim($content);
$subject	= $subject ? $subject : getStrCut(str_replace('&amp;',' ',strip_tags($content)),35,'..');
$html		= $html ? $html : 'TEXT';
$tag		= trim($tag);
$d_regis	= $date['totime'];
$d_comment	= '';
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= $_SERVER['HTTP_USER_AGENT'];
$adddata	= trim($adddata);
$hidden		= $hidden ? intval($hidden) : 0;
$notice		= $notice ? intval($notice) : 0;
$display	= $d['bbs']['display'] || $hidepost || $hidden ? 0 : 1;
$parentmbr	= 0;
$point1		= trim($d['bbs']['point1']);
$point2		= trim($d['bbs']['point2']);
$point3		= $point3 ? filterstr(trim($point3)) : 0;
$point4		= $point4 ? filterstr(trim($point4)) : 0;

if (!$uid || $reply == 'Y')
{
	if(!getDbRows($table[$m.'day'],"date='".$date['today']."' and site=".$s.' and bbs='.$bbsuid))
	getDbInsert($table[$m.'day'],'date,site,bbs,num',"'".$date['today']."','".$s."','".$bbsuid."','0'");
	if(!getDbRows($table[$m.'month'],"date='".$date['month']."' and site=".$s.' and bbs='.$bbsuid))
	getDbInsert($table[$m.'month'],'date,site,bbs,num',"'".$date['month']."','".$s."','".$bbsuid."','0'");
}

$mingid = getDbCnt($table[$m.'data'],'min(gid)','');
$gid = $mingid ? $mingid-1 : 100000000.00;

$QKEY = "site,gid,bbs,bbsid,depth,parentmbr,display,hidden,notice,name,nic,mbruid,id,pw,category,subject,content,html,tag,";
$QKEY.= "hit,down,comment,oneline,trackback,score1,score2,singo,point1,point2,point3,point4,d_regis,d_modify,d_comment,d_trackback,upload,ip,agent,sns,adddata,token";
$QVAL = "'$s','$gid','$bbsuid','$bbsid','$depth','$parentmbr','$display','$hidden','$notice','$name','$nic','$mbruid','$id','$pw','$category','$subject','$content','$html','$tag',";
$QVAL.= "'0','0','0','0','0','0','0','0','$point1','$point2','$point3','$point4','$d_regis','','','','$upload','$ip','$agent','','$adddata','$token'";

getDbInsert($table[$m.'data'],$QKEY,$QVAL);
getDbInsert($table[$m.'idx'],'site,notice,bbs,gid',"'$s','$notice','$bbsuid','$gid'");
getDbUpdate($table[$m.'list'],"num_r=num_r+1,d_last='".$d_regis."'",'uid='.$bbsuid);
getDbUpdate($table[$m.'month'],'num=num+1',"date='".$date['month']."' and site=".$s.' and bbs='.$bbsuid);
getDbUpdate($table[$m.'day'],'num=num+1',"date='".$date['today']."' and site=".$s.' and bbs='.$bbsuid);
$LASTUID = getDbCnt($table[$m.'data'],'max(uid)','');


if ($gid == 100000000.00)
{
	db_query("OPTIMIZE TABLE ".$table[$m.'idx'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table[$m.'data'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table[$m.'month'],$DB_CONNECT); 
	db_query("OPTIMIZE TABLE ".$table[$m.'day'],$DB_CONNECT); 
}
$result = array();
$result['uid'] = $LASTUID;
echo json_encode($result,true);
exit;
?>