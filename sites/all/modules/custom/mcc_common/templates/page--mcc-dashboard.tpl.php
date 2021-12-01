<div class="wrapper">
  <div class="sidebar" data-color="purple" style="background: linear-gradient(to bottom, #9368E9 0%, #943bea 100%)">
    <div class="sidebar-wrapper">
      <div class="logo">
        <a class="simple-text">MCC Education Portal</a>                
      </div>

      <ul class="nav">
        <?php
        global $user;
        $user = user_load($user->uid);
        $user_in_sub_unit = false;
        if (!empty($user->field_sub_unit['und'][0]['target_id'])) {
          $user_in_sub_unit = true;
        }
        $permitted_to_add_unit_activity = false;
        if (_check_if_in_role('Unit Leader', $user->uid) || _check_if_in_role('Central Leader', $user->uid))
          $permitted_to_add_unit_activity = true;
        ?>
        <h6 class="text-center text-success">MCC</h6>
        <?php if (user_access('create syllabus')) { ?>
        <li class="user-profile-menu">
          <a href="/upload-syllabus">
            <i class="pe-7s-note2"></i>
            <p>Upload New Syllabus - English (DOCX only)</p>
          </a>
        </li>
        <li class="user-profile-menu">
          <a href="/academic-syllabus/upload-modules-materials">
            <i class="pe-7s-note2"></i>
            <p>Module Content Upload - English</p>
          </a>
        </li>
        <li class="user-profile-menu">
          <a href="/academic-syllabus/upload-materials">
            <i class="pe-7s-note2"></i>
            <p>Text/ Reference Materials Upload - English</p>
          </a>
        </li>
        <li class="user-profile-menu">
          <a href="/academic-syllabus/upload-audio-video">
            <i class="pe-7s-note2"></i>
            <p>Audio/ Video Upload - English</p>
          </a>
        </li>
        <?php } ?>
        <li class="user-profile-menu">
          <a href="/academic-syllabus-brief">
            <i class="pe-7s-note2"></i>
            <p>Brief General Syllabus - English</p>
          </a>
        </li>
        <li class="user-profile-menu">
          <a href="/academic-syllabus">
            <i class="pe-7s-note2"></i>
            <p>Detail General Syllabus - English</p>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
<!--          <a class="navbar-brand" href="/user">Dashboard</a>-->
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">                        
            <li>
              <a href="/user/logout">
                Log out
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="">
              <?php
              if (isset($messages)) {
                print $messages;
              }
              ?>
              <?php if (isset($site_content['status_message'])): ?>
                <div class="status-messages alert-danger"><i aria-hidden="true" class="fa fa-exclamation-triangle text-danger"></i><?php print $site_content['status_message']; ?></div>
              <?php endif; ?>
              <?php print render($page['content']); ?>
            </div>
          </div>
        </div>             
      </div>
    </div>


    <footer class="footer">
      <div class="container-fluid">
        <p class="copyright pull-right">
          &copy; <?php echo date('Y') ?> MCC.
        </p>
      </div>
    </footer>

  </div>
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