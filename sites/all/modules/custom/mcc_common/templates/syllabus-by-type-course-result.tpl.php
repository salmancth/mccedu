<div class="white-box">
    <?php if(!empty($result)) { ?>
    <div class="table-responsive">
        <h3>Result: <?php echo $course_code; ?> in <?php echo ucfirst($session).'-'.$year; ?> </h3>
        <table class="table table-striped table-bordered nowrap" id="" style="table-layout: fixed">
            <thead>
                <tr class="tablehead">
                    <th class="">Name</th>
                    <th class="">Email</th>
                    <th class="">module</th>
                    <th class="">Score</th>
                    <th class="">Date</th>
                </tr>        
            </thead>
            <tbody>
                <?php foreach ($result as $key=>$value) { ?>
                <tr>
                    <td><?php echo $value->field_name_value; ?></td>
                    <td><?php echo $value->mail; ?></td>
                    <td><?php echo $value->module; ?></td>
                    <td><?php echo round($value->score,2); ?> %</td>
                    <td><?php echo format_date($value->exam_date, 'medium', 'Y-m-d'); ?></td>
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