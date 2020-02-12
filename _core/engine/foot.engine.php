<!-- 사이트 풋터 코드 -->
<?php echo $_HS['footercode'] ?>

<!-- 푸터 스위치 -->
<?php foreach($g['switch_3'] as $_switch) include $_switch ?>

<?php if($g['mobile']&&$_SESSION['pcmode']=='Y'&&$iframe!='Y'):?>
<div id="pctomobile" class="bg-faded" style="width:100%">
	<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=mobilemode" class="btn btn-block btn-secondary" style="font-size: 4rem;padding: 3rem">
		<i class="fa fa-mobile fa-lg" aria-hidden="true"></i> 모바일 모드 전환
	</a>
</div>
<?php endif?>

<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_"></div>

<iframe hidden name="_action_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no" title="iframe"></iframe>

<!-- 알림처리 -->
<iframe hidden name="pushframe" src="" title="iframe"></iframe>

<?php
if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$g['wdgcod'] = $g['path_tmp'].'widget/c'.$_HM['uid'].'.p'.$_HP['uid'].'.mobile.cache';
} else {
	$g['wdgcod'] = $g['path_tmp'].'widget/c'.$_HM['uid'].'.p'.$_HP['uid'].'.desktop.cache';
}
if(is_file($g['wdgcod'])) include $g['wdgcod'];
if($g['widget_cssjs']) include $g['path_core'].'engine/widget.cssjs.php';
if($my['uid']) include $g['path_core'].'engine/notification.engine.php';
?>

<script>

$(function() {

	Iframely('oembed[url]') // oembed 미디어 변환

	// 회원가입 작동중단 처리
	<?php if (!$d['member']['join_enable']): ?>
		$('#modal-join').on('show.<?php echo ($g['mobile']&&$_SESSION['pcmode']!='Y')?'rc':'bs' ?>.modal', function (e) {
			alert('죄송합니다. 지금은 회원가입을 하실 수 없습니다.')
			location.reload();
		})
	<?php endif; ?>

	// 알림 기본 셋팅값 정의
	<?php if ($g['mobile'] && $_SESSION['pcmode'] != 'Y'): ?>
	$.notifyDefaults({
		placement: {
			from: "bottom",
			align: "center"
		},
		allow_dismiss: false,
		offset: 20,
		type: "default",
		timer: 100,
		delay: 1500,
		animate: {
			enter: "animated fadeInUp",
			exit: "animated fadeOutDown"
		}
	});
	<?php else: ?>
	$.notifyDefaults({
		placement: {
			from: "top",
			align: "right"
		},
		allow_dismiss: false,
		offset: 20,
		type: "success",
		timer: 100,
		delay: 1500,
		animate: {
			enter: "animated fadeInDown",
			exit: "animated fadeOutUp"
		}
	});
	<?php endif; ?>

});

	<?php if($_HS['dtd']):?>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', '<?php echo $_HS['dtd']?>', 'auto');
	ga('send', 'pageview');
	<?php endif?>

</script>
