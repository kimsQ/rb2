<link href="<?php echo $g['s']?>/_core/css/github-markdown.css" rel="stylesheet">

<div class="px-5 py-4 markdown-body">
  <?php @readfile($g['path_module'].$module.'/README.md')?>
</div>

<?php getImport('jquery-markdown','jquery.markdown','0.0.10','js')?>

<script>
  $('.markdown-body').markdown();
</script>
