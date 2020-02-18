<?php
if ($my['uid'] && $d['layout']['main_dashboard']=='true') getLink('/dashboard','','','');

if ($d['layout']['main_type']=='postAllFeed') {
  getWidget('post/rc-default/post/all/feed-card',array('wrapper'=>'[data-role="postFeed"].widget','start'=>'#page-main','recnum'=>5));
} else {
  $g['layoutPageVForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.main.php';   // 레이아웃 메인페이지 웨젯설정
  include is_file($g['layoutPageVForSite']) ? $g['layoutPageVForSite'] : $g['dir_layout'].'_var/_var.main.php';
  getWidgetList($d['layout']['main_widgets']);
}
?>

<?php if (!$d['layout']['main_widgets'] && $my['admin'] && $d['layout']['main_type']!='postAllFeed'): ?>
<div class="alert alert-danger text-xs-center border-0 rounded-0" role="alert">
  <a data-href="<?php echo $g['s'].'/?r='.$r.'&amp;layoutPage=settings&prelayout=rc-starter/blank' ?>" class="alert-link">
    <u>메인 꾸미기가 필요합니다.</u>
  </a>
</div>
<?php endif; ?>
