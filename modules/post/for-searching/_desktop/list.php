<?php
$sqlque	= 'uid';
$sqlque .= getSearchSql('name|tag',$q,'','or'); // 게시물 제목과 내용 검색
$orderby = $orderby?$orderby:'desc';

if ($my['uid']) $sqlque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $sqlque .= ' and display = 5'; // 전체공개 포스트만 출력

if($_iscallpage):
$RCD = getDbArray($table['postlist'],$sqlque,'*','uid',$orderby,$d['search']['num'.($swhere=='all'?1:2)],$p);

$_NUM = getDbRows($table['postlist'],$sqlque);

$c_recnum = 3; // 한 열에 출력할 카드 갯수
$totalCardDeck=ceil($_NUM/$c_recnum); // card-deck 갯수 ($_NUM 은 해당 데이타의 총 card 갯수 getDbRows 이용)
$total_card_num = $totalCardDeck*$c_recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;

?>
<div class="card-deck">

	<?php $i=0;foreach($RCD as $R):$i++?>
	<div class="card mb-3">
		<a href="<?php echo getListLink($R,0) ?>" class="position-relative" target="_blank">
			<img src="<?php echo getPreviewResize(getListImageSrc($R['uid']),'320x180') ?>" class="img-fluid" alt="">
			<span class="list_mask">
				<span class="txt"><?php echo $R['num']?><i class="fa fa-list-ul d-block" aria-hidden="true"></i></span>
			</span>
			<img class="list_avatar border" src="<?php echo getAvatarSrc($R['mbruid'],'50') ?>" width="50" height="50" alt="">
		</a>

		<div class="card-body pt-5 p-3">
			<h5 class="card-title h6 mb-1">
				<a class="muted-link" href="<?php echo getListLink($R,0) ?>" target="_blank">
					<?php echo $R['name']?>
				</a>
			</h5>
			<span class="small text-muted">업데이트: <time class="text-muted" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_last'],'c')?>"></time></span>
			<?php if(getNew($R['d_last'],$d['post']['newtime'])):?><span class="rb-new ml-1"></span><?php endif?>
		</div><!-- /.card-body -->
	</div><!-- /.card -->

	<?php
		$print_card_num++; // 카드 출력될 때마 1씩 증가
		$lack_card_num = $total_card_num - $print_card_num;
	 ?>

	<?php if(!($i%$c_recnum)):?></div><div class="card-deck"><?php endif?>
	<?php endforeach?>

	<?php if($lack_card_num ):?>
	<?php for($j=0;$j<$lack_card_num;$j++):?>
	 <div class="card border-0"></div>
	<?php endfor?>
	<?php endif?>
</div><!-- /.card-deck -->

<?php
endif;
$_ResultArray['num'][$_key] = $_NUM;
?>
