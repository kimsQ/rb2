<?php
checkAdmin(0);

include_once $g['path_module'].$m.'/_main.php';
if (!$cat) getLink('./?m=admin&module='.$m.'&front=category','parent.','','');



if ($subQue)
  while($R=db_fetch_array($DAT))

    getDbDelete($table[$m.'category'],'uid='.$R['uid']); // 카테고리 삭제
    getDbDelete($table[$m.'category_index'],'category='.$R['uid']); //인덱스삭제

    $_xfile = $g['dir_module'].'var/code/'.sprintf('%05d',$R['uid']);
    @unlink($_xfile.'.header.php');
    @unlink($_xfile.'.footer.php');
    @unlink($g['dir_module'].'var/files/'.$R['imghead']);
    @unlink($g['dir_module'].'var/fiels/'.$R['imgfoot']);
  }

  if ($parent)
    if (!getDbRows($table[$m.'category'],'parent='.$parent))
      getDbUpdate($table[$m.'category'],'is_child=0','uid='.$parent);
    }
  }


setrawcookie('result_shop_category', rawurlencode('카테고리가 삭제 되었습니다.|danger'));
getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=category&cat='.$parent,'parent.','','');
?>