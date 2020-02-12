<?php
$levelnum = getDbData($table['s_mbrlevel'],'gid=1','*');
$levelname= getDbData($table['s_mbrlevel'],'uid='.$_MP['level'],'*');
?>

<div class="page-wrapper row">
	<div class="col-3 page-nav">

		<?php include $g['dir_module_skin'].'_vcard.php';?>
	</div>

	<div class="col-9 page-main">

		<?php include $g['dir_module_skin'].'_nav.php';?>

		<div class="mt-3">
			<?php include $g['dir_module_skin'].'_newPost.php';?>
		</div>

		<?php include $g['dir_module_skin'].'_newList.php';?>

		<div class="row mt-3">
			<div class="col-6">
				<h2 class="f16 p-2 font-weight-normal mt-4 mb-0">
					<i class="fa fa-file-text-o mr-1" aria-hidden="true"></i> 게시판
				</h2>

				<ul class="list-group list-group-flush">
					<?php $_POST = getDbArray($table['bbsdata'],'site='.$s.' and mbruid='.$_MP['uid'],'*','gid','asc',10,1)?>
					<?php while($_R=db_fetch_array($_POST)):?>
					<?php $_R['mobile']=isMobileConnect($_R['agent'])?>
					<li class="list-group-item px-1 py-2 f13">
						<a href="<?php echo getBbsPostLink($_R)?>" class="muted-link" target="_blank">
							<?php echo getStrCut($_R['subject'],29,'..')?>
						</a>
						<?php if($_R['mobile']):?><i class="fa fa-mobile fa-lg"></i><?php endif?>
						<?php if(strstr($_R['content'],'.jpg')):?>
						<span class="badge badge-light" data-toggle="tooltip" title="사진">
	            <i class="fa fa-camera-retro fa-lg"></i>
	          </span>
						<?php endif?>
						<?php if($_R['upload']):?>
						<span class="badge badge-light" data-toggle="tooltip" title="첨부파일">
	            <i class="fa fa-paperclip fa-lg"></i>
	          </span>
						<?php endif?>
						<?php if($_R['hidden']):?><span class="badge badge-light" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span><?php endif?>
	          <?php if($_R['comment']):?><span class="badge badge-light"><?php echo $_R['comment']?><?php echo $_R['oneline']?'+'.$_R['oneline']:''?></span><?php endif?>
						<?php if(getNew($_R['d_regis'],24)):?><small class="text-danger">n</small><?php endif?>
					</li>
					<?php endwhile?>
					<?php if(!db_num_rows($_POST)):?>
					<li class="list-group-item">등록된 게시물이 없습니다.</li>
					<?php endif?>
				</ul>

			</div><!-- /.col-6 -->
			<div class="col-6 border-left">

				<h2 class="f16 font-weight-normal mt-4 mb-2">
					<i class="fa fa-commenting-o mr-1" aria-hidden="true"></i> 댓글
				</h2>



				<ul class="list-group list-group-flush">
					<?php $_POST = getDbArray($table['s_comment'],'site='.$s.' and mbruid='.$_MP['uid'],'*','uid','asc',10,1)?>
					<?php while($_R=db_fetch_array($_POST)):?>
					<?php $_R['mobile']=isMobileConnect($_R['agent'])?>
					<li class="list-group-item px-1 py-2 f13">
						<a href="<?php echo getSyncUrl($_R['sync'].',CMT:'.$_R['uid'].',s:'.$_R['site'])?>#CMT" class="muted-link" target="_blank">
							<?php echo getStrCut($_R['subject'],29,'..')?>
						</a>
						<?php if($_R['mobile']):?><i class="fa fa-mobile fa-lg"></i><?php endif?>
						<?php if(strstr($_R['content'],'.jpg')):?>
						<span class="badge badge-light" data-toggle="tooltip" title="사진">
	            <i class="fa fa-camera-retro fa-lg"></i>
	          </span>
						<?php endif?>
						<?php if($_R['upload']):?>
						<span class="badge badge-light" data-toggle="tooltip" title="첨부파일">
	            <i class="fa fa-paperclip fa-lg"></i>
	          </span>
						<?php endif?>
						<?php if($_R['hidden']):?><span class="badge badge-light" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span><?php endif?>
						<?php if($_R['oneline']):?><span class="badge badge-light"><?php echo $_R['oneline']?></span><?php endif?>
						<?php if(getNew($_R['d_regis'],24)):?><small class="text-danger">n</small><?php endif?>
					</li>
					<?php endwhile?>
					<?php if(!db_num_rows($_POST)):?>
					<li class="list-group-item">등록된 댓글이 없습니다.</li>
					<?php endif?>
				</ul>

			</div><!-- /.col-6 -->
		</div><!-- /.row -->

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->
