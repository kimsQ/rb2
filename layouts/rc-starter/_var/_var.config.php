<?php
if(!defined('__KIMS__')) exit;

//***********************************************************************************
// 여기에 이 레이아웃에서 사용할 변수들을 정의합니다.
// 변수 작성법은 매뉴얼을 참고하세요.
//***********************************************************************************

$d['layout']['show'] = true; // 관리패널에 레이아웃 관리탭을 보여주기
$d['layout']['date'] = false;  // 데이트픽커 사용

//***********************************************************************************
// 설정배열
//***********************************************************************************

$d['layout']['dom'] = array(

	/* 헤더 */
	'header' => array(
		'헤더',
		'',
		array(
			array('title','input','사이트 제목',''),
			array('file','file','이미지 로고',''),
			array('search','select','검색버튼 출력','예=true,아니오=false'),
			array('noti','select','알림버튼 출력','예=true,아니오=false'),
		),
	),

	/* 메인 페이지 */
	'main' => array(
		'메인',
		'',
		array(
			array('type','select','타입','최신 포스트 피드=postFeed,직접 꾸미기=widget'),
		),
	),

	'company' => array(
		'기업정보',
		'',
		array(
			array('name','input','회사명',''),
			array('ceo','input','대표자',''),
			array('num','input','사업자등록번호',''),
			array('num2','input','통신판매업',''),
			array('manager','input','개인정보보호책임자',''),
			array('addr','textarea','주소','3'),

		),
	),

	'sns' => array(
		'소셜미디어',
		'URL을 입력하세요.',
		array(
			array('instagram','input','인스타그램',''),
			array('facebook','input','페이스북',''),
			array('nblog','input','네이버블로그',''),
			array('youtube','input','유튜브',''),
		),
	),

	'contact' => array(
		'고객센터',
		'',
		array(
			array('tel','input','전화번호',''),
			array('email','input','이메일',''),
			array('fax','input','팩스',''),
		),
	),


);

$d['layout']['widget'] = array (

	'post' => array(
		'포스트',
		array(
			array('rc-list-view-card','특정 리스트'),
			array('rc-list-req-banner','기간별 추천 포스트'),
			array('rc-list-req-list','최근 포스트'),
			array('rc-list-req-swipe','최근 리스트'),
			array('rc-post-cat-collapse','특정 리스트'),
			array('rc-post-new-col6','특정 카테고리'),
			array('rc-post-req-card','특정 키워드'),
			array('rc-post-req-swipe','특정 키워드'),
		),
	),

	'bbs' => array(
		'게시판',
		array(
			array('rc-bbs-list-01','게시판 리스트형-01'),
			array('rc-bbs-media-01','게시판 미디어-01'),
		),
	),

	'profile' => array(
		'채널',
		array(
			array('bs4-best-card','기간별 추천채널')
		),
	),
);



//***********************************************************************************
?>
