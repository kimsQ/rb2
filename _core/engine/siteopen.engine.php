<?php
if(!defined('__KIMS__')) exit;

if ($m != 'admin' && (($_HS['open']==2&&!$my['admin'])||$_HS['open']==3)) $iframe = 'Y';
if ($_HS['open'] == 2) if (!$my['admin'] && $m != 'admin' && $system != 'guide.stopsite') getLink($g['s'].'/?r='.$r.'&system=guide.stopsite','','','');
if ($_HS['open'] == 3) if ($m != 'admin' && $system != 'guide.stopsite') getLink($g['s'].'/?r='.$r.'&system=guide.stopsite','','','');
?>