<?php

function getUrlData($url,$sec)
{
	$URL_parsed = parse_url($url);
	$host = $URL_parsed['host'];
	$port = $URL_parsed['port'];
	$path = $URL_parsed['path'];
	$query= $URL_parsed['query'];
	$scheme= $URL_parsed['scheme'];

	if (!$host) $host = $_SERVER['HTTP_HOST'];

  $out = "GET ".$path.'?'.$query." HTTP/1.1\r\n";
  $out .= "Host: ".$host."\r\n";
  $out .= "Connection: Close\r\n\r\n";

	if ($scheme == 'https') {
		if (!$port) $port = 443;
		$fp = fsockopen('ssl://'.$host,$port,$errno,$errstr,$sec);
	} else {
		if (!$port) $port = 80;
		$fp = fsockopen($host,$port,$errno,$errstr,$sec);
	}

	if (!$fp)
	{
		return false;
	}
	else
	{
		fputs($fp, $out);
		$body = false;
		while (!feof($fp)) {
			$s = fgets($fp, 128);
			if ( $body )
				$in .= $s;
			if ( $s == "\r\n" )
				$body = true;
		}

		fclose($fp);
		return $in;
	}
}

function getRssArray($url,$tag)
{
	return explode('<'.$tag.'>',getUrlData($url,10));
}
function getRssTagValue($str,$tag)
{
	$str_exp = explode('<'.$tag.'>' , $str);
	$str_exp = explode('</'.$tag.'>' , $str_exp[1]);
	$result  = getUTFtoUTF($str_exp[0]) == $str_exp[0] ? $str_exp[0] : getKRtoUTF($str_exp[0]);
	return trim($result);
}
function getRssPageTitle($str,$tag)
{
	return getRssTagValue($str,$tag);
}
function getRssContent($str,$tag)
{
	$str = str_replace('&gt;','>',$str);
	$str = str_replace('&lt;','<',$str);
	$str = str_replace('&quot;','"',$str);
	$str = str_replace('&apos;','\'',$str);
	$str = getRssTagValue($str,$tag);
	$str = str_replace(']]>','',$str);
	$str = str_replace('<![CDATA[','',$str);
	return $str;
}
function getRssDomain($url)
{
	$e = explode('/',str_replace('www.','',str_replace('http://','',$url)));
	return $e[0];
}
function getJSONData($data,$f)
{
	$arr1 = explode('"'.$f.'":"',str_replace(': "',':"',$data));
	$arr2 = explode('"',$arr1[1]);
	return $arr2[0];
}
function _LANG($kind,$module)
{
	return $GLOBALS['lang'][$module][$kind];
}
?>
