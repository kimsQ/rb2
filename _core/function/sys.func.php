<?php
// 소요시간 얻기
function getNowTimes() {
	$MicroTsmp = explode(' ',microtime());
	return $MicroTsmp[0]+$MicroTsmp[1];
}

//TIME얻기
function getCurrentDate()
{
	$MicroTsmp = explode(' ',microtime());
	return $MicroTsmp[0]+$MicroTsmp[1];
}
//링크
function getLink($url,$target,$alert,$history)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getLink.lib.php';
}
//윈도우오픈
function getWindow($url,$alert,$option,$backurl,$target)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getWindow.lib.php';
}
//검색sql
function getSearchSql($w,$k,$ik,$h)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/searchsql.lib.php';
	return LIB_getSearchSql($w,$k,$ik,$h);
}
//페이징
function getPageLink($lnum,$p,$tpage,$_N)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/page.lib.php';
	return LIB_getPageLink($lnum,$p,$tpage,$_N);
}
//문자열끊기
function getStrCut($long_str,$cutting_len,$cutting_str)
{
	$rtn = array();$long_str = trim($long_str);
    return preg_match('/.{'.$cutting_len.'}/su', $long_str, $rtn) ? $rtn[0].$cutting_str : $long_str;
}
//링크필터링
function getLinkFilter($default,$arr)
{
	foreach($arr as $val) if ($GLOBALS[$val]) $default .= '&amp;'.$val.'='.urlencode($GLOBALS[$val]);
	return $default;
}
function getLinkFilter2($default,$arr)
{
	$i = 0;
	foreach($arr as $val) {
		if ($GLOBALS[$val]) {
			$i++;
			$default .= ($i==1 && $GLOBALS['_HS']['rewrite'] ?'?':'&amp;').$val.'='.$GLOBALS[$val];
		}

	}
	return $default;
}
//총페이지수
function getTotalPage($num,$rec)
{
	return @intval(($num-1)/$rec)+1;
}
//날짜포맷
function getDateFormat($d,$f)
{
	return $d ? getDateCal($f,$d,0) : '';
}
//시간조정/포맷
function getDateCal($f,$d,$h)
{
	return date($f,mktime((int)substr($d,8,2)+$h,(int)substr($d,10,2),(int)substr($d,12,2),substr($d,4,2),substr($d,6,2),substr($d,0,4)));
}
//시간값
function getVDate($t)
{
	$date['PROC']	= $t ? getDateCal('YmdHisw',date('YmdHis'),$t) : date('YmdHisw');
	$date['totime'] = substr($date['PROC'],0,14);
	$date['year']	= substr($date['PROC'],0,4);
	$date['month']	= substr($date['PROC'],0,6);
	$date['today']  = substr($date['PROC'],0,8);
	$date['nhour']  = substr($date['PROC'],0,10);
	$date['tohour'] = substr($date['PROC'],8,6);
	$date['toweek'] = substr($date['PROC'],14,1);
	return $date;
}
//남은날짜
function getRemainDate($d)
{
	if(!$d) return 0;
	return ((substr($d,0,4)-date('Y')) * 365) + (date('z',mktime(0,0,0,substr($d,4,2),substr($d,6,2),substr($d,0,4)))-date('z'));
}
//지난시간
function getOverTime($d1,$d2)
{
	if (!$d2) return array(0);
	$d1 = date('U',mktime(substr($d1,8,2),substr($d1,10,2),substr($d1,12,2),substr($d1,4,2),substr($d1,6,2),substr($d1,0,4)));
	$d2 = date('U',mktime(substr($d2,8,2),substr($d2,10,2),substr($d2,12,2),substr($d2,4,2),substr($d2,6,2),substr($d2,0,4)));
	$tx = $d1-$d2;$ar = array(1,60,3600,86400,2592000,31104000);
	for ($i = 0; $i < 5; $i++) if ($tx < $ar[$i+1]) return array((int)($tx/$ar[$i]),$i);
	return array(substr($d1,0,4)-substr($d2,0,4),5);
}
//요일
function getWeekday($n)
{
	return $GLOBALS['lang']['admin']['week'][$n];
}
//시간비교(시간단위)
function getNew($time,$term)
{
	if(!$time) return false;
	$dtime = date('YmdHis',mktime(substr($time,8,2)+$term,substr($time,10,2),substr($time,12,2),substr($time,4,2),substr($time,6,2),substr($time,0,4)));
	if ($dtime > $GLOBALS['date']['totime']) return true;
	else return false;
}
//시간비교(분단위)
function getValid($time,$term)
{
	if(!$time) return false;
	$dtime = date('YmdHis',mktime(substr($time,8,2),substr($time,10,2)+$term,substr($time,12,2),substr($time,4,2),substr($time,6,2),substr($time,0,4)));
	if ($dtime > $GLOBALS['date']['totime']) return true;
	else return false;
}
//퍼센트
function getPercent($a,$b,$flag)
{
	return round($a / $b * 100 , $flag);
}
//지정문자열필터링
function filterstr($str)
{
	$str = str_replace(',','',$str);
	$str = str_replace('.','',$str);
	$str = str_replace('-','',$str);
	$str = str_replace(':','',$str);
	$str = str_replace(' ','',$str);
	return $str;
}
//문자열복사
function strCopy($str1,$str2)
{
	$badstrlen = getUTFtoUTF($str1) == $str1 ? strlen($str1) : intval(strlen($str1)/3);
	return str_pad('',($badstrlen?$badstrlen:1),$str2);
}
//아웃풋
function getContents($str,$html)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getContent.lib.php';
	return LIB_getContents($str,$html,$filter);
}
//쿠키배열
function getArrayCookie($ck,$split,$n)
{
	$arr = explode($split,$ck);
	return $arr[$n];
}
//대괄호배열
function getArrayString($str)
{
	$arr1 = array();
	$arr1['data'] = array();
	$arr2 = explode('[',$str);
	foreach($arr2 as $val)
	{
		if($val=='') continue;
		$arr1['data'][] = str_replace(']','',$val);
	}
	$arr1['count'] = count($arr1['data']);
	return $arr1;
}
//성별
function getSex($flag)
{
	return $GLOBALS['lang']['admin']['sex'][$flag-1];
}
//생일->나이
function getAge($birth)
{
	if (!$birth) return 0;
	return substr($GLOBALS['date']['today'],0,4) - substr($birth,0,4) + 1;
}
//나이->출생년도
function getAgeToYear($age)
{
	return substr($GLOBALS['date']['today'],0,4)-($age-1);
}
//사이즈포멧
function getSizeFormat($size,$flag)
{
	if ($size/(1024*1024*1024)>1) return round($size/(1024*1024*1024),$flag).'GB';
	if ($size/(1024*1024)>1) return round($size/(1024*1024),$flag).'MB';
	if ($size/1024>1) return round($size/1024,$flag).'KB';
	if ($size/1024<1) return $size.'B';
}
//파일타입
function getFileType($ext)
{
	if (strpos('_gif,jpg,jpeg,png,bmp,',strtolower($ext))) return 2;
	if (strpos('_swf,',strtolower($ext))) return 3;
	if (strpos('_mid,wav,mp3,m4a,',strtolower($ext))) return 4;
	if (strpos('_mp4,asf,asx,avi,mpg,mpeg,wmv,wma,mov,flv,',strtolower($ext))) return 5;
	if (strpos('_doc,xls,ppt,hwp',strtolower($ext))) return 6;
	if (strpos('_zip,tar,gz,tgz,alz,',strtolower($ext))) return 7;
	return 1;
}
//파일확장자
function getExt($name)
{
	$nx=explode('.',$name);
	return $nx[count($nx)-1];
}
//이미지추출
function getImgs($code,$type)
{
	$erg = '/src[ =]+[\'"]([^\'"]+\.(?:'.$type.'))[\'"]/i';
	preg_match_all($erg, $code, $mtc, PREG_PATTERN_ORDER);
	return $mtc[1];
}
//이미지체크
function getThumbImg($img)
{
	$arr=array('.jpg','.gif','.png');
	foreach($arr as $val) if(is_file($img.$val)) return $GLOBALS['g']['s'].'/'.str_replace('./','',$img).$val;
}
function getUploadImage($upfiles,$d,$content,$ext)
{
	include_once $GLOBALS['g']['path_core'].'function/lib/getUploadImage.lib.php';
	return LIB_getUploadImage($upfiles,$d,$content,$ext);
}

