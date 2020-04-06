<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'list-default' => array(
		'포스트 카테고리 리스트 기본형',  //위젯명
		array(
			array('cat','postcat','카테고리',''),
			array('title','input','타이틀',''),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('margin_top','select','상단여백','적용=true,미적용=false','true'),
			array('sort','select','정렬순서','등록순=gid,조회순=hit,좋아요순=likes,댓글순=comment','gid'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('newtime','select','새글표시','1시간=1,3시간=3,6시간=6,12시간=12,24시간=24','6'),
			array('limit','select','출력수','3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10,11개=11,12개=12','4'),
		),
	),
);

?>
