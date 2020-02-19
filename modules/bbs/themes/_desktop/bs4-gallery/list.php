<?php
// 화면크기에 따라 한열에 배치할 아이템갯수와 관련된 class 산출
$col_xl_num = 12 /$d['theme']['xl_item'] ;
$col_lg_num = 12 /$d['theme']['lg_item'] ;
$col_md_num = 12 /$d['theme']['md_item'] ;
$col_sm_num = 12 /$d['theme']['sm_item'] ;
$col_xs_num = 12 /$d['theme']['xs_item'] ;
$col_xl = $d['theme']['xl_item']?' col-xl-'.$col_xl_num:'';
$col_lg = $d['theme']['lg_item']?' col-lg-'.$col_lg_num:'';
$col_md = $d['theme']['md_item']?' col-md-'.$col_md_num:'';
$col_sm = $d['theme']['sm_item']?' col-sm-'.$col_sm_num:'';
$col_xs = $d['theme']['xs_item']?' col-xs-'.$col_xs_num:'';
?>

<?php include $g['dir_module_skin'].'_header.php'?>

<section class="rb-bbs-list">

  <header class="d-flex justify-content-between align-items-center my-4">
    <span class="text-muted">
      <small>총게시물 : <strong><?php echo number_format($NUM+count($NCD))?></strong> 건  (<?php echo $p?>/<?php echo $TPG?> page) </small>
      <?php if($d['bbs']['rss']):?>
      <a href="<?php echo $g['bbs_rss'] ?>" target="_blank" class="ml-2 muted-link">
        <i class="fa fa-rss-square" aria-hidden="true"></i> RSS
      </a>
      <?php endif?>
    </span>


    <form class="form-inline" name="bbssearchf" action="<?php echo $g['s']?>/">
      <input type="hidden" name="r" value="<?php echo $r?>">
      <input type="hidden" name="c" value="<?php echo $c?>">
      <input type="hidden" name="m" value="<?php echo $m?>">
      <input type="hidden" name="bid" value="<?php echo $bid?>">
      <input type="hidden" name="cat" value="<?php echo $cat?>">
      <input type="hidden" name="sort" value="<?php echo $sort?>">
      <input type="hidden" name="orderby" value="<?php echo $orderby?>">
      <input type="hidden" name="recnum" value="<?php echo $recnum?>">
      <input type="hidden" name="type" value="<?php echo $type?>">
      <input type="hidden" name="iframe" value="<?php echo $iframe?>">
      <input type="hidden" name="skin" value="<?php echo $skin?>">

      <!-- 카테고리 출력부  -->
      <?php if($B['category']):$_catexp = explode(',',$B['category']);$_catnum=count($_catexp)?>
      <select name="category" class="form-control custom-select mr-2" onchange="document.bbssearchf.cat.value=this.value;document.bbssearchf.submit();">
        <option value="">
          <?php echo $_catexp[0]?>
        </option>
        <?php for($i = 1; $i < $_catnum; $i++):if(!$_catexp[$i])continue;?>
        <option value="<?php echo $_catexp[$i]?>" <?php if($_catexp[$i]==$cat):?> selected="selected"
        <?php endif?>>
        <?php echo $_catexp[$i]?>
        <?php if($d['theme']['show_catnum']):?>(<?php echo getDbRows($table[$m.'data'],'site='.$s.' and notice=0 and bbs='.$B['uid']." and category='".$_catexp[$i]."'")?>)
        <?php endif?>
        </option>
        <?php endfor?>
      </select>
      <?php endif?>

      <!-- 검색창 출력부  -->
      <?php if($d['theme']['search']):?>
      <div class="input-group">
        <select class="custom-select" name="where"  style="width:100px">
          <option value="subject|tag"<?php if($where=='subject|tag'):?> selected="selected"<?php endif?>>제목+태그</option>
          <option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>본문</option>
          <option value="name"<?php if($where=='name'):?> selected="selected"<?php endif?>>이름</option>
          <option value="nic"<?php if($where=='nic'):?> selected="selected"<?php endif?>>닉네임</option>
          <option value="id"<?php if($where=='id'):?> selected="selected"<?php endif?>>아이디</option>
          <option value="term"<?php if($where=='term'):?> selected="selected"<?php endif?>>등록일</option>
        </select>
        <input type="text" class="form-control" name="keyword" value="<?php echo $_keyword?>" placeholder="검색어를 입력해주세요" style="width:200px">
        <div class="input-group-append">
          <button class="btn btn-light" type="submit">검색</button>
        </div>
        <?php if ($keyword): ?>
        <div class="input-group-append">
          <a class="btn btn-primary" href="<?php echo $g['bbs_reset'] ?>">리셋</a>
        </div>
        <?php endif; ?>
      </div>
      <?php endif?>

    </form>

  </header>

  <div class="table-responsive-md">
    <table class="table text-center">
      <colgroup>
        <col width="7%">
        <col>
        <col width="10%">
      </colgroup>
      <tbody>

        <!-- 공지사항 출력부  -->
        <?php foreach($NCD as $R):?>
        <?php $R['mobile']=isMobileConnect($R['agent'])?>
        <tr class="table-light">
          <td>
            <?php if($R['uid'] != $uid):?>
            <span class="badge badge-white">공지</span>
            <?php else:?>
            <span class="now">&gt;&gt;</span>
            <?php endif?>
          </td>
          <td class="text-left">
            <?php if($R['mobile']):?><i class="fa fa-mobile fa-lg"></i>
            <?php endif?>
            <?php if($R['category']):?>
            <span class="badge badge-secondary"><?php echo $R['category']?></span>
            <?php endif?>
            <a href="<?php echo $g['bbs_view'].$R['uid']?>" class="muted-link">
              <?php echo getStrCut($R['subject'],$d['bbs']['sbjcut'],'')?>
            </a>
            <?php if(strstr($R['content'],'.jpg') || strstr($R['content'],'.png')):?>
            <span class="badge badge-white" data-toggle="tooltip" title="사진">
              <i class="fa fa-camera-retro fa-lg"></i>
            </span>
            <?php endif?>
            <?php if($R['upload']):?>
            <span class="badge badge-white" data-toggle="tooltip" title="첨부파일">
              <i class="fa fa-paperclip fa-lg"></i>
            </span>
            <?php endif?>
            <?php if($R['hidden']):?><span class="badge badge-white" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span><?php endif?>
            <?php if($R['comment']):?><span class="badge badge-white"><?php echo $R['comment']?><?php echo $R['oneline']?'+'.$R['oneline']:''?></span><?php endif?>
            <?php if(getNew($R['d_regis'],24)):?><span class="rb-new ml-1"></span><?php endif?>
          </td>
          <td class="text-muted small"><?php echo getDateFormat($R['d_regis'],'Y.m.d')?></td>
        </tr>
        <?php endforeach?>

      </tbody>
    </table>


    <?php if ($NUM): ?>
      <div class="row gutter-half">
      <!-- 일반글 출력부 -->
      <?php foreach($RCD as $R):?>
      <?php
      $R['mobile']=isMobileConnect($R['agent']);
      $d['upload'] = getArrayString($R['upload']);
      ?>
      <div class="<?php echo $col_xl.$col_lg.$col_md.$col_sm.$col_xs ?>">
        <div class="card" id="item-<?php echo $R['uid']?>">

          <a class="position-relative" href="<?php echo $g['bbs_view'].$R['uid']?>">
            <img src="<?php echo getPreviewResize(getUpImageSrc($R),'640x360') ?>" alt="" class="card-img-top">
            <div class="card-img-overlay opacity-0">
              <div class="d-flex flex-column w-100 h-100">
                <?php if ($R['hidden']): ?>
                <div class="rb-hidden">
                  <i class="fa fa-lock fa-fw"></i>
                </div>
                <?php else: ?>

                <?php if($R['category']):?>
                <h2 class="align-self-start list-inline mb-auto mr-auto mb-0">
                  <span class="badge badge-pill badge-secondary">
                    <?php echo $R['category']?>
                  </span>
                </h2>
                <?php endif?>

                <ul class="align-self-end list-inline mt-auto ml-auto mb-0">
                  <li class="list-inline-item">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                     <span data-role="likes"><?php echo $R['likes']?></span>
                  </li>
                  <li class="list-inline-item">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    <?php echo $R['hit']?>
                  </li>
                  <li class="list-inline-item">
                    <i class="fa fa-clone" aria-hidden="true"></i>
                    <?php echo $d['upload']['count'] ?>
                  </li>
                  <li class="list-inline-item">
                    <i class="fa fa-comment-o" aria-hidden="true"></i>
                    <span data-role="total_comment"><?php echo $R['comment']?></span>
                  </li>
                </ul>
                <?php endif; ?>
              </div>
            </div>
          </a><!-- /.position-relative -->

          <div class="card-body">
            <a class="muted-link" href="<?php echo $g['bbs_view'].$R['uid']?>">
              <?php echo getStrCut($R['subject'],100,'')?>
            </a>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="text-muted">
              <a class="muted-link" href="/@<?php echo $R['id'] ?>"
                data-toggle="getMemberLayer"
                data-uid="<?php echo $R['uid'] ?>"
                data-mbruid="<?php echo $R['mbruid'] ?>">
                <?php echo $R[$_HS['nametype']]?>
              </a>
            </span>
            <small class="text-muted">
              <time <?php echo $d['theme']['timeago']?'data-plugin="timeago"':'' ?> datetime="<?php echo getDateFormat($R['d_regis'],'c')?>">
                <?php echo getDateFormat($R['d_regis'],'Y.m.d')?>
              </time>
              <?php if(getNew($R['d_regis'],24)):?><span class="rb-new ml-1"></span><?php endif?>
            </small>
          </div>
        </div><!-- /.card -->
      </div>
      <?php endforeach?>
    </div>

    <?php else: ?>
    <div class="d-flex align-items-center justify-content-center text-muted" style="height: 350px">
      <div class="text-xs-center">
        <div class="display-1">
          <i class="fa fa-folder-open-o" aria-hidden="true"></i>
        </div>
        <p>게시물이 없습니다.</p>
      </div>
    </div>
    <?php endif; ?>

  </div>

  <footer class="d-flex justify-content-between align-items-center my-5">
    <div class="btn-group">
      <a class="btn btn-light" href="<?php echo $g['bbs_reset']?>">처음목록</a>
      <a class="btn btn-light" href="<?php echo $g['bbs_list']?>">새로고침</a>
    </div>
    <ul class="pagination mb-0">
      <?php echo getPageLink($d['theme']['pagenum'],$p,$TPG,'')?>
    </ul>
    <?php if($B['uid']):?>
    <a class="btn btn-light" href="<?php echo $g['bbs_write']?>"><i class="fa fa-pencil"></i> 글쓰기</a>
    <?php endif?>
  </footer>

</section>

<?php include $g['dir_module_skin'].'_footer.php'?>

<!-- 댓글 출력관련  -->
<link href="<?php echo $g['url_root']?>/modules/comment/themes/_desktop/bs4-modal/css/style.css<?php echo $g['wcache']?>" rel="stylesheet">

<!-- 포토모달(댓글포함) 오픈 -->
<script src="<?php echo $g['url_module_skin'] ?>/js/openGallery.js<?php echo $g['wcache']?>" ></script>

<script>
$(function () {

  //검색어가 있을 경우 검색어 input focus
  <?php if ($keyword): ?>
  $('[name="keyword"]').focus()
  <?php endif; ?>

  <?php if (!$c): ?>
  document.title = '<?php echo $B['name']?> · <?php echo $g['browtitle']?>'  // 브라우저 타이틀 재설정
  <?php endif; ?>

})


</script>
