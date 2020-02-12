<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result = false;
if ($type == 'id')
{
	$isId = getDbRows($table['s_mbrid'],"id='".$fvalue."'");
	if (!$isId && !is_file($g['path_tmp'].'out/'.$fvalue.'.txt')) $result = true;
	if ($result):
	?>
	<script>
	parent.getId('rb-idcheck').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i>정상';
	parent.document.procForm.check_id.value = '1';
	parent.submitFlag = false;
	</script>
	<?php else:?>
	<script>
	parent.getId('rb-idcheck').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	parent.document.procForm.check_id.value = '0';
	parent.submitFlag = false;
	</script>
	<?php
	endif;
}
else if ($type == 'nic')
{
	if ($my['admin']) $result = true;
	else {
		if($my['uid']) $isId = getDbRows($table['s_mbrdata'],"nic='".$fvalue."' and nic<>'".$my['nic']."'");
		else $isId = getDbRows($table['s_mbrdata'],"nic='".$fvalue."'");
		if (!$isId) $result = true;
	}
	if ($result):
	?>
	<script>
	parent.getId('rb-nickcheck').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i>정상';
	parent.document.procForm.check_nic.value = '1';
	parent.submitFlag = false;
	</script>
	<?php else:?>
	<script>
	parent.getId('rb-nickcheck').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	parent.document.procForm.check_nic.value = '0';
	parent.submitFlag = false;
	</script>
	<?php
	endif;
}
else if ($type == 'email')
{
	if (strpos($fvalue,'@') && strpos($fvalue,'.'))
	{
		if ($my['admin']) $result = true;
		else {
			if ($my['uid']) $isId = getDbRows($table['s_mbrdata'],"email='".$fvalue."' and email <> '".$my['email']."'");
			else $isId = getDbRows($table['s_mbrdata'],"email='".$fvalue."'");
			if (!$isId) $result = true;
		}
	}
	if ($result):
	?>
	<script>
	parent.getId('rb-emailcheck').innerHTML = '<i class="fa fa-info-circle fa-lg fa-fw"></i>정상';
	parent.document.procForm.check_email.value = '1';
	parent.submitFlag = false;
	</script>
	<?php else:?>
	<script>
	parent.getId('rb-emailcheck').innerHTML = '<i class="fa fa-question fa-lg fa-fw"></i>확인요망';
	parent.document.procForm.check_email.value = '0';
	parent.submitFlag = false;
	</script>
	<?php
	endif;
}
exit;
?>
