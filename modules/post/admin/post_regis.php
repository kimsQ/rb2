<?php

$R=array();
$upfile = '';

if ($uid) {
	$R=getUidData($table[$module.'data'],$uid);

  $u_arr = getArrayString($R['upfiles']);
  $_tmp=array();
  $i=0;
  foreach ($u_arr['data'] as $val) {
     $U=getUidData($table['s_upload'],$val);
     if(!$U['fileonly']) $_tmp[$i]=$val;
     $i++;
  }

  $insert_array='';
  // 중괄로로 재조립
  foreach ($_tmp as $uid) {
    $insert_array.='['.$uid.']';
  }
}

?>


<!-- smooth-scroll : https://github.com/cferdinandi/smooth-scroll -->
<?php getImport('smooth-scroll','smooth-scroll.polyfills.min','16.1.0','js') ?>

<div class="rb-post-regis<?php if($_SESSION['editor_sidebar']=='right'):?> rb-fixed-sidebar<?php endif?>">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $module?>">
		<input type="hidden" name="a" value="regis_post">
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>">
    <input type="hidden" name="category_members">
    <input type="hidden" name="upload" id="upfilesValue" value="<?php echo $R['upload']?>">
    <input type="hidden" name="featured_img" value="<?php echo $R['featured_img'] ?>">
		<input type="hidden" name="html" value="HTML">
		<input type="hidden" name="content" value="">

    <header class="d-flex justify-content-between align-items-center py-2 pl-4 pr-5 bg-white">
			<div class="form-group w-50 mb-0">
				<label class="sr-only">제목</label>
				<input type="text" name="subject" value="<?php echo $R['subject']?$R['subject']:'[제목없음]'?>" class="form-control-plaintext px-2 py-0" placeholder="제목을 입력하세요">
			</div>
      <div class="">
        <a class="btn btn-light" href="<?php echo $g['adm_href'] ?>&front=main" title="매장보기">
          포스트 목록
        </a>

        <?php if ($uid): ?>
        <a class="btn btn btn-outline-success" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;mod=view&amp;cid=<?php echo $R['cid']?>" target="_blank">
          보기
        </a>
        <?php endif; ?>
				<button type="button" class="btn btn-primary js-submit">
					<span class="not-loading">
						저장하기
					</span>
					<span class="is-loading"><i class="fa fa-spinner fa-lg fa-spin fa-fw"></i></span>
				</button>

      </div>
    </header>

		<main>
			<?php
				$__SRC__ = getContents($R['content'],$R['html']);
				include $g['path_plugin'].'ckeditor5/import.desktop.post.php';
			?>
		</main>

		<aside class="rb-attach-sidebar bg-white">

			<div class="sidebar-header d-flex justify-content-between align-items-center pt-1 px-2 position-absolute" style="top:1px;right:1px;">
				<div class=""></div>
				<button type="button" class="close js-closeSidebar btn" aria-label="Close" data-toggle="tooltip" title="첨부패널 닫기">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<ul class="nav nav-pills nav-fill" role="tablist">
        <li class="nav-item">
          <a class="nav-link rounded-0 border-top-0 border-left-0<?php if(!$_SESSION['editor_sidebar_tab']):?> active<?php endif?>" id="tab-file" data-toggle="tab" href="#pane-file" role="tab" aria-controls="file" aria-selected="true" onclick="sessionSetting('editor_sidebar_tab','','','');">
            첨부
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-0 border-top-0 <?php if($_SESSION['editor_sidebar_tab']=='link'):?> active<?php endif?>" id="tab-link" data-toggle="tab" href="#pane-link" role="tab" aria-controls="media" aria-selected="false" onclick="sessionSetting('editor_sidebar_tab','link','','');">
            링크
          </a>
        </li>
				<li class="nav-item">
					<a class="nav-link rounded-0 border-top-0 <?php if($_SESSION['editor_sidebar_tab']=='category'):?> active<?php endif?>" id="tab-category" data-toggle="tab" href="#pane-category" role="tab" aria-controls="media" aria-selected="false" onclick="sessionSetting('editor_sidebar_tab','category','','');">
						카테고리
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link rounded-0 border-top-0 <?php if($_SESSION['editor_sidebar_tab']=='toc'):?> active<?php endif?>" id="tab-toc" data-toggle="tab" href="#pane-toc" role="tab" aria-controls="media" aria-selected="false" onclick="sessionSetting('editor_sidebar_tab','toc','','');">
						목차
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link rounded-0 border-top-0 border-right-0<?php if($_SESSION['editor_sidebar_tab']=='cog'):?> active<?php endif?>" id="tab-cog" data-toggle="tab" href="#pane-cog" role="tab" aria-controls="media" aria-selected="false" onclick="sessionSetting('editor_sidebar_tab','cog','','');">
						설정
					</a>
				</li>
      </ul>

			<div class="tab-content mt-3">
				<div class="tab-pane px-2<?php if(!$_SESSION['editor_sidebar_tab']):?> show active <?php endif?>" id="pane-file" role="tabpanel">
					<?php getWidget('_default/attach',array('parent_module'=>'post','theme'=>'_desktop/bs4-default-attach','attach_handler_photo'=>'[data-role="attach-handler-photo"]','parent_data'=>$R,'attach_object_type'=>'file','wysiwyg'=>'Y'));?>

					<p>
						<small class="text-muted">
							사진,파일,비디오,오디오를 한번에 최대 최대 <?php echo str_replace('M','',ini_get('upload_max_filesize'))?>MB 까지 업로드 할수 있습니다.<br>

						</small>
					</p>
				</div>
				<div class="tab-pane px-2<?php if($_SESSION['editor_sidebar_tab']=='link'):?> show active <?php endif?>" id="pane-link" role="tabpanel">

					<?php getWidget('_default/attach',array('parent_module'=>'post','theme'=>'_desktop/bs4-default-link','attach_handler_photo'=>'[data-role="attach-handler-photo"]','parent_data'=>$R,'wysiwyg'=>'Y'));?>

				</div><!-- /.tab-pane -->
				<div class="tab-pane px-4<?php if($_SESSION['editor_sidebar_tab']=='toc'):?> show active <?php endif?>" id="pane-toc" role="tabpanel">

					<ul id="toc" class=" ck-toc list-unstyled"></ul>

				</div><!-- /.tab-pane -->

				<div class="tab-pane px-4<?php if($_SESSION['editor_sidebar_tab']=='category'):?> show active <?php endif?>" id="pane-category" role="tabpanel">
					<?php $_treeOptions=array('site'=>$s,'table'=>$table[$module.'category'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>true,'allOpen'=>true,'bookmark'=>'site-menu-info')?>
					<?php $_treeOptions['link'] = $g['adm_href'].'&amp;cat='?>
					<?php echo getTreePostCategoryCheck($_treeOptions,$uid,0,0,'')?>
				</div><!-- /.tab-pane -->

				<div class="tab-pane px-4<?php if($_SESSION['editor_sidebar_tab']=='cog'):?> show active <?php endif?>" id="pane-cog" role="tabpanel">

					<div class="form-group">
						<label class="sr-only">요약설명</label>
						<textarea class="form-control" rows="2" name="review" placeholder="요약설명을 입력하세요"><?php echo $R['review']?></textarea>
						<small class="form-text text-muted">500자 이내로 등록할 수 있으며 태그를 사용할 수 있습니다.</small>
					</div>


					<div class="form-group mt-4">
						<label class="sr-only">태그</label>
						<input type="text" name="tag" value="<?php echo $R['tag']?>" class="form-control"  placeholder="태그를 입력하세요">
						<small class="form-text text-muted">콤마(,)로 구분하여 입력해 주세요.</small>
					</div>

					<div class="card">
						<div class="card-header">
							연결메뉴
						</div>
						<div class="card-body">

							<select name="linkedmenu" class="form-control custom-select">
								<option value="">사용 안함</option>
								<option disabled>--------------------</option>
								<?php include_once $g['path_core'].'function/menu1.func.php'?>
								<?php $cat=$R['linkedmenu']?>
								<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
							</select>
							<small class="form-text text-muted">
								이 포스트를 메뉴에 연결하였을 경우 해당메뉴를 지정해 주세요.<br>
								연결메뉴를 지정하면 로케이션이 동기화 됩니다.
							</small>

						</div>
					</div>

					<div class="card">
						<div class="card-header">
							연결 상품
						</div>
						<div class="card-body">
							<input class="form-control" name="linkedshop" type="text" placeholder="연결할 상품" value="<?php echo $R['linkedshop']?>">
							<small class="form-text text-muted">
								[상품고유번호][상품고유번호].. 형식으로 입력해주세요
							</small>
						</div>
					</div>

				</div><!-- /.tab-pane -->

			</div><!-- /.tab-content -->

		</aside>

	</form>
</div>


<!-- 요약부분 글자수 체크 -->
<?php getImport('bootstrap-maxlength','bootstrap-maxlength.min',false,'js') ?>


<script type="text/javascript">

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

putCookieAlert('result_post_regis') // 실행결과 알림 메시지 출력

// $("#toc").toc({content: ".ck-content", headings: "h2,h3,h4"});

var scroll = new SmoothScroll('a[href*="#"]');

$(".js-openSidebar").click(function(){
	$('.rb-post-regis').addClass('rb-fixed-sidebar');
	sessionSetting('editor_sidebar','right','','');
});

$(".js-closeSidebar").click(function(){
	$('.rb-post-regis').removeClass('rb-fixed-sidebar');
	sessionSetting('editor_sidebar','','','');
	$('[data-toggle="tooltip"]').tooltip('hide')
});

$(".js-submit").click(function(e) {
	$(this).attr("disabled",true);

	var f = document.procForm;
	if (f.subject.value == '')
	{
		alert('제목 입력해 주세요.');
		f.subject.focus();
		return false;
	}

	var editorData = editor.getData();
	$('[name="content"]').val(editorData);

  // 카테고리 체크
	var cat_sel=$('input[name="tree_members[]"]');
	var cat_sel_n=cat_sel.length;
  var cat_arr=$('input[name="tree_members[]"]:checked').map(function(){return $(this).val();}).get();
	var cat_n=cat_arr.length;

	if(cat_sel_n>0 && cat_arr==''){
		alert('지정된 카테고리가 없습니다.\n적어도 하나이상의 카테고리를 지정해 주세요.');
		return false;
	} else {
    var s='';
    for (var i=0;i <cat_n;i++) {
      if(cat_arr[i]!='')  s += '['+cat_arr[i]+']';
    }
    f.category_members.value = s;
	}

  // 대표이미지가 없을 경우, 첫번째 업로드 사진을 지정함
  var featured_img_input = $('input[name="featured_img"]'); // 대표이미지 input
  var featured_img_uid = $(featured_img_input).val();
  if(featured_img_uid ==0){ // 대표이미지로 지정된 값이 없는 경우
    var first_attach_img_li = $('.rb-attach-photo li:first'); // 첫번째 첨부된 이미지 리스트 li
    var first_attach_img_uid = $(first_attach_img_li).attr('data-id');
    featured_img_input.val(first_attach_img_uid);
  }

  // 첨부파일 uid 를 upfiles 값에 추가하기
  var attachfiles=$('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
  var new_upfiles='';
  if(attachfiles){
    for(var i=0;i<attachfiles.length;i++) {
      new_upfiles+=attachfiles[i];
    }
    $('input[name="upload"]').val(new_upfiles);
  }

	// $("#toc").empty().toc({content: ".ck-content", headings: "h2,h3,h4"}); // TOC 갱신

	setTimeout(function(){
		getIframeForAction(f);
		f.submit();
	}, 500);



});



</script>
