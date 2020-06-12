<?php
if (!$my['uid']) exit;

$S = 0;
$N = 0;
$P = array();

if ($dfiles)
{
	$ufilesArray = getArrayString($dfiles);
	foreach($ufilesArray['data'] as $_val)
	{
		$R = getUidData($table['s_upload'],$_val);
		if ($R['mbruid'] != $my['uid'] || ($R['type']!=-1 && $R['type']!=2)) continue;
		$P[] = $R;
		$S += $R['size'];
		$N++;
	}
	$NUM = $N;
	$TPG = 1;
}
else {
	$sort	= $sort ? $sort : 'pid';
	$orderby= $orderby ? $orderby : 'asc';
	$recnum	= 50;
	$_WHERE = 'site='.$s.' and mbruid='.$my['uid'].' and (type=-1 or type=2) and fileonly=0';
	if ($album)
	{
		$_album = $album;
		if ($album == 'none') $_album = 0;
		if ($album == 'trash') $_album = -1;
		$_WHERE .= ' and category='.$_album;
	}
	if ($where && $keyw)
	{
		if (strstr('[mbruid]',$where)) $_WHERE .= " and ".$where."='".$keyw."'";
		else $_WHERE .= getSearchSql($where,$keyw,$ikeyword,'or');
	}
	$RCD = getDbArray($table['s_upload'],$_WHERE,'*',$sort,$orderby,$recnum,$p);
	$NUM = getDbRows($table['s_upload'],$_WHERE);
	$TPG = getTotalPage($NUM,$recnum);

	while($R = db_fetch_array($RCD))
	{
		$P[] = $R;
		$S += $R['size'];
		$N++;
	}
}

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

$g['base_href'] = $g['s'].'/?r='.$r.'&m='.$m.'&iframe=Y&mdfile='.$mdfile.'&dropfield='.$dropfield.'&dropfiles='.$dropfiles.'&dfiles='.$dfiles;
?>


<style>
<?php $_gapAdj = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')||strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')||strpos($_SERVER['HTTP_USER_AGENT'],'rv:1')?true:false?>
#rb-body {
  background-color: inherit;
}

#photobox {
  position: absolute;
  display: block;
  top: 0;
  left: 0;
  bottom: 42px;
  right: 0;
  overflow: hidden;
}

#photobox .category-box {
  position: absolute;
  display: block;
  top: 0;
  left: 0;
  bottom: 0;
  width: <?php echo $dfiles?'0px': '195px'?>;
  overflow-x: hidden;
  overflow-y: auto;
}

#photobox .photo-box {
  position: absolute;
  display: block;
  top: 0;
  left: <?php echo $dfiles?'0px': '210px'?>;
  bottom: 0;
  right: 0;
  overflow-x: hidden;
  overflow-y: auto;
}
#photobox .photo-box.sideOpen {
  right: 355px;
}
#photobox .btn-toolbar {
  position: relative;
  top: -15px;
  left: 15px;
  margin-right: 40px;
}

#photoorder {
	margin-bottom: 0;
  padding: 0;
}

#photoorder .rb-photo-check {
  position: absolute;
	margin-top: 5px;
  margin-left: 5px;
}

#photoorder li {
	position: relative;
  float: left;
  list-style-type: none;
  border: #ddd solid 1px;
  padding: 0;
  margin: 0 5px 20px 5px;
	overflow: hidden;
}

#photoorder .selected::before {
    border: 5px solid #007bff;
    content: "";
    position: absolute;
    top: -1px;
    bottom: -1px;
    left: -1px;
    right: -1px;
}

#photoorder li .photo {
  width: 100px;
  height: 67px;
  cursor: pointer;
	background-size: cover;
	background-position: center center;
	background-repeat: no-repeat;
}

#photoorder li .btn-group {
	position: absolute;
	bottom: -25px;
	width: 100%
}
#photoorder li:hover .btn-group {
  display: block;
	bottom:0;
	-webkit-transition: all 0.2s linear;
	-moz-transition: all 0.2s linear;
	-o-transition: all 0.2s linear;
	transition: all 0.2s linear;
	background-color: rgba(0, 0, 0, 0.8);
}

