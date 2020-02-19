<?php include $g['dir_module_skin'].'_header.php'?>

<section class="rb-bbs-list">

  <header class="d-flex justify-content-between align-items-center my-4">
    <span class="text-muted">
      <small>총게시물 : <strong><?php echo number_format($NUM+count($NCD))?></strong> 건  (<?php echo $p?>/<?php echo $TPG?> page) </small>
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
    <table class="table text-center" data-role="bbs-list">
      <colgroup>
        <col width="7%">
        <col>
        <col width="15%">
        <col width="10%">
        <col width="10%">
      </colgroup>
      <thead class="thead-light">
        <tr>
          <th scope="col">번호</th>
          <th scope="col">제목</th>
          <th scope="col">글쓴이</th>
          <th scope="col">조회</th>
          <th scope="col">작성일</th>
        </tr>
      </thead>
      <tbody>

        <!-- 공지사항 출력부  -->
        <?php foreach($NCD as $R):?>
        <?php $R['mobile']=isMobileConnect($R['agent'])?>
        <tr class="table-light" id="item-<?php echo $R['uid'] ?>">
          <td>
            <?php if($R['uid'] != $uid):?>
            <span class="badge badge-light">공지</span>
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
            <span class="badge badge-light" data-toggle="tooltip" title="사진">
              <i class="fa fa-camera-retro fa-lg"></i>
            </span>
            <?php endif?>
            <?php if($R['upload']):?>
            <span class="badge badge-light" data-toggle="tooltip" title="첨부파일">
              <i class="fa fa-paperclip fa-lg"></i>
            </span>
            <?php endif?>
            <?php if($R['hidden']):?><span class="badge badge-light" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span><?php endif?>
            <?php if($R['comment']):?>
            <span class="badge badge-light" data-role="total_comment">
              <?php echo $R['comment']?><?php echo $R['oneline']?'+'.$R['oneline']:''?>
            </span>
            <?php endif?>
            <?php if(getNew($R['d_regis'],24)):?><span class="rb-new"></span><?php endif?>
          </td>
          <td>
            <?php if ($d['theme']['profile_link']): ?>
            <a class="muted-link" href="/@<?php echo $R['id'] ?>"
              data-toggle="getMemberLayer"
              data-uid="<?php echo $R['uid'] ?>"
              data-mbruid="<?php echo $R['mbruid'] ?>">
              <?php echo $R[$_HS['nametype']]?>
            </a>
            <?php else: ?>
            <?php echo $R[$_HS['nametype']]?>
            <?php endif; ?>
          </td>
          <td class="text-muted"><?php echo $R['hit']?></td>
          <td class="text-muted small">
            <time <?php echo $d['theme']['timeago']?'data-plugin="timeago"':'' ?> datetime="<?php echo getDateFormat($R['d_regis'],'c')?>">
              <?php echo getDateFormat($R['d_regis'],'Y.m.d')?>
            </time>
          </td>
        </tr>
        <?php endforeach?>

        <!-- 일반글 출력부 -->
        <?php foreach($RCD as $R):?>
        <?php $R['mobile']=isMobileConnect($R['agent'])?>
        <tr id="item-<?php echo $R['uid'] ?>">
          <td class="text-muted small">
            <?php if($R['uid'] != $uid):?>
            <?php echo $NUM-((($p-1)*$recnum)+$_rec++)?>
            <?php else:$_rec++?>
            <span class="now">&gt;&gt;</span>
            <?php endif?>
          </td>
          <td class="text-left">
            <?php if($R['depth']):?>
            <img src="<?php echo $g['img_core']?>/blank.gif" width="<?php echo ($R['depth']-1)*13?>" height="1">
            <span class="ico-replay"></span>
            <?php endif?>
            <?php if($R['mobile']):?>
            <span class="badge badge-light"><i class="fa fa-mobile fa-lg"></i></span>
            <?php endif?>
            <?php if($R['category']):?>
            <span class="badge badge-light"><?php echo $R['category']?></span>
            <?php endif?>

            <a href="<?php echo $g['bbs_view'].$R['uid']?>" class="muted-link">
              <?php echo getStrCut($R['subject'],$d['bbs']['sbjcut'],'')?>
            </a>

            <?php if(strstr($R['content'],'.jpg') || strstr($R['content'],'.png')):?>
            <span class="badge badge-light" data-toggle="tooltip" title="사진">
              <i class="fa fa-camera-retro fa-lg"></i>
            </span>
            <?php endif?>
            <?php if($R['upload']):?>
            <span class="badge badge-light" data-toggle="tooltip" title="첨부파일">
              <i class="fa fa-paperclip fa-lg"></i>
            </span>
            <?php endif?>
            <?php if($R['hidden']):?>
            <span class="badge badge-light" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span>
            <?php endif?>
            <?php if($R['comment']):?>
            <span class="badge badge-light" data-role="total_comment">
              <?php echo $R['comment']?><?php echo $R['oneline']?'+'.$R['oneline']:''?>
            </span>
            <?php endif?>
            <?php if(getNew($R['d_regis'],24)):?><span class="rb-new ml-1"></span><?php endif?>
          </td>
          <td>
            <?php if ($d['theme']['profile_link']): ?>
            <a class="muted-link" href="/@<?php echo $R['id'] ?>"
              data-toggle="getMemberLayer"
              data-uid="<?php echo $R['uid'] ?>"
              data-mbruid="<?php echo $R['mbruid'] ?>">
              <?php echo $R[$_HS['nametype']]?>
            </a>
            <?php else: ?>
            <?php echo $R[$_HS['nametype']]?>
            <?php endif; ?>
          </td>
          <td><?php echo $R['hit']?></td>
          <td class="text-muted small">
            <time <?php echo $d['theme']['timeago']?'data-plugin="timeago"':'' ?> datetime="<?php echo getDateFormat($R['d_regis'],'c')?>">
              <?php echo getDateFormat($R['d_regis'],'Y.m.d')?>
            </time>
          </td>
        </tr>
        <?php endforeach?>


        <?php if(!$NUM):?>
      	<tr>
        	<td class="text-muted p-5" colspan="5">
            게시물이 없습니다.
          </td>
      	</tr>
      	<?php endif?>


      </tbody>
    </table>
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

<script>
//검색어가 있을 경우 검색어 input focus
<?php if ($keyword): ?>
$('[name="keyword"]').focus()
<?php endif; ?>
</script>
