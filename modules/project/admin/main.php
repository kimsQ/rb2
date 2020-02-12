<?php
include $g['path_module'].$module.'/var/var.php';
if($d['project']['url'] && $d['project']['key']):
include $g['path_core'].'function/rss.func.php';
$projectData = getUrlData($d['project']['url'].'&iframe=Y&page=client.project&_clientu='.$g['s'].'&_clientr='.$r.'&key='.$d['project']['key'].'&project='.$DB['name'],10);
$projectData = explode('[RESULT:',$projectData);
$projectData = explode(':RESULT]',$projectData[1]);
$projectData = $projectData[0];
echo $projectData;
else:?>

<div class="p-4">
  <div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
   <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
     <p>프로젝트 설정 필요합니다.</p>
     <small>
       프로젝트 키는 프로젝트의 라이센스 취득여부를 확인하여 후속 지원에 활용됩니다. <br>
       key가 맞지 않거나 분실시에는 kimsq.com 에 로그인 후, 나의 프로젝트 > 호스팅 > kimsQ 설치 페이지에서 확인할 수 있습니다. <br>
       기타 문의 사항은 live@kimsq.com 또는 전화 1544-1507 로 문의 바랍니다.
     </small>

     <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=admin" class="btn btn-outline-primary btn-block mt-3">
       설정하기
     </a>
   </div>
 </div>
</div>

<?php endif?>
