<div id="mjointbox">
	<h5>
		<i class="fa fa-info-circle"></i>
		<?php echo getFolderName($g['path_widget'].$swidget)?>
	</h5>

	<form name="procform" class="form-horizontal rb-form" role="form">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">시작메뉴</label>
			<div class="col-sm-8">
				<select name="smenu" class="form-control custom-select">
				<option value="0"<?php if(!$wdgvar['smenu']):?> selected<?php endif?>>ㆍ처음(root)</option>
				<option value="-1">ㆍ1단계 선택메뉴</option>
				<option value="-2">ㆍ2단계 선택메뉴</option>
				<option value="-3">ㆍ3단계 선택메뉴</option>
				<option value="0">----------------------------------------------------------------</option>
				<?php $_isUid='u'?>
				<?php $cat=$wdgvar['smenu']?>
				<?php include $g['path_core'].'function/menu1.func.php'?>
				<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">추출단계</label>
			<div class="col-sm-8">
				<select name="limit" class="form-control custom-select">
				<?php for($i = 1; $i < 3; $i++):?>
				<option value="<?php echo $i?>"<?php if($wdgvar['limit']==$i||(!$wdgvar['limit']&&$i==2)):?> selected="selected"<?php endif?>>ㆍ<?php echo sprintf('시작메뉴 포함 %s단계',$i)?></option>
				<?php endfor?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">링크방식</label>
			<div class="col-sm-8">
				<select name="link" class="form-control custom-select">
				<option value="link">ㆍ일반</option>
				<option value="bookmark">ㆍ북마크</option>
				</select>
				<small class="form-text text-muted mt-2">
					북마크 방식을 지정하면 링크가 다음과 같이 생성됩니다.<br>
					<code>&lt;a data-scroll href=&quot;#MENUCODE&quot;&gt;</code>
				</small>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">아코디언<br><span class="badge badge-light">accordion</span></label>
			<div class="col-sm-8">
				<div class="input-group">
				  <div class="input-group-prepend">
				    <span class="input-group-text">#</span>
				  </div>
				  <input type="text" name="collid" value="<?php echo $wdgvar['collid']?$wdgvar['collid']:'drawer-menu'?>" class="form-control">
					<div class="input-group-append">
				    <div class="input-group-text">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="accordion" name="accordion" value="1" checked>
								<label class="custom-control-label" for="accordion">사용</label>
							</div>
				    </div>
				  </div>

				</div>
				<small class="form-text text-muted mt-2">
					ID를 지정해 주세요. 아코디언 기능 적용시에 필요합니다.
				</small>

			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">컬랩스<br><span class="badge badge-light">collapse</span></label>
			<div class="col-sm-8 pt-1">
				<div class="custom-control custom-checkbox">
				  <input type="checkbox" class="custom-control-input" id="collapse" name="collapse" value="1" checked>
				  <label class="custom-control-label" for="collapse">사용</label>
				</div>
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="dispfmenu" name="dispfmenu" value="1">
					<label class="custom-control-label" for="dispfmenu">부모메뉴를 포함시킴</label>
				</div>
			</div>
		</div>


	</form>
</div>


<script>
//위젯코드 리턴
function widgetCode(n)
{
	var f = document.procform;
	var widgetName = "<?php echo $swidget?>"; // 위젯명칭
	var widgetInfo = "";

	if(f.smenu.value) widgetInfo+= "'smenu'=>'"+f.smenu.value+"',";
	if(f.limit.value) widgetInfo+= "'limit'=>'"+f.limit.value+"',";
	if(f.link.value) widgetInfo+= "'link'=>'"+f.link.value+"',";
	if(f.collid.value) widgetInfo+= "'collid'=>'"+f.collid.value+"',";
	if(f.accordion.checked) widgetInfo+= "'accordion'=>'1',";
	if(f.dispfmenu.checked) widgetInfo+= "'dispfmenu'=>'1',";
	if(f.collapse.checked) widgetInfo+= "'collapse'=>'1',";

	if (n) return "<img alt=\"getWidget('"+widgetName+"',array("+widgetInfo+"))\" class=\"rb-widget-edit-img\" src=\"./_core/images/blank.gif\">"; // 에디터삽입 위젯 이미지 코드
	else return "<"+"?php "+"getWidget('"+widgetName+"',array("+widgetInfo+"))?>"; // PHP 위젯함수 코드
}
//위젯 삽입하기
function saveCheck(n)
{
	<?php $isCodeOnly='Y'?>// 코드추출만 지원할 경우
}
</script>
