<!-- 게시물 추출 위젯에서 참조하는 파일 입니다. -->
<?php $d['bbs']['c_skin_modal'] = '_desktop/bs4-modal'; ?>

<link href="<?php echo $g['url_module_skin'] ?>/_main.css<?php echo $g['wcache']?>" rel="stylesheet">
<link href="<?php echo $g['url_root']?>/modules/comment/themes/<?php echo $d['bbs']['c_skin_modal'] ?>/css/style.css<?php echo $g['wcache']?>" rel="stylesheet">
<script src="<?php echo $g['url_module_skin'] ?>/js/getPostData.js<?php echo $g['wcache']?>" ></script>

<script>

  $(function () {

      var modal_settings={
        mid  : '#modal-bbs-view', // 모달아이디
        ctheme  : '<?php echo $d['bbs']['c_skin_modal'] ?>' //모달 댓글테마
      }
      getPostData(modal_settings); // 모달 출력관련

  })

</script>
