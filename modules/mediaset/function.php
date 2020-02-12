<?php
if(!defined('__KIMS__')) exit;

function getVodCode($src)
{
	$exp1 = explode('youtube.com/embed/',$src);
	$exp2 = strstr($exp1[1],'?') ? explode('?',$exp1[1]) : explode('"',$exp1[1]);
	return $exp2[0];
}
function getVodThumb($src,$what)
{
	return '//img.youtube.com/vi/'.getVodCode($src).'/'.$what.'.jpg';
}
function getVodUrl($src)
{
	return '//www.youtube.com/watch?feature=player_detailpage&v='.getVodCode($src);
}
function getMediaLink($R,$type,$size)
{

	if ($R['type'] == 2 || $R['type'] == 5) return $R['url'].$R['folder'].'/'.getPreviewResize($R['tmpname'],$size);
	if ($R['type'] == -1) return $R['src'];
	if ($R['type'] == 0) return getVodUrl($R['src']);

	return '#.';
}

?>
