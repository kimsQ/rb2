<section class="post-section row">

	<div class="col-8">

		<div class="mb-4">
			<oembed url="<?php echo getFeaturedimgMeta($R,'linkurl') ?>">
				<div class="bg-black d-flex align-items-center justify-content-center text-muted" style="height: 360px">
					<div class="spinner-border" role="status">
					  <span class="sr-only">Loading...</span>
					</div>
				</div>
			</oembed>
		</div>

		<!-- 태그 -->
		<?php if ($R['tag']): ?>
		<div>
			<?php $_tags=explode(',',$R['tag'])?>
			<?php $_tagn=count($_tags)?>
			<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
			<?php $_tagk=trim($_tags[$i])?>
			<a class="badge bg-white rounded-0 f13 font-weight-light border-0" href="<?php echo RW('m=post&mod=keyword&') ?>keyword=<?php echo urlencode($_tagk)?>">
			#<?php echo $_tagk?>
			</a>
			<?php endfor?>
		</div>
		<?php endif; ?>

		<h2 class="h5"><?php echo stripslashes($R['subject']) ?></h2>

		<div class="page-meta border-bottom pb-1 mb-4">
			<div class="d-flex justify-content-between align-items-center">

				<div class="mt-1 text-muted">
					<span>조회수 <?php echo number_format($R['hit'])?>회</span>
					<span class="badge badge-light align-middle border border-success text-success mr-1"><?php echo $g['projectSet']['type'][$R['type']] ?></span>
					<time class="mr-1">
						•<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'Y-m-d H:i') ?>
					</time>
				</div>
				<div class="">

					<!-- 좋아요 or 싫어요 -->
			    <?php if (!$R['dis_like']): ?>
					<span class="dropdown">
				    <button type="button" class="btn btn-link muted-link px-2 text-decoration-none<?php if($is_liked):?> active<?php endif?>"
							data-toggle="<?php echo $my['uid']?'button':'dropdown' ?>"
							data-act="<?php echo $my['uid']?'actionIframe':'dropdown'?>"
				      data-url="<?php echo $g['post_action']?>opinion&amp;opinion=like&amp;uid=<?php echo $R['uid']?>&amp;effect=heartbeat"
				      data-role="btn_post_like">
				      <i class="material-icons align-text-bottom">thumb_up</i>
				      <span data-role='likes_<?php echo $R['uid']?>' class="ml-1 f13 text-muted"><?php echo $R['likes']?$R['likes']:'좋아요'?></span>
				    </button>
						<div class="dropdown-menu shadow" style="min-width: 300px;">
							<div class="py-3 px-4">
								<h6>포스트가 마음에 드시나요?</h6>
								<p class="f13 text-muted mb-0">로그인하여 의견을 알려주세요.</p>
							</div>
							<div class="dropdown-divider"></div>
							<div class="px-3">
								<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modal-login">
									로그인
								</button>
							</div>
						</div>
					</span>

					<span class="dropdown">
				    <button type="button" class="btn btn-link muted-link px-2 text-decoration-none<?php if($is_disliked):?> active<?php endif?>"
							data-toggle="<?php echo $my['uid']?'button':'dropdown' ?>"
				      data-act="<?php echo $my['uid']?'actionIframe':'dropdown'?>"
				      data-url="<?php echo $g['post_action']?>opinion&amp;opinion=dislike&amp;uid=<?php echo $R['uid']?>&amp;effect=heartbeat"
				      data-role="btn_post_dislike">
				      <i class="material-icons align-text-bottom">thumb_down</i>
				      <span data-role='dislikes_<?php echo $R['uid']?>' class="ml-1 f13 text-muted"><?php echo $R['dislikes']?$R['dislikes']:'싫어요'?></span>
				    </button>
						<div class="dropdown-menu shadow" style="min-width: 300px;">
							<div class="py-3 px-4">
								<h6>포스트가 마음에 안 드시나요?</h6>
								<p class="f13 text-muted mb-0">로그인하여 의견을 알려주세요.</p>
							</div>
							<div class="dropdown-divider"></div>
							<div class="px-3">
								<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modal-login">
									로그인
								</button>
							</div>
						</div>
					</span>
			    <?php endif; ?>

					<?php if (!$R['dis_share']): ?>
					<button type="button" class="btn btn-link muted-link px-2 text-decoration-none"
						data-toggle="modal" data-target="#modal-post-share">
						<i class="material-icons align-text-bottom mirror">reply</i>
						<span class="f13 text-muted">공유</span>
					</button>
					<?php endif; ?>

					<?php if (!$R['dis_listadd']): ?>
					<span class="dropdown" data-role="listadd">
						<button type="button" class="btn btn-link muted-link px-2 text-decoration-none"
							data-toggle="<?php echo $my['uid']?'modal':'dropdown'?>"
							data-target="<?php echo $my['uid']?'#modal-post-listadd':''?>"
							data-uid="<?php echo $R['uid']?>">
							<i class="material-icons align-text-bottom">playlist_add</i>
							<span class="f13 text-muted">저장</span>
						</button>
						<div class="dropdown-menu shadow" style="min-width: 300px;">
							<div class="py-3 px-4">
								<h6>나중에 다시 보고 싶으신가요?</h6>
								<p class="f13 text-muted mb-0">로그인하여 포스트를 리스트에 추가하세요.</p>
							</div>
							<div class="dropdown-divider"></div>
							<div class="px-3">
								<button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modal-login">
									로그인
								</button>
							</div>
						</div>
					</span>
					<?php endif; ?>

					<?php if ($R['num_rating'] && !$R['disabled_rating']): ?>
					<span class="ml-2" data-toggle="tooltip" title="참여: <?php echo $R['num_rating'] ?>명 , 평점 <?php echo $R['rating']/$R['num_rating']?>" role="button">· <i class="fa fa-star-o" aria-hidden="true"></i>
					<a href="#" class="muted-link"> <?php echo $R['rating']/$R['num_rating']?></a></span>
					<?php endif; ?>

					<div class="dropdown d-inline">
					  <button class="btn btn-link muted-link px-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <i class="material-icons">more_horiz</i>
					  </button>
					  <div class="dropdown-menu dropdown-menu-right shadow">
					    <a class="dropdown-item" href="#modal-post-report" data-toggle="modal" data-uid="<?php echo $R['uid']?>">
								신고하기
							</a>
					  </div>
					</div>

				</div>
			</div><!-- /.page-meta-body -->
		</div>

		<div class="d-flex justify-content-between">

			<div class="media w-100" data-mbruid="<?php echo $R['mbruid'] ?>">
				<a href="<?php echo getProfileLink($R['mbruid']) ?>" class="mr-3">
			  	<img src="<?php echo getAvatarSrc($R['mbruid'],'48') ?>" class="rounded-circle" width="48" height="48" alt="<?php echo $M1[$_HS['nametype']] ?>의 프로필">
				</a>
			  <div class="media-body pt-1">

					<div class="d-flex justify-content-between">
						<div class="mb-2">
							<h6 class="mb-1">
								<a href="<?php echo getProfileLink($R['mbruid']) ?>" class="text-reset text-decoration-none"><?php echo $M1[$_HS['nametype']] ?></a>
							</h6>
							<p class="mb-0 text-muted f12">
								<?php if ($M1['num_follower']): ?>
								<a class="text-reset text-decoration-none" href="<?php echo getProfileLink($R['mbruid'])?>/follower">
									구독자
									<span data-role="num_follower"><?php echo number_format($M1['num_follower'])?></span>
									명
								</a>
								<?php else: ?>
								구독자 <span data-role="num_follower">없음</span>
								<?php endif; ?>
							</p>
						</div>
						<div data-role="item" data-featured_img="<?php echo getPreviewResize(getUpImageSrc($R),'180x100') ?>" data-subject="<?php echo stripslashes($R['subject'])?>">

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
		 					 <a href="<?php echo RW('m=post&mod=write&cid='.$R['cid']) ?>" class="btn btn-outline-primary">수정</a>
							 <?php endif; ?>

							 <?php endif?>

							 <?php if($my['uid']!=$R['mbruid']):?>
							 <button type="button" class="btn btn-primary<?php echo $_isFollowing ?' active':''?>"
								data-act="<?php echo $my['uid']?'actionIframe':'' ?>"
								data-toggle="<?php echo $my['uid']?'button':'dropdown' ?>"
								data-role="follow"
								data-url="<?php echo $g['s'].'/?r='.$r.'&amp;m=member&amp;a=profile_follow&amp;mbruid='.$M1['memberuid']?>">
								 구독
							 </button>
							 <div class="dropdown-menu dropdown-menu-right shadow" style="min-width: 350px;">
								 <div class="py-3 px-4">
									 <h6><?php echo $M1[$_HS['nametype']] ?>님의 포스트를 구독하시겠습니까?</h6>
									 <p class="f13 text-muted mb-0">구독하려면 로그인하세요.</p>
								 </div>
								 <div class="dropdown-divider"></div>
								 <div class="px-3 text-right">
									 <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#modal-login">
										 로그인
									 </button>
								 </div>
							 </div>
							 <?php endif?>
						</div>
					</div><!-- /.flex -->

					<!-- 본문 -->
					<article class="rb-article" data-plugin="shorten">
						<?php echo getContents($R['content'],$R['html'])?>

						<?php if ($R['category']): ?>
            <span class="ml-2 f13 text-muted">
              <i class="fa fa-folder-o mr-1" aria-hidden="true"></i> <?php echo getAllPostCat($m,$R['category']) ?>
            </span>
            <?php endif; ?>

					</article>

					<section class="mt-1">
						<?php include $g['dir_module_skin'].'_view_attach.php'?>
					</section>

			  </div>
			</div><!-- /.media -->

		</div><!-- /.d-flex -->

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
					<i class="material-icons mr-1 text-muted" style="font-size: 42px;">playlist_play</i>
					<div class="media-body">
						<h5 class="h6 mb-0 pb-0 pt-1">
							<?php echo $LIST['name'] ?>
						</h5>
				    <small class="text-muted line-clamp-1"><?php echo $LIST['review']?$LIST['review']:getProfileInfo($LIST['mbruid'],'name') ?></small>
					</div>
				</a><!-- /.media -->

		  </div>
		  <ul class="list-group list-group-flush">
				<?php foreach($LCD as $_L): ?>
				<a href="<?php echo getPostLink($_L,$mbrid?1:0).($GLOBALS['_HS']['rewrite']?'?':'&').'list='.$list ?>"
					class="list-group-item list-group-item-action p-1 pr-3 serial<?php echo $_L['cid']==$cid?' active':' bg-light' ?>">
					<div class="media">
						<span class="align-self-center pr-2 pl-1 f12 counter" style="width:20px"></span>
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

$( document ).ready(function() {

	$('[data-plugin="shorten"]').shorten({
		moreText: '더보기',
		lessText: ''
	});

	$('.rb-article').linkify({
		target: "_blank"
	});

});
</script>
