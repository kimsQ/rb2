<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if (is_file($g['path_file'].'cover/'.$my['cover']))
{
	unlink($g['path_file'].'cover/'.$my['cover']);
}
getDbUpdate($table['s_mbrdata'],"cover=''",'memberuid='.$my['uid']);

// getLink('','parent.','삭제되었습니다.','');
?>

<script>
parent.$('[data-role="cover"]').attr('src',parent.rooturl + '/files/cover/0.jpg');
parent.$('[data-role="cover-wrapper"]').removeClass('active')
setTimeout(function(){
	parent.$.notify({message: '커버이미지가 삭제되었습니다.'},{type: 'default'});
}, 500);

</script>

<?php
exit;
?>
