<?php
if(!defined('__KIMS__')) exit;

$R = getUidData($table[$m.'data'],$uid);

if (!$my['uid']) getLink('','','로그인 해주세요.','');
if (!$R['uid']) getLink('','','존재하지 않는 포스트 입니다.','');

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
$_tmpvfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $_tmpvfile;


if(!getDbRows($table['s_mbrmonth'],"date='".$date['month']."' and site=".$s.' and mbruid='.$R['mbruid'])) {
  getDbInsert($table['s_mbrmonth'],'date,site,mbruid',"'".$date['month']."','".$s."','".$R['mbruid']."'");
}

if(!getDbRows($table['s_mbrday'],"date='".$date['today']."' and site=".$s.' and mbruid='.$R['mbruid'])) {
  getDbInsert($table['s_mbrday'],'date,site,mbruid',"'".$date['today']."','".$s."','".$R['mbruid']."'");
}

if(!getDbRows($table[$m.'month'],"date='".$date['month']."' and site=".$s.' and data='.$R['uid'])) {
  getDbInsert($table[$m.'month'],'date,site,data',"'".$date['month']."','".$s."','".$R['uid']."'");
}

if(!getDbRows($table[$m.'day'],"date='".$date['today']."' and site=".$s.' and data='.$R['uid'])) {
  getDbInsert($table[$m.'day'],'date,site,data',"'".$date['today']."','".$s."','".$R['uid']."'");
}

if ($send=='ajax') {

	$result=array();

	if (!$my['uid']) {
		$result['error']=true;
		$result['msg'] = '로그인해 주세요.';
		$result['msgType'] = 'danger';
		echo json_encode($result);
		exit;
	}
	if (!$R['uid']) {
		$result['error']=true;
		$result['msg'] = '잘못된 접근입니다.';
		$result['msgType'] = 'danger';
		echo json_encode($result);
		exit;
	}
	if ($d['post']['denylikemy'] && ($R['mbruid']==$my['uid'])) {
		$result['error']=true;
		$result['msg'] = '자신 글은 평가할 수 없습니다.';
		$result['msgType'] = 'danger';
		echo json_encode($result);
		exit;
	}

} else {

	if (!$my['uid']) {
		echo '<script type="text/javascript">';
		echo 'parent.$("#modal-login").modal();';
		echo '</script>';
	  exit;
	}
	if (!$R['uid']) exit;

	if ($d['post']['denylikemy'] && ($R['mbruid']==$my['uid'])) getLink('','','자신 글은 평가할 수 없습니다.','');
}

$mbruid = $my['uid'];

$check_like_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='like'";
$check_dislike_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='dislike'";

$is_liked = getDbRows($table['s_opinion'],$check_like_qry);
$is_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);

