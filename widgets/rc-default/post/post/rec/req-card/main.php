<div style="<?php echo $wdgvar['posts']?'min-height: 250px':'' ?>" data-role="list"></div>

<script>

var wrapper =   $('<?php echo $wdgvar['wrapper'] ?> [data-role="list"]');
var start = '<?php echo $wdgvar['start'] ?>';
var posts = '<?php echo $wdgvar['posts'] ?>';
var markup_file = '<?php echo $wdgvar['markup'] ?>';
var none = '';

wrapper.loader({ position: 'inside' });

$.post(rooturl+'/?r='+raccount+'&m=post&a=get_postReq',{
  start : start,
  posts : posts,
  markup_file : markup_file
  },function(response,status){
    if(status=='success'){
      var result = $.parseJSON(response);
      var list=result.list;
      wrapper.loader('hide');
      if (list) {
        wrapper.html(list);
        wrapper.find('[data-toggle="page"]').attr('data-start',start);
      } else {
        wrapper.html(none)
      }
      wrapper.find('[data-plugin="timeago"]').timeago();
    } else {
      alert(status);
    }
});

</script>
