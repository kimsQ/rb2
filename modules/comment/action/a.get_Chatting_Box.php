<?php
/* 채팅박스 초기화 */
if(!defined('__KIMS__')) exit;

require_once $g['dir_module'].'includes/base.class.php';
require_once $g['dir_module'].'includes/module.class.php';

$chatting = new Chatting();  
$chatting->id = $_GET['chat_id']; // get 으로 넘어온 값을 id 지정
$is_owner = $chatting->is_owner(); // 채팅방장 여부
$totalPage = $chatting->getTotalPage($chatting->id,$chatting->recnum);
$totalRow = getDbRows($table[$m.'data'],"bbsid='".$chatting->id."'");
$SAT = $chatting->getSettings($chatting->id); // 채팅방 설정값 

// 이미지 폴더 패스 
$TMPL['img_module_skin'] = $chatting->getThemePath($chatting->id).'/images/';

// chat box html 추출 
if($is_owner) $TMPL['chat_owner_menu'] = $chatting->getHtml('chat_owner_menu');
else $TMPL['chat_owner_menu'] = '';

// 차단사용자 모달 값 세팅 
$TMPL['room_name'] = $SAT['room_name'];// 채팅방명 
$TMPL['block_list'] = $chatting->getBlockUser($chatting->id,1,5); // 차단사용자 리스트 

// 열람 권한 체크 및 chat 출력 
$UAP = $chatting->getUAP($chatting->id);
if(!$UAP['open']) $TMPL['chat_rows'] = $chatting->getNoAccessMsg('not_open'); // 오픈전 메세지  
else if(!$UAP['view']) $TMPL['chat_rows'] = $chatting->getNoAccessMsg('no_viewPerm'); // 열람권한 없음 메세지 
else if($UAP['closed']) $TMPL['chat_rows'] = $chatting->getNoAccessMsg('closed'); // closed 메세지 
else $TMPL['chat_rows'] = $chatting->getChatLog($chatting->id,1,$chatting->recnum);

// 이모티콘 리스트 
$TMPL['emoticon_list'] = $chatting->getEmoticonList($chatting->id);

$chat_box = $chatting->getHtml('chat_box');	

$result['chat_box'] = $chat_box;
$result['is_owner'] = $is_owner; // 채팅방장 여부 
$result['owner_id'] = $SAT['owner_id'];
$result['totalPage'] = $totalPage;
$result['totalRow'] = $totalRow;
$result['userGroup'] = $my['mygroup']?$my['mygroup']:0;
$result['userLevel'] = $my['level']?$my['level']:0;
$result['room_type'] = $SAT['room_type']; // 운영시작
$result['perm_write'] = $UAP['write']; // 작성 권한
$result['room_open'] = $UAP['open']; // 운영시작 
$result['room_closed'] = $UAP['closed']; // 운영마감 
$result['t_start'] = $UAP['t_start']; // 운영마감 
$result['t_end'] = $UAP['t_end']; // 운영마감 
$result['now_time'] = $UAP['now_time']; // 운영마감 


echo json_encode($result,true);
exit;
?>