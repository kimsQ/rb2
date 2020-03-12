<style>
/*임시*/
input[type=radio],
input[type=checkbox] {
  margin-left: -1.25rem;
}
</style>

<?php

include_once $g['path_module'].$module.'/_main.php';
$ISCAT = getDbRows($table[$module.'category'],'');

if($cat){
  $CINFO = getUidData($table[$module.'category'],$cat);
  $ctarr = getPostCategoryCodeToPath($table[$module.'category'],$cat,0);
  $ctnum = count($ctarr);
  for ($i = 0; $i < $ctnum; $i++) {
    $CXA[] = $ctarr[$i]['uid'];
		$CINFO['code'] .= $ctarr[$i]['id'].($i < $ctnum-1 ? '/' : '');
		$_code .= $ctarr[$i]['uid'].($i < $ctnum-1 ? '/' : '');
  }
  $code = $code ? $code : $_code;
}
$catcode = '';
$is_fcategory =  $CINFO['uid'] && $vtype != 'sub';
$is_regismode = !$CINFO['uid'] || $vtype == 'sub';

if ($is_regismode){	$CINFO['name']	   = '';
  $CINFO['hidden']   = '';
  $CINFO['imghead']  = '';
  $CINFO['imgfoot']  = '';
}
?>

  <div id="catebody" class="row">
    <div id="category" class="col-sm-4 col-md-4 col-lg-3 sidebar">

      <div id="accordion">

        <div class="card border-0">
          <div class="card-header p-0">
  					<a class="d-block accordion-toggle muted-link<?php if($_SESSION['post_category_collapse']):?> collapsed<?php endif?>"
  						 data-toggle="collapse"
  					   onclick="sessionSetting('post_category_collapse','','','');"
  						 href="#categoryTree">
  						<i class="fa fa-sitemap fa-lg fa-fw"></i>
  						분류
  					</a>
  				</div>
          <div class="collapse<?php if(!$_SESSION['post_category_collapse']):?> show<?php endif?>" id="categoryTree" data-parent="#accordion">
            <div class="card-body">
              <?php if($ISCAT):?>

                <?php $_treeOptions=array('site'=>$s,'table'=>$table[$module.'category'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>false,'allOpen'=>false,'bookmark'=>'site-cafe-info')?>
    						<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
    						<?php echo getTreeMenu($_treeOptions,$code,0,0,'')?>

              <?php else:?>
                <div class="none">등록된 카테고리가 없습니다.</div>
              <?php endif?>
            </div><!-- /.card-body -->
          </div>
        </div><!-- /.card -->

        <?php if($CINFO['is_child']||(!$cat&&$ISCAT)):?>
        <div class="card">
          <div class="card-header p-0">
            <a class="d-block accordion-toggle muted-link<?php if($_SESSION['post_category_collapse']!='order'):?> collapsed<?php endif?>"
               data-toggle="collapse"
               onclick="sessionSetting('post_category_collapse','order','','');"
               href="#categoryOrder">
              <i class="fa fa-retweet fa-lg fa-fw"></i>
              순서 조정
            </a>
          </div>
          <div class="collapse<?php if($_SESSION['post_category_collapse']=='order'):?> show<?php endif?>" id="categoryOrder" data-parent="#accordion" >
              <form role="form" action="<?php echo $g['s']?>/" method="post">
                <input type="hidden" name="r" value="<?php echo $r?>">
                <input type="hidden" name="m" value="<?php echo $module?>">
                <input type="hidden" name="a" value="modifycategorygid">

                <div class="card-body">

                  <div class="dd" id="nestable-category">
                    <ol class="dd-list">
                      <?php $_MENUS=getDbSelect($table[$module.'category'],'parent='.intval($CINFO['uid']).' and depth='.($CINFO['depth']+1).' order by gid asc','*')?>
                      <?php while($_M=db_fetch_array($_MENUS)):?>
                      <li class="dd-item" data-id="<?php echo $_i?>">
                        <input type="checkbox" name="categorymembers[]" value="<?php echo $_M['uid']?>" checked class="d-none">
                        <div class="dd-handle"><i class="fa fa-arrows fa-fw"></i> <?php echo $_M['name']?></div>
                      </li>
                      <?php $_i++;endwhile?>
                    </ol>
                  </div>

                </div><!-- /.card-body -->

              </form>

              <!-- nestable : https://github.com/dbushell/Nestable -->
              <?php getImport('nestable','jquery.nestable',false,'js') ?>
              <script>
              $('#nestable-category').nestable();
              $('.dd').on('change', function() {
                var f = document.forms[0];
                getIframeForAction(f);
                f.submit();
              });
              </script>

          </div>
        </div>
        <?php endif?>

      </div>

    </div>
    <div id="catinfo" class="col-sm-8 col-md-8 ml-sm-auto col-xl-9">
      <form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" enctype="multipart/form-data" onsubmit="return saveCheck(this);" autocomplete="off">
        <input type="hidden" name="r" value="<?php echo $r?>" />
        <input type="hidden" name="m" value="<?php echo $module?>" />
        <input type="hidden" name="a" value="regiscategory" />
        <input type="hidden" name="cat" value="<?php echo $CINFO['uid']?>" />
        <input type="hidden" name="code" value="<?php echo $code?>">
        <input type="hidden" name="vtype" value="<?php echo $vtype?>" />
        <input type="hidden" name="depth" value="<?php echo intval($CINFO['depth'])?>" />
        <input type="hidden" name="parent" value="<?php echo intval($CINFO['uid'])?>" />
        <div class="d-flex justify-content-between my-3">
          <h3 class="mb-0">
            <?php if($is_regismode):?>
              <?php if($vtype == 'sub'):?>하위 카테고리 만들기<?php else:?>최상위 카테고리 만들기<?php endif?>
              <?php else:?>
                카테고리 등록정보
              <?php endif?>
            </h3>
            <div>
              <a class="btn btn-light" href="<?php echo $g['adm_href']?>&amp;type=makesite">최상위카테고리 등록</a>
            </div>
          </div>
          <p>
            <small class="text-muted">
              <?php if($is_regismode):?>
                복수의 카테고리을 한번에 등록하시려면 카테고리명을 콤마(,)로 구분해 주세요.<br />
                보기)정치경제,문화예술,비즈니스
              <?php else:?>
                속성을 변경하려면 설정값을 변경한 후 [속성변경] 버튼을 클릭해주세요.<br />
                카테고리을 삭제하면 소속된 하위카테고리까지 모두 삭제됩니다.
              <?php endif?>
            </small>
          </p>
          <?php if($vtype == 'sub'):?>
            <div class="form-group form-row">
              <label class="col-md-2 col-form-label text-center">상위 카테고리</label>
              <div class="col-md-10 col-lg-9">
                <ol class="breadcrumb">
                  <?php for ($i = 0; $i < $ctnum; $i++): ?>
                    <li class="breadcrumb-item"><?php echo $ctarr[$i]['name']?></li>
                    <?php $catcode .= $ctarr[$i]['id'].'/'; endfor?>
                  </ol>
                </div>
              </div>
            <?php else:?>
              <?php if($cat):?>
                <div class="form-group form-row">
                  <label class="col-md-2 col-form-label text-center">상위 카테고리</label>
                  <div class="col-md-10 col-lg-9 form-inline">
                    <ol class="breadcrumb">
                      <?php for ($i = 0; $i < $ctnum-1; $i++): ?>
                      <li class="breadcrumb-item"><?php echo $ctarr[$i]['name']?></li>
                      <?php
                      $delparent=$ctarr[$i]['uid'];
                      $catcode .= $ctarr[$i]['id'].'/';
                      endfor
                      ?>
                      <?php if(!$delparent):?>
                      <li class="breadcrumb-item active" aria-current="page">최상위카테고리</li>
                      <?php endif?>
                    </ol>

                  </div>
                </div>
                <?php endif?>
              <?php endif?>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center">카테고리 명칭</label>
                <div class="col-md-10 col-lg-9">
                  <div class="input-group input-group-lg">
                    <input type="text" name="name" value="<?php echo $CINFO['name']?>" class="form-control sname<?php echo $is_fcategory?1:2?>"<?php if(!$code || $vtype):?> autofocus<?php endif?>>
                    <?php if($is_fcategory):?>
                      <span class="input-group-append">
                        <?php if($CINFO['depth']<5):?>
                        <a class="btn btn-light" href="<?php echo $g['adm_href']?>&amp;cat=<?php echo $cat?>&amp;code=<?php echo $code?>&amp;vtype=sub"  data-toggle="tooltip" title="하위 카테고리만들기">
                          <i class="fa fa-share fa-rotate-90 fa-lg"></i>
                        </a>
                        <?php endif?>
                        <a class="btn btn-light"
                          href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletecategory&amp;cat=<?php echo $cat?>&amp;parent=<?php echo $delparent?>"
                          target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')" data-toggle="tooltip" title="카테고리삭제">
                          <i class="fa fa-trash-o fa-lg"></i>
                        </a>
                      </span>
                    <?php endif?>
                  </div>
                </div>
              </div>

              <div class="form-group row rb-outside">
      					<label class="col-lg-2 col-form-label text-lg-right">코드</label>
      					<div class="col-lg-10 col-xl-9">
      						<input class="form-control" placeholder="미등록시 자동생성 됩니다." type="text" name="id" value="<?php echo $CINFO['id']?>" maxlength="20">
      						<button type="button" class="btn btn-link text-muted mt-2 pl-0" data-toggle="collapse" data-target="#guide_menucode">
      							<i class="fa fa-question-circle fa-fw"></i>
      							카테고리를 잘 표현할 수 있는 단어로 입력해 주세요.
      						</button>

      						<div id="guide_menucode" class="collapse">
      							<small>
      								<ul class="form-text text-muted pl-3 mt-2">
      									<li>영문대소문자/숫자/_/- 조합으로 등록할 수 있습니다.</li>
      									<li>보기) 호출주소 : <code><?php echo RW('category=CODE')?></code></li>
      									<li>코드는 중복될 수 없습니다.</li>
      								</ul>
      							</small>
      						</div>
      					</div>
      				</div>

              <?php if($CINFO['uid']&&!$vtype):?>
      				<?php $_url = $g['s'].'/?r='.$r.'&m=post&cat='.$CINFO['id'].'&code='.$code?>
      				<div class="form-group row">
      					<label class="col-lg-2 col-form-label text-lg-right">주소</label>
      					<div class="col-lg-10 col-xl-9">

      						<div class="input-group" style="margin-bottom: 5px">
      							<input id="_url_m_1_" type="text" class="form-control" value="<?php echo $_url?>" readonly>
      							<span class="input-group-append">
      								<a href="#." class="btn btn-light js-clipboard" data-tooltip="tooltip" title="클립보드에 복사" data-clipboard-target="#_url_m_1_"><i class="fa fa-clipboard"></i></a>
      								<a href="<?php echo $_url?>" target="_blank" class="btn btn-light" data-tooltip="tooltip" title="접속">Go!</a>
      							</span>
      						</div>

      					</div>
      				</div>
              <?php endif?>

              <hr>

              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center">숨김처리</label>
                <div class="col-md-10 col-lg-9">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="hidden" id="cat_hidden" value="1"<?php if($CINFO['hidden']):?> checked="checked"<?php endif?>> 카테고리숨김
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="reject" id="cat_reject" value="1"<?php if($CINFO['reject']):?> checked="checked"<?php endif?>> 카테고리차단
                    </label>
                  </div>
                  <small class="form-text text-muted">
                    <strong>카테고리숨김 : </strong>메뉴를 출력하지 않습니다.(링크접근 가능)<br>
                    <strong>카테고리차단 : </strong>메뉴의 접근을 차단합니다.(링크접근 불가)
                  </small>
                </div>
              </div>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center">포스트 출력</label>
                <div class="col-md-10 col-lg-9">
                  <div class="input-group w-25">
                    <input type="text" name="recnum" value="<?php echo $CINFO['recnum']?$CINFO['recnum']:20?>" size="3" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">개</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center">레이아웃</label>
                <div class="col-md-10 col-lg-9">
                  <select name="layout" class="form-control custom-select">
                    <option value="">포스트 대표레이아웃</option>
                    <?php $dirs = opendir($g['path_layout'])?>
                    <?php while(false !== ($tpl = readdir($dirs))):?>
                      <?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
                      <?php $dirs1 = opendir($g['path_layout'].$tpl)?>
                      <?php while(false !== ($tpl1 = readdir($dirs1))):?>
                        <?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
                        <option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($CINFO['layout']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
                      <?php endwhile?>
                      <?php closedir($dirs1)?>
                    <?php endwhile?>
                    <?php closedir($dirs)?>
                  </select>
                </div>
              </div>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center"><span class="badge badge-dark">모바일</span></label>
                <div class="col-md-10 col-lg-9">
                  <select name="layout_mobile" class="form-control custom-select">

                  </select>
                </div>
              </div>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center">카테고리 테마</label>
                <div class="col-md-10 col-lg-9">
                  <select name="skin" class="form-control custom-select">
                    <option value="">포스트 대표테마</option>
                    <?php $tdir = $g['path_module'].$module.'/themes/_desktop/'?>
                    <?php $dirs = opendir($tdir)?>
                    <?php while(false !== ($skin = readdir($dirs))):?>
                      <?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
                      <option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>"<?php if($CINFO['skin']=='_desktop/'.$skin):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
                    <?php endwhile?>
                    <?php closedir($dirs)?>
                  </select>
                </div>
              </div>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center"><span class="badge badge-dark">모바일</span></label>
                <div class="col-md-10 col-lg-9">
                  <select name="skin_mobile" class="form-control custom-select">
                    <option value="">포스트 대표테마</option>
                  </select>
                </div>
              </div>
              <div class="form-group form-row">
                <label class="col-md-2 col-form-label text-center">소속메뉴</label>
                <div class="col-md-10 col-lg-9">
                  <select name="sosokmenu" class="form-control custom-select">
                    <option value="">사용안함</option>
                    <?php include_once $g['path_core'].'function/menu1.func.php' ?>
                    <?php $cat=$CINFO['sosokmenu']?>
                    <?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-md-2 col-form-label text-center">대표이미지</label>
                <div class="col-md-10 col-lg-9">
                  <div class="input-group">
                    <input class="form-control rb-modal-photo-drop" onmousedown="_mediasetField='meta_image_src&dfiles='+this.value;" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window" type="text" name="featured_img" id="meta_image_src" value="<?php echo $CINFO['featured_img']?>">
                    <div class="input-group-append">
                      <button class="btn btn-light rb-modal-photo1" type="button" title="포토셋" data-tooltip="tooltip" data-toggle="modal" data-target="#modal_window">
                        <i class="fa fa-photo fa-lg"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <?php if($CINFO['uid']):?>
                <div class="form-group form-row">
                  <label class="col-md-2 col-form-label text-center">코드확장</label>
                  <div class="col-md-10 col-lg-9">
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" <?php if($CINFO['imghead']||is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.header.php')):?> checked="checked"<?php endif?> disabled="disabled">
                        카테고리헤더
                        <button class="btn btn-sm btn-light" type="button" data-toggle="collapse" data-target="#menu_header" aria-expanded="false" aria-controls="menu_header">
                          <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" <?php if($CINFO['imgfoot']||is_file($g['path_page'].'menu/'.sprintf('%05d',$CINFO['uid']).'.footer.php')):?> checked="checked"<?php endif?> disabled="disabled">
                        카테고리풋터
                        <button class="btn btn-sm btn-light" type="button" data-toggle="collapse" data-target="#menu_footer" aria-expanded="false" aria-controls="menu_footer">
                          <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                      </label>
                    </div>
                  </div>
                </div>
                <div id="menu_header" class="collapse multi-collapse">
                  <div class="form-group form-row">
                    <label class="col-md-2 col-form-label text-center">헤더파일</label>
                    <div class="col-md-10 col-lg-9">
                      <input type="file" name="imghead" class="upfile" />
                      <?php if($CINFO['imghead']):?>
                        <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=filemanager&amp;front=main&amp;editmode=Y&amp;pwd=./modules/<?php echo $module?>/var/files/&file=<?php echo $CINFO['imghead']?>" target="_blank" title="<?php echo $CINFO['imghead']?>" class="u">파일수정</a>
                        <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=category_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=head" target="_action_frame_<?php echo $m?>" class="u" onclick="return confirm('정말로 삭제하시겠습니까?     ');">삭제</a>
                      <?php else:?>
                        <span>(gif/jpg/png/swf 가능)</span>
                      <?php endif?>
                    </div>
                  </div>
                  <div class="form-group form-row">
                    <label class="col-md-2 col-form-label text-center">헤더코드</label>
                    <div class="col-md-10 col-lg-9">
                      <textarea name="codhead" class="form-control" rows="4" id="codheadArea"><?php if(is_file($g['path_module'].$module.'/var/code/'.sprintf('%05d',$CINFO['uid']).'.header.php')) echo htmlspecialchars(implode('',file($g['path_module'].$module.'/var/code/'.sprintf('%05d',$CINFO['uid']).'.header.php')))?></textarea>
                    </div>
                  </div>
                </div>
                <div id="menu_footer" class="collapse multi-collapse">
                  <div class="form-group form-row">
                    <label class="col-md-2 col-form-label text-center">풋터파일</label>
                    <div class="col-md-10 col-lg-9">
                      <input type="file" name="imgfoot" class="upfile" />
                      <?php if($CINFO['imgfoot']):?>
                        <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=filemanager&amp;front=main&amp;editmode=Y&amp;pwd=./modules/<?php echo $module?>/var/files/&file=<?php echo $CINFO['imgfoot']?>" target="_blank" title="<?php echo $CINFO['imgfoot']?>" class="u">파일수정</a>
                        <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=category_file_delete&amp;cat=<?php echo $CINFO['uid']?>&amp;dtype=foot" target="_action_frame_<?php echo $m?>" class="u" onclick="return confirm('정말로 삭제하시겠습니까?     ');">삭제</a>
                      <?php else:?>
                        <span>(gif/jpg/png/swf 가능)</span>
                      <?php endif?>
                    </div>
                  </div>
                  <div class="form-group form-row">
                    <label class="col-md-2 col-form-label text-center">풋터코드</label>
                    <div class="col-md-10 col-lg-9">
                      <textarea name="codfoot" id="codfootArea" class="form-control" rows="4"><?php if(is_file($g['path_module'].$module.'/var/code/'.sprintf('%05d',$CINFO['uid']).'.footer.php')) echo htmlspecialchars(implode('',file($g['path_module'].$module.'/var/code/'.sprintf('%05d',$CINFO['uid']).'.footer.php')))?></textarea>
                    </div>
                  </div>
                </div>
              <?php endif?>
              <div class="form-group row my-4">
                <div class="col-2"></div>
                <div class="col-10">
                  <?php if($is_fcategory && $CINFO['is_child']):?>
                  <div class="custom-control custom-checkbox mb-4">
                    <input type="checkbox" class="custom-control-input" name="subcopy" id="cubcopy" value="1" checked="checked">
                    <label class="custom-control-label" for="cubcopy">이 설정(숨김처리,레이아웃)을 하위카테고리에도 일괄적용합니다.</label>
                  </div>
                  <?php endif?>

                  <?php if($vtype=='sub'):?><input type="button" class="btn btn-light" value="등록취소" onclick="history.back();" /><?php endif?>
                  <input type="submit" class="btn btn-primary" value="<?php echo $is_fcategory?'카테고리속성 변경':'신규카테고리 등록'?>" />
                </div>

              </div>
            </form>
          </div>
        </div>

<script type="text/javascript">
  var orderopen = false;

  //사이트 셀렉터 출력
	$('[data-role="siteSelector"]').removeClass('d-none')

  function orderOpen() {
    if (orderopen == false) {
      getId('menuorder').style.display = 'block';
      orderopen = true;
    } else {
      getId('menuorder').style.display = 'none';
      orderopen = false;
    }
  }

  function displaySelect(obj) {
    var f = document.procForm;
    if (obj.value == '1') {
      getId('jointBox').style.display = 'block';
      getId('widgetBox').style.display = 'none';
      getId('codeBox').style.display = 'none';
      f.joint.focus();
    } else if (obj.value == '2') {
      getId('jointBox').style.display = 'none';
      getId('widgetBox').style.display = 'block';
      getId('codeBox').style.display = 'none';
    } else if (obj.value == '3') {
      getId('jointBox').style.display = 'none';
      getId('widgetBox').style.display = 'none';
      getId('codeBox').style.display = 'block';
    } else {
      getId('jointBox').style.display = 'none';
      getId('widgetBox').style.display = 'none';
      getId('codeBox').style.display = 'none';
    }
  }

  function codShowHide(layer, show, hide, img) {
    if (getId(layer).style.display != show) {
      getId(layer).style.display = show;
      img.src = img.src.replace('ico_under', 'ico_over');
      setCookie('ck_' + layer, show, 1);
    } else {
      getId(layer).style.display = hide;
      img.src = img.src.replace('ico_over', 'ico_under');
      setCookie('ck_' + layer, hide, 1);
    }
  }

  function saveCheck(f) {
    if (f.name.value == '') {
      alert('카테고리명칭을 입력해 주세요.      ');
      f.name.focus();
      return false;
    }
  }

  putCookieAlert('result_post_category') // 실행결과 알림 메시지 출력

  $('.rb-modal-photo1').on('click',function() {
    modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=meta_image_src')?>');
  });
  $('.rb-modal-photo-drop').on('click',function() {
    modalSetting('modal_window','<?php echo getModalLink('&amp;m=mediaset&amp;mdfile=modal.photo.media&amp;dropfield=')?>'+_mediasetField);
  });

</script>
