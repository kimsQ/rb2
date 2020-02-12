<?php
/* 채팅박스 초기화 */
if(!defined('__KIMS__')) exit;

require_once $g['dir_module'].'includes/base.class.php';
require_once $g['dir_module'].'includes/module.class.php';

$comment = new Comment();
$comment->parent = $_POST['parent']; // post 로 넘어온 값
$comment->parent_table = $_POST['parent_table']; // post 로 넘어온 값
$comment->theme_name = $_POST['theme_name']; // post 로 넘어온 값
$comment->sort = $_POST['sort'];
$comment->recnum = $_POST['recnum'];
$comment->orderby = $_POST['orderby'];

$totalPage = $comment->getTotalData($comment->parent,$comment->recnum,'comment','page',0);
$totalRow = $comment->getTotalData($comment->parent,$comment->recnum,'comment','row',0);

$TMPL['comment_total'] = $totalRow==0?'':$totalRow;
$TMPL['login_user_pic'] = $comment->getUserAvatar($my['uid'],'src');
$TMPL['login_user_nic'] = $my['nic'];
$TMPL['comment_parent'] = $comment->parent;

// comment_box.html 구성요소 세팅
$TMPL['img_module_skin'] = $comment->getThemePath('absolute').'/images/'; // 이미지 폴더 패스
$TMPL['theme_css_path'] = $comment->getThemePath('absolute').'/css/style.css'; // 테마 css
$TMPL['comment_rows_notice'] = $comment->getCommentLog($comment->parent,$sort,$orderby,$recnum,1,1); // 열람 권한 체크 및 고정 comment 출력
$TMPL['comment_rows'] = $comment->getCommentLog($comment->parent,$sort,$orderby,$recnum,1,0); // 열람 권한 체크 및 comment 출력
$TMPL['emoticon_list'] = $comment->getEmoticonList($comment->parent); // 이모티콘 리스트
$TMPL['comment_header'] = $comment->getHtml('comment_header'); // 헤더
$TMPL['comment_write'] = $comment->getHtml('comment_write'); // 쓰기

// 최종 리턴되는 댓글 box html & 세팅값
$result['comment_box'] = $comment->getHtml('comment_box');
$result['totalPage'] = $totalPage;
$result['totalRow'] = $totalRow;
$result['perm_write'] = $my['uid']?true:false; // 작성 권한
$result['userGroup'] = $my['mygroup']?$my['mygroup']:0;
$result['userLevel'] = $my['level']?$my['level']:0;

echo json_encode($result);
exit;
?>
