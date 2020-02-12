<meta charset="utf-8">

<!-- Seo -->
<meta name="robots" content="<?php echo strip_tags($g['meta_bot'])?>">
<meta name="title" content="<?php echo strip_tags($g['meta_tit'])?>">
<meta name="keywords" content="<?php echo strip_tags($g['meta_key'])?>">
<meta name="description" content="<?php echo strip_tags($g['meta_des'])?>">
<meta name="author" content="<?php echo $_HS['name'] ?>">

<link rel="image_src" href="<?php echo strip_tags($g['meta_img'])?>">
<link rel="canonical" href="<?php echo strip_tags($g['url_root'].$_SERVER['REQUEST_URI'])?>">

<meta property="og:site_name" content="<?php echo $_HS['name'] ?>">
<meta property="og:locale" content="ko_KR">
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo strip_tags($g['url_root'].$_SERVER['REQUEST_URI'])?>">
<meta property="og:title" content="<?php echo strip_tags($g['meta_tit'])?>">
<meta property="og:description" content="<?php echo strip_tags($g['meta_des'])?>">
<meta property="og:image" content="<?php echo strip_tags($g['meta_img'])?>">

<title><?php echo $g['browtitle']?></title>

<!-- 파비콘 -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $g['img_layout']?>/icon/homescreen.png">
<link rel="shortcut icon" href="<?php echo $g['img_layout']?>/icon/favicon.ico">

<!-- 웹앱 매니페스트 -->
<link rel="manifest" href="<?php echo $manifestForSite?>">

<!-- 사이트 헤드 코드 -->
<?php echo $_HS['headercode']?>

<!-- bootstrap css -->
<?php getImport('bootstrap','css/bootstrap.min','4.4.1','css')?>

<!-- jQuery -->
<?php getImport('jquery','jquery.min','3.3.1','js')?>

<?php getImport('popper.js','umd/popper.min','1.14.0','js')?>

<!-- bootstrap js -->
<?php getImport('bootstrap','js/bootstrap.min','4.4.1','js')?>

<!-- 시스템 폰트 -->
<?php getImport('font-awesome','css/font-awesome','4.7.0','css')?>
<?php getImport('font-kimsq','css/font-kimsq',false,'css')?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- anchorjs : https://github.com/bryanbraun/anchorjs -->
<?php getImport('anchorjs','anchor.min','4.2.0','js')?>

<!-- smooth-scroll: https://github.com/cferdinandi/smooth-scroll -->
<?php getImport('smooth-scroll','smooth-scroll.polyfills.min','16.1.0','js') ?>

<!-- 엔진코드:삭제하지마세요 -->
<?php include $g['path_core'].'engine/cssjs.engine.php' ?>

<!-- 레이아웃 스타일 -->
<link href="<?php echo $g['url_layout']?>/_css/style.css<?php echo $g['wcache']?>" rel="stylesheet">

<!-- 레이아웃 본문 컨텐츠 스타일(선택) -->
<link href="<?php echo $g['url_layout']?>/_css/article.css" rel="stylesheet">

<!-- timeago : 상대시간 표기 -->
<?php getImport('jquery-timeago','jquery.timeago','1.6.7','js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.ko','1.6.7','js')?>
