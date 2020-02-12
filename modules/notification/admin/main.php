<?php
$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 301 ? $recnum : 30;
$sqlque	= 'uid';

$account = $SD['uid'];
$sqlque .= ' and site='.$account;
if ($moduleid) $sqlque .= " and frommodule='".$moduleid."'";
if ($isread)
{
	if ($isread == 1) $sqlque .= " and d_read<>''";
	else $sqlque .= " and d_read=''";
}
if ($where && $keyw)
{
	$sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');
}

$RCD = getDbArray($table['s_notice'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_notice'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>


<div id="notification" class="px-4 my-3">

	<form name="procForm" action="<?php echo $g['s']?>/" method="get" class="form-horizontal">
		<input type="hidden" name="r" value="<?php echo $r?>">
		<input type="hidden" name="m" value="<?php echo $m?>">
		<input type="hidden" name="module" value="<?php echo $module?>">
		<input type="hidden" name="front" value="<?php echo $front?>">

		<div class="form-inline">
			<select name="moduleid" class="form-control custom-select" onchange="this.form.submit();">
				<option value="">모듈(전체)</option>
				<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,$p)?>
				<?php while($MD = db_fetch_array($MODULES)):?>
				<option value="<?php echo $MD['id']?>"<?php if($MD['id']==$moduleid):?> selected<?php endif?>><?php echo $MD['name']?> (<?php echo $MD['id']?>)</option>
				<?php endwhile?>
			</select>
			<select name="isread" class="form-control custom-select" onchange="this.form.submit();">
				<option value="">상태(전체)</option>
				<option value="1"<?php if($isread==1):?> selected<?php endif?>>확인</option>
				<option value="2"<?php if($isread==2):?> selected<?php endif?>>미확인</option>
			</select>

			<select name="recnum" onchange="this.form.submit();" class="form-control custom-select">
				<?php for($i=30;$i<=300;$i=$i+30):?>
				<option value="<?php echo $i?>"<?php if($i==$recnum):?> selected="selected"<?php endif?>><?php echo sprintf('%d 개',$i)?></option>
				<?php endfor?>
			</select>

			<div class="btn-toolbar ml-2">
				<div class="btn-group btn-group-toggle" data-toggle="buttons">
					<label class="btn btn-light<?php if($sort=='uid'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
						<input type="radio" value="uid" name="sort"<?php if($sort=='uid'):?> checked<?php endif?>> 알림일
					</label>
					<label class="btn btn-light<?php if($sort=='d_read'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
						<input type="radio" value="d_read" name="sort"<?php if($sort=='d_read'):?> checked<?php endif?>> 확인일
					</label>
				</div>

				<div class="btn-group btn-group-toggle ml-2" data-toggle="buttons">
					<label class="btn btn-light<?php if($orderby=='desc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
						<input type="radio" value="desc" name="orderby"<?php if($orderby=='desc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-desc"></i> 역순
					</label>
					<label class="btn btn-light<?php if($orderby=='asc'):?> active<?php endif?>" onclick="btnFormSubmit(this);">
						<input type="radio" value="asc" name="orderby"<?php if($orderby=='asc'):?> checked<?php endif?>> <i class="fa fa-sort-amount-asc"></i> 정순
					</label>
				</div>
			</div>

		</div><!-- /.form-inline -->

		<div class="form-inline mt-2">

			<select name="where" class="form-control custom-select">
				<option value="message"<?php if($where=='message'):?> selected="selected"<?php endif?>>메시지</option>
				<option value="referer"<?php if($where=='referer'):?> selected="selected"<?php endif?>>URL</option>
			</select>
			<input type="text" name="keyw" value="<?php echo stripslashes($keyw)?>" class="form-control ml-2">
			<button class="btn btn-light ml-2" type="submit">검색</button>
			<a href="<?php echo $g['adm_href']?>" class="btn btn-light ml-1">초기화</a>

			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=notice_testonly" onclick="return hrefCheck(this,true,'정말로 테스트 알림을 보내시겠습니까?     ');" class="btn btn-light ml-2">테스트 알림</a>
			<a href="#." class="btn btn-light rb-notifications-modal ml-1" role="button" data-toggle="modal" data-target="#modal_window">내알림 보기</a>

		</div><!-- /.form-inline -->

	</form>

</div>

<form name="listForm" action="<?php echo $g['s']?>/" method="post">
	<input type="hidden" name="r" value="<?php echo $r?>">
	<input type="hidden" name="m" value="<?php echo $module?>">
	<input type="hidden" name="a" value="">

	<div class="table-responsive">
		<table class="table table-striped f13 text-center">

			<colgroup>
				<col width="50">
				<col width="50">
				<col width="80">
				<col width="80">
				<col>
				<col width="100">
				<col width="100">
				<col width="100">
			</colgroup>
			<thead class="small text-muted">
				<tr>
					<th>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input checkAll-noti-user" id="checkAll-noti-user">
							<label class="custom-control-label" for="checkAll-noti-user"></label>
						</div>
					</th>
					<th>번호</th>
					<th>보낸사람</th>
					<th>받는사람</th>
					<th class="text-left">내용</th>
					<th>연결 URL</th>
					<th>알림일시</th>
					<th>확인일시</th>
				</tr>
			</thead>
			<?php $_i=0;while($R=db_fetch_array($RCD)):?>
			<?php $SM1=$R['mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'name,nic'):array()?>
			<?php $SM2=$R['frommbr']?getDbData($table['s_mbrdata'],'memberuid='.$R['frommbr'],'name,nic'):array()?>
			<tr>
				<td>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input checkAll-noti-user" id="noti_members_<?php echo $R['uid']?>" name="noti_members[]" value="<?php echo $R['uid']?>" onclick="checkboxCheck();">
						<label class="custom-control-label" for="noti_members_<?php echo $R['uid']?>"></label>
					</div>
				</td>
				<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
				<td>
					<?php if($SM2['name']):?>
					<a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-mbrinfo badge badge-pill badge-dark" onmousedown="mbrIdDrop('<?php echo $R['frommbr']?>','notice');">
						<?php echo $SM2[$_HS['nametype']]?></a>
					<?php else:?>
					<span class="badge badge-pill badge-dark">시스템</span>
					<?php endif?>
				</td>
				<td>
					<a href="#" data-toggle="modal" data-target="#modal_window" class="rb-modal-mbrinfo badge badge-pill badge-dark" onmousedown="mbrIdDrop('<?php echo $R['mbruid']?>','notice');">
						<?php echo $SM1[$_HS['nametype']]?>
					</a>
				</td>
				<td class="text-left">
					<a tabindex="0" class="muted-link" role="button" data-toggle="popover" data-trigger="focus" data-html="true" data-content="<?php echo $R['message'] ?>"><?php echo getStrCut($R['message'],'80','..')?></a>
				</td>
				<td>
					<?php if($R['referer']):?>
					<a class="badge badge-pill badge-dark" href="<?php echo $R['referer']?>" target="<?php echo $R['target']?>">보기</a>
					<?php else:?>
					<span class="small text-muted">없음</span>
					<?php endif?>
				</td>
				<td class="rb-update">
					<time class="timeago small text-muted" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?>"></time>
				</td>
				<td class="rb-update">
					<?php if($R['d_read']):?>
					<time class="timeago small text-muted" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_read'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_read'],'Y.m.d H:i')?>"></time>
					<?php else:?>
					<span class="badge badge-pill badge-dark">미확인</span>
					<?php endif?>
				</td>
			</tr>
			<?php $_i++;endwhile?>
		</table>
	</div>

	<?php if(!$NUM):?>
	<div class="rb-none">알림이 없습니다.</div>
	<?php endif?>

	<div class="d-flex justify-content-between px-3 my-4">
		<div>
			<button type="button" onclick="chkFlag('noti_members[]');checkboxCheck();" class="btn btn-light">선택/해제</button>
			<button type="button" onclick="actCheck('multi_delete');" class="btn btn-light" id="rb-action-btn" disabled>삭제</button>
		</div>
		<ul class="pagination">
			<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
		</ul>
	</div>
</form>


<?php include $g['path_module'].'member/admin/_modal.php';?>

<!-- timeago -->
<?php getImport('jquery-timeago','jquery.timeago',false,'js')?>
<?php getImport('jquery-timeago','locales/jquery.timeago.'.$lang['notification']['a2039'],false,'js')?>
<script>

putCookieAlert('result_noti_main') // 실행결과 알림 메시지 출력

jQuery(document).ready(function() {
	$(".rb-update time").timeago();
});

// 회원 이름,닉네임 클릭시 uid & mod( 탭 정보 : info, main, post 등) 지정하는 함수
var _mbrModalUid;
var _mbrModalMod;
function mbrIdDrop(uid,mod)
{
	_mbrModalUid = uid;
	_mbrModalMod = mod;
}

// 회원정보 modal 호출하는 함수 : 위에서 지정한 회원 uid & mod 로 호출한다 .
$('.rb-modal-mbrinfo').on('click',function() {
  modalSetting('modal_window','<?php echo getModalLink('&amp;m=admin&amp;module=member&amp;front=modal.mbrinfo&amp;uid=')?>'+_mbrModalUid+'&amp;tab='+_mbrModalMod);
});

$('[data-toggle="popover"]').popover()

//사이트 셀렉터 출력
$('[data-role="siteSelector"]').removeClass('d-none')

$(".checkAll-noti-user").click(function(){
	$(".rb-noti-user").prop("checked",$(".checkAll-noti-user").prop("checked"));
	checkboxCheck();
});
function checkboxCheck()
{
	var f = document.listForm;
    var l = document.getElementsByName('noti_members[]');
    var n = l.length;
    var i;
	var j=0;

	for	(i = 0; i < n; i++)
	{
		if (l[i].checked == true) j++;
	}
	if (j) getId('rb-action-btn').disabled = false;
	else getId('rb-action-btn').disabled = true;
}
function actCheck(act)
{
	var f = document.listForm;
    var l = document.getElementsByName('noti_members[]');
    var n = l.length;
	var j = 0;
    var i;
	var s = '';

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
			s += '['+l[i].value+']';
		}
	}
	if (!j)
	{
		alert('선택된 알림이 없습니다.      ');
		return false;
	}

	if (act == 'multi_delete')
	{
		if(confirm('정말로 삭제하시겠습니까?    '))
		{
			getIframeForAction(f);
			f.a.value = act;
			f.submit();
		}
	}
	return false;
}
</script>
