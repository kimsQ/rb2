<?php
$step_start = 1;
$pwd_start = $g['path_widget'];
$g['adm_href'] = $g['s']."/?r=".$r."&amp;system=".$system."&amp;iframe=".$iframe.($dropfield?"&amp;dropfield=".$dropfield:'').($option?"&amp;option=".$option:'').($isWcode?"&amp;isWcode=".$isWcode:'').($isEdit?"&amp;isEdit=".$isEdit:'');

if ($option)
{
	$wdgvar=array();
	//$swval=explode(',',getKRtoUTF(urldecode(str_replace('[!]','&',$option))));
	$swval=explode(',',urldecode(str_replace('[!]','&',$option)));
	$swidget=$swval[0];
	$pwd = $pwd_start.$swidget.'/';

	foreach($swval as $_cval)
	{
		$_xval=explode('^',$_cval);
		$wdgvar[$_xval[0]]=$_xval[1];
	}
}
else {
	$pwd = $pwd ? urldecode($pwd) : $pwd_start;
	$swidget = is_file($pwd.'main.php') ? str_replace($g['path_widget'],'',$pwd) : '';
	if ($swidget) $swidget = substr($swidget,0,strlen($swidget)-1);
}


if (strstr($pwd,'..'))
{
  getLink('','','정상적인 접근이 아닙니다.','close');
}
if(!is_dir($pwd))
{
	getLink('','','존재하지 않는 폴더입니다.','close');
}

function getDirexists($dir)
{
    $opendir = opendir($dir);
    while(false !== ($file = readdir($opendir)))
	{
        if(is_dir($dir.'/'.$file) && !strstr('[.][..][images][data]',$file)){$fex = 1; break;}
    }
    closedir($opendir);
    return $fex;
}
function getPrintdir( $nTab, $filepath, $files, $state ,$dir_ex)
{
    global $g,$pwd,$file,$step_start;

    if($step_start) { $nTab = $nTab - $step_start; }
	$css = strstr($pwd,$filepath) ? ' active' : '';
	$fname1 = getKRtoUTF($files);
	$fname2 = getFolderName($filepath);

    echo '<a href="'.$g['adm_href'].'&amp;pwd='.urlencode($filepath).'" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center';
    if($state && $dir_ex) {
		echo '"><span><i class="fa fa-folder-o"></i>&nbsp; ';
    }
    else if (!$state && $dir_ex) {
		echo '"><span><i class="fa fa-folder-open-o"></i>&nbsp; ';
    }
    else {
		echo $css.'" style="color:#'.($css?'fff':'999').'"><span class="pl-3"<i class="fa fa-puzzle-piece"></i>&nbsp; ';
    }
	echo $fname2.'</span></a>';
}
function getDirlist($dirpath,$nStep)
{
    global $pwd;
    $arrPath = explode('/', $pwd );

    if( $dir_handle = opendir($dirpath) )
    {
        while( false !== ($files = readdir($dir_handle)) )
        {
            $subDir = $dirpath.$files.'/';
            if(is_dir($subDir) && !strstr('[.][..][images][data]',$files))
            {
                getPrintdir( $nStep, $subDir, $files, !strstr($pwd,$subDir) , getDirexists($subDir) );
                if( $arrPath[$nStep+1] == $files ) {
                    getDirlist( $subDir, $nStep+1);
                }
            }
        }
    }
    closedir( $dir_handle );
}
function getWidgetPreviewImg($path)
{
	if (is_file($path.'.jpg')) return $path.'.jpg';
	if (is_file($path.'.gif')) return $path.'.gif';
	if (is_file($path.'.png')) return $path.'.png';
	return false;
}
?>

<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">

