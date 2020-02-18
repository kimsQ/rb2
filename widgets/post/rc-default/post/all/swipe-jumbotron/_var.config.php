<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'swipe-jumbotron' => array(
		'최근 포스트 스와이프 점보트론',  //위젯명
		array(
			array('title','hidden','타이틀','최근 포스트 스와이프 점보트론'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('autoplay','select','자동실행','사용함=true,사용안함=false','false'),
			array('mask','select','이미지 마스크','사용함=show,사용안함=hide','hide'),
			array('subject','select','제목출력','출력함=show,출력안함=hide','hide'),
			array('effect','select','이펙트','슬라이드=slide,페이드=fade','slide'),
			array('limit','select','출력 항목수','2개=2,4개=4,6개=6,8개=8,10개=10,12개=12','4'),
		),
	),
);

?>
