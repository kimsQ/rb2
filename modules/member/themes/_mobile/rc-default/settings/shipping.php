<?php
$sqlque0 = 'mbruid='.$my['uid'];
$sqlque1 = 'mbruid='.$my['uid'].' and base=1';
$sqlque2 = 'mbruid='.$my['uid'].' and base=0';

$PCD = getDbArray($table['s_mbrshipping'],$sqlque1,'*','uid','asc',0,1);
$RCD = getDbArray($table['s_mbrshipping'],$sqlque2,'*','uid','asc',0,1);

$NUM = getDbRows($table['s_mbrshipping'],$sqlque0);
?>

<div class="page center" id="page-main">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<h1 class="title" data-location="reload">
			<i class="fa fa-truck fa-fw text-muted mr-1" aria-hidden="true"></i> 배송지 관리
		</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button class="btn btn-outline-primary btn-block"
			data-toggle="page"
			data-target="#page-edit"
			data-start="#page-main"
			data-act="edit"
			data-title="배송지 등록">
			배송지 등록
		</button>
	</div>
	<?php if ($TPG > 1): ?>
	<footer class="bar bar-standard bar-footer bar-light bg-white p-x-0">
		<div class="">
			<?php echo getPageLink($d['theme']['pagenum'],$p,$TPG,'')?>
		</div>
	</footer>
	<?php endif; ?>

	<main class="content bg-faded animated fadeIn delay-1">

		<ul class="table-view bg-white" style="margin-top: -.0625rem">

			<?php while($P=db_fetch_array($PCD)):?>
		  <li class="table-view-cell">
				<div class="media-body">
					<?php echo $P['label'] ?><span class="badge badge-primary badge-outline ml-2">기본배송지</span>
					<p>
						<span class="text-muted"><?php echo $P['zip'] ?></span>
						<?php echo $P['addr1'] ?><br><?php echo $P['addr2'] ?>
						<span class="ml-1"><?php echo $P['tel1'] ?></span>
						<span class="ml-1"><?php echo $P['tel2'] ?></span>
						<span class="ml-1"><?php echo $P['name'] ?></span>
					</p>
				</div>

		    <button class="btn btn-secondary"
					data-toggle="page"
					data-target="#page-edit"
					data-start="#page-main"
					data-uid="<?php echo $P['uid'] ?>"
					data-act="edit"
					data-title="<?php echo $P['label'] ?>"
					data-url="">
					관리
				</button>
		  </li>
			<?php endwhile?>

			<?php while($R=db_fetch_array($RCD)):?>
		  <li class="table-view-cell">
				<div class="media-body">
					<?php echo $R['label'] ?>
					<p>
						<span class="text-muted"><?php echo $R['zip'] ?></span>
						<?php echo $R['addr1'] ?><br><?php echo $R['addr2'] ?>
						<span class="ml-1"><?php echo $R['tel1'] ?></span>
						<span class="ml-1"><?php echo $R['tel2'] ?></span>
						<span class="ml-1"><?php echo $R['name'] ?></span>
					</p>
				</div>

		    <button class="btn btn-secondary"
					data-toggle="page"
					data-target="#page-edit"
					data-start="#page-main"
					data-uid="<?php echo $R['uid'] ?>"
					data-act="edit"
					data-title="<?php echo $R['label'] ?>"
					data-url="">
					관리
				</button>
		  </li>
			<?php endwhile?>

			<?php if(!$NUM):?>
				<li class="table-view-cell text-xs-center p-5 text-muted d-flex align-items-center justify-content-center bg-faded" style="height: calc(100vh - 10.5rem);">
					내역이 없습니다.
			  </li>
			<?php endif?>
		</ul>

	</main>

</div><!-- /.page -->

