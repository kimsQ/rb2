<?php
$R=array();
$recnum= $recnum ? $recnum : 12;
$sendsql = 'gid>-1';
if ($keyw)
{
	$sendsql .= " and (id like '%".$keyw."%' or name like '%".$keyw."%')";
}
$RCD = getDbArray($table['s_module'],$sendsql,'*','gid','asc',$recnum,$p);
$NUM = getDbRows($table['s_module'],$sendsql);
$TPG = getTotalPage($NUM,$recnum);
if (!$id)$id=$module;
$R = getDbData($table['s_module'],"id='".$id."'",'*');
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-5 col-md-5 col-xl-4 d-none d-sm-block sidebar" id="tab-content-list">
			<div class="card">
				<div class="card-header">
					<i class="fa kf kf-module fa-lg fa-fw"></i>
					전체모듈
					<span class="pull-right">
						<button type="button" class="btn btn-link py-0 muted-link" data-toggle="collapse" data-target="#panel-search" data-tooltip="tooltip" title="검색필터" onclick="sessionSetting('sh_module_search','1','','1');getSearchFocus();">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
				<div id="panel-search" class="collapse">
					<form role="form" action="<?php echo $g['s']?>/" method="get">
						<input type="hidden" name="r" value="<?php echo $r?>">
						<input type="hidden" name="m" value="<?php echo $m?>">
						<input type="hidden" name="module" value="<?php echo $module?>">
						<input type="hidden" name="front" value="<?php echo $front?>">
						<input type="hidden" name="id" value="<?php echo $id?>">

						<div class="card-header rb-search-box">
							<div class="input-group">
								<div class="input-group-addon"><small>출력수</small></div>
								<div class="input-group-btn">
									<select class="form-control" name="recnum" onchange="this.form.submit();">
									<option value="15"<?php if($recnum==15):?> selected<?php endif?>>15</option>
									<option value="30"<?php if($recnum==30):?> selected<?php endif?>>30</option>
									<option value="60"<?php if($recnum==60):?> selected<?php endif?>>60</option>
									<option value="100"<?php if($recnum==100):?> selected<?php endif?>>100</option>
									</select>
								</div>
							</div>
						</div>
						<div class="rb-keyword-search">
							<input type="text" name="keyw" class="form-control" value="<?php echo $keyw?>" placeholder="모듈명,아이디 검색">
						</div>
					</form>
				</div>

				<div class="panel-collapse collapse show" id="collapmetane">
					<table id="module-list" class="table">
						<thead>
							<tr>
								<td class="rb-name"><span>모듈명</span></td>
								<td class="rb-id"><span>아이디</span></td>
								<td class="rb-time"><span>등록일</span></td>
							</tr>
						</thead>
						<tbody>
							<?php while($_R = db_fetch_array($RCD)):?>
							<tr<?php if($id==$_R['id']):?> class="table-active"<?php endif?> onclick="goHref('<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $p?>&amp;id=<?php echo $_R['id']?>&amp;keyw=<?php echo urlencode($keyw)?>#page-info');">
								<td class="rb-name">
									<i class="kf <?php echo $_R['icon']?$_R['icon']:'kf-'.$_R['id']?>"></i>
									<?php echo $_R['name']?>
									<?php if(!$_R['hidden']):?><small><small class="fa fa-eye"></small></small><?php endif?>
								</td>
								<td class="rb-id"><?php echo $_R['id']?></td>
								<td class="rb-time">
									<?php echo getDateFormat($_R['d_regis'],'Y.m.d')?>
								</td>
							</tr>
							<?php endwhile?>
						</tbody>
					</table>

					<?php if($TPG>1):?>
					<ul class="pagination justify-content-center">
						<script>getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
					</ul>
					<?php endif?>
				</div>
			</div>
		</div>

		<?php if(!$R['id']) $R=getDbData($table['s_module'],"id='site'",'*')?>
		<?php if($g['device']):?><a name="page-info"></a><?php endif?>
		<div class="col-sm-7 col-md-7 ml-sm-auto col-xl-8 pt-3" id="tab-content-view">
			<div class="page-header mt-0">
				<h4>모듈 익스텐션 정보</h4>
			</div>

			<div class="row">
				<div class="col-md-2 col-sm-2 text-center">
					<div class="rb-box">
						<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $m?>&amp;module=<?php echo $_R['id']?>">
							<i class="rb-icon kf <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?>"></i><br>
							<i class="rb-name"><?php echo $R['id']?></i>
						</a>
					</div>
				</div>
				<div class="col-md-10 col-sm-10">
					<h4 class="mb-2">
						<strong><?php echo $R['name']?></strong>
					</h4>
					<button type="button" class="btn btn-light mb-2"><span class="badge badge-secondary">1.1.0</span> 최신 업데이트가 없습니다.</button>
					<p class="text-muted"><small>선택된 모듈에 대한 플러그인 정보입니다.</small></p>
				</div>
			</div>

			<hr>


			<?php
			include $g['path_core'].'function/rss.func.php';
			include $g['path_module'].'market/var/var.php';
			$_serverinfo = explode('/',$d['update']['url']);
			$updatefile = 'http://'.$_serverinfo[2].'/__update/market/modules/'.$id.'/theme.txt';
			$_updatelist = getUrlData($updatefile,10);
			$_updatelist = explode("\n",$_updatelist);
			$_updatelength = count($_updatelist)-1;
			$recnum	=  1000;
			$TPG = getTotalPage($_updatelength,$recnum);
			?>

			<?php if (remoteFileExist($updatefile) == 1): ?>
			<div class="table-responsive">
				<table class="table table-hover f13 text-center">
					<thead class="text-muted">
						<tr>
							<th>내 테마</th>
							<th>테마명(아이디)</th>
							<th>제작자</th>
							<th>마켓등록일</td>
							<th>설치일</th>
							<th>다운로드</th>
							<th>원격설치</th>
						</tr>
					</thead>
					<tbody>
						<?php $_ishistory=false?>
						<?php for($i = $_updatelength-(($p-1)*$recnum)-1; $i > $_updatelength-($p*$recnum)-1; $i--):?>
						<?php $_update=trim($_updatelist[$i]);if(!$_update)continue?>
						<?php $var1=explode(',',$_update)?>
						<?php $var2=explode(',',$_updatelist[$i-1])?>
						<?php $_updatefile=$g['path_module'].$id.'/update/'.$var1[0].'.'.$var1[5].'.txt'?>
						<?php if(is_file($_updatefile)):?>
						<?php $_supdate=explode(',',implode('',file($_updatefile)))?>

						<tr>
							<td><?php if(is_dir($g['path_module'].$id.'/themes/'.$var1[0])):?><span style="color:red;">Y</span><?php else:?>N<?php endif?></td>
							<td><a href="http://<?php echo $_serverinfo[2]?>/market/<?php echo $var1[2]?>" target="_blank"><?php echo $var1[3]?>(<?php echo $var1[0]?>)</a></td>
							<td><?php echo $var1[4]?></td>
							<td><?php echo getDateFormat($var1[1],'Y.m.d')?></td>

							<td><?php echo getDateFormat($_supdate[0],'Y.m.d')?></td>
							<td>
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_plugin&amp;extension_path=./modules/<?php echo $id?>/&amp;type=download&amp;ufile=<?php echo $var1[0]?>.<?php echo $var1[5]?>" onclick="return hrefCheck(this,true,'정말로 다운로드 받으시겠습니까?');" class="btn btn-light">다운로드</a>
							</td>
							<td>
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_plugin&amp;extension_path=./modules/<?php echo $id?>/&amp;type=delete&amp;ufile=<?php echo $var1[0]?>.<?php echo $var1[5]?>" title="테마 제거" onclick="return hrefCheck(this,true,'정말로 이 테마를 제거하시겠습니까?');" class="btn btn-light">테마제거</a>
							</td>
						</tr>

						<?php else:?>

						<tr>
							<td><?php if(is_dir($g['path_module'].$id.'/theme/'.$var1[0])):?><span style="color:red;">Y</span><?php else:?>N<?php endif?></td>
							<td></td>
							<td><a href="http://<?php echo $_serverinfo[2]?>/market/<?php echo $var1[2]?>" target="_blank"><?php echo $var1[3]?>(<?php echo $var1[0]?>)</a></td>
							<td><?php echo $var1[4]?></td>
							<td><?php echo getDateFormat($var1[1],'Y.m.d')?></td>

							<td><span class="label label-default">미설치</span></td>
							<td>
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_plugin&amp;extension_path=./modules/<?php echo $id?>/&amp;type=download&amp;ufile=<?php echo $var1[0]?>.<?php echo $var1[5]?>" onclick="return hrefCheck(this,true,'정말로 다운로드 받으시겠습니까?');" class="btn btn-light">다운로드</a>
							</td>
							<td>
								<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=update_plugin&amp;extension_path=./modules/<?php echo $id?>/&amp;type=install&amp;ufile=<?php echo $var1[0]?>.<?php echo $var1[5]?>" onclick="return hrefCheck(this,true,'정말로 설치 하시겠습니까?');" class="btn btn-light">원격설치</a>
							</td>
						</tr>

						<?php endif?>
						<?php endfor?>
						<?php if(!$_updatelength):?>
						<tr>
						<td colspan="8" class="text-center text-muted">마켓에 등록된 관련테마나 플러그인이 없습니다.</td>
						</tr>
						<?php endif?>
					</tbody>
				</table>
			</div>

			<ul class="pagination justify-content-center d-none">
				<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'');</script>
			</ul>
		<?php else: ?>
		<div class="p-5 text-muted small text-center">
			업데이트 정보가 없습니다.
		</div>
		<?php endif; ?>

		</div>
	</div>

</div>