<div id="widgetbox">
	<div class="category bg-light">
		<?php getDirlist($pwd_start,$step_start)?>
	</div>
	<div class="content">
		<?php if($swidget):?>
		<?php if($option):?>
		<input type="hidden" id="s_w" value="">
		<input type="hidden" id="s_h" value="">
		<input type="hidden" id="s_t" value="">
		<input type="hidden" id="s_l" value="">
		<?php endif?>

		<div class="position-relative">
			<ul class="nav nav-tabs f14" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#code" role="tab" data-toggle="tab">설정하기</a></li>
				<li class="nav-item"><a class="nav-link" href="#preview" role="tab" data-toggle="tab">미리보기</a></li>
				<li class="nav-item"><a class="nav-link" href="#readme" role="tab" data-toggle="tab">사용안내</a></li>
			</ul>
			<?php if($isWcode=='Y'):?>
			<div class="js-del">
				<a class="btn btn-link muted-link btn-sm" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;a=deletewidget&amp;pwd=<?php echo $pwd?>" title="삭제" data-tooltip="tooltip" data-placement="left" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">
					<i class="fa fa-trash-o fa-fw"></i>
				</a>
			</div>
			<?php endif?>
		</div><!-- /.position-relative -->

		<div class="tab-content p-3">
			<div class="tab-pane active f14" id="code">
				<?php include $g['path_widget'].$swidget.'/admin.php' ?>
			</div>
			<div class="tab-pane" id="preview">
				<?php $_widgetPreview=getWidgetPreviewImg($g['path_widget'].$swidget.'/thumb')?>
				<?php if($_widgetPreview):?>
					<div class="text-center mt-4">
							<a href="<?php echo $_widgetPreview?>" target="_blank">
								<img src="<?php echo $_widgetPreview?>" class="img-fluid" alt="">
							</a>
					</div>

				<?php else:?>
				<div class="none">
					<i class="fa fa-puzzle-piece fa-5x"></i><br><br>
					미리보기가 없습니다.
				</div>
				<?php endif?>
			</div>

			<div class="tab-pane" id="readme">
				<div class="bg-light text-center text-muted f12 rounded border p-2">
					위젯파일 경로:  <span class="ml-2"><?php echo $g['path_widget'].$swidget ?>/main.php</span>
				</div>
				<?php $markdown_readme = $g['path_widget'].$swidget.'/README.md';?>
				<?php if (file_exists($markdown_readme)): ?>
				<div class="pb-5 readme">
					<?php readfile($g['path_widget'].$swidget.'/README.md')?>
				</div>
				<?php else: ?>
					<div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 5.53rem);">
						<div class="text-muted text-center">
							<h1><i class="fa fa-file-text-o" aria-hidden="true"></i></h1>
						  <small>안내문서가 없습니다.</small>
						</div>
					</div>
				<?php endif; ?>

			</div>

		</div>

		<?php else:?>
		<div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 5.53rem);">
			<div class="text-muted text-center">
				<h1><i class="fa fa-mouse-pointer" aria-hidden="true"></i></h1>
			  <small>추가할 위젯을 선택하세요.</small>
			</div>
		</div>
		<?php endif?>
		<textarea id="rb-widget-code-result" class="hidden"></textarea>
	</div>
</div>


<!-- @부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->

<div id="_modal_header" hidden>
	<h5 class="modal-title">
		<i class="kf-widget kf-lg"></i>
		위젯 선택하기
	</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div id="_modal_footer" hidden>
	<button type="button" class="btn btn-light pull-left" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
	<?php if(!$isWcode||$isEdit):?>
	<?php if($isCodeOnly):?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window._widgetCode();modalSetting('.rb-modal-x','<?php echo getModalLink('site/pages/popup.widget.code')?>');" data-toggle="modal" data-target=".rb-modal-x"<?php if(!$swidget):?> disabled<?php endif?>>
		<i class="fa fa-code fa-lg"></i> 코드보기
	</a>
	<button type="button" class="btn btn-light" disabled>위젯코드만 지원</button>
	<?php else:?>
	<button type="button" class="btn btn-light" onclick="frames._modal_iframe_modal_window._widgetCode();modalSetting('.rb-modal-x','<?php echo getModalLink('site/pages/popup.widget.code')?>');" data-toggle="modal" data-target=".rb-modal-x"<?php if(!$swidget):?> disabled<?php endif?>>
		<i class="fa fa-code fa-lg"></i> 코드보기
	</a>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window._saveCheck(<?php echo $isEdit?1:0?>);"<?php if(!$swidget):?> disabled<?php endif?>>삽입하기</button>
	<?php endif?>
	<?php else:?>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window._widgetCode();modalSetting('.rb-modal-x','<?php echo getModalLink('site/pages/popup.widget.code')?>');" data-toggle="modal" data-target=".rb-modal-x"<?php if(!$swidget):?> disabled<?php endif?>>
		<i class="fa fa-code fa-lg"></i> 코드보기
	</a>
	<?php endif?>
</div>


<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<script>

$("#readme .readme").markdown();

function _widgetCode()
{
	getId('rb-widget-code-result').innerHTML = widgetCode(0);
}
function _saveCheck(n)
{
	saveCheck(n);
	parent.$('#modal_window').modal('hide');
}
function dropJoint(m)
{
	var f = opener.getId('<?php echo $dropfield?>');
	f.value = m;
	f.focus();
	top.close();
}

<?php if($swidget && $option):?>
var dp = <?php echo $dropfield?>;
var sz = parent.moveObject[dp];
getId('s_w').value = parseInt(sz.style.width);
getId('s_h').value = parseInt(sz.style.height);
getId('s_t').value = parseInt(sz.style.top);
getId('s_l').value = parseInt(sz.style.left);
<?php endif?>

function modalSetting(){
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '580px';
	parent.getId('_modal_body_modal_window').style.height = '580px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}

modalSetting();


</script>
