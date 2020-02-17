<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';

$sort=$_GET['sort']?$_GET['sort']:'uid';
$orderby=$_GET['orderby']?$_GET['orderby']:'desc';
$recnum=$_GET['recnum']?$_GET['recnum']:15;// 추출갯수
$page=$_GET['page']?$_GET['page']:1;
$callMod=$_GET['callMod']; //안읽은 상태
$sqlque = 'mbruid='.$my['uid'];
if ($callMod=='unread') $sqlque .= ' and d_read=""';

$RCD = getDbArray($table['s_notice'],$sqlque,'*',$sort,$orderby,$recnum,$page);
$NUM = getDbRows($table['s_notice'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php'; // 사이트 회원모듈 변수파일
$_varfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].'member/var/var.php';
include_once $_varfile; // 변수파일 인클루드

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['member']['theme_mobile'];
} else {
  $theme = $d['member']['theme_main'];
}

$result=array();
$result['error'] = false;

$html='';
$m = 'member';
$markup_file = 'noti_list'; // 기본 마크업 페이지 전달 (테마 내부 _html/noti_list.html)

$skin=new skin($markup_file);

while($R = db_fetch_array($RCD)){
  $SM1=$R['mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'name,nic'):array();
  $SM2=$R['frommbr']?getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'memberuid,name,nic'):array();
  $MD = getDbData($table['s_module'],"id='".$R['frommodule']."'",'icon');
  $avatar =$R['frommbr']?getAvatarSrc($SM2['memberuid'],'120'):'/_core/images/touch/homescreen-192x192.png';

  $TMPL['from'] = $SM2[$_HS['nametype']];
  $TMPL['icon'] = $MD['icon'];
  $TMPL['avatar'] = $avatar;
  $TMPL['uid'] = $R["uid"];
  $TMPL['title'] = $R['title'];
  $TMPL['message'] = getStrCut($R['message'],150,'');
  $TMPL['datetime'] = getDateFormat($R['d_regis'],'c');
  $TMPL['referer'] = $R['referer'];
  $TMPL['check_read'] = $R['d_read']?'bg-light bg-faded':'';
  $TMPL['check_new'] = getNew($R['d_regis'],24)?'':' d-none';

  $html.=$skin->make();
}

if(!$NUM) {
  // 모바일/데스크탑 분기
  if ($g['mobile'] && $_SESSION['pcmode'] != 'Y') {
    $html.='<li class="p-5 text-xs-center text-muted d-flex align-items-center justify-content-center bg-faded" style="height: calc(100vh - 10.5rem);">새 알림이 없습니다.</li>';
  } else {
    $html.='<span class="list-group-item text-center p-5 small text-muted">새 알림이 없습니다.</span>';
  }
}

$result['num'] = !$NUM?'':$NUM;
$result['tpg'] = $TPG;
$result['content'] = $html;
echo json_encode($result);

exit;
?>
