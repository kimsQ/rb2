<?php
include $g['path_module'].$module.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];
if($d['market']['url'] && $d['market']['key'] && $d['market']['userid'] ):
include $g['path_core'].'function/rss.func.php';
$marketData = getUrlData($d['market']['url'].'&iframe=Y&page=client.front&package=0&_clientu='.$g['s'].($goods?'&goods='.$goods:'').'&_clientr='.$r.'&cat='.$cat.'&theme='.$theme.'&sort='.$sort.'&orderby='.$orderby.'&type='.$type.'&ptype='.$ptype.'&p='.$p.'&todayfree='.$todayfree.'&sailing='.$sailing.'&where='.$where.'&keyword='.$keyword.'&brand='.$brand.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);
$marketData = explode('[RESULT:',$marketData);
$marketData = explode(':RESULT]',$marketData[1]);
$marketData = $marketData[0];
echo $marketData;
else:?>
<?php include $g['path_module'].$module.'/admin/_guide.php'; ?>
<?php endif?>
