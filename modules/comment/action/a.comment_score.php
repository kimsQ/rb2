<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) echo '[RESULT:로그인을 먼저 해주세요.:RESULT]';

$R = getUidData($table['s_comment'],$uid);
if (!$R['uid']) exit;
$score_limit = 1; //점수한계치(이 점수보다 높은 갚을 임의로 보낼 경우 제한)
$score = $score ? $score : 1;
if ($score > $score_limit) $score = $score_limit;

if (!strstr($_SESSION['module_comment_score'],'['.$R['uid'].']'))
{
	if ($value == 'good')
	{
		getDbUpdate($table['s_comment'],'score1=score1+'.$score,'uid='.$R['uid']);
		echo '<script>parent.getId("_score1_'.$uid.'").innerHTML="'.($R['score1']+$score).'";</script>';;
	}
	else {
		getDbUpdate($table['s_comment'],'score2=score2+'.$score,'uid='.$R['uid']);
		echo '<script>parent.getId("_score2_'.$uid.'").innerHTML="'.($R['score1']+$score).'";</script>';;
	}
	$_SESSION['module_comment_score'] .= '['.$R['uid'].']';
   echo '[RESULT:ok:RESULT]'; 
}
else {
   echo	'[RESULT:이미 평가하신 댓글입니다.:RESULT]'; 
}
exit;
?>