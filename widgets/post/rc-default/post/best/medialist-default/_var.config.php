<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'new-medialist' => array(
		'인기 포스트 미디어 리스트형',
		array(
			array('title','input','타이틀','인기 포스트'),
			array('subtitle','input','보조 타이틀',''),
			array('margin_top','select','상단여백','적용=true,미적용=false','true'),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('sort','select','정렬기준','조회순=hit,좋아요순=likes,댓글순=comment','hit'),
			array('term','select','출력기간','최근 1주=-1 week,최근 2주=-2 week,최근 3주=-3 week,최근 1달=-4 week'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('thumb','select','섬네일 종류','대표 이미지=thumb,프로필 이미지=avatar','thumb'),
			array('media_align','select','섬네일 정렬','좌측=left,우측=right','right'),
			array('timeago','select','등록일시 표시','상대시간 표기=true,날짜/시간 표기=false','false'),
			array('duration','select','동영상 표시','재생시간 표시=show,재생버튼 표시=hide','hide'),
			array('ranking','select','강조 랭킹표시','강조안함=false,전체강조=1000,1개=1,2개=2,3개=3,4개=4,5개=5,10개=10','3'),
			array('limit','select','출력수','3개=3,4개=4,5개=5,6개=6,7개=7,8개=8,9개=9,10개=10,11개=11,12개=12','5'),
		),
	),
);

?>
