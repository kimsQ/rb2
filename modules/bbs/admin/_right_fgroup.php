<!--
 // makebbs.php 의 권한설정 부분
-->
<fieldset>
	<legend><span class="badge badge-pill badge-primary">목록접근</span></legend>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">허용등급</label>
			<div class="col-lg-10 col-xl-9">
				<select name="perm_l_list" class="form-control custom-select">
					<option value="0">&nbsp;+ 전체허용</option>
					<option value="0">--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['bbs']['perm_l_list']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
				</select>
			</div>
	</div>
	<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">차단그룹</label>
			<div class="col-lg-10 col-xl-9">
				 <select name="_perm_g_list" class="form-control custom-select" multiple size="5">
					<option value=""<?php if(!$d['bbs']['perm_g_list']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					<?php while($_S=db_fetch_array($_SOSOK)):?>
					<option value="<?php echo $_S['uid']?>"<?php if(strstr($d['bbs']['perm_g_list'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					<?php endwhile?>
				</select>
			</div>
	 </div>
</fieldset>

<fieldset class="mt-4">
	 <legend><span class="badge badge-pill badge-primary">본문열람</span></legend>
		<div class="form-group row">
			 <label class="col-lg-2 col-form-label text-lg-right">허용등급</label>
			 <div class="col-lg-10 col-xl-9">
				 <select name="perm_l_view" class="form-control custom-select">
					 <option value="0">&nbsp;+ 전체허용</option>
					 <option value="0">--------------------------------</option>
					 <?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					 <?php while($_L=db_fetch_array($_LEVEL)):?>
					 <option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['bbs']['perm_l_view']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					 <?php if($_L['gid'])break; endwhile?>
				 </select>
			 </div>
	 </div>
	 <div class="form-group row">
			 <label class="col-lg-2 col-form-label text-lg-right">차단그룹</label>
			 <div class="col-lg-10 col-xl-9">
					<select name="_perm_g_view" class="form-control custom-select" multiple size="5">
					 <option value=""<?php if(!$d['bbs']['perm_g_view']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					 <?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					 <?php while($_S=db_fetch_array($_SOSOK)):?>
					 <option value="<?php echo $_S['uid']?>"<?php if(strstr($d['bbs']['perm_g_view'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					 <?php endwhile?>
				 </select>
			 </div>
		</div>
</fieldset>

<fieldset class="mt-4">
	<legend><span class="badge badge-pill badge-primary">글쓰기</span></legend>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">허용등급</label>
			<div class="col-lg-10 col-xl-9">
				<?php if (!$uid): ?>
				<input type="hidden" name="perm_l_write" value="1">
				<?php else: ?>
				<select name="perm_l_write" class="form-control custom-select">
					<option value="0">&nbsp;+ 전체허용</option>
					<option value="0">--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['bbs']['perm_l_write']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
				</select>
				<?php endif; ?>
			</div>
	</div>
	<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">차단그룹</label>
			<div class="col-lg-10 col-xl-9">
				 <select name="_perm_g_write" class="form-control custom-select" multiple size="5">
					<option value=""<?php if(!$d['bbs']['perm_g_write']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					<?php while($_S=db_fetch_array($_SOSOK)):?>
					<option value="<?php echo $_S['uid']?>"<?php if(strstr($d['bbs']['perm_g_write'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					<?php endwhile?>
				</select>
			</div>
	 </div>
</fieldset>

<fieldset class="mt-4">
	<legend><span class="badge badge-pill badge-primary">다운로드</span></legend>
	 <div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">허용등급</label>
			<div class="col-lg-10 col-xl-9">
				<select name="perm_l_down" class="form-control custom-select">
					<option value="0">&nbsp;+ 전체허용</option>
					<option value="0">--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['bbs']['perm_l_down']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
				</select>
			</div>
	</div>
	<div class="form-group row">
			<label class="col-lg-2 col-form-label text-lg-right">차단그룹</label>
			<div class="col-lg-10 col-xl-9">
				 <select name="_perm_g_down" class="form-control custom-select" multiple size="5">
					<option value=""<?php if(!$d['bbs']['perm_g_down']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					<?php while($_S=db_fetch_array($_SOSOK)):?>
					<option value="<?php echo $_S['uid']?>"<?php if(strstr($d['bbs']['perm_g_down'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					<?php endwhile?>
				</select>
			</div>
	 </div>
</fieldset>
