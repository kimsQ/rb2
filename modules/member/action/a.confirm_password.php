<?php
if(!defined('__KIMS__')) exit; // 비정상적인 접근을 차단

if (!$my['uid']) getLink('','','회원만 접근할 수 있습니다.',''); // 회원만 접근 허용할 경우

$M = getDbData($table['s_mbrid'],"id='".$id."'",'*');
$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');

if ($M['pw'] != getCrypt($pw,$M1['d_regis']))
{
	echo '<script type="text/javascript">';
	echo 'parent.$("#password").addClass("is-invalid").val("").focus();';
	echo 'parent.$(".alert").removeClass("d-none");';
	echo 'parent.$("#passwordErrorBlock").html("잘못된 비밀번호입니다. 다시 시도하세요.");';
	echo '</script>';
	exit();
}


if ($type == 'changeID') {
	echo '<script type="text/javascript">';
	echo 'parent.$("#FormConfirmPassword").addClass("d-none");';
	echo 'parent.$("#FormChangeID").removeClass("d-none");';
	echo 'parent.$("#FormChangeID").find("[name=a]").val("account_config");';
	echo 'setTimeout(function(){parent.$("#FormChangeID").find(".js-focus").focus();}, 100);';
	echo 'parent.$("#FormChangeID").find("fieldset").attr("disabled",false);';
	echo '</script>';
}


exit();
?>
