<?php
$site_layout = theme_get_setting('site_layout', 'sensen');
$logo_position = theme_get_setting('logo_position', 'sensen');
$menu_scheme = theme_get_setting('menu_scheme', 'sensen');
$primary_color = theme_get_setting('primary_color', 'sensen');

if ($site_layout == "wide") {
    $site_layout_wide = 'selected="selected">Wide';
    $site_layout_boxed = ">Boxed";
} else {
    $site_layout_boxed = 'selected="selected">Bowed';
    $site_layout_wide = ">Wide";
}
if ($logo_position == "leftlogo") {
    $logo_position_left = 'selected="selected">Left Logo';
    $logo_position_center = ">Center Logo";
} else {
    $logo_position_left = ">Left Logo";
    $logo_position_center = 'selected="selected">Center Logo';
}
if ($menu_scheme == "darkmenu") {
    $menu_scheme_light = ">Light Menu";
    $menu_scheme_dark = 'selected="selected">Dark Menu';
} else {
    $menu_scheme_light = 'selected="selected">Light Menu';
    $menu_scheme_dark = ">Dark Menu";
}

?>
<div class="style-selector" style="left: -225px;">
    <div class="switch-container">
        <div class="switch button" status="closed"><i class="fa fa-cog"></i></div>
    </div>
    <div class="style-selector-container">
        <h5 class="style-selector-main-title">STYLE SWITCHER</h5>
        <h6 class="style-selector-box-title">Site Layout</h6>
        <div class="field-container">
            <select  id="site_layout">

                <option value="wide" <?php print $site_layout_wide ?></option>
                <option value="boxed"<?php print $site_layout_boxed ?></option>
            </select>
        </div>
        <h6 class="style-selector-box-title">Logo Position</h6>
        <div class="field-container">
            <select  id="logo_position">
                <option value="left-logo" <?php print $logo_position_left ?></option>
                <option value="center-logo"  <?php print $logo_position_center ?></option>
            </select>
        </div>
        <h6 class="style-selector-box-title">Menu Scheme</h6>
        <div class="field-container">
            <select  id="menu_scheme">
                <option value="dark" <?php print $menu_scheme_dark ?></option>
                <option value="light"<?php print $menu_scheme_light ?> </option>
            </select>
        </div>
        <h6 class="style-selector-box-title">Primary Color</h6>
        <div class="field-container primary-color-option">
            <div class="color-small-box " data-color="#FFCC0D" style="background: #FFCC0D;"></div>
            <div class="color-small-box" data-color="#FF6600" data-file="1.css" style="background: #FF6600;"></div>
            <div class="color-small-box" data-color="#BDDB00" data-file="2.css" style="background: #BDDB00;"></div>
            <div class="color-small-box" data-color="#F9B281" data-file="3.css" style="background: #F9B281;"></div>
            <div class="color-small-box" data-color="#53B7F9" data-file="4.css" style="background: #53B7F9;"></div>
        </div>
    </div>
</div>