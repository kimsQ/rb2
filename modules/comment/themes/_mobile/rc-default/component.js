// 댓글

var popup_comment_mypost = $('#popup-comment-mypost');
var sheet_comment_online = $('#sheet-comment-online'); //답글(oneline)보기
var sheet_comment_write = $('#sheet-comment-write');


//댓글쓰기 컴포넌트가 호출
$(document).on('click','[data-role="comment_box"] [data-toggle="commentWrite"]',function(){
  if (memberid) {
    var type = $(this).attr('data-type');
    var parent = $(this).attr('data-parent');
    var uid = $(this).attr('data-uid');
    var act = $(this).attr('data-act');
    sheet_comment_write.find('[data-kcact="regis"]').attr('data-type',type).attr('data-parent',parent).attr('data-act',act);
    setTimeout(function(){sheet_comment_write.sheet();}, 10);
  } else {
    $('#modal-login').modal();
  }
  return false;
});

$(document).on('click','[data-role="comment_box"] [data-role="toggle-oneline-input"]',function(){
  if (memberid) {
    var type = $(this).attr('data-type');
    var parent = $(this).attr('data-parent');
    var uid = $(this).attr('data-uid');
    var act = $(this).attr('data-act');
    sheet_comment_write.find('[data-kcact="regis"]').attr('data-type',type).attr('data-parent',parent).attr('data-act',act);
    setTimeout(function(){sheet_comment_write.sheet();}, 10);
  } else {
    $('#modal-login').modal();
  }
  return false;
});

$(document).on('click','.sheet [data-role="toggle-oneline-input"]',function(){
  if (memberid) {
    $(document).find('[data-role="comment_box"] [data-role="toggle-oneline-input"]').click();
  } else {
    $('#modal-login').modal();
  }
  return false;
});


$(document).on('click','#popup-comment-mypost .table-view-cell a',function(event){
  event.preventDefault();
  event.stopPropagation();
  var button = $(this);
  var uid = button.attr('data-uid');
  var type = button.attr('data-type');
  var parent = button.attr('data-parent');
  var toggle = button.attr('data-toggle');
  var kcact = button.attr('data-kcact');
  var act = button.attr('data-act');
  var hidden =  button.attr('data-hidden');

  history.back() // popup 닫기

  // console.log(toggle)
  setTimeout(function() {
    if (toggle) {
      if (act=='edit') {
        console.log('댓글 수정모드');
        var content = $('[data-role="comment_box"]').find('[data-role="'+type+'-origin-content-'+uid+'"]').html();
        $('[data-role="comment_box"]').find('[data-toggle="edit"][data-type="'+type+'"][data-uid="'+uid+'"]').click();
        sheet_comment_write.sheet();
        setTimeout(function(){
          sheet_comment_write.attr('data-uid',uid).attr('data-type',type);
          InserHTMLtoEditor(editor_sheet,content);
          sheet_comment_write.find('[data-kcact="regis"]').attr('data-type',type).attr('data-uid',uid).attr('data-act',act).attr('data-hidden',hidden);;
          if(hidden=='true') {
            sheet_comment_write.find('[data-role="comment-hidden"]').addClass('active');
          }
        }, 10);

      } else {
        $(document).find('[data-role="comment_box"] [data-role="'+type+'-item"][data-uid="'+uid+'"] [data-toggle="'+toggle+'"]').click()
      }

    } else {
      $(document).find('[data-role="comment_box"] [data-role="menu-container-'+type+'"] [data-uid="'+uid+'"][data-kcact="'+kcact+'"]').click()
    }
  }, 100);
});