#photoorder li .btn-group-sm>.btn {
  padding: .15rem .4rem;
  font-size: 0.575rem;
  line-height: 1.5;
  border-radius: .2rem;
	background-color: transparent;
	color: #fff;
}


#infobox {
  position: absolute;
  display: block;
  width: 320px;
  top: 0;
  right: 15px;
  bottom: 50px;
  overflow: hidden;
}

#infobox .card-img-overlay .btn {
	position: absolute;
	top: 180px;
	right: 0;
	background-color: rgba(0, 0, 0, 0.7);
	border-radius: 0;
	color: #ccc;
	font-size: 12px
}
#infobox .card-img-overlay .btn:hover {
	text-decoration: none;
	color: #fff;
}
#infobox .infobox-body {
	overflow-y: auto;
	position: absolute;
  top: 212px;
	bottom: 0;
}

#infobox .layoutbox-body {
  display: block;
  width: 100%;
  height: 100%;
  border-left: #dfdfdf solid 1px;
  overflow: hidden;
}

#infobox .layoutbox-body .selectbox {
  position: absolute;
  display: block;
  width: 100%;
  left: 0;
  right: 0;
  padding: 10px 15px 0 15px;
}

#infobox .layoutbox-body .iframebox {
  position: absolute;
  display: block;
  width: 100%;
  top: 95px;
  bottom: <?php echo $_gapAdj?'105px': '55px'?>;
  padding: 0 0 0 15px;
  overflow: hidden;
  border-top: #dfdfdf solid 1px;
}

#infobox .layoutbox-body .optionbox {
  position: absolute;
  display: block;
  width: 100%;
  padding: 1px 15px 10px 15px;
  bottom: <?php echo $_gapAdj?'40px': '0'?>;
  border-top: #dfdfdf solid 1px;
}

#infobox .layoutbox-body .optionbox .text-center {
  border-top: 0;
  padding-top: 10px;
  padding-bottom: 0;
}

#progressBar {
  display: none;
  margin-right: 15px;
}

.rb-list-group a {
  padding: 8px 5px 3px 7px;
}

.rb-list-group a span {
  font-weight: normal;
}

.rb-data-none {
  height: 88%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: #9a9eac;
}

#_pic_play_layer_ {
	height: 165px;
	background-color: #eee
}

</style>

<form name="_upload_form_" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_upload_iframe_">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $m?>">
	<input type="hidden" name="a" value="mediaset/upload">
	<input type="hidden" name="saveDir" value="<?php echo $g['path_file']?>mediaset/">
	<input type="hidden" name="gparam" value="<?php echo $gparam?>">
	<input type="hidden" name="category" value="<?php echo $_album?>">
	<input type="hidden" name="mediaset" value="Y">
	<input type="hidden" name="ablum_type" value="1">

	<input name="upfiles[]" type="file" accept="image/*" id="filefiled" class="d-none" onchange="getFiles();">
</form>

<iframe name="_upload_iframe_" width="1" height="1" frameborder="0" scrolling="no"></iframe>

