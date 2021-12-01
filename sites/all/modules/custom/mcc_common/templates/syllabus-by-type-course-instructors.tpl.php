<div class="white-box">
    <?php if(!empty($result)) { ?>
    <div class="table-responsive">
        <h3>List of instructors - <?php echo ucfirst($session).'-'.$year; ?> </h3>
        <table class="table table-striped table-bordered nowrap" id="" style="table-layout: fixed">
            <thead>
                <tr class="tablehead">
                    <th class="">Name</th>
                    <th class="">Email</th>
                    <th class="">Phone</th>
                    <th class="">Course</th>
                    <th class=""></th>
                </tr>        
            </thead>
            <tbody>
                <?php foreach ($result as $key=>$value) { ?>
                <tr>
                    <td><?php echo $value->field_name_value; ?></td>
                    <td><?php echo $value->mail; ?></td>
                    <td><?php echo $value->field_phone_value; ?></td>
                    <td><?php echo $value->course_code; ?></td>
                    <td><a href="/syllabus/course-instructor-unassign/<?php echo $value->id ?>">UNASSIGN</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>    
    <?php
    } else {
        echo 'Nothing Found';
    }
    ?>
</div>