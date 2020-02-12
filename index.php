<?php
function getUrlData($url,$sec) {
	$URL_parsed = parse_url($url);
	$host = $URL_parsed['host'];
	$port = $URL_parsed['port'];
	$path = $URL_parsed['path'];
	$query= $URL_parsed['query'];

	if (!$host) $host = $_SERVER['HTTP_HOST'];
	if (!$port) $port = 80;

    $out = "GET ".$path.'?'.$query." HTTP/1.1\r\n";
    $out .= "Host: ".$host."\r\n";
    $out .= "Connection: Close\r\n\r\n";

	$fp = fsockopen($host,$port,$errno,$errstr,$sec);

	if (!$fp)
	{
		return false;
	}
	else
	{
		fputs($fp, $out);
		$body = false;
		while (!feof($fp)) {
			$s = fgets($fp, 128);
			if ( $body )
				$in .= $s;
			if ( $s == "\r\n" )
				$body = true;
		}

		fclose($fp);
		return $in;
	}
}

function DirCopy($dir1 , $dir2) {
	$dirh = opendir($dir1);
	while(false !== ($filename = readdir($dirh)))
	{
		if($filename != '.' && $filename != '..')
		{
			if(!is_file($dir1.'/'.$filename))
			{
				@mkdir($dir2.'/'.$filename , 0707);
				@chmod($dir2.'/'.$filename , 0707);
				DirCopy($dir1.'/'.$filename , $dir2.'/'.$filename);
			}
			else
			{
				@copy($dir1.'/'.$filename , $dir2.'/'.$filename);
				@chmod($dir2.'/'.$filename , 0707);
			}
		}
	}
	closedir($dirh);
}

function DirDelete($t_dir) {
	$dirh = opendir($t_dir);
	while(false !== ($filename = readdir($dirh)))
	{
		if($filename != '.' && $filename != '..')
		{
			if(!is_file($t_dir.'/'.$filename))
			{
				DirDelete($t_dir.'/'.$filename);
			}
			else {
				@unlink($t_dir.'/'.$filename);
			}
		}
	}
	closedir($dirh);
	@rmdir($t_dir);
}

$_rb2list = getUrlData('https://kimsq.github.io/rb2/releases.txt',10);
$_rb2list = explode("\n",$_rb2list);
$_rb2listlength = count($_rb2list)-1;

$url = $_POST['url'];
$tmp_folder = $_POST['folder'];
$php_version=explode('.',phpversion());

if ($url) {

  $zipFile = "./rb2.zip";
  $zipResource = fopen($zipFile, "w");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FAILONERROR, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_FILE, $zipResource);
  $file = curl_exec($ch);
  if(!$file) {
   echo "에러 :- ".curl_error($ch);
  }
  $zip = new ZipArchive;
  $extractPath = "./";
  if($zip->open($zipFile) != "true"){
   echo "에러 :- zip 파일을 열수 없습니다.";
  }
  $zip->extractTo($extractPath);
  $zip->close();
  curl_close($ch);
	@unlink('./index.php');
  @unlink($zipFile);
	header("Refresh:0");
  DirCopy($extractPath.$tmp_folder,$extractPath);
  DirDelete($extractPath.$tmp_folder);
}

?>

<!doctype html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="//kimsq.github.io/rb2/images/favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//kimsq.github.io/rb2/css/install.css">
		<link rel="stylesheet" href="//kimsq.github.io/rb2/plugins/font-kimsq/1.0.0/css/font-kimsq.css">
    <title>킴스큐 설치 - Rb2</title>
  </head>
  <body>

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
			<header class="masthead mb-auto"></header>
      <main role="main" class="inner cover">
				<p class="lead">
					<a href="https://github.com/kimsQ/rb2/" target="_blank">
						<i class="kf kf-bi-01"></i>
					</a>
				</p>
        <h1 class="cover-heading font-weight-light mb-2">킴스큐 Rb2 설치를 시작합니다.</h1>

				<?php if ($php_version[0]>=7): ?>
				<p class="lead">별도의 서버작업(패키지 다운로드,압축해제,퍼미션 조정 등) 절차없이 쉽고 빠르게 설치를 진행할 것입니다.
					 설치할 패키지를 선택해주세요.</p>
				<form action="./index.php" method="post">
					<input type="hidden" name="folder" value="">
					<div class="form-group">
						<label class="sr-only">패키지 버전</label>
						<div class="input-group">
							<select name="url" class="form-control custom-select custom-select-lg rounded-0" <?php echo $url?'disabled':'' ?>>
								<option value="">설치버전을 선택하세요.</option>
								<?php for($i = 0; $i < $_rb2listlength; $i++):?>
								<?php $_list=trim($_rb2list[$i]);if(!$_list)continue?>
								<?php $var1=explode(',',$_list)?>
								<option value="<?php echo $var1[1]?>" <?php echo ($url==$var1[1])?'selected':'' ?> data-folder="rb2-<?php echo $var1[2]?>">
									<?php echo $var1[0]?>
								</option>
								<?php endfor?>
							</select>
							<div class="input-group-append d-none">
								<label class="input-group-text rounded-0 bg-white">
									<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
									<span class="sr-only">Loading...</span>
								</label>
							</div>
						</div>

					</div>
				</form>
				<?php else: ?>
				<div class="alert alert-danger mt-4" role="alert">
				  PHP7 이상에서 설치할 수 있습니다.
				</div>
				<?php endif; ?>

      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner text-center">
          <p>Copyright Redblock inc.</p>
        </div>
      </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script>

      $('[name="url"]').change(function() {
        var url = $(this).val();
        var form = $('form');
        var folder = form.find('option:selected').attr('data-folder');
        $(this).blur();
        if (!url) {
          $(this).focus();
          return false
        }
        form.find('[name="folder"]').val(folder);
        form.find('.input-group-append').removeClass('d-none');
        form.submit();
				$(this).attr('disabled', 'true')
      });

    </script>

  </body>
</html>
