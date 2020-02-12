<?php

// 게시물 태그추출 함수
function getPostTag($tag){
  global $g,$r;
  $_tags=explode(',',$tag);
  $_tagn=count($_tags);
  $html='';
  $post_list = $g['url_root'].'/?r='.$r.'&m=post&bid=';
  $i=0;
  for($i = 0; $i < $_tagn; $i++):;
    $_tagk=trim($_tags[$i]);
    $html.='<span data-toggle="tag" data-tag="'.$_tagk.'" class="badge badge-primary badge-inverted f13">#';
    $html.=$_tagk;
    $html.='</span>';
  endfor;
  return $html;
}


/*
댓글 삭제 함수
$d : 설정 파일 내역 배열, $m : 모듈명 $B : 블로그 uid
parent 가 $m.$R['uid'] 형식인점에 유의 !!!
*/
function DeleteComment($R,$d,$m,$B)
{
	global $table,$date;

	$CCD = getDbArray($table['s_comment'],"parent='".$m.$R['uid']."'",'*','uid','asc',0,0);

	while($C=db_fetch_array($CCD))
	{
		if ($C['upload']) DeleteUpfile($C,$d);
		if ($C['oneline']) DeleteOneline($C,$d);
		getDbDelete($table['s_comment'],'uid='.$C['uid']);

		if ($d['blog']['c_give_opoint']&&$C['mbruid'])
		{
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$C['mbruid']."','0','-".$d['blog']['c_give_opoint']."','댓글삭제(".getStrCut($C['subject'],15,'').")환원','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point-'.$d['blog']['c_give_opoint'],'memberuid='.$C['mbruid']);
		}
		getDbUpdate($table[$m.'members'],'num_c=num_c-1','blog='.$B['uid'].' and mbruid='.$C['mbruid']);
	}
}

//한줄의견 삭제 함수
function DeleteOneline($C,$d)
{
	global $table,$date;

	$_ONELINE = getDbSelect($table['s_oneline'],'parent='.$C['uid'],'*');
	while($_O=db_fetch_array($_ONELINE))
	{
		if ($d['blog']['c_give_opoint']&&$_O['mbruid'])
		{
			getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$_O['mbruid']."','0','-".$d['blog']['c_give_opoint']."','한줄의견삭제(".getStrCut(str_replace('&amp;',' ',strip_tags($_O['content'])),15,'').")환원','".$date['totime']."'");
			getDbUpdate($table['s_mbrdata'],'point=point-'.$d['blog']['c_give_opoint'],'memberuid='.$_O['mbruid']);
		}
	}
	getDbDelete($table['s_oneline'],'parent='.$C['uid']);
}

//첨부파일 삭제 함수
function DeleteUpfile($R,$d)
{
   global $g,$table;

   $UPFILES = getArrayString($R['upload']);

	foreach($UPFILES['data'] as $_val)
	{
		$U = getUidData($table['s_upload'],$_val);
		if ($U['uid'])
		{
			if ($U['url']==$d['blog']['ftp_urlpath'])
			{
				$FTP_CONNECT = ftp_connect($d['blog']['ftp_host'],$d['blog']['ftp_port']);
				$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['blog']['ftp_user'],$d['blog']['ftp_pass']);
				if ($d['blog']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);
				if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
				if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');

				ftp_delete($FTP_CONNECT,$d['blog']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
				if($U['type']==2) ftp_delete($FTP_CONNECT,$d['blog']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
				ftp_close($FTP_CONNECT);
			}
			else {
				 unlink('.'.$U['url'].$U['folder'].'/'.$U['tmpname']);
                       if($U['type']==2) unlink('.'.$U['url'].$U['folder'].'/'.$U['thumbname']);
			}
			getDbDelete($table['s_upload'],'uid='.$U['uid']);
		}
	}
}

?>
