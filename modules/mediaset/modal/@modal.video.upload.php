<?php
function getVodCode($src)
{
	$exp1 = explode('youtube.com/embed/',$src);
	$exp2 = strstr($exp1[1],'?') ? explode('?',$exp1[1]) : explode('"',$exp1[1]);
	return $exp2[0];
}
function getVodThumb($src,$what)
{
	return '//img.youtube.com/vi/'.getVodCode($src).'/'.$what.'.jpg';
}
function getVodUrl($src)
{
	return '//www.youtube.com/watch?feature=player_detailpage&v='.getVodCode($src);
}

$S = 0;
$N = 0;

if ($files)
{
	$d['mediaset'] = getArrayString($files);
	foreach($d['mediaset']['data'] as $_val)
	{
		$U = getUidData($table['s_upload'],$_val);
		if ($U['uid'])
		{
			$S+= $U['size'];
			$N++;
		}
	}
}


$P = array();

if (!$_SESSION['upsescode'])
{
	$_SESSION['upsescode'] = str_replace('.','',$g['time_start']);
}

$sescode = $_SESSION['upsescode'];

if ($sescode)
{
	$PHOTOS = getDbArray($table['s_upload'],"tmpcode='".$sescode."' and (type=0 or type=5) and fileonly=0",'*','pid','asc',0,0);
	while($R = db_fetch_array($PHOTOS))
	{
		$P[] = $R;
		$S += $R['size'];
		$N++;
	}
}

$d['mediaset']['limitnum'] = $d['mediaset']['maxnum_img'];
$d['mediaset']['limitsize'] = $d['mediaset']['maxsize_img'];
$d['mediaset']['limitsize'] = $d['mediaset']['limitsize'] * 1024 * 1024;


$LimitNum = $d['mediaset']['limitnum'] - $N;
$LimitSize= $d['mediaset']['limitsize'] - $S;

$gparamExp= explode('|',$gparam);

if ($tab == 'file_info')
{
	if (!$file_uid)
	{
		$file_uid = $P[0]['uid'];
		$_R = $P[0];
	}
	else {
		$_R = getUidData($table['s_upload'],$file_uid);
	}
}
$g['base_href'] = $g['s'].'/?r='.$r.'&amp;m='.$m.'&amp;iframe=Y&amp;mdfile='.$mdfile.'&amp;dropfield='.$dropfield.'&amp;dropfiles='.$dropfiles;
?>

<?php getImport('bootstrap-select','bootstrap-select',false,'css')?>
<?php getImport('bootstrap-select','bootstrap-select',false,'js')?>


<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_upload_iframe_">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $m?>">
<input type="hidden" name="a" value="upload_vod">
<input type="hidden" name="saveDir" value="<?php echo $g['path_file']?>">
<input type="hidden" name="gparam" value="<?php echo $gparam?>">
<input type="hidden" name="category" value="0">

<input name="upfiles[]" type="file" accept="video/mp4" id="filefiled" class="hidden" onchange="getFiles();" />
</form>
<iframe name="_upload_iframe_" width="1" height="1" frameborder="0" scrolling="no"></iframe>

