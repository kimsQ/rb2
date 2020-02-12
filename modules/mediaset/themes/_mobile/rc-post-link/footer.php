
<script>

$(document).ready(function() {

  var sheet = $('#sheet-post-linkadd');

  sheet.on('click','[data-act="saveLink"]',function(){
    var container = '#modal-post-write';
    var button = $(this);
    var input = sheet.find('input');
  	var url = input.val();
    var linkNum = Number($(container).find('[data-role="linkNum"]').text());

    if (!url) {
      input.focus()
      return false
    }

    var link_url_parse = $('<a>', {href: url});

    //네이버 블로그 URL의 실제 URL 변환
    if ((link_url_parse.prop('hostname')=='blog.naver.com' || link_url_parse.prop('hostname')=='m.blog.naver.com' ) && link_url_parse.prop('pathname')) {
      var nblog_path_arr = link_url_parse.prop('pathname').split("/");
      var nblog_id = nblog_path_arr[1];
      var nblog_pid = nblog_path_arr[2];
      if (nblog_pid) {
        var url =  'https://blog.naver.com/PostView.nhn?blogId='+nblog_id+'&logNo='+nblog_pid;
      } else {
        var url = 'https://blog.naver.com/PostList.nhn?blogId='+nblog_id;
      }
    }

    button.attr('disabled',true)

  	$.get('//embed.kimsq.com/oembed',{
  			url: url
  	}).done(function(response) {
        var type = response.type;
  			var title = response.title;
        var description = response.description;
        var thumbnail_url = response.thumbnail_url;
        var author = response.author;
        var provider = response.provider_name;
        var url = response.url;
        var width = response.thumbnail_width;
        var height = response.thumbnail_height;
        var embed = response.html;

  			sheet.find('[data-role="title"]').text(title);
        sheet.find('[data-role="description"]').text(description);
        sheet.find('[data-role="thumbnail"]').attr('src',thumbnail_url);
        sheet.find('[data-act="insert"]').attr('data-url',url).attr('data-title',title).attr('data-description',description).attr('data-thumbnail',thumbnail_url).attr('data-provider',provider);

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
                 theme : '_mobile/rc-post-link',
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
                  if(!result.error){
                    history.back();
                    $(container).find('[data-role="attach-preview-link"]').append(result.list);
                    setTimeout(function(){ $.notify("링크가 추가 되었습니다."); }, 300);
                    $(container).find('[data-role="linkNum"]').text(linkNum+1);
                  }
              });

        	});

        } else {

          $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
            type : 8,
            title : title,
            theme : '_mobile/rc-post-link',
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
              if(!result.error){
                history.back();
                $(container).find('[data-role="attach-preview-link"]').append(result.list);
                setTimeout(function(){ $.notify("링크가 추가 되었습니다."); }, 300);
                $(container).find('[data-role="linkNum"]').text(linkNum+1);
              }
          });

        }


  	}).fail(function() {
      alert( "URL을 확인해주세요." );
    }).always(function() {
      input.val('')
      button.attr('disabled',false)
    });

  });

  $('body').on('tap','[data-act="sheet"][data-target="#sheet-attach-moreAct"][data-mod="link"]',function(){
    var button = $(this);
    var target = button.attr('data-target');
    var type = button.attr('data-type');
    var title = button.attr('data-title');

    var uid = button.attr('data-id');
    var type = button.attr('data-type');
    var showhide = button.attr('data-showhide');
    var name = button.attr('data-name');
    var insert_text = button.attr('data-insert');
    var sheet = $('#sheet-attach-moreAct');
    $('#attach-files-backdrop').removeClass('hidden');
    sheet.find('[data-role="insert_text"]').val(insert_text);
    sheet.find('[data-attach-act="featured-img"]').attr('data-id',uid).attr('data-type',type).attr('data-mod','link');
    sheet.find('[data-attach-act="showhide"]').attr('data-id',uid).attr('data-content',showhide).attr('data-mod','link');
    sheet.find('[data-attach-act="delete"]').attr('data-id',uid).attr('data-type',type).attr('data-mod','link');

    if (type!='photo') { // 이미지가 아닐 경우
      sheet.find('[data-attach-act="featured-img"]').closest('.table-view-cell').addClass('hidden');  // 대표이미지 항목 숨김처리함
    } else {
      sheet.find('[data-attach-act="featured-img"]').closest('.table-view-cell').removeClass('hidden');  // 대표이미지 항목 숨김처리함
    }
    $(target).sheet({
      title : title
    });
  });


})
</script>
