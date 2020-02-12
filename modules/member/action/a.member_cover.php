<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) exit;

include $g['path_core'].'function/thumb.func.php';

if ($_FILES['upfile']['tmp_name'])
{
	$fileName	= strtolower($_FILES['upfile']['name']);
	$fileSize	= $_FILES['upfile']['size'];
	$fileExt	= getExt($fileName);
	$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
	$fileType	= getFileType($fileExt);
	$filePhoto	= md5($fileName).substr($date['totime'],8,14).'.'.$fileExt;
	$saveFile1	= $g['path_file'].'cover/'.$filePhoto;

	if (strstr('[jpg][png][gif]',$fileExt))
	{
		if ($fileExt == 'jpg') {
			exifRotate($_FILES['upfile']['tmp_name']); //가로세로 교정
		}
		ResizeWidth($_FILES['upfile']['tmp_name'],$saveFile1,680);
		@chmod($saveFile1,0707);

		getDbUpdate($table['s_mbrdata'],"cover='".$filePhoto."'",'memberuid='.$my['uid']);
	}
	else {
		getLink('reload','parent.','이미지파일이 아닙니다. JPG/PNG 파일만 허용됩니다.','');
	}
?>
<script>
var cover = '<?php echo $filePhoto?>';

function logoChange(cover) {
	parent.$('[data-role="cover"]').attr('src',parent.rooturl + '/_core/opensrc/timthumb/thumb.php?src=/files/cover/' + cover+'&w=680&h=350&s=1');
	parent.$('#page-settings-cover').find('.content').loader("hide");
}
logoChange(cover);
parent.$('[data-role="cover-wrapper"]').addClass('active');
setTimeout(function(){
	parent.$.notify({message: '커버이미지가 등록되었습니다.'},{type: 'default'});
}, 500);

</script>
<?php
}
exit;
?>
