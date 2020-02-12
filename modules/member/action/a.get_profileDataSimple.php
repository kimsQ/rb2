<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error']=false;

$mbruid = $_POST['mbruid'];

$_MH = getUidData($table['s_mbrid'],$mbruid);
$_MD = getDbData($table['s_mbrdata'],"memberuid='".$mbruid."'",'*');
$_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$mbruid);

$result['id'] = $_MH['id'];
$result['nic'] = $_MD['nic'];
$result['cover'] = getCoverSrc($mbruid,'800','500');
$result['avatar'] = getAvatarSrc($mbruid,'250');
$result['bio'] = $_MD['bio'];
$result['grade'] = $g['grade']['m'.$_MD['level']];
$result['point'] = number_format($_MD['point']);
$result['num_follower'] = number_format($_MD['num_follower']);
$result['num_post'] = number_format($_MD['num_post']);
$result['num_list'] = number_format($_MD['num_list']);
$result['num_goods'] = number_format($_MD['num_goods']);
$result['isFollowing'] = $_isFollowing;

echo json_encode($result);
exit;
?>
