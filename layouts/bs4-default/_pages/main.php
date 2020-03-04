<?php
if ($my['uid'] && $d['layout']['main_dashboard']=='true') getLink('/dashboard','','','');

$g['layoutPageVForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.main.php';   // 레이아웃 메인페이지 웨젯설정
include is_file($g['layoutPageVForSite']) ? $g['layoutPageVForSite'] : $g['dir_layout'].'_var/_var.main.php';
getWidgetList($d['layout']['main_widgets']);
?>

<?php if (!$d['layout']['main_widgets'] && $my['admin']): ?>
<div class="alert alert-danger text-center border-0 rounded-0" role="alert">
  메인 꾸미기가 필요합니다.
</div>
<?php endif; ?>
