<?php
if(!defined('__KIMS__')) exit;

// post 로 넘어오는 값 
$post = $_POST['post']; // 해당 블로그 data uid 

// 리턴값 세팅 
$result = array();
$result['error'] = false;

$mbruid = $my['uid'];

// 로그인한 사용자가 좋아요를 했는지 여부 체크 
$is_liked = getDbRows($table[$m.'likes'],'mbruid='.$mbruid.' and post='.$post);

if($is_liked){ // 좋아요를 했던 경우 
	// rb_blog_likes 테이블 row 삭제 
	getDbDelete($table[$m.'likes'],'mbruid='.$mbruid.' and post='.$post);
    
    // rb_blog_data 테이블 해당 글의 likes 갯수 업데이트 
    getDbUpdate($table[$m.'data'],'likes=likes-1','uid='.$post); 

}else{ // 좋아요 안한 경우 추가 
	// rb_blog_likes 테이블 row 추가 
    $QKEY = "mbruid,post,d_regis";
    $QVAL = "'$mbruid','$post','".$date['totime']."'";
    getDbInsert($table[$m.'likes'],$QKEY,$QVAL);

    // rb_blog_data 테이블 해당 글의 likes 갯수 업데이트 
    getDbUpdate($table[$m.'data'],'likes=likes+1','uid='.$post); 	

}

// 현재 해당 글 likes 갯수 얻기 
$R = getDbData($table[$m.'data'],'uid='.$post,'likes'); 

$result['total_like'] = $R['likes'];

echo json_encode($result);
exit;
?>