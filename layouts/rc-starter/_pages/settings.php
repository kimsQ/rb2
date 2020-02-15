<?php
checkAdmin(0);
include $g['dir_layout'].'_var/_var.config.php';
?>

<section class="page center" id="page-layout-settings">
  <header class="bar bar-nav bar-light bg-white p-x-0">
    <a data-href="/" class="icon icon-home pull-left p-x-1" role="button"></a>
    <button class="btn btn-link btn-nav pull-right px-4" data-act="submit">
      <span class="not-loading">
        저장
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="sr-only">저장중...</span>
        </div>
      </span>
    </button>
    <h1 class="title">
      <a data-location="reload" data-text="새로고침..">
        레이아웃 편집
      </a>
    </h1>
  </header>

  <main class="content bg-faded">

    <form action="<?php echo $g['s']?>/" method="post" enctype="multipart/form-data" target="_action_frame_<?php echo $m?>">
      <input type="hidden" name="r" value="<?php echo $r?>">
      <input type="hidden" name="m" value="<?php echo $m?>">
      <input type="hidden" name="a" value="regislayoutsite">
      <input type="hidden" name="send_mod" value="ajax">

      <ul class="table-view table-view-full border-top-0 bg-white" id="layout-settings-panels">
        <?php $_i=1;foreach($d['layout']['dom'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
        <li class="table-view-cell">
          <a class="navigate-right collapsed"
            data-toggle="collapse"
            data-parent="#layout-settings-panels"
            data-target="#layout-settings-<?php echo $__i?>-body"
            aria-expanded="true">
            <?php echo $_val[0]?>
          </a>
          <ul class="table-view collapse" id="layout-settings-<?php echo $__i?>-body" style="padding-right: 3.9rem">
            <li class="table-view-cell">
              <p class="text-muted small mb-1"><?php echo $_val[1]?></p>
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
                  <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button" onclick="$('#layout_<?php echo $_key?>_<?php echo $_v[0]?>').click();" style="padding: 0.5rem 0.75rem;font-size: 1rem;">
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
            </li>
          </ul>
        </li>
        <?php $_i++;endforeach?>

      </ul>

      <ul class="table-view table-view-full bg-white<?php echo $d['layout']['main_type']=='widget'?'':' d-none' ?>">
        <li class="table-view-cell" data-toggle="page" data-target="#page-widget-list" data-start="#page-layout-settings">
          <a class="navigate-right">
            <strong>메인 꾸미기</strong>
          </a>
        </li>
      </ul>
    </form>

  </main>
</section>

<section class="page right" id="page-widget-list">
  <header class="bar bar-nav bar-light bg-white p-x-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <button class="btn btn-link btn-nav pull-right px-4" data-act="submit">
      <span class="not-loading">
        저장
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="sr-only">저장중...</span>
        </div>
      </span>
    </button>
    <h1 class="title title-left" data-history="back">
      메인 꾸미기
    </h1>
  </header>

  <nav class="bar bar-tab bg-white shadow-sm">
    <a class="tab-item text-reset" role="button"
      data-toggle="sheet"
      href="#sheet-layoutreset-confirm"
      data-role="reset">
      초기화
    </a>
    <a class="tab-item text-reset border-left" role="button"
      data-toggle="modal"
      href="#modal-widget-selector"
      data-area="main">
      위젯 추가
    </a>
  </nav>

  <main class="content bg-faded">

    <form name="layoutMainPage" method="post" action="<?php echo $g['s']?>/" target="_action_frame_<?php echo $m?>"  class="" role="form">
      <input type="hidden" name="r" value="<?php echo $r?>">
      <input type="hidden" name="a" value="regislayoutpage">
      <input type="hidden" name="m" value="site">
      <input type="hidden" name="page" value="main">
      <input type="hidden" name="area" value="main_widgets">
      <input type="hidden" name="main_widgets" value="">
      <div data-role="widgetPage" data-plugin="sortable" data-area="main" class="ml-4"></div>
    </form>

  </main>
</section>

<section class="page right" id="page-widget-view">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <button class="btn btn-link btn-nav pull-right px-4" data-act="save">
      <span class="not-loading">
        저장
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="sr-only">저장중...</span>
        </div>
      </span>
    </button>
    <h1 class="title title-left" data-history="back">
      위젯 설정 <small class="text-muted ml-2" data-role="title"></small>
    </h1>
  </header>
  <div class="content bg-white" data-role="widgetConfig">
    <div class="content-padded pb-4" data-role="form">
    </div>
  </div>
</section>

<section class="page right" id="page-widget-makelist">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <button class="btn btn-link btn-nav pull-right px-4" data-act="submit">
      <span class="not-loading">
        만들기
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="sr-only">생성중...</span>
        </div>
      </span>
    </button>
    <h1 class="title title-left" data-history="back">
      새 리스트
    </h1>
  </header>
  <main class="content bg-white">

    <div class="form-list floating">
      <div class="input-row position-relative" style="padding: 6px 0 5px 16px;">
        <label class="w-100">리스트 명</label>
        <input type="text" placeholder="리스트 명" name="name" autocomplete="off">
        <div class="invalid-tooltip"></div>
      </div>
    </div>

  </main>
</section>

<section class="page right" id="page-widget-makebbs">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <button class="btn btn-link btn-nav pull-right px-4" data-act="submit">
      <span class="not-loading">
        만들기
      </span>
      <span class="is-loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="sr-only">생성중...</span>
        </div>
      </span>
    </button>
    <h1 class="title title-left" data-history="back">
      새 게시판
    </h1>
  </header>
  <main class="content bg-white">
    <form class="">
      <div class="form-list floating">
        <div class="input-row position-relative" style="padding: 6px 0 5px 16px;">
          <label class="w-100">게시판 아이디 <span class="ml-1">(영문 또는 숫자만)</span></label>
          <input type="text" placeholder="게시판 아이디" name="id" autocomplete="off">
          <div class="invalid-tooltip"></div>
        </div>
        <div class="input-row position-relative" style="padding: 6px 0 5px 16px;">
          <label class="w-100">게시판 이름</label>
          <input type="text" placeholder="게시판 이름" name="name" autocomplete="off">
          <div class="invalid-tooltip"></div>
        </div>
      </div>
    </form>
  </main>
</section>

<!-- 레이아웃 위젯탐색기 -->
<section id="modal-widget-selector" class="modal fast">
  <header class="bar bar-nav bar-light bg-white px-0">
    <a class="icon material-icons pull-left  px-3" role="button" data-history="back">arrow_back</a>
    <h1 class="title title-left" data-history="back">위젯 찾아보기</h1>
  </header>
  <div class="bar bar-standard bar-header-secondary bar-light bg-white px-0">
    <select class="form-control custom-select border-0" name="widget_selector" data-area="">
      <option value="">선택하세요.</option>
      <?php include $g['dir_layout'].'_var/_var.config.php'; ?>
      <?php $_i=1;foreach($d['layout']['widget'] as $_key => $_val):$__i=sprintf('%02d',$_i)?>
      <optgroup label="<?php echo $_val[0]?>">
        <?php foreach($_val[1] as $_v):?>
        <option value="<?php echo $_key ?>/<?php echo $_v[0]?>"><?php echo $_v[1]?></option>
        <?php endforeach?>
      </optgroup>
      <?php $_i++;endforeach?>
    </select>
  </div>
  <nav class="bar bar-tab bar-dark bg-primary d-none">
    <button class="btn btn-primary btn-block" role="button" data-act="apply">
      다음
    </button>
  </nav>
  <main class="content bg-faded">
    <blockquote class="content-padded py-3 blockquote text-muted" data-role="readme"></blockquote>
    <div data-role="none">
      <div class="d-flex justify-content-center align-items-center bg-light" style="height:370px">
        <div class="text-muted">
          <p>위젯을 선택해주세요.</p>
        </div>
      </div>
    </div>
    <div class="card mt-2 p-2 shadow-sm d-none" data-role="thumb">
      <img src="" alt=""  class="img-fluid" style="filter: grayscale(100%);">
    </div>
  </main>
</section>

<section id="sheet-layoutreset-confirm" class="sheet" style="top: 70vh;">
  <header class="bar bar-nav bar-inverse bg-primary">
    <h1 class="title title-left px-3">초기화 전 유의사항</h1>
  </header>
  <nav class="bar bar-tab bar-light bg-white">
    <a class="tab-item text-reset" role="button" data-history="back">
      취소
    </a>
    <a class="tab-item text-primary border-left" role="button" data-reset="main">
      확인
    </a>
  </nav>
  <main>
    <div class="content-padded py-3 text-xs-center text-muted">
      <p>모바일 메인 페이지를 초기 상태로 되돌립니다.</p>
    </div>
  </main>
</section>

<script src="<?php echo $g['url_layout']?>/_js/settings.js<?php echo $g['wcache']?>"></script>
