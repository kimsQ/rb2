<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';

include_once $g['path_module'].'bbs/var/var.php';
include_once $g['path_var'].'bbs/var.'.$bid.'.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}
include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$result=array();
$result['error']=false;
$result['isperm'] = true;

//게시물 쓰기 권한체크
if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
	if ($d['bbs']['perm_l_write'] > $my['level'] || strpos('_'.$d['bbs']['perm_g_write'],'['.$my['mygroup'].']')) {
    $markup_file = 'permcheck'; //잠김페이지 전달 (테마 내부 _html/permcheck.html)
    $result['isperm'] = false;
    $skin=new skin($markup_file);
    $result['main']=$skin->make();
	}
  if ($R['uid'] && $reply != 'Y') {
    if ($my['uid'] != $R['mbruid']) {
       if (!strpos('_'.$_SESSION['module_'.$m.'_pwcheck'],'['.$R['uid'].']')) {
         $markup_file = 'pwcheck'; //인증페이지 전달 (테마 내부 _html/pwcheck.html)
         $result['isperm'] = false;
         $skin=new skin($markup_file);
         $result['main']=$skin->make();
       }
    }
  }
}

if ($result['isperm']==true) {
  $_SESSION['wcode'] = $date['totime'];
  $result['pcode']=$date['totime'];
}

echo json_encode($result);
exit;
?>
