<section id="page-bbs-list" class="page center" data-role="bbs-list" data-snap-ignore="true">

  <header class="bar bar-nav bar-light bg-white p-x-0" data-role="bar-nav">
    <a href="#drawer-left" data-toggle="drawer" class="icon icon-bars pull-left p-x-1" role="button"></a>
    <a href="#popover-bbs-listMarkup" data-toggle="popover" data-bid="<?php echo $bid ?>" class="icon icon-more-vertical pull-right pl-2 pr-3"></a>
    <h1 class="title">
      <a data-location="reload" data-text="새로고침..">
        <?php echo $B['name']?$B['name']:($_HM['name']?$_HM['name']:$_HP['name'])?>
      </a>
    </h1>
  </header>


  <main class="content bg-white" data-role="bbs-list"></main>

</section>

<script>

  var bid = '<?php echo $bid?>';
  var local_listMarkup = localStorage.getItem('bbs-'+bid+'-listMarkup'); // 목록 마크업 (listMarkup)

  if (local_listMarkup) {
    var listMarkup = local_listMarkup;
  } else {
    var listMarkup = '<?php echo $d['theme']['listMarkup'] ?>';
    localStorage.setItem('bbs-'+bid+'-listMarkup', listMarkup);
  }

  $( document ).ready(function() {
    getBbsList(bid,'','','#page-bbs-list'); // 목록 셋팅
    getBbsView({
      type      : 'page', // 타입(modal,page)
      mid       : '#page-bbs-view', // 컴포넌트 아이디
      ctheme    : '<?php echo $d['bbs']['c_mskin']?$d['bbs']['c_mskin']:$d['comment']['skin_mobile']; ?>' //모달 댓글테마
    });
  });

</script>
