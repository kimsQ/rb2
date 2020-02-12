<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
include_once $g['dir_module'].'var/var.php';

$result=array();
$result['error']=false;

$R = getUidData($table[$m.'data'],$uid);

include_once $g['path_module'].'post/var/var.php';

$result['uid'] = $R['uid'];

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['m_skin']?$d['post']['m_skin']:$d['post']['skin_mobile'];
  $device = 'mobile';
} else {
  $theme = $d['post']['skin']?$d['post']['skin']:$d['post']['skin_main'];
  $device = 'desktop';
}

$sort = 'uid';
$orderby = 'desc';
$recnum = 20;
$where = 'module="'.$m.'" and opinion="'.$opinion.'" and entry='.$uid; // 출력 조건
$where1 = 'module="'.$m.'" and opinion="like" and entry='.$uid; // 좋아요 출력 조건
$where2 = 'module="'.$m.'" and opinion="dislike" and entry='.$uid; // 싫어요 출력 조건
$RCD = getDbArray($table['s_opinion'],$where,'*',$sort,$orderby,$recnum,1);
$NUM = getDbRows($table['s_opinion'],$where);
$NUM1 = getDbRows($table['s_opinion'],$where1);  //좋아요 수량
$NUM2 = getDbRows($table['s_opinion'],$where2);  //싫어요 수량

$html='';
foreach ($RCD as $R) {
  $M	= getUidData($table['s_mbrid'],$R['mbruid']);
  $M1 = getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'*');
  $myself = $R['mbruid']==$my['uid']?' (나)':'';
  $TMPL['nic']=$M1['nic'].$myself;
  $TMPL['id']=$M['id'];
  $TMPL['mbruid']=$R['mbruid'];
  $TMPL['avatar']=getAvatarSrc($R['mbruid'],'84');
  $TMPL['num_follower']=$M1['num_follower'];
  $TMPL['num_post']=$M1['num_post'];
  $TMPL['profile_link']=getProfileLink($R['mbruid']);
  $TMPL['d_regis']=getDateFormat($R['d_regis'],'Y-m-d H:i');
  $skin_item=new skin($markup_file);
  $html.=$skin_item->make();
}

$result['num']=$NUM;
$result['num_like']=$NUM1;
$result['num_dislike']=$NUM2;
$result['list']=$html;
echo json_encode($result);
exit;
?>
