<?php

// seo 데이타 -- 전송되는 타이틀 추출

$_MSEO = getDbData($table['s_seo'],'rel=1 and parent='.$_HM['uid'],'*');
$_PSEO = getDbData($table['s_seo'],'rel=2 and parent='.$_HP['uid'],'*');
$_WTIT=strip_tags($g['meta_tit']);

//$_link_domain = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://';
//$_link_url = $_link_domain.$_SERVER['REQUEST_URI']; // URL
$_link_url=$g['url_root'].$_SERVER['REQUEST_URI'];

?>

<ul class="list-inline mb-3">
  <li data-toggle="tooltip" title="페이스북" class="list-inline-item">
    <a href="" role="button">
      <img src="<?php echo $g['img_core']?>/sns/facebook.png" alt="페이스북공유" class="rounded-circle" width="48">
    </a>
  </li>
  <li data-toggle="tooltip" title="카카오스토리" class="list-inline-item">
    <a  href="" role="button">
      <img src="<?php echo $g['img_core']?>/sns/kakaostory.png" alt="카카오스토리" class="rounded-circle" width="48">
    </a>
  </li>
  <li data-toggle="tooltip" title="네이버" class="list-inline-item">
    <a  href="" role="button">
      <img src="<?php echo $g['img_core']?>/sns/naver.png" alt="네이버" class="rounded-circle" width="48">
    </a>
  </li>
  <li data-toggle="tooltip" title="트위터" class="list-inline-item">
    <a href="" role="button">
      <img src="<?php echo $g['img_core']?>/sns/twitter.png" alt="트위터" class="rounded-circle" width="48">
    </a>
  </li>
  <li data-toggle="tooltip" title="메일보내기" class="list-inline-item">
    <a href="mailto:<?php if($my['uid']):?><?php echo $my['email']?><?php endif?>?subject=경기방송%20기사공유-<?php echo $_WTIT?>&body=<?php echo $_link_url?>">
      <img src="<?php echo $g['img_core']?>/sns/mail.png" alt="메일" class="rounded-circle" width="48">
    </a>
  </li>
</ul>

<script type="text/javascript">
// sns 이벤트
function snsWin(sns)
{
    var snsset = new Array();
    var enc_tit = "<?php echo urlencode($_HS['title'])?>";
    var enc_sbj = "<?php echo urlencode($_WTIT)?>";
    var enc_url = "<?php echo urlencode($_link_url)?>";
    var enc_tag = "<?php echo urlencode(str_replace(',',' ',$R['tag']))?>";
    snsset['t'] = 'https://twitter.com/intent/tweet?url=' + enc_url + '&text=' + enc_sbj;
    snsset['f'] = 'http://www.facebook.com/sharer.php?u=' + enc_url;
    snsset['n'] = 'http://share.naver.com/web/shareView.nhn?url=' + enc_url + '&title=' + enc_sbj;
    snsset['ks'] = 'https://story.kakao.com/share?url=' + enc_url + '&title=' + enc_sbj;
    window.open(snsset[sns]);
}
</script>
