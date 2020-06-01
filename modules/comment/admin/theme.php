<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">
<style>
#__code__ {
	font-weight: normal;
	font-family: Menlo,Monaco,Consolas,"Courier New",monospace !important;
}
</style>
<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<?php getImport('codemirror','lib/codemirror',false,'css')?>
<?php getImport('codemirror','lib/codemirror',false,'js')?>
<?php getImport('codemirror','theme/'.$d['admin']['codeeidt'],false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'css')?>
<?php getImport('codemirror','addon/display/fullscreen',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/xml/xml',false,'js')?>
<?php getImport('codemirror','mode/javascript/javascript',false,'js')?>
<?php getImport('codemirror','mode/css/css',false,'js')?>
<?php getImport('codemirror','mode/htmlmixed/htmlmixed',false,'js')?>
<?php getImport('codemirror','mode/clike/clike',false,'js')?>
<?php getImport('codemirror','mode/php/php',false,'js')?>

<div class="row no-gutters">
  <div class="col-sm-4 col-md-4 col-lg-3 d-none d-sm-block sidebar"><!-- 좌측영역 시작 -->
    <div class="card border-0">
      <div class="card-header f13">
        테마 리스트
      </div>

      <div class="list-group list-group-flush">
        <?php $i=0?>
        <?php $xdir = $g['path_module'].$module.'/themes/'?>
        <?php $tdir = $xdir.'_desktop/'?>
        <?php $dirs = opendir($tdir)?>
        <?php while(false !== ($skin = readdir($dirs))):?>
        <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
        <?php $i++?>
        <a href="<?php echo $g['adm_href']?>&amp;theme=_desktop/<?php echo $skin?>" class="list-group-item list-group-item-action d-flex align-items-center<?php if($theme=='_desktop/'.$skin):?> border border-primary<?php endif?>">
          <span><?php echo getFolderName($tdir.$skin)?></span>
          <span class="badge badge-<?php echo $theme=='_desktop/'.$skin?'primary':'dark' ?> badge-pill ml-auto"><?php echo $skin?></span>
        </a>
        <?php endwhile?>
        <?php closedir($dirs)?>
        <?php $tdir = $xdir.'_mobile/'?>
        <?php $dirs = opendir($tdir)?>
        <?php while(false !== ($skin = readdir($dirs))):?>
        <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
        <?php $i++?>
        <a href="<?php echo $g['adm_href']?>&amp;theme=_mobile/<?php echo $skin?>" class="list-group-item list-group-item-action d-flex align-items-center<?php if($theme=='_mobile/'.$skin):?> border border-primary<?php endif?>">
          <span><?php echo getFolderName($tdir.$skin)?></span>
          <span class="badge badge-<?php echo $theme=='_mobile/'.$skin?'primary':'dark' ?> badge-pill ml-auto"><?php echo $skin?></span>
        </a>
      <?php endwhile?>
      <?php closedir($dirs)?>
      </div>

      <?php if(!$i):?>
      <div class="none">등록된 테마가 없습니다.</div>
      <?php endif?>


    </div> <!-- 좌측 card 끝 -->
  </div>  <!-- 좌측 영역 끝 -->
  <div class="col-sm-8 col-md-8 col-lg-9 ml-sm-auto ">

    <?php if($theme):?>
    <form class="card rounded-0 border-0" name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
      <input type="hidden" name="r" value="<?php echo $r?>" />
      <input type="hidden" name="m" value="<?php echo $module?>" />
      <input type="hidden" name="a" value="theme_config" />
      <input type="hidden" name="theme" value="<?php echo $theme?>" />

      <div class="card-header p-0 page-body-header">
        <ol class="breadcrumb rounded-0 mb-0 bg-transparent text-muted">
          <?php $_theme =explode('/' , $theme); ?>
          <li class="breadcrumb-item">root</li>
          <li class="breadcrumb-item">modules</li>
          <li class="breadcrumb-item"><?php echo $module?></li>
          <li class="breadcrumb-item">themes</li>
          <li class="breadcrumb-item"><?php echo $_theme[0]?></li>
          <li class="breadcrumb-item"><?php echo $_theme[1]?></li>
        </ol>
      </div>


      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link js-tooltip<?php if(!$_COOKIE['moduleBbsThemeTab']||$_COOKIE['moduleBbsThemeTab']=='readme'):?> active<?php endif?>" href="#readme" data-toggle="tab" onclick="setCookie('moduleBbsThemeTab','readme',1);" title="README.md" data-placement="bottom">
            안내문서
          </a>
        </li>
        <li class="nav-item editor">
          <a class="nav-link js-tooltip<?php if($_COOKIE['moduleBbsThemeTab']=='editor'):?> active<?php endif?>" href="#var" data-toggle="tab" onclick="setCookie('moduleBbsThemeTab','editor','1');" title="_var.php" data-placement="bottom">
            설정 변수
          </a>
        </li>
      </ul>
      <div class="tab-content">

        <div class="tab-pane <?php if(!$_COOKIE['moduleBbsThemeTab']||$_COOKIE['moduleBbsThemeTab']=='readme'):?> show active<?php endif?>" id="readme" role="tabpanel" aria-labelledby="readme-tab">

          <?php if (is_file($g['path_module'].$module.'/themes/'.$theme.'/README.md')): ?>
          <div class="markdown-body px-4 py-0 readme">
            <?php readfile($g['path_module'].$module.'/themes/'.$theme.'/README.md')?>
          </div>
          <?php else: ?>

            <div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
      			 <div><i class="fa fa-exclamation-circle fa-3x mb-3" aria-hidden="true"></i>
      				 <p>테마 안내문서가 없습니다.</p>
      			 </div>
      		 </div>

          <?php endif; ?>

          <?php if (is_file($g['path_module'].$module.'/themes/'.$theme.'/LICENSE')): ?>
          <div class="py-5 px-4">
            <h5>라이센스</h5>
            <textarea class="form-control" rows="10"><?php readfile($g['path_module'].$module.'/themes/'.$theme.'/LICENSE')?></textarea>
          </div>
          <?php endif; ?>



        </div>

        <div class="tab-pane pr-2<?php if($_COOKIE['moduleBbsThemeTab']=='editor'):?> show active<?php endif?>" id="var" role="tabpanel" aria-labelledby="var-tab">

          <div class="">
            <div class="rb-codeview">
              <div class="rb-codeview-body">
                <textarea name="theme_var" id="__code__" class="form-control" rows="30"><?php echo implode('',file($g['path_module'].$module.'/themes/'.$theme.'/_var.php'))?></textarea>
              </div>

              <div class="rb-codeview-footer p-2">
                <div class="form-row mb-2">
									<div class="col pt-2 text-muted">
										테마명 : <?php echo getFolderName($g['path_module'].$module.'/themes/'.$theme)?>
                  </div>
                  <div class="col">

                  </div>
                  <div class="col text-right pt-2 text-muted">
                    <small><?php echo count(file($g['path_module'].$module.'/themes/'.$theme.'/_var.php')).' lines'?></small></li>
                    <small class="ml-3"><?php echo getSizeFormat(@filesize($g['path_module'].$module.'/themes/'.$theme.'/_var.php'),2)?></small>
                  </div>
                </div>
              </div>

            </div> <!--.rb-codeview -->
            </div> <!--.rb-files -->
            <div class="card-footer">

              <button type="submit" class="btn btn-outline-primary">저장하기</button>
              <span class="ml-3 text-muted">이 테마를 사용하는 모든 댓글목록에 위의 설정값이 적용됩니다.</span>
              <?php if($theme):?>
              <div class="pull-right">
                <a class="btn btn-outline-danger" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=theme_delete&amp;theme=<?php echo $theme?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 이 테마를 삭제하시겠습니까?       ');">테마삭제</a>
              </div>
              <?php endif?>

            </div>
        </div><!-- /.tab-pane -->

      </div><!-- /.tab-content -->



    <?php else:?>

      <div class="text-center text-muted d-flex align-items-center justify-content-center" style="height: calc(100vh - 10rem);">
       <div class="">
         <i class="fa fa fa-picture-o fa-3x mb-3" aria-hidden="true"></i>
         <p>테마를 선택해 주세요.</p>
         <p class="small">테마설정은 해당 테마를 사용하는 모든 댓글목록에 적용됩니다.</p>

         <ul class="list list-unstyled small">
          <li>테마는 댓글목록의 외형을 변경할 수 있는 요소입니다.</li>
          <li>테마설정은 댓글목록의 외형만 제어하며 댓글목록의 내부시스템에는 영향을 주지 않습니다.</li>
          <li>테마의 속성을 변경하면 해당테마를 사용하는 모든 댓글목록에 적용됩니다.</li>
        </ul>
       </div>
     </div>



    <?php endif?>

    </form>
    </div> <!-- 우측영역 끝 -->
</div> <!--.row -->


<?php if($d['admin']['codeeidt'] && $theme):?>
<!-- codemirror -->
<style>
.CodeMirror {
	font-size: 13px;
	font-weight: normal;
	font-family: Menlo,Monaco,Consolas,"Courier New",monospace !important;
}
</style>

<script>

(function() {
  $(".markdown-body").markdown();

	putCookieAlert('result_comment_theme') // 실행결과 알림 메시지 출력

  var editor = CodeMirror.fromTextArea(getId('__code__'), {
    mode: "<?php echo $codeset[$codeext]?$codeset[$codeext]:'application/x-httpd-php'?>",
      indentUnit: 2,
      lineNumbers: true,
      matchBrackets: true,
      indentWithTabs: true,
    theme: '<?php echo $d['admin']['codeeidt']?>'
  });
  editor.setSize('100%','500px');
  _isCodeEdit = true;
})();

</script>
<!-- @codemirror -->
<?php endif?>


<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
	return confirm('정말로 실행하시겠습니까?         ');
}
//]]>
</script>
