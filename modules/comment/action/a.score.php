<?php
if(!defined('__KIMS__')) exit;

$useGUEST = 0; //비회원도 접근허용할 경우 1로 변경
$score_limit = 1; //점수한계치(이 점수보다 높은 갚을 임의로 보낼 경우 제한)
$score = $score ? $score : 1;
if ($score > $score_limit) $score = $score_limit;

if (!$useGUEST)
{
	if (!$my['uid']) getLink('','','로그인해 주세요.','');
	$scorelog = '['.$my['uid'].']';
}
else {
	$scorelog = '['.$_SERVER['REMOTE_ADDR'].']';
	if ($my['uid']) $scorelog .= '['.$my['uid'].']';
}


$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) getLink('','','존재하지 않는 게시물입니다.','');

$UT = getDbData($table[$m.'xtra'],'parent='.$R['uid'],'*');
$scoreset = array('good'=>'score1','bad'=>'score2');

// 공감,비공감 또는 추천,비추천 등 2개이상의 체크가 가능할 경우 둘중 하나라도 체크했을때 중복을 제한하려면 주석을 풀어주세요.
//if (strpos('_'.$UT['score1'],'['.$my['uid'].']') || strpos('_'.$UT['score1'],'['.$_SERVER['REMOTE_ADDR'].']') || strpos('_'.$UT['score2'],'['.$my['uid'].']') || strpos('_'.$UT['score2'],'['.$_SERVER['REMOTE_ADDR'].']'))
//{
//	getLink('','','이미 반영된 글입니다.','');
//}

if (!strpos('_'.$UT[$scoreset[$value]],'['.$my['uid'].']') && !strpos('_'.$UT[$scoreset[$value]],'['.$_SERVER['REMOTE_ADDR'].']'))
{
	getDbUpdate($table[$m.'data'],$scoreset[$value].'='.$scoreset[$value].'+'.$score,'uid='.$R['uid']);
	if (!$UT['parent'])
	{
		getDbInsert($table[$m.'xtra'],'parent,site,bbs,'.$scoreset[$value],"'".$R['uid']."','".$s."','".$R['bbs']."','".$scorelog."'");
	}
	else {
		getDbUpdate($table[$m.'xtra'],$scoreset[$value]."='".$UT[$scoreset[$value]].$scorelog."'",'parent='.$R['uid']);
	}
}
else {
	getLink('','','이미 반영된 글입니다.','');
}

getLink('','','반영되었습니다.','');
?>