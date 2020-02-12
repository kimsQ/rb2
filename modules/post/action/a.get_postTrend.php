<?php
if(!defined('__KIMS__')) exit;

$R = getUidData($table[$m.'data'],$uid);

if (!$my['uid'] || !$R['uid']) {
	getLink('','','정상적인 접근이 아닙니다.','');
}

$result=array();
$result['error'] = false;

$data = array();

$new_date = date("Ymd", strtotime($d_start.' -1 '.$unit));

// 디바이스별 접속구분
if ($mod=='device') {

	$type = 'pie';

	$mobile=0;
	$desktop=0;

	while(true) {
		if ($unit=='month') {
			$_new_date = date("Y/m", strtotime($new_date. '+1 month'));
			$new_date = date("Ymd", strtotime($new_date. '+1 month'));
		} else {
			$_new_date = date("m/d", strtotime($new_date. '+1 day'));
			$new_date = date("Ymd", strtotime($new_date. '+1 day'));
		}
		$_R = getDbData($table[$m.$unit],'date ='.$new_date.' and data='.$R['uid'],'*');
		$mobile+=$_R['mobile'];
		$desktop+=$_R['desktop'];

		if ($unit=='month') {
		  if(substr($new_date,0,6) == date('Ym', strtotime("now"))) break;
		} else {
		  if($new_date == date('Ymd', strtotime("now"))) break;
		}

	}

	$data['labels'] =  array ('모바일','데스크탑');
	$data['datasets']= array (
		array (
			'label' => '디바이스별 접속 현황',
			'backgroundColor' => array('#007bff', '#563d7c'),
			'data' => array($mobile, $desktop)
		)
	);

}

// 내외부 접속구분
if ($mod=='side') {

	$type='pie';
	$outside=0;
	$inside=0;

	while(true) {
		if ($unit=='month') {
			$_new_date = date("Y/m", strtotime($new_date. '+1 month'));
			$new_date = date("Ymd", strtotime($new_date. '+1 month'));
		} else {
			$_new_date = date("m/d", strtotime($new_date. '+1 day'));
			$new_date = date("Ymd", strtotime($new_date. '+1 day'));
		}
		$_R = getDbData($table[$m.$unit],'date ='.$new_date.' and data='.$R['uid'],'*');
		$outside+=$_R['outside'];
		$inside+=$_R['inside'];
		if ($unit=='month') {
		  if(substr($new_date,0,6) == date('Ym', strtotime("now"))) break;
		} else {
		  if($new_date == date('Ymd', strtotime("now"))) break;
		}
	}

	$data['labels'] =  array ('외부 및 직접접속','내부');
	$data['datasets']= array (
		array (
			'label' => '접속구분',
			'backgroundColor' => array('#007bff', '#555'),
			'data' => array($outside, $inside)
		)
	);

}

// 외부 유입추이
if ($mod=='referer') {

	$type='bar';
	$inside=0;$yt=0;$kt=0;$ks=0;$bd=0;$ig=0;$fb=0;$tt=0;$nb=0;$etc=0;

	while(true) {
		if ($unit=='month') {
			$_new_date = date("Y/m", strtotime($new_date. '+1 month'));
			$new_date = date("Ymd", strtotime($new_date. '+1 month'));
		} else {
			$_new_date = date("m/d", strtotime($new_date. '+1 day'));
			$new_date = date("Ymd", strtotime($new_date. '+1 day'));
		}
		$_R = getDbData($table[$m.$unit],'date ='.$new_date.' and data='.$R['uid'],'*');
		$inside+=$_R['inside'];
		$yt+=$_R['yt'];
		$kt+=$_R['kt'];
		$ks+=$_R['ks'];
		$bd+=$_R['bd'];
		$ig+=$_R['ig'];
		$fb+=$_R['fb'];
		$tt+=$_R['tt'];
		$nb+=$_R['nb'];
		if ($unit=='month') {
		  if(substr($new_date,0,6) == date('Ym', strtotime("now"))) break;
		} else {
		  if($new_date == date('Ymd', strtotime("now"))) break;
		}
	}

	$etc = $R['hit']-($yt+$kt+$ks+$bd+$ig+$fb+$tt+$nb)-$inside;

	$data['labels'] =  array ('내부','유튜브','카카오톡','카카오스토리','밴드','인스타그램','페이스북','트위터','네이버 블로그','기타');
	$data['datasets']= array (
		array (
			'label' => '내부유입',
			'backgroundColor' => array('#888888','#ff0000', '#e4d533','#ff9400', '#1bcc21','#b50189', '#3a5896','#007bff','#40cd19','#444444'),
			'data' => array($inside,$yt,$kt,$ks,$bd,$ig,$fb,$tt,$nb,$etc)
		)
	);

	$options['scales']['yAxes'] = array (array('display'=>true,'scaleLabel' => array ('display'=>true,'labelString'=>'유입수')));

}


