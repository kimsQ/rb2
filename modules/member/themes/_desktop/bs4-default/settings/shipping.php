<?php
$sqlque0 = 'mbruid='.$my['uid'];
$sqlque1 = 'mbruid='.$my['uid'].' and base=1';
$sqlque2 = 'mbruid='.$my['uid'].' and base=0';

$PCD = getDbArray($table['s_mbrshipping'],$sqlque1,'*','uid','asc',0,1);
$RCD = getDbArray($table['s_mbrshipping'],$sqlque2,'*','uid','asc',0,1);

$NUM = getDbRows($table['s_mbrshipping'],$sqlque0);
?>

<?php include_once $g['dir_module_skin'].'_header.php'?>

<div class="page-wrapper row">
  <nav class="col-3 page-nav">
    <?php include_once $g['dir_module_skin'].'_nav.php'?>
  </nav>
  <div class="col-9 page-main">

    <div class="subhead mt-0">
      <h2 class="subhead-heading">배송지 관리</h2>
    </div>

    <?php if (!getValid($my['last_log'],$d['member']['settings_expire'])): //로그인 후 경과시간 비교(분 ?>
    <?php include_once $g['dir_module_skin'].'_lock.php'?>
    <?php else: ?>

    <?php if ($NUM): ?>
    <div class="d-flex justify-content-between align-items-end mb-2">
			<div class="">
				<span>총 <?php echo $NUM ?>건</span>
			</div>
		</div>

    <table class="table text-center">
      <thead class="thead-light">
        <tr>
          <th scope="col">배송지</th>
          <th scope="col">주소</th>
          <th scope="col">연락처</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody class="f13">

        <?php while($P=db_fetch_array($PCD)):?>
        <tr>
          <th scope="row" class="align-middle">
            <?php echo $P['label'] ?><br><small class="text-muted"><?php echo $P['name'] ?></small><br><span class="badge badge-primary">기본배송지</span></th>
          <td class="text-left">
            <span class="text-muted"><?php echo $P['zip'] ?></span><br>
            <?php echo $P['addr1'] ?><br><?php echo $P['addr2'] ?>
          </td>
          <td class="align-middle">
            <?php echo $P['tel1'] ?><br>
            <?php echo $P['tel2'] ?>
          </td>
          <td class="align-middle">
            <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modal-shipping" data-uid="<?php echo $P['uid'] ?>" data-act="edit">수정</button>
            <button type="button" class="btn btn-light btn-sm" data-act="del" data-uid="<?php echo $P['uid'] ?>">삭제</button>
          </td>
        </tr>
        <?php endwhile?>

        <?php while($R=db_fetch_array($RCD)):?>
        <tr>
          <th scope="row" class="align-middle"><?php echo $R['label'] ?><br><small class="text-muted"><?php echo $R['name'] ?></small></th>
          <td class="text-left">
            <span class="text-muted"><?php echo $R['zip'] ?></span><br>
            <?php echo $R['addr1'] ?><br><?php echo $R['addr2'] ?>
          </td>
          <td class="align-middle">
            <?php echo $R['tel1'] ?><br>
            <?php echo $R['tel2'] ?>
          </td>
          <td class="align-middle">
            <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modal-shipping" data-uid="<?php echo $R['uid'] ?>" data-act="edit">수정</button>
            <button type="button" class="btn btn-light btn-sm" data-act="del" data-uid="<?php echo $R['uid'] ?>">삭제</button>
          </td>
        </tr>
        <?php endwhile?>

      </tbody>
    </table>
    <div class="text-right">
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-shipping" data-act="add">
        배송지 등록
      </button>
    </div>
    <?php else: ?>
    <div class="card p-5 my-4 text-center text-muted">
      <i class="fa fa-truck fa-3x" aria-hidden="true"></i><br>
      등록된 배송지가 없습니다. <br>
      쇼핑에서 사용할 배송지를 관리하실 수 있습니다.<br>
      자주 쓰는 배송지를 편리하게 통합 관리 하세요!<br>
      <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modal-shipping" data-act="add">
        배송지 등록
      </button>
    </div>
    <?php endif; ?>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal-shipping">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="fa fa-truck fa-fw fa-lg" aria-hidden="true"></i>
              <span data-role="title">배송지 정보 상세</span>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="shippingForm" role="form" action="<?php echo $g['s']?>/" method="post" >
              <input type="hidden" name="r" value="<?php echo $r?>">
              <input type="hidden" name="m" value="<?php echo $m?>">
              <input type="hidden" name="a" value="settings_shipping">
              <input type="hidden" name="act" value="">
              <input type="hidden" name="uid" value="">


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-nowrap">배송지명</label>
                  <div class="col-sm-10">
                    <input type="text" name="label" class="form-control w-50" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-nowrap">수령인 <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control w-50" placeholder="" required>
                    <div class="invalid-feedback">수령인을 입력해주세요.</div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-nowrap">주소 <span class="text-danger">*</span></label>
                  <div class="col-sm-10">

                    <div class="form-row mb-2">
                     <div class="col-3">
                       <input type="text" class="form-control" name="zip" value="" id="zip" maxlength="5" size="5" readonly required>
                     </div>
                     <div class="col-6">
                       <button type="button" class="btn btn-light" role="button" id="execDaumPostcode">우편번호찾기</button>
                     </div>
                   </div><!-- /.form-row -->

                    <div class="form-row">
                     <div class="form-group col-12">
                       <input type="text" class="form-control mb-2" name="addr1" id="addr1" value="" readonly>
                       <input type="text" class="form-control" name="addr2" id="addr2" value="" required>
                       <div class="invalid-feedback">
                         주소를 입력해주세요.
                       </div>
                     </div>
                   </div><!-- /.form-row -->

                  </div>
                </div><!-- /.form-group -->

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-nowrap">연락처 <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="form-inline">
                      <input type="text" name="tel1_1" value="" maxlength="4" size="4" class="form-control" required><span class="px-1">-</span>
                      <input type="text" name="tel1_2" value="" maxlength="4" size="4" class="form-control" required><span class="px-1">-</span>
                      <input type="text" name="tel1_3" value="" maxlength="4" size="4" class="form-control" required>
                      <div class="invalid-feedback">
                        전화번호를 입력해주세요.
                      </div>
                    </div><!-- /.form-inline -->
                    <div class="invalid-feedback"></div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-nowrap">연락처2</label>
                  <div class="col-sm-10">
                    <div class="form-inline">
                      <input type="text" name="tel2_1" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
                      <input type="text" name="tel2_2" value="" maxlength="4" size="4" class="form-control"><span class="px-1">-</span>
                      <input type="text" name="tel2_3" value="" maxlength="4" size="4" class="form-control">
                      <div class="invalid-feedback">
                        전화번호를 입력해주세요.
                      </div>
                    </div><!-- /.form-inline -->
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-nowrap">기본배송지</label>
                  <div class="col-sm-10">
                    <div class="custom-control custom-checkbox mt-2">
                      <input type="checkbox" class="custom-control-input" id="base" name="base" value="1">
                      <label class="custom-control-label" for="base">기본 배송지로 설정</label>
                    </div>
                  </div>
                </div>
            </form>

          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
            <button type="button" class="btn btn-primary" data-role="submit">
              <span class="not-loading">저장</span>
              <span class="is-loading">저장중..</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal : 우편번호 찾기 -->
    <div id="modal-DaumPostcode" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">우편번호 찾기</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0" id="postLayer" style="height: 500px">
          </div>
        </div>
      </div>
    </div>

    <?php endif; ?>

  </div><!-- /.page-main -->
