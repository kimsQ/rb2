<?phpif(!defined('__KIMS__')) exit;
checkAdmin(0);

include_once $g['path_module'].$m.'/_main.php';
if (!$cat) getLink('./?m=admin&module='.$m.'&front=category','parent.','','');
$CINFO = getUidData($table[$m.'category'],$cat);
$subQue = getPostCategoryCodeToSql($table[$m.'category'],$CINFO['id']);
$subQue = str_replace('category=','uid=',$subQue);

if ($subQue){
  $DAT = getDbSelect($table[$m.'category'],$subQue,'*');
  while($R=db_fetch_array($DAT))	{

    getDbDelete($table[$m.'category'],'uid='.$R['uid']); // 카테고리 삭제
    getDbDelete($table[$m.'category_index'],'category='.$R['uid']); //인덱스삭제

    $_xfile = $g['path_file'].$m.'/code/'.sprintf('%05d',$R['uid']);
    @unlink($_xfile.'.header.php');
    @unlink($_xfile.'.footer.php');
    @unlink($g['path_file'].$m.'/category/'.$R['imghead']);
    @unlink($g['path_file'].$m.'/category/'.$R['imgfoot']);
  }

  if ($parent)	{
    if (!getDbRows($table[$m.'category'],'parent='.$parent))	{
      getDbUpdate($table[$m.'category'],'is_child=0','uid='.$parent);
    }
  }
  db_query("OPTIMIZE TABLE ".$table[$m.'category'],$DB_CONNECT);
}

setrawcookie('result_post_category', rawurlencode('카테고리가 삭제 되었습니다.|danger'));
getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=category&cat='.$parent,'parent.','','');
?>
