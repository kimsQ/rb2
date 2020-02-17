function setWidgetConfig(id,name,path,wdgvar,area) {
  var page_widget_view = $('#page-widget-view');

  page_widget_view.find('[data-role="form"]').html('');

  page_widget_view.page({
    start: '#page-widget-list'
  });

  if (!wdgvar) var mod = 'add';
  else var mod = 'edit';

  page_widget_view.find('[data-act="save"]').attr('data-mod',mod).attr('data-area',area);

  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=site&a=get_widgetConfig',{
      name : name,
      widget : path,
      wdgvar : wdgvar,
      area : area
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var page=result.page;
          var widget_name=result.widget_name;
          var widget=result.widget;
          if (!page) {
            history.back()
            setTimeout(function(){ $.notify({message: '위젯설정을 확인해주세요.'},{type: 'default'});}, 400);
            resetPage()
            return false
          }
          page_widget_view.attr('data-id',id);
          page_widget_view.attr('data-name',name);
          page_widget_view.attr('data-path',path);
          page_widget_view.find('[data-role="title"]').text(widget_name);
          page_widget_view.find('[data-role="form"]').html(page);

        } else {
          $.notify({message: '위젯설정을 확인해주세요.'},{type: 'danger'});
          return false
        }
      });
  }, 100);

}

function resetPage() {
  $('#page-widget-list [data-role="widgetConfig"]').addClass('d-none');
  $('#page-widget-list [data-role="addWidget"]').removeClass('active');
  $('#modal-widget-selector [name="widget_selector"]').prop('selectedIndex',0);
  $('#page-widget-list [data-role="widgetPage"] [data-role="item"]').removeClass('active shadow-sm')
}

var page_layout_settings = $('#page-layout-settings')
var page_widget_list = $('#page-widget-list');
var page_widget_view = $('#page-widget-view');
var page_widget_makebbs = $('#page-widget-makebbs');
var page_widget_makelist = $('#page-widget-makelist');
var modal_widget_selector = $('#modal-widget-selector');
var sheet_layoutreset_confirm = $('#sheet-layoutreset-confirm');

$('#layout-settings-panels').on('show.rc.collapse', function (e) {
  var target = $(e.target)
  var cell = target.closest('.table-view-cell')
  $(this).find('[data-toggle="collapse"]').removeClass('bg-faded');
  cell.find('[data-toggle="collapse"]').addClass('bg-faded')
})

page_layout_settings.find('[data-act="submit"]').click(function(){
  $(this).attr('disabled', true );
  setTimeout(function(){
    page_layout_settings.find('form').submit()
  }, 500);
});

page_layout_settings.find('[name="layout_main_type"]').change(function(){
  var type = $(this).val();
  var button = page_layout_settings.find('[data-target="#page-widget-list"]').closest('.table-view');
  if (type=='widget') button.removeClass('d-none');
  else button.addClass('d-none');
});

page_widget_list.find('[data-act="submit"]').click(function(){
  $(this).attr("disabled", true);
  var widgets=$(document).find('#page-widget-list input[name="widget_members[]"]').map(function(){return $(this).val()}).get();
  var new_widgets='';
  if(widgets){
    for(var i=0;i<widgets.length;i++) {
      new_widgets+=widgets[i];
    }
    page_widget_list.find('input[name="main_widgets"]').val(new_widgets);
  }
  setTimeout(function(){
    page_widget_list.find('[name="layoutMainPage"]').submit();
    resetPage(); // 상태초기화
    page_widget_list.find('[data-role="reset"]').removeClass('d-none')
   }, 500);
});

page_widget_list.on('show.rc.page', function (event) {
  var page = $(this)

  setTimeout(function(){
    $.post(rooturl+'/?r='+raccount+'&m=site&a=get_widgetPage',{
      page : 'main',
      layout : 'rc-starter'
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var list=result.list;
          var layoutPageVarForSite=result.layoutPageVarForSite;

          page.find('[data-role="widgetPage"]').html(list);

          if (layoutPageVarForSite) page.find('[data-role="reset"]').removeClass('d-none');
          else page.find('[data-role="reset"]').addClass('d-none');

          //순서변경
          page.find('[data-plugin="sortable"] ol').sortable({
            axis: 'y',
            cancel: 'button',
            delay: 250,
            placeholder: 'ui-state-highlight'
          });
          page.find('[data-plugin="sortable"] ol').disableSelection();

        } else {
          alert('위젯설정을 확인해주세요.')
          return false
        }
      });
  }, 200);

})

