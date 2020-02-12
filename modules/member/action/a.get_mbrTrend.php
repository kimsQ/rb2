<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) {
	getLink('','','정상적인 접근이 아닙니다.','');
}

$result=array();
$result['error'] = false;

$labelArray = [];
$dataArray = [];

$data = array();

$new_date = date("Ymd", strtotime($d_start.' -1 day'));

$labelsArray = array ();
$dataArray = array ();
$followerArray = array ();

$follower=0;

while(true) {
	$_new_date = date("m/d", strtotime($new_date. '+1 day'));
	$new_date = date("Ymd", strtotime($new_date. '+1 day'));

	$_R = getDbData($table['s_mbrday'],'date ='.$new_date.' and mbruid='.$my['uid'],'*');
	array_push($labelsArray, $_new_date);
	array_push($dataArray,  $_R['post_'.$mod]?$_R['post_'.$mod]:0);
	array_push($followerArray,  $_R['follower']?$_R['follower']:0);$follower+=$_R['follower'];

	if($new_date == date('Ymd', strtotime("now"))) break;
}

$type='line';
$data['labels'] =  $labelsArray;

if ($mod=='hit') {

	$data['datasets']= array (
		array (
			'label' => '조회수',
			'borderColor' => array('#004085'),
			'backgroundColor' => array('#cce5ff'),
			'data' => $dataArray,
			'fill' => true,
		)
	);

}

if ($mod=='likes') {
	$data['datasets']= array (
		array (
			'label' => '좋아요 추이',
			'backgroundColor' => array('#d4edda'),
			'borderColor' => array('#155724'),
			'data' => $dataArray
		)
	);
}

if ($mod=='dislikes') {
	$data['datasets']= array (
		array (
			'label' => '싫어요 추이',
			'backgroundColor' => array('#f8d7da'),
			'borderColor' => array('#721c24'),
			'data' => $dataArray
		)
	);
}

if ($mod=='comment') {
	$data['datasets']= array (
		array (
			'label' => '댓글 추이',
			'backgroundColor' => array('#fff3cd'),
			'borderColor' => array('#856404'),
			'data' => $dataArray
		)
	);
}

if ($mod=='follower') {
	$data['datasets']= array (
		array (
			'label' => '구독자 추이',
			'backgroundColor' => array('#d1ecf1'),
			'borderColor' => array('#0c5460'),
			'data' => $followerArray
		)
	);
}

$result['type'] = $type;
$result['data'] = $data;
$result['options'] = $options;

echo json_encode($result);
exit;
?>