<div class="page right" id="page-edit">
	<header class="bar bar-nav bar-dark bg-primary px-0">
		<a class="icon icon-left-nav pull-left p-x-1" role="button" data-history="back"></a>
		<button class="btn btn-link pull-right mr-3">
			저장
		</button>
		<h1 class="title" data-location="reload">
			<i class="fa fa-truck fa-fw text-muted mr-1" aria-hidden="true"></i> <span data-role="title"></span>
		</h1>
	</header>
	<div class="bar bar-standard bar-footer bar-light bg-faded">
		<button class="btn btn-outline-danger btn-block">
			배송지 삭제
		</button>
	</div>
	<main class="content bg-faded">

		<div class="content-padded">

			<div class="form-group">
		    <label>배송지명</label>
		    <input type="text" class="form-control" name="label" value="" placeholder="배송지명을 입력하세요." autocomplete="off">
				<div class="invalid-feedback">
					배송지명을 입력해주세요.
				</div>
		  </div>

			<div class="form-group">
		    <label>수령인 <span class="text-danger">*</span></label>
		    <input type="text" class="form-control" name="name" value="" placeholder="수령인을 입력하세요." autocomplete="off">
				<div class="invalid-feedback">
					수령인을 입력해주세요.
				</div>
		  </div>

			<div class="form-group">
				<label>주소 <span class="text-danger">*</span></label>
				<div id="addrbox"<?php if($my['addr0']=='해외'):?> class="hidden"<?php endif?>>
					<div class="input-group" style="margin-bottom: 5px">
						<input type="number" class="form-control" name="zip" value="<?php echo substr($my['zip'],0,5)?>" id="zip1" placeholder="" readonly>
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button" id="execDaumPostcode">
								<i class="fa fa-search"></i>우편번호
							</button>
						</span>
					</div>
					<input class="form-control" type="text" value="<?php echo $my['addr1']?>" name="addr1" id="addr1" readonly placeholder="우편번호를 선택" style="margin-bottom: 5px">
					<input class="form-control" type="text" value="<?php echo $my['addr2']?>" name="addr2" id="addr2" style="margin-bottom: 5px" placeholder="상세 주소를 입력">
					<div class="invalid-feedback">
						주소를 입력해주세요.
					</div>
				</div>

				<?php if($d['member']['form_settings_overseas']):?>
	      <div class="m-t-1">
	        <?php if($my['addr0']=='해외'):?>
					<label class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" name="overseas" value="1" checked="checked" onclick="overseasChk(this);">
					  <span class="custom-control-indicator"></span>
					  <span class="custom-control-description" id="overseas_ment">해외거주자 입니다.</span>
					</label>
	        <?php else:?>
					<label class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" name="overseas" value="1" onclick="overseasChk(this);">
					  <span class="custom-control-indicator"></span>
					  <span class="custom-control-description" id="overseas_ment">해외거주자일 경우 체크해 주세요.</span>
					</label>
	        <?php endif?>
	      </div>
	      <?php endif?>

			</div><!-- /.form-group -->

			<div class="form-group">
				<label>연락처 <span class="text-danger">*</span></label>
				<?php $tel1=explode('-',$my['tel1'])?>
				<div class="form-row">
					<div class="col-xs-4">
						<input type="text" name="tel1_1" value="<?php echo $tel1[0]?>" maxlength="4" size="4" class="form-control" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<input type="text" name="tel1_2" value="<?php echo $tel1[1]?>" maxlength="4" size="4"  class="form-control" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<input type="text" name="tel1_3" value="<?php echo $tel1[2]?>" maxlength="4" size="4" class="form-control" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>연락처2</label>
				<?php $tel1=explode('-',$my['tel1'])?>
				<div class="form-row">
					<div class="col-xs-4">
						<input type="text" name="tel1_1" value="<?php echo $tel1[0]?>" maxlength="4" size="4" class="form-control" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<input type="text" name="tel1_2" value="<?php echo $tel1[1]?>" maxlength="4" size="4"  class="form-control" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
					<div class="col-xs-4">
						<input type="text" name="tel1_3" value="<?php echo $tel1[2]?>" maxlength="4" size="4" class="form-control" autocomplete="off">
						<div class="invalid-feedback">
							입력필요
						</div>
					</div>
				</div>
			</div>

			<label class="custom-control custom-checkbox m-t-3">
				<input type="checkbox" class="custom-control-input" name="birthtype" id="birthtype" value="1">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description">기본 배송지로 등록</span>
			</label>

		</div><!-- /.content-padded -->

	</main>
</div><!-- /.page -->

<!-- Modal -->
<div id="modal-DaumPostcode" class="modal">
  <header class="bar bar-nav bar-light bg-faded px-0">
    <a class="icon icon-close pull-right p-x-1" data-history="back" role="button"></a>
    <h1 class="title">우편번호 검색</h1>
  </header>
  <div class="content" id="postLayer">
  </div>
</div>

<?php if($_SERVER['HTTPS'] == 'on'):?>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<?php else:?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<?php endif?>

<script>

$(function() {

});

</script>
