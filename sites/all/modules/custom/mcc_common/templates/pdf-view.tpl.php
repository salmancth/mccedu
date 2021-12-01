<?php if ($file_type == 'pdf') { ?>
  <?php global $base_url; ?>
  <input type="hidden" value="<?php echo $file_url; ?>" id="test-pdf"/>
  <div class="row">
    <div id="pdf-main-container col col-md-12" style="margin: 0 auto">
      <iframe id="doc-frame" src='<?php echo $base_url; ?>/pdf-viewer/web/viewer.html?file=<?php echo $file_url; ?>&embedded=true' frameborder='0'></iframe>
    </div>
  </div>
  <!--  <div class="row">
      <div id="pdf-main-container col col-md-12" style="margin: 0 auto">
        <div id="pdf-loader"><i class="fa fa-spinner fa-spin"></i> </div>
        <div id="pdf-contents">
          <div id="pdf-meta">
            <div id="pdf-buttons">
              <button id="pdf-prev">Previous</button>
              <button id="pdf-next">Next</button>
            </div>
            <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div>
          </div>
          <canvas id="pdf-canvas"></canvas>
          <div id="page-loader">Loading page ...</div>
        </div>
      </div>
    </div>-->
  <!--  <script>

      var __PDF_DOC,
              __CURRENT_PAGE,
              __TOTAL_PAGES,
              __PAGE_RENDERING_IN_PROGRESS = 0,
              __CANVAS = jQuery('#pdf-canvas').get(0),
              __CANVAS_CTX = __CANVAS.getContext('2d');

      function showPDF(pdf_url) {
        jQuery("#pdf-loader").show();

        PDFJS.getDocument({url: pdf_url}).then(function(pdf_doc) {
          __PDF_DOC = pdf_doc;
          __TOTAL_PAGES = __PDF_DOC.numPages;

          // Hide the pdf loader and show pdf container in HTML
          jQuery("#pdf-loader").hide();
          jQuery("#pdf-contents").show();
          jQuery("#pdf-total-pages").text(__TOTAL_PAGES);

          // Show the first page
          showPage(1);
        }).catch(function(error) {
          // If error re-show the upload button
          jQuery("#pdf-loader").hide();
          jQuery("#upload-button").show();

          alert(error.message);
        });
        ;
      }

      function showPage(page_no) {
        __PAGE_RENDERING_IN_PROGRESS = 1;
        __CURRENT_PAGE = page_no;

        // Disable Prev & Next buttons while page is being loaded
        jQuery("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

        // While page is being rendered hide the canvas and show a loading message
        jQuery("#pdf-canvas").hide();
        jQuery("#page-loader").show();

        // Update current page in HTML
        jQuery("#pdf-current-page").text(page_no);

        // Fetch the page
        __PDF_DOC.getPage(page_no).then(function(page) {
          // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
          var scale_required = __CANVAS.width / page.getViewport(1).width;

          // Get viewport of the page at required scale
          var viewport = page.getViewport(scale_required);

          // Set canvas height
          __CANVAS.height = viewport.height;

          var renderContext = {
            canvasContext: __CANVAS_CTX,
            viewport: viewport
          };

          // Render the page contents in the canvas
          page.render(renderContext).then(function() {
            __PAGE_RENDERING_IN_PROGRESS = 0;

            // Re-enable Prev & Next buttons
            jQuery("#pdf-next, #pdf-prev").removeAttr('disabled');

            // Show the canvas and hide the page loader
            jQuery("#pdf-canvas").show();
            jQuery("#page-loader").hide();
          });
        });
      }
      if (jQuery("#test-pdf").length) {
        var total_width = jQuery(window).innerWidth();
        var pdf_width = total_width / 2;
        jQuery("#pdf-canvas").attr('width', pdf_width);
        showPDF(jQuery("#test-pdf").val());
      }
      // Upon click this should should trigger click on the #file-to-upload file input element
      // This is better than showing the not-good-looking file input element
      jQuery("#upload-button").on('click', function() {
        jQuery("#file-to-upload").trigger('click');
      });

      // When user chooses a PDF file
      jQuery("#file-to-upload").on('change', function() {
        // Validate whether PDF
        if (['application/pdf'].indexOf(jQuery("#file-to-upload").get(0).files[0].type) == -1) {
          alert('Error : Not a PDF');
          return;
        }

        jQuery("#upload-button").hide();
        // Send the object url of the pdf
        showPDF(URL.createObjectURL(jQuery("#file-to-upload").get(0).files[0]));
      });

      // Previous page of the PDF
      jQuery("#pdf-prev").on('click', function() {
        if (__CURRENT_PAGE != 1)
          showPage(--__CURRENT_PAGE);
      });

      // Next page of the PDF
      jQuery("#pdf-next").on('click', function() {
        if (__CURRENT_PAGE != __TOTAL_PAGES)
          showPage(++__CURRENT_PAGE);
      });

    </script>-->
  <!--  <style type="text/css">

      #upload-button {
        width: 150px;
        display: block;
        margin: 20px auto;
      }

      #file-to-upload {
        display: none;
      }

      #pdf-main-container {
        /*	width: 400px;*/
        margin: 20px auto;
      }

      #pdf-loader {
        display: none;
        text-align: center;
        color: #999999;
        font-size: 13px;
        line-height: 100px;
        height: 100px;
      }

      #pdf-contents {
        display: none;
      }

      #pdf-meta {
        overflow: hidden;
        margin: 0 0 20px 0;
      }

      #pdf-buttons {
        float: left;
      }

      #page-count-container {
        float: right;
      }

      #pdf-current-page {
        display: inline;
      }

      #pdf-total-pages {
        display: inline;
      }

      #pdf-canvas {
        border: 1px solid rgba(0,0,0,0.2);
        box-sizing: border-box;
      }

      #page-loader {
        height: 100px;
        line-height: 100px;
        text-align: center;
        display: none;
        color: #999999;
        font-size: 13px;
      }

    </style>-->
<?php } else { ?>
  <div class="row">
    <div id="pdf-main-container col col-md-12" style="margin: 0 auto">
      <iframe id="doc-frame" src='https://docs.google.com/viewer?url=<?php echo $file_url; ?>&embedded=true' frameborder='0'></iframe>
    </div>
  </div>  
<?php } ?>

<script>
  if (jQuery("#doc-frame").length) {
    var total_width = jQuery(window).innerWidth();
    var pdf_width = total_width / 1.50;
    jQuery("#doc-frame").attr('width', pdf_width);
    jQuery("#doc-frame").attr('height', pdf_width);
  }
</script>