<?php
//메뉴출력
function getMenuShowPost($Post,$table,$j,$parent,$depth,$uid,$CXA,$hidden)
{
	global $cat;
	global $MenuOpen,$numhidden,$checkbox,$headfoot;
	static $j;

	$CD=getDbSelect($table,($Post?'Post='.$Post.' and ':'').'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		if(@in_array($C['uid'],$CXA)) $MenuOpen .= 'trees[0].tmB('.$j.');';
		$numprintx = !$numhidden && $C['num_open'] ? '&lt;span class="num"&gt;('.$C['num_open'].')&lt;/span&gt;' : '';
		if($GLOBALS['d']['Post']['writeperm']) $numprintx.= !$numhidden && $C['num_reserve'] ? '&lt;span class="num1"&gt;('.$C['num_reserve'].')&lt;/span&gt;' : '';
		$C['name'] = $headfoot && ($C['imghead']||$C['imgfoot']||$C['codhead']||$C['codfoot']) ? '&lt;b&gt;'.$C['name'].'&lt;b&gt;' : $C['name'];
		$name = $C['uid'] != $cat ? addslashes($C['name']): '&lt;span class="on"&gt;'.addslashes($C['name']).'&lt;/span&gt;';

		if($checkbox)
		{
			$icon1 = '&lt;input type="checkbox" name="category_members[]" value="'.$C['uid'].'"'.($cat==$C['uid']||getDbRows($GLOBALS['table'][$GLOBALS['m'].'catidx'],'category='.$C['uid'].' and parent='.$GLOBALS['R']['uid'])?' checked="checked"':'').' /&gt;';
		}
		$icon2 = $C['mobile'] ? ' &lt;img src="'.$GLOBALS['g']['img_core'].'/_public/ico_mobile.gif" class="mobile" alt="" /&gt;' : '';
		$icon3 = $C['reject'] ? ' &lt;img src="'.$GLOBALS['g']['img_core'].'/_public/ico_hidden.gif" alt="" /&gt;' : '';

		if ($C['isson'])
		{
			echo "['".$icon1.$name.$icon2.$numprintx."','".($GLOBALS['g']['Post_home_rw']?$C['id']:$C['uid'])."',";
			getMenuShowPost($Post,$table,$j,$C['uid'],$C['depth'],$uid,$CXA,$hidden);
			echo "],\n";
		}
		else {
			echo "['".$icon1.$name.$icon2.$icon3.$numprintx."','".($GLOBALS['g']['Post_home_rw']?$C['id']:$C['uid'])."',''],\n";
		}
	}
}
//메뉴코드->경로
function getMenuCodeToPathPost($table,$cat,$j)
{
	global $DB_CONNECT;
	static $arr;

	$R=getUidData($table,$cat);
	if($R['parent'])
	{
		$arr[$j]['uid'] = $R['uid'];
		$arr[$j]['id'] = $R['id'];
		$arr[$j]['name']= $R['name'];
		getMenuCodeToPathPost($table,$R['parent'],$j+1);
	}
	else {
		$C=getUidData($table,$cat);
		$arr[$j]['uid'] = $C['uid'];
		$arr[$j]['id'] = $C['id'];
		$arr[$j]['name']= $C['name'];
	}
	sort($arr);
	reset($arr);
	return $arr;
}
//메뉴코드->SQL
function getMenuCodeToSqlPost($table,$cat,$f)
{
	static $sql;

	$R=getUidData($table,$cat);
	if ($R['uid']) $sql .= $f.'='.$R['uid'].' or ';
	if ($R['isson'])
	{
		$RDATA=getDbSelect($table,'parent='.$R['uid'],'uid');
		while($C=db_fetch_array($RDATA)) getMenuCodeToSqlPost($table,$C['uid'],$f);
	}
	return substr($sql,0,strlen($sql)-4);
}
function getMenuCodeToSqlPost1($tbl,$cat,$Post,$sql)
{
	global $sql;
	$R=getUidData($tbl,$cat);
	if(!strstr($sql,'['.$R['uid'].']')) $sql = $sql.'['.$R['uid'].']';
	if($R['parent'])
	{
		$C=getUidData($tbl,$R['parent']);
		if(!strstr($sql,'['.$C['uid'].']')) $sql = $sql.'['.$C['uid'].']';
		getMenuCodeToSqlPost1($tbl,$C['uid'],$Post,$sql);
	}
	return $sql;
}
function getMenuCodeToSqlPost2($tbl,$cat,$Post,$sql)
{
	global $sql;
	$R=getUidData($tbl,$cat);
	if(!strstr($sql,'['.$R['uid'].']')) $sql = $sql.'['.$R['uid'].']';
	if($R['isson'])
	{
		$RDATA=getDbSelect($tbl,'Post='.$Post.' and parent='.$R['uid'],'uid');
		while($C=db_fetch_array($RDATA))
		{
			if(!strstr($sql,'['.$C['uid'].']')) $sql = $sql.'['.$C['uid'].']';
			getMenuCodeToSqlPost2($tbl,$C['uid'],$Post,$sql);
		}
	}
	return $sql;
}

