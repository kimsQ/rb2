<?php
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
	$PHOTOS = getDbArray($table['s_upload'],"tmpcode='".$sescode."' and fileonly=1",'*','pid','asc',0,0);
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
?>

<?php getImport('bootstrap-select','bootstrap-select',false,'css')?>
<?php getImport('bootstrap-select','bootstrap-select',false,'js')?>


<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_upload_iframe_">
<input type="hidden" name="r" value="<?php echo $r?>">
<input type="hidden" name="m" value="<?php echo $m?>">
<input type="hidden" name="a" value="upload">
<input type="hidden" name="saveDir" value="<?php echo $g['path_file']?>">
<input type="hidden" name="gparam" value="<?php echo $gparam?>">
<input type="hidden" name="fileonly" value="Y">

<input name="upfiles[]" type="file" multiple="true" accept="image/*" id="filefiled" class="hidden" onchange="getFiles();" />
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
			<?php foreach($P as $val):?>
			<li<?php if($file_uid==$val['uid']):?> class="selected"<?php endif?>>
				<table>
				<tr>
				<td width="30"><input type="checkbox" class="rb-photo-check" name="photomembers[]" value="<?php echo $val['uid']?>|<?php echo $val['url'].$val['folder'].'/'.$val['tmpname']?>|<?php echo $val['name']?>|"></td>
				<td width="30"><img src="<?php echo $g['img_core']?>/file/small/<?php echo $val['ext']?>.gif" alt=""></td>
				<td><?php echo $val['name']?></td>
				<td width="100" style="color:#c0c0c0;font-family:arial;font-size:11px;"><?php echo $val['ext']?></td>
				<td width="100" style="color:#c0c0c0;font-family:arial;font-size:11px;text-align:center;"><?php echo getSizeFormat($val['size'],1)?></td>
				</tr>
				</table>
			</li>
			<?php endforeach?>
		</ul>
		</form>
		<?php else:?>
		<div class="none">
		<!--div class="ment">
			<span><?php echo getSizeFormat($d['mediaset']['limitsize'],0)?>,<?php echo $d['mediaset']['limitnum']?>개</span>까지 올릴 수 있습니다.
			<br>
			<button type="button" class="btn btn-default" onclick="getId('filefiled').click();">사진추가</button>
		</div-->
		</div>
		<?php endif?>
	</div>
</div>








<!----------------------------------------------------------------------------
@부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->

<div id="_modal_header" class="hidden">
    <button type="button" class="close rb-close-white" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="fa fa-picture-o fa-lg"></i> 파일올리기</h4>
</div>

<div id="_modal_footer" class="hidden">
	<button type="button" class="btn btn-primary pull-left" onclick="frames._modal_iframe_modal_window.getId('filefiled').click();">파일추가</button>
	<?php if($N>1):?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.orderCheck();">순서변경</button>
	<?php endif?>
	<?php if($N):?>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.deleteCheck(1);">선택삭제</button>
	<button type="button" class="btn btn-default pull-left" onclick="frames._modal_iframe_modal_window.deleteCheck(2);">전체삭제</button>
	<?php endif?>
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">첨부</button>
</div>
	
<script language="javascript">
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
function deleteCheck(x)
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	var j = 0;
	for (i = 0; i < n; i++)
	{
		if (x == 2) l[i].checked = true;
		if (l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('삭제할 사진을 선택해 주세요.');
		return false;
	}
	if (confirm('정말로 삭제하시겠습니까?'))
	{
		f.a.value = 'files_delete_file';
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
	getId('captioncontent').value = getId('caption_'+uid).innerHTML;
}
function modalSetting()
{
	//parent.getId('modal_window_dialog_modal_window').style.width = (parent.innerWidth-100)+'px'; //모달창 가로폭
	parent.getId('_modal_iframe_modal_window').style.height = '450px'; //높이(px)

/*
	parent.getId('modal_window_dialog_modal_window').style.position = 'absolute';
	parent.getId('modal_window_dialog_modal_window').style.display = 'block';
	parent.getId('modal_window_dialog_modal_window').style.width = '97%';
	parent.getId('modal_window_dialog_modal_window').style.top = '0';
	parent.getId('modal_window_dialog_modal_window').style.left = '0';
	parent.getId('modal_window_dialog_modal_window').style.right = '0';
	parent.getId('modal_window_dialog_modal_window').style.bottom = '0';
	parent.getId('modal_window_dialog_modal_window').children[0].style.height = '100%';
*/
	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_header_modal_window').style.background = '#3F424B';
	parent.getId('_modal_header_modal_window').style.color = '#fff';

/*
	parent.getId('_modal_body_modal_window').style.position = 'absolute';
	parent.getId('_modal_body_modal_window').style.display = 'block';
	parent.getId('_modal_body_modal_window').style.paddingRight = '2px';
	parent.getId('_modal_body_modal_window').style.top = '50px';
	parent.getId('_modal_body_modal_window').style.left = '0';
	parent.getId('_modal_body_modal_window').style.right = '0';
	parent.getId('_modal_body_modal_window').style.bottom = '15px';
*/
	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
/*
	parent.getId('_modal_footer_modal_window').style.position = 'absolute';
	parent.getId('_modal_footer_modal_window').style.background = '#fff';
	parent.getId('_modal_footer_modal_window').style.width = '100%';
	parent.getId('_modal_footer_modal_window').style.bottom = '0';

	parent.getId('_modal_iframe_modal_window').style.overflow = 'hidden';
	parent.getId('_modal_iframe_modal_window').scrolling = 'no';
*/
}
modalSetting();
$('.selectpicker').selectpicker();
</script>

<!----------------------------------------------------------------------------
//부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴
----------------------------------------------------------------------------->



<style>

#photobox {position:absolute;display:block;top:0;left:0;bottom:0;right:0px;overflow:hidden;height:450px;}
#photobox .photo-box {position:absolute;display:block;top:22px;left:0;bottom:0;right:0;overflow-x:hidden;overflow-y:auto;}

#photoorder {padding:0;border-top:#efefef solid 1px;}
#photoorder .rb-photo-check {}
#photoorder li {list-style-type:none;}
#photoorder li table {width:100%;border-bottom:#efefef solid 1px;}

#progressBar {display:none;margin-right:15px;}
#progressPer {}
</style>