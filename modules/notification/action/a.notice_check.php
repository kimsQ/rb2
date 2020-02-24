<?php
if(!defined('__KIMS__')) exit;
if(!$my['uid']) exit;
$g['notiVarForSite'] = $g['path_var'].'site/'.$r.'/notification.var.php';
include_once file_exists($g['notiVarForSite']) ? $g['notiVarForSite'] : $g['path_module'].$m.'/var/var.php';

if($noticedata=='Y'):
$NT_DATA = explode('|',$my['noticeconf']);
?>
[RESULT:
<?php if($NT_DATA[2] && !$_SESSION['sh_notify_auto_del']):?>
<div class="alert alert-danger alert-dismissible" style="margin:0;border:0;border-radius:0;" role="alert">
	<button type="button" class="close" data-dismiss="alert" onclick="sessionSetting('sh_notify_auto_del','1','','');"><span aria-hidden="true">&times;</span></button>
	<strong><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&iframe=Y&system=popup.notification&callMod=config" class="alert-link">Warning!</a></strong> 자동삭제 설정되어 있습니다.
</div>
<?php endif?>
<?php $RCD = getDbArray($table['s_notice'],'mbruid='.$my['uid'].($callMod=='view'?'':" and d_read=''"),'*','uid','desc',($recnum?$recnum:10),$p)?>
<?php $_i=0;while($R=db_fetch_array($RCD)):?>
<?php if (!$R['d_read']) getDbUpdate($table['s_notice'],"d_read='".$date['totime']."'","uid='".$R['uid']."'")?>
<?php $M=getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'*')?>
<div class="list-group-item">

	<div class="media">
		<?php if($R['frommbr']):?>
		<a href="#." class="mr-3" id='_rb-popover-from-<?php echo $_i?>' data-placement="right" data-popover="popover" data-content="<div id='rb-popover-from-<?php echo $_i?>'><script>getPopover('member','<?php echo $R['mbruid']?>','rb-popover-from-<?php echo $_i?>')</script></div>">
			<img src="<?php echo $g['s']?>/files/avatar/<?php echo $M['photo']?$M['photo']:'0.svg'?>" width="48" height="48" alt="프로필 사진<?php echo $M['nic']?>" class="rounded-circle">
		</a>
		<?php else:?>
		<i class="fa fa-bullhorn fa-2x mr-3 text-muted"></i>
		<?php endif?>

		<div class="media-body">
			<div class="rb-message">
				<?php echo $R['message']?>
				<?php if($R['referer']):?>
				<a href="<?php echo $R['referer']?>" target="<?php echo $R['target']=='_blank'?$R['target']:'_ADMPNL_'?>" onclick="parent.getId('_close_btn_').click();">더보기 &raquo;</a>
				<?php endif?>
			</div>
			<div class="small text-muted">
				<?php if($R['frommbr']):?>From <?php echo $M['nic']?> <?php endif?>
				<?php echo getDateFormat($R['d_regis'],'n월 j일 A g시 i분')?>
				<?php if($callMod=='view'):?>
				<div class="btn-toolbar pull-right">
					<div class="btn-group-toggle">
						<label id="noti-<?php echo $R['uid']?>" class="btn btn-secondary btn-sm" title="선택" data-tooltip="tooltip">
							<input type="checkbox" name="noti_members[]" value="<?php echo $R['uid']?>|<?php echo $R['frommbr']?>|<?php echo $R['frommodule']?>" class="hidden" onclick="noti_check_child(this);">
							<i class="fa fa-check"></i>
						</label>
					</div>
				</div>
				<?php endif?>
			</div>
		</div>
	</div>
</div>
<?php if($NT_DATA[2]&&$R['d_read']) getDbDelete($table['s_notice'],"uid='".$R['uid']."'")?>
<?php $_i++;endwhile?>
<?php if(!$_i):?>
<div class="list-group-item media">
	<div class="pull-left">
		<i class="glyphicon glyphicon-info-sign fa-3x"></i>
	</div>
	<div class="media-body">
		<?php echo sprintf('<strong>%s</strong>님, 새 알림이 없습니다.<br>알림을 이용하시면 새로운 정보를 실시간으로 받아볼 수 있습니다.',$my[$_HS['nametype']])?><br>
		<div class="rb-time">
			<?php echo getDateFormat($date['totime'],'n월 j일 A g시 i분')?>
		</div>
	</div>
</div>
<?php
endif;
$not_readnum = getDbRows($table['s_notice'],'mbruid='.$my['uid']." and d_read=''");
if($my['num_notice'] != $not_readnum) getDbUpdate($table['s_mbrdata'],'num_notice='.$not_readnum,'memberuid='.$my['uid']);
?>
<img src="<?php echo $g['s']?>/_core/images/blank.gif" onload="<?php if($my['admin']):?>top.frames._ADMPNL_.<?php endif?>pushNotification(<?php echo $not_readnum?>);getNotificationNum(<?php echo $_i?>);">
:RESULT]
<?php
exit;
endif;

if ($isModal!='Y'):
$not_readnum = getDbRows($table['s_notice'],'mbruid='.$my['uid']." and d_read=''");
if($my['num_notice'] != $not_readnum) getDbUpdate($table['s_mbrdata'],'num_notice='.$not_readnum,'memberuid='.$my['uid']);
?>
<meta http-equiv="refresh" content="<?php echo $d['ntfc']['sec']?>;url=<?php echo $g['s']?>/?r=<?php echo $r?>&m=notification&a=notice_check">
<script>
parent.pushNotification(<?php echo $not_readnum?>);
</script>
<?php
endif;
exit;
?>
