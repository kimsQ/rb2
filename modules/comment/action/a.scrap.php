<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) getLink('','','삭제되었거나 존재하지 않는 게시물입니다.','');
$B = getUidData($table[$m.'list'],$R['bbs']);
if (!$B['uid']) getLink('','','존재하지 않는 게시판입니다.','');

$mbruid		= $my['uid'];
$category	= $_HM['name']?$_HM['name']:$B['name'];
$subject	= addslashes($R['subject']);
$url	    = getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').($c?'c='.$c:'m='.$m),array('bid','uid','skin','iframe'));
$d_regis	= $date['totime'];

if (getDbRows($table['s_scrap'],"mbruid=".$mbruid." and url='".$url."'"))
{
	getLink('','','이미 스크랩된 게시물입니다.','');
}

$_QKEY = 'mbruid,category,subject,url,d_regis';
$_QVAL = "'$mbruid','$category','$subject','$url','$d_regis'";
getDbInsert($table['s_scrap'],$_QKEY,$_QVAL);


getLink('' ,'' , '스크랩 되었습니다.' , '');
?>