//댓글 저장버튼 클릭
sheet_comment_write.find('[data-kcact="regis"]').click(function(event) {

  if (!$(this).hasClass("active")) {
    $.notify({message: '내용을 입력해주세요.'},{type: 'default'});
    editor_sheet.editing.view.focus();
    return false
  }

  sheet_comment_write.find('fieldset').prop('disabled', true);
  $(this).addClass('fa-spin');

  var type = $(this).attr('data-type');
  var parent = $(this).attr('data-parent');
  var uid = $(this).attr('data-uid');
  var act = $(this).attr('data-act');
  var hidden = $(this).attr('data-hidden');
  var content = editor_sheet.getData();

  setTimeout(function(){

    if (type=='comment' && act=='regis') {
      const commentRegisEditor = document.querySelector( '[data-role="comment_box"] .ck-editor__editable' );
      const commentRegisEditorInstance = commentRegisEditor.ckeditorInstance;
      commentRegisEditorInstance.setData(content);
      $('[data-role="comment_box"] [data-role="comment-input-wrapper"]').find('[data-kcact="regis"]').attr('data-hidden',hidden).click();
    }

    if (type=='oneline' && act=='regis') {
      const onelineRegisEditor = document.querySelector( '[data-role="oneline-input-wrapper-'+parent+'"] .ck-editor__editable' );
      const onelineRegisEditorInstance = onelineRegisEditor.ckeditorInstance;
      onelineRegisEditorInstance.setData(content);
      $('[data-role="oneline-input-wrapper-'+parent+'"]').find('[data-kcact="regis"]').attr('data-hidden',hidden).click();
    }

    if (type=='comment' && act=='edit') {

      console.log('comment 수정 실행')
      const commentRegisEditor = document.querySelector( '[data-role="comment_box"] [data-role="comment-item"] .ck-editor__editable' );
      const commentRegisEditorInstance = commentRegisEditor.ckeditorInstance;
      commentRegisEditorInstance.setData(content);
      $('[data-role="comment_box"]').find('[data-kcact="edit"][data-uid="'+uid+'"]').attr('data-hidden',hidden).click();
    }

    if (type=='oneline' && act=='edit') {

      console.log('oneline 수정 실행')
      const commentRegisEditor = document.querySelector( '[data-role="comment_box"] [data-role="oneline-item"][data-uid="'+uid+'"] .ck-editor__editable' );
      const commentRegisEditorInstance = commentRegisEditor.ckeditorInstance;
      commentRegisEditorInstance.setData(content);
      $('[data-role="comment_box"]').find('[data-kcact="edit"][data-type="oneline"][data-uid="'+uid+'"]').attr('data-hidden',hidden).click();
    }
  }, 600);

});

