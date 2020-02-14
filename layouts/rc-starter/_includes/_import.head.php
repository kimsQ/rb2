<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#333">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- Seo -->
<meta name="robots" content="<?php echo strip_tags($g['meta_bot'])?>">
<meta name="title" content="<?php echo strip_tags($g['meta_tit'])?>">
<meta name="keywords" content="<?php echo strip_tags($g['meta_key'])?>">
<meta name="description" content="<?php echo strip_tags($g['meta_des'])?>">
<link rel="image_src" href="<?php echo strip_tags($g['meta_img'])?>">

<meta property="og:site_name" content="<?php echo $_HS['name'] ?>">
<meta property="og:locale" content="ko_KR">
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo strip_tags($g['url_root'].$_SERVER['REQUEST_URI'])?>">
<meta property="og:title" content="<?php echo strip_tags($g['meta_tit'])?>">
<meta property="og:description" content="<?php echo strip_tags($g['meta_des'])?>">
<meta property="og:image" content="<?php echo strip_tags($g['meta_img'])?>">

<!-- 파비콘 -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $g['img_layout']?>/icon/homescreen.png">
<link rel="shortcut icon" href="<?php echo $g['img_layout']?>/icon/favicon.ico">

<title><?php echo $g['browtitle']?></title>

<!-- 웹앱 매니페스트 -->
<link rel="manifest" href="<?php echo $manifestForSite?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $touchIconForSite ?>">

<!-- 사이트 헤드 코드 -->
<?php echo $_HS['headercode']?>

<!-- rc css -->
<?php getImport('rc','css/rc','1.0.0','css')?>
<?php getImport('rc','css/rc-add','1.0.0','css')?>

<!-- jQuery -->
<?php getImport('jquery','jquery.min','1.12.4','js')?>

<!-- rc js -->
<?php getImport('rc','js/rc','1.0.0','js')?>

<!-- 시스템 폰트 -->
<?php getImport('font-awesome','css/font-awesome','4.7.0','css')?>
<?php getImport('font-kimsq','css/font-kimsq',false,'css')?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- swiper : http://idangero.us/swiper/ -->
<?php getImport('swiper','css/swiper','5.2.1','css')?>
<?php getImport('swiper','js/swiper.min','5.2.1','js')?>

<!-- timeago : 상대시간 표기 -->
<?php getImport('jquery-timeago','jquery.timeago','1.6.7','js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko','1.6.7','js')?>

<!-- markjs js : https://github.com/julmot/mark.js -->
<?php getImport('markjs','jquery.mark.min','8.11.1','js')?>

<!-- 소셜공유시 URL 클립보드저장 : clipboard.js  : https://github.com/zenorocha/clipboard.js-->
<?php getImport('clipboard','clipboard.min','2.0.4','js') ?>

<!-- color-thief : https://github.com/lokesh/color-thief  -->
<?php getImport('color-thief','color-thief.min','2.3.0','js') ?>

<!-- jQuery UI : https://jqueryui.com/-->
<?php getImport('jquery-ui','jquery-ui.sortable,min','1.12.1','js')?>

<!-- jquery-ui-touch-punch : https://github.com/furf/jquery-ui-touch-punch/ -->
<?php getImport('jquery-ui-touch-punch','jquery.ui.touch-punch.min','0.2.3','js')?>

<!-- 사이트 헤드 코드 -->
<?php echo $_HS['headercode']?>

<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/cssjs.engine.php' ?>

<!-- global css -->
<link href="<?php echo $g['url_layout']?>/_css/style.css<?php echo $g['wcache']?>" rel="stylesheet">
<link href="<?php echo $g['url_layout']?>/_css/article.css<?php echo $g['wcache']?>" rel="stylesheet">

<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script>
var kakao_jskey = '<?php echo $d['connect']['jskey_k'] ?>';
Kakao.init(kakao_jskey);
</script>
