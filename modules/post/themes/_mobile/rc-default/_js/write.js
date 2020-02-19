function setPostWrite(settings) {
  var wrapper = settings.wrapper;
  var uid=settings.uid;
  if (!uid) var uid=wrapper.attr('data-uid');

  // 상태 초기화
  wrapper.find('[name="uid"]').val('');
  wrapper.find('[data-role="display_label"]').text(uid?'':'전체공개');
  popover_post_display.find('[data-toggle="display"] .badge').empty();
  popover_post_display.find('[data-toggle="display"][data-display="5"] .badge').html('<span class="icon icon-check"></span>');
  wrapper.find('[name="display"]').val(5);
  wrapper.find('[name="category_members"]').val('');
  wrapper.find('[name="list_members"]').val('');
  wrapper.find('[name="upload"]').val('');
  wrapper.find('[name="member"]').val('');
  wrapper.find('[name="featured_img"]').val('');
  wrapper.find('[name="review"]').val('');
  wrapper.find('[name="format"]').val(1);
  wrapper.find('[name="dis_rating"]').val(0);
  wrapper.find('[name="dis_like"]').val(0);
  wrapper.find('[name="dis_comment"]').val(0);
  wrapper.find('[name="dis_listadd"]').val(0);
  wrapper.find('[name="goods"]').val('');
  wrapper.find('[data-role="linkNum"]').text('');
  //wrapper.find('[data-role="attach-preview-photo"]').html('');
  wrapper.find('[data-role="attach-preview-link"]').html('');
  wrapper.find('[data-role="linkadd_input"]').val('');
  wrapper.find('[data-toggle="switch"][data-role="dis_like"]').addClass('active');
  wrapper.find('[data-toggle="switch"][data-role="dis_comment"]').addClass('active');
  wrapper.find('[data-toggle="switch"][data-role="dis_listadd"]').addClass('active');
  wrapper.find('.switch-handle').removeAttr("style");
  wrapper.find('[data-toggle="collapse"]').addClass('collapsed');
  wrapper.find('.collapse').removeClass('in');
  wrapper.find('[data-role="goodsNum"]').text('');

  wrapper.find('[name="uid"]').val(uid);
  autosize.destroy(wrapper.find('[data-plugin="autosize"]'));

  setTimeout(function(){

    // 미디어셋 초기화
    wrapper.find('[data-role="attach-files"]').RbUploadFile(post_upload_settings); // 아작스 폼+input=file 엘리먼트 세팅
    wrapper.find('[data-role="attach-files"]').RbAttachTheme(post_attach_settings);
    wrapper.find('[data-sortable="mediaset"]').sortable({
      axis: 'y',
      cancel: 'button',
      delay: 250,
      update: function( event, ui ) {
        var attachfiles=wrapper.find('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
        var new_upfiles='';
        if(attachfiles){
          for(var i=0;i<attachfiles.length;i++) {
            new_upfiles+=attachfiles[i];
          }
        }
        $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=modifygid',{
           attachfiles : new_upfiles
         })
      }
    });

    // 에디터 초기화
    DecoupledEditor
      .create( document.querySelector( '[data-role="write"] [data-role="editor-body"]' ),{
        placeholder: '본문 입력...',
        toolbar: [ 'alignment:left','alignment:center','bulletedList','blockQuote','imageUpload','insertTable','undo'],
        removePlugins: [ 'ImageToolbar', 'ImageCaption', 'ImageStyle',,'WordCount' ],
        image: {},
        language: 'ko',
        extraPlugins: [rbUploadAdapterPlugin],
        table: {
          contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
        },
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
            'quotes',
            'typography',
            ],
            extra: [
              // Add some custom transformations – e.g. for emojis.
              { from: ':)', to: '🙂' },
              { from: ':+1:', to: '👍' },
              { from: ':tada:', to: '🎉' }
            ],
          }
        }
      } )
      .then( newEditor => {
        console.log('editor_post init');

        editor_post = newEditor;
        wrapper.find('.toolbar-container').html(editor_post.ui.view.toolbar.element)
        editor_post.editing.view.document.on( 'change:isFocused', ( evt, name, value ) => {
          if (value) {
            console.log('editor_post focus');
            wrapper.addClass('editor-focused');
          } else {
            console.log('editor_post blur');
            wrapper.removeClass('editor-focused');
          }
        } );

        $.post(rooturl+'/?r='+raccount+'&m=post&a=get_category',{
          uid : uid
        },function(response,status){
           if(status=='success'){
             var result = $.parseJSON(response);
             var category_tree=result.category_tree;
             page_post_edit_category.find('[data-role="box"]').html(category_tree);
           } else {
             alert(status);
           }
        });

        if (uid) {
          $.post(rooturl+'/?r='+raccount+'&m=post&a=get_postWrite',{
            uid : uid
           },function(response,status){
              if(status=='success'){
                var result = $.parseJSON(response);
                var featured=result.featured;
                var featured_img=result.featured_img;
                var upload=result.upload;
                var display=result.display;
                var display_label=result.display_label;
                var format=result.format;
                var time=result.time;
                var subject=result.subject;
                var review=result.review;
                var tag=result.tag;
                var content=result.content;
                var nic=result.nic;
                var isperm=result.isperm;
                var linkurl=result.linkurl;
                var listCollapse=result.listCollapse;
                var dis_like = result.dis_like;
                var dis_comment = result.dis_comment;
                var dis_listadd = result.dis_listadd;
                var goods = result.goods;
                var linkNum = result.linkNum;
                var attachNum = result.attachNum;
                var goodsNum = result.goodsNum;
                var attachFileTheme = result.theme_attachFile;

                wrapper.find('[data-role="display_label"]').text(display_label);
                popover_post_display.find('[data-toggle="display"] .badge').empty();
                popover_post_display.find('[data-toggle="display"][data-display="'+display+'"] .badge').html('<span class="icon icon-check"></span>');
                wrapper.find('[name="display"]').val(display);

                wrapper.find('[data-role="subject"]').val(subject);
                wrapper.find('[data-role="time"]').text(time);
                wrapper.find('[data-role="featured"]').attr('src',featured);
                wrapper.find('[name="featured_img"]').val(featured_img);
                wrapper.find('[name="upload"]').val(upload);
                wrapper.find('[name="review"]').val(review);
                wrapper.find('[name="tag"]').val(tag);
                wrapper.find('[name="goods"]').val(goods);
                wrapper.find('[name="dis_like"]').val(dis_like);
                wrapper.find('[name="dis_comment"]').val(dis_comment);
                wrapper.find('[name="dis_listadd"]').val(dis_listadd);

                if (featured_img) wrapper.find('.media-left').removeClass('d-none');
                else wrapper.find('.media-left').addClass('d-none');

                if (linkNum) {
                  wrapper.find('[data-role="addlink_guide"]').addClass('d-none');
                  wrapper.find('[data-role="linkNum"]').text(linkNum);
                  wrapper.find('[data-role="attach-preview-link"]').removeClass('hidden').html(link)
                }

                if (attachNum) {
                  $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=getAttachFileList',{
                       p_module : 'post',
                       uid : uid,
                       theme_file : attachFileTheme,
                       mod : 'upload'
                    },function(response){
                     var result = $.parseJSON(response);

                     var photo=result.photo;
                     var video=result.video;
                     var audio=result.audio;
                     var file=result.file;
                     var zip=result.zip;
                     var doc=result.doc;

                     wrapper.find('[name="featured_img"]').val(featured_img); // 대표이미지 셋팅
                     wrapper.find('[data-role="attach-preview-photo"]').html(photo);
                     wrapper.find('[data-role="attach-preview-video"]').html(video)
                     wrapper.find('[data-role="attach-preview-audio"]').html(audio)
                     wrapper.find('[data-role="attach-preview-file"]').html(file)
                     wrapper.find('[data-role="attachNum"]').text(attachNum)
                   });
                } else {
                  $('[data-role="attach_guide"]').removeClass('d-none');
                  wrapper.find('[data-role="attachNum"]').text('');
                }

                if (goodsNum) {
                  wrapper.find('[data-role="goodsNum"]').text(goodsNum);
                }

                editor_post.setData(content);

                wrapper.find('[name="format"]').val(format).prop("selected", true);

                wrapper.find('[data-role="loader"]').addClass('d-none') //로더 제거
                wrapper.find('form').removeClass('d-none')

                if (dis_like) {
                  wrapper.find('[data-toggle="switch"][data-role="dis_like"]').removeClass('active');
                } else {
                  wrapper.find('[data-toggle="switch"][data-role="dis_like"]').addClass('active');
                }

                if (dis_comment) {
                  wrapper.find('[data-toggle="switch"][data-role="dis_comment"]').removeClass('active');
                } else {
                  wrapper.find('[data-toggle="switch"][data-role="dis_comment"]').addClass('active');
                }

                if (dis_listadd) {
                  wrapper.find('[data-toggle="switch"][data-role="dis_listadd"]').removeClass('active');
                } else {
                  wrapper.find('[data-toggle="switch"][data-role="dis_listadd"]').addClass('active');
                }

                wrapper.find('.form-list.floating .input-row').addClass('active');

                autosize(wrapper.find('[data-plugin="autosize"]'));

              } else {
                alert(status);
              }

          });
        } else {
          wrapper.find('[data-role="loader"]').addClass('d-none') //로더 제거
          wrapper.find('form').removeClass('d-none')

          autosize(wrapper.find('[data-plugin="autosize"]'));
        }

      })
      .catch( error => {
          console.error( error );
      } );

  }, 10);

  wrapper.find('.form-list.floating .input-row textarea').on('keyup', function(event) {
    if ($(this).val().length >= 1) {
      $(this).parents('.input-row').addClass('active');
    } else {
      $(this).parents('.input-row').removeClass('active');
    }
  })


  wrapper.find('.switch[data-role="dis_comment"]').on('changed.rc.switch', function () {
    var _switch = $(this);
    if (_switch.hasClass('active')) {
      wrapper.find('[name="dis_comment"]').val(0);
    } else {
      wrapper.find('[name="dis_comment"]').val(1);
    }
  })

  wrapper.find('.switch[data-role="dis_like"]').on('changed.rc.switch', function () {
    var _switch = $(this);
    if (_switch.hasClass('active')) {
      wrapper.find('[name="dis_like"]').val(0);
    } else {
      wrapper.find('[name="dis_like"]').val(1);
    }
  })

  wrapper.find('.switch[data-role="dis_listadd"]').on('changed.rc.switch', function () {
    var _switch = $(this);
    if (_switch.hasClass('active')) {
      wrapper.find('[name="dis_listadd"]').val(0);
    } else {
      wrapper.find('[name="dis_listadd"]').val(1);
    }
  })

  //연결상품 불러오기
  // $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_postAttachGoods',{
  //   markup_file: 'attach_goods_write_item',
  //   uid : uid,
  //   featured_size : '140x104'
  //   },function(response,status){
  //     if(status=='success'){
  //       var result = $.parseJSON(response);
  //       var list=result.list;
  //       page_post_edit_goodslist.find('[data-role="attach-goods"]').html(list);
  //       page_post_edit_goodslist.find('[data-sortable="goods"]').sortable({
  //         axis: 'y',
  //         cancel: 'button',
  //         delay: 250,
  //         update: function( event, ui ) {
  //           var attachGoods=$('input[name="attachGoods[]"]').map(function(){return $(this).val()}).get();
  //           var new_goods='';
  //           if(attachGoods){
  //             for(var i=0;i<attachGoods.length;i++) {
  //               new_goods+=attachGoods[i];
  //             }
  //           }
  //           $.post(rooturl+'/?r='+raccount+'&m=shop&a=modifygid',{
  //              attachfiles : new_goods
  //            })
  //
  //         }
  //       });
  //     } else {
  //       alert(status);
  //     }
  // });

} // getPostWrite

