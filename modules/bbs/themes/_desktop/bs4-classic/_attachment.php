<!-- 첨부파일 접근권한 -->
<?php if ($d['bbs']['perm_l_down'] <= $my['level'] && (strpos($d['bbs']['perm_g_down'],'['.$my['mygroup'].']') === false)): ?>

<!-- 사진 -->
<?php if ($R['upload']): ?>

<?php
	 $img_files = array();
	 $audio_files = array();
	 $video_files = array();
	 $down_files = array();
	 foreach($d['upload']['data'] as $_u){
			if($_u['type']==2 and $_u['hidden']==0) array_push($img_files,$_u);
			else if($_u['type']==4 and $_u['hidden']==0) array_push($audio_files,$_u);
			else if($_u['type']==5 and $_u['hidden']==0) array_push($video_files,$_u);
			else if($_u['type']==1 || $_u['type']==6 || $_u['type']==7 and $_u['hidden']==0) array_push($down_files,$_u);
	 }
	 $attach_photo_num = count ($img_files);
	 $attach_video_num = count ($video_files);
	 $attach_audio_num = count ($audio_files);
	 $attach_down_num = count ($down_files);
?>


	<div class="attach-section clearfix my-5">

		<?php if($attach_photo_num>0):?>
		<div class="float-left">
			<ul class="list-inline mb-1 gallery animated fadeIn delay-1" data-plugin="photoswipe">
				<?php foreach($img_files as $_u):?>

				<?php
					$img_origin=$_u['host'].'/'.$_u['folder'].'/'.$_u['tmpname'];
					$thumb_list=getPreviewResize($img_origin,'180x120'); // 미리보기 사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
					$thumb_modal=getPreviewResize($img_origin,'c'); // 정보수정 모달용  사이즈 조정 (이미지 업로드시 썸네일을 만들 필요 없다.)
				?>
					<figure class="list-inline-item">
						<a class="" href="<?php echo $img_origin ?>" data-size="<?php echo $_u['width']?>x<?php echo $_u['height']?>" title="<?php echo $_u['name']?>">
			      	<img src="<?php echo $thumb_list ?>" alt="" class="border">
						</a>
			      <figcaption itemprop="caption description" class="f12 p-3">
							<div class="media">
								<div class="mr-2"><i class="fa fa-file-image-o fa-lg text-primary" aria-hidden="true"></i></div>
							  <div class="media-body">
									<p class="mb-2 font-weight-bold"><?php echo $_u['name']?></p>
									<small data-role="caption"><?php echo $_u['caption']?></small>
									<small><?php echo getSizeFormat($_u['size'],1)?></small>
							  </div>
							</div>
						</figcaption>
						<div class="card__corner">
							<div class="card__corner-triangle"></div>
						</div>
					</figure>
				<?php endforeach?>
			</ul>
		</div>
		<?php endif?>

		<?php if($attach_down_num>0):?>
		<div class="float-left">
			<ul class="list-inline mb-1 gallery animated fadeIn delay-1">
				<?php foreach($down_files as $_u):?>
					<?php
						 $ext_to_fa=array('xls'=>'excel','xlsx'=>'excel','ppt'=>'powerpoint','pptx'=>'powerpoint','txt'=>'text','pdf'=>'pdf','zip'=>'archive','doc'=>'word');
						 $ext_icon=in_array($_u['ext'],array_keys($ext_to_fa))?'-'.$ext_to_fa[$_u['ext']]:'';
					 ?>
					 <li class="list-inline-item">
			        <div class="card f12" style="width: 180px">
								<div class="card__corner">
									<div class="card__corner-triangle"></div>
								</div>
								<div class="card-block d-flex justify-content-center align-items-center"  style="height:87px">
									<i class="fa fa-3x fa-file<?php echo $ext_icon?>-o text-muted"></i>
								</div>
								<div class="card-footer p-2 text-truncate text-muted bg-light">
									<i class="fa fa-download" aria-hidden="true"></i> <?php echo $_u['name']?>
								</div>
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=mediaset&amp;a=download&amp;uid=<?php echo $_u['uid']?>" class="card-img-overlay bg-light text-muted p-3">
									<div class="media">
										<div class="mr-2"><i class="fa fa-file<?php echo $ext_icon?>-o fa-lg text-primary" aria-hidden="true"></i></div>
									  <div class="media-body">
											<p class="mb-2 font-weight-bold"><?php echo $_u['name']?></p>
											<small data-role="caption"><?php echo $_u['caption']?></small>
											<small><?php echo getSizeFormat($_u['size'],1)?></small>
											<span class="ml-2">
												<i class="fa fa-download" aria-hidden="true"></i>
												<small class="text-muted"><?php echo number_format($_u['down'])?></small>
											</span>

									  </div>
									</div>
							  </a>

			        </div>
					 </li>
				<?php endforeach?>
			</ul>
		</div>
		<?php endif?>
	</div>


	<?php if($attach_video_num>0):?>
	<div class="card-deck">
		<?php foreach($video_files as $_u):?>
		<?php
			 $ext_to_fa=array('xls'=>'excel','xlsx'=>'excel','ppt'=>'powerpoint','pptx'=>'powerpoint','txt'=>'text','pdf'=>'pdf','zip'=>'archive','doc'=>'word');
			 $ext_icon=in_array($_u['ext'],array_keys($ext_to_fa))?'-'.$ext_to_fa[$_u['ext']]:'';
		 ?>
		<div class="card">
			<video width="320" height="240" controls data-plugin="mediaelement" class="card-img-top">
				<source src="<?php echo $_u['host']?>/<?php echo $_u['folder']?>/<?php echo $_u['tmpname']?>" type="video/<?php echo $_u['ext']?>">
			</video>
			<div class="card-body">
				<h6 class="card-title"><?php echo $_u['name']?></h6>
				<p class="card-text"><small class="text-muted">(<?php echo getSizeFormat($_u['size'],1)?>)</small></p>
			</div><!-- /.card-block -->
		</div><!-- /.card -->
		<?php endforeach?>
	</div><!-- /.card-deck -->
	<?php endif?>



	<?php if($attach_audio_num>0):?>
	<div class="card-deck">
		<?php foreach($audio_files as $_u):?>
		<?php
			$ext_to_fa=array('xls'=>'excel','xlsx'=>'excel','ppt'=>'powerpoint','pptx'=>'powerpoint','txt'=>'text','pdf'=>'pdf','zip'=>'archive','doc'=>'word');
			$ext_icon=in_array($_u['ext'],array_keys($ext_to_fa))?'-'.$ext_to_fa[$_u['ext']]:'';
		 ?>
		<div class="card">
			<audio controls data-plugin="mediaelement" class="card-img-top w-100">
				<source src="<?php echo $_u['host']?>/<?php echo $_u['folder']?>/<?php echo $_u['tmpname']?>" type="audio/mp3">
			</audio>
			<div class="card-body">
				<h6 class="card-title"><?php echo $_u['name']?></h6>
				<p class="card-text"><small class="text-muted">(<?php echo getSizeFormat($_u['size'],1)?>)</small></p>
			</div><!-- /.card-block -->
		</div><!-- /.card -->
		<?php endforeach?>
	</div><!-- /.card-deck -->
	<?php endif?>

	<?php endif; ?>

<?php endif; ?>