//트리(@ 2.0.0)
function getTreeCategory($conf,$code,$depth,$parent,$tmpcode)
{
	$ctype = $conf['ctype']?$conf['ctype']:'uid';
	$id = 'tree_'.filterstr(microtime());
	$tree = '<div class="rb-tree"><ul id="'.$id.'">';
	$CD=getDbSelect($conf['table'],($conf['Post']?'Post='.$conf['Post'].' and ':'').'depth='.($depth+1).' and parent='.$parent.($conf['dispHidden']?' and hidden=0':'').($conf['mobile']?' and mobile=1':'').' order by gid asc','*');
	$_i = 0;
	while($C=db_fetch_array($CD))
	{
		$rcode= $tmpcode?$tmpcode.'/'.$C[$ctype]:$C[$ctype];
		$t_arr = explode('/', $code);
		$t1_arr = explode('/', $rcode);
		$topen= in_array($t1_arr[count($t1_arr)-1], $t_arr)?true:false;

		$tree.= '<li>';
		if ($C['isson'])
		{
			$tree.= '<a data-toggle="collapse" href="#'.$id.'-'.$_i.'-'.$C['uid'].'" class="rb-branch'.($conf['allOpen']||$topen?'':' collapsed').'"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu-'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			//else $tree.= '<a href="'.$conf['link'].$C['uid'].'&amp;code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
         else $tree.= '<a href="'.$conf['link'].$C['uid'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
  		   if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="'._LANG('fs002','admin').'" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</span>';
			$tree.='</u></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				//if($C['mobile']) $tree.= '<i class="glyphicon glyphicon-phone" title="'._LANG('fs005','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= '<i class="glyphicon glyphicon-new-window" title="'._LANG('fs004','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['reject']) $tree.= '<i class="glyphicon glyphicon-ban-circle" title="'._LANG('fs003','admin').'" data-tooltip="tooltip"></i>';
			}

			$tree.= '<ul id="'.$id.'-'.$_i.'-'.$C['uid'].'" class="collapse'.($conf['allOpen']||$topen?' in':'').'">';
			$tree.= getTreeCategory($conf,$code,$C['depth'],$C['uid'],$rcode);
			$tree.= '</ul>';
		}
		else {
			$tree.= '<a href="#." class="rb-leaf"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if ($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			//else $tree.= '<a href="'.$conf['link'].$C['uid'].'&amp;code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
         else $tree.= '<a href="'.$conf['link'].$C['uid'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
         if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="'._LANG('fs002','admin').'" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</u>';
			$tree.='</span></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				//if($C['mobile']) $tree.= '<i class="glyphicon glyphicon-phone" title="'._LANG('fs005','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= '<i class="glyphicon glyphicon-new-window" title="'._LANG('fs004','admin').'" data-tooltip="tooltip"></i>&nbsp;';
				if($C['reject']) $tree.= '<i class="glyphicon glyphicon-ban-circle" title="'._LANG('fs003','admin').'" data-tooltip="tooltip"></i>';
			}
		}
		$tree.= '</li>';
		$_i++;
	}
	$tree.= '</ul></div>';
	return $tree;
}

