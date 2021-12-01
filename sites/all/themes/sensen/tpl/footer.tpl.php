<div class="footer">
    <div class="footer-content bkwrapper clearfix container">
        <div class="row">
            <?php if ($page['footer_first']): ?>
                <div class="footer-sidebar col-md-4">
                    <?php print render($page['footer_first']) ?>
                </div>
            <?php endif; ?>
            <?php if ($page['footer_second']): ?>
                <div class="footer-sidebar col-md-4">
                    <?php print render($page['footer_second']) ?>
                </div>
            <?php endif; ?>

            <?php if ($page['footer_third']): ?>
                <div class="footer-sidebar col-md-4">
                    <?php print render($page['footer_third']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-lower">
        <div class="container">
            <div class="footer-inner clearfix">
                <div id="footer-menu" class="menu-footer-menu-container">
                   <?php if ($page['footer_menu']): ?>
           
                    <?php print render($page['footer_menu']) ?>
              
            <?php endif; ?>
                </div>
                <div class="bk-copyright"><?php print theme_get_setting('footer_copyright_message', 'sensen');?></div>
            </div>
        </div>
    </div>
</div>

