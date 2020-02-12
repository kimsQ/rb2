<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_tmpdfile = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['search']['theme'] = \"".$theme."\";\n");
fwrite($fp, "\$d['search']['m_theme'] = \"".$m_theme."\";\n");
fwrite($fp, "\$d['search']['num1'] = \"".$num1."\";\n");
fwrite($fp, "\$d['search']['num2'] = \"".$num2."\";\n");
fwrite($fp, "\$d['search']['term'] = \"".$term."\";\n");
fwrite($fp, "\$d['search']['layout'] = \"".$layout."\";\n");
fwrite($fp, "\$d['search']['m_layout'] = \"".$m_layout."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

$_tmpdfile = $g['dir_module'].'var/search.list.txt';

$fp = fopen($_tmpdfile,'w');
fwrite($fp,trim(stripslashes($searchlist)));
fclose($fp);
@chmod($_tmpdfile,0707);

setrawcookie('search_config_result', rawurlencode('설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
