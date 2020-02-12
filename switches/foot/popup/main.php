<?php $POPUPS = getDbSelect($table['s_popup'],'hidden=0','*')?>

<?php while($POP=db_fetch_array($POPUPS)):?>
  <?php if (!$POP['term0'] && ($POP['term1'] > $date['totime'] || $POP['term2'] < $date['totime'])):?>
  <?php getDbUpdate($table['s_popup'],'hidden=1','uid='.$POP['uid']);continue?>
  <?php endif?>
  <?php $POP['xdispage']='_'.$POP['dispage']?>
  <?php if(strpos($POP['xdispage'],'[c['.$_HS['uid'].']]')) continue?>
  <?php if(!strpos($POP['xdispage'],'[s['.$_HS['uid'].']]') && !strpos($POP['xdispage'],'[m['.$_HS['uid'].']'.$_HM['id'].']') && !strpos($POP['xdispage'],'[m['.$_HS['uid'].']'.$_HP['id'].']')) continue?>

  <?php
  if ($g['mobile']&&$_SESSION['pcmode']!='Y') $POP['skin'] =  $POP['m_skin'];
  $g['dir_popup_skin'] = $g['path_module'].'popup/themes/'. $POP['skin'].'/';
  ?>

  <aside>
    <?php
    if(strpos($_COOKIE['popview'], $POP['uid']) !== false) {
    } else {
      if ($POP['admin']) {
        if ($my['admin']) {
          include $g['dir_popup_skin'].'main.php';
        }
      } else {
        include $g['dir_popup_skin'].'main.php';
      }
    }
    ?>
  </aside>
<?php endwhile?>
