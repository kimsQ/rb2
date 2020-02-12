<?php
if(!defined('__KIMS__')) exit;

$R = getUidData($table[$m.'data'],$uid);

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
		$result['msg'] = '삭제되었거나 존재하지 않는 포스트입니다.';
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
	if (!$R['uid']) getLink('','','삭제되었거나 존재하지 않는 포스트입니다.','');
}

$mbruid		= $my['uid'];
$module 	= $m;
$category	= $_HM['name']?$_HM['name']:$B['name'];
$entry		= $R['uid'];
$subject	= addslashes($R['subject']);
$url	    = getLinkFilter($g['s'].'/?'.($_HS['usescode']?'r='.$r.'&amp;':'').($c?'c='.$c:'m='.$m),array('bid','uid','skin','iframe'));
$d_regis	= $date['totime'];

$check_saved_qry = "mbruid='".$mbruid."' and module='".$module."' and entry='".$entry."'";
$is_saved = getDbRows($table['s_saved'],$check_saved_qry);

if ($is_saved){ // 이미 저장했던 경우
	getDbDelete($table['s_saved'],$check_saved_qry);
}else{ // 저장을 안한 경우 추가
	$_QKEY = 'mbruid,module,category,entry,subject,url,d_regis';
	$_QVAL = "'$mbruid','$module','$category','$entry','$subject','$url','$d_regis'";
	getDbInsert($table['s_saved'],$_QKEY,$_QVAL);
}

if ($send=='ajax') {

	$result['error']=false;

	if ($is_saved) $result['is_post_saved'] = 1;
	else $result['is_post_saved'] = 0;

	echo json_encode($result);
	exit;
}
?>

<script>

<?php if ($is_saved): ?>
parent.$("[data-role=btn_post_saved]").removeClass("active");
<?php else: ?>
parent.$("[data-role=btn_post_saved]").addClass("active");
<?php endif; ?>

window.parent.$.notify({

<?php if ($is_saved): ?>
message: "포스트이 저장함에서 삭제되었습니다."
<?php else:?>
message: "포스트이 저장함에 추가되었습니다."
<?php endif; ?>

},{
	placement: {
		from: "bottom",
		align: "center"
	},
	allow_dismiss: false,
	offset: 20,
	type: "success",
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