//도메인
function getDomain($url)
{
	$urlexp = explode('/',$url);
	return $urlexp[2];
}
//키워드
function getKeyword($url)
{
	$urlexp = explode('?' , urldecode($url));
	if (!trim($urlexp[1])) return '';
	$queexp = explode('&' , $urlexp[1]);
	$quenum = count($queexp);
	for ($i = 0; $i < $quenum; $i++){$valexp = explode('=',trim($queexp[$i])); if (strstr(',query,q,p,',','.$valexp[0].',')&&!is_numeric($valexp[1])) return $valexp[1] == getUTFtoUTF($valexp[1]) ? $valexp[1] : getKRtoUTF($valexp[1]);}
	return '';
}
//검색엔진
function getSearchEngine($url)
{
	$set = array('naver','nate','daum','yahoo','google');
	foreach($set as $val) if (strpos($url,$val)) return $val;
	return 'etc';
}
//브라우져
function getBrowzer($agent)
{
	if(isMobileConnect($agent)) {
		$set = array('Android','iPhone');
	} else {
		$set = array('rv:12','rv:11','MSIE 10','MSIE 9','MSIE 8','MSIE 7','MSIE 6','Firefox','Opera','Chrome','Safari');
	}
	foreach($set as $val) if (strpos('_'.$agent,$val)) return str_replace('rv:','MSIE ',$val);
	return '';
}
//디바이스종류
function getDeviceKind($agent,$type)
{
	if (!$type) return 'desktop';
	if ($type == 'ipad' || (strstr($agent,'android')&&!strstr($agent,'mobile'))) return 'tablet';
	return 'phone';
}
//모바일접속체크
function isMobileConnect($agent)
{
	if($_SESSION['pcmode']=='E') return 'RB-Emulator';
	$_xagent = strtolower($agent);
	$_agents = array('android','iphone','ipad','ipod','blackberry','windows phone');
	foreach($_agents as $_key) if(strpos($_xagent,$_key)) return $_key;
	return '';
}
//폴더네임얻기
function getFolderName($file)
{
	if(is_file($file.'/name.txt')) return implode('',file($file.'/name.txt'));
	return basename($file);
}
function getKRtoUTF($str)
{
	return iconv('euc-kr','utf-8',$str);
}
function getUTFtoKR($str)
{
	return iconv('utf-8','euc-kr',$str);
}
function getUTFtoUTF($str)
{
	return iconv('utf-8','utf-8',$str);
}
//관리자체크
function checkAdmin($n)
{
	if(!$GLOBALS['my']['admin']) getLink('','','관리권한이 없습니다.',$n?$n:'');
}
//MOD_rewrite
function RW($rewrite)
{
	if ($GLOBALS['_HS']['rewrite'])
	{
		if(!$rewrite) return $GLOBALS['g']['r']?$GLOBALS['g']['r']:'/';
		$rewrite = str_replace('c=','c/',$rewrite);
		$rewrite = str_replace('m=post&mbrid=','@',$rewrite);
		// $rewrite = str_replace('m=post&mod=list','list',$rewrite);
		$rewrite = str_replace('m=post&mod=list_view','list',$rewrite);
		$rewrite = str_replace('&mod=list_view&listid=','/list/',$rewrite);
		$rewrite = str_replace('&listid=','/',$rewrite);
		$rewrite = str_replace('m=search','search',$rewrite);
		$rewrite = str_replace('m=post','post',$rewrite);
		$rewrite = str_replace('&mod=write','/write',$rewrite);
		$rewrite = str_replace('&mod=category','/category',$rewrite);
		$rewrite = str_replace('&mod=keyword&','/search?',$rewrite);
		$rewrite = str_replace('&mod=view&cid=','/post/',$rewrite);
		$rewrite = str_replace('mod=dashboard','dashboard',$rewrite);
		$rewrite = str_replace('mod=settings','settings',$rewrite);
		$rewrite = str_replace('mod=profile&mbrid=','@',$rewrite);
		$rewrite = str_replace('mod=','p/',$rewrite);
		$rewrite = str_replace('m=admin','admin',$rewrite);
		$rewrite = str_replace('m=bbs','b',$rewrite);
		$rewrite = str_replace('&bid=','/',$rewrite);
		$rewrite = str_replace('&uid=','/',$rewrite);
		$rewrite = str_replace('&cid=','/',$rewrite);
		$rewrite = str_replace('&CMT=','/',$rewrite);
		$rewrite = str_replace('&page=','?page=',$rewrite);
		$rewrite = str_replace('&code=','?code=',$rewrite);
		$rewrite = str_replace('&s=','/s',$rewrite);
		$rewrite = str_replace('&cat=','/category/',$rewrite);

		return $GLOBALS['g']['r'].'/'.$rewrite;
	}
	else return $GLOBALS['_HS']['usescode']?('./?r='.$GLOBALS['_HS']['id'].($rewrite?'&amp;'.$rewrite:'')):'./'.($rewrite?'?'.$rewrite:'');
}
//위젯불러오기
function getWidget($widget,$wdgvar)
{
	global $DB_CONNECT,$table,$date,$my,$r,$s,$m,$g,$d,$c,$mod,$_HH,$_HD,$_HS,$_HM,$_HP,$_CA;
	static $wcsswjsc;
	if (!is_file($g['wdgcod']) && !strpos('_'.$wcsswjsc,'['.$widget.']'))
	{
		$wcss = $g['path_widget'].$widget.'/main.css';
		$wjsc = $g['path_widget'].$widget.'/main.js';
		if (is_file($wcss)) $g['widget_cssjs'] .= '<link href="'.$g['s'].'/widgets/'.$widget.'/main.css" rel="stylesheet">'."\n";
		if (is_file($wjsc)) $g['widget_cssjs'] .= '<script src="'.$g['s'].'/widgets/'.$widget.'/main.js"></script>'."\n";
		$wcsswjsc.='['.$widget.']';
	}
	$wdgvar['widget_id'] = str_replace('/','-',$widget);
	$wdgvar['widgetlang'] = $_HS['lang']?$_HS['lang']:$d['admin']['syslang'];
	include getLangFile($g['path_widget'].$widget.'/lang.',$wdgvar['widgetlang'],'.php');
	include $g['path_widget'].$widget.'/main.php';
}

