<?php
$col_class = 'col-md-12';
if (!empty($facultySubjects) && !empty($registeredSubjects)) {
    $col_class = 'col-md-6';
}
?>
<div class="white-box">
    <div class="row">
        <?php if (!empty($facultySubjects)) { ?>             
            <div class="<?php echo $col_class; ?>">
                <h2>Instructor for Courses</h2>
                <div class="table-responsive">    
                    <div class="demo-html"></div>
                    <table class="table table-striped table-bordered nowrap" id="faculty_courses_list-table">
                        <thead>
                            <tr class="tablehead">
                                <th class="">Course</th>
                                <th class="">Session - Year</th>
                            </tr>        
                        </thead>
                        <tbody>
                            <?php foreach ($facultySubjects as $key=>$sub): ?>
                                <tr>                                    
                                    <td><?php echo $sub; ?></td>
                                    <td><?php echo ucfirst($key); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>  
            </div>
        <?php } ?>
        <?php if (!empty($registeredSubjects)) { ?>
            <div class="<?php echo $col_class; ?>">
                <h2>My Registered Courses</h2>
                <div class="table-responsive">    
                    <div class="demo-html"></div>
                    <table class="table table-striped table-bordered nowrap" id="registered_courses_list-table">
                        <thead>
                            <tr class="tablehead">
                                <th class="">Course</th>
                                <th class="">Session - Year</th>
                            </tr>        
                        </thead>
                        <tbody>
                            <?php foreach ($registeredSubjects as $sub): ?>
                                <tr>
                                    <td>
                                        <?php // echo implode(', ', $sub['courses']); ?>
                                        <?php
                                        $full_str = '';
                                        foreach($sub['courses'] as $course) {
                                            $separator = empty($full_str)? "":", ";
                                            $full_str .= $separator._getHyperLinkedCourse($course, $academic_syllabuses);
                                        }
                                        echo $full_str;
                                        ?>
                                    </td>
                                    <td><?php echo ucfirst($sub['session']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php // pretty_print($academic_syllabuses, 0); ?>