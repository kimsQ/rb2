<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'new-medialist' => array(
		'최근 포스트 미디어 리스트형',  //위젯명
		array(
			array('title','input','타이틀','최근 포스트'),
			array('margin_top','select','상단여백','적용=true,미적용=false','true'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('thumb','select','섬네일 종류','대표 이미지=thumb,프로필 이미지=avatar','thumb'),
			array('media_align','select','섬네일 정렬','좌측=left,우측=right','left'),
			array('timeago','select','등록일시 표시','상대시간 표기=true,날짜/시간 표기=false','false'),
			array('duration','select','동영상 표시','재생시간 표시=show,재생버튼 표시=hide','hide'),
			array('limit','select','출력수','3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10,11개=11,12개=12','4'),
			array('link','input','링크연결',RW('m=post&mod=list'))
		),
	),
);

?>