//위젯목록
function getWidgetList($str)
{
	$page_widgets = preg_replace('/\r\n|\r|\n/','',trim($str));
	$widgets = getArrayString($page_widgets);
	$code='';
	foreach ($widgets['data'] as $widget) {
		$wdg_arr = explode('^',$widget);
		$wdgvar_arr = explode(',',$wdg_arr[3]);
		$wdgvar = array();
		foreach ($wdgvar_arr as $key ) {
			$_wdgvar_arr = explode('=',$key);
			$wdgvar += [ $_wdgvar_arr[0] => $_wdgvar_arr[1] ];
		}
		$code.= getWidget($wdg_arr[2],$wdgvar);
	}
	return $code;
}

// 페이지 편집용 위젯목록
function getWidgetListEdit($str)
{
	global $g;
	$page_widgets = preg_replace('/\r\n|\r|\n/','',trim($str));
	$widgets = getArrayString($page_widgets);

	if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
		$html = '<ol class="list-unstyled mb-0">';
		foreach ($widgets['data'] as $widget) {
			$wdg_arr = explode('^',$widget);
			$html .= '<li class="card bg-white round-0 position-relative text-muted text-xs-center shadow-sm" data-name="'.$wdg_arr[1].'" data-path="'.$wdg_arr[2].'" id="'.$wdg_arr[0].'" data-role="item">
									<a data-act="remove" title="삭제" role="button" class="position-absolute btn btn-link text-muted border-0" style="right:.5rem;top:50%;margin-top: -.92rem;"><i class="fa fa-times" aria-hidden="true"></i></a>
									<div data-act="move" class="position-absolute btn btn-link text-muted border-0" style="left:.5rem;top:50%;margin-top: -.92rem;"><i class="fa fa-arrows" aria-hidden="true"></i></div>
									<input type="hidden" name="widget_members[]" value="['.$widget.']">
									<button type="button" class="btn btn-link btn-lg text-reset" data-act="edit">'.$wdg_arr[1].'</button>
								</li>';
		}
		$html .= '</ol>';
	} else {
		$html = '<ol class="dd-list list-unstyled mb-0">';
		foreach ($widgets['data'] as $widget) {
			$wdg_arr = explode('^',$widget);
			$html .= '<li class="card round-0 mb-3 text-muted  text-center dd-item" data-name="'.$wdg_arr[1].'" data-path="'.$wdg_arr[2].'" id="'.$wdg_arr[0].'" data-role="item">
									<div class="position-relative"><a href="" data-act="remove" title="삭제" class="badge badge-light border-0"><i class="fa fa-times" aria-hidden="true"></i></a>
									<div data-act="move" class="badge badge-light dd-handle border-0"><i class="fa fa-arrows" aria-hidden="true"></i></div></div>
									<input type="hidden" name="widget_members[]" value="['.$widget.']">
									<div class="card-body"><a href="#" class="text-reset" data-role="title" data-act="edit">'.$wdg_arr[1].'</a></div>
								</li>';
		}
		$html .= '</ol>';
	}

	return $html;
}

