<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;

$sqlque = 'mbruid='.$my['uid'];
if ($module) $sqlque .= " and frommodule='".$module."'";
if ($fromsys) $sqlque .= " and frommbr=0";

$RCD = getDbArray($table['s_notice'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_notice'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$pageHome = './noti';

if ($module) {
	$pageLink = './noti?module='.$module.'&amp;';
} else {
	$pageLink = './noti?';
}

//모든 알림 읽음처리
getDbUpdate($table['s_notice'],"d_read='".$date['totime']."'",$sqlque);
getDbUpdate($table['s_mbrdata'],'num_notice=0','memberuid='.$my['uid']);
?>


<div class="container">

	<div class="subhead mt-0">
		<h2 class="subhead-heading">
			<i class="fa fa-bell-o fa-fw" aria-hidden="true"></i> 내 알림함
		</h2>
		<span class="text-muted">알림을 수신하면 웹 사이트내의 정보는 물론 회원님이 언급되거나 관련된 정보들을 실시간으로 받아보실 수 있습니다.</span>
	</div>

	<div class="row mt-3">
		<div class="col-3">

			<?php include $g['dir_module_skin'].'_nav.php';?>

		</div><!-- /.col-3 -->
		<div class="col-9">

			<form name="listForm" action="<?php echo $g['s']?>/" method="post">
				<input type="hidden" name="r" value="<?php echo $r?>">
				<input type="hidden" name="m" value="notification">
				<input type="hidden" name="a" value="">
				<input type="hidden" name="deltype" value="">

				<div class="card">

					<?php if($NUM):?>
					<div class="card-header py-2">
						<section class="d-flex justify-content-between align-items-center">
							<div class="">
								<div class="custom-control custom-checkbox mr-3" data-toggle="tooltip" title="전체선택">
									<input type="checkbox" class="custom-control-input js-checkAll" id="checkAll">
									<label class="custom-control-label" for="checkAll" data-role="checked-num"></label>
								</div>

							</div>
							<fieldset disabled data-role="actions">
								<button type="button" class="btn btn-light btn-sm" onclick="actCheck('multi_delete_user','cut_member');">
									<i class="fa fa-ban fa-fw fa-lg" aria-hidden="true"></i>
									보낸회원 차단
								</button>
								<button type="button" class="btn btn-light btn-sm" onclick="actCheck('multi_delete_user','cut_module');">
									<i class="fa fa-ban fa-fw fa-lg" aria-hidden="true"></i>
									보낸곳 차단
								</button>
								<button type="button" class="btn btn-light btn-sm" onclick="actCheck('multi_delete_user','delete_select');">
									<i class="fa fa-trash fa-fw fa-lg" aria-hidden="true"></i>
									삭제
								</button>
							</fieldset>
						</section>
					</div>
					<?php endif?>

					<ul class="list-group list-group-flush">
						<?php $_i=0;while($R=db_fetch_array($RCD)):?>
						<?php $SM1=$R['mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'name,nic'):array()?>
						<?php $SM2=$R['frommbr']?getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'memberuid,name,nic'):array()?>
						<?php $MD = getDbData($table['s_module'],"id='".$R['frommodule']."'",'icon'); ?>
						<?php $avatar =$R['frommbr']?getAvatarSrc($SM2['memberuid'],'42'):'/_core/images/touch/homescreen-42x42.png'  ?>
					  <li class="list-group-item d-flex list-group-item-action ">

							<div class="custom-control custom-checkbox mr-3">
							  <input type="checkbox" class="custom-control-input" name="noti_members[]" id="item-<?php echo $R['uid']?>" onclick="checkboxCheck();" value="<?php echo $R['uid']?>|<?php echo $R['frommbr']?>|<?php echo $R['frommodule']?>">
							  <label class="custom-control-label" for="item-<?php echo $R['uid']?>"></label>
							</div>

							<div class="media w-100">
								<a class="mr-3 position-relative" href="<?php echo getProfileLink($SM2['memberuid']) ?>"
									data-toggle="getMemberLayer"
									data-mbruid="<?php echo $SM2['memberuid'] ?>">
									<img class="rounded " src="<?php echo $avatar ?>" alt="" width=42>
									<?php if ($R['frommbr']): ?>
									<i class="<?php echo $MD['icon'] ?> bg-primary text-white position-absolute noti-mobule-badge"></i>
									<?php endif?>
								</a>
								<div class="media-body">
									<div class="d-flex w-100 justify-content-between mb-1">
										<h5 class="my-0">
											<?php if($SM2['name']):?>
											<a class="f15 muted-link" href="<?php echo getProfileLink($SM2['memberuid']) ?>"
					              data-toggle="getMemberLayer"
					              data-mbruid="<?php echo $SM2['memberuid'] ?>">
					              <?php echo $R['title']?> <?php echo $SM2[$_HS['nametype']]?>
					            </a>
											<?php else: ?>
											<?php echo $R['title']?>  <span class="badge badge-pill badge-light">시스템</span>
											<?php endif?>
										</h5>
										<div class="">
											<?php if(getNew($R['d_regis'],24)):?><small class="rb-new align-text-top"></small><?php endif?>
											<time class="small text-muted" data-plugin="timeago" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-toggle="tooltip" title="<?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?>">
											</time>
										</div>
									</div>
									<p class="mb-0">
										<?php echo getStrCut($R['message'],200,'..')?>
										<?php if (strlen($R['message'])>200): ?>
										<a class="ml-2 badge badge-light"
											data-toggle="modal" href="#modal-noti"
											data-uid="<?php echo $R['uid'] ?>"
											data-from="<?php echo $SM2[$_HS['nametype']] ?>">
											 자세히
										 </a>
										<?php endif; ?>
									</p>

									 <?php if ($R['referer']): ?>
									 <a href="<?php echo $R['referer']?>" target="_blank" class="badge badge-light"><?php echo $R['button']?></a>
									 <?php endif; ?>



								</div>
							</div>
						</li>
						<?php $_i++;endwhile?>

						<?php if(!$NUM):?>
						<li class="list-group-item">
							<div class="p-5 text-center text-muted">알림이 없습니다.</div>
						</li>
						<?php endif?>

					</ul>
				</div><!-- /.card -->

			</form>

				<?php if($NUM):?>
				<div class="d-flex justify-content-center my-4">
					<ul class="pagination mb-0">
						<?php echo getPageLink(10,$p,$TPG,'')?>
					</ul>
				</div>
				<?php endif?>




		</div><!-- /.col-9 -->
	</div><!-- /.row -->

</div><!-- /.container -->



<script type="text/javascript">

// 선택박스 체크시 액션버튼 활성화 함수
function checkboxCheck() {
	var f = document.listForm;
    var l = document.getElementsByName('noti_members[]');
    var n = l.length;
    var i;
	var j=0;

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true){
          $(l[i]).parent().parent().addClass('list-group-item-checked'); // 선택된 체크박스 tr 강조표시
			j++;
		}else{
			$(l[i]).parent().parent().removeClass('list-group-item-checked');
		}
	}

	if (j) {
		$('[data-role="checked-num"]').text(j+'개 선택됨')
		$('[data-role="actions"]').attr('disabled',false)
		$('#checkAll').prop('indeterminate', true)
	} else {
		$('[data-role="checked-num"]').text('')
		$('#checkAll').prop('indeterminate', false)
		$('[data-role="actions"]').attr('disabled',true)
	}


	// 하단 회원관리 액션 버튼 상태 변경
	if (j) $('#list-bottom-fset').prop("disabled",false);
	else $('#list-bottom-fset').prop("disabled",true);
}

