<?php

//게시물링크
function getPostLink2($arr)
{
	return RW('m=bbs&bid='.$arr['bbsid'].'&uid='.$arr['uid'].($GLOBALS['s']!=$arr['site']?'&s='.$arr['site']:''));
}

$postarray1 = array();
$postarray2 = array();

$postarray1 = getArrayString($postuid);
foreach($postarray1['data'] as $val)
{
	if (!strstr($_SESSION['BbsPost'.$type],'['.$val.']'))
	{
		$_SESSION['BbsPost'.$type] .= '['.$val.']';
	}
}
$postarray2 = getArrayString($_SESSION['BbsPost'.$type]);
rsort($postarray2['data']);
reset($postarray2['data']);
?>
<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="type" value="<?php echo $type?>" />
	<input type="hidden" name="a" value="" />

	<div id="toolbox" class="p-3">

		<header class="d-flex justify-content-between mb-2">
			<ul class="nav nav-pills">
				<li class="nav-item">
					<a class="nav-link<?php if($type=='multi_move'):?> active<?php endif?>" href="<?php echo $g['adm_href']?>&amp;iframe=<?php echo $iframe?>&amp;type=multi_move">게시물 이동</a>
				</li>
				<li class="nav-item">
					<a class="nav-link<?php if($type=='multi_copy'):?> active<?php endif?>" href="<?php echo $g['adm_href']?>&amp;iframe=<?php echo $iframe?>&amp;type=multi_copy">게시물 복사</a>
				</li>
			</ul>
			<a class="btn btn-link" href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=multi_empty&amp;type=<?php echo $type?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 대기리스트를 비우시겠습니까?       ');">비우기</a>
		</header>

		<table class="table table-sm f13 text-center mb-0 border-bottom">
			<colgroup>
				<col width="30">
				<col width="80">
				<col>
				<col width="50">
				<col width="90">
			</colgroup>
			<thead class="thead-light">
				<tr>
					<th scope="col">
						<button type="button" class="btn btn-sm btn-link p-0" onclick="chkFlag('post_members[]');">선택</button>
					</th>
					<th scope="col">게시판</th>
					<th scope="col">제목</th>
					<th scope="col">조회</th>
					<th scope="col" class="side2">날짜</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach($postarray2['data'] as $val):?>
				<?php $R=getUidData($table[$module.'data'],$val)?>
				<?php $R['mobile']=isMobileConnect($R['agent'])?>
				<?php $B = getUidData($table[$module.'list'],$R['bbs']); ?>
				<tr>
					<td class="text-center">
						<div class="custom-control custom-checkbox custom-control-inline mr-0">
						  <input type="checkbox" class="custom-control-input" id="post_members_<?php echo $R['uid']?>" name="post_members[]" value="<?php echo $R['uid']?>" checked="checked">
						  <label class="custom-control-label" for="post_members_<?php echo $R['uid']?>"></label>
						</div>
					</td>
					<td class="bbsid"><?php echo $B['name'] ?></td>
					<td class="text-left">
						<?php if($R['notice']):?><span class="badge badge-light">공지</span><?php endif?>
						<?php if($R['mobile']):?><span class="badge badge-light"><i class="fa fa-mobile fa-lg"></i></span><?php endif?>
						<?php if($R['category']):?><span class="badge badge-light"><?php echo $R['category']?></span><?php endif?>
						<a href="<?php echo getPostLink2($R)?>" target="_blank" class="muted-link"><?php echo $R['subject']?></a>
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
						<?php if($R['hidden']):?>
						<span class="badge badge-light" data-toggle="tooltip" title="비밀글"><i class="fa fa-lock fa-lg"></i></span>
						<?php endif?>
						<?php if($R['comment']):?><span class="badge badge-light"><?php echo $R['comment']?><?php if($R['oneline']):?>+<?php echo $R['oneline']?><?php endif?></span><?php endif?>
						<?php if(getNew($R['d_regis'],24)):?><span class="rb-new"></span><?php endif?>
					</td>
					<td class="small"><?php echo $R['hit']?></td>
					<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
				</tr>
				<?php endforeach?>

				<?php if(!$postarray2['count']):?>
				<tr>
					<td class="text-center py-4 text-muted" colspan="5">게시물이 없습니다.</td>
				</tr>
				<?php endif?>

			</tbody>
		</table>

		<footer class="footer mt-5">


			<?php if($type == 'multi_copy'):?>

			<div class="form-group row">
		    <label class="col-sm-2 col-form-label text-right">게시판 선택</label>
		    <div class="col-sm-10">
					<select name="bid" class="form-control custom-select w-50">
						<option value="">&nbsp;+ 선택하세요</option>
						<option value="" disabled>---------------------------</option>
						<?php $_BBSLIST = getDbArray($table[$module.'list'],'','*','gid','asc',0,1)?>
						<?php while($_B=db_fetch_array($_BBSLIST)):?>
						<option value="<?php echo $_B['uid']?>"<?php if($_B['uid']==$bid):?> selected="selected"<?php endif?>>ㆍ<?php echo $_B['name']?>(<?php echo $_B['id']?> - <?php echo number_format($_B['num_r'])?>)</option>
						<?php endwhile?>
						<?php if(!db_num_rows($_BBSLIST)):?>
						<option value="">등록된 게시판이 없습니다.</option>
						<?php endif?>
					</select>
		    </div>
		  </div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right">복사옵션</label>
				<div class="col-sm-10 pt-2">

					<div class="custom-control custom-checkbox custom-control-inline">
					  <input type="checkbox" class="custom-control-input" id="inc_upload" name="inc_upload" value="1" checked="checked">
					  <label class="custom-control-label" for="inc_upload">첨부파일포함</label>
					</div>

					<div class="custom-control custom-checkbox custom-control-inline">
						<input type="checkbox" class="custom-control-input" id="inc_comment" name="inc_comment" value="1" checked="checked">
						<label class="custom-control-label" for="inc_upload">댓글/한줄의견포함</label>
					</div>

				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right"></label>
				<div class="col-sm-10">
					<input type="button" value="복사" class="btn btn-primary" onclick="actQue('multi_copy');" />
					<input type="button" value="닫기" class="btn btn-light" onclick="top.close();" />
				</div>
			</div>

			<?php else:?>

			<div class="form-group row">
		    <label class="col-sm-2 col-form-label text-right">게시판 선택</label>
		    <div class="col-sm-10">
					<select name="bid" class="form-control custom-select w-50">
						<option value="">&nbsp;+ 선택하세요</option>
						<option value="" disabled>---------------------------</option>
						<?php $_BBSLIST = getDbArray($table[$module.'list'],'','*','gid','asc',0,1)?>
						<?php while($_B=db_fetch_array($_BBSLIST)):?>
						<option value="<?php echo $_B['uid']?>"<?php if($_B['uid']==$bid):?> selected="selected"<?php endif?>>ㆍ<?php echo $_B['name']?>(<?php echo $_B['id']?> - <?php echo number_format($_B['num_r'])?>)</option>
						<?php endwhile?>
						<?php if(!db_num_rows($_BBSLIST)):?>
						<option value="">등록된 게시판이 없습니다.</option>
						<?php endif?>
					</select>
					<small class="form-text text-muted mt-2">
					 동일게시판의 게시물은 제외됨
					</small>
		    </div>
		  </div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label text-right"></label>
				<div class="col-sm-10">
					<input type="button" value="이동" class="btn btn-primary" onclick="actQue('multi_move');" />
					<input type="button" value="닫기" class="btn btn-light" onclick="top.close();" />
				</div>
			</div>

			<?php endif?>
		</footer>

	</div>

</form>

<script type="text/javascript">
//<![CDATA[
function actQue(act)
{
	var f = document.procForm;
    var l = document.getElementsByName('post_members[]');
    var n = l.length;
	var j = 0;
    var i;

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('선택된 게시물이 없습니다.      ');
		return false;
	}

	if (f.bid.value == '')
	{
		alert('게시판을 선택해 주세요.       ');
		f.bid.focus();
		return false;
	}
	if (confirm('정말로 실행하시겠습니까?    '))
	{
		f.a.value = act;
		f.submit();
	}
	return false;
}


document.title = "게시물 <?php echo $type=='multi_move'?'이동':'복사'?>";
self.resizeTo(650,650);
//]]>
</script>
