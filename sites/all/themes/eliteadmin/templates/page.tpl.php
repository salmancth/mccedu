<?php
global $user;
$hrefStrt = '/mccedu/';
$user_roles = $user->roles;
//pretty_print($user_roles, 0);
$syllabus_types = array(
    'general' => 'General Syllabus',
    'bangla' => 'Bangla Syllabus',
    'short' => 'Short Courses',
);
$logged_in = false;
if ($user->uid)
    $logged_in = true;
?>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
            <div class="top-left-part m-t-5 m-l-5 hidden-sm hidden-xs"><a class="logo" href="">MCC Education Portal</a></div>
            <ul class="nav navbar-top-links navbar-left hidden-xs">
                <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>        
            </ul>
            <?php if ($logged_in) { ?>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a href="<?php echo $hrefStrt; ?>user/logout"><i class="fa fa-power-off"></i> Logout From Education Portal</a></li>
                        <!--<a href="javascript:window.open('','_self').close();"><i class="fa fa-power-off"></i> Logout From Education Portal</a></li>-->
                    <!-- /.dropdown-user -->
                    </li>
                </ul>
            <?php } ?>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Left navbar-header -->
    <?php if ($logged_in) { ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">                    
                    <?php if (user_access('create syllabus')) { ?>
                        <li>
                            <a href="" class="waves-effect active two-column">
                                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i> 
                                <span class="hide-menu"> Admin Stuff <span class="fa arrow"></span> </span></a>
                            <ul class="nav nav-second-level collapse in">
                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                        <span class="hide-menu">Upload Section ></span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/upload-syllabus-by-type">Upload New Syllabus</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/upload-modules-materials">Module Content Upload</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/upload-materials">Text/ Reference Materials Upload</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/upload-audio-video">Audio/ Video Upload</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/upload-pdf-version">Syllabus PDF version Upload</a>
                                        </li>
                                        <?php if (user_access('upload qb')) { ?>
                                            <li>
                                                <a href="<?php echo $hrefStrt; ?>syllabus/upload-qb">Question Bank Upload</a>
                                            </li>
                                        <?php } ?>
                                        <?php if (user_access('course registration')) { ?>
                                            <li>
                                                <a href="<?php echo $hrefStrt; ?>syllabus/course-registration">Upload Course Registration CSV</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>                                
                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                        <span class="hide-menu">Course Related ></span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse second-level">                                                                            
                                        <?php if (user_access('course registration')) { ?>
                                            <li>
                                                <a href="<?php echo $hrefStrt; ?>syllabus/course-instructor-assignment">Course Instructor Assignment</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $hrefStrt; ?>syllabus/course-instructor-list">Course Instructor List</a>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/course-url">Course Meeting URL</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/course-result">Course Result</a>
                                        </li>                                        
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/course-schedule-create">Course Schedule Create</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/course-schedule">Course Schedule</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/course-class-create">Course Class Create</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $hrefStrt; ?>syllabus/course-classes">Attendance</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>admin/people/create">Create User</a>
                                </li>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/edu-user-list">List of Users</a>
                                </li>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/edu-blocked-user-list">List of Blocked Users</a>
                                </li>
                            </ul>
                        </li>          
                    <?php } ?>
                    <?php if (_isFaculty()) { ?>
                        <li>
                            <a href="" class="waves-effect active">
                                <i class="linea-icon linea-basic fa-fw" data-icon="v"></i> 
                                <span class="hide-menu"> Faculty Stuff <span class="fa arrow"></span> </span></a>
                            <ul class="nav nav-second-level collapse in">
                                <?php if (_isFacultyOnly() && user_access('upload qb')) { ?>
                                    <li>
                                        <a href="<?php echo $hrefStrt; ?>syllabus/upload-qb">Question Bank Upload</a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/instructor-for-courses">Faculty of Courses</a>
                                </li>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/my-registered-users">Communication</a>
                                </li>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/course-class-create">Course Class Create</a>
                                </li>
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/course-classes">Attendance</a>
                                </li>
                                <?php if (_isFacultyOnly()) { ?>
                                    <li>
                                        <a href="<?php echo $hrefStrt; ?>syllabus/course-result">Course Result</a>
                                    </li>
                                <?php } ?>                                
                            </ul>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo $hrefStrt; ?>syllabus/my-courses" class="waves-effect active">
                            <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> My Courses <span class="fa arrow"></span> </span></a>
                    </li>
                    <li>
                        <a href="<?php echo $hrefStrt; ?>syllabus/my-courses-result" class="waves-effect active">
                            <i class="linea-icon linea-basic fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> My Result <span class="fa arrow"></span> </span></a>
                    </li>

                    <?php foreach ($syllabus_types as $key => $value) { ?>
                        <li>
                            <a href="" class="waves-effect active">
                                <i class="linea-icon linea-basic fa-fw" data-icon=""></i> 
                                <span class="hide-menu"> <?php echo $value; ?> <span class="fa arrow"></span> </span></a>
                            <ul class="nav nav-second-level collapse in">
                                <li>
                                    <a href="<?php echo $hrefStrt; ?>syllabus/academic-syllabus-brief-by-type/<?php echo $key; ?>">Courses At A Glance</a>
                                </li>
                                <li class="user-profile-menu">
                                    <a href="<?php echo $hrefStrt; ?>syllabus/academic-syllabus-by-type/<?php echo $key; ?>">Detail <?php echo $value; ?></a>
                                </li>
                                <li class="user-profile-menu">
                                    <a href="<?php echo $hrefStrt; ?>syllabus/academic-syllabus-pdf/<?php echo $key; ?>">Syllabus Book</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo $hrefStrt; ?>syllabus/calendar" class="waves-effect active">
                            <i class="linea-icon linea-basic fa-fw" data-icon="v"></i> 
                            <span class="hide-menu"> Course Calendar <span class="fa arrow"></span> </span></a>
                    </li>
                </ul>
            </div>
        </div>
    <?php } ?>
    <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h4 class="page-title"><?php print $title; ?></h4>
                </div>
            </div>
            <!-- .row -->
            <div class="row-fluid">
                <!--<div class="white-box">-->
                <?php if (isset($messages)): ?>
                    <?php print $messages; ?>
                <?php endif; ?>

                <?php if (isset($site_content['status_message'])): ?>
                    <div class="status-messages alert-danger"><i aria-hidden="true" class="fa fa-exclamation-triangle text-danger"></i><?php print $site_content['status_message']; ?></div>
                <?php endif; ?>
                <?php // if (empty($user->uid)) { ?>
                    <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
                    <?php // } ?>
                <div class="main-content">
                    <?php print render($page['content']); ?>
                </div>
                <!--</div>-->
            </div>                                  
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> Muslim Circle Of Canada </footer>
    </div>
    <!-- /#page-wrapper -->
</div>

<div class="modal fade" id="rowInfoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <colgroup>
                        <col width="35%" />
                        <col width="65%" />
                    </colgroup>
                </table>
            </div>
        </div>
    </div>
</div>