<?php
if ($my['uid'] && $d['layout']['main_dashboard']=='true') getLink('/dashboard','','','');

if ($d['layout']['main_type']=='postFeed') {
  getWidget('post/rc-post-all-scroll',array('wrapper'=>'[data-role="postFeed"].widget','start'=>'#page-main','recnum'=>5));
} else {

  $g['layoutPageVForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.main.php';   // 레이아웃 메인페이지 웨젯설정
  include is_file($g['layoutPageVForSite']) ? $g['layoutPageVForSite'] : $g['dir_layout'].'_var/_var.main.php';
  getWidgetList($d['layout']['main_widgets']);

}
?>
