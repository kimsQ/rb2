<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;

$sqlque = 'mbruid='.$my['uid'];
if ($category) $sqlque .= " and category='".$category."'";

$RCD = getDbArray($table['s_notice'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_notice'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$PageLink = './noti?';
if ($type) $PageLink .= 'type='.$type.'&amp;';

?>

<header class="bar bar-nav bar-dark bg-primary px-0">
	<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
	<a class="icon icon-gear pull-right p-x-1" role="button" href="<?php echo $g['s'] ?>/?r=<?php echo $r ?>&mod=settings&page=noti"></a>
	<h1 class="title" data-location="reload">내 알림함</h1>
</header>

<div class="bar bar-standard bar-footer bar-light bg-white">
  <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=notification&amp;a=multi_delete_user&amp;deltype=delete_all" class="btn btn-secondary btn-block" onclick="return hrefCheck(this,true,'정말로 전체 알림 삭제를 하시겠습니까?');">
		<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>
		알림함 비우기
	</a>
</div>


<main class="content bg-faded">

	<ul class="table-view table-view-full bg-white mb-0 animated fadeIn delay-1" style="margin-top: -.0625rem">
		<?php $_i=0;while($R=db_fetch_array($RCD)):?>
		<?php $SM1=$R['mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'name,nic'):array()?>
		<?php $SM2=$R['frommbr']?getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'memberuid,name,nic'):array()?>
		<?php $MD = getDbData($table['s_module'],"id='".$R['frommodule']."'",'icon'); ?>
		<?php $avatar =$R['frommbr']?getAvatarSrc($SM2['memberuid'],'120'):'/_core/images/touch/homescreen-192x192.png'  ?>
		<li class="table-view-cell<?php echo $R['d_read']?'':' table-view-active' ?>">
			<a data-toggle="sheet" href="#sheet-noti"
				data-from="<?php echo $SM2[$_HS['nametype']] ?>"
				data-icon="<?php echo $MD['icon'] ?>"
				data-avatar="<?php echo $avatar ?>"
				data-uid="<?php echo $R["uid"] ?>">
				<span class="media-object pull-left position-relative">
					<img class="img-circle" src="<?php echo $avatar ?>" style="width:52px">
					<?php if ($R['frommbr']): ?>
					<i class="<?php echo $MD['icon'] ?> bg-primary position-absolute"></i>
					<?php endif; ?>
				</span>

				<div class="media-body">
					<span class="d-flex justify-content-between">
						<span><?php echo $R['title'] ?> <span class="badge"><?php echo $R['frommbr']?$SM2[$_HS['nametype']]:'' ?></span></span>
						<span style="margin-top: -.2rem">
							<?php echo getNew($R['d_regis'],24)?' <span class="rb-new ml-1"></span>':'' ?>
							<time class="small badge badge-default badge-inverted" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_regis'],'c') ?>"></time>
						</span>
					</span>
					<p><?php echo getStrCut($R['message'],150,'')?> </p>
				</div>
			</a>
		</li>
		<?php $_i++;endwhile?>

		<?php if(!$NUM):?>
		<li class="table-view-cell text-xs-center p-5 text-muted d-flex align-items-center justify-content-center bg-faded" style="height: calc(100vh - 10.5rem);">
			내역이 없습니다.
	  </li>
		<?php endif?>

	</ul>

</main>


<script>

// 더보기
var currentPage =1; // 처음엔 무조건 1, 아래 더보기 진행되면서 +1 증가
var totalPage = '<?php echo $TPG?>';
var totalNUM = '<?php echo $NUM?>';
var sort = '<?php echo $sort?>';
var orderby = '<?php echo $orderby?>';
var recnum = '<?php echo $recnum?>';

$('.content').infinitescroll({
	dataSource: function(helpers, callback){
		var nextPage = parseInt(currentPage)+1;
		if (totalPage>currentPage) {
			$.get(rooturl+'/?r='+raccount+'&m=notification&a=get_moreList',{
					page : nextPage,
					sort: sort,
					orderby: orderby,
					recnum: recnum,
			},function(response) {
					var result = $.parseJSON(response);
					var error = result.error;
					var content = result.content;
					if(error) alert(result.error_comment);
					callback({ content: content });
					currentPage++; // 현재 페이지 +1
					console.log(currentPage+'페이지 불러옴')
					$('[data-plugin="timeago"]').timeago();
			});
		} else {
			callback({ end: true });
			console.log('더이상 불러올 페이지가 없습니다.')
		}
	},
	appendToEle : $('.table-view'),
	percentage : 95,  // 95% 아래로 스크롤할때 다움페이지 호출
	hybrid : false  // true: 버튼형, false: 자동
});

</script>
