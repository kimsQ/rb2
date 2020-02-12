<div id="mjointbox">

	<div class="title">
		이 모듈(댓글)을 연결하시겠습니까?
	</div>

	<select id="comment_skin" class="form-control custom-select">
  	<option value="">&nbsp;+ 댓글 대표테마</option>
  	<option value="" disabled>--------------------------------</option>
  	<?php $tdir = $g['path_module'].$smodule.'/themes/_desktop/'?>
  	<?php $dirs = opendir($tdir)?>
  	<?php while(false !== ($skin = readdir($dirs))):?>
  	<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
  	<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>">ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
  	<?php endwhile?>
  	<?php closedir($dirs)?>
	</select>
  
	<input type="checkbox" id="hidepost" value="1" /> 최근댓글 출력제외

	<input type="button" value="연결" class="btn btn-light" onclick="dropJoint('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $smodule?>'+(getId('comment_skin').value!=''?'&skin='+getId('comment_skin').value:'')+(getId('hidepost').checked==true?'&hidepost=1':'')+'&sync=Y');" />

</div>

<style type="text/css">
#mjointbox {}
#mjointbox select {width:150px;padding:2px;}
#mjointbox .title {border-bottom:#dfdfdf dashed 1px;padding:0 0 10px 0;margin:0 0 20px 0;}
</style>
