<!--
 // makebbs.php 의 픗터삽입  부분 
-->  
<div class="form-group">
	 <label class="col-sm-2 control-label">픗터 파일</label>
	 <div class="col-sm-10">
	  	 <input type="file" name="imgfoot">
		 <?php if($R['imgfoot']):?>
		 <p class="form-control-static">
		 	 <a class="btn bnt-link" href="<?php echo $g['r']?>/?m=<?php echo $module?>&amp;a=bbs_file_delete&amp;bid=<?php echo $R['id']?>&amp;dtype=foot" target="_action_frame_<?php echo $m?>"  onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?');">삭제</a>
	       <a class="btn btn-link" href="<?php echo $g['s']?>/modules/<?php echo $module?>/var/files/<?php echo $R['imgfoot']?>" target="_blank">등록파일 보기</a>
		 </p>
		 <?php else:?>
		 <small class="help-block">(gif/jpg/png/swf 가능)</small>
		 <?php endif?>
	 </div>
</div>
<div class="form-group">
   <label class="col-sm-2 control-label">
       픗터 코드
   </label>
 	<div class="col-sm-10">
	    <p>
		    <textarea name="codfoot" id="codfootArea" class="form-control" rows="5"><?php if(is_file($g['path_module'].$module.'/var/code/'.$R['id'].'.footer.php')) echo htmlspecialchars(implode('',file($g['path_module'].$module.'/var/code/'.$R['id'].'.footer.php')))?></textarea>
	    </p>
    </div>
</div>
<div class="form-group">
   <label class="col-sm-2 control-label">
       노출 위치
   </label>
 	<div class="col-sm-10">
	    <div class="col-sm-3">
	    	  <label class="checkbox">
		        <input  type="checkbox" name="inc_foot_list" value="[l]"<?php if(strstr($R['putfoot'],'[l]')):?> checked <?php endif?>  class="form-control"> <i></i>목록		
		     </label>
		 </div>   
		 <div class="col-sm-3">
		 	  <label class="checkbox">
		        <input  type="checkbox" name="inc_foot_view" value="[v]"<?php if(strstr($R['putfoot'],'[v]')):?> checked <?php endif?>  class="form-control"><i></i>본문		
		     </label>
		 </div>   
		 <div class="col-sm-3">
		 	  <label class="checkbox">
		        <input  type="checkbox" name="inc_foot_write" value="[w]"<?php if(strstr($R['putfoot'],'[w]')):?> checked <?php endif?>  class="form-control"><i></i>쓰기		
		     </label>
		 </div>   		  
    </div>
</div>