// 로그인한 사용자가 좋아요를 했는지 여부 체크하여 처리
if ($opinion=='like') {
	$opinion_type = '좋아요';
	if($is_liked){ // 좋아요를 했던 경우
		$opinion_act = '취소';
    $OP = getDbData($table['s_opinion'],$check_like_qry,'*');
		getDbDelete($table['s_opinion'],$check_like_qry);
		getDbUpdate($table[$m.'data'],'likes=likes-1','uid='.$uid);
		getDbUpdate($table['s_mbrdata'],'likes_post=likes_post-1','memberuid='.$R['mbruid']);
		getDbUpdate($table['s_mbrmonth'],'post_likes=post_likes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 조회수 갱신
		getDbUpdate($table['s_mbrday'],'post_likes=post_likes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별조회수 갱신
		getDbUpdate($table[$m.'month'],'likes=likes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 좋아요수 갱신
		getDbUpdate($table[$m.'day'],'likes=likes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 좋아요수 갱신

	}else{ // 좋아요 안한 경우 추가
		$opinion_act = '추가';
		$QKEY = "mbruid,module,entry,opinion,d_regis";
		$QVAL = "'$mbruid','$m','$uid','like','".$date['totime']."'";
		getDbInsert($table['s_opinion'],$QKEY,$QVAL);
		getDbUpdate($table[$m.'data'],'likes=likes+1','uid='.$uid);
		getDbUpdate($table['s_mbrdata'],'likes_post=likes_post+1','memberuid='.$R['mbruid']);
		getDbUpdate($table['s_mbrmonth'],'post_likes=post_likes+1',"date='".$date['month']."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 조회수 갱신
		getDbUpdate($table['s_mbrday'],'post_likes=post_likes+1',"date='".$date['today']."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별조회수 갱신
		getDbUpdate($table[$m.'month'],'likes=likes+1',"date='".$date['month']."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 좋아요수 갱신
		getDbUpdate($table[$m.'day'],'likes=likes+1',"date='".$date['today']."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 좋아요수 갱신

		if ($is_disliked) {
      $OP = getDbData($table['s_opinion'],$check_dislike_qry,'*');
			getDbDelete($table['s_opinion'],$check_dislike_qry);
			getDbUpdate($table[$m.'data'],'dislikes=dislikes-1','uid='.$uid);
      getDbUpdate($table['s_mbrdata'],'dislikes_post=dislikes_post-1','memberuid='.$R['mbruid']);
      getDbUpdate($table['s_mbrmonth'],'post_dislikes=post_dislikes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 싫어요수 갱신
      getDbUpdate($table['s_mbrday'],'post_dislikes=post_dislikes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별 싫어요수 갱신
      getDbUpdate($table[$m.'month'],'dislikes=dislikes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 싫어요수 갱신
      getDbUpdate($table[$m.'day'],'dislikes=dislikes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 싫어요수 갱신
		}
	}
}

// 로그인한 사용자가 싫어요를 했는지 여부 체크하여 처리
if ($opinion=='dislike') {
	$opinion_type = '싫어요';
	if($is_disliked){ // 싫어요를 했던 경우
		$opinion_act = '취소';
    $OP = getDbData($table['s_opinion'],$check_dislike_qry,'*');
		getDbDelete($table['s_opinion'],$check_dislike_qry);
		getDbUpdate($table[$m.'data'],'dislikes=dislikes-1','uid='.$uid);
    getDbUpdate($table['s_mbrdata'],'dislikes_post=dislikes_post-1','memberuid='.$R['mbruid']);
    getDbUpdate($table['s_mbrmonth'],'post_dislikes=post_dislikes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 싫어요수 갱신
    getDbUpdate($table['s_mbrday'],'post_dislikes=post_dislikes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별 싫어요수 갱신
    getDbUpdate($table[$m.'month'],'dislikes=dislikes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 싫어요수 갱신
    getDbUpdate($table[$m.'day'],'dislikes=dislikes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 싫어요수 갱신

	}else{ // 싫어요를 안한 경우 추가
		$opinion_act = '추가';
		$QKEY = "mbruid,module,entry,opinion,d_regis";
		$QVAL = "'$mbruid','$m','$uid','dislike','".$date['totime']."'";
		getDbInsert($table['s_opinion'],$QKEY,$QVAL);
		getDbUpdate($table[$m.'data'],'dislikes=dislikes+1','uid='.$uid);
    getDbUpdate($table['s_mbrdata'],'dislikes_post=dislikes_post+1','memberuid='.$R['mbruid']);
    getDbUpdate($table['s_mbrmonth'],'post_dislikes=post_dislikes+1',"date='".$date['month']."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 싫어요수 갱신
    getDbUpdate($table['s_mbrday'],'post_dislikes=post_dislikes+1',"date='".$date['today']."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별 싫어요수 갱신
    getDbUpdate($table[$m.'month'],'dislikes=dislikes+1',"date='".$date['month']."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 싫어요수 갱신
    getDbUpdate($table[$m.'day'],'dislikes=dislikes+1',"date='".$date['today']."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 싫어요수 갱신

		if ($is_liked) {
      $OP = getDbData($table['s_opinion'],$check_like_qry,'*');
			getDbDelete($table['s_opinion'],$check_like_qry);
			getDbUpdate($table[$m.'data'],'likes=likes-1','uid='.$uid);
			getDbUpdate($table['s_mbrdata'],'likes_post=likes_post-1','memberuid='.$R['mbruid']);
			getDbUpdate($table['s_mbrmonth'],'post_likes=post_likes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 월별 조회수 갱신
			getDbUpdate($table['s_mbrday'],'post_likes=post_likes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and mbruid='.$R['mbruid']); //회원별 일별조회수 갱신
			getDbUpdate($table[$m.'month'],'likes=likes-1',"date='".substr($OP['d_regis'],0,6)."' and site=".$s.' and data='.$R['uid']); //포스트별 월별 조회수 갱신
			getDbUpdate($table[$m.'day'],'likes=likes-1',"date='".substr($OP['d_regis'],0,8)."' and site=".$s.' and data='.$R['uid']);  //포스트별 일별 조회수 갱신
		}
	}
}

// 포스트 등록자에게 알림전송
if ($d['post']['noti_opinion']) {
	$B = getDbData($table['postlist'],'id="'.$R['postid'].'"','name');
	$referer = $g['url_http'].'/'.$r.'/b/'.$bid.'/'.$uid;

	include $g['dir_module'].'var/noti/_'.$a.'.php';  // 알림메시지 양식
	$noti_title = $d['post']['noti_title'];
	$noti_title = str_replace('{post}',$name,$noti_title);
	$noti_title = str_replace('{OPINION_TYPE}',$opinion_type,$noti_title);
	$noti_title = str_replace('{OPINION_ACT}',$opinion_act,$noti_title);
	$noti_title = str_replace('{MEMBER}',$my[$_HS['nametype']],$noti_title);

	$noti_body = $d['post']['noti_body'];
	$noti_body = str_replace('{MEMBER}',$my[$_HS['nametype']],$noti_body);
	$noti_body = str_replace('{SUBJECT}',$R['subject'],$noti_body);
	$noti_referer = $g['url_http'].'/?r='.$r.'&mod=settings&page=noti';
	$noti_button = '게시물 확인';
	$noti_tag = '';
	$noti_skipEmail = 0;
	$noti_skipPush = 0;

	putNotice($R['mbruid'],$m,$my['uid'],$noti_title,$noti_body,$noti_referer,$noti_button,$noti_tag,$noti_skipEmail,$noti_skipPush);
}

$R = getUidData($table[$m.'data'],$uid);

// getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','2','글추천 포인트 by ".$my['nic']."님 (".getStrCut($R['subject'],15,'').")','".$date['totime']."'");
// getDbUpdate($table['s_mbrdata'],'point=point+2','memberuid='.$R['mbruid']);

if ($send=='ajax') {

	$result['error']=false;

	if ($is_liked) $result['is_post_liked'] = 1;
	else $result['is_post_liked'] = 0;

	if ($is_disliked) $result['is_post_disliked'] = 1;
	else $result['is_post_disliked'] = 0;

	$result['likes'] = $R['likes'];
	$result['dislikes'] = $R['dislikes'];

	echo json_encode($result);
	exit;
}
?>


<script>

<?php if ($opinion=='like'): ?>
	<?php if ($is_liked): ?>
	parent.$("[data-role=btn_post_like_<?php echo $uid?>]").removeClass("active <?php echo $effect ?>");
	<?php else: ?>
	parent.$("[data-role=btn_post_like_<?php echo $uid?>]").addClass("active <?php echo $effect ?>");
	<?php endif; ?>

	<?php if ($is_disliked): ?>
	parent.$("[data-role=btn_post_dislike_<?php echo $uid?>]").removeClass("active <?php echo $effect ?>");
	<?php endif; ?>
<?php endif; ?>

<?php if ($opinion=='dislike'): ?>
	<?php if ($is_disliked): ?>
	parent.$("[data-role=btn_post_dislike_<?php echo $uid?>]").removeClass("active <?php echo $effect ?>");
	<?php else: ?>
	parent.$("[data-role=btn_post_dislike_<?php echo $uid?>]").addClass("active <?php echo $effect ?>");
	<?php endif; ?>

	<?php if ($is_liked ): ?>
	parent.$("[data-role=btn_post_like_<?php echo $uid?>]").removeClass("active");
	<?php endif; ?>
<?php endif; ?>

parent.$("[data-role='likes_<?php echo $uid?>']").text('<?php echo $R['likes']?>');
parent.$("[data-role='dislikes_<?php echo $uid?>']").text('<?php echo $R['dislikes']?>');

window.parent.$.notify({

<?php if ($opinion=='like'): ?>
	<?php if ($is_liked): ?>
	message: "좋아요가 취소 되었습니다."
	<?php else:?>
	message: "좋아요가 추가 되었습니다."
	<?php endif; ?>
<?php else: ?> // 싫어요
	<?php if ($is_disliked): ?>
	message: "싫어요가 취소 되었습니다."
	<?php else:?>
	message: "싫어요가 추가 되었습니다."
	<?php endif; ?>
<?php endif; ?>

},{
	placement: {
		from: "bottom",
		align: "center"
	},
	allow_dismiss: false,
	offset: 20,
	type: "default",
	timer: 100,
	delay: 1500,
	animate: {
		enter: "animated fadeInUp",
		exit: "animated fadeOutDown"
	}
});

</script>
<?php
exit;
?>
