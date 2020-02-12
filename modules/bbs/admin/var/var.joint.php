<?php
$recnum = 10;
$catque = 'uid and site='.$s;
if ($_keyw) $catque .= " and ".$where." like '".$_keyw."%'";
$PAGES = getDbArray($table[$smodule.'list'],$catque,'*','gid','asc',$recnum,$p);
$NUM = getDbRows($table[$smodule.'list'],$catque);
$TPG = getTotalPage($NUM,$recnum);
$tdir = $g['path_module'].$smodule.'/theme/';
?>

<div id="mjointbox">
	<div class="title">
		<form name="bbsSform" class="form-inline" action="<?php echo $g['s']?>/" method="get">
			<input type="hidden" name="system" value="<?php echo $system?>">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="iframe" value="<?php echo $iframe?>">
			<input type="hidden" name="dropfield" value="<?php echo $dropfield?>">
			<input type="hidden" name="smodule" value="<?php echo $smodule?>">
			<input type="hidden" name="cmodule" value="<?php echo $cmodule?>">
			<input type="hidden" name="p" value="<?php echo $p?>">
	 		<input type="hidden" name="newboard" value="<?php echo $newboard?>">

			<select name="where" class="form-control custom-select" >
				<option value="name"<?php if($where == 'name'):?> selected="selected"<?php endif?>>게시판제목</option>
				<option value="id"<?php if($where == 'id'):?> selected="selected"<?php endif?>>게시판ID</option>
			</select>

      <div class="input-group ml-2">
        <input type="text" name="_keyw" size="15" value="<?php echo addslashes($_keyw)?>" class="form-control" />
				<div class="input-group-append">
					<input type="submit" value=" 검색 " class="btn btn-light">
					<input type="button" value=" 리셋 " class="btn btn-light" onclick="thisReset();">
				</div>
       	<!--<input type="button" value=" 새 게시판 " class="btn<?php echo $newboard?'gray':'blue'?>" onclick="this.form.newboard.value=1;this.form.submit();" />-->
       </div> <!--.input-group-->

		</form>
	</div>

	<?php if($newboard):?>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $smodule?>" />
		<input type="hidden" name="a" value="makebbs" />
		<input type="hidden" name="backUrl" value="<?php echo $g['s']?>/?r=<?php echo $r?>&system=<?php echo $system?>&iframe=<?php echo $iframe?>&dropfield=<?php echo $dropfield?>&smodule=<?php echo $smodule?>&cmodule=<?php echo $cmodule?>" />
		<input type="hidden" name="hitcount" value="0">
		<input type="hidden" name="recnum" value="20">
		<input type="hidden" name="sbjcut" value="40">
		<input type="hidden" name="newtime" value="24">
		<input type="hidden" name="point1" value="0">
		<input type="hidden" name="point2" value="0">
		<input type="hidden" name="perm_l_list" value="0">
		<input type="hidden" name="perm_l_view" value="0">
		<input type="hidden" name="snsconnect" value="0">

		<table>
			<tr>
				<td class="td1">
					게시판이름
				</td>
				<td class="td2">
					<input type="text" name="name" value="" class="input sname" />
					아이디 <input type="text" name="id" value="" class="input sname2" />
					<div id="guide_bbsidname" class="guide hide">
					<span class="b">게시판이름</span> : 한글,영문등 자유롭게 등록할 수 있습니다.<br />
					<span class="b">아이디</span> : 영문 대소문자+숫자+_ 조합으로 만듭니다.<br />
					</div>

				</td>
			</tr>
			<tr>
				<td class="td1">
					카 테 고 리
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_category','block','none');" />
				</td>
				<td class="td2">
					<input type="text" name="category" value="" class="input sname1" />
					<div id="guide_category" class="guide hide">
					<span class="b">콤마(,)</span>로 구분해 주세요. <span class="b">첫분류는 분류제목</span>이 됩니다.<br />
					보기)<span class="b">구분</span>,유머,공포,엽기,무협,기타
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">레 이 아 웃</td>
				<td class="td2">
					<select name="layout" class="form-control custom-select">
					<option value="">&nbsp;+ 사이트 대표레이아웃</option>
					<?php $dirs = opendir($g['path_layout'])?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
					<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
					<option value="" disabled>--------------------------------</option>
					<?php while(false !== ($tpl1 = readdir($dirs1))):?>
					<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
					<option value="<?php echo $tpl?>/<?php echo $tpl1?>">ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
					<?php endwhile?>
					<?php closedir($dirs1)?>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1">게시판테마</td>
				<td class="td2">
					<select name="skin" class="form-control custom-select">
					<option value="">&nbsp;+ 게시판 대표테마</option>
					<option value="" disabled>--------------------------------</option>
					<?php $tdir = $g['path_module'].$smodule.'/themes/_desktop/'?>
					<?php $dirs = opendir($tdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					<option value="_desktop/<?php echo $skin?>" title="<?php echo $skin?>">ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td1 sfont1">(모바일접속)</td>
				<td class="td2">
					<select name="m_skin" class="form-control custom-select">
					<option value="">&nbsp;+ 모바일 대표테마</option>
					<option value="" disabled>--------------------------------</option>
					<?php $tdir = $g['path_module'].$smodule.'/themes/_mobile/'?>
					<?php $dirs = opendir($tdir)?>
					<?php while(false !== ($skin = readdir($dirs))):?>
					<?php if($skin=='.' || $skin == '..' || is_file($tdir.$skin))continue?>
					<option value="_mobile/<?php echo $skin?>" title="<?php echo $skin?>">ㆍ<?php echo getFolderName($tdir.$skin)?>(<?php echo $skin?>)</option>
					<?php endwhile?>
					<?php closedir($dirs)?>
					</select>
				</td>
			</tr>

			<tr>
				<td class="td1">
					연 결 메 뉴
					<img src="<?php echo $g['img_core']?>/_public/ico_q.gif" alt="도움말" title="도움말" class="hand" onclick="layerShowHide('guide_sosokmenu','block','none');" />
				</td>
				<td class="td2">
					<select name="sosokmenu" class="form-control custom-select">
					<option value="">&nbsp;+ 사용안함</option>
					<option value="" disabled>--------------------------------</option>
					<?php include_once $g['path_core'].'function/menu1.func.php'?>
					<?php $cat=$d['bbs']['sosokmenu']?>
					<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
					</select>
					<div id="guide_sosokmenu" class="guide hide">
					이 게시판을 연결할 메뉴를 지정해 주세요.<br />
					연결메뉴를 지정하면 게시물수,로케이션이 동기화됩니다.<br />
					</div>
				</td>
			</tr>
			<tr>
				<td class="td1">글쓰기권한</td>
				<td class="td2">
					<select name="perm_l_write" class="form-control custom-select">
					<option value="0">&nbsp;+ 전체허용</option>
					<option value="0" disabled>--------------------------------</option>
					<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
					<?php while($_L=db_fetch_array($_LEVEL)):?>
					<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==1):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>) 이상</option>
					<?php if($_L['gid'])break; endwhile?>
					</select>
				</td>
			</tr>
		</table>

		<div class="mt-3">
			<input type="submit" class="btn btn-primary" value="새게시판 만들기">
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=<?php echo $smodule?>&amp;front=main&amp;type=makebbs" target="_blank">더 자세히</a>
			<a href="#." class="btn btn-light" onclick="thisReset();">취소</a>
		</div>

	</form>



	<?php else:?>
	<?php if($NUM):?>
	<table class="table table-sm table-hover">
		 <colgroup>
		    <col width="30%">
		    <col>
		    <col width="32%">
		 </colgroup>
		<tr>
				<td class="name">
					<a href="<?php echo $g['r']?>/?m=<?php echo $smodule?>" target="_blank" class="muted-link">
						전체게시물
					</a>
					</td>
				<td>
				    <?php include $g['path_module'].$smodule.'/var/var.php';?>
				   <select class="form-control custom-select form-control-sm">
				     <option><?php echo getFolderName($tdir.$d['bbs']['skin_total'])?></option>
				    </select>
				</td>
				<td class="text-right pr-2">
					<button class="btn btn-light btn-sm" onclick="dropJoint('<?php echo $g['s']?>/?m=<?php echo $smodule?>');" /><i class="fa fa-link"></i> 연결하기</button>
				</td>
		</tr>
		<?php while($R = db_fetch_array($PAGES)):?>
		<?php include $g['path_var'].$smodule.'/var.'.$R['id'].'.php'?>
		<tr<?php if($R['id']==$id):?> class="madetr"<?php endif?>>
		<td class="align-middle">
			<?php if($R['category']):?>
			<select id="cat<?php echo $R['id']?>" class="form-control custom-select form-control-sm" title="<?php echo $R['id']?>">
				<option value="">&nbsp;+ <?php echo $R['name']?></option>
				<?php $_catexp = explode(',',$R['category']);$_catnum=count($_catexp)?>
				<option value="" disabled>--------------------------------</option>
				<?php for($i = 1; $i < $_catnum; $i++):if(!$_catexp[$i])continue;?>
				<option value="<?php echo $_catexp[$i]?>">ㆍ<?php echo $_catexp[$i]?></option>
				<?php endfor?>
			</select>
			<?php else:?>
			<input type="hidden" id="cat<?php echo $R['id']?>" value="" class="form-control">
			<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $smodule?>&amp;bid=<?php echo $R['id']?>" target="_blank" title="게시판보기" class="muted-link">
				<?php echo $R['name']?>
			</a>
			<span class="badge badge-light badge-pill"><?php echo $R['id']?></span>
			<?php endif?>
		</td>
		<td class="align-middle">
			<select class="form-control form-control-sm custom-select">
		    <option><?php echo $d['bbs']['skin'] ? getFolderName($tdir.$d['bbs']['skin']) : '게시판 대표테마'?></option>
			</select>
		</td>
		<td class="align-middle text-right pr-2">
			<button class="btn btn-light btn-sm" onclick="dropJoint('<?php echo $g['s']?>/?m=<?php echo $smodule?>&bid=<?php echo $R['id']?>'+(getId('cat<?php echo $R['id']?>').value?'&cat='+getId('cat<?php echo $R['id']?>').value:''));" /><i class="fa fa-link"></i> 연결하기</button>
		</td>
		</tr>
		<?php endwhile?>
	</table>

	<div class="mt-3">
		<ul class="pagination pagination-sm justify-content-center">
			<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
		</ul>
	</div>
	<?php else:?>
	<div class="alert alert-warning">
	<?php if($_keyw):?>
		<i class="fa fa-exclamation-triangle"></i> 검색결과에 해당되는 게시판이 없습니다.
	<?php else:?>
		 <i class="fa fa-exclamation-triangle"></i> 아직 게시판이 만들어지지 않았습니다. 게시판을 만들어주세요.
	<?php endif?>
	</div>
	<?php endif?>
	<?php endif?>

