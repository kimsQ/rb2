<?php
include $g['path_module'].$module.'/var/var.php';
if($d['market']['key']):
include $g['path_core'].'function/rss.func.php';
$marketData = getUrlData($d['market']['url'].'&iframe=Y&page=client.start&_clientu='.$g['s'].'&_clientr='.$r.'&key='.$d['market']['key'].'&version=2',10);
$marketData = explode('[RESULT:',$marketData);
$marketData = explode(':RESULT]',$marketData[1]);
$marketData = $marketData[0];
echo $marketData;
else:?>
<div class="noconfig">
<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=config">마켓 접속설정을 등록해 주세요.</a>
</div>
<?php endif?>
