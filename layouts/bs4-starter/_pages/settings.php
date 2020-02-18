<?php
if (!$my['admin']) getLink('/','','','');
$g['layoutPageVarForSite'] = $g['path_var'].'site/'.$r.'/layout.'.dirname($_HS['layout']).'.main.php';
include is_file($g['layoutPageVarForSite']) ? $g['layoutPageVarForSite'] : $g['dir_layout'].'_var/_var.main.php';
include $g['dir_layout'].'_var/_var.config.php';
?>

<div class="row">
  <div class="col-8">

    <?php include $g['dir_layout'].'/_includes/settings-nav.php' ?>

    <?php if ($type=='mainedit'): ?>
    <form name="settingMain" method="post" action="<?php echo $g['s']?>/" target="_action_frame_<?php echo $m?>"  class="my-4" role="form">
      <input type="hidden" name="r" value="<?php echo $r?>">
      <input type="hidden" name="a" value="regislayoutpage">
      <input type="hidden" name="m" value="site">
      <input type="hidden" name="page" value="main">
      <input type="hidden" name="area" value="main_widget_top,main_widget_left,main_widget_right">
      <input type="hidden" name="main_widget_top" value="">
      <input type="hidden" name="main_widget_left" value="">
      <input type="hidden" name="main_widget_right" value="">

      <div data-role="widgetPage" data-area="top">
        <?php echo getWidgetListEdit($d['layout']['main_widget_top']) ?>
      </div>

      <div class="row gutter-half">
        <div class="col-6">
          <div data-role="widgetPage" data-area="left" data-plugin="nestable" class="dd">
            <?php echo getWidgetListEdit($d['layout']['main_widget_left']) ?>
            <div data-role="addWidget" class="">
              <button type="button" class="btn btn-white text-muted btn-block f13 py-3" data-target="#modal-widget-selector" data-toggle="modal" data-area="left" style="border-style: dashed;">
                <i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> 위젯 추가
              </button>
              <div class="card card-placeholder">
                <div class="card-body">&nbsp;</div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-6">

          <div data-role="widgetPage" data-area="right" data-plugin="nestable" class="dd">
            <?php echo getWidgetListEdit($d['layout']['main_widget_right']) ?>
            <div data-role="addWidget" class="">
              <button type="button" class="btn btn-white text-muted btn-block f13 py-3" data-target="#modal-widget-selector" data-toggle="modal" data-area="right" style="border-style: dashed;">
                <i class="fa fa-plus-circle fa-fw" aria-hidden="true"></i> 위젯 추가
              </button>
              <div class="card card-placeholder">
                <div class="card-body">&nbsp;</div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <div class="">
          <?php if ($type=='mainedit'): ?>
          <button type="button" class="btn btn-white <?php echo file_exists($g['layoutPageVarForSite'])?'':'d-none' ?>"
            data-act="reset" data-page="main" data-toggle="tooltip" title="꾸미기 초기화">
            초기화
          </button>
          <?php endif; ?>
        </div>

        <button type="button" data-act="submit" class="btn btn-outline-primary">
          <span class="not-loading">
            저장
          </span>
          <span class="is-loading">
            처리중...
          </span>
        </button>
      </div>

    </form>
    <?php else: ?>

    <form name="settingLayout" action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>">
      <input type="hidden" name="r" value="<?php echo $r?>">
      <input type="hidden" name="m" value="<?php echo $m?>">
      <input type="hidden" name="a" value="regislayoutsite">

      <div class="row">
        <div class="col-3">
          <div class="nav flex-column nav-pills" id="layout-settings-tab" role="tablist" aria-orientation="vertical">
            <?php $_i=1;foreach($d['layout']['dom'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
            <a class="nav-link rounded-0" data-order="<?php echo $__i?>"
              data-toggle="pill"
              href="#layout-settings-<?php echo $__i?>-body"
              role="tab">
              <?php echo $_val[0]?>
            </a>
            <?php $_i++;endforeach?>
          </div>
        </div>
        <div class="col-9">
          <div class="tab-content" id="layout-settings-tabContent">
            <?php $_i=1;foreach($d['layout']['dom'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
            <div class="tab-pane fade" id="layout-settings-<?php echo $__i?>-body" role="tabpanel">
              <?php if(count($_val[2])):?>
              <?php foreach($_val[2] as $_v):?>
              <div class="form-group">
                <?php if($_v[1]!='hidden'):?>
                <label><?php echo $_v[2]?></label>
                <?php endif?>

                <?php if($_v[1]=='hidden'):?>
                <input type="hidden" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
                <?php endif?>

                <?php if($_v[1]=='input'):?>
                <input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo stripslashes($d['layout'][$_key.'_'.$_v[0]])?>" autocomplete="off">
                <?php endif?>

                <?php if($_v[1]=='color'):?>
                <div class="input-group">
                  <input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
                  <span class="input-group-append">
                    <button class="btn btn-light" type="button" data-toggle="modal" data-target=".bs-example-modal-sm" onclick="getColorLayer(getId('layout_<?php echo $_key?>_<?php echo $_v[0]?>').value.replace('#',''),'layout_<?php echo $_key?>_<?php echo $_v[0]?>');"><i class="fa fa-tint"></i></button>
                  </span>
                </div>
                <?php endif?>

                <?php if($_v[1]=='date'):?>
                <div class="input-group input-daterange">
                  <input type="text" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>">
                  <span class="input-group-append">
                    <button class="btn btn-light" type="button" onclick="getCalCheck('<?php echo $_key?>_<?php echo $_v[0]?>');"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
                <?php endif?>

                <?php if($_v[1]=='mediaset'):?>
                <div class="input-group">
                  <input type="text" class="form-control rb-modal-photo-drop js-tooltip" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>" onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>&dfiles='+this.value;" title="선택된 사진" data-toggle="modal" data-target="#modal_window">
                  <span class="input-group-append">
                    <button onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>';" class="btn btn-light rb-modal-photo-drop js-tooltip" type="button" title="포토셋" data-toggle="modal" data-target="#modal_window"><i class="fa fa-picture-o"></i></button>
                  </span>
                </div>
                <?php endif?>

                <?php if($_v[1]=='videoset'):?>
                <div class="input-group">
                  <input type="text" class="form-control rb-modal-video-drop js-tooltip" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>" onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>&dfiles='+this.value;" title="선택된 비디오" data-toggle="modal" data-target="#modal_window">
                  <span class="input-group-append">
                    <button onmousedown="_mediasetField='layout_<?php echo $_key?>_<?php echo $_v[0]?>';" class="btn btn-light rb-modal-video-drop js-tooltip" type="button" title="비디오셋" data-toggle="modal" data-target="#modal_window"><i class="fa fa-video-camera"></i></button>
                  </span>
                </div>
                <?php endif?>

                <?php if($_v[1]=='file'):?>
                <div class="input-group">
                  <input type="text" class="form-control" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>_name" value="<?php echo $d['layout'][$_key.'_'.$_v[0]]?>" onclick="$('#layout_<?php echo $_key?>_<?php echo $_v[0]?>').click();">
                  <input type="file" class="d-none" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" id="layout_<?php echo $_key?>_<?php echo $_v[0]?>" onchange="getId('layout_<?php echo $_key?>_<?php echo $_v[0]?>_name').value='파일 선택됨';">
                  <span class="input-group-append">
                    <button class="btn btn-light" type="button" onclick="$('#layout_<?php echo $_key?>_<?php echo $_v[0]?>').click();">
                      파일첨부
                    </button>
                  </span>
                </div>
                <?php if($d['layout'][$_key.'_'.$_v[0]]):?>
                <div style="padding:3px 0 0 2px;"><input type="checkbox" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>_del" value="1"> 현재파일 삭제</div>
                <?php endif?>
                <?php endif?>

                <?php if($_v[1]=='textarea'):?>
                <textarea type="text" rows="<?php echo $_v[3]?>" class="form-control" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>"><?php echo stripslashes($d['layout'][$_key.'_'.$_v[0]])?></textarea>
                <?php endif?>

                <?php if($_v[1]=='select'):?>
                <select name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" class="form-control custom-select">
                  <?php $_sk=explode(',',$_v[3])?>
                  <?php foreach($_sk as $_sa):?>
                  <?php $_sa1=explode('=',$_sa)?>
                  <option value="<?php echo $_sa1[1]?>"<?php if($d['layout'][$_key.'_'.$_v[0]] == $_sa1[1]):?> selected<?php endif?>><?php echo $_sa1[0]?></option>
                  <?php endforeach?>
                </select>
                <?php endif?>

                <?php if($_v[1]=='radio'):?>
                <?php $_sk=explode(',',$_v[3])?>
                <?php foreach($_sk as $_sa):?>
                <?php $_sa1=explode('=',$_sa)?>
                <label class="rb-rabel"><input type="radio" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" value="<?php echo $_sa1[1]?>"<?php if($d['layout'][$_key.'_'.$_v[0]] == $_sa1[1]):?> checked<?php endif?>> <?php echo $_sa1[0]?></label>
                <?php endforeach?>
                <?php endif?>

                <?php if($_v[1]=='checkbox'):?>
                <?php $_sk=explode(',',$_v[3])?>
                <?php foreach($_sk as $_sa):?>
                <?php $_sa1=explode('=',$_sa)?>
                <label class="rb-rabel"><input type="checkbox" name="layout_<?php echo $_key?>_<?php echo $_v[0]?>_chk[]" value="<?php echo $_sa1[1]?>"<?php if(strstr($d['layout'][$_key.'_'.$_v[0]],$_sa1[1])):?> checked<?php endif?>> <?php echo $_sa1[0]?></label>
                <?php endforeach?>
                <?php endif?>

                <?php if($_v[1]=='menu'):?>
                <select name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" class="form-control custom-select">
                  <option value="">사용안함</option>
                  <option value="" disabled>--------------------------------</option>
                  <?php include_once $g['path_core'].'function/menu1.func.php'?>
                  <?php $cat=$d['layout'][$_key.'_'.$_v[0]]?>
                  <?php getMenuShowSelectCode($s,$table['s_menu'],0,0,0,0,0,'')?>
                </select>
                <?php endif?>

                <?php if($_v[1]=='bbs'):?>
                <select name="layout_<?php echo $_key?>_<?php echo $_v[0]?>" class="form-control custom-select">
                  <option value="">사용안함</option>
                  <option value="" disabled>----------------------------------</option>
                  <?php $BBSLIST = getDbArray($table['bbslist'],'','*','gid','asc',0,1)?>
                  <?php while($R=db_fetch_array($BBSLIST)):?>
                  <option value="<?php echo $R['id']?>"<?php if($d['layout'][$_key.'_'.$_v[0]]==$R['id']):?> selected="selected"<?php endif?>>
                    ㆍ<?php echo $R['name']?>(<?php echo $R['id']?>)
                  </option>
                  <?php endwhile?>
                </select>
                <?php endif?>

              </div>
              <?php endforeach?>
              <?php endif?>

            </div>
            <?php $_i++;endforeach?>
          </div>

          <button type="button" data-act="submit" class="btn btn-outline-primary mt-3">
            <span class="not-loading">
              저장하기
            </span>
            <span class="is-loading">
              처리중...
            </span>
          </button>

        </div>
      </div>

    </form>

    <?php endif; ?>

  </div>
  <div class="col-4">

    <div data-role="widgetConfig" class="sticky-top d-none" style="z-index: 999;">
      <div data-role="form" class="my-3"></div>
    </div>

  </div>
</div><!-- /.row -->

<!-- nestable : https://github.com/dbushell/Nestable -->
<?php getImport('nestable','jquery.nestable',false,'js') ?>
<?php getImport('clipboard','clipboard.min','2.0.4','js') ?>

<script src="<?php echo $g['url_layout']?>/_js/settings.js"></script>
