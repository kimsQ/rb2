/* 다운로드 */
function getDownload(btn,ver,lang)
{
	if (confirm('<?php echo _LANG('i060','install')?>    '))
	{
		var version = ver.value;
		document.title = '<?php echo _LANG('i061','install')?>';
		btn.disabled = true;
		btn.children[1].innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i>  <?php echo _LANG('i062','install')?>';
		frames.download_frame.location.href = './index.php?install=download&version=' + version + '&sitelang='+lang;
	}
}
function errDownload(folder)
{
	if (folder == '')
	{
		alert('<?php echo _LANG('i063','install')?>    ');
	}
	else if (folder == '1')
	{
		alert('<?php echo _LANG('i064','install')?>    ');
	}
	else {
		alert('<?php echo _LANG('i065','install')?>\nFolder : '+folder+'     ');
	}
	location.href = './index.php';
}
function getUploadPackage(obj)
{
	document.title = '<?php echo _LANG('i066','install')?>';
	var btn = document.getElementById('btn-group');
		btn.disabled = true;
		btn.children[1].innerHTML = '<i class="fa fa-spinner fa-lg fa-spin fa-fw"></i>  <?php echo _LANG('i067','install')?>';
	obj.form.submit();
}

/* 인스톨러 */
function agreecheck(obj)
{
	if (obj.checked == true) getId('_next_btn_').disabled = false;
	else getId('_next_btn_').disabled = true;
}
var nowStep = 1;
var isSubmit = false;
function stepCheck(type)
{
	var f = document.procForm;

	if (type == 'next')
	{

		if (nowStep == 2)
		{

			if (f.dbhost.value == '')
			{
				alert('<?php echo _LANG('i068','install')?>   ');
				f.dbhost.focus();
				return false;
			}
			if (f.dbname.value == '')
			{
				alert('<?php echo _LANG('i069','install')?>   ');
				f.dbname.focus();
				return false;
			}
			if (f.dbuser.value == '')
			{
				alert('<?php echo _LANG('i070','install')?>   ');
				f.dbuser.focus();
				return false;
			}
			if (f.dbpass.value == '')
			{
				alert('<?php echo _LANG('i071','install')?>   ');
				f.dbpass.focus();
				return false;
			}
			if (f.dbport.value == '')
			{
				alert('<?php echo _LANG('i072','install')?>   ');
				f.dbport.focus();
				return false;
			}
			if (!chkIdValue(f.dbhead.value))
			{
				alert('<?php echo _LANG('i073','install')?>   ');
				f.dbhead.focus();
				return false;
			}
		}

		if (nowStep == 3)
		{
			if (f.name.value == '')
			{
				alert('<?php echo _LANG('i074','install')?>   ');
				f.name.focus();
				return false;
			}
			if (!chkEmailAddr(f.email.value))
			{
				alert('<?php echo _LANG('i075','install')?>   ');
				f.email.focus();
				return false;
			}
			if (f.id.value.length < 4 || f.id.value.length > 12 || !chkIdValue(f.id.value))
			{
				alert('<?php echo _LANG('i076','install')?>   ');
				f.id.focus();
				return false;
			}
			if (f.pw0.value == '')
			{
				alert('<?php echo _LANG('i077','install')?>   ');
				f.pw0.focus();
				return false;
			}
			if (f.pw1.value == '')
			{
				alert('<?php echo _LANG('i078','install')?>');
				f.pw1.focus();
				return false;
			}
			if (f.pw0.value != f.pw1.value)
			{
				alert('<?php echo _LANG('i079','install')?>   ');
				f.pw0.value = '';
				f.pw1.value = '';
				f.pw0.focus();
				return false;
			}
		}

		if (nowStep == 4)
		{
			if (isSubmit == true)
			{
				alert('<?php echo _LANG('i080','install')?>  ');
				return false;
			}
			if (f.sitename.value == '')
			{
				alert('<?php echo _LANG('i081','install')?>   ');
				f.sitename.focus();
				return false;
			}
			if (f.siteid.value == '' ||  !chkIdValue(f.siteid.value))
			{
				alert('<?php echo _LANG('i082','install')?>   ');
				f.siteid.focus();
				return false;
			}

			if(confirm('<?php echo _LANG('i083','install')?>  '))
			{
				isSubmit = true;
				f.submit();
				return false;
			}
		}
	}

	if (type == 'next')
	{
		if(nowStep < 4) nowStep++;
	}
	else {
		if(nowStep > 1) nowStep--;
	}

	if (nowStep > 1) getId('_lang_').className = 'hidden';
	else getId('_lang_').className = 'pull-right';

	getId('step-1').className = '';
	getId('step-2').className = '';
	getId('step-3').className = '';
	getId('step-4').className = '';
	getId('step-'+nowStep).className = 'rb-active';

	getId('step-1-body').className = 'step-body hidden';
	getId('step-2-body').className = 'step-body hidden';
	getId('step-3-body').className = 'step-body hidden';
	getId('step-4-body').className = 'step-body hidden';
	getId('step-'+nowStep+'-body').className = 'step-body';


	if (nowStep == 1)
	{
		getId('_prev_btn_').disabled = true;
	}
	else {
		getId('_prev_btn_').disabled = false;
	}

	if (nowStep == 2)
	{
		f.dbname.focus();
	}
	if (nowStep == 3)
	{
		f.name.focus();
	}
	if (nowStep == 4)
	{
		f.sitename.focus();
	}
}
function tabSelect(obj,id)
{
	obj.parentNode.children[0].className = '';
	obj.parentNode.children[1].className = '';
	obj.className = 'rb-active1';
	getId('db-info').className = 'tab-panel hidden';
	getId('db-option').className = 'tab-panel hidden';
	getId(id).className = 'tab-panel';
	getId('db-info-well').className = 'well hidden';
	getId('db-option-well').className = 'well hidden';
	getId(id+'-well').className = 'well';
}
function tabSelect1(obj,id)
{
	obj.parentNode.children[0].className = '';
	obj.parentNode.children[1].className = '';
	obj.className = 'rb-active1';
	getId('user-info').className = 'tab-panel hidden';
	getId('user-option').className = 'tab-panel hidden';
	getId(id).className = 'tab-panel';
}
