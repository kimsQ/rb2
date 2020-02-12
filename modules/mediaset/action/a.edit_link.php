<?php
if(!defined('__KIMS__')) exit;
$result=array();
$result['error']=false;

if($act=='delete')  getDbDelete($table['s_link'],'uid='.$uid);
else if($act=='showhide'){
     if($showhide=='show') getDbUpdate($table['s_link'],'hidden=0','uid='.$uid);
       else getDbUpdate($table['s_link'],'hidden=1','uid='.$uid);
}

$result['msg']='ok';

echo json_encode($result,true); 
exit;
?>
