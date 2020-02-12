<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 201 ? $recnum : 20;
$listque	= 'uid';

$RCD = getDbArray($table['s_gitlog'],$listque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_gitlog'],$listque);
$TPG = getTotalPage($NUM,$recnum);

$result=array();
$result['error'] = false;

$html = '';
while ($R=db_fetch_array($RCD)) {

  $version_array = explode('->', $R['version']);
  $version = $version_array[1];

  $html .= '<li class="table-view-cell">
              <a class="navigate-right" data-toggle="page"
                data-target="#page-software-logview"
                data-title="'.$version.'"
                data-uid="'.$R['uid'].'"
                data-start="#page-software-loglist">
                <span class="badge badge-default badge-inverted">'.getDateFormat($R['d_regis'],'Y.m.d H:i').'</span>
                <code>'.$version.'</code>
              </a>
            </li>';
}

$result['list'] = $html;

echo json_encode($result);
exit;
?>