<div id="photobox">
	<div id="progressBar" class="progress progress-striped active">
	  <div id="progressPer" class="progress-bar progress-bar-danger" role="progressbar"></div>
	</div>

	<div class="photo-box">
		<?php if($N):?>

		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/core.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/events.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/css.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/coordinates.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/drag.js"></script>
		<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/dragsort.js"></script>
		<script>
		var dragsort = ToolMan.dragsort();
		function slideshowOpen()
		{
			dragsort.makeListSortable(getId("photoorder"));
		}
		window.onload = slideshowOpen;
		</script>

		<form name="photolistForm" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="a" value="">
		<ul id="photoorder">
			<?php foreach($P as $val):$val['xurl']=($g['s']=='/'?$g['s']:$g['s'].'/').'files/'?>
			<li<?php if($file_uid==$val['uid']):?> class="selected"<?php endif?> ondblclick="location.href='<?php echo $g['s']?>/?r=<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info';">
				<input type="checkbox" class="rb-photo-check" name="photomembers[]" value="<?php echo $val['uid']?>|<?php echo $val['xurl'].$val['folder'].'/'.$val['tmpname']?>|<?php echo $val['name']?>|" onclick="photoCheck(<?php echo $val['uid']?>);">
				<span id="caption_<?php echo $val['uid']?>" class="hidden"><?php echo htmlspecialchars($val['caption'])?></span>
				<?php if($val['type']):?>
				<div id="vod_<?php echo $val['uid']?>" class="photo"><video src="<?php echo $val['url'].$val['folder'].'/'.$val['tmpname']?>" width="100%" height="100%"></video></div>
				<span id="vodsrc_<?php echo $val['uid']?>" class="hidden"><iframe src="<?php echo $g['url_root'].'/_core/opensrc/thumb/image.php?vod='.$val['url'].$val['folder'].'/'.$val['tmpname']?>" width="350" height="250" frameborder="0" scrolling="no"></iframe></span>
				<?php else:?>
				<div id="vod_<?php echo $val['uid']?>" class="photo" style="background:url('<?php echo getVodThumb($val['src'],'mqdefault')?>') center center no-repeat;"></div>
				<span id="vodsrc_<?php echo $val['uid']?>" class="hidden"><iframe width="350" height="250" src="http://www.youtube.com/embed/<?php echo getVodCode($val['src'])?>/?autohide=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe></span>
				<?php endif?>

				<div class="btn-group">
					<button class="btn btn-default" type="button" title="형식:<?php if($val['type']>0):?>내부동영상<?php else:?>외부동영상<?php endif?>" data-tooltip="tooltip">
					<i class="<?php if($val['type']>0):?>glyphicon glyphicon-cloud-upload<?php else:?>fa fa-link<?php endif?> fa-lg"></i>
					</button>

					<button class="btn btn-default" type="button" title="수정" data-tooltip="tooltip" onclick="location.href='<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info';">
					<i class="fa fa-edit fa-lg"></i>
					</button>

					<button class="btn btn-default" type="button" title="보기" data-tooltip="tooltip" onclick="location.href='<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&autoplay=Y';">
					<i class="glyphicon glyphicon-play-circle fa-lg"></i>
					</button>

					<button class="btn btn-default" type="button" title="삭제" data-tooltip="tooltip" onclick="deleteCheck(0,<?php echo $val['uid']?>);">
					<i class="fa fa-trash-o fa-lg"></i>
					</button>
				</div>
			</li>
			<?php endforeach?>
		</ul>
		</form>
		<?php else:?>
		<div class="alert alert-success">
			<span class="glyphicon glyphicon-info-sign"></span>
			첨부할 동영상을 선택해 주세요.
			<button type="button" class="btn btn-default" onclick="getId('filefiled').click();">PC동영상 업로드</button>
			<button type="button" class="btn btn-default" onclick="vodAdd();">외부동영상 링크</button>
		</div>
		<?php endif?>
	</div>
</div>

