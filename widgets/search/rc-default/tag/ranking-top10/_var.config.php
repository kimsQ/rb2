<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'ranking-top10' => array(
		'기간별 주요 키워드',  //위젯명
		array(
			array('title','input','타이틀','기간별 주요 키워드'),
			array('term','select','집계기간','최근 1주=-1 week,최근 2주=-2 week,최근 3주=-3 week,최근 1달=-4 week'),
		),
	),
);

?>
