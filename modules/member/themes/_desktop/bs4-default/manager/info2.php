<?php 
include_once $g['path_module'].$module.'/_main.php';
//소속넘버로 분과이름 추출
$s2b=array(
'12'=>'제도법제분과',
'13'=>'사회공헌분과',
'14'=>'기부문화분과',
'16'=>'변호사분과', //여기서부터는 기부컨설팅위원회
'17'=>'세무 · 회계사 분과',
'18'=>'법무사 분과',
'19'=>'부동산 분과',
'20'=>'금융 분과'
);
// 소속넘버로 위원회 이름 추출
$s2mb=array(
'11'=>'배분위원회',
'12'=>'기부문화연구소-제도법제분과',
'13'=>'기부문화연구소-사회공헌분과',
'14'=>'기부문화연구소-기부문화분과',
'15'=>'기부문화연구소-이사',
'16'=>'기부컨설팅위원회-변호사분과',
'17'=>'기부컨설팅위원회-세무 · 회계사 분과',
'18'=>'기부컨설팅위원회-법무사 분과',
'19'=>'기부컨설팅위원회-부동산 분과',
'20'=>'기부컨설팅위원회-금융분과',
'21'=>'기금운용위원회',
'22'=>'이사회'
);

$s2m=array(
'11'=>'배분위원회',
'12'=>'기부문화연구소',
'13'=>'기부문화연구소',
'14'=>'기부문화연구소',
'15'=>'기부문화연구소',
'16'=>'기부컨설팅위원회',
'17'=>'기부컨설팅위원회',
'18'=>'기부컨설팅위원회',
'19'=>'기부컨설팅위원회',
'20'=>'기부컨설팅위원회',
'21'=>'기금운용위원회',
'22'=>'이사회'
);
?>
<style>
.ajax_msg {position:absolute;left:220px;bottom:70px;line-height:180%;color:red;}
</style>
 <!-- 아작스 이미지 업로드용 JQ -->
  <script type="text/javascript" src="<?php echo $g['path_module']?>member/var/jquery.form.js"></script>  
<!-- 아작스 이미지 업로드용 JQ -->
<div id="pages_join">
   
    <div style="height:200px;vertical-align:bottom;position:relative;">
	  <?php ajax_imgupload2('admin','member',$mbruid)?> 
		  <p style="position:absolute;left:220px;top:80px;line-height:180%;">* JPG 만 가능. 사이즈는 177px X 140px.
	</div>
	

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="info_update2" />
	<input type="hidden" name="memberuid" value="<?php echo $M['memberuid']?>" />

	<table summary="회원가입 기본정보를 입력받는 표입니다.">
	<caption>회원가입 기본정보</caption> 
	<colgroup> 
	<col width="100"> 
	<col> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col"></th>
	<th scope="col"></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="key">성명<span>*</span></td>
		<td>
			<input type="text" name="name" value="<?php echo $M['name']?>" maxlength="50" class="input" />
		</td>
	</tr>
 
    <tr>
		<td class="key">소속</td>
		<td>
			<select name="sosok" onchange="this.form.submit();">
			<?php $GRP = db_query("select * from ".$table['s_mbrdata']." where sosok<30 and sosok>10 group by sosok",$DB_CONNECT)?>
			<?php while($_G=db_fetch_array($GRP)):?>
			<option value="<?php echo $_G['sosok']?>"<?php if($_G['sosok']==$M['sosok']):?> selected="selected"<?php endif?>><?php echo $s2mb[$_G['sosok']]?></option>
			<?php endwhile?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="key">직위</td>
		<td>
			<input type="text" name="nic" value="<?php echo $M['nic']?>" maxlength="80" class="input" />
		</td>
	</tr>
	<tr>
		<td class="key">겸직</td>
		<td>
			<input type="text" name="addfield" value="<?php echo $M['addfield']?>" maxlength="80" class="input long" />
		</td>
	</tr>

	</tbody>
	</table>


	<div class="submitbox">
		<input type="submit" value="정보수정" class="btnblue" />
	</div>

	</form>

</div>

<script type="text/javascript">
//<![CDATA[

function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('이름을 입력해 주세요.');
		f.name.focus();
		return false;
	}
	
	return confirm('정말로 수정하시겠습니까?       ');
}


document.title = "<?php echo $M[$_HS['nametype']]?>님의 가입정보";
self.resizeTo(600,600);

//]]>
</script>