if ($mod=='hit' || $mod=='likes' || $mod=='dislikes' || $mod=='comment') {

	$labelsArray = array ();
	$dataArray = array ();
	$dataytArray = array ();
	$dataktArray = array ();
	$dataksArray = array ();
	$databdArray = array ();
	$dataigArray = array ();
	$datafbArray = array ();
	$datattArray = array ();
	$datanbArray = array ();
	$yt=0;$kt=0;$ks=0;$bd=0;$ig=0;$fb=0;$tt=0;$nb=0;

	while(true) {
		if ($unit=='month') {
			$_new_date = date("Y/m", strtotime($new_date. '+1 month'));
			$new_date = date("Ymd", strtotime($new_date. '+1 month'));
		} else {
			$_new_date = date("m/d", strtotime($new_date. '+1 day'));
			$new_date = date("Ymd", strtotime($new_date. '+1 day'));
		}

		$_R = getDbData($table[$m.$unit],'date ='.$new_date.' and data='.$R['uid'],'*');
		array_push($labelsArray, $_new_date);
		array_push($dataArray,  $_R[$mod]?$_R[$mod]:0);
		array_push($dataytArray,  $_R['yt']?$_R['yt']:0);$yt+=$_R['yt'];
		array_push($dataktArray,  $_R['kt']?$_R['kt']:0);$kt+=$_R['kt'];
		array_push($dataksArray,  $_R['ks']?$_R['ks']:0);$ks+=$_R['ks'];
		array_push($databdArray,  $_R['bd']?$_R['bd']:0);$bd+=$_R['bd'];
		array_push($dataigArray,  $_R['ig']?$_R['ig']:0);$ig+=$_R['ig'];
		array_push($datafbArray,  $_R['fb']?$_R['fb']:0);$fb+=$_R['fb'];
		array_push($datattArray,  $_R['tt']?$_R['tt']:0);$tt+=$_R['tt'];
		array_push($datanbArray,  $_R['nb']?$_R['nb']:0);$nb+=$_R['nb'];
		if ($unit=='month') {
		  if(substr($new_date,0,6) == date('Ym', strtotime("now"))) break;
		} else {
		  if($new_date == date('Ymd', strtotime("now"))) break;
		}
	}

	$type='line';
	$data['labels'] =  $labelsArray;

	if ($mod=='hit') {

		$data['datasets']= array (
			array (
				'label' => '조회수',
				'borderColor' => array('#999999'),
				'backgroundColor' => array('#999999'),
				'data' => $dataArray,
				'fill' => false,
			)
		);

		if ($yt) {
			array_push($data['datasets'], array (
				'label' => '유튜브',
				'borderColor' => array('#ff0000'),
				'backgroundColor' => array('#ff0000'),
				'data' => $dataytArray,
				'fill' => false,
			));
		}

		if ($kt) {
			array_push($data['datasets'], array (
				'label' => '카카오톡',
				'borderColor' => array('#e4d533'),
				'backgroundColor' => array('#e4d533'),
				'data' => $dataktArray,
				'fill' => false,
			));
		}

		if ($ks) {
			array_push($data['datasets'], array (
				'label' => '카카오스토리',
				'borderColor' => array('#ff9400'),
				'backgroundColor' => array('#ff9400'),
				'data' => $dataksArray,
				'fill' => false,
			));
		}

		if ($bd) {
			array_push($data['datasets'], array (
				'label' => '밴드',
				'borderColor' => array('#1bcc21'),
				'backgroundColor' => array('#1bcc21'),
				'data' => $databdArray,
				'fill' => false,
			));
		}

		if ($ig) {
			array_push($data['datasets'], array (
				'label' => '인스타그램',
				'borderColor' => array('#b50189'),
				'backgroundColor' => array('#b50189'),
				'data' => $dataigArray,
				'fill' => false,
			));
		}

		if ($fb) {
			array_push($data['datasets'], array (
				'label' => '페이스북',
				'borderColor' => array('#3a5896'),
				'backgroundColor' => array('#3a5896'),
				'data' => $datafbArray,
				'fill' => false,
			));
		}

		if ($tt) {
			array_push($data['datasets'], array (
				'label' => '트위터',
				'borderColor' => array('#007bff'),
				'backgroundColor' => array('#007bff'),
				'data' => $datattArray,
				'fill' => false,
			));
		}

		if ($nb) {
			array_push($data['datasets'], array (
				'label' => '네이버 블로그',
				'borderColor' => array('#40cd19'),
				'backgroundColor' => array('#40cd19'),
				'data' => $datanbArray,
				'fill' => false,
			));
		}

		$options['scales']['xAxes'] = array (array('display'=>true,'scaleLabel' => array ('display'=>true,'labelString'=>'기간')));
		$options['scales']['yAxes'] = array (array('display'=>true,'scaleLabel' => array ('display'=>true,'labelString'=>'외부 유입수')));
		// $options['tooltips'] =  array ('mode'=>'index');

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

}

$result['type'] = $type;
$result['data'] = $data;
$result['options'] = $options;

echo json_encode($result);
exit;
?>