//트리 카테고리 - write_plus 전용
function getTreeCategoryForWrite($conf,$code,$depth,$parent,$tmpcode)
{
	global $m,$table;

	$ctype = $conf['ctype']?$conf['ctype']:'uid';
	$id = 'tree_'.filterstr(microtime());
	$tree = '<div class="rb-tree"><ul id="'.$id.'">';
	$CD=getDbSelect($table[$m.'category'],($conf['Post']?'Post='.$conf['Post'].' and ':'').'depth='.($depth+1).' and parent='.$parent.($conf['dispHidden']?' and hidden=0':'').($conf['mobile']?' and mobile=1':'').' order by gid asc','*');
	$_i = 0;
	while($C=db_fetch_array($CD))
	{
		$rcode= $tmpcode?$tmpcode.'/'.$C[$ctype]:$C[$ctype];
		$t_arr = explode('/', $code);
		$t1_arr = explode('/', $rcode);
		$topen= in_array($t1_arr[count($t1_arr)-1], $t_arr)?true:false;
		$cat_link=$conf['link']?$conf['link'].$C['uid']:'#'; // 링크는 있는 경우에만
		$NUM=getDbRows($table[$m.'category'],'parent='.$C['uid']);
		// $dispNum='<span class="badge">'.$NUM.'</span>';
		$is_selected=getDbRows($table[$m.'catidx'],'Post='.$conf['Post'].' and post='.$conf['post'].' and category='.$C['uid']);
		$catCheckbox='<input type="checkbox" name="category[]" value="'.$C['uid'].'" data-role="category-checkbox" data-name="'.$C['name'].'" '.($is_selected?'checked':'').'>';

		$tree.= '<li>';
		if ($C['isson'])
		{
			$tree.=$code;
			$tree.= '<a data-toggle="collapse" href="#'.$id.'-'.$_i.'-'.$C['uid'].'" class="rb-branch'.($conf['allOpen']||$topen?'':' collapsed').'"></a>';
			$tree.= '<a href="'.$cat_link.'"><span'.($code==$rcode?' class="rb-active"':'').'>';
  		      if($conf['dispCheckbox']) $tree.= $catCheckbox;
			$tree.= $C['name'];
			$tree.='</span></a>';
			if($conf['dispNum']) $tree.=$dispNum;

			$tree.= '<ul id="'.$id.'-'.$_i.'-'.$C['uid'].'" class="collapse'.($conf['allOpen']||$topen?' in':'').'">';
			$tree.= getTreeCategoryForWrite($conf,$code,$C['depth'],$C['uid'],$rcode);
			$tree.= '</ul>';
		}
		else {
			$tree.= '<a href="#." class="rb-leaf"></a>';
			$tree.= '<a href="'.$cat_link.'"><span'.($code==$rcode?' class="rb-active"':'').'>';
         		if($conf['dispCheckbox']) $tree.= $catCheckbox;
			$tree.= $C['name'];
			$tree.='</span></a>';
			if($conf['dispNum']) $tree.=$dispNum;

		}
		$tree.= '</li>';
		$_i++;
	}
	$tree.= '</ul></div>';
	return $tree;
}

// 포스트 상태별 라벨 출력 함수
function postLabel($mod,$step,$isreserve)
{
	$user_step=array('임시보관','발행요청','발행보류','발행완료');
	$manager_step=array('임시보관','대기','보류','발행');
	$step_label=array('default','success','danger','default');
    $html='';
    if($mod=='user') $html.='<span class="badge badge-'.$step_label[$step].'">'.$user_step[$step].'</span>';
    else $html.='<span class="badge badge-'.$step_label[$step].'">'.$mamager_step[$step].'</span>';

    // 예약발행 체크
    if($isreserve) $html.=' <span class="label label-info">예약</span>';

    return $html;
}

