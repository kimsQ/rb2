<?php
$_WTIT=strip_tags($g['meta_tit']);
$link_url = explode("?", $g['url_root'].$_SERVER['REQUEST_URI']);  // 파라미터 제외
$_link_url = $link_url[0] ;
?>

<ul class="list-inline" data-role="linkshare">
  <li data-toggle="tooltip" title="페이스북" class="list-inline-item">
    <a href="" role="button" onclick="snsWin('fb');">
      <img src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북공유" class="rounded-circle" width="50">
    </a>
  </li>
  <li data-toggle="tooltip" title="카카오스토리" class="list-inline-item">
    <a href="" role="button"  onclick="snsWin('ks');">
      <img src="<?php echo $g['img_core']?>/sns/kakaostory.png" alt="카카오스토리" class="rounded-circle" width="50">
    </a>
  </li>
  <li data-toggle="tooltip" title="네이버" class="list-inline-item">
    <a href="" role="button" onclick="snsWin('nv');">
      <img src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버" class="rounded-circle" width="50">
    </a>
  </li>
  <li data-toggle="tooltip" title="트위터" class="list-inline-item">
    <a href="" role="button" onclick="snsWin('tt');">
      <img src="<?php echo $g['img_core']?>/sns/twitter.png" alt="트위터" class="rounded-circle" width="50">
    </a>
  </li>
</ul>

<div class="mt-5 mb-4">
  <div class="input-group mt-3" data-role="ref_selector">
    <div class="input-group-prepend">
      <button class="btn btn-white dropdown-toggle text-primary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        선택
      </button>
      <div class="dropdown-menu shadow" data-url="<?php echo $_link_url?>">
        <a class="dropdown-item" href="#" data-ref="kt">카카오톡</a>
        <a class="dropdown-item" href="#" data-ref="yt">유튜브</a>
        <a class="dropdown-item" href="#" data-ref="fb">페이스북</a>
        <a class="dropdown-item" href="#" data-ref="ig">인스타그램</a>
        <a class="dropdown-item" href="#" data-ref="nb">네이버 블로그</a>
        <a class="dropdown-item" href="#" data-ref="ks">카카오스토리</a>
        <a class="dropdown-item" href="#" data-ref="tt">트위터</a>
        <div role="separator" class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-ref="em">이메일</a>
        <a class="dropdown-item" href="#" data-ref="sm">SMS</a>
        <a class="dropdown-item" href="#" data-ref="et">기타</a>
      </div>
    </div>
    <input type="text" class="form-control" readonly value="<?php echo $_link_url?>" id="_url_">
    <div class="input-group-append">
      <button class="btn btn-white js-clipboard js-tooltip" type="button" title="클립보드에 복사" data-clipboard-target="#_url_">
        <i class="fa fa-clone" aria-hidden="true"></i>
      </button>
    </div>
  </div>
  <span class="form-text text-muted mt-3 f13">통계분석을 위해 매체별 전용URL 사용해주세요.</span>
</div>

<?php getImport('clipboard','clipboard.min','2.0.4','js'); ?>

<script type="text/javascript">

// sns 이벤트
function snsWin(sns) {
    var snsset = new Array();
    var enc_sbj = "<?php echo urlencode($_WTIT)?>";
    var enc_url = "<?php echo $_link_url?>?ref="+sns;
    var enc_tag = "<?php echo urlencode(str_replace(',',' ',$R['tag']))?>";
    snsset['tt'] = 'https://twitter.com/intent/tweet?url=' + enc_url + '&text=' + enc_sbj;
    snsset['fb'] = 'http://www.facebook.com/sharer.php?u=' + enc_url;
    snsset['nv'] = 'http://share.naver.com/web/shareView.nhn?url=' + enc_url + '&title=' + enc_sbj;
    snsset['ks'] = 'https://story.kakao.com/share?url=' + enc_url + '&title=' + enc_sbj;
    window.open(snsset[sns]);
}

$( document ).ready(function() {

  var clipboard = new ClipboardJS('.js-clipboard');
  clipboard.on('success', function (e) {
    $(e.trigger)
      .attr('title', '복사완료!')
      .tooltip('_fixTitle')
      .tooltip('show')
      .attr('title', '클립보드 복사')
      .tooltip('_fixTitle')

    e.clearSelection()
  })

  $('[data-role="ref_selector"]').find('.dropdown-item').click(function(){
    var item = $(this)
    var selector = $('[data-role="ref_selector"]')
    var ref = item.attr('data-ref');
    var url = selector.find('.dropdown-menu').attr('data-url');
    var label = item.text();
    selector.find('[data-toggle="dropdown"]').text(label)
    selector.find('[type="text"]').val(url+'?ref='+ref)
    selector.find('.js-tooltip').click();
  });

});

</script>
