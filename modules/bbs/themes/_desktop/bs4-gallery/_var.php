<?php
// 공통
$d['theme']['profile_link'] = "1";  // 회원 프로필 링크 (사용=1/사용안함=0)

//목록
$d['theme']['xl_item'] = "4";  // ≥ 1200px 미디어에서 한줄당 사진수(1,2,3,4,6 범위내 사용, )
$d['theme']['lg_item'] = "3";  // ≥ 992px 미디어에서 한줄당 사진수(1,2,3,4,6 범위내 사용, )
$d['theme']['md_item'] = "3";  // ≥ 768px 미디어에서 한줄당 사진수(1,2,3,4,6 범위내 사용, )
$d['theme']['sm_item'] = "2";  // ≥ 576px 미디어에서 한줄당 사진수(1,2,3,4,6 범위내 사용, )
$d['theme']['xs_item'] = "1";  // < 576px 미디어에서한줄당 사진수(1,2,3,4,6 범위내 사용, )
$d['theme']['list_thumb'] = "n"; //섬네일사이즈(s=75x75/q=150x150/t=100x67/m=240x160/n=320x213/z=640x427/c=800x534, htaccess 참고)
$d['theme']['use_rss'] = "1"; //rss발행사용(사용=1/사용안함=0)
$d['theme']['show_catnum'] = "1"; //분류별등록수출력(출력=1/감춤=0)
$d['theme']['pagenum'] = "5"; //페이지스킵숫자갯수
$d['theme']['search'] = "1"; //검색폼출력(출력=1/감춤=0)
$d['theme']['timeago'] = "1"; //상대시간 표기(사용=1/일시표기=0)

//본문
$d['theme']['view_thumb'] = "s"; //섬네일사이즈(s=75x75/q=150x150/t=100x67/m=240x160/n=320x213/z=640x427, htaccess 참고)
$d['theme']['date_viewf'] = "Y.m.d H:i"; //날짜포맷
$d['theme']['show_report'] = "1"; //신고사용(사용=1/사용안함=0)
$d['theme']['show_print'] = "1"; //인쇄사용(사용=1/사용안함=0)
$d['theme']['show_saved'] = "1"; //링크저장사용(사용=1/사용안함=0)
$d['theme']['use_reply'] = "0"; //답변사용(사용=1/사용안함=0)
$d['theme']['show_tag'] = "1"; //태그출력(출력=1/감춤=0)
$d['theme']['show_upfile'] = "1"; //첨부파일출력(출력=1/감춤=0)
$d['theme']['show_like'] = "1"; //좋아요 출력(출력=1/감춤=0)-회원전용
$d['theme']['show_dislike'] = "0"; //싫어요 출력(출력=1/감춤=0)-회원전용
$d['theme']['show_share'] = "1"; //SNS공유출력(출력=1/감춤=0)
$d['theme']['show_comment'] = "0"; //댓글출력(사용=1/사용안함=0)
$d['theme']['comment_theme'] = "_desktop/bs4-default"; //댓글 테마 (/modules/comment/themes/ 참고)

//글쓰기
$d['theme']['editor'] = "ckeditor"; //에디터 (ckeditor/summernote/simplemde)
$d['theme']['edit_height'] = "200"; //글쓰기폼높이(픽셀)
$d['theme']['show_edittoolbar'] = "0"; //에디터 툴바출력(출력=1/감춤=0)
$d['theme']['show_upload'] = "1"; //파일 업로드 출력 여부 (출력=1/감춤=0)
$d['theme']['upload_theme'] = "_desktop/bs4-gallery"; //파일 업로드 테마 (/modules/mediaset/themes/ 참고)
$d['theme']['upload_qty'] = "2"; //파일 업로드 출력 갯수
$d['theme']['perm_upload'] = "1"; //파일첨부권한(등급이상)
$d['theme']['show_wtag'] = "1"; //태그필드출력(출력=1/감춤=0)
$d['theme']['use_hidden'] = "1"; //비밀글(사용안함=0/유저선택사용=1/무조건비밀글=2)
?>
