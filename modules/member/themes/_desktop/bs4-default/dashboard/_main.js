$(document).ready(function() {

  $('[data-toggle="actionIframe"] , [data-act="actionIframe"]').click(function() {
    getIframeForAction('');
    frames.__iframe_for_action__.location.href = $(this).attr("data-url");
  });


});
