<?php

// 댓글 일반 사항
/*
   1) 댓글 저장 테이블 : rb_s_comment
   2) 한줄의견 저장 테이블 : rb_s_oneline
   3) rb_s_comment 의 parent 필드 저장형식 ==> p_modulep_uid
      예를 들어, 게시판 모듈의 uid = 3 인 글의 댓글은 아래와 같이 저장됩니다.
      ====> bbs3
    4) 테마 css 는 테마/css/style.css 이며 댓글박스 가져올때 자동으로 함께 링크를 가져옵니다.
       이 css 를 삭제하면 안되며 필요없는 경우 공백으로 처리하는 방법으로 하시기 바랍니다.
       현재, notify 부분에 대한 css 가 있어서 삭제하면 안됩니다.
*/

// 댓글 출력 함수
// 함수 호출 방식으로 하면 모달 호출시에도 적용하기 편합니다.
/*
   1) module = 부모모듈 : 댓글의 부모 모듈 id ( ex: bbs, post, forum ...)
   2) parent_uid = 부모 uid : 댓글의 부모 포스트 uid
   3) parent_table = 부모 테이블 : p_uid 가 소속된 테이블명 ( ex : rb_bbs_data, rb_blog_data, rb_chanel_data ...)
             (댓글, 한줄의견 추가/삭제시 합계 업데이트시 필요)
*/

 $comment_theme =  '_desktop/bs4-default';  // 댓글 테마
?>


<div id="commentting-container">
 <!-- 댓글 출력  -->
</div>

<link href="<?php echo $g['url_root']?>/modules/comment/themes/<?php echo $comment_theme?>/css/style.css" rel="stylesheet">



<script>

var attach_file_saveDir = '<?php echo $g['path_file']?>comment/';// 파일 업로드 폴더
var attach_module_theme = '_desktop/bs4-default-attach';// attach 모듈 테마

$(function() {

  // 댓글 출력 함수 실행
  var p_module = '<?php echo $m?>';
  var p_table = '<?php echo $table[$m.'data']?>';
  var p_uid = '<?php echo $R['uid']?>';
  var theme = '<?php echo $comment_theme ?>';
  var agent = navigator.userAgent.toLowerCase();

  var commentting_container = $('#commentting-container');

  var get_Rb_Comment = function(p_module,p_table,p_uid,theme){
    commentting_container.Rb_comment({
       moduleName : 'comment', // 댓글 모듈명 지정 (수정금지)
       parent : p_module+'-'+p_uid, // rb_s_comment parent 필드에 저장되는 형태가 p_modulep_uid 형태임 참조.(- 는 저장시 제거됨)
       parent_table : p_table, // 부모 uid 가 저장된 테이블 (게시판인 경우 rb_bbs_data : 댓글, 한줄의견 추가/삭제시 전체 합계 업데이트용)
       theme_name : theme, // 댓글 테마
       containerClass :'rb-commentting', // 본 엘리먼트(#commentting-container)에 추가되는 class
       recnum: 15, // 출력갯수
       commentPlaceHolder : '댓글을 입력해 주세요..',
       noMoreCommentMsg : '댓글 없음 ',
       commentLength : 500, // 댓글 입력 글자 수 제한
       toolbar : ['heading','strikethrough','imageUpload','link','bulletedList', 'numberedList', 'blockQuote','|','alignment:left','alignment:center','|','Highlight','Code','insertTable'] // 툴바 항목
    });
  }

  get_Rb_Comment(p_module,p_table,p_uid,theme);

  $('[data-toggle="tooltip"]').tooltip()

  // 댓글이 등록된 후에
  $('#commentting-container').on('saved.rb.comment',function(){
    // $.notify({message:'댓글이 등록 되었습니다.'});
    $('[data-toggle="tooltip"]').tooltip()

    $(document).on('click','.add-comment',function(){
     var uid = $(this).data('parent')
     var textarea = $('[data-role="oneline-input-'+uid+'"]')
     setTimeout(function(){ textarea.focus(); }, 200); // 한줄의견 추가시에 textarea focus 처리하기
    });

  })
  // 댓글이 수정된 후에
  $('#commentting-container').on('edited.rb.comment',function(){
    $.notify({message: '댓글이 수정 되었습니다.'},{type: 'success'});
  })

  // 한줄의견이 등록된 후에
  $('#commentting-container').on('saved.rb.oneline',function(){
    $('[data-toggle="tooltip"]').tooltip()
  })
  $('#commentting-container').on('edited.rb.oneline',function(){
    $.notify({message: '의견이 수정 되었습니다.'},{type: 'success'});
  })

});

</script>
