<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$result=array();
$result['error']=false;

include $g['path_tmp'].'app/'.$package_folder.'/_settings/var.php';

$site_list='';
$_SITES_ALL = getDbArray($table['s_site'],'','*','gid','asc',0,1);
while ($_R = db_fetch_array($_SITES_ALL)) {
  $site_list.='<option value="'.$_R['uid'].'">'.$_R['name'].'</option>';
}

$option='';
foreach ($d['package']['execute'] as $_key => $_val) {
  $option.= '<div class="custom-control custom-checkbox">';
  $option.= '<input type="checkbox" class="custom-control-input" id="ACT_'.$_val[0].'" name="ACT_'.$_val[0].'" value="1" '.($_val[2]?' checked':'').'>';
  $option.= '<label class="custom-control-label" for="ACT_'.$_val[0].'">'.$_val[1].'</label>';
  $option.= '</div>';
}

if (is_file($g['path_tmp'].'app/'.$package_folder.'/_settings/readme.txt')) {
  $readme = json_decode(file_get_contents($g['path_tmp'].'app/'.$package_folder.'/_settings/readme.txt'), true);
}

$result['name']=$d['package']['name'];
$result['site_list'] = $site_list;
$result['option'] = $option;
$result['readme'] = $readme;

echo json_encode($result);
exit;
?>
