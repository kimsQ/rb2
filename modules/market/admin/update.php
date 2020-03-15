<?php include $g['path_module'].$module.'/var/var.php' ?>

<div class="p-4">
  <div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
   <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
     <p>마켓접속 설정 필요합니다.</p>
     <small>
       프로젝트 키는 프로젝트의 라이센스 취득여부를 확인하여 후속 지원에 활용됩니다. <br>
       key가 맞지 않거나 분실시에는 kimsq.com 에 로그인 후, 나의 프로젝트 페이지에서 확인할 수 있습니다.
     </small>

     <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $module?>&amp;front=config" class="btn btn-outline-primary btn-block mt-3">
       설정하기
     </a>
   </div>
 </div>
</div>
