<?php
$g['url_reset']	= $g['s'].'/?r='.$r.'&iframe=Y&amp;m='.$m.'&amp;front='.$front.'&amp;mbruid='.$M['memberuid'];
$g['url_page']	= $g['url_reset'].'&amp;page='.$page;
?>


<div id="pages_top">

	<div class="title">
		<div class="xl"><h2><a href="<?php echo $g['url_reset']?>"><?php echo $M[$_HS['nametype']]?>님</a></h2></div>
		<div class="xr">
		
			<ul>
			<li class="leftside"></li>
			<?php if($d['member']['mytab_post']):?><li<?php if($page=='post'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=post">게시물</a></li><?php endif?>
			<?php if($d['member']['mytab_comment']):?><li<?php if($page=='comment'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=comment">댓글</a></li><?php endif?>
			<?php if($d['member']['mytab_oneline']):?><li<?php if($page=='oneline'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=oneline">한줄의견</a></li><?php endif?>
			<?php if($d['member']['mytab_scrap']):?><li<?php if($page=='scrap'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=scrap">스크랩</a></li><?php endif?>
			<?php if($d['member']['mytab_paper']):?><li<?php if($page=='paper'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=paper">쪽지</a></li><?php endif?>
			<?php if($d['member']['mytab_friend']):?><li<?php if($page=='friend'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=friend">친구</a></li><?php endif?>
			<?php if($d['member']['mytab_point']):?><li<?php if($page=='point'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=point">포인트</a></li><?php endif?>
			<?php if($d['member']['mytab_log']):?><li<?php if($page=='log'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=log">접속기록</a></li><?php endif?>
			<?php if($d['member']['mytab_info']):?><li<?php if($page=='info'):?> class="selected"<?php endif?>><a href="<?php echo $g['url_reset']?>&amp;page=info">가입정보</a></li><?php endif?>
			<li><a href="javascript:top.close();">창닫기</a></li>
			</ul>

		</div>
		<div class="clear"></div>
	</div>
	
</div>

