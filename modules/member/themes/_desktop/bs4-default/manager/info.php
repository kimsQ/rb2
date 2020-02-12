<?php include_once $g['dir_module_skin'].'_menu.php'?>

<div id="pages_join">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="info_update" />
	<input type="hidden" name="check_nic" value="<?php echo $M['nic']?1:0?>" />
	<input type="hidden" name="check_email" value="<?php echo $M['email']?1:0?>" />
	<input type="hidden" name="memberuid" value="<?php echo $M['memberuid']?>" />


	<div class="msg">
		<span class="b">(*)</span> 표시가 있는 항목은 반드시 입력해야 합니다.<br />
		관리자권한을 이용해서 이름,닉네임,이메일등을 중복확인없이 변경할 수 있습니다.<br />
	</div>


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
	<td class="key">이름(실명)<span>*</span></td>
	<td>
		<input type="text" name="name" value="<?php echo $M['name']?>" maxlength="10" class="input" />
	</td>
	</tr>
	<?php if($d['member']['form_nic']):?>
	<tr>
	<td class="key">닉네임<?php if($d['member']['form_nic_p']):?><span>*</span><?php endif?></td>
	<td>
		<input type="text" name="nic" value="<?php echo $M['nic']?>" maxlength="20" class="input" onblur="sameCheck(this,'hLayernic');" />
		<span class="hmsg" id="hLayernic"></span>
		<div>닉네임은 자신을 표현할 수 있는 단어로 20자까지 자유롭게 사용할 수 있습니다.</div>
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_birth']):?>
	<tr>
	<td class="key">생년월일<?php if($d['member']['form_birth_p']):?><span>*</span><?php endif?></td>
	<td>
		<select name="birth_1">
		<option value="">년도</option>
		<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
		<option value="<?php echo $i?>"<?php if($M['birth1']==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
		<?php endfor?>
		</select>
		<select name="birth_2">
		<option value="">월</option>
		<?php $birth_2=substr($M['birth2'],0,2)?>
		<?php for($i = 1; $i < 13; $i++):?>
		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_2==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
		<?php endfor?>
		</select>
		<select name="birth_3">
		<option value="">일</option>
		<?php $birth_3=substr($M['birth2'],2,2)?>
		<?php for($i = 1; $i < 32; $i++):?>
		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($birth_3==$i):?> selected="selected"<?php endif?>><?php echo $i?></option>
		<?php endfor?>
		</select>
		<input type="checkbox" name="birthtype" value="1"<?php if($M['birthtype']):?> checked="checked"<?php endif?> />음력<br />
	</td>
	</tr>
	<?php endif?>
	<?php if($d['member']['form_sex']):?>
	<tr>
	<td class="key">성별<?php if($d['member']['form_sex_p']):?><span>*</span><?php endif?></td>
	<td class="shift">
		<input type="radio" name="sex" value="1"<?php if($M['sex']==1):?> checked="checked"<?php endif?> />남성
		<input type="radio" name="sex" value="2"<?php if($M['sex']==2):?> checked="checked"<?php endif?> />여성
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_qa']):?>
	<tr>
	<td class="key">비번찾기 질문<?php if($d['member']['form_qa_p']):?><span>*</span><?php endif?></td>
	<td>
		<input type="text" name="pw_q" value="<?php echo $M['pw_q']?>" class="input pw_q2" />
	</td>
	</tr>

	<tr>
	<td class="key">비번찾기 답변<?php if($d['member']['form_qa_p']):?><span>*</span><?php endif?></td>
	<td>
		<input type="text" name="pw_a" value="<?php echo $M['pw_a']?>" class="input" />
		<div>
		비밀번호찾기 질문에 대한 답변을 혼자만 알 수 있는 단어나 기호로 입력해 주세요.<br />
		비밀번호를 찾을 때 필요하므로 반드시 기억해 주세요.
		</div>
	</td>
	</tr>
	<?php endif?>

	<tr>
	<td class="key">이메일<span>*</span></td>
	<td>
		<input type="text" name="email" value="<?php echo $M['email']?>" size="35" class="input" onblur="sameCheck(this,'hLayeremail');" />
		<span class="hmsg" id="hLayeremail"></span>
		<div>주로 사용하는 이메일 주소를 입력해 주세요. 비밀번호 잊어버렸을 때 확인 받을 수 있습니다.</div>
		<div class="remail"><input type="checkbox" name="remail" value="1"<?php if($M['mailing']):?> checked="checked"<?php endif?> />뉴스레터나 공지이메일을 수신받겠습니다.</div>
	</td>
	</tr>

	<?php if($d['member']['form_home']):?>
	<tr>
	<td class="key">홈페이지<?php if($d['member']['form_home_p']):?><span>*</span><?php endif?></td>
	<td>
		<input type="text" name="home" value="<?php echo $M['home']?>" size="35" class="input" />
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_tel2']):?>
	<tr>
	<td class="key">휴대전화<?php if($d['member']['form_tel2_p']):?><span>*</span><?php endif?></td>
	<td><?php $tel2=explode('-',$M['tel2'])?>
		<input type="text" name="tel2_1" value="<?php echo $tel2[0]?>" maxlength="3" size="4" class="input" />-
		<input type="text" name="tel2_2" value="<?php echo $tel2[1]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="tel2_3" value="<?php echo $tel2[2]?>" maxlength="4" size="4" class="input" />
		<div class="remail"><input type="checkbox" name="sms" value="1"<?php if($M['sms']):?> checked="checked"<?php endif?> />알림문자를 받겠습니다.</div>
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_tel1']):?>
	<tr>
	<td class="key">전화번호<?php if($d['member']['form_tel1_p']):?><span>*</span><?php endif?></td>
	<td><?php $tel1=explode('-',$M['tel1'])?>
		<input type="text" name="tel1_1" value="<?php echo $tel1[0]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="tel1_2" value="<?php echo $tel1[1]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="tel1_3" value="<?php echo $tel1[2]?>" maxlength="4" size="4" class="input" />
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_addr']):?>
	<tr>
	<td class="key">주소<?php if($d['member']['form_addr_p']):?><span>*</span><?php endif?></td>
	<td>
		<div id="addrbox"<?php if($M['addr0']=='해외'):?> class="hide"<?php endif?>>
		<div>
		<input type="text" name="zip_1" id="zip1" value="<?php echo substr($M['zip'],0,3)?>" maxlength="3" size="3" readonly="readonly" class="input" />-
		<input type="text" name="zip_2" id="zip2" value="<?php echo substr($M['zip'],3,3)?>" maxlength="3" size="3" readonly="readonly" class="input" /> 
		<input type="button" value="우편번호" class="btngray btn" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&m=zipsearch&zip1=zip1&zip2=zip2&addr1=addr1&focusfield=addr2');" />
		</div>
		<div><input type="text" name="addr1" id="addr1" value="<?php echo $M['addr1']?>" size="55" readonly="readonly" class="input" /></div>
		<div><input type="text" name="addr2" id="addr2" value="<?php echo $M['addr2']?>" size="55" class="input" /></div>
		</div>
		<?php if($d['member']['form_foreign']):?>
		<div class="remail shift">
		<?php if($M['addr0']=='해외'):?>
		<input type="checkbox" name="foreign" value="1" checked="checked" onclick="foreignChk(this);" /><span id="foreign_ment">해외거주자 입니다.</span>
		<?php else:?>
		<input type="checkbox" name="foreign" value="1" onclick="foreignChk(this);" /><span id="foreign_ment">해외거주자일 경우 체크해 주세요.</span>
		<?php endif?>
		</div>
		<?php endif?>
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_job']):?>
	<tr>
	<td class="key">직업<?php if($d['member']['form_job_p']):?><span>*</span><?php endif?></td>
	<td>
		<select name="job">
		<option value="">&nbsp;+ 선택하세요</option>
		<option value="">------------------</option>
		<?php $_job=file($g['dir_module'].'var/job.txt')?>
		<?php foreach($_job as $_val):?>
		<option value="<?php echo trim($_val)?>"<?php if(trim($_val)==$M['job']):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_val)?></option>
		<?php endforeach?>
		</select>
	</td>
	</tr>
	<?php endif?>

	<?php if($d['member']['form_marr']):?>
	<tr>
	<td class="key">결혼기념일<?php if($d['member']['form_marr_p']):?><span>*</span><?php endif?></td>
	<td>
		<select name="marr_1">
		<option value="">년도</option>
		<?php for($i = substr($date['today'],0,4); $i > 1930; $i--):?>
		<option value="<?php echo $i?>"<?php if($i==$M['marr1']):?> selected="selected"<?php endif?>><?php echo $i?></option>
		<?php endfor?>
		</select>
		<select name="marr_2">
		<option value="">월</option>
		<?php for($i = 1; $i < 13; $i++):?>
		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($M['marr2'],0,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
		<?php endfor?>
		</select>
		<select name="marr_3">
		<option value="">일</option>
		<?php for($i = 1; $i < 32; $i++):?>
		<option value="<?php echo sprintf('%02d',$i)?>"<?php if($i==substr($M['marr2'],2,2)):?> selected="selected"<?php endif?>><?php echo $i?></option>
		<?php endfor?>
		</select>
	</td>
	</tr>
	<?php endif?>

	<?php $_add = file($g['dir_module'].'var/add_field.txt')?>
	<?php foreach($_add as $_key):?>
	<?php $_val = explode('|',trim($_key))?>
	<?php if($_val[6]) continue?>
	<?php $_myadd1 = explode($_val[0].'^^^',$M['addfield'])?>
	<?php $_myadd2 = explode('|||',$_myadd1[1])?>

	<tr>
	<td class="key"><?php echo $_val[1]?><?php if($_val[5]):?><span>*</span><?php endif?></td>
	<td>
	<?php if($_val[2]=='text'):?>
	<input type="text" name="add_<?php echo $_val[0]?>" class="input" style="width:<?php echo $_val[4]?>px;" value="<?php echo $_myadd2[0]?>" />
	<?php endif?>
	<?php if($_val[2]=='password'):?>
	<input type="password" name="add_<?php echo $_val[0]?>" class="input" style="width:<?php echo $_val[4]?>px;" value="<?php echo $_myadd2[0]?>" />
	<?php endif?>
	<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
	<select name="add_<?php echo $_val[0]?>" style="width:<?php echo $_val[4]?>px;">
	<option value="">&nbsp;+ 선택하세요</option>
	<?php foreach($_skey as $_sval):?>
	<option value="<?php echo trim($_sval)?>"<?php if(trim($_sval)==$_myadd2[0]):?> selected="selected"<?php endif?>>ㆍ<?php echo trim($_sval)?></option>
	<?php endforeach?>
	</select>
	<?php endif?>
	<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
	<div class="shift">
	<?php foreach($_skey as $_sval):?>
	<input type="radio" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>"<?php if(trim($_sval)==$_myadd2[0]):?> checked="checked"<?php endif?> /><?php echo trim($_sval)?>
	<?php endforeach?>
	</div>
	<?php endif?>
	<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
	<div class="shift">
	<?php foreach($_skey as $_sval):?>
	<input type="checkbox" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>"<?php if(strstr($_myadd2[0],'['.trim($_sval).']')):?> checked="checked"<?php endif?> /><?php echo trim($_sval)?>
	<?php endforeach?>
	</div>
	<?php endif?>
	<?php if($_val[2]=='textarea'):?>
	<textarea name="add_<?php echo $_val[0]?>" rows="5" style="width:<?php echo $_val[4]?>px;"><?php echo $_myadd2[0]?></textarea>
	<?php endif?>

	</tr>
	<?php endforeach?>

	</tbody>
	</table>


	<?php if($d['member']['form_comp']):?>
	<?php if($M['comp']) $myc = getDbData($table['s_mbrcomp'],'memberuid='.$M['memberuid'],'*')?>
	<?php $tel = explode('-',$myc['comp_tel'])?>
	<?php $fax = explode('-',$myc['comp_fax'])?>
	<div class="tt_comp">
	기업정보
	<?php if(!$M['comp']):?>
	<span class="tt_check">(<input type="checkbox" name="comp" value="1" />기업정보를 등록합니다)</span>
	<?php else:?>
	<input type="checkbox" name="comp" value="1" checked="checked" class="hide" />
	<?php endif?>	
	</div>


	<table summary="회원가입 기업정보를 입력받는 표입니다.">
	<caption>회원가입 기업정보</caption> 
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
	<td class="key">사업자등록번호<span>*</span></td>
	<td colspan="3">
		<input type="text" name="comp_num_1" size="4" maxlength="3" class="input" value="<?php echo substr($myc['comp_num'],0,3)?>" /> -
		<input type="text" name="comp_num_2" size="3" maxlength="2" class="input" value="<?php echo substr($myc['comp_num'],3,2)?>" /> -
		<input type="text" name="comp_num_3" size="5" maxlength="5" class="input" value="<?php echo substr($myc['comp_num'],5,5)?>" />
		<input type="radio" name="comp_type" value="1"<?php if($myc['comp_type']==1||!$myc['comp_type']):?> checked="checked"<?php endif?> />개인
		<input type="radio" name="comp_type" value="2"<?php if($myc['comp_type']==2):?> checked="checked"<?php endif?> />법인
	</td>
	</tr>
	<tr>
	<td class="key">회사명<span>*</span></td>
	<td>
		<input type="text" name="comp_name" class="input" value="<?php echo $myc['comp_name']?>" />
	</td>
	<td class="key">대표자명<span>*</span></td>
	<td>
		<input type="text" name="comp_ceo" class="input" value="<?php echo $myc['comp_ceo']?>" />
	</td>
	</tr>
	<tr>
	<td class="key">업태<span>*</span></td>
	<td>
		<input type="text" name="comp_upte" class="input" value="<?php echo $myc['comp_upte']?>" />
	</td>
	<td class="key">종목<span>*</span></td>
	<td>
		<input type="text" name="comp_jongmok" class="input" value="<?php echo $myc['comp_jongmok']?>" />
	</td>
	</tr>
	<tr>
	<td class="key">대표전화<span>*</span></td>
	<td>
		<input type="text" name="comp_tel_1" value="<?php echo $tel[0]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="comp_tel_2" value="<?php echo $tel[1]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="comp_tel_3" value="<?php echo $tel[2]?>" maxlength="4" size="4" class="input" />
	</td>
	<td class="key">팩스</td>
	<td>
		<input type="text" name="comp_fax_1" value="<?php echo $fax[0]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="comp_fax_2" value="<?php echo $fax[1]?>" maxlength="4" size="4" class="input" />-
		<input type="text" name="comp_fax_3" value="<?php echo $fax[2]?>" maxlength="4" size="4" class="input" />
	</td>
	</tr>
	<tr>
	<td class="key">소속부서</td>
	<td>
		<input type="text" name="comp_part" class="input" value="<?php echo $myc['comp_part']?>" />
	</td>
	<td class="key">직책</td>
	<td>
		<input type="text" name="comp_level" class="input" value="<?php echo $myc['comp_level']?>" />
	</td>
	</tr>
	<tr>
	<td class="key">사업장주소<span>*</span></td>
	<td colspan="3">
		<div>
		<input type="text" name="comp_zip_1" id="comp_zip1" value="<?php echo substr($myc['comp_zip'],0,3)?>" maxlength="3" size="3" readonly="readonly" class="input" />-
		<input type="text" name="comp_zip_2" id="comp_zip2" value="<?php echo substr($myc['comp_zip'],3,3)?>" maxlength="3" size="3" readonly="readonly" class="input" /> 
		<input type="button" value="우편번호" class="btngray btn" onclick="OpenWindow('<?php echo $g['s']?>/?r=<?php echo $r?>&m=zipsearch&zip1=comp_zip1&zip2=comp_zip2&addr1=comp_addr1&focusfield=comp_addr2');" />
		</div>
		<div><input type="text" name="comp_addr1" id="comp_addr1" value="<?php echo $myc['comp_addr1']?>" size="55" readonly="readonly" class="input" /></div>
		<div><input type="text" name="comp_addr2" id="comp_addr2" value="<?php echo $myc['comp_addr2']?>" size="55" class="input" /></div>
		</div>
	</td>
	</tr>
	</tbody>
	</table>
	<?php endif?>


	<div class="submitbox">
		<input type="submit" value="정보수정" class="btnblue" />
	</div>

	</form>

</div>

<script type="text/javascript">
//<![CDATA[
function foreignChk(obj)
{
	if (obj.checked == true)
	{
		getId('addrbox').style.display = 'none';
		getId('foreign_ment').innerHTML= '해외거주자 입니다.';
	}
	else {
		getId('addrbox').style.display = 'block';
		getId('foreign_ment').innerHTML= '해외거주자일 경우 체크해 주세요.';
	}
}
function sameCheck(obj,layer)
{

	if (!obj.value)
	{
		eval('obj.form.check_'+obj.name).value = '0';
		getId(layer).innerHTML = '';
	}
	else
	{
		if (obj.name == 'email')
		{
			if (!chkEmailAddr(obj.value))
			{
				obj.form.check_email.value = '0';
				obj.focus();
				getId(layer).innerHTML = '이메일형식이 아닙니다.';
				return false;
			}
		}

		frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&a=same_check&fname=' + obj.name + '&fvalue=' + obj.value + '&flayer=' + layer;
	}
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('이름을 입력해 주세요.');
		f.name.focus();
		return false;
	}
	<?php if($d['member']['form_nic_p']):?>
	if (f.check_nic.value == '0')
	{
		alert('닉네임을 확인해 주세요.');
		f.nic.focus();
		return false;
	}
	<?php endif?>
	<?php if($d['member']['form_birth']&&$d['member']['form_birth_p']):?>
	if (f.birth_1.value == '')
	{
		alert('생년월일을 지정해 주세요.');
		f.birth_1.focus();
		return false;
	}
	if (f.birth_2.value == '')
	{
		alert('생년월일을 지정해 주세요.');
		f.birth_2.focus();
		return false;
	}
	if (f.birth_3.value == '')
	{
		alert('생년월일을 지정해 주세요.');
		f.birth_3.focus();
		return false;
	}
	<?php endif?>
	<?php if($d['member']['form_sex']&&$d['member']['form_sex_p']):?>
	if (f.sex[0].checked == false && f.sex[1].checked == false)
	{
		alert('성별을 선택해 주세요.  ');
		return false;
	}
	<?php endif?>
	<?php if($d['member']['form_qa']&&$d['member']['form_qa_p']):?>
	if (f.pw_q.value == '')
	{
		alert('비밀번호 찾기 질문을 입력해 주세요.');
		f.pw_q.focus();
		return false;
	}
	if (f.pw_a.value == '')
	{
		alert('비밀번호 찾기 답변을 입력해 주세요.');
		f.pw_a.focus();
		return false;
	}
	<?php endif?>

	if (f.check_email.value == '0')
	{
		alert('이메일을 확인해 주세요.');
		f.email.focus();
		return false;
	}
	<?php if($d['member']['form_home']&&$d['member']['form_home_p']):?>
	if (f.home.value == '')
	{
		alert('홈페이지 주소를 입력해 주세요.');
		f.home.focus();
		return false;
	}
	<?php endif?>
	<?php if($d['member']['form_tel2']&&$d['member']['form_tel2_p']):?>
	if (f.tel2_1.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.tel2_1.focus();
		return false;
	}
	if (f.tel2_2.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.tel2_2.focus();
		return false;
	}
	if (f.tel2_3.value == '')
	{
		alert('휴대폰번호를 입력해 주세요.');
		f.tel2_3.focus();
		return false;
	}
	<?php endif?>

	<?php if($d['member']['form_tel1']&&$d['member']['form_tel1_p']):?>
	if (f.tel1_1.value == '')
	{
		alert('전화번호를 입력해 주세요.');
		f.tel1_1.focus();
		return false;
	}
	if (f.tel1_2.value == '')
	{
		alert('전화번호를 입력해 주세요.');
		f.tel1_2.focus();
		return false;
	}
	if (f.tel1_3.value == '')
	{
		alert('전화번호를 입력해 주세요.');
		f.tel1_3.focus();
		return false;
	}
	<?php endif?>
		
	<?php if($d['member']['form_addr']&&$d['member']['form_addr_p']):?>
	if (!f.foreign || f.foreign.checked == false)
	{
		if (f.addr1.value == ''||f.addr2.value == '')
		{
			alert('주소를 입력해 주세요.');
			f.addr2.focus();
			return false;
		}
	}
	<?php endif?>


	<?php if($d['member']['form_job']&&$d['member']['form_job_p']):?>
	if (f.job.value == '')
	{
		alert('직업을 선택해 주세요.');
		f.job.focus();
		return false;
	}
	<?php endif?>

	<?php if($d['member']['form_marr']&&$d['member']['form_marr_p']):?>
	if (f.marr_1.value == '')
	{
		alert('결혼기념일을 지정해 주세요.');
		f.marr_1.focus();
		return false;
	}
	if (f.marr_2.value == '')
	{
		alert('결혼기념일을 지정해 주세요.');
		f.marr_2.focus();
		return false;
	}
	if (f.marr_3.value == '')
	{
		alert('결혼기념일을 지정해 주세요.');
		f.marr_3.focus();
		return false;
	}
	<?php endif?>

	var radioarray;
	var checkarray;
	var i;
	var j = 0;

	<?php foreach($_add as $_key):?>
	<?php $_val = explode('|',trim($_key))?>
	<?php if(!$_val[5]||$_val[6]) continue?>

	<?php if($_val[2]=='text' || $_val[2]=='password' || $_val[2]=='select' || $_val[2]=='textarea'):?>
	if (f.add_<?php echo $_val[0]?>.value == '')
	{
		alert('<?php echo $_val[1]?>이(가) <?php echo $_val[2]=='select'?'선택':'입력'?>되지 않았습니다.     ');
		f.add_<?php echo $_val[0]?>.focus();
		return false;
	}
	<?php endif?>
	<?php if($_val[2]=='radio'):?>
	j = 0;
	radioarray = f.add_<?php echo $_val[0]?>;
	for (i = 0; i < radioarray.length; i++)
	{
		if (radioarray[i].checked == true) j++;
	}
	if (!j)
	{
		alert('<?php echo $_val[1]?>이(가) 선택되지 않았습니다.     ');
		radioarray[0].focus();
		return false;
	}
	<?php endif?>
	<?php if($_val[2]=='checkbox'):?>
	j = 0;
	checkarray = document.getElementsByName("add_<?php echo $_val[0]?>[]");
	for (i = 0; i < checkarray.length; i++)
	{
		if (checkarray[i].checked == true) j++;
	}
	if (!j)
	{
		alert('<?php echo $_val[1]?>이(가) 선택되지 않았습니다.     ');
		checkarray[0].focus();
		return false;
	}
	<?php endif?>
	<?php endforeach?>


	<?php if($d['member']['form_comp']):?>
	if (f.comp.checked == true)
	{
		if (f.comp_num_1.value == '')
		{
			alert('사업자등록번호를 입력해 주세요.     ');
			f.comp_num_1.focus();
			return false;
		}
		if (f.comp_num_2.value == '')
		{
			alert('사업자등록번호를 입력해 주세요.     ');
			f.comp_num_2.focus();
			return false;
		}
		if (f.comp_num_3.value == '')
		{
			alert('사업자등록번호를 입력해 주세요.     ');
			f.comp_num_3.focus();
			return false;
		}

		if (f.comp_name.value == '')
		{
			alert('회사명을 입력해 주세요.     ');
			f.comp_name.focus();
			return false;
		}
		if (f.comp_ceo.value == '')
		{
			alert('대표자명을 입력해 주세요.     ');
			f.comp_ceo.focus();
			return false;
		}
		if (f.comp_upte.value == '')
		{
			alert('업태를 입력해 주세요.     ');
			f.comp_upte.focus();
			return false;
		}
		if (f.comp_jongmok.value == '')
		{
			alert('종목을 입력해 주세요.     ');
			f.comp_jongmok.focus();
			return false;
		}
		if (f.comp_tel_1.value == '')
		{
			alert('대표전화번호를 입력해 주세요.');
			f.comp_tel_1.focus();
			return false;
		}
		if (f.comp_tel_2.value == '')
		{
			alert('대표전화번호를 입력해 주세요.');
			f.comp_tel_2.focus();
			return false;
		}

		if (f.comp_addr1.value == '')
		{
			alert('사업장주소를 입력해 주세요.');
			f.comp_addr2.focus();
			return false;
		}
	}
	<?php endif?>



	return confirm('정말로 수정하시겠습니까?       ');
}


document.title = "<?php echo $M[$_HS['nametype']]?>님의 가입정보";
self.resizeTo(800,750);

//]]>
</script>




