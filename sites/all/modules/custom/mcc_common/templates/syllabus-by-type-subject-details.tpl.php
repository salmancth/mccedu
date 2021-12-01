<?php
if (!empty($sub_details)) {
//  pretty_print($sub_details, 0);
    global $base_url;
    $displayed = false;
    $display_class = 'show';
    $module_numbers = array();
    ?>  
    <div class="breadcrumb">
        <div style="display: inline-block">
            <span style="font-size: 50px; padding: 10px" class="glyphicon glyphicon-book" aria-hidden="true"></span>       
        </div>
        <div style="display: inline-block">
            <a style="font-size: 25px"><?php echo $sub_details['subject']['name']; ?></a>
            <p class="text-muted">
                <?php if (!empty($dept)): ?>
                    <a href="/syllabus/academic-syllabus-by-type/<?php echo $dept->syllabus_type; ?>#<?php echo $dept->shortcode; ?>"><?php echo $dept->name; ?></a>
                <?php endif; ?>
            </p>
        </div>

    </div>
    <?php //$li_active_class = 'active'; ?>
    <?php $li_active_class = ''; ?>
    <ul class="nav customtab nav-tabs" role="tablist">
        <?php if (!empty($sub_details['subject']['learning_objectives'])) { ?>
            <li  role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#lo">Learning Objectives</a>
            </li>
            <?php $li_active_class = ''; ?>
        <?php } ?>
        <?php if (!empty($sub_details['subject']['course_contents'])) { ?>
            <li role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#cc">Course Contents</a>
            </li>  
            <?php $li_active_class = ''; ?>
        <?php } ?>
        <?php if ((!empty($sub_details['subject']['text']) || !empty($uploaded_text))) { ?>
            <li role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#text">Text Materials</a>
            </li>  
            <?php $li_active_class = ''; ?>
        <?php } ?>
        <?php if ((!empty($sub_details['subject']['ref']) || !empty($uploaded_ref))) { ?>
            <li role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#ref">Reference Materials</a>
            </li>  
            <?php $li_active_class = ''; ?>
        <?php } ?>
        <?php if (!empty($uploaed_audio_video)): ?>
            <li role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#audio_video">Audio/ Video</a>
            </li>
            <?php $li_active_class = ''; ?>
        <?php endif; ?>
        <?php if (!empty($subject_has_questions->total_questions)) { ?>
            <li role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#exam">Self Evaluation</a>
            </li>  
        <?php } ?>
        <?php if (!empty($subject_has_questions->total_questions) && _isFaculty()) { ?>
            <li role="presentation" class="nav-item <?php echo $li_active_class ?>">
                <a class="nav-link <?php echo $li_active_class ?>" data-toggle="tab" href="#module-active">Set Module Active/ Inactive</a>
            </li>  
        <?php } ?>
    </ul>
    <div class="tab-content">
        <?php if (!empty($sub_details['subject']['learning_objectives'])) { ?>
            <div id="lo" class="tab-pane fade active in <?php echo $display_class; ?>" role="tabpanel">      
                <div class="panel panel-default"> 
                    <div class="panel-heading"> <h3 class="panel-title">Learning Objectives</h3> </div> 
                    <div class="panel-body"> 
                        <?php echo $sub_details['subject']['learning_objectives']; ?>
                    </div> 
                </div>        
                <?php if (!empty($sub_details['subject']['learning_objectives_details'])) { ?>
                    <div class="panel panel-default"> 
                        <div class="panel-heading"> <h3 class="panel-title">Learning Objectives Details</h3> </div> 
                        <div class="panel-body"> 
                            <?php echo $sub_details['subject']['learning_objectives_details']; ?>
                        </div> 
                    </div>
                <?php } ?>
            </div>
            <?php $display_class = ''; ?>
        <?php } ?>
        <?php if (!empty($sub_details['subject']['course_contents'])) { ?>
            <div id="cc" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">      
                <div class="panel panel-default"> 
                    <div class="panel-heading"> <h3 class="panel-title">Course Contents</h3> </div> 
                    <div class="panel-body"> 
                        <?php $cc_count = 1; ?>
                        <?php foreach ($sub_details['subject']['course_contents'] as $course_contents) { ?>
                            <?php echo nl2br(decode_entities($course_contents['module']['module_details'])); ?><br/>
                            <?php
//              $found_material = false;
                            foreach ($module_materials as $material) {
                                $material = array_pop($material);
                                $module_numbers[$cc_count] = $cc_count;
                                if ($material['module_no'] == $cc_count && !empty($material['file']->fid)) {
                                    ?>
                                    <i class = "fa fa-file-text-o" aria-hidden = "true"></i> 
                                    <?php // $found_material = true; ?>
                                    <?php // if (!empty($material['file']->fid)) { ?>
                                    <a class="ctools-use-modal" href="/read-pdf/nojs/<?php
                                    echo $material['file']->fid;
                                    ;
                                    ?>">
                                        <span><?php echo $material['file']->filename; ?></span>
                                    </a><br/>
                                    <?php
//                  }
                                }
                            }
//              if ($found_material)
                            echo "<hr/>";
                            $cc_count++;
                            ?>
                        <?php } ?>
                    </div> 
                </div>        
                <?php if (!empty($sub_details['subject']['course_contents_details'])) { ?>
                    <div class="panel panel-default"> 
                        <div class="panel-heading"> <h3 class="panel-title">Course Contents Details</h3> </div> 
                        <div class="panel-body"> 
                            <?php echo nl2br($sub_details['subject']['course_contents_details']); ?>
                        </div> 
                    </div>
                <?php } ?>
            </div>
            <?php $display_class = ''; ?>
        <?php } ?>
        <?php if ((!empty($sub_details['subject']['text']) || !empty($uploaded_text))) { ?>
            <div id="text" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
                <div class="card" style="padding: 10px">
                    <ul class="common-list">
                        <?php foreach ($sub_details['subject']['text'] as $text) { ?>
                            <li>
                                <?php
                                $text_name = trim(str_replace('*', '', $text['material']['name']));
                                if (!$is_allowed_to_access_books) {
                                    echo $text_name;
                                } else {
                                    $text_name_arr = explode('[', $text_name);
                                    $text_name_arr = explode('(', $text_name_arr[0]);
                                    if (!empty($text_name_arr[0]))
                                        $text_name = $text_name_arr[0];
                                    $text_name = trim($text_name);
                                    $printed = false;
                                    if (!empty($uploaded_text)) {
                                        foreach ($uploaded_text as $textbook) {
                                            if (strpos($textbook->filename, $text_name) !== false) {
                                                $printed = true;
                                                ?>
                                                <a class="ctools-use-modal text-success" href="/read-pdf/nojs/<?php echo $textbook->fid; //$curr_file_url;                                            ?>">
                                                    <span><i class="fa fa-bookmark"></i> 
                                                        <?php echo _prepare_hyperlinked_text($text['material']['name']); ?> <i style="" class="fa fa-book" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if (!$printed) { ?>
                                        <a><i class="fa fa-bookmark"></i> <?php echo _prepare_hyperlinked_text($text['material']['name']); ?></a>
                                    <?php } ?>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if (!empty($uploaded_text) && $is_allowed_to_access_books) : ?>
                        <hr/>
                        <div class="row row in text-center">
                            <?php foreach ($uploaded_text as $text): ?>
                                <?php if (!empty($text->fid)) { ?>
                                    <div class="col col-md-2 col-xs-12 m-b-10">
                                        <div><i style="font-size: 60px" class="fa fa-book" aria-hidden="true"></i></div>
                                        <?php
                                        $curr_file_url = '';
                                        $curr_file_url = _prepare_materials_url($text->uri);
                                        ?>
                                        <?php if (!empty($curr_file_url)) { ?>
                                            <div>
                                                <a class="ctools-use-modal" href="/read-pdf/nojs/<?php echo $text->fid; //$curr_file_url;                                            ?>">
                                                    <span><?php echo $text->filename; ?></span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>      
            </div>
            <?php $display_class = ''; ?>
        <?php } ?>
        <?php if ((!empty($sub_details['subject']['ref']) || !empty($uploaded_ref))) { ?>
            <div id="ref" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
                <div class="card" style="padding: 10px">
                    <ul class="common-list">
                        <?php foreach ($sub_details['subject']['ref'] as $ref) { ?>
                            <li>
                                <?php
                                $text_name = trim(str_replace('*', '', $ref['material']['name']));
                                if (!$is_allowed_to_access_books) {
                                    echo $text_name;
                                } else {
                                    $text_name_arr = explode('[', $text_name);
                                    $text_name_arr = explode('(', $text_name_arr[0]);
                                    if (!empty($text_name_arr[0]))
                                        $text_name = $text_name_arr[0];
                                    $text_name = trim($text_name);
                                    $printed = false;
                                    if (!empty($uploaded_text)) {
                                        foreach ($uploaded_ref as $textbook) {
                                            if (strpos($textbook->filename, $text_name) !== false) {
                                                $printed = true;
                                                ?>
                                                <a class="ctools-use-modal text-success" href="/read-pdf/nojs/<?php echo $textbook->fid; //$curr_file_url;                                            ?>">
                                                    <span><i class="fa fa-bookmark"></i> 
                                                        <?php echo _prepare_hyperlinked_text($ref['material']['name']); ?> <i style="" class="fa fa-book" aria-hidden="true"></i>
                                                    </span>
                                                </a>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if (!$printed) { ?>
                                        <a><i class="fa fa-bookmark"></i> <?php echo _prepare_hyperlinked_text($ref['material']['name']); ?></a>
                                    <?php } ?>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if (!empty($uploaded_ref) && $is_allowed_to_access_books) : ?>
                        <hr/>
                        <div class="row row in text-center">
                            <?php foreach ($uploaded_ref as $text): ?>
                                <?php if (!empty($text->fid)) { ?>
                                    <div class="col col-md-2 col-xs-12 m-b-10">
                                        <div><i style="font-size: 60px" class="fa fa-book" aria-hidden="true"></i></div>              
                                        <?php
                                        $curr_file_url = '';
                                        $curr_file_url = _prepare_materials_url($text->uri);
                                        ?>
                                        <?php if (!empty($curr_file_url)) { ?>
                                            <div>
                                                <a class="ctools-use-modal" href="/read-pdf/nojs/<?php echo $text->fid; //$curr_file_url;                                            ?>">
                                                    <span><?php echo $text->filename; ?></span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>      
            </div>
            <?php $display_class = ''; ?>
        <?php } ?>
        <?php if (!empty($uploaed_audio_video)): ?>
            <div id="audio_video" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
                <div class="card" style="padding: 10px">
                    <?php foreach ($uploaed_audio_video as $key => $value) { ?>
                        <div class="well well-sm">
                            <?php //print_r($value); ?>
                            <video width="400" controls style="margin: auto; display: block">
                                <source src="<?php echo file_create_url($value->uri) ?>" type="video/mp4">
                                Your browser does not support HTML5 video.
                            </video>
                            <br/><span><center><?php echo $value->filename; ?></center></span><br/>
                        </div>
                    <?php } ?>
                </div>      
            </div>
            <?php $display_class = ''; ?>
        <?php endif; ?>
        <?php //pretty_print($uploaed_audio_video, 0);     ?>
        <?php
        $column_class = 'col-md-12';
        if (!empty($course_result)) {
            $column_class = 'col-md-6';
        }
        ?>
        <?php if (!empty($subject_has_questions->total_questions)) { ?>
            <div id="exam" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
                <div class="row">
                    <div class="col <?php echo $column_class; ?>">
                        <div class="card" style="padding: 10px">
                            <div class="panel panel-default"> 
                                <div class="panel-heading"> <h3 class="panel-title">Self Evaluation</h3> </div> 
                                <div class="panel-body"> 
                                    <?php
                                    if (!empty($module_count)) {
//                                        pretty_print($module_numbers);
                                        for ($count_m = 1; $count_m <= $module_count; $count_m++) {
                                            if(empty($active_modules[$count_m]) || (isset($active_modules[$count_m]) && (REQUEST_TIME < $active_modules[$count_m]['active_date'])))
                                                continue;
                                            ?>
                                            <div>
                                                <a style="margin-bottom:5px" class="btn btn-info btn-circle1 btn-lg ctools-use-modal" href="/syllabus/exam/<?php echo $sub_full_code; ?>/nojs/<?php echo $count_m ?>">
                                                    <i class="fa fa-paper-plane"></i> Evaluate - Module <?php echo $count_m ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <a class="btn btn-info btn-circle1 btn-lg ctools-use-modal" href="/syllabus/exam/<?php echo $sub_full_code; ?>/nojs">
                                            <i class="fa fa-paper-plane"></i> Evaluate
                                        </a>
                                    <?php } ?>
                                    <?php //pretty_print($course_result, 0); ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($course_result)) { ?>
                        <div class="col col-md-6 card mcc-timeline">
                            <ul class="timeline">
                                <p class="text-muted text-right text-success">Your Score In This Subject</p>
                                <?php
                                $count = 0;
                                foreach ($course_result as $result) {
                                    ?>
                                    <li class="<?php echo ($count % 2) ? 'timeline-inverted' : ''; ?>">
                                        <div class="timeline-badge success"><i class="fa fa-graduation-cap"></i> </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">Score: <?php echo round($result['score'], 2) . '%'; ?></h4>
                                                <?php if (!empty($result['module'])) { ?>
                                                    Module: <?php echo $result['module']; ?><br/>
                                                <?php } ?>
                                                <p>
                                                    On <small class="text-muted"><i class="fa fa-clock-o"></i> 
                                                        <?php echo format_date($result['exam_date'], 'medium', 'Y-m-d'); ?>
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    $count++;
                                }
                                ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>        
            </div>
            <?php $display_class = ''; ?>  
        <?php } ?>
        <?php if (!empty($subject_has_questions->total_questions) && _isFaculty()) { ?>
            <div id="module-active" class="tab-pane fade <?php echo $display_class; ?>" role="tabpanel">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="card" style="padding: 10px">
                            <div class="panel panel-default"> 
                                <!--<div class="panel-heading"> <h3 class="panel-title">Exam</h3> </div>--> 
                                <div class="panel-body"> 
                                    <?php print drupal_render($module_active_inactive_form); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-danger" role="alert">Subject Not Found</div>
    <?php
}