<?php global $base_url; ?>
<div class="card card-outline-primary m-b-20 white-box">
  <div class="card-block">
    <?php if (!empty($file_url)) { ?>
      <div class="embed-responsive embed-responsive-16by9">
        <iframe id="doc-frame" class="embed-responsive-item" src="<?php echo $base_url; ?>/pdf-viewer/web/viewer.html?file=<?php echo $file_url; ?>" allowfullscreen></iframe>
      </div>
      <!--<iframe src='<?php // echo $base_url; ?>/pdf-viewer/web/viewer.html?file=<?php // echo $file_url; ?>&embedded=true' frameborder='0'></iframe>-->
    <?php } else { ?>

    <?php } ?>
  </div>    
</div>

<script>
  if (jQuery("#doc-frame").length) {
    var total_width = jQuery(window).innerWidth();
    var pdf_width = total_width / 1.50;
    jQuery("#doc-frame").attr('width', pdf_width);
    jQuery("#doc-frame").attr('height', pdf_width);
  }
</script>