<div id="photobox">
	<?php if(!$dfiles):?>
	<div class="category-box">

		<div class="list-group">
			<a href="<?php echo $g['base_href']?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2<?php if(!$album):?> active<?php endif?>">전체사진<span class="badge"><?php echo getDbCnt($table['s_uploadcat'],'sum(r_num)','mbruid='.$my['uid'].' and type=1')?></span></a>
			<a href="<?php echo $g['base_href']?>&album=none" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2<?php if($album=='none'):?> active<?php endif?>">미카테고리<span class="badge"><?php echo getDbCnt($table['s_uploadcat'],'sum(r_num)','mbruid='.$my['uid']." and type=1 and name='none'")?></span></a>

			<?php $_TMP_CT=array()?>
			<?php $_CT_RCD = getDbArray($table['s_uploadcat'],'mbruid='.$my['uid']." and type=1 and name<>'none' and name<>'trash'",'*','gid','asc',0,1)?>
			<?php while($_CT=db_fetch_array($_CT_RCD)):$_TMP_CT[]=$_CT?>
			<a href="<?php echo $g['base_href']?>&album=<?php echo $_CT['uid']?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2<?php if($album==$_CT['uid']):?> active<?php endif?>"><?php echo $_CT['name']?><span class="badge"><?php echo $_CT['r_num']?></span></a></li>
			<?php endwhile?>

			<a href="<?php echo $g['base_href']?>&album=trash" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2<?php if($album=='trash'):?> active<?php endif?>">휴지통<span class="badge"><?php echo getDbCnt($table['s_uploadcat'],'sum(r_num)','mbruid='.$my['uid']." and type=1 and name='trash'")?></span></a>
		</div>
		<div class="my-3">
			<form action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_" onsubmit="return AddAlbumRcheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="mediaset/category_add">
			<input type="hidden" name="ablum_type" value="1">
			<div class="input-group">
				<input type="text" name="name" class="form-control" placeholder="추가할 카테고리">
				<span class="input-group-append">
					<button type="submit" class="btn btn-outline-secondary">추가</button>
				</span>
			</div>
			</form>
		</div>
	</div>
	<?php endif?>

	<div class="photo-box<?php echo $file_uid || $outlink=='Y'?' sideOpen':''?>">

		<div id="progressBar" class="progress progress-striped active">
		  <div id="progressPer" class="progress-bar progress-bar-danger" role="progressbar"></div>
		</div>

		<?php if($NUM):?>
		<?php if(!$dfiles):?>
		<div class="d-flex mb-3">
			<div class="btn-group btn-group-sm mr-auto">
				<button type="button" class="btn btn-light" title="전체선택" data-toggle="tooltip" data-placement="top" onclick="elementsCheck('photomembers[]','true');"><i class="fa fa-check-square-o"></i></button>
				<button type="button" class="btn btn-light" title="선택해제" data-toggle="tooltip" data-placement="top" onclick="elementsCheck('photomembers[]','false');"><i class="fa fa-minus-square-o"></i></button>
				<button type="button" class="btn btn-light"title="휴지통" data-toggle="tooltip" data-placement="top" onclick="deleteCheck(1,'');"><i class="fa fa-trash-o"></i></button>

				<div class="btn-group btn-group-sm">
					<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-folder-o fa-fw"></i> 옮기기
					<span class="caret"></span>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="#." onclick="deleteCheck('move','0');"><i class="fa fa-folder-o fa-fw"></i> 미카테고리</a>
						<?php foreach($_TMP_CT as $_CT):?>
						<a class="dropdown-item" href="#." onclick="deleteCheck('move','<?php echo $_CT['uid']?>');"><i class="fa fa-folder-o fa-fw"></i> <?php echo $_CT['name']?></a>
						<?php endforeach?>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#." onclick="deleteCheck('delete','');"><i class="fa fa-times fa-fw"></i> 영구삭제</a>
					</div>
				</div>
			</div>

			<div class="btn-group btn-group-sm">
				<button type="button" class="btn btn-light"<?php if($p-1<1):?> disabled="disabled"<?php endif?> data-toggle="tooltip" data-placement="bottom" title="이전" onclick="location.href=getPageGo(<?php echo $p-1?>,0);"><i class="fa fa-angle-left fa-lg"></i></button>
				<button type="button" class="btn btn-light"<?php if($p+1>$TPG):?> disabled="disabled"<?php endif?> data-toggle="tooltip" data-placement="bottom" title="다음" onclick="location.href=getPageGo(<?php echo $p+1?>,0);"><i class="fa fa-angle-right fa-lg"></i></button>
			</div>

			<div class="btn-group btn-group-sm mx-2">
				<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"><?php echo number_format($NUM)?>개 <span class="badge badge-light"><?php echo $p?>/<?php echo sprintf('%s 페이지',$TPG)?></span></button>
				<div class="dropdown-menu" role="menu">
					<a class="dropdown-item<?php if($p==1):?> active<?php endif?>" href="#." onclick="location.href=getPageGo(1,0);">첫 페이지</a>
					<?php for($i=2;$i<$TPG;$i++):?>
					<a class="dropdown-item<?php if($p==$i):?> active<?php endif?>" href="#." onclick="location.href=getPageGo(<?php echo $i?>,0);"><?php echo sprintf('%s 페이지',$i)?></a>
					<?php endfor?>
					<?php if($TPG>1):?>
					<a class="dropdown-item<?php if($p==$TPG):?> active<?php endif?>" href="#." onclick="location.href=getPageGo(<?php echo $TPG?>,0);">마지막 페이지</a>
					<?php else:?>
					<a class="dropdown-item disabled" href="#">마지막 페이지</a>
					<?php endif?>
				</div>
			</div>
		</div>
		<?php endif?>

		<form name="photolistForm" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $m?>">
			<input type="hidden" name="a" value="">
			<input type="hidden" name="mediaset" value="Y">
			<input type="hidden" name="dtype" value="">
			<input type="hidden" name="mcat" value="">

			<ul id="photoorder" class="clearfix">
				<?php foreach($P as $val):$val['xurl']=$val['type']>0?($val['fserver']?$val['url'].$val['folder'].'/'.$val['tmpname']:(($g['s']=='/'?$g['s']:$g['s'].'/').'files/'.$val['folder'].'/'.$val['tmpname'])):$val['src']?>
				<li<?php if($file_uid==$val['uid']):?> class="selected"<?php endif?> click="location.href='<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&album=<?php echo $album?>';">
					<input type="checkbox" class="rb-photo-check" name="photomembers[]" value="<?php echo $val['uid']?>|<?php echo $val['xurl']?>|<?php echo $val['name']?>|<?php echo $val['linkto']?>|" onclick="photoCheck(<?php echo $val['uid']?>);"<?php if($dfiles):?> checked<?php endif?>>

					<span id="caption_<?php echo $val['uid']?>" class="hidden"><?php echo htmlspecialchars($val['caption'])?></span>
					<?php if($val['type']>0):?>
					<div class="photo"
						style="background-image:url('<?php echo getPreviewResize($val['src'],'t')?>');" onclick="location.href='<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&album=<?php echo $album?>';"></div>
					<?php else:?>
					<div title="외부링크" class="photo" data-toggle="tooltip"><img src="./_core/opensrc/timthumb/thumb.php?src=<?php echo $val['src'] ?>&w=100&h=67&s=1" onclick="location.href='<?php echo $g['base_href']?>&file_uid=<?php echo $val['uid']?>&tab=file_info&album=<?php echo $album?>';"></div>
					<?php endif?>
				</li>
				<?php endforeach?>
			</ul>
		</form>

		<?php else:?>
		<div class="rb-data-none text-center">
			<div class="">
				<div class="display-3"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></div>
					등록된 사진이 없습니다.
			</div>
		</div>
		<?php endif?>
	</div>
