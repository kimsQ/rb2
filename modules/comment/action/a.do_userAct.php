<?php
if(!defined('__KIMS__')) exit;
require_once $g['dir_module'].'includes/base.class.php';
require_once $g['dir_module'].'includes/module.class.php';
$comment = new Comment();
$comment->parent = $_REQUEST['parent']; // post 로 넘어온 값
$comment->parent_table = $_REQUEST['parent_table']; // post 로 넘어온 값
$comment->theme_name = $_REQUEST['theme_name']; // post 로 넘어온 값
$comment->sort = $_REQUEST['sort'];
$comment->recnum = $_REQUEST['recnum'];
$comment->orderby = $_REQUEST['orderby'];

// post 로 넘어오는 값
$entry = $_REQUEST['entry']; // 해당 글 uid
$type = $_REQUEST['type'];// comment or oneline
$uid = $_REQUEST['uid']; // comment, oneline...PK
$parent = $_REQUEST['parent'];

// 리턴값 세팅
$result = array();
$result['error'] = false;

if($act=='like'){

    // 테이블 세팅
    if($type=='comment') $update_table = $comment->commentTable;
    else if($type=='oneline') $update_table = $comment->onelineTable;
    $opinion_table = $comment->opinionTable;

    $mbruid = $my['uid'];

    $check_qry = "mbruid='".$mbruid."' and module='".$type."' and entry='".$entry."' and opinion='like'";
    // 로그인한 사용자가 좋아요를 했는지 여부 체크
    $is_liked = getDbRows($opinion_table,$check_qry);

    if($is_liked){ // 좋아요를 했던 경우
        getDbDelete($opinion_table,$check_qry);
        getDbUpdate($update_table,'likes=likes-1','uid='.$entry);
        $result['is_liked'] = 0;
    }else{ // 좋아요 안한 경우 추가
        $QKEY = "mbruid,module,entry,opinion,d_regis";
        $QVAL = "'$mbruid','$type','$entry','like','".$date['totime']."'";
        getDbInsert($opinion_table,$QKEY,$QVAL);
        getDbUpdate($update_table,'likes=likes+1','uid='.$entry);
        $result['is_liked'] = 1;
    }

    // 현재 해당 글 likes 갯수 얻기
    $R = getDbData($update_table,'uid='.$entry,'likes');

    $result['total_like'] = $R['likes']?$R['likes']:'';
    $result['check_qry'] = $check_qry;
    $result['update_table'] = $update_table;
}else if($act=='delete'){
    if($type=='comment')  $del_msg = $comment->deleteComment($uid);
    else if($type=='oneline') $del_msg = $comment->deleteOneline($parent,$uid);

    if($del_msg=='OK') $result['msg'] = $del_msg;
    else {
        $result['error'] = true;
        $result['error_msg'] = $del_msg;
    }

}else if($act=='notice'){  // 공지글 지정
    $update_table = $comment->commentTable;
    $check_qry = "notice=1 and uid=".$uid;
    $is_notice = getDbRows($update_table,$check_qry);

    if ($is_notice) {
      getDbUpdate($update_table,'notice=0','uid='.$uid);
      $result['is_notice'] = 0;
    } else {
      getDbUpdate($update_table,'notice=1','uid='.$uid);
      $result['is_notice'] = 1;
    }
    // $result['content'] = $comment->getCommentLog($parent,$sort,$orderby,$recnum,$page);

}else if($act=='getCommentList'){  // 댓글 더보기 & 리로드
    $result['content'] = $comment->getCommentLog($parent,$sort,$orderby,$recnum,$page,0);
    $result['notice']  = $comment->getCommentLog($parent,$sort,$orderby,$recnum,$page,1);
}

echo json_encode($result);
exit;
?>