page_widget_list.on('hidden.rc.page', function (event) {
  var page = $(this)
  page.find('[data-role="widgetPage"]').html('');
})

page_widget_view.on('click','[data-act="save"]',function() {
  var name = $(document).find('#page-widget-view').attr('data-name');
  var _title = $(document).find('#page-widget-view [data-role="widgetConfig"] [name="title"]').val();
  var title_placeholder = $(document).find('#page-widget-view [data-role="widgetConfig"] [name="title"]').attr('placeholder');
  var path = $(document).find('#page-widget-view').attr('data-path');
  var id = $(document).find('#page-widget-view').attr('data-id');
  var mod = $(this).attr('data-mod');
  var area = $(this).attr('data-area');

  $(this).attr('disabled', true);

  var title = _title?_title:title_placeholder;
  if (!title) title = name;

  $(document).find('[data-role="widgetPage"] .card').removeClass('animated bounceIn delay-3')

  var widget_var = id+'^'+title+'^'+path+'^';

  $('#page-widget-view [data-role="widgetConfig"] [name]').each(function(index){
    var _name =  $(this).attr('name');
    var _var =  $(this).val()?$(this).val():'';
    if (_name=='title' && !_var ) _var =  $(this).attr('placeholder');
    widget_var += _name+'='+_var+',';
  });

  setTimeout(function(){
    history.back();
    resetPage();
    if (mod=='add') {
      var box = '<li class="card bg-white round-0 position-relative text-muted text-xs-center ui-sortable-handle animated fadeInUp delay-3" data-name="'+name+'" data-path="'+path+'" data-role="item" id="'+id+'">'+
                '<a data-act="remove" title="삭제" role="button" class="position-absolute btn btn-link text-muted border-0" style="right:.5rem;top:50%;margin-top: -.92rem;"><i class="fa fa-times" aria-hidden="true"></i></a>'+
                '<div data-act="move" class="position-absolute btn btn-link text-muted border-0" style="left:.5rem;top:50%;margin-top: -.92rem;"><i class="fa fa-arrows" aria-hidden="true"></i></div>'+
                '<input type="hidden" name="widget_members[]" value="['+widget_var+']">'+
                '<button type="button" class="btn btn-link btn-lg text-reset" data-act="edit">'+title+'</button>'+
                '</li>';

      $(document).find('#page-widget-list [data-role="widgetPage"][data-area="'+area+'"] ol').append(box);

    } else {

      $(document).find('#'+id+' [name="widget_members[]"]').val('['+widget_var+']');
      $(document).find('#'+id+'').addClass('animated bounceIn');
      $(document).find('#'+id+' [data-role="title"]').text(title);
      $(document).find('#'+id+' [data-act="edit"]').text(title);
      $(document).find('#page-widget-list [data-role="widgetPage"] [data-role="item"]').removeClass('active shadow-sm')
      page_widget_list.find('[data-act="submit"]').click();
    }

  }, 200);

});

page_widget_view.on('hidden.rc.page', function (event) {
  var page = $(this)
  page.find('[data-act="save"]').attr('disabled', false);
  resetPage();
})

page_widget_view.on('click','[data-act="make"]',function() {
  var button = $(this);
  var mod = button.attr('data-mod');
  if (mod=='bbs') var target = page_widget_makebbs;
  if (mod=='postlist') var target = page_widget_makelist;
  if (!mod) return false;
  target.page({ start: '#page-widget-view' });
})