//댓글쓰기 컴포넌트가 호출될때
sheet_comment_write.on('shown.rc.sheet', function (e) {
  setTimeout(function(){
    DecoupledEditor
    .create( document.querySelector('#sheet-comment-write [data-role="comment-input"]'),{
      placeholder: '공개 댓글 추가...',
      toolbar: [ 'bold','italic','bulletedList','numberedList','blockQuote','imageUpload','|','undo','redo'],
      language: 'ko',
      extraPlugins: [rbUploadAdapterPlugin],
      mediaEmbed: {
          extraProviders: [
              {
                  name: 'other',
                  url: /^([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)/
              },
              {
                  name: 'another',
                  url: /^([a-zA-Z0-9_\-]+)\.([a-zA-Z0-9_\-]+)/
              }
          ]
      },
      typing: {
          transformations: {
              include: [
                  // Use only the 'quotes' and 'typography' groups.
                  'quotes',
                  'typography',

                  // Plus, some custom transformation.
                  { from: '->', to: '→' },
                  { from: ':)', to: '🙂' },
                  { from: ':+1:', to: '👍' },
                  { from: ':tada:', to: '🎉' },
              ],
          }
      },
      removePlugins: [ 'WordCount' ],
      image: {}
    } )
    .then( newEditor => {
      editor_sheet = newEditor;
      console.log('editor_sheet init');
      editor_sheet.editing.view.focus();
      sheet_comment_write.find('.toolbar-container').html(editor_sheet.ui.view.toolbar.element)
      $('[data-role="commentWrite-container"]').removeClass('active');
      sheet_comment_write.find('[data-placeholder]').addClass('ck-placeholder');

      editor_sheet.editing.view.document.on( 'change:isFocused', ( evt, name, value ) => {
        if (value) {
          console.log('editor_comment focus');
          $('[data-role="commentWrite-container"]').addClass('active');
        } else {
          console.log('editor_comment blur');
        }
      } );

      editor_sheet.model.document.on( 'change:data', () => {
        var content = editor_sheet.getData();
        if (content) {
          sheet_comment_write.find('[data-kcact="regis"]').addClass('active');
          $('[data-role="commentWrite-container"]').addClass('active');
          sheet_comment_write.find('[data-placeholder]').removeClass('ck-placeholder');
        } else {
          sheet_comment_write.find('[data-kcact="regis"]').removeClass('active');
          sheet_comment_write.find('[data-placeholder]').addClass('ck-placeholder');
        }
      } );

    })
    .catch( error => {
        console.error( error );
    } );

    $('[data-role="comment-box"] [data-role="commentWrite-container"]').css('opacity','.2');

    sheet_comment_write.find('[data-role="comment-hidden"]').off('changed.rc.switch').on('changed.rc.switch', function () {
      if ($(this).hasClass("active")) {
        console.log('비밀글 ON')
        sheet_comment_write.find('[data-kcact="regis"]').attr('data-hidden','true');
      } else {
        console.log('비밀글 OFF')
        sheet_comment_write.find('[data-kcact="regis"]').attr('data-hidden','false');
      }
    })
  }, 200);
})

sheet_comment_write.on('hidden.rc.sheet', function (e) {

  editor_sheet.setData('');
  console.log('editor_sheet empty')
  editor_sheet.destroy();
  console.log('editor_sheet destroy')
  sheet_comment_write.find('[data-kcact="regis"]').removeClass('active');
  sheet_comment_write.find('fieldset').prop('disabled', false);
  sheet_comment_write.find('[data-kcact="regis"]').removeClass('fa-spin').attr('data-type','').attr('data-parent','').attr('data-act','').attr('data-hidden','');
  $('[data-role="comment-box"] [data-role="commentWrite-container"]').css('opacity','1')
  $('#sheet-comment-write-toolbar').collapse('hide');

  // 비밀글 옵션 초기화
  sheet_comment_write.find('[data-role="comment-hidden"]').removeClass('active');
  sheet_comment_write.find('[data-role="comment-hidden"] .switch-handle').removeAttr('style');

  var uid = sheet_comment_write.attr('data-uid');
  var type = sheet_comment_write.attr('data-type');

  sheet_comment_write.removeAttr('data-uid').removeAttr('data-type')

  if (uid && type) {
    $('body').removeClass('comment-editmod');
    console.log(type+' 수정모드 해제')
  }

  const onelineRegisEditor = document.querySelector( '[data-role="comment-item"] .ck-editor__editable' );
  if (onelineRegisEditor) {
    const onelineRegisEditorInstance = onelineRegisEditor.ckeditorInstance;
    onelineRegisEditorInstance.destroy();
  }
})

popup_comment_mypost.on('show.rc.popup', function (e) {
  var button = $(e.relatedTarget);
  var uid = button.attr('data-uid');
  var type = button.attr('data-type');
  var parent = button.attr('data-parent');
  var notice = button.closest('[data-role="'+type+'-item"]').attr('data-notice');
  var hidden = button.closest('[data-role="'+type+'-item"]').attr('data-hidden');
  var popup = $(this);

  popup.find('[data-role="comment_box"]').removeClass('d-none');
  if (type=='oneline') popup.find('[data-role="comment_box"]').addClass('d-none');

  if (notice=="true") popup.find('[data-kcact="notice"] span').text('해제')
  else popup.find('[data-kcact="notice"] span').text('')

  if (hidden=="true") popup.find('[data-act="edit"]').attr('data-hidden','true');
  else popup.find('[data-act="edit"]').attr('data-hidden','false');

  popup.find('.table-view-cell a').attr('data-uid',uid);
  popup.find('.table-view-cell a').attr('data-type',type)
})

// 답글(oneline)보기
sheet_comment_online.on('show.rc.sheet', function(event) {
  var sheet = $(this);
  var button = $(event.relatedTarget);
  var top = button.closest('.content').css('padding-top');
  var comment_item = button.closest('[data-role="comment-item"]').clone().wrapAll("<div/>").parent().html();
  sheet.css('top',top);
  sheet.find('[data-role="list"]').loader({ position: 'inside' });
  setTimeout(function(){ sheet.find('[data-role="list"]').html(comment_item); }, 300);
})
