<?php
function getAgoGrade($SR,$keyword,$d1,$d2)
{
	global $date,$table,$DB_CONNECT,$s;
	$d_regis1	= date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-$d1,substr($date['today'],0,4)));
	$d_regis2	= date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-$d2,substr($date['today'],0,4)));
	$WHEREIS = 'where (date between '.$d_regis1.' and '.$d_regis2.") and keyword='".$keyword."' and site=".$s;
	$SCOUNT	= db_fetch_array(db_query('SELECT sum(hit) FROM '.$table['s_inkey'].' '.$WHEREIS,$DB_CONNECT));

	if (!$SCOUNT[0]) return -1;
	$len = count($SR);
	for($i = 0; $i < $len; $i++)
	{
		if ($SCOUNT[0] > $SR[$i]) break;
	}
	return $i;
}
function getGradeArr($d1,$d2)
{
	global $date,$table,$DB_CONNECT,$s;
	$d_regis1	= date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-$d1,substr($date['today'],0,4)));
	$d_regis2	= date('Ymd',mktime(0,0,0,substr($date['today'],4,2),substr($date['today'],6,2)-$d2,substr($date['today'],0,4)));
	$WHEREIS = 'where (date between '.$d_regis1.' and '.$d_regis2.') and site='.$s;
	$SCOUNT	= db_query('SELECT sum(hit) as cnt FROM '.$table['s_inkey'].' '.$WHEREIS.' group by keyword order by cnt desc',$DB_CONNECT);
	while($R=db_fetch_array($SCOUNT)) $ARR[] = $R['cnt'];
	return $ARR;
}
function getSicon($n1,$n2)
{
	if($n1 < 0) return 'new';
	if($n1 > $n2) return 'up';
	if($n1 < $n2) return 'down';
	if($n1 ==$n2) return 'same';
}
function getNumChange($n1,$n2)
{
	if($n1 < 0  || $n1 == $n2) return '';
	if($n1 > $n2) return $n1 - $n2;
	if($n1 < $n2) return $n2 - $n1;
}
?>