<?php if($N || $outlink == 'Y'):?>
<div id="infobox">
	<?php if($outlink=='Y'):?>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#">외부동영상 추가</a></li>
	</ul>
	<div class="infobox-body">
		<div class="pic-info1">
			<div id="_vod_play_layer_" class="media-pic">
				
			</div>

			<form name="_upload_form1_" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="upload_vod">
			<input type="hidden" name="gparam" value="<?php echo $gparam?>">
			<input type="hidden" name="link" value="Y">
			<input type="hidden" name="category" value="0">


			<div class="panel-body">
				<div class="form-group">
					<label>유투브소스 (Embed Code)</label>
					<textarea name="src" id="_vod_embed_code_" class="form-control" rows="4"><?php echo $_R['src']?></textarea>
				</div>
			</div>
			</form>
		</div>
		<div class="pic-submit1">
			<div class="text-center">
				<button type="button" class="btn btn-default" onclick="getVodPreview();" style="margin-bottom:3px;">동영상 불러오기</button>
				<button type="button" class="btn btn-primary" onclick="getVodSave();">동영상 저장하기</button>
			</div>
		</div>
	</div>

	<?php else:?>
	<ul class="nav nav-tabs">
		<li<?php if($file_uid):?> class="active"<?php endif?>><a href="<?php echo $g['base_href']?>&amp;file_uid=<?php echo $file_uid?>&amp;tab=file_info">동영상정보</a></li>
		<li<?php if(!$file_uid):?> class="active"<?php endif?>><a href="<?php echo $g['base_href']?>">삽입하기</a></li>
	</ul>

	<?php if($tab == 'file_info'):?>
	<?php $_videoSrc=getVodCode($_R['src'])?>
	<div class="infobox-body">
		<div class="pic-info">
			<div id="_vod_play_layer_" class="media-pic">
			<?php if($autoplay=='Y'):?>
				<?php if(!$_R['type']):?>
				<iframe width="90%" src="http://www.youtube.com/embed/<?php echo $_videoSrc?>/?autoplay=1&autohide=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen style="margin:15px;"></iframe>
				<?php else:?>
				<video src="<?php echo $_R['url'].$_R['folder'].'/'.$_R['tmpname']?>" width="90%" controls autoplay preload="auto" style="margin:15px;"></video>
				<?php endif?>
			<?php else:?>
				<?php if(!$_R['type']):?>
				<iframe width="90%" src="http://www.youtube.com/embed/<?php echo $_videoSrc?>/?autoplay=0&autohide=0&rel=0&wmode=transparent" frameborder="0" allowfullscreen style="margin:15px;"></iframe>
				<?php else:?>
				<video src="<?php echo $_R['url'].$_R['folder'].'/'.$_R['tmpname']?>" width="90%" controls preload="auto" style="margin:15px;"></video>
				<?php endif?>
			<?php endif?>
			</div>
			<form name="captionForm" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="caption_regis_vod">
			<input type="hidden" name="uid" value="<?php echo $_R['uid']?>">

			<div class="panel-body">

				<div class="form-group">
					<label>Video Name</label>
					<input type="text" class="form-control" name="name" value="<?php echo $_R['name']?>">
				</div>
				<div class="form-group">
					<label>Alt Text</label>
					<input type="text" class="form-control" name="alt" value="<?php echo $_R['alt']?>">
				</div>
				<div class="form-group">
					<label>Caption</label>
					<textarea class="form-control" name="caption" rows="3"><?php echo $_R['caption']?></textarea>
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control" name="description" rows="3"><?php echo $_R['description']?></textarea>
				</div>
				<?php if(!$_R['type']):?>
				<div class="form-group">
					<label>유투브소스 (Embed Code)</label>
					<textarea name="src" id="_vod_embed_code_" class="form-control" rows="4"><?php echo $_R['src']?></textarea>
				</div>
				<?php endif?>
				<div class="form-group">
					<label class="control-label">License</label>
					<select name="license" class="selectpicker show-tick show-menu-arrow scrollMe" data-width="100%" data-style="btn btn-default" data-size="auto">
						<option value="0"<?php if($_R['license']==0):?> selected<?php endif?>>None (All rights reserved)</option>
						<option value="1"<?php if($_R['license']==1):?> selected<?php endif?>>저작자표시-비영리-동일조건변경허락 Creative Commons</option>
						<option value="2"<?php if($_R['license']==2):?> selected<?php endif?>>저작자표시-비영리 Creative Commons</option>
						<option value="3"<?php if($_R['license']==3):?> selected<?php endif?>>저작자표시-비영리-변경금지 Creative Commons</option>
						<option value="4"<?php if($_R['license']==4):?> selected<?php endif?>>저작자표시 Creative Commons</option>
						<option value="5"<?php if($_R['license']==5):?> selected<?php endif?>>저작자표시-동일조건변경허락 Creative Commons</option>
						<option value="6"<?php if($_R['license']==6):?> selected<?php endif?>>저작자표시-변경금지 Creative Commons</option>
					</select>
				</div>
				<div class="form-group">
					<label>Category</label>
					<select name="category" class="selectpicker show-tick show-menu-arrow scrollMe" data-width="100%" data-style="btn btn-default" data-size="auto">
					<?php $_CT_RCD = getDbArray($table['s_uploadcat'],'mbruid='.$my['uid']." and type=2 and name<>'none' and name<>'trash'",'*','gid','asc',0,1)?>
					<option value="0"<?php if($_R['category']==0):?> selected<?php endif?>>미분류</option>
					<?php while($_CT=db_fetch_array($_CT_RCD)):?>
					<option value="<?php echo $_CT['uid']?>"<?php if($_R['category']==$_CT['uid']):?> selected<?php endif?>><?php echo $_CT['name']?>(<?php echo number_format($_CT['r_num'])?>)</option>
					<?php endwhile?>
					<option value="-1"<?php if($_R['category']==-1):?> selected<?php endif?>>휴지통</option>
					</select>
				</div>
			</div>
			</form>
		</div>
		<div class="pic-submit">
			<div class="text-center">
				<button type="button" class="btn btn-primary" onclick="infoCheck();">정보수정</button>
			</div>
		</div>
	</div>
	<?php else:?>
	<div class="layoutbox-body">
		
		<div class="selectbox">
			<select class="selectpicker show-tick show-menu-arrow scrollMe" data-width="100%" data-style="btn btn-default" data-size="auto" onchange="frames._template_iframe_.location.href='<?php echo $g['url_module'].'/lang.'.$_HS['lang']?>/modal/template/'+this.value;">
			<option value="video-base.html">템플릿 선택하기</option>
			<option data-divider="true"></option>
			<?php $tdir = $g['dir_module'].'lang.'.$_HS['lang'].'/modal/template/'?>
			<?php $dirs = opendir($tdir)?>
			<?php while(false !== ($skin = readdir($dirs))):?>
			<?php if(!strstr($skin,'.html') || !strstr($skin,'video-') || $skin == 'video-base.html')continue?>
			<option value="<?php echo $skin?>"><?php echo $skin?></option>
			<?php endwhile?>
			<?php closedir($dirs)?>
			</select>
		</div>

		<div class="iframebox">
			<iframe name="_template_iframe_" src="<?php echo $g['dir_module'].'lang.'.$_HS['lang']?>/modal/template/video-base.html" width="100%" height="100%" frameborder="0"></iframe>
		</div>
		
		<div class="optionbox">
			<div class="text-center">
				<button type="button" class="btn btn-primary" onclick="templateCheck();">삽입하기</button>
			</div>
		</div>

	<?php endif?>
	</div>
	<?php endif?>
