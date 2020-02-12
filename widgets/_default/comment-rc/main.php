<div id="commentting-container">
 <!-- 댓글 출력  -->
</div>

<!-- theme css : 삭제금지, 불필요한 경우 해당 파일 내용을 비움. -->

<link href="<?php echo $g['url_root']?>/modules/comment/themes/<?php echo $wdgvar['theme']?>/css/style.css" rel="stylesheet">
<script src="<?php echo $g['url_root']?>/modules/comment/lib/Rb.comment.js"></script>

<script>

var get_Rb_Comment = function(p_module,p_table,p_uid,theme){
  $('#commentting-container').Rb_comment({
     moduleName : 'comment', // 댓글 모듈명 지정 (수정금지)
     parent : p_module+'-'+p_uid, // rb_s_comment parent 필드에 저장되는 형태가 p_modulep_uid 형태임 참조.(- 는 저장시 제거됨)
     parent_table : p_table, // 부모 uid 가 저장된 테이블 (게시판인 경우 rb_bbs_data : 댓글, 한줄의견 추가/삭제시 전체 합계 업데이트용)
     theme_name : theme, // 댓글 테마
     containerClass :'rb-commentting', // 본 엘리먼트(#commentting-container)에 추가되는 class
     recnum: 5, // 출력갯수
     commentPlaceHolder : '비방 및 욕설이 들어간 댓글은 별다른 고지 없이 삭제 될 수 있습니다.',
     noMoreCommentMsg : '댓글 없음 ',
     commentLength : 500, // 댓글 입력 글자 수 제한
  });

}

// 댓글 출력 함수 실행
var p_module = '<?php echo $wdgvar['module']?>';
var p_table = '<?php echo $wdgvar['parent_table']?>';
var p_uid = '<?php echo $wdgvar['parent_uid']?>';//9294053;
var theme = '<?php echo $wdgvar['theme']?>';

get_Rb_Comment(p_module,p_table,p_uid,theme);


</script>
