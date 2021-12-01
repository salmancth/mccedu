<div class="white-box">
    <div class="table-responsive">
        <table class="table table-striped table-bordered nowrap" id="completed_registration_list-table">
            <thead>
                <tr class="tablehead">
                    <th class="">Session</th>
                    <th class="">Name</th>
                    <th class="">Email</th>
                    <th class="">Courses</th>
                    <th class="">Paid?</th>
                    <th class="">Operation</th>
                </tr>        
            </thead>
            <tbody>
                <?php if (!empty($registration_details)) { ?>
                    <?php foreach ($registration_details as $registration): ?>
                        <tr>
                            <td><?php echo ucfirst($registration['session']); ?></td>
                            <td>
                                <?php echo!empty($registration['user']->field_name['und'][0]['value']) ? $registration['user']->field_name['und'][0]['value'] : ''; ?>
                            </td>
                            <td><?php echo $registration['user']->mail; ?></td>
                            <td><?php
                                if (!empty($registration['courses'])) {
                                    echo implode(', ', $registration['courses']);
                                }
                                ?>
                            </td>
                            <td><?php echo ucfirst($registration['paid']); ?></td>
                            <td>
                                <a onclick="return confirm('Are You Sure')"  href="/syllabus/registration/delete/<?php echo $registration['id']; ?>">DELETE</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>