function savePost(f) {

  var editorData = editor_post.getData();
  var after = modal_post_write.attr('data-after');
  var start = modal_post_write.attr('data-start')?modal_post_write.attr('data-start'):'#page-post-allpost';

  // 카테고리 체크
	var cat_sel=page_post_edit_category.find('input[name="tree_members[]"]');
	var cat_sel_n=cat_sel.length;
  var cat_arr=page_post_edit_category.find('input[name="tree_members[]"]:checked').map(function(){return $(this).val();}).get();
	var cat_n=cat_arr.length;

	// if(cat_sel_n>0 && cat_arr==''){
	// 	alert('지정된 카테고리가 없습니다.\n적어도 하나이상의 카테고리를 지정해 주세요.');
  //   $('#advan').tab('show')
	// 	return false;
	// }

  var s='';
  for (var i=0;i <cat_n;i++) {
    if(cat_arr[i]!='')  s += '['+cat_arr[i]+']';
  }

  f.category_members.value = s;


  // 리스트 체크
  var list_sel=modal_post_write.find('input[name="postlist_members[]"]');
  var list_arr=modal_post_write.find('input[name="postlist_members[]"]:checked').map(function(){return $(this).val();}).get();
	var list_n=list_arr.length;
  var l='';
  for (var i=0;i <list_n;i++) {
    if(list_arr[i]!='')  l += '['+list_arr[i]+']';
  }
  modal_post_write.find('input[name="list_members"]').val(l);

  // 대표이미지가 없을 경우, 첫번째 업로드 사진을 지정함
  var featured_img_input = modal_post_write.find('input[name="featured_img"]'); // 대표이미지 input
  var featured_img_uid = $(featured_img_input).val();
  if(featured_img_uid ==0){ // 대표이미지로 지정된 값이 없는 경우
    var first_attach_img_li = modal_post_write.find('[data-role="attach-preview-photo"] li:first'); // 첫번째 첨부된 이미지 리스트 li
    var first_attach_img_uid = modal_post_write.find(first_attach_img_li).attr('data-id');
    featured_img_input.val(first_attach_img_uid);
  }

  // 첨부파일 uid 를 upfiles 값에 추가하기
  var attachfiles=modal_post_write.find('input[name="attachfiles[]"]').map(function(){return $(this).val()}).get();
  var new_upfiles='';
  if(attachfiles){
    for(var i=0;i<attachfiles.length;i++) {
      new_upfiles+=attachfiles[i];
    }
    modal_post_write.find('input[name="upload"]').val(new_upfiles);
  }

  // 공유회원 uid 를 members 값에 추가하기
  var postmembers=modal_post_write.find('input[name="postmembers[]"]').map(function(){return $(this).val()}).get();
  var new_members='';
  if(postmembers){
    for(var i=0;i<postmembers.length;i++) {
      new_members+=postmembers[i];
    }
    modal_post_write.find('input[name="member"]').val(new_members);
  }

  // 첨부상품 uid 를 gooods 값에 추가하기
  var postgoods=$('input[name="attachGoods[]"]').map(function(){return $(this).val()}).get();
  var new_goods='';
  if(postgoods){
    for(var i=0;i<postgoods.length;i++) {
      new_goods+=postgoods[i];
    }
    modal_post_write.find('input[name="goods"]').val(new_goods);
  }

  checkUnload = false;
  $('[data-role="postsubmit"]').attr( 'disabled', true );

  var form = modal_post_write.find('[name="writeForm"]')
  var uid = form.find('[name="uid"]').val();
  var category_members = form.find('[name="category_members"]').val();
  var list_members = form.find('[name="list_members"]').val();
  var member = form.find('[name="member"]').val();
  var upload = form.find('[name="upload"]').val();
  var goods = form.find('[name="goods"]').val();
  var featured_img = form.find('[name="featured_img"]').val();
  var html = form.find('[name="html"]').val();
  var subject = form.find('[name="subject"]').val();
  var display = form.find('[name="display"]').val();
  var format = modal_post_write.find('[name="format"]').val();

  var review = page_post_edit_review.find('[name="review"]').val();
  var tag = page_post_edit_tag.find('[name="tag"]').val();

  var dis_like = form.find('[name="dis_like"]').val();
  var dis_comment = form.find('[name="dis_comment"]').val();
  var dis_listadd = form.find('[name="dis_listadd"]').val();

  if (!subject) {
    $.notify({message: '제목 입력후 저장해 주세요.'},{type: 'default'});
    modal_post_write.find('[data-act="submit"]').attr('disabled',false);
    return false;
  }

  // if (editorData == '') {
  //   $.notify({message: '본문 입력후 저장해 주세요.'},{type: 'default'});
  //   modal_post_write.find('[data-act="submit"]').attr('disabled',false);
  //   return false;
  // }

  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=post&a=write',{
      send_mod : 'ajax',
      content : editorData,
      uid : uid,
      category_members : category_members,
      list_members : list_members,
      member : member,
      upload : upload,
      featured_img : featured_img,
      html : html,
      subject : subject,
      review : review,
      tag : tag,
      format : format,
      goods : goods,
      display : display,
      dis_like : dis_like,
      dis_comment : dis_comment,
      dis_listadd : dis_listadd
      },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;

          if (!error) {
            var d_modify=result.d_modify;

            form.find('[data-role="postsubmit"]').attr( 'disabled', false );
            history.back();
            setTimeout(function(){
              if (uid) {
                $.notify({message: '저장 되었습니다.'},{type: 'default'});
              } else {
                if (display<4) {
                  $('#page-post-mypost').page({ start: start, title : '내 포스트', url : 'dashboard?page=post' });
                }
              }
              // 메인화면 목록 새로불러오기
              getPostAll({
                wrapper : $('[data-role="postFeed"] [data-role="list"]'),
                start : start,
                markup    : 'post-row',  // 테마 > _html > post-row-***.html
                recnum    : 5,
                sort      : 'gid',
                none : $(start).find('[data-role="postFeed"] [data-role="none"]').html(),
                paging : 'infinit'
              })
             }, 300);
          } else {
            history.back();
            setTimeout(function(){
              $.notify({message: error},{type: 'danger'}); // 작성권한 없음
              return false
            }, 300);
          }

        } else {
          alert(status);
        }
    });
  }, 200);
}

