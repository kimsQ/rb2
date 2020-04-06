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

$d['layout']['dom'] = array (

	/* 헤더 */
	'header' => array(
		'헤더',
		'',
		array(
			array('type','select','헤더 타입','타입1=type1,타입2=type2,타입3=type3'),
			array('title','input','사이트 제목',''),
			array('logo','file','이미지 로고',''),
			array('logo_size','input','이미지 로고 크기 (1~100% 숫자만)','84'),
			array('logo_position','select','이미지 로고 정렬','왼쪽=0,가운데=50,오른쪽=100','50'),
			array('position','select','헤더 고정','고정안함=static,고정함=fixed'),
			array('container','select','헤더 가로폭','보통(1000px)=container,넓게(1140px)=container-lg,아주넓게(1200px)=container-xl,와이드(100%)=container-fluid,좁게(940px)=container-sm,아주좁게(860px)=container-xs'),
			array('menu','select','메뉴','dropdown-hover=dropdown-hover,mega-2depth=mega-2depth,mega-3depth=mega-3depth,출력안함=false'),
			array('menu_limit','select','메뉴레벨','1차메뉴=1,2차메뉴=2,3차메뉴=3,출력안함=false','3'),
			array('allcat','select','전체 카테고리','출력=true,미출력=false'),
			array('search','select','검색 출력','입력형=input,버튼형=button,미출력=false'),
			array('login','select','로그인폼 출력','예=true,아니오=false'),
		),
	),

	'footer' => array(
		'풋터',
		'',
		array(
			array('container','select','가로폭','보통(1000px)=container,넓게(1140px)=container-lg,아주넓게(1200px)=container-xl,와이드(100%)=container-fluid,좁게(940px)=container-sm,아주좁게(860px)=container-xs'),
			array('type','select','타입','타입1=type1,타입2=type2,타입3=type3'),
			array('logo','file','이미지 로고',''),
			array('logo_size','input','이미지 로고 크기 (1~100% 숫자만)','84'),
			array('logo_gray','select','로고 흑백처리','처리함=true,처리안함=false','true'),
			array('link','menu','하단링크',''),
			array('family','menu','패밀리 사이트','')
		),
	),

	/* 메인 페이지 */
	'home' => array(
		'home',
		'데스크탑 메인페이지 설정을 관리합니다.',
		array(
			array('type','select','타입','기본=postAllFeed,직접 꾸미기=widget'),
			array('container','select','가로폭','보통(1000px)=container,넓게(1140px)=container-lg,아주넓게(1200px)=container-xl,와이드(100%)=container-fluid,좁게(940px)=container-sm,아주좁게(860px)=container-xs'),
			array('dashboard','select','로그인 후 대시보드 이동','아니오=false,예=true'),
		),
	),

	'default' => array(
		'default',
		'데스크탑 레이아웃 설정을 관리합니다.',
		array(
			array('container','select','가로폭','보통(1000px)=container,넓게(1140px)=container-lg,아주넓게(1200px)=container-xl,와이드(100%)=container-fluid,좁게(940px)=container-sm,아주좁게(860px)=container-xs'),
			array('bgcolor','select','배경색','흰색=bg-white,밝은회색=bg-light'),
			array('breadcrumb','select','경로표시','미출력=false,타입1=type1,타입2=type2'),
			array('titlebar','select','타이틀바','타입1=type1,타입2=type2,출력안함=false'),
			array('menutitle','select','메뉴 타이틀','타입1=type1,타입2=type2,출력안함=false'),
		),
	),

	'sidebar' => array(
		'sidebar',
		'데스크탑 레이아웃 설정을 관리합니다.',
		array(
			array('container','select','가로폭','보통(1000px)=container,넓게(1140px)=container-lg,아주넓게(1200px)=container-xl,와이드(100%)=container-fluid,좁게(940px)=container-sm,아주좁게(860px)=container-xs'),
			array('bgcolor','select','배경색','흰색=bg-white,밝은회색=bg-light'),
			array('breadcrumb','select','경로표시','미출력=false,타입1=type1,타입2=type2'),
			array('titlebar','select','타이틀바','타입1=type1,타입2=type2,출력안함=false'),
			array('menutitle','select','메뉴 타이틀','타입1=type1,타입2=type2,출력안함=false'),
		),
	),

	'docs' => array(
		'docs',
		'데스크탑 레이아웃 설정을 관리합니다.',
		array(
			array('container','select','가로폭','보통(1000px)=container,넓게(1140px)=container-lg,아주넓게(1200px)=container-xl,와이드(100%)=container-fluid,좁게(940px)=container-sm,아주좁게(860px)=container-xs'),
			array('bgcolor','select','배경색','흰색=bg-white,밝은회색=bg-light'),
			array('footer','select','전용풋터','타입1=type1,타입2=type2,타입3=type3'),
		),
	),

	'company' => array(
		'기업정보',
		'',
		array(
			array('name','input','회사명',''),
			array('ceo','input','대표자',''),
			array('num','input','사업자등록번호',''),
			array('num2','input','통신판매업 신고번호',''),
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
			array('hours','input','업무시간',''),
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
		),
	),

);

$d['layout']['widget'] = array (

	'post' => array(
		'포스트',
		array(
			array('bs4-default/post/post/best/card-default','기간별 추천 포스트'),
			array('bs4-default/post/post/new/card-default','최근 포스트'),
			array('bs4-default/post/post/tag/card-default','특정 키워드'),
			array('bs4-default/post/post/cat/card-default','특정 카테고리'),
			array('bs4-default/post/list/new/card-default','최근 리스트'),
			array('bs4-default/post/list/view/card-default','특정 리스트'),
		),
	),

	'bbs' => array(
		'게시판',
		array(
			array('bs4-default/bbs/all/list-default','최근 리스트 기본'),
			array('bs4-default/bbs/all/gallery-default','최근 갤러리 기본'),
		),
	),

	'mediaset' => array(
		'미디어셋',
		array(
			array('bs4-default/mediaset/banner/carousel-jumbo','배너 캐러셀 점보'),
			array('bs4-default/mediaset/banner/grid-default','배너 그리드 기본형'),
		),
	),

	'profile' => array(
		'채널',
		array(
			array('bs4-default/profile/best/card-default','기간별 추천채널')
		),
	),
);


//***********************************************************************************
?>
