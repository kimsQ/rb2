<?php
if(!defined('__KIMS__')) exit;


checkAdmin(0);

$str_month = '';
$str_today = '';
$B = getUidData($table[$m.'list'],$bid);
sort($post_members);
reset($post_members);

foreach ($post_members as $val)
{
	$R = getUidData($table[$m.'data'],$val);
	if (!$R['uid']) continue;
	if ($R['bbs']==$B['uid']) continue;

	$month = substr($R['d_regis'],0,6);
	$today = substr($R['d_regis'],0,8);

	//게시물이동
	getDbUpdate($table[$m.'data'],'bbs='.$B['uid'].",bbsid='".$B['id']."'",'uid='.$R['uid']);
	getDbUpdate($table[$m.'idx'],'bbs='.$B['uid'],'gid='.$R['gid']);

	getDbUpdate($table[$m.'list'],"num_r=num_r-1",'uid='.$R['bbs']);
	getDbUpdate($table[$m.'list'],"num_r=num_r+1",'uid='.$B['uid']);

	getDbUpdate($table[$m.'month'],'num=num-1',"date='".$month."' and site=".$R['site'].' and bbs='.$R['bbs']);
	getDbUpdate($table[$m.'day'],'num=num-1',"date='".$today."' and site=".$R['site'].' and bbs='.$R['bbs']);

	if(!strstr($str_month,'['.$month.']') && !getDbRows($table[$m.'month'],"date='".$month."' and site=".$R['site'].' and bbs='.$B['uid']))
	{
		getDbInsert($table[$m.'month'],'date,site,bbs,num',"'".$month."','".$R['site']."','".$B['uid']."','1'");
		$str_month .= '['.$month.']';
	}
	else {
		getDbUpdate($table[$m.'month'],'num=num+1',"date='".$month."' and site=".$R['site'].' and bbs='.$B['uid']);
	}

	if(!strstr($str_today,'['.$today.']') && !getDbRows($table[$m.'day'],"date='".$today."' and site=".$site.' and bbs='.$bbsuid))
	{
		getDbInsert($table[$m.'day'],'date,site,bbs,num',"'".$today."','".$R['site']."','".$B['uid']."','1'");
		$str_today .= '['.$today.']';
	}
	else {
		getDbUpdate($table[$m.'day'],'num=num+1',"date='".$today."' and site=".$R['site'].' and bbs='.$B['uid']);
	}


	//댓글이동
	if ($R['comment'])
	{

		$CCD = getDbArray($table['s_comment'],"parent='".$m.$R['uid']."'",'*','uid','desc',0,0);

		while($_C=db_fetch_array($CCD))
		{
			$comment_cync = '['.$m.']['.$R['uid'].'][uid,comment,oneline,d_comment]['.$table[$m.'data'].']['.$_C['parentmbr'].'][m:'.$m.',bid:'.$B['id'].',uid:'.$R['uid'].']';
			getDbUpdate($table['s_comment'],"cync='$comment_cync'",'uid='.$_C['uid']);


			if ($_C['upload'])
			{
				$UPFILES   = getArrayString($_C['upload']);
				foreach($UPFILES['data'] as $_val)
				{
					$U = getUidData($table['s_upload'],$_val);
					if ($U['uid'])
					{
						getDbUpdate($table['s_upload'],"cync=''",'uid='.$U['uid']);
					}
				}
			}
		}
	}

	//첨부파일이동
	if ($R['upload'])
	{

		$UPFILES   = getArrayString($R['upload']);
		foreach($UPFILES['data'] as $_val)
		{
			$U = getUidData($table['s_upload'],$_val);
			if ($U['uid'])
			{
				getDbUpdate($table['s_upload'],"cync=''",'uid='.$U['uid']);
			}
		}
	}

	$_SESSION['BbsPost'.$type] = str_replace('['.$R['uid'].']','',$_SESSION['BbsPost'.$type]);
}


$referer = $g['s'].'/?r='.$r.'&iframe=Y&m=admin&module='.$m.'&front=movecopy&type='.$type;

getLink($referer,'parent.','실행되었습니다.','');
?>