//문자열필터(@ 1.1.0)
function getStripTags($string)
{
	return str_replace('&nbsp;',' ',str_replace('&amp;nbsp;',' ',strip_tags($string)));
}
//스위치로드(@ 1.1.0)
function getSwitchInc($pos)
{
	$incs = array();
	if(isset($GLOBALS['d']['switch'][$pos]))
	{
		foreach ($GLOBALS['d']['switch'][$pos] as $switch => $sites)
		{
			if(strpos('_'.$sites,'['.$GLOBALS['r'].']'))
			$incs[] = $GLOBALS['g']['path_switch'].$pos.'/'.$switch.'/main.php';
		}
	}
	return $incs;
}
//알림기록(@ 2.0.0)
function putNotice($rcvmember,$sendmodule,$sendmember,$title,$message,$referer,$button,$tag,$skip_email,$skip_push)
{
	global $g,$d,$s,$table,$date,$my,$_HS;
	include $g['path_module'].'notification/var/var.php';
	if ($rcvmember && $message && !strstr($d['ntfc']['cut_modules'],'['.$sendmodule.']'))
	{
		$R=getDbData($table['s_mbrdata'],'memberuid='.$rcvmember,'noticeconf');
		$N = explode('|',$R['noticeconf']);
		$send_email = $N[1]?1:0;
		$send_push = $N[2]?1:0;

		$title = $title?$title:'새 알림이 도착했습니다.';
		if (!$N[0] && !strstr($N[3],'['.$sendmodule.']') && !strstr($N[4],'['.$sendmember.']'))
		{
			$message = $my['admin'] ? $message : strip_tags($message);
			$QKEY = 'uid,mbruid,site,frommodule,frommbr,title,message,referer,button,tag,d_regis,d_read,email,push';
			$QVAL = "'".$g['time_srnad']."','".$rcvmember."','".$s."','".$sendmodule."','".$sendmember."','".$title."','".$message."','".$referer."','".$button."','".$tag."','".$date['totime']."','',$send_email,$send_push";
			getDbInsert($table['s_notice'],$QKEY,$QVAL);
			getDbUpdate($table['s_mbrdata'],'num_notice='.getDbRows($table['s_notice'],'mbruid='.$rcvmember." and d_read=''"),'memberuid='.$rcvmember);

			if ($send_email && !$skip_email) {  //이메일 알림
			  include_once $g['path_core'].'function/email.func.php';
			  $M = getDbData($table['s_mbrdata'],'memberuid='.$rcvmember,'name,email');
			  $join_email = $d['member']['join_email']?$d['member']['join_email']:$d['admin']['sysmail'];
			  $join_tel = $d['member']['join_tel']?$d['member']['join_tel']:$d['admin']['sms_tel'];

			  $email_title = '['.$_HS['name'].' 알림] '.$title;

			  $email_body = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
			  $email_body .= '<p>'.$message.'</p>';
			  $email_body.= '<p><a href="'.$referer.'" style="display:block;font-size:15px;color:#fff;text-decoration:none;padding: 15px;background:#007bff;width: 200px;text-align: center;margin: 38px auto;" target="_blank">'.$button.'</a></p>';
			  $email_body.= implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
			  $email_body = str_replace('{EMAIL_MAIN}',$join_email,$email_body); //대표 이메일
			  $email_body = str_replace('{TEL_MAIN}',$join_tel,$email_body); // 대표 전화
			  $email_body = str_replace('{SITE}',$_HS['name'],$email_body); //사이트명

			  getSendMail($M['email'].'|'.$M['name'],$my['email'].'|'.$my['nic'],$email_title,$email_body,'HTML');
			}


			if ($send_push && !$skip_push) { //푸시 알림
				include_once $g['path_core'].'function/fcm.func.php';
				$TKD = getDbArray($table['s_iidtoken'],'mbruid='.$rcvmember,'token','uid','asc',0,1);
				$tokenArray = array();

				if ($sendmember==0) {
					$avatar = $g['url_http'].'/_core/images/touch/homescreen-192x192.png';
				} else {

					$M = getDbData($table['s_mbrdata'],'memberuid='.$sendmember,'photo');
					if ($M['photo']) {
						$_array=explode('.',$M['photo']);
						$name=$_array[0];
						$ext=$_array[1];
						$size='192x192';
						$avatar=$g['s'].'/avatar/'.$name.'_'.$size.'.'.$ext;
					} else {
						$avatar=$g['s'].'/files/avatar/0.svg';
					}
				}

			  while ($row = db_fetch_array($TKD)) {
			    array_push($tokenArray,$row['token']);
			  }
				getSendFCM($tokenArray,$title,$message,$avatar,$referer,$tag);
			}

		}
	}
}
//모달링크(@ 2.0.0)
function getModalLink($modal)
{
	global $g,$r;
	return $g['s'].'/?r='.$r.'&amp;iframe=Y&amp;modal='.$modal;
}
//JS/CSS임포트(@ 2.0.0)
function getImport($plugin,$path,$version,$kind)
{
	global $g,$d;
	if ($kind == 'js') echo '<script src="'.$g['s'].'/plugins/'.$plugin.'/'.($version?$version:$d['ov'][$plugin]).'/'.$path.'.js"></script>';
	else echo '<link href="'.$g['s'].'/plugins/'.$plugin.'/'.($version?$version:$d['ov'][$plugin]).'/'.$path.'.css" rel="stylesheet">';
}
//썸네일(@ 2.0.0)
function getThumbPic($width,$height,$crop,$img)
{
	global $g;
	return $g['s'].'/_core/opensrc/thumb/image.php?width='.($width?$width:'').'&amp;height='.($height?$height:'').'&amp;cropratio='.$crop.'&amp;image='.$img;
}
//트리(@ 2.0.0)
function getTreeMenu($conf,$code,$depth,$parent,$tmpcode)
{
	global $_HS;
	$ctype = $conf['ctype']?$conf['ctype']:'uid';
	$id = 'tree_'.filterstr(microtime());
	$tree = '<div class="rb-tree"><ul id="'.$id.'">';
	$CD=getDbSelect($conf['table'],($conf['site']?'site='.$conf['site'].' and ':'').'depth='.($depth+1).' and parent='.$parent.($conf['dispHidden']?' and hidden=0':'').($conf['mobile']?' and mobile=1':'').' order by gid asc','*');
	$_i = 0;
	while($C=db_fetch_array($CD))
	{
		$rcode= $tmpcode?$tmpcode.'/'.$C[$ctype]:$C[$ctype];
		$t_arr = explode('/', $code);
		$t1_arr = explode('/', $rcode);
		$topen= in_array($t1_arr[count($t1_arr)-1], $t_arr)?true:false;

		$tree.= '<li>';
		if ($C['is_child'])
		{
			$tree.= '<a data-toggle="collapse" href="#'.$id.'-'.$_i.'-'.$C['uid'].'" class="rb-branch'.($conf['allOpen']||$topen?'':' collapsed').'"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu-'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a href="'.$conf['link'].$C['uid'].($_HS['rewrite']?'?':'&amp;').'code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="숨김" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</span>';
			$tree.='</u></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="fa fa-mobile fa-fw fa-lg" title="모바일" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= ' <i class="fa fa-window-restore fa-fw" title="새창" data-tooltip="tooltip"></i>';
				if($C['reject']) $tree.= ' <i class="fa fa-lock fa-lg fa-fw" title="차단" data-tooltip="tooltip"></i>';
			}

			$tree.= '<ul id="'.$id.'-'.$_i.'-'.$C['uid'].'" class="collapse'.($conf['allOpen']||$topen?' show':'').'">';
			$tree.= getTreeMenu($conf,$code,$C['depth'],$C['uid'],$rcode);
			$tree.= '</ul>';
		}
		else {
			$tree.= '<a href="#." class="rb-leaf"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if ($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a href="'.$conf['link'].$C['uid'].($_HS['rewrite']?'?':'&amp;').'code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="숨김" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</u>';
			$tree.='</span></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="fa fa-mobile fa-lg fa-fw" title="모바일" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= ' <i class="fa fa-window-restore fa-fw" title="새창" data-tooltip="tooltip"></i>';
				if($C['reject']) $tree.= ' <i class="fa fa-lock fa-lg fa-fw" title="차단" data-tooltip="tooltip"></i>';
			}
		}
		$tree.= '</li>';
		$_i++;
	}
	$tree.= '</ul></div>';
	return $tree;
}

