<?php
if(!defined('__KIMS__')) exit;

$data = array();
$posts=getDbArray($table[$m.'data'],"mbruid=".$my['uid']." and subject like '%".$q."%'",'subject,cid','hit','desc','',1);
$postData = '';
while($R=db_fetch_array($posts)){
  $link = '/post/write/'.$R['cid'];
  $subject = str_replace(',', '', $R['subject']);
  $postData .= $subject.'|'.$link.',';
}
$data['postlist'] = $postData;

echo json_encode($data);
exit;
?>
