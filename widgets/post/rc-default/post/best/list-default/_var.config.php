<?php
if(!defined('__KIMS__')) exit;

$d['widget']['dom'] = array(

	'new-list' => array(
		'기간별 인기 포스트 리스트형',  //위젯명
		array(
			array('title','input','타이틀','인기 포스트'),
			array('subtitle','input','보조 타이틀',''),
			array('show_header','select','헤더출력','출력=show,숨김=hide','show'),
			array('sort','select','정렬기준','조회순=hit,좋아요순=likes,댓글순=comment','hit'),
			array('term','select','출력기간','최근 1주=-1 week,최근 2주=-2 week,최근 3주=-3 week,최근 1달=-4 week'),
			array('vtype','select','보기타입','모달형=modal,페이지형=page','modal'),
			array('ranking','select','강조 랭킹표시','강조안함=false,전체강조=1000,1개=1,2개=2,3개=3,4개=4,5개=5,10개=10','3'),
			array('limit','select','출력수','5개=5,10개=10','5'),
		),
	),
);

?>