</div>

<?php if((($file_uid || $dropfield=='editor') && $NUM) || $outlink == 'Y'):$_sideOpen=true?>
<div id="infobox" class="card">

	<?php if($outlink=='Y'):?>
		<div class="card-header">
			외부사진 추가
		</div>

		<div id="_pic_play_layer_" class="card-img-top"></div>
		<div class="infobox-body card-body w-100 px-3">
			<div class="pic-info1">

				<form name="_upload_form1_" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
					<input type="hidden" name="r" value="<?php echo $r?>">
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="a" value="mediaset/upload">
					<input type="hidden" name="gparam" value="<?php echo $gparam?>">
					<input type="hidden" name="link" value="Y">
					<input type="hidden" name="category" value="<?php echo $_album?>">
					<input type="hidden" name="mediaset" value="Y">

				<div class="panel-body">
					<div class="form-group">
						<label>이미지주소 (URL)</label>
						<textarea name="src" id="_pic_embed_code_" class="form-control" rows="4" autofocus><?php echo $_R['src']?></textarea>
					</div>
				</div>
				</form>
			</div>
			<div class="pic-submit1">
				<div class="text-center">
					<button type="button" class="btn btn-light" onclick="getPicPreview();" style="margin-bottom:3px;">이미지 불러오기</button>
					<button type="button" class="btn btn-primary" onclick="getPicSave();">이미지 저장하기</button>
				</div>
			</div>
		</div>

		<?php else:?>
		<img alt="<?php echo $_R['name']?>" class="card-img-top" src="<?php echo $_R['type']>0?getPreviewResize($_R['src'],'n'):'./_core/opensrc/timthumb/thumb.php?src='.$_R['src'].'&w=320&h=213&s=1'?>">

		<div class="card-img-overlay">
			<button class="btn btn-link" type="button" onclick="window.open('<?php echo $_R['src']?>');">
				원본보기
			</button>
		</div>

		<?php if($tab == 'file_info'):?>
		<div class="infobox-body card-body p-3">
			<form name="captionForm" action="<?php echo $g['s']?>/" method="post" target="_upload_iframe_">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="<?php echo $m?>">
				<input type="hidden" name="a" value="mediaset/caption_regis">
				<input type="hidden" name="uid" value="<?php echo $_R['uid']?>">

				<?php if($_R['type']>0):?>
				<ul class="list-unstyled photo-info small">
					<li class="text-muted">등록일시 : <?php echo getDateFormat($_R['d_update']?$_R['d_update']:$_R['d_regis'],'Y.m.d H:i')?> </li>
					<li class="text-muted">사진크기 : <?php echo $_R['width']?> × <?php echo $_R['height']?></li>
					<li class="text-muted">파일용량 : <?php echo getSizeFormat($_R['size'],1)?></li>
					<li class="text-muted">파일종류 : <?php echo $_R['ext']?></li>
				</ul>
				<?php else:?>
				<ul class="list-unstyled photo-info small">
					<li class="text-muted">등록일시 : <?php echo getDateFormat($_R['d_update']?$_R['d_update']:$_R['d_regis'],'Y.m.d H:i')?></li>
					<li class="text-muted">사진출처 : <span class="text-danger"><?php echo getDomain($_R['src'])?></span></li>
					<li class="text-muted">파일종류 : <?php echo $_R['ext']?></li>
				</ul>
				<?php endif?>

				<div class="form-group">
					<label>파일명</label>
					<input type="text" class="form-control form-control-sm" name="name" value="<?php echo substr($_R['name'],0,strlen($_R['name'])-strlen($_R['ext'])-1)?>">
				</div>
				<div class="form-group">
					<label>Alt 값</label>
					<input type="text" class="form-control form-control-sm" name="alt" value="<?php echo $_R['alt']?>">
				</div>
				<?php if($_R['type']<0):?>
				<div class="form-group">
					<label>이미지 Url</label>
					<textarea class="form-control form-control-sm" name="src" rows="3"><?php echo $_R['src']?></textarea>
				</div>
				<?php endif?>
				<div class="form-group">
					<label>캡션</label>
					<textarea class="form-control form-control-sm" name="caption" rows="3"><?php echo $_R['caption']?></textarea>
				</div>
				<div class="form-group">
					<label>설명</label>
					<textarea class="form-control" name="description" rows="3"><?php echo $_R['description']?></textarea>
				</div>
				<div class="form-group">
					<label>다운로드 허용</label>
					<select name="hidden" class="form-control custom-select custom-select-sm">
					<option value="0"<?php if(!$_R['hidden']):?> selected<?php endif?>>예</option>
					<option value="1"<?php if($_R['hidden']):?> selected<?php endif?>>아니오</option>
					</select>
				</div>
				<div class="form-group">
					<label>링크</label>
					<select name="linkto" class="form-control custom-select custom-select-sm">
					<option value="0"<?php if(!$_R['linkto']):?> selected<?php endif?>>링크없음</option>
					<option value="1"<?php if($_R['linkto']==1):?> selected<?php endif?>>일반사진</option>
					<option value="2"<?php if($_R['linkto']==2):?> selected<?php endif?>>라이트박스</option>
					<option value="3"<?php if($_R['linkto']==3):?> selected<?php endif?>>미디어링크</option>
					</select>
				</div>
				<div class="form-group">
					<label>링크 주소</label>
					<input type="text" class="form-control form-control-sm" name="linkurl" value="<?php echo $_R['linkurl']?>" placeholder="http://를 포함해서 입력해 주세요.">
				</div>
				<div class="form-group">
					<label class="control-label">라이센스</label>
					<select name="license" class="form-control custom-select custom-select-sm">
						<option value="0"<?php if($_R['license']==0):?> selected<?php endif?>>None (All rights reserved)</option>
						<option value="1"<?php if($_R['license']==1):?> selected<?php endif?>>저작자표시-비영리-동일조건변경허락 Creative Commons</option>
						<option value="2"<?php if($_R['license']==2):?> selected<?php endif?>>저작자표시-비영리 Creative Commons</option>
						<option value="3"<?php if($_R['license']==3):?> selected<?php endif?>>저작자표시-비영리-변경금지 Creative Commons</option>
						<option value="4"<?php if($_R['license']==4):?> selected<?php endif?>>저작자표시 Creative Commons</option>
						<option value="5"<?php if($_R['license']==5):?> selected<?php endif?>>저작자표시-동일조건변경허락 Creative Commons</option>
						<option value="6"<?php if($_R['license']==6):?> selected<?php endif?>>저작자표시-변경금지 Creative Commons</option>
					</select>
				</div>
			</form>
			<div class="pic-submit">
				<div class="text-center">
					<button type="button" class="btn btn-outline-primary btn-block" onclick="infoCheck();">저장하기</button>
				</div>
			</div>
		</div>
		<?php else:?>



	<?php endif?>
	</div>
	<?php endif?>
