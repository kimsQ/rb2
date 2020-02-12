<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$badword = trim($badword);
$badword = str_replace("\r\n","",$badword);
$badword = str_replace("\n","",$badword);

$fdset = array('skin_main','skin_mobile','skin_total','rss','restr','commentdel','badword','badword_action','badword_escape','report_del','report_del_num','report_del_act','recnum','newtime','give_point','give_opoint');
$gfile= $g['path_var'].'site/'.$r.'/'.$m.'.var.php';

$fp = fopen($gfile,'w');
fwrite($fp, "<?php\n");
foreach ($fdset as $val)
{
	fwrite($fp, "\$d['comment']['".$val."'] = \"".trim(${$val})."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($gfile,0707);

setrawcookie('comment_config_result', rawurlencode('설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
