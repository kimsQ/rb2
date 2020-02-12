<?php
function LIB_getPageLink($lnum,$p,$tpage,$_N)
{
	if (!$_N) $_N = $GLOBALS['g']['pagelink'].'&amp;';
	$g_q  = $p > 1 ? '<li class="page-item"><a class="page-link" href="'.$_N.'p=1" data-toggle="tooltip" title="첫 페이지"><i class="fa fa-angle-double-left"></i></a></li>' : '<li class="page-item disabled"><a class="page-link" href="#." data-toggle="tooltip" title="First page"><i class="fa fa-angle-double-left"></i></a></li>';
	if($p < $lnum+1) { $g_q .= '<li class="page-item disabled"><a class="page-link" href="#." data-toggle="tooltip" title="이전 페이지"><i class="fa fa-angle-left"></i></a></li>'; }
	else{ $pp = (int)(($p-1)/$lnum)*$lnum; $g_q .= '<li class="page-item"><a class="page-link" href="'.$_N.'page='.$pp.'" data-toggle="tooltip" title="Previous page"><i class="fa fa-angle-left"></i></a></li>';}
	$st1 = (int)(($p-1)/$lnum)*$lnum + 1;
	$st2 = $st1 + $lnum;
	for($jn = $st1; $jn < $st2; $jn++)
	if ( $jn <= $tpage)
	($jn == $p)? $g_q .= '<li class="page-item active"><span class="page-link">'.$jn.'</span></li>' : $g_q .= '<li class="page-item"><a class="page-link" href="'.$_N.'p='.$jn.'">'.$jn.'</a></li>';
	if($tpage < $lnum || $tpage < $jn) { $g_q .= '<li class="page-item disabled"><a class="page-link" href="#." data-toggle="tooltip" title="Next page"><i class="fa fa-angle-right"></i></a></li>'; }
	else{$np = $jn; $g_q .= '<li class="page-item"><a class="page-link" href="'.$_N.'p='.$np.'" data-toggle="tooltip" title="다음 페이지"><i class="fa fa-angle-right"></i></a></li>'; }
	$g_q  .= $tpage > $p ? '<li class="page-item"><a class="page-link" href="'.$_N.'p='.$tpage.'" data-toggle="tooltip" title="마지막 페이지('.$tpage.')"><i class="fa fa-angle-double-right"></i></a></li>' : '<li class="page-item disabled"><a class="page-link" href="#." data-toggle="tooltip" title="Last page('.$tpage.')"><i class="fa fa-angle-double-right"></i></a></li>';
	return $g_q;
}
?>
