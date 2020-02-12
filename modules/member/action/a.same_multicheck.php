<?php
if(!defined('__KIMS__')) exit;

if (!$fname || !$fvalue) exit;

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

if ($fname == 'id[]')
{
	if (strstr(','.$d['member']['join_cutid'].',',','.$fvalue.','))
	{
		$resultnum = 0;
		$resultmsg = '사용 제한된 아이디입니다. ';
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
					$resultmsg = '탈퇴한 아이디 입니다';
				}
				else {
					$resultnum = 1;
					$resultmsg = '<span class="ok">OK!</span>';
				}
			}
			else {
				$resultnum = 1;
				$resultmsg = '<span class="ok">OK!</span>';
			}
		}
		else {
			$resultnum = 0;
			$resultmsg = '이미 사용중인 아이디입니다';
		}
	}
}
if ($fname == 'email[]')
{
	if ($my['uid'])
	{
		$isId = getDbRows($table['s_mbrdata'],"email='".$fvalue."' and email <> '".$my['email']."'");
	}
	else {
		$isId = getDbRows($table['s_mbrdata'],"email='".$fvalue."'");
	}
	if (!$isId)
	{
		$resultnum = 1;
		$resultmsg = '<span class="ok">OK!</span>';
	}
	else {
		$resultnum = 0;
		$resultmsg = '이미 존재하는 이메일입니다';
	}
}
if ($fname == 'nic[]')
{

	if (strstr(','.$d['member']['join_cutnic'].',',','.$fvalue.',') && !$my['admin'])
	{
		$resultnum = 0;
		$resultmsg = '이미 존재하는 닉네임입니다';
	}
	else
	{
		if ($my['admin'])
		{
			$resultnum = 1;
			$resultmsg = '<span class="ok">OK!</span>';
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
				$resultmsg = '<span class="ok">OK!</span>';
			}
			else {
				$resultnum = 0;
				$resultmsg = '이미 존재하는 닉네임입니다';
			}
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $_HS['lang']?>" xml:lang="<?php echo $_HS['lang']?>" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
//<![CDATA[
function re_fales()
{

    var d = parent.document.getElementsByName('<?php echo $fname?>');
	var n = d.length;
	 var j = 0;
	 var i;
	 var s = '';

	 for( i=0;i<n;i++)
	 {
		if(d[i].value=='<?php echo $fvalue?>')
		 {
		    d[i].value='';
			setTimeout(function()
			{
			 d[i].focus()
			}, 10);
	        return false;
		 }
	  }

}

parent.document.procForm.check_id.value = "<?php echo $resultnum?>";
<?php if($resultnum==0):?>
alert('\n <?php echo addslashes($resultmsg)?>\n');
re_fales();
<?php endif?>
//]]>
</script>
</head>
<body></body>
</html>
<?php exit?>
