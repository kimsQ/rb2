<script type="text/javascript">
  putCookieAlert('system_update_result');
</script>

<?php
checkAdmin(0);
include $g['path_module'].'admin/var/var.version.php';
include $g['path_core'].'function/rss.func.php';
$lastest_version = trim(getUrlData('https://kimsq.github.io/rb2/lastest.txt'.$g['wcache'],10));
$current_version = $_SESSION['current_version']?$_SESSION['current_version']:$d['admin']['version'];
$_current_version = str_replace('.','',$current_version);
$_lastest_version = str_replace('.','',$lastest_version);
$git_version = shell_exec('git --version');
if ($_lastest_version-$_current_version > 0) $try_update = true;
else $try_update = false;

$LASTUID = getDbCnt($table['s_gitlog'],'max(uid)','');
$R = getUidData($table['s_gitlog'],$LASTUID);
$d_last = $LASTUID?getDateFormat($R['d_regis'],'Y.m.d H:i'):'';
$_SESSION['current_version'] = '';
?>

<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">

<section class="page center" id="page-software-main">
  <header class="bar bar-nav bar-light bg-faded px-0">
    <a data-href="/" class="icon icon-home pull-left p-x-1" role="button"></a>
    <a class="icon icon-refresh pull-right p-x-1" data-location="reload" data-text="업데이트를 확인하는 중.." role="button"></a>
    <h1 class="title" data-location="reload" data-text="업데이트를 확인하는 중..">시스템 정보</h1>
  </header>
  <div class="content bg-faded">

    <form name="updateForm" method="post" action="<?php echo $g['s']?>/" target="_action_frame_site" class="py-4">
      <input type="hidden" name="r" value="<?php echo $r?>">
  		<input type="hidden" name="m" value="admin">
  		<input type="hidden" name="a" value="update">
  		<input type="hidden" name="remote" value="https://github.com/kimsQ/rb.git">
  		<input type="hidden" name="current_version" value="<?php echo $current_version?>">
  		<input type="hidden" name="lastest_version" value="<?php echo $lastest_version?>">

      <div class="text-xs-center">
        <i class="h1 kf kf-bi-01"></i>
        <strong class="d-block mt-2">
          현재 버전 <?php echo $current_version?>
        </strong>

        <?php if ($try_update): ?>
        <small class="d-block text-muted">최신 버전 <?php echo $lastest_version ?></small>

        <?php if ($git_version): ?>
          <?php if (is_dir('./.git')): ?>
          <a data-toggle="sheet" href="#sheet-update-confirm" class="btn btn-primary mt-3">
            업데이트
          </a>
          <?php else: ?>
          <button type="button" data-act="gitinit" class="btn btn-outline-success mt-3">
            업데이트 환경 초기화
          </button>
          <?php endif; ?>
        <?php else: ?>
        <div class="alert alert-danger content-padded f14" role="alert">
          <strong>[git 설치필요]</strong> 버전관리를 위해 git 설치가 필요합니다. 호스팅 제공업체 또는 서버 관리자에게 요청해주세요.
        </div>
        <?php endif; ?>
        <?php else: ?>
        <small class="d-block text-muted mt-2">최신 버전 입니다.</small>
        <?php endif; ?>

      </div>
  	</form>

    <ul class="table-view text-xs-left bg-white">
      <?php if ($d_last): ?>
      <li class="table-view-cell">
        <a class="navigate-right" data-toggle="page" data-target="#page-software-loglist" data-start="#page-software-main">
          <span class="badge badge-default badge-inverted"><?php echo $d_last ?></span>
          업데이트 이력
        </a>
      </li>
      <?php endif; ?>
      <li class="table-view-cell">
        <a class="navigate-right" data-toggle="page" data-target="#page-software-kimsq" data-start="#page-software-main">
          설명서
        </a>
      </li>
      <li class="table-view-cell">
        <a class="navigate-right" data-toggle="page" data-target="#page-software-license" data-start="#page-software-main">
          라이센스
        </a>
      </li>
    </ul>
    <ul class="table-view text-xs-left bg-white">
      <li class="table-view-cell">
        <span class="badge badge-default badge-inverted"><?php echo $_SERVER['SERVER_SOFTWARE']?></span>
        웹서버
      </li>
      <li class="table-view-cell">
        <span class="badge badge-default badge-inverted">PHP <?php echo phpversion()?></span>
         개발언어
      </li>
      <li class="table-view-cell">
        <span class="badge badge-default badge-inverted"><?php echo db_info()?> (<?php echo $DB['type']?>)</span>
        데이터베이스
      </li>
      <li class="table-view-cell">
        <span class="badge badge-default badge-inverted"><?php echo $git_version?$git_version:'git 미설치'?></span>
        버전관리
      </li>
    </ul>
  </div>
</section>

<section class="page right" id="page-software-loglist">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">업데이트 이력</h1>
  </header>
  <div class="content">
    <ul class="table-view mt-0 border-top-0 bg-white" data-role="list">
    </ul>
  </div>
</section>

<section class="page right" id="page-software-logview">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">업데이트 상세내역 <small class="ml-2 text-muted" data-role="title"></small></h1>
  </header>
  <div class="content text-xs-left bg-white">
    <table class="table f14 bg-white border-bottom mb-1" style="margin-top:-1px">
      <colgroup>
        <col width="25%">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row" class="text-xs-center">버전</th>
          <td><span data-role="version"></span></td>
        </tr>
        <tr>
          <th scope="row" class="text-xs-center">일시</th>
          <td><span data-role="d_regis"></span></td>
        </tr>
        <tr>
          <th scope="row" class="text-xs-center">작업자</th>
          <td><span data-role="name"></span></td>
        </tr>
      </tbody>
    </table>
    <div class="">
      <textarea class="form-control border-0 f14" style="height:60vh" data-role="output"></textarea>
    </div>

  </div>
</section>

<section class="page right" id="page-software-kimsq">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">설명서</h1>
  </header>
  <div class="content">

    <div class="content-padded markdown-body text-xs-left">
      <?php readfile('./README.md')?>
    </div>

  </div>
</section>

<section class="page right" id="page-software-license">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">라이센스</h1>
  </header>
  <div class="content">

    <textarea class="form-control border-0" style="height:90vh"><?php readfile('./LICENSE')?></textarea>

  </div>
</section>

<div id="sheet-update-confirm" class="sheet" style="top: 50vh;">
  <header class="bar bar-nav bar-inverse bg-primary">
    <h1 class="title title-left px-3">업데이트 전 유의사항</h1>
  </header>
  <nav class="bar bar-tab bar-light bg-white">
    <a class="tab-item text-muted" role="button" data-history="back">
      취소
    </a>
    <a class="tab-item text-primary border-left" role="button" data-act="submit">
      확인 했습니다.
    </a>
  </nav>
  <main>
    <div class="content-padded">
      <p>업데이트시 최신 코드가 적용됩니다.</p>
      <p>기본 패키지 파일에 직접 수정하거나 추가한 코드가 포함된 파일이 업데이트 내역에 포함되어 있을 경우, 해당사항이 덧씌워 집니다.</p>
      <p><mark>업데이트 전에 반드시 코드를 별도파일로 분리하거나 파일명을 변경한 후 업데이트 해주세요.</mark></p>
    </div>
  </main>
</div>

<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<script src="<?php echo $g['url_layout']?>/_js/system.js<?php echo $g['wcache']?>"></script>