/** 날짜 출력함수
$R : 해당 row 배열
$mod : d_regis,d_modify,d_published (최초등록, 수정, 발행)
**/
function getTimeagoDate($date,$mod)
{
	if($date){
	   $html='<time class="timeago" data-toggle="tooltip" datetime="'.getDateFormat($date,'c').'" data-tooltip="tooltip" title="'.getDateFormat($date,'Y.m.d H:i').'"></time>';
	}else{
		if($mod=='d_published') $html ='<span class="text-mute">발행 전</span>';
		else $html='';
	}
	return $html;
}

/* 알림을 보내는 방법 ************************************************************
- 다음의 함수를 실행합니다.
putNotice($rcvmember,$sendmodule,$sendmember,$message,$referer,$target);
$rcvmember	: 받는회원 UID
$sendmodule	: 보내는모듈 ID
$sendmember	: 보내는회원 UID (시스템으로 보낼경우 0)
$message	: 보내는 메세지 (관리자 및 허가된 사용자는 HTML태그 사용가능 / 일반 회원은 불가)
$referer	: 연결해줄 URL이 있을 경우 http:// 포함하여 지정
$target		: 연결할 URL의 링크 TARGET (새창으로 연결하려면 _blank)

/* 포스트 알림 전송함수 ************************************************************
$SM : 보내는 회원 정보 배열
$RM : 받는 회원 정보 배열
$Post_id : 블로그 아이디
$mod : 승인요청, 보류, 발행 (req,hold,publish)
********************************************************************************/
function putPostNotice($SM,$RM,$Post_id,$mod)
{
	global $g,$r,$_HS;

   // 기본값 설정
   $target='_self'; // _blank 처리하지 않는다.
   $base_link=$g['url_root'].'/?r='.$r.'&mod=';

    // 모드별 메세지 세팅
    $mod_to_msg=array(
    	'req'=>'포스트 발행승인 요청이 도착했습니다.',
    	'hold'=>$RM[$_HS['nametype']].'님이 등록한 포스트가 발행보류 처리되었습니다.',
    	'publish'=>$RM[$_HS['nametype']].'님이 등록한 포스트가 발행되었습니다.',
    );

    // 모드별 링크 세팅
    $mod_to_link=array('req'=>'post-confirm','hold'=>'post-all','publish'=>'post-all');

    // 알림함수 공통인수 설정
	$rcvmbr=$RM['memberuid'];
	$sendmbr=$SM['memberuid'];
	$sendmodule='Post';

	// 모드별 알림 메세지 & 링크  세팅
   $msg=$mod_to_msg[$mod];
   $link=$base_link.$mod_to_link[$mod];

   // 알림 발송
   putNotice($rcvmbr,$sendmodule,$sendmbr,$msg,$link,$target);

   // 메일 발송
   setSendMail($SM,$RM,$mod,$link);
}

/* 포스트 알림 메일전송 함수 ************************************************************
$SM : 보내는 회원 정보 배열
$RM : 받는 회원 정보 배열
$mod : 승인요청, 보류, 발행 (req,hold,publish)
$link : 해당 포스트 링크
********************************************************************************/
function setSendMail($SM,$RM,$mod,$link)
{
    global $g,$_HS;

    include_once $g['path_core'].'function/email.func.php';

    // 공통 인수 설정
    $to_email=$RM['email'];
    $to_name=$RM['name'];
    // $from_email=$SM['email'];
		$from_email='notifications@kimsq.com';  // 시스템 보내는 메일주소,  보낸 사람의 주소가 실제 발송 주소와 다를 경우 스펨처리 될 가능성
    $from_name='경기방송';

    if($mod=='req'){ // 승인자에게 보냄
       $title='['.$_HS['name'].'] 사이트에 등록된 포스트의 승인요청 입니다. ';
       $content='아래와 같이 '.$RM[$_HS['nametype']].'님의 승인요청 포스트가 등록되었습니다. <br />';
   }else if($mod=='hold'){
	   $title='['.$_HS['name'].'] 사이트에 등록된 포스트가 발행보류 처리되었습니다. ';
       $content='아래와 같이 '.$RM[$_HS['nametype']].'님이 등록한 포스트가 발행보류 처리되었습니다. <br />';
	}else if($mod=='publish'){
       $title='['.$_HS['name'].'] 사이트에 등록된 포스트가 발행 처리되었습니다. ';
       $content='아래와 같이 '.$RM[$_HS['nametype']].'님이 등록한 포스트가 발행 처리되었습니다. <br />';
	}
    // content 내용에 링크 추가
    $content .='<a href="'.$link.'" target="_blank">'.$link.'</a>';

    getSendMail($to_email.'|'.$to_name, $from_email.'|'.$from_name,$title, $content, 'HTML');

}


