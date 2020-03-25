<?php
$g['mediasetVarForSite'] = $g['path_var'].'site/'.$r.'/'.$module.'.var.php';
include_once file_exists($g['mediasetVarForSite']) ? $g['mediasetVarForSite'] : $g['path_module'].$module.'/var/var.php';
?>

<div id="configbox" class="p-4">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="config">
		<input type="hidden" name="ftp_connect" value="<?php echo $d['mediaset']['use_fileserver']?>">
		<input type="hidden" name="maxsize_file" value="<?php echo $d['mediaset']['maxsize_file']?>">

		<h4>파일첨부 설정</h4>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label text-sm-right">파일 첨부</label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<div class="input-group">
							<input type="number" name="maxnum_file" value="<?php echo $d['mediaset']['maxnum_file']?>" class="form-control">
							<div class="input-group-append">
						    <span class="input-group-text">개</span>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input type="number" name="maxsize_mb" value="" class="form-control" onChange="mbConverter()">
							<div class="input-group-append">
						    <span class="input-group-text">MB이내</span>
						  </div>
						</div>
					</div>
				</div>
				<small class="form-text text-muted"><?php echo sprintf('현재 서버에서 허용하고 있는 1회 최대 첨부용량은 <code>%sMB</code>입니다.',str_replace('M','',ini_get('upload_max_filesize')))?></small>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label text-sm-right">최대 사진 사이즈</label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<div class="input-group">
							<input type="number" name="thumbsize" value="<?php echo $d['mediaset']['thumbsize']?>" class="form-control">
							<div class="input-group-append">
						    <span class="input-group-text">픽셀</span>
						  </div>
						</div>
					</div>
				</div>
				<small class="form-text text-muted">
					사진파일 업로드시 사진의 사이즈가 기준점을 초과할 경우 자동으로 리사이징 됩니다.
				</small>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label text-sm-right">파일 저장소</label>
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-3">
						<select name="use_fileserver" class="form-control custom-select" onchange="serverChange(this);">
							<option value=""<?php if(!$d['mediaset']['use_fileserver']):?> selected<?php endif?>>현재서버</option>
							<option value="2"<?php if($d['mediaset']['use_fileserver']==2):?> selected<?php endif?>>AWS S3</option>
						</select>
					</div>
				</div>
				<small class="form-text text-muted">
					첨부물(사진 또는 파일)이 많은 경우, <a href="https://aws.amazon.com/ko/s3/?nc2=h_m1" target="_blank">AWS S3</a> 사용을 권장합니다.
				</small>
			</div>
		</div>

		<div id="use_awss3"<?php if($d['mediaset']['use_fileserver']!=2):?> class="d-none"<?php endif?>>

			<div class="page-header">
				<h4>AWS S3 설정  <small class="text-muted ml-2">Amazon Simple Storage Service</small>	</h4>
			</div>


			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-sm-right">액세스 키 ID</label>
				<div class="col-sm-8">
						<input type="text" name="s3_key" value="<?php echo $d['mediaset']['S3_KEY']?>" class="form-control">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-sm-right">비밀 액세스 키</label>
				<div class="col-sm-8">
						<input type="text" name="s3_sec" value="<?php echo $d['mediaset']['S3_SEC']?>" class="form-control">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-sm-right">리전</label>
				<div class="col-sm-8">
						<input type="text" name="s3_region" value="<?php echo $d['mediaset']['S3_REGION']?>" class="form-control">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-sm-right">버킷</label>
				<div class="col-sm-8">
						<input type="text" name="s3_bucket" value="<?php echo $d['mediaset']['S3_BUCKET']?>" class="form-control">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card f12 text-muted">
						<div class="card-body">
							<p>Amazon Simple Storage Service(Amazon S3)는 업계 최고의 확장성과 데이터 가용성 및 보안과 성능을 제공하는 객체 스토리지 서비스입니다. 즉, 어떤 규모 어떤 산업의 고객이든 이 서비스를 사용하여 웹 사이트, 모바일 애플리케이션, 백업 및 복원, 아카이브, 엔터프라이즈 애플리케이션, IoT 디바이스, 빅 데이터 분석 등과 같은 다양한 사용 사례에서 원하는 만큼의 데이터를 저장하고 보호할 수 있습니다. Amazon S3는 사용하기 쉬운 관리 기능을 제공하므로 특정 비즈니스, 조직 및 규정 준수 요구 사항에 따라 데이터를 조직화하고 세부적인 액세스 제어를 구성할 수 있습니다. Amazon S3는 99.999999999%의 내구성을 제공하도록 설계되었으며, 전 세계 기업의 수백만 애플리케이션을 위한 데이터를 저장합니다.</p>

							<a href="https://s3.console.aws.amazon.com" target="_blank" class="btn btn-light">S3 콘솔접속</a>
							<a href="https://aws.amazon.com/ko/s3/?nc2=h_m1" target="_blank" class="btn btn-light">자세히 보기</a>
						</div>
					</div>
				</div>
			</div>






		</div>

		<button type="submit" class="btn btn-outline-primary btn-block btn-lg my-4">저장하기</button>

	</form>
