<?php
//pretty_print($academic_syllabus['deparments'], 0);
$dept_keys = array_keys($academic_syllabus['deparments']);
?>
<ul class="nav customtab nav-tabs dept-tabs" role="tablist">
  <?php
  foreach ($dept_keys as $key => $val) {
    $dept_name = $academic_syllabus['deparments'][$val]['department']['name'];
    $dept_code = $academic_syllabus['deparments'][$val]['department']['code'];
    $class = '';
    if ($key == 0)
      $class = 'active';
    ?>
    <li role="presentation" class="nav-item">
      <a id="<?php echo $dept_code; ?>-li" class="nav-link <?php echo $class; ?>" data-toggle="tab" href="#<?php echo $dept_code; ?>"><?php echo $dept_name; ?></a>
    </li>
    <?php
  }
  ?>
</ul> 
<div class="tab-content">
  <?php
  foreach ($dept_keys as $key1 => $val) {
    $dept_name = $academic_syllabus['deparments'][$val]['department']['name'];
    $dept_code = $academic_syllabus['deparments'][$val]['department']['code'];
    $dept_id = $academic_syllabus['deparments'][$val]['department']['id'];
    $dept_subs = $academic_syllabus['deparments'][$val]['department']['subjects'];
    $class = '';
    if ($key1 == 0)
      $class = 'in active';
    ?>
    <div id="<?php echo $dept_code; ?>" class="tab-pane fade <?php echo $class.' '.$key1; ?>" role="tabpanel">
      <h1 class="text-center">
        <?php echo $dept_name; ?> Details&nbsp;&nbsp;
        <?php
        if ($edit_permission) {
          ?>
          <span class="label label-primary">
            <a href="/syllabus/department-edit/<?php echo $dept_id; ?>">EDIT</a>
          </span>
          <?php
        }
        ?>
      </h1>
      <div class="row">
        <?php foreach ($dept_subs as $sub_key => $sub_val) { ?>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="panel panel-default card card-outline-success">
              <div class="panel-heading text-center"><?php echo $sub_val['subject']['name']; ?><br/>
                <span class="label label-info m-l-5"><?php echo $dept_code . '-' . $sub_val['subject']['code']; ?></span>
              </div>
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <p><?php echo $sub_val['subject']['learning_objectives']; ?></p>
                  <div class="text-center">
                    <a href="/syllabus/subject/<?php echo $sub_val['subject']['id'] . '/' . $lang; ?>" class="btn btn-default btn-outline-primary m-t-10 collapseble">Subject Details</a>
                  </div>
                </div>
              </div>
            </div>
          </div>          
        <?php } ?>
      </div>
    </div>
    <?php
  }
  ?>
</div>