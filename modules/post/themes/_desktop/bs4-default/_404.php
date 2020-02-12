<div class="jumbotron jumbotron-fluid bg-white py-5 mb-0">
  <div class="container">
    <h1 class="display-2 text-center">404</h1>
    <p class="lead text-center text-muted">잘못된 주소이거나 비공개 또는 삭제된 글입니다.</p>

    <div class="text-center">
      <?php if (!$my['uid']): ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login">로그인 하기</button>
      <?php endif; ?>
      <button type="button" class="btn btn-light" onclick="history.back();">이전가기</button>
    </div>

  </div>
</div>

<script type="text/javascript">
	document.title = 'Page not found · 킴스큐';
</script>
