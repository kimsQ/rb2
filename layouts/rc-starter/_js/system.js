var page_software_loglist = $('#page-software-loglist');
var page_software_logview = $('#page-software-logview');

$('.markdown-body').markdown();

$('#sheet-update-confirm [data-act="submit"]').click(function(){
  history.back();
  setTimeout(function(){
    $('.content').loader({ position: 'overlay',text: '잠시만 기다리세요...' });
  }, 300);
  setTimeout(function(){
    $('[name="updateForm"]').submit();
  }, 1000);
});

$('[data-act="gitinit"]').click(function(){
  $(this).attr( 'disabled', true );
  $('.content').loader({ position: 'overlay',text: '잠시만 기다리세요...' });
  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=admin&a=gitinit',{
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;
          var msg=result.msg;
          if (error) {
            $.notify({message: msg},{type: 'default'});
            $(this).attr( 'disabled', false );
            return false
          } else {
            location.reload();
          }
        } else {
          $.notify({message: '다시 시도해 주세요.'},{type: 'default'});
          $(this).attr( 'disabled', false );
          return false
        }
      });
  }, 1000);
});

page_software_loglist.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  page.find('[data-role="list"]').loader({ position: 'inside' });
  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=admin&a=get_updateList',{
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var list=result.list;
          page.find('[data-role="list"]').html(list)
        } else {
          $.notify({message: '다시 시도해 주세요.'},{type: 'danger'});
          return false
        }
      });
  }, 200);
});

page_software_logview.on('show.rc.page', function(event) {
  var button = $(event.relatedTarget);
  var page = $(this);
  var uid = button.attr('data-uid');

  page.find('[data-role="list"]').loader({ position: 'inside' });
  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=admin&a=get_updateData',{
      uid : uid
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var version=result.version;
          var name=result.name;
          var output=result.output;
          var d_regis=result.d_regis;
          page.find('[data-role="version"]').text(version);
          page.find('[data-role="name"]').text(name);
          page.find('[data-role="output"]').val(output);
          page.find('[data-role="d_regis"]').text(d_regis);
        } else {
          $.notify({message: '다시 시도해 주세요.'},{type: 'danger'});
          return false
        }
      });
  }, 200);
})

page_software_logview.on('hidden.rc.page', function(event) {
  var page = $(this);
  page.find('[data-role="version"]').html('');
  page.find('[data-role="output"]').val('');
  page.find('[data-role="d_regis"]').html('');
})
