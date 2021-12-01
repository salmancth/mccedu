<?php
$col_class = 'col-md-12';
?>
<div class="white-box">
    <div class="row">
        <?php if (!empty($results)) { ?>
            <div class="<?php echo $col_class; ?>">
                <h2><?php echo $page_title; ?></h2>
                <div class="table-responsive">    
                    <div class="demo-html"></div>
                    <table class="table table-striped table-bordered nowrap" id="courses_result_list-table">
                        <thead>
                            <tr class="tablehead">
                                <th class="">Course</th>
                                <th class="">Module</th>
                                <th class="">Session - Year</th>
                                <th class="">Exam Date</th>
                                <th class="">Score</th>
                            </tr>        
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result): ?>
                                <tr>
                                    <td>
                                        <?php echo _getHyperLinkedCourse($result['course_code'], $academic_syllabuses); ?>
                                        <?php echo str_replace($result['course_code'], ' ', $academic_syllabuses_name[$result['course_code']]); ?>
                                    </td>
                                    <td><?php echo !empty($result['module'])?$result['module']:'-'; ?></td>
                                    <td><?php echo ucfirst($result['session']).'-'.$result['year']; ?></td>
                                    <td><?php echo format_date($result['exam_date'], 'medium', 'Y-m-d'); ?></td>
                                    <td><?php echo round($result['score'], 2) . '%'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>