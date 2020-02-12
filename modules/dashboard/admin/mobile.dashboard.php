<link href="<?php echo $g['s']?>/modules/<?php echo $module?>/admin/main.css" rel="stylesheet"> 
<div id="rb-dashboard-for-mobile">
<?php
$_dashboardInclude = true;
include $g['path_module'].$module.'/admin/main.php';
?>
</div>