function getTreeCategory($conf,$code,$depth,$parent,$tmpcode)
{
	global $_HS;
	$ctype = $conf['ctype']?$conf['ctype']:'uid';
	$id = 'tree_'.filterstr(microtime());
	$tree = '<div class="rb-tree"><ul id="'.$id.'">';
	$CD=getDbSelect($conf['table'],($conf['site']?'site='.$conf['site'].' and ':'').'depth='.($depth+1).' and parent='.$parent.($conf['dispHidden']?' and hidden=0':'').($conf['mobile']?' and mobile=1':'').' order by gid asc','*');
	$_i = 0;
	while($C=db_fetch_array($CD))
	{
		$rcode= $tmpcode?$tmpcode.'/'.$C[$ctype]:$C[$ctype];
		$t_arr = explode('/', $code);
		$t1_arr = explode('/', $rcode);
		$topen= in_array($t1_arr[count($t1_arr)-1], $t_arr)?true:false;

		$tree.= '<li>';
		if ($C['is_child'])
		{
			$tree.= '<a data-toggle="collapse" href="#'.$id.'-'.$_i.'-'.$C['uid'].'" class="rb-branch'.($conf['allOpen']||$topen?'':' collapsed').'"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu-'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a href="'.$conf['link'].$C['id'].($_HS['rewrite']?'?':'&amp;').'code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="숨김" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</span>';
			$tree.='</u></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="fa fa-mobile fa-fw fa-lg" title="모바일" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= ' <i class="fa fa-window-restore fa-fw" title="새창" data-tooltip="tooltip"></i>';
				if($C['reject']) $tree.= ' <i class="fa fa-lock fa-lg fa-fw" title="차단" data-tooltip="tooltip"></i>';
			}

			$tree.= '<ul id="'.$id.'-'.$_i.'-'.$C['uid'].'" class="collapse'.($conf['allOpen']||$topen?' show':'').'">';
			$tree.= getTreeCategory($conf,$code,$C['depth'],$C['uid'],$rcode);
			$tree.= '</ul>';
		}
		else {
			$tree.= '<a href="#." class="rb-leaf"></a>';
			if ($conf['userMenu']=='link') $tree.= '<a href="'.RW('c='.$rcode).'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else if ($conf['userMenu']=='bookmark') $tree.= '<a data-scroll href="#rb-tree-menu'.$C['id'].'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			else $tree.= '<a href="'.$conf['link'].$C['id'].($_HS['rewrite']?'?':'&amp;').'code='.$rcode.($conf['bookmark']?'#'.$conf['bookmark']:'').'"><span'.($code==$rcode?' class="rb-active"':'').'>';
			if($conf['dispCheckbox']) $tree.= '<input type="checkbox" name="tree_members[]" value="'.$C['uid'].'">';
			if($C['hidden']) $tree.='<u title="숨김" data-tooltip="tooltip">';
			$tree.= $C['name'];
			if($C['hidden']) $tree.='</u>';
			$tree.='</span></a>';

			if($conf['dispNum']&&$C['num']) $tree.= ' <small>('.$C['num'].')</small>';
			if(!$conf['hideIcon'])
			{
				if($C['mobile']) $tree.= '<i class="fa fa-mobile fa-lg fa-fw" title="모바일" data-tooltip="tooltip"></i>&nbsp;';
				if($C['target']) $tree.= ' <i class="fa fa-window-restore fa-fw" title="새창" data-tooltip="tooltip"></i>';
				if($C['reject']) $tree.= ' <i class="fa fa-lock fa-lg fa-fw" title="차단" data-tooltip="tooltip"></i>';
			}
		}
		$tree.= '</li>';
		$_i++;
	}
	$tree.= '</ul></div>';
	return $tree;
}

