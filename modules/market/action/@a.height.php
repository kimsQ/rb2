<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
?>

<script type="text/javascript">
//<![CDATA[
<?php if($innerF):?>
parent.parent.parent.document.getElementById('marketFrame').style.height = '<?php echo ($height+100)?>px';
<?php else:?>
parent.parent.document.getElementById('marketFrame').style.height = '<?php echo ($height+100)?>px';
parent.parent.scrollTo(0,0);
<?php endif?>
//]]>
</script>

<?php exit?>