</div><!-- /.row -->

<?php include_once $g['dir_module_skin'].'_footer.php'?>

<?php if($_SERVER['HTTPS'] == 'on'):?>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<?php else:?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<?php endif?>

<script>

var f = document.getElementById("shippingForm")
var form = $('#shippingForm')
var modal = $('#modal-shipping')

form.submit(function(event){
  if (f.checkValidity() === false) {
    modal.find('[data-role="submit"]').attr('disabled',false)

    var name = modal.find('[name="name"]')
    var addr1 = modal.find('[name="addr1"]')
    var addr2 = modal.find('[name="addr2"]')
    var tel1_1= modal.find('[name="tel1_1"]')
    var tel1_2= modal.find('[name="tel1_2"]')
    var tel1_3= modal.find('[name="tel1_3"]')

    if (!name.val()) name.addClass('is-invalid').focus()
    if (!addr1.val()) addr1.addClass('is-invalid')
    if (!addr2.val()) addr2.addClass('is-invalid')
    if (!tel1_1.val()) tel1_1.addClass('is-invalid')
    if (!tel1_2.val()) tel1_2.addClass('is-invalid')
    if (!tel1_3.val()) tel1_3.addClass('is-invalid')

    event.preventDefault();
    event.stopPropagation();
  }

});

