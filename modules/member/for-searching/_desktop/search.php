<?php
$sqlque	= 'hidden=0';
$sqlque .= getSearchSql('nic|name',$q,'','or'); // 닉네임 및 이름 검색
$orderby = 'desc';

if($_iscallpage):
$RCD = getDbArray($table['s_mbrdata'],$sqlque,'*','memberuid',$orderby,$d['search']['num'.($type=='all'?1:2)],$p);
$_NUM = getDbRows($table['s_mbrdata'],$sqlque);

$c_recnum = 3; // 한 열에 출력할 카드 갯수
$totalCardDeck=ceil($_NUM/$c_recnum); // card-deck 갯수 ($_NUM 은 해당 데이타의 총 card 갯수 getDbRows 이용)
$total_card_num = $totalCardDeck*$c_recnum;// 총 출력되야 할 card 갯수(빈카드 포함)
$print_card_num = 0; // 실제 출력된 카드 숫자 (아래 card 출력될 때마다 1 씩 증가)
$lack_card_num = $total_card_num;


?>
<div class="card-deck">

	<?php $i=0;foreach($RCD as $R):$i++?>
	<div class="card mb-3">
		<a href="<?php echo getProfileLink($R['memberuid'])?>" class="position-relative" target="_blank">
			<img src="<?php echo getCoverSrc($R['memberuid'],320,150) ?>" class="img-fluid" alt="">
			<img class="list_avatar shadow-sm" src="<?php echo getAvatarSrc($R['memberuid'],'80') ?>" width="80" height="80" alt="" style="margin-bottom:-30px;margin-left: -40px">
		</a>

		<div class="card-body pt-5 p-3">
			<h5 class="card-title h6 mb-1">
				<a class="muted-link" href="<?php echo getProfileLink($R['memberuid'])?>" target="_blank">
					<?php echo $R['nic']?>
				</a>
			</h5>
			<span class="small text-muted">포스트: <?php echo $R['num_post']?></span>
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
