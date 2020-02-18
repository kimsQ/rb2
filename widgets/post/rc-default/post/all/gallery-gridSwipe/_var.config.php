<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'gallery-gridSwipe' => array(
		'최근 포스트 그리드 스와이프',  //위젯명
		array(
			array('title','input','타이틀','최근 포스트'),
			array('margin_top','select','상단여백','적용=true,미적용=false','true'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('author','select','등록자 표시','표시함=true,표시안함=false','false'),
			array('duration','select','동영상 표시','재생시간 표시=show,재생버튼 표시=hide','hide'),
			array('limit','select','총 출력 항목수','6개=6,12개=12,18개=18','12'),
			array('swipe','select','스와이프 사용','사용함=true,사용안함=false','false'),
			array('link','input','링크연결','/post')
		),
	),
);

?>
