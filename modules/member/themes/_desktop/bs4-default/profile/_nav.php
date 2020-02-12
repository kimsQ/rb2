<?php

//동기화URL
function getSyncUrl($sync){
	if (!$sync) return $GLOBALS['g']['r'];
	$_r = getArrayString($sync);
	$_r = $_r['data'][5];
	if ($GLOBALS['_HS']['rewrite']&&strpos('_'.$_r,'m:bbs,bid:'))
	{
		$_r = str_replace('m:bbs','b',$_r);
		$_r = str_replace(',bid:','/',$_r);
		$_r = str_replace(',uid:','/',$_r);
		$_r = str_replace(',CMT:','/',$_r);
		$_r = str_replace(',s:','/s',$_r);
		return $GLOBALS['g']['r'].'/'.$_r;
	}
	else return $GLOBALS['g']['s'].'/?'.($GLOBALS['_HS']['usescode']?'r='.$GLOBALS['_HS']['id'].'&amp;':'').str_replace(':','=',str_replace(',','&amp;',$_r));
}

$para_str = $_HS['rewrite']?'/':'&page=';
?>

<div class="user-profile-nav">
  <nav class="nav underline-nav">
    <a class="nav-link f16<?php if ($page=='main'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']) ?>">홈</a>
		<a class="nav-link f16<?php if ($page=='post'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>post">
			포스트
		</a>
		<a class="nav-link f16<?php if ($page=='list'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>list">
			리스트
		</a>
    <a class="nav-link f16<?php if ($page=='bbs'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>bbs">
      게시판
    </a>
    <a class="nav-link f16<?php if ($page=='comment'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>comment">
      댓글
    </a>
    <a class="nav-link f16<?php if ($page=='oneline'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>oneline">
      한줄의견
    </a>
    <a class="nav-link f16<?php if ($page=='follower'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>follower">
      <span data-toggle="tooltip" title="<?php echo $_MP['nic'] ?>님을 구독하는 사람">팔로워</span>
      <span class="badge"> <?php echo getDbRows($table['s_friend'],'by_mbruid='.$_MP['uid'])?></span>
    </a>
    <a class="nav-link f16<?php if ($page=='following'): ?> active<?php endif; ?>" href="<?php echo getProfileLink($_MP['uid']).$para_str ?>following">
      <span data-toggle="tooltip" title="<?php echo $_MP['nic'] ?>님이 구독하는 사람">팔로잉</span>
      <span class="badge"> <?php echo getDbRows($table['s_friend'],'my_mbruid='.$_MP['uid'])?></span>
    </a>

  </nav>
</div>