//현재경로(@ 2.0.0)
function getLocation($loc)
{
	if ($loc) return str_replace(' - Home - ','',strip_tags(str_replace('<li',' - <li',$loc)));
	else {
		global $g,$table,$_HS,$_HP,$_HM,$_CA,$c;
		$_loc = '<li class="breadcrumb-item"><a href="'.RW(0).'">Home</a></li>';
		if ($_HM['uid'])
		{
			$_cnt = count($_CA)-1;
			$_cod = '';
			for ($i = 0; $i < $_cnt; $i++)
			{
				$_val  = getDbData($table['s_menu'],"id='".$_CA[$i]."'",'id,name');
				$_cod .= $_val['id'].'/';
				$_loc .= '<li class="breadcrumb-item"><a href="'.RW('c='.substr($_cod,0,strlen($_cod)-1)).'">'.$_val['name'].'</a></li>';
			}
			$_loc .= '<li class="breadcrumb-item active">'.$_HM['name'].'</li>';
		}
		else if ($_HP['uid'])
		{
			if ($_HP['linkedmenu'])
			{
				$_sok = explode('/',$_HP['linkedmenu']);
				$_cnt = count($_sok);
				$_cod = '';
				for ($i = 0; $i < $_cnt; $i++)
				{
					$_val  = getDbData($table['s_menu'],"id='".$_CA[$i]."'",'id,name');
					$_cod .= $_val['id'].'/';
					$_loc .= '<li class="breadcrumb-item"><a href="'.RW('c='.substr($_cod,0,strlen($_cod)-1)).'">'.$_val['name'].'</a></li>';
				}
			}
			$_loc .= '<li class="breadcrumb-item active">'.$_HP['name'].'</li>';
		}
		else if ($g['push_location'])
		{
			$_loc .= $g['push_location'];
		}
		return $_loc;
	}
}
//페이지타이틀(@ 2.0.0)
function getPageTitile()
{
	global $g,$_HS,$_HP,$_HM;
	$title = str_replace('{site}',$_HS['name'],$_HS['title']);
	$title = str_replace('{location}',getLocation($g['location']),$title);
	if ($_HM['uid']) $title = str_replace('{subject}',$_HM['name'],$title);
	else if ($_HP['uid'] && !$_HP['ismain']) $title = str_replace('{subject}',$_HP['name'],$title);
	else $title = $_HS['name'];
	return $title;
}
//메타이미지(@ 2.0.0)
function getMetaImage($str)
{
	if (!$str) return '';
	if (strstr($str,'://'))	return $str;
	$imgs = getArrayString($str);
	$R = getUidData($GLOBALS['table']['s_upload'],$imgs['data'][0]);
	if ($R['type'] == 2 || $R['type'] == 5) return getPreviewResize($R['host'],$R['folder'],$R['tmpname'],'z');
	if ($R['type'] == -1) return $R['src'];
	return '';
}
//암호화(@ 2.4)
function getCrypt($str,$salt)
{
	$salt = substr(base64_encode($salt.'salt'),0,22);
	if(function_exists('password_hash')) return password_hash($str,PASSWORD_BCRYPT,array('cost'=>10,'salt'=>$salt)).'$1';
	return md5(sha1(md5($str.$salt))).'$4';
}
//언언반환(@ 2.0.0)
function _LANG($kind,$module)
{
	return $GLOBALS['lang'][$module][$kind];
}
function _LANG_($kind,$module,$defaultstr)
{
	return $GLOBALS['lang'][$module][$kind] ? $GLOBALS['lang'][$module][$kind] : $defaultstr;
}
//언언셋인클루드(@ 2.0.0)
function getLangFile($path,$lang,$file)
{
	$langFile1 = $path.$lang.$file;
	$langFile2 = $path.'DEFAULT'.$file;
	if (is_file($langFile1)) return $langFile1;
	else if(is_file($langFile2)) return $langFile2;
	else return $GLOBALS['g']['path_var'].'empty.php';
}
// 엑세스토큰 생성
function genAccessToken($length)
{
   $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $access_token = substr( str_shuffle( $chars ), 0, $length );
    return $access_token;
}
// 엑세스토큰 세팅함수
function setAccessToken($memberuid,$type)
{
   global $g,$d,$DB,$r;
   // 해당 회원 uid 로 등록된 모든 토큰 삭제
    if($type=='logout'){
    	$RCD = array();
    	$_RCD = getDbSelect($DB['head'].'_s_mbrtoken','memberuid='.$memberuid,'*');
		while($_RC=db_fetch_array($_RCD)) $RCD[] = $_RC;
		$_WHERE = '(';
		foreach($RCD as $R)
		{
		   $_WHERE .='(memberuid='.$R['memberuid'].') or ';
		}
	     $_WHERE = substr($_WHERE,0,strlen($_WHERE)-4).')';
      getDbDelete($DB['head'].'_s_mbrtoken',$_WHERE);
      setcookie($DB['head'].'_token','',time() - 3600,'/'); // 쿠키 초기화
   }else{
     // 신규토큰 세팅
		 $g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
		 $_mbrVerFile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].'member/var/var.php';
		 require_once $_mbrVerFile;
	   $login_expire=$d['member']['login_expire']; // 회원모듈 사이트별 환경설정에서 지정한 로그인 유지 기간 (일 기준)
	   $login_expire_last=time()+60*60*24*(int)$login_expire;
	   $access_token=genAccessToken(80); //
	   $_QKEY="memberuid,access_token,expire";
	   $_QVAL=" '".$memberuid."','".$access_token."','".$login_expire_last."'";
	   getDbInsert($DB['head'].'_s_mbrtoken',$_QKEY,$_QVAL); // 토큰 테이블에 저장
	   setcookie($DB['head'].'_token',$memberuid.'|'.$access_token,$login_expire_last,'/'); // 쿠키 생성
   }
}

