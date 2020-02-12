<?php
$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['path_module'].'post/var/var.php';
include_once $svfile;

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 16;
$postque = 'site='.$s;

$_line =4; //한 열에 출력할 카드 갯수
$totalCardRow=ceil($recnum/$_line); // row 갯수
$total_card_num = $totalCardRow*$_line;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

$postque .= ' and (display=2 and hidden=0 or display>3)';

$postque .= ' and mbruid='.$my['uid'];
$NUM = getDbRows($table['s_feed'],$postque);
$TCD = getDbArray($table['s_feed'],$postque,'entry',$sort,$orderby,$recnum,$p);
while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table['postdata'],'uid='.$_R['entry'],'*');

$TPG = getTotalPage($NUM,$recnum);

$vtype	= $vtype ? $vtype : $_SESSION['feed_vtype'];
$_SESSION['feed_vtype'] = $vtype ? $vtype : 'card';

$g['page_reset']	= RW('mod=dashboard&page='.$page);
$g['page_list']	= $g['page_reset'].getLinkFilter('',array($vtype?'vtype':''));
$g['pagelink']	= $g['page_list'];

?>

<div class="container">
	<div class="d-flex justify-content-between align-items-center subhead mt-0">
		<h3 class="mb-0">
			피드
		</h3>
		<div class="">
			<a href="<?php echo RW('mod=dashboard&page=follower&type=following')?>" class="btn btn-white">
				구독 관리
			</a>
			<a href="<?php echo RW('mod=dashboard&page=feed&vtype=card')?>" class="btn btn-white py-1<?php echo $_SESSION['feed_vtype']=='card'?' active':'' ?>">
				<div class="d-flex justify-content-center align-content-between">
					<i class="material-icons">view_module</i>
				</div>
			</a>
			<a href="<?php echo RW('mod=dashboard&page=feed&vtype=media')?>" class="btn btn-white py-1<?php echo $_SESSION['feed_vtype']=='media'?' active':'' ?>">
				<div class="d-flex justify-content-center align-content-between">
					<i class="material-icons">view_list</i>
				</div>
			</a>
		</div>
	</div>

	<div class="d-flex align-items-center border-top border-dark pt-4 pb-3" role="filter">
		<span class="f18">전체 <span class="text-primary"><?php echo number_format($NUM)?></span> 개</span>
	</div><!-- /.d-flex -->

	<?php if ($vtype=='media'): ?>
	<ul class="list-unstyled" style="margin-top: -1rem">
		<?php if (!empty($RCD)): ?>
		<?php foreach($RCD as $R):?>
		<li class="mt-4 d-flex justify-content-between align-items-center"
			data-role="item"
			data-featured_img="<?php echo getPreviewResize(getUpImageSrc($R),'180x100') ?>"
			data-hit="<?php echo $R['hit']?>"
			data-likes="<?php echo $R['likes']?>"
			data-comment="<?php echo $R['comment']?>"
			data-subject="<?php echo stripslashes($R['subject'])?>">

			<div class="media w-75">
				<a href="<?php echo getPostLink($R,1)?>" class="position-relative mr-3" target="_blank">
					<img class="border" src="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'180x100'):getPreviewResize('/files/noimage.png','180x100') ?>" alt="" width="180">
					<time class="badge badge-dark rounded-0 position-absolute f14" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
				</a>
				<div class="media-body">
					<h5 class="my-1 line-clamp-2">
						<a href="<?php echo getPostLink($R,1)?>" class="font-weight-light muted-link" <?php echo !checkPostOwner($R)?'target="_blank"':'' ?>>
							<?php echo stripslashes($R['subject'])?>
						</a>
					</h5>
					<div class="mb-1">
						<ul class="list-inline d-inline-block f13 text-muted">
							<li class="list-inline-item">조회수 <?php echo $R['hit']?>회 </li>
							<li class="list-inline-item">• 업데이트 :
								<time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time>
							</li>
						</ul>

						<?php if ($R['category']): ?>
						<span class="ml-2 f13 text-muted">
							<i class="fa fa-folder-o mr-1" aria-hidden="true"></i> <?php echo getAllPostCat('post',$R['category']) ?>
						</span>
						<?php endif; ?>

						<?php if ($R['review']): ?>
						<p class="text-muted f13 mt-2 mb-1 line-clamp-2"><?php echo $R['review'] ?></p>
						<?php endif; ?>

					</div>
				</div>
			</div><!-- /.media -->
			<div class="">
				<a href="<?php echo getProfileLink($R['mbruid']) ?>" class="media align-items-center mb-2 text-decoration-none text-reset">
					<img src="<?php echo getAvatarSrc($R['mbruid'],'32') ?>" class="mr-2 rounded-circle" width="32" height="32" alt="<?php echo $M1[$_HS['nametype']] ?>의 프로필">
					<div class="media-body">
						<?php echo getProfileInfo($R['mbruid'],$_HS['nametype']) ?>
					</div>
				</a>
			</div>
		</li>
		<?php endforeach?>
		<?php endif; ?>
	</ul>
	<?php else: ?>

	<div class="card-deck" data-role="post-list">
		<?php if (!empty($RCD)): ?>
    <?php $i=0;foreach($RCD as $R):$i++;?>
    <div class="card shadow-sm" id="item-<?php echo $_R['uid'] ?>">
      <a class="text-nowrap text-truncate muted-link position-relative " href="<?php echo getPostLink($R,1) ?>" target="_blank">
        <img src="<?php echo checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'250x140'):getPreviewResize('/files/noimage.png','250x140') ?>" alt="" class="card-img-top">
        <time class="badge badge-dark rounded-0 position-absolute" style="right:1px;bottom:1px"><?php echo checkPostPerm($R)?getUpImageTime($R):'' ?></time>
      </a>
      <div class="card-body p-3">
        <h6 class="card-title mb-0 line-clamp-2">
          <a class="muted-link" href="<?php echo RW('m=post&mod=write&cid='.$R['cid']) ?>">
            <?php echo checkPostPerm($R)?getStrCut(stripslashes($R['subject']),100,'..'):'[비공개 포스트]'?>
          </a>
        </h6>

        <small class="text-muted small" ><?php echo getProfileInfo($R['mbruid'],$_HS['nametype']) ?> • 업데이트 : <time data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c')?>"></time></small>
      </div><!-- /.card-body -->
    </div><!-- /.card -->

    <?php
      $print_card_num++; // 카드 출력될 때마 1씩 증가
      $lack_card_num = $total_card_num - $print_card_num;
     ?>

    <?php if(!($i%$_line)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
    <?php endforeach?>
		<?php endif; ?>

    <?php if($lack_card_num ):?>
      <?php for($j=0;$j<$lack_card_num;$j++):$i++;?>
       <div class="card border-0" style="background-color: transparent"></div>
       <?php if(!($i%$_line)):?></div><div class="card-deck mt-3" data-role="post-list"><?php endif?>
      <?php endfor?>
    <?php endif?>

  </div><!-- /.card-deck -->

	<?php endif; ?>

	<?php if(!$NUM):?>
	<div class="d-flex align-items-center justify-content-center" style="height: 40vh">
		<div class="text-muted">표시할 포스트가 없습니다.</div>
	</div>
	<?php endif?>

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


</div>

<?php include $g['path_module'].'post/mod/_component.desktop.php';?>