page_widget_view.on('click','[data-act="code"]',function() {
  var name = page_widget_view.attr('data-name');
  var title = page_widget_view.find('[name="title"]').val();
  var path = page_widget_view.attr('data-path');

  if (!title) title = name;

  var widget_var = '';

  page_widget_view.find('[data-role="widgetConfig"] [name]').each(function(index){
    var _name =  $(this).attr('name');
    var _var =  $(this).val()?$(this).val():'';
    widget_var += "'"+_name+"'=>'"+_var+"',";
  });

  var code = "<?php getWidget('"+path+"',array("+widget_var+")) ?>";

  $('#widgetCode').val(code);

  var clipboard = new ClipboardJS('.js-clipboard');

  clipboard.off().on('success', function (e) {
    $(e.trigger)
      $.notify({message: '클립보드 복사완료!'},{type: 'default'});
    e.clearSelection()
  })

  clipboard.on('error', function (e) {
    var modifierKey = /Mac/i.test(navigator.userAgent) ? '\u2318' : 'Ctrl-'
    var fallbackMsg = 'Press ' + modifierKey + 'C to copy'

    $(e.trigger)
      .attr('title', fallbackMsg)
      .attr('title', 'Copy to clipboard')
  })
});

//게시판 선택시
$(document).on('change','[data-role="widgetConfig"] [name="bid"]',function(){
  var name = $(this).find('option:selected').attr('data-name');
  var link = $(this).find('option:selected').attr('data-link');
  var id = $(this).find('option:selected').val();
  if (id) {
    page_widget_view.find('[data-role="widgetConfig"]').find('[name="title"]').val(name);
    page_widget_view.find('[data-role="widgetConfig"]').find('[name="link"]').val(link);
  } else {
    page_widget_view.find('[data-role="widgetConfig"]').find('[name="title"]').val('');
    page_widget_view.find('[data-role="widgetConfig"]').find('[name="link"]').val('');
  }
});

//포스트 카테고리 선택시
$(document).on('change','[data-role="widgetConfig"] [name="cat"]',function(){
  var category = $(this).find('option:selected').attr('data-category');
  if (category) {
    page_widget_view.find('[data-role="widgetConfig"]').find('[name="title"]').val(category);
  } else {
    page_widget_view.find('[data-role="widgetConfig"]').find('[name="title"]').val('');
  }
});

page_widget_makebbs.on('show.rc.page', function (event) {
  var page = $(this)
  page.find('input').val('');
  page.find('.input-row').removeClass('active');

})

page_widget_makelist.on('show.rc.page', function (event) {
  var page = $(this)
  page.find('input').val('');
  page.find('.input-row').removeClass('active');
})

page_widget_makebbs.on('click','[data-act="submit"]',function() {
  var page = page_widget_makebbs;
  var button = $(this);
  var id = page.find('[name="id"]').val();
  var name = page.find('[name="name"]').val();
  if (!id) {
    page.find('[name="id"]').focus().addClass('is-invalid');
    page.find('[name="id"]').nextAll('.invalid-tooltip').text('게시판 아이디를 입력해주세요.')
    return false
  }

  //아이디 유용성 체크
  if (!chkIdValue(id)) {
    page.find('[name="id"]').focus().addClass('is-invalid');
    page.find('[name="id"]').nextAll('.invalid-tooltip').text('영문 또는 숫자를 사용해주세요.')
    return false
  }

  if (!name) {
    page.find('[name="name"]').focus().addClass('is-invalid');
    page.find('[name="name"]').nextAll('.invalid-tooltip').text('게시판 이름을 입력해주세요.')
    return false
  }

  button.attr('disabled',true);
  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=bbs&a=makebbs',{
      id : id,
      name : name,
      m_layout : 'rc-starter/blank-drawer.php',
      send_mod : 'ajax'
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;

          if (error=='id_exists') {
            page.find('[name="id"]').focus().addClass('is-invalid');
            page.find('[name="id"]').nextAll('.invalid-tooltip').text('이미 같은 아이디의 게시판이 존재합니다.');
            button.attr('disabled',false);
            return false
          }

          history.back();
          page_widget_view.find('[name="bid"]').append('<option value="'+id+'" data-name="'+name+'" data-link="/b/'+id+'">ㆍ '+name+'('+id+')</option>');
          page_widget_view.find('[name="bid"]').val(id).attr('selected','selected');
          page_widget_view.find('[name="title"]').val(name);
          page_widget_view.find('[name="link"]').val('/b/'+id);

        } else {
          button.attr('disabled',false);
          alert('다시 시도해 주세요.')
          return false
        }
      });

  }, 500);
})