</div><!-- /.card -->
<?php endif?>




<!-- @부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->

<div id="_modal_header" hidden>

	<ul class="nav nav-tabs border-bottom-0" style="margin-top: .1rem">
		<li class="nav-item">
			<a href="#" class="nav-link active">
				포토셋
			</a>
		</li>
		<?php if(!$dfiles && !$dropfield):?>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&iframe=Y&mdfile=modal.video.media&dropfield=<?php echo $dropfield?>&dropfiles=<?php echo $dropfiles?>" target="_modal_iframe_modal_window">
				비디오셋
			</a>
		</li>
		<?php endif?>
	</ul>

	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>

</div>

<div id="_modal_footer" hidden>
	<?php if(!$dfiles):?>
	<div class="">
		<button type="button" class="btn btn-light" <?php if($album!='trash'):?>onclick="frames._modal_iframe_modal_window.getId('filefiled').click();"<?php else:?>disabled<?php endif?>><i class="fa fa-cloud-upload fa-lg"></i> 내컴퓨터에서</button>
		<button type="button" class="btn btn-light" <?php if($album!='trash'):?>onclick="frames._modal_iframe_modal_window.picAdd();"<?php else:?>disabled<?php endif?>><i class="fa fa-link fa-lg"></i> 외부사진</button>

		<?php if($album>0):?>
		<button type="button" class="btn btn-danger" onclick="frames._modal_iframe_modal_window.catDelete();">카테고리 삭제</button>
		<?php endif?>
		<?php if($NUM>1):?>
		<?php if($album>0):?>
		<button type="button" class="btn btn-danger" onclick="frames._modal_iframe_modal_window.orderCheck();">순서변경</button>
		<?php endif?>
		<?php endif?>

		<?php if($NUM&&$album=='trash'):?>
		<button type="button" class="btn btn-danger" onclick="frames._modal_iframe_modal_window.deleteCheck(3,'');">휴지통 비우기</button>
		<?php endif?>

	</div>
	<?php endif?>

	<div class="">
		<button type="button" class="btn btn-light" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
		<?php if($dropfield&&$dropfield!='editor'):?>
		<button type="button" class="btn btn-danger" onclick="frames._modal_iframe_modal_window.fieldDrop();">적용하기</button>
		<?php endif?>
	</div>

