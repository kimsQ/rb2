<?php
if(!defined('__KIMS__')) exit;

if ($m != 'admin' && $iframe !='Y' && !$system)
{
	$g['agent'] = $_SERVER['HTTP_USER_AGENT'];
	$g['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['location'.$s] = strip_tags($g['location']);

	if(strpos($g['agent'],'Google')||strpos($g['agent'],'Yahoo')||strpos($g['agent'],'naver')||strpos($g['agent'],'bot'))
	{
		$_SESSION['mylog'.$s] = $g['ip'].'-'.$date['totime'];
		$_SESSION['agent'.$s] = $g['agent'];
		exit;
	}

	if ($_SESSION['mylog'.$s])
	{
		getDbUpdate($table['s_counter'],'page=page+1','site='.$s." and date='".$date['today']."'");
		if ($_keyword && !strstr('[name][nic][id][term]',$where))
		{
			if (preg_match("/(http|https):\/\/(.*?)$/i", $_keyword)) exit;
			$_INKEY = getDbData($table['s_inkey'],'site='.$s." and date='".$date['today']."' and keyword='".$_keyword."'",'*');
			if($_INKEY['uid']) getDbUpdate($table['s_inkey'],'hit=hit+1','uid='.$_INKEY['uid']);
			else getDbInsert($table['s_inkey'],'site,date,keyword,hit',"'".$s."','".$date['today']."','".$_keyword."','1'");
		}
	}
	else {
		$_referer = $referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'];
		$_sengine = getSearchEngine($_referer);
		$_outkeyw = getKeyword($_referer);
		$_browser = getBrowzer($g['agent']);
		$_QKEY = 'site,mbruid,ip,referer,agent,d_regis';
		$_QVAL = "'".$s."','".$my['uid']."','".$g['ip']."','".$_referer."','".$g['agent']."','".$date['totime']."'";
		getDbInsert($table['s_referer'],$_QKEY,$_QVAL);
		$_REFCNT = getDbRows($table['s_referer'],'');
		if ($_REFCNT > 1000000)
		{
			$_REFOVER = getDbArray($table['s_referer'],'','*','uid','asc',($_REFCNT - 1000000),1);
			while($_REFK=db_fetch_array($_REFOVER)) getDbDelete($table['s_referer'],'uid='.$_REFK['uid']);
		}
		if ($_outkeyw)
		{
			$_OUTKEY = getDbData($table['s_outkey'],'site='.$s." and date='".$date['today']."' and keyword='".$_outkeyw."'",'*');
			if($_OUTKEY['uid']) getDbUpdate($table['s_outkey'],$_sengine.'='.$_sengine.'+1,total=total+1','uid='.$_OUTKEY['uid']);
			else getDbInsert($table['s_outkey'],'site,date,keyword,'.$_sengine.',total',"'".$s."','".$date['today']."','".$_outkeyw."','1','1'");
		}
		$_ISBROWER = getDbData($table['s_browser'],'site='.$s." and date='".$date['today']."' and browser='".$_browser."'",'*');
		if ($_ISBROWER['uid']) getDbUpdate($table['s_browser'],'hit=hit+1','uid='.$_ISBROWER['uid']);
		else getDbInsert($table['s_browser'],'site,date,browser,hit',"'".$s."','".$date['today']."','".$_browser."','1'");
		$_TODAYCNT = getDbData($table['s_counter'],"date='".$date['today']."' and site=".$s,'*');
		if ($_TODAYCNT['uid'])
		{
			getDbUpdate($table['s_counter'],'hit=hit+1,page=page+1','uid='.$_TODAYCNT['uid']);
			getDbUpdate($table['s_numinfo'],'visit=visit+1',"date='".$date['today']."' and site=".$s);
		}
		else
		{
			getDbInsert($table['s_counter'],'site,date,hit,page',"'".$s."','".$date['today']."','1','1'");
			getDbInsert($table['s_numinfo'],'date,site,visit',"'".$date['today']."','".$s."','1'");
		}
		if ($_REFCNT == 1)
		{
			db_query("OPTIMIZE TABLE ".$table['s_referer'],$DB_CONNECT);
			db_query("OPTIMIZE TABLE ".$table['s_outkey'],$DB_CONNECT);
			db_query("OPTIMIZE TABLE ".$table['s_browser'],$DB_CONNECT);
			db_query("OPTIMIZE TABLE ".$table['s_counter'],$DB_CONNECT);
			db_query("OPTIMIZE TABLE ".$table['s_numinfo'],$DB_CONNECT);
		}
		$_SESSION['mylog'.$s] = $g['ip'].'-'.$date['totime'];
		$_SESSION['agent'.$s] = $g['agent'];
	}
}
?>
