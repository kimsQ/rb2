<?php
if(!defined('__KIMS__')) exit;

if(!$d['bbs']['rss'])
{
	getLink('','','RSS발행을 지원하지 않는 게시판입니다.','close');
}

if($bid)
{
	$B = getDbData($table[$m.'list'],"id='".$bid."'",'*');
}

$sort	= 'gid';
$orderby= 'asc';
$recnum	= 20;

$_QUE = 'site='.$s.' and hidden=0';
if ($mbruid)
{
	$_QUE .= ' and mbruid='.$mbruid;
}
if ($B['uid'])
{
	$_QUE .= ' and bbs='.$B['uid'];
}

$RCD = array();
if ($mbruid)
{
	$M=getDbData($table['s_mbrdata'],'memberuid='.$mbruid,'*');
	$TCD = getDbArray($table[$m.'data'],$_QUE,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
}
else {
	$TCD = getDbArray($table[$m.'data'],$_QUE,'gid',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table[$m.'data'],'gid='.$_R['gid'],'*');
}
Header("Content-type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
echo "<?xml version='1.0' encoding='utf-8'?>\r\n\r\n";

if($type == 'rss1') :?>

<rss version='2.0' xmlns:dc='http://purl.org/dc/elements/1.1/'>
	<channel>
		<title><?php echo $mbruid?$M[$_HS['nametype']].'님의 포스트':(htmlspecialchars($B['name']?$B['name']:$_HS['name']))?></title>
		<link><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?><?php if($B['uid']):?>&amp;bid=<?php echo $B['id']?><?php endif?></link>
		<dc:language><?php echo substr($_HS['lang'],0,2)?></dc:language>
<?php foreach($RCD as $R):?>
		<item>
			<title><?php echo htmlspecialchars($R['subject'])?></title>
			<description><![CDATA[<?php echo getContents($R['content'],$R['html'],'')?>]]></description>
			<link><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;bid=<?php echo $R['bbsid']?>&amp;uid=<?php echo $R['uid']?></link>
			<dc:creator><?php echo htmlspecialchars($R[$_HS['nametype']])?></dc:creator>
			<category><![CDATA[<?php echo htmlspecialchars($R['category'])?>]]></category>
			<?php if($R['tag']):?>
			<?php $tags=explode(',',trim($R['tag']))?>
			<?php $tagn=count($tags)?>
			<?php for($i = 0; $i < $tagn; $i++):if(!$tags[$i])continue?>
			<category><![CDATA[<?php echo htmlspecialchars($tags[$i])?>]]></category>
			<?php endfor?>
			<?php endif?>
			<guid><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;bid=<?php echo $R['bbsid']?>&amp;uid=<?php echo $R['uid']?></guid>
			<dc:date><?php echo getDateFormat($R['d_regis'],'r')?></dc:date>
			<dc:subject></dc:subject>
		</item>
<?php endforeach?>
	</channel>
</rss>

<?php elseif($type == 'atom') :?>

<feed version="0.3"
	xmlns="http://purl.org/atom/ns#"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" >

	<title><?php echo $mbruid?$M[$_HS['nametype']].'님의 포스트':(htmlspecialchars($B['name']?$B['name']:$_HS['name']))?></title>

	<id><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?><?php if($B['uid']):?>&amp;bid=<?php echo $B['id']?><?php endif?></id>
	<author><name><?php echo htmlspecialchars($B['name']?$B['name']:$_HS['name'])?></name></author>
	<info><![CDATA[<?php echo htmlspecialchars($B['name']?$B['name']:$_HS['name'])?>]]></info>

<?php foreach($RCD as $R):?>
	<entry>
		<title><?php echo htmlspecialchars($R['subject'])?></title>
		<link rel="alternate" type="text/html" href="<?php echo $g['r']?>/?m=<?php echo $m?>&amp;uid=<?php echo $R['uid']?>" />
		<id><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;bid=<?php echo $R['bbsid']?>&amp;uid=<?php echo $R['uid']?></id>
		<created><?php echo getDateFormat($R['d_regis'],'r')?></created>
		<modified><?php echo getDateFormat($R['d_modify'],'r')?></modified>
		<summary type="text/html" mode="escaped"><![CDATA[<?php echo getContents($R['content'],$R['html'],'')?>]]></summary>
	</entry>
<?php endforeach?>

</feed>


<?php else :?>

<rss version='2.0' xmlns:dc='http://purl.org/dc/elements/1.1/'>
	<channel>
		<title><?php echo $mbruid?$M[$_HS['nametype']].'님의 포스트':(htmlspecialchars($B['name']?$B['name']:$_HS['name']))?></title>
		<link><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?><?php if($B['uid']):?>&amp;bid=<?php echo $B['id']?><?php endif?></link>
		<dc:language><?php echo substr($_HS['lang'],0,2)?></dc:language>
<?php foreach($RCD as $R):?>
		<item>
			<title><?php echo htmlspecialchars($R['subject'])?></title>
			<description><![CDATA[<?php echo getContents($R['content'],$R['html'],'')?>]]></description>
			<link><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;bid=<?php echo $R['bbsid']?>&amp;uid=<?php echo $R['uid']?></link>
			<dc:creator><?php echo htmlspecialchars($R[$_HS['nametype']])?></dc:creator>
			<category><![CDATA[<?php echo htmlspecialchars($R['category'])?>]]></category>
			<?php if($R['tag']):?>
			<?php $tags=explode(',',trim($R['tag']))?>
			<?php $tagn=count($tags)?>
			<?php for($i = 0; $i < $tagn; $i++):if(!$tags[$i])continue?>
			<category><![CDATA[<?php echo htmlspecialchars($tags[$i])?>]]></category>
			<?php endfor?>
			<?php endif?>
			<guid><?php echo $g['url_root']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;bid=<?php echo $R['bbsid']?>&amp;uid=<?php echo $R['uid']?></guid>
			<dc:date><?php echo getDateFormat($R['d_regis'],'r')?></dc:date>
			<dc:subject></dc:subject>
		</item>
<?php endforeach?>
	</channel>
</rss>

<?php endif?>