function saveTwit(display,content) {

  var start = modal_post_twit.attr('data-start')?modal_post_twit.attr('data-start'):'#page-post-allpost';
  setTimeout(function(){

    $.post(rooturl+'/?r='+raccount+'&m=post&a=write',{
      send_mod : 'ajax',
      content : '',
      subject : content,
      display : display,
      html : 'TEXT'
      },function(response,status){
        if(status=='success'){
          var result = $.parseJSON(response);
          var error=result.error;

          if (!error) {
            history.back(); // 작성모달 내리고
            setTimeout(function(){
              if (display==5) {

                // 메인화면 목록 새로불러오기
                getPostAll({
                  wrapper : $('[data-role="postFeed"] [data-role="list"]'),
                  start : start,
                  markup    : 'post-row',  // 테마 > _html > post-row-***.html
                  recnum    : 5,
                  sort      : 'gid',
                  none : '',
                  paging : 'infinit'
                })

              } else {
                $('#page-post-mypost').page({ start: start });
              }
             }, 300);
          } else {
            history.back();
            setTimeout(function(){
              $.notify({message: error},{type: 'danger'});  // 작성권한 없음
              return false
            }, 300);
          }
        } else {
          alert(status);
        }
    });
  }, 200);
}

function savePostByLink(url,start) {

  $.get('//embed.kimsq.com/oembed',{
      url: url
  }).done(function(response) {
      var type = response.type;
      var title = response.title;
      var description = response.description?response.description:'.';
      var description = linkifyStr(description,{ target: '_blank' });
      var description = description.replace(/(?:\r\n|\r|\n)/g, '<br>');
      var thumbnail_url = response.thumbnail_url;
      var author = response.author;
      var provider = response.provider_name;
      var url = response.url;
      var width = response.thumbnail_width;
      var height = response.thumbnail_height;
      var embed = response.html;

      $('[name="subject"]').val(title);

      if (type=='video') {

        $.get('//embed.kimsq.com/iframely',{
            url: url
        }).done(function(response) {
            var duration = response.meta.duration;
            var _duration = moment.duration(duration, 's');
            var formatted_duration = _duration.format("h:*m:ss");

            $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
               type : 9,
               title : title,
               theme : '_desktop/bs4-default-link',
               description : description,
               thumbnail_url : thumbnail_url,
               author: author,
               provider : provider,
               url : url,
               duration : duration?duration:'',
               time :  duration?formatted_duration:'',
               width : width,
               height : height,
               embed : embed
            },function(response){
                var result=$.parseJSON(response);
                var uid = result.last_uid
                if(!result.error){

                  // 새 포스트 저장
                  var subject = title;
                  var content = description;
                  var upload = '['+uid+']';
                  var featured_img = uid;
                  var format = 2; //비디오 타입
                  var html = 'HTML';

                  $.post(rooturl+'/?r='+raccount+'&m=post&a=write',{
                    send_mod : 'ajax',
                    content : content,
                    upload : upload,
                    featured_img : featured_img,
                    html : html,
                    subject : subject,
                    format : format
                    },function(response,status){
                      if(status=='success'){
                        var result = $.parseJSON(response);
                        var error=result.error;

                        if (!error) {
                          var uid=result.last_uid;
                          var cid=result.last_cid;

                          history.back();
                          modal_post_write.attr('data-uid',uid).attr('data-after','mypost').attr('data-start',start);

                          setTimeout(function(){
                            modal_post_write.modal({
                              title : '포스트 수정',
                              url : '/post/write/'+cid
                            });
                          }, 300);
                        } else {
                          history.back();
                          setTimeout(function(){
                            $.notify({message: error},{type: 'danger'}); // 작성권한 없음
                            return false
                          }, 300);
                        }

                      } else {
                        alert(status);
                      }
                  });

                }
            });

        });

      } else {

        $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
          type : 8,
          title : title,
          saveDir : './files/post/',
          theme : '_desktop/bs4-default-link',
          description : description,
          thumbnail_url : thumbnail_url,
          author: author,
          provider : provider,
          url : url,
          width : width,
          height : height,
          embed : embed
        },function(response){
          var result=$.parseJSON(response);
          var uid = result.last_uid
          if(!result.error){

            // 새 포스트 저장
            var subject = title;
            var content = '<p>'+description+'</p>';
            var upload = '['+uid+']';
            var featured_img = uid;

            if (provider=='Vimeo' || provider=='kakaoTV' || provider=='NAVERTV') {
              var format = 2; //비디오 타입
            } else {
              var format = 1; //문서 타입
            }

            var html = 'HTML';

            $.post(rooturl+'/?r='+raccount+'&m=post&a=write',{
              send_mod : 'ajax',
              content : content,
              upload : upload,
              featured_img : featured_img,
              html : html,
              subject : subject,
              format : format
              },function(response,status){
                if(status=='success'){
                  var result = $.parseJSON(response);
                  var error=result.error;

                  if (!error) {
                    var uid=result.last_uid;
                    var cid=result.last_cid;
                    history.back();
                    modal_post_write.attr('data-uid',uid).attr('data-after','mypost').attr('data-start',start);
                    setTimeout(function(){
                      modal_post_write.modal({
                        title : '포스트 수정',
                        url : '/post/write/'+cid
                      });
                    }, 300);
                  } else {
                    history.back();
                    setTimeout(function(){
                      $.notify({message: error},{type: 'danger'}); // 작성권한 없음
                      return false
                    }, 300);
                  }

                } else {
                  alert(status);
                }
            });

          }
        });
      }

  }).fail(function() {
    $.notify({message: 'URL을 확인해주세요.'},{type: 'default'});
    sheet_post_linkadd.find('[data-act="submit"]').attr('disabled',false );
    textarea.attr('disabled',false).focus()
  }).always(function() {
  });

} // savePostByLink()

