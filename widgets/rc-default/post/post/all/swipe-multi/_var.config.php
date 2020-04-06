<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'swipe-multi' => array(
		'최근 포스트 스와이프 멀티형',  //위젯명
		array(
			array('title','input','타이틀','최근 포스트'),
			array('margin_top','select','상단여백','적용=true,미적용=false','true'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('author','select','등록자 표시','표시함=true,표시안함=false','false'),
			array('duration','select','동영상 표시','재생시간 표시=show,재생버튼 표시=hide','hide'),
			array('perview','select','한화면 표시 아이템수','1개반=80%,2개반=40%','40%'),
			array('limit','select','출력 항목수','2개=2,3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10','5'),
			array('link','input','링크연결','/post')
		),
	),
);

?>