// TimThumb 이미지 출력함수
function getTimThumb($data=array())
{
	global $g;
	$origin_src=$data['src'];
	$w=$data['width'];
	$h=$data['height'];
	$q=$data['qulity'];
 	$f=$data['filter'];
	$a=$data['align'];
	$t=$data['type'];
	$s=$data['sharpen'];
	$source='/_core/opensrc/timthumb/thumb.php';
  $img_qry=$source.'?src='.$origin_src;
  $img_qry .=($w?'&w='.$w:'').($h?'&h='.$h:'').($q?'&q='.$q:'').($f?'&f='.$f:'').($a?'&a='.$a:'').($t?'&t='.$t:'').($s?'&s='.$s:'');

	if($origin_src) $result=$img_qry;
	else $result='';
	return $result;
}

// 아바타 이미지 추출함수
function getAvatarSrc($mbruid,$size){
	global $g,$table;
	$M = getDbData($table['s_mbrdata'],'memberuid='.$mbruid,'photo');
	$_array=explode('.',$M['photo']);
	$name=$_array[0];
	$ext=$_array[1];
	$size=$size.'x'.$size;
	if ($M['photo']) $result=$g['s'].'/avatar/'.$name.'_'.$size.'.'.$ext;
	else $result=$g['s'].'/files/avatar/no_avatar.png';
	return $result;
}

// 커버 이미지 추출함수
function getCoverSrc($mbruid,$width,$height){
	global $g,$table;
	$M = getDbData($table['s_mbrdata'],'memberuid='.$mbruid,'cover');
	$_array=explode('.',$M['cover']);
	$name=$_array[0];
	$ext=$_array[1];
	if ($M['cover']) $result=$g['s'].'/cover/'.$name.'_'.$width.'x'.$height.'.'.$ext;
	else $result=$g['s'].'/files/cover/0_'.$width.'x'.$height.'.png';
	return $result;
}

// 프로필 페이지 링크
function getProfileLink($mbruid) {
	global $g,$table;
	$M = getUidData($table['s_mbrid'],$mbruid);
	$result = RW('mod=profile&mbrid=').$M['id'];
	return $result;
}

// 회원정보 추출
function getProfileInfo($mbruid,$info){
  global $g,$table;
	$M = getDbData($table['s_mbrdata'],'memberuid='.$mbruid,'*');
	$result=$M[$info];
  return $result;
}

// 업로드 이미지 src 추출함수
function getUpImageSrc($R){
  global $g,$table;

   if($R['featured_img']){
		$F=getUidData($table['s_upload'],trim($R['featured_img']));
		$src=$F['src'];
   }else{
    $img_arr=getImgs($R['content'],'jpg|jpge|gif|png');
    $src=$img_arr[0]?$img_arr[0]:'/files/noimage.png';
   }
  return $src;
}

// 업로드 이미지 재생시간 추출함수
function getUpImageTime($R){
  global $g,$table;
	$F=getUidData($table['s_upload'],trim($R['featured_img']));
	$time=$F['time'];
  return $time;
}

// 미리보기용 이미지 resize 함수 .htaccess 연계됨
function getPreviewResize($src,$size){
	if ($src) {
		$thumbnail_url_parse = parse_url($src);
		$thumbnail_url_arr = explode('//',$src);
		if ($thumbnail_url_parse['scheme']) {
			switch ($size) {
				case 's':
					$size='75x75';
					break;
				case 'q':
					$size='150x150';
					break;
				case 't':
					$size='100x67';
					break;
				case 'm':
					$size='240x160';
					break;
				case 'n':
					$size='320x213';
					break;
				case 'z':
					$size='640x427';
					break;
				case 'c':
					$size='800x534';
					break;
				case 'b':
					$size='1024x683';
					break;
				case 'h':
					$size='1600x1068';
					break;
				case 'k':
					$size='2048x1367';
					break;
			}
			if (strpos($src, 'maps.google.com') !== false) {
				$result = $src;
			} else if (strpos($src, '?') !== false) {
				$_size = explode('x',$size);
				$result = '/_core/opensrc/timthumb/thumb.php?src='.$src.'&w='.$_size[0].'&h='.$_size[1].'&s=1';
			} else {
				$result = '/thumb'.($thumbnail_url_parse['scheme']=='https'?'-ssl':'').'/'.$size.'/u/'.$thumbnail_url_arr[1];
			}
		} else {
			$_array=explode('.',$src);
		  $name=$_array[0];
		  $ext=$_array[1];
			$result=$name.'_'.$size.'.'.$ext;
		}
	} else {
		$result='';
	}
  return $result;
}

//페이지 출력
function getPageSelect($site,$main,$mobile,$pid) {
	global $table;
	$PCD=getDbSelect($table['s_page'],$site?'site='.$site.''.($main ? ' and ismain=1':'').($mobile ? ' and mobile=1':''):'','*');
	while($P=db_fetch_array($PCD)) {
		echo '<option value="'.$P['id'].'"'.($P['id']==$pid?' selected':'').'>'.$P['name'].' - '.$P['id'].'</option>';
	}
}

// 대표이미지 메타정보 추출
function getFeaturedimgMeta($R,$meta){
  global $table;
	$F=getUidData($table['s_upload'],trim($R['featured_img']));
	$meta=$F[$meta];
  return $meta;
}

