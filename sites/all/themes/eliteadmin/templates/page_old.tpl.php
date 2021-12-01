<?php
/**
 * @file
 * Bartik's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 * @see html.tpl.php
 */
?>
<?php
global $user;
?>
<div id="wrapper">
    <!-- Top Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header"> 
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <div class="top-left-part">
                <a class="logo" href="<?php print $front_page; ?>/frontdesk">
                    <b>
                        <!--This is dark logo icon-->
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="dark-logo" />
                        <!--This is light logo icon-->
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="light-logo" />
                    </b>
                    <span class="hidden-xs">
                        <!--This is dark logo icon-->
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="dark-logo" />
                        <!--This is light logo icon-->
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="light-logo" />
                    </span>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                <li>
                    <form role="search" class="app-search hidden-xs">
                        <input type="text" placeholder="Search..." class="form-control">
                        <a href=""><i class="fa fa-search"></i></a>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-envelope"></i>
                        <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                    </a>
                    <ul class="dropdown-menu mailbox animated bounceInDown">
                        <li>
                            <div class="drop-title">You have 4 new messages</div>
                        </li>
                        <li>
                            <div class="message-center">
                                <a href="#">
                                    <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5>
                                        <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"> <img src="../plugins/images/users/sonu.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Sonu Nigam</h5>
                                        <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"> <img src="../plugins/images/users/arijit.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Arijit Sinh</h5>
                                        <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5>
                                        <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><i class="icon-note"></i>
                        <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks animated slideInUp">
                        <li>
                            <a href="#">
                                <div>
                                    <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <!-- .Megamenu -->
                <li class="mega-dropdown">
                    <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Mega</span> <i class="icon-options-vertical"></i></a>
                    <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                        <li class="col-sm-3">
                            <ul>
                                <li class="dropdown-header">Header Title</li>
                                <li><a href="javascript:void(0)">Link of page</a> </li>
                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul>
                                <li class="dropdown-header">Header Title</li>
                                <li><a href="javascript:void(0)">Link of page</a> </li>
                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul>
                                <li class="dropdown-header">Header Title</li>
                                <li><a href="javascript:void(0)">Link of page</a> </li>
                            </ul>
                        </li>
                        <li class="col-sm-3">
                            <ul>
                                <li class="dropdown-header">Header Title</li>
                                <li> <a href="javascript:void(0)">Link of page</a> </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- /.Megamenu -->
                <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                <!-- /.dropdown -->
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- End Top Navigation -->
    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse slimscrollsidebar">
            <div class="user-profile">
                <div class="dropdown user-pro-body">
                    <a href="#" class="dropdown-toggle u-dropdown" 
                       data-toggle="dropdown" role="button" aria-haspopup="true" 
                       aria-expanded="false"><?php print $user->name; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu animated flipInY">
                        <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/user/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <ul class="nav" id="side-menu">
                <li class="nav-small-cap"></li>
                <li><a href="javascript:void(0);" class="waves-effect">
                        <i class="icon-people fa-fw"></i> 
                        <span class="hide-menu"><?php echo t('Customers'); ?><span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li> <a href="/frontdesk/customers"><?php echo t('Customers'); ?></a></li>
                        <li> <a href="/frontdesk/customer/add/nojs"><?php echo t('Add').' '.t('Customers'); ?></a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="waves-effect">
                        <i class="ti-clipboard fa-fw"></i> 
                        <span class="hide-menu"><?php echo t('Acceptances'); ?><span class="fa arrow"></span></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li> <a href="/frontdesk/acceptances"><?php echo t('Acceptances'); ?></a></li>
                        <li> <a href="/frontdesk/acceptance/add"><?php echo t('Add').' '.t('Acceptance'); ?></a></li>
                    </ul>
                </li>                                                                              
            </ul>
        </div>
    </div>
    <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row-fluid bg-title">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h4 class="page-title"><?php print $title; ?></h4>
                </div>
<!--                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <a href="https://themeforest.net/item/elite-admin-responsive-dashboard-web-app-kit-/16750820" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Buy Now</a>
                    <ol class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li class="active">CRM Dashboard</li>
                    </ol>
                </div>-->
                <!-- /.col-lg-12 -->
            </div>
            <!--row -->

            <div class="row-fluid">
                <?php
                if (isset($messages)) {
                  print $messages;
                }
                ?>
                <?php if (isset($site_content['status_message'])): ?>
                  <div class="status-messages alert-danger"><i aria-hidden="true" class="fa fa-exclamation-triangle text-danger"></i><?php print $site_content['status_message']; ?></div>
                <?php endif; ?>
                <div class="main-content">
                    <?php print render($page['content']); ?>
                </div>
            </div>

<!--            <div class="row-fluid">
                <div class="col-md-3 col-sm-6">
                    <div class="white-box">
                        <div class="r-icon-stats">
                            <i class="ti-user bg-danger"></i>
                            <div class="bodystate">
                                <h4>3564</h4>
                                <span class="text-muted">New Customers</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="white-box">
                        <div class="r-icon-stats">
                            <i class="ti-shopping-cart bg-info"></i>
                            <div class="bodystate">
                                <h4>342</h4>
                                <span class="text-muted">New Products</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="white-box">
                        <div class="r-icon-stats">
                            <i class="ti-wallet bg-success"></i>
                            <div class="bodystate">
                                <h4>56%</h4>
                                <span class="text-muted">Today's Profit</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="white-box">
                        <div class="r-icon-stats">
                            <i class="ti-star bg-inverse"></i>
                            <div class="bodystate">
                                <h4>56%</h4>
                                <span class="text-muted">New Leads</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!--/row -->
            <!--row -->