</div>

<?php if($NUM>1&&$album>0):?>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/core.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/events.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/css.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/coordinates.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/drag.js"></script>
<script src="<?php echo $g['s']?>/_core/opensrc/tool-man/dragsort.js"></script>
<script>
var dragsort = ToolMan.dragsort();
dragsort.makeListSortable(getId("photoorder"));
</script>
<?php endif?>

<script>

$(function () {
	putCookieAlert('mediaset_result') // 실행결과 알림 메시지 출
  $('[data-toggle="tooltip"]').tooltip()
})

var isGetPic = false;
function getPicPreview()
{
	if (getId('_pic_embed_code_').value == '' || getId('_pic_embed_code_').value.indexOf('://') == -1)
	{
		alert('파일의 주소를 입력해주세요.   ');
		getId('_pic_embed_code_').focus();
		return false;
	}

	getId('_pic_play_layer_').innerHTML = '<img width="90%" src="'+getId('_pic_embed_code_').value+'" style="margin:15px 0 0 15px;">';
	isGetPic = true;
}
function getPicSave()
{
	if (isGetPic == false)
	{
		alert('이미지를 불러온 후 저장해 주세요.   ');
		return false;
	}
	var f = document._upload_form1_;
	f.submit();
	return false;
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
function picAdd()
{
	location.href = '<?php echo $g['base_href']?>&album=<?php echo $album?>&outlink=Y';
}
function gridProgress()
{
	setTimeout("location.reload();",1000);
}
function fieldDrop()
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	var j = 0;
	var s = '';
	var x;

	for (i = 0; i < n; i++)
	{
		if (l[i].checked == true)
		{
			j++;
			x = l[i].value.split('|');
			s += '['+x[0]+']';
		}
	}
	if (!j)
	{
		alert('사진을 선택해 주세요.  ');
		return false;
	}
	parent.getId('<?php echo $dropfield?>').value <?php if(!$dfiles):?>+<?php endif?>= s;
	parent.$('#modal_window').modal('hide');
}
function AddAlbumRcheck(f)
{
	if (f.name.value == '')
	{
		alert('카테고리명을 입력해 주세요.  ');
		f.name.focus();
		return false;
	}
	return true;
}
function catDelete()
{
	if (confirm('정말로 삭제하시겠습니까?   '))
	{
		var f = document._upload_form_;
		f.a.value = 'mediaset/category_delete';
		f.submit();
	}
	return false;
}
function deleteCheck(x,uid)
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
	var j = 0;

	if (x == 3)
	{
		if (confirm('정말로 휴지통을 비우시겠습니까?'))
		{
			f.a.value = 'mediaset/files_empty';
			f.submit();
		}
		return false;
	}

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

	if (x == 'move')
	{
		if (!j)
		{
			alert('이동할 사진을 선택해 주세요.');
			return false;
		}
		f.a.value = 'mediaset/files_delete';
		f.dtype.value = x;
		f.mcat.value = uid;
		f.submit();
	}
	else if (x == 'delete')
	{
		if (!j)
		{
			alert('영구삭제할 사진을 선택해 주세요.');
			return false;
		}
		if (confirm('정말로 삭제하시겠습니까?'))
		{
			f.a.value = 'mediaset/files_delete';
			f.dtype.value = x;
			f.submit();
		}
	}
	else {
		if (!j)
		{
			alert('삭제할 사진을 선택해 주세요.');
			return false;
		}
		if (confirm('휴지통으로 이동하시겠습니까?'))
		{
			f.a.value = 'mediaset/files_delete';
			f.submit();
		}
	}
	return false;
}
function orderCheck()
{
	var f = document.photolistForm;
    var l = document.getElementsByName('photomembers[]');
    var n = l.length;
    var i;
		for (i = 0; i < n; i++)
		{
			l[i].checked = true;
		}
		f.a.value = 'mediaset/files_order';
		f.submit();
}
function infoCheck()
{
	var f = document.captionForm;
	f.submit();
}
function photoCheck(uid)
{

}
function elementsCheck(members,flag)
{
    var l = document.getElementsByName(members);
    var n = l.length;
    var i;
    for (i = 0; i < n; i++)
	{
		if (flag == 'true')
		{
			l[i].checked = true;
		}
		else {
			l[i].checked = false;
		}
	}
	return false;
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
			_stable = stable.replace('[HREF]',val[1]).replace('[SRC]',val[1]).replace('[ALT]',val[2]).replace('[CAPTION]',getId('caption_'+val[0]).innerHTML);

			if (val[3] == '0')
			{
				_stable = _stable.replace('[A]','').replace('[/A]','');
			}
			if (val[3] == '1')
			{
				_stable = _stable.replace('[A]','<a href="'+val[1]+'" title="'+val[2]+'">').replace('[/A]','</a>');
			}
			if (val[3] == '2')
			{
				_stable = _stable.replace('[A]','<a href="'+val[1]+'" title="'+val[2]+'" class="data-gallery">').replace('[/A]','</a>');
			}
			if (val[3] == '3')
			{
				_stable = _stable.replace('[A]','<a href="'+rooturl+'/photos/'+val[0]+'">').replace('[/A]','</a>');
			}

			_stable1 += _stable;
		}
		table = _stable1;
		table = table.replace(/\[ROOTURL\]/g,rooturl);
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
				table = table.replace('[HREF-'+j+']',val[1]);
				table = table.replace('[SRC-'+j+']',val[1]);
				table = table.replace('[ALT-'+j+']',val[2]);
				table = table.replace('[CAPTION-'+j+']',getId('caption_'+val[0]).innerHTML);

				if (val[3] == '0')
				{
					table = table.replace('[A-'+j+']','').replace('[/A-'+j+']','');
				}
				if (val[3] == '1')
				{
					table = table.replace('[A-'+j+']','<a href="'+val[1]+'" title="'+val[2]+'">').replace('[/A-'+j+']','</a>');
				}
				if (val[3] == '2')
				{
					table = table.replace('[A-'+j+']','<a href="'+val[1]+'" title="'+val[2]+'" class="data-gallery">').replace('[/A-'+j+']','</a>');
				}
				if (val[3] == '3')
				{
					table = table.replace('[A-'+j+']','<a href="'+rooturl+'/photos/'+val[0]+'">').replace('[/A-'+j+']','</a>');
				}

				j++;
			}
		}

		if(!j)
		{
			alert('적용할 사진을 선택해 주세요.   ');
			return false;
		}

		table = table.replace(/\[ROOTURL\]/g,rooturl);
	}

	parent.InserHTMLtoEditor(table);
	parent.$('#modal_window').modal('hide');
}

function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.position = 'absolute';
	parent.getId('modal_window_dialog_modal_window').style.display = 'block';
	parent.$('#modal_window_dialog_modal_window').css('max-width','100%');
	parent.getId('modal_window_dialog_modal_window').style.padding = '0 20px 0 20px';
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

	parent.getId('_modal_footer_modal_window').className = 'modal-footer d-flex justify-content-between';
	parent.getId('_modal_footer_modal_window').style.position = 'absolute';
	parent.getId('_modal_footer_modal_window').style.width = '100%';
	parent.getId('_modal_footer_modal_window').style.bottom = '0';

	parent.getId('_modal_iframe_modal_window').style.overflow = 'hidden';
	parent.getId('_modal_iframe_modal_window').scrolling = 'no';
}
modalSetting();
</script>

<!-- //부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->
