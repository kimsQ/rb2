<?php
if(!defined('__KIMS__')) exit;


checkAdmin(0);

$memberuid	= $my['uid'];
$url		= $g['s'].'/?r='.$r.'&m='.$m.'&module='.$_addmodule.'&front='.$_addfront;
if(getDbRows($table['s_admpage'],'memberuid='.$memberuid." and url='".$url."'"))
{
	getLink('','','이미 등록된 북마크입니다.','');
}

$maxgid = getDbCnt($table['s_admpage'],'max(gid)','memberuid='.$memberuid);
$MD = getDbData($table['s_module'],"id='".$_addmodule."'",'*');

include getLangFile($g['path_module'].$_addmodule.'/language/',$d['admin']['syslang'],'/lang.admin-menu.php');
$varfile = $g['path_module'].$_addmodule.'/admin/var/var.menu.php';
if (is_file($varfile))
{
	include $varfile;
	$name= $MD['name'].' - '.$d['amenu'][$_addfront];
}
else {
	$name= $MD['name'];
}

$gid = $maxgid + 1;
getDbInsert($table['s_admpage'],'memberuid,gid,name,url',"'$memberuid','$gid','$name','$url'");
$bookmark_uid = getDbCnt($table['s_admpage'],'max(uid)','');

if ($_addmodule == 'admin' && $_addfront == 'bookmark')
{
	getLink('reload','parent.','','');
}
else {
?>
<script>
parent.getId('_bookmark_star_').className = 'fa fa-lg fa-star rb-star-fill text-primary';
parent.getId('_bookmark_notyet_').className = 'btn-group btn-group-sm dropdown hidden';
parent.getId('_bookmark_already_').className = 'btn-group btn-group-sm dropdown';
parent.getId('_add_bookmark_').innerHTML <?php if(getDbRows($table['s_admpage'],'memberuid='.$my['uid'])>1):?>+<?php endif?>= '<a href="<?php echo $url?>" class="list-group-item" id="_now_bookmark_<?php echo $bookmark_uid?>"><i class="fa fa-fw fa-file-text-o"></i><?php echo $name?></a>';
</script>
<?php
exit;
}
?>
