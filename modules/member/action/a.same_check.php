<?php
if(!defined('__KIMS__')) exit;

if (!$fname || !$fvalue) exit;

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

if ($my['admin'])
{
	$resultnum = 1;
	$resultmsg = 'OK!';
	$resultclass = 'is-valid';
}
else {
	if ($fname == 'id')
	{
		if (strstr(','.$d['member']['join_cutid'].',',','.$fvalue.','))
		{
			$resultnum = 0;
			$resultmsg = '사용할 수 없는 아이디입니다';
			$resultclass = 'is-invalid';
		}
		else
		{
			$isId = getDbRows($table['s_mbrid'],"id='".$fvalue."'");
			if (!$isId)
			{
				if(!$d['member']['join_rejoin'])
				{
					if(is_file($g['path_tmp'].'out/'.$fvalue.'.txt'))
					{
						$resultnum = 0;
						$resultmsg = '사용할 수 없는 아이디입니다';
					  $resultclass = 'is-invalid';
					}
					else {
						$resultnum = 1;
						$resultmsg = '';
						$resultclass = 'is-valid';
					}
				}
				else {
					$resultnum = 1;
					$resultmsg = '';
					$resultclass = 'is-valid';
				}
			}
			else {
				$resultnum = 0;
				$resultmsg = '사용할 수 없는 아이디입니다';
				$resultclass = 'is-invalid';
			}
		}
	}
	if ($fname == 'email')
	{
		$isId = getDbRows($table['s_mbremail'],"email='".$fvalue."'");
		if (!$isId)
		{
			$resultnum = 1;
			$resultmsg = '';
			$resultclass = 'is-valid';
		}
		else {
			$resultnum = 0;
			$resultmsg = '이미 존재하는 이메일입니다';
			$resultclass = 'is-invalid';
		}
	}
	if ($fname == 'nic')
	{

		if (strstr(','.$d['member']['join_cutnic'].',',','.$fvalue.',') && !$my['admin'])
		{
			$resultnum = 0;
			$resultmsg = '이미 존재하는 닉네임입니다';
			$resultclass = 'is-invalid';
		}
		else
		{
			if ($my['admin'])
			{
				$resultnum = 1;
				$resultmsg = '';
				$resultclass = 'is-valid';
			}
			else {
				if($my['uid'])
				{
					$isId = getDbRows($table['s_mbrdata'],"nic='".$fvalue."' and nic<>'".$my['nic']."'");
				}
				else {
					$isId = getDbRows($table['s_mbrdata'],"nic='".$fvalue."'");
				}
				if (!$isId)
				{
					$resultnum = 1;
					$resultmsg = '';
					$resultclass = 'is-valid';
				}
				else {
					$resultnum = 0;
					$resultmsg = '이미 존재하는 닉네임입니다.';
					$resultclass = 'is-invalid';
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_HS['lang']?>">
<head>
<meta charset="utf-8">
<title></title>
<script type="text/javascript">
//<![CDATA[
<?php if(!$resultnum):?>
// parent.document.getElementById("memberForm").<?php echo $fname?>.value = '';
parent.document.getElementById("memberForm").<?php echo $fname?>.focus();
parent.document.getElementById("<?php echo $flayer?>").className = "invalid-feedback";
<?php endif?>
parent.document.getElementById("memberForm").<?php echo $fname?>.classList.add("<?php echo $resultclass?>");
parent.document.getElementById("memberForm").check_<?php echo $fname?>.value = "<?php echo $resultnum?>";
parent.document.getElementById("<?php echo $flayer?>").innerHTML = '<?php echo addslashes($resultmsg)?>';
//]]>
</script>
</head>
<body></body>
</html>
<?php exit?>
