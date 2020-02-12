
<script>

  $(function () {

    getBbsView({
      type    : 'page', // 호출 컴포넌트 타입(modal,page)
      mid     : '#page-bbs-view', // 컴포넌트 아이디
      ctheme  : '<?php echo $d['bbs']['c_mskin']?$d['bbs']['c_mskin']:$d['comment']['skin_mobile']; ?>' //모달 댓글테마
    });

  })

</script>