</div>


<style type="text/css">

#mjointbox {}

#mjointbox .title {padding:0 0 20px 0;}
#mjointbox table .name a {font-weight:bold;}
#mjointbox table .name a,
#mjointbox table .name span {position:relative;top:8px;}

#mjointbox table .name span {font-size:11px;color:#c0c0c0;padding-left:3px;}

#mjointbox .rb-page-box {text-align:center;border-top:#dfdfdf solid 1px;margin:20px 0 20px 0;}
.table td.text-right {padding-right: 0}

</style>

<script type="text/javascript">
//<![CDATA[
function thisReset()
{
	var f = document.bbsSform;
	f.newboard.value = '';
	f.p.value = 1;
	f._keyw.value = '';
	f.submit();
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('게시판이름을 입력해 주세요.     ');
		f.name.focus();
		return false;
	}
	if (f.bid.value == '')
	{
		if (f.id.value == '')
		{
			alert('게시판아이디를 입력해 주세요.      ');
			f.id.focus();
			return false;
		}
		if (!chkFnameValue(f.id.value))
		{
			alert('게시판아이디는 영문 대소문자/숫자/_ 만 사용가능합니다.      ');
			f.id.value = '';
			f.id.focus();
			return false;
		}
	}
	return confirm('정말로 새 게시판을 만드시겠습니까?         ');
}
//]]>
</script>
