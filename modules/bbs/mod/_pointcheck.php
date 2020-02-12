
<div class="card w-75 mx-auto my-5">
	<div class="card-header">
		<?php echo $R['subject']?> - <?php echo $R[$_HS['nametype']]?>님
	</div>
	<div class="card-body">

		<ul>
			<li>요청하신 게시물은 열람시 포인트가 차감됩니다.</li>
			<?php if($my['uid']):?>
			<li>열람에 필요한 포인트는 <span class="text-danger"><?php echo number_format($R['point2'])?> 포인트</span> 이며 회원님은 현재 <span class="text-primary"><?php echo number_format($my['point'])?> 포인트</span> 보유 중입니다.</li>
			<?php else:?>
			<li>회원으로 로그인하셔야 이용하실 수 있습니다. 로그인해 주세요.</li>
			<?php endif?>
			<li>한번 열람한 게시물은 브라우져를 모두 닫을때까지 재결제 없이 열람할 수 있습니다.</li>
			<?php if($my['admin']):?>
			<li class="b"><?php echo $my[$_HS['nametype']]?>님은 관리자권한으로 포인트는 차감되지 않습니다.</li>
			<?php endif?>
			<?php if($my['uid']==$R['mbruid']):?>
			<li class="b"><?php echo $my[$_HS['nametype']]?>님은 게시물 등록자이므로 실제 포인트는 차감되지 않습니다.</li>
			<?php endif?>
		</ul>

	</div>

	<div class="card-footer text-center">
		<button type="button" class="btn btn-light btn-lg" onclick="history.back();" >
			돌아가기
		</button>
		<button type="button" class="btn btn-primary btn-lg" onclick="viewArticle();">
			열람하기 <span class="badge badge-light"><?php echo number_format($R['point2'])?> 포인트 차감</span>
		</button>
	</div>

</div><!-- /.card -->






<form name="checkForm" method="post" action="<?php echo $g['s']?>/" target="_action_frame_<?php echo $m?>" onsubmit="return permCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="a" value="point_view" />
	<input type="hidden" name="c" value="<?php echo $c?>" />
	<input type="hidden" name="cuid" value="<?php echo $_HM['uid']?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="bid" value="<?php echo $R['bbsid']?>" />
	<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />

	<input type="hidden" name="p" value="<?php echo $p?>" />
	<input type="hidden" name="cat" value="<?php echo $cat?>" />
	<input type="hidden" name="sort" value="<?php echo $sort?>" />
	<input type="hidden" name="orderby" value="<?php echo $orderby?>" />
	<input type="hidden" name="recnum" value="<?php echo $recnum?>" />
	<input type="hidden" name="type" value="<?php echo $type?>" />
	<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
	<input type="hidden" name="skin" value="<?php echo $skin?>" />
	<input type="hidden" name="where" value="<?php echo $where?>" />
	<input type="hidden" name="keyword" value="<?php echo $_keyword?>" />
</form>


<script type="text/javascript">
//<![CDATA[
function viewArticle()
{
	var f = document.checkForm;
	if (memberid == '')
	{
		alert('로그인하신 후에 이용해 주세요.   ');
		return false;
	}
	<?php if($my['point'] < $R['point2']):?>
	if (memberid == '')
	{
		alert('회원님의 보유포인트가 열람포인트보다 적습니다.  ');
		return false;
	}
	<?php endif?>
	if (confirm('정말로 열람하시겠습니까?   '))
	{
		f.submit();
	}
}
//]]>
</script>
