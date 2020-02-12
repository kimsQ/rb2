<div id="jointbox">
	<div class="category">
		<div class="list-group">
		<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
		<?php while($R=db_fetch_array($MODULES)):?>
		<?php $_jfile0 = $g['path_module'].$R['id'].'/admin/var/var.joint.php'?>
		<?php if(!is_file($_jfile0)||strstr($cmodule,'['.$R['id'].']'))continue?>
		<?php if($smodule==$R['id']) $g['var_joint_file'] = is_file($_jfile0)?$_jfile0:(is_file($_jfile1)?$_jfile1:$_jfile2)?>
		<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;iframe=<?php echo $iframe?>&amp;dropfield=<?php echo $dropfield?>&amp;smodule=<?php echo $R['id']?>&amp;cmodule=<?php echo $cmodule?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php if($smodule==$R['id']):?> active<?php endif?>"><span><i class="kf fa-fw <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?>"></i> <?php echo $R['name']?></span><span class="badge badge-light badge-pill"><?php echo $R['id']?></span></a>
		<?php endwhile?>
		</div>
	</div>
	<div class="content">
		<?php if($smodule):?>
		<?php include $g['var_joint_file'] ?>
		<?php else:?>
		<div class="none">
			<i class="kf kf-module fa-5x"></i><br><br>
			연결할 모듈을 선택하세요.
		</div>
		<?php endif?>
	</div>
</div>



<!-- @부모레이어를 제어할 수 있도록 모달의 헤더와 풋터를 부모레이어에 출력시킴 -->

<div id="_modal_header" class="hidden">
  <h4 class="modal-title"><i class="kf-module kf-lg"></i> 모듈 연결하기</h4>
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>

<div id="_modal_footer" class="hidden">
	<?php if($dropButtonUrl):?>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
	<button type="button" class="btn btn-primary" onclick="frames._modal_iframe_modal_window.dropJoint('<?php echo $dropButtonUrl?>');">모듈연결</button>
	<?php else:?>
	<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" id="_modalclosebtn_">닫기</button>
	<?php endif?>
</div>




<script>
function dropJoint(m)
{
	var f = parent.getId('<?php echo $dropfield?>');
	f.value = m;
	parent.$('#modal_window').modal('hide');
}
function modalSetting()
{
	parent.getId('modal_window_dialog_modal_window').style.width = '100%';
	parent.getId('modal_window_dialog_modal_window').style.paddingRight = '20px';
	parent.getId('modal_window_dialog_modal_window').style.maxWidth = '800px';
	parent.getId('_modal_iframe_modal_window').style.height = '430px';
	parent.getId('_modal_body_modal_window').style.height = '430px';

	parent.getId('_modal_header_modal_window').innerHTML = getId('_modal_header').innerHTML;
	parent.getId('_modal_header_modal_window').className = 'modal-header';
	parent.getId('_modal_body_modal_window').style.padding = '0';
	parent.getId('_modal_body_modal_window').style.margin = '0';

	parent.getId('_modal_footer_modal_window').innerHTML = getId('_modal_footer').innerHTML;
	parent.getId('_modal_footer_modal_window').className = 'modal-footer';
}
modalSetting();
</script>
