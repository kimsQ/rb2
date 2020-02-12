<?php

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 5;

$sqlque = 'to_mbruid='.$_M['uid'];
if ($account) $sqlque .= ' and site='.$account;
if ($moduleid) $sqlque .= " and module='".$moduleid."'";

if ($d_start) $sqlque .= ' and d_regis > '.str_replace('/','',$d_start).'000000';
if ($d_finish) $sqlque .= ' and d_regis < '.str_replace('/','',$d_finish).'240000';
if ($where && $keyw)
{
    $sqlque .= getSearchSql($where,$keyw,$ikeyword,'or');
}
$RCD = getDbArray($table['s_sms'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_sms'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);
?>

<div class="manager-list pt-3 px-3">

	<form name="searchForm" action="<?php echo $g['s']?>/" method="get">
  	<input type="hidden" name="r" value="<?php echo $r?>">
  	<input type="hidden" name="m" value="<?php echo $m?>">
  	<input type="hidden" name="module" value="<?php echo $module?>">
  	<input type="hidden" name="front" value="<?php echo $front?>">
  	<input type="hidden" name="tab" value="<?php echo $tab?>">
  	<input type="hidden" name="uid" value="<?php echo $_M['uid']?>">
  	<input type="hidden" name="p" value="<?php echo $p?>">
  	<input type="hidden" name="iframe" value="<?php echo $iframe?>">

    <div class="d-flex justify-content-between align-items-center">
      <div>
        <small><?php echo sprintf('총 %d건',$NUM)?></small>
        <span class="badge badge-pill badge-dark"><?php echo $p?>/<?php echo $TPG?> 페이지</span>
        <button type="button" class="btn btn-link btn-sm muted-link" data-toggle="collapse" data-target="#search-more-bbs" onclick="sessionSetting('sh_bbslist','1','','1');">
          고급검색
        </button>
      </div>
      <div class="form-inline">
        <select name="bid" class="form-control form-control-sm custom-select" onchange="this.form.submit();">
          <option value="">모듈</option>
          <?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,$p)?>
          <?php while($MD = db_fetch_array($MODULES)):?>
          <option value="<?php echo $MD['id']?>"<?php if($MD['id']==$moduleid):?> selected<?php endif?>><?php echo $MD['name']?> (<?php echo $MD['id']?>)</option>
          <?php endwhile?>
        </select>
      </div><!-- /.form-inline -->
    </div><!-- /.d-flex -->

    <div id="search-more-bbs" class="mt-3 collapse<?php if($_SESSION['sh_bbslist']):?> show<?php endif?>">
      <div class="d-flex justify-content-between align-items-center">
        <div class="form-inline input-daterange" id="datepicker">
          <input type="text" class="form-control form-control-sm" name="d_start" placeholder="시작일" value="<?php echo $d_start?>">
          <span class="px-1">~</span>
          <input type="text" class="form-control form-control-sm" name="d_finish" placeholder="종료일" value="<?php echo $d_finish?>">
          <button class="btn btn-light btn-sm ml-1" type="submit"><i class="fa fa-search"></i></button>
        </div><!-- /.form-inline -->
        <div class="form-inline">
          <select name="where" class="form-control form-control-sm custom-select">
            <option value="content"<?php if($where=='content'):?> selected="selected"<?php endif?>>메시지</option>
          </select>
          <input type="text" name="keyw" class="form-control form-control-sm ml-1" placeholder="검색어를 입력해주세요." value="<?php echo $keyw?>">
          <button class="btn btn-light ml-1" type="submit"><i class="fa fa-search"></i>검색</button>
          <button class="btn btn-light ml-1" type="button" onclick="this.form.keyw.value='';this.form.submit();">리셋</button>
        </div><!-- /.form-inline -->
      </div><!-- /.d-flex -->
    </div><!-- /.collapse -->

 </form>
</div>

<form name="adm_list_form" class="mt-3" action="<?php echo $g['s']?>/" method="post">
  <input type="hidden" name="r" value="<?php echo $r?>">
   <input type="hidden" name="module" value="<?php echo $module?>">
  <input type="hidden" name="front" value="<?php echo $front?>">
  <input type="hidden" name="tab" value="<?php echo $tab?>">
  <input type="hidden" name="p" value="<?php echo $p?>">
  <input type="hidden" name="iframe" value="<?php echo $iframe?>">
  <input type="hidden" name="m" value=""> <!-- 액션파일이 있는 모듈명  -->
  <input type="hidden" name="a" value=""> <!-- 액션명  -->
   <div class="table-responsive">
    <table class="table table-hover f13 text-center">
      <colgroup>
				<col width="50">
				<col width="50">
				<col width="50">
				<col>
				<col width="150">
			</colgroup>
      <thead class="small text-muted">
        <tr>
          <th><input type="checkbox"  class="checkAll-act-list" data-toggle="tooltip" title="전체선택"></th>
          <th>번호</th>
          <th>보낸사람</th>
          <th>내용</th>
          <th>알림일시</th>
        </tr>
      </thead>
      <tbody>
        <?php while($R=db_fetch_array($RCD)):?>
         <?php $SM1=$R['to_mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['to_mbruid'],'name,nic'):array()?>
         <?php $SM2=$R['from_mbruid']?getDbData($table['s_mbrdata'],'memberuid='.$R['from_mbruid'],'name,nic'):array()?>
        <tr>
          <td><input type="checkbox" name="sms_members[]"  onclick="checkboxCheck();" class="mbr-act-list" value="<?php echo $R['uid']?>"></td>
          <td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
          <td><span class="badge badge-pill badge-dark"><?php echo $SM2['name']?$SM2['name']:'시스템'?></span></td>
          <td class="text-left">
              <?php echo getStrCut($R['content'],'80','..')?>
          </td>
          <td class="rb-update">
            <time class="timeago small text-muted" data-toggle="tooltip" datetime="<?php echo getDateFormat($R['d_regis'],'c')?>" data-tooltip="tooltip" title="<?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?>"></time>
          </td>
        </tr>
        <?php endwhile?>
      </tbody>
    </table>
      <?php if(!$NUM):?>
      <div class="text-muted text-center py-4">
        <i class="fa fa-exclamation-circle fa-2x mb-1 d-block" aria-hidden="true"></i>
        <small>데이타가 없습니다.</small>
      </div>
       <?php endif?>
 </div>

 <ul class="pagination pagination-sm justify-content-center py-3">
   <script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
 </ul>

</form>
