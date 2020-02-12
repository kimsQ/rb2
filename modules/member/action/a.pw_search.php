<?php
if(!defined('__KIMS__')) exit;

$result_num = 1;
$id		= trim($new_id);
$pw_a	= stripslashes(trim($new_pw_a));
$pw1	= trim($new_pw1);
$pw2	= trim($new_pw2);

if (!$id)
{
	getLink('','','아이디를 입력해 주세요.','');
}

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

if ($d['member']['login_emailid'])
{
	$R = getDbData($table['s_mbrdata'],"email='".$id."'",'*');
	if (!$R['memberuid']) getLink('','','존재하지 않는 이메일입니다.','');
	$M = getUidData($table['s_mbrid'],$R['memberuid']);
}
else
{
	$M = getDbData($table['s_mbrid'],"id='".$id."'",'*');
	if (!$M['uid']) getLink('','','존재하지 않는 아이디입니다.','');
	$R = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
}

if ($pw_a)
{
	if ($pw_a == $R['pw_a'])
	{
		$result_num = 3;
		$alert = "인증되셨습니다.재 등록할 패스워드를 입력해 주세요.";

		if ($pw1 && $pw2)
		{
			getDbUpdate($table['s_mbrid'],"pw='".md5($pw1)."'",'uid='.$M['uid']);
			getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."'",'memberuid='.$M['uid']);

			getLink(RW('mod=login'),'parent.','','');
		}
	}
	else {
		$result_num = 2;
		$alert = "질문에 대한 답변이 일치하지 않습니다.";
	}
}
else {
	$result_num = 2;
	$alert = "질문에 대한 답변을 입력해 주세요.";
	$pushmsg = $R['pw_q'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $_HS['lang']?>" xml:lang="<?php echo $_HS['lang']?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
//<![CDATA[
function pwStepCheck(n)
{
	parent.getId('pwauth_step_1').style.display = 'none';
	parent.getId('pwauth_step_2').style.display = 'none';
	parent.getId('pwauth_step_3').style.display = 'none';

	parent.getId('pwauth_step_'+n).style.display = 'block';
	parent.getId('id_auth').value = n;
	parent.getId('pwsearchStep_'+n).focus();
}
pwStepCheck(<?php echo $result_num?>);

<?php if($pushmsg):?>
parent.getId('pw_question').innerHTML = "<?php echo $pushmsg?>";
<?php endif?>
<?php if($alert):?>
alert('<?php echo $alert?>');
<?php endif?>

//]]>
</script>
</head>
<body></body>
</html>
<?php exit?>
