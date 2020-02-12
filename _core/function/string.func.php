<?php
//문자열형태소추출
function getSiKey($singer)
{
	$singer_set1 = "ㄱ,ㄴ,ㄷ,ㄹ,ㅁ,ㅂ,ㅅ,ㅇ,ㅈ,ㅊ,ㅋ,ㅍ,ㅌ,ㅎ";
	$singer_set2 = "가,나,다,라,마,바,사,아,자,차,카,타,파,하";
	$singer_set3 = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
	$singer_arr1 = explode(',' , $singer_set1);
	$singer_arr2 = explode(',' , $singer_set2);
	$singer_arr3 = explode(',' , $singer_set3);

	$singer_sub = substr(strtoupper($singer) , 0 , 2);
	$singer_ord = ord($singer_sub);

	if ($singer_ord > 64 && $singer_ord < 91)
	{ // 영문
		
		for($i = 0; $i < 26; $i++)
		{
			if($singer_sub >= $singer_arr3[$i])
			{
				$key = $singer_arr3[$i];
			}
		}
	}
	else {
		$key = "기타";
		for($i = 0; $i < 14; $i++)
		{
			if ($singer_sub >= $singer_arr2[$i])
			{
				$key = $singer_arr1[$i];
			}
		}
	}
	return $key;
}
?>