page_post_edit_review.on('shown.rc.page', function(event) {
  var page = $(this)
  var textarea = page.find('textarea')
  setTimeout(function(){ textarea.focus() }, 300);
})

page_post_edit_review.on('hidden.rc.page', function(event) {
  var page = $(this)
  var textarea = page.find('textarea')
  textarea.blur()
})

page_post_edit_tag.on('shown.rc.page', function(event) {
  var page = $(this)
  var textarea = page.find('textarea')
  setTimeout(function(){ textarea.focus() }, 300);
})

page_post_edit_tag.on('hidden.rc.page', function(event) {
  var page = $(this)
  var textarea = page.find('textarea')
  textarea.blur()
})

page_post_edit_imageGoodsTag.on('shown.rc.page', function(event) {
  var page = $(this)
  console.log('상품태그 기능추가');
  var swiper = new Swiper('#page-post-edit-imageGoodsTag .swiper-container');
})

page_post_edit_imageGoodsTag.on('hidden.rc.page', function(event) {
  var page = $(this)
  var swiper = new Swiper('#page-post-edit-imageGoodsTag .swiper-container');
  swiper.destroy();
})

page_post_edit_goodslist.on('shown.rc.page', function(event) {
  var page = $(this)
  var input = page.find('[name="keyword"]')
  var uid = modal_post_write.attr('data-uid');
  page.find('[data-role="backdrop"]').addClass('d-none')

  page.find('[data-plugin="autocomplete"]').blur(function(){
    page.find('[data-role="backdrop"]').addClass('d-none')
    $(this).val('');
  });

  page.find('[data-plugin="autocomplete"]').on("change keyup paste", function() {
    var currentVal = $(this).val();
    if (currentVal) {
      page.find('[data-role="backdrop"]').removeClass('d-none')
      page.find('[data-role="keyword-reset"]').removeClass("d-none");

    } else {
      page.find('[data-role="backdrop"]').addClass('d-none');
      page.find('[data-role="keyword-reset"]').addClass("d-none");
    }
  });

  // 검색어 입력필드 초기화
  page.on('click','[data-act="keyword-reset"]',function(){
    page.find('[data-plugin="autocomplete"]').val('') // 입력필드 초기화
    setTimeout(function(){
      page.find('[data-plugin="autocomplete"]').blur().autocomplete('clear');; // 입력필드 포커싱
      page.find('[data-role="keyword-reset"]').addClass("d-none"); // 검색어 초기화 버튼 숨김
    }, 10);
  });


  //상품연결을 위한 상품명 검색
  page.find('[data-plugin="autocomplete"]').autocomplete({
    width : 320,
    minChars:1,
    showNoSuggestionNotice: true,
    noSuggestionNotice : '결과가 없습니다.',
    lookup: function (query, done) {

       $.getJSON(rooturl+"/?m=shop&a=search_data", {q: query,featured_size : '140x104'}, function(res){
           if (res.goodslist) {
             var sg_goods = [];
             var data_arr = res.goodslist.split(',');//console.log(data.usernames);
             $.each(data_arr,function(key,goods){
               var goodsData = goods.split('|');
               var name = goodsData[0];
               var uid = goodsData[1];
               var featured_img = goodsData[2];
               var price = goodsData[3];
               sg_goods.push({"value":name,"data":{ 'uid': uid, 'featured_img': featured_img, 'price': price }});
             });
             var result = {
               suggestions: sg_goods
             };
              done(result);
           }
       });
   },

   formatResult: function (suggestion,currentValue) {
     return '<div class="media"><span class="media-left"><img src="' + suggestion.data.featured_img+'" class="media-object border mr-2" style="width:70px"/></span><div class="media-body" style="line-height: 1.2;"><h6 class="my-0 text-reset line-clamp-2">'  + $.Autocomplete.formatResult(suggestion, currentValue) + '</h6><span class="text-muted f13">'+ suggestion.data.price+'</span></div></div>';
    },

    onSelect: function (suggestion) {
      if (page.find('[data-plugin="autocomplete"]').val().length >= 1) {
        console.log(suggestion.data.uid)
        $(this).val('');
        page.find('[data-role="backdrop"]').addClass('d-none')
        page.find('[data-role="keyword-reset"]').addClass("d-none"); // 검색어 초기화 버튼 숨김
        $.post(rooturl+'/?r='+raccount+'&m=shop&a=get_goodsData',{
            markup_file: 'attach_goods_write_item',
            uid : suggestion.data.uid,
            featured_size : '140x104'
          },function(response){
           var result = $.parseJSON(response);
           var item=result.item;
           page.find('[data-role="attach-goods"]').append(item);
           $.notify({message: '추가 되었습니다.'},{type: 'default'});
        });

      }
    }
  });

})

page_post_edit_goodslist.on('hidden.rc.page', function(event) {
  var page = $(this);
  var input = page.find('[name="keyword"]');
  var goodsNum = page.find('[data-role="item"]').length
  input.val('').blur()
  page.find('[data-plugin="autocomplete"]').autocomplete('dispose');
  page_post_edit_main.find('[data-role="goodsNum"]').text(goodsNum);
})

//연결상품 지우기
page_post_edit_goodslist.find('[data-role="attach-goods"]').on('tap','[data-act="del"]',function(){
  var item = $(this).closest('[data-role="item"]')
  item.remove();
});

page_post_edit_goodsview.on('show.rc.page', function(event) {
  var page = $(this)
  console.log('상품 상세보기')
})
