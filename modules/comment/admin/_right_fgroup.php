<!--
 // makebbs.php 의 권한설정 부분 
-->
<div class="well well-lg">
	<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				 <h3><span class="label label-default">채팅 열람</label></h3>
			</div>				
	</div>
    <div class="form-group">
			<label class="col-sm-2 control-label">허용등급</label>
			<div class="col-sm-10">
				<select name="perm_l_view" class="form-control">
					<option value="0">&nbsp;+ 전체허용</option>
					<option value="0">--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['bbs']['perm_l_view']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
				</select>
			</div>				
	</div>
	<div class="form-group">
			<label class="col-sm-2 control-label">차단그룹</label>
			<div class="col-sm-10">
			   <select name="_perm_g_view" class="form-control" multiple size="5">
					<option value=""<?php if(!$d['bbs']['perm_g_view']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					<?php while($_S=db_fetch_array($_SOSOK)):?>
					<option value="<?php echo $_S['uid']?>"<?php if(strstr($d['bbs']['perm_g_view'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					<?php endwhile?>
				</select>
			</div>				
	 </div>
</div> <!-- .well-->	 	 

<div class="well well-lg">
	 <div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				 <h3><span class="label label-default">채팅 참여(글쓰기)</label></h3>
			 </div>				
	</div>
    <div class="form-group">
			<label class="col-sm-2 control-label">허용등급</label>
			<div class="col-sm-10">
				<select name="perm_l_write" class="form-control">
					<option value="0">&nbsp;+ 전체허용</option>
					<option value="0">--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['bbs']['perm_l_write']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
				</select>
			</div>				
	</div>
	<div class="form-group">
			<label class="col-sm-2 control-label">차단그룹</label>
			<div class="col-sm-10">
			   <select name="_perm_g_write" class="form-control" multiple size="5">
					<option value=""<?php if(!$d['bbs']['perm_g_write']):?> selected="selected"<?php endif?>>ㆍ차단안함</option>
					<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
					<?php while($_S=db_fetch_array($_SOSOK)):?>
					<option value="<?php echo $_S['uid']?>"<?php if(strstr($d['bbs']['perm_g_write'],'['.$_S['uid'].']')):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
					<?php endwhile?>
				</select>
			</div>				
	 </div>
</div> <!-- .well-->
