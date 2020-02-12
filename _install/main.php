<?php
if(!defined('__KIMS__')) exit;
$sitelang = $sitelang ? $sitelang : 'DEFAULT';
$_langfile = $g['path_root'].'_install/language/'.$sitelang.'/lang.install.php';
if (is_file($_langfile)) include $_langfile;

$g['s'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
$g['url_root'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'].$g['s'];
require $g['path_var'].'plugin.var.php';
require $g['path_core'].'function/sys.func.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['install']['flag']?>">
	<head>
		<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title><?php echo _LANG('i007','install')?></title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<?php getImport('font-awesome','css/font-awesome',false,'css')?>
		<?php getImport('font-kimsq','css/font-kimsq',false,'css')?>

		<script>
		var mbrclick= false;
		var rooturl = '<?php echo $g['url_root']?>';
		</script>
		<script src="./_core/js/sys.js"></script>
		<script><?php include './_install/main.js'?></script>
		<link href="./_install/main.css" rel="stylesheet">
	</head>
	<body id="rb-body-install">

		<div class="container">
			<div class="panel panel-default rb-installer">

				<div class="panel-heading">
					<h1 class="panel-title">
						<span id="_lang_" class="pull-right" style="margin-top: -4px">
							<select class="form-control input-sm" onchange="location.href='./index.php?sitelang='+this.value;">
							<?php $dirs = opendir($g['path_root'].'_install/language/')?>
							<?php while(false !== ($tpl = readdir($dirs))):?>
							<?php if($tpl=='.'||$tpl=='..')continue?>
							<option value="<?php echo $tpl?>"<?php if($sitelang==$tpl):?> selected<?php endif?> title="<?php echo $tpl?>"><?php echo implode('',file($g['path_root'].'_install/language/'.$tpl.'/name.txt'))?> &nbsp; </option>
							<?php endwhile?>
							<?php closedir($dirs)?>
							</select>
						</span>
						<i class="kf kf-bi-01 fa-lg"></i> Rb  <small>Installer</small>
					</h1>
				</div>

				<form name="procForm" class="form-horizontal" role="form" id="wizard" action="./" method="post" target="_action_frame_" onsubmit="return installCheck(this);">
					<input type="hidden" name="install" value="a.install">
					<input type="hidden" name="sitelang" value="<?php echo $sitelang?>">
					<input type="hidden" name="dbkind" value="MySQL">
					<input type="hidden" name="dbtype" value="MyISAM">

					<div class="panel-body">
						<div class="row">

							<!-- 스텝 -->
							<div class="col-sm-3 side-steps hidden-xs">
								<div id="step-1" class="rb-active"><i class="fa fa-check-square-o fa-2x"></i><?php echo _LANG('i008','install')?></div>
								<div id="step-2"><i class="fa kf-dbmanager fa-2x"></i><?php echo _LANG('i009','install')?></div>
								<div id="step-3"><i class="fa fa-user fa-2x"></i><?php echo _LANG('i010','install')?></div>
								<div id="step-4"><i class="fa fa-home fa-2x"></i><?php echo _LANG('i011','install')?></div>
							</div>
							<div class="col-sm-9 rb-step-body">

								<!-- 라이선스 -->
								<div id="step-1-body">
									<div class="page-header visible-xs">
										<h3><i class="fa fa-check-square-o fa-lg fa-fw"></i> <?php echo _LANG('i012','install')?></h3>
									</div>
									<div class="form-group">
										<br>
										<label><?php echo _LANG('i013','install')?> <span class="label label-default">RBL</span></label>
										<textarea class="form-control" rows="15"><?php readfile('LICENSE'.(is_file('LICENSE-'.$sitelang)?'-'.$sitelang:''))?></textarea>
									</div>

									<div class="checkbox">
										<label>
											<input type="checkbox" onclick="agreecheck(this);"> <strong><?php echo _LANG('i014','install')?></strong>
										</label>
									</div>
								</div>

								<!-- 데이터베이스 -->
								<div id="step-2-body" class="hidden">

									<div class="page-header visible-xs">
										<h3><i class="fa kf-dbmanager fa-lg fa-fw"></i> <?php echo _LANG('i015','install')?></h3>
									</div>

									<ul class="nav nav-pills">
										<li class="rb-active1" onclick="tabSelect(this,'db-info');"><a href="#."><?php echo _LANG('i016','install')?></a></li>
										<li onclick="tabSelect(this,'db-option');"><a href="#."><?php echo _LANG('i017','install')?></a></li>
									</ul>

									<div class="tab-panel" id="db-info">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i018','install')?> </label>
											<div class="col-sm-8">
												<select class="form-control" name="dbkind">
													<option>MySQL 또는 MariaDB</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i019','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbname" value="" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i020','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbuser" value="" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="password"><?php echo _LANG('i021','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="password" name="dbpass" value="" id="password">
											</div>
										</div>
									</div>
									<div id="db-info-well" class="well">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i022','install')?>
										</small>
									</div>

									<div class="tab-panel hidden" id="db-option">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i023','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbhost" value="localhost">
												<span class="help-block"><?php echo _LANG('i024','install')?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i025','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbport" value="3306">
												<span class="help-block"><?php echo _LANG('i026','install')?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i027','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="dbhead" value="rb">
												<span class="help-block"><?php echo _LANG('i028','install')?></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i029','install')?></label>
											<div class="col-sm-8">
												<select name="dbtype" class="form-control">
													<option>MyISAM</option>
													<option>InnoDB</option>
												</select>
												<span class="help-block"><?php echo _LANG('i030','install')?></span>
											</div>
										</div>
									</div>
									<div id="db-option-well" class="well hidden">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i031','install')?>
										</small>
									</div>
								</div>


								<!-- 사용자 등록 -->
								<div id="step-3-body" class="hidden">

									<div class="page-header visible-xs">
										<h3><i class="fa fa-user fa-lg fa-fw"></i> <?php echo _LANG('i032','install')?></h3>
									</div>

									<ul class="nav nav-pills">
										<li class="rb-active1" onclick="tabSelect1(this,'user-info');"><a href="#."><?php echo _LANG('i033','install')?></a></li>
										<li onclick="tabSelect1(this,'user-option');"><a href="#."><?php echo _LANG('i034','install')?></a></li>
									</ul>
									<div class="tab-panel" id="user-info">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i035','install')?> </label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="name" value="<?php echo $_POST['_live_name']?>"  placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i036','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="email" name="email" value="<?php echo $_POST['_live_email']?>" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i037','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="id" value="" placeholder="<?php echo _LANG('i038','install')?>" autofocus autocomplete="off">
												<span class="help-block"></span>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="password"><?php echo _LANG('i039','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="password" value="" name="pw0" placeholder="" autocomplete="off">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label" for="password2"><?php echo _LANG('i040','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="password" value="" name="pw1" placeholder="" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="tab-panel hidden" id="user-option">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i041','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="nick" value="" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i042','install')?></label>
											<div class="col-sm-8">
												<label class="radio-inline">
													<input type="radio" name="sex" value="1"> <?php echo _LANG('i043','install')?>
												</label>
												<label class="radio-inline">
													<input type="radio" name="sex" value="2"> <?php echo _LANG('i044','install')?>
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i045','install')?></label>
											<div class="col-sm-8">
												<div class="row rb-input-row">
													<div class="col-xs-4">
														<select name="birth_1" class="form-control">
														<option value="">Year</option>
														<?php for($i = date('Y'); $i > 1930; $i--):?>
														<option value="<?php echo $i?>"><?php echo $i?></option>
														<?php endfor?>
														</select>
													</div>
													<div class="col-xs-4">
														<select name="birth_2" class="form-control">
														<option value="">Month</option>
														<?php for($i = 1; $i < 13; $i++):?>
														<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
														<?php endfor?>
														</select>
													</div>
													<div class="col-xs-4">
														<select name="birth_3" class="form-control">
														<option value="">Day</option>
														<?php for($i = 1; $i < 32; $i++):?>
														<option value="<?php echo sprintf('%02d',$i)?>"><?php echo $i?></option>
														<?php endfor?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"></label>
											<div class="col-sm-8">
												<div class="checkbox">
													<label>
														<input type="checkbox" name="birthtype" value="1">
														<?php echo _LANG('i046','install')?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i047','install')?></label>
											<div class="col-sm-8">
												<div class="row rb-input-row">
													<div class="col-xs-4">
														<select name="tel_1" class="form-control">
														<option value="010">010</option>
														</select>
													</div>
													<div class="col-xs-4">
														<input class="form-control" type="number" name="tel_2" value="" placeholder="">
													</div>
													<div class="col-xs-4">
														<input class="form-control" type="number" name="tel_3" value="" placeholder="">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="well">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i048','install')?>
										</small>
									</div>
								</div>

								<!-- 사이트 생성 -->
								<div id="step-4-body" class="hidden">

									<div class="page-header visible-xs">
										<h3><i class="fa fa-home fa-lg fa-fw"></i>  <?php echo _LANG('i049','install')?></h3>
									</div>

									<div class="tab-panel">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i050','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="sitename" value="홈페이지" placeholder="<?php echo _LANG('i051','install')?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php echo _LANG('i052','install')?></label>
											<div class="col-sm-8">
												<input class="form-control" type="text" name="siteid" value="home" placeholder="">
												<div class="help-block">
													<?php echo _LANG('i053','install')?>
													<br>
													<code><?php echo $g['url_root']?>/<?php echo _LANG('i054','install')?></code>
												</div>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="rewrite" value="1" checked>
														<?php echo _LANG('i055','install')?>
													</label>
												</div>
												<div class="help-block">
													<?php echo _LANG('i056','install')?>
													<br>
													<code><?php echo $g['url_root']?>/?r=home&c=menu</code> <i class="glyphicon glyphicon-arrow-down"></i> <br>
													<code><?php echo $g['url_root']?>/home/c/menu</code>
												</div>
											</div>
										</div>

									</div>
									<div class="well">
										<i class="fa fa-info-circle fa-2x pull-left fa-border"></i>
										<small>
										<?php echo _LANG('i057','install')?>
										</small>
									</div>
								</div>

							</div>

						</div>

					</div>

					<div class="panel-footer clearfix">
						<button class="btn btn-default pull-left" type="button" id="_prev_btn_" onclick="stepCheck('prev');" disabled>
							<i class="fa fa-caret-left fa-lg"></i>&nbsp; <?php echo _LANG('i058','install')?></button>
						<button class="btn btn-primary pull-right" type="button" id="_next_btn_" onclick="stepCheck('next');" disabled>
							<?php echo _LANG('i059','install')?> &nbsp;<i class="fa fa-caret-right fa-lg"></i>
						</button>
					</div>

				</form>

			</div>
		</div>

		<iframe name="_action_frame_" width="0" height="0" frameborder="0" scrolling="no"></iframe>
	</body>
</html>