</div>
<?php endif?>







<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close rb-close-white" style="position:absolute;right:15px;z-index:1;" data-dismiss="modal" aria-hidden="true">&times;</button>

	<ul class="nav nav-tabs" style="position:relative;left:5px;margin-bottom:-20px;z-index:0;">
		<li class="active"><a href="#">업로드 패널</a></li>
		<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;iframe=Y&amp;mdfile=modal.video.media&amp;dropfield=<?php echo $dropfield?>&amp;dropfiles=<?php echo $dropfiles?>" target="_modal_iframe_modal_window">비디오셋</a></li>
	</ul>
</div>

<div id="_modal_footer" class="hidden">

	<button type="button" class="btn btn-primary pull-left" onclick="frames._modal_iframe_modal_window.getId('filefiled').click();"><i class="fa fa-cloud-upload fa-lg"></i> PC동영상</button>
	<button type="button" class="btn btn-primary pull-left" onclick="frames._modal_iframe_modal_window.picAdd();"><i class="fa fa-link fa-lg"></i> 외부동영상</button>

	<?php if($N>1):?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.orderCheck();">순서변경</button>
	<?php endif?>
	<?php if($N):?>
	<!--
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.deleteCheck(1,'');">선택삭제</button>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.deleteCheck(2,'');">전체삭제</button>
	-->
	<?php endif?>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
</div>
	
