<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'ranking-top10' => array(
		'기간별 주요 키워드',  //위젯명
		array(
			array('title','input','타이틀','기간별 주요 키워드'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('limit','select','출력수','3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10,11개=11,12개=12','4'),
		),
	),
);

?>