// 포스트 위젯에서 사용되는 base 쿼리 정의
function getPostBaseQry($m)
{
	global $table,$s;
	return $table[$m.'data'].'.isreserve=0 and '.$table[$m.'data'].'.step=3';
}

// 포스트 데이타 추출 함수
function getPostData($R,$data)
{
	global $g,$table,$r,$_HS,$d;

   $m='Post';

   include_once $g['path_module'].$m.'/var/var.php';

   $result=array();
	 $B=getUidData($table[$m.'list'],$R['Post']);

   if($d['Post']['rewrite']) $result['link']=$g['s'].($r?'/'.$r:'').'/archive/'.$B['id'].'/';
   else $result['link'] = $g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;Post='.$B['id'].'&amp;front=list&uid=';

   if($R['isphoto']&&$R['upload'])
    {
        $upArray = getArrayString($R['upload']);
        $_U = getUidData($table['s_upload'],$upArray['data'][0]);
        $img = $_U['url'].$_U['folder'].'/'.$_U['tmpname'];
    }
    $img_arr=getImgs($R['content'],'jpg');
    $result['preview_img']=$img_arr[0]?$img_arr[0]:'';

    // 회원정보 세팅
    $M=getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'*');
		$M2=getDbData($table['s_mbrid'],'uid='.$R['mbruid'],'*');

    // 회원이름
    $result['mbr_name']=$M[$_HS['nametype']];

		// 회원 아이디
		$result['mbr_id']=$M2['id'];

     // 아바타 사진 url 세팅
     if($M['photo']) $result['avatar_img']=$g['url_root'].'/_var/avatar/'.$M['photo'];
     else  $result['avatar_img']=$g['url_root'].'/_var/avatar/0.gif';

    return $result[$data];
}

// 권기택 추가

//분류코드->SQL
function getPostCategoryCodeToSql($table,$cat)
{
	$R=getUidData($table,$cat);
	if ($R['uid']) $sql .= 'category='.$R['uid'].' or ';
	if ($R['isson'])
	{
		$RDATA=getDbSelect($table,'parent='.$R['uid'],'uid,isson');
		while($C=db_fetch_array($RDATA)) $sql .= getPostCategoryCodeToSqlX($table,$C['uid'],$C['isson']);
	}
	return substr($sql,0,strlen($sql)-4);
}
//분류코드->SQL
function getPostCategoryCodeToSqlX($table,$cat,$isson)
{
	$sql = 'category='.$cat.' or ';
	if ($isson)
	{
		$RDATA=getDbSelect($table,'parent='.$cat,'uid,isson');
		while($C=db_fetch_array($RDATA)) $sql .= getPostCategoryCodeToSqlX($table,$C['uid'],$C['isson']);
	}
	return $sql;
}

// daum 송고용 채널명 추출함수
function getDaumChannel($post){
    global $table,$DB_CONNECT;

    $tbl_idx = $table['Postcatidx'];
    $tbl_cat = $table['Postcategory'];

    $query="SELECT i.*,c.* FROM ".$tbl_idx." as i left join ".$tbl_cat." as c on i.category=c.uid
               WHERE i.post=".$post." and c.hidden=0 and c.daum_cat<>''";
    $result = db_fetch_array(db_query($query,$DB_CONNECT));

	$channel = $result['daum_cat'];
	return $channel;
}

?>
