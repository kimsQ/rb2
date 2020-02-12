<?php
$R = getDbData($table['s_mobile'],'','*');
?>

<div class="container-fluid" id="mobilebox">

	<form class="row" name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="mobile">
		<input type="hidden" name="checkm" value="<?php echo $R['usemobile']?$R['usemobile']:0?>">

		<div class="col-md-6">
			<ul class="list-inline">
				<li class="list-inline-item"><i class="fa fa-tablet fa-5x"></i></li>
				<li class="list-inline-item"><i class="fa fa-mobile fa-4x"></i></li>
				<li class="list-inline-item"><h2>모바일 기기로 접속 시</h2></li>
			</ul>
			<div class="nav btn-group btn-group-toggle  w-100" data-toggle="buttons">
				<a href="#usemobile-00" class="btn btn-light<?php if(!$R['usemobile']):?> active<?php endif?>" style="width: 33.3%;" data-toggle="tab">
					<input type="radio" name="usemobile" value="0"<?php if(!$R['usemobile']):?> checked="checked"<?php endif?>> 사이트별 적용
				</a>
				<a href="#usemobile-02" class="btn btn-light<?php if($R['usemobile']==2):?> active<?php endif?>" style="width: 33.3%;" data-toggle="tab">
					<input type="radio" name="usemobile" value="2"<?php if($R['usemobile']==2):?> checked="checked"<?php endif?>> 특정 도메인 으로 이동
				</a>
				<a href="#usemobile-01" class="btn btn-light<?php if($R['usemobile']==1):?> active<?php endif?>" style="width: 33.3%;" data-toggle="tab">
					<input type="radio" name="usemobile" value="1"<?php if($R['usemobile']==1):?> checked="checked"<?php endif?>> 특정 사이트로 연결
				</a>
			</div>
			<div class="tab-content">
				<div class="tab-pane bg-light rounded p-4 text-muted fade<?php if(!$R['usemobile']):?> show active<?php endif?>" id="usemobile-00">
					모바일 기기로 접속 시 사이트별로 모바일 모드를 적용할 수 있습니다.
				</div>
				<div class="tab-pane text-muted fade<?php if($R['usemobile']==2):?> show active<?php endif?>" id="usemobile-02">
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="fa fa-lg fa-fw kf kf-domain"></i></span>
					  </div>
						<select name="startdomain" class="form-control custom-select">
							<option value="">연결할 도메인을 선택 하세요</option>
							<?php $SITES = getDbArray($table['s_domain'],'','*','gid','asc',0,$p)?>
							<?php while($S = db_fetch_array($SITES)):?>
							<option value="http://<?php echo $S['name']?>"<?php if('http://'.$S['name']==$R['startdomain']):?> selected<?php endif?>>ㆍ<?php echo $S['name']?></option>
							<?php endwhile?>
							<?php if(!db_num_rows($SITES)):?>
							<option value="">등록된 도메인이 없습니다.</option>
							<?php endif?>
						</select>
					</div>
					<small class="form-text text-muted">
						모바일 기기로 접속 시 특정 도메인을 연결할 수 있습니다.
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=domain&amp;type=makedomain">도메인 추가</a>
					</small>
				</div>
				<div class="tab-pane text-muted fade<?php if($R['usemobile']==1):?> show active<?php endif?>" id="usemobile-01">
					<div class="input-group input-group-lg">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="fa fa-lg fa-fw kf kf-home"></i></span>
					  </div>
						<select name="startsite" class="form-control custom-select">
							<option value="">연결할 사이트를 선택하세요.</option>
							<?php $SITES = getDbArray($table['s_site'],'','*','gid','asc',0,$p)?>
							<?php while($S = db_fetch_array($SITES)):?>
							<option value="<?php echo $S['uid']?>"<?php if($S['uid']==$R['startsite']):?> selected<?php endif?>>ㆍ<?php echo $S['label']?></option>
							<?php endwhile?>
							<?php if(!db_num_rows($SITES)):?>
							<option value="">등록된 사이트가 없습니다.</option>
							<?php endif?>
						</select>
					</div>
					<small class="form-text text-muted">
						모바일 기기로 접속 시 특정 사이트로 연결할 수 있습니다. 도메인은 유지 됩니다.
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=site&amp;type=makesite">사이트 추가</a>
					</small>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-lg-5">
			<div class="form-group mt-4">
				<label>디바이스 목록</label>
				<textarea name="agentlist" rows="11" class="form-control"><?php echo trim(implode('',file($g['path_var'].'mobile.agent.txt')))?></textarea>
			</div>
		</div>

		<div class="col-md-12">
			<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4">저장하기</button>
		</div>

	</form>

</div>

<script>
function saveCheck(f)
{
	if (f.checkm.value == '1')
	{
		if (f.startsite.value == '')
		{
			alert('시작사이트를 지정해 주세요.   ');
			f.startsite.focus();
			return false;
		}
	}
	if (f.checkm.value == '2')
	{
		if (f.startdomain.value == '')
		{
			alert('시작도메인을 지정해 주세요.   ');
			f.startdomain.focus();
			return false;
		}
	}
	if (confirm('정말로 실행하시겠습니까?       '))
	{
		getIframeForAction(f);
		$(".btn-primary").addClass("disabled");
		return true;
	}
	return false;
}
</script>
