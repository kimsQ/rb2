<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'list-default' => array(
		'최근 포스트 리스트 기본형',  //위젯명
		array(
			array('title','input','타이틀','최근 포스트'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('limit','select','출력수','3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10,11개=11,12개=12','4'),
			array('newtime','select','새글표시','1시간=1,3시간=3,6시간=6,12시간=12,24시간=24','6'),
			array('link','input','링크연결','/post')
		),
	),
);

?>
