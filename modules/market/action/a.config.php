<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$_tmpdfile = $g['path_var'].'/market.var.php';
$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['market']['userid'] = \"".$userid."\";\n");
fwrite($fp, "\$d['market']['key'] = \"".$key."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

setrawcookie('market_action_result', rawurlencode('입력하신 내용이 적용되었습니다.|success'));
getLink('reload','parent.','','');
?>
