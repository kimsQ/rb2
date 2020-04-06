<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'view-list' => array(
		'리스트뷰 리스트 기본',  //위젯명
		array(
			array('listid','postlist','내 리스트',''),
			array('title_badge','input','타이틀 라벨','이슈'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('margin_top','select','상단여백','적용=true,미적용=false','true'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('limit','select','출력 항목수','1개=1,2개=2,3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10,11개=11,12개=12','4'),
		),
	),
);

?>
