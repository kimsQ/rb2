<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

?>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<textarea id="maildocDiv"><?php echo htmlspecialchars(implode('',file($g['dir_module'].'doc/'.$type.'.txt')))?></textarea>
<script type="text/javascript">
//<![CDATA[
function insertMaildoc()
{
	parent.document.getElementById('editFrameContent').value = document.getElementById('maildocDiv').value;
	parent.frames.editFrame.location.reload();
}
window.onload = insertMaildoc;
//]]>
</script>
<?php exit?>