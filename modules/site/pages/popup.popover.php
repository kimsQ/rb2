<?php
$M = array_merge(getUidData($table['s_mbrid'],$mbruid),getDbData($table['s_mbrdata'],'memberuid='.(int)$mbruid,'*'));
?>


<div id="rb-member-profile" class="media">
	<a class="pull-left" href="#">
		<img class="media-object" src="<?php echo $g['s']?>/_var/avatar/180.<?php echo $M['photo']?$M['photo']:'0.gif'?>">
	</a>
	<div class="media-body">
		<h4 class="media-heading">
			<span data-placement="bottom" data-tooltip="tooltip" title="<?php echo $M['name']?>"><?php echo $M['nic']?>님</span>
			<button class="close pull-right" type="button" onclick="hidePopover('<?php echo $layer?>');">&times;</button>
		</h4>
		<p class="text-muted">서울특별시</p>
		<p class="rb-log" data-tooltip="tooltip" title="<?php echo getDateFormat($M['last_log'],'Y.m.d H:i')?>">
			최근접속 (<time class="timeago" data-toggle="tooltip" datetime="<?php echo getDateFormat($M['last_log'],'c')?>"></time>)
		</p>
	</div>
</div>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko',false,'js')?>
<script>
jQuery(document).ready(function() {
	$(".rb-log time").timeago();
});
function hidePopover(id)
{
	parent.$('#_'+id).click();
}
</script>
