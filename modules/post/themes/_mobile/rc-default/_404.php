<header class="bar bar-nav bar-light bg-faded">
	<a class="title" data-href="<?php echo RW(0)?>" data-text="새로고침">
    <?php echo $d['layout']['header_file']?'<img src="'.$g['url_layout'].'/_var/'.$d['layout']['header_file'].'">':stripslashes($d['layout']['header_title'])?>
  </a>
</header>

<div class="content">
  <p class="text-xs-center text-muted py-5">잘못된 주소이거나 비공개 또는 삭제된 글입니다.</p>

  <div class="text-xs-center">
    <?php if (!$my['uid']): ?>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login">로그인 하기</button>
    <?php endif; ?>
    <button type="button" class="btn btn-light" onclick="history.back();">이전가기</button>
  </div>
</div>

<script type="text/javascript">
	document.title = 'Page not found · 킴스큐';
</script>
