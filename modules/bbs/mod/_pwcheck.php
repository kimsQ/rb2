<?php if ($g['mobile']&&$_SESSION['pcmode']!='Y'): ?>
<header class="bar bar-nav bar-light bg-faded">
  <a class="icon icon-left-nav pull-left" role="button" data-history="back"></a>
  <h1 class="title"><?php echo $B['name'] ?></h1>
</header>
<div class="content">

  <form name="checkForm" method="post" class="form-horizontal rb-form" action="<?php echo $g['s']?>/" target="_action_frame_<?php echo $m?>" onsubmit="return permCheck(this);">
    <input type="hidden" name="r" value="<?php echo $r?>" />
    <input type="hidden" name="a" value="<?php echo $mod=='delete'?$mod:'pwcheck'?>" />
    <input type="hidden" name="c" value="<?php echo $c?>" />
    <input type="hidden" name="cuid" value="<?php echo $_HM['uid']?>" />
    <input type="hidden" name="m" value="<?php echo $m?>" />
    <input type="hidden" name="bid" value="<?php echo $R['bbsid']?$R['bbsid']:$bid?>" />
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


    <div class="input-group input-group-lg my-4">
      <input type="text" class="form-control" type="password" name="pw">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">확인</button>
      </div>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" onclick="history.go(-1);">취소</button>
      </div>
    </div>

  </form>


</div><!-- /.content -->
<?php else: ?>
<section class="d-flex justify-content-center align-items-center" style="height: 50vh;">

  <div class="card w-50">
		 <div class="card-header">
			  <i class="fa fa-lock fa-lg"></i> 비밀번호 확인
		  </div>
	     <div class="card-body">
					<form name="checkForm" method="post" class="form-horizontal rb-form" action="<?php echo $g['s']?>/" target="_action_frame_<?php echo $m?>" onsubmit="return permCheck(this);">
						<input type="hidden" name="r" value="<?php echo $r?>" />
						<input type="hidden" name="a" value="<?php echo $mod=='delete'?$mod:'pwcheck'?>" />
						<input type="hidden" name="c" value="<?php echo $c?>" />
						<input type="hidden" name="cuid" value="<?php echo $_HM['uid']?>" />
						<input type="hidden" name="m" value="<?php echo $m?>" />
						<input type="hidden" name="bid" value="<?php echo $R['bbsid']?$R['bbsid']:$bid?>" />
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


            <div class="input-group input-group-lg my-4">
              <input type="text" class="form-control" type="password" name="pw">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">확인</button>
              </div>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" onclick="history.go(-1);">취소</button>
              </div>
            </div>

					</form>
		    </div>	<!-- .panel-body -->
			 <div class="card-footer text-muted">
			     게시물 등록시에 입력했던 비밀번호를 입력해 주세요.
			 </div>
   </div>

</section>
<?php endif; ?>

<script type="text/javascript">
//<![CDATA[
var checkFlag = false;
function permCheck(f)
{
	if (checkFlag == true)
	{
		alert('확인중입니다. 잠시만 기다려 주세요.   ');
		return false;
	}

	if (f.pw.value == '')
	{
		alert('비밀번호를 입력해 주세요.   ');
		f.pw.focus();
		return false;
	}
	checkFlag = true;
}
window.onload = function(){document.checkForm.pw.focus();}
//]]>
</script>
