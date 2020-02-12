<?php
if(!defined('__KIMS__')) exit;


$sort = 'gid'; // 정렬 기준
$orderby = 'asc'; // 정렬순서
$recnum = 100; // 출력갯수

$where = 'parent='.$parent.' and hidden=0';

$RCD = getDbArray($table[$m.'category'],$where,'*',$sort,$orderby,$recnum,1);
$NUM = getDbRows($table[$m.'category'],$where);

$result=array();
$result['error']=false;

$nav_links='';
$swiper_slides='';
$nav_links.='<div class="nav-link swiper-slide" data-category="'.$parent.'">전체보기</div>';
$swiper_slides='<div class="swiper-slide" data-category="'.$parent.'"></div>';
while($R = db_fetch_array($RCD)){
  $nav_links.='<div class="nav-link swiper-slide" data-category="'.$R['uid'].'">'.$R['name'].'</div>';
  $swiper_slides.='<div class="swiper-slide" data-category="'.$R['uid'].'"></div>';
}

$result['nav_links'] = $nav_links;
$result['swiper_slides'] = $swiper_slides;
$result['num'] = $NUM;

echo json_encode($result);
exit;
?>