page_widget_makebbs.find('input').keyup(function() {
	$(this).removeClass('is-invalid');
  page_widget_makebbs.find('.invalid-tooltip').text('')
});

page_widget_makelist.find('input').keyup(function() {
	$(this).removeClass('is-invalid');
  page_widget_makelist.find('.invalid-tooltip').text('')
});

page_widget_makelist.on('click','[data-act="submit"]',function() {
  var page = page_widget_makelist;
  var button = $(this);
  var name = page.find('[name="name"]').val();

  if (!name) {
    page.find('[name="name"]').focus().addClass('is-invalid');
    page.find('[name="name"]').nextAll('.invalid-tooltip').text('리스트명을 입력해주세요.')
    return false
  }

  button.attr('disabled',true);
  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=post&a=regis_list',{
      display : 3,
      name : name,
      send_mod : 'ajax'
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;
          var id=result.id;

          if (error=='name_exists') {
            page.find('[name="name"]').focus().addClass('is-invalid');
            page.find('[name="name"]').nextAll('.invalid-tooltip').text('이미 같은 이름의 리스트가 존재합니다.');
            button.attr('disabled',false);
            return false
          }

          history.back();
          page_widget_view.find('[name="listid"]').append('<option value="'+id+'">ㆍ '+name+'</option>');
          page_widget_view.find('[name="listid"]').val(id).attr('selected','selected');

        } else {
          button.attr('disabled',false);
          alert('다시 시도해 주세요.')
          return false
        }
      });

  }, 500);
})

page_widget_makebbs.on('hide.rc.page', function (event) {
  var page = $(this)
  page.find('input').blur();
  page.find('[data-act="submit"]').attr('disabled',false);
  page.find('input').removeClass('is-invalid');
  page.find('.invalid-tooltip').text('')
})

page_widget_makelist.on('hide.rc.page', function (event) {
  var page = $(this)
  page.find('input').blur();
  page.find('[data-act="submit"]').attr('disabled',false);
  page.find('input').removeClass('is-invalid');
  page.find('.invalid-tooltip').text('')
})

$(document).find('[data-role="widgetPage"]').on('tap','[data-act="remove"]',function(e){
  e.preventDefault();
  $(this).closest('.card').remove();
  // resetPage();
});

$(document).find('[data-role="widgetPage"]').on('tap','[data-act="edit"]',function(e) {
  var item =  $(this).closest('[data-role="item"]')
  var id = item.attr('id');
  var name = item.attr('data-name');
  var path = item.attr('data-path');
  var wdgvar = item.find('[name="widget_members[]"]').val();
  var area;
  setWidgetConfig(id,name,path,wdgvar,area)
  page_widget_list.find('[data-role="widgetPage"] [data-role="item"]').removeClass('active shadow-sm');
  page_widget_view.find('[data-role="widgetConfig"]').attr('data-id',id);
  page_widget_list.find('[data-role="addWidget"]').removeClass('active');
  item.addClass('active shadow-sm');
});

modal_widget_selector.on('show.rc.modal', function (e) {
  var modal = $(this);
  var button = $(e.relatedTarget);
  var area = button.attr('data-area');

  //상태 초기화
  modal.find('select').prop('selectedIndex',0).removeAttr('data-area');
  modal.find('[data-role="none"]').removeClass('d-none');
  modal.find('[data-role="readme"]').addClass('d-none');
  modal.find('[data-role="thumb"]').addClass('d-none');
  modal.find('.bar-tab').addClass('d-none');

  resetPage();
  setTimeout(function(){ modal.find('[name="widget_selector"]').attr('data-area',area).trigger('focus'); }, 100);

})

