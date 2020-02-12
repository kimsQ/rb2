<?php
//검색sql
function LIB_getSearchSql($w,$k,$ik,$h)
{
	if($k==',' || (!$k&&$h=='not')) return '';
	$k = $k ? urldecode($k) : '';
	$ik= $ik? urldecode($ik) : '';
	$h = $h ? $h : 'or';
	$k = str_replace(' ', ',',$k);
	$karr = explode(',' , $k);
	$knm  = count($karr);
	
	$result = ' and (';

	if ($h == 'not')
	{
		$h = 'and';
		if (strstr($w,'|'))
		{
			$warr	= explode('|' , $w);
			$wnm	= count($warr);

			for ($j = 0; $j < $knm; $j++)
			{
				if (!$karr[$j]) continue;

				for ($i = 0; $i < $wnm; $i++) if (strlen($karr[$j])>2) $result .= $warr[$i]."<>'".$karr[$j]."' ".$h.' ';
			}
		}
		else {
			for ($i = 0; $i < $knm; $i++) if (strlen($karr[$i])>2) $result .= $w."<>'".$karr[$i]."' ".$h.' ';
		}
	}
	else {
		if (strstr($w,'|'))
		{
			$warr	= explode('|' , $w);
			$wnm	= count($warr);

			for ($j = 0; $j < $knm; $j++)
			{
				if (!$karr[$j]) continue;

				for ($i = 0; $i < $wnm; $i++) if (strlen($karr[$j])>2) $result .= $warr[$i]." like '%".$karr[$j]."%' ".$h.' ';
			}
		}
		else {
			for ($i = 0; $i < $knm; $i++) if (strlen($karr[$i])>2) $result .= $w." like '%".$karr[$i]."%' ".$h.' ';
		}
	}
	$result = substr($result,0,strlen($result)-4).')';
	if($ik) $result .= getSearchSql($w,$ik,'',$h);
	return $result;
}
?>