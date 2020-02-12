<?php
if (!$_SESSION['upsescode'])
{
  $_SESSION['upsescode'] = str_replace('.','',$g['time_start']);
}
$sescode = $_SESSION['upsescode'];
if($R['uid']){
    $u_arr = getArrayString($R['upload']);
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

if ($reply == 'Y') {
  $submit_btn = '답변';
  $submit_msg = '답변 게시물 등록중...';
  $title_text = '게시물 답변 · ';
}
else if ($uid) {
  $submit_btn = '수정';
  $submit_msg = '게시물 수정중...';
  $title_text = '게시물 수정 · ';
}
else {
  $submit_btn = '등록';
  $submit_msg = '게시물 등록중...';
  $title_text = '새 게시물';
}

?>

<?php include $g['dir_module_skin'].'_header.php'?>

<section class="rb-bbs-write">

	<article class="mt-4">
  	<form name="writeForm" method="post" action="<?php echo $g['s']?>/" onsubmit="return writeCheck(this);" role="form">
  		<input type="hidden" name="r" value="<?php echo $r?>">
  		<input type="hidden" name="a" value="write">
  		<input type="hidden" name="c" value="<?php echo $c?>">
  		<input type="hidden" name="cuid" value="<?php echo $_HM['uid']?>">
  		<input type="hidden" name="m" value="<?php echo $m?>">
  		<input type="hidden" name="bid" value="<?php echo $R['bbsid']?$R['bbsid']:$bid?>">
  		<input type="hidden" name="uid" value="<?php echo $R['uid']?>">
  		<input type="hidden" name="reply" value="<?php echo $reply?>">
  		<input type="hidden" name="nlist" value="<?php echo $g['bbs_list']?>">
  		<input type="hidden" name="pcode" value="<?php echo $date['totime']?>">
  		<input type="hidden" name="html" value="HTML">
      <input type="hidden" name="upfiles" id="upfilesValue" value="<?php echo $reply=='Y'?'':$R['upload']?>">
      <input type="hidden" name="featured_img" value="<?php echo $R['featured_img'] ?>">

      <?php if(!$my['id']):?>
      <div class="form-group">
        <label>이름</label>
        <input type="text" name="name" placeholder="이름을 입력해 주세요." value="<?php echo $R['name']?>" id="" class="form-control">
      </div>
      <?php if(!$R['uid']||$reply=='Y'):?>
      <div class="form-group">
        <label>암호</label>
        <input type="password" name="pw" placeholder="암호는 게시글 수정 및 삭제에 필요합니다." value="<?php echo $R['pw']?>" id="" class="form-control">
        <small class="form-text text-muted">비밀답변은 비번을 수정하지 않아야 원게시자가 열람할 수 있습니다.</small>
      </div>
      <?php endif?>
      <?php endif?>

      <?php if($B['category']):$_catexp = explode(',',$B['category']);$_catnum=count($_catexp)?>
  		<div class="form-group">
  			<label>카테고리</label>
        <select name="category" class="form-control custom-select">
          <option value="">&nbsp;+ <?php echo $_catexp[0]?>선택</option>
          <?php for($i = 1; $i < $_catnum; $i++):if(!$_catexp[$i])continue;?>
          <option value="<?php echo $_catexp[$i]?>"<?php if($_catexp[$i]==$R['category']||$_catexp[$i]==$cat):?> selected="selected"<?php endif?>>ㆍ<?php echo $_catexp[$i]?><?php if($d['theme']['show_catnum']):?>(<?php echo getDbRows($table[$m.'data'],'site='.$s.' and notice=0 and bbs='.$B['uid']." and category='".$_catexp[$i]."'")?>)<?php endif?></option>
          <?php endfor?>
        </select>
  		 </div>
  		 <?php endif?>

		    <div class="form-group">
					<label for="">제목</label>
          <input type="text" name="subject" placeholder="제목을 입력해 주세요." value="<?php echo $R['subject']?>" id="" class="form-control form-control-lg" autofocus>
        </div>

        <div class="form-group">
					<label class="sr-only"></label>
          <?php if($my['admin']):?>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" class="custom-control-input" id="notice" name="notice" value="1"<?php if($R['notice']):?> checked="checked"<?php endif?>>
            <label class="custom-control-label" for="notice">공지글</label>
          </div>
          <?php endif?>

          <?php if($d['theme']['use_hidden']==1):?>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" class="custom-control-input" id="hidden" name="hidden" value="1"<?php if($R['hidden']):?> checked<?php endif?>>
            <label class="custom-control-label" for="hidden">비밀글</label>
          </div>
          <?php elseif($d['theme']['use_hidden']==2):?>
          <input type="hidden" name="hidden" value="1">
          <?php endif?>
        </div>

        <div class="mb-3">
          <script>
          var attach_file_saveDir = '<?php echo $g['path_file']?>bbs/';// 파일 업로드 폴더
          var attach_module_theme = '<?php echo $d['bbs']['a_skin']?$d['bbs']['a_skin']: ($d['theme']['upload_theme']?$d['theme']['upload_theme']:$d['bbs']['attach_main']); ?>';// attach 모듈 테마  
          </script>
          <?php
            $__SRC__ = htmlspecialchars($R['content']);

            if ($g['broswer']!='MSIE 11' && $g['broswer']!='MSIE 10' && $g['broswer']!='MSIE 9') {
              include $g['path_plugin'].'ckeditor5/import.classic.php';
            } else {
              include $g['path_plugin'].'ckeditor/import.desktop.php';
            }
          ?>
        </div>

        <!-- 첨부파일 업로드 -->
        <?php if($d['theme']['show_upload']&&$d['theme']['perm_upload']<=$my['level']):?>
        <?php if ($d['bbs']['attach']): ?>
        <?php include $g['dir_module_skin'].'_uploader.php'?>
        <?php endif; ?>
        <?php endif?>


  		   <?php if($d['theme']['show_wtag']):?>
  			 <div class="form-group mt-4">
    				<label>태그<span class="rb-form-required text-danger"></span></label>
            <input class="form-control" type="text" name="tag" placeholder="검색태그를 입력해 주세요." value="<?php echo $R['tag']?>">
            <small class="form-text text-muted mt-2">이 게시물을 가장 잘 표현할 수 있는 단어를 콤마(,)로 구분해서 입력해 주세요. 첫번째 항목이 대표 태그로 활용됩니다.</small>
  			 </div>
         <?php endif?>

       <div class="form-group mt-5">
  				<label class="mr-3">등록 후</label>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="backtype1" name="backtype" value="list"<?php if(!$_SESSION['bbsback'] || $_SESSION['bbsback']=='list'):?> checked<?php endif?>>
            <label class="custom-control-label" for="backtype1">목록으로 이동</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="backtype2" name="backtype" value="view"<?php if($_SESSION['bbsback']=='view'):?> checked<?php endif?>>
            <label class="custom-control-label" for="backtype2">본문으로 이동</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" id="backtype3" name="backtype" value="now"<?php if($_SESSION['bbsback']=='now'):?> checked<?php endif?>>
            <label class="custom-control-label" for="backtype3">이 화면 유지</label>
          </div>
  			</div><!-- /.form-group -->

      <footer class="text-center my-5">
        <button class="btn btn-lg btn-light" type="button" onclick="cancelCheck();">취소</button>
        <button class="btn btn-lg btn-primary js-submit" type="submit">
          <?php echo $submit_btn ?>
        </button>
      </footer>

  	</form>
	</article>

</section>

<?php include $g['dir_module_skin'].'_footer.php'?>

<script type="text/javascript">


// 글 등록 함수
var submitFlag = false;

function writeCheck(f) {

	if (submitFlag == true) {
		alert('게시물을 등록하고 있습니다. 잠시만 기다려 주세요.');
		return false;
	}
	if (f.name && f.name.value == '') {
		alert('이름을 입력해 주세요. ');
		f.name.focus();
		return false;
	}
	if (f.pw && f.pw.value == '') {
		alert('암호를 입력해 주세요. ');
		f.pw.focus();
		return false;
	}

  <?php if ($B['category']): ?>
  if (f.category && f.category.value == '') {
    alert('카테고리를 선택해 주세요. ');
    f.category.focus();
    return false;
  }
  <?php endif; ?>

	if (f.subject.value == '') {
		alert('제목을 입력해 주세요.      ');
		f.subject.focus();
		return false;
	}
	if (f.notice && f.hidden) {
		if (f.notice.checked == true && f.hidden.checked == true) {
			alert('공지글은 비밀글로 등록할 수 없습니다.  ');
			f.hidden.checked = false;
			return false;
		}
	}

  var editorData = editor.getData();

  if (editorData == '')
  {
    alert('내용을 입력해 주세요.       ');
    editor.editing.view.focus();
    return false;
  } else {
    $('[name="content"]').val(editorData)
  }

  // 대표이미지가 없을 경우, 첫번째 업로드 사진을 지정함
  var featured_img_input = $('input[name="featured_img"]'); // 대표이미지 input
  var featured_img_uid = $(featured_img_input).val();
  if(!featured_img_uid){ // 대표이미지로 지정된 값이 없는 경우
    var first_attach_img_li = $('.rb-attach-photo li:first'); // 첫번째 첨부된 이미지 리스트 li
    var first_attach_img_uid = $(first_attach_img_li).data('id');
    featured_img_input.val(first_attach_img_uid);
  }

  // 첨부파일 uid 를 upfiles 값에 추가하기
  var attachfiles=$('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
  var new_upfiles='';
  if(attachfiles){
    for(var i=0;i<attachfiles.length;i++) {
      new_upfiles+=attachfiles[i];
    }
    $('input[name="upfiles"]').val(new_upfiles);
  }

  getIframeForAction(f);

  submitFlag = true;
  $('.js-submit').addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> <?php echo $submit_msg?>');
  return submitFlag;
}

function cancelCheck() {
	if (confirm('정말 취소하시겠습니까?    ')){
		history.back();
	}
}

document.title = '<?php echo $title_text ?> · <?php echo $B['name']?>';

</script>
