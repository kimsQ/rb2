<?php
$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['path_module'].'post/var/var.php';
include_once $svfile;

$type = $type ? $type : 'follower';
$sort	= 'uid';
$orderby= 'desc';
$recnum	= 30;

$postque	= 'my_mbruid='.$my['uid'];

if($type == 'follower') {
	$postque	= 'by_mbruid='.$my['uid'];
	$_fmemberuid = 'my_mbruid';
}
if($type == 'following') {
	$_fmemberuid = 'by_mbruid';
}
if($type == 'friend') {
	$postque	= 'by_mbruid='.$my['uid'].' and rel=1';
	$_fmemberuid = 'my_mbruid';
}
if ($where && $keyword) $postque .= getSearchSql($where,$keyword,$ikeyword,'or');
$RCD = getDbArray($table['s_friend'],$postque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_friend'],$postque);
$TPG = getTotalPage($NUM,$recnum);

$g['page_reset']	= RW('mod=dashboard&page='.$page);
$g['page_list']	= $g['page_reset'].getLinkFilter('',array($type?'type':''));
$g['pagelink']	= $g['page_list'];

?>

<div class="container">
	<div class="d-flex justify-content-between align-items-center subhead mt-0">
		<h3 class="mb-0">
			구독자 관리
		</h3>
		<div class="">
			<a href="<?php echo RW('mod=dashboard&page=follower')?>" class="btn btn-white<?php echo $type=='follower'?' active':'' ?>">
				나를 구독하는 사람
				<span class="badge"><?php echo getDbRows($table['s_friend'],'by_mbruid='.$my['uid'])?></span>
			</a>
			<a href="<?php echo RW('mod=dashboard&page=follower&type=following')?>" class="btn btn-white<?php echo $type=='following'?' active':'' ?>">
				내가 구독하는 사람
				<span class="badge"><?php echo getDbRows($table['s_friend'],'my_mbruid='.$my['uid'])?></span>
			</a>
			<a href="<?php echo RW('mod=dashboard&page=follower&type=friend')?>" class="btn btn-white<?php echo $type=='friend'?' active':'' ?>" data-toggle="tooltip" title="서로 구독하는 관계">
				친구
				<span class="badge"><?php echo getDbRows($table['s_friend'],'by_mbruid='.$my['uid'].' and rel=1')?></span>
			</a>
		</div>
	</div>

	<div class="d-flex justify-content-between align-items-center border-top border-dark pb-3" role="filter">

	</div><!-- /.d-flex -->

	<ul class="list-inline mt-3">
		<?php foreach($RCD as $R):?>
		<?php $num_follower = getProfileInfo($R[$_fmemberuid],'num_follower') ?>
		<?php $_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$R[$_fmemberuid]); ?>
		<?php $_isFriend = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$R[$_fmemberuid].' and rel=1'); ?>
		<li class="list-inline-item text-center mr-5" data-mbruid="<?php echo $R[$_fmemberuid] ?>">
			<a href="<?php echo getProfileLink($R[$_fmemberuid])?>" class="d-block text-decoration-none text-reset" target="_blank">
				<img alt="" class="rounded-circle border" src="<?php echo getAvatarSrc($R[$_fmemberuid],'105') ?>" width="105" height="105" >
				<div class="mt-2">
					<?php echo getProfileInfo($R[$_fmemberuid],'nic')?>
					<span class="badge badge-light align-middle"><?php echo $_isFriend?'친구':'' ?></span>
				</div>
			</a>
			<p class="text-muted mb-2 f13 mt-1">
				구독자 <span data-role="num_follower"><?php echo number_format($num_follower)?></span>명
			</p>
			<?php if($my['uid']!=$R[$_fmemberuid]):?>
			<button type="button" class="btn btn-primary btn-sm<?php echo $_isFollowing ?' active':''?>"
			 data-act="actionIframe"
			 data-toggle="button"
			 data-role="follow"
			 data-url="<?php echo $g['s'].'/?r='.$r.'&amp;m=member&amp;a=profile_follow&amp;mbruid='.$R[$_fmemberuid]?>">
				구독
			</button>
			<?php endif?>
		</li>
		<?php endforeach?>
	</ul>

	<?php if(!$NUM):?>
	<div class="d-flex align-items-center justify-content-center" style="height: 40vh">
		<div class="text-muted">자료가 없습니다.</div>
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