<script language="javascript">
function playVod(vod,src)
{
	getId('vod_'+vod).innerHTML = '<iframe width="175" height="98" src="http://www.youtube.com/embed/' + src + '/?autoplay=1&autohide=1&rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>';
}
var isGetVod = false;
function getVodPreview()
{
	if (getId('_vod_embed_code_').value.indexOf('<iframe') == -1)
	{
		alert('유투브 iframe 소스를 입력해주세요.   ');
		getId('_vod_embed_code_').focus();
		return false;
	}
	var gx1 = getId('_vod_embed_code_').value.split('src="');
	var gx2 = gx1[1].split('"');

	getId('_vod_play_layer_').innerHTML = '<iframe width="90%" src="'+gx2[0]+'" frameborder="0" allowfullscreen style="margin:15px;"></iframe>';
	isGetVod = true;
}
function getVodSave()
{
	if (isGetVod == false)
	{
		alert('동영상을 불러온 후 저장해 주세요.   ');
		return false;
	}
	//if (confirm('정말로 저장하시겠습니까?    '))
	//{
		var f = document._upload_form1_;
		f.submit();
	//}
	return false;
}
function vodAdd()
{
	location.href = '<?php echo $g['base_href']?>&outlink=Y';
}
function getFiles()
{
	for (var i = 0; i < parent.getId('_modal_footer_modal_window').children.length; i++)
	{
		parent.getId('_modal_footer_modal_window').children[i].disabled = true;
	}
	getId('progressBar').style.display = 'block';

	var f = document._upload_form_;
	f.submit();
}
function gridProgress()
{
	setTimeout("location.reload();",1000);
}
function deleteCheck(x,uid)
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	var j = 0;
	var gx;
	for (i = 0; i < n; i++)
	{
		if (x == 0)
		{
			gx = l[i].value.split('|');
			if (uid != parseInt(gx[0])) l[i].checked = false;
			else l[i].checked = true;
		}
		if (x == 2) l[i].checked = true;
		if (l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('삭제할 동영상을 선택해 주세요.');
		return false;
	}
	if (confirm('정말로 삭제하시겠습니까?'))
	{
		f.a.value = 'files_delete';
		f.submit();
	}
	return false;
}
function orderCheck()
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	if (confirm('정말로 변경하시겠습니까?'))
	{
		for (i = 0; i < n; i++)
		{
			l[i].checked = true;
		}
		f.a.value = 'files_order';
		f.submit();
	}
	return false;
}
function infoCheck()
{
	var f = document.captionForm;
	f.submit();
}
function photoCheck(uid)
{

}
function templateCheck()
{
	var ifr = frames._template_iframe_;

	if(ifr.select_tpl == '')
	{
		alert('적용할 템플릿을 선택해 주세요.   ');
		return false;
	}

	if (ifr.select_tpl == '__tpl__all')
	{
		var table = '';
		var stable = ifr.document.getElementById(ifr.select_tpl).innerHTML;
		var _stable = stable;
		var _stable1 = '';
		var f = document.photolistForm;
		var l = document.getElementsByName('photomembers[]');
		var n = l.length;
		var i;

		for (i = 0; i < n; i++)
		{
			val = l[i].value.split('|');
			_stable = stable.replace('[VOD]',getId('vodsrc_'+val[0]).innerHTML).replace('[CAPTION]',getId('caption_'+val[0]).innerHTML);
			_stable1 += _stable;
		}
		table = _stable1;
	}
	else {

		var table = ifr.document.getElementById(ifr.select_tpl).innerHTML;
		var f = document.photolistForm;
		var l = document.getElementsByName('photomembers[]');
		var n = l.length;
		var i;
		var j = 0;
		var val;

		for (i = 0; i < n; i++)
		{
			if(l[i].checked == true)
			{
				val = l[i].value.split('|');
				table = table.replace('[VOD-'+j+']',getId('vodsrc_'+val[0]).innerHTML);
				table = table.replace('[CAPTION-'+j+']',getId('caption_'+val[0]).innerHTML);
				j++;
			}
		}

		if(!j)
		{
			alert('적용할 동영상을 선택해 주세요.   ');
			return false;
		}
	}

	parent.CKEDITOR.instances['ckeditor_textarea'].insertHtml(table);
	parent.$('#modal_window').modal('hide');

}
function modalSetting()
{
	//parent.getId('modal_window_dialog_modal_window').style.width = (parent.innerWidth-100)+'px'; //모달창 가로폭
	//parent.getId('_modal_iframe_modal_window').style.height = (parent.innerHeight-280)+'px'; //높이(px)

	parent.getId('modal_window_dialog_modal_window').style.position = 'absolute';
	parent.getId('modal_window_dialog_modal_window').style.display = 'block';
	parent.getId('modal_window_dialog_modal_window').style.width = '97%';
	parent.getId('modal_window_dialog_modal_window').style.top = '0';
	parent.getId('modal_window_dialog_modal_window').style.left = '0';
	parent.getId('modal_window_dialog_modal_window').style.right = '0';
	parent.getId('modal_window_dialog_modal_window').style.bottom = '0';
	parent.getId('modal_window_dialog_modal_window').children[0].style.height = '100%';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_header_modal_window').style.height = '57px';

	parent.getId('_modal_body_modal_window').style.position = 'absolute';
	parent.getId('_modal_body_modal_window').style.display = 'block';
	parent.getId('_modal_body_modal_window').style.paddingRight = '2px';
	parent.getId('_modal_body_modal_window').style.top = '50px';
	parent.getId('_modal_body_modal_window').style.left = '0';
	parent.getId('_modal_body_modal_window').style.right = '0';
	parent.getId('_modal_body_modal_window').style.bottom = '15px';

	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
	parent.getId('_modal_footer_modal_window').style.position = 'absolute';
	parent.getId('_modal_footer_modal_window').style.background = '#fff';
	parent.getId('_modal_footer_modal_window').style.width = '100%';
	parent.getId('_modal_footer_modal_window').style.bottom = '0';

	parent.getId('_modal_iframe_modal_window').style.overflow = 'hidden';
	parent.getId('_modal_iframe_modal_window').scrolling = 'no';

	parent.getId('_modal_header_modal_window').style.background = '#3F424B';
	parent.getId('_modal_header_modal_window').style.color = '#fff';
}
modalSetting();
$('.selectpicker').selectpicker();
</script>