function actCheck(act,type) {
	var f = document.listForm;
	var l = document.getElementsByName('noti_members[]');
	var n = l.length;
	var j = 0;
	var i;

	if (type == 'delete_all' || type == 'delete_read')
	{
		if (confirm('정말로 일괄 삭제하시겠습니까?'))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.deltype.value = type;
			f.submit();
		}
		return false;
	}

	for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
		}
	}
	if (!j)
	{
		alert('선택된 알림이 없습니다. ');
		return false;
	}

	getIframeForAction(f);
	f.a.value = act;
	f.deltype.value = type;
	f.submit();
}

$(function () {

	putCookieAlert('member_noti_result') // 실행결과 알림 메시지 출력

	// 선택박스 체크 이벤트 핸들러
	$(".js-checkAll").click(function(){
		$('[name="noti_members[]"]').prop("checked",$(".js-checkAll").prop("checked"));
		checkboxCheck();
		$(this).prop('indeterminate', false)
		$('[data-toggle="tooltip"]').tooltip('hide')
	});

	//게시물 목록에서 프로필 풍선(popover) 띄우기
	$('[data-toggle="getMemberLayer"]').popover({
		container: 'body',
		trigger: 'manual',
		html: true,
		content: function () {
			var uid = $(this).attr('data-uid')
			var mbruid = $(this).attr('data-mbruid')
			var type = 'popover'
			$.post(rooturl+'/?r='+raccount+'&m=member&a=get_profileData',{
				 mbruid : mbruid,
				 type : type
				},function(response){
				 var result = $.parseJSON(response);
				 var profile=result.profile;
				 $('#popover-item-'+uid).html(profile);
			 });
			return '<div id="popover-item-'+uid+'" class="p-1">불러오는 중...</div>';
		}
	})
	.on("mouseenter", function () {
		var _this = this;
		$(this).popover("show");
		$(".popover").on("mouseleave", function () {
			$(_this).popover('hide');
		});
	}).on("mouseleave", function () {
		var _this = this;
		setTimeout(function () {
			if (!$(".popover:hover").length) {
				$(_this).popover("hide");
			}
		}, 30);
	});

})
</script>