$(function () {

  putCookieAlert('member_settings_result') // 실행결과 알림 메시지 출력

  modal.on('show.bs.modal', function (e) {
    var button = $(e.relatedTarget) // Button that triggered the modal
    var uid = button.data('uid')
    var act = button.data('act')

    //항목 초기화
    modal.find('[type="text"]').val('').removeClass('is-invalid')
    modal.find('[name="base"]').attr('checked',false)
    modal.find('fieldset').attr('disabled',false)
    modal.find('[data-role="submit"]').attr('disabled',false)

    //액션구분
    modal.find('[name="act"]').val(act)

    if (uid) {

      $.post(rooturl+'/?r='+raccount+'&m=member&a=settings_shipping',{
        act : 'get_data',
         uid : uid
        },function(response){
         var result = $.parseJSON(response);

        var title = '배송지 정보 상세'
        var label = result.label
        var name = result.name
        var zip = result.zip
        var addr1 = result.addr1
        var addr2 = result.addr2
        var tel1 = result.tel1
        var tel2 = result.tel2
        var base = result.base

        modal.find('[name="label"]').val(label)
        modal.find('[name="name"]').val(name)
        modal.find('[name="zip"]').val(zip)
        modal.find('[name="addr1"]').val(addr1)
        modal.find('[name="addr2"]').val(addr2)

        if (tel1) {
          var tel1 = result.tel1.split('-')
          modal.find('[name="tel1_1"]').val(tel1[0])
          modal.find('[name="tel1_2"]').val(tel1[1])
          modal.find('[name="tel1_3"]').val(tel1[2])
        }

        if (tel2) {
          var tel2 = result.tel2.split('-')
          modal.find('[name="tel2_1"]').val(tel2[0])
          modal.find('[name="tel2_2"]').val(tel2[1])
          modal.find('[name="tel2_3"]').val(tel2[2])
        }

        if (base==1) modal.find('[name="base"]').attr('checked',true)

      });

    } else {
      var title = '배송지 등록'
    }

    modal.find('[data-role="title"]').text(title)
    modal.find('[name="uid"]').val(uid)
  })

  modal.on('shown.bs.modal', function (e) {
    var button = $(e.relatedTarget)
    var uid = button.data('uid')
    if (!uid) modal.find('[name="label"]').trigger('focus')
  })

  $('[data-act="del"]').click(function() {
    if (confirm('정말로 삭제하시겠습니까?   ')){
      var uid = $(this).data('uid')
      var act = 'del'
      var url = rooturl+'/?r='+raccount+'&m=member&a=settings_shipping&act='+act+'&uid='+uid
      getIframeForAction();
      frames.__iframe_for_action__.location.href = url;
    }
  });

  modal.find('[data-role="submit"]').click(function() {
    $(this).attr('disabled',true)
    getIframeForAction(f);
    setTimeout(function(){
      modal.find('#shippingForm').submit()
      // modal.modal('hide')
    }, 500);
  });

  // 폼유효성 상태표시 흔적 초기화
  form.find('[type="text"]').keyup(function(){
    $(this).removeClass('is-invalid is-valid')
  });

  $("#execDaumPostcode").click(function() {
    // 우편번호 찾기 화면을 넣을 element
    var element_wrap = document.getElementById('postLayer');
    function execDaumPostcode() {
      daum.postcode.load(function(){
        new daum.Postcode({
             oncomplete: function(data) {
                 // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                 // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                 // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                 var fullAddr = data.address; // 최종 주소 변수
                 var extraAddr = ''; // 조합형 주소 변수
                 // 기본 주소가 도로명 타입일때 조합한다.
                 if(data.addressType === 'R'){
                     //법정동명이 있을 경우 추가한다.
                     if(data.bname !== ''){
                         extraAddr += data.bname;
                     }
                     // 건물명이 있을 경우 추가한다.
                     if(data.buildingName !== ''){
                         extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                     }
                     // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                     fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                 }
                 // 우편번호와 주소 정보를 해당 필드에 넣는다.
                 document.getElementById('zip').value = data.zonecode; //5자리 새우편번호 사용
                 document.getElementById('addr1').value = fullAddr;
                 $('#modal-DaumPostcode').modal('hide')// 우편번호 검색모달을 숨김
                 $('#addr1').removeClass('is-invalid') //에러표시 초기화
                 $('#addr2').focus()

             },
             // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
             width : '100%',
             height : '100%'
         }).embed(element_wrap);
        });
      element_wrap.style.display = 'block';
      $('#modal-DaumPostcode').modal('show')
    }
    execDaumPostcode()
  })

})

</script>
