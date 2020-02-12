<?php
/* msg 템플릿 초기화 */
if(!defined('__KIMS__')) exit;
require_once $g['dir_module'].'includes/base.class.php';
require_once $g['dir_module'].'includes/module.class.php';

$chatting = new Chatting();  
$chatting->id = $_GET['chat_id']; // get 으로 넘어온 값을 id 지정

$resutl = array();
$result['me'] = $chatting->getHtmlOnly('my_msg');
$result['other'] = $chatting->getHtmlOnly('other_msg');
$result['notice'] = $chatting->getHtmlOnly('notice_msg');
$result['notice'] = $chatting->getHtmlOnly('notice_msg');
$result['photo'] = $chatting->getHtmlOnly('photo_msg');
$result['file'] = $chatting->getHtmlOnly('file_msg');
$result['emoticon'] = $chatting->getHtmlOnly('emoticon_msg');

echo json_encode($result,true);
exit;
?>