modal_widget_selector.find('[name="widget_selector"]').change(function(){
  var modal = $('#modal-widget-selector');
  var path =  $(this).val();
  var name = $(this).find('option:selected').text();
  var id = randomId();
  var area = $(this).attr('data-area');
  var wdgvar = '';
  var button = $('#modal-widget-selector').find('[data-act="apply"]');

  if (path) $('#modal-widget-selector').find('.bar-tab').removeClass('d-none');
  else $('#modal-widget-selector').find('.bar-tab').addClass('d-none');

  modal.find('[data-role="none"]').removeClass('d-none');
  modal.find('[data-role="thumb"]').addClass('d-none').removeClass('animated fadeIn');;
  modal.find('[data-role="thumb"] img').attr('src','');
  modal.find('[data-role="readme"]').html('');

  button.attr('data-path',path);
  button.attr('data-name',name);
  button.attr('data-id',id);
  button.attr('data-area',area);

  $.post(rooturl+'/?r='+raccount+'&m=site&a=get_widgetGuide',{
    widget : path
   },function(response,status){
      if(status=='success'){
        var result = $.parseJSON(response);
        var readme=result.readme;
        var thumb=result.thumb;

        modal.find('[data-role="readme"]').html(readme).removeClass('d-none');

        if (!thumb) {
          modal.find('[data-role="none"]').removeClass('d-none');
          modal.find('[data-role="thumb"]').addClass('d-none');
        } else {
          modal.find('[data-role="none"]').addClass('d-none');
          modal.find('[data-role="thumb"]').removeClass('d-none').addClass('animated fadeIn');
          modal.find('[data-role="thumb"] img').attr('src',thumb);
        }

      } else {
        alert('위젯설정을 확인해주세요.')
        return false
      }
    });

});

modal_widget_selector.find('[data-act="apply"]').click(function(){

  var button = $(this)
  var path =  button.attr('data-path');
  var name = button.attr('data-name');
  var id = button.attr('data-id');
  var area = button.attr('data-area');
  var wdgvar = '';
  var modal = $('#modal-widget-selector');

  if (!path) {
    modal.find('[name="widget_selector"]').focus();
    return false;
  }

  history.back();

  setTimeout(function(){
    $('#page-widget-view [data-role="form"]').html('');
    $('#page-widget-list [data-role="item"]').removeClass('active shadow-sm')

    if (path) {
      setWidgetConfig(id,name,path,wdgvar,area)
      $('#page-widget-list [data-role="widgetPage"][data-area="'+area+'"] [data-role="addWidget"]').addClass('active');
    } else {
      $('#page-widget-view [data-role="widgetConfig"]').addClass('d-none');
    }
  }, 10);
});

modal_widget_selector.on('hidden.rc.modal', function (event) {
  var modal = $(this)
  var button = modal.find('[data-act="submit"]');
  var selector =  modal.find('[name="widget_selector"]');
  button.removeAttr('data-path').removeAttr('data-id').removeAttr('data-area').removeAttr('data-name');
  selector.removeAttr('data-area');
  modal.find('[name="widget_selector"]').prop('selectedIndex',0);
  modal.find('[data-role="readme"]').html('');
  modal.find('[data-role="thumb"]').attr('src','')

  $('[data-role="addWidget"]').removeClass('active');
})

sheet_layoutreset_confirm.find('[data-reset="main"]').click(function(){
  var page = page_widget_list.find('[name="page"]').val();
  var area = page_widget_list.find('[name="area"]').val();
  history.back(); //sheet 내림
  setTimeout(function(){
    page_widget_list.find('[data-role="widgetPage"]').loader({ position: 'inside' });
    $.post(rooturl+'/?r='+raccount+'&m=site&a=deletelayoutpage',{
      page : page,
      area : area
     },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;
          var list=result.list;
          if (!error) {
            page_widget_list.find('[data-role="widgetPage"]').html(list).addClass('animated fadeInUp delay-3');
            page_widget_list.find('[data-role="reset"]').addClass('d-none')
          }
        } else {
          alert('다시시도 해주세요.')
          return false
        }
      });

  }, 300);

});
