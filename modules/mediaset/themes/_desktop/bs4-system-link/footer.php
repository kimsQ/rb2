<?php
  // 모달 페이지 인클루드
  include $g['dir_attach_theme'].'/modals.php';

  getImport('moment','moment','2.22.2','js');
  getImport('moment-duration-format','moment-duration-format','2.2.2','js');

?>

<script>

$(document).ready(function() {

  var clipboard = new ClipboardJS('[data-link-act="clipboard"]');

  $('[data-link-act="insert"]').tooltip({
    trigger: 'hover',
    title : '본문삽입'
  });
  $('[data-attach-act="clipboard"]').tooltip({
    trigger: 'hover',
    title : '클립보드 복사'
  });
  $('[data-link-act="clipboard"]').tooltip();

  $('body').on('click','[data-link-act="insert"]',function(){
     $(this).attr('data-original-title', '삽입 되었습니다.')
     $(this).tooltip('show');
     $(this).attr('data-original-title', '본문삽입')
  });

  $('body').on('click','[data-link-act="clipboard"]',function(){
     $(this).attr('data-original-title', '복사 되었습니다.')
     $(this).tooltip('show');
     $(this).attr('data-original-title', '')
  });


  var check_url = $('#check_url');
  var iframe_api_key = 'ad515293314b53d30d0e94';

  check_url.find(".btn").click(function(){
    var container = '#attach_link'
    var fieldset = check_url
    var textarea = check_url.find('textarea')
  	var url = textarea.val()

    if (!url) {
      textarea.focus()
      return false
    }

    fieldset.attr('disabled',true)

  	$.get('//embed.kimsq.com/oembed',{
  			api_key : iframe_api_key,
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
  			check_url.find('[data-role="title"]').text(title);
        check_url.find('[data-role="description"]').text(description);
        check_url.find('[data-role="thumbnail"]').attr('src',thumbnail_url);
        check_url.find('[data-act="insert"]').attr('data-url',url).attr('data-title',title).attr('data-description',description).attr('data-thumbnail',thumbnail_url).attr('data-provider',provider);

        if (type=='video') {

          $.get('//embed.kimsq.com/iframely',{
        			api_key : iframe_api_key,
        			url: url
        	}).done(function(response) {
              var duration = response.meta.duration;
              var _duration = moment.duration(duration, 's');
              var formatted_duration = _duration.format("h:*m:ss");

              $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
                 type : 9,
                 title : title,
                 theme : '_desktop/bs4-system-link',
                 description : description,
                 thumbnail_url : thumbnail_url,
                 author: author,
                 provider : provider,
                 url : url,
                 duration : duration?duration:'',
                 time :  duration?formatted_duration:'',
                 width : width,
                 height : height,
                 embed : embed,
                 wysiwyg : '<?php echo $wdgvar['wysiwyg'] ?>'
              },function(response){
                    var result=$.parseJSON(response);
                    if(!result.error){
                        $(container).find('[data-role="attach-preview-link"]').prepend(result.list);
                        $.notify("추가 되었습니다.");
                    }
              });

        	});

        } else {

          $.post(rooturl+'/?r='+raccount+'&m=mediaset&a=saveLink',{
            type : 8,
            title : title,
            theme : '_desktop/bs4-system-link',
            description : description,
            thumbnail_url : thumbnail_url,
            author: author,
            provider : provider,
            url : url,
            width : width,
            height : height,
            embed : embed,
            wysiwyg : '<?php echo $wdgvar['wysiwyg'] ?>'
          },function(response){
                var result=$.parseJSON(response);
                if(!result.error){
                    $(container).find('[data-role="attach-preview-link"]').prepend(result.list);
                    $.notify("추가 되었습니다.");
                }
          });

        }


  	}).fail(function() {
      alert( "URL을 확인해주세요." );
    }).always(function() {
      textarea.val('')
      fieldset.attr('disabled',false)
    });

  });


})
</script>