<!--            <div class="row-fluid">
                <div class="col-md-5 col-lg-4 col-sm-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Leads by Source</h3>
                        <div id="morris-donut-chart" class="ecomm-donute" style="height: 317px;"></div>
                        <ul class="list-inline m-t-30 text-center">
                            <li class="p-r-20">
                                <h5 class="text-muted"><i class="fa fa-circle" style="color: #fb9678;"></i> Ads</h5>
                                <h4 class="m-b-0">8500</h4>
                            </li>
                            <li class="p-r-20">
                                <h5 class="text-muted"><i class="fa fa-circle" style="color: #01c0c8;"></i> Tredshow</h5>
                                <h4 class="m-b-0">3630</h4>
                            </li>
                            <li>
                                <h5 class="text-muted"> <i class="fa fa-circle" style="color: #4F5467;"></i> Web</h5>
                                <h4 class="m-b-0">4870</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7 col-lg-8 col-sm-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Top Products sales</h3>
                        <ul class="list-inline text-center">
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #00bfc7;"></i>iMac</h5>
                            </li>
                            <li>
                                <h5><i class="fa fa-circle m-r-5" style="color: #b4becb;"></i>iPhone</h5>
                            </li>
                        </ul>
                        <div id="morris-area-chart2" style="height: 370px;"></div>
                    </div>
                </div>
            </div>-->
            <!-- row -->
            <!-- .row -->

            <!-- /row -->
<!--            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">New Customers List</h3>
                        <p class="text-muted">this is the sample data here for crm</p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Deshmukh</td>
                                        <td>Prohaska</td>
                                        <td>@Genelia</td>
                                        <td><span class="label label-danger">admin</span> </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Deshmukh</td>
                                        <td>Gaylord</td>
                                        <td>@Ritesh</td>
                                        <td><span class="label label-info">member</span> </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Sanghani</td>
                                        <td>Gusikowski</td>
                                        <td>@Govinda</td>
                                        <td><span class="label label-warning">developer</span> </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Roshan</td>
                                        <td>Rogahn</td>
                                        <td>@Hritik</td>
                                        <td><span class="label label-success">supporter</span> </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Joshi</td>
                                        <td>Hickle</td>
                                        <td>@Maruti</td>
                                        <td><span class="label label-info">member</span> </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Nigam</td>
                                        <td>Eichmann</td>
                                        <td>@Sonu</td>
                                        <td><span class="label label-success">supporter</span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">New Product List</h3>
                        <p class="text-muted">this is the sample data here for crm</p>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Products</th>
                                        <th>Popularity</th>
                                        <th>Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Milk Powder</td>
                                        <td><span class="peity-line" data-width="120" data-peity='{ "fill": ["#13dafe"], "stroke":["#13dafe"]}' data-height="40">0,-3,-2,-4,-5,-4,-3,-2,-5,-1</span> </td>
                                        <td><span class="text-danger text-semibold"><i class="fa fa-level-down" aria-hidden="true"></i> 28.76%</span> </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Air Conditioner</td>
                                        <td><span class="peity-line" data-width="120" data-peity='{ "fill": ["#13dafe"], "stroke":["#13dafe"]}' data-height="40">0,-1,-1,-2,-3,-1,-2,-3,-1,-2</span> </td>
                                        <td><span class="text-warning text-semibold"><i class="fa fa-level-down" aria-hidden="true"></i> 8.55%</span> </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>RC Cars</td>
                                        <td><span class="peity-line" data-width="120" data-peity='{ "fill": ["#13dafe"], "stroke":["#13dafe"]}' data-height="40">0,3,6,1,2,4,6,3,2,1</span> </td>
                                        <td><span class="text-success text-semibold"><i class="fa fa-level-up" aria-hidden="true"></i> 58.56%</span> </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Down Coat</td>
                                        <td><span class="peity-line" data-width="120" data-peity='{ "fill": ["#13dafe"], "stroke":["#13dafe"]}' data-height="40">0,3,6,4,5,4,7,3,4,2</span> </td>
                                        <td><span class="text-info text-semibold"><i class="fa fa-level-up" aria-hidden="true"></i> 35.76%</span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- /.row -->
            <!-- .right-sidebar -->
            <div class="right-sidebar">
                <div class="slimscrollright">
                    <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                    <div class="r-panel-body">
<!--                        <ul>
                            <li><b>Layout Options</b></li>
                            <li>
                                <div class="checkbox checkbox-info">
                                    <input id="checkbox1" type="checkbox" class="fxhdr">
                                    <label for="checkbox1"> Fix Header </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox checkbox-warning">
                                    <input id="checkbox2" type="checkbox" checked="" class="fxsdr">
                                    <label for="checkbox2"> Fix Sidebar </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox checkbox-success">
                                    <input id="checkbox4" type="checkbox" class="open-close">
                                    <label for="checkbox4"> Toggle Sidebar </label>
                                </div>
                            </li>
                        </ul>
                        <ul id="themecolors" class="m-t-20">
                            <li><b>With Light sidebar</b></li>
                            <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
                            <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
                            <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
                            <li><a href="javascript:void(0)" theme="blue" class="blue-theme">4</a></li>
                            <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
                            <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
                            <li><b>With Dark sidebar</b></li>
                            <br/>
                            <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
                            <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
                            <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme working">9</a></li>
                            <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
                            <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
                            <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
                        </ul>
                        <ul class="m-t-20 all-demos">
                            <li><b>Choose other demos</b></li>
                        </ul>
                        <ul class="m-t-20 chatonline">
                            <li><b>Chat option</b></li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/ritesh.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/john.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/pawandeep.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
            </div>
            <!-- /.right-sidebar -->
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> <?php echo date('Y'); ?> &copy; SPR. Developed By <a href="http://webemania.com">WEBEMANIA.COM</a> </footer>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