<!----------------------------------------------------------------------------
//부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->



<style>
<?php $_isIE = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')||strpos($_SERVER['HTTP_USER_AGENT'],'rv:1')?true:false?>

#photobox {position:absolute;display:block;top:15px;left:0;bottom:0;right:<?php echo $N?290:0?>px;overflow:hidden;}
#photobox .photo-box {position:absolute;display:block;top:42px;left:0;bottom:0;right:0;overflow-x:hidden;overflow-y:auto;}
#photobox .alert {margin-right:<?php echo $outlink=='Y'?'305':'15'?>px;}

#photoorder {padding:0 0 10px 0;}
#photoorder .rb-photo-check {position:absolute;margin-left:5px;}
#photoorder li {float:left;list-style-type:none;border:#dfdfdf solid 3px;padding:0;margin:0 9px 20px 10px;}
#photoorder .selected {border:#FC5F4A solid 3px;}
#photoorder li .photo {width:170px;height:98px;cursor:move;}
#photoorder li .btn-group {display:none;}
#photoorder li:hover .btn-group {display:block;position:absolute;}
#photoorder li:hover .btn-group button {top:-34px;}

#infobox {position:absolute;display:block;width:290px;top:15px;right:0;bottom:0;overflow:hidden;}
#infobox .infobox-body {display:block;width:100%;height:100%;border-left:#dfdfdf solid 1px;overflow:hidden;}
#infobox .infobox-body .pic-info {position:absolute;display:block;width:100%;top:42px;bottom:<?php echo $_isIE?'95px':'55px'?>;overflow-x:hidden;overflow-y:auto;}
#infobox .infobox-body .pic-info img {padding:15px 15px 0 15px;}
#infobox .infobox-body .pic-submit {position:absolute;display:block;width:100%;bottom:<?php echo $_isIE?'40px':'0'?>;border-top:#dfdfdf solid 1px;padding:10px 15px 10px 15px;}

#infobox .infobox-body .pic-info1 {position:absolute;display:block;width:100%;top:42px;bottom:<?php echo $_isIE?'132px':'92px'?>;overflow-x:hidden;overflow-y:auto;}
#infobox .infobox-body .pic-submit1 {position:absolute;display:block;width:100%;bottom:<?php echo $_isIE?'40px':'0'?>;border-top:#dfdfdf solid 1px;padding:10px 15px 10px 15px;}

#infobox .text-center .btn {width:100%;}

#infobox .layoutbox-body {display:block;width:100%;height:100%;border-left:#dfdfdf solid 1px;overflow:hidden;}
#infobox .layoutbox-body .selectbox {position:absolute;display:block;width:100%;left:0;right:0;padding:10px 15px 0 15px;}
#infobox .layoutbox-body .iframebox {position:absolute;display:block;width:100%;top:95px;bottom:<?php echo $_isIE?'105px':'55px'?>;padding:0 0 0 15px;overflow:hidden;border-top:#dfdfdf solid 1px;}
#infobox .layoutbox-body .optionbox {position:absolute;display:block;width:100%;padding:1px 15px 10px 15px;bottom:<?php echo $_isIE?'40px':'0'?>;border-top:#dfdfdf solid 1px;}
#infobox .layoutbox-body .optionbox .text-center {border-top:0; padding-top:10px;padding-bottom:0;}

#progressBar {display:none;margin-right:15px;}
#progressPer {}
</style>