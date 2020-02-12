<?php
//댓글링크
function getCommentLink($arr)
{
	$sync_arr=explode('|',$arr['sync']);
	$B = getUidData($sync_arr[0],$sync_arr[2]);
	return RW('m='.$sync_arr[1].'&bid='.$B['bbsid'].'&uid='.$sync_arr[2].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''.'#CMT-'.$arr['uid']));
}

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;
$bbsque = 'mbruid='.$_MP['uid'].' and site='.$s;
if ($where && $keyword)
{
	if (strstr('[name][nic][id][ip]',$where)) $bbsque .= " and ".$where."='".$keyword."'";
	else if ($where == 'term') $bbsque .= " and d_regis like '".$keyword."%'";
	else $bbsque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_comment'],$bbsque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_comment'],$bbsque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div class="page-wrapper row">
	<div class="col-3 page-nav">

		<?php include $g['dir_module_skin'].'_vcard.php';?>
	</div>

	<div class="col-9 page-main">

		<?php include $g['dir_module_skin'].'_nav.php';?>

		<section>

			<header class="d-flex justify-content-between mt-4 mb-2">
				<div>
					<?php echo number_format($NUM)?>개 <small class="text-muted">(<?php echo $p?>/<?php echo $TPG?>페이지)</small>
				</div>
			</header>


			<table class="table text-center">
				<colgroup>
					<col width="50">
					<col>
					<col width="120">
				</colgroup>
				<thead class="thead-light">
					<tr>
						<th scope="col" class="side1">번호</th>
						<th scope="col">제목</th>
						<th scope="col" class="side2">날짜</th>
					</tr>
				</thead>
			<tbody>

			<?php while($R=db_fetch_array($RCD)):?>
			<?php $R['mobile']=isMobileConnect($R['agent'])?>
			<tr>
				<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
				<td class="text-left">
					<?php if($R['mobile']):?><i class="fa fa-mobile fa-lg"></i><?php endif?>
					<a href="<?php echo getCommentLink($R)?>" target="_blank" class="muted-link"><?php echo $R['subject']?></a>
					<?php if(strstr($R['content'],'.jpg')):?>
					<span class="badge badge-light" data-toggle="tooltip" title="사진">
						<i class="fa fa-camera-retro fa-lg"></i>
					</span>
					<?php endif?>
					<?php if($R['upload']):?>
					<span class="badge badge-light" data-toggle="tooltip" title="첨부파일">
						<i class="fa fa-paperclip fa-lg"></i>
					</span>
					<?php endif?>
          <?php if($R['hidden']):?><span class="badge badge-light" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span><?php endif?>
					<?php if($R['oneline']):?><span class="badge badge-light"><?php echo $R['oneline']?></span><?php endif?>
					<?php if(getNew($R['d_regis'],24)):?><small class="text-danger">new</small><?php endif?>
				</td>
				<td>
					<time class="small text-muted"><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></time>
				</td>
			</tr>
			<?php endwhile?>

			<?php if(!$NUM):?>
				<tr>
					<td colspan="3" class="py-5 text-muted">
						댓글이 없습니다.
					</td>
				</tr>
			<?php endif?>

			</tbody>
			</table>


			<footer class="d-flex justify-content-between align-items-center my-4">
				<div class="">
					<?php if ($NUM > $recnum): ?>
					<ul class="pagination mb-0">
						<?php echo getPageLink(5,$p,$TPG,$_N)?>
					</ul>
					<?php endif; ?>
				</div>

				<form name="bbssearchf" action="<?php echo$g['page_reset']?>" class="form-inline">
					<?php if ($_HS['rewrite']): ?>
					<input type="hidden" name="sort" value="<?php echo $sort?>">
					<?php else: ?>
					<input type="hidden" name="r" value="<?php echo $r?>">
					<?php if($_mod):?>
					<input type="hidden" name="mod" value="<?php echo $_mod?>">
					<?php else:?>
					<input type="hidden" name="m" value="<?php echo $m?>">
					<input type="hidden" name="front" value="<?php echo $front?>">
					<?php endif?>
					<input type="hidden" name="page" value="<?php echo $page?>">
					<input type="hidden" name="sort" value="<?php echo $sort?>">
					<input type="hidden" name="orderby" value="<?php echo $orderby?>">
					<input type="hidden" name="recnum" value="<?php echo $recnum?>">
					<input type="hidden" name="type" value="<?php echo $type?>" />
					<input type="hidden" name="mbrid" value="<?php echo $_MP['id']?>">
					<?php endif; ?>

					<select name="where" class="form-control custom-select">
						<option value="subject"<?php if($where=='subject'):?> selected="selected"<?php endif?>>제목</option>
						<option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>본문</option>
					</select>

					<input type="text" name="keyword" size="30" value="<?php echo $_keyword?>" class="form-control ml-2">
					<button class="btn btn-light ml-2" type="submit">검색</button>
					<?php if ($keyword): ?>
					<a class="btn btn-light ml-1" href="<?php echo $g['page_reset']?>">리셋</a>
					<?php endif; ?>
				</form>

		  </footer>

		</section>

	</div><!-- /.page-main -->
</div><!-- /.page-wrapper -->
