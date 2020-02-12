<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_"></div>

<iframe hidden name="_action_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no"></iframe>

<?php if($my['uid']&&$m=='admin') include $g['path_core'].'engine/notification.engine.admin.php'?>

<script>

(function ($) {
  'use strict'

  $(function () {

    var clipboard = new ClipboardJS('.js-clipboard');

    clipboard.on('success', function (e) {
      $(e.trigger)
        .attr('title', '복사완료!')
        .tooltip('_fixTitle')
        .tooltip('show')
        .attr('title', '클립보드 복사')
        .tooltip('_fixTitle')

      e.clearSelection()
    })

    clipboard.on('error', function (e) {
      var modifierKey = /Mac/i.test(navigator.userAgent) ? '\u2318' : 'Ctrl-'
      var fallbackMsg = 'Press ' + modifierKey + 'C to copy'

      $(e.trigger)
        .attr('title', fallbackMsg)
        .tooltip('_fixTitle')
        .tooltip('show')
        .attr('title', 'Copy to clipboard')
        .tooltip('_fixTitle')
    })

  })
}(jQuery))

</script>