</div>


<script>

function mbConverter(){
	document.procForm.maxsize_file.value = document.procForm.maxsize_mb.value * 1024 * 1024
}

function byteConverter(){
	document.procForm.maxsize_mb.value = document.procForm.maxsize_file.value / (1024*1024)
}

function serverChange(obj)
{
	if (obj.value == '1') {
		$('#use_ftpserver').removeClass('d-none')
		$('#use_awss3').addClass('d-none')
	} else if (obj.value == '2') {
		$('#use_ftpserver').addClass('d-none')
		$('#use_awss3').removeClass('d-none')
	} else {
		$('#use_ftpserver').addClass('d-none')
		$('#use_awss3').addClass('d-none')
	}
}
var submitFlag = false;
function sendCheck(id)
{
	if (submitFlag == true)
	{
		alert('응답을 기다리는 중입니다. 잠시 기다려 주세요.');
		return false;
	}
	var f = document.procForm;

	if (f.ftp_host.value == '')
	{
		alert('FTP 서버주소를 입력해 주세요.   ');
		f.ftp_host.focus();
		return false;
	}
	if (f.ftp_port.value == '')
	{
		alert('FTP 포트번호를 입력해 주세요.    ');
		f.ftp_port.focus();
		return false;
	}
	if (f.ftp_user.value == '')
	{
		alert('FTP 아이디를 입력해 주세요.    ');
		f.ftp_user.focus();
		return false;
	}
	if (f.ftp_pass.value == '')
	{
		alert('FTP 암호를 입력해 주세요.    ');
		f.ftp_pass.focus();
		return false;
	}
	if (f.ftp_folder.value == '')
	{
		alert('첨부할 폴더경로를 입력해 주세요.    ');
		f.ftp_folder.focus();
		return false;
	}
	if (f.ftp_urlpath.value == '')
	{
		alert('URL 접속주소를 입력해 주세요.    ');
		f.ftp_urlpath.focus();
		return false;
	}

	mbConverter()

	f.a.value = 'ftp_check';
	getId(id).innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
	getIframeForAction(f);
	f.submit();
	submitFlag = true;
}
function saveCheck(f)
{
	if (f.use_fileserver.value == '1')
	{
		if (f.ftp_host.value == '')
		{
			alert('FTP 서버주소를 입력해 주세요.   ');
			f.ftp_host.focus();
			return false;
		}
		if (f.ftp_port.value == '')
		{
			alert('FTP 포트번호를 입력해 주세요.    ');
			f.ftp_port.focus();
			return false;
		}
		if (f.ftp_user.value == '')
		{
			alert('FTP 아이디를 입력해 주세요.    ');
			f.ftp_user.focus();
			return false;
		}
		if (f.ftp_pass.value == '')
		{
			alert('FTP 암호를 입력해 주세요.   ');
			f.ftp_pass.focus();
			return false;
		}
		if (f.ftp_folder.value == '')
		{
			alert('첨부할 폴더경로를 입력해 주세요.    ');
			f.ftp_folder.focus();
			return false;
		}
		if (f.ftp_urlpath.value == '')
		{
			alert('URL 접속주소를 입력해 주세요.    ');
			f.ftp_urlpath.focus();
			return false;
		}
	}
	// if (f.ftp_connect.value == '')
	// {
		// alert('FTP가 연결되는지 확인해 주세요.   ');
		// return false;
	// }
	getIframeForAction(f);

}
function ftp_select(obj)
{
	if (obj.value == '') obj.form.ftp_port.value = '21';
	else obj.form.ftp_port.value = '22';
}


$('[data-role="siteSelector"]').removeClass('d-none'); //사이트 셀렉터 출력
putCookieAlert('mediaset_config_result'); // 실행결과 알림 메시지 출력
byteConverter();

</script>
