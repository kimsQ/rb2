<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['lang']['admin']['flag']?>">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
<title></title>
<script>
<?php $url = str_replace('&amp;','&',$url)?>
<?php if($alert):?>alert('<?php echo $alert?>');<?php endif?>
<?php if($url):?>window.open('<?php echo $url?>','','<?php echo $option?>');<?php endif?>
<?php if($backurl=='reload'):?>
<?php if($_POST):?>
<?php if($target) echo $target?>location.replace(<?php if($target) echo $target?>location.href);
<?php else:?>
<?php if($target) echo $target?>location.reload();
<?php endif?>
<?php endif?>
<?php if($backurl&&$backurl!='reload'):?><?php if($target) echo $target?>location.href="<?php echo $backurl?>";<?php endif?>
</script>
</head>
<body></body>
</html>
