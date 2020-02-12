<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$badword = trim($badword);
$badword = str_replace("\r\n","",$badword);
$badword = str_replace("\n","",$badword);

$fdset = array('skin_main','skin_mobile','skin_total','editor_main','editor_mobile','attach_main','attach_mobile','comment_main','comment_mobile','rss','restr','denylikemy','replydel','commentdel','badword','badword_action','badword_escape','singo_del','singo_del_num','singo_del_act','recnum','sbjcut','newtime');

$gfile= $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$fp = fopen($gfile,'w');
fwrite($fp, "<?php\n");
foreach ($fdset as $val)
{
	fwrite($fp, "\$d['bbs']['".$val."'] = \"".trim(${$val})."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($gfile,0707);

setrawcookie('bbs_config_result', rawurlencode('<i class="fa fa-check" aria-hidden="true"></i> 설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
