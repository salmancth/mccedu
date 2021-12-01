<?php
$dept_keys = array_keys($academic_syllabus['deparments']);
?>
<div class="row">
  <div class="col col-md-12">
    <?php
    foreach ($dept_keys as $key => $val) {
      $dept_name = $academic_syllabus['deparments'][$val]['department']['name'];
      $dept_code = $academic_syllabus['deparments'][$val]['department']['code'];
      $syllabus_type = $academic_syllabus['deparments'][$val]['department']['syllabus_type'];
      $dept_id = $academic_syllabus['deparments'][$val]['department']['id'];
      $dept_subs = $academic_syllabus['deparments'][$val]['department']['subjects'];
      echo '<div class="card card-outline-primary m-b-20 white-box">';
      echo '<div class="card-block">';
      echo '<h3 class="box-title"><a href="/syllabus/academic-syllabus-by-type/'.$syllabus_type.'#' . $dept_code . '">' . $dept_code . ' - ' . $dept_name . '</a></h4>';
      echo '<ul class="common-list">';
      foreach ($dept_subs as $sub_key => $sub_val) {
        echo '<li><a href="/syllabus/subject/' . $sub_val['subject']['id'] . '">'
        . '<i class="fa fa-check text-success"></i> ' . $dept_code . '-' . $sub_val['subject']['code'] .
        ': ' . $sub_val['subject']['name'] . '</a></li>';
      }
      echo '</ul>';
      echo '</div>';
      echo '</div>';
    }
    ?>
  </div>
</div>