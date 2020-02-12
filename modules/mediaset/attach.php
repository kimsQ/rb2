<?php
if(!defined('__KIMS__')) exit;

// 위젯에서 지정한 값들
$d['attach']['parent_module']=$parent_module;
$d['attach']['parent_table']=$parent_table;
$d['attach']['parent_uid']=$parent_uid;
$d['attach']['parent_field']=$parent_field;
$d['attach']['parent_data']=$parent_data;
$d['attach']['theme']=$attach_module_theme?$attach_module_theme:'default'; // 지정 테마
$d['attach']['handler_file']=$attach_handler_file;
$d['attach']['handler_photo']=$attach_handler_photo;
$d['attach']['handler_getModalList']=$attach_handler_getModalList; // 첨부파일 리스트 모달로 호출하는 handler
$d['attach']['mod']=$attach_mod?$attach_mod:'main'; // 위젯에서 받은 값
$d['attach']['object_type']=$attach_object_type?$attach_object_type:''; // 첨부 대상에 따른 분류 : photo, file, link, video....
$d['attach']['tmpcode']=$attach_tmpcode?$attach_tmpcode:$date['totime']; // 여러개일 경우를 고려행 uniqe 코드 생성
$d['attach']['featuredImg_form_name']=$attach_featuredImg_form_name?$attach_featuredImg_form_name:''; // 대표이미지로 선정된 이미지 uid 가 저장될 form name (DB 필드명)
$d['attach']['wdgvar_id']=$attach_wdgvar_id; // 위젯 고유 id
$d['attach']['editor_type']=$editor_type; // 에디터 타입 : html,markdown

$g['dir_attach_module'] = $g['path_module'].'mediaset/';
$g['url_attach_module'] = $g['s'].'/modules/mediaset';

$g['dir_attach_theme'] = $g['dir_attach_module'].'themes/'.$d['attach']['theme'].'/';
$g['url_attach_theme'] = $g['url_attach_module'].'/themes/'.$d['attach']['theme'];

$g['dir_attach_mode'] = $g['dir_attach_theme'].$d['attach']['mod'];
$g['url_attach_mode'] = $g['url_attach_theme'].'/'.$d['attach']['mod'];

if(!$g['dir_module']) $g['dir_module']=$g['dir_attach_module'];

//$g['main'] = $g['main'] ? $g['main'] : $g['dir_attach_mode'].'.php';
include $g['dir_attach_mode'].'.php';
?>
