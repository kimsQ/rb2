<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';

$sort = $_GET['sort']; // 정렬 기준
$orderby = $_GET['orderby']; // 정렬순서
$recnum = $_GET['recnum']; // 출력갯수
$page = $_GET['page']; // 처음엔 무조건 1
$where = 'mbruid='.$my['uid']; // 출력 조건

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php'; // 사이트 회원모듈 변수파일
$_varfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$m.'/var/var.php';
include_once $_varfile; // 변수파일 인클루드

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['member']['theme_mobile'];
} else {
  $theme = $d['member']['theme_main'];
}

$result=array();
$result['error'] = false;

$RCD = getDbArray($table['s_notice'],$where,'*',$sort,$orderby,$recnum,$page);
$html='';
$m = 'member';
$markup_file = 'noti_list'; // 기본 마크업 페이지 전달 (테마 내부 _html/noti_list.html)

$skin=new skin($markup_file);

while($R = db_fetch_array($RCD)){
 $SM1=$R['mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'name,nic'):'';
 $SM2=$R['frommbr']?getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'memberuid,name,nic'):'';
 $MD = getDbData($table['s_module'],"id='".$R['frommodule']."'",'icon');
 $avatar =$R['frommbr']?getAvatarSrc($SM2['memberuid'],'120'):'/_core/images/touch/homescreen-192x192.png';

 $TMPL['from'] = $SM2[$_HS['nametype']];
 $TMPL['icon'] = $MD['icon'];
 $TMPL['avatar'] = $avatar;
 $TMPL['uid'] = $R["uid"];
 $TMPL['title'] = $R['title'];
 $TMPL['message'] = getStrCut($R['message'],150,'');
 $TMPL['datetime'] = getDateFormat($R['d_regis'],'c');

 $TMPL['check_read'] = $R['d_read']?'':'table-view-active';
 $TMPL['check_new'] = getNew($R['d_regis'],24)?'':' d-none';

 $html.=$skin->make();
}

$result['content'] = $html;

echo json_encode($result);
exit;
?>
