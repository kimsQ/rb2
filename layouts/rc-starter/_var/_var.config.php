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
			array('type','select','타입','기본=postAllFeed,직접 꾸미기=widget'),
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

	'contact' => array(
		'고객센터',
		'',
		array(
			array('tel','input','전화번호',''),
			array('email','input','이메일',''),
			array('fax','input','팩스',''),
		),
	),

	'sns' => array(
		'소셜미디어',
		'URL을 입력하세요.',
		array(
			array('youtube','input','유튜브',''),
			array('instagram','input','인스타그램',''),
			array('facebook','input','페이스북',''),
			array('nblog','input','네이버블로그',''),
			array('ncafe','input','네이버카페',''),
			array('dcafe','input','다음카페',''),
			array('band','input','밴드',''),
		),
	),

);

$d['layout']['widget'] = array (

	'post' => array(
		'포스트',
		array(
			array('rc-default/post/post/all/list-default','최근 리스트 기본'),
			array('rc-default/post/post/all/list-highlight','최근 리스트 강조'),
			array('rc-default/post/post/all/gallery-default','최근 갤러리'),
			array('rc-default/post/post/all/gallery-grid','최근 그리드'),
			array('rc-default/post/post/all/gallery-gridSwipe','최근 그리드 스와이프'),
			array('rc-default/post/post/all/medialist-default','최근 미디어 리스트'),
			array('rc-default/post/post/all/swipe-default','최근 스와이프 기본'),
			array('rc-default/post/post/all/swipe-jumbotron','최근 스와이프 점보트론'),
			array('rc-default/post/post/all/swipe-multi','최근 스와이프 멀티'),

			array('rc-default/post/post/best/list-default','인기 리스트'),
			array('rc-default/post/post/best/list-highlight','인기 리스트 강조'),
			array('rc-default/post/post/best/medialist-default','인기 미디어 리스트'),
			array('rc-default/post/post/best/gallery-default','인기 갤러리'),
			array('rc-default/post/post/best/gallery-grid','인기 그리드'),
			array('rc-default/post/post/best/gallery-gridSwipe','인기 그리드 스와이프'),
			array('rc-default/post/post/best/swipe-default','인기 스와이프 기본'),
			array('rc-default/post/post/best/swipe-multi','인기 스와이프 멀티'),

			array('rc-default/post/post/tag/list-default','태그 리스트'),
			array('rc-default/post/post/tag/list-highlight','태그 리스트 강조'),

			array('rc-default/post/post/cat/list-default','카테고리 리스트'),

			array('rc-default/post/list/view/list-default','리스트뷰 리스트 기본'),
			array('rc-default/post/list/view/list-highlight','리스트뷰 리스트 강조'),
			array('rc-default/post/list/view/gallery-default','리스트뷰 갤러리'),

			// array('list/view-card','특정 리스트'),
			// array('list/req-banner','기간별 추천 포스트'),
			// array('list/req-swipe','최근 리스트'),
			// array('post/cat-collapse','특정 리스트'),
			// array('post/req-card','특정 키워드'),
			// array('post/req-swipe','특정 키워드'),
		),
	),


	'bbs' => array(
		'게시판',
		array(
			array('rc-default/bbs/all/list-default','최근 리스트 기본'),
		),
	),

	'member' => array(
		'프로필',
		array(
			array('rc-default/member/my/card-default','나의 프로필 카드')
		),
	),

	'site' => array(
		'사이트',
		array(
			array('rc-default/site/cover-default','사이트 커버 기본형')
		),
	),

	'search' => array(
		'검색',
		array(
			array('rc-default/search/tag/ranking-top10','기간별 주요 키워드')
		),
	),
);



//***********************************************************************************
?>
