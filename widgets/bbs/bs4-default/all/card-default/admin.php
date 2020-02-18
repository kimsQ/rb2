<div id="mjointbox">
	<h5>
		<i class="fa fa-info-circle"></i>
		<?php echo getFolderName($g['path_widget'].$swidget)?>
	</h5>
	<form name="procform" class="" role="form">
		<div class="form-group row">
			<label class="col-sm-3 col-form-label col-form-label-sm">게시판 선택</label>
			<div class="col-sm-8">
				<select name="bbsid" onchange="titleChange(this);" class="form-control form-control-sm custom-select">
					<option value="">&nbsp;+ 전체게시물</option>
					<option value="" disabled>----------------------------------</option>
					<?php $BBSLIST = getDbArray($table['bbslist'],'','*','gid','asc',0,1)?>
					<?php while($R=db_fetch_array($BBSLIST)):?>
					<option value="<?php echo $R['id']?>^<?php echo $R['name']?>^<?php echo RW('m=bbs&bid='.$R['id'])?>"<?php if($wdgvar['bid']==$R['id']):?> selected="selected"<?php endif?>>
						ㆍ<?php echo $R['name']?>(<?php echo $R['id']?>)
					</option>
					<?php endwhile?>
				</select>

			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label col-form-label-sm">타이틀</label>
			<div class="col-sm-8">
				<input type="text" name="title" value="<?php echo $wdgvar['title']?$wdgvar['title']:'최근 뉴스'?>" class="form-control form-control-sm" placeholder="">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label col-form-label-sm">링크연결</label>
			<div class="col-sm-8">
				<input type="text" name="link" value="<?php echo $wdgvar['link']?>" class="form-control form-control-sm" placeholder="">
				<small class="form-text text-muted mt-2">
					링크입력시 more(더보기) 링크에 적용됩니다.
				</small>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label">한열 항목수</label>
			<div class="col-sm-4">
				<select name="recnum" class="form-control form-control-sm custom-select w-50">
				<?php for($i = 2; $i < 11; $i++):?>
				<option value="<?php echo $i?>"<?php if($wdgvar['recnum']==$i || (!$wdgvar['recnum']&&$i==3)):?> selected<?php endif?>><?php echo $i?>개</option>
				<?php endfor?>
				</select>
			</div>
			<label class="col-sm-2 col-form-label col-form-label-sm px-0">총 항목수</label>
			<div class="col-sm-3 px-0">
				<select name="limit" class="form-control form-control-sm custom-select w-50">
				<?php for($i = 1; $i < 21; $i++):?>
				<option value="<?php echo $i?>"<?php if($wdgvar['limit']==$i || (!$wdgvar['limit']&&$i==6)):?> selected<?php endif?>><?php echo $i?>개</option>
				<?php endfor?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label col-form-label-sm">제목자르기</label>
			<div class="col-sm-8">
				<div class="input-group input-group-sm w-50">
				  <input type="text" class="form-control" placeholder="" name="sbjcut" value="<?php echo $wdgvar['sbjcut']?>" >
				  <div class="input-group-append">
				    <span class="input-group-text">자에서 자름</span>
				  </div>
				</div>
				<small class="form-text text-muted mt-2">
					미입력시 자르지 않음
				</small>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 control-label col-form-label-sm">사진사이즈</label>
			<div class="col-sm-8">
				<div class="input-group input-group-sm w-75">
					<input type="number" class="form-control" name="width" value="<?php echo $wdgvar['width']?$wdgvar['width']:400?>" placeholder="">
					<div class="input-group-append">
				    <span class="input-group-text">x</span>
				  </div>
					<input type="number" class="form-control" name="height" value="<?php echo $wdgvar['height']?$wdgvar['height']:250?>" placeholder="">
					<div class="input-group-append">
				    <span class="input-group-text">px</span>
				  </div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 col-form-label col-form-label-sm">보기형식</label>
			<div class="col-sm-8">
				<select name="view" class="form-control form-control-sm custom-select w-50">
					<option value="modal">모달 레이어</option>
					<option value="link">일반 링크</option>
				</select>
			</div>
		</div>

	</form>
</div>

<script>
//위젯코드 리턴
function widgetCode(n)
{
	var f = document.procform;
	var bbsx = f.bbsid.value.split('^');
	var widgetName = "<?php echo $swidget?>"; // 위젯명칭
	var widgetInfo = "";
	if(bbsx[0]) widgetInfo = "'bid'=>'"+bbsx[0]+"',";
	if(f.recnum.value) widgetInfo+= "'recnum'=>'"+f.recnum.value+"',";
	if(f.limit.value) widgetInfo+= "'limit'=>'"+f.limit.value+"',";
	if(f.title.value) widgetInfo+= "'title'=>'"+f.title.value+"',";
	if(f.link.value) widgetInfo+= "'link'=>'"+f.link.value+"',";
	if(f.width.value) widgetInfo+= "'width'=>'"+f.width.value+"',";
	if(f.height.value) widgetInfo+= "'height'=>'"+f.height.value+"',";
	if(f.view.value) widgetInfo+= "'view'=>'"+f.view.value+"'";


	if (n) return "<img alt=\"getWidget('"+widgetName+"',array("+widgetInfo+"))\" class=\"rb-widget-edit-img\" src=\"./_core/images/blank.gif\">"; // 에디터삽입 위젯 이미지 코드
	else return "<"+"?php "+"getWidget('"+widgetName+"',array("+widgetInfo+"))?>"; // PHP 위젯함수 코드
}

function titleChange(obj) {
	var f = document.procform;
	if (obj.value == '')
	{
		f.title.value = '최근 뉴스';
		f.link.value = '';
		f.title.focus();
	}
	else {
		var tt = obj.value.split('^');
		f.title.value = tt[1];
		f.link.value = tt[2];
		f.link.focus();
	}
}

//위젯 삽입하기
function saveCheck(n)
{
<?php $isCodeOnly='Y'?>// 코드추출만 지원할 경우
}
</script>
