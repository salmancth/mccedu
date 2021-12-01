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
$user_roles = $user->roles;
?>
<div id="wrapper">
    <!-- Top Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header"> 
            <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <div class="top-left-part">
                <a class="logo" href="<?php print $front_page; ?>frontdesk">
                    <b>
                        <!--This is dark logo icon-->
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="dark-logo" />
                        <!--This is light logo icon-->
                        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="light-logo" />
                    </b>
                    <span class="hidden-xs hidden-sm hidden-ms hidden-md hidden-lg hidden-xl">
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
                                    <div class="user-img"> <img src="" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Pavan kumar</h5>
                                        <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"> <img src="" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Sonu Nigam</h5>
                                        <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"> <img src="" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>Arijit Sinh</h5>
                                        <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                </a>
                                <a href="#">
                                    <div class="user-img"> <img src="" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
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
            <div class="user-profile m-t-20">
                <div class="dropdown user-pro-body">
                    <a href="#" class="dropdown-toggle u-dropdown" 
                       data-toggle="dropdown" role="button" aria-haspopup="true" 
                       aria-expanded="false"><?php print $user->name; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu animated flipInY">
                        <li><a href="/user/<?php print $user->uid; ?>/edit"><i class="fa fa-user"></i> My Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/user/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a><i class="fa fa-pencil-square-o"></i><b> Role</b></a></li>
                        <?php foreach ($user_roles as $key => $role) { ?>
                          <?php
                          if (strpos($role, 'authenticated') !== FALSE)
                            continue;
                          ?>
                          <li><a>&nbsp;<?php print ucwords($role); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <ul class="nav" id="side-menu">
                <!--                <li class="nav-small-cap"></li>-->
                <li>
                    <?php
                    echo l('<i class="fa fa-desktop" aria-hidden="true"></i> ' . t('Dashboard'), '/frontdesk/', array('html' => true));
                    ?>
                </li>
                <?php if (user_access('access frontdesk')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="ti-clipboard fa-fw"></i> 
                          <span class="hide-menu"><?php echo t('Acceptances'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <?php if (user_access('add new acceptance')): ?>
                            <li> 
                                <?php
                                echo l('<i class="fa fa-clipboard" aria-hidden="true"></i> ' . t('Add') . ' ' . t('Acceptance'), '/frontdesk/acceptance/add', array('html' => true));
                                ?>
                            </li>
                          <?php endif; ?>
                          <li>
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search '), '/frontdesk/acceptances', array('html' => true));
                              ?>
                          </li>
                          <?php if (user_access('manage employees')): ?>
                            <li> 
                                <?php
                                echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Acceptance') . ' ' . t('Profit/ Loss'), '/frontdesk/acceptances/profit-loss', array('html' => true));
                                ?>
                            </li>
                          <?php endif; ?>
                            <?php if (user_access('add new acceptance')): ?>
                            <li> 
                                <?php
                                echo l('<i class="fa fa-clipboard" aria-hidden="true"></i> ' . t('Acceptance Generate Refund'), '/frontdesk/acceptance/refund', array('html' => true));
                                ?>
                            </li>
                          <?php endif; ?>
                      </ul>
                  </li>
                <?php endif; ?>
                <?php if (user_access('add new customer')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="icon-people fa-fw"></i> 
                          <span class="hide-menu"><?php echo t('Customers'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li>
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search '), '/frontdesk/customers', array('html' => true));
                              ?>
                          </li>
                          <li>                              
                              <?php
                              echo l('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . t('Add') . ' ' . t('Customer'), '/frontdesk/customer/add/nojs', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?> 
                <?php if (user_access('manage employees')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="fa fa-building"></i> 
                          <span class="hide-menu"><?php echo t('Branches'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li> 
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search '), '/frontdesk/voc/branch', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-building" aria-hidden="true"></i> ' . t('Add') . ' ' . t('Branch'), '/frontdesk/voc/branch/add/nojs', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?>
                <?php if (user_access('manage employees')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="fa fa-users"></i> 
                          <span class="hide-menu"><?php echo t('Users'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li> 
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search '), '/frontdesk/employees', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-user-plus" aria-hidden="true"></i> ' . t('Add') . ' ' . t('User'), '/frontdesk/employees/add/nojs', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?>
                <?php if (user_access('manage employees')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="fa fa-tasks"></i> 
                          <span class="hide-menu"><?php echo t('Managerial Tasks'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li> 
                              <?php
                              echo l('<i class="fa fa-money"></i> ' . t('Transactions'), '/frontdesk/accounts/transactions', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-chain-broken"></i> ' . t('DDT Viewer'), '/frontdesk/acceptance/ddt', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-list-alt" aria-hidden="true"></i> ' . t('Attendances'), '/frontdesk/employees-attendance', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-certificate" aria-hidden="true"></i> ' . t('Employee Performance'), '/frontdesk/employee-track-record', array('html' => true));
                              ?>
                          </li>
                      </ul>

                  </li>
                <?php endif; ?>
                <?php if (user_access('access frontdesk')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="ti-briefcase fa-fw"></i> 
                          <span class="hide-menu"><?php echo t('Order Spare parts'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li>
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search '), '/frontdesk/order-parts', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-clipboard" aria-hidden="true"></i> ' . t('Submit Order Parts'), '/frontdesk/order-parts/add', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?>

                <?php if (user_access('access backoffice order')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="fa fa-calculator"></i> 
                          <span class="hide-menu"><?php echo t('Back Office E-Commerce Order'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li>
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search '), '/frontdesk/backoffice-orders', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-shopping-cart" aria-hidden="true"></i> ' . t('Add E-Commerce Order'), '/frontdesk/backoffice-orders/add', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?>
                <?php if (user_access('access purchase invoice')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="ti-receipt fa-fw"></i> 
                          <span class="hide-menu"><?php echo t('Purchase Invoices'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li>
                              <?php
                              echo l('<i class="ti-search fa-fw" aria-hidden="true"></i> ' . t('Search'), '/frontdesk/purchase-invoices', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-shopping-cart" aria-hidden="true"></i> ' . t('Add New Purchase Invoice'), '/frontdesk/purchase-invoices/add', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?>
                <?php if (user_access('access general expense')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="fa fa-calculator"></i> 
                          <span class="hide-menu"><?php echo t('Expenses'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li>
                              <?php
                              echo l('<i class="fa fa-search" aria-hidden="true"></i> ' . t('Search'), '/frontdesk/general-expenses', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa fa-line-chart" aria-hidden="true"></i> ' . t('Add New General Expense'), '/frontdesk/general-expenses/add', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?>
                <?php if (user_access('manage settings')): ?>
                  <li><a href="javascript:void(0);" class="waves-effect">
                          <i class="ti-settings"></i> 
                          <span class="hide-menu"><?php echo t('Additional Settings'); ?><span class="fa arrow"></span></span>
                      </a>
                      <ul class="nav nav-second-level">
                          <li>
                              <?php
                              echo l('<i class="fa" aria-hidden="true"></i> ' . t('Control Status List'), '/frontdesk/settings/acceptance/category/device_current_status', array('html' => true));
                              ?>
                          </li>
                          <li>
                              <?php
                              echo l('<i class="fa" aria-hidden="true"></i> ' . t('Acceptance Transaction Settings'), '/frontdesk/settings/acceptance/transaction', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa" aria-hidden="true"></i> ' . t('Acceptance DDT Settings'), '/frontdesk/settings/acceptance/ddt', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa" aria-hidden="true"></i> ' . t('Acceptance Default Status'), '/frontdesk/settings/acceptance/set-default/device_current_status', array('html' => true));
                              ?>
                          </li>
                          <li> 
                              <?php
                              echo l('<i class="fa" aria-hidden="true"></i> ' . t('Set Main Branch'), '/frontdesk/settings/acceptance/set-default/branch', array('html' => true));
                              ?>
                          </li>
                      </ul>
                  </li>
                <?php endif; ?> 
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
            </div>
            <!--row -->

            <div class="row-fluid">
                <?php if (isset($messages)): ?>
                  <?php print $messages; ?>
                <?php endif; ?>

                <?php if (isset($site_content['status_message'])): ?>
                  <div class="status-messages alert-danger"><i aria-hidden="true" class="fa fa-exclamation-triangle text-danger"></i><?php print $site_content['status_message']; ?></div>
                <?php endif; ?>
                <div class="main-content">
                    <?php print render($page['content']); ?>
                </div>
            </div>


            <!-- /.row -->
            <!-- .right-sidebar -->
            <div class="right-sidebar">
                <div class="slimscrollright">
                    <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                    <div class="r-panel-body">
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