//게시물 링크
function getPostLink($arr,$profile){
	global $table;
	if ($profile) {
		$M = getUidData($table['s_mbrid'],$arr['mbruid']);
		return RW('m=post&mbrid='.$M['id'].'&mod=view&cid='.$arr['cid'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
	}  else {
		return RW('m=post&cid='.$arr['cid'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
	}
}

//리스트 링크
function getListLink($arr,$profile){
	global $table;
	if ($profile) {
		$M = getUidData($table['s_mbrid'],$arr['mbruid']);
		return RW('m=post&mbrid='.$M['id'].'&mod=list_view&listid='.$arr['id'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
	}  else {
		return RW('m=post&mod=list_view&listid='.$arr['id'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
	}
}

function getBbsPostLink($arr){
	return RW('m=bbs&bid='.$arr['bbsid'].'&uid='.$arr['uid'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
}

function getCURLData($url,$header) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	if(is_array($header)) curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt($ch, CURLOPT_COOKIE, '' );
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$curl_exec = curl_exec($ch);
	curl_close($ch);
	return $curl_exec;
}

function remoteFileExist($filepath) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$filepath);
  curl_setopt($ch, CURLOPT_NOBODY, 1);
  curl_setopt($ch, CURLOPT_FAILONERROR, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  if(curl_exec($ch)!==false) {
    return true;
  } else {
    return false;
  }
}

// 외부연결 URL 생성 (로그인과 정보 제공 동의 과정이 완료되면 콜백 URL에 code값과 state 값이 URL 문자열로 전송됩니다.)
function getConnectUrl($s,$id,$secret,$callBack,$type){
	$_SESSION['SL']['state'.$s] = md5(microtime().mt_rand());
	$g['connect']['client_id'] = $id;
	$g['connect']['client_secret'] = $secret;
	$g['connect']['redirect_uri'] = urlencode($callBack);
	$g['connect']['state'] = $_SESSION['SL']['state'.$s];

	if ($s == 'naver') {
		$g['connect'] = 'https://nid.naver.com/oauth2.0/authorize?client_id='.$g['connect']['client_id'].'&response_type=code&redirect_uri='.$g['connect']['redirect_uri'].'&state='.$g['connect']['state'];
	}
	if ($s == 'kakao') {
		$g['connect'] = 'https://kauth.kakao.com/oauth/authorize?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'].'&response_type=code&scope=';
	}
	if ($s == 'google') {
		$g['connect'] = 'https://accounts.google.com/o/oauth2/auth?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'].'&response_type=code&scope=email%20profile&state=%2Fprofile&approval_prompt=auto';
	}
	if ($s == 'facebook') {
		$g['connect']= 'https://www.facebook.com/v3.0/dialog/oauth?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'].'&state='.$g['connect']['state'];
	}
	if ($s == 'instagram') {
		$g['connect']= 'https://api.instagram.com/oauth/authorize/?client_id='.$g['connect']['client_id'].'&redirect_uri='.$g['connect']['redirect_uri'].'&response_type=code';
	}
	return $g['connect'];
}

// 포스트의 모든 카테고리 출력
function getAllPostCat($m,$str) {
  global $table;
	$cats  = getArrayString($str);
	$CatName = '';
  foreach($cats['data'] as $val) {
    $C=getUidData($table[$m.'category'],$val);
		$code=$C['parent']?$C['parent'].'/'.$C['uid']:$C['uid'];
    $CatName.= '<a href="'.RW('m=post&cat='.$C['id'].'&code=').$code.'" class="muted-link">'.$C['name'].'</a>, ';
  }
  $result=substr($CatName,0,-2);
  return $result?$result:'';
}

// 포스트에 카테고리가 있는지 체크함수
function IsPostCat($post) {
  global $table;
  $m='post';
  $catque='data='.$post;
  $NUM=getDbRows($table[$m.'index'],$catque);
  return $NUM;
}

// 리스트의 첫번째 포스트의 대표이미지 src 추출
function getListImageSrc($list) {
  global $table,$s,$my;
  $m='post';
  $que='list='.$list.' and site='.$s;
  $LISTX=array();
  $LIST_ARR=getDbArray($table[$m.'list_index'],$que,'*','gid','asc',1,1);
  while ($LT=db_fetch_array($LIST_ARR)) $LISTX[]=$LT;
  $R=getUidData($table[$m.'data'],$LISTX[0]['data']);

	if($R['featured_img']){
	 $F=getUidData($table['s_upload'],trim($R['featured_img']));
	 $_IS_POSTMBR=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$R['uid'].' and auth=1');
	 $perm_post = $my['admin'] || $_IS_POSTMBR || !$R['hidden'] ? true : false;
	 $src=$perm_post?$F['src']:'/files/noimage.png';
	}else{
	 $img_arr=getImgs($R['content'],'jpg|jpge|gif|png');
	 $src=$img_arr[0]?$img_arr[0]:'/files/noimage.png';
	}
 return $src;
}

// 포스트의 조회권한 여부
function checkPostPerm($R) {
  global $table,$my;
  $m='post';
	switch ($R['display']) {
		case '1':
			if ($my['admin'] || ($R['mbruid']==$my['uid'])) $perm = true;
			else $perm = false;
			break;
		case '2':
			$_IS_POSTMBR=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$R['uid'].' and auth=1');
			if ($my['admin'] || $_IS_POSTMBR ) $perm = true;
			else $perm = false;
			break;
		case '3':
			$perm = true;
			break;
		case '4':
			if ($my['uid']) $perm = true;
			else $perm = false;
			break;
		case '5':
			$perm = true;
			break;
		default:
			$perm = false;
			break;
	}
 return $perm;
}

// 포스트의 수정권한 여부
function checkPostOwner($R) {
  global $table,$my;
  $m='post';
	switch ($R['display']) {
		case '1':
			if ($my['admin'] || ($R['mbruid']==$my['uid'])) $perm = true;
			else $perm = false;
			break;
		default:
			$_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$R['uid'].' and auth=1 and level=1');
			if ($my['admin'] || $_IS_POSTOWN ) $perm = true;
			else $perm = false;
		break;
	}
 return $perm;
}

// 리퍼러 변환
function checkReferer($ref) {

	switch ($ref) {
		case 'yt':  // yotube
 			$referer = 'https://youtube.com';
			break;
		case 'kt':  // kakaotalk
			$referer = 'https://www.kakaocorp.com/service/KakaoTalk';
			break;
		case 'ks': //kakaostory
			$referer = 'https://story.kakao.com';
			break;
		case 'bd':  //band
			$referer = 'https://band.us';
			break;
		case 'ig':  //instagram
			$referer = 'https://www.instagram.com';
			break;
		case 'fb':  //facebook
			$referer = 'https://www.facebook.com';
			break;
		case 'tt':  // twitter
			$referer = 'https://www.twitter.com';
			break;
		case 'nb':  // naver blog
			$referer = 'https://section.blog.naver.com/';
			break;
		default:
			$referer = '';
			break;
	}
 return $referer;
}

?>
