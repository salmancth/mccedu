<?php
//pretty_print($academic_syllabus['deparments'], 0);
$dept_keys = array_keys($academic_syllabus['deparments']);
?>
<!--<ul class="nav">
<?php
//  foreach ($dept_keys as $key => $val) {
//    $dept_name = $academic_syllabus['deparments'][$val]['department']['name'];
//    $dept_code = $academic_syllabus['deparments'][$val]['department']['code'];
//    $dept_id = $academic_syllabus['deparments'][$val]['department']['id'];
//    $dept_subs = $academic_syllabus['deparments'][$val]['department']['subjects'];
//    echo '<li><a href="/academic-syllabus#'.$dept_code.'">'.$dept_code.' - '.$dept_name . '</a></li>';
//    echo '<ul>';
//    foreach ($dept_subs as $sub_key => $sub_val) {
//      echo '<li><a href="/academic-syllabus/subject/'.$sub_val['subject']['id'].'">'.$dept_code . '-' . $sub_val['subject']['code'] . 
//        ': ' . $sub_val['subject']['name'] . '</a></li>';
//    }
//    echo '</ul>';
//  }
?>
</ul>-->
<div class="row">
  <div class="col col-md-12">
    <?php
    foreach ($dept_keys as $key => $val) {
      $dept_name = $academic_syllabus['deparments'][$val]['department']['name'];
      $dept_code = $academic_syllabus['deparments'][$val]['department']['code'];
      $dept_id = $academic_syllabus['deparments'][$val]['department']['id'];
      $dept_subs = $academic_syllabus['deparments'][$val]['department']['subjects'];
      echo '<div class="card card-outline-primary m-b-20 white-box">';
      echo '<div class="card-block">';
      echo '<h3 class="box-title"><a href="/academic-syllabus#' . $dept_code . '">' . $dept_code . ' - ' . $dept_name . '</a></h4>';
      //echo '</div>';
      //echo '<div>';
      echo '<ul class="common-list">';
      foreach ($dept_subs as $sub_key => $sub_val) {        
        echo '<li><a href="/academic-syllabus/subject/' . $sub_val['subject']['id'] . '">'
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