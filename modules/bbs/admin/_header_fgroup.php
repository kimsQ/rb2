<!--
 // makebbs.php 의 헤더삽입  부분
-->
<div class="form-group row">
	 <label class="col-lg-2 col-form-label text-lg-right" >헤더 파일</label>
	 <div class="col-lg-10 col-xl-9">
	  	 <input type="file" name="imghead">
		 <?php if($R['imghead']):?>
		 <p class="form-control-static">
		 	 <a class="btn bnt-link" href="<?php echo $g['s']?>/?m=<?php echo $module?>&amp;a=bbs_file_delete&amp;bid=<?php echo $R['id']?>&amp;dtype=head" target="_action_frame_admin"  onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">삭제</a>
	       <a class="btn btn-link" href="<?php echo $g['s']?>/modules/<?php echo $module?>/var/files/<?php echo $R['imghead']?>" target="_blank">등록파일 보기</a>
		 </p>
		 <?php else:?>
		 <small class="help-block">(gif/jpg/png 가능)</small>
		 <?php endif?>
	 </div>
</div>
<div class="form-group row">
   <label class="col-lg-2 col-form-label text-lg-right">
       헤더 코드
   </label>
 	<div class="col-lg-10 col-xl-9">
	    <p>
		    <textarea name="codhead" id="codheadArea" class="form-control" rows="5"><?php if(is_file($g['path_module'].$module.'/var/code/'.$R['id'].'.header.php')) echo htmlspecialchars(implode('',file($g['path_module'].$module.'/var/code/'.$R['id'].'.header.php')))?></textarea>
	    </p>
    </div>
</div>
<div class="form-group row">
   <label class="col-lg-2 col-form-label text-lg-right">
       노출 위치
   </label>
 	<div class="col-lg-10 col-xl-9">

		<div class="custom-control custom-checkbox custom-control-inline">
		  <input type="checkbox" class="custom-control-input" id="inc_head_list" name="inc_head_list" value="[l]"<?php if(strstr($R['puthead'],'[l]')):?> checked <?php endif?>>
		  <label class="custom-control-label" for="inc_head_list">목록</label>
		</div>
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" class="custom-control-input" id="inc_head_view" name="inc_head_view" value="[v]"<?php if(strstr($R['puthead'],'[v]')):?> checked <?php endif?>>
			<label class="custom-control-label" for="inc_head_view">본문</label>
		</div>
		<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" class="custom-control-input" id="inc_head_write" name="inc_head_write" value="[w]"<?php if(strstr($R['puthead'],'[w]')):?> checked <?php endif?>>
			<label class="custom-control-label" for="inc_head_write">쓰기</label>
		</div>

  </div>
</div>
