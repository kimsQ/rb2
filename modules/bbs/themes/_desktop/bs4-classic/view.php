<?php include $g['dir_module_skin'].'_header.php'?>

<section class="rb-bbs-view">

	<header>

		<div class="media">
			<span class="mr-3">
				<img class="border rounded" src="<?php echo getAvatarSrc($R['mbruid'],'55') ?>" width="55" height="55" alt="">
			</span>

		  <div class="media-body">
				<h1 class="h4 mt-0">
					<?php if($R['category']):?>
					<span class="badge badge-light"><?php echo $R['category']?></span>
					<?php endif?>
					<?php echo $R['subject']?>
					<?php if($R['hidden']):?>
					<span class="badge badge-white" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span>
					<?php endif?>
				</h1>

				<div class="d-flex justify-content-between mt-2">
			 		<ul class="rb-meta list-inline mb-0 text-muted">
			 			<li class="list-inline-item">
							<?php if ($d['theme']['profile_link']): ?>
							<a class="muted-link" href="#"
								data-toggle="getMemberLayer"
								data-uid="<?php echo $R['uid'] ?>"
								data-mbruid="<?php echo $R['mbruid'] ?>">
								<?php echo $R[$_HS['nametype']]?>
							</a>
							<?php else: ?>
							<?php echo $R[$_HS['nametype']]?>
							<?php endif; ?>
						</li>
						<li class="list-inline-item rb-divider"></li>
			 			<li class="list-inline-item"><?php echo getDateFormat($R['d_regis'],$d['theme']['date_viewf'])?></li>
						<li class="list-inline-item rb-divider"></li>
			 			<li class="list-inline-item">조회 : <?php echo $R['hit']?></li>
			 		</ul>

			 		<div class="btn-group d-print-none">
			 			<?php if($d['theme']['show_report']):?>
			 			<a class="btn btn-link muted-link" href="<?php echo $g['bbs_action']?>singo&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 신고하시겠습니까?');">
							<i class="fa fa-meh-o"></i> 신고
						</a>
			 			<?php endif?>
			 			<?php if($d['theme']['show_saved']):?>
						<button type="button" class="btn btn-link muted-link<?php if($is_saved):?> active<?php endif?>"
							data-toggle="actionIframe"
							data-url="<?php echo $g['bbs_action']?>saved&amp;uid=<?php echo $R['uid']?>"
							data-role="btn_post_saved">
							<i class="fa fa-bookmark-o"></i> 저장
						</button>
			 			<?php endif?>
						<?php if($d['theme']['show_print']):?>
						<button class="btn btn-link  muted-link" data-toggle="print" type="button"><i class="fa fa-print"></i> 인쇄</button>
			 			<?php endif?>
			 		</div>
			 	</div><!-- /.d-flex -->
		  </div><!-- /.media-body -->
		</div><!-- /.media -->

	</header>

	<!-- 본문 -->
	<article class="py-4 rb-article">
		<?php echo getContents($R['content'],$R['html'])?>
	</article>

	<!-- 좋아요 or 싫어요 -->
	<div class="text-center d-print-none">
		<?php if($d['theme']['show_like']):?>
		<button type="button" class="btn btn-light<?php if($is_liked):?> active<?php endif?>"
			data-toggle="actionIframe"
			data-url="<?php echo $g['bbs_action']?>opinion&amp;opinion=like&amp;uid=<?php echo $R['uid']?>&amp;effect=heartbeat"
			data-role="btn_post_like">
			<i class="fa fa fa-heart-o fa-fw" aria-hidden="true"></i> <strong></strong>
			<span data-role='likes_<?php echo $R['uid']?>' class="badge badge-inverted"><?php echo $R['likes']?></span>
		</button>
		<?php endif?>

		<?php if($d['theme']['show_dislike']):?>
		<button type="button" class="btn btn btn-light<?php if($is_disliked):?> active<?php endif?>"
			data-toggle="actionIframe"
			data-url="<?php echo $g['bbs_action']?>opinion&amp;opinion=dislike&amp;uid=<?php echo $R['uid']?>&amp;effect=heartbeat"
			data-role="btn_post_dislike">
			<i class="fa fa-thumbs-o-down fa-fw" aria-hidden="true"></i> <strong></strong>
			<span data-role='dislikes_<?php echo $R['uid']?>' class="badge badge-inverted"><?php echo $R['dislikes']?></span>
		</button>
		<?php endif?>
	</div>

	<!-- 링크 공유 -->
	<?php if($d['theme']['show_share']):?>
	<div class="mt-4 d-print-none text-center">
		<?php include $g['dir_module_skin'].'_linkshare.php'?>
	</div>
	<?php endif?>

	<!-- 태그 -->
	<?php if($R['tag']&&$d['theme']['show_tag']):?>
	<div class="">
		<?php $_tags=explode(',',$R['tag'])?>
		<?php $_tagn=count($_tags)?>
		<?php $i=0;for($i = 0; $i < $_tagn; $i++):?>
		<?php $_tagk=trim($_tags[$i])?>
		<a class="badge badge-secondary" href="<?php echo $g['bbs_orign']?>&amp;where=subject|tag&amp;keyword=<?php echo urlencode($_tagk)?>">
		<?php echo $_tagk?>
		</a>
		<?php endfor?>
	</div>
	<?php endif?>

	<!-- 첨부파일 인클루드 -->
	<?php if($d['upload']['data']&&$d['theme']['show_upfile']&&$attach_file_num>0):?>
	<aside class="mt-4">
		<?php include $g['dir_module_skin'].'_attachment.php'?>
	</aside>
	<?php endif?>

	<footer class="d-flex justify-content-between align-items-center mt-3 d-print-none">
		<div class="btn-group">
			 <?php if($my['admin'] || $my['uid']==$R['mbruid']):?>
				 <a href="<?php echo $g['bbs_modify'].$R['uid']?>" class="btn btn-light">수정</a>
				 <a href="<?php echo $g['bbs_delete'].$R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?');" class="btn btn-light">삭제</a>
				<?php endif?>
				<?php if($my['admin']&&$d['theme']['use_reply']):?>
				<a href="<?php echo $g['bbs_reply'].$R['uid']?>" class="btn btn-light">답변</a>
				<?php endif?>
		 </div>
		 <a href="<?php echo $g['bbs_list']?>" class="btn btn-light">목록</a>
	</footer>


	<!-- 댓글 인클루드 -->
	<?php if(!$d['bbs']['c_hidden']):?>
	<aside class="mt-4">
		<?php include $g['dir_module_skin'].'_comment.php'?>
	</aside>
	<?php endif?>

</section>

<?php include $g['dir_module_skin'].'_footer.php'?>

<?php if($d['theme']['show_list']&&$print!='Y'):?>
<?php include_once $g['dir_module'].'mod/_list.php'?>
<?php include_once $g['dir_module_skin'].'list.php'?>
<?php endif?>
