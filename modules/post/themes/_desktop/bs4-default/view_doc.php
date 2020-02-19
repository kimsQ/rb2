<section class="post-section row">

	<div class="col-8">

		<h2 class="h3"><?php echo stripslashes($R['subject']) ?></h2>

		<div class="page-meta f13">
	    <div class="page-meta-body">
	      <div class="project-meta">

	        <span class="badge badge-light align-middle border border-success text-success mr-1"><?php echo $g['projectSet']['type'][$R['type']] ?></span>
	        <time class="js-timeago mr-1 text-muted js-tooltip" title="등록일시">
	          <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo getDateFormat($R['d_regis'],'Y-m-d H:i') ?>
	        </time>
	        <?php if($R['d_modify']):?>
	        <time class="text-muted f12">
	          (<?php echo '수정 : '.getDateFormat($R['d_modify'],'Y-m-d H:i') ?>)
	        </time>
	        <?php endif?>

					<?php if (!$R['disabled_comment']): ?>
					<span class="ml-2">· 댓글 : <a class="muted-link" href="#comments"><?php echo $R['comment']?></a></span>
					<?php endif; ?>

	        <span class="ml-2">
	          조회 : <?php echo $R['hit']?>
	        </span>

					<?php if (!$R['disabled_like']): ?>
					<span class="ml-2">· <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span class="text-muted" data-role=like_num><?php echo $R['likes']?></span></span>
					<?php endif; ?>

					<?php if ($R['num_rating'] && !$R['disabled_rating']): ?>
					<span class="ml-2" data-toggle="tooltip" title="참여: <?php echo $R['num_rating'] ?>명 , 평점 <?php echo $R['rating']/$R['num_rating']?>" role="button">· <i class="fa fa-star-o" aria-hidden="true"></i>
					<a href="#" class="muted-link"> <?php echo $R['rating']/$R['num_rating']?></a></span>
					<?php endif; ?>

	      </div>
	    </div><!-- /.page-meta-body -->
	  </div>

		<blockquote class="blockquote mt-4">
			<?php echo $R['review'] ?>
		</blockquote>

		<!-- 본문 -->
		<article class="py-4 rb-article">
			<?php echo getContents($R['content'],$R['html'])?>
		</article>

		<section class="mt-4">
			<?php include $g['dir_module_skin'].'_view_attach.php'?>
		</section>

		<div class="my-4 text-center d-print-none">
			<!-- 스크탭-->
			<button type="button" class="btn btn-white <?php if($is_saved):?> active<?php endif?>"
				data-toggle="button"
				data-act="actionIframe"
				data-url="<?php echo $g['post_action']?>saved&amp;uid=<?php echo $R['uid']?>"
				data-role="btn_post_saved">
				<i class="material-icons align-middle">bookmark_border</i> 저장
			</button>

			<!-- 좋아요 or 싫어요 -->
			<?php if (!$R['dis_like']): ?>
			<button type="button" class="btn btn-white<?php if($is_liked):?> active<?php endif?>"
				data-toggle="button"
				data-act="actionIframe"
				data-url="<?php echo $g['post_action']?>opinion&amp;opinion=like&amp;uid=<?php echo $R['uid']?>&amp;effect=heartbeat"
				data-role="btn_post_like">
				<i class="material-icons align-middle">thumb_up</i> <strong></strong>
				<span data-role='likes_<?php echo $R['uid']?>' class="badge badge-inverted"><?php echo $R['likes']?></span>
			</button>

			<button type="button" class="btn btn btn-white<?php if($is_disliked):?> active<?php endif?>"
				data-toggle="button"
				data-act="actionIframe"
				data-url="<?php echo $g['post_action']?>opinion&amp;opinion=dislike&amp;uid=<?php echo $R['uid']?>&amp;effect=heartbeat"
				data-role="btn_post_dislike">
				<i class="material-icons align-middle">thumb_down</i> <strong></strong>
				<span data-role='dislikes_<?php echo $R['uid']?>' class="badge badge-inverted"><?php echo $R['dislikes']?></span>
			</button>
			<?php endif; ?>
		</div>

		<!-- 태그 -->
		<?php if ($R['tag']): ?>
		<div class="">
			<?php $_tags=explode(',',$R['tag'])?>
			<?php $_tagn=count($_tags)?>
			<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
			<?php $_tagk=trim($_tags[$i])?>
			<a class="badge badge-light rounded-0 f15 font-weight-light bg-light border-0 py-2" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>">
			#<?php echo $_tagk?>
			</a>
			<?php endfor?>
		</div>
		<?php endif; ?>

		<!-- 작성자 정보 -->
		<div class="text-center my-4 py-5 border-top">
			<a href="<?php echo getProfileLink($R['mbruid']) ?>" class="text-reset text-decoration-none">
				<img class="mb-3 rounded-circle border" src="<?php echo getAvatarSrc($R['mbruid'],'64') ?>" width="64" height="64" alt="<?php echo $M1[$_HS['nametype']] ?>의 프로필">
				<h5 class="mb-1"><?php echo $M1[$_HS['nametype']] ?></h5>
				<span class="f13 text-muted"><?php echo $M1['bio'] ?></span>
			</a>
		</div>

		<!-- 링크 공유 -->
		<div class="my-4 d-print-none text-center">
			<?php include $g['dir_module_skin'].'_linkshare.php'?>
		</div>

		<footer class="d-flex justify-content-between align-items-center my-5 d-print-none">
			<div data-role="item" data-featured_img="<?php echo getPreviewResize(getUpImageSrc($R),'180x100') ?>" data-subject="<?php echo $R['subject'] ?>">
				 <?php if($_perm['post_owner']):?>

					 <?php if ($R['likes'] || $R['dislikes']): ?>
					 <button type="button" class="btn btn btn-outline-primary"
						data-target="#modal-post-opinion"
						data-opinion="like"
						data-toggle="modal"
						data-uid="<?php echo $R['uid'] ?>">
						 좋아요 내역
					 </button>
					 <?php endif; ?>

					 <?php if ($d['post']['writeperm']): ?>
						<button type="button" class="btn btn btn-outline-primary"
						 data-target="#modal-post-analytics"
						 data-toggle="modal"
						 data-uid="<?php echo $R['uid'] ?>">
							분석
						</button>

						<a href="<?php echo RW('m=post&mod=write&cid='.$R['cid']) ?>" class="btn btn-primary">수정</a>
						<?php endif; ?>
					<?php endif?>
			 </div>
			 <div class="">
				 <button type="button" class="btn btn-white" data-history="back">이전가기</button>
			 </div>

		</footer>

		<?php if (!$R['dis_comment']): ?>
		<aside class="border-top mt-4 pt-4">
			<?php include $g['dir_module_skin'].'_comment.php'?>
		</aside>
		<?php endif; ?>


	</div><!-- /.col -->

	<div class="col-4 pr-0">

		<?php if ($list): ?>
		<?php
		$LIST=getDbData($table[$m.'list'],"id='".$list."'",'*');
		$_WHERE = 'site='.$s;
		$_WHERE .= ' and list="'.$LIST['uid'].'"';
		$TCD = getDbArray($table[$m.'list_index'],$_WHERE,'*','gid','asc',11,1);
		$NUM = getDbRows($table[$m.'list_index'],$_WHERE);
		while($_R = db_fetch_array($TCD)) $LCD[] = getDbData($table[$m.'data'],'uid='.$_R['data'],'*');
		?>

		<div class="card mb-4 shadow-sm">
		  <div class="card-body px-2 pt-2 pb-1">

				<a href="<?php echo getListLink($LIST,$mbrid?1:0) ?>" class="media text-reset text-decoration-none">
					<i class="material-icons mr-1 text-muted" style="font-size: 34px;">playlist_play</i>
					<div class="media-body">
						<h5 class="h6 mb-0">
							<?php echo $LIST['name'] ?>
						</h5>
				    <small class="text-muted"><?php echo $MBR['name'] ?></small>
					</div>
				</a><!-- /.media -->

		  </div>
		  <ul class="list-group list-group-flush">
				<?php foreach($LCD as $_L): ?>
				<a href="<?php echo getPostLink($_L,$mbrid?1:0).($GLOBALS['_HS']['rewrite']?'?':'&').'list='.$list ?>"
					class="list-group-item list-group-item-action p-1 pr-3 serial<?php echo $_L['cid']==$cid?' active':' bg-light' ?>">
					<div class="media">
						<span class="align-self-center pr-2 pl-1 f12 counter"></span>
						<span class="position-relative mr-2">
		          <img class="" src="<?php echo getPreviewResize(getUpImageSrc($_L),'100x56') ?>" alt="">
		          <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo getUpImageTime($_L) ?></time>
		        </span>

		        <div class="media-body">
		          <h5 class="f13 my-1 font-weight-light line-clamp-2">
		            <?php echo stripslashes($_L['subject'])?>
		          </h5>
							<ul class="list-inline d-inline-block f13">
								<li class="list-inline-item">
									<time data-plugin="timeago" datetime="<?php echo getDateFormat($_L['d_regis'],'c')?>"></time>
								</li>
							</ul>
		        </div>
					</div>
				</a>
				<?php endforeach; ?>

		  </ul>
		</div>
		<?php endif; ?>

		<?php include $g['dir_module_skin'].'_newPost.php' ?>


		<?php include $g['dir_module_skin'].'_newList.php' ?>


	</div><!-- /.col -->

</section>


<!-- jquery.shorten : https://github.com/viralpatel/jquery.shorten -->
<?php getImport('jquery.shorten','jquery.shorten.min','1.0','js')?>

<script>
$('[data-plugin="shorten"]').shorten({
	moreText: '더보기',
	lessText: ''
});
</script>
