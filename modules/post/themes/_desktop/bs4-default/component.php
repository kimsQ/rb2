<div class="modal" id="modal-post-share" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">공유하기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center p-5">
        <?php include $g['dir_module_skin'].'_linkshare.php'?>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-post-listadd" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">저장하기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-2" style="min-height: 200px">
        <?php if ($my['uid']) include $g['dir_module_skin'].'_listadd.php'?>
      </div>
      <div class="modal-footer py-2 f13">
        <button type="button" class="btn btn-link mr-auto text-reset text-decoration-none" data-role="list-add-button">
          <i class="material-icons text-muted align-bottom mr-1">add</i>
          새 리스트 만들기
        </button>

        <div class="input-group my-2 d-none" data-role="list-add-input">
          <input type="text" class="form-control" placeholder="리스트명 입력" name="list_name">
          <div class="input-group-append">
            <button class="btn btn-white" type="button" data-act="list-add-submit">
              <span class="not-loading">
                추가
              </span>
              <span class="is-loading">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              </span>
            </button>
            <button class="btn btn-white" type="button" data-act="list-add-cancel">취소</button>
          </div>
        </div><!-- /.input-group -->

        <button type="button" class="btn btn-link" data-act="submit">
          <span class="not-loading">
            저장하기
          </span>
          <span class="is-loading">
            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
            저장중...
          </span>
        </button>

      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-post-report" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">신고하기</h5>
      </div>
      <div class="modal-body" style="min-height: 200px">
        <?php include $g['dir_module_skin'].'_report.php'?>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-link text-muted" data-dismiss="modal">취소</button>
        <button type="button" class="btn btn-link">접수하기</button>
      </div>
    </div>
  </div>
</div>

<script>

$( document ).ready(function() {

  $('#modal-post-listadd').on('show.bs.modal', function (e) {
    var modal = $(this);
    var button = $(e.relatedTarget);
    var uid =  button.attr('data-uid');
    var submit = modal.find('[data-act="submit"]')
    modal.attr('data-uid',uid);
    submit.attr('disabled',false );

  })

  $('#modal-post-listadd').find('[data-act="submit"]').click(function(){
    var modal = $('#modal-post-listadd');
    var uid = modal.attr('data-uid');

    // 리스트 체크
    var list_sel=$('input[name="postlist_members[]"]');
    var list_arr=$('input[name="postlist_members[]"]:checked').map(function(){return $(this).val();}).get();
    var list_n=list_arr.length;
    var list_members='';
    for (var i=0;i <list_n;i++) {
      if(list_arr[i]!='')  list_members += '['+list_arr[i]+']';
    }

    $(this).attr('disabled',true );

    setTimeout(function(){
      $.post(rooturl+'/?r='+raccount+'&m=post&a=update_listindex',{
        uid : uid,
        list_members : list_members
        },function(response,status){
          if(status=='success'){
            modal.modal('hide');
            $.notify({message: '리스트에 저장되었습니다.'},{type: 'default'});
          } else {
            alert(status);
          }
      });
    }, 500);

  });

  $('#modal-post-listadd').find('[data-role="list-add-button"]').click( function() {
    $(this).addClass('d-none');
    $('#modal-post-listadd').find('[data-role="list-add-input"]').removeClass('d-none');
    $('#modal-post-listadd').find('[data-act="submit"]').addClass('d-none');
    $('#modal-post-listadd').find('[data-role="list-add-input"]').find('.form-control').val('').focus();
  } );
  $('#modal-post-listadd').find('[data-act="list-add-cancel"]').click( function() {
    $('#modal-post-listadd').find('[data-role="list-add-button"]').removeClass('d-none');
    $('#modal-post-listadd').find('[data-act="submit"]').removeClass('d-none');
    $('#modal-post-listadd').find('[data-role="list-add-input"]').addClass('d-none')
  } );

  $('#modal-post-listadd').find('[data-act="list-add-submit"]').click(function(e){
    var modal = $('#modal-post-listadd');
    var button = $(this)
    var input = modal.find('[name="list_name"]');
    var list = $('[data-role="list-selector"]');
    var checked_num = list.find('[data-role="list_num"]');
    var checked_num_val = Number(checked_num.text());
    var name = input.val();

    if (!name) {
      input.focus();
      return false
    }
    button.attr( 'disabled', true );

    setTimeout(function(){

      $.post(rooturl+'/?r='+raccount+'&m=post&a=regis_list',{
        name : name,
        send_mod : 'ajax'
        },function(response,status){
          if(status=='success'){
            var result = $.parseJSON(response);
            var uid=result.uid;
            var icon=result.icon;
            var label=result.label;
            var item = '<div class="d-flex justify-content-between align-items-center px-3 py-2"><div class="custom-control custom-checkbox">'+
                          '<input type="checkbox" id="listRadio'+uid+'" name="postlist_members[]" value="'+uid+'" class="custom-control-input" checked>'+
                          '<label class="custom-control-label" for="listRadio'+uid+'">'+name+'</label>'+
                        '</div><i class="material-icons text-muted mr-2" data-toggle="tooltip" title="" data-original-title="'+label+'">'+icon+'</i></div>';
            button.attr( 'disabled', false );
            input.val('');
            $('#modal-post-listadd').find('[data-role="list-add-button"]').removeClass('d-none');
            $('#modal-post-listadd').find('[data-role="list-add-input"]').addClass('d-none')
            $('#modal-post-listadd').find('[data-act="submit"]').removeClass('d-none');
            list.append(item);
            $('#modal-post-listadd').find('[data-toggle="tooltip"]').tooltip();
          } else {
            alert(status);
          }
      });
    }, 200);
  });

  $('#modal-post-report').on('show.bs.modal', function (e) {
    if (!memberid) {
      alert('로그인 해주세요.');
      return false;
    }
  })

});

</script>
