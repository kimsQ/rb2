<?php
$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['path_module'].'post/var/var.php';
include_once $svfile;

if (!$d['post']['writeperm']) getLink('','','잘못된 접근입니다..','-1');

$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;
$where = 'subject|review|tag';
$postque = 'site='.$s;

if ($display) $postque .= ' and display='.$display;

if ($sort != 'gid') $orderby= 'desc';

if ($sort == 'gid' && !$keyword) {

	$postque .= ' and mbruid='.$my['uid'];
	$NUM = getDbRows($table['postmember'],$postque);
	$TCD = getDbArray($table['postmember'],$postque,'gid',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');

} else {

	$postque .= getSearchSql('members','['.$my['uid'].']',$ikeyword,'or');

	if ($where && $keyword) {
		if (strstr('[name][nic][id][ip]',$where)) $postque .= " and ".$where."='".$keyword."'";
		else if ($where == 'term') $postque .= " and d_regis like '".$keyword."%'";
		else $postque .= getSearchSql($where,$keyword,$ikeyword,'or');
	}

	$NUM = getDbRows($table['postdata'],$postque);
	$TCD = getDbArray($table['postdata'],$postque,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;

}

$TPG = getTotalPage($NUM,$recnum);

$g['post_base']	 = $g['s'].'/?r='.$r.'&amp;'.'m=post';
$g['post_reset']	= RW('mod=dashboard&page='.$page);
$g['post_list']	= $g['post_reset'].getLinkFilter('',array($sort!='gid'?'sort':'',$orderby!='asc'?'orderby':'',$display?'display':'',$keyword?'keyword':''));
$g['pagelink']	= $g['post_list'];
$g['post_view']	= $g['post_list'].'&amp;mod=view&amp;cid=';
$g['post_write'] = $g['post_list'].'&amp;mod=write';
$g['post_modify']= $g['post_write'].'&amp;cid=';
$g['post_action']= $g['post_base'].'&amp;a=';
$g['post_delete']= $g['post_action'].'delete&amp;cid=';

switch ($sort) {
	case 'gid'      : $sort_txt='등록순';break;
	case 'd_modify' : $sort_txt='최신순';break;
	case 'hit'      : $sort_txt='조회순';break;
	case 'likes'    : $sort_txt='좋아요순';break;
	case 'comment'  : $sort_txt='댓글순';break;
	default         : $sort_txt='기본';break;
}

?>

<div class="container">
	<div class="d-flex justify-content-between align-items-center subhead mt-0">
		<h3 class="mb-0">
			포스트 관리
		</h3>
		<div class="">
			<a href="<?php echo getProfileLink($my['uid']) ?><?php echo $_HS['rewrite']?'/':'&page=' ?>post" class="btn btn-white">
				<i class="fa fa-address-card-o fa-fw" aria-hidden="true"></i>
				프로필 이동
			</a>
			<?php if ($d['post']['writeperm']): ?>
			<a href="<?php echo RW('m=post&mod=write')?>" class="btn btn-primary">새 포스트</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="d-flex align-items-center border-top border-dark pt-4 pb-3" role="filter">
		<span class="f18">전체 <span class="text-primary"><?php echo number_format($NUM)?></span> 개</span>
		<form name="toolbarForm" action="<?php echo $g['post_reset'] ?>" method="get" class="form-inline ml-auto">

			<?php if (!$_HS['rewrite']): ?>
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="mod" value="dashboard">
			<?php endif; ?>

			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="sort" value="<?php echo $sort?>">
			<input type="hidden" name="display" value="<?php echo $display?>">

			<div class="dropdown mr-2" data-role="sort">
				<a class="btn btn-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					정열 : <?php echo $sort_txt ?>
				</a>

				<div class="dropdown-menu shadow-sm">
					<button class="dropdown-item<?php echo $sort=='gid'?' active':'' ?>" type="button" data-value="gid">
						등록순
					</button>
					<button class="dropdown-item<?php echo $sort=='d_modify'?' active':'' ?>" type="button" data-value="d_modify">
						최신순
					</button>
					<button class="dropdown-item<?php echo $sort=='hit'?' active':'' ?>" type="button" data-value="hit">
						조회순
					</button>
					<button class="dropdown-item<?php echo $sort=='likes'?' active':'' ?>" type="button" data-value="likes">
						좋아요순
					</button>
					<button class="dropdown-item<?php echo $sort=='comment'?' active':'' ?>" type="button" data-value="comment">
						댓글순
					</button>
				</div>
			</div>

			<label class="sr-only">상태</label>
			<div class="dropdown" data-role="display">
				<a class="btn btn-white dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					상태 : <?php echo $display?$g['displaySet']['label'][$display]:'전체' ?>
				</a>

				<div class="dropdown-menu shadow-sm">
					<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo !$display?' active':'' ?>" type="button">
						전체
						<small><?php echo number_format(getDbRows($table['postmember'],'mbruid='.$my['uid'].' and site='.$s))?></small>
					</button>
					<div class="dropdown-divider"></div>

					<?php $displaySet=explode('||',$d['displaySet'])?>
					<?php $i=1;foreach($displaySet as $displayLine):if(!trim($displayLine))continue;$dis=explode(',',$displayLine)?>
					<button class="dropdown-item d-flex justify-content-between align-items-center<?php echo $display==$i?' active':'' ?>" type="button" data-value="<?php echo $i ?>">
						<span>
							<i class="material-icons mr-1 f18 align-middle" aria-hidden="true"><?php echo $dis[1]?></i>
							<?php echo $dis[0]?>
						</span>
						<small><?php echo number_format(getDbRows($table['postmember'],'mbruid='.$my['uid'].' and site='.$s.' and display='.$i))?></small>
					</button>
					<?php $i++;endforeach?>

				</div>
			</div>

			<div class="input-group ml-2">
			  <input type="text" name="keyword" class="form-control" placeholder="제목,요약,태그 검색" value="<?php echo $keyword ?>">
			  <div class="input-group-append">
			    <button class="btn btn-white text-muted border-left-0" type="submit">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
					<?php if ($keyword): ?>
					<a href="<?php echo $g['post_reset']?>" class="btn btn-white">초기화</a>
					<?php endif; ?>
			  </div>
			</div>

		</form><!-- /.form-inline -->
	</div><!-- /.d-flex -->

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $m?>" />
		<input type="hidden" name="front" value="<?php echo $front?>" />
		<input type="hidden" name="a" value="" />

		<ul class="list-unstyled" style="margin-top: -1rem" data-plugin="markjs">
			<?php if (!empty($RCD)): ?>
			<?php foreach($RCD as $R):?>
		  <li class="media mt-4"
				data-role="item"
				data-featured_img="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'300x168'):getPreviewResize('/files/noimage.png','300x168') ?>"
				data-hit="<?php echo $R['hit']?>"
				data-likes="<?php echo $R['likes']?>"
				data-comment="<?php echo $R['comment']?>"
				data-subject="<?php echo checkPostPerm($R)?stripslashes($R['subject']):'[비공개 포스트]'?>">

				<a href="<?php echo getPostLink($R,0)?>" class="position-relative mr-3" target="_blank">
					<img class="" src="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'300x168'):getPreviewResize('/files/noimage.png','300x168') ?>" alt="" width="180">
					<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
					<span class="badge badge-primary rounded-0 position-absolute f14" style="left:1px;top:1px"><?php echo $R['mbruid']!=$my['uid']?'공유':'' ?></span>
				</a>

		    <div class="media-body">
		      <h5 class="my-1 line-clamp-2">
						<a href="<?php echo checkPostOwner($R)?RW('m=post&mod=write&cid='.$R['cid']):getPostLink($R,1) ?>" class="font-weight-light muted-link" <?php echo !checkPostOwner($R)?'target="_blank"':'' ?>>
							<?php echo checkPostPerm($R)?stripslashes($R['subject']):'[비공개 포스트]'?>
						</a>
					</h5>
					<?php if (checkPostPerm($R)): ?>
					<div class="mb-1">
						<ul class="list-inline d-inline-block f13 text-muted">
							<li class="list-inline-item">조회 <?php echo $R['hit']?> </li>
							<li class="list-inline-item">
								<a class="text-reset" href="#modal-post-opinion" data-toggle="modal" data-uid="<?php echo $R['uid']?>" data-opinion="like">
									좋아요 <?php echo $R['likes']?>
								</a>
							</li>
							<li class="list-inline-item">
								<a class="text-reset" href="#modal-post-opinion" data-toggle="modal" data-uid="<?php echo $R['uid']?>" data-opinion="dislike">
									싫어요 <?php echo $R['dislikes']?>
								</a>
							</li>
							<li class="list-inline-item">댓글 <?php echo $R['comment']?> </li>
							<li class="list-inline-item">
								<time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
							</li>
						</ul>

						<?php if ($R['category']): ?>
						<span class="ml-2 f13 text-muted">
							<i class="fa fa-folder-o mr-1" aria-hidden="true"></i> <?php echo getAllPostCat('post',$R['category']) ?>
						</span>
						<?php endif; ?>

						<span class="ml-2 f13 text-muted">
							<!-- 태그 -->
							<?php $_tags=explode(',',$R['tag'])?>
							<?php $_tagn=count($_tags)?>
							<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
							<?php $_tagk=trim($_tags[$i])?>
							<a class="badge badge-light" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>"><?php echo $_tagk?></a>
							<?php endfor?>
						</span>

					</div>
					<?php else: ?>
						<p class="text-muted py-3">
							이 포스트에 대한 액세스 권한이 없습니다.
						</p>
					<?php endif; ?>
		    </div>
				<div class="ml-3 align-self-center form-inline">

					<div class="dropdown mr-2" data-toggle="display" data-uid="<?php echo $R['uid'] ?>">
						<button class="btn btn-white btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-width: 8.3rem"<?php echo !checkPostOwner($R)?' disabled':'' ?>>
							<?php echo $g['displaySet']['label'][$R['display']] ?>
						</button>
						<div class="dropdown-menu dropdown-menu-right shadow" style="min-width: 8.3rem">
							<?php $displaySet=explode('||',$d['displaySet'])?>
							<?php $i=1;foreach($displaySet as $displayLine):if(!trim($displayLine))continue;$dis=explode(',',$displayLine)?>
							<button class="dropdown-item<?php echo $R['display']==$i?' active':'' ?>" type="button" data-display="<?php echo $i?>" data-label="<?php echo $dis[0]?>">
								<i class="material-icons mr-1 f18 align-middle" aria-hidden="true"><?php echo $dis[1]?></i>
								<?php echo $dis[0]?>
							</button>
							<?php $i++;endforeach?>
						</div>
					</div>

					<div class="dropdown">
						<button class="btn btn-white btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="min-width: 5rem"<?php echo !checkPostOwner($R)?' disabled':'' ?>>
							관리
						</button>
						<div class="dropdown-menu dropdown-menu-right shadow-sm" style="min-width: 5rem">
							<a class="dropdown-item" href="<?php echo RW('m=post&mod=write&cid='.$R['cid']) ?>" >수정</a>

							<?php if ($R['mbruid']==$my['uid']): ?>
							<a class="dropdown-item" href="<?php echo $g['post_delete'].$R['cid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?');">
								삭제
							</a>
							<?php endif; ?>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo getPostLink($R,1) ?>" target="_blank">보기</a>
							<a class="dropdown-item" href="#modal-post-analytics" data-toggle="modal" data-backdrop="static" data-uid="<?php echo $R['uid'] ?>">
								통계
							</a>
						</div>
					</div>
				</div>
		  </li>
			<?php endforeach?>
			<?php endif; ?>

			<?php if(!$NUM):?>
			<li>

				<div class="d-flex align-items-center justify-content-center" style="height: 40vh">
					<div class="text-muted">포스트가 없습니다.</div>
				</div>

			</li>
			<?php endif?>

		</ul>

		<div class="d-flex justify-content-between my-4">
			<div class=""></div>

			<?php if ($NUM > $recnum): ?>
			<ul class="pagination mb-0">
				<?php echo getPageLink(10,$p,$TPG,'')?>
			</ul>
			<?php endif; ?>

			<div class="">
			</div>
		</div>


	</form>
</div>

<?php include $g['path_module'].'post/mod/_component.desktop.php';?>

<script type="text/javascript">

putCookieAlert('post_action_result') // 실행결과 알림 메시지 출력

$(document).ready(function() {

	//공개상태 변경 dropdown
	$('[data-toggle="display"] .dropdown-item').click(function(){
    var button = $(this)
		var dropdown = button.closest('[data-toggle="display"]');
    var display = button.attr('data-display');
		var uid = dropdown.attr('data-uid');
		var label = button.attr('data-label');

		dropdown.find('.dropdown-item').removeClass('active');
		button.addClass('active');
		dropdown.find('.dropdown-toggle').text(label);

		$.post(rooturl+'/?r='+raccount+'&m=post&a=change_display',{
			uid : uid,
			display : display
			},function(response,status){
				if(status=='success'){
					$.notify({message: '공개상태가 변경되었습니다.'},{type: 'success'});
				} else {
					alert(status);
				}
		});
  });

	// 툴바
	$('[name="toolbarForm"] .dropdown-item').click(function(){
		var form = $('[name="toolbarForm"]');
		var value = $(this).attr('data-value');
		var role = $(this).closest('.dropdown').attr('data-role');
		form.find('[name="'+role+'"]').val(value)
		form.submit();
	});

	// marks.js
	$('[data-plugin="markjs"]').mark("<?php echo $keyword ?>");

});

</script>
