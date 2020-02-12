<div class="modal fade" tabindex="-1" role="dialog" id="modal-noti">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light align-items-center">
        <h5 class="modal-title">
          <i class="fa fa-bell-o fa-fw" aria-hidden="true"></i> 알림
          <span class="badge badge-light align-text-top" data-role="from"></span>
        </h5>
        <div class="text-muted">
          <i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> <span data-role="d_regis">2018.10.12</span>
        </div>
      </div>
      <div class="modal-body">
        <p data-role="message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">닫기</button>
        <a class="btn btn-primary" data-role="referer" target="_blank">내용확인</a>
      </div>
    </div>
  </div>
</div>

<script>

var modal_noti = $('#modal-noti')  // 알림보기 팝업

$(function() {

  $(document).on('show.bs.modal','#sheet-noti',function(event){

    var item = $(event.relatedTarget)
    var uid = item.data('uid')
    var from = item.data('from')
    modal_noti.find('[data-role="from"]').text(from)
    $.post(rooturl+'/?r='+raccount+'&m=notification&a=get_notiData',{
         uid : uid
      },function(response){
       var result = $.parseJSON(response);
       var referer=result.referer;
       var d_regis=result.d_regis;
       var message=result.message;
       modal_noti.find('[data-role="message"]').html(message)
       modal_noti.find('[data-role="d_regis"]').text(d_regis)
       if (referer) modal_noti.find('[data-role="referer"]').attr('href',referer)
       else modal_noti.find('[data-role="referer"]').addClass('d-none')
    });
  })

  $(document).on('hidden.bs.modal',modal_noti,function(event){
    //내용 초기화
    modal_noti.find('[data-role="from"]').html('')
    modal_noti.find('[data-role="referer"]').removeClass('d-none')
    modal_noti.find('[data-role="message"]').text('')
    modal_noti.find('[data-role="d_regis"]').text('')
  })

});
</script>
