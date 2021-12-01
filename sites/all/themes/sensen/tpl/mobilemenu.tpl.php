<div id="main-mobile-menu">
    <div class="block">
        <div id="mobile-inner-header">
            <h3 class="menu-title"> MCC </h3>
            <a class="mobile-menu-close" href="#" title="Close"><i class="fa fa-arrow-left"></i></a> </div>
        <div class="top-menu">
            <h3 class="menu-location-title"> Top Menu </h3>
            <div id="mobile-top-menu" class="menu-top-menu-container">
                <!-- top menu-->
                <?php if ($page['top_menu']): ?>
                    <!-- Navigation start //-->
                    <?php print render($page['top_menu']); ?>
                    <!-- Navigation end //-->
                <?php endif; ?>
            </div>
        </div>
        <div class="main-menu">
            <h3 class="menu-location-title"> Main Menu </h3>
            <div id="mobile-menu" class="menu-main-menu-container">
                <?php if ($page['main_menu']): ?>
                    <!-- Navigation start //-->
                    <?php print render($page['main_menu']); ?>
                    <!-- Navigation end //-->
                <?php endif; ?>
                <!-- / Navigation -->
            </div>
        </div>
    </div>
</div>
