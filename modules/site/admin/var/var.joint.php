<?php
$dropButtonUrl = ''; //모듈연결하기 버튼에 지정할 URL(미 지정시 모듈연결버튼 생략)$recnum = 15;$catque = 'site='.$s.' and pagetype>1';if ($cat) $catque .= " and category='".$cat."'";if ($_keyw) $catque .= " and ".$where." like '".$_keyw."%'";$PAGES = getDbArray($table['s_page'],$catque,'*','uid','asc',$recnum,$p);$NUM = getDbRows($table['s_page'],$catque);$TPG = getTotalPage($NUM,$recnum);?>
<div id="mjointbox">
	<div class="title">
		<form class="form-inline rb-form" role="form" action="<?php echo $g['s']?>/" method="get">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="system" value="<?php echo $system?>">
			<input type="hidden" name="iframe" value="<?php echo $iframe?>" />
			<input type="hidden" name="dropfield" value="<?php echo $dropfield?>">
			<input type="hidden" name="smodule" value="<?php echo $smodule?>">
			<input type="hidden" name="cmodule" value="<?php echo $cmodule?>">
			<input type="hidden" name="p" value="<?php echo $p?>">

			<select class="form-control custom-select form-control-sm" name="cat" class="cat" onchange="this.form.submit();">
				<option value="">&nbsp;+ 페이지분류</option>
				<?php $_cats=array()?>
				<?php $CATS=db_query("select *,count(*) as cnt from ".$table['s_page']." group by category",$DB_CONNECT)?>
				<?php while($C=db_fetch_array($CATS)):$_cats[]=$C['category']?>
				<option value="<?php echo $C['category']?>"<?php if($C['category']==$cat):?> selected<?php endif?>>ㆍ<?php echo $C['category']?> (<?php echo $C['cnt']?>)</option>
				<?php endwhile?>
			</select>

			<select class="form-control custom-select form-control-sm ml-1" name="where">
				<option value="name"<?php if($where == 'name'):?> selected="selected"<?php endif?>>페이지명</option>
				<option value="id"<?php if($where == 'id'):?> selected="selected"<?php endif?>>페이지코드</option>
			</select>

			<input class="form-control form-control-sm ml-1" placeholder="" type="text" name="_keyw" size="10" value="<?php echo addslashes($_keyw)?>">

			<input type="submit" value=" 검색 " class="btn btn-light btn-sm ml-1">
			<input type="button" value=" 리셋 " class="btn btn-light btn-sm ml-1" onclick="this.form.p.value=1;this.form.cat.value='';this.form._keyw.value='';this.form.submit();">

		</form>
	</div>

	<?php if($NUM):?>
	<table class="table table-sm table-hover">
		<?php while($PR = db_fetch_array($PAGES)):?>
		<tr>
			<td class="align-middle pl-2">
				<a href="<?php echo RW('mod='.$PR['id'])?>" target="_blank" title="페이지보기" data-tooltip="tooltip" class="muted-link">
					<i class="fa fa-file-text-o"></i>
					<?php echo $PR['name']?>
				</a>
				<span class="badge badge-pill badge-secondary"><?php echo $PR['id']?></span>
			</td>
			<td class="text-right">
				<button class="btn btn-light btn-sm" type="button" onclick="dropJoint('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $smodule?>&mod=<?php echo $PR['id']?>');">
					<i class="fa fa-floppy-o"></i>
					연결하기
				</button>
			</td>
		</tr>
		<?php endwhile?>
	</table>
	<div class="rb-page-box">
		<ul class="pagination pagination-sm justify-content-center mt-3">
			<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
		</ul>
	</div>
	<?php endif?></div>
<style>
#mjointbox {}
#mjointbox .title {padding:0 0 20px 0;}
#mjointbox .rb-page-box {text-align:center;border-top:#dfdfdf solid 1px;margin:20px 0 20px 0;}
</style>
