<?php
if(!defined('__KIMS__')) exit;

$data = array();

$Mbrs=getDbArray($table['s_mbrdata'],"nic like '%".$nic."%'",'memberuid,nic,name,email,photo','point','desc','',1);
$mbrData = '';
while($R=db_fetch_array($Mbrs)){
    if (!$R['photo']) $R['photo'] = '0.gif';
    $mbrData .= $R['nic'].'|'.$R['photo'].',';
}
$data['mbrlist'] = $mbrData;

echo json_encode($data);
exit;
?>
