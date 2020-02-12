<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['lang']['admin']['flag']?>">
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow">
<title></title>
<script>
var cHref = <?php if($target) echo $target?>location.href.split('#');
<?php $url = str_replace('&amp;','&',$url)?>
<?php if($alert):?>alert('<?php echo $alert?>');<?php endif?>
<?php if(!strpos($url,'__target')):?>
	<?php if($url=='reload'):?>
		<?php if($_POST):?>
			<?php if($target) echo $target?>location.replace(cHref[0]);
		<?php else:?>
			<?php if($target) echo $target?>location.reload();
		<?php endif?>
	<?php endif?>

	<?php if($url&&$url!='reload'):?><?php if($target) echo $target?>location.href="<?php echo $url?>";<?php endif?>
<?php endif?>
<?php if($history=='close'):?>window.top.close();<?php endif?>
<?php if($history<0):?>history.go(<?php echo $history?>);<?php endif?>
</script>
</head>
<body>

<?php
if (strpos($url,'__target')) :
	$url_exp = explode('?',$url);
	$par_exp = explode('&',$url_exp[1]);
?>
	<form name="backForm" action="<?php echo $g['s']?>" method="get" target="">
	<?php foreach($par_exp as $val):if(trim($val)=='')continue?>
	<?php $_prm = explode('=',$val)?>
	<?php if($_prm[0]=='__target'){$__target=$_prm[1];continue;}?>
	<input type="hidden" name="<?php echo $_prm[0]?>" value="<?php echo $_prm[1]?>" />
	<?php endforeach?>
	</form>
	<script type="text/javascript">
	//<![CDATA[
	document.backForm.target = '<?php echo $__target?>';
	document.backForm.submit();
	//]]>
	</script>
<?php endif?>

<h1><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/"><?php echo $_HS['title'] ?></a></h1>
</body>
</html>
<?php exit?>