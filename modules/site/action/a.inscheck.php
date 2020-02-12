<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);
$instFp = $g['path_var'].'install.txt';
$instIp = is_file($instFp) ? implode('',file($instFp)) : $_SERVER['REMOTE_ADDR'];
?>

<?php if(!strstr($instIp,'127.0.')&&!strstr($instIp,'192.168.')):?>
<?php include_once $g['path_module'].'market/var/var.php'?>
<?php $fp=fopen($instFp,'w');fwrite($fp,$_SERVER['REMOTE_ADDR']);fclose($fp);@chmod($instFp,0707);?>
<form name="installForm" action="<?php echo $d['market']['url']?>" method="post" target="_action_frame_<?php echo $m?>">
<input type="hidden" name="m" value="qmarket" />
<input type="hidden" name="a" value="rb_install" />
<input type="hidden" name="url" value="<?php echo $g['url_root']?>" />
<input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>" />
<input type="hidden" name="server" value="<?php echo $_SERVER['SERVER_SOFTWARE']?>" />
<input type="hidden" name="version" value="<?php echo $d['admin']['version']?>" />
<input type="hidden" name="language" value="<?php echo $g['sys_selectlang']?>" />
</form>
<script>
window.onload=function(){document.installForm.submit();}
</script>
<?php endif?>
