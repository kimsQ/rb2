<?php
if(!defined('__KIMS__')) exit;

// if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

$MS = getDbData($table['s_mbrsns'],"mbruid='".$my['uid']."' and sns='kakao'",'*');

//getLink('','',$MS['access_token'].' 토근입니다..','');

$msg = 'template_object= {
  "object_type": "feed",
  "content": {
    "title": "디저트 사진",
    "description": "아메리카노, 빵, 케익",
    "image_url": "http://mud-kage.kakao.co.kr/dn/NTmhS/btqfEUdFAUf/FjKzkZsnoeE4o19klTOVI1/openlink_640x640s.jpg",
    "image_width": 640,
    "image_height": 640,
    "link": {
      "web_url": "http://www.daum.net",
      "mobile_web_url": "http://m.daum.net",
      "android_execution_params": "contentId=100",
      "ios_execution_params": "contentId=100"
    }
  },
  "social": {
    "like_count": 100,
    "comment_count": 200,
    "shared_count": 300,
    "view_count": 400,
    "subscriber_count": 500
  },
  "buttons": [
    {
      "title": "웹으로 이동",
      "link": {
        "web_url": "http://www.daum.net",
        "mobile_web_url": "http://m.daum.net"
      }
    },
    {
      "title": "앱으로 이동",
      "link": {
        "android_execution_params": "contentId=100",
        "ios_execution_params": "contentId=100"
      }
    }
  ]
}';

$dat = json_decode(getCURLData2('https://kapi.kakao.com/v2/api/talk/memo/default/send',array("Authorization: Bearer ".$MS['access_token']),array($msg)), true);


getLink('','',$dat['result_code'].' 결과입니다.','-1');

?>
